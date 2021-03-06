<?php
namespace App\Http\Controllers\Mantenimiento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mantenimiento\Balotario;
use App\Models\Proceso\ProgramacionUnica;
use App\Models\Proceso\TipoEvaluacion;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Controllers\Api\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;
use App\Models\Mantenimiento\BalotarioPregunta;

class BalotarioEM extends Controller
{
     private $api;
     
    public function __construct()
    {
        $this->api = new Api();
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
        error_reporting(E_ERROR);
    } 

    public function EditStatus(Request $r )
    {
        if ( $r->ajax() ) {
            Balotario::runEditStatus($r);
            $return['rst'] = 1;
            $return['msj'] = 'Registro actualizado';
            return response()->json($return);
        }
    }

   public function New(Request $r )
    {
        if ( $r->ajax() ) {

            $mensaje= array(
                'required'    => ':attribute es requerido',
                'unique'      => ':attribute solo debe ser único',
            );

            $rules = array(
                'programacion_unica_id' => 
                       ['required',
                        Rule::unique('v_balotarios','programacion_unica_id')->where(function ($query) use($r) {
                                $query->where('tipo_evaluacion_id',$r->tipo_evaluacion_id );
                        }),
                        ],
            );

            
            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Balotario::runNew($r);
                $return['rst'] = 1;
                $return['msj'] = 'Registro creado';
            }
            else{
                $return['rst'] = 2;
                $return['msj'] = $validator->errors()->all()[0];
            }
            return response()->json($return);
        }
    }

    public function Edit(Request $r )
    {
        if ( $r->ajax() ) {
            $mensaje= array(
                'required'    => ':attribute es requerido',
                'unique'        => ':attribute solo debe ser único',
            );

            $rules = array(
                'programacion_unica_id' => 
                       ['required',
                        Rule::unique('v_balotarios','programacion_unica_id')->ignore($r->id)->where(function ($query) use($r) {
                                $query->where('tipo_evaluacion_id',$r->tipo_evaluacion_id );
                        }),
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Balotario::runEdit($r);
                $return['rst'] = 1;
                $return['msj'] = 'Registro actualizado';
            }
            else{
                $return['rst'] = 2;
                $return['msj'] = $validator->errors()->all()[0];
            }
            return response()->json($return);
        }
    }
    
    public function Load(Request $r ){
        if ( $r->ajax() ) {
            $renturnModel = Balotario::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }

    public function ValidarTipoEvaluacionBalotario(Request $r ){
        if ( $r->ajax() ) {
            if( trim(session('idcliente'))=='' ){
                session(['idcliente' => 2]);
            }
            $idcliente = session('idcliente');
            $tab_cli = DB::table('clientes_accesos')
                      ->where('id','=', $idcliente)
                      ->where('estado','=', 1)
                      ->first();

            $programacionUnica = ProgramacionUnica::find($r->programacion_unica_id);

            
            // URL (CURL)
            $cli_links =    DB::table('clientes_accesos_links')
                            ->where('cliente_acceso_id','=',$tab_cli->id)
                            ->where('tipo','=', 12)
                            ->first();

            $buscar = array("pkey","pueid");
            $reemplazar = array($tab_cli->keycli, $programacionUnica->programacion_unica_externo_id);
            $url = str_replace($buscar, $reemplazar, $cli_links->url);
            $objArr = $this->api->curl($url);

            $return_response = '';

            if (empty($objArr))
            {
                $return_response = $this->api->response(422,"error","Ingrese sus datos de envio");
            }
            else if(isset($objArr->data->key->id) && isset($objArr->data->key->token))
            {
                $tab_cli =  DB::table('clientes_accesos')
                            ->select('id', 'nombre', 'key', 'url', 'ip')
                            ->where('id','=', $objArr->data->key->id)
                            ->where('key','=', $objArr->data->key->token)
                            //->where('ip','=', $this->api->getIPCliente())
                            ->where('estado','=', 1)
                            ->first();

                if( count($tab_cli)>0 )
                {
                    $val = $this->insertarTipoEvaluacionBalotario($objArr, $r);
                    if($val['return'] == true)
                      $return_response = $this->api->response(200,"success","Proceso ejecutado satisfactoriamente");
                    else
                        $return_response = $this->api->response(422,"error","Revisa tus parametros de envio");
                }
                else
                {
                    $return_response = $this->api->response(422 ,"error","Su Parametro de seguridad son incorrectos");
                }
            }
            else
            {
                $return_response = $this->api->response(422,"error","Revisa tus parametros de envio");
            }

            // Creación de un archivo JSON para dar respuesta al cliente
              /*$uploadFolder = 'txt/api';
              $nombre_archivo = "cliente.json";
              $file = $uploadFolder . '/' . $nombre_archivo;
              unlink($file);
              if($archivo = fopen($file, "a"))
              {
                fwrite($archivo, $return_response);
                fclose($archivo);
              }*/
            // --
            $renturnModel = Balotario::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";    
            return response()->json($return);   
        }
    }
    
     public function insertarTipoEvaluacionBalotario($objArr, $r){
         
        
        try{ 
            DB::beginTransaction();
            Balotario::where('programacion_unica_id', $r->programacion_unica_id)
            ->update([
            'estado' => 0,
            'persona_id_updated_at'=>1,
            'updated_at'=>date('Y-m-d H:i:s')
            ]);

            foreach ($objArr->data->tipo as $k=>$value)
            {
                $tipoeval = TipoEvaluacion::where('tipo_evaluacion_externo_id','=', $value->tipo_evaluacion_externo_id)
                          ->first();
                if(count($tipoeval) == 0) //Insert
                {
                  $tipoeval = new TipoEvaluacion();
                  $tipoeval->tipo_evaluacion_externo_id = $value->tipo_evaluacion_externo_id;
                  $tipoeval->persona_id_created_at=1;
                }
                else
                {
                  $tipoeval->persona_id_updated_at=1;
                }

                $tipoeval->tipo_evaluacion = $value->tipo_evaluacion;
                $tipoeval->nro_pregunta = $value->nro_pregunta;
                $tipoeval->save();

                $balotario= Balotario::where('v_balotarios.tipo_evaluacion_id','=', $tipoeval->id)
                            ->where('v_balotarios.programacion_unica_id','=', $r->programacion_unica_id)
                            ->first();

                if(count($balotario) == 0){
                  $balotario = new Balotario();
                  $balotario->programacion_unica_id = $r->programacion_unica_id;
                  $balotario->tipo_evaluacion_id = $tipoeval->id;
                  $balotario->persona_id_created_at=1;
                  $balotario->cantidad_maxima =0;
                  $balotario->cantidad_pregunta =0;
                }
                else{
                  $balotario->estado=1;
                  $balotario->persona_id_updated_at=2;
                }
                $balotario->save();
            }
            DB::commit();
            $data['return']= true;
          
        }catch (\Exception $e){
            //var_dump($e);exit();
            DB::rollback();
            $data['return']= false;
        }
        return $data;
    }
    
    public function GenerateBallot(Request $r ){
        if ( $r->ajax() ) {
            
            $rst=Balotario::runGenerateBallot($r);
            
            if($rst['rst']==1){
                $return['msj'] = 'Balotario Generado';
            }else{
                $return['msj'] = 'Balotario no Generado por que falta '.$rst['falta'].' pregunta(s) en: '.$rst['unidad_contenido'];
            }
            
            $return['rst'] = $rst['rst'];
            return response()->json($return);
        }
    }
    
    public function GenerarPDF(Request $r) {

        $renturnModel = BalotarioPregunta::runLoad($r);
        $HeadBallotPdf=Balotario::runHeadBallotPdf($r);

        $preguntas = array();
        foreach ($renturnModel as $data) {
        $pregunta = $data->pregunta.'|'.$data->imagen;
            if (isset($preguntas[$pregunta])) {
                $preguntas[$pregunta][] = $data;
            } else {
                $preguntas[$pregunta] = array($data);
            }
        }
        
        $data = ['preguntas' => $preguntas,'head'=>$HeadBallotPdf];

	$pdf = PDF::Make();
        $pdf->SetHeader('TELESUP|Balotario de Preguntas|{PAGENO}');
        $pdf->SetFooter('TELESUP');

	$pdf->loadView('mantenimiento.plantilla.plantillapdf', $data);
	return $pdf->Stream('document.pdf');

        
        
//        $pdf = PDF::make();
//        $content = "<ul><li>Hello this is first pdf file.</li></ul>";
//	$pdf->WriteHTML($content);
//	return $pdf->Stream('document.pdf');

    }
    
}

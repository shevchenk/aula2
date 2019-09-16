<?php
namespace App\Http\Controllers\Proceso;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\Api;
use App\Models\Proceso\TipoEvaluacion;
use App\Models\Proceso\ProgramacionUnica;
//use App\Models\Proceso\Persona;
use App\Models\Proceso\Programacion;
use App\Models\Proceso\Evaluacion;

class TipoEvaluacionPR extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(){
        //
    }

    public function Load(Request $r )
    {
        if ( $r->ajax() ) {
            $r['dni'] = Auth::user()->dni;
            $renturnModel = TipoEvaluacion::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }

    public function validarTipoEvaluacion(Request $r)
    {
        if( trim(session('idcliente'))=='' ){
            session(['idcliente' => 2]);
        }
        $idcliente = session('idcliente');
        $tab_cli = DB::table('clientes_accesos')
                      ->where('id','=', $idcliente)
                      ->where('estado','=', 1)
                      ->first();

        $programacion = Programacion::find($r->programacion_id);
        $programacion_unica = ProgramacionUnica::find($programacion->programacion_unica_id);

        // URL (CURL)
        $cli_links =  DB::table('clientes_accesos_links')
                      ->where('cliente_acceso_id','=', $idcliente)
                      ->where('tipo','=', 11)
                      ->first();
        $buscar = array("pkey", "pdni","pueid");
        $reemplazar = array($tab_cli->keycli, Auth::user()->dni, $programacion_unica->programacion_unica_externo_id);
        $url = str_replace($buscar, $reemplazar, $cli_links->url);
        $objArr = $this->api->curl($url);
        // --
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

            if( isset($tab_cli->id) )
            {
                $val = $this->insertarTipoEvaluacion($objArr, $r);
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
        $r['dni'] = Auth::user()->dni;
        $renturnModel = TipoEvaluacion::runLoad($r);
        //dd($renturnModel);
        $return['rst'] = 1;
        $return['data'] = $renturnModel;
        $return['msj'] = "No hay registros aún";
        return response()->json($return);
    }

    public function validarTipoEvaluacionMaster(Request $r)
    {
        $programacion_unica = ProgramacionUnica::find($r->programacion_unica_id);

        $param_data = array('dni' => Auth::user()->dni,
                              'programacion_unica_externo_id' => $programacion_unica->programacion_unica_externo_id);
        // URL (CURL)
        $cli_links = DB::table('clientes_accesos_links')->where('cliente_acceso_id','=', 1)
                                                        ->where('tipo','=', 11)
                                                        ->first();
        $objArr = $this->api->curl($cli_links->url, $param_data);
        // --
        $return_response = '';

        if (empty($objArr))
        {
            $return_response = $this->api->response(422,"error","Ingrese sus datos de envio");
        }
        else if(isset($objArr->key[0]->id) && isset($objArr->key[0]->token))
        {
            $tab_cli = DB::table('clientes_accesos')->select('id', 'nombre', 'key', 'url', 'ip')
                                                    ->where('id','=', $objArr->key[0]->id)
                                                    ->where('key','=', $objArr->key[0]->token)
                                                    //->where('ip','=', $this->api->getIPCliente())
                                                    ->where('estado','=', 1)
                                                    ->first();

            if($objArr->key[0]->id == @$tab_cli->id && $objArr->key[0]->token == @$tab_cli->key)
            {
                $val = $this->insertarTipoEvaluacion($objArr, $r);
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
          $uploadFolder = 'txt/api';
          $nombre_archivo = "cliente.json";
          $file = $uploadFolder . '/' . $nombre_archivo;
          unlink($file);
          if($archivo = fopen($file, "a"))
          {
            fwrite($archivo, $return_response);
            fclose($archivo);
          }
        // --
        $r['dni'] = Auth::user()->dni;
        $renturnModel = TipoEvaluacion::runLoad($r);
        //dd($renturnModel);
        $return['rst'] = 1;
        $return['data'] = $renturnModel;
        $return['msj'] = "No hay registros aún";
        return response()->json($return);
    }

    public function insertarTipoEvaluacion($objArr, $r)
    {
        
        try
        {
          DB::beginTransaction();
          
          Evaluacion::where('programacion_id', $r->programacion_id)
          ->where('estado_cambio','<',2)
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
              $tipoeval->save();

              $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                            ->where('tipo_evaluacion_id', '=', $tipoeval->id)
                            ->where('estado_cambio','<',2)
                            ->first();

              //$r['fecha_evaluacion'] = $value->fecha_evaluacion;
              if(count($evaluacion) == 0) // Insert
              {
                $evaluacion = new Evaluacion;
                $evaluacion->programacion_id = $r->programacion_id;
                $evaluacion->tipo_evaluacion_id = $tipoeval->id;
                $evaluacion->persona_id_created_at=Auth::user()->id;
              }
              else{
                $evaluacion->persona_id_updated_at=Auth::user()->id;
              }
                
                $evaluacion->fecha_evaluacion_inicial = $value->fecha_evaluacion_ini;
                $evaluacion->fecha_evaluacion_final = $value->fecha_evaluacion_fin;
                $evaluacion->estado=1;
                $evaluacion->save();
              //break;
          }

          DB::commit();
          $data['return']= true;
        }
        catch (\Exception $e)
        {
            //dd($e);
            DB::rollback();
            $data['return']= false;
        }
        return $data;
    }
}

<?php
namespace App\Http\Controllers\Mantenimiento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Api;
use App\Models\Mantenimiento\Curso;
use DB;

class CursoEM extends Controller{
    private $api;
    public function __construct(){
         $this->api = new Api();
    }

    public function Load(Request $r ){
        if ( $r->ajax() ) {
            $renturnModel = Curso::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }

    public function validarCursoMaster(Request $r){
        $idcliente = session('idcliente');
        $tab_cli = DB::table('clientes_accesos')
                      ->where('id','=', $idcliente)
                      ->where('estado','=', 1)
                      ->first();
        // URL (CURL)
        $cli_links =  DB::table('clientes_accesos_links')
                      ->where('cliente_acceso_id','=', $idcliente)
                      ->where('tipo','=', 8)
                      ->first();
        $buscar = array("pkey");
        $reemplazar = array($tab_cli->keycli);
        $url = str_replace($buscar, $reemplazar, $cli_links->url);
        if( session('empresa_id')!=null ){
          $url.="&empresa_id=".session('empresa_id');
        }
        
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
                $val = $this->insertarCurso($objArr);
                if($val['return'] == true){
                  //$this->api->curl('localhost/Cliente/Retorno.php',$val['externo_id']);

                  $return_response = $this->api->response(200,"success","Proceso ejecutado satisfactoriamente");
                }else
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
        $renturnModel = Curso::runLoad($r);
        $return['rst'] = 1;
        $return['data'] = $renturnModel;
        $return['msj'] = "No hay registros aún";
        return response()->json($return);
    }

    public function insertarCurso($objArr){
        $array_curso='0';

        try{
          DB::beginTransaction();
              Curso::where('estado', 1)
              ->where(function($query) use($objArr){
                  if( isset($objArr->data->cursos[0]->empresa_externo_id) ){
                      $query->where('empresa_externo_id', $objArr->data->cursos[0]->empresa_externo_id);
                  }
              })
              ->update([
                'estado' => 0,
                'persona_id_updated_at'=>1,
                'updated_at'=>date('Y-m-d H:i:s')
              ]);
          foreach ($objArr->data->cursos as $k=>$value)
          {
              $curso = Curso::where('curso_externo_id','=', $value->curso_externo_id)
                        ->first();
              if (!isset($curso->id))
              {
                  $curso = new Curso();
                  $curso->curso_externo_id = $value->curso_externo_id;
                  $curso->empresa_externo_id = $value->empresa_externo_id;
                  $curso->persona_id_created_at=1;
              }
              else
              {
                  $curso->persona_id_updated_at=1;
              }
              $curso->estado = 1;
              $curso->curso = $value->curso;
              $curso->save();
          }

          DB::commit();
          $data['return']= true;
          //$data['externo_id']=array('curso'=>$array_curso,'programacion_unica'=>$array_programacion_unica,'programacion'=>$array_programacion);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            //dd($e);
           $data['return']= false;
        }
        return $data;
    }

    public function Edit(Request $r )
    {
        if ( $r->ajax() ) {
            $mensaje= array(
                'required'    => ':attribute es requerido',
                'unique'        => ':attribute solo debe ser único',
            );

            $rules = array(
                'file_nombre' =>
                       ['required',
                        ],
            );

            $validator=Validator::make($r->all(), $rules,$mensaje);

            if ( !$validator->fails() ) {
                Curso::runEdit($r);
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
}

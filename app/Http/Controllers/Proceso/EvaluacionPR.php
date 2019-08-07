<?php
namespace App\Http\Controllers\Proceso;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\Api;
use App\Models\Proceso\Curso;
use App\Models\Proceso\ProgramacionUnica;
use App\Models\Proceso\Persona;
use App\Models\Proceso\Programacion;
use App\Models\Proceso\Evaluacion;
use App\Models\Mantenimiento\Balotario;
use App\Models\Proceso\EvaluacionDetalle;

use App\Models\Mantenimiento\Respuesta;

class EvaluacionPR extends Controller
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
            $renturnModel = Curso::runLoad($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }

    public function validarCurso(Request $r)
    {
        $idcliente = session('idcliente');
        $tab_cli = DB::table('clientes_accesos')
                      ->where('id','=', $idcliente)
                      ->where('estado','=', 1)
                      ->first();

        // URL (CURL)
        $cli_links = DB::table('clientes_accesos_links')
                      ->where('cliente_acceso_id','=', $idcliente)
                      ->where('tipo','=', 3)
                      ->first();
        $buscar = array("pkey", "pdni");
        $reemplazar = array($tab_cli->keycli, Auth::user()->dni);
        $url = str_replace($buscar, $reemplazar, $cli_links->url);
        $objArr = $this->api->curl($url);
        
        $return_response = '';
        
        if (empty($objArr))
        {
            $return_response = $this->api->response(422,"error","Ingrese sus datos de envio");
        }
        else if( isset($objArr->data->key->id) && isset($objArr->data->key->token) )
        {
        
            $tab_cli = DB::table('clientes_accesos')
                        ->select('id', 'key')
                        ->where('id','=', $objArr->data->key->id)
                        ->where('key','=', $objArr->data->key->token)
                        //->where('ip','=', $this->api->getIPCliente())
                        ->where('estado','=', 1)
                        ->first();
            if($objArr->data->key->id == @$tab_cli->id && $objArr->data->key->token == @$tab_cli->key)
            {
                $val = $this->insertarEvaluacion($objArr);
                if($val['return'] == true){
                  //$this->api->curl('localhost/Cliente/Retorno.php', $val['externo_id']);
                  $return_response = $this->api->response(200,"success","Proceso ejecutado satisfactoriamente");
                }
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
        $renturnModel = Curso::runLoad($r);
        $return['rst'] = 1;
        $return['data'] = $renturnModel;
        $return['msj'] = "No hay registros aún";
        return response()->json($return);
    }


    public function insertarEvaluacion($objArr)
    {
        DB::beginTransaction();
        $array_curso='0';
        $array_programacion_unica='0';
        $array_programacion='0';
        
        try
        {
          foreach ($objArr->data->alumno as $k=>$value)
          {
              $alumno = Persona::where('dni', '=', $value->dni)->first();
              if (count($alumno) == 0)
              {
                  $alumno = new Persona();
                  $alumno->dni = $value->dni;
                  $alumno->password = bcrypt($value->dni);
                  $alumno->persona_id_created_at=1;
              }
              else{
                  $alumno->persona_id_updated_at=1;
              }

              $alumno->paterno = $value->paterno;
              $alumno->materno = $value->materno;
              $alumno->nombre = $value->nombre;
              $alumno->sexo = $value->sexo;
              if( trim($value->fecha_nacimiento)!='' ){
                  $alumno->fecha_nacimiento = $value->fecha_nacimiento;
              }
              $alumno->telefono = $value->telefono;
              $alumno->celular = $value->celular;
              $alumno->save();

              Programacion::where('persona_id', $alumno->id)
              ->update([
                'estado' => 0,
                'persona_id_updated_at'=>1,
                'updated_at'=>date('Y-m-d H:i:s')
              ]);
          }

          foreach ($objArr->data->programacion as $k=>$value)
          {
              $curso = Curso::where('curso_externo_id','=', $value->curso_externo_id)
                        ->first();
              if (count($curso) == 0)
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

              $curso->curso = $value->curso;
              $curso->save();
              //$array_curso.=','.$curso->curso_externo_id;
              
              $docente = Persona::where('dni', '=', $value->docente_dni)->first();
              if (count($docente) == 0)
              {
                  $docente = new Persona();
                  $docente->dni = $value->docente_dni;
                  $docente->persona_id_created_at=1;
                  $docente->password = bcrypt($value->docente_dni);
              }
              else{
                  $docente->persona_id_updated_at=1;
              }

              $docente->paterno = $value->docente_paterno;
              $docente->materno = $value->docente_materno;
              $docente->nombre = $value->docente_nombre;
              $docente->save();
              // --

              // Proceso Programación Unica
              $programacion_unica = ProgramacionUnica::where('programacion_unica_externo_id', '=', $value->programacion_unica_externo_id)
                                    ->first();
              if (count($programacion_unica) == 0)
              {
                  $programacion_unica = new ProgramacionUnica();
                  $programacion_unica->programacion_unica_externo_id = $value->programacion_unica_externo_id;
                  $programacion_unica->persona_id_created_at=1;
              }
              else{
                  $programacion_unica->estado=1;
                  $programacion_unica->persona_id_updated_at=1;
              }

              $programacion_unica->carrera = $value->carrera;
              /*$programacion_unica->ciclo = $value->ciclo;
              $programacion_unica->semestre = $value->semestre;*/
              $programacion_unica->curso_id = $curso->id;
              $programacion_unica->persona_id = $docente->id;
              $programacion_unica->fecha_inicio = $value->fecha_inicio;
              $programacion_unica->fecha_final = $value->fecha_final;
              $programacion_unica->save();
              //$array_programacion_unica.=','.$programacion_unica->programacion_unica_externo_id;
              // --

              // Proceso Programación
              $programacion = Programacion::where('programacion_externo_id', '=', $value->programacion_externo_id)
                              ->first();
              if (count($programacion) == 0) //Insert
              {
                  $programacion = new Programacion();
                  $programacion->programacion_externo_id = $value->programacion_externo_id;
                  $programacion->programacion_unica_id = $programacion_unica->id;
                  $programacion->persona_id = $alumno->id;
                  $programacion->persona_id_created_at=1;
              }
              else //Update
              {
                  $programacion->estado = 1;
                  $programacion->persona_id_updated_at=1;
              }
              $programacion->save();
              //$array_programacion.=','.$programacion->programacion_externo_id;
              // --
          }

          DB::commit();
          $data['return']= true;
          //$data['externo_id']=array('curso'=>$array_curso,'programacion_unica'=>$array_programacion_unica,'programacion'=>$array_programacion);
        }
        catch (\Exception $e)
        {
            //dd($e);
            DB::rollback();
            $data['return']= false;
        }
        return $data;
    }

    public function cargarPreguntas(Request $r )
    {
        if ( $r->ajax() ) {

          $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                                  ->where('tipo_evaluacion_id', '=', $r->tipo_evaluacion_id)
                                  ->where('estado_cambio', '=',0)
                                  ->where('estado',1)
                                  ->first();

          $val_evaluacion = '';
          $evaluacion_fecha_inicial = '';
          $evaluacion_fecha_final = '';
          $evaluacion_id=0;
          $evaluacion_estado_cambio=0;
          if( isset($evaluacion->estado_cambio) )
          {
            $evaluacion_estado_cambio = $evaluacion->estado_cambio;
            if($evaluacion->fecha_evaluacion_inicial <= date('Y-m-d') && $evaluacion->fecha_evaluacion_final >= date('Y-m-d'))
            {
              $balotario =  Balotario::where('programacion_unica_id', '=', $r->programacion_unica_id)
                            ->where('tipo_evaluacion_id', '=', $r->tipo_evaluacion_id)
                            ->where('modo', '=', 1)
                            ->first();
              if (count($balotario) == 0) {
                $renturnModel = NULL;
                $evaluacion_id = 0;
                $val_evaluacion = 'error_balotario';
              } else {
                $renturnModel = Evaluacion::listarPreguntas($r);
                $evaluacion_id = $evaluacion->id;
              }
            }
            else
            {
              $renturnModel = NULL;
              $evaluacion_id = 0;
              $val_evaluacion = 'error_fecha';
              //$evaluacion_fecha = date('Y-m-d');
              $evaluacion_fecha_inicial = $evaluacion->fecha_evaluacion_inicial;
              $evaluacion_fecha_final = $evaluacion->fecha_evaluacion_final;
            }
          }

            $return['rst'] = 1;

            $return['evaluacion_id'] = $evaluacion_id;
            $return['evaluacion_estado_cambio'] = $evaluacion_estado_cambio;
            $return['val_fecha_evaluacion'] = $val_evaluacion;
            $return['evaluacion_fecha_inicial'] = $evaluacion_fecha_inicial;
            $return['evaluacion_fecha_final'] = $evaluacion_fecha_final;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }


    public function verResultPreguntas(Request $r )
    {
        if ( $r->ajax() ) {
            
            $renturnModel = Evaluacion::verResultados($r);
            $return['rst'] = 1;
            $return['data'] = $renturnModel;
            $return['msj'] = "No hay registros aún";
            return response()->json($return);
        }
    }

    public function guardarEvaluacion(Request $r )
    {
        if ( $r->ajax() ) {
            $datos = json_decode($r->datos);
            //dd($datos);
            if($datos)
            {
              $val = false;
              $nota_puntaje = 0;
              $puntos= 20/count($datos);
              foreach ($datos as $key => $value)
              {
                $r['evaluacion_id'] = $value->evaluacion_id;
                $r['pregunta_id'] = $value->pregunta_id;
                $r['respuesta_id'] = $value->respuesta_id;
                $respuesta = Respuesta::find($value->respuesta_id);
                $r['puntaje'] = 0;
                if( $respuesta->correcto==1 ){
                  $r['puntaje'] = $puntos;
                }

                EvaluacionDetalle::runNew($r);
                $id_evaluacion = $value->evaluacion_id;
                $nota_puntaje += $r['puntaje'];
              }

                $r['id'] = $id_evaluacion;
                $r['nota'] = $nota_puntaje;
                $r['estado_cambio'] = 1;
                Evaluacion::runEdit($r);

            }

            $return['rst'] = 1;
            $return['msj'] = 'Evaluación registrado satisfactoriamente!';

            return response()->json($return);
        }
    }
    
    public function GenerateReprogramacion(Request $r ){
        if ( $r->ajax() ) {
            
            $rst= Evaluacion::runGenerateReprogramacion($r);
            
            if($rst==1){
                $return['msj'] = 'Reprogramación Generado';
            }else{
                $return['msj'] = 'Reprogramación no Generada';
            }
            
            $return['rst'] = $rst;
            return response()->json($return);
        }
    }

}

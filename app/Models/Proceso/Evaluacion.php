<?php
namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Models\Mantenimiento\Balotario;

use DB;

class Evaluacion extends Model
{
    //protected   $table = 'v_balotarios';
    protected   $table = 'v_evaluaciones';

    public static function listarPreguntas($r)
    {

      if( $r->has('validacion') ){
          $balotario= DB::table('v_balotarios AS b')
                      ->where('b.tipo_evaluacion_id','=', $r->tipo_evaluacion_id)
                      ->where('b.programacion_unica_id','=', $r->programacion_unica_id)
                      ->first();

          DB::beginTransaction();

          if(!isset($balotario->id)){
            $balotario = new Balotario();
            $balotario->programacion_unica_id = $r->programacion_unica_id;
            $balotario->tipo_evaluacion_id = $r->tipo_evaluacion_id;
            $balotario->persona_id_created_at=1;
            $balotario->cantidad_maxima =-1;
          }
          else{
            $balotario = Balotario::find($balotario->id);
            $balotario->estado=1;
            $balotario->persona_id_updated_at=2;
          }
          $balotario->cantidad_pregunta =10;
          $balotario->modo =1;
          $balotario->save();

          $curso =  DB::table('v_programaciones_unicas')
                    ->where('id',$r->programacion_unica_id)
                    ->first();

          $sql="
          INSERT INTO v_balotarios_preguntas (balotario_id, pregunta_id, estado, created_at, persona_id_created_at)
          SELECT $balotario->id, p.id, 1, NOW(), 1
          FROM v_preguntas p
          INNER JOIN v_unidades_contenido uc ON uc.id=p.unidad_contenido_id AND uc.tipo_evaluacion_id = $r->tipo_evaluacion_id
          LEFT JOIN v_balotarios_preguntas bp ON bp.pregunta_id=p.id AND bp.balotario_id=$balotario->id
          WHERE p.curso_id = $curso->curso_id
          AND bp.id IS NULL
          ";
          DB::insert($sql);

          DB::commit();
      }

      $balotario = DB::table('v_balotarios')
                        ->where('programacion_unica_id', $r->programacion_unica_id)
                        ->where('tipo_evaluacion_id', $r->tipo_evaluacion_id)
                        ->get();

      $sql = DB::table('v_balotarios AS b')
              ->join('v_balotarios_preguntas AS bp',function($join){
                  $join->on('b.id','=','bp.balotario_id');
              })
              ->join('v_preguntas AS p',function($join){
                  $join->on('bp.pregunta_id','=','p.id');
              })
              ->join('v_respuestas AS r',function($join){
                  $join->on('p.id','=','r.pregunta_id');
              })
              ->select(
              'b.id',
              'b.programacion_unica_id',
              'b.cantidad_pregunta',
              DB::raw('p.id AS pregunta_id'),
              'p.pregunta',
              'p.imagen',
              'p.puntaje',
              DB::raw('GROUP_CONCAT(CONCAT(r.id, ":", r.respuesta) SEPARATOR "|") as alternativas'),
              DB::raw('GROUP_CONCAT(CONCAT( ROUND(RAND()*10), ":", r.id, ":", r.respuesta) SEPARATOR "|") as alternativas_ex')
              )
              ->where(
                  function($query) use ($r){
                      $query->where('b.estado', '=', 1);

                      if( $r->has("programacion_unica_id") ){
                          $programacion_unica_id=trim($r->programacion_unica_id);
                          if( $programacion_unica_id !='' ){
                              $query->where('b.programacion_unica_id','=', $programacion_unica_id);
                          }
                      }

                      if( $r->has("tipo_evaluacion_id") ){
                          $tipo_evaluacion_id=trim($r->tipo_evaluacion_id);
                          if( $tipo_evaluacion_id !='' ){
                              $query->where('b.tipo_evaluacion_id','=', $tipo_evaluacion_id);
                          }
                      }
                  }
              )
              ->groupBy('b.id', 'p.id','b.programacion_unica_id','b.cantidad_pregunta','p.pregunta', 'p.imagen',
              'p.puntaje')
              ->inRandomOrder()
              ->limit($balotario[0]->cantidad_pregunta)
              ->get();
        $result=array('','');
        $result[0] = $sql;
        $result[1] = $balotario[0]->cantidad_pregunta;
        return $result;
    }

    public static function verResultados($r)
    {
      $sql = DB::table('v_evaluaciones AS e')
              ->join('v_evaluaciones_detalle AS ed',function($join){
                  $join->on('e.id','=','ed.evaluacion_id');
              })
              ->join('v_preguntas AS p',function($join){
                  $join->on('ed.pregunta_id','=','p.id');
              })
              ->join('v_respuestas AS r',function($join){
                  $join->on('ed.respuesta_id','=','r.id');
              })
              ->select(
              'e.id',
              DB::raw('p.id AS pregunta_id'),
              'p.pregunta',
              'p.imagen',
              DB::raw('r.id AS respuesta_id'),
              'r.respuesta',
              'ed.puntaje'
              )
              ->where(
                  function($query) use ($r){
                      $query->where('ed.estado', '=', 1);
                      $query->where('e.id', '=', $r->evaluacion_id);
                  }
              )
              ->get();
        $result = $sql;
        return $result;
    }

    public static function runNew($r)
    {

        $evaluacion = new Evaluacion;
        $evaluacion->programacion_id = trim( $r->programacion_id );
        $evaluacion->tipo_evaluacion_id = trim( $r->tipo_evaluacion_id );
        $evaluacion->fecha_evaluacion = trim( $r->fecha_evaluacion );

        //$evaluacion->estado_cambio = trim( $r->estado_cambio );
        $evaluacion->estado = 1;
        $evaluacion->persona_id_created_at=Auth::user()->id;
        $evaluacion->save();
    }

    public static function runEdit($r)
    {

        $evaluacion = Evaluacion::find($r->id);
        $evaluacion->nota = trim( $r->nota );
        $evaluacion->estado_cambio = trim( $r->estado_cambio );
        $evaluacion->fecha_examen = trim( $r->fecha_examen );
        $evaluacion->persona_id_updated_at=Auth::user()->id;
        $evaluacion->save();
    }
    
    public static function runGenerateReprogramacion($r)
    {

        $result= Programacion::select("ve.*")
                ->join('v_evaluaciones as ve',function($join){
                    $join->on('v_programaciones.id','=','ve.programacion_id')
                    ->where('ve.estado_cambio','=',0)
                    ->where('ve.estado','=',1);
                })
                ->where(
                      function($query) use ($r){
                            if( $r->has("programacion_unica_id") ){
                                $programacion_unica_id=trim($r->programacion_unica_id);
                                if( $programacion_unica_id !='' ){
                                    $query->where('v_programaciones.programacion_unica_id','=',$programacion_unica_id);
                                }
                            }
                            if( $r->has("programacion_id") ){
                                $programacion_id=trim($r->programacion_id);
                                if( $programacion_id !='' ){
                                    $query->where('ve.programacion_id','=',$programacion_id);
                                }
                            }
                            if( $r->has("tipo_evaluacion_id") ){
                                $tipo_evaluacion_id=trim($r->tipo_evaluacion_id);
                                if( $tipo_evaluacion_id !='' ){
                                    $query->where('ve.tipo_evaluacion_id','=',$tipo_evaluacion_id);
                                }
                            }
                      }
                )->get();

        if(count($result)>0){
            foreach ($result as $data){
                $evaluacion =Evaluacion::find($data->id);
                $evaluacion->fecha_reprogramada_inicial =$r->fecha_reprogramada_inicial;
                $evaluacion->fecha_reprogramada_final =$r->fecha_reprogramada_final;
                $evaluacion->estado_cambio =3;
                $evaluacion->persona_id_updated_at=Auth::user()->id;
                $evaluacion->save();
                
                $evaluacion=new Evaluacion;
                $evaluacion->programacion_id=$data->programacion_id;
                $evaluacion->tipo_evaluacion_id=$data->tipo_evaluacion_id;
                $evaluacion->fecha_evaluacion_inicial=$r->fecha_reprogramada_inicial;
                $evaluacion->fecha_evaluacion_final=$r->fecha_reprogramada_final;
                $evaluacion->estado_cambio=0;
                $evaluacion->persona_id_created_at=Auth::user()->id;
                $evaluacion->save();
            }
            return 1;
        }else{
            return 2;
        }
    }

    public static function verEvaluacion($r)
    {
        $sql = DB::table('v_evaluaciones AS e')
                ->join('v_programaciones AS p', 'p.id','=','e.programacion_id')
                ->join('v_programaciones_unicas AS pu', 'pu.id','=','p.programacion_unica_id')
                ->join('v_cursos AS c', 'c.id','=','pu.curso_id')
                ->join('v_personas AS pe', 'pe.id','=','p.persona_id')
                ->selectRaw('pe.paterno, pe.materno, pe.nombre, pe.dni
                , DATE(e.fecha_examen) fecha_examen, e.nota, c.curso')
                ->where('e.id', $r->id)
                ->first();
        return $sql;
    }

}

<?php
namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Models\Proceso\Evaluacion;
use DB;

class TipoEvaluacion extends Model
{
    protected   $table = 'v_tipos_evaluaciones';

    public static function runLoad($r)
    {
        if( $r->has('validacion') ){
            $tipos_evaluaciones=
            DB::table('v_programaciones AS p')
            ->join('v_programaciones_unicas AS pu',function($join){
                $join->on('pu.id','=','p.programacion_unica_id')
                ->where('pu.estado',1);
            })
            ->join('v_unidades_contenido AS uc',function($join){
                $join->on('uc.curso_id','=','pu.curso_id')
                ->where('uc.estado',1);
            })
            ->select('uc.tipo_evaluacion_id')
            ->where('p.id',$r->programacion_id)
            ->groupBy('uc.tipo_evaluacion_id')
            ->get();

            foreach ($tipos_evaluaciones as $key => $value) {
                $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                                ->where('tipo_evaluacion_id', '=', $value->tipo_evaluacion_id)
                                ->where('estado_cambio','<',2)
                                ->first();

                //$r['fecha_evaluacion'] = $value->fecha_evaluacion;
                if(!isset($evaluacion->id)) // Insert
                {
                  $evaluacion = new Evaluacion;
                  $evaluacion->programacion_id = $r->programacion_id;
                  $evaluacion->tipo_evaluacion_id = $value->tipo_evaluacion_id;
                  $evaluacion->persona_id_created_at=Auth::user()->id;
                }
                else{
                  $evaluacion->persona_id_updated_at=Auth::user()->id;
                }
                  
                  $evaluacion->fecha_evaluacion_inicial = date('Y-m-d');
                  $evaluacion->fecha_evaluacion_final = '2050-12-31';
                  $evaluacion->estado=1;
                  $evaluacion->save();
            }
        }

        $sql=DB::table('v_tipos_evaluaciones as te')
                  ->leftJoin('v_evaluaciones AS e',function($join){
                      $join->on('te.id','=','e.tipo_evaluacion_id')
                      ->where('e.estado',1);
                  })
                  ->leftJoin('v_programaciones AS vp',function($join){
                      $join->on('vp.id','=','e.programacion_id');
                  })
                  ->select(
                      'te.id',
                      'te.tipo_evaluacion',
                      'te.tipo_evaluacion_externo_id',
                      'te.estado',
                      DB::raw('MAX(e.estado_cambio) AS estado_cambio'),
                      DB::raw('MAX(e.id) AS evaluacion_id'),
                      DB::raw('MAX( CONCAT(e.fecha_examen,"|",e.id,"|",e.estado_cambio,"|",e.nota) ) AS evaluacion_resultado'),
                      DB::raw('MAX( CONCAT(e.id,"|",e.estado_cambio,"|",e.nota) ) AS evaluacion')
                    )
                  ->where('te.estado',1)
                  ->where(
                      function($query) use ($r){
                        
                        if( $r->has("programacion_id") ){
                            $programacion_id=trim($r->programacion_id);
                            if( $programacion_id !='' ){
                                $query->where('e.programacion_id','=', $r->programacion_id);
                            }
                        }
                        
                        if( $r->has("programacion_unica_id") ){
                            $programacion_unica_id=trim($r->programacion_unica_id);
                            if( $programacion_unica_id !='' ){
                                $query->where('vp.programacion_unica_id','=', $r->programacion_unica_id);
                            }
                        }
                        if( $r->has("estado_cambio") ){
                            $estado_cambio= explode(",",$r->estado_cambio);
                            if( $estado_cambio !='' ){
                                //$query->whereIn('e.estado_cambio', $estado_cambio);
                            }
                        }
                        
                      }
                  );
//                  if($r->has("programacion_unica_id")){
                      $sql->groupBy('te.id','te.tipo_evaluacion','te.tipo_evaluacion_externo_id','te.estado');
//                  }
        $result = $sql->paginate(20);
        return $result;
    }
}

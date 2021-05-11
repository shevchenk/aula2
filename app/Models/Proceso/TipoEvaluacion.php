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
            
            DB::beginTransaction();
            $sql="UPDATE v_evaluaciones SET estado=0 WHERE programacion_id='".$r->programacion_id."'";
            DB::update($sql);

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
            ->join('v_tipos_evaluaciones AS te',function($join){
                $join->on('te.id','=','uc.tipo_evaluacion_id');
            })
            ->select('uc.tipo_evaluacion_id','te.tipo_evaluacion_externo_id')
            ->where('p.id',$r->programacion_id)
            ->whereNotNull('uc.tipo_evaluacion_id')
            ->groupBy('uc.tipo_evaluacion_id','te.tipo_evaluacion_externo_id')
            ->orderBy('uc.id')
            ->get();

            foreach ($tipos_evaluaciones as $key => $value) {
                $clave = array_search( $value->tipo_evaluacion_externo_id , array_column($r->evaluacion, 'tipo_evaluacion_id'));

                $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                                ->where('tipo_evaluacion_id', '=', $value->tipo_evaluacion_id)
                                ->where('estado_cambio','<',2)
                                ->orderBy('id','desc')
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
                  $evaluacion->peso_evaluacion = $r->evaluacion[$clave]->peso_evaluacion;
                  $evaluacion->orden = $key+1; //$r->evaluacion[$clave]->orden;
                  $evaluacion->estado=1;
                  $evaluacion->save();
            }
            DB::commit();
        }

        $nota_minima = $r->evaluacion[0]->nota_minima;

        $sql=DB::table('v_tipos_evaluaciones as te')
                  ->join('v_evaluaciones AS e',function($join){
                      $join->on('te.id','=','e.tipo_evaluacion_id')
                      ->where('e.estado',1);
                  })
                  ->join('v_programaciones AS vp',function($join){
                      $join->on('vp.id','=','e.programacion_id');
                  })
                  ->select(
                      'te.id',
                      'te.tipo_evaluacion',
                      'te.tipo_evaluacion_externo_id',
                      'te.estado',
                      DB::raw('MAX(e.orden) AS orden'),
                      DB::raw('MAX(e.estado_cambio) AS estado_cambio'),
                      DB::raw('MAX(e.id) AS evaluacion_id'),
                      DB::raw('MAX( CONCAT(IFNULL(e.fecha_examen,""),"|",e.id,"|",e.estado_cambio,"|",e.nota,"|",e.orden,"|",e.peso_evaluacion,"|'.$nota_minima.'") ) AS evaluacion_resultado'),
                      DB::raw('MAX( CONCAT(e.id,"|",e.estado_cambio,"|",e.nota,"|",e.orden,"|",e.peso_evaluacion,"|'.$nota_minima.'") ) AS evaluacion')
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
                      $sql->groupBy('te.id','te.tipo_evaluacion','te.tipo_evaluacion_externo_id','te.estado')
                      ->orderBy('orden');
//                  }
        $result = $sql->paginate(20);
        return $result;
    }
}

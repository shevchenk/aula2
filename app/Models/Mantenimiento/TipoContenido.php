<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TipoContenido extends Model
{
    protected   $table = 'v_tipos_contenidos';
    
        public static function runEditStatus($r)
    {
        $tipo_contenido = TipoContenido::find($r->id);
        $tipo_contenido->estado = trim( $r->estadof );
        $tipo_contenido->persona_id_updated_at=Auth::user()->id;
        $tipo_contenido->save();
    }

    public static function runNew($r)
    {
        $tipo_contenido = new TipoContenido;
        $tipo_contenido->tipo_contenido = trim( $r->tipo_contenido );
        $tipo_contenido->estado = trim( $r->estado );
        $tipo_contenido->persona_id_created_at=Auth::user()->id;
        $tipo_contenido->save();
    }

    public static function runEdit($r)
    {
        $tipo_contenido = TipoContenido::find($r->id);
        $tipo_contenido->tipo_contenido = trim( $r->tipo_contenido );
        $tipo_contenido->estado = trim( $r->estado );
        $tipo_contenido->persona_id_updated_at=Auth::user()->id;
        $tipo_contenido->save();
    }


    public static function runLoad($r)
    {
        $sql=TipoContenido::select('v_tipos_contenidos.id','v_tipos_contenidos.tipo_contenido','v_tipos_contenidos.estado')

            ->where( 
                    
                function($query) use ($r){

                    if( $r->has("tipo_contenido") ){
                        $tipo_contenido=trim($r->tipo_contenido);
                        if( $tipo_contenido !='' ){
                            $query->where('v_tipos_contenidos.tipo_contenido','like','%'.$tipo_contenido.'%');
                        }   
                    }
                    
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('v_tipos_contenidos.estado','=',''.$estado.'');
                        }
                    }
                }
            );
        $result = $sql->orderBy('v_tipos_contenidos.tipo_contenido','asc')->paginate(10);
        return $result;
    }
    
    public static function ListarTipoContenido($r)
    {  
        $sql= TipoContenido::select('id','tipo_contenido','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('tipo_contenido','asc')->get();
        return $result;
    }
}

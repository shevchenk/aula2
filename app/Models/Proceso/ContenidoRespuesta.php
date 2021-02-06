<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class ContenidoRespuesta extends Model
{
    protected   $table = 'v_contenidos_respuestas';

    public static function runLoad($r){
        $result=ContenidoRespuesta::select('v_contenidos_respuestas.id', 'v_contenidos_respuestas.contenido_id',
                DB::raw("CONCAT_WS(' ',vpe.paterno,vpe.materno,vpe.nombre) as alumno"),
                'v_contenidos_respuestas.created_at','v_contenidos_respuestas.respuesta',
                'v_contenidos_respuestas.ruta_respuesta', 'v_contenidos_respuestas.nota', 
                'v_contenidos_respuestas.comentario', 'v_contenidos_respuestas.ruta_comentario',
                'v_contenidos_respuestas.estado', 'v_contenidos_respuestas.created_at')
            ->join('v_programaciones as vpr',function($join){
                $join->on('vpr.id','=','v_contenidos_respuestas.programacion_id');
            })
            ->join('v_personas as vpe','vpe.id','=','vpr.persona_id')
            ->where( 
                function($query) use ($r){
                    if( $r->has("programacion_id")){
                        $programacion_id=trim($r->programacion_id);
                        if( $programacion_id !=''){
                            $query->where('vpr.id','=',$r->programacion_id);
                        }
                    }
                }
            )
            ->where('v_contenidos_respuestas.contenido_id','=',$r->contenido_id)
            ->where('v_contenidos_respuestas.estado','=',1)
            ->orderBy('v_contenidos_respuestas.created_at','desc')->get();
        return $result;
    }

    public static function runEditStatus($r)
    {
        $contenido = ContenidoRespuesta::find($r->id);
        $contenido->estado = trim( $r->estadof );
        $contenido->persona_id_updated_at=Auth::user()->id;
        $contenido->save();
    }

    // --
    public static function runNew($r)
    {
        $validacion =   ContenidoRespuesta::where('programacion_id','=',$r->programacion_id)
                        ->where('contenido_id','=',$r->contenido_id)
                        ->where('estado','=', 1)
                        ->first();
        if( isset($validacion->nota) AND ($validacion->nota!='' AND $validacion->nota > 0) ){
            return 0;
        }
        else{
            ContenidoRespuesta::where('programacion_id','=',$r->programacion_id)
                                ->where('contenido_id','=',$r->contenido_id)
                                  ->update(array(
                                    'estado' => 0,
                                    'persona_id_updated_at' => Auth::user()->id));
    
            $contenido = new ContenidoRespuesta;
            $contenido->contenido_id = trim( $r->contenido_id );
            $contenido->programacion_id = trim( $r->programacion_id );
            $contenido->respuesta = trim( $r->respuesta );
            if(trim($r->file_nombre)!='' and trim($r->file_archivo)!=''){
                $contenido->ruta_respuesta = trim( $r->file_nombre );
                $url = "file/content/".$r->file_nombre;
                $ftf=new ContenidoRespuesta;
                $ftf->fileToFile($r->file_archivo, $url);
            }
            $contenido->estado = 1;
            $contenido->persona_id_created_at=Auth::user()->id;
            $contenido->save();
            return 1;
        }
    }
    // --

    public static function guardarNotaRpta($r)
    {
        $contenido = ContenidoRespuesta::find($r->id);
        if( $r->has('nota') AND $r->nota > 0 ){
            $contenido->nota = trim( $r->nota );
        }

        $contenido->comentario = trim( $r->comentario );

        if( $r->has('archivo') AND $r->archivo != '' ){
            $contenido->ruta_comentario = "R-".$r->nombre_archivo;
            $url = "file/content/R-".$r->nombre_archivo;
            $ftf=new ContenidoRespuesta;
            $ftf->fileToFile($r->archivo, $url);
        }

        $contenido->persona_id_updated_at=Auth::user()->id;
        $contenido->save();
    }

    public static function guardarRecalificar($r)
    {
        DB::beginTransaction();
        $contenido = ContenidoRespuesta::find($r->id);
        $contenido->estado = 0;
        $contenido->persona_id_updated_at=Auth::user()->id;
        $contenido->save();

        $contenidoNew = New ContenidoRespuesta;
        $contenidoNew->contenido_id = $contenido->contenido_id;
        $contenidoNew->programacion_id = $contenido->programacion_id;
        $contenidoNew->respuesta = $contenido->respuesta;
        $contenidoNew->ruta_respuesta = $contenido->ruta_respuesta;
        $contenidoNew->estado = 1;
        $contenidoNew->persona_id_created_at=Auth::user()->id;
        $contenidoNew->save();
        DB::commit();
    }


    public function fileToFile($file, $url){

        $urld = explode("/",$url);
        $urlt = array();

        for ($i=0; $i < (count($urld)-1) ; $i++) {
            array_push($urlt, $urld[$i]);
            $urltexto=implode("/",$urlt);
            if ( !is_dir($urltexto) ) {
                mkdir($urltexto,0777);
            }
        }

        list($type, $file) = explode(';', $file);
        list(, $type)      = explode('/', $type);

        if ($type=='jpeg') $type='jpg';
        if ($type=='x-icon') $type='ico';
        if (strpos($type,'document')!==False) $type='docx';
        if (strpos($type,'msword')!==False) $type='doc';
        if (strpos($type,'presentation')!==False) $type='pptx';
        if (strpos($type,'powerpoint')!==False) $type='ppt';
        if (strpos($type, 'sheet') !== False) $type='xlsx';
        if (strpos($type, 'excel') !== False) $type='xls';
        if (strpos($type, 'pdf') !== False) $type='pdf';
        if ($type=='plain') $type='txt';

        list(, $file) = explode(',', $file);
        $file = base64_decode($file);
        file_put_contents($url , $file);

        return $url.$type;
    }
}

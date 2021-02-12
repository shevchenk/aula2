<?php

namespace App\Models\Proceso;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Mantenimiento\Menu;
use DB;

class Contenido extends Model
{
    protected   $table = 'v_contenidos';

    public static function runEditStatus($r){

        $contenido = Contenido::find($r->id);
        $contenido->estado = trim( $r->estadof );
        $contenido->persona_id_updated_at=Auth::user()->id;
        $contenido->save();

        // Eliminar archivo
        $dir = new Contenido();
        $dir->deleteDirectory("file/content/c$contenido->id");
        // --
    }

    private function deleteDirectory($dir)
    {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
            if($current != '.' && $current != '..') {
                if (!@unlink($dir.'/'.$current))
                    deleteDirectory($dir.'/'.$current);
            }
        }
        closedir($dh);
        @rmdir($dir);
    }

    public static function runNew($r){

        $contenido = new Contenido;
        $contenido->programacion_unica_id = trim( $r->programacion_unica_id );
        $contenido->curso_id = trim( $r->curso_id );
        $contenido->unidad_contenido_id = trim( $r->unidad_contenido_id );
        $contenido->titulo_contenido = trim( $r->titulo_contenido );
        $contenido->contenido = trim( $r->contenido );
        $contenido->tipo_respuesta = trim( $r->tipo_respuesta );
        if($r->tipo_respuesta==1 or $r->tipo_respuesta==2){
            if($r->fecha_inicio!=''){
                $contenido->fecha_inicio =$r->fecha_inicio ;
            }
            if($r->fecha_final!=''){
                $contenido->fecha_final =$r->fecha_final;
            }
            if($r->hora_inicio!=''){
                $contenido->hora_inicio =$r->hora_inicio ;
            }
            if($r->hora_final!=''){
                $contenido->hora_final =$r->hora_final;
            }
            if($r->fecha_ampliada!=''){
                $contenido->fecha_ampliada =$r->fecha_ampliada;
            }
        }else{
            $contenido->fecha_inicio = null;
            $contenido->fecha_final = null;
        }
        if($r->referencia!=''){
            $contenido->referencia= implode('|', $r->referencia);
        }else{
            $contenido->referencia=null;
        }
        if($r->fecha_inicio_d!=''){
            $contenido->fecha_inicio_d =$r->fecha_inicio_d ;
        }
        if($r->fecha_final_d!=''){
            $contenido->fecha_final_d =$r->fecha_final_d;
        }
        if($r->fecha_ampliada_d!=''){
            $contenido->fecha_ampliada_d =$r->fecha_ampliada_d;
        }
        $contenido->estado = trim( $r->estado );
        $contenido->persona_id_created_at=Auth::user()->id;
        $contenido->save();

        if( trim($r->file_nombre)!='' ){
            $type=explode(".",$r->file_nombre);
            $extension=".".end($type);
        }
        if( trim($r->file_archivo)!='' AND !$r->has('chk_archivo') ){
            $url = "file/content/c$contenido->id/A$contenido->id".$extension;
            $contenido->ruta_contenido = "c$contenido->id/A$contenido->id".$extension;
            Menu::fileToFile($r->file_archivo, $url);
        }

        $contenido->foto='no disponible.jpg';

        if( trim($r->foto_nombre)!='' ){
            $type=explode(".",$r->foto_nombre);
            $extension=".".end($type);
        }
        if( trim($r->foto_archivo)!='' AND !$r->has('chk_archivo2') ){
            $url = "file/content/c$contenido->id/F$contenido->id".$extension;
            $contenido->foto = "c$contenido->id/F$contenido->id".$extension;
            Menu::fileToFile($r->foto_archivo, $url);
        }

        $contenido->video = '';
        if( $r->has('video') AND $r->video!='' ){
            $contenido->video = trim($r->video);
            $contenido->ruta_contenido = "";
        }
        $contenido->save();

    }

    public static function runEdit($r)
    {
        $contenido = Contenido::find($r->id);
        $contenido->contenido = trim( $r->contenido );
        $contenido->unidad_contenido_id = trim( $r->unidad_contenido_id );
        $contenido->titulo_contenido = trim( $r->titulo_contenido );
        
        if( trim($r->file_nombre)!='' ){
            $type=explode(".",$r->file_nombre);
            $extension=".".end($type);
        }
        if( trim($r->file_archivo)!='' AND !$r->has('chk_archivo') ){
            $url = "file/content/c$contenido->id/A$contenido->id".$extension;
            $contenido->ruta_contenido = "c$contenido->id/A$contenido->id".$extension;
            Menu::fileToFile($r->file_archivo, $url);
        }

        if( trim($r->foto_nombre)!='' ){
            $type=explode(".",$r->foto_nombre);
            $extension=".".end($type);
        }
        if( trim($r->foto_archivo)!='' AND !$r->has('chk_archivo2') ){
            $url = "file/content/c$contenido->id/F$contenido->id".$extension;
            $contenido->foto = "c$contenido->id/F$contenido->id".$extension;
            Menu::fileToFile($r->foto_archivo, $url);
        }

        $contenido->video = '';
        if( $r->has('video') AND $r->video!='' ){
            $contenido->video = trim($r->video);
            $contenido->ruta_contenido = "";
        }
        
        $contenido->tipo_respuesta = trim( $r->tipo_respuesta );
        if($r->tipo_respuesta==1 or $r->tipo_respuesta==2){
            if($r->fecha_inicio!=''){
                $contenido->fecha_inicio =$r->fecha_inicio ;
            }
            if($r->fecha_final!=''){
                $contenido->fecha_final =$r->fecha_final;
            }
            if($r->hora_inicio!=''){
                $contenido->hora_inicio =$r->hora_inicio ;
            }
            if($r->hora_final!=''){
                $contenido->hora_final =$r->hora_final;
            }
            if($r->fecha_ampliada!=''){
                if( $r->fecha_ampliada!=$contenido->fecha_ampliada ){
                    $contenido->persona_masivo=Auth::user()->id;
                }
                $contenido->fecha_ampliada =$r->fecha_ampliada;
            }
        }else{
            $contenido->fecha_inicio = null;
            $contenido->fecha_final = null;
        }
        if($r->referencia!=''){
            $contenido->referencia= implode('|', $r->referencia);
        }else{
            $contenido->referencia=null;
        }
        if($r->fecha_inicio_d!=''){
            $contenido->fecha_inicio_d =$r->fecha_inicio_d ;
        }
        if($r->fecha_final_d!=''){
            $contenido->fecha_final_d =$r->fecha_final_d;
        }
        if($r->fecha_ampliada_d!=''){
            $contenido->fecha_ampliada_d =$r->fecha_ampliada_d;
        }
        $contenido->estado = trim( $r->estado );
        $contenido->persona_id_updated_at=Auth::user()->id;
        $contenido->save();
    }


    public static function runLoad($r){
        $result=DB::table('v_contenidos as vc')
                ->select('vc.id','vc.contenido',DB::raw('IFNULL(vc.referencia,"") as referencia'),'vc.ruta_contenido','vc.video',
                'vc.tipo_respuesta','vtc.color',
                DB::raw('IFNULL(vc.fecha_inicio,"") as fecha_inicio'),
                DB::raw('IFNULL(vc.hora_inicio,"") as hora_inicio'),
                DB::raw('IFNULL(vc.hora_final,"") as hora_final'),'vc.unidad_contenido_id','vc.titulo_contenido',
                DB::raw('IFNULL(vc.fecha_final,"") as fecha_final'),'vuc.unidad_contenido',
                DB::raw('IFNULL(vc.fecha_ampliada,"") as fecha_ampliada'),'vc.foto as foto_contenido',
                'vcu.curso', 'vc.estado','vc.curso_id','vc.programacion_unica_id',
                DB::raw('CASE vc.tipo_respuesta  WHEN 0 THEN "Solo vista" WHEN 1 THEN "Requiere Respuesta" END AS tipo_respuesta_nombre'),
                DB::raw('IFNULL(vc.fecha_inicio_d,"") as fecha_inicio_d'),
                DB::raw('IFNULL(vc.fecha_final_d,"") as fecha_final_d'),
                DB::raw('IFNULL(vc.fecha_ampliada_d,"") as fecha_ampliada_d'))
                ->join('v_cursos as vcu','vcu.id','=','vc.curso_id')
                ->join('v_unidades_contenido as vuc','vuc.id','=','vc.unidad_contenido_id')
                ->join('v_tipos_contenidos as vtc','vtc.id','=','vc.tipo_respuesta')
                ->where(
                    function($query) use ($r){
                      $query->where('vc.estado','=',1);

                      if( $r->has("programacion_unica_id") ){
                          $programacion_unica_id=trim($r->programacion_unica_id);
                          if( $programacion_unica_id !='' ){
                              $query->where('vc.programacion_unica_id','=', $programacion_unica_id);
                          }
                      }

                      if( $r->has("tipo_respuesta") ){
                          $tipo_respuesta=trim($r->tipo_respuesta);
                          if( $tipo_respuesta !='' ){
                              $query->where('vc.tipo_respuesta','=', $tipo_respuesta);
                          }
                      }

                      if( $r->has("curso_id") ){
                          $curso_id=trim($r->curso_id);
                          if( $curso_id !='' ){
                              $query->where('vc.curso_id','=', $curso_id);
                          }
                      }
                      if( $r->has("distinto_programacion_unica_id") ){
                          $programacion_unica_id=trim($r->distinto_programacion_unica_id);
                          if( $programacion_unica_id !='' ){
                              $query->where('vc.programacion_unica_id','!=', $programacion_unica_id);
                          }
                      }
                    }
                )
            ->orderBy('vuc.unidad_contenido','asc')
            ->orderBy('vtc.orden','asc')
            ->orderBy('vc.titulo_contenido','asc')->get();
        return $result;
    }

    public function fileToFile($file, $id ,$url)
    {
        if ( !is_dir('file') ) {
            mkdir('file',0777);
        }
        if ( !is_dir('file/content/'.$id) ) {
            mkdir('file/content/'.$id,0777);
        }
        list($type, $file) = explode(';', $file);
        list(, $type) = explode('/', $type);
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
        list(, $file)      = explode(',', $file);
        $file = base64_decode($file);
        file_put_contents($url , $file);
        return $url. $type;
    }

    // --
    public static function runLoadContenidoProgra($r){
        $result=DB::table('v_contenidos AS vc')
                ->select('vc.id','vc.contenido','vc.ruta_contenido',
                DB::raw('IFNULL(vc.referencia,"") as referencia'),
                'vc.titulo_contenido','vc.video','vc.tipo_respuesta','vtc.color',
                DB::raw('IFNULL(vc.fecha_inicio,"") as fecha_inicio'),
                DB::raw('IFNULL(vc.fecha_final,"") as fecha_final'),'vuc.unidad_contenido',
                DB::raw('IFNULL(vc.fecha_ampliada,"") as fecha_ampliada'),
                DB::raw('IFNULL(vc.hora_inicio,"") as hora_inicio'),
                DB::raw('IFNULL(vc.hora_final,"") as hora_final'),
                'vc.foto as foto_contenido','vc.unidad_contenido_id',
                'vcu.curso', 'vc.estado','vc.curso_id','vc.programacion_unica_id',
                DB::raw('CASE vc.tipo_respuesta  WHEN 0 THEN "Solo vista" WHEN 1 THEN "Requiere Respuesta" END AS tipo_respuesta_nombre'))
            ->join('v_cursos as vcu','vcu.id','=','vc.curso_id')
            ->join('v_unidades_contenido as vuc','vuc.id','=','vc.unidad_contenido_id')
            ->join('v_tipos_contenidos as vtc','vtc.id','=','vc.tipo_respuesta')
            ->where('vc.programacion_unica_id','=',$r->programacion_unica_id)
            ->where('vc.estado','=',1)
            ->orderBy('vuc.unidad_contenido','asc')
            ->orderBy('vtc.orden','asc')
            ->orderBy('vc.titulo_contenido','asc')->get();
        return $result;
    }

    public static function ValidaCarga($r)
    {
        $result=DB::table('v_programaciones_unicas AS vpu')
                ->select(DB::raw('DATE(vpu.fecha_inicio) as fecha'))
                ->where('id',$r->aux_id)
                ->first();

        $retorno['val']=0;
        if( $result->fecha<=date('Y-m-d') ){
            $retorno['val']=1;
        }
        $retorno['fecha']=$result->fecha;
        $retorno['programacion_id']=$r->aux_programacion_id;
        $retorno['id']=$r->aux_id;
        $retorno['curso_id']=$r->aux_curso_id;
        $retorno['curso']=$r->aux_curso;
        $retorno['imagen']=$r->aux_imagen;
        return $retorno;
    }
    // --
        public static function runNewCopiaContenido($r){

            if($r->id!=''){
                $id= implode(',', $r->id);
                $data=Contenido::whereRaw('id IN ('.$id.')')->get();
            }else{
                $data=array();
            }

            foreach ($data as $result){
                $contenido = new Contenido;
                $contenido->programacion_unica_id =$r->programacion_unica_id;
                $contenido->curso_id =$result->curso_id;
                $contenido->contenido =$result->contenido;
                $contenido->tipo_respuesta =$result->tipo_respuesta;
                $contenido->titulo_contenido =$result->titulo_contenido;
                $contenido->unidad_contenido_id =$result->unidad_contenido_id;
                if($result->fecha_inicio!=''){
                    $contenido->fecha_inicio =$result->fecha_inicio ;
                }
                if($result->fecha_final!=''){
                    $contenido->fecha_final =$result->fecha_final;
                }
                if($result->fecha_ampliada!=''){
                    $contenido->fecha_ampliada =$result->fecha_ampliada;
                }
                $contenido->referencia=  $result->referencia;
                $contenido->estado =$result->estado;
                $contenido->persona_id_created_at=Auth::user()->id;
                $contenido->save();
                
                if ( !is_dir('file/content/c'.$contenido->id) ) {
                     mkdir('file/content/c'.$contenido->id,0777);
                }
                $file_archivo=explode('/', $result->ruta_contenido);
                $file_fichero = 'file/content/'.$result->ruta_contenido;
                $file_nuevo_fichero = 'file/content/c'.$contenido->id.'/'.$file_archivo[1];
                
                copy($file_fichero,$file_nuevo_fichero);
                $contenido->ruta_contenido='c'.$contenido->id.'/'.$file_archivo[1];
                
                if($result->foto!='default/nodisponible.png'){
                    $archivo=explode('/', $result->foto);
                    $fichero = 'file/content/'.$result->foto;
                    $nuevo_fichero = 'file/content/c'.$contenido->id.'/'.$archivo[1];

                    copy($fichero,$nuevo_fichero);
                    $contenido->foto='c'.$contenido->id.'/'.$archivo[1]; 
                }else{
                    $contenido->foto=$result->foto; 
                }

                $contenido->save();
            }

        }

}


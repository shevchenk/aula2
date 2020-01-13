<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Mantenimiento\UnidadContenido;
use DB;

class Curso extends Model
{
    protected   $table = 'v_cursos';

    public static function ListCursos($r){
        $sql=Curso::select('id','curso','estado')
            ->where('estado','=','1');
        $result = $sql->orderBy('curso','asc')->get();
        return $result;
    }

    public static function runEdit($r)
    {
        DB::beginTransaction();
        $usuario = Auth::user()->id;
        $curso = Curso::find($r->id);
        $curso->persona_id_updated_at = $usuario;
        $curso->valida_evaluacion = $r->valida_evaluacion;
        if( $r->has('file_archivo') AND $r->file_archivo!='' AND $r->file_nombre!=''){
            $type=explode(".",$r->file_nombre);
            $extension=".".$type[1];
            $este = new Curso;
            $url = "img/course/c".$curso->id.$extension; 
            $este->fileToFile($r->file_archivo, $url);
            $curso->imagen = $url;
        }
        if( $r->has('file_archivo2') AND $r->file_archivo2!='' AND $r->file_nombre2!=''){
            $type=explode(".",$r->file_nombre2);
            $extension=".".$type[1];
            $este = new Curso;
            $url = "img/course/c_v".$curso->id.$extension; 
            $este->fileToFile($r->file_archivo2, $url);
            $curso->imagen2 = $url;
        }
        $curso->link = trim($r->link);
        $curso->whatsapp = trim($r->whatsapp);
        $curso->save();

        DB::table('v_unidades_contenido')
        ->where('curso_id','=', $r->id)
        ->update(
            array(
                'estado' => 0,
                'persona_id_updated_at' => $usuario,
                'updated_at' => date('Y-m-d H:i:s')
                )
            );

        $unidad_contenido= $r->unidad_contenido;
        $id_unidad_contenido= $r->id_unidad_contenido;
        if( $r->has('unidad_contenido') ){
            for ($i=0; $i < count($unidad_contenido) ; $i++) { 
                $UC=UnidadContenido::find($id_unidad_contenido[$i]);

                if( !isset($UC->id) )
                {
                    $UC = new UnidadContenido;
                    $UC->curso_id = $r->id;
                    $UC->persona_id_created_at = $usuario;
                }
                else{
                    $UC->persona_id_updated_at = $usuario;
                }
                $UC->unidad_contenido=$unidad_contenido[$i];
                if( $r->has('tipo_evaluacion_'.$id_unidad_contenido[$i]) AND COUNT($r['tipo_evaluacion_'.$id_unidad_contenido[$i]])>0 ){
                    $tipo_evaluacion = implode( ",", $r['tipo_evaluacion_'.$id_unidad_contenido[$i] ] );
                    $UC->tipo_evaluacion_id=  $tipo_evaluacion;
                }
                else{
                    $UC->tipo_evaluacion_id= '';
                }
                $UC->estado=1;
                $UC->save();
            }
        }
        DB::commit();
    }
    
    public static function runLoad($r){
        $result=DB::table('v_cursos AS c')
                ->leftJoin('v_unidades_contenido AS vuc', function($join){
                    $join->on('vuc.curso_id','=','c.id')
                    ->where('vuc.estado',1);
                })
                ->select('c.id','c.curso','c.curso_externo_id','c.estado','c.imagen'
                    ,'c.imagen2', 'c.link', 'c.whatsapp'
                    ,DB::raw(' GROUP_CONCAT(vuc.unidad_contenido SEPARATOR "|") AS unidad_contenido ')
                    ,'c.valida_evaluacion'
                )
                ->where(
                    function($query) use ($r){
                        $query->where('c.estado','=', 1);
                        if( $r->has("curso") ){
                              $curso=trim($r->curso);
                              if( $curso !='' ){
                                  $query->where('c.curso','like','%'.$curso.'%');
                              }
                        }
                        if( $r->session()->has('empresa_id') ){
                            $query->where('empresa_externo_id', session('empresa_id'));
                        }
                    }
                )
                ->groupBy('c.id','c.curso','c.curso_externo_id','c.valida_evaluacion','c.estado','c.imagen','c.imagen2','c.link','c.whatsapp')
                ->paginate(10);

        return $result;
    }
    
    public function fileToFile($file, $url){
        if ( !is_dir('img') ) {
            mkdir('img',0777);
        }
        if ( !is_dir('img/course') ) {
            mkdir('img/course',0777);
        }

        if( is_file($url) ){
            @unlink($url);
        }
        
        list($type, $file) = explode(';', $file);
        list(, $type) = explode('/', $type);
        if ($type=='jpeg') $type='jpg';
        if (strpos($type,'document')!==False) $type='docx';
        if (strpos($type, 'sheet') !== False) $type='xlsx';
        if (strpos($type, 'pdf') !== False) $type='pdf';
        if ($type=='plain') $type='txt';
        list(, $file)      = explode(',', $file);

        $file = base64_decode($file);
        file_put_contents($url , $file);
        return $url. $type;
    }
    
    public static function CargarUnidadContenido($r){
        $sql=DB::table('v_unidades_contenido')
            ->select('id','unidad_contenido','tipo_evaluacion_id')
            ->where('curso_id', $r->id)
            ->where('estado','=','1');
        $result = $sql->orderBy('unidad_contenido','asc')->get();
        return $result;
    }
}

?>

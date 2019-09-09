<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Mantenimiento\Menu;
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
        $usuario = Auth::user()->id;
        $curso = Curso::find($r->id);
        $curso->persona_id_updated_at = $usuario;
        $url='';
        if(trim($r->file_archivo)!=''){
            $type=explode(".",$r->file_nombre);
            $extension=".".$type[1];
            $este = new Curso;
            $url = "img/course/c".$curso->id.$extension; 
            $este->fileToFile($r->file_archivo, $url);
        }
        $curso->imagen = $url;
        $curso->save();
    }
    
    public static function runLoad($r){
        $result=DB::table('v_cursos AS c')
                ->select('c.id','c.curso','c.curso_externo_id','c.estado','c.imagen')
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
                )->paginate(10);

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
    
}

?>

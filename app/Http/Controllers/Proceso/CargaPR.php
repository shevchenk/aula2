<?php

namespace App\Http\Controllers\Proceso;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mantenimiento\Curso;
use App\Models\Mantenimiento\UnidadContenido;
use App\Models\Mantenimiento\Pregunta;
use App\Models\Mantenimiento\Respuesta;
use Excel;

class CargaPR extends Controller {

    public function __construct() {
        $this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    }

    public function CargaPreguntaRespuesta() {

        ini_set('memory_limit', '512M');
        if (isset($_FILES['carga']) and $_FILES['carga']['size'] > 0) {

            $uploadFolder = 'txt/preguntarespuesta';

            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder);
            }

            $nombreArchivo = explode(".", $_FILES['carga']['name']);
            $tmpArchivo = $_FILES['carga']['tmp_name'];
            $archivoNuevo = $nombreArchivo[0] . "_u" . Auth::user()->id . "_" . date("Ymd_his") . "." . $nombreArchivo[1];
            $file = $uploadFolder . '/' . $archivoNuevo;

            $m = "Ocurrio un error al subir el archivo. No pudo guardarse.";
            if (!move_uploaded_file($tmpArchivo, $file)) {
                $return['rst'] = 2;
                $return['msj'] = $m;
                return response()->json($return);
            }
            
            $array_error = array();
            $no_pasa = 0;
            $array = array();

            $file = file('txt/preguntarespuesta/' . $archivoNuevo);
            
            /*$detfile = explode("\t", $file[270]);
            $aux=$detfile[2];
            $aux2=$detfile[2];
            $aux= trim(utf8_encode($aux));
            $aux2= trim(htmlspecialchars($aux2, ENT_IGNORE, "UTF-8"));
            if(strlen($aux2)==strlen($detfile[2])){
                $detfile[2]=trim(htmlspecialchars($detfile[2], ENT_IGNORE, "UTF-8"));
            }
            else{
                $detfile[2]=trim(utf8_encode($detfile[2]));
            }
            $buscar=array('¿','&iquest;','&#191;');
            $reemplazar=array('','','');
            $detfile[2]=str_replace($buscar, $reemplazar, $detfile[2]);
            dd("(".strlen($aux).")".$aux." || (".strlen($aux2).")".$aux2." || (".strlen($detfile[2]).")".$detfile[2]);
            */

            for ($i = 0; $i < count($file); $i++) {

                DB::beginTransaction();
                if (trim($file[$i]) != '') {
                    //$file[$i]=$this->ValidarUTF8($file[$i]);
                    $detfile = explode("\t", $file[$i]);

                    $con = 0;
                    for ($j = 0; $j < count($detfile); $j++) {
                        $buscar = array(chr(13) . chr(10), "\r\n", "\n", "�", "\r", "\n\n", "\xEF", "\xBB", "\xBF");
                        $reemplazar = "";
                        $detfile[$j] = trim(str_replace($buscar, $reemplazar, $detfile[$j]));
                        $array[$i][$j] = $detfile[$j];
                        $con++;
                    }
                    $detfile[0]=$this->ValidarUTF8($detfile[0]);
                    //$detfile[0]=trim($detfile[0]);
                    $curso = Curso::where('curso', '=', $detfile[0])
                                    ->where('estado','=',1)
                                    ->where(function($query){
                                        if( session('empresa_id')!=null ){
                                            $query->where('empresa_externo_id',session('empresa_id'));
                                        }
                                    })
                                    ->first();
                    $detfile[1]=$this->ValidarUTF8($detfile[1]);
                    //$detfile[1]=trim($detfile[1]);
                    $curso_id=0;
                    if( isset($curso->id) ){
                        $curso_id=$curso_id;
                    }
                    $unidadcontenido =UnidadContenido::where('unidad_contenido', '=', $detfile[1])
                                        ->where('curso_id', '=' ,$curso_id)
                                        ->where('estado','=',1)->first();


                    if (!isset($unidadcontenido->id) or !isset($curso->id)) {
                        
                        if(!isset($curso->id)){
                              $msg_error = ($i+1).'- Motivo: No se encontro Curso: '.$detfile[0].'<br>'; 
                              array_push($array_error, $msg_error);
                        }
                        if(!isset($unidadcontenido->id)){
                              $msg_error = ($i+1).'- Motivo: No se encontro Unidad de Contenido: '.$detfile[1].'<br>'; 
                              array_push($array_error, $msg_error);  
                        }
                        $no_pasa=$no_pasa+1;
                        DB::rollBack();
                        continue;
                        
                    } else {
                        $detfile[2]=$this->ValidarUTF8($detfile[2]);
                        //$detfile[2]=trim($detfile[2]);
                        $vpregunta =Pregunta::where('pregunta', '=', $detfile[2] )
                                    ->where('curso_id','=',$curso->id)
                                    ->where('unidad_contenido_id','=',$unidadcontenido->id)
                                    ->first();
                        if( isset($vpregunta->id) ){
                            $pregunta= Pregunta::find($vpregunta->id);
                            $pregunta->estado=1;
                            $pregunta->persona_id_updated_at = Auth::user()->id;
                        }
                        else{
                            $pregunta = new Pregunta;
                            $pregunta->pregunta = $detfile[2];
                            $pregunta->puntaje = 1;
                            $pregunta->persona_id_created_at = Auth::user()->id;
                        }
                        $pregunta->curso_id = $curso->id;
                        $pregunta->unidad_contenido_id = $unidadcontenido->id;
                        $pregunta->save();

                        for ($h = 3; $h < count($detfile); $h += 2) {
                            $detfile[$h]=$this->ValidarUTF8($detfile[$h]);
                            //$detfile[$h]=trim($detfile[$h]);
                            if (trim($detfile[$h]) != '') {
                                $vrespuesta =Respuesta::where('respuesta', '=', $detfile[$h] )
                                             ->where('pregunta_id','=',$pregunta->id)->first();
                                if( isset($vrespuesta->id) ){
                                    $respuesta= Respuesta::find($vrespuesta->id);
                                    $respuesta->persona_id_created_at = Auth::user()->id;
                                }
                                else{
                                    $respuesta = new Respuesta;
                                    $respuesta->pregunta_id = $pregunta->id;
                                    $respuesta->tipo_respuesta_id = 1;
                                    $respuesta->respuesta = $detfile[$h];
                                    $respuesta->persona_id_created_at = Auth::user()->id;
                                }
                                    $respuesta->correcto = $detfile[$h + 1];
                                    $respuesta->puntaje = $detfile[$h + 1];
                                    $respuesta->save();
                            }
                        }
                    }
                }
                DB::commit();
            }

            if (count($array_error) > 0 or $no_pasa > 1) {
                    $return['error_carga'] = $array_error;
                    $return['no_pasa'] = $no_pasa;
                    $return['rst'] = 2;
                    $return['msj'] = 'Existieron algunos errores';
            } else {
                    $return['rst'] = 1;
                    $return['msj'] = 'Archivo procesado correctamente';
            }

            return response()->json($return);
        }
    }

    public function ValidarUTF8($valor){
        $retorno='';
        $retorno=trim(htmlspecialchars($valor, ENT_IGNORE, "UTF-8"));
        return $retorno;
    }
    
    public function ExportPlantilla(Request $r ){
        $renturnModel = $this->runExportPlantilla($r);
        
        Excel::create('Plantilla', function($excel) use($renturnModel) {

        $excel->setTitle('Plantilla de carga')
              ->setCreator('Jorge Salcedo')
              ->setCompany('JS Soluciones')
              ->setDescription('Plantilla de carga de preguntas y respuestas');

        $excel->sheet('Plantillas', function($sheet) use($renturnModel) {
            $sheet->setOrientation('landscape');
            $sheet->setPageMargin(array(
                0.25, 0.30, 0.25, 0.30
            ));

            $sheet->setStyle(array(
                'font' => array(
                    'name'      =>  'Bookman Old Style',
                    'size'      =>  8,
                    'bold'      =>  false
                )
            ));

            $sheet->cell('A1', function($cell) {
                $cell->setValue('CARGA DE PREGUNTAS Y RESPUESTAS');
                $cell->setFont(array(
                    'family'     => 'Bookman Old Style',
                    'size'       => '20',
                    'bold'       =>  true
                ));
            });
            $sheet->mergeCells('A1:'.$renturnModel['max'].'1');
            $sheet->cells('A1:'.$renturnModel['max'].'1', function($cells) {
                $cells->setBorder('solid', 'none', 'none', 'solid');
                $cells->setAlignment('center');
                $cells->setValignment('center');
            });

            $sheet->setWidth($renturnModel['length']);
            $sheet->fromArray(array(
                array(''),
                $renturnModel['cabecera']
            ));

            $data=json_decode(json_encode($renturnModel['data']), true);
            $sheet->rows($data);

            $sheet->cells('A3:'.$renturnModel['max'].'3', function($cells) {
                $cells->setBorder('solid', 'none', 'none', 'solid');
                $cells->setAlignment('center');
                $cells->setValignment('center');
                $cells->setFont(array(
                    'family'     => 'Bookman Old Style',
                    'size'       => '10',
                    'bold'       =>  true
                ));
            });
            
            $sheet->setAutoSize(array(
                'M', 'N','O'
            ));

            $count = $sheet->getHighestRow();

            $sheet->getStyle('M4:O'.$count)->getAlignment()->setWrapText(true);
            
            $sheet->setBorder('A3:'.$renturnModel['max'].$count, 'thin');

        });
        
        })->export('xlsx');
    }
    
    public static function runExportPlantilla($r){
        
        $rsql= array(array('Curso Prueba','Unidad Prueba','Pregunta Prueba','Rpta 1 Prueba','0','Rpta 2 Prueba','1','Rpta 3 Prueba','0','Rpta n','0'));

        $length=array(
            'A'=>5,'B'=>15,'C'=>20,'D'=>20,'E'=>20,'F'=>15,'G'=>15,'H'=>25,'I'=>30,
            'J'=>15,'K'=>15,
        );
        $cabecera=array(
            'Curso','Unidad de Contenido','Pregunta','Respuesta 1','Alternativa Correcta 1','Respuesta 2','Alternativa Correcta 2',
            'Respuesta 3','Alternativa Correcta 3','Respuesta n','Alternativa Correcta n'
        );
        $campos=array();

        $r['data']=$rsql;
        $r['cabecera']=$cabecera;
        $r['campos']=$campos;
        $r['length']=$length;
        $r['max']='K'; // Max. Celda en LETRA
        return $r;
    }

    public function ExportGestorContenido(Request $r ){
        $renturnModel = $this->runExportGestorContenido($r);
        
        Excel::create('Plantilla', function($excel) use($renturnModel) {

        $excel->setTitle('Gestor Contenido')
              ->setCreator('Jorge Salcedo')
              ->setCompany('JS Soluciones')
              ->setDescription('Situación del gestor de contenido');

        $excel->sheet('GC', function($sheet) use($renturnModel) {
            $sheet->setOrientation('landscape');
            $sheet->setPageMargin(array(
                0.25, 0.30, 0.25, 0.30
            ));

            $sheet->setStyle(array(
                'font' => array(
                    'name'      =>  'Bookman Old Style',
                    'size'      =>  8,
                    'bold'      =>  false
                )
            ));

            $sheet->cell('A1', function($cell) {
                $cell->setValue('Resumen Gestor de Contenido');
                $cell->setFont(array(
                    'family'     => 'Bookman Old Style',
                    'size'       => '20',
                    'bold'       =>  true
                ));
            });
            $sheet->mergeCells('A1:'.$renturnModel['max'].'1');
            $sheet->cells('A1:'.$renturnModel['max'].'1', function($cells) {
                $cells->setBorder('solid', 'none', 'none', 'solid');
                $cells->setAlignment('center');
                $cells->setValignment('center');
            });

            $sheet->setWidth($renturnModel['length']);
            $sheet->fromArray(array(
                array(''),
                $renturnModel['cabecera']
            ));

            $data=json_decode(json_encode($renturnModel['data']), true);
            $sheet->rows($data);

            $sheet->cells('A3:'.$renturnModel['max'].'3', function($cells) {
                $cells->setBorder('solid', 'none', 'none', 'solid');
                $cells->setAlignment('center');
                $cells->setValignment('center');
                $cells->setFont(array(
                    'family'     => 'Bookman Old Style',
                    'size'       => '10',
                    'bold'       =>  true
                ));
            });
            
            /*$sheet->setAutoSize(array(
                'M', 'N','O'
            ));*/

            $count = $sheet->getHighestRow();

            $sheet->getStyle('M4:O'.$count)->getAlignment()->setWrapText(true);
            
            $sheet->setBorder('A3:'.$renturnModel['max'].$count, 'thin');

        });
        
        })->export('xlsx');
    }

    public static function runExportGestorContenido($r){
        
        $rsql= array();

        $length=array(
            'A'=>5,'B'=>15,'C'=>20,'D'=>20,'E'=>20,'F'=>15,'G'=>15,'H'=>25,'I'=>30,
            'J'=>15,'K'=>15,
        );
        $cabecera=array(
            'Curso','Unidad de Contenido','Pregunta','Respuesta 1','Alternativa Correcta 1','Respuesta 2','Alternativa Correcta 2',
            'Respuesta 3','Alternativa Correcta 3','Respuesta n','Alternativa Correcta n'
        );
        $campos=array();

        $r['data']=$rsql;
        $r['cabecera']=$cabecera;
        $r['campos']=$campos;
        $r['length']=$length;
        $r['max']='K'; // Max. Celda en LETRA
        return $r;
    }

}

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
use App\Models\Tcpdf\Pdf;
use TCPDF_FONTS;
use Hash;

class EvaluacionPR extends Controller 
{
    private $api;
    private $servidor;

    public function __construct()
    {
        $this->api = new Api();
        $this->servidor = 'http://localhost/miaula/public';
        if( $_SERVER['SERVER_NAME']=='miaula.formacioncontinua.pe' ){
            $this->servidor = 'http://miaula.formacioncontinua.pe';
        }
        elseif( $_SERVER['SERVER_NAME']=='capamiaula.formacioncontinua.pe' ){
            $this->servidor = 'http://capamiaula.formacioncontinua.pe';
        }

        if( !isset($_GET['key']) ){
            $this->middleware('auth');
        }
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

    public function DescargarCertificadoV2(Request $r)
    {
        if ( $r->ajax() ) {
            $programacion = Programacion::find($r->id);
            if( $programacion->deuda_total*1 == 0 ){
                $return['rst'] = 1;
                $return['archivo_certificado'] = $programacion->archivo_certificado;
                if( $programacion->archivo_certificado == '' ){
                    $return['rst'] = 2;
                }
            }
            else{
                $return['rst'] = 3;
            }
            return response()->json($return); 
        }
    }

    public function validarCurso(Request $r)
    {
        if( trim(session('idcliente'))=='' ){
            session(['idcliente' => 2]);
        }
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
        $val['cursos']=array();

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

        $r['dni'] = Auth::user()->dni;
        $renturnModel = Curso::runLoad($r);
        $return['rst'] = 1;
        $return['data'] = $renturnModel;
        $return['data2'] = $val['cursos'];
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
              if (!isset($alumno->id))
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
              if (!isset($curso->id))
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
              if (!isset($docente->id))
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
              if (!isset($programacion_unica->id))
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
                if (!isset($programacion->id)) //Insert
                {
                  $programacion = new Programacion();
                  $programacion->programacion_externo_id = $value->programacion_externo_id;
                  $programacion->persona_id_created_at=1;
                }
                else //Update
                {
                    $programacion->estado = 1;
                    $programacion->persona_id_updated_at=1;
                }

                if( isset($value->archivo_certificado) ){
                    $programacion->archivo_certificado = '';
                    $programacion->deuda_total = $value->deuda_total;
                    
                    if( $value->archivo_certificado != '' ){
                        $programacion->archivo_certificado = str_replace('miaula.','',$this->servidor).'/'.$value->archivo_certificado;
                    }
                }
                
              $programacion->persona_id = $alumno->id;
              $programacion->programacion_unica_id = $programacion_unica->id;
              $programacion->fecha_matricula = $value->fecha_matricula;
              $programacion->save();
              //$array_programacion.=','.$programacion->programacion_externo_id;
              // --
          }

          foreach ($objArr->data->cursos as $key => $value) {
              $curso = Curso::where('curso_externo_id','=', $value->curso_externo_id)
                        ->first();
              $cursos= array();
              if (isset($curso->id))
              {
                $value->imagen=$curso->imagen;
                $value->imagen2 = $curso->imagen2;
                $value->link = $curso->link;
                $value->whatsapp = $curso->whatsapp;
              }
          }

          DB::commit();
          $data['return']= true;
          $data['cursos'] = $objArr->data->cursos;
          //$data['externo_id']=array('curso'=>$array_curso,'programacion_unica'=>$array_programacion_unica,'programacion'=>$array_programacion);
        }
        catch (\Exception $e)
        {
            dd($e);
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
          $renturnModel = array(array(),10);
          $seguir=true;

          $validaFechaInicio = Programacion::find($r->programacion_id);
          $hoy= date('Y-m-d');
          $dias = 0;

          $validardias = DB::table('v_programaciones_unicas AS pu')
                         ->join('v_cursos AS c','c.id','=','pu.curso_id')
                         ->where('pu.id',$r->programacion_unica_id)
                         ->select('c.dias','c.intentos')
                         ->first();

          $dias = $validardias->dias;
          $intentos = $validardias->intentos;

          $fecha_matricula = date('Y-m-d', strtotime($validaFechaInicio->fecha_matricula.' + '.$dias.' days'));

          if( $fecha_matricula > $hoy ){
              $seguir=false;
              $evaluacion_fecha_inicial = $fecha_matricula;
              $val_evaluacion = 'error_matricula';
          }

          if( ($r->valida_evaluacion==2 OR $r->valida_evaluacion==3) AND $seguir==true ){
            $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                          ->where('tipo_evaluacion_id', '=', $r->tipo_evaluacion_id)
                          ->where('estado',1)
                          ->first();
            if( $r->valida_evaluacion==2 ){
                $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                              ->where('orden', '<', $evaluacion->orden)
                              ->where('nota', '<', $r->nota_minima)
                              ->where('estado',1)
                              ->first();
                if( isset($evaluacion->id) ){
                    $seguir=false;
                    $val_evaluacion = 'error_tipo_2';
                }
            }
            else{
                $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                              ->where('orden', '<', $evaluacion->orden)
                              ->where('estado_cambio', '=', '0')
                              ->where('estado',1)
                              ->first();
                if( isset($evaluacion->id) ){
                    $seguir=false;
                    $val_evaluacion = 'error_tipo_3';
                }
            }

          }

          if( isset($evaluacion->estado_cambio) AND $seguir==true )
          {
            $evaluacion_estado_cambio = $evaluacion->estado_cambio;
            if($evaluacion->fecha_evaluacion_inicial <= date('Y-m-d') && $evaluacion->fecha_evaluacion_final >= date('Y-m-d'))
            {
              $balotario =  Balotario::where('programacion_unica_id', '=', $r->programacion_unica_id)
                            ->where('tipo_evaluacion_id', '=', $r->tipo_evaluacion_id)
                            ->where('modo', '=', 1)
                            ->first();
              if (!isset($balotario->id) AND !$r->has('validacion')) {
                $renturnModel = array(array(),10);
                $evaluacion_id = 0;
                $val_evaluacion = 'error_balotario';
              } else {
                $renturnModel = Evaluacion::listarPreguntas($r);
                $evaluacion_id = $evaluacion->id;
              }
            }
            else
            {
              $renturnModel = array(array(),10);
              $evaluacion_id = 0;
              $val_evaluacion = 'error_fecha';
              //$evaluacion_fecha = date('Y-m-d');
              $evaluacion_fecha_inicial = $evaluacion->fecha_evaluacion_inicial;
              $evaluacion_fecha_final = $evaluacion->fecha_evaluacion_final;
            }
          }
          elseif( $seguir==true ){
              $renturnModel = array(array(),10);
              $evaluacion_id = 0;
              $val_evaluacion = 'error_intento';
              $seguir=false;
              if( $r->has('validacion') ){
                  $evaluacion = Evaluacion::where('programacion_id', '=', $r->programacion_id)
                                ->where('tipo_evaluacion_id', '=', $r->tipo_evaluacion_id)
                                ->whereRaw('DATE(fecha_examen)=CURDATE()')
                                ->get();
                  if( count($evaluacion) < $intentos OR $intentos == 0 ){
                      DB::beginTransaction();

                      $sql="UPDATE v_evaluaciones
                            SET estado_cambio = 2
                            WHERE estado = 1
                            AND estado_cambio = 1
                            AND tipo_evaluacion_id = $r->tipo_evaluacion_id
                            AND programacion_id = $r->programacion_id
                            ";
                      DB::update($sql);

                      $evaluacion = new Evaluacion;
                      $evaluacion->programacion_id = $r->programacion_id;
                      $evaluacion->tipo_evaluacion_id = $r->tipo_evaluacion_id;
                      $evaluacion->persona_id_created_at=1;
                      $evaluacion->fecha_evaluacion_inicial = date('Y-m-d');
                      $evaluacion->fecha_evaluacion_final = '2050-12-31';
                      $evaluacion->estado=1;
                      $evaluacion->save();
                      DB::commit();

                      $val_evaluacion = '';
                      $seguir=true;
                      $renturnModel = Evaluacion::listarPreguntas($r);
                      $evaluacion_id = $evaluacion->id;
                  }
              }
          }

          if( count($renturnModel[0])<$renturnModel[1] AND $seguir==true ){
            $val_evaluacion='error_cantidad';
          }

            $return['rst'] = 1;
            $return['evaluacion_id'] = $evaluacion_id;
            $return['evaluacion_estado_cambio'] = $evaluacion_estado_cambio;
            $return['val_fecha_evaluacion'] = $val_evaluacion;
            $return['intentos'] = $intentos;
            $return['evaluacion_fecha_inicial'] = $evaluacion_fecha_inicial;
            $return['evaluacion_fecha_final'] = $evaluacion_fecha_final;
            $return['data'] = $renturnModel[0];
            $return['cantidad'] = $renturnModel[1];
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
              //dd($puntos.'=>'.count($datos));
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
                $r['fecha_examen'] = date('Y-m-d H:i:s');
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

    public function DescargarCertificado(Request $r){
        $key = array('','');
        if( $r->has('key') ){
            $key = explode('.$/$.',$r->key);
            if( Hash::check($key[1], $key[0]) ){
                $r['programacion_id'] = $key[1];
                $r['nota_minima'] = $key[2];
            }
            else{
                $r['programacion_id'] = 0;
                $r['nota_minima'] = 0;
            }
        }
        //dd($r);

        $evaluacion = Evaluacion::verEvaluacion($r);
        $mes=['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
        $fecha= explode("-","2019-01-01");
        $nombre='';
        $curso='';
        $nota=0;
        $empresa_id=0;

        if( isset($evaluacion->dni) ){
            if( trim($evaluacion->fecha_examen)=='' ){
                $evaluacion->fecha_examen= date('Y-m-d');
            }
            $fecha= explode("-", $evaluacion->fecha_examen);
            $nombre = $evaluacion->nombre." ".$evaluacion->paterno." ".$evaluacion->materno;
            $curso = $evaluacion->curso;
            $nota = $evaluacion->nota;
            $empresa_id = $evaluacion->empresa_externo_id;
        }
        /*$nombre = 'DEL AGUILA JIMENEZ CAROLINA FIORELLA DEL CARMEN';
        $nombre = 'ISAAC LUIS EDUARDO MORI GUERRA';
        $curso= 'VALIDACION DE INSTRUMENTO DE INVESTIGACION Y PROCESAMIENTO DE DATOS';
        $curso= 'MATEMÁTICA FINANCIERA Y GESTIÓN DE DOCUMENTOS FINANCIEROS Y MERCANTILES';
        $curso= 'SEO TÉCNICO: POSICIONAMIENTO AVANZADO';
        $curso= 'NORMAS DE REDACCIÓN APLICADAS EN LA INVESTIGACIÓN CIENTÍFICA (NORMAS APA Y CHICAGO)';*/

        $pdf = new Pdf('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $imageFile = 'certificado/certificado'.$empresa_id.'.png';
        /*if ( !is_file( $imageFile )){
          $imageFile = 'certificado/certificado.jpg';
        }*/
        if ( $nota<$r->nota_minima ){
            $imageFile = 'certificado/certificado'.$empresa_id.'_v.png';
        }
        elseif ( $r->has('key') ){
            $imageFile = 'certificado/certificado'.$empresa_id.'_qr.png';
        }
        
        $pdf->ActivarFondo($imageFile);

        $key=bcrypt($r->programacion_id);

        $qrData = array(
            'url' => $this->servidor."/ReportDinamic/Proceso.EvaluacionPR@DescargarCertificado?key=".$key.".$/$.".$r->programacion_id.".$/$.".$r->nota_minima,
            'posx' => 230,
            'posy' => 160,
            'w' => 35,
            'h' => 35,
            'color' => array(0,32,96)
        );

        if( $nota>= $r->nota_minima AND !$r->has('key') ){
            $pdf->ActivarQR($qrData);
        }


        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Jorge Salcedo');
        $pdf->SetTitle('Certificado Digital');
        $pdf->SetSubject('Certificado del Curso');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->AddPage();
        $fontname = TCPDF_FONTS::addTTFfont('fonts/Calibri Regular.ttf', 'TrueTypeUnicode', '', 32);
        $pdf->SetTextColor(0, 32, 96);
        
        if( $nota< $r->nota_minima OR ($nota>= $r->nota_minima AND !$r->has('key')) ){
            $pdf->Ln(55);
            $pdf->SetFont($fontname, '', 17, '', false);
            $pdf->Cell(50, 17, 'Otorgado a:   ', 0, 0, 'R', 0, '');
            $pdf->SetFont($fontname, '', 25, '', false);
            $pdf->MultiCell(190, 0, $nombre, 'B', 'C', 0, 1, '', '',true);
            
            $pdf->SetFont($fontname, '', 17, '', false);
            $pdf->Cell(135, 15, 'Por su participación y aprobación en el curso de:', 0, 1, 'R', 0, '');
            
            $pdf->SetFont($fontname, '', 25, '', false);
            $pdf->Cell(20, 0, '', 0, 0, 'R', 0, '');
            $pdf->MultiCell(220, 0, $curso, 'B', 'C', 0, 1, '', '', true);

            $pdf->SetFont($fontname, '', 17, '', false);
            $pdf->Cell(123, 15, 'con una duración de 210 horas académicas.', 0, 1, 'R', 0, '');
            $pdf->Cell(140, 12, 'Lima,', 0, 0, 'R', 0, '');
            $pdf->SetFont($fontname, '', 25, '', false);
            $pdf->Cell(100, 0, $fecha[2].' de '.$mes[$fecha[1]*1].' del '.$fecha[0], 0, 1, 'C', 0, '');

            if( !$r->has('quitar_firma') ){
                $pdf->Image('certificado/secretaria'.$empresa_id.'.png', 60, 165, 70, 30, '', '', '', true, 300, '', false, false, 0, false, false, false);
                $pdf->Image('certificado/director'.$empresa_id.'.png', 140, 168, 70, 30, '', '', '', true, 300, '', false, false, 0, false, false, false);
            }
        }
        elseif ($nota>=$r->nota_minima AND $r->has('key')){
            $pdf->Ln(45);
            $pdf->SetFont($fontname, '', 16, '', false);
            $pdf->MultiCell(0, 0, 'La Secretaría General da constancia de la validez de este certificado, cuyos datos se encuentran registrados en nuestro sistema informático.', 0, 'L', 0, 1, '', '',true);

            $pdf->Ln(15);
            $pdf->SetFont($fontname, '', 16, '', false);
            $pdf->Cell(90, 10, 'Este certificado ha sido otorgado a:', 0, 0, '', 0, '');
            $pdf->SetFont($fontname, '', 24, '', false);
            $pdf->MultiCell(164, 0, $nombre, 0, 'C', 0, 1, '', '',true);

            $pdf->SetFont($fontname, '', 16, '', false);
            $pdf->Cell(0, 15, 'Por haber participado y aprobado el curso de:', 0, 1, '', 0, '');

            $pdf->SetFont($fontname, '', 24, '', false);
            $pdf->MultiCell(0, 0, $curso, '', 'C', 0, 1, '', '', true);
            
            $pdf->Ln(1);
            $pdf->SetFont($fontname, '', 16, '', false);
            $pdf->MultiCell(0, 0, 'Con una duración de 210 horas académicas, realizando su evaluación final el día '.$fecha[2].'-'.$fecha[1].'-'.$fecha[0].' obteniendo la nota de: '.($nota*1), '', '', 0, 0, '', '', true);

            $pdf->Ln(25);
            $fecha = explode( "-", date('Y-m-d') );
            $pdf->Cell(160, 0, 'Lima,', 0, 0, 'R', 0, '');
            $pdf->Cell(70, 0, $fecha[2].' de '.$mes[$fecha[1]*1].' del '.$fecha[0], 0, 1, 'C', 0, '');
            $pdf->Image('certificado/secretaria'.$empresa_id.'.png', 80, 165, 70, 30, '', '', '', true, 300, '', false, false, 0, false, false, false);
        }
        $pdf->Output('example_002.pdf', 'I');
    }

    public function guardarNota(Request $r )
    {
        if ( $r->ajax() ) {
            $programacion = Programacion::find($r->programacion_id);
            $programacion->nota_final = $r->nota;
            $programacion->save();
            $return['rst']=1;
            return response()->json($return);
        }
    }

    public function DescargarCertificadoMasivo(Request $r){
        $key = array('','');
        if( $r->has('key') ){
            $key = explode('.$/$.',$r->key);
            if( Hash::check($key[1], $key[0]) ){
                $r['programacion_id'] = $key[1];
                $r['nota_minima'] = $key[2];
            }
            else{
                $r['programacion_id'] = 0;
                $r['nota_minima'] = 0;
            }
        }
        
        $pdf = new Pdf('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
          $pdf->SetAuthor('Jorge Salcedo');
          $pdf->SetTitle('Certificado Digital');
          $pdf->SetSubject('Certificado del Curso');
          $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

          $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
          $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
          $pdf->SetAutoPageBreak(TRUE, 0);
          $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $ids = explode(",",$r->programacion_id);

        for ($i=0; $i < count($ids); $i++) { 
          $r['programacion_id'] = $ids[$i];
          $evaluacion = Evaluacion::verEvaluacion($r);

          $mes=['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
          $fecha= explode("-","2019-01-01");
          $nombre='';
          $curso='';
          $nota=0;
          $empresa_id=0;

          if( isset($evaluacion->dni) ){
              if( trim($evaluacion->fecha_examen)=='' ){
                  $evaluacion->fecha_examen= date('Y-m-d');
              }
              $fecha= explode("-", $evaluacion->fecha_examen);
              $nombre = $evaluacion->nombre." ".$evaluacion->paterno." ".$evaluacion->materno;
              $curso = $evaluacion->curso;
              $nota = $evaluacion->nota;
              $empresa_id = $evaluacion->empresa_externo_id;
          }

          if( $i==0 ){
              $imageFile = 'certificado/certificado'.$empresa_id.'.png';
              if ( $nota<$r->nota_minima ){
                  $imageFile = 'certificado/certificado'.$empresa_id.'_v.png';
              }
              elseif ( $r->has('key') ){
                  $imageFile = 'certificado/certificado'.$empresa_id.'_qr.png';
              }
              $pdf->ActivarFondo($imageFile);
          }

          $key=bcrypt($r->programacion_id);

          $qrData = array(
              'url' => $this->servidor."/ReportDinamic/Proceso.EvaluacionPR@DescargarCertificado?key=".$key.".$/$.".$r->programacion_id.".$/$.".$r->nota_minima,
              'posx' => 230,
              'posy' => 160,
              'w' => 35,
              'h' => 35,
              'color' => array(0,32,96)
          );

          if( $nota>= $r->nota_minima AND !$r->has('key') ){
              $pdf->ActivarQR($qrData);
          }
          
          $pdf->AddPage();
          $fontname = TCPDF_FONTS::addTTFfont('fonts/Calibri Regular.ttf', 'TrueTypeUnicode', '', 32);
          $pdf->SetTextColor(0, 32, 96);
          
          if( $nota< $r->nota_minima OR ($nota>= $r->nota_minima AND !$r->has('key')) ){
              $pdf->Ln(55);
              $pdf->SetFont($fontname, '', 17, '', false);
              $pdf->Cell(50, 17, 'Otorgado a:   ', 0, 0, 'R', 0, '');
              $pdf->SetFont($fontname, '', 25, '', false);
              $pdf->MultiCell(190, 0, $nombre, 'B', 'C', 0, 1, '', '',true);
              
              $pdf->SetFont($fontname, '', 17, '', false);
              $pdf->Cell(135, 15, 'Por su participación y aprobación en el curso de:', 0, 1, 'R', 0, '');
              
              $pdf->SetFont($fontname, '', 25, '', false);
              $pdf->Cell(20, 0, '', 0, 0, 'R', 0, '');
              $pdf->MultiCell(220, 0, $curso, 'B', 'C', 0, 1, '', '', true);

              $pdf->SetFont($fontname, '', 17, '', false);
              $pdf->Cell(123, 15, 'con una duración de 210 horas académicas.', 0, 1, 'R', 0, '');
              $pdf->Cell(140, 12, 'Lima,', 0, 0, 'R', 0, '');
              $pdf->SetFont($fontname, '', 25, '', false);
              $pdf->Cell(100, 0, $fecha[2].' de '.$mes[$fecha[1]*1].' del '.$fecha[0], 0, 1, 'C', 0, '');

              if( !$r->has('quitar_firma') ){
                  $pdf->Image('certificado/secretaria'.$empresa_id.'.png', 60, 165, 70, 30, '', '', '', true, 300, '', false, false, 0, false, false, false);
                  $pdf->Image('certificado/director'.$empresa_id.'.png', 140, 168, 70, 30, '', '', '', true, 300, '', false, false, 0, false, false, false);
              }
          }
          elseif ($nota>=$r->nota_minima AND $r->has('key')){
              $pdf->Ln(45);
              $pdf->SetFont($fontname, '', 16, '', false);
              $pdf->MultiCell(0, 0, 'La Secretaría General da constancia de la validez de este certificado, cuyos datos se encuentran registrados en nuestro sistema informático.', 0, 'L', 0, 1, '', '',true);

              $pdf->Ln(15);
              $pdf->SetFont($fontname, '', 16, '', false);
              $pdf->Cell(90, 10, 'Este certificado ha sido otorgado a:', 0, 0, '', 0, '');
              $pdf->SetFont($fontname, '', 24, '', false);
              $pdf->MultiCell(164, 0, $nombre, 0, 'C', 0, 1, '', '',true);

              $pdf->SetFont($fontname, '', 16, '', false);
              $pdf->Cell(0, 15, 'Por haber participado y aprobado el curso de:', 0, 1, '', 0, '');

              $pdf->SetFont($fontname, '', 24, '', false);
              $pdf->MultiCell(0, 0, $curso, '', 'C', 0, 1, '', '', true);
              
              $pdf->Ln(1);
              $pdf->SetFont($fontname, '', 16, '', false);
              $pdf->MultiCell(0, 0, 'Con una duración de 210 horas académicas, realizando su evaluación final el día '.$fecha[2].'-'.$fecha[1].'-'.$fecha[0].' obteniendo la nota de: '.($nota*1), '', '', 0, 0, '', '', true);

              $pdf->Ln(25);
              $fecha = explode( "-", date('Y-m-d') );
              $pdf->Cell(160, 0, 'Lima,', 0, 0, 'R', 0, '');
              $pdf->Cell(70, 0, $fecha[2].' de '.$mes[$fecha[1]*1].' del '.$fecha[0], 0, 1, 'C', 0, '');
              $pdf->Image('certificado/secretaria'.$empresa_id.'.png', 80, 165, 70, 30, '', '', '', true, 300, '', false, false, 0, false, false, false);
          }
        }
        $pdf->Output('example_002.pdf', 'I');
    }

    public function EnviarAlerta(Request $r)
    {
        if( trim(session('idcliente'))=='' ){
            session(['idcliente' => 2]);
        }
        $idcliente = session('idcliente');
        $tab_cli = DB::table('clientes_accesos')
                      ->where('id','=', $idcliente)
                      ->where('estado','=', 1)
                      ->first();

        // URL (CURL)
        $cli_links = DB::table('clientes_accesos_links')
                      ->where('cliente_acceso_id','=', $idcliente)
                      ->where('tipo','=', 5)
                      ->first();
        $buscar = array("pkey", "pdni","pcurso");
        $reemplazar = array($tab_cli->keycli, Auth::user()->dni, $r->curso);
        $url = str_replace($buscar, $reemplazar, $cli_links->url);
        if( $r->has('tipo') ){
          $url.='&tipo='.$r->tipo;
        }
        $objArr = $this->api->curl($url);
        //dd($url);
        $return_response = '';
        $val['cursos']=array();
        $return['rst'] = 2;


        if (empty($objArr))
        {
            $return_response = $this->api->response(422,"error","Ingrese sus datos de envio");
        }
        else if( isset($objArr->key->id) && isset($objArr->key->token) )
        {
        
            $tab_cli = DB::table('clientes_accesos')
                        ->select('id', 'key')
                        ->where('id','=', $objArr->key->id)
                        ->where('key','=', $objArr->key->token)
                        //->where('ip','=', $this->api->getIPCliente())
                        ->where('estado','=', 1)
                        ->first();
            if($objArr->key->id == @$tab_cli->id && $objArr->key->token == @$tab_cli->key)
            {
                if($objArr->key->ok == "ok"){
                    $return['rst'] = 1;
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
        
        return response()->json($return);
    }

    public function VerEvaluaciones(Request $r)
    {
      if ( $r->ajax() ) {
            $r['persona_id'] = Auth::user()->id;
            $evaluaciones = Evaluacion::VerEvaluaciones($r);
            $return['rst']=1;
            $return['data']=$evaluaciones;
            return response()->json($return);
        }
    }

    public function SolicitarCertificado(Request $r)
    {
      if ( $r->ajax() ) {
            $r['persona_id'] = Auth::user()->id;
            $return = Evaluacion::SolicitarCertificado($r);
            return response()->json($return);
        }
    }

}

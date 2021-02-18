@extends('layout.master')

@section('include')
@parent
{{ Html::style('lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}
{{ Html::script('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}
{{ Html::script('lib/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}

{{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}

@include( 'proceso.alumno.gestor2.css.gestor2' )
@include( 'proceso.alumno.gestor2.js.gestor2_ajax' )
@include( 'proceso.alumno.gestor2.js.contenido2_ajax' )

@include( 'proceso.alumno.gestor2.js.gestor2' )
@include( 'proceso.alumno.gestor2.js.contenido2' )

@stop

@section('content')
<section class="content-header">
    <h1>Gestor
        <small>Contenidos</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Contenidos</a></li>
        <li class="active">Gestor</li>
    </ol>
</section>

<section class="content">
    <form id="CursosForm" method="POST">
        <div id="cursosUnicos" class="row animate-box" data-animate-effect="fadeInLeft">
            
        </div>
    </form>

    <form id="ContenidoForm" style="display: none">
        <div class="panel panel-success" style="padding-bottom: 10px;">
            <div id="div_cabecera" class="CursoTitulo"></div>
            <div align="center">
                <img id="imageCurso" src="img/course/fundamentos.jpg" class="img-responsive">
            </div>
            <div class="panel-body" id="DivContenido">
            </div>
            <div class="box text-center" style="margin-top: 10px;">
                <input type= "hidden" name="txt_programacion_unica_id" id="txt_programacion_unica_id" class="form-control mant" >
                <input type= "hidden" name="txt_programacion_id" id="txt_programacion_id" class="form-control mant" >
                <div class="btn btn-warning btn-lg" onClick="VerCursos()">
                    <i class="fa fa-chevron-left fa-lg"></i>&nbsp;Regresar
                </div>
            </div>
        </div>
    </form><!-- .form -->

    <div id="div_contenido_respuesta" class="box box-body no-padding">
        <div class="panel panel-warnimg">
            <div class="panel-heading" style="background-color: #FFE699;color:black">
                <center>.::Desarrollo de la Tarea::.<b id="titulo_tarea_pro"></b></center>
            </div>
            <div class="col-md-4" style="margin-top: 40px;">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">AGREGAR RESPUESTA AQUÍ</div>
                    <div class="panel-body">
                        <form id="frmRepuestaAlum" name="frmRepuestaAlum" class="form-inline">
                            <input type= "hidden" name="txt_contenido_id" id="txt_contenido_id" class="form-control mant" >
                            <input type= "hidden" name="programacion_unica_id" id="programacion_unica_id" class="form-control mant" >
                            <div class="col-md-12">
                                <label class="sr-only" for="Respuesta">Respuesta</label>
                                <div class="input-group col-xs-12">
                                    <textarea class="form-control" id="txt_respuesta" name="txt_respuesta" placeholder="" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top:10px;">

                                <input type="text" style="" readonly="" class="col-xs-7 input-sm" id="txt_file_nombre" name="txt_file_nombre" value="">
                                <input type="text" style="display: none;" id="txt_file_archivo" name="txt_file_archivo">
                                <label class="col-xs-5 btn btn-default btn-flat  btn-xs" style="height: 30px; margin-top: 0px;">
                                    <i class="fa fa-file-image-o fa-lg"></i>Cargar Documento
                                    <input type="file" style="display: none;" onchange="onImagen(event);">
                                </label>
                            </div>

                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <button type="button" onClick="CancelarTarea();" class="col-xs-12 btn btn-default">Cancelar</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="btnGrabarRpta" name="btnGrabarRpta" class="col-xs-12 btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Enviar</button>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box-body table-responsive no-padding">
                    <table id="TableRespuestaAlu" class="table table-bordered table-hover">
                        <thead>
                            <tr class="cabecera">
                                <th>Fecha de Envio</th>
                                <th>Respuesta Enviada</th>
                                <th>Archivo</th>
                                <th>Comentario del Docente - Archivo</th>
                                <th>Mi Nota</th>
                                <th>[-]</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    </div>

</section><!-- .content -->
@stop

@section('form')
@include( 'proceso.alumno.gestor2.form.evaluacion' )
@stop

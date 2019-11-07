@extends('layout.master')  

@section('include')
@parent

{{ Html::style('lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}
{{ Html::script('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}
{{ Html::script('lib/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}

{{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}

@include( 'proceso.master.gestor.css.gestormaster' )
@include( 'proceso.master.gestor.js.gestormaster_ajax' )
@include( 'proceso.master.gestor.js.contenidomaster_ajax' )
@include( 'proceso.master.gestor.js.gestormaster' )
@include( 'proceso.master.gestor.js.contenidomaster' )

@stop

@section('content')
<section class="content-header">
    <h1>Gestor de Contenido
        <small>Proceso</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Mantenimiento</a></li>
        <li class="active">Gestor de Contenido</li>
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
            <div class="panel-footer col-md-12 text-center" style="margin-top: 10px;">
                <input type= "hidden" name="txt_programacion_unica_id" id="txt_programacion_unica_id" class="form-control mant" >
                <div class='btn btn-primary btn-lg' onClick="AgregarEditar3(1)" >
                    <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo
                </div>
                <div class="btn btn-warning btn-lg" onClick="VerCursos()">
                    <i class="fa fa-chevron-left fa-lg"></i>&nbsp;Regresar
                </div>
            </div>
        </div>
    </form><!-- .form -->

    <hr>
    <form id="ContenidoProgramacionForm" style="display: none">
        <input type= "hidden" name="txt_contenido_id" id="txt_contenido_id" class="form-control mant" >
        <div class="panel panel-warning">
            <div class="panel-heading" style="background-color: #FFE699;color:black">
                <center>.::Ampliación de Respuesta::.<b id="titulo_tarea_pro"></b></center>
            </div>
            <div class="panel-body table-responsive no-padding">
                <div class="col-md-12">
                    <table id="TableContenidoProgramacion" class="table table-bordered table-hover">
                        <thead>
                            <tr class="cabecera">
                                <th>Alumno</th>
                                <th>Fecha de Ampliación</th>
                                <th>[-]</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr class="cabecera">
                                <th>Alumno</th>
                                <th>Fecha de Ampliación</th>
                                <th>[-]</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class='btn btn-primary btn-sm' class="btn btn-primary" onClick="AgregarEditar2(1)" >
                        <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                    </div>
                </div><!-- .box-body -->
            </div>
        </div>
    </form><!-- .form -->
    <hr>
    <form id="ContenidoRespuestaForm" style="display: none">
        <input type= "hidden" name="txt_contenido_id" id="txt_contenido_id" class="form-control mant" >
        <input type= "hidden" name="txt_contenido_respuesta_id" id="txt_contenido_respuesta_id" class="form-control mant" >
        <input type= "hidden" name="txt_nota_cr" id="txt_nota_cr" class="form-control mant" >
        <div class="panel panel-warning">
            <div class="panel-heading" style="background-color: #FFE699;color:black">
                <center>.::Respuesta de Contenido::.<b id="titulo_tarea"></b></center>
            </div>
            <div class="panel-body table-responsive no-padding">
                <div class="col-md-12">
                    <table id="TableContenidoRespuesta" class="table table-bordered table-hover">
                        <thead>
                            <tr class="cabecera">
                                <th>Alumno</th>
                                <th>Respuesta</th>
                                <th>Archivo</th>
                                <th>Fecha</th>
                                <th>Nota</th>
                                <th>[]</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr class="cabecera">
                                <th>Alumno</th>
                                <th>Respuesta</th>
                                <th>Archivo</th>
                                <th>Fecha</th>
                                <th>Nota</th>
                                <th>[]</th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- .box-body -->
            </div>
        </div>
    </form><!-- .form -->
</section><!-- .content -->
@stop

@section('form')
    @include( 'proceso.master.gestor.form.contenido' )
@stop

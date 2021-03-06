@extends('layout.master')  

@section('include')
@parent
{{ Html::style('lib/datatables/dataTables.bootstrap.css') }}
{{ Html::script('lib/datatables/jquery.dataTables.min.js') }}
{{ Html::script('lib/datatables/dataTables.bootstrap.min.js') }}

{{ Html::style('lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}
{{ Html::script('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}
{{ Html::script('lib/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}

{{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}

{{ Html::style('lib/iCheck/all.css') }}
{{ Html::script('lib/iCheck/icheck.min.js') }}

@include( 'proceso.master.gestor.js.gestor_ajax' )
@include( 'proceso.master.gestor.js.gestor' )
@include( 'proceso.master.gestor.js.contenido_ajax' )
@include( 'proceso.master.gestor.js.contenido' )
@include( 'proceso.master.gestor.js.contenidoprogramacion_ajax' )
@include( 'proceso.master.gestor.js.contenidoprogramacion' )
@include( 'proceso.master.gestor.js.contenidorespuesta_ajax' )
@include( 'proceso.master.gestor.js.contenidorespuesta' )
@include( 'proceso.master.gestor.js.listapersona_ajax' )
@include( 'proceso.master.gestor.js.listapersona' )
@include( 'proceso.docente.gestor.js.copiacontenido' )
@include( 'proceso.docente.gestor.js.copiacontenido_ajax' )


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
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body  no-padding"> <!-- table-responsive-->
                    <form id="ProgramacionUnicaForm">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="background-color: #337ab7;color:#fff">
                                <center>.::Programación de Cursos::.</center>
                            </div>
                            <div class="panel-body table-responsive no-padding">
                                <div class="col-md-12">
                                    <table id="TableProgramacionUnica" class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="cabecera">
                                                <!--th class="col-xs-2">
                                                    <div class="form-group">
                                                        <label><h4>Especialidad:</h4></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="txt_carrera" id="txt_carrera" placeholder="Especialidad" onkeypress="return masterG.enterGlobal(event, '#txt_curso', 1);">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="col-xs-1">
                                                    <div class="form-group">
                                                        <label><h4>Semestre:</h4></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="txt_semestre" id="txt_semestre" placeholder="Semestre" onkeypress="return masterG.enterGlobal(event, '#txt_curso', 1);">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="col-xs-1">
                                                    <div class="form-group">
                                                        <label><h4>Ciclo:</h4></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="txt_ciclo" id="txt_ciclo" placeholder="Ciclo" onkeypress="return masterG.enterGlobal(event, '#txt_curso', 1);">
                                                        </div>
                                                    </div>
                                                </th-->
                                                <th class="col-xs-3">
                                                    <div class="form-group">
                                                        <label><h4>Curso:</h4></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="txt_curso" id="txt_curso" placeholder="Curso" onkeypress="return masterG.enterGlobal(event, '#txt_docente', 1);">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="col-xs-2">
                                                    <div class="form-group">
                                                        <label><h4>Docente:</h4></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="txt_docente" id="txt_docente" placeholder="Docente" onkeypress="return masterG.enterGlobal(event, '#txt_curso', 1);">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="col-xs-1">
                                                    <div class="form-group">
                                                        <label><h4>Fecha Inicio:</h4></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="txt_fecha_inicio" id="txt_fecha_inicio" placeholder="Fecha Inicio" onkeypress="return masterG.enterGlobal(event, '#txt_curso', 1);">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="col-xs-1">
                                                    <div class="form-group">
                                                        <label><h4>Fecha Final:</h4></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="txt_fecha_final" id="txt_fecha_final" placeholder="Fecha Final" onkeypress="return masterG.enterGlobal(event, '#txt_curso', 1);">
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr class="cabecera">
                                                <!--th>Especialidad</th>
                                                <th>Semestre</th>
                                                <th>Ciclo</th-->
                                                <th>Curso</th>
                                                <th>Docente</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Final</th>
                                                <!--th>[Exportar Notas]</th>
                                                <th>[Plantilla]</th>
                                                <th>[Replicar]</th-->
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- .box-body -->
                            </div>
                        </div>
                    </form><!-- .form -->

                    <hr>

                    <form id="ContenidoForm" style="display: none">
                        <div class="panel panel-success" style="padding-bottom: 10px;">
                            <div class="progress active" style="height: auto !important;">
                                <div class="progress-bar progress-bar-aqua progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; font-size:30px; line-height:20pt;">
                                  <div id="div_cabecera" style="margin: 10px 10px;"></div>
                                </div>
                            </div>
                            <div align="center">
                                <img id="imageCurso" src="img/course/fundamentos.jpg" style="width: 600px;height: 200px;margin-top: 5px;padding: 8px">
                            </div>
                            <div class="panel-body table-responsive no-padding">
                                <div class="col-md-12">
                                    <input type= "hidden" name="txt_programacion_unica_id" id="txt_programacion_unica_id" class="form-control mant" >
                                    <div class="box box-solid">
                                        <div class="box-body">
                                            <div class="box-group" id="DivContenido">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center" style="margin-top: 10px;">
                                    <div class='btn btn-primary btn-lg'onClick="AgregarEditar3(1)" >
                                        <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo
                                    </div>
                                </div>
                            </div><!-- .box-body -->
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
                </div><!-- .box -->
            </div>
        </div>
    </div><!-- .col -->
</div><!-- .row -->
</section><!-- .content -->
@stop

@section('form')
@include( 'proceso.docente.gestor.form.copiacontenido' )
@include( 'proceso.master.gestor.form.contenido' )
@include( 'proceso.master.gestor.form.contenidoprogramacion' )
@include( 'proceso.master.gestor.form.listapersona' )
@stop

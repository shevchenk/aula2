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

    @include( 'proceso.alumno.mievaluacion.js.mievaluacion_ajax' )
    @include( 'proceso.alumno.mievaluacion.js.mievaluacion' )

    @include( 'proceso.alumno.mievaluacion.js.tipoevaluacion_ajax' )
    @include( 'proceso.alumno.mievaluacion.js.tipoevaluacion' )

@stop

@section('content')
<section class="content-header">
    <h1>Mis evaluaciones
        <small>Alumnos</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Mis evaluaciones</a></li>
        <li class="active">Alumnos</li>
    </ol>
</section>

<style>
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}

.UnidadContenido{
  width: 100%;
  font-size: 15px;
  background: #8F969D42;
  color: #3A3A3A;
  text-align: center;
  min-height: 50px;
  line-height: 50px;
  margin: 10px 10px;
}
</style>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="overflow: hidden;">
                <form id="TipoEvaluacionForm">
                  <div class="panel panel-primary">
                    <div class="panel-heading" style="background-color: #337ab7;color:#fff">
                        <center>.::Evaluaciones de Alumnos::.</center>
                    </div>

                        <div class="box-body table-responsive no-padding">
                          <div class="col-md-12">
                          <table id="TableEvaluacion" class="table table-bordered table-hover">
                              <thead>
                                  <tr class="cabecera">
                                  <input type="hidden" name="txt_estado" class="mant" value="1">
                                      <th class="col-xs-2">
                                          <div class="form-group">
                                              <label><h4>Curso</h4></label>
                                              <div class="input-group">
                                                  <input type="text" class="form-control" name="txt_curso" id="txt_curso" placeholder="Curso" onkeypress="return masterG.enterGlobal(event,'#txt_docente',1);">
                                              </div>
                                          </div>
                                      </th>
                                      <th class="col-xs-2">
                                          <div class="form-group">
                                              <label><h4>Docente</h4></label>
                                              <div class="input-group">
                                                  <input type="text" class="form-control" name="txt_docente" id="txt_docente" placeholder="Docente" onkeypress="return masterG.enterGlobal(event,'#txt_curso',1);">
                                              </div>
                                          </div>
                                      </th>
                                      <!--th class="col-xs-1">
                                          <div class="form-group">
                                              <label><h4>Fecha Examen</h4></label>
                                          </div>
                                      </th>
                                      <th class="col-xs-1">
                                          <div class="form-group">
                                              <label><h4>Nota</h4></label>
                                          </div>
                                      </th>
                                      <th class="col-xs-1">[-]</th-->
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                  <tr class="cabecera">
                                    <th>Curso</th>
                                    <th>Docente</th>
                                    <!--th>Fecha Examen</th>
                                    <th>Nota</th>
                                    <th>[-]</th-->
                                  </tr>
                              </tfoot>
                          </table>
                          </div>
                        </div><!-- .box-body -->
                  </div>
                </form><!-- .form -->

                <hr>
                <form id="EvaluacionForm" style="display: none">

                  <div class="panel panel-primary active" style="padding-bottom: 10px;">
                      <div class="UnidadContenido">
                        <span id="div_cabecera"></span>
                        <span id="span_color" class="col-md-2 list-group-item-success" style="font-weight: bold;float: none">
                                Nota Final a la fecha:
                                <span id="span_nota" class="badge" style="font:20px;">0</span>
                                <span id="span_resultado"></span>
                                <input type="hidden" id="txt_nota_minima" class="mant" value="0">
                        </span>
                        <span id="span_btn">
                        </span>
                      </div>
                          
                      <div class="panel-body table-responsive">
                          <input type= "hidden" name="txt_estado_cambio" id="txt_estado_cambio" class="form-control mant" value="0,1">  
                        <input type= "hidden" name="txt_programacion_id" id="txt_programacion_id" class="form-control mant">
                        <input type= "hidden" name="txt_programacion_unica_id" id="txt_programacion_unica_id" class="form-control mant">
                        <input type= "hidden" name="txt_valida_evaluacion" id="txt_valida_evaluacion" class="form-control mant">
                        <input type="hidden" id="txt_curso" name="txt_curso" class="form-controlmant">
                        <style media="screen">
                        .rotar:hover{
                              cursor: pointer;
                              transform: rotate(-5deg);
                              -webkit-transform: rotate(-5deg);
                              -moz-transform: rotate(-5deg);
                              -o-transform: rotate(-5deg);
                        }
                        </style>

                        <div id="DivContenido" class="box-body table-responsive no-padding">
                          <div class="col-md-12">
                          </div>
                        </div>

                      </div><!-- .box-body -->
                  </div>

                </form><!-- .form -->


                <form id="ResultEvaluacion" style="display: none">
                  <input type= "hidden" name="txt_programacion_id" id="txt_programacion_id" class="form-control mant">
                  <input type= "hidden" name="txt_programacion_unica_id" id="txt_programacion_unica_id" class="form-control mant">
                  <input type="hidden" id="txt_tipo_evaluacion_id" name="txt_tipo_evaluacion_id" class="form-controlmant">

                  <input type="hidden" id="txt_tipo_evaluacion" name="txt_tipo_evaluacion" class="form-controlmant">
                  <input type="hidden" id="txt_curso" name="txt_curso" class="form-controlmant">

                  <div class="col-md-12">
                    <div class="col-md-2"></div>

                    <div class="col-md-8" id="resultado">
                    </div>

                    <div class="col-md-2"></div>
                  </div>
                </form><!-- .form -->

                <form id="ResultFinalEvaluacion" style="display: none">
                  <input type= "hidden" name="txt_programacion_id" id="txt_programacion_id" class="form-control mant">
                  <input type="hidden" id="txt_evaluacion_id" name="txt_evaluacion_id" class="form-controlmant">

                  <input type="hidden" id="txt_tipo_evaluacion" name="txt_tipo_evaluacion" class="form-controlmant">
                  <input type="hidden" id="txt_curso" name="txt_curso" class="form-controlmant">

                  <div class="col-md-12">
                    <div class="col-md-2"></div>

                    <div class="col-md-8" id="resultado_final">
                    </div>

                    <div class="col-md-2"></div>
                  </div>
                </form><!-- .form -->

            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->
@stop

@section('form')
     @include( 'proceso.alumno.gestor.form.contenido' )
@stop

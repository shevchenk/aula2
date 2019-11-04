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
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c189.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">GESTIÓN DE RECURSOS HUMANOS</h3>
                    <p>Fecha de Inicio: 2019-10-01</p>
                </a>
            </div>
        </div>
        <div style="display: none;" class="row animate-box" data-animate-effect="fadeInLeft">
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c189.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">GESTIÓN DE RECURSOS HUMANOS</h3>
                    <p>Fecha de Inicio: 2019-10-01</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c191.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">LEGISLACIÓN LABORAL</h3>
                    <p>Fecha de Inicio: 2019-10-05</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c192.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">CONTABILIDAD DE COSTOS</h3>
                    <p>Fecha de Inicio: 2019-10-10</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c195.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">CÓDIGO TRIBUTARIO</h3>
                    <p>Fecha de Inicio: 2019-10-15</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c196.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">CÓDIGO TRIBUTARIO</h3>
                    <p>Fecha de Inicio: 2019-10-25</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c189.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">GESTIÓN DE RECURSOS HUMANOS</h3>
                    <p>Fecha de Inicio: 2019-10-31</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c191.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">LEGISLACIÓN LABORAL</h3>
                    <p>Fecha de Inicio: 2019-11-11</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c196.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">CÓDIGO TRIBUTARIO</h3>
                    <p>Fecha de Inicio: 2019-11-19</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">
                <a href="work.html">
                    <img src="img/course/c192.png" alt="Free HTML5 Website Template by FreeHTML5.co" class="img-responsive">
                    <h3 class="fh5co-work-title">CONTABILIDAD DE COSTOS</h3>
                    <p>Fecha de Inicio: 2019-11-25</p>
                </a>
            </div>
        </div>
    </form>

    <form id="ContenidoForm" style="display: none">
        <div class="panel panel-success" style="padding-bottom: 10px;">
            <div class="progress active" style="height: auto !important;">
                <div class="progress-bar progress-bar-aqua progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; font-size:30px; line-height:20pt;">
                  <div id="div_cabecera" style="margin: 10px 10px;"></div>
                </div>
            </div>
            <div align="center">
                <img id="imageCurso" src="img/course/fundamentos.jpg" class="img-responsive">
            </div>
            
                <div class="panel-body">
                    <div class="panel box box-primary"> 
                        <div class="box-header with-border collapsed" data-toggle="collapse" data-parent="#DivPadre" href="#collapse1" width="100%"> 
                            <div class="progress active" style="height: auto !important; width: 90%; margin-inline: auto;"> 
                                <div class="progress-bar progress-bar-default progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; font-size:24px; line-height:20pt;"> 
                                  <div style="margin: 10px 10px;"> Tema1: Que es Modernización de la Gestión Pública</div> 
                                </div> 
                            </div> 
                        </div> 
                        <div id="collapse1" class="panel-collapse collapse"> 
                            <div class="box-body">
                                <div class="col-lg-4 col-md-6 CabContenidoG CabContenido" id="trid_247">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bg-blue formatotitulo">
                                                <div class="btn-group">
                                                    <span>Apoyo interno1 : Inicios del cambio climático en el distrito de Lima y Callao, efectos secundarios.</span>
                                                    <button type="button" class="btn bg-navy btn-flat btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Links de Apoyo
                                                        <i class="caret"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Nro 1
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Nro 2
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                            <i class="fa fa-book fa-lg"></i> Link Probando yo ando</a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link yo pruebo ahora
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link yo pruebo ahora
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link yo pruebo ahora
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link yo pruebo ahora
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link yo pruebo ahora
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link yo pruebo ahora
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link yo pruebo ahora
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <img src="img/course/c218.png" alt="" style="max-width: 60%;">
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="text-justify formatotexto">
                                                Apoyo Interno, indica que la información es realizada por las institución y ayudará al alumno en su formación continua para seguir creciendo profesional y personalmente. Estamos para servirles
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CambiarEstado3(0,247)" class="col-xs-12 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <span class="fa fa-trash fa-lg"></span> Eliminar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="AgregarEditar3(0,247)" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="fa fa-edit fa-lg"></span> Editar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6"></div>
                                        <div class="col-lg-3 col-md-6"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 CabContenidoG CabContenido" id="trid_247">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bg-red formatotitulo">
                                                <div class="btn-group">
                                                    <span>Tarea para la casa2</span>
                                                    <button type="button" class="btn bg-navy btn-flat btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Links de Apoyo
                                                        <i class="caret"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Nro 1
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Nro 2
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Probando yo ando
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <img src="img/course/c217.png" alt="" style="max-width: 60%;">
                                        </div>
                                        <div class="col-md-6 col-sm-6" style="border-right: 2px solid #e9e9e9;">
                                            <div class="text-justify formatotexto">
                                                Apoyo Interno, indica que la información es realizada por las institución y ayudará al alumno en su formación continua para seguir creciendo profesional y personalmente. Estamos para servirles
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="text-justify formatotexto">
                                                <ul>
                                                    <li>Fecha Ini. : 2019-11-01</li>
                                                    <li>Fecha Fin. : 2019-11-05<br>
                                                    <li>Fecha Amp. : 2019-11-05<br>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CambiarEstado3(0,247)" class="col-xs-12 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <span class="fa fa-trash fa-lg"></span> Eliminar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="AgregarEditar3(0,247)" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="fa fa-edit fa-lg"></span> Editar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CargarContenidoProgramacion(248,33,'Tema1: Hola Mundo xd','Tarea','2019-11-01','2019-11-05','2019-11-05')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ampliación de Respuesta">
                                                <span class="fa fa-list fa-lg"></span>Ampl.
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CargarContenidoRespuesta(248,'Tema1: Hola Mundo xd','Tarea','2019-11-01','2019-11-05','2019-11-05')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Respuesta de Contenido">
                                                <span class="fa fa-list fa-lg"></span>Resp.
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 CabContenidoG CabContenido" id="trid_247">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bg-red formatotitulo">
                                                <span>Tarea para la casa3</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <img src="img/course/c217.png" alt="" style="max-width: 60%;">
                                        </div>
                                        <div class="col-md-6 col-sm-6" style="border-right: 2px solid #e9e9e9;">
                                            <div class="text-justify formatotexto">
                                                Apoyo Interno, indica que la información es realizada por las institución y ayudará al alumno en su formación continua para seguir creciendo profesional y personalmente. Estamos para servirles
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="text-justify formatotexto">
                                                <ul>
                                                    <li>Fecha Ini. : 2019-11-01</li>
                                                    <li>Fecha Fin. : 2019-11-05</li>
                                                    <li>Fecha Amp. : 2019-11-05</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CambiarEstado3(0,247)" class="col-xs-12 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <span class="fa fa-trash fa-lg"></span> Eliminar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="AgregarEditar3(0,247)" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="fa fa-edit fa-lg"></span> Editar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CargarContenidoProgramacion(248,33,'Tema1: Hola Mundo xd','Tarea','2019-11-01','2019-11-05','2019-11-05')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ampliación de Respuesta">
                                                <span class="fa fa-list fa-lg"></span>Ampl.
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CargarContenidoRespuesta(248,'Tema1: Hola Mundo xd','Tarea','2019-11-01','2019-11-05','2019-11-05')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Respuesta de Contenido">
                                                <span class="fa fa-list fa-lg"></span>Resp.
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 CabContenidoG CabContenido" id="trid_247">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bg-blue formatotitulo">
                                                <div class="btn-group">
                                                    <span>Apoyo interno4</span>
                                                    <button type="button" class="btn bg-navy btn-flat btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Links de Apoyo
                                                        <i class="caret"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Nro 1
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Nro 2
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Probando yo ando
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Probando yo ando
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.youtube.com/watch?v=-wgz-PgW8B4&amp;list=RDGMEM2VCIgaiSqOfVzBAjPJm-agVM-wgz-PgW8B4&amp;start_radio=1" target="_blank">
                                                                <i class="fa fa-book fa-lg"></i> Link Probando yo ando
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <img src="img/course/c220.png" alt="" style="max-width: 60%;">
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="text-justify formatotexto">
                                                Apoyo Interno, indica que la información es realizada por las institución y ayudará al alumno en su formación continua para seguir creciendo profesional y personalmente. Estamos para servirles
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CambiarEstado3(0,247)" class="col-xs-12 btn btn-danger" data-placement="top" title="Eliminar">
                                                <span class="fa fa-trash fa-lg"></span> Eliminar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="AgregarEditar3(0,247)" style="" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="fa fa-edit fa-lg"></span> Editar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 CabContenidoG CabContenido" id="trid_247">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bg-blue formatotitulo">
                                                <span>Apoyo interno5</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <img src="img/course/c220.png" alt="" style="max-width: 60%;">
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="text-justify formatotexto">
                                                Apoyo Interno, indica que la información es realizada por las institución y ayudará al alumno en su formación continua para seguir creciendo profesional y personalmente. Estamos para servirles
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CambiarEstado3(0,247)" class="col-xs-12 btn btn-danger" data-placement="top" title="Eliminar">
                                                <span class="fa fa-trash fa-lg"></span> Eliminar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="AgregarEditar3(0,247)" style="" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="fa fa-edit fa-lg"></span> Editar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 CabContenidoG CabContenido" id="trid_247">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bg-blue formatotitulo">
                                                <span>Apoyo interno6</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <img src="img/course/c220.png" alt="" style="max-width: 60%;">
                                        </div>
                                        <div class="col-md-6 col-sm-6" style="border-right: 2px solid #e9e9e9;">
                                            <div class="text-justify formatotexto">
                                                Apoyo Interno, indica que la información es realizada por las institución y ayudará al alumno en su formación continua para seguir creciendo profesional y personalmente. Estamos para servirles
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="text-justify formatotexto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="CambiarEstado3(0,247)" class="col-xs-12 btn btn-danger" data-placement="top" title="Eliminar">
                                                <span class="fa fa-trash fa-lg"></span> Eliminar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <button type="button" onclick="AgregarEditar3(0,247)" style="" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="fa fa-edit fa-lg"></span> Editar
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="box-header with-border collapsed" data-toggle="collapse" data-parent="#DivPadre" href="#collapse2" width="100%"> 
                            <div class="progress active" style="height: auto !important; width: 90%; margin-inline: auto;"> 
                                <div class="progress-bar progress-bar-default progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; font-size:24px; line-height:20pt;"> 
                                  <div style="margin: 10px 10px;"> Tema2: Como Implementar Gestión por Procesos</div> 
                                </div> 
                            </div> 
                        </div> 
                        <div id="collapse2" class="panel-collapse collapse"> 
                            <div class="box-body">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type= "hidden" name="txt_programacion_unica_id" id="txt_programacion_unica_id" class="form-control mant" >
                        <div class="box-group" id="DivContenido">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center" style="margin-top: 10px;">
                    <div class='btn btn-primary btn-lg' onClick="AgregarEditar3(1)" >
                        <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo
                    </div>
                    <div class="btn btn-warning btn-lg" onClick="VerCursos()">
                        <i class="fa fa-chevron-left fa-lg"></i>&nbsp;Regresar
                    </div>
                </div>
            
        </div>

    </form><!-- .form -->
</section><!-- .content -->
@stop

@section('form')
    @include( 'proceso.master.gestor.form.contenido' )
@stop

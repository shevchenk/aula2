<div class="modal" id="ModalContenido" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Contenido</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="ModalContenidoForm">
                        <input type="hidden" class="form-control mant" id="txt_programacion_unica_id" name="txt_programacion_unica_id" readonly="">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="label_curso">Curso</label>
                                <input  type="hidden" class="form-control mant"  id="txt_curso_id" name="txt_curso_id" readonly="">
                                <textarea class="form-control mant" id="txt_curso" name="txt_curso" disabled="" rows="1"></textarea>
                            </div> 
                        </div>
                        <div class="col-sm-12">  
                            <div class="form-group">
                                <label>Unidad de Contenido</label>
                                <select class="form-control selectpicker show-menu-arrow" data-live-search="true" name="slct_unidad_contenido_id" id="slct_unidad_contenido_id">
                                    <option value>.::Seleccione::.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="form-group">
                                <label>Titulo de Contenido</label>
                                <textarea type="text" rows='4'  class="form-control" id="txt_titulo_contenido" name="txt_titulo_contenido"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-12">
                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea type="text" rows='4'  class="form-control" id="txt_contenido" name="txt_contenido"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tipo de Recurso</label>
                                <select class="form-control selectpicker"  data-actions-box='true' name="slct_tipo_respuesta" id="slct_tipo_respuesta">
                                    <option value>.::Seleccione::.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <img class="img-circle_cabecera" id="txt_foto_imagen" style="height: 142px;width: 100%;border-radius: 8px;border: 1px solid grey;margin-top: 5px;padding: 8px"> 
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label style="color:red;">
                                            <input type="checkbox" class="checkbox" id="chk_archivo2" name="chk_archivo2">
                                            *Archivo no ogligatorio
                                        </label>
                                    </div>
                                    <label>Foto del Contenido (900*600)</label>
                                    <input type="text" readonly="" class="form-control input-sm" id="txt_foto_nombre" name="txt_foto_nombre" value="">
                                    <input type="text" style="display: none;" id="txt_foto_archivo" name="txt_foto_archivo">
                                    <label class="btn btn-default btn-flat margin btn-xs">
                                        <i class="fa fa-file-pdf-o fa-lg"></i>
                                        <i class="fa fa-file-word-o fa-lg"></i>
                                        <i class="fa fa-file-image-o fa-lg"></i>
                                        <input type="file" style="display: none;" onchange="masterG.onImagen(event,'#txt_foto_nombre','#txt_foto_archivo','#txt_foto_imagen');">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <img class="img-circle_cabecera" id="txt_file_imagen" style="height: 142px;width: 100%;border-radius: 8px;border: 1px solid grey;margin-top: 5px;padding: 8px"> 
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label style="color:red;">
                                            <input type="checkbox" class="checkbox" id="chk_archivo" name="chk_archivo">
                                            *Archivo no ogligatorio
                                        </label>
                                    </div>
                                    <label>Archivo del Contenido</label>
                                    <input type="text" readonly="" class="form-control input-sm" id="txt_file_nombre" name="txt_file_nombre" value="">
                                    <input type="text" style="display: none;" id="txt_file_archivo" name="txt_file_archivo">
                                    <label class="btn btn-default btn-flat margin btn-xs">
                                        <i class="fa fa-file-pdf-o fa-lg"></i>
                                        <i class="fa fa-file-word-o fa-lg"></i>
                                        <i class="fa fa-file-image-o fa-lg"></i>
                                        <input type="file" style="display: none;" onchange="masterG.onImagen(event,'#txt_file_nombre','#txt_file_archivo','#txt_file_imagen');">
                                    </label>
                                </div>
                            </div>
                            <divl class="col-lg-12 col-md-12">
                                <label>Link del Contenido</label>
                                <textarea class="form-control" id="txt_video" name="txt_video"></textarea>
                            </divl>
                        </div>
                        <div id="respuesta">
                            <div class="col-md-12">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title anotacion">Different Width</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Fecha de Inicio</label>
                                                    <input type="text" class="form-control fecha" id="txt_fecha_inicio" name="txt_fecha_inicio" readonly="" >
                                                </div>
                                            </div>
                                            <div id="video" style="display:none">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Hora Inicio</label>
                                                        <input type="text" class="form-control hora" id="txt_hora_inicio" name="txt_hora_inicio" readonly="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Hora Final</label>
                                                        <input type="text" class="form-control hora" id="txt_hora_final" name="txt_hora_final" readonly="" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tarea" style="display:none">
                                                <div class="col-md-4">
                                                    <div class="form-group respuesta">
                                                        <label>Fecha Final</label>
                                                        <input type="text" class="form-control fecha" id="txt_fecha_final" name="txt_fecha_final" readonly="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha Ampliada</label>
                                                        <input type="text" class="form-control fecha" id="txt_fecha_ampliada" name="txt_fecha_ampliada" readonly="" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="profesor_tarea" style="display:none">
                                <div class="col-md-12">
                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <h3 class="box-title profesor">Different Width</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha de Inicio</label>
                                                        <input type="text" class="form-control fecha" id="txt_fecha_inicio_d" name="txt_fecha_inicio_d" readonly="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha Final</label>
                                                        <input type="text" class="form-control fecha" id="txt_fecha_final_d" name="txt_fecha_final_d" readonly="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha Ampliada</label>
                                                        <input type="text" class="form-control fecha" id="txt_fecha_ampliada_d" name="txt_fecha_ampliada_d" readonly="" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Referencia
                                    <a class='btn btn-success btn-xs' onclick="AgregarReferencia()">
                                        <i class="fa fa-plus fa-xs"></i>
                                    </a>
                                </label>
                                <div id="referencia">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: none;">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control selectpicker show-menu-arrow" name="slct_estado" id="slct_estado">
                                    <option  value='0'>Inactivo</option>
                                    <option  value='1'>Activo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- FIN DE MODAL BODY -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default active pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


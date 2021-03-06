<div class="modal" id="ModalCurso" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Curso</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <form id="ModalCursoForm">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Curso</label>
                            <textarea class="form-control" id="txt_curso" name="txt_curso" disabled=""></textarea>
                            <input type="hidden" class="mant" id="txt_id" name="txt_id">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-8 col-sm-8">
                            <div class="form-group">
                                <label>Imagen</label>
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
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <img class="img-circle_cabecera" id="txt_file_imagen" style="height: 142px;width: 100%;border-radius: 8px;border: 1px solid grey;margin-top: 5px;padding: 8px"> 
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-8 col-sm-8">
                            <div class="form-group">
                                <label>Imagen 2 de Ventas</label>
                                <input type="text" readonly="" class="form-control input-sm" id="txt_file_nombre2" name="txt_file_nombre2" value="">
                                <input type="text" style="display: none;" id="txt_file_archivo2" name="txt_file_archivo2">
                                <label class="btn btn-default btn-flat margin btn-xs">
                                    <i class="fa fa-file-pdf-o fa-lg"></i>
                                    <i class="fa fa-file-word-o fa-lg"></i>
                                    <i class="fa fa-file-image-o fa-lg"></i>
                                    <input type="file" style="display: none;" onchange="masterG.onImagen(event,'#txt_file_nombre2','#txt_file_archivo2','#txt_file_imagen2');">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <img class="img-circle_cabecera" id="txt_file_imagen2" style="height: 142px;width: 100%;border-radius: 8px;border: 1px solid grey;margin-top: 5px;padding: 8px"> 
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <label>Link del Brochure:</label>
                            <textarea id="txt_link" name="txt_link" class="form-control" placeholder="Ingrese Link del Brochure"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <label>Nro de WhatsApp de ventas:</label>
                            <input id="txt_whatsapp" name="txt_whatsapp" class="form-control" placeholder="Ingrese el nro de WhatsApp">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br><br>
                        <table class="table table-bordered table-hover">
                            <thead class="bg-info">
                                <tr>
                                    <th style="text-align: center;">Seleccione la forma de la evaluación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>
                                    <select name="slct_valida_evaluacion" id="slct_valida_evaluacion" class="form-control">
                                        <option value="1">
                                        Rendir las evaluaciones sin orden determinado
                                        </option>
                                        <option value="2">
                                        Rendir las evaluaciones según el orden y que haya aprobado la evaluación anterior
                                        </option>
                                        <option value="3">
                                        Rendir las evaluaciones según el orden sin importar la nota de la evaluación anterior
                                        </option>
                                    </select>
                                </td></tr>
                                <tr><td>
                                    <label>Nro días posterior a la inscripción del alumno para realizar sus evaluaciones:</label>
                                    <input id="txt_dias" name="txt_dias" class="form-control" placeholder="Nro de Días">
                                </td></tr>
                                <tr><td>
                                    <label>Nro de intentos a evaluar por día (0 = Ilimitado):</label>
                                    <input id="txt_intentos" name="txt_intentos" class="form-control" placeholder="Nro de Intentos">
                                </td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <br><br>
                        <table class="table table-bordered table-hover">
                            <thead class="bg-info">
                                <tr>
                                    <th style="text-align: center;">Unidad de Contenido</th>
                                    <th style="text-align: center;">Tipo de Evaluación<select id="slct_tipo_evaluacion" style="display: none;"></select></th>
                                    <th style="text-align: center;"><a class="btn btn-sm btn-success" onClick="AgregarUC();"><i class="fa fa-plus fa-lg"></i></a></th>
                                </tr>
                            </thead>
                            <tbody id='tb_te'>
                            </tbody>
                        </table>
                    </div>
                </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default active pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

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
                        <br><br>
                        <table class="table table-bordered table-hover">
                            <thead class="bg-info">
                                <tr>
                                    <th style="text-align: center;">Unidad de Contenido</th>
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

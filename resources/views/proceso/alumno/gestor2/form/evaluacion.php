<div class="modal" id="ModalEvaluacion" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Contenido</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Curso</label>
                        <input class="form-control" disabled id="txt_curso" type="text" value="">
                    </div>
                    <div class="col-md-12">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <table id="misevaluaciones" class="table table-hover table-bordered">
                            <thead>
                                <tr class="bg-info">
                                    <th>Tipo Evaluación</th>
                                    <th>Nota</th>
                                    <th>Fecha Evaluación</th>
                                    <th>Nota Final</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- FIN DE MODAL BODY -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default active pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="btnsolicitar" class="btn btn-primary">Solicitar Certificado</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" id="ModalAprobados" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header btn-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Listado de alumno aprobados</h4>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="box">
                        <form id="ModalAprobadosForm">
                            <div class="panel panel-success" style="padding-bottom: 10px;">
                                <div class="panel-body table-responsive no-padding">
                                    <div class="col-md-12">
                                        <input type= "hidden" name="txt_programacion_unica_id" id="txt_programacion_unica_id" class="form-control mant" >
                                        <table class="table table-bordered">
                                            <thead style="background-color: #A9D08E;color:black">
                                            <tr>
                                                <th>#</th>
                                                <th>DNI</th>
                                                <th>Paterno</th>
                                                <th>Materno</th>
                                                <th>Nombre</th>
                                                <th>Nota Final</th>
                                                <th>[<input type="checkbox" name="chk_all" onchange="ChkAll(this);">]</th>
                                            </tr>
                                            </thead>
                                            <tbody id="DivAprobados">
                                            </tbody>
                                        </table>
                                    </div><!-- .box-body -->
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default active pull-left" data-dismiss="modal">Close</button>
                <button type="button" onClick="EnviarMasivo();" class="btn btn-primary"><i class="fa fa-file-pdf-o fa-lg"></i>.::Exportar Seleccionados::.</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

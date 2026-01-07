<div id="editar-objetivos-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Sección de Objetivos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="col-12 col-lg-12 mg-sm-b-10">
                            <div class="input-group custom-input-group">
                                <input type="hidden" id="idTit">

                                <input type="text" id="text-editar" name="text-editar" class="form-control custom-input" placeholder="Escriba un sección">
                                <button onclick="insertarEditar()" id="" class="btn custom-btn">Editar Sección</button>
                            </div>


                        </div><!-- input-group -->

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>

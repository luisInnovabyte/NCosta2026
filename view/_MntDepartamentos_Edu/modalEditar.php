<div id="editar-departamento-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Editar Departamento</h5>
                        <form id="editar-tipoCurso" method="POST">
                            <input type="hidden" name="id-departamento" id="id-departamento" value="">
                            <div class="row g-3">

                                <div class="col-12 col-lg-12">
                                    <label for="nombreTipo" class="form-label">Nombre</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nomDepartamentoE" name="nomDepartamentoE" placeholder="Nombre" data-type="3" data-min="1" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="editarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div id="editar-accionescontado-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Concepto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hiddenid">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Editando <label id="editando"></label></h5>
                        <div class="row g-3 d-flex justify-content-center tx-center">
                            <div class="col-12 col-lg-6">
                                <label for="nombreTrabajadorE" class="form-label">Seleccionar usuario</label>
                                <select class="form-select bg-light-grey" id="nombreTrabajadorE" data-placeholder="Elige un usuario" multiple>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="profesionTrabajadorE" class="form-label">Seleccionar profesiones</label>
                                <select class="form-select bg-light-grey" id="profesionTrabajadorE" data-placeholder="Elige una profesion" multiple>
                                    <option></option>
                                </select>
                            </div>

                        </div>
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
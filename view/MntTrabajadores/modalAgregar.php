<div id="agregar-trabajador-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Trabajador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Nueva trabajador</h5>
                        <div class="row g-3 d-flex justify-content-center tx-center">
                            <div class="col-12 col-lg-6">
                                <label for="nombreTrabajador" class="form-label">Seleccionar usuario</label>
                                <select class="form-select bg-light-grey" id="nombreTrabajador" data-placeholder="Elige un usuario" multiple>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="profesionTrabajador" class="form-label">Seleccionar profesiones</label>
                                <select class="form-select bg-light-grey" id="profesionTrabajador" data-placeholder="Elige una profesion" multiple>
                                    <option></option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
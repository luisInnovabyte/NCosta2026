<div id="agregar-departamentos-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary bg-gradient text-white py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Nuevo Departamento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="insertarDepartamento" method="POST">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="nombreDepartamento" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-building me-1"></i> Nombre Departamento <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-building text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nombreDepartamento" name="nombreDepartamento" placeholder="Nombre del departamento" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="prefijofactura" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-receipt me-1"></i> Prefijo Factura <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-receipt text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijofactura" name="prefijofactura" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfactura" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Factura <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfactura" name="nfactura" placeholder="Nº siguiente en factura" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="prefijofacturapro" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-file-earmark-text me-1"></i> Prefijo Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-file-earmark-text text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijofacturapro" name="prefijofacturapro" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfacturapro" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfacturapro" name="nfacturapro" placeholder="Nº siguiente en proforma" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="prefijoabono" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-arrow-return-left me-1"></i> Prefijo Abono <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-arrow-return-left text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijoabono" name="prefijoabono" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfacturaNeg" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Abono <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfacturaNeg" name="nfacturaNeg" placeholder="Nº siguiente en abono" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <label for="prefijoabonoProf" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-file-earmark-minus me-1"></i> Prefijo Abono Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-file-earmark-minus text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijoabonoProf" name="prefijoabonoProf" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfacturaprofDep" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Abono Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfacturaprofDep" name="nfacturaprofDep" placeholder="Nº siguiente en abono proforma" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>

                        <!-- Selector de color -->
                        <div class="col-12 col-lg-6">
                            <label for="colorDepartamento" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-palette-fill me-1"></i> Color del Departamento
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-palette-fill text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="colorDepartamento" name="colorDepartamento" value="#222222" placeholder="Selecciona un color" readonly>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary px-4" title="Guardar" onClick="agregarElementoDepartamentos()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

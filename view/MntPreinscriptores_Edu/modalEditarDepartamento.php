<div id="editar-departamento-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning bg-gradient text-dark py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Editar Departamento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="insertarDepartamentoE" method="POST">
                    <input type="hidden" name="id-departamento" id="id-departamento" value="">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="nombreDepartamentoE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-building me-1"></i> Nombre Departamento <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-building text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nombreDepartamentoE" name="nombreDepartamentoE" placeholder="Nombre del departamento" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="prefijofacturaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-receipt me-1"></i> Prefijo Factura <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-receipt text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijofacturaE" name="prefijofacturaE" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfacturaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Factura <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfacturaE" name="nfacturaE" placeholder="Nº siguiente en factura" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="prefijofacturaproE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-file-earmark-text me-1"></i> Prefijo Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-file-earmark-text text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijofacturaproE" name="prefijofacturaproE" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfacturaproE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfacturaproE" name="nfacturaproE" placeholder="Nº siguiente en proforma" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="prefijoabonoE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-arrow-return-left me-1"></i> Prefijo Abono <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-arrow-return-left text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijoabonoE" name="prefijoabonoE" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfacturaNegE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Abono <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfacturaNegE" name="nfacturaNegE" placeholder="Nº siguiente en abono" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <label for="prefijoabonoProfE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-file-earmark-minus me-1"></i> Prefijo Abono Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-file-earmark-minus text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="prefijoabonoProfE" name="prefijoabonoProfE" placeholder="PRE" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <label for="nfacturaprofDepE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> Nº Abono Proforma <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nfacturaprofDepE" name="nfacturaprofDepE" placeholder="Nº siguiente en abono proforma" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                                
                        <!-- Selector de color -->
                        <div class="col-12 col-lg-6">
                            <label for="colorDepartamentoE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-palette-fill me-1"></i> Color del Departamento
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-palette-fill text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="colorDepartamentoE" name="colorDepartamentoE" value="#222222" placeholder="Selecciona un color" readonly>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning px-4" title="Guardar Cambios" onClick="editarElementoDepartamento()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

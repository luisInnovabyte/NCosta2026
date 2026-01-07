<div id="agregar-iva-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary bg-gradient text-white py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Nuevo IVA
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="agregar-iva-form" method="POST">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="valorIva" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-percent me-1"></i> Valor IVA <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-percent text-primary"></i></span>
                                <input type="number" class="form-control border-start-0 ps-0" data-type="5" data-min="1" data-max="2" id="valorIva" data-required="1" placeholder="Ej: 21" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="descrIva" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-card-text me-1"></i> Descripción IVA <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" data-type="3" data-min="2" data-max="150" autocomplete="off" data-required="1" id="descrIva" placeholder="Ej: IVA General">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary px-4" title="Guardar" onclick="agregarIva()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
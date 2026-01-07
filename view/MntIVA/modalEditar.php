<div id="editar-iva-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning bg-gradient text-dark py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Editar IVA
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editar-iva-form" method="POST">
                    <input type="hidden" id="idIvaHidden">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="valorIvaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-percent me-1"></i> Valor IVA <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-percent text-warning"></i></span>
                                <input type="number" class="form-control border-start-0 ps-0" data-type="5" data-min="1" data-max="2" id="valorIvaE" data-required="1" placeholder="Ej: 21" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="descrIvaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-card-text me-1"></i> Descripción IVA <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" data-type="3" data-min="2" data-max="150" autocomplete="off" data-required="1" id="descrIvaE" placeholder="Ej: IVA General">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning px-4" title="Guardar cambios" onclick="editarIva()">
                    <i class="bi bi-check-lg me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
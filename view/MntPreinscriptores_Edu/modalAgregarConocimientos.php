<div id="agregar-conocimientos-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary bg-gradient text-white py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Nueva Descripción como nos conocieron
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="insertarConocimiento" method="POST">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="nombreConocimiento" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-lightbulb me-1"></i>Descripción como nos conocieron <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lightbulb text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nombreConocimiento" 
                                name="nombreConocimiento" placeholder="Descripción" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                     
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary px-4" title="Guardar" onClick="agregarElementoConocimiento()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
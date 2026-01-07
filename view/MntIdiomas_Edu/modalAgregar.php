<div id="insertar-idioma-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary bg-gradient text-white py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Agregar Idioma
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="insertar-idioma-form" method="POST">
                    <div class="row g-4">
                        <div class="col-12 col-lg-6">
                            <label for="descrIdioma" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-translate me-1"></i> Nombre <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-translate text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" id="descrIdioma" name="descrIdioma" placeholder="Ingrese el nombre del idioma" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="codIdioma" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-code me-1"></i> Código <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-code text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" id="codIdioma" name="codIdioma" placeholder="Ej: ES, EN, FR" data-type="3" data-min="1" data-max="2" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="textIdioma" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-chat-text me-1"></i> Observación
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-chat-dots text-primary"></i>
                                </span>
                                <textarea class="autoArea form-control border-start-0 ps-0" id="textIdioma" name="textIdioma" placeholder="Comentarios adicionales (opcional)" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="1" data-required="0"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary px-4" title="Guardar" onClick="agregarElemento()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
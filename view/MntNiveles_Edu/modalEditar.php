<div id="editar-nivel-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning bg-gradient text-dark py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Editar Nivel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editar-nivel-form" method="POST">
                    <input type="hidden" id="id-nivel" name="idNivel">
                    <div class="row g-4">
                        <!-- Campo Nombre -->
                        <div class="col-12 col-lg-6">
                            <label for="descripcion-nivel" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-bookmark-star me-1"></i> Nombre <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-bookmark-star text-warning"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" id="descripcion-nivel" name="descrNivel" placeholder="Ingrese el nombre del nivel" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <!-- Campo Código -->
                        <div class="col-12 col-lg-6">
                            <label for="codigo-nivel" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-upc-scan me-1"></i> Código <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-upc-scan text-warning"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" id="codigo-nivel" name="codNivel" placeholder="Ingrese el código" data-type="3" data-min="1" data-max="6" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <!-- Campo Observación -->
                        <div class="col-12">
                            <label for="observaciones-nivel" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-chat-text me-1"></i> Observación
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-chat-dots text-warning"></i>
                                </span>
                                <textarea class="autoArea form-control border-start-0 ps-0" id="observaciones-nivel" name="textNivel" placeholder="Observaciones adicionales" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="1" data-required="0"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning px-4" title="Actualizar" onClick="editarElemento()">
                    <i class="bi bi-check-lg me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
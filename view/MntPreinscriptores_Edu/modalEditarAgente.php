<div id="editar-agente-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning bg-gradient text-dark py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Editar Agente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editarAgenteForm" method="POST">
                    <input type="hidden" name="id-agente" id="id-agente" value="">
                    <div class="row g-4">
                        <!-- Nombre del Agente -->
                        <div class="col-12 col-lg-6">
                            <label for="nombreAgenteE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person me-1"></i> Nombre del Agente <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nombreAgenteE" name="nombreAgenteE" placeholder="Ingrese el nombre" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <!-- Identificador Fiscal -->
                        <div class="col-12 col-lg-6">
                            <label for="identificacionFiscalAgenteE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-card-text me-1"></i> Identificador Fiscal
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="identificacionFiscalAgenteE" name="identificacionFiscalAgenteE" placeholder="NIF / CIF / VAT" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <!-- Domicilio Fiscal -->
                        <div class="col-12 col-lg-6">
                            <label for="domicilioFiscalAgenteE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-geo-alt me-1"></i> Domicilio Fiscal
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-house-door text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="domicilioFiscalAgenteE" name="domicilioFiscalAgenteE" placeholder="Dirección completa" data-type="13" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <!-- Correo del Agente -->
                        <div class="col-12 col-lg-6">
                            <label for="correoAgenteE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-envelope me-1"></i> Correo Electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="correoAgenteE" name="correoAgenteE" placeholder="ejemplo@correo.com" data-type="1" data-min="3" data-max="40" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning px-4" title="Guardar Cambios" onClick="editarElementoAgentes()">
                    <i class="bi bi-check-lg me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
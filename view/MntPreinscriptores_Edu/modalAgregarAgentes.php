<div id="agregar-agentes-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary bg-gradient text-white py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-person-plus-fill"></i> Nuevo Agente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="insertarAgente" method="POST">
                    <div class="row g-4">
                        <!-- Nombre del Agente -->
                        <div class="col-12 col-lg-6">
                            <label for="nombreAgente" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person me-1"></i> Nombre del Agente <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nombreAgente" name="nombreAgente" placeholder="Ingrese el nombre" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <!-- Identificador Fiscal -->
                        <div class="col-12 col-lg-6">
                            <label for="identificacionFiscalAgente" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-card-text me-1"></i> Identificador Fiscal
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="identificacionFiscalAgente" name="identificacionFiscal" placeholder="NIF / CIF / VAT" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <!-- Domicilio Fiscal -->
                        <div class="col-12 col-lg-6">
                            <label for="domicilioFiscalAgente" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-geo-alt me-1"></i> Domicilio Fiscal
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-house-door text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="domicilioFiscalAgente" name="domicilioFiscal" placeholder="Dirección completa" data-type="13" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <!-- Correo del Agente -->
                        <div class="col-12 col-lg-6">
                            <label for="correoAgente" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-envelope me-1"></i> Correo Electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="correoAgente" name="correoAgente" placeholder="ejemplo@correo.com" data-type="1" data-min="3" data-max="40" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary px-4" title="Guardar Agente" onClick="agregarElementoAgentes()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
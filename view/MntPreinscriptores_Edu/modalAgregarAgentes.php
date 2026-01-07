<div id="agregar-agentes-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Agente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Nuevo Agente</h5>
                        <form id="insertarAgente" method="POST">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Nombre Agente</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nombreAgente" name="nombreAgente" placeholder="Nombre" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Identificador Fiscal</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="identificacionFiscalAgente" name="identificacionFiscal" placeholder="Identificador Fiscal" data-type="8" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Domicilio Fiscal</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="domicilioFiscalAgente" name="domicilioFiscal" placeholder="Domicilio Fiscal" data-type="0" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Correo Agente</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="correoAgente" name="correoAgente" placeholder="Correo de Agente" data-type="1" data-min="3" data-max="40" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                              

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarElementoAgentes()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
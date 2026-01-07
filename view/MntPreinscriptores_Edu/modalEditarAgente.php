<div id="editar-agente-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Agente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Editar Agente</h5>
                        <form id="editarAgenteForm" method="POST">
                            <input type="hidden" name="id-agente" id="id-agente" value="">

                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="nombreAgenteE" class="form-label">Nombre Agente</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nombreAgenteE" name="nombreAgenteE" placeholder="Nombre" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Idefntificador Fiscal</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="identificacionFiscalAgenteE" name="identificacionFiscalAgenteE" placeholder="Identificador Fiscal" data-type="8" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Domicilio Fiscal</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="domicilioFiscalAgenteE" name="domicilioFiscalAgenteE" placeholder="Domicilio Fiscal" data-type="0" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Correo Agente</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="correoAgenteE" name="correoAgenteE" placeholder="Correo de Agente" data-type="1" data-min="3" data-max="40" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                              

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="editarElementoAgentes()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
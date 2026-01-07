<div id="editar-contrato-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Editar Contrato</h5>
                        <form id="editar-contrato-form" method="POST" autocomplete="off">
                            <input type="hidden" name="idContratoE" id="idContratoE" value="">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="tipoPersonalE" class="form-label">Tipo de contrato:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <select class="form-control custom-select select2" id="tipoPersonalE" name="tipoPersonalE" placeholder="Tipo de contrato"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="fecInicioPersoContratoE" class="form-label">Fecha Inicio:</label>
                                    <div class="position-relative input-icon">
                                        <input type="text" id="fecInicioPersoContratoE" name="fecInicioPersoContratoE" class="form-control date-format" placeholder="18 Julio, 2024" />
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="fecFinalPersoContratoE" class="form-label">Fecha Fin:</label>
                                    <div class="position-relative input-icon">
                                        <input type="text" id="fecFinalPersoContratoE" name="fecFinalPersoContratoE" class="form-control date-format" placeholder="3 Enero, 2030" />
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Categoría:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input class="form-control" id="textCategoriaE" name="textCategoriaE" data-type="3" data-min="0" data-max="300" data-new-input="1" data-descripcion="1" data-required = "0"></input>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Jornada:</label                                                                                                 >
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input class="form-control" id="textJornadaE" name="textJornadaE" data-type="3" data-min="0" data-max="300" data-new-input="1" data-descripcion="1" data-required = "0"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Duración:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input class="form-control" id="textDuracionE" name="textDuracionE" data-type="3" data-min="0" data-max="300" data-new-input="1" data-descripcion="1" data-required = "0"></input>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Observaciones:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <textarea class="autoArea form-control" id="textTipoContratoE" name="textTipoContratoE" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="1" data-required = "0"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="editarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>

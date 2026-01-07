<div id="insertar-contrato-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Nuevo Contrato</h5>
                        <form id="insertar-contrato-form" method="POST" autocomplete="off">
                        
                        <input type="hidden" name="idContrato" id="idContrato" value="">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="nomPersonal" class="form-label">Tipo de contrato:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <select class="form-control custom-select select2" id="tipoPersonal" name="tipoPersonal" placeholder="Tipo de contrato"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="fecInicioPersoContrato" class="form-label">Fecha Inicio:</label>
                                    
                                    <div class="position-relative input-icon">
                                        <input type="text" id="fecInicioPersoContrato" name="fecInicioPersoContrato" class="form-control date-format" placeholder="18 Julio, 2025" />
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="fecFinalPersoContrato" class="form-label">Fecha Fin:</label>
                                    
                                    <div class="position-relative input-icon">
                                        <input type="text" id="fecFinalPersoContrato" name="fecFinalPersoContrato" class="form-control date-format" placeholder="3 Enero, 2030" />
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Categoría:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input class="form-control" id="textCategoria" name="textCategoria" data-type="3" data-min="0" data-max="300" data-new-input="1" data-descripcion="1" data-required = "0"></input>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Jornada:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input class="form-control" id="textJornada" name="textJornada" data-type="3" data-min="0" data-max="300" data-new-input="1" data-descripcion="1" data-required = "0"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Duración:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input class="form-control" id="textDuracion" name="textDuracion" data-type="3" data-min="0" data-max="300" data-new-input="1" data-descripcion="1" data-required = "0"></input>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Observaciones:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <textarea class="autoArea form-control" id="textTipoContrato" name="textTipoContrato" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="1" data-required = "0"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
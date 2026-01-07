<div id="editar-tarifaAloja-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning bg-gradient text-dark py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Editar Tarifa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editar-tarifaAloja-form" method="POST">
                    <input type="hidden" id="idTarifasAloja" name="idTarifasAloja">
                    <div class="row g-4">
                        <div class="col-12 col-lg-6">
                            <label for="DescrTarifaAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-tag me-1"></i> Nombre <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="DescrTarifaAlojaE" name="DescrTarifaAlojaE" placeholder="Nombre de la tarifa" data-type="3" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="codTarifaAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-upc-scan me-1"></i> Código
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="codTarifaAlojaE" name="codTarifaAlojaE" placeholder="Código de la tarifa" data-type="3" data-min="3" data-max="10" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="unidadTarifasAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-123 me-1"></i> Cantidad
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-123 text-warning"></i></span>
                                <input type="number" class="form-control border-start-0 ps-0" id="unidadTarifasAlojaE" name="unidadTarifasAlojaE" placeholder="Cantidad" min="0" value="1" data-type="5" data-min="1" data-max="3" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="unidadMedidaTarifaPluralE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-rulers me-1"></i> Unidad de Medida
                            </label>
                            <div class="input-group">
                                        <select class="select2 js-example-responsive" data-placeholder="SELECCIONA UNA UNIDAD DE MEDIDA" style="width: 100%; height: 65px !important;" id="unidadMedidaTarifaPluralE" name="unidadMedidaTarifaPluralE">
                                            <option value="0" selected>SIN UNIDAD DE MEDIDA</option>
                                            <option value="1">Días</option>
                                            <option value="2">Días extra</option>
                                            <option value="3">Semanas</option>
                                            <option value="4">Quincenas</option>
                                            <option value="5">Meses</option>
                                            <option value="6">Trimestres</option>
                                            <option value="7">Años</option>
                                            <option value="8">Oferta especial</option>
                                            <option value="9">Horas</option>
                                            <option value="10">Descuento</option>
                                            <option value="11">Viajes</option>
                                        </select>
                                        <select class="select2 js-example-responsive d-none" data-placeholder="SELECCIONA UNA UNIDAD DE MEDIDA" style="width: 100%; height: 65px !important;" id="unidadMedidaTarifaSingularE" name="unidadMedidaTarifaSingularE">
                                            <option value="0" selected>SIN UNIDAD DE MEDIDA</option>
                                            <option value="1">Día</option>
                                            <option value="2">Día extra</option>
                                            <option value="3">Semana</option>
                                            <option value="4">Quincena</option>
                                            <option value="5">Més</option>
                                            <option value="6">Trimestre</option>
                                            <option value="7">Año</option>
                                            <option value="8">Oferta especial</option>
                                            <option value="9">Hora</option>
                                            <option value="10">Descuento</option>
                                            <option value="11">Viaje</option>
                                        </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="importeTarifasAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-currency-euro me-1"></i> Importe <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-currency-euro text-warning"></i></span>
                                <input type="number" class="form-control border-start-0 ps-0" id="importeTarifasAlojaE" name="importeTarifasAlojaE" placeholder="Importe" data-type="5" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="descuentoTarifasE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-percent me-1"></i> Descuento
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-percent text-warning"></i></span>
                                <input type="number" class="form-control border-start-0 ps-0" id="descuentoTarifasE" name="descuentoTarifasE" placeholder="Descuento (%)" value="0" min="-100" max="100" data-type="5" data-min="1" data-max="4" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="cta1TarifasAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-calculator me-1"></i> Cuenta Contable 1
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-calculator text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="cta1TarifasAlojaE" name="cta1TarifasAlojaE" placeholder="Cuenta contable 1" data-type="3" data-min="1" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="cta2TarifasAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-calculator me-1"></i> Cuenta Contable 2
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-calculator text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="cta2TarifasAlojaE" name="cta2TarifasAlojaE" placeholder="Cuenta contable 2" data-type="3" data-min="1" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="cta3TarifasAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-calculator me-1"></i> Cuenta Contable 3
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-calculator text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="cta3TarifasAlojaE" name="cta3TarifasAlojaE" placeholder="Cuenta contable 3" data-type="3" data-min="1" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="selectIvaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-percent me-1"></i> IVA <span class="text-danger">*</span>
                            </label>
                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONA UN IVA" style="width: 100%; height: 65px !important;" id="selectIvaE" name="selectIvaE">
                            </select>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="departamentoTarifaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-building me-1"></i> Departamento <span class="text-danger">*</span>
                            </label>
                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONA UN DEPARTAMENTO" style="width: 100%; height: 65px !important;" id="departamentoTarifaE" name="departamentoTarifaE">
                            </select>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="tipoTarifaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-tags me-1"></i> Tipo <span class="text-danger">*</span>
                            </label>
                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONA UN TIPO" style="width: 100%; height: 65px !important;" id="tipoTarifaE" name="tipoTarifaE">
                                <option value="Alojamiento">Alojamiento</option>
                                <option value="Docencia">Docencia</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="textTarifasAlojaE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-chat-text me-1"></i> Descripción
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 align-items-start pt-2"><i class="bi bi-chat-text text-warning"></i></span>
                                <textarea class="autoArea form-control border-start-0 ps-0" id="textTarifasAlojaE" name="textTarifasAlojaE" placeholder="Descripción de la tarifa" rows="3" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="1" data-required="0"></textarea>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning px-4" title="Guardar cambios" onClick="editarElemento()">
                    <i class="bi bi-check-lg me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>

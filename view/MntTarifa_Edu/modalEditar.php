<div id="editar-tarifaAloja-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Tarifa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <h5 class="mb-4">Editar Tarifa</h5>
                        </div>
                        <form id="editar-tarifaAloja-form" method="POST">
                        <input type="hidden" id="idTarifasAloja" name="idTarifasAloja">

                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="DescrTarifaAlojaE" class="form-label">Nombre</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="DescrTarifaAlojaE" name="DescrTarifaAlojaE" placeholder="Nombre" data-type="3" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="codTarifaAlojaE" class="form-label">Codigo</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="codTarifaAlojaE" name="codTarifaAlojaE" placeholder="Codigo" data-type="3" data-min="3" data-max="10" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="unidadTarifasAlojaE" class="form-label">Cantidad</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="number" class="form-control" id="unidadTarifasAlojaE" name="unidadTarifasAlojaE" placeholder="Cantidad" min="0" value="1" data-type="5" data-min="1" data-max="3" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="unidadMedidaTarifaPluralE" class="form-label">Unidad de Medida</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
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
                                    <label for="importeTarifasAlojaE" class="form-label">Importe</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="number" class="form-control" id="importeTarifasAlojaE" name="importeTarifasAlojaE" placeholder="Importe" data-type="5" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="descuentoTarifasE" class="form-label">Descuento</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="number" class="form-control" id="descuentoTarifasE" name="descuentoTarifasE" placeholder="Descuento" value="0" min="-100" max="100" data-type="5" data-min="1" data-max="4" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="cta1TarifasAlojaE" class="form-label">Cuenta contable 1</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="cta1TarifasAlojaE" name="cta1TarifasAlojaE" placeholder="Cuenta contable 1" data-type="3" data-min="1" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="cta2TarifasAlojaE" class="form-label">Cuenta contable 2</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="cta2TarifasAlojaE" name="cta2TarifasAlojaE" placeholder="Cuenta contable 2" data-type="3" data-min="1" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="cta3TarifasAlojaE" class="form-label">Cuenta contable 3</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="cta3TarifasAlojaE" name="cta3TarifasAlojaE" placeholder="Cuenta contable 3" data-type="3" data-min="1" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="selectIvaE" class="form-label">IVA</label>
                                    <select class="select2 js-example-responsive" data-placeholder="SELECCIONA UN IVA" style="width: 100%; height: 65px !important;" id="selectIvaE" name="selectIvaE">
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="departamentoTarifaE" class="form-label">Departamento</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <select class="select2 js-example-responsive" data-placeholder="SELECCIONA UN DEPARTAMENTO" style="width: 100%; height: 65px !important;" id="departamentoTarifaE" name="departamentoTarifaE">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="tipoTarifaE" class="form-label">Tipo</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <select class="select2 js-example-responsive" data-placeholder="SELECCIONA UN DEPARTAMENTO" style="width: 100%; height: 65px !important;" id="tipoTarifaE" name="tipoTarifaE">
                                            <option value="Alojamiento">Alojamiento</option>
                                            <option value="Docencia">Docencia</option>
                                            <option value="Otros">Otros</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <label for="textTarifasAlojaE" class="form-label">Descripción</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <textarea class="autoArea form-control" id="textTarifasAlojaE" name="textTarifasAlojaE" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="1" data-required="0"></textarea>
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

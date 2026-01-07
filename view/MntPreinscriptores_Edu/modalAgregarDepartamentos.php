<div id="agregar-departamentos-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Nuevo Departamento</h5>
                        <form id="insertarDepartamento" method="POST">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="nombreTipo" class="form-label">Nombre Departamento</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nombreDepartamento" name="nombreDepartamento" placeholder="Nombre" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="nombreTipo" class="form-label">Prefijo Factura</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="prefijofactura" name="prefijofactura" placeholder="PRE Factura Pro" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <label for="nombreTipo" class="form-label">Nº Factura (El Nº siguiente se pondrá en factura)</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nfactura" name="nfactura" placeholder="Nº Factura" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="nombreTipo" class="form-label">Prefijo Proforma</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="prefijofacturapro" name="prefijofacturapro" placeholder="PRE Factura Pro" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <label for="nombreTipo" class="form-label">Nº Proforma (El Nº siguiente se pondrá en factura proforma)</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nfacturapro" name="nfacturapro" placeholder="Nº Factura Pro" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="nombreTipo" class="form-label">Prefijo Abono</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="prefijoabono" name="prefijoabono" placeholder="PRE Factura Pro" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <label for="nombreTipo" class="form-label">Nº Abono (El Nº siguiente se pondrá en factura abono)</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nfacturaNeg" name="nfacturaNeg" placeholder="Nº Factura Abono" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label for="nombreTipo" class="form-label">Prefijo Abono Proforma</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="prefijoabonoProf" name="prefijoabonoProf" placeholder="PRE Abono Proforma" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <label for="nombreTipo" class="form-label">Nº Abono Proforma (El Nº siguiente se pondrá en factura abono Prof.)</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nfacturaprofDep" name="nfacturaprofDep" placeholder="Nº Abono Proforma" data-type="3" data-min="1" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>

                                <!-- NUEVO CAMPO: Selector de color -->
                                <div class="col-12 col-md-6">
                                    <label for="colorDepartamento" class="form-label">Color del Departamento</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-palette-fill"></i></span>
                                        <input type="text" class="form-control" id="colorDepartamento" name="colorDepartamento" value="#222222" placeholder="Selecciona un color" readonly>
                                    </div>
                                </div>
                                <!-- FIN NUEVO CAMPO -->

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarElementoDepartamentos()">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="editar-personal-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Personal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Nueva Personal</h5>
                        <form id="editar-personal-form" method="POST" autocomplete="off">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                <input type="hidden" name="idPersonalE" id="hiddenid">
                                    <label for="nomPersonalE" class="form-label">Nombre:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nomPersonalE" name="nomPersonalE" placeholder="Nombre" data-type="0" data-min="2" data-max="40" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="apePersonalE" class="form-label">Apellido:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="apePersonalE" name="apePersonalE" placeholder="Apellido" data-type="0" data-min="2" data-max="40" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="usuPersonalE" class="form-label">Usuario (email):</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="email" class="form-control" id="usuPersonalE" name="usuPersonalE" placeholder="ejemplo@ejemplo.com" data-type="1" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="1" autocomplete="new-user">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="paisPersonalE" class="form-label">País:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="paisPersonalE" name="paisPersonalE" placeholder="País" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonalE" class="form-label">Calle:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="dirPersonalE" name="dirPersonalE" placeholder="Calle" data-type="3" data-min="3" data-max="120" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="poblaPersonalE" class="form-label">Población:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="poblaPersonalE" name="poblaPersonalE" placeholder="Población" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="cpPersonalE" class="form-label">Código Postal:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="cpPersonalE" name="cpPersonalE" placeholder="Código Postal" data-type="5" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="provPersonalE" class="form-label">Provincia:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="provPersonalE" name="provPersonalE" placeholder="Provincia" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                
                                <div class="col-12 col-md-6">
                                    <label for="tlfPersonalE" class="form-label">Teléfono:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="tel" class="form-control" id="tlfPersonalE" name="tlfPersonalE" placeholder="Teléfono" data-type="4" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="movilPersonalE" class="form-label">Móvil:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="tel" class="form-control" id="movilPersonalE" name="movilPersonalE" placeholder="Móvil" data-type="2" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                               
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12 col-md-6 row mg-t-20">
                                    <div class="col-12 col-md-2 form-label">Rol:</div>
                                    <div class="col-12 col-md-10">
                                            <div class="container_radio">
                                                <div class="custom-radio">
                                                    <input type="radio" class="form-check-input" id="rol-profesor" name="rolE" value="2" checked>
                                                    <label class="form-check-label radio-label" for="rol-profesor">
                                                        <div class="radio-circle"></div>
                                                        <span class="radio-text">Profesor</span>
                                                    </label>
                                                    
                                                    <input type="radio" class="form-check-input" id="rol-administrador" name="rolE" value="1">
                                                    <label class="form-check-label radio-label" for="rol-administrador">
                                                        <div class="radio-circle"></div>
                                                        <span class="radio-text">Admin</span>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mg-t-20">
                                    <label class="checkbox">
                                        <label class="mg-r-10">Activo:</label>
                                        <input type="checkbox" class="checkbox-input" id="estUsuE" name="estUsuE" value="1">
                                        <svg height="28" width="28" class="checkbox-check">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </label>
                                </div>
                                <div class="row d-flex justify-content-center text-center">
                                    <div class="col-sm-12 col-md-12 col-lg-12 mg-t-10 mg-sm-t-0">
                                        <label class="col-sm-12 col-md-12 col-lg-12 form-control-label">
                                            ¿En qué departamentos quieres que se vea? <span class="tx-danger">*</span>
                                        </label>
                                        <div class="mx-auto" style="width: 50%;">
                                            <select class="js-example-placeholder-multiple js-states form-control" id="departamentosSelectE" multiple="multiple"></select>
                                        </div>
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

<div id="insertar-personal-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Personal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Nueva Personal</h5>
                        
                            <form id="insertar-personal-form" method="POST" autocomplete="off">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="nomPersonal" class="form-label">Nombre:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nomPersonal" name="nomPersonal" placeholder="Nombre" data-type="0" data-min="2" data-max="40" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="apePersonal" class="form-label">Apellidos:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="apePersonal" name="apePersonal" placeholder="Apellido" data-type="0" data-min="2" data-max="40" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="usuPersonal" class="form-label">Usuario (email):</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="email" class="form-control" id="usuPersonal" name="usuPersonal" placeholder="ejemplo@ejemplo.com" data-type="1" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="1" autocomplete="new-user">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="paisPersonal" class="form-label">País:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="paisPersonal" name="paisPersonal" placeholder="País" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="dirPersonal" class="form-label">Calle:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="dirPersonal" name="dirPersonal" placeholder="Calle" data-type="3" data-min="3" data-max="120" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="poblaPersonal" class="form-label">Población:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="poblaPersonal" name="poblaPersonal" placeholder="Población" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="cpPersonal" class="form-label">Código Postal:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="cpPersonal" name="cpPersonal" placeholder="Código Postal" data-type="5" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="provPersonal" class="form-label">Provincia:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="provPersonal" name="provPersonal" placeholder="Provincia" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                               
                                <div class="col-12 col-md-6">
                                    <label for="tlfPersonal" class="form-label">Teléfono:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="tel" class="form-control" id="tlfPersonal" name="tlfPersonal" placeholder="Teléfono" data-type="4" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="movilPersonal" class="form-label">Móvil:</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="tel" class="form-control" id="movilPersonal" name="movilPersonal" placeholder="Móvil" data-type="2" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                    </div>
                                </div> 
                            </div>
                          
                            <div class="row g-3 mg-t-20">
                                <div class="col-12 col-md-6 row mg-t-20">
                                    <div class="col-12 col-md-2 form-label">Rol:</div>
                                    <div class="col-12 col-md-10">
                                            <div class="container_radio">
                                                <div class="custom-radio">
                                                    <input type="radio" class="form-check-input" id="rol-profesor" name="rolSelec" value="2" checked>
                                                    <label class="form-check-label radio-label" for="rol-profesor">
                                                        <div class="radio-circle"></div>
                                                        <span class="radio-text">Profesor</span>
                                                    </label>
                                                    
                                                    <input type="radio" class="form-check-input" id="rol-administrador" name="rolSelec" value="1">
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
                                                <input type="checkbox" class="checkbox-input" id="estUsu" value="1">

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
                                            <select class="js-example-placeholder-multiple js-states form-control" id="departamentosSelect" multiple="multiple"></select>
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
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="gestion-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Interesado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Datos del interesado</h5>
                        <div class="row g-3">

                            <div class="col-12">

                                <div class="row">
                            
                                    <input type="hidden" id="idSelect">

                                    <h2><b id="idTextSelect"></b> - <b id="nameSelect"></b> - <b id="correoSelect"></b></h2>
                                 
                                    <div class="col-12 row  mg-b-20">
                                    
                                        <div class="col-12 ">
                                            
                                            <div class="form-check form-check-success">
                                                <input class="checki" type="checkbox" value="" id="checkNuevoUsuario" >
                                                <label class="" for="checkNuevoUsuariofg">
                                                    Enviar nuevo usuario. 
                                                </label> <br>
                                                <b class="tx-danger">*</b> En caso de no tener usuario, se creará un usuario nuevo, podrá establecer una contraseña.<br>
                                                <b class="tx-danger">*</b> Si el usuario esta registrado, se enviará un enlace para restablecer la contraseña.

                                            </div>
                                           
                                            <div class="form-check form-check-warning">
                                                <input class="checki" type="checkbox" value="" id="checkRecordatorioPerfil" >
                                                <label class="" for="checkRecordatorioPerfilgg">
                                                    Enviar un recordatorio para completar el perfil.
                                                </label> 
                                            </div>

                                            <div class="form-check form-check-success">
                                                <input class="checki" type="checkbox" value="" id="checkFactura" >
                                                <label class="" for="checkFacturad">
                                                    Enviar Apartado de facturas
                                                </label> 
                                            </div>
                                        </div>
                                        
                                    </div>

                                    
                                    <hr>
                                    
                                    <div class="col-12 row  mg-b-20">
                                    
                                        <div class="col-12 ">
                                            <div class="alertsText">
                                                <p class="textFactura d-none">- Se enviará la última factura</p>
                                                <p class="textCuenta d-none" >- Se enviará cuenta de usuario</p>
                                                <p class="textRecordatorioPerfil d-none">- Se enviará un recordatorio para completar el perfil</p>
                                            </div>
                                            <div class="col-12 row ">
                                                <div class="col-12">
                                                    <label for="">El correo se enviará a </label>
                                                </div>

                                                <div class="col-6 d-flex align-items-center">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                        <input type="text" class="docenciaInput form-control tx-left-force" id="correoEnviar" value="">
                                                    </div>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-end">
                                                    <button type="button" id="botonEnviarCorreo" class="btn btn-outline-danger px-5">
                                                        <span class="material-symbols-outlined">mail</span>Enviar correo
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </div>
                            
                            </div>

                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div id="gestion-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Personal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Datos del trabajador</h5>
                        <div class="row g-3">

                            <div class="col-12">

                                <div class="row">
                            
                                    <input type="hidden" id="idSelect">

                                   

                                    
                                    <div class="col-12 row  mg-b-20">
                                    
                                        <div class="col-12 ">
                                            <p><b class="tx-danger">*</b> Se enviará un correo para restablecer la contraseña de la cuenta: <b id="correoRes"></b></p>
                                            <div class="form-check form-check-success">
                                                <input class="checki" type="checkbox" value="" id="checkNuevoUsuario" >
                                                <label class="" for="checkNuevoUsuariofg">
                                                    Enviar creación de nuevo usuario. 
                                                </label> 
                                            </div>
                                        
                                            
                                        </div>
                                        
                                    </div>

                                    
                                    <hr>
                                    
                                    <div class="col-12 row  mg-b-20">
                                    
                                        <div class="col-12 ">
                                    
                                            <div class="col-12 row ">
                                                <div class="col-12">
                                                    <label for="">El corre se enviará a </label>
                                                </div>

                                                <div class="col-6 d-flex align-items-center">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                        <input type="text" class="docenciaInput form-control tx-left-force" id="correoEnviar" value="">
                                                    </div>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-end">
                                                    <button type="button" id="botonEnviarCorreoPersonal" class="btn btn-outline-danger px-5">
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
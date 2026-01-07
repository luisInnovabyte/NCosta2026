    <!-- ============================================================== -->
            <!-- MODAL INSERTAR AULAS  -->
            <!-- ============================================================== -->

            <div id="insertar-aula-modal" class="modal fade">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Añadir Aula</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
                        </div>
                        <form id="formAula" class="">
                            <div class="modal-body">

                                <div class="row mg-b-10">
                                    <div class="form-group col-12 col-lg-6 ">
                                        <label for="recipient-name" class="control-label">Nombre del Aula:</label>
                                        <input type="text" class="form-control" name="descrAula" id="descrAula">
                                        <div class="row">
                                            <span id="infoDescrAula" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo números y letras</span>
                                            <span id="lonDescrAula" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                        </div>
                                    </div>

                                    

                                    <div class="form-group col-12 col-lg-6 ">
                                        <label for="recipient-name" class="control-label">Localización:</label>
                                        <input type="text" class="form-control" id="localizacionAula" name="localizacionAula" >
                                        <div class="row">
                                            <span id="infotelfAula" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo números y letras</span>
                                            <span id="lontelfAula" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                        </div>
                                    </div>

                                 
                                    <div class="form-group col-12 col-lg-6 ">
                                        <label for="" class="">Capacidad:</label>
                                        <input id="capaAula" type="text" value="1" name="capaAula">
                                    </div>
                                        
                                    <div class="col-12 col-lg-6 d-flex flex-wrap align-items-center">
                                        <div class="form-check me-3 form-check-danger">
                                            <input class="form-check-input  form-check-warning" type="checkbox" id="flexCheckHibrido">
                                            <label class="form-check-label" id="hibriCheck" for="flexCheckHibrido">Híbrido</label>
                                        </div>
                                        <div class="form-check me-3 form-check-success">
                                            <input class="form-check-input" type="checkbox" id="flexCheckKids">
                                            <label class="form-check-label" id="kidsCheck" for="flexCheckKids">Kids</label>
                                        </div>
                                        <div class="form-check me-3 form-check-warning">
                                            <input class="form-check-input" type="checkbox" id="flexCheckParaliticos">
                                            <label class="form-check-label" id="paraCheck" for="flexCheckParaliticos">Paralíticos</label>
                                        </div>
                                        <div class="form-check me-3 form-check-info">
                                            <input class="form-check-input" type="checkbox" id="flexCheckAgorafobia">
                                            <label class="form-check-label" id="agoraCheck" for="flexCheckAgorafobia">Agorafobia</label>
                                        </div>
                                    </div>
                                
                                    <hr>


                                    <textarea id="textAula" name="textAula"></textarea>



                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal" id="cancelar-insert">Cerrar</button>
                                <button type="submit" class="btn btn-success waves-effect waves-light" id="guardar-insert">Guardar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
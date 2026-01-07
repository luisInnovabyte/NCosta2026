 <!-- ============================================================== -->
            <!------------------- MODAL EDITAR AULAS   --------------------------->
            <!-- ============================================================== -->

            <div id="editar-aula-modal" class="modal fade">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Aula</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
                        </div>
                        <div class="modal-body">

                            <form id="formAulaEditar" class="">
                                <input type="hidden" class="form-control" name="idAulaE" id="idAulaE">

                                <div class="row mg-b-10">
                                    <div class="form-group col-12 col-lg-6 ">
                                        <label for="recipient-name" class="control-label">Nombre del Aula:</label>
                                        <input type="text" class="form-control" name="descrAulaE" id="descrAulaE">
                                        <div class="row">
                                            <span id="infodescrAulaE" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo letras y números</span>
                                            <span id="londescrAulaE" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                        </div>
                                    </div>

                                   
                                    <div class="form-group col-12 col-lg-6 ">
                                        <label for="recipient-name" class="control-label">Localización:</label>
                                        <input type="text" class="form-control" id="localizacionE" name="localizacionE">
                                        <div class="row">

                                            <span id="infotelfAulaE" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo números y letras</span>
                                            <span id="lontelfAulaE" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                        </div>
                                    </div>


                                    <div class="form-group col-12 col-lg-6 ">
                                        <label for="" class="">Capacidad:</label>
                                        <input id="capaAulaE" type="text" value="1" name="capaAulaE">
                                    </div>
                                    
                                  
                                    <div class="col-12 col-lg-6 d-flex flex-wrap align-items-center">
                                        <div class="form-check me-3 form-check-danger">
                                            <input class="form-check-input  form-check-warning" type="checkbox" id="flexCheckHibridoE">
                                            <label class="form-check-label" id="hibriCheckE" for="flexCheckHibridoE">Híbrido</label>
                                        </div>
                                        <div class="form-check me-3 form-check-success">
                                            <input class="form-check-input" type="checkbox" id="flexCheckKidsE">
                                            <label class="form-check-label" id="kidsCheckE" for="flexCheckKidsE">Kids</label>
                                        </div>
                                        <div class="form-check me-3 form-check-warning">
                                            <input class="form-check-input" type="checkbox" id="flexCheckParaliticosE">
                                            <label class="form-check-label" id="paraCheckE" for="flexCheckParaliticosE">Paralíticos</label>
                                        </div>
                                        <div class="form-check me-3 form-check-info">
                                            <input class="form-check-input" type="checkbox" id="flexCheckAgorafobiaE">
                                            <label class="form-check-label" id="agoraCheckE" for="flexCheckAgorafobiaE">Agorafobia</label>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                            

                                <textarea id="textAulaE" name="textAulaE"></textarea>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
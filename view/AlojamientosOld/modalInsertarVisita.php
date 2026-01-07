<!-- ============================================================== -->
                <!-- MODAL INSERTAR Visitas  -->
                <!-- ============================================================== -->
                <div id="insertar-visitas-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Añadir Visitas</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                            </div>
                            <div class="modal-body">
                                <form id="insertar-visitas-form" method="POST">
                                    <input type="hidden" id="idAloja_AlojaVi" name="idAloja_AlojaVi"></input>

                                    <div class="row">
                                        <div class="form-group col-12 col-lg-6">

                                            <label for="recipient-name" class="control-label">Visitante:</label>
                                            <input type="text" class="form-control" id="quienAlojaVis" name="quienAlojaVis" minlength="2" maxlength="70" required>
                                            <div class="row">
                                                <span id="infoquienAlojaVis" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo letras</span>
                                                <span id="lonquienAlojaVis" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="recipient-name" class="control-label">Fecha de visita:</label>
                                            <input type="date" class="form-control" id="fechaAlojaVis" name="fechaAlojaVis" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Observaciones:</label>
                                        <textarea id="descrImpreAloja" name="descrImpreAloja"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-success waves-effect waves-light" id="guardar-btn">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- MODAL EDITAR TIPO DE CURSO  -->
                <!-- ============================================================== -->

                <div id="editar-contenido-modal" class="modal fade">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Editar Contenido</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <form id="editar-contenido" name="editar-contenido">
                                <div class="modal-body">
                                <div class="row">
                                        <div class="form-group col-4 col">
                                            <label class="control-label">Titular</label>
                                            <select class="select2">
                                                <option value="0">SELECCIONAR TITULAR</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-4 col">
                                            <label for="recipient-name" class="control-labelcol">Nivel</label>
                                            <select class="select2">
                                                <option value="0">SELECCIONAR NIVEL</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-4 col">
                                            <label for="recipient-name" class="control-labelcol">Tipo curso</label>
                                            <select class="select2">
                                                <option value="0">SELECCIONAR TIPO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Contenido:</label>
                                        <textarea name="textConteEdit" id="textConteEdit"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Observación Titular:</label>
                                        <textarea name="textObsTitEdit" id="textObsTitEdit"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-info">Guardar</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
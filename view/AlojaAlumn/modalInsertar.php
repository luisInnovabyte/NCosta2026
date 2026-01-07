  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="agregar-opis-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Valoración de Alumnos          </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
              <div class="modal-body">
                    
                <form id="insertar-opiniones-form" method="POST">
                        <div class="row">
                            <div class="form-group col-12 col-lg-6">
                                <input type="hidden" id="idAloja_AlojaOpi" name="idAloja_AlojaOpi" value=""></input>
                                <input type="hidden" id="idUsu" name="idUsu" value="<?php session_start();
                                                                                                            echo $_SESSION["usuPre_idInscripcion"]; ?>"></input>
                                <label for="recipient-name" class="control-label">Nombre:</label>
                                <input type="text" class="form-control" name="nameUsu" id="nameUsu" value="<?php session_start();
                                                                                                            echo $_SESSION["usu_nom"]; ?>" disabled></input>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="recipient-name" class="control-label">Fecha de comentario:</label>
                                <input type="date" class="form-control" id="fechaAlojaOpi" name="fechaAlojaOpi" readonly value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group col-12 col-lg-12 ">
                            <div class="row mt-3">
                                <label for="recipient-name" class="control-label col-5 text-right">Valoración:</label>
                                <div class="col-6" name="default-star-rating" id="default-star-rating"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Comentario:</label>
                            <textarea id="descrAlojaOpi" name="descrAlojaOpi"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect waves-light" id="guardar">Guardar</button>
                        </div>
                    </form>       

          </div>
          </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
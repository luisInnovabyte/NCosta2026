<!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="editar-idioma-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Valoración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
              <div class="modal-body">
                    
                <input type="hidden" id="id-idioma" name="idIdioma">
                    <form id="editar-idioma-form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Nombre:</label>
                                <input type="text" class="form-control" id="descripcion-idioma" name="descripcion-idioma" value="" minlength="2" maxlength="60" required>
                                <div class="row">
                                    <span id="infodescripcion-idioma" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo números y letras</span>
                                    <span id="londescripcion-idioma" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Código:</label>
                                <input type="text" class="form-control" id="codigo-idioma" name="codigo-idioma" value="" minlength="1" maxlength="2" required>
                                <div class="row">
                                    <span id="infocodigo-idioma" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Longitud de 2 letras en mayúsculas</span>
                                    <span id="loncodigo-idioma" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Observaciones:</label>
                                <textarea id="observaciones-idioma" name="textIdioma"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Guardar</button>
                        </div>
                    </form>
          </div>
          </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
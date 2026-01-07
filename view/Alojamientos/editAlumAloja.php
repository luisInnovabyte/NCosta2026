  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="alumnos-aloja-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccione un Alumno               </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
              <div class="modal-body">
                 
                        <form id="editar-ficha-form" method="POST">
                            <div class="row">
                                <div class="form-group col-12 col-lg-6">
                                    <input type="hidden" id="idAlumAloja" name="idAlumAloja" value="">
                                    <label for="recipient-name" class="control-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombreAlum" name="nombreAlum" value="" disabled>

                                </div>
                                <div class="form-group col-12 col-lg-6 ">
                                    <label for="recipient-name" class="control-label">Fecha de muestra:</label>
                                    <input type="date" class="form-control" id="fechamuestra" name="fechamuestra" value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-lg-6 ">
                                    <label for="recipient-name" class="control-label">Fecha de entrada:</label>
                                    <input type="date" class="form-control" id="fechaentrada" name="fechaentrada" value="" required>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="recipient-name" class="control-label">Fecha de salida:</label>
                                    <input type="date" class="form-control" id="fechasalida" name="fechasalida" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <input type="checkbox" id="estado" name="estado">
                                    </div>
                                    <div class="col-auto">
                                        <label class="form-control-label" style="margin-bottom: 3px !important;">¿Mostrar alojamiento al alumno?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Guardar</button>
                            </div>
                        </form>
                       
              </div>

             
          </div>
          </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
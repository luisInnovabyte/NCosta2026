  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->

  <div id="verClase" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Seleccione un curso para añadir alumnos</h4>
                  <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#selectCurso1" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                  <div class="row">
                          <div type="button" class="col-12 col-lg-6 col-md-6" style="cursor:default">
                                  <div class="card-hover card border-left border-success">
                                      <div class="card-body">
                                          <div class="d-flex no-block align-items-center">
                                              <div class="mg-r-20 tx-break">
                                                  <span class="text-success display-6"><i class="ti-user"></i></span>
                                              </div>

                                              <div class="ml-auto">
                                                  <h4>Profesor: <label id="profesorCursoMostrar"></label></h4>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                          </div>
                  </div>
                  <div class="row" id="alumnosCursoMostrar"></div>


              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" data-toggle="modal" data-target="#insertar-tipocurso-modal">Cerrar</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
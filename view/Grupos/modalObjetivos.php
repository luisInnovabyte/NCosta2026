  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->

  <div id="objetivos-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Objetivos</h4>
                  <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#selectCurso1" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="idAlumnoModal">
                  <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#agregar" role="tab"><span class="hidden-sm-up"><i class="ti-plus"></i></span> <span class="hidden-xs-down">Agregar / Quitar</span></a> </li>
                      <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#listar" role="tab"><span class="hidden-sm-up"><i class="ti-list"></i></span> <span class="hidden-xs-down">Objetivos</span></a> </li>
                  </ul>
                  <div class="tab-content tabcontent-border">
                      <div class="tab-pane active" id="agregar" role="tabpanel">
                          <div class="row mg-t-20">
                            <div class="col-12 row d-flex justify-content-ceter">
                                <div class="col-6 tx-center"><label class="bold tx-20">Todos los Objetivos</label></div>
                                <div class="col-6 tx-center"><label class="bold tx-20">Objetivos del Alumno</label></div>
                            </div>
                              <div class="col-12">
                                  <select multiple="multiple" size="10" id="listAddObj" class="duallistbox-nuevo-obj">
                                  </select>
                              </div>
                          </div>
                          <div class="mg-t-20 d-flex justify-content-end">
                                        
                            <button type="button" class="mg-r-10 btn btn-success waves-effect text-left" onClick="guardarObjetivosAlumno();">Guardar</button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" data-toggle="modal" data-target="#insertar-tipocurso-modal">Cerrar</button>
                          </div>
                      </div>
                      <div class="tab-pane" id="listar" role="tabpanel">
                          <div class="row">
                              <div class="col-12 row d-flex justify-content-center" id="listObjetivos">
                                  
                              </div>
                          </div>
                          <div class="mg-t-20 d-flex justify-content-end">
                                        
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" data-toggle="modal" data-target="#insertar-tipocurso-modal">Cerrar</button>
                          </div>
                      </div>
                      <div class="tab-pane  p-20" id="profile" role="tabpanel">2</div>
                      <div class="tab-pane p-20" id="messages" role="tabpanel">3</div>
                  </div>
              </div>
              <div class="modal-footer">
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="seleccionarAlumno" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información Alumno Seleccionado                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
              <div class="modal-body">
                                <div id="divInfoAlumno" class="">
                                    <div class="card w-100">
                                        <div class="card-header bg-transparent">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                <h6 class="mb-0 fw-bold">Información del Alumno</h6>
                                                </div>
                                                <div class="dropdown ms-auto">
                                                <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                                    </li>
                                                    <li>
                                                    <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                                    </li>
                                                </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card-body">
                                    <div class="team-list">
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="hidden" id="idAlumno">
                                            <input type="hidden" id="codNivel">

                                            
                                            <div class="">
                                            <img id="avatarUsu" src="" alt="" width="50" height="50" class="rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                            <h6  id="nombreAlumno" class="mb-1 fw-bold"></h6>
                                            </div>
                                            <div class="">
                                            <a href="" id="botonPerfil" target="_blank" class="btn btn-outline-primary rounded-5 btn-sm px-3">Ver Perfil</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-warning text-white">
                                                <i class=" bi bi-clipboard2-pulse"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Adaptaciones</h6>
                                            <div id="adaptacionesDiv">

                                            </div>
                                            
                                            

                                            </div>
                                            
                                            
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-info text-white">
                                                <i class="bi bi-journal-bookmark"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Nivel Seleccionado</h6>
                                            <input type="hidden" id="idLlegada">
                                            <input type="hidden" id="nivelAsignado">

                                            <span id="idiomaTxt" class="badge bg-danger-subtle text-danger border border-danger"></span>
                                            <span id="tipoTxt" class="badge bg-info-subtle text-info border border-info"></span>
                                            <span id="nivelTxt" class="badge bg-warning-subtle text-warning border border-warning"></span>
                                            <div id="ultimoCurso">

                                            </div>

                                            </div>
                                          
                                            
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-success text-white">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">Grupo de Amigos</h6>

                                                <div class="mb-2" id="grupoAmigos">
                                                  
                                                </div>
                                               
                                                <div class="mt-2" id="listaAmigos">
                                                    
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-primary text-white">
                                                <i class="bi bi-journal-bookmark-fill"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">Matriculas</h6>
                                                <div id="matriculasDiv" class="mt-2">
                                                    
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                    </div>
                                </div>
             
                </div>



              </div>
              
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
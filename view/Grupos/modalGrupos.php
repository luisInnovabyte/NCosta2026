  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="seleccionarGrupo" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información Alumno Seleccionado                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
                                <div class="modal-body">
                                    <div class="card w-100">
                                        <div class="card-header bg-transparent">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                            <h6 class="mb-0 fw-bold">Grupo</h6>
                                            </div>
                                            <div class="dropdown ms-auto">
                                            <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
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

                                        <input type="hidden" id="cursoSeleccionado">
                                        <input type="hidden" id="codSeleccionado">
                                        <input type="hidden" id="fechaSeleccionado">
                                        <div class="row justify-content-center text-center">
                                            <div class="col">
                                                <h3 class="h3">Ruta</h3>
                                                <p id="rutaSeleccionada"></p>
                                                <label ><span class="badge bg-dark-subtle text-white border border-dark" id="codSelectText"></span></label>
                                                <label ><span class="badge bg-dark-subtle text-white border border-dark" id="fecSelectText"></span></label>

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center text-center">
                                            <div class="col">
                                                <h3 class="h3">Alumnos</h3>
                                                <p><label >Cantidad: <span class="badge bg-dark-subtle text-white border border-dark" id="capacidadText"></span></label></p>

                                                <div class="col-12" id="alumnos">

                                                </div>
                                             

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center text-center">
                                            <div class="col">
                                                <h3 class="h3">Aula</h3> <br>

                                                <div class="contenedor-tabla tablaViewAula mg-t-10 mg-b-10 d-none">
                                                    <table class="tabla-view">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Localización</th>
                                                                <th>Capacidad</th>
                                                                <th>Características</th>
                                                                <th>Observación</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td id="nombreAulaView"></td>
                                                                <td id="locaAulaView"></td>
                                                                <td id="capaAulaView"></td>
                                                                <td id="caraAulaView"></td>
                                                                <td id="obsAulaView"></td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- <div class="row mg-b-50 mg-t-20">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button type="button" id="botonDupliAlumno" onclick="seleccionarClases()" class="btn btn-outline-info px-5  ">
                                                            <span class="material-symbols-outlined">location_away</span> Seleccionar Aula
                                                        </button>
                                                    </div>
                                                    
                                                </div> -->
                                                <hr>
                                                <div class="row">
                                                    <div class="d-flex flex-column mg-t-10 justify-content-center nombreProfeView d-none align-items-center">
                                                        <b>Profesor Seleccionado</b>
                                                        <p id="nombreSeleccionadoProfeView" class="text-dark font-weight-semibold bg-light border rounded p-3 shadow-sm"></p>
                                                    </div>
                                                   <!--  <div class="col-12 d-flex justify-content-center">
                                                        <button id="botonAddAlumno" type="button"  onclick="seleccionarProfesor()" class="btn btn-outline-success px-5 ">
                                                            <span class="material-symbols-outlined">person_add</span> Añadir Profesor
                                                        
                                                        </button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                               
                                    </div>



            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div></div>
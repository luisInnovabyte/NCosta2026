  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="seleccionarProfesor" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccione un Profesor               </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
              <div class="modal-body">
                 
                <div class="col-12 card mb-3">
                    <div class="table-responsive order-mobile-first ">
                    <?php
                    $nombreTabla = "personal_table";
                    $nombreCampos = ["ID", "Nombre", "Dirección", "Teléfono", "Email"];
                    $nombreCamposFooter = [
                        "ID",
                        "<input type='text' class='form-control' id='FootNombre' name='FootNombre' placeholder='Buscar Nombre'>",
                        "<input type='text' class='form-control' id='FootDirección' name='FootDirección' placeholder='Buscar Dirección'>",
                        "<input type='text' class='form-control' id='FootTelefono' name='FootTelefono' placeholder='Buscar Teléfono'>",
                        "<input type='text' class='form-control' id='FootEmail' name='FootEmail' placeholder='Buscar Email'>",

                    ];

                    $cantidadGrupos = 1; //* CANTIDAD DE AGRUPACIONES *// //=Valores 0 ~ 3==//
                    $columGrupos = []; //* COLUMNAS A AGRUPAR *// //=Poner el numero de la columna empezando a contar desde 0==//
                    $agrupacionesPersonalizadas = 0; //* MARCAR SI QUIERES REALIZAR EL DISEÑO DE LA AGRUPACION MANUAL O AUTOMATICA *// //= 0->Auto 1->Manual ==//
                    $colorHEX = "#3AB54A"; //* COLOR POR DEFECTO DE LAS AGRUPACIONES *// //= Color Hexadecimal #000000 ~ #FFFFFF ==//
                    $desplegado = 0; //* SI QUIERES QUE POR DEFECTO LAS AGRUPACIONES ESTEN PLEGADAS *// //= 0->DESPLEGADO 1->PLEGADO ==//
                    $colorPicker = 0; //* SI QUIERES MOSTRAR EL COLOR PICKER O NO *// //= 0->No 1->Si  ==//

                    $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                    echo $tablaHTML;
                    ?>
                    </div>
                </div>
                    <div class="col-12 viewSelectProfe card mb-3 d-none">
                        <input type="hidden" id="idProfesorSeleccionado">
                        <div class="d-flex flex-column mg-t-10 justify-content-center align-items-center">
                            <b>Profesor Seleccionado</b>
                            <p id="nombreSeleccionadoProfe" class="text-dark font-weight-semibold bg-light border rounded p-3 shadow-sm"></p>
                        </div>


                        <div class="row mg-t-20 mg-b-10">
                        <div class="col-12 d-flex justify-content-center">
                                <button id="botonAddAlumno" type="button"  onclick="asignarProfesor()" class="btn btn-outline-success px-5 ">
                                <span class="material-symbols-outlined">person_add</span> Añadir Profesor
                            
                            </button>
                        </div>
                        
                        </div>
                    </div>
                </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" data-toggle="modal" data-target="#seleccionarProfesor">Cerrar</button>
              </div>
          </div>
          </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
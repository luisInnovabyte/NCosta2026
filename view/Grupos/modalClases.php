  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="seleccionarClases" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccione un Aula para el grupo                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
              <div class="modal-body">
                 
                <div class="col-12 card mb-3">
                    <div class="table-responsive order-mobile-first ">
                    <?php
                        $nombreTabla = "aulas_table";
                        $nombreCampos = ["ID", "Nombre", "Localizacion", "Capacidad","Características", "Observación"];
                        $nombreCamposFooter = [
                            "ID", "Nombre", "Localizacion", "Capacidad","Características", "Observación"
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
                <input type="hidden" id="aulaSeleccionadaEnd">
                <input type="hidden" id="grupoSeleccionadoEnd">

                <div class="col-12 card text-center d-flex justify-content-center align-items-center mg-b-50 p-b-30 mg-t-20" >
                    <h3 class="aulaNoSelectView mg-t-10">¡Selecciona una clase!</h3>
                                        
                    <h4 class="aulaSelectView  mg-t-10 d-none" >Aula Seleccionada</h4>

                    <div class="contenedor-tabla  mg-t-10 mg-b-10 aulaSelectView d-none">
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
                                    <td id="nombreAulaModal"></td>
                                    <td id="locaAulaModal"></td>
                                    <td id="capaAulaModal"></td>
                                    <td id="caraAulaModal"></td>
                                    <td id="obsAulaModal"></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="aulaSelectView  mg-t-10 d-none" >Información de Alumnos</h4>
                    
                    <p class="aulaSelectView">Esta aula tiene una capacidad de <b id="capacidadModalText"></b>. El grupo seleccionado contiene un total de <b id="totalAlumnosText"></b></p>

                    <div >
                        <div class="contenedor-tabla  mg-t-10 mg-b-10 aulaSelectView ">
                            <table class="tabla-view">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Condiciones</th>
                                        <th>Otros</th>
                                    </tr>
                                </thead>
                                <tbody id="datosAlumnosModal">
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="row aulaSelectView mg-t-20 mg-b-20">
                        <div class="col-12 d-flex justify-content-center">
                            <button type="button" id="" onclick="asignarAulaCurso()" class="btn btn-outline-info px-5  ">
                                <span class="material-symbols-outlined">location_away</span> Asignar Aula
                            </button>
                        </div>
                       
                    </div>
                </div>



              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" data-toggle="modal" data-target="#seleccionarClases">Cerrar</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
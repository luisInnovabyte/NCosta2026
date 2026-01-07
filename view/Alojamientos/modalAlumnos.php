  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->
  <div id="alumnos-grupo-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccione un Alumno               </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
              <div class="modal-body">
                 
                <div class="col-12 card mb-3">
                    <div class="table-responsive order-mobile-first ">
                    <?php
                    $nombreTabla = "seleccionar-alumno-table";
                    $nombreCampos = ["ID Usuario", "Nombre","Tarifa Alojamiento","Fecha Inicio","Fecha Fin","Gestión","Token"];
                    $nombreCamposFooter =  ["ID Usuario", "Nombre","Tarifa Alojamiento","Fecha Inicio","Fecha Fin","Gestión","Token"];
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
                    
                </div>

             
          </div>
          </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
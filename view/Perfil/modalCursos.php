<div id="cursosmatriculaciones-modal" class="modal fade" tabindex="-1" aria-labelledby="cursosmatriculaciones-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cursosmatriculaciones-modalLabel">Cursos Asignados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <div class="card">
          <div class="card-body p-4">
            <div class="col-12">
              <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

              <div class="row">
                <div class="table-responsive order-mobile-first">
                  <?php
                    $nombreTabla = "cursosMatriculaciones_table";
                    $nombreCampos = ["Ruta", "Fecha Inicio", "Fecha Fin"];

                    $cantidadGrupos = 1;
                    $columGrupos = [];
                    $agrupacionesPersonalizadas = 0;
                    $colorHEX = "#3AB54A";
                    $desplegado = 0;
                    $colorPicker = 0;

                    $tablaHTML = generarTabla(
                      $nombreTabla,
                      $nombreCampos,
                      $nombreCampos, // encabezado y pie iguales
                      $cantidadGrupos,
                      $columGrupos,
                      $agrupacionesPersonalizadas,
                      $colorHEX,
                      $desplegado,
                      $colorPicker
                    );
                    echo $tablaHTML;
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="buscar-rutas-modal" class="modal fade">
<div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Buscar Grupos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="row">
                            <h5 class="mb-4">Buscar Grupos</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">

                                <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                <div class="row">
                                    <div class="table-responsive order-mobile-first">
                                        <?php
                                            $nombreTabla = "cursosTablaTodos";
                                            $nombreCampos = ["ID", "Ruta",  "Código", "Fecha Inicio","Alumnos", "Capacidad", "Serie", "codGrupo","Semana Actual","Semana Siguiente","idrutaCursos","codIdioma","codTipoCurso","idNumIdioma","idNumTipoCurso","estCursos"];
                                            $nombreCamposFooter = ["ID",  "Ruta","Código", "Fecha Inicio","Alumnos", "Capacidad", "Serie", "codGrupo","Semana Actual","Semana Siguiente","idrutaCursos","codIdioma","codTipoCurso","idNumIdioma","idNumTipoCurso","estCursos"];
                                            $cantidadGrupos = 1; 
                                            $columGrupos = [];
                                            $agrupacionesPersonalizadas = 0;
                                            $colorHEX = "#3AB54A";
                                            $desplegado = 0;
                                            $colorPicker = 0;

                                            $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                                            echo $tablaHTML;
                                        ?>
                                    </div>
                                </div> <!-- cierre row -->

                            </div> <!-- cierre col-12 -->
                        </div> <!-- cierre row g-3 -->

                    </div> <!-- cierre card-body -->
                </div> <!-- cierre card -->
            </div> <!-- cierre modal-body -->

        </div> <!-- cierre modal-content -->
    </div> <!-- cierre modal-dialog -->
</div> <!-- cierre buscar-rutas-modal -->

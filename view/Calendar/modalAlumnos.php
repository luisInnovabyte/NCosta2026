<div id="modalAlumnos" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Alumnos del Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="row">
                            <h5 class="mb-4">Alumnos</h5>
                        </div>
                        <p>🖥️ Híbrido / 🧒 Kids / ♿ Aula Adaptada / 🧠 Fobia</p>
                        <div class="row g-3">
                            <div class="col-12">
                                <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                <div class="row">
                                    <div class="table-responsive order-mobile-first">
                                        <?php
                                            $nombreTabla = "alumnosTablaGrupo";
                                            $nombreCampos = ["ID", "Nombre",  "Contacto", "Condiciones","Preferencia Horaria", "Grupo Amigos", "Preferencia Grupo"];
                                            $nombreCamposFooter = ["ID", "Nombre", "Contacto", "Condiciones", "Preferencia Horaria", "Grupo", "Preferencia Grupo"];
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
</div> <!-- cierre modalAlumnos -->

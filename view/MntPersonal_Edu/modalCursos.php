<div id="cursos-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cursos Asignados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <p>Añade los tipo de cursos que puede realizar el profesor.</p>
                        <div class="row">
                            <input type="hidden" id="idPersonal">
                            <div class="form-group col-md-3">
                                <label for="idioma">Idiomas</label><br>
                                <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR IDIOMA" style="width: 100%; height: 65px !important;" id="selectIdiomaModal">
                                    <?php foreach ($datosIdioma as $row) { ?>
                                        <option value="<?php echo $row["idIdioma"] ?>"><?php echo $row["descrIdioma"] ?> - <?php echo $row["codIdioma"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                           
                            <div class="form-group col-md-3">
                                <label for="curso">Tipo de Curso</label><br>
                                <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CURSO" style="width: 100%; height: 65px !important;" id="selectCursoModal">
                                    <?php foreach ($datos as $row) { ?>
                                        <option value="<?php echo $row["idTipo"] ?>"><?php echo $row["descrTipo"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="curso"><b class="tx-success">Desde el Nivel</b></label><br>
                                <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR NIVEL" style="width: 100%; height: 65px !important;" id="nivelDesde">
                                    <?php foreach ($datosN as $row) { ?>
                                        <option value="<?php echo $row["idNivel"] ?>"><?php echo $row["codNivel"] ?> - <?php echo $row["descrNivel"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="curso"><b class="tx-danger">Hasta el Nivel</b></label><br>
                                <select class="select2 js-example-responsive " desabled data-placeholder="SELECCIONAR NIVEL" style="width: 100%; height: 65px !important;" id="nivelHasta">
                                </select>
                            </div>
                           <div class="mg-t-20">
                                <button  type="button" class="btn btn-success" title="Insertar Ruta" onClick="insertarCurso()">Añadir Rutas</button>
                           </div>

                        </div>
                        <hr>

                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">

                                <div class="table-responsive order-mobile-first">
                                    <?php
                                    $nombreTabla = "personalruta_table";
                                    $nombreCampos = ["ID", "Nombre", "Idioma Curso", "Tipo Curso","Nivel Desde","Nivel Hasta","Eliminar"];
                                    $nombreCamposFooter = ["ID", "Nombre", "Idioma Curso", "Tipo Curso","Nivel Desde","Nivel Hasta","Eliminar"];

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
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);

    ?>
    <!--end head-->
    <style>
/* ========================================== */
/*     FORMATO MAESTRO COSTA DE VALENCIA     */
/* ========================================== */

.page-header-custom {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
}
.page-header-custom h2 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
}
.page-header-custom p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 0.9rem;
}
.nav-tabs-custom .nav-link {
    border: none;
    color: #6c757d;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
    transition: all 0.2s ease;
}
.nav-tabs-custom .nav-link:hover {
    color: #1AA3E8;
    background-color: rgba(26, 163, 232, 0.1);
}
.nav-tabs-custom .nav-link.active {
    color: #fff;
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
}
.btn-add-record {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-add-record:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 163, 232, 0.4);
}

/* ========================================== */
/*     ESTILOS PERSONALIZADOS                */
/* ========================================== */
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }

        table.dataTable {
            width: 100% !important;
        }

        table.dataTable th,
        table.dataTable td {
            text-align: center;
            /* Centrar el contenido */
            vertical-align: middle;
            /* Alinear verticalmente */
        }

        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn {
            padding: 6px 10px;
            margin: 2px;
            font-size: 14px;
        }

        /* Ajuste para las columnas de estado */
        .badge-success {
            background-color: #28a745 !important;
        }

        .badge-secondary {
            background-color: #6c757d !important;
        }

        .badge-warning {
            background-color: #ffc107 !important;
            color: #000;
        }

        .badge-info {
            background-color: #17a2b8 !important;
        }

        .fadeIn {
            opacity: 0;
            animation: fadeInAnimation 0.5s ease-in-out forwards;
        }

        @keyframes fadeInAnimation {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .fadeOut {
            opacity: 1;
            animation: fadeOutAnimation 0.5s ease-in-out forwards;
        }

        @keyframes fadeOutAnimation {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .texto-peque {
            font-size: 10px !important;
        }
    </style>

    <?php

    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    require_once("../../models/TipoCurso_Edu.php");
    require_once("../../models/Niveles_Edu.php");
    require_once("../../models/Idiomas_Edu.php");

    $idiomas = new Idiomas();
    $datosIdioma = $idiomas->listarIdiomasSelect();
    $cursos = new TipoCurso();
    $datos = $cursos->listarTipoCursoSelect();
    $niveles = new Niveles();
    $datosN = $niveles->listarNivelesSelect();


    ?>
</head>



<body>

    <!--start mainHeader-->
    <?php include("../../config/templates/mainHeader.php"); ?>
    <!--end mainHeader-->


    <!--start sidebar-->
    <?php include("../../config/templates/mainSidebar.php"); ?>
    <!--end sidebar-->

    <!-- **************************************** -->
    <!--                BREADCUM                  -->
    <!-- **************************************** -->
    <!-- <span class="breadcrumb-item active">Mantenimiento</span> -->
    <!-- **************************************** -->
    <!--                FIN DEL BREADCUM                  -->
    <!-- **************************************** -->

    <!-- ***************************************************** -->
    <!--                CABECERA DE LA PAGINA                  -->
    <!-- ***************************************************** -->

    <!--start main content-->
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Mantenimientos</li>
                        <li class="breadcrumb-item" aria-current="page">Rutas</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <!-- <div class="col-12 pageTitle mt-3">
                <div class="row">
                    <div class="col-1 wd-auto-force">
                        <i class="fa-solid fa-triangle-exclamation tx-50-force"></i>
                    </div>
                    <div class="col-10 d-flex align-items-center">
                        <div class="row">
                            <h4 class="col-12 tx-18">AVISOS GERENCIA</h4>
                            <p class="mb-0 col-12 tx-16"></p>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="col-12 card mt-3">
                <div class="card-body">
                    <!-- Header profesional -->
                    <div class="page-header-custom">
                        <h2><i class='bx bx-map me-2'></i>Rutas de Cursos</h2>
                        <p>Configuración de rutas de aprendizaje y secuencias de cursos</p>
                    </div>

                    <div class="row">

                            <div class="row" id="">
                                <div class="col-12">
                                    <div class="card">
                                        
                                        <div class="card-body">
                                             <div class="ml-auto">
                                                        <button class="btn btn-warning waves-effect waves-light tx-white" id="duplicarRutaBoton" onClick="">Duplicar Ruta</button>
                                                    </div>
                                            <h4 class="card-title"></h4>
                                            <div class="repeater-default m-t-30">
                                                <div data-repeater-list="">
                                                    <div data-repeater-item="">
                                                        <form>
                                                            <div class="container">
                                                                <div class="row d-flex justify-content-center align-items-center text-center">
                                                                    <input type="hidden" id="idEditando">
                                                                    <div class="form-group col-md-2">
                                                                        <label for="idioma">Idiomas</label><br>
                                                                        <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR IDIOMA" style="width: 100%; height: 65px !important;" id="selectIdioma">
                                                                            <?php foreach ($datosIdioma as $row) { ?>
                                                                                <option value="<?php echo $row["idIdioma"] ?>"><?php echo $row["descrIdioma"] ?> - <?php echo $row["codIdioma"] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-2">
                                                                        <label for="curso">Tipo de Curso</label><br>
                                                                        <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CURSO" style="width: 100%; height: 65px !important;" id="selectCurso">
                                                                            <?php foreach ($datos as $row) { ?>
                                                                                <option value="<?php echo $row["idTipo"] ?>"><?php echo $row["descrTipo"] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-2">
                                                                        <label for="nivel">Nivel</label><br>
                                                                        <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR NIVEL" style="width: 100%; height: 65px !important;" id="selectNivel">
                                                                            <?php foreach ($datosN as $row) { ?>
                                                                                <option value="<?php echo $row["idNivel"] ?>"><?php echo $row["codNivel"] ?> - <?php echo $row["descrNivel"] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-1 d-flex flex-column align-items-center">
                                                                        <label for="minAlumnos">Min Alumnos</label>
                                                                        <input type="number" value="1" style="width: 80%; height: 35px !important; font-size: 18px; text-align: center;" min="1" max="99"
                                                                            oninput="validarAlumnos()" oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);" id="minAlumnos">
                                                                    </div>
                                                                    <div class="form-group col-md-1 d-flex flex-column align-items-center">
                                                                        <label for="maxAlumnos">Max Alumnos</label>
                                                                        <input type="number" style="width: 80%; height: 35px !important; font-size: 18px; text-align: center;" min="1" max="99"
                                                                            oninput="validarAlumnos()" oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);" id="maxAlumnos">
                                                                    </div>
                                                                    <div class="form-group col-md-1 d-flex flex-column align-items-center">
                                                                        <label for="periodicidad">Periodicidad</label>
                                                                        <input type="number" style="width: 80%; height: 35px !important; font-size: 18px; text-align: center;" min="1" max="99"
                                                                            oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);" id="periodicidad">
                                                                    </div>

                                                                    <div class="form-group col-md-2">
                                                                        <label for="opciones">Medida</label><br>
                                                                        <select class="select2 js-example-responsive" data-placeholder="SELECCIONA MEDIDA" style="width: 100%; height: 65px !important;" id="medida">
                                                                            <option value="">Medida</option>
                                                                            <option value="0">Sin Medida</option>
                                                                            <option value="1">Días</option>
                                                                            <option value="2">Semanas</option>
                                                                            <option value="3">Meses</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-1 d-flex flex-column align-items-center">
                                                                        <label for="peso">Peso</label>
                                                                        <input type="number" min="1" max="99"
                                                                            style="width: 80%; height: 35px !important; font-size: 18px; text-align: center;"
                                                                            id="peso"
                                                                            onblur="" value="1" placeholder="">

                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </form>
                                                        <hr>
                                                    </div>
                                                </div>
                                                
                                                <!-- Contenedor para los botones alineados -->
                                                <div class="d-flex justify-content-between">
                                                    <button class="btn btn-info waves-effect waves-light tx-white" id="agregarContenido" onClick="agregarContenido()">Añadir Ruta</button>

                                                    <button class="btn btn-warning waves-effect waves-light tx-white d-none editCurso" onClick="actualizarCurso()">Editar Ruta</button>

                                                    <button id="botonCancelar" class="btn btn-danger waves-effect waves-light tx-white  d-none editCurso" onClick="cancelarEditar()">Cancelar</button>

                                                    <!-- Botón "Duplicar Ruta" alineado a la derecha -->
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12" id="tablaRutas">
                                <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                <div class="row ">

                                    <div class="table-responsive order-mobile-first">
                                        <?php
                                        $nombreTabla = "rutas_table";
                                        $nombreCampos = ["Id", "Idioma", "Tipo Curso", "Nivel", "Alumnos", "Periodicidad", "Peso", 'Código', "Estado", "Acciones"];
                                        $nombreCamposFooter = ["Id", "Idioma", "Tipo Curso", "Nivel", "Alumnos", "Periodicidad", "Peso", 'Código', "Estado", "Acciones"];

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
            </div>

    </main>
    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalDuplicar.php' ?>

    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
    
    <?php include("../../config/templates/searchModal.php"); ?>
    <?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->


    <script>
        /*  function validateInput(input) {
        let value = input.value;
        if (value && !/^\d+$/.test(value)) {  // Verifica que sea solo un número
            input.value = '';
            toastr.error('Por favor, ingrese un número válido.');
        } else {
            let num = parseInt(value);
            if (num !== 1 && num % 5 !== 0) {  // Permite 1 o múltiplos de 5
            input.value = ''; // Borra el valor
            toastr.error('Por favor, ingresa un múltiplo de 5 o el número 1');
            }
        }
        }
 */
        function validarAlumnos() {
            let minAlumnos = $("#minAlumnos").val();
            let maxAlumnos = $("#maxAlumnos").val();

            // Asegurarse de que los campos no estén vacíos
            if (minAlumnos === "" || maxAlumnos === "") return;

            // Convertir los valores a enteros
            minAlumnos = parseInt(minAlumnos);
            maxAlumnos = parseInt(maxAlumnos);

            if (minAlumnos > maxAlumnos) {
                toastr.error('El número mínimo de alumnos no puede ser mayor que el número máximo de alumnos.', 'Error de Validación');
                $("#minAlumnos").val(maxAlumnos); // Ajustar minAlumnos para que no sea mayor que maxAlumnos
            } else if (maxAlumnos < minAlumnos) {
                toastr.error('El número máximo de alumnos no puede ser menor que el número mínimo de alumnos.', 'Error de Validación');
                $("#maxAlumnos").val(minAlumnos); // Ajustar maxAlumnos para que no sea menor que minAlumnos
            }
        }
    </script>

    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>
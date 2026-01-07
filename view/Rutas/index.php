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

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                    <h2 class="card-title">Rutas de Cursos</h2>
                    <div class="my-3 border-top"></div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card radius-10">
                                <div class="card-body p-0">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                    Mostrar Guía
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-secondary waves-effect tx-12-force col-12 col-lg-1">Posición</button>

                                                    <label class="mg-l-10 col-12 col-lg-10 mg-t-10-force mg-lg-t-0-force"> El campo <b>Peso</b> debe asignarse con números múltiplos de 5 (5, 10, 15…) o con el número 1. Este valor indica el peso de los cursos en la ruta de aprendizaje. Si el primer curso tiene el orden 10, el siguiente deberá ser un número mayor, también múltiplo de 5, como 15 o 20. </label>
                                                </div>
                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-primary btn-icon waves-effect tx-12-force col-12 col-lg-1">Periodicidad</button>
                                                    <label class="mg-l-10 col-12 col-lg-10  mg-t-10-force mg-lg-t-0-force">La periodicidad se define con dos campos: uno para la cantidad numérica y otro para la unidad de tiempo (días, semanas o meses). Al combinarlos, se establece el intervalo de tiempo entre cursos. Por ejemplo, si se asigna una cantidad de 5 y la unidad 'meses', el resultado será '5 meses'.</label>
                                                </div>
                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-info waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-edit"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-10  mg-t-10-force mg-lg-t-0-force"> Con este botón podrás <label class="fw-bold">editar</label> la información de la opción seleccionada.</label>
                                                </div>

                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-success waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-check"></i></button>
                                                    <button class="btn btn-danger waves-effect tx-12-force col-12 col-lg-1 mg-lg-l-10 mg-lg-t-0-force mg-l-0 mg-t-10-force"><i class="fa-solid fa-xmark"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-8  mg-t-10-force mg-lg-t-0-force"> Con estos botones podrás <label class="fw-bold tx-success">activar</label> / <label class="fw-bold tx-danger">desactivar</label> las opciones, <label class="fw-bold tx-success">permitiendo</label> / <label class="fw-bold tx-danger">denegando</label> su <label class="fw-bold">uso en apartados de la aplicación</label>.</label>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-12 d-flex justify-content-end mg-b-10">
                            <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#insertar-contenido-modal">Agregar Nivel</button>
                        </div> -->
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
<?php 
session_start();

?>
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
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
    <link href="../../public/js/libs/raty-js/lib/jquery.raty.css" rel="stylesheet">

    <style>
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }
        .group1 {
            font-size: 12px;
            color: #FFFFF5FE !important;
            background: blue !important;
            opacity: 0.70;
        }
     
    </style>

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
                        <li class="breadcrumb-item" aria-current="page">Alojamientos <i class="lni emoji-speechless display-7 text-muted" title=""></i></li>
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
                    <h2 class="card-title">Alojamientos</h2>



                    
                    <div class="my-3 border-top"></div>

                    <div class="row">
                       
                        
                        
                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg-2 align-items-center d-lg-flex justify-content-lg-end">
                                    <div class="text-center">

                                        <!-- Button trigger -->
                                        <!-- <a id="vinPequeno" href="./newproducto.php"> -->

                                        <a href="datosAlojamiento.php">
                                            <button type="button" class="btn btn-outline-primary mb-lg-0 mb-2 mt-sm-1">
                                                Añadir Alojamiento
                                            </button>
                                        </a>
                                        <!-- <br>
                                        <a href="../../view/MntTipoAloja/" class="btn btn-outline-primary mt-1 mb-lg-0 mb-3">Gestionar Tipo Alojamiento</a> -->
                                    </div>
                                    </div>
                                </div>
                                <div class="table-responsive order-mobile-first">
                                    <?php
                                    $nombreTabla = "aloja_table";
                                    $nombreCampos = ["ID", "Tipo Alojamiento","Identificador", "Nombre", "Dirección", "Capacidad total", "Ocupados", "Valoración","Valoración", "Estado", "Acciones","Alumnos", "Visitas", "Opiniones"];
                                    $nombreCamposFooter = [
                                        "ID",
                                        "Tipo Alojamiento",
                                        "<input type='text' class='form-control' id='identificadorTipo' name='identificadorTipo' placeholder='Buscar Identificador'>",
                                        "<input type='text' class='form-control' id='FootTipo' name='FootTipo' placeholder='Buscar Nombre'>",
                                        "<input type='text' class='form-control' id='FootDireccion' name='FootDireccion' placeholder='Buscar Dirección'>",
                                        "Capacidad total", "Ocupados", "Valoración", "Valoración",  "Estado", "Acciones", "Alumnos", "Visitas", "Opiniones"
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
                        </div>
                    </div>

                </div>
            </div>

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->

    <!--end plugins extra-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
    
    <?php include_once 'modalAgregarOpi.php' ?>

    <?php include_once 'modalAgregarVisita.php' ?>
    <?php include_once 'verPersonasAlojamiento.php' ?>
    
    <?php include("../../config/templates/searchModal.php"); ?>
  


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->


    <script src="../../public/js/libs/raty-js/lib/jquery.raty.js"></script>

    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="alojaIndex.js"></script>
    <!--end plugins extra-->



</body>

</html>
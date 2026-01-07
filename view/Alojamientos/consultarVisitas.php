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
    $id = $_GET["id"];
    if ($id == '') {
        header("Location: index.php");
    }
    require_once("../../models/Alojamientos.php");
    $alojamiento = new Alojamientos();
    $idAloja = $_GET['id'];

    $datos  = $alojamiento->getAlojamiento_x_token($idAloja);
 
    ?>
    <!--end head-->
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">

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
        #seleccionar-alumno-table tbody tr:hover { 
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #seleccionar-alumno-table tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
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
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Listado Alojamientos</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Consultar visitas<i class="lni emoji-speechless display-7 text-muted" title=""></i></li>
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
                  

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                         
            <input type="hidden"id="idVisAloja" value="<?php echo $id ?>">
                <div class="card-body">
                    <!-- <h4 class="card-title">Mantenimiento de categorias - Empresa MAT</h4>
                                            <h6 class="card-subtitle">En este apartado vas a poder gestionar las categorias</h6> <br><br> -->
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="card-body">
                                <h4 class="card-title">Listado de Visitas</h4>
                                <h6 class="card-subtitle">En este apartado vas a poder ver las visitas</h6> <br><br>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card border-left border-success">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                                <div>
                                                    <span class="text-success display-6"><i class="ti-home"></i></span>
                                                </div>
                                                <div class="ml-auto tx-right">
                                                    <a href="../Alojamientos/">
                                                        <h4><?php echo $datos[0]['nombreAloja']." ".$datos[0]['apeAloja']; ?></h4>
                                                    </a>
                                                    <h6 class="text-cyan"><?php echo $datos[0]['descrTiposAloja'] ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- #################################################### -->
                                <!-- ########## INICO BOTON PEQUEÑO y DERECHA ########### -->
                                <!-- #################################################### -->


                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-sm-12 col-md-12 col-lg-2 offset-lg-10"> -->
                    <div class="col-sm-2 col-md-2 col-lg-2 align-items-center d-lg-flex justify-content-lg-end">
                        <div class="text-center">

                            <!-- Button trigger -->
                            <!-- <a id="vinPequeno" href="./newproducto.php"> -->

                            <!-- <a href="/costaValencia/view/Alojamientos/datosAlojamiento.php">
                                    <button type="button" class="btn btn-outline-primary mb-lg-0 mb-3">
                                        Añadir Alojamiento
                                    </button></a> -->
                            <!-- <br>
                                <a href="../../view/MntTipoAloja/" class="btn btn-outline-primary mt-1 mb-lg-0 mb-3">Gestionar Tipo Alojamiento</a> -->
                        </div>
                    </div>
                </div>
                    
                    <!-- ES NECESARIO PARA QUE FUNCIONE EL comunDataTables.js -->
                    <!-- ********************************************************** -->
                    <!-- AÑADIR PARA QUE SEA VISIBLE Y ACTIVADO POR EL JAVASCRIPT  -->
                    <?php include_once '../../config/templates/filtroActivo.php' ?>
                    <!-- ********************************************************** -->
                    <!-- ******************** FIN ********************************* -->
                    <!--  AÑADIR PARA QUE SEA VISIBLE Y ACTIVADO POR EL JAVASCRIPT  -->
                    <!-- ********************************************************** -->
                <div class="table-responsive">
                    <?php
                        $nombreTabla = "visitas_table";
                        $nombreCampos = ["ID", "Visitante", "Fecha de Visita","Observación", "Acción"];
                        $nombreCamposFooter = ["ID", "Visitante", "Fecha de Visita","Observación", "Acción"];

                        $cantidadGrupos = 1; //* CANTIDAD DE AGRUPACIONES *// //=Valores 0 ~ 3==//
                        $columGrupos = []; //* COLUMNAS A AGRUPAR *// //=Poner el numero de la columna empezando a contar desde 0==//
                        $agrupacionesPersonalizadas = 0; //* MARCAR SI QUIERES REALIZAR EL DISEÑO DE LA AGRUPACION MANUAL O AUTOMATICA *// //= 0->Auto 1->Manual ==//
                        $colorHEX = "#3AB54A"; //* COLOR POR DEFECTO DE LAS AGRUPACIONES *// //= Color Hexadecimal #000000 ~ #FFFFFF ==//
                        $desplegado = 0; //* SI QUIERES QUE POR DEFECTO LAS AGRUPACIONES ESTEN PLEGADAS *// //= 0->DESPLEGADO 1->PLEGADO ==//
                        $colorPicker = 0; //* SI QUIERES MOSTRAR EL COLOR PICKER O NO *// //= 0->No 1->Si  ==//

                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                        echo $tablaHTML;
                
                    ?>
                           
                    <a onclick='window.history.back(); return false;'><button type='button' class='btn btn-secondary'>Volver</button></a>
                </div>
            </div>
                    </div>

                </div>
            </div>

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php //include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditarVisita.php' ?>
    <?php //include_once 'modalAlumnos.php' ?>
    <?php //include_once 'editAlumAloja.php' ?>

    <?php include("../../config/templates/searchModal.php"); ?>
  


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <script src="visitas.js"></script>
    <!--end plugins extra-->



</body>

</html>
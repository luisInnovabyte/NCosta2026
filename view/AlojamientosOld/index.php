<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once '../../config/templates/mainHead.php';
    require '../../config/funciones.php';
    require '../../config/conexion.php';

    require_once("../../models/Alojamientos.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    checkAccess(["1"]); 
    ?>
    <!-- CSS DE RATY -->
    <link href="../../public/js/libs/raty-js/lib/jquery.raty.css" rel="stylesheet">
    <!-- CSS DE DROPZONE IMG -->
    <link rel="stylesheet" type="text/css" href="../../public/js/libs/dropzone/dist/min/dropzone.min.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php include_once '../../config/templates/mainPreloader.php' ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->



    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <?php include_once '../../config/templates/mainLogo.php' ?>
                    <!-- ============================================================== -->
                    <!-- FIN Logo -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->

                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ================================================================================ -->
                    <!--PARTE SUPERIOR DESPUES DEL SIDEBAR (TRES LINEAS, CAJA DE REGALO, CAMPANA y SOBRE) -->
                    <!-- ================================================================================ -->
                    <?php include_once '../../config/templates/mainNavbar.php' ?>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include_once '../../config/templates/mainSidebar.php' ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- CABECERA DE LA PAGINA Y TITULO  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- CABECERA-->
                    <!-- ============================================================== -->
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Alojamientos</h4>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>


                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="../../index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Alojamientos</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- FIN DE CABECERA DE LA PAGINA Y TITULO  -->
            <!-- ============================================================== -->



            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <!-- ============================================================== -->
                <!-- CONTENIDO DE LA PÁGINA  -->
                <!-- ============================================================== -->

                <div class="card-body">
                    <!-- <h4 class="card-title">Mantenimiento de categorias - Empresa MAT</h4>
                                            <h6 class="card-subtitle">En este apartado vas a poder gestionar las categorias</h6> <br><br> -->
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="card-body">
                                <h4 class="card-title">Mantenimiento de Alojamientos</h4>
                                <h6 class="card-subtitle">En este apartado vas a poder gestionar los Alojamientos</h6> <br><br>
                                <!-- #################################################### -->
                                <!-- ########## INICO BOTON PEQUEÑO y DERECHA ########### -->
                                <!-- #################################################### -->

                              <!-- ES NECESARIO PARA QUE FUNCIONE EL comunDataTables.js -->
                                <!-- BOTON DE AYUDA QUE NO ESTÄ VISIBLE NUNCA -->
                                <!-- Se llama desde el JS -->
                                <?php include_once '../../config/templates/botonAyuda.php' ?>
                                <!-- AÑADIR BOTON DE AYUDA -->
                                <!-- Card -->
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-lg-1">

                                </div>
                                
                            </div>
                        </div>

                        <!-- <div class="col-sm-12 col-md-12 col-lg-2 offset-lg-10"> -->
                        <div class="col-sm-2 col-md-2 col-lg-2 align-items-center d-lg-flex justify-content-lg-end">
                            <div class="text-center">

                                <!-- Button trigger -->
                                <!-- <a id="vinPequeno" href="./newproducto.php"> -->

                                <a href="datosAlojamiento.php">
                                    <button type="button" class="btn btn-outline-primary mb-lg-0 mb-2 mt-sm-1">
                                        Añadir Alojamiento
                                    </button></a>
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
                    </div>
                    <div class="table-responsive">
                        <?php
                        $nombreTabla = "aloja_table";
                        $nombreCampos = ["ID", "Tipo Alojamiento", "Nombre", "Dirección", "Capacidad total", "Ocupados", "Valoración","Valoración", "Estado", "Acciones","Alumnos", "Visitas", "Opiniones"];
                        $nombreCamposFooter = [
                            "ID",
                            "Tipo Alojamiento",
                            "<input type='text' class='form-control' id='FootTipo' name='FootTipo' placeholder='Buscar Nombre'>",
                            "<input type='text' class='form-control' id='FootDireccion' name='FootDireccion' placeholder='Buscar Dirección'>",
                            "Capacidad total", "Ocupados", "Valoración", "Valoración",  "Estado", "Acciones", "Alumnos", "Visitas", "Opiniones"
                        ];

                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                        echo $tablaHTML;
                        ?>
                       
                    </div>
                </div>
               
                <!-- ============================================================== -->
                <!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->



                
                <!-- ============================================================== -->
                <!-- MODAL INSERTAR   -->
                <!-- ============================================================== -->
                <?php include_once 'modalInsertarOpiniones.php' ?>

                <!-- ============================================================== -->
                <!-- MODAL INSERTAR   -->
                <!-- ============================================================== -->
                <?php include_once 'modalInsertarVisita.php' ?>

                 <!-- ============================================================== -->
                <!-- MODAL AYUDA  -->
                <!-- ============================================================== -->
                <?php include_once '../../config/modalAyudas/modalAyudaAlojamientos.php' ?>

            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <?php include_once '../../config/templates/mainFooter.php' ?>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <div class="chat-windows"></div>


    <?php include_once '../../config/templates/mainJs.php' ?>

    <!-- SCRIPTS PERSONALIZADOS -->

    <!-- ALERTAS  -->
    <script src="../../dist/js/custom.min.js"></script>

    <!-- DropZone IMG -->
    <script src="../../public/js/libs/dropzone/dist/min/dropzone.min.js"></script>

    <script src="../../public/js/libs/raty-js/lib/jquery.raty.js"></script>

    <!-- Llamada de la parte común del datatables -->
    <script src="../../config/templates/comunDataTables.js"></script>
    
    <script src="alojaIndex.js"></script>
    <script src="visitas.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="es">
<?php include '../../config/funciones.php' ?>
<!-- Hace falta por que ahí está la funcion que genera las tablas en HTML -->

<head>
    <?php include_once '../../config/templates/mainHead.php' ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    checkAccess(['0']);
    ?>
    <!-- CSS DE ALERTAS -->
    <!-- CSS DE DROPZONE IMG -->
    <link rel="stylesheet" type="text/css" href="../../public/js/libs/dropzone/dist/min/dropzone.min.css">
    <!-- CSS DE LAS TABLAS ALUMNOS -->
    <link rel="stylesheet" type="text/css" href="../../public/js/libs/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css">


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
                        <h4 class="page-title">Cursos</h4>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>


                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="..\Home">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Cursos</li>
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
                        
                            <div class="row">
                                <div class="col-sm-10 col-md-10 col-lg-10">
                                    <div class="card-body">
                                        <h4 class="card-title">Mis Cursos</h4>
                                        <h6 class="card-subtitle">En esta sección podrás ver los cursos asignados, así como llevar a cabo la asistencia y consultar los objetivos.</h6> <br><br>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12 col-md-12 col-lg-2 offset-lg-10"> -->
                            
                            </div>

                            <!--  CURSO -->
                            
                            <div class="row">
                    
                                <div class="col-12 ">
                                    <div class="table-responsive ">
                                        <?php
                                        $nombreTabla = "cursos_profesor_table";
                                        $nombreCampos = ["Id", "Idioma", "Tipo de Curso",  "Nivel", "Capacidad", "Semana", "Fecha Curso", "Idtf.","Alumnos", "Codígo", "Acción"];
                                        $nombreCamposFooter = [
                                            "Id", "Idioma", "Tipo de Curso",  "Nivel", "Capacidad", "Semana", "Fecha Curso", "Idtf.","Alumnos", "Codígo","Acción"
                                        ];

                                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                                        echo $tablaHTML;
                                        ?>

                                    </div>
                                </div>

                                </div>

                           
                        </div>

                    </div>

                </div>
              
                <!-- ============================================================== -->
                <!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

           

            <!-- ============================================================== -->
            <!-- MODAL AYUDA  -->
            <!-- ============================================================== -->
            <?php include_once '../../config/modalAyudas/modalAyuda.php' ?>

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
    <!-- TouchSpin + - -->
    <script src="../../public/js/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- ALERTAS  -->
    <script src="../../dist/js/custom.min.js"></script>

    <!-- DropZone IMG -->
    <script src="../../public/js/libs/dropzone/dist/min/dropzone.min.js"></script>

    <!-- Llamada de la parte común del datatables -->
    <script src="../../config/templates/comunDataTables.js"></script>
    
    <!-- DUAL LISTBOX -->
    <script src="../../public/js/libs/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="../../public/js/dist/pages/forms/dual-listbox/dual-listbox.js"></script>

    <script src="cursoIndex.js"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="es">
<?php include '../../config/funciones.php' ?>
<!-- Hace falta por que ahí está la funcion que genera las tablas en HTML -->

<head>
    <?php include_once '../../config/templates/mainHead.php' ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    checkAccess(['1']);
    ?>
    <!-- CSS DE ALERTAS -->
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
                        <h4 class="page-title">Titulares de Contenidos</h4>
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
                                    <li class="breadcrumb-item active" aria-current="page">Tit - Contenidos</li>
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
                        <div class="col-sm-10 col-md-10 col-lg-10">
                            <div class="card-body">
                                <h4 class="card-title">Mantenimiento de los titulares de contenidos</h4>
                                <h6 class="card-subtitle">Esta sección está dedicada a la gestión de los distintos titulares de contenidos. Es de acceso exclusivo de los administradores del sistema.</h6> <br><br>

                               
                                <!-- ES NECESARIO PARA QUE FUNCIONE EL comunDataTables.js -->
                                <!-- BOTON DE AYUDA QUE NO ESTÄ VISIBLE NUNCA -->
                                <!-- Se llama desde el JS -->
                                <?php include_once '../../config/templates/botonAyuda.php' ?>
                                <!-- AÑADIR BOTON DE AYUDA -->
                                <!-- Card -->
                            </div>
                        </div>

                                <!-- #################################################### -->
                                <!-- ########## INICO BOTON PEQUEÑO y DERECHA ########### -->
                                <!-- #################################################### -->
                        <!-- <div class="col-sm-12 col-md-12 col-lg-2 offset-lg-10"> -->
                        <div class="col-sm-2 col-md-2 col-lg-2 align-items-center d-lg-flex justify-content-lg-end">
                            <div class="text-center">

                                <!-- Button trigger -->
                                <!-- <a id="vinPequeno" href="./newproducto.php"> -->
                                <button type="button" class="btn btn-outline-primary mb-lg-0 mb-3" data-toggle="modal" data-target="#insertar-contenido-modal">
                                    Añadir titular
                                </button>
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
                    </div> <!-- del row -->                
                <!-- CREACION DE LA TABLA  -->
                <!-- SE CREA CON UNA FUNCION QUE ESTA EN CONFIG/funciones.php (generarTabla)  -->
                <!-- Se le pasa el 1er. Parametro = Nombre de la tabla (El id de la tabla)  -->
                <!-- Se le pasa el 2o. Parametro = Es una matriz con los nombres de la columnas de cabeceras  -->
                <!-- Se le pasa el 3o. Parametro = Es una matriz con los nombres de la columnas de pies  -->
                <div class="row">
                    <div class="col-4">

                        <!-- TEXTO PREVIO -->
                        <p class="tx-14">&nbsp;</p>
                        <p>&nbsp;
                        </p>
                        <!-- FIN DEL TEXTO PREVIO -->
                        <div id="addRow" class="col-12 mg-sm-b-15 bd-3 pd-t-80 pd-b-80">

                            <div class="row">
                                <div class="col-12 col-lg-7 mg-sm-b-10">

                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <label class="ckbox ckbox-success wd-16 mg-b-0">
                                                </label>
                                            </div>
                                        </div>

                                        <input type="text" id="titCont" name="titCont" class="form-control" placeholder="Escriba un titular">
                                    </div><!-- input-group -->
                                </div><!-- input-group -->
                                <div class="col-12 col-lg-4 ">
                                    <button onclick=agregarTitContenido() id="newConceptos" class="btn btn-primary col-lg-8 col-sm-12">Añadir</button>
                                </div>
                            </div>
                            
                        </div>
                    <!-- Editar -->
                        <div class="d-none bd-3 pd-t-80 pd-b-80" id="updateRow">
                            <input type="hidden" id="idConceptos" class="form-control" placeholder="">
                            <div class="row">
                                <div class="input-group col-lg-6 tx-center mg-b-10">
                                    <div class="input-group" id="inputEditar">
                                        <!-- <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon ion-edit tx-16 lh-0 op-6"></i></span>
                                        </div> -->
                                        <input type="text" class="form-control" id="text-editar" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <input type="hidden" id="idTit">
                                    <button onclick=insertarEditar() class="btn btn-success col-lg-5 col-sm-12 mg-b-10">Editar</button>
                                    <button onclick=ocultarEditar() class="btn btn-danger col-lg-5  col-sm-12 mg-b-10">Cancelar</button>
                                </div>

                            </div>
                            <!--del ROW -->
                        </div> <!-- de la COLUMNA -->
                    </div>
                    <div class="table-responsive col-8">
                        <?php
                        $nombreTabla = "contenido_table";
                        $nombreCampos = ["idTitular","Descripcion","Observaciones","Estado","Acciones"];
                        $nombreCamposFooter = ["idTitular","Descripcion","Observaciones","Estado","Acciones"];

                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                        echo $tablaHTML;
                        ?>

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
            <!-- MODAL INSERTAR   -->
            <!-- ============================================================== -->
            <?php include_once 'modalInsertar.php' ?>

            <!-- ============================================================== -->
            <!-- MODAL EDITAR   -->
            <!-- ============================================================== -->
            <?php include_once 'modalEditar.php' ?>

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

    <script src="contenidoIndex.js"></script>

</body>

</html>
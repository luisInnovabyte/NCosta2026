<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once '../../config/templates/mainHead.php';
    require '../../config/funciones.php';
    require '../../config/conexion.php';
    require_once("../../models/Alojamientos.php");

    $id = $_GET["id"];
    if ($id == '') {
        header("Location: index.php");
    }

    $alojamiento = new Alojamientos();
    $datos = $alojamiento->getAlojamiento_x_id($id);


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
                        <h4 class="page-title">Visitas</h4>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>


                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Alojamientos</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Visitas</li>
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
                                <h4 class="card-title">Mantenimiento de visitas</h4>
                                <h6 class="card-subtitle">En este apartado vas a poder gestionar las visitas</h6> <br><br>
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
                    <input type="hidden" id="idVisAloja" value="<?php echo $_GET["id"]?>">
                <div class="table-responsive">
                    <?php
                    $nombreTabla = "visitas_table";
                    $nombreCampos = ["ID", "Visitante", "Fecha visita", "Observación", "Acción"];
                    $nombreCamposFooter = [
                        "ID",
                        "<input type='text' class='form-control' id='Visitante' name='Visitante' placeholder='Buscar Visitante'>",
                        "Fecha visita", "Observación", "Acción"
                    ];

                    $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                    echo $tablaHTML;
                    ?>
                    <a onclick="window.history.back(); return false;"><button type="button" class="btn btn-secondary">Volver</button></a>
                </div>

                <!-- ============================================================== -->
                <!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->

                <!-- MODAL EDICION NIVEL -->
                <div id="editar-visitas-modal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Editar Visita</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">

                                <form id="editar-visitas-form">
                                    <div class="row">
                                        <div class="form-group col-12 col-lg-6">
                                            <input type="hidden" id="idVis" name="idVis">
                                            <label for="recipient-name" class="control-label">Visitante:</label>
                                            <input type="text" class="form-control" id="quienAlojaVis" name="quienAlojaVis" minlength="2" maxlength="70" required>
                                            <div class="row">
                                                <span id="infoquienAlojaVis" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo letras</span>
                                                <span id="lonquienAlojaVis" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="recipient-name" class="control-label">Fecha de visita:</label>
                                            <input type="date" class="form-control" id="fechaAlojaVis" name="fechaAlojaVis" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Observaciones:</label>
                                        <textarea id="descrImpreAloja" name="descrImpreAloja"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-success waves-effect waves-light" id="guardar-btn">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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

<!-- Llamada de la parte común del datatables -->
<script src="../../config/templates/comunDataTables.js"></script>

    <script src="visitas.js"></script>

</body>

</html>
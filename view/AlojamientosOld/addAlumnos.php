<!DOCTYPE html>
<html lang="es">

<head>
    <!-- dropzone -->
    <link rel="stylesheet" type="text/css" href="../../public/js/libs/dropzone/dist/min/dropzone.min.css">
    <?php include_once '../../config/templates/mainHead.php' ?>
    
    <?php
    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");

    require_once("../../models/Alojamientos.php");
    $alojamiento = new Alojamientos();
    $idAloja = $_GET['idAloja'];

    $datos = $alojamiento->listarAlumnosAlojaxId($idAloja);

    $data = $alojamiento->getAlojamiento_x_id($idAloja);

    ?>
    <style>
        /* OCULTAR BARRA DE CARGA DROPZONE */
        .dz-progress {
            display: none !important;
        }
    </style>
    <?php
   
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR

    checkAccess(['1']);

    ?>
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


        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- CABECERA-->
                    <!-- ============================================================== -->
                    <div class="col-5 align-self-center">
                        <h4 id="page-title" class="page-title"></h4>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>


                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Listado Alojamientos</a>
                                    </li>
                                    <li id="current-page" class="breadcrumb-item active" aria-current="page">Añadir Allumno</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- FIN DE CABECERA DE LA PAGINA Y TITULO  -->
            <!-- ============================================================== -->
            <!-- RECOGEMOS LA VARIABLE IDCLIENTE -->

            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ***************************************************** -->
                <!--            END CABECERA DE LA PAGINA                  -->
                <!-- ***************************************************** -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <!-- **************************************** -->
                            <!--             CONTENIDO PRINCIPAL          -->
                            <!-- **************************************** -->


                            <div class="col-lg-12 ">
                                <div class="form-layout form-layout-4 ">
                                    <!-- DIV CASA -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card border-left border-success">
                                            <div class="card-body">
                                                <div class="d-flex no-block align-items-center">
                                                    <div>
                                                        <span class="text-success display-6"><i class="ti-home"></i></span>
                                                    </div>
                                                    <div class="ml-auto tx-right">
                                                        <a href="../Alojamientos/">
                                                            <h4><?php echo $datos[0]['nombreAloja']; ?></h4>
                                                        </a>
                                                        <h6 class="text-cyan"><?php echo $data[0]['descrTiposAloja'] ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- AVISO DE USUARIO CON ALOJAMIENTO -->
                                    <div id="usuariosAlojamientos">

                                    </div>

                                    <h5 class="br-section-label" id="current-title">Añadir Alumno</h5><br>
                                    <br>
                                    <br>

                                    <form method="POST" id="newAlumn_form">
                                        <!-- row -->
                                        <input type="hidden" id="idAloja" name="idAloja" value="<?php echo $_GET["idAloja"] ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-3">
                                                <button type="button" class="btn btn-outline-primary mb-lg-0 mb-3" data-toggle="modal" data-target="#seleccionar-alumno-modal">
                                                    Seleccionar Alumno
                                                </button>
                                            </div>
                                            <div class="col-12 col-lg-3 mg-b-10" >
                                                <label class="col-sm-12 col-md-12 col-lg-12 form-control-label">Alumno: <span class="tx-danger">*</span></label>
                                                <input type="hidden" name="idAlumno" id="idAlumno">
                                                <div class='d-none custom-border' id='borde'>
                                                    <span class="tx-normal d-none" id="etiquetaNombre">Nombre: </span><p id="nombreAlumno" class="tx-bold tx-success"></p>
                                                    <span class="tx-normal d-none" id="etiquetaEmail">Email: </span><p id="emailAlumno" class="tx-bold"></p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de muestra: <span class="tx-danger">*</span></label>
                                                <input type="date" class="form-control" id="fechaMuestra" name="fechaMuestra" placeholder="Seleccione una fecha" required/>
                                                <div class="row">
                                                    <span id="infoFechaMuestra2" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                    <span id="infoFechaMuestra" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Introduzca una fecha anterior a la de Entrada</span>
                                                    <span id="infoFechaMuestra3" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Se mostrará automáticamente el alumno en el alojamiento en la fecha introducida</span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <!-- row -->


                                        <div class="row">
                                            <div class="col-12 col-lg-3 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de entrada: <span class="tx-danger">*</span></label>

                                                <input type="date" class="form-control" id="fecEntradaAlumAloja" name="fecEntradaAlumAloja" placeholder="Seleccione una fecha" required/>

                                                <div class="row">
                                                    <span id="infoFecActDesde" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                </div>

                                            </div>
                                            <br>
                                            <!-- row -->
                                            <div class="col-12 col-lg-3 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de salida: <span class="tx-danger">*</span></label>

                                                <input type="date" class="form-control" id="fecSalidaAlumAloja" name="fecSalidaAlumAloja" placeholder="Seleccione una fecha" required/>

                                                <div class="row">
                                                    <span id="infoFecActHasta" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                </div>

                                            </div>
                                            <div class="col-12 col-lg-3 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Hora de salida: <span class="tx-danger">*</span></label>

                                                <input type="time" class="form-control" id="horaSalidaAlumAloja" name="horaSalidaAlumAloja" />

                                            </div><!-- row -->
                                        </div>
                                        <!-- row -->
                                        <br>

                                        <div class="row">
                                            <input type="checkbox" class="col-1" id="estado" name="estado" style="float: left; margin-right: 10px;">
                                            <label class="col-sm-12 col-md-12 col-lg-2 form-control-label" style="margin-top: 6px;">¿Mostrar alojamiento al alumno?</label>
                                        </div>

                                        <!-- row -->
                                        <br>
                                        <!-- row Desplegable-->

                                        <div class=" form-layout-footer mg-t-30 pd-t-20 ">
                                            <!-- <button type="button" id="cancelar" class="btn btn-dark mg-sm-t-10">Volver</button> -->
                                            <a href="index.php" class="btn btn-dark mg-sm-t-10">Volver</a>
                                            <button type="submit" name="action" id="botonGuardar" value="add" class="btn btn-success mg-sm-t-10">Guardar</button>

                                        </div><!-- form-layout-footer -->
                                        <!-- form-layout-footer -->
                                    </form>
                                </div><!-- form-layout -->
                            </div>
                        </div>
                    </div><!-- br-section-wrapper -->
                </div>
            </div>

            <!-- MODAL DATATABLE SELECCIONAR ALUMNO -->
            <div id="seleccionar-alumno-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Seleccionar Alumno </h4>
                            <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#insertar-tipocurso-modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">

                    
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
                        $nombreTabla = "seleccionar-alumno-table";
                        $nombreCampos = ["ID Usuario", "Nombre", "Correo", "Teléfono"];
                        $nombreCamposFooter = [
                            "ID Usuario",
                            "<input type='text' class='form-control' id='Nombre' name='Nombre' placeholder='Buscar Idioma'>",
                            "<input type='text' class='form-control' id='Correo' name='Correo' placeholder='Buscar Curso'>",
                            "<input type='text' class='form-control' id='Telefono' name='Telefono' placeholder='Buscar Telefono'>",
                        ];

                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                        echo $tablaHTML;
                        ?>
                       
                    </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" data-toggle="modal" data-target="#insertar-tipocurso-modal">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
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

<!-- Llamada de la parte común del datatables -->
<script src="../../config/templates/comunDataTables.js"></script>


    <script src="addAlumnos.js"></script>


</body>

</html>
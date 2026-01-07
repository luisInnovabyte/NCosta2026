<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once '../../config/templates/mainHead.php';
    require '../../config/funciones.php';
    require '../../config/conexion.php';

    require_once("../../models/Alojamientos.php"); 
    
    $alojamiento = new Alojamientos();
    $datos = $alojamiento->getAlojamiento_x_id($_GET['idAloja']);
    
    ?>
    
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
                        <h4 class="page-title">Alumnos</h4>
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
                                    <li class="breadcrumb-item active" aria-current="page">Consultar Alumnos</li>
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
                                <h4 class="card-title">Listado de Alumnos Inscritos</h4>
                                <h6 class="card-subtitle">En este apartado vas a poder gestionar los alumnos del alojamiento</h6> <br><br>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card border-left border-success">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                                <div>
                                                    <span class="text-success display-6"><i class="ti-home"></i></span>
                                                </div>
                                                <div class="ml-auto tx-right">
                                                    <a href="../Alojamientos/"><h4><?php echo $datos[0]['nombreAloja']. " ".$datos[0]['apeAloja'];?></h4></a>
                                                    <h6 class="text-cyan"><?php echo $datos[0]['descrTiposAloja'] ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- ES NECESARIO PARA QUE FUNCIONE EL comunDataTables.js -->
                                <!-- BOTON DE AYUDA QUE NO ESTÄ VISIBLE NUNCA -->
                                <!-- Se llama desde el JS -->
                                <?php include_once '../../config/templates/botonAyuda.php' ?>
                                <!-- AÑADIR BOTON DE AYUDA -->
                                <!-- Card -->
                                <!-- DIV CASA -->
                                <!-- #################################################### -->
                                <!-- ########## INICO BOTON PEQUEÑO y DERECHA ########### -->
                                <!-- #################################################### -->
                                
                            </div>
                            
                            <!-- <div class="col-sm-12 col-md-12 col-lg-2 offset-lg-10"> -->
                                <div class="col-sm-2 col-md-2 col-lg-2 align-items-center d-lg-flex justify-content-lg-end">
                                <div class="text-center">
                                <!-- ES NECESARIO PARA QUE FUNCIONE EL comunDataTables.js -->
                                <!-- ********************************************************** -->
                                <!-- AÑADIR PARA QUE SEA VISIBLE Y ACTIVADO POR EL JAVASCRIPT  -->
                                <?php include_once '../../config/templates/filtroActivo.php' ?>
                                <!-- ********************************************************** -->
                                <!-- ******************** FIN ********************************* -->
                                <!--  AÑADIR PARA QUE SEA VISIBLE Y ACTIVADO POR EL JAVASCRIPT  -->
                                <!-- ********************************************************** -->
                                    
                                 
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                             <input type="hidden" id="idAlumn" name="idAlumn" value="<?php echo $_GET['idAloja'] ?>">

                            <?php
                            
                            $nombreTabla = "alumn_table";
                            $nombreCampos = ["ID", "Nombre","Correo","Telefono", "Fecha Entrada", "Fecha Salida", "Fecha de visualización", "Estado", "Historial", "Albarán", "Acción"];
                            $nombreCamposFooter = [
                                "ID",
                                "<input type='text' class='form-control' id='Nombre' name='Nombre' placeholder='Buscar Nombre'>",
                                "<input type='text' class='form-control' id='Correo' name='Correo' placeholder='Buscar Correo'>",
                                "<input type='text' class='form-control' id='Telefono' name='Telefono' placeholder='Buscar Telefono'>",
                                 "Fecha Entrada", "Fecha Salida", "Fecha de visualización", "Estado", "Historial", "Albarán", "Acción"
                            ];

                            $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                            echo $tablaHTML;
                            ?>
                           
                            <a href="index.php" class="btn btn-dark mg-sm-t-10">Volver</a>
                        </div>
                    </div>
                    <div id="editar-ficha-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Información Alumno</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                                </div>
                                <div class="modal-body">
                                    <form id="editar-ficha-form" method="POST">
                                        <div class="row">
                                            <div class="form-group col-12 col-lg-6">
                                                <input type="hidden" id="idAlumAloja" name="idAlumAloja" value="">
                                                <label for="recipient-name" class="control-label">Nombre:</label>
                                                <select class='form-control custom-select tx-break' id="nombreOpi" name="nombreOpi" style="width: 100%; height:36px;" disabled>
                                                    <option value="0">SELECCIONE UN ALUMNO</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-lg-6 ">
                                                <label for="recipient-name" class="control-label">Fecha de muestra:</label>
                                                <input type="date" class="form-control" id="fechamuestra" name="fechamuestra" value="" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-12 col-lg-6 ">
                                                <label for="recipient-name" class="control-label">Fecha de entrada:</label>
                                                <input type="date" class="form-control" id="fechaentrada" name="fechaentrada" value="" required>
                                            </div>
                                            <div class="form-group col-12 col-lg-6">
                                                <label for="recipient-name" class="control-label">Fecha de salida:</label>
                                                <input type="date" class="form-control" id="fechasalida" name="fechasalida" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <input type="checkbox" id="estado" name="estado">
                                                </div>
                                                <div class="col-auto">
                                                    <label class="form-control-label" style="margin-bottom: 3px !important;">¿Mostrar alojamiento al alumno?</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="consult_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 id="tituloModal" class="modal-title"></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>

                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table id="consult_table" class="table table-striped table-bordered">
                                            <input type="hidden" id="idAlumnAloja" name="idAlumnAloja" value="<?php echo $_GET['idAlumnAloja'] ?>">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Fecha Entrada</th>
                                                    <th>Fecha Salida</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    
                                    </div>

                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- End Container fluid  -->
                    <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- MODAL AYUDA  -->
                <!-- ============================================================== -->
                <?php include_once '../../config/modalAyudas/modalAyuda.php' ?>

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

    <!-- Llamada de la parte común del datatables -->
    <script src="../../config/templates/comunDataTables.js"></script>

    <script src="consultarAlumnos.js"></script>
</body>

</html>
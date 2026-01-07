<!DOCTYPE html>
<html lang="es">

<head>
    <!-- dropzone -->
    <link rel="stylesheet" type="text/css" href="../../public/js/libs/dropzone/dist/min/dropzone.min.css">
    <?php include_once '../../config/templates/mainHead.php' ?>
    <?php


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
                                        <a href="index.php">Gestionar Actividades</a>
                                    </li>
                                    <li id="current-page" class="breadcrumb-item active" aria-current="page">Crear Actividad</li>
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
                                                    <h5 class="br-section-label" id="current-title">Crear actividad</h5>
                                                    <br>
                                                    <br>

                                                    <form method="POST" id="newActividad_form">
                                                        <!-- row -->
                                                        <div class="row">
                                                            <div class="col-6 mg-b-10">
                                                                <!-- ID -->
                                                                <input type="hidden" name="idAct" id="idAct" value="<?php echo $_GET['idAct'] ?>">
                                                                <!-- IMAGEN -->
                                                                <input type="hidden" name="imgAct" id="imgAct">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Nombre: <span class="tx-danger">*</span></label>
                                                                <input type="text" class="form-control" id="descrAct" name="descrAct" minlength="2" maxlength="100" placeholder="Título de la actividad" required/>

                                                                <div class="row">
                                                                    <span id="infoDescrAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 100 caracteres</span>
                                                                </div>


                                                            </div><!-- row -->
                                                            <div class="col-6 mg-b-10">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha límite de inscripción: <span class="tx-danger">*</span></label>

                                                                <input type="date" class="form-control" id="fecActFinSolicitud" name="fecActFinSolicitud" placeholder="Seleccione una fecha" required/>

                                                                <div class="row">
                                                                    <span id="infoFecActFinSolicitud" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6 mg-b-10">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de inicio actividad: <span class="tx-danger">*</span></label>

                                                                <input type="date" class="form-control" id="fecActDesde" name="fecActDesde" placeholder="Seleccione una fecha" required/>

                                                                <div class="row">
                                                                    <span id="infoFecActDesde" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                                </div>

                                                            </div>
                                                            <br>
                                                            <!-- row -->
                                                            <div class="col-6 mg-b-10">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de fin actividad: <span class="tx-danger"></span></label>

                                                                <input type="date" class="form-control" id="fecActHasta" name="fecActHasta" placeholder="Seleccione una fecha" />

                                                                <div class="row">
                                                                    <span id="infoFecActHasta" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- row -->

                                                        <br>

                                                        <!-- row Desplegable-->
                                                        <div class="row">

                                                            <div class="col-6 mg-b-10">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Hora inicio actividad: <span class="tx-danger">*</span></label>

                                                                <input type="time" class="form-control" id="horaInicioAct" name="horaInicioAct" onClick="this.select()" required/>

                                                                <div class="row">
                                                                    <span id="infoHoraInicioAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Horas:Minutos</span>
                                                                </div>


                                                            </div><!-- row -->
                                                            <br>
                                                            <div class="col-6 mg-b-10">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Hora fin actividad: </label>

                                                                <input type="time" class="form-control" id="horaFinAct" name="horaFinAct" onClick="this.select()"/>

                                                                <div class="row">
                                                                    <span id="infoHoraFinAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Horas:Minutos</span>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-6 mg-b-10">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Horas lectivas previstas: <span class="tx-danger"></span></label>
                                                                <input type="number" class="form-control" id="horasLectivasAct" name="horasLectivasAct" min=1 max=300/>

                                                                <div class="row">
                                                                    <span id="infoHorasLectivasAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 11 caracteres numéricos</span>
                                                                </div>

                                                            </div><!-- row -->
                                                            <br>
                                                            <div class="col-6 mg-b-10">
                                                                <label class="col-sm-12 col-md-12 form-control-label">Punto de encuentro: <span class="tx-danger">*</span></label>
                                                                <input type="text" class="form-control" id="puntoEncuentroAct" name="puntoEncuentroAct" minlength="2" maxlength="105" required />

                                                                <div class="row">
                                                                    <span id="infoPuntoEncuentroAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 105 caracteres</span>
                                                                </div>
                                                        </div>
                                                        
                                                        </div><!-- row -->

                                                        <br>
                                                        <div class="row mg-b-10">
                                                            <div class="row col-6">
                                                                <div class="form-group col-6 ">
                                                                    <label for="recipient-name" class="control-label">Min. Alumnos:</label>
                                                                    <input type="text" name="minAlumTipo" value="1" class="form-control" id="minAlumTipo" min=1 required>
                                                                    <span id="infoMinAlumTipo" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">(Min - 1 y Max - 999)</span>
                                                                </div>
                                                                <div class="form-group col-6 ">
                                                                    <label for="recipient-name" class="control-labelcol">Max. Alumnos:</label>
                                                                    <input type="text" name="maxAlumTipo" value="1" class="form-control" id="maxAlumTipo" min=1 required>
                                                                    <span id="infoMaxAlumTipo" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">(Min - 1 y Max - 999) </span>
                                                                </div>
                                                            </div>

                                                            <div class="row col-6">
                                                                <div class="col-sm-12 col-md-12 col-lg-10 mg-t-10 mg-sm-t-0">
                                                                <label class="col-sm-12 col-md-12 col-lg-2 form-control-label">Guía: <span class="tx-danger">*</span></label>

                                                                    <select class='form-control custom-select tx-break' id="idPersonal_guiaAct" name="idPersonal_guiaAct" style="width: 100%; height:36px;" required>
                                                                        <option value="0">SELECCIONE UN GUÍA</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                        </div><!-- row -->
                                                        <br>
                                                        <div class="row mg-b-10">
                                                            <label for="recipient-name" class="col-sm-12 col-md-12 col-lg-12 form-control-label">Descripción de la actividad:</label>
                                                            <div class="col-sm-12 col-md-12 col-lg-12 mg-t-10 mg-sm-t-0">
                                                                <textarea id="obsAct" name="obsAct"></textarea>
                                                            </div>
                                                            <div class="row">
                                                                <span id="infoObsAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500"></span>
                                                            </div>
                                                        </div><!-- row -->
                                                        <!-- Inicio del dropzone -->

                                                        <!-- Fin del dropzone -->
                                                        <!-- <div class="sig sigWrapper"> -->
                                                        <label for="recipient-name" class="control-label">Imagen de cabecera:</label>
                                                        <br>
                                                            <img src="" id="imgCabecera" class='d-none wd-100p ' height="300">
                                                            <div action="#" class="dropzone" id="my-great-dropzone">
                                                                <div class="fallback">
                                                                    <input id="file" name="file" type="file" multiple />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                    <span id="infoImgCabecera" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 2 MB</span>
                                                            </div>
                                                        <div class=" form-layout-footer mg-t-30 pd-t-20 ">
                                                            <!-- <button type="button" id="cancelar" class="btn btn-dark mg-sm-t-10">Volver</button> -->
                                                            <button type="submit" name="action" id="botonGuardar" value="add" class="btn btn-success mg-sm-t-10">Guardar</button>
                                                            <button type="button" name="botonCambiarImg" id="botonCambiarImg" class="btn btn-warning mg-sm-t-10 d-none" onclick="showDropzone()">Cambiar Cabecera</button>
                                                            <button type="button" name="desactivarActividad" id="desactivarActividad" class="btn btn-danger mg-sm-t-10 d-none" onclick="desactivar(<?php echo $_GET['idAct'] ?>)">Desactivar</button>
                                                            <button type="button" name="activarActividad" id="activarActividad" class="btn btn-success mg-sm-t-10 d-none" onclick="activar(<?php echo $_GET['idAct'] ?>)">Activar</button>
                                                            <a href="index.php" class="btn btn-dark mg-sm-t-10">Volver</a>

                                                        </div><!-- form-layout-footer -->
                                                        <!-- form-layout-footer -->
                                                    </form>
                                                </div><!-- form-layout -->
                                            </div>
                                    <!-- **************************************** -->
                                    <!-- **************************************** -->
                                    <!-- **************************************** -->
                                    
                                </div>
                            </div><!-- br-section-wrapper -->
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


    <?php include_once '../../config/templates/mainJs.php';?>

    <!-- SCRIPTS PERSONALIZADOS -->

    <!-- ALERTAS  -->
    <script src="../../dist/js/custom.min.js"></script>
    <!-- TouchSpin + - -->
    <script src="../../public/js/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- time -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- DropZone IMG -->
    <script src="../../public/js/libs/dropzone/dist/min/dropzone.min.js"></script>

    <script src="gestionarActividad.js"></script>







</body>

</html>
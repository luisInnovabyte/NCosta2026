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

    require_once("../../models/Alojamientos.php");
    $alojamiento = new Alojamientos();
    $idAloja = $_GET['idAloja'];


    $data = $alojamiento->getAlojamiento_x_token($idAloja);

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
                        <li class="breadcrumb-item" aria-current="page">Añadir Alumno <i class="lni emoji-speechless display-7 text-muted" title=""></i></li>
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
                    <h2 class="card-title">Añadir Alumno</h2>



                    
                    <div class="my-3 border-top"></div>

                    <div class="row">
                       
                        
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
                                                        <h6 class="text-cyan"><?php echo $data[0]['nombreAloja'] ?></h6>
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
                                        <input type="hidden" id="idAloja" name="idAloja" value="<?php echo $data[0]['idAloja'] ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-3">
                                                <button type="button" class="btn btn-outline-primary mb-lg-0 mb-3" onclick="cargarModalAlumnos()">
                                                    Seleccionar Alumno
                                                </button>
                                            </div>
                                            <div class="col-12 col-lg-3 mg-b-10" >
                                                <label class="col-sm-12 col-md-12 col-lg-12 form-control-label">Alumno: <span class="tx-danger">*</span></label>
                                                <input type="hidden" name="idAlumno" id="idAlumno">
                                                <div class='d-none custom-border' id='borde'>
                                                    <span class="tx-normal d-none" id="etiquetaNombre">Nombre: </span><p id="nombreAlumno" class="tx-bold tx-success"></p>
                                                    <span class="tx-normal d-none" id="etiquetaEmail">Tarifa Alojamiento: </span><p id="tipotarifaAlumno" class="tx-bold"></p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de muestra: <span class="tx-danger">* </span></label>
                                                <input type="date" class="form-control" id="fechaMuestra" name="fechaMuestra" placeholder="Seleccione una fecha" required/>
                                                <div class="row">
                                                    <span id="infoFechaMuestra2" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Se mostrará 2 días antes al cargar. Formato Día/Mes/Año</span>
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

                </div>
            </div>

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalAlumnos.php' ?>

    <?php include("../../config/templates/searchModal.php"); ?>
  


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <script src="addAlumnos.js"></script>
    <!--end plugins extra-->



</body>

</html>
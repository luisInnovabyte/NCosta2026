<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
      session_start();
      $rolUsuario =  $_SESSION['usu_rol'];
   
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1','2']);
    // ROL USUARIO

    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    
    require_once("../../models/Actividades_Edu.php");
   
    $idActividad = $_GET['idAct'];

    $actividad = new Actividades();
  
    $datosActividad =  $actividad->getActividad_x_id($idActividad);
    $guia = $datosActividad[0]['idPersonal_guiaAct'];
    //$departametosActivos = $datosActividad[0]['departamentoDisponible'];
    // CAMBIADO A IDS DEPARTAMENTOS, QUE ES EL CAMPO DINÁMICO QUE AHORA SE VA A UTILIZAR
    $departametosActivos = $datosActividad[0]['idsDepartamentos'];

    $clase_estado = match ($datosActividad[0]['estadoAct']) {
        1 => 'tx-success',  // Activa
        0 => 'tx-danger',   // Inactiva
        2 => 'tx-warning',  // Cancelada
        3 => 'tx-info',     // Fin de Inscripción
        default => 'tx-secondary' // En caso de algún valor inesperado
    };
    ?>
    
    <!--end head-->
    <style>
/* ========================================== */
/*     FORMATO MAESTRO COSTA DE VALENCIA     */
/* ========================================== */

.page-header-custom {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
}
.page-header-custom h2 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
}
.page-header-custom p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 0.9rem;
}
.nav-tabs-custom .nav-link {
    border: none;
    color: #6c757d;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
    transition: all 0.2s ease;
}
.nav-tabs-custom .nav-link:hover {
    color: #1AA3E8;
    background-color: rgba(26, 163, 232, 0.1);
}
.nav-tabs-custom .nav-link.active {
    color: #fff;
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
}
.btn-add-record {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    color: white;
}
.btn-add-record:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 163, 232, 0.4);
}

/* ========================================== */
/*     ESTILOS PERSONALIZADOS                */
/* ========================================== */
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }

        .alumno-inscrito {
            background-color:rgb(218, 7, 7) !important;
            }

        .disabled-row {
            opacity: 0.4;
        }

    </style>
</head>



<body>
    <input type="hidden" id="depasActividad" value="<?php echo $idActividad; ?>">
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
    <input type="hidden" id="rolUsuario" value="<?php echo $rolUsuario ?>">

    <!--start main content-->
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Lista de Alumnos</li>
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

            <div class="col-12 card mt-3">
                <div class="card-body">
                    <!-- Header profesional -->
                    <div class="page-header-custom">
                        <h2><i class='bx bx-user-plus me-2'></i>Gestión Lista de Alumnos</h2>
                        <p>Administrar alumnos inscritos en actividades</p>
                    </div>
                    <input type="hidden" id="idActividad" value="<?php echo $_GET['idAct'] ?>">

                    <div class="row">
                    <div class="card-body">
                                <h4 class="card-title">Actividad:
                                    <b class="<?= $clase_estado ?>"><?= $datosActividad[0]['descrAct'] ?></b>
                                </h4>

                                <h6 class="card-subtitle">En este apartado vas a poder gestionar los alumnos de la actividad.</h6> <br><br>


                                <!-- ES NECESARIO PARA QUE FUNCIONE EL comunDataTables.js -->
                                <!-- BOTON DE AYUDA QUE NO ESTÄ VISIBLE NUNCA -->
                                <!-- Se llama desde el JS -->
                                <?php include_once '../../config/templates/botonAyuda.php' ?>
                                <!-- AÑADIR BOTON DE AYUDA -->
                                <!-- Card -->


                                <!-- #################################################### -->
                                <!-- ########## INICO BOTON PEQUEÑO y DERECHA ########### -->
                                <!-- #################################################### -->


                            </div>
                        </div>
                        
                        <?php if($guia ==  $_SESSION['usuPre_idInscripcion'] ||  $_SESSION['usu_rol'] == 1){?>
                            <div class="col-12 d-flex justify-content-end mb-3">
                                <?php
                                $estado = $datosActividad[0]['estadoAct'];

                                if ($estado == '1' || $estado == '3') { ?>
                                    <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#insertar-alumno-modal">
                                        <i class="bx bx-plus me-1"></i>Añadir Alumno
                                    </button>
                                <?php } else if ($estado == '2') { ?>
                                    <button class="btn btn-warning waves-effect tx-white col-12 col-lg-3 tx-center text-center">CANCELADA</button>

                                <?php } else if ($estado == '0') { ?>
                                    <button class="btn btn-danger waves-effect col-12 col-lg-3">NO ACTIVA</button>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">
                    <!-- ################################# -->
                    <!-- ########## ADMINISTRADOR ######### -->
                    <!-- ################################# -->
                              
                                <!-- ################################# -->
                                <!-- ############ PROFESOR ########### -->
                                <!-- ################################# -->
                                <div id=""  class="table-responsive order-mobile-first">
                                    <?php
                                    $nombreTabla = "alumno_table";
                                    $nombreCampos = ["ID", "Nombre", "Fecha Alta", "Edad", "Dar de Baja", "Asistencia"];
                                    $nombreCamposFooter = ["ID", "Nombre", "Fecha Alta", "Edad", "Dar de Baja", "Asistencia"];

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
                        <a onclick="window.history.back(); return false;"><button type="button" class="btn btn-secondary">Volver</button></a>
                    </div>
                </div>
            </div>

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalInsertarAlumnos.php' ?>


    <?php include("../../config/templates/searchModal.php"); ?>
  


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="alumno.js"></script>
    <!--end plugins extra-->



</body>

</html>
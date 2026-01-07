<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);

    ?>
    <!--end head-->
    <style>
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }

        .container_radio {
  display: flex;
  justify-content: start;
  align-items: center;
}

.custom-radio {
  display: flex;
  flex-direction: column;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.custom-radio input[type="radio"] {
  display: none;
}

.radio-label {
  display: flex;
  align-items: center;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

.radio-circle {
  width: 20px;
  height: 20px;
  border: 2px solid #ffcc00;
  border-radius: 50%;
  margin-right: 10px;
  transition: border-color 0.3s ease-in-out, background-color 0.3s ease-in-out;
}

.radio-text {
  font-size: 1rem;
  color: #333;
  transition: color 0.3s ease-in-out;
}

.custom-radio input[type="radio"]:checked + .radio-label {
  background-color: #ffcc00;
}

.custom-radio input[type="radio"]:checked + .radio-label .radio-circle {
  border-color: #fff;
  background-color: #ffcc00;
}

.custom-radio input[type="radio"]:checked + .radio-label .radio-text {
  color: #64748b;
}

.checkbox {
  display: flex;
  justify-content: center;
  cursor: pointer;
  width: auto !important;
}

.checkbox:hover .checkbox-check {
  background: #ff475425;
}

.checkbox-input {
  width: 1px;
  height: 1px;
  opacity: 0;
}

.checkbox-input:checked + .checkbox-check {
  background: #FFCC00;
  stroke-dashoffset: 0;
}

.checkbox-check {
  border: 0.2rem solid #FFCC00;
  stroke: #f9f9f9;
  stroke-dasharray: 25;
  stroke-dashoffset: 25;
  stroke-linecap: round;
  stroke-width: 0.2rem;
  border-radius: 0.2rem;
  fill: none;
  transition: background 0.4s, stroke-dashoffset 0.6s;
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
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Mantenimientos</li>
                        <li class="breadcrumb-item" aria-current="page">Alumnos</li>
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
                    <h2 class="card-title">Consultar Alumnos</h2>
                    <div class="my-3 border-top"></div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card radius-10">
                            <div class="card-body p-0">
                                <div class="accordion accordion-flush" id="accordionLeyenda">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingLeyenda">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeyenda" aria-expanded="false" aria-controls="collapseLeyenda">
                                        Mostrar Leyenda
                                    </button>
                                    </h2>
                                    <div id="collapseLeyenda" class="accordion-collapse collapse" aria-labelledby="headingLeyenda" data-bs-parent="#accordionLeyenda">
                                    <div class="accordion-body row d-flex align-items-center">
                                        <button class="btn btn-warning waves-effect col-12 col-lg-1" title="Enviar correo">
                                        <i class="fa-regular fa-envelope"></i>
                                        </button>
                                        <label class="mg-l-10 col-12 col-lg-10 mg-t-10-force mg-lg-t-0-force">
                                        Este botón te permite <span class="fw-bold">enviar un correo</span> al alumno escogido para restablecer su contraseña o enviarle la creación de su nuevo usuario.
                                        </label>
                                    </div>

                                     <div class="accordion-body row d-flex align-items-center">
                                        <button class="btn btn-success waves-effect tx-12-force col-12 col-lg-1" title="Activar">
                                        <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger waves-effect tx-12-force col-12 col-lg-1 mg-lg-l-10 mg-lg-t-0-force mg-l-0 mg-t-10-force" title="Desactivar">
                                        <i class="fa-solid fa-xmark"></i>
                                        </button>
                                        <label class="mg-l-10 col-12 col-lg-8 mg-t-10-force mg-lg-t-0-force">
                                        Usa estos botones para <span class="fw-bold tx-success">activar</span> o <span class="fw-bold tx-danger">desactivar</span> al alumno de la aplicación.
                                        </label>
                                    </div>

                                    <div class="accordion-body row d-flex align-items-center">
                                        <button class="btn btn-info btn-icon col-12 col-lg-1" title="Ver datos interesado">
                                        <i class="fas fa-child-reaching"></i>
                                        </button>
                                        <label class="mg-l-10 col-12 col-lg-10 mg-t-10-force mg-lg-t-0-force">
                                        Con este botón podrás <span class="fw-bold">ver los datos del interesado</span>.
                                        </label>
                                    </div>

                                    <div class="accordion-body row d-flex align-items-center">
                                        <button class="btn btn-success btn-icon col-12 col-lg-1" title="Ver perfil">
                                        <i class="fas fa-clipboard-user"></i>
                                        </button>
                                        <label class="mg-l-10 col-12 col-lg-10 mg-t-10-force mg-lg-t-0-force">
                                        Te llevará al <span class="fw-bold">perfil completo</span> del usuario.
                                        </label>
                                    </div>

                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">

                                <div class="table-responsive order-mobile-first">
                                    <?php
                                    $nombreTabla = "alumnos_table";
                                    $nombreCampos = ["ID","Nickname", "Nombre", "Dirección", "Teléfono", "Email","Departamentos", "Interesados/Alumnos", "Estado", "Acción", "Interesado", "Perfil"];
                                    $nombreCamposFooter = ["ID","Nickname", "Nombre", "Dirección", "Teléfono", "Email","Departamentos", "Interesados/Alumnos", "Estado", "Acción", "Interesado", "Perfil"];;

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
                    </div>
                </div>
                
            </div>

       
        </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->
    <?php include_once 'modalGestion.php' ?>
    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php'?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
 

    <?php include("../../config/templates/searchModal.php"); ?>
<?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>
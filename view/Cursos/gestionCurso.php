<!DOCTYPE html>
<html lang="es">
<?php include '../../config/funciones.php' ?>
<!-- Hace falta por que ahí está la funcion que genera las tablas en HTML -->

<head>
  <?php include_once '../../config/templates/mainHead.php' ?>
  <?php
  // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
  checkAccess(['1','2','0']);
  ?>
  <!-- CSS DE ALERTAS -->
  <!-- CSS DE DROPZONE IMG -->
  <link rel="stylesheet" type="text/css" href="../../public/js/libs/dropzone/dist/min/dropzone.min.css">
  <!-- CSS DE LAS TABLAS ALUMNOS -->
  <link rel="stylesheet" type="text/css" href="../../public/js/libs/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css">
  <?php
  $idCurso = $_GET["idCurso"];
  if ($idCurso == '') {
    header("Location: index.php");
  }
  ?>
  <style>
    .checklist {
      --background: #fff;
      --text: #414856;
      --check: #4f29f0;
      --disabled: #c3c8de;
      --width: 100px;
      --height: 180px;
      --border-radius: 10px;
      background: var(--background);
      width: var(--width);
      height: var(--height);
      border-radius: var(--border-radius);
      position: relative;
      box-shadow: 0 10px 30px rgba(65, 72, 86, 0.05);
      padding: 30px 85px;
      display: grid;
      grid-template-columns: 30px auto;
      align-items: center;
      justify-content: center;
    }

    .checklist label {
      color: var(--text);
      position: relative;
      cursor: pointer;
      display: grid;
      align-items: center;
      width: fit-content;
      transition: color 0.3s ease;
      margin-right: 20px;
    }

    .checklist label::before,
    .checklist label::after {
      content: "";
      position: absolute;
    }

    

    .checklist input[type="checkbox"] {
      -webkit-appearance: none;
      -moz-appearance: none;
      position: relative;
      height: 15px;
      width: 15px;
      outline: none;
      border: 0;
      margin: 0 15px 0 0;
      cursor: pointer;
      background: var(--background);
      display: grid;
      align-items: center;
      margin-right: 20px;
    }

    .checklist input[type="checkbox"]::before,
    .checklist input[type="checkbox"]::after {
      content: "";
      position: absolute;
      height: 2px;
      top: auto;
      background: rgb(28, 165, 143);
      border-radius: 2px;
    }

    .checklist input[type="checkbox"].checkBoxOK::before,
    .checklist input[type="checkbox"].checkBoxOK::after {
      content: "";
      position: absolute;
      height: 2px;
      top: auto;
      background: rgb(28, 165, 143);
      border-radius: 2px;
    }

    .checklist input[type="checkbox"]::before {
      width: 0px;
      right: 60%;
      transform-origin: right bottom;
    }

    .checklist input[type="checkbox"]::after {
      width: 0px;
      left: 40%;
      transform-origin: left bottom;
    }

    .checklist input[type="checkbox"]:checked::before {
      animation: check-01 0.4s ease forwards;
    }

    .checklist input[type="checkbox"]:checked::after {
      animation: check-02 0.4s ease forwards;
    }

    .checklist input[type="checkbox"]:checked+label {
      color:#1CA58F;
      animation: move 0.3s ease 0.1s forwards;
    }

    

    .checklist input[type="checkbox"]:checked+label::after {
      animation: firework 0.5s ease forwards 0.1s;
    }

    @keyframes move {
      50% {
        padding-left: 8px;
        padding-right: 0px;
      }

      100% {
        padding-right: 4px;
      }
    }

    @keyframes slice {
      60% {
        width: 100%;
        left: 4px;
      }

      100% {
        width: 100%;
        left: -2px;
        padding-left: 0;
      }
    }

    @keyframes check-01 {
      0% {
        width: 4px;
        top: auto;
        transform: rotate(0);
      }

      50% {
        width: 0px;
        top: auto;
        transform: rotate(0);
      }

      51% {
        width: 0px;
        top: 8px;
        transform: rotate(45deg);
      }

      100% {
        width: 5px;
        top: 8px;
        transform: rotate(45deg);
      }
    }

    @keyframes check-02 {
      0% {
        width: 4px;
        top: auto;
        transform: rotate(0);
      }

      50% {
        width: 0px;
        top: auto;
        transform: rotate(0);
      }

      51% {
        width: 0px;
        top: 8px;
        transform: rotate(-45deg);
      }

      100% {
        width: 10px;
        top: 8px;
        transform: rotate(-45deg);
      }
    }

    @keyframes firework {
      0% {
        opacity: 1;
        box-shadow: 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0, 0 0 0 -2px #4f29f0;
      }

      30% {
        opacity: 1;
      }

      100% {
        opacity: 0;
        box-shadow: 0 -15px 0 0px #4f29f0, 14px -8px 0 0px #4f29f0, 14px 8px 0 0px #4f29f0, 0 15px 0 0px #4f29f0, -14px 8px 0 0px #4f29f0, -14px -8px 0 0px #4f29f0;
      }
    }
  </style>
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
            <h4 class="page-title">Lista de Alumnos</h4>
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
                  <li class="breadcrumb-item active" aria-current="page">Lista de alumnos</li>
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
        <input type="hidden" id="idCurso" value="<?php echo $idCurso ?>">
        <!-- ============================================================== -->
        <!-- CONTENIDO DE LA PÁGINA  -->
        <!-- ============================================================== -->

        <div class="card-body">

          <div class="row">
            <div class="col-sm-10 col-md-10 col-lg-10">
              <div class="card-body">
                <h4 class="card-title">Creación de Cursos y Asignación de Estudiantes</h4>
                <h6 class="card-subtitle">En esta sección, podrás crear nuevos cursos, añadir alumnos a los cursos y también cambiarlos de curso.</h6> <br><br>
              </div>
            </div>
            <!-- <div class="col-sm-12 col-md-12 col-lg-2 offset-lg-10"> -->



          </div>


          <div class="row col-12 mg-t-30  bd-2 shadow-base   rounded justify-content-center tx-center align-items-center">

            <!-- Acciones -->
            <div class="col-12 mg-b-20 mg-t-10">
              <h2>Acciones</h2>
            </div>
            <!-- BOTON 1 -->
            <div class="col-md-3 col-12 mg-t-10 mg-b-30">

              <div class="form-group">
                <label for="">Seleccione una fecha</label>
                <input type="date" class="form-control" id="fechaLista" value="<?php echo transformarFecha('', ['Y', '-', 'm', '-', 'd']); ?>">
              </div>
            </div>
            <!-- BOTON 2 -->
            <!-- <div class="col-md-3 col-12  mg-t-10 mg-b-30">
              <button type="button" onclick="agregarQuitarContenido()" class="btn waves-effect tx-bold waves-light btn-block btn-info">Agregar/Quitar Contenido</button>
            </div> -->
            <!-- BOTON 3 -->
            <div class="col-md-3 col-12  mg-t-10 mg-b-30">
              <button type="button" onclick="listarContenidos()" class="btn waves-effect tx-bold waves-light btn-block btn-cyan">Lista de Contenidos</button>
            </div>

          </div>


          <div id="divAgregarQuitarContenido" class="accionesCurso col-12  card-line d-none mg-t-30">

            <!-- titulos -->
            <div class="col-12 mg-t-20 mg-b-20">
              <h3 class="tx-info card-title">Agregar/Quitar Contenido</h3>
              <small>Añada nuevos contenidos al curso o quite los que ya existen de el.</small>
            </div>



            <!-- TITULO INDICATIVO -->
            <div class="row col-12 mg-t-20 justify-content-center tx-center align-items-center">

              <div class="col-md-6 col-12 row">
                <p class="col-12 tx-20 tx-bold tx-underline">Todos los contenidos</p>
              </div>
              <span><i class="fa-solid tx-20 fa-chevron-right"></i></span>

              <div class="col-md-6 col-12">
                <input type="hidden" id="idCursoAddAlumno">
                <p id="codigoText1" class="col-12 tx-20 tx-bold tx-underline">Contenidos del curso</p>
              </div>

              <div class="col-12">
                <select multiple="multiple" size="10" id="listAddContenidos" class="duallistbox-nuevo-contenido">
                </select>
              </div>

              <div class="d-flex col-12 justify-content-end text-right  tx-bold">
                <small id="alumnosMaximos" class="text-right-force tx-bold"></small>
              </div>

              <div class="mg-t-20 mg-b-20">
                <button id="" class="btn btn-dark btn-outline" type="button" onclick="agregarQuitarContenido()"> <span> Cancelar </span> </button>
                <button class="btn btn-success" type="button" id="guardarContenido"> Guardar Contenido </button>
              </div>
            </div>
          </div>
          <div id="divListarContenido" class="accionesCurso col-12  card-line d-none mg-t-30">
            <!-- titulos -->
            <div class="col-12 mg-t-20 mg-b-20">
              <h3 class="tx-info card-title">Listado de Contenido</h3>
              <small>Marcar el contenido realizado.</small>
            </div>



            <!-- TITULO INDICATIVO -->
            <div class="row col-12 mg-t-20 justify-content-center tx-center align-items-center">




              <div class="col-12">
                <div class="col-12 row d-flex justify-content-center" id="listContenidos">

                </div>
              </div>

              <div class="d-flex col-12 justify-content-end text-right  tx-bold">
                <small id="alumnosMaximos" class="text-right-force tx-bold"></small>
              </div>
            </div>
          </div>

        </div>


        <div class="row d-flex justify-content-center bd-0 shadow-base   rounded"  style="cursor:default;background-color: #F5F5F5;">

          <div class="row  d-flex justify-content-center col-12">

            <div type="button" class="col-12 col-lg-6 col-md-6 mg-t-20 " style="cursor:default">
                <div class="card-hover card border-left bd" style="pointer-events: none;">
                  <div class="card-body" style="background-color: rgba(3, 163, 23, 0.8)">
                    <div class="d-flex no-block align-items-center">
                      <div class="mg-r-20 tx-break">
                        <span class="text-success display-6">    <img src="teacher.svg" width="90px" alt="Teacher SVG"></span>
                      </div>

                      <div class="ml-auto tx-white">
                        <h4>Profesor: <label id="profesorCursoMostrar"></label></h4>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

          </div>


          <div class="row  d-flex justify-content-center col-12 mg-l-10 mg-r-10" id="alumnosCursoMostrar">
          
          </div>

          <div class="row  d-flex justify-content-center col-12 mg-b-20">
              <a onclick='window.history.back(); return false;'><button type='button' class='btn btn-secondary'>Volver</button></a>
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
  <?php include_once 'modalObjetivos.php' ?>

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
  <script src="gestionCurso.js"></script>

</body>

</html>
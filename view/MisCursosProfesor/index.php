<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
        
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['2']);
   

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
        .course-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .course-card:hover {
            transform: translateY(-5px);
        }
        .progress {
            height: 8px;
            border-radius: 5px;
        }
        .course-image {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        .course-dates {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 10px;
        }


        /* CALENDARIO */
            #calendar {
            width: 100% !important;
            max-width: 100%;
            height: auto;
            font-size: 16px;
            padding: 15px;
            }

            /* Personalización solo para listWeek */
            .fc-list-event {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px 0;
            background: #f8f9fa;
            transition: background 0.3s ease;
            }

            .fc-list-event:hover {
            background: #e9ecef;
            }

            .fc-list-event-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            padding: 6px 12px;
            }

            .fc-list-event-time {
            font-size: 14px;
            font-weight: 500;
            color: #555;
            padding-left: 12px;
            }

            .fc-list-day {
            background-color: #dfefff;
            font-weight: bold;
            color: #004085;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            }

            .fc .fc-list {
            border: none;
            box-shadow: none;
            }

            /* Móvil: espaciado y ancho completo */
            @media (max-width: 768px) {
            #calendar {
                padding: 10px;
            }
            }



/* BOTON PROVISIONAL*/
/* BOTÓN PROVISIONAL */
.btn-shine {
  display: inline-block; /* Nuevo: asegura que respete contenedores */
  font-size: 30px;
  font-weight: 600;
  font-family: "Poppins", sans-serif;
  text-decoration: none;
  white-space: nowrap;

  position: relative;
  color: transparent;
  background-image: linear-gradient(
    120deg,
    #ff9999 0%,
    #fff0f0 40%,
    #cc6666 60%,
    #ff9999 100%
  );
  background-size: 200% auto;
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;

  animation: shine 3s linear infinite;

  max-width: 100%;              /* Nuevo: no excede su contenedor */
  overflow-wrap: break-word;   /* Nuevo: permite cortar palabras largas */
  word-break: break-word;      /* Nuevo: lo mismo */
}

/* BOTÓN DEFINITIVO */
.btn-shineV {
  display: inline-block; /* Nuevo: asegura que respete contenedores */
  font-size: 30px;
  font-weight: 600;
  font-family: "Poppins", sans-serif;
  text-decoration: none;
  white-space: nowrap;

  position: relative;
  color: transparent;
  background-image: linear-gradient(
    120deg,
    #99ff99 0%,
    #f0fff0 40%,
    #66cc66 60%,
    #99ff99 100%
  );
  background-size: 200% auto;
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;

  animation: shine 3s linear infinite;

  max-width: 100%;              /* Nuevo */
  overflow-wrap: break-word;   /* Nuevo */
  word-break: break-word;      /* Nuevo */
}

/* ANIMACIÓN DE BRILLO */
@keyframes shine {
  0% {
    background-position: 200% center;
  }
  100% {
    background-position: -200% center;
  }
}

/* RESPONSIVE: para pantallas menores a 768px */
@media (max-width: 768px) {
  .btn-shine,
  .btn-shineV {
    font-size: 20px;        /* Reducido para móviles */
    white-space: normal;    /* Permite saltos de línea */
    text-align: center;     /* Centrado en móvil */
    display: block;         /* Ocupa el ancho completo */
    width: 100%;            /* Asegura que se ajuste */
  }

  .txtProvisional,
  .txtPublicado {
    display: block;
    text-align: center;
    padding: 0 10px;        /* Añade margen lateral en móvil */
  }
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
                        <li class="breadcrumb-item" aria-current="page">Docencia</li>
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
            <input type="hidden" id="idToken" value="<?php session_start(); echo $_SESSION['usu_token']; ?>">

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                    <h2 class="card-title">Gestión de Curso ( Course Management )</h2>
                    <div class="my-3 border-top"></div>

                    

                    <div class="container mg-t-10">
                        <h2 class="mb-4 text-center">Mis cursos ~ My Courses</h2>
                        <div class="text-center p-3">
                            <a href="#" class="btn-shine txtProvisional d-none">
                                Calendario Provisional / Provisional Calendar
                            </a>
                            <br>
                            <small class="txtProvisional d-none">
                                ❗ The provisional calendar is subject to change. It is your responsibility to check it daily if necessary.
                            </small><br>
                            <small class="txtProvisional d-none">
                                ❗ El calendario provisional está sujeto a cambios. Es su responsabilidad consultarlo diariamente si fuese necesario.
                            </small>

                            <a href="#" class="btn-shineV txtPublicado d-none mt-3">
                                Calendario Definitivo / Final Calendar
                            </a>
                        </div>

                        <input type="hidden" id="diaInicioSemanaImp">
                        <input type="hidden" id="diaFinSemanaImp">
                        <input type="hidden" id="rutaSeleccionada" class="form-control mt-2 text-center" readonly style="max-width: 300px;">

                        <div id="todosCursos" class="row g-4">
                            <!-- Curso 1 -->
                                   
                        </div>
                    </div>
                    <div class="container-fluid">
                    <div id="calendar"></div>

                   
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
    <?php include_once 'modalInformacion.php' ?>

    <?php include("../../config/templates/searchModal.php"); ?>
    <?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->


    <!--end plugins extra-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- NUEVO FUNCION -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
       <!-- Tippy y dependencias -->
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>
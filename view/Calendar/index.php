<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);

    ?>
    <!--end head-->
    <style>
          #calendar {
          max-width: 100% !important;
    }
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }

        table.dataTable {
            width: 100% !important;
        }

        table.dataTable th,
        table.dataTable td {
            text-align: center;
            /* Centrar el contenido */
            vertical-align: middle;
            /* Alinear verticalmente */
        }

        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn {
            padding: 6px 10px;
            margin: 2px;
            font-size: 14px;
        }

        /* Ajuste para las columnas de estado */
        .badge-success {
            background-color: #28a745 !important;
        }

        .badge-secondary {
            background-color: #6c757d !important;
        }

        .badge-warning {
            background-color: #ffc107 !important;
            color: #000;
        }

        .badge-info {
            background-color: #17a2b8 !important;
        }

        .fadeIn {
            opacity: 0;
            animation: fadeInAnimation 0.5s ease-in-out forwards;
        }

        @keyframes fadeInAnimation {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .fadeOut {
            opacity: 1;
            animation: fadeOutAnimation 0.5s ease-in-out forwards;
        }

        @keyframes fadeOutAnimation {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .texto-peque {
            font-size: 10px !important;
        }
        #buscar-rutas-modal tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #buscar-rutas-modal tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
        }
        #calendar {
            max-width: 1200px;   /* Más ancho */
            height: 900px;       /* Más alto */
            margin: 0 auto;
            font-size: 16px;     /* Puedes ajustar también el tamaño base de la fuente */
        }

        .checkbox-container {
  display: flex;
  gap: 20px;
  padding: 20px;
  background: #f8fafc;
  border-radius: 16px;
  box-shadow:
    0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -2px rgba(0, 0, 0, 0.05);
  flex-wrap: wrap;
  justify-content: center;
}

.ios-checkbox {
  --checkbox-size: 28px;
  --checkbox-color: #3b82f6;
  --checkbox-bg: #dbeafe;
  --checkbox-border: #93c5fd;

  position: relative;
  display: inline-block;
  cursor: pointer;
  user-select: none;
  -webkit-tap-highlight-color: transparent;
}

.ios-checkbox input {
  display: none;
}

.checkbox-wrapper {
  position: relative;
  width: var(--checkbox-size);
  height: var(--checkbox-size);
  border-radius: 8px;
  transition: transform 0.2s ease;
}
.disabled-row {
    opacity: 0.4;
    pointer-events: auto; /* Permite clics */
}
.checkbox-bg {
  position: absolute;
  inset: 0;
  border-radius: 8px;
  border: 2px solid var(--checkbox-border);
  background: white;
  transition: all 0.2s ease;
}

.checkbox-icon {
  position: absolute;
  inset: 0;
  margin: auto;
  width: 80%;
  height: 80%;
  color: white;
  transform: scale(0);
  transition: all 0.2s ease;
}

.check-path {
  stroke-dasharray: 40;
  stroke-dashoffset: 40;
  transition: stroke-dashoffset 0.3s ease 0.1s;
}

/* Checked State */
.ios-checkbox input:checked + .checkbox-wrapper .checkbox-bg {
  background: var(--checkbox-color);
  border-color: var(--checkbox-color);
}

.ios-checkbox input:checked + .checkbox-wrapper .checkbox-icon {
  transform: scale(1);
}

.ios-checkbox input:checked + .checkbox-wrapper .check-path {
  stroke-dashoffset: 0;
}

/* Hover Effects */
.ios-checkbox:hover .checkbox-wrapper {
  transform: scale(1.05);
}

/* Active Animation */
.ios-checkbox:active .checkbox-wrapper {
  transform: scale(0.95);
}

/* Focus Styles */
.ios-checkbox input:focus + .checkbox-wrapper .checkbox-bg {
  box-shadow: 0 0 0 4px var(--checkbox-bg);
}

/* Color Themes */
.ios-checkbox.blue {
  --checkbox-color: #3b82f6;
  --checkbox-bg: #dbeafe;
  --checkbox-border: #93c5fd;
}

.ios-checkbox.green {
  --checkbox-color: #10b981;
  --checkbox-bg: #d1fae5;
  --checkbox-border: #6ee7b7;
}

.ios-checkbox.purple {
  --checkbox-color: #8b5cf6;
  --checkbox-bg: #ede9fe;
  --checkbox-border: #c4b5fd;
}

.ios-checkbox.red {
  --checkbox-color: #ef4444;
  --checkbox-bg: #fee2e2;
  --checkbox-border: #fca5a5;
}

/* Animation */
@keyframes bounce {
  0%,
  100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
}

.ios-checkbox input:checked + .checkbox-wrapper {
  animation: bounce 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.fc-event-title {
    white-space: normal !important;
    overflow-wrap: break-word;
}
.fc-event {
    height: auto !important;
    min-height: 3em; /* o más, según el contenido */
}


/* SWITCH */
/* From Uiverse.io by cbolson */ 
.switch {
  --_switch-bg-clr: #70a9c5;
  --_switch-padding: 2px; /* antes: 4px */
  --_slider-bg-clr: rgba(12, 74, 110, 0.65);
  --_slider-bg-clr-on: rgba(12, 74, 110, 1);
  --_slider-txt-clr: #ffffff;
  --_label-padding: 0.4rem 0.8rem; /* antes: 1rem 2rem */
  --_switch-easing: cubic-bezier(0.47, 1.64, 0.41, 0.8);
  color: white;
  width: fit-content;
  display: flex;
  justify-content: center;
  border-radius: 9999px;
  cursor: pointer;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  position: relative;
  isolation: isolate;
}

.switch input[type="checkbox"] {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
.switch > span {
  display: grid;
  place-content: center;
  transition: opacity 300ms ease-in-out 150ms;
  padding: var(--_label-padding);
}
.switch::before,
.switch::after {
  content: "";
  position: absolute;
  border-radius: inherit;
  transition: inset 150ms ease-in-out;
}
/* switch slider */
.switch::before {
  background-color: var(--_slider-bg-clr);
  inset: var(--_switch-padding) 50% var(--_switch-padding)
    var(--_switch-padding);
  transition:
    inset 500ms var(--_switch-easing),
    background-color 500ms ease-in-out;
  z-index: -1;
  box-shadow:
    inset 0 1px 1px rgba(0, 0, 0, 0.3),
    0 1px rgba(255, 255, 255, 0.3);
}
/* switch bg color */
.switch::after {
  background-color: var(--_switch-bg-clr);
  inset: 0;
  z-index: -2;
}
/* switch hover & focus */
.switch:focus-within::after {
  inset: -0.25rem;
}
.switch:has(input:checked):hover > span:first-of-type,
.switch:has(input:not(:checked)):hover > span:last-of-type {
  opacity: 1;
  transition-delay: 0ms;
  transition-duration: 100ms;
}
/* switch hover */
.switch:has(input:checked):hover::before {
  inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
    45%;
}
.switch:has(input:not(:checked)):hover::before {
  inset: var(--_switch-padding) 45% var(--_switch-padding)
    var(--_switch-padding);
}
/* checked - move slider to right */
.switch:has(input:checked)::before {
  background-color: var(--_slider-bg-clr-on);
  inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
    50%;
}
/* checked - set opacity */
.switch > span:last-of-type,
.switch > input:checked + span:first-of-type {
  opacity: 0.75;
}
.switch > input:checked ~ span:last-of-type {
  opacity: 1;
}


    </style>

    <?php


    ?>
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
                        <li class="breadcrumb-item" aria-current="page">Calendario</li>
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
                    <h2 class="card-title">Calendario</h2>
                    <div class="my-3 border-top"></div>

                    <div class="row">
                     

                        <!-- <div class="col-12 d-flex justify-content-end mg-b-10">
                            <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#insertar-contenido-modal">Agregar Nivel</button>
                        </div> -->
                        <!-- Sección visualmente destacada -->
                       <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body bg-light rounded">

                                <div class="row g-3">

                                    <!-- Botón Seleccionar Ruta (ajustado con label invisible) -->
                                    <div class="col-md-12 d-flex flex-column align-items-center text-center mt-4">
                                        <label class="form-label invisible">Seleccionar Ruta</label>

                                        <!-- Switch centrado -->
                                        <!-- Switch centrado -->
                                        <div class="d-none" id="switchPublicado">
                                            <div class="text-center mb-2">
                                                <p class="mb-1">Semana seleccionada <b id="diaInicioSemana"></b> - <b id="diaFinSemana"></b></p>
                                                <input type="hidden" id="diaInicioSemanaImp">
                                                <input type="hidden" id="diaFinSemanaImp">

                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <label for="filter" class="switch my-2" aria-label="Toggle Filter">
                                                    <input type="checkbox" id="filter" />
                                                    <span>Provisional</span>
                                                    <span>Publicado</span>
                                                </label>
                                            </div>
                                        </div>

                                        

                                        <!-- Botón grande centrado -->
                                        <div class="d-flex my-3" style="width: 100%; max-width: 500px; gap: 10px;">
                                          <button class="btn btn-danger tx-white btn-lg flex-fill" id="botonAsignar" onClick="abrirModalRutas();">Selecciona un curso</button>
                                          <button class="btn btn-primary tx-white btn-lg flex-fill d-none" id="botonConsultar" onClick="abrirModalAlumnos();">Consultar alumnos</button>
                                        </div>

                                        
                                        <!-- Input de solo lectura centrado -->
                                        <input type="hidden" id="rutaSeleccionada" class="form-control mt-2 text-center" readonly style="max-width: 300px;">
                                    </div>

<!-- 
                                    <div class="col-md-4">
                                        <label class="form-label invisible">Ver Aulas</label>
                                        <div class="d-grid">
                                            <button class="btn btn-success btn-lg" id="botonAulas" onClick="verAulas();">Ver Aulas</button>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label invisible">Consultar Alumnos</label>
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-lg" id="botonAlumnos" onClick="consultarAlumnos();">Consultar Alumnos</button>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                           

                            <div class="col-12 row" id="tablaRutas">


                                <div class="col-12">
                                    <div id="calendar"></div>
                                </div>

                              

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </main>


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalDuplicar.php' ?>


    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
    <?php include_once 'modalCursos.php' ?>

        <?php include_once 'modalAlumnos.php' ?>

    <?php include("../../config/templates/searchModal.php"); ?>
    <?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->


    <!--start plugins extra-->
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    

    <!--end plugins extra-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- NUEVO FUNCION -->
<!--     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 -->    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

 
        <!-- Tippy y dependencias -->
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>

        <!-- FullCalendar -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

        <!-- Charts (si lo usas) -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- Tu script principal que contiene la lógica del calendario -->
        <script type="text/javascript" src="index.js"></script>


</body>

</html>
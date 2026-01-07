<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
        
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <!-- CSS de Summernote Lite (independiente de Bootstrap) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet"> 

    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    checkAccess(['2']);
    
    $idHorario = $_GET['idHorario'];

    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    
    require_once("../../models/Horario.php");

    $horario = new Horario();


    $datosHorarioArray = $horario->listarhorarioxId($idHorario);
    $datosHorario = $datosHorarioArray[0]; // Usamos solo el primer resultado
  
    // VARIABLES //
    $idHorario = $datosHorario['idHorario'];
    $idCurso_horario = $datosHorario['idCurso_horario'];
    $diaInicio_horario = $datosHorario['diaInicio_horario'];
    $horaInicio_horario = $datosHorario['horaInicio_horario'];
    $horaFin_horario = $datosHorario['horaFin_horario'];

    $cargarTareasDiarias = $horario->cargarTareasDiarias($idHorario);
    $tareaHoy = $cargarTareasDiarias[0]['descripcionTarea'] ?? '';
    $idTareasDiaria = $cargarTareasDiarias[0]['idTareasDiaria'] ?? '';

     // MWE QUEDO GESTIONANDO ESTO
    $cargarTareasDiariasAnterior = $horario->cargarTareasDiaAnterior($idCurso_horario,$diaInicio_horario,$horaInicio_horario);
    $datos = $cargarTareasDiariasAnterior[0] ?? null;

    $tareaAnterior = $datos['descripcionTarea'] ?? '';
    $nombreProfesor = ($datos['nomPersonal'] ?? '') . ' ' . ($datos['apePersonal'] ?? '');
    $diaTareaAnterior = isset($datos['diaInicio_horario']) 
        ? 'Enviado el día ' . fechaLocal($datos['diaInicio_horario']) . ' ' . ($datos['horaInicio_horario'] ?? '') . ' ' . ($datos['horaFin_horario'] ?? '') 
        : '';


    $json_string = json_encode($cargarTareasDiariasAnterior);
    $file = 'Y2T4.json';
    file_put_contents($file, $json_string);
 

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

        /*BOTONES DE OPCIONES */
        .attendance-menu {
        display: flex;
        background: #f3f3f3;
        padding: 6px;
        border-radius: 10px;
        gap: 4px;
        justify-content: center;
        flex-wrap: wrap;
        }

        .attendance-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s ease;
        }

        .attendance-btn:hover {
        background: #e0e0e0;
        }

        .attendance-btn.active {
        background: #d0e8ff;
        font-weight: bold;
        }

        #tareaAnterior {
            width: 100%;
            height: 150px;
            margin-bottom: 20px;
            resize: none;
        }
        textarea[readonly] {
            background-color: #f0f0f0;
            border: none;
            resize: none;
            height: 150px;
            font-size: 1.0rem;
        }
        .note-editable {
            font-size: 1.0rem;
            line-height: 1.6;
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
            
            <input type="hidden" id="idHorarioImput" value="<?php echo $idHorario;?>">
            <input type="hidden" id="idCursoImput" value="<?php echo $idCurso_horario;?>">
            <input type="hidden" id="diaInicio_horario" value="<?php echo $diaInicio_horario;?>">
            <input type="hidden" id="horaInicio_horario" value="<?php echo $horaInicio_horario ;?>">
            <input type="hidden" id="horaFin_horario" value="<?php echo $horaFin_horario;?>">

            <input type="hidden" id="idToken" value="<?php session_start(); echo $_SESSION['usu_token']; ?>">
            <input type="hidden" value="<?php echo $idTareasDiaria?>" id="tareasCreadas">

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                        <h2 class="mb-4 text-center">Gestionando curso <?php echo $_GET['idCurso'];?></h2>
                        <h3 class="mb-4 text-center"><span class="badge  text-info border border-info"><?php echo fechaLocal($diaInicio_horario);?></span> <span class="badge  text-danger border border-danger"><?php echo $horaInicio_horario;?> - <?php echo $horaFin_horario;?></span></h3>

                    <div class="my-3 border-top"></div>

                    <div class="container mg-t-10">

                        <h2 class="mb-4 text-center">Lista de Alumnos</h2>

                        <!-- Botón encima del buscador -->
                        <div class="text-center my-3">
                            <button id="marcarTodosAsistencia" class="btn btn-success">
                                <i class="fa-solid fa-check-double me-2"></i> Marcar todos como asistencia
                            </button>
                        </div>

                        <div class="text-center p-3">
                            <div class="col-md-12 mg-t-10-force">
                                <div class="table-responsive order-mobile-first">
                                    <?php
                                    $nombreTabla = "listaAlumnosClase";
                                    $nombreCampos = ["Nº", "Avatar", "Nombre del Alumno", "DNI / ID", "Asistencia", "Observaciones", "idALumno", "idLlegada"];
                                    $nombreCamposFooter = ["Nº", "Avatar", "Nombre del Alumno", "DNI / ID", "Asistencia", "Observaciones", "idALumno", "idLlegada"];

                                    $cantidadGrupos = 1;
                                    $columGrupos = [];
                                    $agrupacionesPersonalizadas = 0;
                                    $colorHEX = "#3AB54A";
                                    $desplegado = 0;
                                    $colorPicker = 0;

                                    echo generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="my-3 border-top"></div>

                   
                    <div class="container py-5">
                    <h2 class="mb-4 text-center fw-bold">📝 Tareas</h2>

                    <!-- Tarea anterior -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white fw-semibold">
                        📅 Tarea del día anterior - <?php echo $nombreProfesor.' | '. $diaTareaAnterior ?>
                        </div>
                        <div class="card-body">
                            <div class="form-control" style="min-height: 150px; background: #f8f9fa; border: 1px solid #ced4da;">
                                <?php echo $tareaAnterior; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Tarea para hoy -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white fw-semibold">
                        🆕 Tarea para hoy
                        </div>
                        <div class="card-body">
                            <textarea id="tareaHoy"><?php echo $tareaHoy;?></textarea>
                        </div>
                    </div>

                    <!-- Botón -->
                   <div class="text-center" id="btnGuardarContainer">
                        <?php if($idTareasDiaria == ''){ ?>
                            <button id="btnGuardar" onclick="guardarTareaClase()" class="btn btn-success px-4 py-2 fw-semibold">💾 Guardar tarea</button>
                        <?php } else { ?>
                            <button id="btnGuardar" onclick="guardarTareaClase()" class="btn btn-warning px-4 py-2 fw-semibold">💾 Editar tarea</button>
                        <?php } ?>
                    </div>

                    </div>


                    <div class="col-6 d-flex ">
                            <a  href="index.php" class="btn btn-outline-success px-5 ">
                                <span class="material-symbols-outlined">arrow_back_ios</span> Volver
                            
                            </a>
                        </div>
                    </div>
                   
            </div>

          

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->
         <?php include_once 'modalAgregarLista.php' ?>

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
   <script>
    $(document).ready(function() {
        $('#tareaHoy').summernote({
        height: 200,
        placeholder: 'Escribe la tarea del día de hoy...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']]
        ],
          fontSizes: ['8', '10', '12', '14', '16', '18', '24', '36'] // Opcional

        });
    });
     $(document).ready(function() {
        $('#tareaAlumno').summernote({
        height: 50,
        placeholder: 'Escribe la tarea del día de hoy para el alumno...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']]
        ],
          fontSizes: ['8', '10', '12', '14', '16', '18', '24', '36'] // Opcional

        });
    });
    </script>

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
    <script src="gestionarCurso.js"></script>
    <!--end plugins extra-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
     


</body>

</html>
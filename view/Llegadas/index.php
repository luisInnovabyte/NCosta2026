<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
      checkAccess(['1']); 

    ?><?php

        require_once('../../config/templates/sesion.php');
        require_once("../../config/conexion.php");
        require_once("../../models/Prescriptor.php");

        $prescriptor = new Prescriptor();
        $datos = $prescriptor->mostrarElementoxToken($_GET["tokenPreinscripcion"]);
        
        // Capturar parámetro opcional idLlegada para enlace directo
        $idLlegadaDirecta = isset($_GET["idLlegada"]) ? intval($_GET["idLlegada"]) : null;

        require_once("../../models/Rutas.php");

        $rutas = new Rutas();
        $datosRutas = $rutas->listarRutasActivas();

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
}
.btn-add-record:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 163, 232, 0.4);
}

/* ========================================== */
/*     ESTILOS PERSONALIZADOS LLEGADAS       */
/* ========================================== */
        
        .botonFlotante1 {}

        .botonFlotante2 {
            top: 61px;
            margin-right: -5px;

        }

        .botonFlotante3 {
            top: 121px;
            margin-right: -5px;
        }
        .botonFlotante7 {
            top: -10px;
            margin-right: -5px;
        }
        .botonFlotante4 {
            top: 181px;
            margin-right: -5px;
        }

        .botonFlotante5 {
            top: 572px;
            margin-right: -5px;
        }

        .botonFlotante5-1 {
            top: 490px;
            margin-right: -10px;
        }

        .colorBoton1 {
            background: #c1c0a3 !important;
        }

        .colorBoton2 {
            background: #ff5c0f !important;
            border-radius: 10px;
        }

        .colorBoton3 {
            background: #0080ff !important;
            border-radius: 10px;
        }

        .colorBoton4 {
            background: #dc3545 !important;
            border-radius: 10px;
        }
        .colorBoton4 {
            background: #dc3545 !important;
            border-radius: 10px;
        }
        .colorBoton5 {
            background: #198754 !important;
            border-radius: 10px;
        }
        .colorBoton7 {
            background: #B3CBBD !important;
            border-radius: 10px;
        }
        /* Estilo del contenedor de sugerencias */
        .suggestions-list {
            position: absolute;
            width: 99%;
            border: 1px solid #ccc;
            background-color: white;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            /* Asegura que las sugerencias se muestran sobre otros elementos */
            display: none;
            top: 40px
                /* Ocultamos inicialmente */
        }

        .sg-list-v2 {
            top: 60px
        }

        /* Estilo de cada sugerencia */
        .suggestions-list p {
            padding: 10px;
            margin: 0;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .suggestions-list p:hover {
            background-color: #f0f0f0;
        }

        .nav-link[disabled] {
            pointer-events: none;
            /* No permite clics */
            color: grey;
            /* Cambia el color */
            text-decoration: none;
            /* Sin subrayado */
            cursor: not-allowed;
            /* Cambia el cursor para indicar que está deshabilitado */
            opacity: 0.5;
            /* Reduce la opacidad */
        }

        /* From Uiverse.io by KhaledMatalkah */
        .custom-checkbox {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            font-size: 16px;
            color: #333;
            transition: color 0.3s;
        }

        .custom-checkbox input[type="checkbox"] {
            display: none;
        }

        .custom-checkbox .checkmark {
            width: 24px;
            height: 24px;
            border: 2px solid #333;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: background-color 0.3s, border-color 0.3s, transform 0.3s;
            transform-style: preserve-3d;
        }

        .custom-checkbox .checkmark::before {
            content: "\2713";
            font-size: 16px;
            color: transparent;
            transition: color 0.3s, transform 0.3s;
        }

        .custom-checkbox input[type="checkbox"]:checked+.checkmark {
            background-color: #333;
            border-color: #333;
            transform: scale(1.1) rotateZ(360deg) rotateY(360deg);
        }

        .custom-checkbox input[type="checkbox"]:checked+.checkmark::before {
            color: #fff;
        }

        .custom-checkbox:hover {
            color: #666;
        }

        .custom-checkbox:hover .checkmark {
            border-color: #666;
            background-color: #f0f0f0;
            transform: scale(1.05);
        }

        .custom-checkbox input[type="checkbox"]:focus+.checkmark {
            box-shadow: 0 0 3px 2px rgba(0, 0, 0, 0.2);
            outline: none;
        }

        .custom-checkbox .checkmark,
        .custom-checkbox input[type="checkbox"]:checked+.checkmark {
            transition: background-color 1.3s, border-color 1.3s, color 1.3s, transform 0.3s;
        }



        /* Colores de fondo para cada card */
        .card-body.datos-generales {
            background-color: #e3f2fd;
            /* Azul claro */
        }
        .card-body.datos-generales2 {
            background-color: #F2F4E3; /* Amarillo pastel muy suave */
        }
        .card-body.datos-generales3 {
            background-color: #E3F2FD; /* Azul claro profesional */
        }
        .card-body.datos-generales4 {
            background-color: #FDE3F2; /* Rosa pálido delicado */
        }
        .card-body.datos-generales5 {
            background-color: #F2FDE3; /* Verde menta sutil y fresco */
        }
        .card-body.datos-generales6 {
            background-color: #FDEFE3; /* Melocotón muy claro y cálido */
        }
        .card-body.datos-generales7 {
            background-color: #E3FDF2; /* Verde aguamarina súper suave */
        }

        .card-body.datos-estudiante {
            background-color: #fff3e0;
            /* Amarillo claro */
        }

        .card-body.datos-contacto {
            background-color: #e8f5e9;
            /* Verde claro */
        }

        .card-body.ubicacion {
            background-color: #f0f4c3;
            /* Verde pálido */

        }

        .card-body.observacion {
            background-color: #ede4f5;
            /* Lila claro */

        }

        .datos-cancelacion {
            background-color: #ffcece;

        }

        /* Efecto de elevación para el card al hacer hover en un input */
        .card-hover {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card-hover:hover,
        .card-hover.active {
            transform: translateY(-5px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Efecto de parpadeo */
        @keyframes parpadeo {
            0%, 100% {
                background-color: transparent;
            }
            50% {
                background-color:rgb(150, 235, 170);; /* Verde claro */
                color: #155724; /* Verde oscuro para el texto */
                border: 1px solid rgb(150, 235, 170); /* Borde verde claro */
            }
        }

        /* Clase para aplicar el parpadeo */
        .blinkX {
            animation: parpadeo 1.5s infinite;
            padding: 2px 4px; /* Espaciado para que se vea el efecto mejor */
            border-radius: 4px; /* Bordes redondeados */
        }

        .transfer-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
  }
  .transfer-section {
    width: 48%;
    padding: 20px;
    border-radius: 10px;
  }
  .transfer-title {
    font-size: 1.5em;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
    background: linear-gradient(to right, #007bff, #0056b3);
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
  }
  .transfer-regreso .transfer-title {
    background: linear-gradient(to right, #ff9800, #e65100);
  }
        .seccion-transfer {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        min-height: 100%;
    }

    .transfer-llegada {
        background: #e3f2fd; /* Azul claro */
        border-left: 5px solid #0d47a1;
    }

    .transfer-regreso {
        background: #fff3e0; /* Naranja claro */
        border-left: 5px solid #ff6f00;
    }

    .separador {
        display: none; /* Se oculta porque estarán en la misma fila */
    }

    @media (max-width: 768px) {
        .separador {
            display: block; /* Se vuelve a mostrar en pantallas pequeñas */
            text-align: center;
            font-weight: bold;
            margin: 15px 0;
            color: #777;
        }
    }

    .estLlegadasLabel {
        font-size: 18px; /* Ajusta el tamaño de la fuente */
        padding: 10px 20px; /* Aumenta el relleno interno del label */
        margin: 10px; /* Aumenta el margen externo */
        font-weight: bold; /* Asegura que el texto esté en negrita */
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

        #llegadasTable tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #llegadasTable tbody tr:hover td {
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
        <input type="hidden" id="idPrescriptor" value="<?php echo isset($_GET["idPrescriptor"]) ? $_GET["idPrescriptor"] : ''; ?>">
        <input type="hidden" id="tokkenPrescripcion" value="<?php echo $datos[0]["idPrescripcion"] ?>">
        <input type="hidden" id="idLlegadaDirecta" value="<?php echo $idLlegadaDirecta ?? ''; ?>">
        <!-- NUEVOS INPUTS PARA SABER SI HAY FACTURA PROFORMA O REAL ACTIVA EN ESA LLEGADA -->
        <input type="hidden" id="inputFacturaProforma" name="inputFacturaProforma">
        <input type="hidden" id="inputFacturaReal" name="inputFacturaReal">
        <!-- NUEVOS INPUTS PARA SABER SI HAY FACTURA PROFORMA O REAL ACTIVA EN ESA LLEGADA -->
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">

                        <li class="breadcrumb-item" aria-current="page">Llegadas </li>
                        

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

            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-12 card">
                        <!-- Header profesional -->
                        <div class="page-header-custom d-flex justify-content-between align-items-center">
                            <div>
                                <h2><i class='bx bx-calendar-check me-2'></i>Gestión de Llegadas</h2>
                                <p>Control y registro de llegadas de estudiantes</p>
                            </div>
                            <button type="button" class="btn btn-light" onclick="window.open('ayuda.html', 'Ayuda', 'width=1200,height=800,scrollbars=yes,resizable=yes');">
                                <i class="fa-solid fa-circle-question"></i> Ayuda
                            </button>
                        </div>
                        <div class="card-body d-none cardLlegadas" id="divNuevaLlegada">
                            <div class="cardLlegadas " >
                                
                                <div id="estadoLlegada" class="mb-3"></div>

                                <div class="card mg-t-20 card-hover">

                                    <div class="card-body datos-generales">
                                        <h3 class="card-title text-center">Datos del Interesado</h3>
                                        <div class="row">
                                            <div class="col-md-3 mg-t-10-force">
                                                <label for="idLlegada" class="form-label">Num.Llegada</label>
                                                <input type="text" class="form-control form-control-sm" id="idLlegada" placeholder="Número secuencial" disabled>
                                                <input type="hidden" class="form-control form-control-sm" id="idLlegadaReal" placeholder="Número secuencial" disabled>

                                            </div>
                                            <div class="col-md-3 mg-t-10-force">
                                                <label for="diaInscripcion" class="form-label">Día Inscripción</label>
                                                <input type="date" class="form-control form-control-sm fechaSinHorapick" id="diaInscripcion">
                                            </div>
                                            <div class="col-md-3 mg-t-10-force">
                                                <label for="idPrescriptorDatos" class="form-label">Interesado</label>
                                                <input disabled type="search" class="form-control form-control-sm" id="idPrescriptorDatos" placeholder="Buscar interesado..."> <!-- //*! Buscador complejo *// -->

                                            </div>
                                            <div class="col-md-3 mg-t-10-force">
                                                <label for="idDepartamento" class="form-label">Departamento</label>
                                                <select class="form-control form-control-sm" id="departamentoSelect" data-placeholder="Selecciona Departamento"></select>
                                            </div>
                                            <div class="col-md-6 mg-t-10-force">
                                                <label for="nombreApellidos" class="form-label">Nombre y Apellidos</label>
                                                <input type="text" class="form-control form-control-sm" id="nombreApellidos" disabled>
                                            </div>
                                            <div class="col-md-3 mg-t-10-force">
                                                <label for="sexo" class="form-label">Sexo</label>
                                                <input type="text" class="form-control form-control-sm" id="sexo" disabled>
                                            </div>
                                            <div class="col-md-3 mg-t-10-force">
                                                <label for="pais" class="form-label">País</label>
                                                <input type="text" class="form-control form-control-sm" id="pais" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card mg-t-30 card-hover">

                                    <div class="card-body  datos-generales">

                                        <h2 class="card-title text-center">Agente / Grupo Facturación / Grupo Amigos y Familia</h2>
                                        <div class="row">
                                            <div class="col-md-4 mg-t-10-force">
                                                <label for="idAgente" class="form-label">Agente</label>

                                                <div class="input-group">
                                                    <input type="hidden" id="idAgente" name="idAgente">
                                                    <input type="search" class="form-control form-control-sm" id="nombreAgente" placeholder="Buscar agente..."> <!-- //*! Select con busqueda *// -->
                                                    <div class="suggestions-list"></div>
                                                    <button class="btn btn-outline-secondary bd-secondary searchAgente" id="btnSearchAgente" type="button">
                                                        <i class="fa-solid fa-search"></i> <!-- Icono de lupa usando Bootstrap Icons --> <input type="hidden" class="buscarTarifa">
                                                    </button>
                                                     <a href="../MntPreinscriptores_Edu/" target="blank_" class="btn btn-outline-info bd-info searchAgente" id="btnSearchAgente" type="button">
                                                        <i class="fa-solid fa-user-plus"></i> <!-- Icono de lupa usando Bootstrap Icons --> <input type="hidden" class="buscarTarifa">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mg-t-10-force" id="divGrupo">
                                                <label for="idGrupo" class="form-label">Grupo Facturacion</label>
                                                <input type="text" class="form-control form-control-sm" id="idGrupo" placeholder="Nombre del grupo">
                                                <div class="suggestions-list sg-list-v2"></div>

                                            </div>
                                            <div class="col-md-4 mg-t-10-force" id="divGrupo">
                                                <label for="idGrupoAmigo" class="form-label">Grupo Amigos y Familia</label>
                                                <input type="text" class="form-control form-control-sm" id="idGrupoAmigo" placeholder="Nombre del grupo">
                                                <div class="suggestions-list sg-list-v2"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="card mg-t-30 card-hover">

                                    <div class="card-body  datos-generales">
                                        <h2 class="card-title text-center">Información de llegada</h2>
                                        <div class="row">
                                            <div class="col-md-4 mg-t-10-force">
                                                <label for="fechaLlegada" class="form-label">Fecha y Hora de Llegada</label>
                                                <input type="datetime-local" class="form-control form-control-sm fechaFullHoypick" id="fechaLlegada">
                                            </div>
                                            <div class="col-md-4 mg-t-10-force">
                                                <label for="lugarLlegada" class="form-label">Lugar de Llegada</label>
                                                <input type="text" class="form-control form-control-sm " id="lugarLlegada">
                                            </div>
                                            <div class="col-md-4 mg-t-10-force">
                                                <label for="recogeAlumno" class="form-label">Quién recoge al alumno</label>
                                                <input type="text" class="form-control form-control-sm" id="recogeAlumno">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 cardLlegadas d-none">
                                    <div id="guardarTxt" class="row d-flex justify-content-center">
                                        <small ><b class="tx-danger">*</b> Debe crear la llegada para poder añadir los distintos servicios.</small>
                                        <button id="guardarBtn"  type="button" class="col-lg-3 col-12 mg-2 btn btn-info text-white">Crear Llegada</button>
                                    </div>
                                </div>
                                <div class="mt-3 cardLlegadas d-none">
                                    <div class="row d-flex justify-content-center">
                                        <button id="editarBtn" type="button" class="col-lg-3 col-12 mg-2 btn btn-info text-white">Editar campos Llegada</button>
                                    </div>
                                </div>
                                <hr class="tx-danger">
                                <div class="serviciosDiv d-none">
                                    <h2>Servicios</h2>
                                    <ul class="nav nav-tabs mg-t-20 cardLlegadas d-none" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="docencia-tab" data-bs-toggle="tab" data-bs-target="#docencia" type="button" role="tab">Matriculación</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="alojamiento-tab" data-bs-toggle="tab" data-bs-target="#alojamiento" type="button" role="tab">Alojamiento</button>
                                        </li>
                                         <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="trans-tab" data-bs-toggle="tab" data-bs-target="#transfer" type="button" role="tab">Transfer</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="otros-tab" data-bs-toggle="tab" data-bs-target="#otros" type="button" role="tab">Pagos</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="nivel-tab" data-bs-toggle="tab" data-bs-target="#nivel" type="button" role="tab">Nivel</button>
                                        </li>
                                       
                                        <li class="nav-item" role="presentation" id="botonContenedorVisado">
                                            <button class="nav-link disabled" id="visados-tabNew" data-bs-toggle="tab" data-bs-target="#visados" type="button" role="tab" disabled>Visado</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="suplidos-tab" data-bs-toggle="tab" data-bs-target="#suplidos" type="button" role="tab">Suplidos</button>
                                        </li>
                                    </ul>
                                
                                    <div class="tab-content cardLlegadas d-none" id="myTabContent">


                                        <!-- =============================================== -->
                                        <!--                   DOCENCIA                      -->
                                        <!-- =============================================== -->
                                        <div class="tab-pane fade show active" id="docencia" role="tabpanel">
                                            <div class="card mt-3 card-hover">
                                                <div class="card-body datos-generales2">
                                                    <h5 class="card-title d-flex justify-content-between align-items-center">
                                                        <span>
                                                            Docencia <label id="textEditar"></label><label id="tiempoDocencia"></label>
                                                        </span>
                                                        <!-- <button class="btn btn-sm btn-info tx-white ms-2" title="Forzar Estados" onclick="forzarEstadosMatricula()" type="button">
                                                            <i class="bi bi-arrow-repeat"></i> Forzar Estados
                                                        </button> -->
                                                    </h5>

                                                    <input type="hidden" id="idMatriculaEditando">
                                                    <input type="hidden" id="descripcionTarifa">

                                                    <div class="row">
                                                      <!-- Contenedor para el mensaje, oculto por defecto -->
                                                      <div class="mensajeFacturas" style="display:none; background-color: #fdf6f0; border: 2px dashed #d4a373; padding: 20px; border-radius: 12px; font-family: Georgia, serif; color: #5a3e36; max-width: 600px; margin: 30px auto; text-align: center;"></div>
                                                      <div class="mensajeGrupo" style="display:none; background-color: #fdf6f0; border: 2px dashed #d4a373; padding: 20px; border-radius: 12px; font-family: Georgia, serif; color: #5a3e36; max-width: 600px; margin: 30px auto; text-align: center;"></div>

                                                      <div id="zonaFormMatricula" class="row">

                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="codDocencia" class="form-label">Tarifa de Docencia</label>
                                                            <div class="input-group" id="groupTarifaDocenciaInputs">

                                                                <input type="text" class="form-control form-control-sm" id="codDocencia" disabled><!-- //*! Select con busqueda *// -->
                                                                <div class="suggestions-list"></div>
                                                                    <button class="btn btn-outline-secondary bd-secondary searchTarifa" id="btnSearchTarifaDocencia" type="button" onClick="abrirModalTarifas('Docencia');" disabled>
                                                                        <i class="fa-solid fa-search"></i> <!-- Icono de lupa usando Bootstrap Icons --> <input type="hidden" class="buscarTarifa">
                                                                    </button>
                                                                </div>

                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="importeDocencia" class="form-label">Importe</label>
                                                            <input type="text" class="form-control form-control-sm" id="importeDocencia" disabled>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="ivaDocencia" class="form-label">IVA</label>
                                                            <input type="text" class="form-control form-control-sm" id="ivaDocencia" disabled>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="descDocencia" class="form-label">Descuento</label>
                                                            <input type="text" class="form-control form-control-sm" id="descDocencia" disabled>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="inicioDocencia" class="form-label">Fecha de Inicio</label>
                                                            <input type="text" class="form-control fechaSinHoraHoypick form-control-sm" id="inicioDocencia" placeholder="DD/MM/AAAA">
                                                            
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="finalDocencia" class="form-label">Fecha de Finalización</label>
                                                            <input type="text" class="form-control fechaSinHoraHoypick form-control-sm"  id="finalDocencia" placeholder="DD/MM/AAAA">
                                                        </div>
                                                    
                                                        <div class="col-md-12 mg-t-10-force" id="obsMatricula">
                                                            <label for="nivelDocencia" class="form-label">Observaciones Matriculación</label>
                                                            <textarea class="form-control form-control-sm" id="observacionesDocencias" rows="2"></textarea>
                                                        </div>
                                                        <div class="row col-md-12 mg-t-10-force justify-content-center">
                                                            <button id="agregarMatriculaNew" class="col-lg-3 col-12 mg-lg-2 btn btn-primary">Agregar</button>
                                                            <button id="guardarMatricula" class="col-lg-3 col-12 mg-lg-2 btn btn-success d-none">Guardar</button>
                                                            <button id="cancelarMatricula" class="col-lg-3 col-12 mg-lg-2 btn btn-danger d-none">Cancelar</button>
                                                        </div>
                                                        </div> <!-- cierre de zonaFormMatricula -->
                                                        <div class="col-md-12 mg-t-10-force">
                                                            
                                                            <div id="matriculacionTableDiv" class="table-responsive order-mobile-first">
                                                                <?php
                                                                $nombreTabla = "matriculacionTableNew";
                                                                $nombreCampos = ["Tarifa", "Descripción", "Observaciones", "Importe", "IVA", "Descuento", "Fecha Inicio", "Fecha Fin","Estado", "Acción"];
                                                                $nombreCamposFooter = [
                                                                    "<input type='text' class='form-control' id='FootDescripcion' name='FootDescripcion' placeholder='Buscar Tarifa'>",
                                                                    "Descripción",
                                                                    "Observaciones",
                                                                    "Importe",
                                                                    "IVA",
                                                                    "Descuento",
                                                                    "Fecha Inicio",
                                                                    "Fecha Fin",
                                                                    "Estado",
                                                                    "Acción"
                                                                ];

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
                                                    </div> <!-- cierre de row -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- =============================================== -->
                                        <!--                   ALOJAMIENTO                   -->
                                        <!-- =============================================== -->
                                        <div class="tab-pane fade" id="alojamiento" role="tabpanel">
                                            <div class="card mt-3 card-hover">
                                                <div class="card-body datos-generales3">
                                                    <h5 class="card-title d-flex justify-content-between align-items-center">
                                                        <span>
                                                        Alojamientos <label id="textAlojamiento"></label><lable id="tiempoAloja"></lable>
                                                        </span>
                                                        <button class="btn btn-sm btn-info tx-white ms-2" title="Forzar Estados" onclick="forzarEstadosAlojamiento()" type="button">
                                                            <i class="bi bi-arrow-repeat"></i> Forzar Estados
                                                        </button>
                                                    </h5>
                                                    <div class="row">
                                                      <!-- Contenedor para el mensaje, oculto por defecto -->
                                                      <div class="mensajeFacturas" style="display:none; background-color: #fdf6f0; border: 2px dashed #d4a373; padding: 20px; border-radius: 12px; font-family: Georgia, serif; color: #5a3e36; max-width: 600px; margin: 30px auto; text-align: center;"></div>  
                                                      <div class="mensajeGrupo" style="display:none; background-color: #fdf6f0; border: 2px dashed #d47e73ff; padding: 20px; border-radius: 12px; font-family: Georgia, serif; color: #5a3e36; max-width: 600px; margin: 30px auto; text-align: center;"></div>

                                                      <div id="zonaFormAlojamiento" class="row">
                                                        <input type="hidden" id="idAlojamientoEditando">
                                                        <input type="hidden" id="descripcionTarifaAloja">
                                                        
                                                        <div class="col-12 col-md-3 col-lg-3 mg-t-10-force">
                                                            <label for="codAlojamiento" class="form-label">Tarifa de Alojamiento</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-sm" id="codAlojamiento"><!-- //*! Select con busqueda *// -->
                                                                <div class="suggestions-list"></div>
                                                                <button class="btn btn-outline-secondary bd-secondary searchTarifa"  id="btnSearchTarifaAlojamiento"  type="button" onClick="abrirModalTarifas('Alojamiento');">
                                                                    <i class="fa-solid fa-search"></i> <!-- Icono de lupa usando Bootstrap Icons --> <input type="hidden" class="buscarTarifa">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-3 col-lg-2 mg-t-10-force">
                                                            <label for="importeAlojamiento" class="form-label">Importe</label>
                                                            <input type="text" class="form-control form-control-sm" id="importeAlojamiento" disabled>
                                                        </div>
                                                        <div class="col-12 col-md-3 col-lg-1 mg-t-10-force">
                                                            <label for="ivaAlojamiento" class="form-label">IVA</label>
                                                            <input type="text" class="form-control form-control-sm" id="ivaAlojamiento" disabled>
                                                        </div>
                                                        <div class="col-12 col-md-3 col-lg-1 mg-t-10-force">
                                                            <label for="descuentoAlojamiento" class="form-label">Descuento</label>
                                                            <input type="text" class="form-control form-control-sm" id="descuentoAlojamiento" disabled>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="entradaAlojamiento" class="form-label">Fecha de Entrada</label>
                                                            <input type="text"  class="form-control fechaSinHoraHoypick form-control-sm" id="entradaAlojamiento" placeholder="DD/MM/AAAA">
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-2 mg-t-10-force">
                                                            <label for="salidaAlojamiento" class="form-label">Fecha de Salida</label>
                                                            <input type="text"  class="form-control fechaSinHoraHoypick form-control-sm"  id="salidaAlojamiento" placeholder="DD/MM/AAAA">
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-1 mg-t-10-force">
                                                            <label for="horaAlojamiento" class="form-label">Hora</label>
                                                            <input type="time" class="form-control form-control-sm" id="horaAlojamiento" value="11:00">
                                                        </div>
                                                        
                                                        <div class="col-12 mg-t-10-force">
                                                            <label for="observacionesAlojamiento" class="form-label">Observaciones Alojamiento</label>
                                                            <textarea class="form-control form-control-sm" id="observacionesAlojamiento" rows="2"></textarea>
                                                        </div>
                                                        
                                                        <div class="row col-12 mg-t-10-force justify-content-center">
                                                            <button id="agregarAlojamientosNew" class="col-lg-3 col-12 mg-lg-2 btn btn-primary">Agregar</button>
                                                            <button id="guardarAlojamientoNew" class="col-lg-3 col-12 mg-lg-2 btn btn-success d-none btnEditViewAloja">Guardar</button>
                                                            <button id="cancelarAlojamiento" class="col-lg-3 col-12 mg-lg-2 btn btn-danger d-none btnEditViewAloja">Cancelar</button>
                                                        </div>
                                                        </div> <!-- cierre de zonaFormAlojamientvvv -->

                                                        <div class="col-md-12 mg-t-10-force">

                                                            <div class="table-responsive order-mobile-first">
                                                                <?php
                                                                $nombreTabla = "alojamientoTableNew";
                                                                $nombreCampos = ["Tarifa","Descripción", "Importe", "IVA", "Descuento", "Fecha Inicio", "Fecha Fin", "Hora Salida", "Acción"];
                                                                $nombreCamposFooter = [
                                                                    "<input type='text' class='form-control' id='FootDescripcion' name='FootDescripcion' placeholder='Buscar Tarifa'>",
                                                                    "Descripción",
                                                                    "Importe",
                                                                    "IVA",
                                                                    "Descuento",
                                                                    "Fecha Inicio",
                                                                    "Fecha Fin",
                                                                    "Hora Salida",
                                                                    "Acción"
                                                                ];

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


                                        <!-- =============================================== -->
                                        <!--                   TRANSFER                      -->
                                        <!-- =============================================== -->

                                        <div class="tab-pane fade" id="transfer" role="tabpanel">

                                            <div class="card mt-3 card-hover">
                                                <div class="card-body datos-generales">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12  seccion-transfer transfer-llegada">
                                                        <div class="transfer-title position-relative text-center py-2" style="background:#007bff; color:white; border-radius:6px;">
                                                            <button type="button"  onclick="vaciarTransfer('llegada')" class="btn btn-sm btn-danger position-absolute" 
                                                                    style="left:10px; top:50%; transform:translateY(-50%);" aria-label="Cerrar">
                                                                &times;
                                                            </button>
                                                            Transfer Llegada
                                                        </div>                                                          
                                                        <div class="row">
                                                                    
                                                                <!-- <label for="codDocencia" class="form-label">Tarifa de Docencia</label>
                                                                <div class="input-group" id="groupTarifaDocenciaInputs">

                                                                    <input type="text" class="form-control form-control-sm" id="codDocencia" disabled>
                                                                    <div class="suggestions-list"></div>
                                                                    <button class="btn btn-outline-secondary bd-secondary searchTarifa" id="btnSearchTarifaDocencia" type="button" onClick="abrirModalTarifas('Docencia');" disabled>
                                                                        <i class="fa-solid fa-search"></i><input type="hidden" class="buscarTarifa">
                                                                    </button>
                                                                </div> -->
                                                                <div class="col-md-6 mg-t-10-force ">
                                                                    <!-- <label for="codigoTarifasLlegada" class="form-label">Código Tarifas (Llegada)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="codigoTarifasLlegada" placeholder="Código tarifas llegada">
                                                                    <div class="suggestions-list"></div> -->

                                                                    <label for="codigoTarifasLlegada" class="form-label">Código Tarifas (Llegada)</label>
                                                                    <div class="input-group">

                                                                        
                                                                        <input type="text" class="form-control form-control-sm" id="codigoTarifasLlegada" placeholder="Código tarifas llegada"><!-- //*! Select con busqueda *// -->
                                                                        <div class="suggestions-list"></div>

                                                                        <button class="btn btn-outline-secondary bd-secondary searchTarifa" type="button" onClick="abrirModalTarifasOtros('Otro', this);">
                                                                            <i class="fa-solid fa-search"></i><input type="hidden" class="buscarTarifa">
                                                                        </button>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="textoTarifasLlegada" class="form-label">Texto Tarifas (Llegada)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="textoTarifasLlegada" placeholder="Texto tarifas llegada" disabled>
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="importeTarifasLlegada" class="form-label">"€" Importe Tarifas (Llegada)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="importeTarifasLlegada" value="0,00€" placeholder="Importe tarifas llegada" disabled>
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="ivaTarifasLlegada" class="form-label">% IVA Tarifas (Llegada)</label>
                                                                    <input type="number" class="form-control form-control-sm" id="ivaTarifasLlegada" placeholder="% IVA tarifas llegada" disabled>
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="diaLlegada" class="form-label">Día Llegada</label>
                                                                    <input type="date"  onkeydown="return false"  class="form-control form-control-sm"  id="diaLlegada">
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="horaLlegada" class="form-label">Hora Llegada</label>
                                                                    <input type="time" class="form-control form-control-sm" id="horaLlegada" >
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="lugarRecogidaLlegada" class="form-label">Lugar de Recogida (Llegada)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="lugarRecogidaLlegada" disabled>
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="lugarEntregaLlegada" class="form-label">Lugar de Entrega (Llegada)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="lugarEntregaLlegada">
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="quienRecogeLlegada" class="form-label">Quién Recoge al Alumno (Llegada)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="quienRecogeLlegada" disabled>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>

                                                        <div class="col-12 separador">───</div>

                                                        <div class="col-md-6 col-12 seccion-transfer transfer-regreso">
                                                                <div class="transfer-title position-relative text-center">
                                                                    <button type="button" onclick="vaciarTransfer('regreso')" class="btn btn-sm btn-danger position-absolute"
                                                                            style="left:10px; top:50%; transform:translateY(-50%);" aria-label="Cerrar">
                                                                        &times;
                                                                    </button>
                                                                    Transfer Regreso
                                                                </div>

                                                                <div class="row">

                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <!-- <label for="codigoTarifasRegreso" class="form-label">Código Tarifas (Regreso)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="codigoTarifasRegreso" placeholder="Código tarifas regreso">
                                                                    <div class="suggestions-list"></div> -->

                                                                    
                                                                    <label for="codigoTarifasRegreso" class="form-label">Código Tarifas (Regreso)</label>
                                                                    <div class="input-group">

                                                                        
                                                                        <input type="text" class="form-control form-control-sm" id="codigoTarifasRegreso" placeholder="Código tarifas regreso"><!-- //*! Select con busqueda *// -->
                                                                        <div class="suggestions-list"></div>

                                                                        <button class="btn btn-outline-secondary bd-secondary searchTarifa" type="button" onClick="abrirModalTarifasOtros('Otro', this);" >
                                                                            <i class="fa-solid fa-search"></i><input type="hidden" class="buscarTarifa">
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="textoTarifasRegreso" class="form-label">Texto Tarifas (Regreso)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="textoTarifasRegreso" placeholder="Texto tarifas regreso" disabled>
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="importeTarifasRegreso" class="form-label">"€" Importe Tarifas (Regreso)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="importeTarifasRegreso"  value="0,00€" placeholder="Importe tarifas regreso" disabled>
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="ivaTarifasRegreso" class="form-label">% IVA Tarifas (Regreso)</label>
                                                                    <input type="number" class="form-control form-control-sm" id="ivaTarifasRegreso" placeholder="% IVA tarifas regreso" disabled>
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="diaRegreso" class="form-label">Día Regreso</label>
                                                                    <input type="date"  onkeydown="return false"  class="form-control form-control-sm" min="<?= date('Y-m-d') ?>" id="diaRegreso">
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="horaRegreso" class="form-label">Hora Regreso</label>
                                                                    <input type="time" class="form-control form-control-sm" id="horaRegreso">
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="lugarRecogidaRegreso" class="form-label">Lugar de Recogida (Regreso)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="lugarRecogidaRegreso">
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="lugarEntregaRegreso" class="form-label">Lugar de Entrega (Regreso)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="lugarEntregaRegreso">
                                                                </div>
                                                                <div class="col-md-6 mg-t-10-force">
                                                                    <label for="quienRecogeRegreso" class="form-label">Quién Recoge al Alumno (Regreso)</label>
                                                                    <input type="text" class="form-control form-control-sm" id="quienRecogeRegreso">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="observaciones" class="form-label">Observaciones</label>
                                                                    <textarea class="form-control form-control-sm" id="observaciones" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                            <!-- Banner de advertencia para cambios sin guardar -->
                                                            <div class="row col-md-12 mg-t-10-force" id="transferWarningBanner" style="display: none;">
                                                                <div class="col-12">
                                                                    <div class="alert alert-warning text-center mb-2" role="alert">
                                                                        <i class="fa-solid fa-exclamation-triangle"></i>
                                                                        <strong>¡Atención!</strong> Hay cambios sin guardar. Presiona "Agregar Transfer" para guardarlos.
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row col-md-12 mg-t-10-force justify-content-center">
                                                                <button onclick="agregarTransfer()" id="btnAgregarTransfer" class="col-lg-3 col-12 mg-lg-2 btn btn-primary">Agregar Transfer</button>
                                                            </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- =============================================== -->
                                        <!--                     PAGOS                       -->
                                        <!-- =============================================== -->

                                        <div class="tab-pane fade" id="otros" role="tabpanel">
                                            <div class="card mt-3 card-hover">
                                                <div class="card-body datos-generales7">
                                                    <h5 class="card-title">Pagos <label id="textEditarPago"></label></h5>
                                                    <input type="hidden" id="idPagoEditando">

                                                    <div class="row">
                                                        <div class="col-md-4 mg-t-10-force">
                                                            <label for="importeAnticipadoOtros" class="form-label">Importe</label>
                                                            <input type="number" class="form-control form-control-sm" step="0.01" min="0" id="importeAnticipadoOtros" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44">
                                                        </div>
                                                        <div class="col-md-4 mg-t-10-force">
                                                            <label for="fechaPagoOtros" class="form-label">Fecha del pago</label>
                                                            <input type="date" class="form-control form-control-sm" id="fechaPagoOtros">
                                                        </div>
                                                        <div class="col-md-4 mg-t-10-force">
                                                            <label for="medioPagoOtros" class="form-label">Medio de pago</label>
                                                            <!--                                                     <input type="text" class="form-control form-control-sm" id="medioPagoOtros"> -->
                                                            <select class="form-control form-control-sm" id="medioPagoOtros" data-placeholder="Selecciona Metodo"></select>

                                                        </div>
                                                        <div class="col-md-12 mg-t-10-force">
                                                            <label for="comentarioPagoOtros" class="form-label">Observación</label>
                                                            <textarea class="form-control form-control-sm" id="comentarioPagoOtros" maxlength="128" rows="3"></textarea>
                                                        </div>
                                                        <div class="row col-md-12 mg-t-10-force justify-content-center">
                                                            <button id="agregarPagoAnticipadoNew" class="col-lg-3 col-12 mg-lg-2 btn btn-primary">Agregar Pago</button>
                                                            <button id="guardarPagoAnticipadoNew" class="col-lg-3 col-12 mg-lg-2 btn btn-success d-none">Guardar Edición</button>
                                                            <button id="cancelarPagoAnticipado" class="col-lg-3 col-12 mg-lg-2 btn btn-danger d-none">Cancelar</button>
                                                        </div>
                                                     
                                                    </div>
                                                    <div class="col-md-12 mg-t-10-force">
                                                            
                                                        <div id="pagoAnticipadoTableDiv" class="table-responsive order-mobile-first">
                                                            <?php
                                                         
                                                            $nombreTabla = "pagoAnticipadoTableNew";
                                                            $nombreCampos = ["Importe Pagado","Fecha de Pago", "Medio utilizado", "Observaciones", "Acción"];
                                                            $nombreCamposFooter = ["Importe Pagado","Fecha de Pago", "Medio utilizado", "Observaciones", "Acción"];

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

                                        <div class="tab-pane fade " id="nivel" role="tabpanel">
                                            <div class="card mt-3 card-hover">
                                                <div class="card-body datos-generales5">
                                                    <h5 class="card-title">Nivel</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="nivelDocencia" class="form-label">Nivel Dice</label>
                                                            <input type="text" class="form-control form-control-sm" id="nivelDocencia">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="nivelDocenciaAsignado" class="form-label">Ruta Asignada</label>
                                                            <div class="d-grid">
                                                                <button class="btn btn-danger tx-white" id="botonAsignar" onClick="abrirModalRutas();">Sin Asignar</button>
                                                            </div>
                                                            <input type="hidden" id="rutaSeleccionada">
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <label for="observacionesNivel" class="form-label">Nivel Observaciones</label>
                                                            <textarea class="form-control form-control-sm" id="observacionesNivel" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-4">
                                                        <button onclick="agregarNivel()" class="btn btn-primary px-4">Agregar Nivel</button>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="visados" role="tabpanel">
                                            <div class="card mt-3 card-hover">
                                                <div class="card-body datos-generales5">
                                                    <h5 class="card-title">Visados</h5> <br>
                                                    <div class="row">
                                                        <!-- Sección de Admisión -->
                                                        <div class="col-md-6">
                                                            <div class="card border-primary p-3" style="background-color: #e3f2fd; border-radius: 10px;">
                                                                <h5 class="text-white p-2 text-center" style="background-color: #0d6efd; border-radius: 5px;">Admisión</h5>
                                                                <div class="mb-4">
                                                                    <label for="visadoCheck" class="form-label">¿El interesado quiere visado?</label>
                                                                    <label class="custom-checkbox">
                                                                        <input name="dummy" type="checkbox" id="visadoCheck">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="fechaAdmision" class="form-label">Fecha carta admisión</label>
                                                                    <input type="date"  onkeydown="return false"  min="<?= date('Y-m-d') ?>" class="form-control form-control-sm" id="fechaAdmision">
                                                                </div>
                                                                <br><br><br>
                                                            </div>
                                                        </div>

                                                        <!-- Sección de Denegación -->
                                                        <div class="col-md-6">
                                                            <div class="card border-danger p-3" style="background-color: #ffebee; border-radius: 10px;">
                                                                <h5 class="text-white p-2 text-center" style="background-color: #dc3545; border-radius: 5px;">Denegación</h5>
                                                                <div class="mb-3">
                                                                    <label for="denegacionFecha" class="form-label">Fecha de denegación</label>
                                                                    <input type="date" onkeydown="return false"  min="<?= date('Y-m-d') ?>" class="form-control form-control-sm" id="denegacionFecha">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="denegacionMotivo" class="form-label">Motivo de denegación</label>
                                                                    <textarea class="form-control form-control-sm" id="denegacionMotivo" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Botón centrado -->
                                                    <div class="row mt-3 justify-content-center">
                                                        <div class="col-auto">
                                                            <button onclick="agregarVisado()" class="btn btn-primary">Guardar Visado</button>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="suplidos" role="tabpanel">
                                            <div class="card mt-3 card-hover">
                                                <div class="card-body datos-generales6">
                                                    <h5 class="card-title">Suplidos</h5>
                                                    <div class="row">
                                                        <div class="col-md-6 mg-t-10-force">
                                                                <label for="nivelDocencia" class="form-label">Importe</label>
                                                                <input type="text" class="form-control form-control-sm" id="importeSuplido">
                                                        </div>
                                                        <div class="col-md-6 mg-t-10-force">
                                                                <label for="nivelDocencia" class="form-label">Descripción</label>
                                                                <input type="text" class="form-control form-control-sm" id="descrSuplido">
                                                        </div>
                                                    </div>
                                                    <div class="row col-md-12 mg-t-10-force justify-content-center">
                                                            <button onclick="agregarSuplidos()" class="col-lg-3 col-12 mg-lg-2 btn btn-primary">Guardar Suplido</button>
                                                        </div>
                                                    <div class="col-md-12 mg-t-10-force">
                                                        <div id="suplidosTableDiv" class="table-responsive order-mobile-first">
                                                            <?php
                                                         
                                                            $nombreTabla = "suplidosTableNew";
                                                            $nombreCampos = ["Importe Suplido","Descripción","Eliminar Suplido"];
                                                            $nombreCamposFooter = ["Importe Suplido","Descripción","Eliminar Suplido"];

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

                                    <div class="card mg-t-30  card-hover">

<div class="card-body datos-generales">
                            <div class="row cardLlegadas">
                                <div class="col-12">
                                    <h6 class="mb-3 text-center text-uppercase"><i class="fa-solid fa-file-invoice"></i> Resumen de Facturación</h6>
                                    
                                    <table class="table table-sm table-borderless mb-0" style="font-size: 0.9rem; table-layout: fixed;">
                                        <colgroup>
                                            <col style="width: 35%;">
                                            <col style="width: 15%;">
                                            <col style="width: 35%;">
                                            <col style="width: 15%;">
                                        </colgroup>
                                        <tbody>
                                            <!-- Matrículas -->
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="py-2">Matrículas (Sin IVA)</td>
                                                <td class="py-2 text-end" id="totalMatriculacionSinIva">0,00 €</td>
                                                <td class="py-2 ps-3" style="border-left: 2px solid #adb5bd;">Matrículas (Con IVA)</td>
                                                <td class="py-2 text-end fw-bold" id="totalMatriculacionConIva">0,00 €</td>
                                            </tr>
                                            
                                            <!-- Alojamiento -->
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="py-2">Alojamiento (Sin IVA)</td>
                                                <td class="py-2 text-end" id="totalAlojamientoSinIva">0,00 €</td>
                                                <td class="py-2 ps-3" style="border-left: 2px solid #adb5bd;">Alojamiento (Con IVA)</td>
                                                <td class="py-2 text-end fw-bold" id="totalAlojamientoConIva">0,00 €</td>
                                            </tr>
                                            
                                            <!-- Transfer Llegada -->
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="py-2">Transfer Llegada (Sin IVA)</td>
                                                <td class="py-2 text-end" id="totalTransferLlegadaSinIva">0,00 €</td>
                                                <td class="py-2 ps-3" style="border-left: 2px solid #adb5bd;">Transfer Llegada (Con IVA)</td>
                                                <td class="py-2 text-end fw-bold" id="totalTransferLlegadaConIva">0,00 €</td>
                                            </tr>
                                            
                                            <!-- Transfer Regreso -->
                                            <tr style="border-bottom: 2px solid #495057;">
                                                <td class="py-2">Transfer Regreso (Sin IVA)</td>
                                                <td class="py-2 text-end" id="totalTransferRegresoSinIva">0,00 €</td>
                                                <td class="py-2 ps-3" style="border-left: 2px solid #adb5bd;">Transfer Regreso (Con IVA)</td>
                                                <td class="py-2 text-end fw-bold" id="totalTransferRegresoConIva">0,00 €</td>
                                            </tr>
                                            
                                            <!-- Totales -->
                                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #495057;">
                                                <td class="py-2 fw-bold text-uppercase" style="font-size: 0.85rem;">Total General (Sin IVA)</td>
                                                <td class="py-2 text-end fw-bold fs-5" id="totalGeneralSinIva">0,00 €</td>
                                                <td class="py-2 ps-3 fw-bold text-uppercase" style="border-left: 2px solid #adb5bd; font-size: 0.85rem;">Total General (Con IVA)</td>
                                                <td class="py-2 text-end fw-bold fs-5" id="totalGeneralConIva">0,00 €</td>
                                            </tr>
                                            
                                            <!-- Pagado -->
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="py-2 fw-bold text-success" colspan="3" style="border-left: 2px solid #adb5bd;"><i class="fa-solid fa-check-circle"></i> Total Pagado</td>
                                                <td class="py-2 text-end fw-bold text-success fs-5" id="finalPagado">0,00 €</td>
                                            </tr>
                                            
                                            <!-- Pendiente -->
                                            <tr>
                                                <td class="py-2 fw-bold text-danger" colspan="3" style="border-left: 2px solid #adb5bd;"><i class="fa-solid fa-exclamation-circle"></i> Pago Pendiente</td>
                                                <td class="py-2 text-end fw-bold text-danger fs-5" id="finalPendiente">0,00 €</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>


                                        </div>

                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
                 


            <div class="card d-none" id="buscarLlegada">
                    <div class="card-body p-4">
                        <div class="row">
                            <h5 class="mb-4 ">Buscar Llegadas de <label id="llegadasDe"></label></h5>
                        </div>
                        
                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">

                                <div class="table-responsive order-mobile-first">
                                    <?php
                                    $nombreTabla = "llegadasTable";

                                    $nombreCampos = ["ID","Token","Nº Llegada", "Dia Inscripcion", "Fecha Llegada","Departamento","Matriculas - Alojamiento","Estado","Alerta Pago"];
                                    $nombreCamposFooter = [
                                        "ID",
                                        "Token",
                                        "<input type='text' class='form-control' id='FootNumero' name='FootNumero' placeholder='Buscar Llegada'>", 
                                        "<input type='text' class='form-control' id='FootDia' name='FootDia' placeholder='Buscar Día'>", 
                                        "<input type='text' class='form-control' id='FootFecha' name='FootFecha' placeholder='Buscar Fecha'>",
                                        "<input type='text' class='form-control' id='FootDepartamento' name='FootDepartamento' placeholder='Buscar Departamento'>",
                                        "<input type='text' class='form-control' id='FootMatriculacion' name='FootMatriculacion' placeholder='Buscar Matriculas'>",
                                        "<input type='text' class='form-control' id='FootEstado' name='FootEstado' placeholder='Buscar Estado'>",
                                        "<input type='text' class='form-control' id='FootAlerta' name='FootAlerta' placeholder='Buscar Alerta'>",
                                    ];
                                   

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
 
</script>
    </main>
    
    <div class="row d-flex justify-content-center d-none" id="buttonContainer">
                                    <a id="" class="col-lg-2 col-12 mg-2 btn btn-success d-none">IR PROFORMA</a> <!-- //! No cargar si no hay Llegadas -->

                                </div>
    <aside class="customizer botonFlotante2">
        <a href="javascript:void(0)" id="nuevaLlegada" data-bs-toggle="modal" title="Nueva llegada" data-bs-target="#modalInfo" class="service-panel-toggle colorBoton3 tx-20" style="opacity: 0.75">
        <i class="fa-solid fa-circle-plus"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante7 d-none">
        <a href="javascript:void(0)" id="cancelacionLlegadas" data-bs-toggle="modal" title="Cancelar Llegada" data-bs-target="#cancelacion-modal" class="service-panel-toggle colorBoton4 tx-20" style="opacity: 0.75">
        <i class="fa-solid fa-plane-slash"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante3 d-none">
        <a href="javascript:void(0)" id="listarLlegadas" data-bs-toggle="modal" title="Listar llegadas" data-bs-target="#modalInfo" class="service-panel-toggle colorBoton3 tx-20" style="opacity: 0.75">
        <i class="fa-solid fa-list-ul"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante4" >
        <a href="../Interesados_Edu" id="btnPreforma" title="Volver" title="IR A LLEGADAS" class="service-panel-toggle colorBoton7 tx-20" style="opacity: 0.75">
        <i class="fa-solid fa-circle-chevron-left"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante5-1 d-none ">
        <a href="javascript:void(0)" id="irProforma" class="service-panel-toggle colorBoton5 tx-20" style="opacity: 0.75">
        <i class="fa-solid fa-file-invoice"></i>        
    </a>
    </aside>
    <aside class="customizer botonFlotante5-1 d-none ">
        <a href="javascript:void(0)" id="updateClient" class="service-panel-toggle colorBoton5 tx-20" style="opacity: 0.75">
            <i class="fa-solid fa-circle-check"></i>
        </a>
    </aside>
   <!--  <aside class="customizer botonFlotante5 d-none ">
        <a href="javascript:void(0)" id="cancelClient" class="service-panel-toggle colorBoton4 tx-20" style="opacity: 0.75">
            <i class="fa-solid fa-circle-xmark"></i>
        </a>
    </aside> -->
    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalLlegadas.php' ?>
    <?php include_once 'modalPrescriptores.php' ?>
    <?php include_once 'modalTarifas.php' ?>
    <?php include_once 'modalAgentes.php' ?>
    <?php include_once 'modalCancelacion.php' ?>
    <?php include_once 'modalRutas.php' ?>

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Selecciona todos los inputs dentro de las cards
            const inputs = document.querySelectorAll(".card-body input, .card-body select");

            inputs.forEach(input => {
                input.addEventListener("mouseenter", function() {
                    // Añade la clase active al card correspondiente cuando el ratón entra en un input
                    const cardBody = input.closest(".card-body");
                    if (cardBody) {
                        cardBody.classList.add("active");
                    }
                });

                input.addEventListener("mouseleave", function() {
                    // Elimina la clase active cuando el ratón sale del input
                    const cardBody = input.closest(".card-body");
                    if (cardBody) {
                        cardBody.classList.remove("active");
                    }
                });
            });
        });
    </script>
    
    <script src="index.js"></script>
    <script src="llegadas.js"></script>

    <!--end plugins extra-->


</body>

</html>
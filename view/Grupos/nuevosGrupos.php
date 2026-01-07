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
  
    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    require_once("../../models/Departamentos_Edu.php");
 
    $depa = new Departamentos();
    $datosDepa = $depa->cargarDepaActivo();
    

    // Fecha actual en formato YYYY-MM-DD (que usa Flatpickr)
    $hoy = date('Y-m-d'); 
    $dosSemanasDespues = date('Y-m-d', strtotime('+14 days'));

    ?>
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
        <!-- matchHeight.js -->
        <script src="../../public/js/jquery-match-height-master/jquery.matchHeight.js" type="text/javascript"></script>
    <style>
        .fecha-columna {
            white-space: normal !important; 
            word-wrap: break-word;
            min-width: 120px; /* Ajusta según necesidad */
            text-align: center;
        }

        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }
        #alumnosTabla tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #alumnosTabla tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
        }
        #aulas_table tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #aulas_table tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
        }
        #cursosTabla tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #cursosTabla tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
        }
        .table-responsive {
            width: 100% !important;
        }
        #aulas_table {
            width: 100% !important;
            max-width: 100% !important;
            table-layout: fixed; /* Opcional, si las columnas están desiguales */
        }
        .contenedor-tabla {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #007bff;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .tabla-view {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .tabla-view th, .tabla-view td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-view th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #0056b3;
        }

        .tabla-view tr:last-child td {
            border-bottom: none;
        }

        .tabla-view tr:hover {
            background-color: #f0f8ff;
        }
        .card-altura-fija {
            height: 500px; /* Ajusta la altura según necesites */
            display: flex;
            flex-direction: column;
        }

        .card-body {
    flex-grow: 1;
    overflow: auto; /* Para manejar contenido que exceda la altura */
}

.info-tooltip {
    position: relative;
    display: inline-block;
}

.info-icon {
    cursor: pointer;
    font-size: 18px;
}
.info-content {
    display: none;
    position: absolute;
    top: 125%; /* Cambiado de bottom a top */
    left: 50%;
    transform: translateX(-50%);
    width: 300px;
    background: #333;
    color: #fff;
    padding: 10px 12px;
    border-radius: 6px;
    font-size: 13px;
    line-height: 1.4;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,.3);
}

/* Flechita hacia arriba */
.info-content::after {
    content: "";
    position: absolute;
    bottom: 100%; /* antes era top: 100% */
    left: 50%;
    margin-left: -6px;
    border-width: 6px;
    border-style: solid;
    border-color: transparent transparent #333 transparent; /* Flecha apuntando hacia arriba */
}

/* Mostrar tooltip */
.info-tooltip:hover .info-content {
    display: block;
}
/* Colores */
.warning { color: #ffc107; }
.success { color: #28a745; }


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
                        <li class="breadcrumb-item" aria-current="page">Grupos</li>
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
                    <h2 class="card-title">Asignación de Alumnos a Grupos  <div class="info-tooltip">
                                                    <span class="info-icon">ℹ️</span>

                                                        <div class="info-content">
                                                            <small>Se mostrará lo seleccionado en el filtro.</small><br>
                                                            <small>Si la matriculación está en <span class="warning">Espera</span> o <span class="success">En Proceso</span>.</small><br>
                                                            <small>Si la llegada ya está en un grupo, no se mostrará.</small>
                                                        </div>
                                                </div></h2>
                    
                    <div class="my-3 border-top"></div>
                        <!-- CONTENIDO  -->
                        <div class="row">
                            <div class="col-12 col-lg-12  card-altura-fija col-xl-6">
                                <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="d-flex align-items-center">
                                  
                                    <div class="mg-l-50">
                                        
                                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONE DEPARTAMENTO" style="width: 100%; height: 65px !important;" id="selectDepartamento">
                                                <?php foreach ($datosDepa as $row) { ?>
                                                    <option value="<?php echo $row["idDepartamentoEdu"] ?>"><?php echo $row["nombreDepartamento"] ?> </option>
                                                <?php } ?>
                                            </select>
                                    </div>
                                    <div class="mg-l-50">                                     
                                        <div>
                                        <input type="text" class="form-control date-range"  placeholder="Selecciona un rango de fechas" data-start="<?= $hoy ?>"  data-end="<?= $dosSemanasDespues ?>">                                        </div>
                                    </div>
                                    <div class="mg-l-50">                                     
                                        <div>
                                        
                                        <button type="button" onclick="cargarTablaAlum()" class="btn btn-outline-success ">
                                                Actualizar
                                            </button>
                                        </div>
                                      
                                    </div>
                                    <div class="mg-l-50">                                     
                                        <div>
                                        
                                        <button type="button" onclick="cargarTablaAlum(3)" class="btn btn-outline-danger ">
                                                Todos
                                            </button>
                                        </div>
                                      
                                    </div>
                                    
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-12" id="divDtInteresados">
                                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                            <div class="row">

                                                <div class="table-responsive order-mobile-first">
                                                    <?php
                                                    $nombreTabla = "alumnosTabla";
                                                    $nombreCampos = ["ID", "Nombre", "G. Amigos", "Nivel", "Fecha Inicio"];
                                                    $nombreCamposFooter = ["ID", "Nombre", "G. Amigos", "Nivel", "Fecha Inicio"];
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
                                                <div>
                                               
                                                </div>
                                                

                                            </div>
                                        </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 col-xl-6 h-100">
                                <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="d-flex align-items-center">
                                    <div class="">
                                        <h6 class="mb-0 fw-bold">Cursos Disponibles</h6>
                                    </div>
                                    <div class="dropdown ms-auto">
                                       
                                        <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                        <div id="alertCursos" class="d-flex align-items-center gap-3 border-start border-danger border-4 border-0 px-2 py-1">
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Selecciona un Alumno para mostrar los grupos</h6>
                                            </div>
                                        </div>

                                    <div class="col-12 d-none " id="divCursos">
                                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>
                                            
                                            <div class="row">

                                                <div class="table-responsive order-mobile-first">
                                                    <?php
                                                   
                                                    $nombreTabla = "cursosTabla";
                                                    $nombreCampos = ["ID", "Ruta",  "Código", "Fecha","Fecha Fin","Alumnos", "Capacidad", "Serie", "codGrupo"];
                                                    $nombreCamposFooter = ["ID",  "Ruta","Código", "Fecha","Fecha Fin","Alumnos", "Capacidad", "Serie", "codGrupo"];
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
                        </div>
                        
                        <!--------------->
                        <div class="row">
                                <div id="divInfoAlumno" class="col-12 col-lg-6 col-xl-4 d-flex d-none">
                                    <div class="card w-100">
                                        <div class="card-header bg-transparent">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                <h6 class="mb-0 fw-bold">Información del Alumno</h6>
                                                </div>
                                                <div class="dropdown ms-auto">
                                               
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                                    </li>
                                                    <li>
                                                    <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                                    </li>
                                                </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card-body">
                                    <div class="team-list">
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="hidden" id="idAlumno">
                                            <input type="hidden" id="codNivel">

                                            
                                            <div class="">
                                            <img id="avatarUsu" src="" alt="" width="50" height="50" class="rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                            <h6  id="nombreAlumno" class="mb-1 fw-bold"></h6>
                                            </div>
                                            <div class="">
                                            <a href="" id="botonPerfil" target="_blank" class="btn btn-outline-primary rounded-5 btn-sm px-3">Ver Perfil</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-warning text-white">
                                                <i class=" bi bi-clipboard2-pulse"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Adaptaciones</h6>
                                            <div id="adaptacionesDiv">

                                            </div>
                                            
                                            

                                            </div>
                                            
                                            
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-info text-white">
                                                <i class="bi bi-journal-bookmark"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Nivel Seleccionado</h6>
                                            <input type="hidden" id="idLlegada">
                                            <input type="hidden" id="nivelAsignado">

                                            <span id="idiomaTxt" class="badge bg-danger-subtle text-danger border border-danger"></span>
                                            <span id="tipoTxt" class="badge bg-info-subtle text-info border border-info"></span>
                                            <span id="nivelTxt" class="badge bg-warning-subtle text-warning border border-warning"></span>
                                        

                                            </div>
                                            
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-success text-white">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">Grupo de Amigos</h6>

                                                <div class="mb-2" id="grupoAmigos">
                                                  
                                                </div>
                                               
                                                <div class="mt-2" id="listaAmigos">
                                                    
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ms-auto widget-icon bg-primary text-white">
                                                <i class="bi bi-journal-bookmark-fill"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">Matriculas</h6>

                                                                                             <div id="matriculasDiv" class="mt-2">
                                                    
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                    </div>
                                    </div>
                                </div>
                                </div>
                                    <div id="divAcciones" class="col-12 col-lg-6 col-xl-4  w-auto d-flex d-none">
                                        <div class="card ">
                                            <div class="card-header bg-transparent">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                <h6 class="mb-0 fw-bold">Acción</h6>
                                                </div>
                                                <div class="dropdown ms-auto">
                                               
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                                    </li>
                                                    <li>
                                                    <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                                    </li>
                                                </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card-body">
                                    <!-- <div class="team-list">
                                        <div class="d-flex align-items-center gap-3 border-start border-info border-4 border-0 px-2 py-1">
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Se realizará el traspaso del Alumno a ESIGA1</h6>
                                            <span class="">26/02/2025 12:15</span>
                                            </div>
                                           
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3 border-start border-warning border-4 border-0 px-2 py-1">
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Incompatibilidades</h6>
                                            <span class="">El Aula no está adaptada para este alumno</span>

                                            </div>
                                           
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3 border-start border-danger border-4 border-0 px-2 py-1">
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">11 Alumnos de 10 Permitidos</h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center gap-3 border-start border-danger border-4 border-0 px-2 py-1">
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">No se encontrarón grupos para este alumno</h6>
                                            </div>
                                        </div>
                                        <hr> -->

                                        <div id="divAcciones" class="row">
                                            <h3 class="tx-center">Acciones</h3>
                                                <p class="tx-bold tx-30 tx-danger" id="textEnCurso"></p>

                                                <div id="divCrearCurso" class="row mg-b-20">
                                                    <div class="col-6 d-flex justify-content-center text-center">
                                                        <button type="button" onclick="crearCurso()" class="btn btn-outline-danger px-5">
                                                            <span class="material-symbols-outlined">add_circle</span> Crear Grupo
                                                        </button>
                                                    </div>
                                                    <div class="col-6 d-flex justify-content-center">
                                                        <button id="botonAddAlumno" type="button"  onclick="addCursoAlum()" class="btn btn-outline-success px-5 ">
                                                            <span class="material-symbols-outlined">person_add</span> Añadir Alumno
                                                        
                                                        </button>
                                                    </div>
                                                </div>

                                               

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div id="divCursosTab" class="d-none col-12 col-lg-12 col-xl-4 d-flex">
                                    <div class="card w-100">
                                        <div class="card-header bg-transparent">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                            <h6 class="mb-0 fw-bold">Grupo</h6>
                                            </div>
                                            <div class="dropdown ms-auto">
                                        
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                                </li>
                                                <li>
                                                <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="card-body">

                                        <input type="hidden" id="cursoSeleccionado">
                                        <input type="hidden" id="codSeleccionado">
                                        <input type="hidden" id="fechaSeleccionado">
                                        <div class="row justify-content-center text-center">
                                            <div class="col">
                                                <h3 class="h3">Ruta</h3>
                                                <p id="rutaSeleccionada"></p>
                                                <label ><span class="badge bg-dark-subtle text-white border border-dark" id="codSelectText"></span></label>
                                                <label ><span class="badge bg-dark-subtle text-white border border-dark" id="fecSelectText"></span></label>

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center text-center">
                                            <div class="col">
                                                <h3 class="h3">Alumnos</h3>
                                                <p><label >Cantidad: <span class="badge bg-dark-subtle text-white border border-dark" id="capacidadText"></span></label></p>

                                                <div class="col-12" id="alumnos">

                                                </div>
                                             

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center text-center">
                                            <!-- <div class="col">
                                                <h3 class="h3">Aula</h3> <br>

                                                <div class="contenedor-tabla tablaViewAula mg-t-10 mg-b-10 d-none">
                                                    <table class="tabla-view">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Localización</th>
                                                                <th>Capacidad</th>
                                                                <th>Características</th>
                                                                <th>Observación</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td id="nombreAulaView"></td>
                                                                <td id="locaAulaView"></td>
                                                                <td id="capaAulaView"></td>
                                                                <td id="caraAulaView"></td>
                                                                <td id="obsAulaView"></td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="row mg-b-50 mg-t-20">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button type="button" id="botonDupliAlumno" onclick="seleccionarClases()" class="btn btn-outline-info px-5  ">
                                                            <span class="material-symbols-outlined">location_away</span> Seleccionar Aula
                                                        </button>
                                                    </div>
                                                    
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="d-flex flex-column mg-t-10 justify-content-center nombreProfeView d-none align-items-center">
                                                        <b>Profesor Seleccionado</b>
                                                        <p id="nombreSeleccionadoProfeView" class="text-dark font-weight-semibold bg-light border rounded p-3 shadow-sm"></p>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button id="botonAddAlumno" type="button"  onclick="seleccionarProfesor()" class="btn btn-outline-success px-5 ">
                                                            <span class="material-symbols-outlined">person_add</span> Añadir Profesor
                                                        
                                                        </button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-6 d-flex ">
                                        <a  href="index.php" class="btn btn-outline-success px-5 ">
                                            <span class="material-symbols-outlined">arrow_back_ios</span> Volver
                                        
                                        </a>
                                    </div>
                                </div>
                            </div>

                </div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->



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

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
    <?php include_once 'modalClases.php' ?>
    <?php include_once 'modalProfesor.php' ?>

    
    <?php include("../../config/templates/searchModal.php"); ?>
  


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- end BS Scripts-->

    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script> // Definir fechas desde PHP
       $(document).ready(function() {
        $('.card').matchHeight();
        
    });
    flatpickr.localize(flatpickr.l10ns.es);

    var fechaInicio = "<?= $hoy ?>";
    var fechaFin = "<?= $dosSemanasDespues ?>";
    </script>
    <script src="nuevosGrupos.js"></script>

    <!--end plugins extra-->



</body>

</html>
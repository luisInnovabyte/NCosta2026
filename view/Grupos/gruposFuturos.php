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
    
    require_once("../../models/TipoCurso_Edu.php");
    require_once("../../models/Niveles_Edu.php");
    require_once("../../models/Idiomas_Edu.php");

    $idiomas = new Idiomas();
    $datosIdioma = $idiomas->listarIdiomasSelect();
    $cursos = new TipoCurso();
    $datos = $cursos->listarTipoCursoSelect();

    // Fecha actual en formato YYYY-MM-DD (que usa Flatpickr)
    $hoy = date('Y-m-d'); 
    $dosSemanasDespues = date('Y-m-d', strtotime('+14 days'));

    ?>
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
        <!-- Bootstrap Dual Listbox CSS -->
        <link rel="stylesheet" href="../../public/js/listbox/icon_font/css/icon_font.css">
        <link rel="stylesheet" href="../../public/js/listbox/css/jquery.transfer.css">
        <!-- CSS DE LAS TABLAS ALUMNOS -->
        <link rel="stylesheet" type="text/css" href="../../public/js/libs/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css">
    <style>
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }


        .btn-default {
    background-color:rgba(81, 166, 250, 0.73);
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
        
        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }
        #cursosTablaRight tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #cursosTablaRight tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
        }
        #aulas_table tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #aulas_table tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
        }
        #divCursosTablaTodos tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #divCursosTablaTodos tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
        }
        #rutasTabla tbody tr:hover {
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #rutasTabla tbody tr:hover td {
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
        .transfer-demo {
            width: 640px;
            height: 400px;
            margin: 0 auto;
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
                    <h2 class="card-title"> </h2>
                    <div class="my-3 border-top"></div>
                        <!-- CONTENIDO  -->
                        <div class="row ">
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div class="card">
                                    <div class="card-header bg-transparent">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <h6 class="mb-0 fw-bold">Grupos Disponibles</h6>
                                            </div>
                                            <div id="divBotonesNewL" class="dropdown ms-auto d-none">
                                                <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer" onclick="cargarInfoGrupo('1')" data-bs-toggle="dropdown"><i class="tx-info bi bi-eye-fill fs-4"></i>
                                                </button>
                                                
                                            </div>
                                            <!-- <div class="mg-l-50">
                                                
                                                    <select class="select2 js-example-responsive" data-placeholder="SELECCIONE DEPARTAMENTO" style="width: 100%; height: 65px !important;" id="selectDepartamento">
                                                   
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
                                            </div> -->
                                  
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <!-- cursosTablaTodos -->
                                        <div class="col-12" id="divCursosTablaTodos">
                                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                            <div class="row">

                                                <div class="table-responsive order-mobile-first">
                                                <?php
                                                    $nombreTabla = "cursosTablaTodos";
                                                    $nombreCampos = ["ID", "Ruta",  "Código", "Fecha Inicio","Alumnos", "Capacidad", "Serie", "codGrupo","idrutaCursos","codIdioma","codTipoCurso","idNumIdioma","idNumTipoCurso"];
                                                    $nombreCamposFooter = ["ID",  "Ruta","Código", "Fecha Inicio","Alumnos", "Capacidad", "Serie", "codGrupo","idrutaCursos","codIdioma","codTipoCurso","idNumIdioma","idNumTipoCurso"];
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
                                        <!-- Alumnos TablaTodos -->
                                        <div class="col-12 d-none" id="divAlumnosTablaTodos">

                                    
                                            <div class="row">

                                            <div id="labelsRuta" class="d-flex justify-content-center align-items-center text-center p-2" style="font-size: 1.5rem; "></div>
                                            <div class="col-12 row d-flex mg-b-10 justify-content-center align-items-center  border rounded gx-0 p-2 ">
                                                <div id="codigoTablaT" class="col-1">
                                                    <!-- ESIGA1 -->
                                                </div>
                                                <div id="fechaInicioTablaT" class="col-2">
                                                    <!-- 28-02-2025 -->
                                                </div>
                                                <div id="alumnosInscritosTablaT" class="col-1">
                                                    <!-- 3 -->
                                                </div>
                                                <div id="capacidadInscritoTablaT" class="col-3">
                                                    <!-- 1-5 -->
                                                </div>
                                                <div id="identificadorTablaT" class="col-1">
                                                    <!-- 4 -->
                                                </div>
                                                <div id="codGrupoTablaT" class="col-2">
                                                    <!-- 4 -->
                                                </div>
                                               
                                                <input type="hidden" id="idIiomaTablaT">
                                                <input type="hidden" id="idTipoCursoTablaT">

                                            </div>
                                            


                                            <button type="button" onclick="cambiarAlumnoACursos()" class="btn btn-outline-success ">
                                                Volver a Cursos
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-12  col-lg-6 col-xl-6 ">
                                <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="d-flex align-items-center">
                                    <div class="">
                                        <h6 class="mb-0 fw-bold">Grupos Disponibles</h6>
                                    </div>
                             
                                    <div id="divNewGrupo" class="dropdown ms-auto d-none">
                                       
                                    <button type="button"  onclick="cargarRutas()" class="btn-option btn-sm btn-warning cursor-pointer" ><i class=" tx-warning bi bi-file-earmark-plus fs-4"></i> Grupo Nuevo
                                    </button>
                                       
                                    </div>
                                    <div id="divBotonesNewR" class="dropdown ms-auto d-none">
                                       
                                        <button type="button"  onclick="cargarInfoGrupo('2')" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer" ><i class=" tx-info bi bi-eye-fill fs-4"></i>
                                        </button>
                                       
                                    </div>
                                    </div>
                                </div>
                               
                                <div class="card-body">
                                        <div id="alertCursos" class="d-flex align-items-center gap-3 border-start border-danger border-4 border-0 px-2 py-1">
                                            <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Selecciona un grupo para mostrar </h6>
                                            </div>
                                        </div>

                                        <div class="col-12 d-none " id="divCursosRight">
                                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>
                                            
                                            <div class="row">

                                                <div class="table-responsive order-mobile-first">
                                                    <?php
                                                   
                                                    $nombreTabla = "cursosTablaRight";
                                                    $nombreCampos = ["ID", "Ruta",  "Código", "Fecha Inicio","Fecha Fin","Alumnos", "Capacidad", "Serie", "codGrupo"];
                                                    $nombreCamposFooter = ["ID",  "Ruta","Código", "Fecha Inicio","Fecha Fin","Alumnos", "Capacidad", "Serie", "codGrupo"];
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
                                        <div class="col-12 d-none" id="divDatosRutaR">                                                                                                                     
                                            <div class="row">
                                                <p>Al añadir alumnos se creará el siguiente grupo</p>
                                                    <div class="row">
                                                        <div id="rlabelsIdioma" class="d-flex justify-content-center align-items-center text-center p-2 col-4" style="font-size: 1.5rem; "></div>
                                                        <div id="rlabelsTipo" class="d-flex justify-content-center align-items-center text-center p-2  col-4" style="font-size: 1.5rem; "></div>
                                                        <div id="rlabelsNivel" class="d-flex justify-content-center align-items-center text-center p-2  col-4" style="font-size: 1.5rem; "></div>

                                                    </div>
                                                 
                                                    <div class="col-12 row d-flex mg-b-10 justify-content-center align-items-center border rounded gx-0 p-2 text-center">
                                                        <div class="col-4">
                                                            <label for="alumnosText" class="d-block">Aforo Alumnos</label>
                                                            <div id="alumnosText"></div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="pesoText" class="d-block">Peso</label>
                                                            <div id="pesoText"></div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="codigoText" class="d-block">Código</label>
                                                            <div id="codigoTextRT"></div>
                                                            <div id="idRT"></div>

                                                        </div>
                                                    </div>
                                                                                                    


                                                    <button type="button" onclick="cambiarAlumnoACursosRight()" class="btn btn-outline-success ">
                                                        Volver a Cursos
                                                    </button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-12 d-none " id="divRutas">
                                            <div class="row">

                                                <div class="form-group col-md-4 mg-b-20">
                                                    <label for="idioma">Idiomas</label><br>
                                                    <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR IDIOMA" style="width: 100%; height: 65px !important;" id="selectIdioma">
                                                        <?php foreach ($datosIdioma as $row) { ?>
                                                            <option value="<?php echo $row["idIdioma"] ?>"><?php echo $row["descrIdioma"] ?> - <?php echo $row["codIdioma"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="curso">Tipo de Curso</label><br>
                                                    <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CURSO" style="width: 100%; height: 65px !important;" id="selectCurso">
                                                        <?php foreach ($datos as $row) { ?>
                                                            <option value="<?php echo $row["idTipo"] ?>"><?php echo $row["descrTipo"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>               
                                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>
                                            
                                            <div class="row">

                                                <div class="table-responsive order-mobile-first">
                                                    <?php
                                                   
                                                    $nombreTabla = "rutasTabla";
                                                    $nombreCampos = ["Id", "Idioma", "Tipo Curso", "Nivel", "Alumnos", "Periodicidad", "Peso", 'Código', "Estado", "Acciones"];
                                                    $nombreCamposFooter = ["Id", "Idioma", "Tipo Curso", "Nivel", "Alumnos", "Periodicidad", "Peso", 'Código', "Estado", "Acciones"];
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
                                         <!-- Alumnos TablaTodos -->
                                         <div class="col-12 d-none" id="divAlumnosTablaRight">

                                        
                                            <div class="row">

                                                <div id="labelsRutaR" class="d-flex justify-content-center align-items-center text-center p-2" style="font-size: 1.5rem; "></div>
                                                    <div class="col-12 row d-flex mg-b-10 justify-content-center align-items-center  border rounded gx-0 p-2 ">
                                                        <div id="codigoTablaR" class="col-1">
                                                            <!-- ESIGA1 -->
                                                        </div>
                                                        <div id="fechaInicioTablaR" class="col-2">
                                                            <!-- 28-02-2025 -->
                                                        </div>
                                                        <div id="alumnosInscritosTablaR" class="col-1">
                                                            <!-- 3 -->
                                                        </div>
                                                        <div id="capacidadInscritoTablaR" class="col-3">
                                                            <!-- 1-5 -->
                                                        </div>
                                                        <div id="identificadorTablaR" class="col-1">
                                                            <!-- 4 -->
                                                        </div>
                                                        <div id="codGrupoTablaR" class="col-2">
                                                            <!-- 4 -->
                                                        </div>
                                                    </div>
                                                


                                                    <button type="button" onclick="cambiarAlumnoACursosRight()" class="btn btn-outline-success ">
                                                        Volver a Cursos
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                        </div>

                        <!----- LISTA ALUMNOS --> 
                        <div id="divAlumnos" class="col-12  col-lg-12 col-xl-12 d-none">
                                <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="d-flex align-items-center">
                                    <div class="">
                                        <h6 class="mb-0 fw-bold">Alumnos</h6>
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                                        </button>
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
                                           <!--  <h6 class="mb-1 fw-bold">Selecciona un grupo para mostrar la lista</h6> -->
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 mg-b-10">
                                            <select multiple="multiple" size="10" id="listAddAlumnos" class="duallistbox-nuevo-curso">
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" onclick="guardarListasCursos()" class="btn btn-outline-info wd-100p"> Guardar Lista de Grupos</button>

                                        </div>

                                    </div>
                                </div>
                                  
                                   
                                
                        </div>
                        
                        <!--------------->
                        <div class="row">
                                
                                </div>
                                    <div id="divAcciones" class="col-12 col-lg-6 col-xl-4 d-flex d-none">
                                        <div class="card w-100">
                                            <div class="card-header bg-transparent">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                <h6 class="mb-0 fw-bold">Acción</h6>
                                                </div>
                                                <div class="dropdown ms-auto">
                                                <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                                                </button>
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
                                 

                                        <div class="row">
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
    <?php include_once 'modalGrupos.php' ?>

    <?php include_once 'modalAlumno.php' ?>

    
    
    <?php include("../../config/templates/searchModal.php"); ?>
  


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- end BS Scripts-->
   <!-- DUAL LISTBOX -->
    <script src="../../public/js/libs/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="../../public/js/dist/pages/forms/dual-listbox/dual-listbox.js"></script>
    <!-- Bootstrap Dual Listbox JS -->
    <script src="../../public/js/listbox/js/jquery.transfer.js"></script>    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script> // Definir fechas desde PHP
     
    flatpickr.localize(flatpickr.l10ns.es);

    var fechaInicio = "<?= $hoy ?>";
    var fechaFin = "<?= $dosSemanasDespues ?>";
    </script>
    <script src="gestionGrupos1.js"></script>
    <script>
    
    </script>
    <!--end plugins extra-->



</body>

</html>
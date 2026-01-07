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
        /* From Uiverse.io by ozgeozkaraa01 */
        .container {
            display: flex;
            justify-content: left;
            align-items: left;
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

        .custom-radio input[type="radio"]:checked+.radio-label {
            background-color: #ffcc00;
        }

        .custom-radio input[type="radio"]:checked+.radio-label .radio-circle {
            border-color: #fff;
            background-color: #ffcc00;
        }

        .custom-radio input[type="radio"]:checked+.radio-label .radio-text {
            color: #000;
        }

        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }

        .bd-red {
            border: 1px solid red;
        }

        #tablaCentral td:nth-child(4),
        th:nth-child(4) {
            width: 190px;
            /* Ajusta el tamaño según tu diseño */
            min-width: 190px;
            max-width: 190px;
            text-align: center;
            white-space: nowrap;
            /* Evitar que el contenido se ajuste en varias líneas */
        }

        #tablaAlojamientos {
            width: 100%;
            table-layout: fixed;
            /* Para que las columnas tengan el mismo tamaño */
            border-collapse: collapse;
            /* Para eliminar el espacio entre las celdas */
        }

        #tablaAlojamientos th,
        #tablaAlojamientos td {
            width: 25%;
            /* Todas las columnas con el mismo ancho */
            text-align: center;
        }

        #tablaAlojamientos input {
            border: none;
            background: none;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            /* Para asegurar que el ancho del input respete el tamaño de la celda */
        }

        #tablaRecepcion {
            width: 100%;
            table-layout: fixed;
            /* Para que las columnas tengan el mismo tamaño */
            border-collapse: collapse;
            /* Para eliminar el espacio entre las celdas */
        }

        #tablaRecepcion th,
        #tablaRecepcion td {
            width: 25%;
            /* Todas las columnas con el mismo ancho */
            text-align: center;
        }

        #tablaRecepcion input {
            border: none;
            background: none;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            /* Para asegurar que el ancho del input respete el tamaño de la celda */
        }

        #tablaCentral {
            width: 100%;
            table-layout: fixed;
            /* Mantiene las proporciones de las columnas */
            border-collapse: collapse;
            /* Elimina los espacios entre celdas */
        }

        #tablaCentral th,
        #tablaCentral td {
            text-align: center;
        }

        /* Reducir el ancho de las columnas "Cursos", "Alojamiento", "Otros" */
        #tablaCentral .rowSpanTD {
            width: 5%;
            /* Asigna un menor ancho para estas etiquetas */
        }

        /* Ajustar el ancho de la columna "Código" */
        #tablaCentral th:nth-child(2),
        #tablaCentral td:nth-child(2) {
            width: 20%;
            /* Asigna un ancho de 20% para la columna Código */
            text-align: left !important;
            /* Alinea el contenido de la columna a la izquierda */
        }

        /* Ajustar el ancho de la columna "Concepto" */
        #tablaCentral th:nth-child(3),
        #tablaCentral td:nth-child(3) {

            width: 45%;

            /* Asigna un mayor espacio a la columna Concepto */
            text-align: left !important;
            /* Alinea el contenido de la columna a la izquierda */

        }

        /* Reducir el ancho de la columna "Importe" */
        #tablaCentral th:nth-child(4),
        #tablaCentral td:nth-child(4) {

            width: 8%;
            /* Asigna un ancho de 20% para la columna de Importe */
        }

        #tablaCentral th:nth-child(5),
        #tablaCentral td:nth-child(5) {
            width: 12%;
            /* Asigna un ancho de 20% para la columna de Importe */
        }

        #tablaCentral th:nth-child(6),
        #tablaCentral td:nth-child(6) {
            width: 10%;
            /* Asigna un ancho de 20% para la columna de Importe */
        }

        /* Estilo para los inputs en la columna de importe */
        #tablaCentral input {
            border: none;
            background: none;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            /* Asegura que el input se ajuste al tamaño de la celda */
        }

        /* Estilo del contenedor de sugerencias */
        .suggestions-list {
            position: absolute;
            width: 400px;
            border: 1px solid #ccc;
            background-color: white;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            /* Asegura que las sugerencias se muestran sobre otros elementos */
            display: none;
            /* Ocultamos inicialmente */
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
        <input type="hidden" id="idProforma" value="<?php echo $_GET["idProforma"] ?>">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">

                        <li class="breadcrumb-item" aria-current="page">LISTADO PROFORMAS</li>
                        <li class="breadcrumb-item active" aria-current="page">VER PROFORMA</li>

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
                <div class="card-body ">
                    <h2 class="card-title">FACTURA PROFORMA</h2>
                    <div class="my-3 border-top"></div>
                    <div class="container col-12">
                        <div class="row">

                            <div class="col-12">

                                <div class="card bg-light border shadow-sm p-3">
                                    <!-- Llegada semana -->
                                    <div class="mb-3">
                                        <input type="hidden" id="idCabecera">
                                        <input type="hidden" id="idPie">
                                        <input type="hidden" id="serie">
                                        <label class="fw-bold">INFORMACIÓN DEL ALUMNO - NOMBRE: <label id="nombreFacturacion"></label></label>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">Pais:</span>
                                            <input type="text" id="paisFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">Ciudad:</span>
                                            <input type="text" id="ciudadFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">CP:</span>
                                            <input type="text" id="cpFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">Dirección:</span>
                                            <input type="text" id="direcFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">Provincia:</span>
                                            <input type="text" id="provFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">Teléfono:</span>
                                            <input type="text" id="tefFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">Móvil:</span>
                                            <input type="text" id="movilFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">Correo:</span>
                                            <input type="text" id="correoFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex col-4 justify-content-center">
                                            <span class="fw-bold mg-t-7">CIF:</span>
                                            <input type="text" id="cifFact" class="tx-left-force w-auto form-control" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container col-12">

                        <div class="row">
                            <!-- Sección izquierda -->
                            <div class="col-12 col-xl-3">
                                <div class="card bg-light border shadow-sm p-3">
                                    <!-- Llegada Núm. -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Llegada Núm.</label>
                                        <input disabled type="text" id="llegadaNum" class="tx-center mb-2 tx-left-force tx-20" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">

                                    </div>

                                    <!-- Alumno -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Alumno</label>
                                        <input disabled type="text" class="tx-center mb-2 tx-left-force" id="nombreAlumno" disabled value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">

                                        <div class="d-flex">
                                            <span class="fw-bold me-2">Sexo:</span>
                                            <input disabled type="text" class="tx-center w-auto tx-left-force" id="sexoAlumno" disabled value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">

                                        </div>
                                    </div>

                                    <!-- Matriculación -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Matriculación</label><!-- <button class="mg-l-10 btn btn-success" id="agregarMatriculacion"><i class="fa-solid fa-plus"></i></button> -->
                                        <table class="col-12" id="tablaCursos">
                                            <tr>
                                                <th class="tx-bold tx-center">Curso</th>
                                                <th class="tx-bold tx-center">Inicio</th>
                                                <th class="tx-bold tx-center">Final</th>

                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Alojamiento -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Alojamiento</label><!-- <button class="mg-l-10 btn btn-success" id="agregarAlojamiento"><i class="fa-solid fa-plus"></i></button> -->
                                        <table class="col-12" id="tablaAlojamientos">
                                            <tr>
                                                <th class="tx-bold tx-center">Aloj.</th>
                                                <th class="tx-bold tx-center">Entrada</th>
                                                <th class="tx-bold tx-center">Final</th>
                                                <th class="tx-bold tx-center">Hora Salida</th>

                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Transfer -->

                                    <div class="mb-3">
                                        <h6 class="fw-bold">Transfer Llegada</h6>

                                        <table class="col-12" id="tablaRecepcion">
                                            <tr>
                                                <th class="tx-bold tx-center">Tarifa</th>
                                                <th class="tx-bold tx-center">Día</th>
                                                <th class="tx-bold tx-center">Recogida</th>
                                                <th class="tx-bold tx-center">Entrega</th>

                                            </tr>
                                            <tr>
                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferLlegada" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferLlegadaDia" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferLlegadaLugar" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>
                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferLlegadaLugarEntrega" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>


                                            </tr>
                                        </table>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="fw-bold">Transfer Regreso</h6>

                                        <table class="col-12" id="tablaRecepcion">
                                            <tr>
                                                <th class="tx-bold tx-center">Tarifa</th>
                                                <th class="tx-bold tx-center">Día</th>
                                                <th class="tx-bold tx-center">Recogida</th>
                                                <th class="tx-bold tx-center">Entrega</th>

                                            </tr>
                                            <tr>
                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferRecogida" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferRecogidaDia" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferRecogidaLugar" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>
                                                <td class="tx-center">
                                                    <input disabled type="text" id="idTransferRecogidaLugarEntrega" class="tx-center" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Recepción -->
                                    <!-- <div class="mb-3">
                                        <h6 class="fw-bold">Recepción</h6>

                                        <table class="col-12" id="tablaRecepcion">
                                            <tr>
                                                <th class="tx-bold tx-center">Semana</th>
                                                <th class="tx-bold tx-center">Día</th>
                                                <th class="tx-bold tx-center">Hora</th>
                                                <th class="tx-bold tx-center">Lugar</th>

                                            </tr>
                                            <tr>
                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="<?php echo '--'; ?>" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="<?php echo '--'; ?>" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="<?php echo '--'; ?>" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="<?php echo '--'; ?>" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>


                                            </tr>
                                        </table>
                                        <br>
                                        <textarea class="form-control" id="transferObs" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;"></textarea>
                                    </div> -->
                                </div>

                                <div class="card bg-light border shadow-sm p-3">
                                    <!-- Llegada semana -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Llegada Dia</label>
                                        <input type="text" class="form-control text-center" id="llegadaDia" value="" disabled>
                                    </div>
                                    <div>
                                        <label class="fw-bold">Llegada Semana Número</label>
                                        <input type="text" class="form-control text-center" id="llegadaSemana" value="" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección central -->
                            <div class="col-12 col-xl-7">
                                <div class="card bg-light border shadow-sm p-3">

                                    <!-- Factura Proforma -->
                                    <div class="mb-3 tx-center">

                                        <label class="fw-bold">FACTURA PROFORMA</label>



                                    </div>

                                    <!-- Conceptos (Tabla actualizada) -->

                                    <!-- <div class="mg-b-10 d-flex justify-content-end">
                                        <button type="button" class="btn btn-success dropdown-toggle col-2" data-bs-toggle="dropdown" aria-expanded="false">Agregar</button>

                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" id="addCurso">Curso</a>
                                            </li>
                                            <li><a class="dropdown-item" id="addAlojamiento">Alojamiento</a>
                                            </li>
                                            <li><a class="dropdown-item" id="addOtro">Otro</a>
                                            </li>
                                        </ul>
                                    </div> -->


                                    <table class="table table-bordered" id="tablaCentral">
                                        <thead class="bg-secondary text-white">
                                            <tr>
                                                <th style="background-color: #F8F9FA; border: none"></th> <!-- Columna vacía para la rotación -->
                                                <th>Código</th>
                                                <th>Concepto</th>
                                                <th>IVA</th>
                                                <th>Descuento</th>
                                                <th>Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="rowCursos">
                                                <td rowspan="1" class="rowSpanTD align-middle bg-trant">

                                                    <div class="rotate-text"> [Dto.<input id="descGrupoCurso" style="height: 30px !important" value="0">%]</div>
                                                </td>
                                            </tr>
                                            <!-- <tr>


                                                <td>


                                                    <div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="docenciaInput inputTextFill tx-left-force" value="i5" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> 
                                                    </div>
                                                    <button data-type="Docencia" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button>
                                                </td>
                                                <td><input type="text" class="tx-left-force" value="Curso intensivo, Estancia lingüística Diemer, Christine (5 semanas)" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
                                                <td class="tx-center"><input type="text" class="inputImporte tx-center-force" value="830,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

                                            </tr>
                                            <tr>
                                                <td><div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="docenciaInput inputTextFill tx-left-force" value="el" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> 
                                                    </div>
                                                    <button data-type="Docencia" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
                                                <td><input type="text" class="tx-left-force" value="Estancia lingüística (5 semanas)" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
                                                <td class="tx-center"><input type="text" class="inputImporte tx-center-force" value="0,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
                                            </tr> -->
                                            <tr id="rowAloja">
                                                <td rowspan="1" class="rowSpanTD align-middle bg-trant">
                                                    <div class="rotate-text">Alojamiento [Dto.<input id="descGrupoAloja" style="height: 30px !important" value="0">%]</div>
                                                </td>
                                            </tr>
                                            <!-- <tr>

                                                <td><div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="alojamientoInput inputTextFill tx-left-force" value="hi5" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> 
                                                    </div>
                                                    <button data-type="Alojamiento" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
                                                
                                                
                                                
                                                <td><input type="text" class="tx-left-force" value="Habitación individual (5 semanas)	" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
                                                <td class="tx-center"><input type="text" class="inputImporte tx-center-force" value="765,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

                                            </tr> -->
                                            <tr id="rowOtros">
                                                <td rowspan="1" class="rowSpanTD align-middle bg-trant">
                                                    <div class="rotate-text">Otros [Dto.<input id="descGrupoOtro" style="height: 30px !important" value="0">%]</div>
                                                </td>
                                            </tr>
                                            <!-- <tr>

                                                <td><div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="otroInput inputTextFill tx-left-force" value="m" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> 
                                                    </div>
                                                    <button data-type="Otro" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
                                                
                                                
                                                <td><input type="text" class="tx-left-force" value="Matricula" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
                                                <td class="tx-center"><input type="text" class="inputImporte tx-center-force" value="35,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

                                            </tr>
                                            <tr>
                                                <td><div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="otroInput inputTextFill tx-left-force" value="com" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> 
                                                    </div>
                                                    <button data-type="Otro" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
                                                <td><input type="text" class="tx-left-force" value="Agente 30%" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
                                                <td class="tx-center"><input type="text" class="inputImporte tx-center-force" value="-214,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
                                            </tr> -->
                                        </tbody>
                                    </table>

                                    <!-- Totales -->
                                    <div class="d-flex justify-content-end">
                                        <div class="text-end">
                                            <p>Total Cursos: <label id="totalCursos"></label></p>
                                            <p>Total Alojamiento: <label id="totalAloja"></label></p>
                                            <p>Total Otros: <label id="totalOtros"></label></p>
                                            <p>Descuento Cursos (<label id="descuentoTotalCurso">0</label>%): <label id="totalCursosDto"></label></p>
                                            <p>Descuento Alojamiento(<label id="descuentoTotalAloja">0</label>%): <label id="totalAlojaDto"></label></p>
                                            <p>Descuento Otros(<label id="descuentoTotalOtro">0</label>%): <label id="totalOtrosDto"></label></p>
                                            <p>Total sin IVA: <label id="totalSinIva"></label></p>
                                            <p>Total con Descuento (<label id="descuentoTotal">0</label>%): <label id="totalConDescuento"></label></p>

                                            <div id="groupIVA">

                                            </div>

                                            <p class="fw-bold">Total Factura: <label id="totalConIva"></label></p>
                                            <p class="fw-bold">Ya pagado: <input type="text" id="YaPagado" class="tx-right-force" value="<?php echo '0€'; ?>" style="width:30% !important;border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <button class="col-12 col-lg-5 btn btn-info waves-effect" data-bs-toggle="modal" data-bs-target="#imprimir-modal" >IMPRIMIR</button>
                                        <button class="col-12 col-lg-5 btn btn-success waves-effect mg-t-10 mg-lg-t-0 mg-lg-l-10" id="guardarProformaBtn">EDITAR PROFORMA</button>
                                        <button class="col-12 col-lg-5 btn btn-warning waves-effect mg-t-10 mg-lg-l-10" id="facturaeButton">FACTURAE</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección derecha -->
                            <div class="col-12 col-xl-2">

                                <div class="card bg-light border shadow-sm p-3">

                                    <!-- Cliente Info -->
                                    <div class="mb-3">
                                        <label class="fw-bold">DATOS FACTURA PROFORMA</label>
                                        <div class="d-flex">
                                            <label class="fw-bold mg-t-7">FECHA:</label>
                                            <input type="text" class="tx-left-force w-auto form-control" id="fechaHoyFactura" disabled value="<?php echo date('d/m/Y'); ?>" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">

                                        </div>
                                        <div class="d-flex">
                                            <span class="fw-bold mg-t-7">NÚMERO:</span>
                                            <input type="text" id="numProforma" class="tx-left-force w-auto form-control" disabled value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">

                                        </div>
                                    </div>
                                </div>
                                <div class="card bg-light border shadow-sm p-3">

                                    <!-- Cliente Info -->
                                    <div class="mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold mg-t-7">Agente:</span>
                                            <label type="text" class="tx-left-force w-auto form-control" disabled id="agenteProforma" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                        </div>
                                        <div class="d-flex">
                                            <label class="fw-bold mg-t-7">Grupo Fact:</label>
                                            <label type="text" class="tx-left-force w-auto form-control" id="grupoFact" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;"></label>
                                        </div>
                                        <div class="d-flex">
                                            <label class="fw-bold mg-t-7">Grupo Amigos:</label>
                                            <label type="text" class="tx-left-force w-auto form-control" id="grupoAmigos" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;"></label>
                                        </div>
                                        <div class="d-flex">
                                            <label class="fw-bold mg-t-7">Factura A:</label>
                                            <label type="text" class="tx-left-force w-auto form-control" id="facturaA" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;"></label>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <!-- Estilos CSS para la rotación de texto -->
                    <style>
                        .rotate-text {
                            transform: rotate(-180deg);
                            white-space: nowrap;
                            text-align: center;
                            height: auto;
                            /* Ajusta la altura para espacio adecuado */
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            writing-mode: vertical-rl;
                            /* Mejora la alineación vertical */
                        }

                        .bg-trant {
                            background-color: transparent !important;
                            border: none !important;
                        }
                    </style>

                </div>
            </div>

    </main>
    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalTarifas.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
    <?php include_once 'modalImprimir.php' ?>

    <?php include("../../config/templates/searchModal.php"); ?>



    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->


    <script src="https://unpkg.com/iso-3166-1@0.4.0/iso-3166-1.min.js"></script>

    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>
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
    require_once("../../models/Llegadas.php");
    // MODELS DE PROFORMA AÑADIDO PARA SABER SI EXISTE O NO PROFORMAS ACTIVAS PARA ESTA LLEGADA
    require_once("../../models/Proforma.php");
    // MODELS DE PROFORMA AÑADIDO PARA SABER SI EXISTE O NO PROFORMAS ACTIVAS PARA ESTA LLEGADA

    $idLlegada = $_GET['idLlegada'];

    $llegada = new Llegadas();
    $datosLlegada = $llegada->recogerLlegadasHomexId($idLlegada);
 
    $idPrescriptor = $datosLlegada[0]['idprescriptor_llegadas'];
    $idAgente =  $datosLlegada[0]['agente_llegadas'];
    $grupoFacturacion =  $datosLlegada[0]['grupo_llegadas'];
    
    $idDepartamento =  $datosLlegada[0]['iddepartamento_llegadas'];

    $datosPagoAnticipado = $llegada->totalPagado($idLlegada);
    $totalImporte =  $datosPagoAnticipado[0]['totalImporte'];

    // CREO UN OBJETO DE PROFORMA Y ME GUARDO SI EXISTE O NO UNA PROFORMA PARA ESTA LLEGADA ACTUALMENTE (RETORNA 1 = EXISTE O 0 = NO EXISTE)
    $proforma = new Proforma();
    $totalSuplido = $proforma -> recogerSuplidosXLlegadaSuma($idLlegada);

    $existeProforma = $proforma -> comprobarFacturaProExistente($idLlegada);
    // CREO UN OBJETO DE PROFORMA Y ME GUARDO SI EXISTE O NO UNA PROFORMA PARA ESTA LLEGADA ACTUALMENTE (RETORNA 1 = EXISTE O 0 = NO EXISTE)

    // DATOS TRANSFER // 
    $textotariotallegadaTransfer_llegadas = $datosLlegada[0]['textotariotallegadaTransfer_llegadas'];
    $codigotariotallegadaTransfer_llegadas = $datosLlegada[0]['codigotariotallegadaTransfer_llegadas'];
    $importetariotallegadaTransfer_llegadas = $datosLlegada[0]['importetariotallegadaTransfer_llegadas'];
    $ivatariotallegadaTransfer_llegadas = $datosLlegada[0]['ivatariotallegadaTransfer_llegadas'];

    $textotariotalregresoTransfer_llegadas = $datosLlegada[0]['textotariotalregresoTransfer_llegadas'];
    $codigotariotalregresoTransfer_llegadas = $datosLlegada[0]['codigotariotalregresoTransfer_llegadas'];
    $importetariotalregresoTransfer_llegadas = $datosLlegada[0]['importetariotalregresoTransfer_llegadas'];
    $ivatariotalregresoTransfer_llegadas = $datosLlegada[0]['ivatariotalregresoTransfer_llegadas'];



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

      /* Estilo para la tabla */
      #facturaTabla {
            border-collapse: separate; /* para controlar bordes */
            border-spacing: 0;
            width: 100%;
            border-radius: 12px;
        }

        /* Líneas horizontales entre filas */
        #facturaTabla thead tr,
        #facturaTabla tbody tr {
            border-bottom: 1px solid #ddd;
        }

            /* No bordes verticales en celdas */
        #facturaTabla th,
        #facturaTabla td {
            border: none;
            padding: 10px 12px;
        }

            /* Header destacado con azul Bootstrap */
        #facturaTabla thead th {
            background-color: #e2a65dff; /* azul claro */
            color: white;
            font-weight: 600;
            text-align: center;
        }

            /* Filas alternas para mejor lectura */
        #facturaTabla tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Hover filas */
        #facturaTabla tbody tr:hover {
            background-color: #e0f0d9;
        }

        #abrirModalFacturas {
            background-color: #e2a65dff; /* azul claro */
            border-color: #e2a65dff;
            
        }

        #abrirModalFacturas:hover {
            background-color: #de9e4fff; /* azul un poco más oscuro al hover */
            border-color: #de9e4fff;
            color: white;
        }


        .disabled-radio {
            pointer-events: none; /* lo deshabilita */
            opacity: 0.6;         /* opcional: aspecto de deshabilitado */
        }

        /* Fondo discreto para identificar pantalla de PROFORMA */
        body {
            background: linear-gradient(135deg, #fff8f0 0%, #fef5e7 25%, #fff8f0 50%, #fef5e7 75%, #fff8f0 100%);
            background-attachment: fixed;
            position: relative;
        }

        /* Marca de agua visible en varias esquinas */
        body::before {
            content: "FACTURA PROFORMA";
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            font-weight: 700;
            color: rgba(226, 166, 93, 0.04);
            letter-spacing: 8px;
            z-index: 0;
            pointer-events: none;
            white-space: nowrap;
        }

        body::after {
            content: "PROFORMA";
            position: fixed;
            bottom: 30px;
            right: 30px;
            font-size: 18px;
            font-weight: 700;
            color: rgba(226, 166, 93, 0.6);
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 16px;
            border-radius: 8px;
            border: 2px solid rgba(226, 166, 93, 0.3);
            letter-spacing: 3px;
            z-index: 1000;
            pointer-events: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Asegurar que el contenido esté encima */
        .page-content {
            position: relative;
            z-index: 1;
        }

        /* Aplicar tinte suave a las tarjetas para mantener coherencia */
        .card {
            background: rgba(254, 245, 231, 0.5) !important;
            backdrop-filter: blur(10px);
        }

        /* Mantener algunos cards con fondo claro pero con tinte */
        .card.bg-light {
            background: rgba(255, 248, 240, 0.7) !important;
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
         <!-- NUEVO INPUT HIDDEN PARA SABER CUANDO HAY O NO UNA PROFORMA EXISTENTE -->
        <input type="hidden" id="existeProforma" value="<?php echo $existeProforma; ?>">
         <!-- NUEVO INPUT HIDDEN PARA SABER CUANDO HAY O NO UNA PROFORMA EXISTENTE -->
        <input type="hidden" id="idPrescriptor" value="<?php echo $idPrescriptor; ?>">
        <input type="hidden" id="idLlegada" value="<?php echo $_GET["idLlegada"]; ?>">
        <input type="hidden" id="idAgente" value="<?php echo $idAgente; ?>">
        <input type="hidden" id="nombreGrupoFacturacion" value="<?php echo $grupoFacturacion; ?>">
        <input type="hidden" id="idDepartamento" value="<?php echo $idDepartamento; ?>">
        <input type="hidden" id="serie">


        <!-- TRANSFER DATOS FACTURAR -->
        <input type="hidden" id="textotariotallegadaTransfer_llegadas" value="<?php echo $textotariotallegadaTransfer_llegadas; ?>">
        <input type="hidden" id="codigotariotallegadaTransfer_llegadas" value="<?php echo $codigotariotallegadaTransfer_llegadas; ?>">
        <input type="hidden" id="importetariotallegadaTransfer_llegadas" value="<?php echo $importetariotallegadaTransfer_llegadas; ?>">
        <input type="hidden" id="ivatariotallegadaTransfer_llegadas" value="<?php echo $ivatariotallegadaTransfer_llegadas; ?>">

        <input type="hidden" id="textotariotalregresoTransfer_llegadas" value="<?php echo $textotariotalregresoTransfer_llegadas; ?>">
        <input type="hidden" id="codigotariotalregresoTransfer_llegadas" value="<?php echo $codigotariotalregresoTransfer_llegadas; ?>">
        <input type="hidden" id="importetariotalregresoTransfer_llegadas" value="<?php echo $importetariotalregresoTransfer_llegadas; ?>">
        <input type="hidden" id="ivatariotalregresoTransfer_llegadas" value="<?php echo $ivatariotalregresoTransfer_llegadas; ?>">




        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">

                        <li class="breadcrumb-item" aria-current="page">Interesados</li>
                        <li class="breadcrumb-item" aria-current="page">Llegadas</li>
                        <li class="breadcrumb-item active" aria-current="page">Facturación</li>

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
                    <div class="d-flex align-items-center gap-2">
                        <h2 class="card-title mb-0">GENERACIÓN de FACTURAS PROFORMA</h2>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#ayuda-modal" title="Ver información de ayuda">
                            <i class="bx bx-help-circle"></i>
                        </button>
                    </div>
                    <div class="my-3 border-top"></div>
                    <div class="container col-12">
                        <div class="row col-12 ">

                            <div class="col-12">

                               <div class="card bg-light border shadow-sm p-3">
                                    <!-- Título -->
                                    <div class="mb-3 ">
                                        <label class="fw-bold">INFORMACIÓN DEL ALUMNO - NOMBRE: <input class="form-control" id="nombreFacturacion"></input></label>
                                    </div>

                                    <div class="row">
                                        <!-- Columna izquierda -->
                                        <div class="col-md-6 mb-2">
                                            <div class="mb-2">
                                                <label class="fw-bold">CIF:</label>
                                                <input type="text" id="cifFact" class="form-control" style="">
                                            </div>
                                            <div class="mb-2 row">
                                                <div class="col-6">
                                                    <label class="fw-bold">Móvil:</label>
                                                    <input type="text" id="movilFact" class="form-control" style="">
                                                </div>
                                                <div class="col-6">
                                                    <label class="fw-bold">Teléfono:</label>
                                                    <input type="text" id="tefFact" class="form-control" style="">
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label class="fw-bold">Correo:</label>
                                                <input type="text" id="correoFact" class="form-control" style="">
                                            </div>
                                        </div>

                                        <!-- Columna central -->
                                        <div class="col-md-6 mb-2">
                                            <div class="mb-2">
                                                <label class="fw-bold">Dirección:</label>
                                                <input type="text" id="direcFact" class="form-control" style="">
                                            </div>
                                            <div class="mb-2">
                                                <label class="fw-bold">CP:</label>
                                                <input type="text" id="cpFact" class="form-control" style="">
                                            </div>
                                            <div class="mb-2">
                                                <label class="fw-bold">País:</label>
                                                <input type="text" id="paisFact" class="form-control" style="" >
                                            </div>
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
                                    <form>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="codigoFacturaContenido" class="form-label fw-bold">Código Factura</label>
                                                <input type="text" class="form-control" id="codigoFacturaContenido" name="codigoFacturaContenido" required>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="conceptoFacturaContenido" class="form-label fw-bold">Concepto</label>
                                                <input type="text" class="form-control" id="conceptoFacturaContenido" name="conceptoFacturaContenido" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4 d-none">
                                                <label for="tipoFacturaContenido" class="form-label fw-bold">Tipo de Factura</label>
                                                <select class="form-select" id="tipoFacturaContenido" name="tipoFacturaContenido">
                                                    <option selected value="1">Matriculaciones</option>
                                                    <option value="2">Alojamientos</option>
                                                    <option value="3">Otros</option>
                                                    <option value="4">transfer</option>

                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="ivaFacturaContenido" class="form-label fw-bold">IVA (%)</label>
                                                <input type="text" class="form-control" id="ivaFacturaContenido" name="ivaFacturaContenido" min="0" step="0.01">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="descuentoFacturaContenido" class="form-label fw-bold">Descuento (%)</label>
                                                <input type="text" class="form-control" id="descuentoFacturaContenido" name="descuentoFacturaContenido" min="0" step="0.01">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="importeFacturaContenido" class="form-label fw-bold">Total (€)</label>
                                                <input type="text" class="form-control" id="importeFacturaContenido" name="importeFacturaContenido" min="0" step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center accionesTarifa">
                                            
                                            <div class="d-flex gap-2 editarOn d-none">
                                                <p class="mb-0 me-auto px-2 py-1 border rounded bg-light text-muted parpadeo" style="min-width: 150px;">
                                                    Editando Tarifa <b id="idEditando" class="text-dark">5</b>
                                                </p>
                                                <button type="button" onclick="cancelarEdicion()" id="btnCancelar" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar la edición actual y descartar los cambios">Cancelar</button>
                                                <button type="button" onclick="guardarEdicion()" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Guardar los cambios realizados en la tarifa">Guardar Edición</button>
                                            </div>
                                            <div class="d-flex gap-2 editarOff">
                                                <button type="button" class="btn btn-primary abrirModalGrupo d-none parpadeo" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                title="Recoger los datos de llegada de todo un grupo" <?php echo ($existeProforma == 1) ? 'disabled' : ''; ?>>Datos llegadas Grupo</button>
                                                <button type="button"  class="btn btn-info abrirModalLlegadas" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                title="Recoger los datos de llegada" <?php echo ($existeProforma == 1) ? 'disabled' : ''; ?>>Datos llegadas</button>
                                                <button type="button" class="btn btn-warning abrirModalTarifas" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                title="Añadir una nueva concepto a facturar" <?php echo ($existeProforma == 1) ? 'disabled' : ''; ?>>Añadir Concepto</button>
                                                <button type="button" onclick="guardarFactura()" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                title="Guardar el concepto actual" <?php echo ($existeProforma == 1) ? 'disabled' : ''; ?>>Guardar Concepto</button>

                                            </div>
                                        </div>


                                    </form>
                                </div>


                              
                                 <div class="card bg-light border shadow-sm p-3">

                                    <!-- Cliente Info -->
                                    <div class="mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold mg-t-7">Agente:</span>
                                            <label type="text" class="tx-left-force w-auto form-control" disabled id="agenteProforma" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                            <?php echo $datosLlegada[0]['nombreAgente'];?> </label>
                                        </div>
                                        <div class="d-flex">
                                            <label class="fw-bold mg-t-7">Grupo Fact:</label>
                                            <label type="text" class="tx-left-force w-auto form-control" id="grupoFact" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;"> <?php echo $datosLlegada[0]['grupo_llegadas'];?> </label>
                                        </div>
                                        <div class="d-flex">
                                            <label class="fw-bold mg-t-7">Grupo Amigos/Familia:</label>
                                            <label type="text" class="tx-left-force w-auto form-control" id="grupoAmigos" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;"><?php echo $datosLlegada[0]['grupoAmigos'];?></label>
                                        </div>
                                    </div>
                                    <div class="mb-3">

                                        <label class="fw-bold">A QUIEN SE FACTURA</label>
                                        <div class="container">
                                           <div class="custom-radio">
                                                <input type="radio" class="radioQuienFactura" id="radioAlumno" name="tabs" value="1" checked>
                                                <label class="radio-label" for="radioAlumno">
                                                    <div class="radio-circle"></div>
                                                    <span class="radio-text">Alumno</span>
                                                </label>

                                                <input type="radio" class="radioQuienFactura" id="agenteAlumno" name="tabs" value="2">
                                                <label class="radio-label" for="agenteAlumno">
                                                    <div class="radio-circle"></div>
                                                    <span class="radio-text">Agente</span>
                                                </label>
                                                <?php if($grupoFacturacion != ''){ ?>
                                                <input type="radio" class="radioQuienFactura" id="grupoAlumno" name="tabs" value="3">
                                                <label class="radio-label" for="grupoAlumno">
                                                    <div class="radio-circle"></div>
                                                    <span class="radio-text">Grupo</span>
                                                </label>
                                                <?php }else{ ?>

                                                <label class="radio-label disabled-radio" for="">
                                                    <div class="radio-circle"></div>
                                                    <span class="radio-text">Sin Grupo</span>
                                                </label>


                                               <?php } ?>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                  <div class="card bg-light border shadow-sm p-3">
                                    <!-- Llegada día -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Llegada Día</label>
                                        <input type="text" class="form-control text-center" id="llegadaDia"
                                            value="<?php echo !empty($datosLlegada[0]['fechallegada_llegadas']) ? FechaHoraLocal($datosLlegada[0]['fechallegada_llegadas']) : 'Sin fecha'; ?>"
                                            disabled>
                                    </div>

                                    <!-- Llegada semana -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Llegada Semana Número</label>
                                        <input type="text" class="form-control text-center" id="llegadaSemana"
                                            value="<?php
                                                $fecha = $datosLlegada[0]['fechallegada_llegadas'] ?? '';
                                                echo !empty($fecha) ? (new DateTime($fecha))->format('W') : '';
                                            ?>"
                                            disabled>
                                    </div>

                                    <!-- Concepto Extra -->
                                    <div class="mb-3 text-center">
                                        <label class="fw-bold">Concepto Extra</label>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" id="conceptoExtra" rows="4" placeholder="Escribe aquí el concepto extra..."><?php echo !empty($datosLlegada[0]['textoLibreFacturaProforma']) ? $datosLlegada[0]['textoLibreFacturaProforma'] : ''; ?></textarea>
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
                                        <div class="col-12" id="">
                                           

                                            <div class="row">

                                                <div class="table-responsive order-mobile-first">
                                                 
                                                <?php
                                                    $nombreTabla = "facturaTabla";
                                                    $nombreCampos = ["ID", "Código",  "Concepto", "Tipo","Descuento (%)","Base Imponible (€)","IVA (%)","Total (€)","Gestionar"];
                                                    $nombreCamposFooter = ["ID", "Código",  "Concepto", "Tipo","Descuento","Base Imponible","IVA","Total","Gestionar"];
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

                                                                        
                                        <div class="w-100 px-4 mt-4">
                                        <div class="card shadow-lg border-0">
                                            <div class="card-body">
                                            <h4 class="card-title text-primary mb-4">💼 Resumen de Factura Proforma</h4>

                                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                                <div class="col">
                                                    <p><strong>Total Cursos / Aloja:</strong> <span class="float-end" id="totalCursos"></span></p>
                                                    <!-- <p><strong>Total Transfer:</strong> <span class="float-end" id="totalAloja"></span></p> -->
                                                    <p><strong>Total Suplidos:</strong> <span class="float-end" id="totalSuplidos"><?php echo  $totalSuplido;?>€</span></p>
                                                </div>

                                                <div class="col">
                                                    <p><strong>Total sin IVA:</strong> <span class="float-end" id="totalSinIva"></span></p>
                                                    <p><strong>Ya Pagado:</strong> <span class="float-end" id="YaPagado"><?php echo !empty($totalImporte) ? $totalImporte : '0'; ?> €</span></p>
                                                    <div id="groupIVA" class="mb-2"></div>
                                                    <p><strong>Total con IVA:</strong> <span class="float-end" id="totalCompletoConIva"></span></p>
                                                    <p class="fs-5 fw-bold text-success">Total Pendiente: <span class="float-end" id="totalConIva"></span></p>
                                                </div>
                                            </div>

                                            <div class="text-center my-3">
                                                <?php if ($existeProforma == 0): ?>
                                                    <button id="guardarFacturaBoton" class="btn btn-success">
                                                        <i class="fa-solid fa-check-double me-2"></i> GENERAR FACTURA PROFORMA
                                                    </button>
                                                <?php elseif ($existeProforma == 1): ?>
                                                    <div style="background-color: #fdf6f0; border: 2px dashed #d4a373; padding: 20px; border-radius: 12px; font-family: Georgia, serif; color: #5a3e36; max-width: 600px; margin: 30px auto; text-align: center;">
                                                        <h4 style="color: #b08968;">Debe abonar la factura Proforma actual para generar nueva factura Proforma</h4>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                          
                                            </div>
                                        </div>
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
                                            <span class="fw-bold mg-t-7">Se creará con el Número:</span>
                                            <input type="text" id="numProforma" class="tx-left-force w-auto form-control" disabled value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">

                                        </div>
                                    </div>
                                </div>
                                <div class="card bg-light border shadow-sm p-3">
                                    <!-- Llegada Núm. -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Llegada Núm.</label>
                                        <input disabled type="text" id="llegadaNum" class="tx-center mb-2 tx-left-force tx-20" value="" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">

                                    </div>

                                    <!-- Alumno -->
                                    <div class="mb-3">
                                        <label class="fw-bold">Alumno</label>
                                        <div id="nombreAlumno"></div>
                                    </div>

                                        
                                        <!-- Transfer -->
                                        <p>Facturar Transfer:</p>

  
                                   <div class="mb-3">
                                        <h6 class="fw-bold">Transfer Llegada</h6>
                                        
                                        <div class="transfer-block mb-2 p-2 border rounded">
                                            <p><strong>Tarifa:</strong> <?php echo $datosLlegada[0]['codigotariotallegadaTransfer_llegadas'] . ' ' . $datosLlegada[0]['textotariotallegadaTransfer_llegadas']; ?></p>
                                            <p><strong>Día:</strong> <span id="idTransferLlegadaDia"><?php echo !empty($datosLlegada[0]['diallegadaTransferTransfer_llegadas']) ? fechaLocal($datosLlegada[0]['diallegadaTransferTransfer_llegadas']) : 'Sin fecha';  echo ' '.$datosLlegada[0]['horallegadaTransferTransfer_llegadas']?></span></p>
                                         
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="fw-bold">Transfer Regreso</h6>
                                        
                                        <div class="transfer-block mb-2 p-2 border rounded">
                                            <p><strong>Tarifa:</strong> <span id="idTransferRecogida"> <?php echo $datosLlegada[0]['codigotariotalregresoTransfer_llegadas'] . ' ' . $datosLlegada[0]['textotariotalregresoTransfer_llegadas']; ?></span></p>
                                            <p><strong>Día:</strong> <span id="idTransferRecogidaDia"><?php echo !empty($datosLlegada[0]['diaregresoTransfer_llegadas']) ? fechaLocal($datosLlegada[0]['diaregresoTransfer_llegadas']) : 'Sin fecha';  echo ' '.$datosLlegada[0]['horaregresoTransfer_llegadas']?></span></p>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button id="abrirModalFacturas" onclick="abrirModalFacturas()" class="btn  btn-primary btn-lg px-5 shadow-sm m-1">
                                                Gestionar Factura Pro
                                            </button>

                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <a onclick='window.history.back(); return false;'><button type='button' class='btn btn-secondary'>Volver</button></a>


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
    <!-- Search Modal -->
    <?php include_once 'modalTarifas.php' ?>
    <?php include_once 'modalLlegadas.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
    <?php include_once 'modalImprimir.php' ?>
    <?php include_once 'modalFacturas.php' ?>
    <?php include_once 'modalLlegadasGrupos.php' ?>

    <!-- Modal de Ayuda -->
    <div id="ayuda-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info bg-gradient text-white py-3">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <i class="bx bx-help-circle"></i> Información de Ayuda
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 mb-4">
                        <i class="bx bx-info-circle me-2"></i>
                        <strong>Guía de uso - Factura Proforma</strong>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-file-blank text-primary me-2"></i>¿Qué es una Factura Proforma?</h6>
                        <p class="text-muted ms-3">
                            Una factura proforma es un documento comercial que se emite antes de la venta final.
                            Sirve como presupuesto o cotización detallada de los servicios educativos a contratar.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-list-ol text-success me-2"></i>Procedimiento paso a paso:</h6>
                        <div class="ms-3">
                            <div class="alert alert-light border mb-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="badge bg-info me-2" style="min-width: 30px;">1</span>
                                    <div>
                                        <strong>Hacer clic en el botón azul "HACER PROFORMA"</strong>
                                        <p class="mb-0 text-muted mt-1">Este botón abrirá un modal para iniciar el proceso.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border mb-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="badge bg-info me-2" style="min-width: 30px;">2</span>
                                    <div>
                                        <strong>Seleccionar conceptos de llegadas</strong>
                                        <p class="mb-0 text-muted mt-1">En el modal se mostrarán todos los conceptos generados en llegadas (cursos, alojamientos, transfers, etc.). Seleccione los que desea incluir en la proforma.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border mb-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="badge bg-info me-2" style="min-width: 30px;">3</span>
                                    <div>
                                        <strong>Revisar conceptos cargados</strong>
                                        <p class="mb-0 text-muted mt-1">Los conceptos seleccionados aparecerán en la tabla central. Desde aquí puede modificar o eliminar cualquier concepto según necesite.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border mb-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="badge bg-warning me-2" style="min-width: 30px;">4</span>
                                    <div>
                                        <strong>Añadir conceptos adicionales (opcional)</strong>
                                        <p class="mb-0 text-muted mt-1">Use el botón amarillo "NUEVA TARIFA" para agregar conceptos extras (materiales, actividades, etc.) y luego "GUARDAR TARIFA" para añadirlos a la tabla.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border mb-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="badge bg-success me-2" style="min-width: 30px;">5</span>
                                    <div>
                                        <strong>Revisar la cabecera</strong>
                                        <p class="mb-0 text-muted mt-1">Verifique que los datos de facturación (nombre, CIF, dirección, etc.) sean correctos antes de finalizar.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="badge bg-success me-2" style="min-width: 30px;">6</span>
                                    <div>
                                        <strong>Guardar la proforma</strong>
                                        <p class="mb-0 text-muted mt-1">Una vez revisado todo, haga clic en el botón verde grande "GUARDAR PROFORMA" para generar el documento final.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-mouse text-primary me-2"></i>Botones principales:</h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-3">
                                <button class="btn btn-info btn-sm" disabled><i class="bx bx-file-plus"></i> Hacer Proforma</button>
                                <p class="text-muted ms-3 mb-0 mt-1">
                                    <strong>Botón AZUL CLARO:</strong> Genera una nueva factura proforma seleccionando las llegadas del alumno.
                                    Abre un modal donde podrá elegir qué llegadas incluir en la proforma.
                                </p>
                            </li>
                            <li class="mb-3">
                                <button class="btn btn-warning btn-sm" disabled><i class="bx bx-plus"></i> Nueva Tarifa</button>
                                <p class="text-muted ms-3 mb-0 mt-1">
                                    <strong>Botón AMARILLO/NARANJA:</strong> Añade conceptos adicionales a la proforma (materiales, actividades, extras, etc.).
                                    Permite agregar tarifas personalizadas con código, descripción, IVA y descuentos.
                                </p>
                                <p class="text-muted ms-3 mb-0 mt-1">
                                    <i class="bx bx-info-circle text-warning me-1"></i>
                                    Al hacer clic en este botón, se desplegará un cuadro de tarifas donde podrá seleccionar la tarifa deseada del listado disponible.
                                </p>
                            </li>
                            <li class="mb-3">
                                <button class="btn btn-success btn-sm" disabled><i class="bx bx-save"></i> Guardar Tarifa</button>
                                <p class="text-muted ms-3 mb-0 mt-1">
                                    <strong>Botón VERDE:</strong> Guarda las tarifas añadidas sin generar la proforma definitiva.
                                    Use este botón si desea guardar su progreso y continuar editando más tarde.
                                </p>
                            </li>
                            <li class="mb-3">
                                <button class="btn btn-success btn-sm" disabled><i class="fa-solid fa-check-double"></i> Guardar Proforma</button>
                                <p class="text-muted ms-3 mb-0 mt-1">
                                    <strong>Botón VERDE (grande):</strong> Finaliza y guarda la factura proforma completa.
                                    Este botón aparece al final del formulario y genera el documento definitivo.
                                </p>
                            </li>
                            <li class="mb-3">
                                <button class="btn btn-primary btn-sm" disabled><i class="bx bx-file"></i> Gestionar Factura Pro</button>
                                <p class="text-muted ms-3 mb-0 mt-1">
                                    <strong>Botón AZUL OSCURO:</strong> Abre el historial de facturas proforma del alumno.
                                    Permite consultar, imprimir y gestionar las proformas generadas.
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-edit text-warning me-2"></i>Modo Edición:</h6>
                        <div class="ms-3">
                            <p class="text-muted mb-2">Cuando esté editando una tarifa existente, verá estos botones:</p>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <button class="btn btn-info btn-sm" disabled>Guardar Edición</button>
                                    <span class="text-muted ms-2"><strong>Botón AZUL CLARO:</strong> Guarda los cambios realizados en la tarifa</span>
                                </li>
                                <li class="mb-2">
                                    <button class="btn btn-danger btn-sm" disabled>Cancelar</button>
                                    <span class="text-muted ms-2"><strong>Botón ROJO:</strong> Cancela la edición y descarta los cambios</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-id-card text-info me-2"></i>Datos de facturación:</h6>
                        <p class="text-muted ms-3">
                            Complete los datos de facturación del alumno o responsable de pago.
                            Estos datos aparecerán en la factura proforma y son necesarios para la gestión contable.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-note text-success me-2"></i>Concepto Extra:</h6>
                        <div class="ms-3">
                            <p class="text-muted mb-2">
                                El campo <strong>"Concepto Extra"</strong> le permite añadir texto libre que aparecerá en la factura proforma impresa.
                            </p>
                            <div class="alert alert-success border-0 mb-2">
                                <i class="bx bx-map-pin me-2"></i>
                                <strong>Ubicación en la factura:</strong> Este texto se mostrará en la parte inferior del documento impreso, 
                                justo encima de la sección "FORMA DE PAGO", precedido por un asterisco (*).
                            </div>
                            <p class="text-muted mb-1"><strong>Ejemplos de uso:</strong></p>
                            <ul class="text-muted">
                                <li>Observaciones sobre plazos de validez de la proforma</li>
                                <li>Condiciones especiales de pago o descuentos</li>
                                <li>Notas importantes para el cliente o alumno</li>
                                <li>Instrucciones específicas sobre el servicio contratado</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0">
                        <i class="bx bx-error me-2"></i>
                        <strong>Importante:</strong> Una vez generada la proforma, debe ser abonada antes de poder generar una nueva factura proforma para el mismo alumno.
                        Cuando existe una proforma pendiente de pago, los campos de edición estarán bloqueados.
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <script src="index.js"></script>
    <!--end plugins extra-->

    <!-- Inicializar tooltips de Bootstrap -->
    <script>
        // Inicializar todos los tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>

    

</body>

</html>
<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);
$json_string = json_encode('as');
    $file = 'x13333.json';
    file_put_contents($file, $json_string);
    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    require_once("../../models/Llegadas.php");

    $idLlegada = $_GET['idLlegada'];

    $llegada = new Llegadas();
    $datosLlegada = $llegada->recogerLlegadasHomexId($idLlegada);
 
    $idPrescriptor = $datosLlegada[0]['idprescriptor_llegadas'];
    $idAgente =  $datosLlegada[0]['agente_llegadas'];
    $grupoFacturacion =  $datosLlegada[0]['grupo_llegadas'];
    $idDepartamento =  $datosLlegada[0]['iddepartamento_llegadas'];

    $datosPagoAnticipado = $llegada->totalPagado($idLlegada);
    $totalImporte =  $datosPagoAnticipado[0]['totalImporte'];
    
    require_once("../../models/Proforma.php");

    $tipoFactura = $_GET['tipoFactura'];
    $idFactura = $_GET['idFacturaPro'];

    $proforma = new Proforma();
    $totalSuplido = $proforma -> recogerSuplidosXLlegadaSuma($idLlegada);

    $datosproforma = $proforma->recogerFacturasxIdFactura($idFactura);

    $json_string = json_encode($datosproforma);
    $file = 'DTSFactura.json';
    file_put_contents($file, $json_string);

    $idPie =  $datosproforma[0]['nombreCabecera'];

    $nombreCabecera =  $datosproforma[0]['nombreCabecera'];
    $cifCabecera =  $datosproforma[0]['cifCabecera'];
    $correoCabecera =  $datosproforma[0]['correoCabecera'];
    $direcCabecera =  $datosproforma[0]['direcCabecera'];
    $cpCabecera =  $datosproforma[0]['cpCabecera'];
    $movilCabecera =  $datosproforma[0]['movilCabecera'];
    $tefCabecera =  $datosproforma[0]['tefCabecera'];
    $paisCabecera =  $datosproforma[0]['paisCabecera'];
    $aQuienFactura =  $datosproforma[0]['aQuienFactura'];

    $fechaFactura = fechaLocal($datosproforma[0]['fechProformaPie']);
    $numeroFactura = $datosproforma[0]['serieProformaPie'].' '.$datosproforma[0]['numProformaPie'];

    $estadoPago = $datosproforma[0]['facturaPagada'];
    $textoLibreFacturaProforma = $datosproforma[0]['textoLibreFacturaProforma'];
   
    // ME GUARDO SI EXISTE O NO UNA FACTURA PARA ESTA LLEGADA ACTUALMENTE ACTIVA (RETORNA 1 = EXISTE O 0 = NO EXISTE)
    $existeFacturaReal = $proforma -> comprobarFacturaRealExistente($idLlegada);
    // ME GUARDO SI EXISTE O NO UNA FACTURA PARA ESTA LLEGADA ACTUALMENTE ACTIVA (RETORNA 1 = EXISTE O 0 = NO EXISTE)
    
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
            background-color: #5dade2; /* azul claro */
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
            background-color: #5dade2; /* azul claro */
            border-color: #5dade2;
            
        }

        #abrirModalFacturas:hover {
            background-color: #5499c7; /* azul un poco más oscuro al hover */
            border-color: #5499c7;
            color: white;
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
        <!-- NUEVO INPUT HIDDEN PARA SABER CUANDO HAY O NO UNA FACTURA REAL EXISTENTE -->
        <input type="hidden" id="existeProforma" value="<?php echo $existeProforma; ?>">
        <!-- NUEVO INPUT HIDDEN PARA SABER CUANDO HAY O NO UNA FACTURA REAL EXISTENTE -->
        <input type="hidden" id="idFacturaPro" value="<?php echo $idFactura; ?>">
        <input type="hidden" id="idPrescriptor" value="<?php echo $idPrescriptor; ?>">
        <input type="hidden" id="idLlegada" value="<?php echo $_GET["idLlegada"]; ?>">
        <input type="hidden" id="idAgente" value="<?php echo $idAgente; ?>">
        <input type="hidden" id="nombreGrupoFacturacion" value="<?php echo $grupoFacturacion; ?>">
        <input type="hidden" id="idDepartamento" value="<?php echo $idDepartamento; ?>">
        <input type="hidden" id="serie">
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
                    <h2 class="card-title">FACTURA PROFORMA Nº <?php echo $numeroFactura;?>  <?php
                   
                    ?></h2>                   

                    
                    <div class="my-3 border-top"></div>
                    <div class="container col-12">
                        <div class="row col-12 ">

                            <div class="col-12">

                               <div class="card bg-light border shadow-sm p-3">
                                    <!-- Título -->
                                    <div class="mb-3 ">
                                        <label class="fw-bold">INFORMACIÓN DEL ALUMNO - NOMBRE: <input class="form-control" id="nombreFacturacion" value="<?php echo $nombreCabecera;?>" disabled></input></label>
                                    </div>

                                    <div class="row">
                                        <!-- Columna izquierda -->
                                        <div class="col-md-6 mb-2">
                                            <div class="mb-2">
                                                <label class="fw-bold">CIF:</label>
                                                <input type="text" id="cifFact" value="<?php echo $cifCabecera;?>" disabled class="form-control" style="">
                                            </div>
                                            <div class="mb-2 row">
                                                <div class="col-6">
                                                    <label class="fw-bold">Móvil:</label>
                                                    <input type="text" id="movilFact" value="<?php echo $movilCabecera;?>" disabled class="form-control" style="">
                                                </div>
                                                <div class="col-6">
                                                    <label class="fw-bold">Teléfono:</label>
                                                    <input type="text" id="tefFact" value="<?php echo $tefCabecera;?>" disabled class="form-control" style="">
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label class="fw-bold">Correo:</label>
                                                <input type="text" id="correoFact" value="<?php echo $correoCabecera;?>" disabled class="form-control" style="">
                                            </div>
                                        </div>

                                        <!-- Columna central -->
                                        <div class="col-md-6 mb-2">
                                            <div class="mb-2">
                                                <label class="fw-bold">Dirección:</label>
                                                <input type="text" id="direcFact" class="form-control" value="<?php echo $direcCabecera;?>" disabled style="">
                                            </div>
                                            <div class="mb-2">
                                                <label class="fw-bold">CP:</label>
                                                <input type="text" id="cpFact" value="<?php echo $cpCabecera;?>" disabled class="form-control" style="">
                                            </div>
                                            <div class="mb-2">
                                                <label class="fw-bold">País:</label>
                                                <input type="text" id="paisFact" value="<?php echo $paisCabecera;?>" disabled class="form-control" style="" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">

                        <div class="row">
                            <!-- Sección izquierda -->
                            <div class="col-12 col-xl-3">
                                
                             
                              
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
                                                <?php if($aQuienFactura  == 1){?>
                                                    <input type="radio" class="radioQuienFactura" id="radioAlumno" name="tabs" value="1" checked>
                                                    <label class="radio-label" for="radioAlumno">
                                                        <div class="radio-circle"></div>
                                                        <span class="radio-text">Alumno</span>
                                                    </label>
                                                <?php }else if ($aQuienFactura == 2){?>
                                                    <input type="radio" class="radioQuienFactura" id="agenteAlumno" name="tabs" value="2" checked>
                                                    <label class="radio-label" for="agenteAlumno">
                                                        <div class="radio-circle"></div>
                                                        <span class="radio-text">Agente</span>
                                                    </label>
                                                <?php }else{?>
                                                    <input type="radio" class="radioQuienFactura" id="grupoAlumno" name="tabs" value="3" checked>
                                                    <label class="radio-label" for="grupoAlumno">
                                                        <div class="radio-circle"></div>
                                                        <span class="radio-text">Grupo</span>
                                                    </label>
                                                <?php }?>

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
                                       

                                        <!-- Nuevo card independiente debajo -->
                                        <div class="card bg-light border shadow-sm p-3 mt-3">
                                            <div class="mb-3 text-center">
                                                <label class="fw-bold">Concepto Extra</label>
                                            </div>
                                            <textarea class="form-control" id="conceptoExtra" rows="4" placeholder="Escribe aquí el concepto extra..."><?php echo !empty($textoLibreFacturaProforma) ? $textoLibreFacturaProforma : ''; ?></textarea>
                                        </div> 
                                       
                                       

                                        <button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaDatatablePro('<?php echo $idFactura; ?> ', 1, ' <?php echo $idLlegada; ?> ')"><div> Ver Proforma<i class="fa-solid fa-file"></i></div></button>
                                        <br>
                                        <div id="enviarCorreoAlum"></div> <br>
                                        <button type="button" class="btn btn-danger btn-icon" data-placement="top" title="Abonar Factura"  onclick="realizarAbonoProformaIndex('<?php echo $idPie; ?>','<?php echo $numeroFactura;?>')" ><div> Abonar Proforma</div></button>

                                    </div>

                            </div>

                            <!-- Sección central -->
                            <div class="col-12 col-xl-7">
                                <div class="card bg-light border shadow-sm p-3">

                                    <!-- Factura Proforma -->
                                    <div class="mb-3 tx-center">

                                        <label class="fw-bold">CONCEPTOS</label>



                                    </div>
                                        <div class="col-12" id="">
                                           

                                            <div class="row">

                                                <div class="table-responsive order-mobile-first">
                                                 
                                                <?php
                                                    $nombreTabla = "facturaTabla";
                                                    $nombreCampos = ["ID", "Código",  "Concepto", "Tipo","Descuento (%)","Base Imponible (€)","IVA (%)","Total (€)"];
                                                    $nombreCamposFooter = ["ID", "Código",  "Concepto", "Tipo","Descuento","Base Imponible","IVA","Total"];
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
                                            <h4 class="card-title text-primary mb-4">💼 Resumen de Factura</h4>

                                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                                 <div class="col">
                                                    <p><strong>Total Cursos / Aloja:</strong> <span class="float-end" id="totalCursos"></span></p>
                                                    <p><strong>Total Transfer:</strong> <span class="float-end" id="totalAloja"></span></p>
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
                                                <?php if ($existeFacturaReal == 0): ?>
                                                    <button id="guardarFacturaBoton" class="btn btn-success">
                                                        <i class="fa-solid fa-check-double me-2"></i> Guardar Factura Oficial
                                                    </button>
                                                <?php elseif ($existeFacturaReal == 1): ?>
                                                    <div style="background-color: #fdf6f0; border: 2px dashed #d4a373; padding: 20px; border-radius: 12px; font-family: Georgia, serif; color: #5a3e36; max-width: 600px; margin: 30px auto; text-align: center;">
                                                        <h4 style="color: #b08968;">Debe abonar la factura Real actual para generar nueva factura</h4>
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
                                        <label class="fw-bold">DATOS FACTURA</label>
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
                                                Consultar Facturas
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



</body>

</html>
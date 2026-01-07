<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("../../config/templates/mainHead.php"); ?>
      <style>
    .pace, .pace-progress, .pace-activity {
        display: none !important;
    }
    </style>
    <?php
          checkAccess(['0', '1', '2', '3']);
        require_once("../../config/conexion.php");
        require_once("../../config/funciones.php");
        require_once("../../models/Llegadas.php");

        $idFactura = $_GET['idFactura'];
        $tipoFactura = $_GET['tipoFactura'];
        $idLlegada = $_GET['idLlegada'];

        require_once("../../models/Proforma.php");

        $idFactura = $_GET['idFactura'];
        $tipoFactura = $_GET['tipoFactura'];

        $proforma = new Proforma();
        $json_string = json_encode($idFactura);
        $file = 'IDFACTURA.json';
        file_put_contents($file, $json_string);
        $datosproforma = $proforma->recogerFacturasxIdFacturaReal($idFactura);
        $json_string = json_encode($datosproforma);
        $file = 'DTS21.json';
        file_put_contents($file, $json_string);
        $nombreCabecera =  $datosproforma[0]['nombreCabecera'];
        $cifCabecera =  $datosproforma[0]['cifCabecera'];
        $correoCabecera =  $datosproforma[0]['correoCabecera'];
        $direcCabecera =  $datosproforma[0]['direcCabecera'];
        $cpCabecera =  $datosproforma[0]['cpCabecera'];
        $movilCabecera =  $datosproforma[0]['movilCabecera'];
        $tefCabecera =  $datosproforma[0]['tefCabecera'];
        $paisCabecera =  $datosproforma[0]['paisCabecera'];
    
        $fechaFactura = fechaLocal($datosproforma[0]['fechProformaPie']);
        $numeroFactura = $datosproforma[0]['serieProformaPie'].' '.$datosproforma[0]['numProformaPie'];
        $textoLibreFacturaReal = $datosproforma[0]['textoLibreFacturaReal'];
        $idLlegada =  $datosproforma[0]['idLlegada_Pie'];
        $textoLibreFacturaReal =  $datosproforma[0]['textoLibreFacturaReal'];
        if (!empty($textoLibreFacturaReal)) {
            // Aquí va lo que quieres hacer si está vacío o null
            $textoLibreFacturaReal = '* '.$textoLibreFacturaReal;
        }
    ?>
    <meta charset="UTF-8">
    <title>Factura Costa de Valencia</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap');

* {
    box-sizing: border-box;
}
@media print {
    body {
        /* Sugerir tamaño y márgenes */
        width: 210mm;   /* tamaño A4 vertical */
        height: 297mm;
        margin: 10mm;
    }
}
body {
    font-family: 'Merriweather', serif;
    margin: 0;
    padding: 0;
    background: #f8f9fa;
}

.factura {
    width: 850px;
    min-height: 980px; /* ⬅️ Antes 1160px */
    margin: 30px auto;  /* ⬅️ Antes 40px */
    padding: 30px;      /* ⬅️ Antes 40px */
    background: #ffffff;
    border: 2px solid #0070c0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
}

.header {
    display: flex;
    justify-content: space-between;
    margin-top: 30px; /* ⬅️ Antes 40px */
}

.logo-section {
    max-width: 50%;
    font-size: 13px;
}

.logo-section img {
    height: 60px;
    margin-bottom: 8px; /* ⬅️ Antes 10px */
}

.factura-titulo {
    width: 45%;
    padding: 18px; /* ⬅️ Antes 20px */
    position: relative;
    margin-top: 20px; /* ⬅️ Antes 30px */
    display: flex;
    flex-direction: column;
    min-height: 130px; /* ⬅️ Antes 160px */
}

.factura-titulo::before,
.factura-titulo::after,
.corner-bl,
.corner-br {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
}

/* Esquinas superiores */
.factura-titulo::before {
    top: 0;
    left: 0;
    border-left: 2px solid #000;
    border-top: 2px solid #000;
    border-right: none;
    border-bottom: none;
}

.factura-titulo::after {
    top: 0;
    right: 0;
    border-right: 2px solid #000;
    border-top: 2px solid #000;
    border-left: none;
    border-bottom: none;
}

/* Esquinas inferiores (igual que las superiores) */
.corner-bl {
    bottom: 0;
    left: 0;
    border-left: 2px solid #000;
    border-bottom: 2px solid #000;
    border-top: none;
    border-right: none;
}

.corner-br {
    bottom: 0;
    right: 0;
    border-right: 2px solid #000;
    border-bottom: 2px solid #000;
    border-top: none;
    border-left: none;
}

/* Etiquetas y texto */
.factura-label {
    position: absolute;
    top: -36px; /* ⬅️ Antes -40px */
    right: 0;
    font-size: 24px; /* ⬅️ Antes 26px */
    letter-spacing: 6px;
    color: #003366;
}

.cliente-nombre {
    font-size: 14px;
    font-weight: bold;
    text-align: left;
    border-left: 2px solid #000;
    padding-left: 12px;
    margin-bottom: 4px; /* ⬅️ Antes 5px */
}

.cliente-cif {
    font-size: 14px;
    text-align: left;
    border-left: 2px solid #000;
    padding-left: 12px;
    margin-top: auto;
}

.cliente {
    font-size: 14px;
    text-align: left;
    border-left: 2px solid #000;
    padding-left: 12px;
    margin-top: 40px; /* ⬅️ Antes 50px */
}

.info-factura {
    display: flex;
    gap: 25px; /* ⬅️ Antes 30px */
    margin: 25px 0 8px 0; /* ⬅️ Antes 30px 0 10px 0 */
}

.info-factura table {
    font-size: 14px;
    border-collapse: collapse;
}

.info-factura td {
    border: 1px solid #000;
    padding: 6px 10px; /* ⬅️ Antes 6px 12px */
    white-space: nowrap;
}

/* Tabla principal */
#facturaTabla {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
}

#facturaTabla thead tr,
#facturaTabla tbody tr {
    border-bottom: 1px solid #ddd;
}

#facturaTabla th,
#facturaTabla td {
    border: none;
    padding: 10px 12px;
}

#facturaTabla thead th {
    background-color: #3AB54A;
    color: white;
    font-weight: 700;
    text-align: center;
}

#facturaTabla tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

#facturaTabla tbody tr:hover {
    background-color: #e0f0d9;
}

#facturaTabla tfoot {
    display: none;
}

/* Totales */
.totales-horizontal {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px; /* ⬅️ Antes 25px */
    font-size: 14px;
}

.totales-horizontal td {
    border: 1px solid #000;
    padding: 9px; /* ⬅️ Antes 10px */
    text-align: center;
}

.totales-horizontal tr:first-child {
    background-color: #f2f2f2;
    font-weight: bold;
}

.nota-iva {
    font-size: 12px;
    margin-top: 8px; /* ⬅️ Antes 10px */
    color: #333;
}

.forma-pago {
    font-size: 13px;
    margin-top: 25px; /* ⬅️ Antes 30px */
}

.pie {
    font-size: 11px;
    text-align: center;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid #000;
    color: #555;
}

@media print {
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    #facturaTabla thead th {
        background-color: #3AB54A !important;
        color: white !important;
    }

    #facturaTabla tbody tr:nth-child(odd) {
        background-color: #f9f9f9 !important;
    }

    #facturaTabla tbody tr:hover {
        background-color: #e0f0d9 !important;
    }

    .factura {
        box-shadow: none !important;
       border: 0px solid #fcfcfcff !important; 
    }

    .factura-titulo::before,
    .factura-titulo::after,
    .corner-bl,
    .corner-br {
        background: none !important;
    }
}

#suplidosTabla {
    font-size: 0.85rem; /* Letra más pequeña */
    border: none;       /* Sin borde general */
    background: transparent;
}

#suplidosTabla th,
#suplidosTabla td {
    padding: 4px 8px;       /* Menos espacio interior */
    border: none;           /* Quitar líneas de celdas */
    background: transparent;
}

#suplidosTabla thead,
#suplidosTabla tfoot {
    display: none;          /* Ocultar cabecera y pie si no los necesitas */
}

#suplidosTabla tr:hover {
    background-color: transparent !important; /* Evita el hover llamativo */
}


/* APARTADO COMPRIMIR BODY */

/* --- Compactación general --- */


/* Evitar márgenes por defecto del navegador */
@page {
    margin: 5mm !important;
}

/* --- Compactar header --- */
.header {
    margin: 0 !important;
    padding: 0 !important;
}
.header p {
    margin: 0 !important;
    line-height: 1.1 !important;
}

/* --- Reducir espacio entre tablas --- */
table {
    margin: 0 !important;
}
table td, table th {
    padding: 2px 4px !important;
}

/* --- Info factura muy compacta --- */
.info-factura table td {
    padding: 1px 4px !important;
}

/* --- Totales --- */
.totales-horizontal td {
    padding: 2px 3px !important;
}

/* --- Suplidos --- */
.suplidosContent h5 {
    margin: 5px 0 2px 0 !important;
}
.suplidosContent .table-responsive {
    margin-top: 0 !important;
}

/* --- Texto inferior --- */
.forma-pago {
    margin: 2px 0 !important;
    line-height: 1.1 !important;
}

.pie {
    margin-top: 5px !important;
    line-height: 1.1 !important;
}

/* --- Quitar espacio entre secciones --- */
.row, .col-12, .table-responsive {
    margin: 0 !important;
    padding: 0 !important;
}


</style>


</head>
<body>
    <!-- ID LLEGADA OCULTO -->
    <input type="hidden" name="idFactura" id="idFactura" value="<?php echo $_GET["idFactura"]; ?>">
    <!-- TIPO DE FACTURA OCULTO -->
    <input type="hidden" name="tipoFactura" id="tipoFactura" value="<?php echo $_GET["tipoFactura"]; ?>">
    <input type="hidden" name="idLlegada" id="idLlegada" value="<?php echo $idLlegada; ?>">


    <div class="factura">
        <div class="header">
            <div class="logo-section">
                <img src="logo_pequeno.png" alt="Logo">
                <p>
                    ESCUELA DE ESPAÑOL<br>
                    Avda. Blasco Ibáñez, 66, 46021 Valencia<br>
                    Tel.: (+34) 963 610 367 &nbsp;&nbsp; Fax: (+34) 963 693 649<br>
                    www.costadevalencia.com
                </p>
            </div>
           <div class="factura-titulo">
            <div class="factura-label">FACTURA</div>
            <?php if (!empty($nombreCabecera)): ?>
                <div class="cliente-nombre"><label id="nombreCliente"><?php echo $nombreCabecera; ?></label></div>
            <?php endif; ?>

            <?php if (!empty($cifCabecera)): ?>
                <div class="cliente-cif"><label id="cifCliente">CIF/NIF: <?php echo $cifCabecera; ?></label></div>
            <?php endif; ?>

            <?php if (!empty($direcCabecera) || !empty($cpCabecera) || !empty($paisCabecera)): ?>
                <div class="cliente-cif"><label id="direc">
                    Dirección:
                    <?php echo $direcCabecera . ' ' . $cpCabecera . ' ' . $paisCabecera; ?>
                </label></div>
            <?php endif; ?>

            <?php if (!empty($correoCabecera)): ?>
                <div class="cliente-cif"><label id="correo">Email: <?php echo $correoCabecera; ?></label></div>
            <?php endif; ?>

            <?php if (!empty($movilCabecera) || !empty($tefCabecera)): ?>
                <div class="cliente-cif">
                    <label id="movil">
                        <?php if (!empty($movilCabecera)) echo 'Móvil: ' . $movilCabecera; ?>
                        <?php if (!empty($tefCabecera)) echo ' Tel: ' . $tefCabecera; ?>
                    </label>
                </div>
            <?php endif; ?>

            
            <div class="corner-bl"></div>
            <div class="corner-br"></div>
        </div>

        </div> <!-- ✅ Cierre correcto de .header -->

        <div class="info-factura">
            <table>
                <tr>
                    <td><strong>Fecha:</strong></td>
                    <td><strong>Número:</strong></td>
                </tr>
                <tr>
                    <td><label id="fechaFactura"><?php echo $fechaFactura;?></label></td>
                    <td><label id="numeroFactura"><?php echo $numeroFactura;?></label></td>
                </tr>
            </table>
        </div>
                <br>
        <div class="col-12">
            <div class="row">
                <div class="table-responsive order-mobile-first">
                    <?php
                        $nombreTabla = "facturaTabla";
                        $nombreCampos = ["id","Código", "Concepto", "Tipo", "Descuento (%)", "Base Imponible (€)", "IVA (%)", "Total (€)"];
                        $nombreCamposFooter = ["id","Código", "Concepto", "Tipo", "Descuento", "Base Imponible", "IVA", "Total"];
                        $cantidadGrupos = 1;
                        $columGrupos = [];
                        $agrupacionesPersonalizadas = 0;
                        $colorHEX = "#3AB54A";
                        $desplegado = 0;
                        $colorPicker = 0;

                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                        echo $tablaHTML;
                    ?>
                </div>
            </div>
    
           <br>

    <table class="totales-horizontal">
        <tr id="inicioTotales">
            <td>BASE IMPONIBLE</td>
            <td>IVA</td>
            <!-- <td>DESCUENTO</td> -->
            <td>IVA (EUROS)</td>
            <!-- <td>TOTAL SUPLIDOS</td> -->
            <td>TOTAL CON IVA</td>

        </tr>
        <!--
        <tr id="finTotales">
            <td><label id="baseImponible"></label></td>
            <td><label id="ivaDescuento"></label></td>
             <td><label id="totalDescuento"></label></td> 
            <td><label id="totalFactura"></label></td>
             <td><label id="totalSuplidos"></label></td> 
            <td><label id="totalPago"></label></td>

        </tr>
        -->
        <tr id="finTotales">
            <td><label id="baseImponible"></label></td>
            <td><label></label></td>
            <!-- <td><label id="totalDescuento"></label></td> -->
            <td><label id="ivaTotal"></label></td>
            <!-- <td><label id="totalSuplidos"></label></td> -->
            <td><label id="totalConIva"></label></td>

        </tr>
    </table>

    <!-- totalFactura -->
<br><br>
      
        <div class="nota-iva d-none">
                * Operación exenta de IVA por el artículo 20.1.9º de la Ley 37/1992 de 28 de diciembre
            </div>
            <div  id="suplidosContainer"  class="row suplidosContent">
                 <div class="col-12 mg-t-10">
                    <h5  style="font-weight: bold;">Suplidos</h5>
                </div>
                <div class="table-responsive order-mobile-first">
                    <?php
                        $nombreTabla = "suplidosTabla";
                        $nombreCampos = ["id","Descripción", "Importe Suplido"];
                        $nombreCamposFooter =  ["id","Descripción", "Importe Suplido"];
                        $cantidadGrupos = 1;
                        $columGrupos = [];
                        $agrupacionesPersonalizadas = 0;
                        $colorHEX = "#3AB54A";
                        $desplegado = 0;
                        $colorPicker = 0;

                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                        echo $tablaHTML;
                    ?>
                </div>
            </div>
            <table class="table table-bordered" id="resumenSuplidosTabla">
            <thead>
                <tr>
                    <th>Total con IVA</th>
                    <th  class="suplidosContent">Total Suplidos</th>
                    <th>Total General</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label id="totalConIvaResumen"></label></td>
                    <td class="suplidosContent"><label id="totalSuplidosResumen"></label></td>
                    <td><label id="totalConSuplidos"></label></td>
                </tr>
            </tbody>
        </table>

        <div class="forma-pago">
            <strong><?php echo $textoLibreFacturaReal ?></strong>
        </div>
        <div class="forma-pago">
            <strong>FORMA DE PAGO:</strong> Efectivo o transferencia bancaria a la cuenta:<br>
            IBAN: ES25 0049 0780 4421 1185 6713 &nbsp;&nbsp; SWIFT: BSCH ES MM XXX
        </div>

        <div class="pie">
            COSTA DE VALENCIA S.L. · Avda. Blasco Ibáñez 66, 46021 Valencia · CIF: B96734593<br>
            Tel.: (+34) 963 610 367 · Email: info@costadevalencia.com
        </div>
    </div>

    <?php include("../../config/templates/mainJs.php"); ?>
    <script src="factura.js"></script>
</body>

</html>

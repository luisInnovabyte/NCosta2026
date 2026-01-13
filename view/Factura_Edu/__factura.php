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
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

* {
    box-sizing: border-box;
}

@media print {
    body {
        width: 210mm;
        height: 297mm;
        margin: 10mm;
    }
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
    background: #f5f7fa;
}

.factura {
    width: 850px;
    min-height: 980px;
    margin: 30px auto;
    padding: 40px;
    background: #ffffff;
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 30px;
    border-bottom: 3px solid #0070c0;
    margin-bottom: 30px;
}

.logo-section {
    max-width: 50%;
    font-size: 13px;
    color: #4a5568;
    line-height: 1.6;
}

.logo-section img {
    height: 65px;
    margin-bottom: 12px;
}

.factura-titulo {
    width: 45%;
    padding: 25px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 10px;
    border: 2px solid #0070c0;
    position: relative;
    display: flex;
    flex-direction: column;
    min-height: 140px;
}

.factura-label {
    position: absolute;
    top: -45px;
    right: 10px;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: 4px;
    color: #0070c0;
    text-transform: uppercase;
}

.cliente-nombre {
    font-size: 15px;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 2px solid #0070c0;
}

.cliente-cif {
    font-size: 13px;
    color: #4a5568;
    margin: 4px 0;
    line-height: 1.5;
}

.info-factura {
    display: flex;
    gap: 20px;
    margin: 25px 0;
}

.info-factura table {
    font-size: 14px;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.info-factura td {
    border: 1px solid #e2e8f0;
    padding: 10px 16px;
    background: #ffffff;
}

.info-factura td:first-child {
    background: #f8fafc;
    font-weight: 600;
    color: #2d3748;
}

.info-factura td:last-child {
    font-weight: 600;
    color: #0070c0;
}

/* Tabla principal */
#facturaTabla {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
}

#facturaTabla thead tr,
#facturaTabla tbody tr {
    border-bottom: 1px solid #e2e8f0;
}

#facturaTabla th,
#facturaTabla td {
    border: none;
    padding: 12px 14px;
    font-size: 13px;
}

#facturaTabla thead th {
    background: linear-gradient(135deg, #0070c0 0%, #0056a3 100%);
    color: white;
    font-weight: 600;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 12px;
}

#facturaTabla tbody tr:nth-child(odd) {
    background-color: #f8fafc;
}

#facturaTabla tbody tr:nth-child(even) {
    background-color: #ffffff;
}

#facturaTabla tbody tr:hover {
    background-color: #e6f2ff;
    transition: background-color 0.2s ease;
}

#facturaTabla tbody td {
    color: #2d3748;
}

#facturaTabla tfoot {
    display: none;
}

/* Totales */
.totales-horizontal {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
    font-size: 14px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.totales-horizontal td {
    border: 1px solid #e2e8f0;
    padding: 12px;
    text-align: center;
}

.totales-horizontal tr:first-child {
    background: linear-gradient(135deg, #0070c0 0%, #0056a3 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.totales-horizontal tr:last-child {
    background-color: #f8fafc;
    font-weight: 700;
    color: #0070c0;
    font-size: 15px;
}

.nota-iva {
    font-size: 12px;
    margin-top: 15px;
    color: #718096;
    font-style: italic;
}

.forma-pago {
    font-size: 13px;
    margin-top: 30px;
    padding: 15px;
    background: #f8fafc;
    border-left: 4px solid #0070c0;
    border-radius: 6px;
    color: #2d3748;
    line-height: 1.6;
}

.pie {
    font-size: 11px;
    text-align: center;
    margin-top: auto;
    padding-top: 20px;
    border-top: 2px solid #e2e8f0;
    color: #718096;
    line-height: 1.6;
}

@media print {
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    #facturaTabla thead th {
        background: linear-gradient(135deg, #0070c0 0%, #0056a3 100%) !important;
        color: white !important;
    }

    #facturaTabla tbody tr:nth-child(odd) {
        background-color: #f8fafc !important;
    }

    #facturaTabla tbody tr:nth-child(even) {
        background-color: #ffffff !important;
    }

    #facturaTabla tbody tr:hover {
        background-color: #e6f2ff !important;
    }

    .factura {
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
    }

    .totales-horizontal tr:first-child {
        background: linear-gradient(135deg, #0070c0 0%, #0056a3 100%) !important;
        color: white !important;
    }
}

#suplidosTabla {
    font-size: 13px;
    border: none;
    background: transparent;
    margin-top: 15px;
}

#suplidosTabla th,
#suplidosTabla td {
    padding: 8px 10px;
    border: none;
    background: transparent;
}

#suplidosTabla thead,
#suplidosTabla tfoot {
    display: none;
}

#suplidosTabla tr:hover {
    background-color: transparent !important;
}

#resumenSuplidosTabla {
    margin-top: 15px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

#resumenSuplidosTabla th {
    background: linear-gradient(135deg, #0070c0 0%, #0056a3 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    padding: 12px;
}

#resumenSuplidosTabla td {
    background: #f8fafc;
    font-weight: 700;
    color: #0070c0;
    font-size: 15px;
    padding: 12px;
    text-align: center;
}

/* --- Compactación para impresión --- */
@page {
    margin: 5mm !important;
}

@media print {
    .header {
        margin: 0 !important;
        padding-bottom: 15px !important;
    }
    
    .header p {
        margin: 0 !important;
        line-height: 1.3 !important;
    }

    table {
        margin: 0 !important;
    }
    
    table td, table th {
        padding: 6px 8px !important;
    }

    .info-factura table td {
        padding: 8px 12px !important;
    }

    .totales-horizontal td {
        padding: 8px !important;
    }

    .suplidosContent h5 {
        margin: 10px 0 5px 0 !important;
    }

    .forma-pago {
        margin: 15px 0 !important;
        padding: 10px !important;
    }

    .pie {
        margin-top: 15px !important;
        padding-top: 15px !important;
    }
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
            <div class="factura-label"><?php echo ($tipoFactura == 1) ? 'PROFORMA' : 'FACTURA'; ?></div>
            <?php if (!empty($nombreCabecera)): ?>
                <div class="cliente-nombre"><label id="nombreCliente"><?php echo $nombreCabecera; ?></label></div>
            <?php endif; ?>

            <?php if (!empty($cifCabecera)): ?>
                <div class="cliente-cif"><label id="cifCliente"><strong>CIF/NIF:</strong> <?php echo $cifCabecera; ?></label></div>
            <?php endif; ?>

            <?php if (!empty($direcCabecera) || !empty($cpCabecera) || !empty($paisCabecera)): ?>
                <div class="cliente-cif"><label id="direc">
                    <strong>Dirección:</strong>
                    <?php echo $direcCabecera . ' ' . $cpCabecera . ' ' . $paisCabecera; ?>
                </label></div>
            <?php endif; ?>

            <?php if (!empty($correoCabecera)): ?>
                <div class="cliente-cif"><label id="correo"><strong>Email:</strong> <?php echo $correoCabecera; ?></label></div>
            <?php endif; ?>

            <?php if (!empty($movilCabecera) || !empty($tefCabecera)): ?>
                <div class="cliente-cif">
                    <label id="movil">
                        <?php if (!empty($movilCabecera)) echo '<strong>Móvil:</strong> ' . $movilCabecera; ?>
                        <?php if (!empty($tefCabecera)) echo ' <strong>Tel:</strong> ' . $tefCabecera; ?>
                    </label>
                </div>
            <?php endif; ?>
        </div>

        </div>

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

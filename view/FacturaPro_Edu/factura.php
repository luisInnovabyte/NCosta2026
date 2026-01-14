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
        checkAccess(['1']);
        require_once("../../config/conexion.php");
        require_once("../../config/funciones.php");
        require_once("../../models/Llegadas.php");

        $idFactura = $_GET['idFactura'];
        $tipoFactura = $_GET['tipoFactura'];
        $idLlegada = $_GET['idLlegada'];

        require_once("../../models/Proforma.php");

        $idFactura = $_GET['idFactura'];
        $tipoFactura = $_GET['tipoFactura'];
        $llegada = new Llegadas();
        $proforma = new Proforma();
        $json_string = json_encode($idFactura);
        $file = 'IDFACTURA.json';
        file_put_contents($file, $json_string);
        $datosproforma = $proforma->recogerFacturasxIdFactura($idFactura);
  
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
        $textoLibreFacturaReal = $datosproforma[0]['textoLibreFacturaProforma'];
        $idLlegada =  $datosproforma[0]['idLlegada_Pie'];
        if (!empty($textoLibreFacturaReal)) {
            // Aquí va lo que quieres hacer si está vacío o null
            $textoLibreFacturaReal = '* '.$textoLibreFacturaReal;
        }

        $fechaActualTiempo =date("d/m/Y H:i:s");
        $datosPagoAnticipado = $llegada->totalPagado($idLlegada);
        
        $totalImporte = !empty($datosPagoAnticipado[0]['totalImporte']) ? $datosPagoAnticipado[0]['totalImporte'] : 0;
        if (!empty($totalImporte) && $totalImporte > 0) {
         $totalImporteText = 'Se ha pagado a fecha ' . $fechaActualTiempo . ' un total de ' . $totalImporte . ' €';
        } else {
            $totalImporteText = '';
        }

      

    ?>
    <meta charset="UTF-8">
    <title>Factura Costa de Valencia</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

* {
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    min-height: 100vh;
}
@media print {
    body {
        /* Sugerir tamaño y márgenes */
        width: 210mm;   /* tamaño A4 vertical */
        height: 297mm;
        margin: 10mm;
        background: white;
    }
}
.factura {
    width: 850px;
    min-height: 980px;
    margin: 40px auto;
    padding: 45px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 3px solid #f0f0f0;
}

.logo-section {
    max-width: 50%;
    font-size: 13px;
    color: #64748b;
    line-height: 1.8;
}

.logo-section img {
    height: 70px;
    margin-bottom: 15px;
}

.logo-section p {
    margin: 0;
    font-weight: 400;
}

.factura-titulo {
    width: 48%;
    padding: 25px;
    position: relative;
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25);
    display: flex;
    flex-direction: column;
    min-height: 140px;
    color: white;
}

.factura-titulo::before,
.factura-titulo::after {
    display: none;
}

.corner-bl,
.corner-br {
    display: none;
}

.factura-titulo::after {
    display: none;
}

/* Etiquetas y texto */
.factura-label {
    position: absolute;
    top: -50px;
    right: 0;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 8px;
    color: #3b82f6;
    text-transform: uppercase;
}

.cliente-nombre {
    font-size: 15px;
    font-weight: 700;
    text-align: left;
    padding: 8px 0;
    margin-bottom: 8px;
    border-left: 4px solid rgba(255,255,255,0.8);
    padding-left: 15px;
    color: white;
}

.cliente-cif {
    font-size: 13px;
    font-weight: 400;
    text-align: left;
    padding: 5px 0;
    padding-left: 15px;
    color: rgba(255,255,255,0.95);
    line-height: 1.6;
}

.cliente {
    font-size: 14px;
    text-align: left;
    padding-left: 15px;
    margin-top: 40px;
    color: white;
}

.info-factura {
    display: flex;
    gap: 30px;
    margin: 30px 0;
}

.info-factura table {
    font-size: 14px;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.info-factura td {
    border: none;
    padding: 12px 20px;
    background: #f8fafc;
}

.info-factura tr:first-child td {
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    color: white;
    font-weight: 600;
}

.info-factura tr:last-child td {
    background: white;
    border: 1px solid #e2e8f0;
    color: #1e293b;
    font-weight: 500;
}

/* Tabla principal */
#facturaTabla {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

#facturaTabla thead tr,
#facturaTabla tbody tr {
    border-bottom: 1px solid #e2e8f0;
}

#facturaTabla th,
#facturaTabla td {
    border: none;
    padding: 14px 16px;
    text-align: center;
}

#facturaTabla thead th {
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

#facturaTabla tbody tr {
    transition: all 0.2s ease;
}

#facturaTabla tbody tr:nth-child(odd) {
    background-color: #f8fafc;
}

#facturaTabla tbody tr:nth-child(even) {
    background-color: white;
}

#facturaTabla tbody tr:hover {
    background-color: #dbeafe !important;
    transform: scale(1.01);
}

#facturaTabla tfoot {
    display: none;
}

/* Totales */
.totales-horizontal {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 30px;
    font-size: 15px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.totales-horizontal td {
    border: none;
    padding: 16px;
    text-align: center;
    font-weight: 500;
}

.totales-horizontal tr:first-child {
    background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    color: white;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.totales-horizontal tr:last-child {
    background: #f8fafc;
    color: #1e293b;
    font-size: 16px;
    font-weight: 600;
}

#finTotales {
    border-top: 3px solid #495057;
}

#finTotales td:first-child {
    font-weight: 700;
    color: #1e293b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nota-iva {
    font-size: 12px;
    margin-top: 12px;
    color: #64748b;
    font-style: italic;
}

.forma-pago {
    font-size: 14px;
    margin-top: 30px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #6c757d;
    color: #1e293b;
    line-height: 1.8;
}

.pie {
    font-size: 11px;
    text-align: center;
    margin-top: auto;
    padding-top: 25px;
    border-top: 2px solid #e2e8f0;
    color: #64748b;
    line-height: 1.8;
}

@media print {
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        background: white !important;
    }

    #facturaTabla thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%) !important;
        color: white !important;
    }

    #facturaTabla tbody tr:nth-child(odd) {
        background-color: #f8fafc !important;
    }

    #facturaTabla tbody tr:hover {
        background-color: #dbeafe !important;
    }

    .factura {
        box-shadow: none !important;
        border: none !important;
    }

    .factura-titulo {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%) !important;
        box-shadow: none !important;
    }

    .totales-horizontal tr:first-child {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%) !important;
        color: white !important;
    }

    .info-factura tr:first-child td {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%) !important;
        color: white !important;
    }
}

#suplidosTabla {
    font-size: 13px;
    border: none;
    background: transparent;
}

#suplidosTabla th,
#suplidosTabla td {
    padding: 8px 12px;
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
    margin-top: 20px;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

#resumenSuplidosTabla thead tr {
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    color: white;
}

#resumenSuplidosTabla th {
    padding: 14px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    text-align: center;
}

#resumenSuplidosTabla td {
    padding: 16px;
    text-align: center;
    background: #f8f9fa;
    color: #1e293b;
    font-weight: 600;
    font-size: 15px;
}

.suplidosContent h5 {
    color: #1e293b;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 15px;
    margin-top: 30px;
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
            <div class="factura-label">PROFORMA</div>
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
            <td>TOTAL(IVA Incl.)</td>

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
            <td><strong>TOTAL</strong></td>
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
                    <th>Total(IVA Incl.)</th>
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
            <strong><?php echo $totalImporteText?></strong>
        </div>
        <br>
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

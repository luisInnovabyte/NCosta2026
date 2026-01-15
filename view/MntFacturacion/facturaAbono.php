<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
        checkAccess(['1']);
        require_once("../../config/conexion.php");
        require_once("../../config/funciones.php");
        require_once("../../models/Llegadas.php");

        $idFactura = $_GET['idFactura'];
        $tipoFactura = $_GET['tipoFactura'];
        $idLlegada = $_GET['idLlegada'];
        $realOProforma = (int)$_GET['realOProforma']; // ahora es entero

        require_once("../../models/Proforma.php");

        $proforma = new Proforma();

        // Guardar ID de factura para depuración
        $json_string = json_encode($idFactura);
        $file = 'IDFACTURA.json';
        file_put_contents($file, $json_string);

        // Elegir el método según realOProforma
        if ($realOProforma === 1) {
            $datosproforma = $proforma->recogerFacturasxIdFacturaReal($idFactura);
            $textoLibre = $datosproforma[0]['textoLibreFacturaReal'];
        } else if ($realOProforma === 0) {
            $datosproforma = $proforma->recogerFacturasxIdFactura($idFactura);
            $textoLibre = $datosproforma[0]['textoLibreFacturaProforma']; // Ajustar según tu tabla Proforma
        }

        // Guardar datos de la factura para depuración
        $json_string = json_encode($datosproforma);
        $file = 'DATOSPROFORMAOREAL.json';
        file_put_contents($file, $json_string);

        $nombreCabecera = $datosproforma[0]['nombreCabecera'];
        $cifCabecera = $datosproforma[0]['cifCabecera'];
        $correoCabecera = $datosproforma[0]['correoCabecera'];
        $direcCabecera = $datosproforma[0]['direcCabecera'];
        $cpCabecera = $datosproforma[0]['cpCabecera'];
        $movilCabecera = $datosproforma[0]['movilCabecera'];
        $tefCabecera = $datosproforma[0]['tefCabecera'];
        $paisCabecera = $datosproforma[0]['paisCabecera'];

        $fechaFactura = fechaLocal($datosproforma[0]['fechProformaPie']); //NO ENTIENDO PORQUE LO DE FECHA LOCAL HACE QUE DEJE DE IR DIRECTAMENTE TODO
        //$fechaFactura = $datosproforma[0]['fechProformaPie'];
        $numeroFactura = $datosproforma[0]['serieProformaPie'].' '.$datosproforma[0]['numProformaPie'];
        $idLlegada = $datosproforma[0]['idLlegada_Pie'];

        // Añadir asterisco si existe texto libre
        if (!empty($textoLibre)) {
            $textoLibre = '* '.$textoLibre;
        }

        // Número de abono
        $numeroAbono = ($realOProforma == 1) 
            ? (!empty($datosproforma[0]['abonadaFactura']) ? $datosproforma[0]['abonadaFactura'] : '-') 
            : (!empty($datosproforma[0]['abonadaFacturaPro']) ? $datosproforma[0]['abonadaFacturaPro'] : '-');

        // Número de factura referenciada
        $facturaReferenciada = ($realOProforma == 1) 
            ? (!empty($datosproforma[0]['numFactura_cabe']) ? $datosproforma[0]['serieProformaPie'] . $datosproforma[0]['numFactura_cabe'] : '-') 
            : (!empty($datosproforma[0]['numProformaPie']) ? $datosproforma[0]['serieProformaPie'] . $datosproforma[0]['numProformaPie'] : '-');
        
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
    background: #f8f9fa;
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

.factura-titulo {
    width: 48%;
    padding: 25px;
    position: relative;
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25);
    color: white;
    display: flex;
    flex-direction: column;
    min-height: 180px;
}

/* Etiquetas y texto */
.factura-label {
    position: absolute;
    top: -45px;
    right: 0;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 3px;
    color: #1e293b;
}

.cliente-nombre {
    font-size: 16px;
    font-weight: 700;
    text-align: left;
    margin-bottom: 12px;
    line-height: 1.4;
}

.cliente-cif {
    font-size: 13px;
    text-align: left;
    line-height: 1.6;
    opacity: 0.95;
    margin-bottom: 6px;
}

.cliente {
    font-size: 13px;
    text-align: left;
    line-height: 1.6;
    opacity: 0.95;
}

.info-factura {
    display: flex;
    gap: 30px;
    margin: 30px 0;
}

.info-factura table {
    font-size: 13px;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.info-factura th {
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    color: white;
    font-weight: 600;
    padding: 6px 12px;
    text-align: center;
}

.info-factura td {
    background: white;
    border: 1px solid #e2e8f0;
    padding: 6px 12px;
    white-space: nowrap;
    text-align: center;
}

/* Tabla principal */
#facturaTabla {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-top: 20px;
}

#facturaTabla th,
#facturaTabla td {
    border: none;
    padding: 8px 10px;
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

#facturaTabla tbody tr:nth-child(odd) {
    background-color: #f8fafc;
}

#facturaTabla tbody tr:nth-child(even) {
    background-color: white;
}

#facturaTabla tbody tr:hover {
    background-color: #dbeafe !important;
    transform: scale(1.01);
    transition: all 0.2s ease;
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
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    text-align: center;
}

.totales-horizontal tr:first-child {
    background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.totales-horizontal tr:first-child td {
    border: none;
}

.totales-horizontal .fila-intermedia {
    background-color: white;
    font-weight: 500;
}

.totales-horizontal .fila-intermedia td {
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
}

.totales-horizontal tr:last-child {
    background: #f8fafc;
    font-weight: 700;
    font-size: 16px;
}

.totales-horizontal tr:last-child td {
    border: 1px solid #e2e8f0;
    color: #1e293b;
}

.nota-iva {
    font-size: 12px;
    margin-top: 15px;
    color: #64748b;
    font-style: italic;
}

.forma-pago {
    font-size: 13px;
    margin-top: 30px;
    line-height: 1.8;
    color: #1e293b;
}

.pie {
    font-size: 11px;
    text-align: center;
    margin-top: auto;
    padding-top: 20px;
    border-top: 2px solid #e2e8f0;
    color: #64748b;
    line-height: 1.6;
}

@media print {
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        width: 210mm;
        height: 297mm;
        margin: 10mm;
    }

    .factura {
        box-shadow: none !important;
        margin: 0;
        padding: 30px;
    }

    /* Ocultar elementos de carga/progreso */
    .dataTables_processing,
    .dataTables_wrapper .dataTables_processing,
    div.dataTables_processing,
    .dt-processing,
    .pace,
    .pace-progress,
    .pace-activity {
        display: none !important;
        visibility: hidden !important;
    }

    #facturaTabla thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%) !important;
        color: white !important;
    }

    #facturaTabla tbody tr:nth-child(odd) {
        background-color: #f8fafc !important;
    }

    #facturaTabla tbody tr:nth-child(even) {
        background-color: white !important;
    }

    .factura-titulo {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%) !important;
        color: white !important;
    }

    .totales-horizontal tr:first-child {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%) !important;
        color: white !important;
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

#resumenSuplidosTabla thead th {
    background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border: none;
}

#resumenSuplidosTabla tbody td {
    padding: 14px 16px;
    background: white;
    border: 1px solid #e2e8f0;
}

</style>


</head>
<body>
    <!-- ID LLEGADA OCULTO -->
    <input type="hidden" name="idFactura" id="idFactura" value="<?php echo $_GET["idFactura"]; ?>">
    <!-- TIPO DE FACTURA OCULTO -->
    <input type="hidden" name="tipoFactura" id="tipoFactura" value="<?php echo $_GET["tipoFactura"]; ?>">
    <input type="hidden" name="idLlegada" id="idLlegada" value="<?php echo $idLlegada; ?>">
    <input type="hidden" name="EsProformaOReal" id="EsProformaOReal" value="<?php echo $realOProforma; ?>">



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
            <div class="factura-label">
                <?php 
                    if ($realOProforma == 1) {
                        echo "FACTURA ABONO";
                    } else {
                        echo "PROFORMA ABONO";
                    }
                ?>
            </div>
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
        </div>

        </div> <!-- ✅ Cierre correcto de .header -->

        <div class="info-factura">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Número</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label id="fechaFactura"><?php echo $fechaFactura; ?></label></td>
                        <td><label id="numeroFactura"><?php echo $numeroFactura; ?></label></td>
                    </tr>
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th>Abono</th>
                        <th>
                            <?php 
                                echo ($realOProforma == 1) ? 'Factura Referenciada' : 'Proforma Referenciada'; 
                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label id="numeroAbono"><?php echo $numeroAbono; ?></label></td>
                        <td><label id="facturaReferenciada"><?php echo $facturaReferenciada; ?></label></td>
                    </tr>
                </tbody>
            </table>
        </div>



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

      
        <div class="nota-iva d-none">
                * Operación exenta de IVA por el artículo 20.1.9º de la Ley 37/1992 de 28 de diciembre
            </div>
            <div  id="suplidosContainer"  class="row">
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
              <table class="totales-horizontal" id="resumenSuplidosTabla" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Total con IVA</th>
                    <th>Total Suplidos</th>
                    <th>Total General</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label id="totalConIvaResumen"></label></td>
                    <td><label id="totalSuplidosResumen"></label></td>
                    <td><label id="totalConSuplidos"></label></td>
                </tr>
            </tbody>
        </table>
        <div class="forma-pago">
            <strong><?php echo $textoLibre ?></strong>
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
    <script src="facturaAbonoNueva.js"></script>
</body>

</html>

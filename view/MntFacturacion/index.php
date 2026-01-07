<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);
    $json_string = json_encode('');
    $file = 'wrt.json';
    file_put_contents($file, $json_string);
    ?>
  <style>
    
 /* CSS BONITO PARA DATATABLES, ESTA AQUI POR SI SE QUISIERA UTILIZAR PARA OTRAS VECES 
 CONTENEDOR PRINCIPAL 
#contenedorProforma {
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
  padding: 2rem;
  margin-bottom: 3rem;
}

#contenedorProforma h4.titulo-tabla {
  font-weight: 700;
  font-size: 1.4rem;
  margin-bottom: 1.5rem;
  color: #2c3e50;
  position: relative;
  padding-bottom: 12px;
  display: inline-block;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  letter-spacing: 0.02em;
}

#contenedorProforma h4.titulo-tabla:after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 50px;
  height: 4px;
  border-radius: 2px;
}

#contenedorProforma h4.titulo-tabla:nth-of-type(1):after {
  background: linear-gradient(90deg, #28a745, #5cb85c);
  box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

#contenedorProforma h4.titulo-tabla:nth-of-type(2):after {
  background: linear-gradient(90deg, #dc3545, #e83e8c);
  box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

#tableProformas,
#tableAbonoProforma {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 12px;
  overflow: hidden;
  background: white;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
  margin-bottom: 2.5rem;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

#tableProformas thead th {
  background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%);
  color: white;
  font-weight: 600;
  padding: 16px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 0.85rem;
  position: relative;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-font-smoothing: antialiased;
}

#tableAbonoProforma thead th {
  background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
  color: white;
  font-weight: 600;
  padding: 16px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 0.85rem;
  position: relative;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-font-smoothing: antialiased;
}

#tableProformas thead th:after,
#tableAbonoProforma thead th:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: rgba(255, 255, 255, 0.3);
}

#tableProformas td,
#tableAbonoProforma td {
  padding: 14px 16px;
  text-align: center;
  vertical-align: middle;
  border-bottom: 1px solid rgba(0, 0, 0, 0.03);
  color: #4a5568;
  font-size: 0.95rem;
  transition: all 0.2s ease;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  font-weight: 450;
  letter-spacing: 0.02em;
  line-height: 1.5;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
}

#tableProformas td:nth-child(1),
#tableAbonoProforma td:nth-child(1) {
  font-family: 'SF Mono', 'Roboto Mono', monospace;
  font-weight: 500;
  color: #2c3e50;
}

#tableProformas td:nth-child(2),
#tableAbonoProforma td:nth-child(3) {
  font-weight: 500;
  color: #1a365d;
}

#tableProformas td:nth-child(3),
#tableAbonoProforma td:nth-child(4) {
  font-weight: 500;
  color: #2d3748;
}

#tableProformas td:nth-child(4),
#tableAbonoProforma td:nth-child(5) {
  font-family: 'SF Mono', 'Roboto Mono', monospace;
  font-weight: 500;
  letter-spacing: 0.05em;
}

#tableProformas td:nth-child(5),
#tableAbonoProforma td:nth-child(6),
#tableAbonoProforma td:nth-child(7) {
  font-family: 'SF Mono', 'Roboto Mono', monospace;
  font-size: 0.9rem;
  color: #4a5568;
}

#tableProformas tbody tr:nth-child(even),
#tableAbonoProforma tbody tr:nth-child(even) {
  background-color: rgba(241, 245, 249, 0.5);
}

#tableProformas tbody tr,
#tableAbonoProforma tbody tr {
  transition: all 0.35s cubic-bezier(0.215, 0.61, 0.355, 1);
  position: relative;
}

#tableProformas tbody tr:hover {
  background-color: rgba(40, 167, 69, 0.08) !important;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(40, 167, 69, 0.1);
  z-index: 2;
}

#tableAbonoProforma tbody tr:hover {
  background-color: rgba(220, 53, 69, 0.08) !important;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(220, 53, 69, 0.1);
  z-index: 2;
}

#tableProformas tbody tr:hover td,
#tableAbonoProforma tbody tr:hover td {
  border-bottom-color: transparent;
}

#tableProformas tbody tr:hover td:first-child {
  border-left: 3px solid #28a745;
  padding-left: 13px;
}

#tableAbonoProforma tbody tr:hover td:first-child {
  border-left: 3px solid #dc3545;
  padding-left: 13px;
}

#tableProformas tfoot th,
#tableAbonoProforma tfoot th {
  background: linear-gradient(to right, #f8f9fa, #e9ecef);
  padding: 14px;
  text-align: center;
  font-weight: 600;
  color: #495057;
  font-size: 0.9rem;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
}

#tableProformas {
  border: 1px solid rgba(40, 167, 69, 0.15);
}

#tableAbonoProforma {
  border: 1px solid rgba(220, 53, 69, 0.15);
}

#tableProformas,
#tableAbonoProforma {
  animation: fadeIn 0.5s ease-out forwards;
}

#tableAbonoProforma {
  animation-delay: 0.1s;
}






#contenedorFacturas {
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
  padding: 2rem;
  margin-bottom: 3rem;
}

#contenedorFacturas h4.titulo-tabla {
  font-weight: 700;
  font-size: 1.4rem;
  margin-bottom: 1.5rem;
  color: #2c3e50;
  position: relative;
  padding-bottom: 12px;
  display: inline-block;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  letter-spacing: 0.02em;
}

#contenedorFacturas h4.titulo-tabla:after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 50px;
  height: 4px;
  border-radius: 2px;
}

#contenedorFacturas h4.titulo-tabla:nth-of-type(1):after {
  background: linear-gradient(90deg, #28a745, #5cb85c);
  box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

#contenedorFacturas h4.titulo-tabla:nth-of-type(2):after {
  background: linear-gradient(90deg, #dc3545, #e83e8c);
  box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

#tableFacturas,
#tableAbonoFactura {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 12px;
  overflow: hidden;
  background: white;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
  margin-bottom: 2.5rem;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

#tableFacturas thead th {
  background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%);
  color: white;
  font-weight: 600;
  padding: 16px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 0.85rem;
  position: relative;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-font-smoothing: antialiased;
}

#tableAbonoFactura thead th {
  background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
  color: white;
  font-weight: 600;
  padding: 16px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 0.85rem;
  position: relative;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-font-smoothing: antialiased;
}

#tableFacturas thead th:after,
#tableAbonoFactura thead th:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: rgba(255, 255, 255, 0.3);
}

#tableFacturas td,
#tableAbonoFactura td {
  padding: 14px 16px;
  text-align: center;
  vertical-align: middle;
  border-bottom: 1px solid rgba(0, 0, 0, 0.03);
  color: #4a5568;
  font-size: 0.95rem;
  transition: all 0.2s ease;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
  font-weight: 450;
  letter-spacing: 0.02em;
  line-height: 1.5;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
}

#tableFacturas td:nth-child(1),
#tableAbonoFactura td:nth-child(1) {
  font-family: 'SF Mono', 'Roboto Mono', monospace;
  font-weight: 500;
  color: #2c3e50;
}

#tableFacturas td:nth-child(2),
#tableAbonoFactura td:nth-child(3) {
  font-weight: 500;
  color: #1a365d;
}

#tableFacturas td:nth-child(3),
#tableAbonoFactura td:nth-child(4) {
  font-weight: 500;
  color: #2d3748;
}

#tableFacturas td:nth-child(4),
#tableAbonoFactura td:nth-child(5) {
  font-family: 'SF Mono', 'Roboto Mono', monospace;
  font-weight: 500;
  letter-spacing: 0.05em;
}

#tableFacturas td:nth-child(5),
#tableFacturas td:nth-child(6),
#tableFacturas td:nth-child(7),
#tableAbonoFactura td:nth-child(6),
#tableAbonoFactura td:nth-child(7),
#tableAbonoFactura td:nth-child(8) {
  font-family: 'SF Mono', 'Roboto Mono', monospace;
  font-size: 0.9rem;
  color: #4a5568;
}

#tableFacturas tbody tr:nth-child(even),
#tableAbonoFactura tbody tr:nth-child(even) {
  background-color: rgba(241, 245, 249, 0.5);
}

#tableFacturas tbody tr,
#tableAbonoFactura tbody tr {
  transition: all 0.35s cubic-bezier(0.215, 0.61, 0.355, 1);
  position: relative;
}

#tableFacturas tbody tr:hover {
  background-color: rgba(40, 167, 69, 0.08) !important;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(40, 167, 69, 0.1);
  z-index: 2;
}

#tableAbonoFactura tbody tr:hover {
  background-color: rgba(220, 53, 69, 0.08) !important;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(220, 53, 69, 0.1);
  z-index: 2;
}

#tableFacturas tbody tr:hover td,
#tableAbonoFactura tbody tr:hover td {
  border-bottom-color: transparent;
}

#tableFacturas tbody tr:hover td:first-child {
  border-left: 3px solid #28a745;
  padding-left: 13px;
}

#tableAbonoFactura tbody tr:hover td:first-child {
  border-left: 3px solid #dc3545;
  padding-left: 13px;
}

#tableFacturas tfoot th,
#tableAbonoFactura tfoot th {
  background: linear-gradient(to right, #f8f9fa, #e9ecef);
  padding: 14px;
  text-align: center;
  font-weight: 600;
  color: #495057;
  font-size: 0.9rem;
  font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
}

#tableFacturas {
  border: 1px solid rgba(40, 167, 69, 0.15);
}

#tableAbonoFactura {
  border: 1px solid rgba(220, 53, 69, 0.15);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

#tableFacturas,
#tableAbonoFactura {
  animation: fadeIn 0.5s ease-out forwards;
}

#tableAbonoFactura {
  animation-delay: 0.1s;
}
*/

.table-responsive {
    background: #fff;
    padding: 20px 15px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #444;
}

.table-responsive table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 12px;
}

.table-responsive table thead tr,
.table-responsive table tbody tr {
    border-bottom: 1px solid #ddd;
}

.table-responsive table th,
.table-responsive table td {
    border: none;
    padding: 10px 12px;
}

.table-responsive table thead th {
    background-color: #3AB54A;
    color: white;
    font-weight: 600;
    text-align: center;
}
#tableAbonoProforma thead th {
    background-color: #b53a3aff;
    color: white;
    font-weight: 600;
    text-align: center;
}
#tableAbonoFactura thead th {
    background-color: #b53a3aff;
    color: white;
    font-weight: 600;
    text-align: center;
}
.table-responsive table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.table-responsive table tbody tr:hover {
    background-color: #e0f0d9;
}


</style>

    <!--end head-->
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
  <!--start main content-->
<main class="page-content">
  <!-- Migas de pan -->
  <div class="page-breadcrumb d-sm-flex align-items-center">
    <div class="breadcrumb-title pe-3">
      <a href="../../view/Home/index.php" class="text-reset">Inicio</a>
    </div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item" aria-current="page">Mantenimientos</li>
          <li class="breadcrumb-item" aria-current="page">Facturación</li>
          <li class="breadcrumb-item" aria-current="page">Gestión general</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="row">
  <div class="col-12 card mg-t-20-force">
    <div class="card-body">
      <h2 class="card-title">Facturación General</h2>
      <div class="my-3 border-top"></div>

      <!-- Botones para alternar entre proforma y facturas -->
      <div class="col-12 mb-4 d-flex gap-3">
        <!-- Botón para volver a mostrar las proformas (oculto inicialmente) -->
        <button id="botonMostrarProforma" class="btn btn-primary btn-lg flex-fill d-none">
          <i class="fa-solid fa-file-invoice-dollar me-2"></i> Mostrar Factura Proforma
        </button>

        <!-- Botón para mostrar las facturas (visible inicialmente) -->
        <button id="botonMostrarFacturas" class="btn btn-success btn-lg flex-fill">
          <i class="fa-solid fa-file-invoice me-2"></i> Mostrar Facturas
        </button>
      </div>

    <!-- Contenedor de la tabla de Facturas y Abono Proforma -->
    <div class="col-12 mb-5 d-none" id="contenedorProforma">
      <!-- Tabla Proformas -->
      <h4 class="mb-3 titulo-tabla">Proformas</h4>
      <div class="table-responsive mb-4">
        <?php
          // Configuración tabla Proformas
          $nombreTabla = "tableProformas";
          $nombreCampos = ["ID Proforma", "Número Proforma", "Nombre", "CIF","A Quien Factura", "Fecha", "Abonar", "Pago Pendiente","Ver Factura"];

          // Inputs en el footer con IDs para filtros
          $nombreCamposFooter = [
            "<input type='text' id='FootIDProforma' class='form-control form-control-sm' placeholder='Buscar ID Proforma'>",
            "<input type='text' id='FootNumeroProforma' class='form-control form-control-sm' placeholder='Buscar Número Proforma'>",
            "<input type='text' id='FootNombreProforma' class='form-control form-control-sm' placeholder='Buscar Nombre'>",
            "<input type='text' id='FootCIFProforma' class='form-control form-control-sm' placeholder='Buscar CIF'>",
            "",
            "<input type='text' id='FootFechaProforma' class='form-control form-control-sm' placeholder='Buscar Fecha'>",
            "",
            "",""
          ];

          echo generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, 0, [], 0, "#28a745", 0, 0);
        ?>
      </div>

      <!-- Tabla Abono Proforma -->
      <h4 class="mb-3 titulo-tabla">Abono Proforma</h4>
      <div class="table-responsive">
        <?php
          // Configuración tabla Abono Proforma
          $nombreTabla = "tableAbonoProforma";
          $nombreCampos = ["ID Proforma", "Abonado", "Número Proforma", "Nombre", "CIF","A Quien Factura", "Fecha", "Abonado Fecha", "Abonado Motivo", "Mostrar Abono"];

          // Inputs en el footer con IDs para filtros
          $nombreCamposFooter = [
            "<input type='text' id='FootAbonoIDProforma' class='form-control form-control-sm' placeholder='Buscar ID Proforma'>",
            "<input type='text' id='FootAbonado' class='form-control form-control-sm' placeholder='Buscar Abonado'>",
            "<input type='text' id='FootAbonoNumeroProforma' class='form-control form-control-sm' placeholder='Buscar Número Proforma'>",
            "<input type='text' id='FootAbonoNombre' class='form-control form-control-sm' placeholder='Buscar Nombre'>",
            "<input type='text' id='FootAbonoCIF' class='form-control form-control-sm' placeholder='Buscar CIF'>",
            "",
            "<input type='text' id='FootAbonoFecha' class='form-control form-control-sm' placeholder='Buscar Fecha'>",
            "<input type='text' id='FootAbonadoFecha' class='form-control form-control-sm' placeholder='Buscar Abonado Fecha'>",
            "<input type='text' id='FootAbonadoMotivo' class='form-control form-control-sm' placeholder='Buscar Abonado Motivo'>",
            ""
          ];

          echo generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, 0, [], 0, "#dc3545", 0, 0);
        ?>
      </div>
    </div>


      <!-- Contenedor de la tabla de factura (visible por defecto) -->
      <div class="col-12" id="contenedorFacturas">
        <h4 class="mb-3 titulo-tabla">Facturas</h4>
        <div class="table-responsive">
          <?php
            // Configuración tabla factura
            $nombreTabla = "tableFacturas";
            $nombreCampos = ["ID Factura", "Número Factura", "Nombre", "CIF","A Quien Factura", "Fecha", "Número de Proforma", "Pagado", "Marcar Pagado", "Abonar", "Pago Pendiente","Ver Factura"];
            
            // Inputs para filtro en footer, IDs únicos para no repetir
            $nombreCamposFooter = [
              "<input type='text' class='form-control form-control-sm' id='FootFactID' placeholder='Buscar ID Factura'>",
              "<input type='text' class='form-control form-control-sm' id='FootFactNumFactura' placeholder='Buscar Número Factura'>",
              "<input type='text' class='form-control form-control-sm' id='FootFactNombre' placeholder='Buscar Nombre'>",
              "<input type='text' class='form-control form-control-sm' id='FootFactCIF' placeholder='Buscar CIF'>",
              "",
              "<input type='text' class='form-control form-control-sm' id='FootFactFecha' placeholder='Buscar Fecha'>",
              "<input type='text' class='form-control form-control-sm' id='FootFactNumProforma' placeholder='Buscar Número Proforma'>",
              "<input type='text' class='form-control form-control-sm' id='FootFactPagado' placeholder='Buscar Pagado'>",
              "<input type='text' class='form-control form-control-sm' id='FootFactMarcarPagado' placeholder='Buscar Marcar Pagado'>",
              "<input type='text' class='form-control form-control-sm' id='FootFactAbonar' placeholder='Buscar Abonar'>",
              "",""
            ];
            
            echo generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, 0, [], 0, "#28a745", 0, 0);
          ?>
        </div>

        <!-- Tabla Abono Proforma -->
        <h4 class="mb-3 mg-t-10 titulo-tabla">Abono Factura</h4>
        <div class="table-responsive">
          <?php
            // Configuración tabla Abono Factura
            $nombreTabla = "tableAbonoFactura";
            $nombreCampos = ["ID Factura", "Abonado", "Número Factura", "Nombre", "CIF","A Quien Factura",  "Fecha", "Número de Proforma", "Abonado Fecha", "Abonado Motivo", "Mostrar Abono"];
            
            // Inputs para filtro footer con IDs únicos
            $nombreCamposFooter = [
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactID' placeholder='Buscar ID Factura'>",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactAbonado' placeholder='Buscar Abonado'>",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactNumFactura' placeholder='Buscar Número Factura'>",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactNombre' placeholder='Buscar Nombre'>",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactCIF' placeholder='Buscar CIF'>",
              "",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactFecha' placeholder='Buscar Fecha'>",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactNumProforma' placeholder='Buscar Número Proforma'>",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactAbonadoFecha' placeholder='Buscar Abonado Fecha'>",
              "<input type='text' class='form-control form-control-sm' id='FootAbonoFactAbonadoMotivo' placeholder='Buscar Abonado Motivo'>",
              ""
            ];
            
            echo generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, 0, [], 0, "#dc3545", 0, 0);
          ?>
        </div>

      </div>


    </div>
  </div>
</div>

</main>

    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->


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
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
/* ========================================== */
/*     FORMATO MAESTRO COSTA DE VALENCIA     */
/* ========================================== */

.page-header-custom {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
}
.page-header-custom h2 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
}
.page-header-custom p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 0.9rem;
}
.nav-tabs-custom .nav-link {
    border: none;
    color: #6c757d;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
    transition: all 0.2s ease;
}
.nav-tabs-custom .nav-link:hover {
    color: #1AA3E8;
    background-color: rgba(26, 163, 232, 0.1);
}
.nav-tabs-custom .nav-link.active {
    color: #fff;
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
}
.btn-add-record {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-add-record:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 163, 232, 0.4);
}

/* ========================================== */

.facturacion-tabs {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  padding: 0;
  margin-bottom: 30px;
}

.facturacion-tab {
  display: flex;
  align-items: center;
  gap: 20px;
  padding: 24px 30px;
  background: #ffffff;
  border: 2px solid #e2e8f0;
  border-radius: 16px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.facturacion-tab::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background: transparent;
  transition: all 0.3s ease;
}

.facturacion-tab:hover {
  border-color: #cbd5e1;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.facturacion-tab.active {
  background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
  border-color: #1AA3E8;
  box-shadow: 0 8px 24px rgba(26, 163, 232, 0.25);
}

.facturacion-tab.active::before {
  background: #60a5fa;
}

.facturacion-tab .tab-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 56px;
  height: 56px;
  background: #f1f5f9;
  border-radius: 12px;
  font-size: 24px;
  color: #1AA3E8;
  transition: all 0.3s ease;
  flex-shrink: 0;
}

.facturacion-tab.active .tab-icon {
  background: rgba(255, 255, 255, 0.2);
  color: #ffffff;
  transform: scale(1.1);
}

.facturacion-tab .tab-content {
  display: flex;
  flex-direction: column;
  gap: 4px;
  text-align: left;
}

.facturacion-tab .tab-title {
  font-size: 18px;
  font-weight: 700;
  color: #1e293b;
  letter-spacing: -0.02em;
  transition: color 0.3s ease;
}

.facturacion-tab.active .tab-title {
  color: #ffffff;
}

.facturacion-tab .tab-subtitle {
  font-size: 13px;
  font-weight: 400;
  color: #64748b;
  transition: color 0.3s ease;
}

.facturacion-tab.active .tab-subtitle {
  color: rgba(255, 255, 255, 0.8);
}

@media (max-width: 768px) {
  .facturacion-tabs {
    grid-template-columns: 1fr;
  }
  
  .facturacion-tab {
    padding: 20px 24px;
  }
  
  .facturacion-tab .tab-icon {
    width: 48px;
    height: 48px;
    font-size: 20px;
  }
  
  .facturacion-tab .tab-title {
    font-size: 16px;
  }
  
  .facturacion-tab .tab-subtitle {
    font-size: 12px;
  }
}

/* ========================================== */
/*     TÍTULOS DE TABLAS DESTACADOS          */
/* ========================================== */

.titulo-tabla {
  font-size: 20px;
  font-weight: 600;
  letter-spacing: -0.01em;
  padding: 14px 20px;
  margin-bottom: 20px !important;
  border-radius: 8px;
  position: relative;
  background: #f8fafc;
  border-left: 4px solid #64748b;
  color: #1e293b;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
  transition: all 0.2s ease;
}

/* Estilos específicos para cada tipo de tabla */
#contenedorProforma .titulo-tabla:first-of-type {
  background: #f0fdf4;
  border-left-color: #10b981;
  color: #065f46;
}

#contenedorProforma .titulo-tabla:nth-of-type(2) {
  background: #fef2f2;
  border-left-color: #ef4444;
  color: #991b1b;
}

#contenedorFacturas .titulo-tabla:first-of-type {
  background: #f0fdf4;
  border-left-color: #10b981;
  color: #065f46;
}

#contenedorFacturas .titulo-tabla:nth-of-type(2) {
  background: #fef2f2;
  border-left-color: #ef4444;
  color: #991b1b;
}

.titulo-tabla:hover {
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
}

/* ========================================== */
/*     ESTILOS BÁSICOS DE TABLAS             */
/* ========================================== */

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
  <div class="col-12 card mt-3">
    <div class="card-body">
      <!-- Header profesional -->
      <div class="page-header-custom">
        <h2><i class='bx bx-receipt me-2'></i>Informe de Facturación</h2>
        <p>Gestión completa de facturas proforma, facturas reales y abonos</p>
      </div>

      <!-- Botones modernos tipo tab para alternar entre proforma y facturas -->
      <div class="col-12 mb-4">
        <div class="facturacion-tabs">
          <button id="botonMostrarProforma" class="facturacion-tab">
            <div class="tab-icon">
              <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
            <div class="tab-content">
              <span class="tab-title">Factura Proforma</span>
              <span class="tab-subtitle">Gestión de proformas y abonos</span>
            </div>
          </button>

          <button id="botonMostrarFacturas" class="facturacion-tab active">
            <div class="tab-icon">
              <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div class="tab-content">
              <span class="tab-title">Facturas Reales</span>
              <span class="tab-subtitle">Gestión de facturas y abonos</span>
            </div>
          </button>
        </div>
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
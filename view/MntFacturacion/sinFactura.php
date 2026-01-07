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
  <style>
    

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
            <li class="breadcrumb-item" aria-current="page">Gestión Proforma sin Factura</li>
            </ol>
        </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12 card mg-t-20-force">
        <div class="card-body">
            <h2 class="card-title">Proformas sin Factura</h2>
            <div class="my-3 border-top"></div>

            <!-- Contenedor de la tabla de Proformas -->
            <div class="col-12 mb-5" id="contenedorProforma">
            <h4 class="mb-3 titulo-tabla">Proformas</h4>
            <div class="table-responsive mb-4">
        <?php
          // Configuración tabla Proformas
          $nombreTabla = "tableProformas";
          $nombreCampos = ["ID Proforma", "Número Proforma", "Nombre", "CIF", "Fecha", "Facturar"];

          // Inputs en el footer con IDs para filtros
          $nombreCamposFooter = [
            "<input type='text' id='FootIDProforma' class='form-control form-control-sm' placeholder='Buscar ID Proforma'>",
            "<input type='text' id='FootNumeroProforma' class='form-control form-control-sm' placeholder='Buscar Número Proforma'>",
            "<input type='text' id='FootNombreProforma' class='form-control form-control-sm' placeholder='Buscar Nombre'>",
            "<input type='text' id='FootCIFProforma' class='form-control form-control-sm' placeholder='Buscar CIF'>",
            "<input type='text' id='FootFechaProforma' class='form-control form-control-sm' placeholder='Buscar Fecha'>",
            ""
       
          ];

          echo generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, 0, [], 0, "#28a745", 0, 0);
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
    <script src="sinFactura.js"></script>
    <!--end plugins extra-->

</body>

</html>
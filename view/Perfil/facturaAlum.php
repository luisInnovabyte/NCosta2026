<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['0', '1', '2', '3']);

    ?>
    <!--end head-->
    <style>
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }
        table.dataTable {
    width: 100% !important;
  }

  table.dataTable th,
  table.dataTable td {
    text-align: center; /* Centrar el contenido */
    vertical-align: middle; /* Alinear verticalmente */
  }

  .badge {
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 14px;
  }

  .btn {
    padding: 6px 10px;
    margin: 2px;
    font-size: 14px;
  }

  /* Ajuste para las columnas de estado */
  .badge-success {
    background-color: #28a745 !important;
  }

  .badge-secondary {
    background-color: #6c757d !important;
  }

  .badge-warning {
    background-color: #ffc107 !important;
    color: #000;
  }

  .badge-info {
    background-color: #17a2b8 !important;
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
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Perfil</li>
                        <li class="breadcrumb-item" aria-current="page">Facturas</li>
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
                <div class="card-body">
                    <h2 class="card-title">Facturas</h2>
                    <div class="my-3 border-top"></div>

                        <input type="hidden" id="idTokenUsu" value="<?php echo $_GET['tokenUsu']; ?>">
                       
                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">

                                <div class="table-responsive">
                                        <?php
                                            // Configuración tabla factura
                                            $nombreTabla = "tableFacturas";
                                            $nombreCampos = ["ID Factura", "Número Factura", "Nombre", "CIF", "Fecha", "Número de Proforma", "Pagado", "Marcar Pagado", "Abonar", "Pago Pendiente","Ver Factura"];
                                            
                                            // Inputs para filtro en footer, IDs únicos para no repetir
                                            $nombreCamposFooter = [
                                            "<input type='text' class='form-control form-control-sm' id='FootFactID' placeholder='Buscar ID Factura'>",
                                            "<input type='text' class='form-control form-control-sm' id='FootFactNumFactura' placeholder='Buscar Número Factura'>",
                                            "<input type='text' class='form-control form-control-sm' id='FootFactNombre' placeholder='Buscar Nombre'>",
                                            "<input type='text' class='form-control form-control-sm' id='FootFactCIF' placeholder='Buscar CIF'>",
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->


    <?php include("../../config/templates/searchModal.php"); ?>
    <?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <!--end plugins extra-->

    <script src="facturaAlum.js"></script>


</body>

</html>
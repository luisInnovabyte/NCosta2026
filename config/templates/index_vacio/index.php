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
    <!--end head-->
    <style>
        /* Estilos profesionales para la página */
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
    </style>
</head>

<body>
    <!--start mainHeader-->
    <?php include("../../config/templates/mainHeader.php"); ?>
    <!--end mainHeader-->

    <!--start sidebar-->
    <?php include("../../config/templates/mainSidebar.php"); ?>
    <!--end sidebar-->

    <!--start main content-->
    <main class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">
                <a href="../../view/Home/index.php" class="text-reset">Inicio</a>
            </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Categoría</li>
                        <li class="breadcrumb-item active" aria-current="page">Título Página</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Header de la página -->
        <div class="page-header-custom">
            <h2><i class='bx bx-file me-2'></i>Título de la Página</h2>
            <p>Descripción breve de la funcionalidad de esta página</p>
        </div>

        <!-- Contenedor principal -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    
                    <!-- AQUÍ VA EL CONTENIDO DE LA PÁGINA -->
                    
                </div>
            </div>
        </div>

    </main>
         <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->
    <!--end main content-->

    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <?php include("../../config/templates/searchModal.php"); ?>
    <?php include("../../config/templates/mainFooter.php"); ?>

    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>
    <!--end theme customization-->

    <?php include("../../config/templates/mainFooter.php"); ?>

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
<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // Control de acceso - Solo administradores
    checkAccess(['1']);
    ?>
    <!--end head-->
    <style>
        /* Estilos profesionales para la página */
        .page-header-custom {
            background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);
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
        
        /* Estilos para las alertas de nivel */
        .badge-vencido {
            background: #8B0000 !important;
            color: white;
        }
        .badge-critico {
            background: #DC143C !important;
            color: white;
        }
        .badge-urgente {
            background: #FF4500 !important;
            color: white;
        }
        .badge-importante {
            background: #FFA500 !important;
            color: white;
        }
        .badge-aviso {
            background: #FFD700 !important;
            color: #333;
        }
        .badge-normal {
            background: #32CD32 !important;
            color: white;
        }

        /* Estilos para la tabla */
        .table-wrapper {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Estilos para los filtros */
        .status-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.5rem;
        }

        .status-option {
            flex: 1;
            min-width: 150px;
        }

        .status-radio {
            display: none;
        }

        .status-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .status-radio:checked + .status-label {
            border-color: #1AA3E8;
            background: #E8F4FD;
            font-weight: 600;
        }

        .status-icon {
            margin-right: 0.5rem;
        }

        /* Estilos para detalles expandibles */
        td.details-control {
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNCA2TDggMTBMMTIgNiIgc3Ryb2tlPSIjMzMzIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPjwvc3ZnPg==') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMTBMOCA2TDQgMTAiIHN0cm9rZT0iIzMzMyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz48L3N2Zz4=') no-repeat center center;
        }
        
        /* Asegurar que el modal se muestre correctamente */
        #modalAyudaAlertasCriticas {
            z-index: 9999 !important;
        }
        #modalAyudaAlertasCriticas .modal-dialog {
            z-index: 10000 !important;
        }
        .modal-backdrop {
            z-index: 9998 !important;
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
                        <li class="breadcrumb-item" aria-current="page">Llegadas</li>
                        <li class="breadcrumb-item active" aria-current="page">Alertas Críticas de Pago</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Header de la página -->
        <div class="page-header-custom">
            <div class="d-flex align-items-center">
                <h2 class="mb-0"><i class='bx bx-error-circle me-2'></i>Alertas Críticas de Pago</h2>
                <button type="button" class="btn btn-link p-0 ms-2 text-white" data-bs-toggle="modal" data-bs-target="#modalAyudaAlertasCriticas" title="Ayuda sobre el módulo">
                    <i class="bi bi-question-circle" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <p class="mb-0">Listado de llegadas con pagos pendientes según nivel de urgencia</p>
        </div>

        <!-- Contenedor principal -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    
                    <!-- Contenedor de alerta expandible -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div class="flex-grow-1 me-3" style="min-width: 300px;">
                            <!-- Alerta de filtro activo -->
                            <div class="alert alert-warning alert-dismissible fade show mb-0 w-100" role="alert" id="filter-alert" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="truncate">
                                        <i class="fas fa-filter me-2"></i>
                                        <span>Filtros aplicados: </span>
                                        <span id="active-filters-text" class="text-truncate"></span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-warning ms-2 flex-shrink-0" id="clear-filter">
                                        Limpiar filtros
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acordeón de Filtros -->
                    <div id="accordion" class="accordion mb-3">
                        <div class="card">
                            <div class="card-header bg-white border-bottom py-2">
                                <button class="btn btn-link w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                                </button>
                            </div>
                            <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body pd-20 pt-3">
                                    <div class="row g-3">
                                        <!-- Bloque Nivel de Alerta -->
                                        <div class="col-md-12">
                                            <div class="card shadow-sm h-100">
                                                <div class="card-header bg-white border-bottom py-2">
                                                    <h6 class="mb-0 text-primary">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>Nivel de Alerta
                                                    </h6>
                                                </div>
                                                <div class="card-body p-2">
                                                    <div class="status-selector">
                                                        <div class="status-option">
                                                            <input type="radio" name="filterStatus" id="filterAll" value="all" class="status-radio" checked>
                                                            <label for="filterAll" class="status-label">
                                                                <span class="status-icon">
                                                                    <i class="fas fa-layer-group"></i>
                                                                </span>
                                                                <span class="status-text">Todos</span>
                                                            </label>
                                                        </div>
                                                        <div class="status-option">
                                                            <input type="radio" name="filterStatus" id="filterVencido" value="VENCIDO" class="status-radio">
                                                            <label for="filterVencido" class="status-label">
                                                                <span class="status-icon">
                                                                    <i class="fas fa-times-circle"></i>
                                                                </span>
                                                                <span class="status-text">Vencidos</span>
                                                            </label>
                                                        </div>
                                                        <div class="status-option">
                                                            <input type="radio" name="filterStatus" id="filterCritico" value="CRÍTICO" class="status-radio">
                                                            <label for="filterCritico" class="status-label">
                                                                <span class="status-icon">
                                                                    <i class="fas fa-exclamation-circle"></i>
                                                                </span>
                                                                <span class="status-text">Críticos</span>
                                                            </label>
                                                        </div>
                                                        <div class="status-option">
                                                            <input type="radio" name="filterStatus" id="filterUrgente" value="URGENTE" class="status-radio">
                                                            <label for="filterUrgente" class="status-label">
                                                                <span class="status-icon">
                                                                    <i class="fas fa-bolt"></i>
                                                                </span>
                                                                <span class="status-text">Urgentes</span>
                                                            </label>
                                                        </div>
                                                        <div class="status-option">
                                                            <input type="radio" name="filterStatus" id="filterImportante" value="IMPORTANTE" class="status-radio">
                                                            <label for="filterImportante" class="status-label">
                                                                <span class="status-icon">
                                                                    <i class="fas fa-bell"></i>
                                                                </span>
                                                                <span class="status-text">Importantes</span>
                                                            </label>
                                                        </div>
                                                        <div class="status-option">
                                                            <input type="radio" name="filterStatus" id="filterAviso" value="AVISO" class="status-radio">
                                                            <label for="filterAviso" class="status-label">
                                                                <span class="status-icon">
                                                                    <i class="fas fa-info-circle"></i>
                                                                </span>
                                                                <span class="status-text">Avisos</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- card -->
                    </div><!-- accordion -->

                    <!-- Tabla de alertas críticas -->
                    <div class="table-wrapper">
                        <table id="alertas_criticas_data" class="table display responsive nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID Llegada</th>
                                    <th>Grupo</th>
                                    <th>Prescriptor</th>
                                    <th>Nivel Alerta</th>
                                    <th>Días hasta inicio</th>
                                    <th>Pago Pendiente</th>
                                    <th>% Pagado</th>
                                    <th>Departamento</th>
                                    <th>Agente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos se cargarán aquí -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th><input type="text" placeholder="Buscar ID" class="form-control form-control-sm" /></th>
                                    <th><input type="text" placeholder="Buscar grupo" class="form-control form-control-sm" /></th>
                                    <th><input type="text" placeholder="Buscar prescriptor" class="form-control form-control-sm" /></th>
                                    <th>
                                        <select class="form-control form-control-sm" title="Filtrar por nivel">
                                            <option value="">Todos los niveles</option>
                                            <option value="VENCIDO">Vencido</option>
                                            <option value="CRÍTICO">Crítico</option>
                                            <option value="URGENTE">Urgente</option>
                                            <option value="IMPORTANTE">Importante</option>
                                            <option value="AVISO">Aviso</option>
                                            <option value="NORMAL">Normal</option>
                                        </select>
                                    </th>
                                    <th><input type="text" placeholder="Buscar días" class="form-control form-control-sm" /></th>
                                    <th><input type="text" placeholder="Buscar monto" class="form-control form-control-sm" /></th>
                                    <th><input type="text" placeholder="Buscar %" class="form-control form-control-sm" /></th>
                                    <th><input type="text" placeholder="Buscar departamento" class="form-control form-control-sm" /></th>
                                    <th><input type="text" placeholder="Buscar agente" class="form-control form-control-sm" /></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- table-wrapper -->
                    
                </div>
            </div>
        </div>

    </main>
    <!--end main content-->

    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <?php include("../../config/templates/searchModal.php"); ?>

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
    <script type="text/javascript" src="index.js"></script>
    <!--end plugins extra-->

    <!-- Modal de Ayuda -->
    <?php include("ayuda.php"); ?>

    <script>
        // Asegurar que el modal funcione correctamente
        $(document).ready(function() {
            $('#modalAyudaAlertasCriticas').appendTo('body');
        });
    </script>

</body>

</html>

<?php 
session_start();

// Obtener y validar parámetros relevantes para gestionarEvaluacion
$idLlegada = $_GET['idLlegada'] ?? null;
$tokenUsuURL1 = $_GET['tokenUsu'] ?? null;

// Validar parámetros: si no vienen, redirigir a la página principal de gestionarEvaluacion
if(!$idLlegada || !$tokenUsuURL1) {
    header("Location: ../../view/gestionarEvaluacion/index.php");
    exit();
}

?>
<!doctype html>
<html lang="es" data-bs-theme="light">
<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php include("../Home/asignacionColorPrincipal.php"); ?>
    <?php checkAccess(['2','3','1']); // Permisos según roles ?>

    <style>
        /* Encabezado personalizado para gestión de evaluación */
        .evaluation-header {
            background-color: #0056b3; /* Azul oscuro, representando seriedad */
            color: white;
            padding: 25px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .evaluation-header small {
            display: block;
            margin-top: 5px;
            font-style: italic;
            font-weight: 400;
            opacity: 0.85;
        }
        
        .evaluation-section {
            margin-bottom: 30px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 18px;
        }
        
        .section-title {
            border-bottom: 3px solid #198754; /* Verde para acciones positivas */
            padding-bottom: 7px;
            margin-bottom: 18px;
            color: #198754;
            font-weight: 600;
            font-size: 1.3rem;
        }
        
        .total-hours {
            font-weight: 700;
            font-size: 1.2rem;
            color: #198754;
        }

        .generarReporte {
            transition: transform 0.2s ease-in-out;
        }
        .generarReporte:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(25, 135, 84, 0.5);
        }

        /* From Uiverse.io by csozidev */
        /* From Uiverse.io by guilhermeyohan */

        .check-online {
            position: relative;
            width: 50px;
            height: 25px;
            margin: 0;
            user-select: none;
            display: inline-block;
        }

        /* ✅ OCULTAR el checkbox original correctamente */
        .check-online input[type="checkbox"] {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
            left: -9999px;
        }

        /* ✅ Estilos del switch */
        .check-online label {
            display: block;
            width: 50px;
            height: 25px;
            border-radius: 50px;
            background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .check-online label:after {
            content: '';
            position: absolute;
            top: 1px;
            left: 1px;
            width: 23px;
            height: 23px;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .check-online input[type="checkbox"]:checked + label {
            background: linear-gradient(to bottom, #4cd964, #5de24e);
        }

        .check-online input[type="checkbox"]:checked + label:after {
            transform: translateX(25px);
        }

        /* Opcional: efecto hover */
        .check-online label:hover {
            background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
        }

        /* Ajusta el alto del editor visualmente */
        .note-editor {
        height: 400px !important;
        }

        /* Ajusta el área editable interna */
        .note-editable {
        height: 300px !important;
        overflow-y: auto;
        resize: none;
        }

    </style>
</head>

<body>
    <?php include("../../config/templates/mainHeader.php"); ?>
    <?php include("../../config/templates/mainSidebar.php"); ?>

    <main class="page-content">
        <input type="hidden" id="idLlegada" value="<?php echo $idLlegada?>">
        <input type="hidden" id="tokenUsu" value="<?php echo $tokenUsuURL1?>">

        <!-- Breadcrumb adaptado para gestionarEvaluacion -->
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="index.php" class="text-reset">Evaluaciones</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item active" aria-current="page">Detalle de Evaluación #<?= htmlspecialchars($idLlegada) ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 card mt-3">
                <div class="card-body">
                    <!-- Encabezado -->
                    <div class="evaluation-header text-center">
                        <h2><i class="fa-solid fa-clipboard-check me-2"></i>Detalle de Evaluación</h2>
                        <small>Registro detallado de la formación y actividades del alumno</small>
                        <h5 class="mt-2">Nº Registro: <?= htmlspecialchars($idLlegada) ?></h5>
                        <button class="btn btn-success" type="button" onclick="mostrarModalCertificado(<?php echo $_GET['idLlegada']?>)"> Gestionar Certificado </button>

                    </div>

                    <!-- Cursos Realizados -->
                    <div class="evaluation-section">
                        <h4 class="section-title"><i class="fa-solid fa-book-open-reader me-2"></i>Cursos Realizados</h4>
                        <div class="table-responsive">
                            <?php
                            $nombreTabla = "cursos_table";
                            $nombreCampos = ["Ruta", "Fecha Inicio", "Estado y Fecha Fin", "Estado Curso", "Descargar"];
                            $cantidadGrupos = 0;
                            $columGrupos = [];
                            $agrupacionesPersonalizadas = 0;
                            $colorHEX = "#0056b3"; 
                            $desplegado = 0;
                            $colorPicker = 0;

                            echo generarTabla($nombreTabla,$nombreCampos,$nombreCampos,$cantidadGrupos,$columGrupos,$agrupacionesPersonalizadas,$colorHEX,$desplegado,$colorPicker);
                            ?>
                        </div>
                    </div>

                    
                    <!-- Actividades Adicionales -->
                    <div class="evaluation-section">
                        <h4 class="section-title"><i class="fa-solid fa-calendar-check me-2"></i>Actividades Adicionales</h4>
                        <div class="table-responsive">
                            <?php
                            $nombreTabla = "actividades_table";
                            $nombreCampos = ["Actividad", "Fecha Actividad", "Horas Lectivas", "Punto de encuentro"];
                            $cantidadGrupos = 0;
                            $columGrupos = [];
                            $agrupacionesPersonalizadas = 0;
                            $colorHEX = "#198754";
                            $desplegado = 0;
                            $colorPicker = 0;

                            echo generarTabla($nombreTabla, $nombreCampos, $nombreCampos, $cantidadGrupos, $columGrupos,
                                              $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                            ?>
                        </div>
                    </div>

                    <!-- Resumen Total -->
                    <div class="evaluation-section">
                        <h4 class="section-title"><i class="fa-solid fa-chart-pie me-2"></i>Resumen Total</h4>
                        <div class="table-responsive">
                            <?php
                            $nombreTabla = "resumen_table";
                            $nombreCampos = ["Curso", "Actividad", "Total Horas"];
                            $cantidadGrupos = 1;
                            $columGrupos = [1];
                            $agrupacionesPersonalizadas = 0;
                            $colorHEX = "#6f42c1";
                            $desplegado = 0;
                            $colorPicker = 0;

                            echo generarTabla($nombreTabla, $nombreCampos, $nombreCampos, $cantidadGrupos, $columGrupos,
                                              $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                            ?>
                        </div>
                    </div>

                    <?php 
                    // Validar token para seguridad
                    if (!$tokenUsu) {
                        header("Location: ../../view/gestionarEvaluacion/index.php");
                        exit();
                    }
                    ?>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-primary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Regresar a Evaluaciones
                        </a>
                        <div>
                            <button class="btn btn-success imprimirEvaluacion">
                                <i class="fa-solid fa-file-pdf me-2"></i>Imprimir evaluación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'modalCertificado.php' ?>
        <?php include_once 'modalCertificadoCurso.php' ?>

    </main>

    <?php include("../../config/templates/mainFooter.php"); ?>
    <?php include("../../config/templates/mainJs.php"); ?>

    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="gestionarEvaluacion.js"></script>

</body>
</html>

<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/ZonaAlumnos.php");

session_start();
require_once("../models/Log.php");

$zonaAlumnos = new ZonaAlumnos();



switch ($_GET["op"]) {

    case "listarCursos":

        $cursosAlumno = $zonaAlumnos->listarCursosAlumno();

        echo json_encode($cursosAlumno);


    break;

case "listarCursosPorLlegada":

    if (!isset($_SESSION['llegada_idLlegada'])) {
    echo json_encode([
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => [],
        "error" => "No se ha seleccionado una llegada válida."
    ]);
    break;
}

    $cursos = $zonaAlumnos->listarCursosAlumnoEducacion();
    file_put_contents('CURSOSLISTAR1.json', json_encode($cursos));

    $data = array();

    foreach ($cursos as $row) {
        $sub_array = array();

        // RUTA (idioma, tipo, nivel)
        $sub_array[] = '
            <span class="badge bg-danger-subtle text-danger border border-danger" style="font-size: 1rem;">'
                . $row["codIdioma"] . ' ' . $row["descrIdioma"] .
            '</span>
            <span class="badge bg-info-subtle text-info border border-info" style="font-size: 1rem;">'
                . $row["codTipo"] . ' ' . $row["descrTipo"] .
            '</span>
            <span class="badge bg-warning-subtle text-warning border border-warning" style="font-size: 1rem;">'
                . $row["codNivel"] . ' ' . $row["descrNivel"] .
            '</span>';

        // FECHA INICIO
        $fechaInicio = !empty($row["fechaNuevaCursos"]) ? $row["fechaNuevaCursos"] : $row["fechaCrea_cursos"];
        if (!empty($fechaInicio)) {
            $sub_array[] = '<label class="tx-dark tx-bold" style="font-size: 1rem;">' . fechaLocal($fechaInicio) . '</label>';
        } else {
            $sub_array[] = '<label class="text-muted" style="font-size: 1rem;"><i>No disponible</i></label>';
        }

        // FECHA FIN + ESTADO en un único label
        if (!empty($row["fecFinCurso"])) {
            $fechaFin = $row["fecFinCurso"];
            $hoy = date("Y-m-d H:i:s");

            $tsFechaFin = strtotime($fechaFin);
            $tsHoy = strtotime($hoy);

            if ($tsFechaFin < $tsHoy) {
                $estadoTexto = 'Finalizado';
                $estadoClass = 'bg-danger';
            } else {
                $estadoTexto = 'En curso';
                $estadoClass = 'bg-success';
            }

            $fechaFormateada = FechaHoraLocal($fechaFin);

            $sub_array[] = '<label class="badge ' . $estadoClass . ' text-white fw-bold" style="font-size: 1rem;">' .
                            $estadoTexto . ' — ' . $fechaFormateada .
                        '</label>';
        } else {
            $sub_array[] = '<label class="badge bg-warning text-dark fw-bold" style="font-size: 1rem;">En proceso</label>';
        }

        // ACCIONES
        $btnStyle = 'font-size: 0.85rem; width: 36px; height: 30px; padding: 4px 0; display: inline-flex; align-items: center; justify-content: center;';

        $botonVer = '<button title="Ver detalles" class="btn btn-info btn-sm me-1" style="' . $btnStyle . '">
                        <i class="fa-solid fa-eye"></i>
                    </button>';

        if ($row['est_cursos'] == 1) {
            $botonEstado = '<button title="Curso Activo" class="btn btn-success btn-sm" style="' . $btnStyle . '">
                                <i class="fa-solid fa-check"></i>
                            </button>';
        } else {
            $botonEstado = '<button title="Curso Inactivo" class="btn btn-danger btn-sm" style="' . $btnStyle . '">
                                <i class="fa-solid fa-xmark"></i>
                            </button>';
        }

        $sub_array[] = $botonVer . $botonEstado;

        $data[] = $sub_array;
    }

    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );

    echo json_encode($results);
    break;

    case "listarCursosPorLlegadaSeleccionada":

        $idLlegada = isset($_GET['idLlegada']) ? $_GET['idLlegada'] : 0;

        // Método para filtrar los cursos por llegada:
        $cursos = $zonaAlumnos->listarCursosPorLlegadaSeleccionadaModelo($idLlegada);

        $data = array();

        foreach ($cursos as $row) {
            $sub_array = array();

            // RUTA (idioma, tipo, nivel)
            $sub_array[] = '
                <span class="badge bg-danger-subtle text-danger border border-danger" style="font-size: 1rem;">'
                    . $row["codIdioma"] . ' ' . $row["descrIdioma"] .
                '</span>
                <span class="badge bg-info-subtle text-info border border-info" style="font-size: 1rem;">'
                    . $row["codTipo"] . ' ' . $row["descrTipo"] .
                '</span>
                <span class="badge bg-warning-subtle text-warning border border-warning" style="font-size: 1rem;">'
                    . $row["codNivel"] . ' ' . $row["descrNivel"] .
                '</span>';

            // FECHA INICIO
            $fechaInicio = !empty($row["fechaNuevaCursos"]) ? $row["fechaNuevaCursos"] : $row["fechaCrea_cursos"];
            if (!empty($fechaInicio)) {
                $sub_array[] = '<label class="tx-dark tx-bold" style="font-size: 1rem;">' . fechaLocal($fechaInicio) . '</label>';
            } else {
                $sub_array[] = '<label class="text-muted" style="font-size: 1rem;"><i>No disponible</i></label>';
            }

            // FECHA FIN + ESTADO en un único label
            if (!empty($row["fecFinCurso"])) {
                $fechaFin = $row["fecFinCurso"];
                $hoy = date("Y-m-d H:i:s");

                $tsFechaFin = strtotime($fechaFin);
                $tsHoy = strtotime($hoy);

                if ($tsFechaFin < $tsHoy) {
                    $estadoTexto = 'Finalizado';
                    $estadoClass = 'bg-danger';
                } else {
                    $estadoTexto = 'En curso';
                    $estadoClass = 'bg-success';
                }

                $fechaFormateada = FechaHoraLocal($fechaFin);

                $sub_array[] = '<label class="badge ' . $estadoClass . ' text-white fw-bold" style="font-size: 1rem;">' .
                                $estadoTexto . ' — ' . $fechaFormateada .
                            '</label>';
            } else {
                $sub_array[] = '<label class="badge bg-warning text-dark fw-bold" style="font-size: 1rem;">En proceso</label>';
            }

            // Mostrar estado para tener info visual:
            if ($row['est_cursos'] == 1) {
                $estadoTexto = '<span class="badge bg-success text-white fw-bold" style="font-size: 1rem;">Activo</span>';
            } else {
                $estadoTexto = '<span class="badge bg-danger text-white fw-bold" style="font-size: 1rem;">Inactivo</span>';
            }
            $sub_array[] = $estadoTexto;

            $sub_array[] = "<button class='btn btn-success btn-sm' title='Imprimir Certificado' 
                                style='font-size: 0.85rem; width: 36px; height: 30px; display: inline-flex; align-items: center; justify-content: center;' 
                                onclick='mostrarModalCertificadoPorCurso(" . 
                                    $row["idLlegada_cursos"] . ", " . 
                                    $row["idAlumno_cursos"] . ", " . 
                                    json_encode($row["codGrupo"]) . ", " . 
                                    ($row["idCertificado"] ?? 'null') . // pasa null si no existe
                                ")'>
                                <i class='fa-solid fa-award'></i>
                            </button>";

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
        break;

    case "obtenerCursosYHoras":
        if (!isset($_POST['idLlegada'])) {
            echo json_encode([
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => [],
                "error" => "No se ha proporcionado un ID de llegada válido."
            ]);
            break;
        }

        $idLlegada = $_POST['idLlegada'];
        $cursos = $zonaAlumnos->obtenerCursosConRutaYHoras($idLlegada);
        file_put_contents('debugCursosPorRuta.json', json_encode($cursos));

        $data = [];

        foreach ($cursos as $row) {
            $sub_array = [];

            // RUTA (idioma, tipo, nivel) - Manteniendo exactamente la misma estructura visual
            $sub_array[] = '
                <span class="badge bg-danger-subtle text-danger border border-danger" style="font-size: 1rem;">'
                    . htmlspecialchars($row["codIdioma"] . ' ' . $row["descrIdioma"]) .
                '</span>
                <span class="badge bg-info-subtle text-info border border-info" style="font-size: 1rem;">'
                    . htmlspecialchars($row["codTipo"] . ' ' . $row["descrTipo"]) .
                '</span>
                <span class="badge bg-warning-subtle text-warning border border-warning" style="font-size: 1rem;">'
                    . htmlspecialchars($row["codNivel"] . ' ' . $row["descrNivel"]) .
                '</span>';

            // HORAS LECTIVAS
            $sub_array[] = '<label class="tx-dark tx-bold" style="font-size: 1rem;">' 
                        . htmlspecialchars($row["horasLectivas"]) . ' horas</label>';

            $data[] = $sub_array;
        }

        echo json_encode([
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ]);
        break;

}

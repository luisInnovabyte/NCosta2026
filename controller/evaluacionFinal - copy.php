<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/EvaluacionFinal.php");
require_once("../models/Actividades_Edu.php");

session_start();
require_once("../models/Log.php");

$evaluacionFinal = new EvaluacionFinal();
$actividad = new Actividades();

switch ($_GET["op"]) {

case "mostrarAlumnosFinal":

    // Obtener parámetros de la request GET
    $idDepartamento = isset($_GET['idDepartamento']) ? $_GET['idDepartamento'] : null;
    $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
    $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : null;

    // Decidir qué método usar según parámetros recibidos

   // SI SE TIENE TANTO IDDEPARTAMENTO, FECHA INICIO Y FECHA FIN, SE FILTRA TANTO POR DEPARTAMENTO, COMO POR FECHAS
    if (!empty($idDepartamento) && !empty($fechaInicio) && !empty($fechaFin)) {
        $datos = $evaluacionFinal->obtenerAlumnosFiltrados($idDepartamento, $fechaInicio, $fechaFin);
    }
    // SI SE TIENE IDDEPARTAMENTO Y SOLO FECHA INICIO
    else if (!empty($idDepartamento) && !empty($fechaInicio) && empty($fechaFin)) {
        $datos = $evaluacionFinal->obtenerAlumnosPorFechaExacta($idDepartamento, $fechaInicio);
    }
    // SI SE TIENE IDDEPARTAMENTO Y SOLO FECHA FIN
    else if (!empty($idDepartamento) && empty($fechaInicio) && !empty($fechaFin)) {
        $datos = $evaluacionFinal->obtenerAlumnosPorFechaExacta($idDepartamento, $fechaFin);
    }
    else if (!empty($idDepartamento)) {
        // SI SOLO SE TIENE IDDEPARTAMENTO, SE FILTRA SOLO POR DEPARTAMENTO
        $datos = $evaluacionFinal->mostrarAlumnosFinal($idDepartamento);
    }
    else {
        // No hay parámetros válidos, no continuar y devolver error o vacío
        echo json_encode([
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        ]);
        return; // O exit;
    }

    $data = array();

    foreach ($datos as $row) {
        $sub_array = array();

        $estado = $row["estadoLlegadaEvaluacionFinal"];
        $estadoMostrar = "";

        switch ($estado) {
            case 1:
                $estadoMostrar = "<label class='badge bg-success tx-14-force'>Aprobado</label>";
                break;
            case 2:
                $estadoMostrar = "<label class='badge bg-danger tx-14-force'>Suspendido</label>";
                break;
            case 3:
                $estadoMostrar = "<label class='badge bg-secondary tx-14-force'>Cancelado</label>";
                break;
            case 0:
                $estadoMostrar = "<label class='badge bg-light text-dark tx-14-force'>Sin Evaluar</label>";
                break;
            case null:
            default:
                $estadoMostrar = "<label class='badge bg-light text-dark tx-14-force'>Sin Evaluar</label>";
                break;
        }

        $sub_array[] = $row["id_llegada"];
        $sub_array[] = $row["idAlumno"] . ' - ' . $row["nomUsuario"] . ' ' . $row["nomAlumno"] . ' ' . $row["apeAlumno"];
        $sub_array[] = $row["id_llegada"];
        $sub_array[] = 'Sin Grupo por ahora';
        $sub_array[] = $row["tarifas_asociadas"];
        $sub_array[] = $row["fechas_inicio_matricula"];
        $sub_array[] = $row["fechas_fin_matricula"];
        $sub_array[] = $estadoMostrar;
        $sub_array[] = "<a href='gestionarEvaluacion.php?idLlegada=" . urlencode($row["id_llegada"]) . "&tokenUsu=" . urlencode($row["tokenUsu"]) . "' class='btn btn-success btn-sm' title='Gestionar Alumno' style='font-size: 0.85rem; width: 36px; height: 30px; display: inline-flex; align-items: center; justify-content: center;'><i class='fa-solid fa-award'></i></a>";
        $sub_array[] = $row["fecha_inicio_mas_temprana"];
        $sub_array[] = $row["fecha_fin_mas_tardia"];

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

case "obtenerActividadesYHorasEvaluacion":
    $idLlegada = $_POST['idLlegada'] ?? null;
    $tokenUsu = $_POST['tokenUsu'] ?? null;

    if ($idLlegada && $tokenUsu) {
        $datos = $evaluacionFinal->obtenerActividadesPorLlegadaEvaluacion($idLlegada, $tokenUsu);

        // Adaptar datos para DataTable
        $data = [];
        foreach ($datos as $row) {
            $sub_array = [];
            $sub_array['nombreActividad'] = $row["descrAct"];
            $sub_array['fechaActividad'] = FechaLocal($row["fecActDesde"]) . ' ' . horaLocalSinSegundos($row["horaInicioAct"]) . ' / ' . FechaLocal($row["fecActHasta"]) . ' ' . horaLocalSinSegundos($row["horaFinAct"]);

            if ($row["horasLectivasAct"] == 1) {
                $sub_array['horasLectivas'] = $row["horasLectivasAct"] . " hora";
            } else if ($row["horasLectivasAct"] > 1) {
                $sub_array['horasLectivas'] = $row["horasLectivasAct"] . " horas";
            } else {
                $sub_array['horasLectivas'] = '';
            }

            $sub_array['puntoEncuentro'] = $row["puntoEncuentroAct"];

            $data[] = $sub_array;
        }

        $results = [
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ];

        echo json_encode($results);
    } else {
        echo json_encode([
            "error" => true,
            "mensaje" => "Faltan parámetros idLlegada o tokenUsu"
        ]);
    }
    break;


    
    case "recogerEvaluacionFinalAlumno":
        $idLlegada = $_POST['idLlegada'] ?? null;
        $datos = $evaluacionFinal->recogerEvaluacionFinalAlumno($idLlegada);
    
        echo json_encode($datos);
       
    break;

    case "recogerEvaluacionFinalAlumnoPorCurso":
        $idLlegada = $_POST['idLlegada'] ?? null;
        $codigoGrupo = $_POST['codigoGrupo'] ?? null;
        $datos = $evaluacionFinal->recogerEvaluacionFinalAlumnoPorCurso($idLlegada, $codigoGrupo);
          
        echo json_encode($datos);
       
    break;
        //
   case "mostrarObjetivosAlumno":

    $idLlegada = isset($_GET['idLlegada']) ? $_GET['idLlegada'] : null;

    if (!empty($idLlegada)) {
        $rutas = $evaluacionFinal->obtenerRutasUsuario($idLlegada);

        // Guardar rutas para depuración
        file_put_contents('aa.json', json_encode($rutas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $objetivosTotales = [];

        foreach ($rutas as $ruta) {
        $objetoRuta = $evaluacionFinal->obtenerObjetivosUsuario(
            $ruta['idiomaId_ruta'],
            $ruta['tipoId_ruta'],
            $ruta['nivelId_ruta'],
            $ruta['descrIdioma'],
            $ruta['descrNivel']
        );

        // Crear el campo adicional 'tituloGeneral'
        $tituloGeneral = trim($ruta['descrIdioma'] . ' - ' . $ruta['codIdioma'] . ' ' . $ruta['descrTipo']);

        // Inyectar en el objeto antes de agregarlo al array
        $objetoRuta['tituloGeneral'] = $tituloGeneral;

        $objetivosTotales[] = $objetoRuta;
    }


        // Guardar objetivos para depuración una vez finalizado el foreach
        file_put_contents('aab.json', json_encode($objetivosTotales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo json_encode([
            "sEcho" => 1,
            "iTotalRecords" => count($objetivosTotales),
            "iTotalDisplayRecords" => count($objetivosTotales),
            "aaData" => $objetivosTotales
        ], JSON_UNESCAPED_UNICODE);

    } else {
        echo json_encode([
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        ], JSON_UNESCAPED_UNICODE);
    }

break;

case "mostrarObjetivosPorGrupo":
    $idLlegada = isset($_GET['idLlegada']) ? intval($_GET['idLlegada']) : null;
    $codigoGrupo = isset($_GET['codigoGrupo']) ? $_GET['codigoGrupo'] : null;

    if ($idLlegada && $codigoGrupo) {
        $rutas = $evaluacionFinal->obtenerRutasUsuarioPorGrupo($idLlegada, $codigoGrupo);

        file_put_contents('aa_grupo.json', json_encode($rutas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $objetivosTotales = [];

        foreach ($rutas as $ruta) {
            $objetoRuta = $evaluacionFinal->obtenerObjetivosUsuario(
                $ruta['idiomaId_ruta'],
                $ruta['tipoId_ruta'],
                $ruta['nivelId_ruta'],
                $ruta['descrIdioma'],
                $ruta['descrNivel']
            );

            $tituloGeneral = trim($ruta['descrIdioma'] . ' - ' . $ruta['codIdioma'] . ' ' . $ruta['descrTipo']);

            $objetoRuta['tituloGeneral'] = $tituloGeneral;

            $objetivosTotales[] = $objetoRuta;
        }

        file_put_contents('aab_grupo.json', json_encode($objetivosTotales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo json_encode([
            "sEcho" => 1,
            "iTotalRecords" => count($objetivosTotales),
            "iTotalDisplayRecords" => count($objetivosTotales),
            "aaData" => $objetivosTotales
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        ], JSON_UNESCAPED_UNICODE);
    }
    break;

    case "obtenerDetallesCursoAlumno":
        $idLlegada = $_GET['idLlegada'] ?? null;
        $codigoGrupo = $_GET['codigoGrupo'] ?? null;

        if (!$idLlegada || !$codigoGrupo) {
            echo json_encode(['error' => 'Faltan parámetros idLlegada o codigoGrupo']);
            break;
        }

         // Codificamos el resultado para guardarlo
        $json_string = json_encode("id llegada:", $idLlegada, ", codigoGrupo:", $codigoGrupo);
        $file = 'listarCursosAlumnoParametros.json';
        file_put_contents($file, $json_string);

        $datos = $evaluacionFinal->obtenerDetallesCursoAlumno($idLlegada, $codigoGrupo);

        if (!$datos || count($datos) === 0) {
            echo json_encode(['error' => 'No se encontraron datos']);
            break;
        }

        // Usamos el primer registro para armar el nombre (asumiendo que todos son del mismo alumno)
        $nombreAlumno = trim($datos[0]['nomAlumno'] . ' ' . $datos[0]['apeAlumno']);
        $fechaCertificado = date('d \d\e F \d\e Y');

        $detallesCurso = [];

        foreach ($datos as $curso) {
            $detallesCurso[] = [
                'fechaInicio' => date('d \d\e F', strtotime($curso['fechaInicio'])),
                'fechaFin' => date('d \d\e F \d\e Y', strtotime($curso['fechaFin'])),
                'tipoCurso' => $curso['tipoCurso'],
                'codigoGrupo' => $curso['codigoGrupo'],
                'fechaCertificado' => $fechaCertificado
            ];
        }

        $response = [
            'nombreAlumno' => $nombreAlumno,
            'detallesCurso' => $detallesCurso
        ];

        echo json_encode($response);
        break;


        case "insertarEvaluacion":

        $horasRealizadas = $_POST['horasRealizadas']; 
        $mostrarCertificado = $_POST['mostrarCertificado']; 
        $resultadoEvaluacion = $_POST['resultadoEvaluacion']; 
        $idLlegada = $_POST['idLlegada']; 
        $tokenUsu = $_POST['tokenUsu'];
        $codigoGrupo = isset($_POST['codigoGrupo']) ? $_POST['codigoGrupo'] : null;
        $modo = $_POST['modo']; // 'individual' o 'completo'

        $datosAlumnos = $evaluacionFinal->insertarEvaluacion($horasRealizadas, $mostrarCertificado, $resultadoEvaluacion, $idLlegada, $tokenUsu, $codigoGrupo, $modo);
        
        echo json_encode($datosAlumnos);

        break;

        case "editarEvaluacion":
            
        $idCertificado = $_POST['idCertificado'];
        $horasRealizadas = $_POST['horasRealizadas'];
        $mostrarCertificado = $_POST['mostrarCertificado'];
        $resultadoEvaluacion = $_POST['resultadoEvaluacion'];
        $idLlegada = $_POST['idLlegada'];
        $tokenUsu = $_POST['tokenUsu'];
        $codigoGrupo = isset($_POST['codigoGrupo']) ? $_POST['codigoGrupo'] : null;
        $modo = isset($_POST['modo']) ? $_POST['modo'] : 'completo';

        $datosAlumnos = $evaluacionFinal->editarEvaluacion($idCertificado, $horasRealizadas, $mostrarCertificado, $resultadoEvaluacion, $idLlegada, $tokenUsu, $codigoGrupo, $modo);

        echo json_encode($datosAlumnos);
        break;

        

}

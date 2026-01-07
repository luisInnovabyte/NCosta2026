<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
  
require_once("../models/Horario.php");

$horario = new Horario();

switch ($_GET["op"]) {
    case "listarhorario":
        $idGrupo = $_GET["idCurso"];
        $datos = $horario->listarhorario($idGrupo); // ← Aquí solo lo devuelve
        break;
    case "listarhorarioProfesores":
       
    $datos = $horario->listarhorarioProfesores(); // ← Aquí solo lo devuelve
    break;
    
   
    case "listarhorarioAlumno":
        $idGrupo = $_GET["idCurso"];
        $datos = $horario->listarhorarioAlumno($idGrupo); // ← Aquí solo lo devuelve
        break;
        
    case "listarProfesores":
        $idGrupo = $_POST["codSeleccionado"];
    
        $datos = $horario->listarProfesores($idGrupo); // ← Aquí solo lo devuelve

    break;
    case "listarAulas":
        $horario->listarAulas(); // ya hace echo adentro
    break;
    case "insertarHorarios":
        $codClase         = $_POST['codClase'];
        $fecIni           = $_POST['fecIni'];
        $horaIni          = $_POST['horaIni'];
        $selectProfesores = $_POST['selectProfesores'];
        $selectAulas      = $_POST['selectAulas'];
        $descripcion      = $_POST['descripcion'];
        $horaFin          = $_POST['horaFin'];
        $dias          = $_POST['dias'];
        $publicadoHorario = $_POST['publicadoHorario'];

        $horario->insertarHorarios($codClase,$fecIni,$horaIni,$selectProfesores,$selectAulas,$descripcion,$horaFin,$dias,$publicadoHorario);
    break;    
    case "editarHorarios":
        $codClase         = $_POST['codClase'];
        $fecIni           = $_POST['fecIni'];
        $horaIni          = $_POST['horaIni'];
        $selectProfesores = $_POST['selectProfesores'];
        $selectAulas      = $_POST['selectAulas'];
        $descripcion      = $_POST['descripcion'];
        $horaFin          = $_POST['horaFin'];
        $idHorarioActual  = $_POST['idHorarioActual'];

        $horario->editarHorarios($idHorarioActual,$codClase,$fecIni,$horaIni,$selectProfesores,$selectAulas,$descripcion,$horaFin);
    break;    

    // MÉTODO PARA MARCAR A TODOS LOS ALUMNOS COMO ASISTIDOS
  case 'marcarTodosPresentes':
    try {
        session_start();
        $codigoCurso    = $_POST['codigoCurso'];
        $idHorario      = $_POST['idHorario'];
        $horaClase      = $_POST['horaClase'];       
        $horasAsistidas = $_POST['horasAsistidas'];  
        $idProfesor     = $_SESSION['usuPre_idInscripcion'];

        $resultado = $horario->marcarTodosPresentes($codigoCurso, $idHorario, $idProfesor, $horaClase, $horasAsistidas);

        if ($resultado) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } catch (Exception $e) {
        $errorData = [
            'status' => 'exception',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'fecha' => date('Y-m-d H:i:s')
        ];

        file_put_contents('error_marcarTodosPresentes.json', json_encode($errorData, JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'error', 'message' => 'Se ha producido un error interno.']);
    }
    break;

    
     case "eliminarEvento":
            $idHorario         = $_POST['idHorario'];
            $horario->eliminarEvento($idHorario);
    break;  
      
    case "visibilidadHorario":

        $inicioSemana   = $_POST['inicioSemana'];
        $finSemana   = $_POST['finSemana'];
        $rutaSeleccionada   = $_POST['rutaSeleccionada'];
        $estado   = $_POST['estado'];

        $horario->visibilidadHorario($rutaSeleccionada,$inicioSemana,$finSemana,$estado);
    break;  
    case "cargarEstadoSwitch":

         $inicioSemana   = $_POST['inicioSemana'];
        $finSemana   = $_POST['finSemana'];
        $rutaSeleccionada   = $_POST['rutaSeleccionada'];
        $json_string = json_encode('asd');
        $file = 'ASFGGH.json';
        file_put_contents($file, $json_string);
        $horario->cargarEstadoSwitch($rutaSeleccionada,$inicioSemana,$finSemana);
    break;  
      case "cargarEstadoSwitch":

         $inicioSemana   = $_POST['inicioSemana'];
        $finSemana   = $_POST['finSemana'];
        $rutaSeleccionada   = $_POST['rutaSeleccionada'];
        $json_string = json_encode('asd');
        $file = 'ASFGGH.json';
        file_put_contents($file, $json_string);
        $horario->cargarEstadoSwitch($rutaSeleccionada,$inicioSemana,$finSemana);
    break;  
    case "recogerAlumnosGrupo":

            $idCursoSeleccionado   = $_GET['idCursoSeleccionado'];
            
            $datos = $horario->recogerAlumnosGrupo($idCursoSeleccionado);

            $data = array();

            foreach ($datos as $row) {
                $sub_array = array();


                $sub_array[] = $row["idCurso"];
                $sub_array[] = '<span class="badge bg-info-subtle text-info border border-info">'. $row["nomAlumno"] .' '.  $row["apeAlumno"] .'</span>';
                $sub_array[] = $row["emailUsuario"];

                $detallesAlumno = [];

                // 🖥️ Online
                if (!empty($row['interesadoOnlinePre']) && $row['interesadoOnlinePre'] == 1) {
                    $detallesAlumno[] = "🖥️";
                }

                // 🧒 Menor de edad
                if (!empty($row['fecNacAlumno'])) {
                    $fechaNacimiento = new DateTime($row['fecNacAlumno']);
                    $hoy = new DateTime();
                    $edad = $hoy->diff($fechaNacimiento)->y;

                    if ($edad < 18) {
                        $detallesAlumno[] = "🧒 " . $fechaNacimiento->format('d-m-Y');
                    }
                }

                // 🧠 Agora
                if (!empty($row['agoraAlumno']) && $row['agoraAlumno'] == 1) {
                    $detallesAlumno[] = "🧠";
                }

                // ♿ Minusvalía
                if (!empty($row['minusvaliaAlumno']) && $row['minusvaliaAlumno'] == 1) {
                    $detallesAlumno[] = "♿";
                }

                // 📝 Observaciones de minusvalía
                if (!empty($row['obsMinusvaliaAlumno'])) {
                    $detallesAlumno[] = trim($row['obsMinusvaliaAlumno']);
                }

                // 🔧 Resultado final
                $infoAlumno = implode(" | ", $detallesAlumno);
                $sub_array[] = $infoAlumno;
                $sub_array[] = '<span class="badge text-bg-success border px-1 py-0 me-1 mb-1" style="font-size: 0.8rem; line-height: 1;">'. $row["preferenciaPrincipal"].'</span>';

                $sub_array[] = $row["grupoAmigos"];
                $preferenciasGrupoEtiquetas = '';
                $preferencias = explode(', ', $row["preferenciasGrupo"]);

                foreach ($preferencias as $preferencia) {
                    $preferenciasGrupoEtiquetas .= '<span class="badge text-bg-success border px-1 py-0 me-1 mb-1" style="font-size: 0.8rem; line-height: 1;">'. htmlspecialchars($preferencia) .'</span>';
                }

                $sub_array[] = $preferenciasGrupoEtiquetas;

                
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
    case "comprobarListaAlumno":

        $idAlumno   = $_POST['alumno'];
        $idHorario   = $_POST['horario'];

        $horario->comprobarListaAlumno($idAlumno,$idHorario);
    break;  
    

    // PASAR LISTA
    
     case "insertarLista":
       
    // Recoger datos del formulario
        $idAlumno = isset($_POST["idAlumno"]) ? $_POST["idAlumno"] : null;
        $idCurso = isset($_POST["idCurso"]) ? $_POST["idCurso"] : null;
        $idHorario = isset($_POST["idHorario"]) ? $_POST["idHorario"] : null;
        $asistencia = isset($_POST["asistenciaIn"]) ? $_POST["asistenciaIn"] : null;
        $hora_llegada = isset($_POST["horas_llegada"]) ? $_POST["horas_llegada"] : null;
        $horas_asistencia = isset($_POST["horas_asistencia"]) ? $_POST["horas_asistencia"] : null;
        $motivo = isset($_POST["motivo"]) ? $_POST["motivo"] : null;
        $tareas_realizadas = isset($_POST["tareas_realizadas"]) ? $_POST["tareas_realizadas"] : null;
        $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : null;
        $tareaAlumno = isset($_POST["tareaAlumno"]) ? $_POST["tareaAlumno"] : null;
        $idLlegadaSelect = isset($_POST["idLlegadaSelect"]) ? $_POST["idLlegadaSelect"] : null;

             $horario->insertarLista($idAlumno, $idCurso, $idHorario, $asistencia, $hora_llegada, $horas_asistencia, $motivo, $tareas_realizadas, $observaciones, $tareaAlumno,$idLlegadaSelect);
        echo 1;
    break;  
    case "editarLista":
        
    // Recoger datos del formulario
        $idLista = isset($_POST["idLista"]) ? $_POST["idLista"] : null;
        $idAlumno = isset($_POST["idAlumno"]) ? $_POST["idAlumno"] : null;
        $idCurso = isset($_POST["idCurso"]) ? $_POST["idCurso"] : null;
        $idHorario = isset($_POST["idHorario"]) ? $_POST["idHorario"] : null;
        $asistencia = isset($_POST["asistenciaIn"]) ? $_POST["asistenciaIn"] : null;
        $hora_llegada = isset($_POST["horas_llegada"]) ? $_POST["horas_llegada"] : null;
        $horas_asistencia = isset($_POST["horas_asistencia"]) ? $_POST["horas_asistencia"] : null;
        $motivo = isset($_POST["motivo"]) ? $_POST["motivo"] : null;
        $tareas_realizadas = isset($_POST["tareas_realizadas"]) ? $_POST["tareas_realizadas"] : null;
        $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : null;
        $tareaAlumno = isset($_POST["tareaAlumno"]) ? $_POST["tareaAlumno"] : null;
        $idLlegadaSelect = isset($_POST["idLlegadaSelect"]) ? $_POST["idLlegadaSelect"] : null;

        $horario->editarLista($idLista,$idAlumno, $idCurso, $idHorario, $asistencia, $hora_llegada, $horas_asistencia, $motivo, $tareas_realizadas, $observaciones, $tareaAlumno,$idLlegadaSelect);
        
        echo 1;
    break;  
    case "insertarTareaDiaria":
   
    // Recoger datos del formulario
        $idCurso = isset($_POST["idCurso"]) ? $_POST["idCurso"] : null;
        $idHorario = isset($_POST["idHorario"]) ? $_POST["idHorario"] : null;
        $tareaHoy = isset($_POST["tareaHoy"]) ? $_POST["tareaHoy"] : null;
       
        $horario->insertarTareaDiaria($idCurso,$idHorario,$tareaHoy);
        
        echo 1;
    break;  
    case "editarTareaDiaria":
   
    // Recoger datos del formulario
        $idTarea = isset($_POST["idTarea"]) ? $_POST["idTarea"] : null;

        $idCurso = isset($_POST["idCurso"]) ? $_POST["idCurso"] : null;
        $idHorario = isset($_POST["idHorario"]) ? $_POST["idHorario"] : null;
        $tareaHoy = isset($_POST["tareaHoy"]) ? $_POST["tareaHoy"] : null;
       
        $horario->editarTareaDiaria($idTarea, $idCurso,$idHorario,$tareaHoy);
        
        echo 1;
    break;  
    
}

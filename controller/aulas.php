<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Aulas.php");

$aulas = new Aulas();


switch ($_GET["op"]) {

    case "listarAulas":
      
      
        $datos = $aulas->listarAulas();
       
        
        $data = array();

    
        foreach ($datos as $row) {
            $sub_array = array();
            $checkboxes = '';
            $sub_array[] = $row["idAula"];
            $sub_array[] = '<p class="tx-break tx-bold">' . strtoupper($row["nombreAula"]) . '</p>';
            $sub_array[] = '<p class="tx-break tx-bold">' . strtoupper($row["localizacionAula"]) . '</p>';
            $sub_array[] = '<p class="">' . $row["capacidadAula"] . ' Alumnos</p>';
            if ($row["hibridoAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-danger"> Híbrido </label>';
            }
            
            if ($row["kidsAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-success"> Kids </label>';
            }
            
            if ($row["paraliticosAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-warning"> Paralíticos </label>';
            }
            
            if ($row["agoraAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-info"> Agorafobia </label>';
            }
            $sub_array[] = $checkboxes; // Se almacena todo en una sola columna


            $sub_array[] = '<p class="">' . $row["observacionesAula"] . '</p>';

            if ($row["estAula"] == 1) {
                $sub_array[] = "<span class='tx-success tx-bold''><b>Activa</b></span>";
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Aula" onClick="cargarDatosEditar('.$row["idAula"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Aula" onClick="desactivarAula('.$row["idAula"].')"><i class="fa-solid fa-chalkboard-user"></i></button>';
            } else {
                $sub_array[] = "<span class='tx-warning tx-bold''><b>Inactiva</b></span>";
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Aula" onClick="cargarDatosEditar('.$row["idAula"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-success waves-effect" title="Activar Aula" onClick="activarAula('.$row["idAula"].')"><i class="fa-solid fa-chalkboard-user"></i></button>';
            }
          
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
        case "insertarAula":
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }

        // Llamada al método para guardar los datos
        $aulas->insertarAula($descrAula,$localizacionAula,$capaAula,$textAula,$hibrido,$kids,$paraliticos,$agorafobia);

        break;
        case "obtenerAulaId":

        $datosAula = $aulas->get_aula_x_id($_POST["idAula"]);

        echo json_encode($datosAula);

        break;


        case "editarAula":

            $idAulaE = $_POST["idAulaE"];
            $descrAulaE = ucfirst($_POST["descrAulaE"]);
            $localizacionE = ucfirst($_POST["localizacionE"]);
            $capaAulaE = $_POST["capaAulaE"];
            $textAulaE = $_POST["textAulaE"];
            $hibridoE = $_POST["hibridoE"];
            $kidsE = $_POST["kidsE"];
            $paraliticosE = $_POST["paraliticosE"];
            $agorafobiaE = $_POST["agorafobiaE"];


            // VALIDACION VAN A IR AQUI
            $aulas->editarAula($idAulaE,$descrAulaE,$localizacionE,$capaAulaE,$textAulaE,$hibridoE,$kidsE,$paraliticosE,$agorafobiaE);
        break;

        case "activarAula":

            $aulas->activarAula($_POST["idAula"]);
    
           
            break;
    
        case "desactivarAula":
    
            $aulas->desactivarAula($_POST["idAula"]);
    
          
            break;
/*     case "insertarAula":

        $descrAula = ucfirst($_POST['descrAula']);
        $idiomaAula = ucfirst($_POST['selectIdioma']);
        $telfAula = $_POST['telfAula'];
        $emailAula = $_POST['emailAula'];
        $capaAula = $_POST['capaAula'];
        $dirAula = ucfirst($_POST['dirAula']);
        $provAula = ucfirst($_POST['provAula']);
        $poblaAula = ucfirst($_POST['poblaAula']);
        $cpAula = $_POST['cpAula'];
        $paisAula = ucfirst($_POST['paisAula']);
        $textAula = $_POST['textAula'];

        $aulas->insertarAula($descrAula, $dirAula, $poblaAula, $cpAula, $provAula, $paisAula, $telfAula, $emailAula, $capaAula, $textAula, $idiomaAula);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "aulas.php", "Inserta un nuevo aula " . $_POST['descrAula']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "activarAula":

        $aulas->activarAula($_POST["idAula"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "aulas.php", "Se activiva el aula " . $_POST['idAula']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "desactivarAula":

        $aulas->desactivarAula($_POST["idAula"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "aulas.php", "Se desactiviva el aula " . $_POST['idAula']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

        //EDITAR
    case "obtenerAulaId":

        $datosAula = $aulas->get_aula_x_id($_POST["idAula"]);

        echo json_encode($datosAula);

        break;
    case "editarAula":

        $idAula = $_POST["idAulaE"];
        $descrAula = ucfirst($_POST["descrAulaE"]);
        $idiomaAula = ucfirst($_POST["selectIdiomaE"]);
        $telfAula = $_POST["telfAulaE"];
        $emailAula = $_POST["emailAulaE"];
        $capaAula = $_POST["capaAulaE"];
        $dirAula = ucfirst($_POST["dirAulaE"]);
        $provAula = ucfirst($_POST["provAulaE"]);
        $poblaAula = ucfirst($_POST["poblaAulaE"]);
        $cpAula = $_POST["cpAulaE"];
        $paisAula = ucfirst($_POST["paisAulaE"]);
        $textAula = $_POST["textAulaE"];

        // VALIDACION VAN A IR AQUI
        $aulas->editarAula($idAula, $descrAula, $dirAula, $poblaAula, $cpAula, $provAula, $paisAula, $telfAula, $emailAula, $capaAula, $textAula, $idiomaAula);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "aulas.php", "Se edita el aula " . $_POST['idAulaE']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break; */
}

<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Niveles_Edu.php");

session_start();
require_once("../models/Log.php");

$niveles = new Niveles();


switch ($_GET["op"]) {

    case "listarNiveles":
       
        $datos = $niveles->listarNiveles();


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "niveles.php", "Lista los niveles");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();

        foreach ($datos as $row) {
            $sub_array = [];

            $sub_array[] = '<p>' . $row["idNivel"] . '</p>';
            $sub_array[] = '<p>' . $row["descrNivel"] . '</p>';
            $sub_array[] = '<span class="badge badge-warning">' . $row["codNivel"] . '</span>';
            $sub_array[] = '<p>' . $row["textNivel"] . '</p>';
        
            if ($row["estNivel"] == 1) {
                $sub_array[] = '<span class="badge badge-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="badge badge-secondary">Desactivado</span>';
            }
        
            // Botones de acción mejorados
            $botones = '<button type="button" onClick="cargarElemento(' . $row['idNivel'] . ')" class="btn btn-primary" title="Editar"><i class="fa fa-edit"></i></button>';
            
            if ($row["estNivel"] == 1) {
                $botones .= ' <button type="button" onClick="cambiarEstado(' . $row["idNivel"] . ');" class="btn btn-danger" title="Desactivar"><i class="fa-solid fa-xmark"></i></button>';
            } else {
                $botones .= ' <button type="button" onClick="cambiarEstado(' . $row["idNivel"] . ');" class="btn btn-success" title="Activar"><i class="fa-solid fa-check"></i></button>';
            }
        
            $sub_array[] = $botones;
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

    case "insertarNivel":
        $descrNivel = ucfirst($_POST["descrNivel"]);
        $codNivel = $_POST["codNivel"];
      
        $textNivel = $_POST["textNivel"];
        // VALIDACION VAN A IR AQUI
     
        $datos = $niveles->insertarNivel($descrNivel, $codNivel, $textNivel);



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "niveles.php", "Se inserta un nuevo nivel");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        echo $datos;
        break;

    case "recogerEditar":
        $sub_array = array();
        $datos = $niveles->get_nivel_x_id($_POST["idNivel"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {

                $sub_array[] = $row["idNivel"];
                $sub_array[] = $row["descrNivel"];
                $sub_array[] = $row["codNivel"];
                $sub_array[] = $row["textNivel"];
            }

            echo json_encode($sub_array);
        }
        break;

    case "editarNivel":

        $idNivel = $_POST["idNivel"];
        $descrNivel = ucfirst($_POST["descrNivel"]);
        $codNivel = $_POST["codNivel"];
        $textNivel = $_POST["textNivel"];
        // VALIDACION VAN A IR AQUI
        $datos = $niveles->editarNivel($idNivel, $descrNivel, $codNivel, $textNivel);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "niveles.php", "Se edita el nivel " . $_POST["idNivel"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        echo $datos;
        break;

    case "activarNivel":

        $niveles->activarNivel($_POST["idNivel"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "niveles.php", "Se activa el nivel " . $_POST["idNivel"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "desactivarNivel":

        $niveles->desactivarNivel($_POST["idNivel"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "niveles.php", "Se desactiva el nivel " . $_POST["idNivel"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $niveles->cambiarEstado($idElemento);
            break;
}

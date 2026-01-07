<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/TiposAloja_Edu.php");
session_start();
require_once("../models/Log.php");

$tiposAloja = new TiposAloja();


switch ($_GET["op"]) {

    case "listarTiposAloja":

        $datos = $tiposAloja->listarTiposAloja();



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposAloja_Edu.php", "Lista los tipos de alojamiento ");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["idTiposAloja"] . '</p>';
            $sub_array[] = '<p class="">' . $row["descrTiposAloja"] . '</p>';
            $sub_array[] = '<p class="">' . $row["textTiposAloja"] . '</p>';
            if ($row["estTiposAloja"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-14-force tx-bold">Activo</p>';
            } elseif ($row["estTiposAloja"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-14-force tx-bold">Desactivado</p>';
            }
            // BOTONES DE ACCIONES
            if ($row["estTiposAloja"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idTiposAloja'] . ')"  id="' . $row["idTiposAloja"] . '" class="btn btn-primary btn-icon" data-target="#editar-tipoAloja-modal" data-toggle="modal" data-placement="top" title="Editar Tipo Alojamiento"><div><i class="fa fa-edit"></i></div></button> 
                
                <button type="button" onClick="cambiarEstado(' . $row["idTiposAloja"] . ');"  id="' . $row["idTiposAloja"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Tipo Alojamiento"><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idTiposAloja'] . ')"  id="' . $row["idTiposAloja"] . '" class="btn btn-primary btn-icon" data-target="#editar-tipoAloja-modal" data-toggle="modal" data-placement="top" title="Editar Tipo Alojamiento"><div><i class="fa fa-edit"></i></div></button>


                <button type="button" onClick="cambiarEstado(' . $row["idTiposAloja"] . ');"  id="' . $row["idTiposAloja"] . '" class="btn btn-success btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Tipo Alojamiento"><div><i class="fa-solid fa-check"></i></div></button>';
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

        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $tiposAloja->cambiarEstado($idElemento);
            break;
    case "insertarTiposAloja":

        $descrTiposAloja = ucfirst($_POST["descrTiposAloja"]);
        $textTiposAloja = $_POST["textTiposAloja"];
        // VALIDACION VAN A IR AQUI
        $tiposAloja->insertarTiposAloja($descrTiposAloja, $textTiposAloja);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposAloja_Edu.php", "Se edita un nuevo tipo de alojamiento ");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "recogerEditar":
        $sub_array = array();
        $datos = $tiposAloja->get_tiposAloja_x_id($_POST["idTiposAloja"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {

                $sub_array[] = $row["idTiposAloja"];
                $sub_array[] = $row["descrTiposAloja"];
                $sub_array[] = $row["textTiposAloja"];
            }
            echo json_encode($sub_array);
        }
        break;

    case "editarTiposAloja":

        $idTiposAloja = $_POST["idTiposAlojaE"];
        $descrTiposAloja = ucfirst($_POST["descrTiposAlojaE"]);
        $textTiposAloja = $_POST["textTiposAlojaE"];
        // VALIDACION VAN A IR AQUI
        $tiposAloja->editarTiposAloja($idTiposAloja, $descrTiposAloja, $textTiposAloja);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposAloja_Edu.php", "Se edita el tipo de alojamiento " .  $_POST["idTiposAlojaE"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        break;

    case "activarTipoAloja":

        $tiposAloja->activarTipoAloja($_POST["idTiposAloja"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposAloja_Edu.php", "Se activa el tipo de alojamiento " .  $_POST["idTiposAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "desactivarTipoAloja":

        $tiposAloja->desactivarTipoAloja($_POST["idTiposAloja"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposAloja_Edu.php", "Se desactiva el tipo de alojamiento " .  $_POST["idTiposAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "listarTipoAlojaSelect":
        $datosTiposAloja = $tiposAloja->listarTiposAloja();
        echo json_encode($datosTiposAloja);

        break;
}

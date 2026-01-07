<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/MedidasAloja_Edu.php");
session_start();
require_once("../models/Log.php");

$medidasAloja = new MedidasAloja();


switch ($_GET["op"]) {

    case "listarMedidasAloja":

        $datos = $medidasAloja->listarMedidasAloja();


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medidasAloja.php", "Lista las medidas de alojamiento");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["idMedidaAloja"] . '</p>';
            $sub_array[] = '<p class="">' . $row["descrMedidaAloja"] . '</p>';
            $sub_array[] = '<p class="">' . $row["textMedidaAloja"] . '</p>';
            if ($row["estMedidaAloja"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-14-force tx-bold">Activo</p>';
            } elseif ($row["estMedidaAloja"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-14-force tx-bold">Desactivado</p>';
            }
            // BOTONES DE ACCIONES
            if ($row["estMedidaAloja"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idMedidaAloja'] . ')"  id="' . $row["idMedidaAloja"] . '" class="btn btn-primary btn-icon" data-target="#editar-medidaAloja-modal" data-toggle="modal" data-placement="top" title="Editar Medida Alojamiento"><div><i class="fa fa-edit"></i></div></button> 
                
                <button type="button" onClick="cambiarEstado(' . $row["idMedidaAloja"] . ');"  id="' . $row["idMedidaAloja"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Medida"><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idMedidaAloja'] . ')"  id="' . $row["idMedidaAloja"] . '" class="btn btn-primary btn-icon" data-target="#editar-medidaAloja-modal" data-toggle="modal" data-placement="top" title="Editar Medida Alojamiento"><div><i class="fa fa-edit"></i></div></button>


                <button type="button" onClick="cambiarEstado(' . $row["idMedidaAloja"] . ');"  id="' . $row["idMedidaAloja"] . '" class="btn btn-success btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Medida"><div><i class="fa-solid fa-check"></i></div></button>';
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

    case "listarMedidasTiposAlojaSelect":

        $datosMedidas = $medidasAloja->listarMedidasAloja();
        echo json_encode($datosMedidas);

        break;

    case "insertarMedidaAloja":
        $descrMedidaAloja = ucfirst($_POST["descrMedidaAloja"]);
        $textMedidaAloja = $_POST["textMedidaAloja"];
        // VALIDACION VAN A IR AQUI
        $medidasAloja->insertarMedidaAloja($descrMedidaAloja, $textMedidaAloja);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medidasAloja.php", "Se inserta una nueva medida de alojamiento");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "recogerEditar":
        $sub_array = array();
        $datos = $medidasAloja->get_medidaAloja_x_id($_POST["idMedidaAloja"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {

                $sub_array[] = $row["idMedidaAloja"];
                $sub_array[] = $row["descrMedidaAloja"];
                $sub_array[] = $row["textMedidaAloja"];
            }
            echo json_encode($sub_array);
        }
        break;

    case "editarMedidaAloja":

        $idMedidaAloja = $_POST["idMedidaAloja"];
        $descrMedidaAloja = ucfirst($_POST["descrMedidaAloja"]);
        $textMedidaAloja = $_POST["textMedidaAloja"];
        // VALIDACION VAN A IR AQUI
        $medidasAloja->editarMedidaAloja($idMedidaAloja, $descrMedidaAloja, $textMedidaAloja);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medidasAloja.php", "Se edita la medida de alojamiento " . $_POST["idMedidaAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "activarMedidaAloja":

        $medidasAloja->activarMedidaAloja($_POST["idMedidaAloja"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medidasAloja.php", "Se activa la medida de alojamiento " . $_POST["idMedidaAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "desactivarMedidaAloja":

        $medidasAloja->desactivarMedidaAloja($_POST["idMedidaAloja"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medidasAloja.php", "Se desactiva la medida de alojamiento " . $_POST["idMedidaAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $medidasAloja->cambiarEstado($idElemento);
            break;
}

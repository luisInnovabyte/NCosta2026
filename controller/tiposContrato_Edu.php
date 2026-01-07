<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/TipoContrato_Edu.php");
session_start();
require_once("../models/Log.php");

$curso = new TipoContrato();


switch ($_GET["op"]) {
    case "listarTipoContrato":

        $datos = $curso->listarTipoContrato();


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposContrato_Edu.php", "Lista los tipos de contrato");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idTipoContrato"];
            $sub_array[] = $row["descrTipoContrato"];
            $sub_array[] = $row["textTipoContrato"];


            if ($row["estTipoContrato"] == 1) {
                $sub_array[] = "<span class='tx-success tx-bold''>Activo</span>";
            } elseif ($row["estTipoContrato"] == 0) {
                $sub_array[] = "<span class='tx-warning tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
                // boton editar
                '<button type="button" title="Editar Tipo Contrato" data-target="#editar-tipoContrato-modal" role="button" class="btn btn-primary btn-icon" data-toggle="modal" onClick="cargarElemento(' . $row["idTipoContrato"] . ');"  id="' . $row["idTipoContrato"] . ')"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estTipoContrato"] == 1 ? '<button type="button" title="Desactivar" name="idTipoContrato" onClick="cambiarEstado(' . $row["idTipoContrato"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idTipoContrato" onClick="cambiarEstado(' . $row["idTipoContrato"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check "></i></div>');

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

    case "insertarTipoContrato":
        $descrTipoCurso = ucfirst($_POST["descrTipoContrato"]);
        $textTipo = $_POST["textTipoContrato"];
        $curso->insertarTipoContrato($descrTipoCurso, $textTipo);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposContrato_Edu.php", "Se inserta un nuevo tipo de contrato");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "editarTipoContrato":
        $idTipo = $_POST["id-TipoContrato"];
        $textTipo = $_POST["text-TipoContrato"];
        $descrTipoContrato = ucfirst($_POST["descripcion-TipoContrato"]);
        $datosTipo = $curso->update_tipoContrato($idTipo, $textTipo, $descrTipoContrato);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposContrato_Edu.php", "Se edita el tipo de contrato " .  $_POST["id-TipoContrato"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "activarTipoContrato":
        $curso->activarTipoContrato($_POST["idTipoContrato"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposContrato_Edu.php", "Se activa el tipo de contrato " .  $_POST["idTipoContrato"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "desactivarTipoContrato":
        $curso->desactivarTipoContrato($_POST["idTipoContrato"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tiposContrato_Edu.php", "Se desactiva el tipo de contrato " .  $_POST["idTipoContrato"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "obtenerTipoContratoPorId":

        $idTipoCurso = $_POST['idTipoContrato'];
        $datosTipo = $curso->get_tipoContrato_x_id($idTipoCurso);

        echo json_encode($datosTipo);
        break;

    case "recogerTiposContrato":

        $datosTipo = $curso->listarTipoContrato();

        echo json_encode($datosTipo);


        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $curso->cambiarEstado($idElemento);
            break;
}
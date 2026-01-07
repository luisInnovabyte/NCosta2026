<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/TitContenido_Edu.php");

session_start();
require_once("../models/Log.php");

$titCont = new TitularContenido();


switch ($_GET["op"]) {
    case "listarContenido":
        $datos = $titCont->listarContenido();

        

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "contenido.php", "Lista los contenidos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idTitContenido"];
            $sub_array[] = $row["descrTitContenido"];
            $sub_array[] = $row["obsTitContenido"];


            if ($row["estTitContenido"] == 1) {
                $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
            } elseif ($row["estTitContenido"] == 0) {
                $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
                // boton editar
                '<button type="button"  data-bs-toggle="modal" data-bs-target="#editar-objetivos-modal" title="Editar contenido" role="button" class="btn btn-primary btn-icon" onClick="editarContenido(' . $row["idTitContenido"] . ','.$row["descrTitContenido"].');" id="' . $row["idTitContenido"] . ')"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estTitContenido"] == 1 ? '<button type="button" title="Desactivar" name="idContenido" onClick="cambiarEstado(' . $row["idTitContenido"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idContenido" onClick="cambiarEstado(' . $row["idTitContenido"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');

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
        case "recogerTitular":
            $titCont->agregarTitContenido($_POST["titular"]);
        break;
        case "insertar":
            $titCont->agregarTitContenido($_POST["titular"]);
        break;
        case "editar":
            $titCont->editarTitContenido($_POST["titularID"],$_POST["titular"]);
        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $titCont->cambiarEstado($idElemento);
            break;

    
}

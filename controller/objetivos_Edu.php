<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Objetivos_Edu.php");

session_start();
require_once("../models/Log.php");

$objetivo = new Objetivo();


switch ($_GET["op"]) {
    case "listarObjetivo":
        
        $idTitular = $_GET['idTit'];
        $datos = $objetivo->listarObjetivo($idTitular);



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "objetivos.php", "Lista los objetivos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idObjetivo"];
        
            $sub_array[] = "<p class='badge bg-orange tx-14-force'>".$row["descrTitObjetivo"]."</p>";
            $sub_array[] = "<p class='badge bg-orange tx-14-force'>".$row["descrObjetivo"]."</p>";


            if ($row["estObjetivo"] == 1) {
                $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
            } elseif ($row["estObjetivo"] == 0) {
                $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
                // boton editar
                
                '<button type="button" title="Editar Objetivo" role="button" class="btn btn-primary btn-icon" onClick="editarObjetivo(' . $row["idObjetivo"] . ',\''.$row["descrObjetivo"].'\');"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estObjetivo"] == 1 ? '<button type="button" title="Desactivar" name="idOBjetivo" onClick="cambiarEstado(' . $row["idObjetivo"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idObjetivo" onClick="cambiarEstado(' . $row["idObjetivo"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');

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
        case "insertar":
            $objetivo->agregarObjetivo($_POST["titular"],$_POST["contenido"]);
        break;
        case "editar":
            $objetivo->editarObjetivo($_POST["idCont"],$_POST["contenido"]);
        break;
        case "cambiarEstado":
            
            $objetivo->cambiarEstado($_POST["idElemento"]);
        break;

    
}

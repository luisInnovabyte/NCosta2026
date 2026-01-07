<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Grupos_Edu.php");
session_start();
require_once("../models/Log.php");
$grupos = new Grupos();


switch ($_GET["op"]) {

    case "listarGrupos":

        $datos = $grupos->listarGrupos();
        
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "grupos.php", "Lista los grupos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p>' . $row["idGrupo"] . '</p>';
            $sub_array[] = '<p class="tx-bold">' . $row["nomGrupo"] . '</p>';
            $sub_array[] = '<p class="">' . $row["direcGrupo"] . '</p>';
            $sub_array[] = '<p class="">' . $row["telGrupo"] . '</p>';
            $sub_array[] = '<p class="">' . $row["cifGrupo"] . '</p>';
           
            if ($row["estGrupo"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-14-force tx-bold">Activo</p>';
            } elseif ($row["estGrupos"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-14-force tx-bold">Desactivado</p>';
            }
            // BOTONES DE ACCIONES
            if ($row["estGrupo"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idGrupo'] . ')"  id="' . $row["idGrupo"] . '" class="btn btn-primary btn-icon" data-target="#editar-grupo-modal" data-toggle="modal" data-placement="top" title="Editar Grupo"><div><i class="fa fa-edit"></i></div></button> 
                
                <button type="button" onClick="cambiarEstado(' . $row["idGrupo"] . ');"  id="' . $row["idGrupo"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Grupo"><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else {
                $sub_array[] = ' 
                <button type="button" onClick="cargarElemento(' . $row['idGrupo'] . ')"  id="' . $row["idGrupo"] . '" class="btn btn-primary btn-icon" data-target="#editar-grupo-modal" data-toggle="modal" data-placement="top" title="Editar Grupo"><div><i class="fa fa-edit"></i></div></button>


                <button type="button" onClick="cambiarEstado(' . $row["idGrupo"] . ');"  id="' . $row["idGrupo"] . '" class="btn btn-success btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Grupo"><div><i class="fa-solid fa-check"></i></div></button>';
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
        case "recogerGruposBuscador":
            $query = $_POST["search"];
            $datos = $grupos->recogerGruposBuscador($query);
            
            echo json_encode($datos);
    
    
            break;
            case "recogerGruposAmigosBuscador":
                $query = $_POST["search"];
                $datos = $grupos->recogerGruposAmigosBuscador($query);
                
                echo json_encode($datos);
        
        
                break;
    case "insertarGrupo":
        $nomGrupo = ucfirst($_POST["nomGrupo"]);
        $cifGrupo = strtoupper($_POST["cifGrupo"]);
        $direcGrupo = ucfirst($_POST["direcGrupo"]);
        $telGrupo = $_POST["telGrupo"];

        $grupos->insertarGrupo($nomGrupo, $cifGrupo, $direcGrupo, $telGrupo);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "grupos.php", "Se inserta un nuevo grupo");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "recogerEditar":
        $sub_array = array();
        $datos = $grupos->get_grupo_x_id($_POST["idGrupo"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {

                $sub_array[] = $row["idGrupo"];
                $sub_array[] = $row["nomGrupo"];
                $sub_array[] = $row["direcGrupo"];
                $sub_array[] = $row["telGrupo"];
                $sub_array[] = $row["cifGrupo"];

            }

            echo json_encode($sub_array);
        }
        break;

    case "editarGrupo":

        $idGrupo = $_POST["idGrupos"];
        $nomGrupo = ucfirst($_POST["nomGrupoE"]);
        $cifGrupo = strtoupper($_POST["cifGrupoE"]);
        $direcGrupo = ucfirst($_POST["direcGrupoE"]);
        $telGrupo = $_POST["telGrupoE"];

        $grupos->editarGrupo($idGrupo, $nomGrupo, $cifGrupo, $direcGrupo, $telGrupo);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "grupos.php", "Se edita el grupo " . $_POST['idGrupos']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "activarGrupo":

        $grupos->activarGrupo($_POST["idGrupo"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "grupos.php", "Se activa el grupo " . $_POST['idGrupo']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "desactivarGrupo":

        $grupos->desactivarGrupo($_POST["idGrupo"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "grupos.php", "Se desactiva el grupo " . $_POST['idGrupo']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $grupos->cambiarEstado($idElemento);
            break;

 
}

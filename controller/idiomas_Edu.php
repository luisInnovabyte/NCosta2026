<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Idiomas_Edu.php");
session_start();
require_once("../models/Log.php");
$idiomas = new Idiomas();


switch ($_GET["op"]) {

    case "listarIdiomas":

        $datos = $idiomas->listarIdiomas();
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "idiomas.php", "Lista los idiomas");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["idIdioma"] . '</p>';
            $sub_array[] = '<p class="">' . $row["descrIdioma"] . '</p>';
            $sub_array[] = '<p class="badge bg-info tx-14-force">' . $row["codIdioma"] . '</p>';
            $sub_array[] = '<p class="">' . $row["textIdioma"] . '</p>';
            if ($row["estIdioma"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-14-force tx-bold">Activo</p>';
            } elseif ($row["estIdioma"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-14-force tx-bold">Desactivado</p>';
            }
            // BOTONES DE ACCIONES
            if ($row["estIdioma"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idIdioma'] . ')"  id="' . $row["idIdioma"] . '" class="btn btn-primary btn-icon" data-target="#editar-idioma-modal" data-toggle="modal" data-placement="top" title="Editar Idioma"><div><i class="fa fa-edit"></i></div></button> 
                
                <button type="button" onClick="cambiarEstado(' . $row["idIdioma"] . ');"  id="' . $row["idIdioma"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Idioma"><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idIdioma'] . ')"  id="' . $row["idIdioma"] . '" class="btn btn-primary btn-icon" data-target="#editar-idioma-modal" data-toggle="modal" data-placement="top" title="Editar Idioma"><div><i class="fa fa-edit"></i></div></button>


                <button type="button" onClick="cambiarEstado(' . $row["idIdioma"] . ');"  id="' . $row["idIdioma"] . '" class="btn btn-success btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Idioma"><div><i class="fa-solid fa-check"></i></div></button>';
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

    case "insertarIdioma":
        $descrIdioma = ucfirst($_POST["descrIdioma"]);
        $codIdioma = strtoupper($_POST["codIdioma"]);
        $textIdioma = $_POST["textIdioma"];
        // VALIDACION VAN A IR AQUI
        $idiomas->insertarIdioma($descrIdioma, $codIdioma, $textIdioma);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "idiomas.php", "Se inserta un nuevo idioma ");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "recogerEditar":
        $sub_array = array();
        $datos = $idiomas->get_idioma_x_id($_POST["idIdioma"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {

                $sub_array[] = $row["idIdioma"];
                $sub_array[] = $row["descrIdioma"];
                $sub_array[] = $row["codIdioma"];
                $sub_array[] = $row["textIdioma"];
            }

            echo json_encode($sub_array);
        }
        break;

    case "editarIdioma":

        $idIdioma = $_POST["idIdioma"];
        $descrIdioma = ucfirst($_POST["descrIdioma"]);
        
        $codIdioma = strtoupper($_POST["codIdioma"]);
        $textIdioma = $_POST["observaciones-idioma"];
        // VALIDACION VAN A IR AQUI
        $idiomas->editarIdioma($idIdioma, $descrIdioma, $codIdioma, $textIdioma);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "idiomas.php", "Se edita el idioma " . $_POST['idIdioma']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "activarIdioma":

        $idiomas->activarIdioma($_POST["idIdioma"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "idiomas.php", "Se activa el idioma " . $_POST['idIdioma']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "desactivarIdioma":

        $idiomas->desactivarIdioma($_POST["idIdioma"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "idiomas.php", "Se desactiva el idioma " . $_POST['idIdioma']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "listarIdiomasSelect":
        $datosIdiomas = $idiomas->listarIdiomas();
        echo json_encode($datosIdiomas);

        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $idiomas->cambiarEstado($idElemento);
            break;
}

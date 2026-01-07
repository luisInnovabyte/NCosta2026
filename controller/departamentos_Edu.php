<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Departamentos_Edu.php");

session_start();
require_once("../models/Log.php");

$departamento = new Departamentos();


switch ($_GET["op"]) {
    case "listarDepartamentos":
        $datos = $departamento->listarDepartamentos();



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Lista los tipos de curso");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idDepartamento"];
            $sub_array[] = $row["nombreDepartamento"];

            if ($row["estDepartamento"] == 1) {
                $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
            } elseif ($row["estTipoCurso"] == 0) {
                $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
                // boton editar
                '<button type="button" title="Editar Curso" data-target="#editar-tipoCurso-modal" role="button" class="btn btn-primary btn-icon" data-toggle="modal" onClick="cargarElemento(' . $row["idDepartamento"] . ');"  id="' . $row["idTipo"] . ')"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estDepartamento"] == 1 ? '<button type="button" title="Desactivar" name="idTipo" onClick="cambiarEstado(' . $row["idDepartamento"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idTipo" onClick="cambiarEstado(' . $row["idDepartamento"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');

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

    case "cargarElemento":
        $idElemento = $_POST["idElemento"];
        $dato = $departamento->cargarElemento($idElemento);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Se inserta un nuevo tipo de curso");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        echo json_encode($dato);
        break;

        case "insertarDepartamento":
            $nomDepartamento = $_POST["nomDepartamento"];
            $dato = $departamento->insertarDepartamento($nomDepartamento);
    
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Se inserta un nuevo tipo de curso");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
    
            echo $dato;
            break;
    case "cargarDepaActivo":
       
        $dato = $departamento->cargarDepaActivo();



        echo json_encode($dato);
        break;

        case "insertarDepartamento":
            $nomDepartamento = $_POST["nomDepartamento"];
            $dato = $departamento->insertarDepartamento($nomDepartamento);
    
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Se inserta un nuevo tipo de curso");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
    
            echo $dato;
            break;
    case "editarDepartamento":
        $idDepartamentos = $_POST["idDepartamentos"];
        $nomDepartamentoE = $_POST["nomDepartamentoE"];
        $datos = $departamento->updateDepartamento($idDepartamentos, $nomDepartamentoE);

        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $departamento->cambiarEstado($idElemento);
            break;
}

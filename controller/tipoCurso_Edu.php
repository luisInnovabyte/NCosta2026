<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/TipoCurso_Edu.php");

session_start();
require_once("../models/Log.php");

$curso = new TipoCurso();


switch ($_GET["op"]) {
    case "listarTipoCurso":
        $datos = $curso->listarTipoCurso();



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Lista los tipos de curso");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idTipo"];
            $sub_array[] = $row["descrTipo"];
            $sub_array[] = "<label class='badge bg-orange tx-14-force'>".$row["codTipo"]."</label>";

            $sub_array[] = $row["textTipo"];


            if ($row["estTipoCurso"] == 1) {
                $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
            } elseif ($row["estTipoCurso"] == 0) {
                $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
                // boton editar
                '<button type="button" title="Editar Curso" data-target="#editar-tipoCurso-modal" role="button" class="btn btn-primary btn-icon" data-toggle="modal" onClick="cargarElemento(' . $row["idTipo"] . ');"  id="' . $row["idTipo"] . ')"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estTipoCurso"] == 1 ? '<button type="button" title="Desactivar" name="idTipo" onClick="cambiarEstado(' . $row["idTipo"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idTipo" onClick="cambiarEstado(' . $row["idTipo"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');

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
        case "listarTipoCursoPreinscripciones":
         
            $datos = $curso->listarTipoCurso();
    
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Lista los tipos de curso");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
    
            $data = array();
    
    
            foreach ($datos as $row) {
                $sub_array = array();
    
                $sub_array[] = $row["idTipo"];
                $sub_array[] = $row["descrTipo"];
                
                if ($row["estTipoCurso"] == 1) {
                    $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
                } elseif ($row["estTipoCurso"] == 0) {
                    $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
                }
    
                $sub_array[] =
                // boton editar
                '<button type="button" title="Editar Curso" data-target="#editar-tipoCurso-modal" role="button" class="btn btn-primary btn-icon" data-toggle="modal" onClick="cargarElementoCurso(' . $row["idTipo"] . ');"  id="' . $row["idTipo"] . ')"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estTipoCurso"] == 1 ? '<button type="button" title="Desactivar" name="idTipo" onClick="cambiarEstadoCurso(' . $row["idTipo"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idTipo" onClick="cambiarEstado(' . $row["idTipo"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');

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
    
    case "insertarTipoCurso":
        $descrTipoCurso = ucfirst($_POST["descrTipo"]);
        $codTipo = strtoupper($_POST["codTipo"]);
        $textTipo = $_POST["textTipo"];
        $minAlumnTipo = '0';
        $maxAlumTipo = '0';
        $dato = $curso->insertarTipoCurso($descrTipoCurso, $codTipo, $textTipo, $minAlumnTipo, $maxAlumTipo);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Se inserta un nuevo tipo de curso");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        echo $dato;
        break;

    case "editarTipoCurso":
        
        $idTipo = $_POST["id-tipocursoE"];
        $descrTipoCurso = ucfirst($_POST["descripcion-TipoE"]);
        $codTipo = strtoupper($_POST["codigo-TipoE"]);
        $observaciones = ucfirst($_POST["text-TipoE"]);

        
       /*  $minAlumnTipo = $_POST["minAlumTipoE"];
        $maxAlumTipo = $_POST["maxAlumTipoE"]; */
        $dato = $curso->update_tipoCurso($idTipo, $descrTipoCurso , $codTipo,$observaciones);
       
    

        echo $dato;
        break;
    case "activarTipoCurso":
        $curso->activarTipoCurso($_POST["idTipo"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Se activa el tipo de curso " .  $_POST["idTipo"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        break;

    case "desactivarTipoCurso":
        $curso->desactivarTipoCurso($_POST["idTipo"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tipoCurso_Edu.php", "Se desactiva el tipo de curso " .  $_POST["idTipo"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "obtenerTipoCursoPorId":

        $idTipoCurso = $_POST['idTipoCurso'];
        $datosTipo = $curso->get_tipocurso_x_id($idTipoCurso);

        echo json_encode($datosTipo);
        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $curso->cambiarEstado($idElemento);
            break;
}

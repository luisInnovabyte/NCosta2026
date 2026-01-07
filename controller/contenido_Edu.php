<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Contenido_Edu.php");

session_start();
require_once("../models/Log.php");

$curso = new Contenido();


switch ($_GET["op"]) {
    case "listarContenido":
        $datos = $curso->listarContenido();



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "contenido.php", "Lista los contenidos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idContenido"];
            $sub_array[] = $row["idtitContenido_titContenido"];
            $sub_array[] = $row["idNivelContenido_nivel"];
            $sub_array[] = $row["idTipoContenido_tipoCurso"];
            $sub_array[] = "<p class='badge bg-orange tx-14-force'>".$row["descrTipo"]."</p>";
            $sub_array[] = $row["descrNivel"];
            $sub_array[] = $row["descrContenido"];
            $sub_array[] = $row["descrTitContenido"];
            $sub_array[] = $row["obsContenido"];
            $sub_array[] = $row["codTipo"];
            $sub_array[] = "<p class='badge bg-warning tx-14-force'>".$row["codNivel"]."</p>";
            $sub_array[] = $row["textNivel"];
            $sub_array[] = "<p class='badge bg-info tx-14-force'>".$row["semanasNivel"]."</p>";


            if ($row["estContenido"] == 1) {
                $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
            } elseif ($row["estContenido"] == 0) {
                $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
                // boton editar
                '<button type="button" title="Editar Objetivo" role="button" class="btn btn-primary btn-icon" onClick="editarObjetivo(' . $row["idObjetivo"] . ','.$row["idtitObjetivo_titObjetivo"].','.$row["idNivelObjetivo_nivel"].',\''.$row["descrObjetivo"].'\',\''.$row["descrTitObjetivo"].'\');"  id="' . $row["idObjetivo"] . ')"><div><i class="fa fa-edit"></i></div></button>  '

                '<button type="button" title="Editar contenido" role="button" class="btn btn-primary btn-icon" onClick="editarContenido(' . $row["idContenido"] . ','.$row["idtitContenido_titContenido"].','.$row["idTipoContenido_tipoCurso"].','.$row["idNivelContenido_nivel"].',\''.$row["descrContenido"].'\',\''.$row["descrTitContenido"].'\');"  id="' . $row["idContenido"] . ')"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estContenido"] == 1 ? '<button type="button" title="Desactivar" name="idContenido" onClick="cambiarEstado(' . $row["idContenido"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idContenido" onClick="cambiarEstado(' . $row["idContenido"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');
                editar-objetivos-modal
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
        $curso->agregarContenido($_POST["titular"],$_POST["curso"],$_POST["nivel"],$_POST["contenido"]);
    break;
    case "editar":
        $curso->editarContenido($_POST["idCont"],$_POST["titular"],$_POST["curso"],$_POST["nivel"],$_POST["contenido"]);
    break;
    case "cambiarEstado":
        $idElemento = $_POST["idElemento"];
        $curso->cambiarEstado($idElemento);
        break;

    
}

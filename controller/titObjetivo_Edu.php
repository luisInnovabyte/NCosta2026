<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/TitObjetivo_Edu.php");

session_start();
require_once("../models/Log.php");

$titObjetivo = new TitularObjetivo();


switch ($_GET["op"]) {
    case "listarObjetivo":

        $idiomaSelect = isset($_GET['idioma']) ? $_GET['idioma'] : '';
        $tipoSelect = isset($_GET['tipo']) ? $_GET['tipo'] : '';
        $nivelSelect = isset($_GET['nivel']) ? $_GET['nivel'] : '';
        $datos = $titObjetivo->listarObjetivo($idiomaSelect, $tipoSelect, $nivelSelect);

        

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "contenido.php", "Lista los contenidos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idTitObjetivo"];
            $sub_array[] = "<p class='badge bg-info tx-14-force'>".$row["descrTitObjetivo"]."</p>";

            if ($row["estTitObjetivo"] == 1) {
                $sub_array[] = '<a href="../MntObjetivos_Edu/?id='.$row["idTitObjetivo"].'" type="button" class="btn btn-info tx-white btn-xl btn-icon" title="Editar contenido">Gestionar Objetivos</a>';
            } elseif ($row["estTitObjetivo"] == 0) {
                $sub_array[] = '<a href="" type="button" class="btn disabled tx-white btn-xl btn-icon" title="Editar contenido">Inactivo</a>';
            }

            if ($row["estTitObjetivo"] == 1) {
                $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
            } elseif ($row["estTitObjetivo"] == 0) {
                $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
                // boton editar
                '<button type="button" title="Editar contenido" role="button" class="btn btn-primary btn-icon" onClick="editarContenido(' . $row["idTitObjetivo"] . ',\''.$row["descrTitObjetivo"].'\');"  id="' . $row["idTitContenido"] . ');"  id="' . $row["idTitObjetivo"] . ')"><div><i class="fa fa-edit"></i></div></button>  '
                // boton activar/desactivar
                . ($row["estTitObjetivo"] == 1 ? '<button type="button" title="Desactivar" name="idContenido" onClick="cambiarEstado(' . $row["idTitObjetivo"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idContenido" onClick="cambiarEstado(' . $row["idTitObjetivo"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');

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
            $titObjetivo->agregarTitObjetivo($_POST["titular"],$_POST["idiomaSelect"],$_POST["tipoSelect"],$_POST["nivelSelect"]);
        break;
        case "editar":
            $titObjetivo->editarTitObjetivo($_POST["titularID"],$_POST["titular"],$_POST["idiomaSelect"],$_POST["tipoSelect"],$_POST["nivelSelect"]);
        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $titObjetivo->cambiarEstado($idElemento);
            break;
        



    
}

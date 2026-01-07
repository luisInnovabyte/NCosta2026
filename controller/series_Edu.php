<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Series_Edu.php");
session_start();
require_once("../models/Log.php");

$serie = new Serie();


switch ($_GET["op"]) {

    case "listarSeries":


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "series.php", "Lista las Series");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        $datos = $serie->listarSeries();

        $data = array();


        foreach ($datos as $row) {

            $sub_array = array();

            // BOTONES DE ACCIONES
            $sub_array[] = '<label class="">' . $row["ID "] . '</label>';
            $sub_array[] = '<label class="">' . $row["Descripcion"] . '</label>';
            $sub_array[] =  '<label class="">' . $row["Nombre"] . '</label>';
            $sub_array[] =  '<label class="">' . $row["numPreforma"] . '</label>';
            $sub_array[] =  '<label class="">' . $row["numFactura"] . '</label>';
            $sub_array[] =  '<label class="">' . $row["numAbono"] . '</label>';
            $sub_array[] = ' <button type="button" onClick=eliminar(' . $row["ID"] . ') class="btn btn-danger btn-icon"title="Eliminar Serie"><div><i class="fa fa-xmark"></i></div></button>';

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
        case "insertarSerie":

            $descrSerie = ucfirst($_POST["descrSerie"]);
            $valorSerie = $_POST["valorSerie"];
            // VALIDACION VAN A IR AQUI
            $serie->insertarIva($descrSerie, $valorSerie);
    
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "series.php", "Se inserta una serie");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
            break;

        case "eliminar":
    
            $serie->eliminar($_POST["idSerie"]);
    
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "series.php", "Se elimina la serie " . $_POST["idSerie"]);
            $logI->grabarLinea();
            unset($logI);
            break;

}

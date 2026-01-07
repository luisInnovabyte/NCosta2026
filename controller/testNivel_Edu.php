<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/TestNivel_Edu.php");

session_start();
require_once("../models/Log.php");

$testNivel = new TestNivel();


switch ($_GET["op"]) {
    case "listarTestNivel":
        $datos = $testNivel->listarTestNivel();



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "testnivel.php", "Lista los test de Nivel");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idTestNivel"];
            $sub_array[] = $row["nombreTest"];
            $sub_array[] = "<label class='badge bg-orange tx-14-force'>".$row["codTipo"]."</label>";
            $sub_array[] = $row["idiomaTest"];
            $sub_array[] = '<a href=../../public/testDeNivel/'.$row['archivoTest_pdf'].' download="test_nivel.pdf">Descargar Test de Nivel</a>';


            if ($row["activo"] == 1) {
                $sub_array[] = "<span class='badge bg-success tx-14-force tx-bold''>Activo</span>";
            } elseif ($row["activo"] == 0) {
                $sub_array[] = "<span class='badge bg-secondary tx-14-force tx-bold''>Desactivado</span>";
            }

            $sub_array[] =
          
                // boton activar/desactivar
                ($row["estTipoCurso"] == 1 ? '<button type="button" title="Desactivar" name="idTipo" onClick="cambiarEstado(' . $row["idTipo"] . ')" class="btn btn-danger mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" title="Activar" name="idTipo" onClick="cambiarEstado(' . $row["idTipo"] . ')" class="btn btn-success mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');

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

}

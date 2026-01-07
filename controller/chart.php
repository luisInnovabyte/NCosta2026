<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Chart.php");


$json_string = json_encode('sad');
$file = 'AA1.json';
file_put_contents($file, $json_string);
$chart = new Chart(); // FALTA ESTO

switch ($_GET["op"]) {

    case "circuloxllamadasxcomercial":
        $datos = $chart->getLlamadasxcomercial();

        header('Content-Type: application/json');
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);

        break;
    case "calendarioxllamadas":
        $json_string = json_encode('das');
        $file = 'AS2.json';
        file_put_contents($file, $json_string);
        $datos = $chart->getLlamadasxdia();

        header('Content-Type: application/json');
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);

        break;
    default:
        // Manejar el caso por defecto si es necesario
        break;
}

<?php

//control de errores, habilitar si hay un error 500 y fijarse en el preview del navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Avisos.php");

//require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
//$mail = new PHPMailer(true);

session_start();

$aviso = new Aviso();

$op = $_GET["op"];

switch ($op) {
    case "mostrarAvisos":
        
        $datos = $aviso->mostrarAvisos();
        $data = array();


        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = substr($row["descripcion_tipo"], 0, 1).str_pad($row["idAviso"], 5, '0', STR_PAD_LEFT);
                $sub_array[] = $row["fecAviso"];
                $sub_array[] = $row["fecCita"];
                $sub_array[] = $row["nombreCliente"] . " - Agregar direccion cliente";
                $sub_array[] = $row["referencia"];
                $sub_array[] = $row["descripcion_tipo"];
                $sub_array[] = '<label  class="rounded p-1 calcularColor" style="background-color:'.$row["color_prioridad"].'">'.$row["descripcion_prioridad"].'</label>';
                $sub_array[] = '<label  class="rounded p-1 calcularColor" style="background-color:'.$row["color_estado"].'">'.$row["descripcion_estado"].'</label>';
                $sub_array[] = '<button class="btn btn-primary waves-effect" title="Consultar Tiempo" onClick="consultarTiempo('.$row["idAviso"].')"><i class="fa-solid fa-clock"></i></button>';

                $sub_array[] = '<button class="btn btn-warning waves-effect" title="Ver Detalles" onClick="verDetalles('.$row["idAviso"].')"><i class="fa-solid fa-clipboard-list"></i></button>';
                $sub_array[] = '<button class="btn btn-danger waves-effect" title="Eliminar Cita" onClick="eliminarCita('.$row["idAviso"].')"><i class="fa-solid fa-xmark"></i></button>';

                
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


    default:
        echo "No se ha encontrado esta opción";
}
?>
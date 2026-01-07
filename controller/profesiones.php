<?php

//control de errores, habilitar si hay un error 500 y fijarse en el preview del navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Profesiones.php");

//require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
//$mail = new PHPMailer(true);

session_start();

$profesion = new Profesion();

$op = $_GET["op"];

switch ($op) {
    case "mostrarElementos":
        
        $datos = $profesion->mostrarElementos();
        $data = array();

        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = $row["idProfesion"];
                $sub_array[] = '<label class="rounded p-1 calcularColor" style="background-color:'.$row["color_profesiones"].'">'.$row["descripcion_profesiones"].'</label>';
                if ($row["estProfesion"] == 1) {
                    $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                    $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idProfesion"].')"><i class="fa-solid fa-edit"></i></button>
                    <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idProfesion"].')"><i class="fa-solid fa-user-slash"></i></button>';
                } else {
                    $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                    $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idProfesion"].')"><i class="fa-solid fa-edit"></i></button>
                    <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idProfesion"].')"><i class="fa-solid fa-user-check"></i></button>';
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
    case "agregarElemento":
        $descripcion = $_POST["descripcion"];
        $color = $_POST["color"];
        $profesion->agregarElemento($descripcion,$color);
        break;
    case "cargarElemento":
        $idElemento = $_POST["idElemento"];
        $datos = $profesion->cargarElemento($idElemento);
        echo json_encode($datos);
        break;
    case "editarElemento":
        $descripcion = $_POST["descripcion"];
        $color = $_POST["color"];
        $idElemento = $_POST["idElemento"];
        $profesion->editarElemento($idElemento,$descripcion,$color);
        break;
    case "cambiarEstado":
        $idElemento = $_POST["idElemento"];
        $profesion->cambiarEstado($idElemento);
        break;
    case "listarProfesiones":
        $datos = $profesion->mostrarElementosActivos();
        echo json_encode($datos);
        break;
    default:
        echo "No se ha encontrado esta opción";
}
?>
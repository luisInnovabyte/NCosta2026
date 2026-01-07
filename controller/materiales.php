<?php

//control de errores, habilitar si hay un error 500 y fijarse en el preview del navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Materiales.php");

//require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
//$mail = new PHPMailer(true);

session_start();

$material = new Material();

$op = $_GET["op"];

switch ($op) {
    case "mostrarMateriales":
        
        $datos = $material->mostrarMateriales();

//***FIN JSON***
        $data = array();

        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = $row["idMaterial"];
                $sub_array[] = strtoupper($row["nombreFamilia"].$row["nombreMaterial"].$row["nombreSubFamilia"]);
                $sub_array[] = $row["nombreMaterial"];
                $sub_array[] = $row["nombreFamilia"];
                $sub_array[] = $row["nombreSubFamilia"];
                
                if($row["estructuraMaterial"] == 0){
                    $sub_array[] = "<label class='badge bg-secondary tx-14-force'>NINGUNA</label>";
                } else if($row["estructuraMaterial"] == 1){
                    $sub_array[] = "<label class='badge bg-danger tx-14-force'>FIFO</label>";
                } else {

                    $sub_array[] = "<label class='badge bg-primary tx-14-force'>LIFO</label>";
                }
                if ($row["estMaterial"] == 1) {
                    $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                } else {
                    $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                }

                if ($row["estMaterial"] == 1) {
                    $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Material' onClick='cargarMaterial(" . $row["idMaterial"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-danger waves-effect mg-l-10' title='Desactivar Material' onClick='cambiarEstado(" . $row["idMaterial"] . ")'><i class='fa fa-xmark'></i></button>";
                } else {
                    $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Material' onClick='cargarMaterial(" . $row["idMaterial"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-success waves-effect mg-l-10' title='Activar Material' onClick='cambiarEstado(" . $row["idMaterial"] . ")'><i class='fa fa-check'></i></button>";
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

    case "insertarMaterial":


        $nombreMaterial = $_POST["nombreMaterial"];
        $estructuraMaterial = $_POST["estructuraMaterial"];


        
        $familia = $_POST["familia"];
        $subfamilia = $_POST["subfamilia"];
        date_default_timezone_set('Europe/Madrid');
        $fechAlta_Material =  date("Y-m-d H:i:s"); //Fecha Actual

        // Validaciones básicas
        if (empty($nombreMaterial)) {
            echo "Error: El nombre es obligatorio";
        } else {

            // Si todas las validaciones pasan, insertar el cliente
            $material->insertarMaterial($nombreMaterial, $fechAlta_Material,$estructuraMaterial,$familia,$subfamilia);
            echo true;
        }
        break;

        case "recogerDatosMaterial":
            $idMaterial = $_POST["idMaterial"];
            $datos = $material->recogerDatosMaterial($idMaterial);
            echo json_encode($datos);
            break;

            case "editarMaterial":

                $idMaterial = $_POST["idMaterial"];
                $nombreMaterial = $_POST["nombreMaterial"];
                $estructuraMaterial = $_POST["estructuraMaterial"];
        
                $familia = $_POST["familia"];
                $subfamilia = $_POST["subfamilia"];

                date_default_timezone_set('Europe/Madrid');
                $fechModi_material =  date("Y-m-d H:i:s"); //Fecha Actual
        
        
                $material->editarMaterial($idMaterial, $nombreMaterial, $fechModi_material,$estructuraMaterial,$familia,$subfamilia);
                break;
    
                case "cambiarEstado":
                    $idMaterial = $_POST["idMaterial"];
                    $datos = $material->cambiarEstado($idMaterial);
            
                    echo json_encode($datos);
            
                    break;

    default:
        echo "No se ha encontrado esta opción";
}
?>
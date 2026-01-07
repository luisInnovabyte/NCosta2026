<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Tarifa.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$tarifa = new Tarifa();

$op = $_GET["op"];

switch ($op) {
    case "mostrarTarifas":

        $datos = $tarifa->mostrarTarifas();


        $data = array();

        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = $row["idTarifa"];
                $sub_array[] = $row["iva_tarifa"];
                $sub_array[] = $row["precioTarifa"];
                $sub_array[] = $row["comentarioTarifa"];


                if ($row["estTarifa"] == 1) {
                    $sub_array[] = '<span class="label label-success">Activo</span>';
                } else {
                    $sub_array[] = '<span class="label label-danger">Inactivo</span>';
                }

                if ($row["estTarifa"] == 1) {
                    $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Tarifa' onClick='cargarTarifa(" . $row["idTarifa"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-danger waves-effect mg-l-10' title='Desactivar Tarifa' onClick='cambiarEstado(" . $row["idTarifa"] . ")'><i class='fa fa-xmark'></i></button>";
                } else {
                    $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Tarifa' onClick='cargarTarifa(" . $row["idTarifa"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-success waves-effect mg-l-10' title='Activar Tarifa' onClick='cambiarEstado(" . $row["idTarifa"] . ")'><i class='fa fa-check'></i></button>";
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

    case "listarIva":
        $datos = $tarifa->listarIva();

        echo json_encode($datos);

        break;



    case "insertarTarifa":


        $comentarioTarifa = $_POST["comentarioTarifa"];
        $precioTarifa = $_POST["precioTarifa"];
        $valorIva = $_POST["valorIva"];

        date_default_timezone_set('Europe/Madrid');
        $fechAlta_tarifa =  date("Y-m-d H:i:s"); //Fecha Actual

        // Validaciones básicas
        if (empty($comentarioTarifa)) {
            echo "Error: El comentario de la tarifa es obligatorio";
        } elseif (empty($precioTarifa)) {
            echo "Error: El precio es obligatorio.";
        } else {

            // Si todas las validaciones pasan, insertar el cliente
            $tarifa->insertarTarifa($comentarioTarifa, $precioTarifa, $fechAlta_tarifa, $valorIva);
            echo true;
        }
        break;

        case "recogerDatosTarifa":
            $idTarifa = $_POST["idTarifa"];
            $datos = $tarifa->recogerDatosTarifa($idTarifa);
            echo json_encode($datos);
            break;

            case "editarTarifa":

                $idTarifa = $_POST["idTarifa"];
                $comentarioTarifa = $_POST["comentarioTarifa"];
                $precioTarifa = $_POST["precioTarifa"];
                $valorIva = $_POST["valorIva"];

        
                date_default_timezone_set('Europe/Madrid');
                $fechModi_tarifa =  date("Y-m-d H:i:s"); //Fecha Actual
        
        
                $tarifa->editarTarifa($idTarifa, $comentarioTarifa, $precioTarifa,$valorIva , $fechModi_tarifa);
                break;
    
                case "cambiarEstado":
                    $idTarifa = $_POST["idTarifa"];
                    $datos = $tarifa->cambiarEstado($idTarifa);
            
                    echo json_encode($datos);
            
                    break;


                    case "desactivarTarifa":
                        $idTarifa = $_POST["idTarifa"];
                        date_default_timezone_set('Europe/Madrid');
                        $fechBaja_tarifa =  date("Y-m-d H:i:s"); //Fecha Actual
                
                        $tarifa->desactivarTarifa($idTarifa, $fechBaja_tarifa);
                
                        break;
                
                    case "activarTarifa":
                        $idTarifa = $_POST["idTarifa"];
                        $tarifa->activarTarifa($idTarifa);
                        break;

                
                    
    default:
        echo "No se ha encontrado esta opción";
}
?>
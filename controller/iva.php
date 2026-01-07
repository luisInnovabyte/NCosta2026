

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Iva.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$iva = new Iva();

$op = $_GET["op"];

switch ($op) {
    case "mostrarIva":
        $datos = $iva->mostrarIva();

        //Archivos Log
        //generarLog('iva.php','Mostrar iva'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $data = array();

        foreach ($datos as $row) {


            $sub_array = array();
            $sub_array[] = $row["idIva"];
            $sub_array[] = $row["valorIva"] . " %";
            $sub_array[] = $row["descrIva"];


            //TODO: diseñar columna de estado del IVA segun este a 0 o a 1

            if ($row["estIva"] == 1) {
                $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
            } else {
                $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
            }

            if ($row["estIva"] == 1) {
                $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar IVA' onClick='cargarIva(" . $row["idIva"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-danger waves-effect mg-l-10' title='Desactivar IVA' onClick='cambiarEstado(" . $row["idIva"] . ")'><i class='fa fa-xmark'></i></button>";
            } else {
                $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar IVA' onClick='cargarIva(" . $row["idIva"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-success waves-effect mg-l-10' title='Activar IVA' onClick='cambiarEstado(" . $row["idIva"] . ")'><i class='fa fa-check'></i></button>";
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

    case "insertarIva":

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $valorIva = $_POST["valorIva"];
        $descrIva = $_POST["descrIva"];


        date_default_timezone_set('Europe/Madrid');
        $fechAlta_iva =  date("Y-m-d H:i:s"); //Fecha Actual

        // Validaciones básicas
        if (empty($valorIva)) {
            echo "Error: El valor es obligatorio";
        } elseif (empty($descrIva)) {
            echo "Error: La descripcion es obligatoria.";
        } else {

            // Si todas las validaciones pasan, insertar el cliente
            $resultado = $iva->insertarIva($valorIva, $descrIva, $fechAlta_iva);
            
            if ($resultado === true) {
                echo true;
            } else {
                echo $resultado; // Muestra el error de la base de datos
            }
        }
        break;

    case "cambiarEstado":
        $idIva = $_POST["idIva"];
        $datos = $iva->cambiarEstado($idIva);

        echo json_encode($datos);

        break;

    case "desactivarIva":
        $idIva = $_POST["idIva"];
        date_default_timezone_set('Europe/Madrid');
        $fechBaja_iva =  date("Y-m-d H:i:s"); //Fecha Actual

        $iva->desactivarIva($idIva, $fechBaja_iva);

        break;

    case "activarIva":
        $idIva = $_POST["idIva"];
        $iva->activarIva($idIva);
        break;

    case "recogerDatosIva":
        $idIva = $_POST["idIva"];
        $datos = $iva->recogerDatosIva($idIva);
        echo json_encode($datos);
        break;

    case "editarIva":

        $idIva = $_POST["idIva"];
        $valorIva = $_POST["valorIva"];
        $descrIva = $_POST["descrIva"];


        date_default_timezone_set('Europe/Madrid');
        $fechModi_iva =  date("Y-m-d H:i:s"); //Fecha Actual



        $iva->editarIva($idIva, $valorIva, $descrIva, $fechModi_iva);
        break;


    default:
        echo "No se ha encontrado esta opción";
}

?>
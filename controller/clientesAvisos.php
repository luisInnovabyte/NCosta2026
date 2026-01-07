

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/ClientesAvisos.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$cliente = new Cliente();

$op = $_GET["op"];

switch ($op) {
    case "mostrarElementos":
        $datos = $cliente->mostrarElementos();

        //Archivos Log
        //generarLog('iva.php','Mostrar iva'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $data = array();

        foreach ($datos as $row) {


            $sub_array = array();
            $sub_array[] = $row["idCliAviso"];
            $sub_array[] = $row["nombreCliente"];
            $sub_array[] = $row["descripcion_tipo_cliente"];

            $sub_array[] = $row["telCliente"];

            $sub_array[] = $row["dirCliente"];

            $sub_array[] = $row["emailCliente"];

            $sub_array[] = $row["faxCliente"];

            $sub_array[] = $row["obsCliente"];
            $sub_array[] = $row["notasCliente"];



            //TODO: diseñar columna de estado del IVA segun este a 0 o a 1

            if ($row["estCliente"] == 1) {
                $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento(' . $row["idCliAviso"] . ')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado(' . $row["idCliAviso"] . ')"><i class="fa-solid fa-user-slash"></i></button>';
            } else {
                $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento(' . $row["idCliAviso"] . ')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado(' . $row["idCliAviso"] . ')"><i class="fa-solid fa-user-check"></i></button>';
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
        $nombreCliente = $_POST["nombreCliente"];
        $tipoCliente = $_POST["tipoCliente"];
        $tefCliente = $_POST["tefCliente"];
        $dirCliente = $_POST["dirCliente"];
        $emailCliente = $_POST["emailCliente"];
        $faxCliente = $_POST["faxCliente"];
        $obsCliente = $_POST["obsCliente"];
        $notasCliente = $_POST["notasCliente"];
        $cliente->agregarElemento($nombreCliente,$tipoCliente,$tefCliente,$dirCliente,$emailCliente,$faxCliente,$obsCliente,$notasCliente);
        break;
    case "cargarElemento":
        $idElemento = $_POST["idElemento"];
        $datos = $cliente->cargarElemento($idElemento);
        echo json_encode($datos);
        break;
    case "editarElemento":
        $nombreCliente = $_POST["nombreCliente"];
        $tipoCliente = $_POST["tipoCliente"];
        $tefCliente = $_POST["tefCliente"];
        $dirCliente = $_POST["dirCliente"];
        $emailCliente = $_POST["emailCliente"];
        $faxCliente = $_POST["faxCliente"];
        $obsCliente = $_POST["obsCliente"];
        $notasCliente = $_POST["notasCliente"];
        $idElemento = $_POST["idElemento"];
        $cliente->editarElemento($idElemento, $nombreCliente,$tipoCliente,$tefCliente,$dirCliente,$emailCliente,$faxCliente,$obsCliente,$notasCliente);
        break;
    case "cambiarEstado":
        $idElemento = $_POST["idElemento"];
        $cliente->cambiarEstado($idElemento);
        break;

    default:
        echo "No se ha encontrado esta opción";
}

?>
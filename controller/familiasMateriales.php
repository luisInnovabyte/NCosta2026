

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/FamiliasMateriales.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$familia = new Familia();

$op = $_GET["op"];

switch ($op) {
    case "mostrarElementos":
        $datos = $familia->mostrarElementos();

        //Archivos Log
        //generarLog('iva.php','Mostrar iva'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $data = array();

        foreach ($datos as $row) {


            $sub_array = array();
            $sub_array[] = $row["idFamilia"];
            $sub_array[] = $row["nombreFamilia"];


            //TODO: diseñar columna de estado del IVA segun este a 0 o a 1

            if ($row["estFamilia"] == 1) {
                $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idFamilia"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idFamilia"].')"><i class="fa-solid fa-user-slash"></i></button>';
            } else {
                $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idFamilia"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idFamilia"].')"><i class="fa-solid fa-user-check"></i></button>';
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
            $familia->agregarElemento($descripcion);
            break;
        case "cargarElemento":
            $idElemento = $_POST["idElemento"];
            $datos = $familia->cargarElemento($idElemento);
            echo json_encode($datos);
            break;
        case "editarElemento":
            $descripcion = $_POST["descripcion"];
            $idElemento = $_POST["idElemento"];
            $familia->editarElemento($idElemento,$descripcion);
            break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $familia->cambiarEstado($idElemento);
            break;
        case "recogerFamilias":

            $datos = $familia->mostrarElementos();
            echo json_encode($datos);
            break;
    default:
        echo "No se ha encontrado esta opción";
}

?>
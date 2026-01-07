

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Almacenes.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$almacen = new Almacen();

$op = $_GET["op"];

switch ($op) {
    case "mostrarElementos":
        $datos = $almacen->mostrarElementos();

        //Archivos Log
        //generarLog('iva.php','Mostrar iva'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $data = array();

        foreach ($datos as $row) {


            $sub_array = array();
            $sub_array[] = $row["idAlmacen"];
            $sub_array[] = $row["nombreAlmacen"];
            $sub_array[] = $row["dirAlmacen"];
            $sub_array[] = $row["tefAlmacen"];
            $sub_array[] = $row["emailAlmacen"];

            if ($row["estAlmacen"] == 1) {
                $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idAlmacen"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idAlmacen"].')"><i class="fa-solid fa-user-slash"></i></button>';
            } else {
                $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idAlmacen"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idAlmacen"].')"><i class="fa-solid fa-user-check"></i></button>';
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
            $nombreAlmacen = $_POST["nombreAlmacen"];
            $dirAlmacen = $_POST["dirAlmacen"];
            $tefAlmacen = $_POST["tefAlmacen"];
            $emailAlmacen = $_POST["emailAlmacen"];
            $almacen->agregarElemento($nombreAlmacen,$dirAlmacen,$tefAlmacen,$emailAlmacen);
            break;
        case "cargarElemento":
            $idElemento = $_POST["idElemento"];
            $datos = $almacen->cargarElemento($idElemento);
            echo json_encode($datos);
            break;
        case "editarElemento":
            $nombreAlmacen = $_POST["nombreAlmacen"];
            $dirAlmacen = $_POST["dirAlmacen"];
            $tefAlmacen = $_POST["tefAlmacen"];
            $emailAlmacen = $_POST["emailAlmacen"];
            $tipoAlmacen = $_POST["tipoAlmacen"];
            $idElemento = $_POST["idElemento"];
            $almacen->editarElemento($idElemento,$nombreAlmacen,$dirAlmacen,$tefAlmacen,$emailAlmacen);
            break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $almacen->cambiarEstado($idElemento);
            break;

    default:
        echo "No se ha encontrado esta opción";
}

?>
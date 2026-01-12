<?php
/**
 * Controlador para Listado de Transfers
 * Gestiona los transfers de llegadas con información del alumno
 */

require_once("../config/conexion.php");
require_once("../models/Listado_transfer.php");

$listado = new Listado_transfer();

// Obtener la operación solicitada
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    
    case "listar":
        $datos = $listado->listarTransfers();
        
        // Formatear la respuesta para DataTables
        echo json_encode(array("data" => $datos));
        break;
    
    default:
        echo json_encode(array("error" => "Operación no válida"));
        break;
}

<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Pagos_Edu.php");
session_start();
require_once("../models/Log.php");
$pago = new Pago();


switch ($_GET["op"]) {

    case "listarPagos":

        $datos = $pago->listarPagos();
       
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medios.php", "Lista los medios de pago");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p>' . $row["idMedioPago"] . '</p>';
            $sub_array[] = '<p class="tx-bold">' . $row["nomMedioPago"] . '</p>';
           
            if ($row["estMedioPago"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-14-force tx-bold">Activo</p>';
            } elseif ($row["estMedioPago"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-14-force tx-bold">Desactivado</p>';
            }
            // BOTONES DE ACCIONES
            if ($row["estMedioPago"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idMedioPago'] . ')"  id="' . $row["idMedioPago"] . '" class="btn btn-primary btn-icon" data-target="#editar-pago-modal" data-toggle="modal" data-placement="top" title="Editar Grupo"><div><i class="fa fa-edit"></i></div></button> 
                
                <button type="button" onClick="cambiarEstado(' . $row["idMedioPago"] . ');"  id="' . $row["idMedioPago"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Grupo"><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else {
                $sub_array[] = ' 
                <button type="button" onClick="cargarElemento(' . $row['idMedioPago'] . ')"  id="' . $row["idMedioPago"] . '" class="btn btn-primary btn-icon" data-target="#editar-pago-modal" data-toggle="modal" data-placement="top" title="Editar Grupo"><div><i class="fa fa-edit"></i></div></button>


                <button type="button" onClick="cambiarEstado(' . $row["idMedioPago"] . ');"  id="' . $row["idMedioPago"] . '" class="btn btn-success btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Grupo"><div><i class="fa-solid fa-check"></i></div></button>';
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
    case 'recogerPago':
    
        $datos = $pago->recogerPagoID($_GET["id"]);
        
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "pagos.php", "Recoger los medios de pago por id");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        echo json_encode($datos);
    break;
    case 'editarPago':
    
    
        $datos = $pago->editarPago($_POST["nomPago"],$_POST["idPago"]);
        
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "pagos.php", "editar pago");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        echo json_encode($datos);
    break;
    case 'insertarPago':
    
    
        $datos = $pago->insertarPago($_POST["nomPago"]);
        
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "pagos.php", "insertar pago");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        echo json_encode($datos);
    break;
    case 'desactivarPago':
        $datos = $pago->desactivarPago($_GET["id"]);
        
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "pagos.php", "Desctivar medio de pago");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        echo json_encode($datos);
    break;
    case 'activarPago':
        $datos = $pago->activarPago($_GET["id"]);
        
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "pagos.php", "Activar medio de pago");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        echo json_encode($datos);
    break;
    case "cambiarEstado":
        $idElemento = $_POST["idElemento"];
        $pago->cambiarEstado($idElemento);
        break;
 
    case 'recogerMediosPago':

        $datos = $pago->recogerMediosPago();
        
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "pagos.php", "Recoger los medios de pago");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        echo json_encode($datos);
    break;
}

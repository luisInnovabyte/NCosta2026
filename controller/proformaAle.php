<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/ProformaAle.php");
session_start();
require_once("../models/Log.php");
$proforma = new ProformaAle();


switch ($_GET["op"]) {



        case "listarProformaEnFacturacion":

        $datos = $proforma->listarProformaFacturacion();
       
        $json_string = json_encode($datos);
        $file = 'facturaProforma.json';
        file_put_contents($file, $json_string);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medios.php", "Lista las facturas en facturación");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idPie"];
            $sub_array[] = $row["serieProformaPie"] . "" . $row["numProformaPie"];
            $sub_array[] = $row["nombreCabecera"];
            $sub_array[] = $row["cifCabecera"];
            $sub_array[] = $row["fechProformaPie"];

            /*
            PROFORMA NO TIENE QUE PODER PAGAR O NO PAGAR
            if (empty($row["facturaPagada"]) || $row["facturaPagada"] == 0) {
                $sub_array[] = "
                    <div class='text-center'>
                        <button class='btn btn-success btn-sm d-inline-flex align-items-center gap-2' onclick='marcarPagadoProforma(" . $row["idPie"] . ")'>
                            <i class='fas fa-check-circle'></i> Marcar Pagado
                        </button>
                    </div>
                ";
            } else if ($row["facturaPagada"] == 1) {
                $sub_array[] = "
                    <div class='text-center'>
                        <button class='btn btn-outline-warning btn-sm d-inline-flex align-items-center gap-2' onclick='marcarPagadoProforma(" . $row["idPie"] . ")'>
                            <i class='fas fa-undo'></i> Desmarcar Pagado
                        </button>
                    </div>
                ";
            }
            */


            $sub_array[] = "<label class='badge bg-secondary tx-14'>Abonar Proforma Futuro</label>";

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

       
        case "listarFacturaEnFacturacion":

        $datos = $proforma->listarFacturaFacturacion();
       
        $json_string = json_encode($datos);
        $file = 'facturaNormal.json';
        file_put_contents($file, $json_string);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medios.php", "Lista las facturas en facturación");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
        $sub_array = array();

        $sub_array[] = $row["idPie"];
        $sub_array[] = $row["serieProformaPie"] . "" . $row["numProformaPie"];
        $sub_array[] = $row["nombreCabecera"];
        $sub_array[] = $row["cifCabecera"];
        $sub_array[] = $row["fechProformaPie"];
        $sub_array[] = $row["numFacturaPro"];

        // Mostrar badge según si la factura está pagada o no
        if ($row["facturaPagada"] == 1) {
            $sub_array[] = "<label class='badge bg-success tx-14'>Sí</label>";
        } elseif ($row["facturaPagada"] == 0) {
            $sub_array[] = "<label class='badge bg-danger tx-14'>No</label>";
        }

        if (empty($row["facturaPagada"]) || $row["facturaPagada"] == 0) {
            // Botón para marcar como pagado
            $sub_array[] = "
                <div class='text-center'>
                    <button class='btn btn-success btn-sm d-inline-flex align-items-center gap-2' onclick='marcarPagado(" . $row["idPie"] . ")'>
                        <i class='fas fa-check-circle'></i> Marcar Pagado
                    </button>
                </div>
            ";
        } else if ($row["facturaPagada"] == 1) {
            // Botón para desmarcar pago (habilitado)
            $sub_array[] = "
                <div class='text-center'>
                    <button class='btn btn-outline-warning btn-sm d-inline-flex align-items-center gap-2' onclick='marcarPagado(" . $row["idPie"] . ")'>
                        <i class='fas fa-undo'></i> Desmarcar Pagado
                    </button>
                </div>
            ";
        }


        $sub_array[] = "<label class='badge bg-secondary tx-14'>Abonar futuro</label>";

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
     
        case "desactivarFactura":

        $proforma->desactivarFacturaModelo($_POST['idPie']);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "proforma.php",  "La factura " . $_POST['idPie'] . "fue desactivada");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "activarFactura":

        $proforma->activarFacturaModelo($_POST['idPie']);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "proforma.php",  "La proforma " . $_POST['idPie'] . "fue activada");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "desactivarFacturaProforma":

        $proforma->desactivarFacturaProformaModelo($_POST['idPie']);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "proforma.php",  "La factura " . $_POST['idPie'] . "fue desactivada");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "activarFacturaProforma":

        $proforma->activarFacturaProformaModelo($_POST['idPie']);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "proforma.php",  "La proforma " . $_POST['idPie'] . "fue activada");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;
}

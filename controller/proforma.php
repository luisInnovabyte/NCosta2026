<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Proforma.php");
session_start();
require_once("../models/Log.php");
$proforma = new Proforma();


switch ($_GET["op"]) {

    case "listarProforma":

        $datos = $proforma->listarProforma();
       
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "medios.php", "Lista los medios de pago");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();
        

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idPie"];
            $sub_array[] = $row["numProformaPie"];
            $sub_array[] = $row["nombreCabecera"];
            $sub_array[] = $row["cifCabecera"];
            $sub_array[] = $row["quienFacturaPie"];
            $sub_array[] = $row["fechProformaPie"];
            if($row["estProforma"] == 0){
                $sub_array[] = "<label class='badge bg-danger tx-14'>En Proforma</label>";

            } else if ($row["estProforma"] == 1){
                $sub_array[] = "<label class='badge bg-success tx-14'>Facturado</label>";

            } else {
                $sub_array[] = "<label class='badge bg-secondary tx-14'>Abonado</label>";
            }
            $sub_array[] = "<a href='../VerProforma/index.php?idProforma=".$row["idPie"]."' title='Ver Proforma' class='btn btn-info waves-effect'><i class='fa-solid fa-eye'></i></a><button title='Facturar' class='facturarBtn btn btn-success waves-effect mg-l-5'><i class='fa-solid fa-file-invoice'></i></button>";
            

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
        case "recogerProforma":
            $idProforma = $_POST["idProforma"];
            $datos = $proforma->recogerProforma($idProforma);
            echo json_encode($datos);
        break;
        case "cargarProductoId":
        $idLlegada = $_GET["idLlegada"];
        $existeProforma = $_GET['existeProforma'];
        
        $datos = $proforma->cargarProductoId($idLlegada);
      
        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idContenidoFactura"];
            $sub_array[] = $row["codigoFacturaContenido"];
            $sub_array[] = $row["conceptoFacturaContenido"];
            $tipoFactura = $row["tipoFacturaContenido"];
            if($tipoFactura == 1){
                $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
           
            }else if($tipoFactura == 4){
                $sub_array[] = "<label class='badge bg-secondary tx-14'>Transfer</label>";
            }else{
                $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
            }
            $importe = floatval($row["importeFacturaContenido"] ?? 0);
            $iva = floatval(($row["ivaFacturaContenido"] === '' || $row["ivaFacturaContenido"] === null) ? 0 : $row["ivaFacturaContenido"]);
            $descuento = floatval(($row["descuentoFacturaContenido"] === '' || $row["descuentoFacturaContenido"] === null) ? 0 : $row["descuentoFacturaContenido"]);

                
            // Paso 1: sumar el IVA
            $importe_con_iva = $importe + ($importe * $iva / 100);

            // Paso 2: aplicar el descuento
            $total = $importe_con_iva - ($importe_con_iva * $descuento / 100);

            // Mostrar los valores
            $sub_array[] = $descuento;
            $sub_array[] = number_format($importe, 2, ',', '.'); // 2.930,50
            $sub_array[] = $iva; // si quieres, también puedes formatearlo
            $sub_array[] = number_format($total, 2, ',', '.');   // 3.410,00
            if ($existeProforma == 1) {
                $sub_array[] = '<button type="button" onClick="cargarElementoTarifa(' .  $row['idContenidoFactura']. ')" id="' . $row["idContenidoFactura"] . '" class="btn btn-primary btn-icon" data-placement="top" title="Editar Tarifa" disabled><div><i class="fa fa-edit"></i></div></button> 
                <button type="button" onClick="eliminarTarifa(' . $row["idContenidoFactura"] . ');"  id="' . $row["idContenidoFactura"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Eliminar Tarifa" disabled><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else if ($existeProforma == 0) {
                $sub_array[] = '<button type="button" onClick="cargarElementoTarifa(' .  $row['idContenidoFactura']. ')" id="' . $row["idContenidoFactura"] . '" class="btn btn-primary btn-icon" data-placement="top" title="Editar Tarifa"><div><i class="fa fa-edit"></i></div></button> 
                <button type="button" onClick="eliminarTarifa(' . $row["idContenidoFactura"] . ');"  id="' . $row["idContenidoFactura"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Eliminar Tarifa"><div><i class="fa-solid fa-xmark"></i></div></button>';
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
    case "insertarFactura":
       
        $idLlegada = $_POST['idLlegada'];
        $codigoFactura = $_POST['codigoFactura'];
        $conceptoFactura = $_POST['conceptoFactura'];
        $tipoFactura = $_POST['tipoFactura'];
        $ivaFactura = $_POST['ivaFactura'];
        $descuentoFactura = $_POST['descuentoFactura'];
        $importeFactura = $_POST['importeFactura'];
        $fecha_inicio = '';
        $fecha_fin = '';
        $proforma->insertarFactura( $idLlegada,$codigoFactura,$conceptoFactura, $tipoFactura, $ivaFactura, $descuentoFactura, $importeFactura,$fecha_inicio,$fecha_fin);
    break;
   case "recogerDatosEditar":
       
        $idElemento = $_POST['idElemento'];
       
        $datos = $proforma->recogerDatosEditar($idElemento);
        echo json_encode($datos);

    break;
      case "editarTarifa":
       
        $idEditando = $_POST['idEditando'];
        $codigoFactura = $_POST['codigoFactura'];
        $conceptoFactura = $_POST['conceptoFactura'];
        $tipoFactura = $_POST['tipoFactura'];
        $ivaFactura = $_POST['ivaFactura'];
        $descuentoFactura = $_POST['descuentoFactura'];
        $importeFactura = $_POST['importeFactura'];
        $proforma->editarTarifa( $idEditando,$codigoFactura,$conceptoFactura, $tipoFactura, $ivaFactura, $descuentoFactura, $importeFactura);
    break;
       case "eliminarTarifa":
       
        $idTarifa = $_POST['idTarifa'];
       
        $proforma->eliminarTarifa($idTarifa);
    break;

    case "cargarProductoIdEnFactura":
        $idFactura = $_GET["idFactura"];
 
        $datos = $proforma->cargarProductoIdFactura($idFactura);
        $json_string = json_encode($datos);
        $file = 'Jiofvfvvs.json';
        file_put_contents($file, $json_string);
        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idContenidoFactura"];
            $sub_array[] = $row["codigoFacturaContenido"];
            $sub_array[] = $row["conceptoFacturaContenido"];
            $tipoFactura = $row["tipoFacturaContenido"];
            if($tipoFactura == 1){
                $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
            }else if($tipoFactura == 2){
                $sub_array[] = "<label class='badge bg-info tx-14'>Alojamiento</label>";
            }else{
                $sub_array[] = "<label class='badge bg-secondary tx-14'>Otros</label>";
            }
            $importe = floatval($row["importeFacturaContenido"] ?? 0);
            $iva = floatval(($row["ivaFacturaContenido"] === '' || $row["ivaFacturaContenido"] === null) ? 0 : $row["ivaFacturaContenido"]);
            $descuento = floatval(($row["descuentoFacturaContenido"] === '' || $row["descuentoFacturaContenido"] === null) ? 0 : $row["descuentoFacturaContenido"]);



                
            // Paso 1: sumar el IVA
            $importe_con_iva = $importe + ($importe * $iva / 100);

            // Paso 2: aplicar el descuento
            $total = $importe_con_iva - ($importe_con_iva * $descuento / 100);

            // Mostrar los valores
            $sub_array[] = $descuento;
            
            $sub_array[] = number_format($importe, 2, ',', '.'); // 2.930,50

            $sub_array[] = $iva;

            $sub_array[] = number_format($total, 2, ',', '.');   // 3.410,00
     
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

    /* ES IGUAL A cargarProductoIdEnFactura, PERO AQUI EL TOTAL SALE CON UN - */
    case "cargarProductoIdEnFacturaNegativo":
    try {
        $idFactura = $_GET["idFactura"];

        $datos = $proforma->cargarProductoIdFactura($idFactura);

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idContenidoFactura"];
            $sub_array[] = $row["codigoFacturaContenido"];
            $sub_array[] = $row["conceptoFacturaContenido"];
            $tipoFactura = $row["tipoFacturaContenido"];
            if ($tipoFactura == 1) {
                $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
            } else if ($tipoFactura == 2) {
                $sub_array[] = "<label class='badge bg-info tx-14'>Alojamiento</label>";
            } else {
                $sub_array[] = "<label class='badge bg-secondary tx-14'>Otros</label>";
            }
            $importe = floatval($row["importeFacturaContenido"] ?? 0);
            $iva = floatval(($row["ivaFacturaContenido"] === '' || $row["ivaFacturaContenido"] === null) ? 0 : $row["ivaFacturaContenido"]);
            $descuento = floatval(($row["descuentoFacturaContenido"] === '' || $row["descuentoFacturaContenido"] === null) ? 0 : $row["descuentoFacturaContenido"]);

            // Paso 1: sumar el IVA
            $importe_con_iva = $importe + ($importe * $iva / 100);

            // Paso 2: aplicar el descuento
            $total = $importe_con_iva - ($importe_con_iva * $descuento / 100);

            $sub_array[] = $descuento;
            $sub_array[] = '- ' . number_format($importe, 2, ',', '.');

            // Mostrar los valores
            $sub_array[] = $iva;

            $sub_array[] = '- ' . number_format($total, 2, ',', '.');

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        // Guardar JSON con resultados
        $json_string = json_encode($results);
        $file = 'Jiofvfvvs.json';
        file_put_contents($file, $json_string);

        echo json_encode($results);

    } catch (Exception $e) {
        // Preparar JSON de error
        $error = [
            "error" => true,
            "message" => $e->getMessage()
        ];

        // Guardar JSON con error
        $json_string = json_encode($error);
        $file = 'Jiofvfvvs_error.json';
        file_put_contents($file, $json_string);

        echo json_encode($error);
    }
break;


   case "cargarProductoIdEnFacturaReal":
        $idFactura = $_GET["idFactura"];
 
        $datos = $proforma->cargarProductoIdFacturaReal($idFactura);
        $json_string = json_encode($datos);
        $file = 'Jiofvfvvs.json';
        file_put_contents($file, $json_string);
        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idContenidoFactura"];
            $sub_array[] = $row["codigoFacturaContenido"];
            $sub_array[] = $row["conceptoFacturaContenido"];
            $tipoFactura = $row["tipoFacturaContenido"];
            if($tipoFactura == 1){
                $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
            }else if($tipoFactura == 2){
                $sub_array[] = "<label class='badge bg-info tx-14'>Alojamiento</label>";
            }else{
                $sub_array[] = "<label class='badge bg-secondary tx-14'>Otros</label>";
            }
            $importe = floatval($row["importeFacturaContenido"] ?? 0);
            $iva = floatval(($row["ivaFacturaContenido"] === '' || $row["ivaFacturaContenido"] === null) ? 0 : $row["ivaFacturaContenido"]);
            $descuento = floatval(($row["descuentoFacturaContenido"] === '' || $row["descuentoFacturaContenido"] === null) ? 0 : $row["descuentoFacturaContenido"]);



                
            // Paso 1: sumar el IVA
            $importe_con_iva = $importe + ($importe * $iva / 100);

            // Paso 2: aplicar el descuento
            $total = $importe_con_iva - ($importe_con_iva * $descuento / 100);

            // Mostrar los valores
            $sub_array[] = $descuento;
            
            $sub_array[] = number_format($importe, 2, ',', '.'); // 2.930,50

            $sub_array[] = $iva;

            $sub_array[] = number_format($total, 2, ',', '.');   // 3.410,00
     

        
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
    
    /* ES IGUAL A cargarProductoIdEnFacturaReal, PERO AQUI EL TOTAL SALE CON UN - */
   case "cargarProductoIdEnFacturaRealNegativo":
        try {
            $idFactura = $_GET["idFactura"];

            $datos = $proforma->cargarProductoIdFacturaReal($idFactura);
            $json_string = json_encode($datos);
            $file = 'Jiofvfvvs.json';
            file_put_contents($file, $json_string);
            $data = array();

            foreach ($datos as $row) {
                $sub_array = array();

                $sub_array[] = $row["idContenidoFactura"];
                $sub_array[] = $row["codigoFacturaContenido"];
                $sub_array[] = $row["conceptoFacturaContenido"];
                $tipoFactura = $row["tipoFacturaContenido"];
                if($tipoFactura == 1){
                    $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
                }else if($tipoFactura == 2){
                    $sub_array[] = "<label class='badge bg-info tx-14'>Alojamiento</label>";
                }else{
                    $sub_array[] = "<label class='badge bg-secondary tx-14'>Otros</label>";
                }
                $importe = floatval($row["importeFacturaContenido"] ?? 0);
                $iva = floatval(($row["ivaFacturaContenido"] === '' || $row["ivaFacturaContenido"] === null) ? 0 : $row["ivaFacturaContenido"]);
                $descuento = floatval(($row["descuentoFacturaContenido"] === '' || $row["descuentoFacturaContenido"] === null) ? 0 : $row["descuentoFacturaContenido"]);

                // Paso 1: sumar el IVA
                $importe_con_iva = $importe + ($importe * $iva / 100);

                // Paso 2: aplicar el descuento
                $total = $importe_con_iva - ($importe_con_iva * $descuento / 100);

                // Mostrar los valores
                $sub_array[] = $descuento;
                
                $sub_array[] = number_format($importe, 2, ',', '.'); // 2.930,50

                $sub_array[] = $iva;

                $sub_array[] = number_format($total, 2, ',', '.');   // 3.410,00
        
                $data[] = $sub_array;
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );

            // Guardar JSON con resultados
            $json_string = json_encode($results);
            $file = 'facturaRealN.json';
            file_put_contents($file, $json_string);

            echo json_encode($results);

        } catch (Exception $e) {
            // Preparar JSON de error
            $error = [
                "error" => true,
                "message" => $e->getMessage()
            ];

            // Guardar JSON con error
            $json_string = json_encode($error);
            $file = 'facturaRealN_error.json';
            file_put_contents($file, $json_string);

            echo json_encode($error);
        }
    break;


    
    case "listarMatriculacionesGrupos":

        $nombreGrupos = trim($_GET['nombreGrupos']);

        $datos = $proforma->listarMatriculacionesGrupos($nombreGrupos);

        $data = array();
     
        foreach ($datos as $row) {         
                $sub_array = array();
                $tipo = $row["tipo"];
                if($tipo == '1'){
                    $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
                }else{
                    $sub_array[] = "<label class='badge bg-info tx-14'>Alojamiento</label>";
                }
                $sub_array[] = strtoupper($row["codTarifa"]);
                $sub_array[] = $row["nombreTarifa"];
                $sub_array[] = $row["observaciones"];
                $sub_array[] = $row["precio"];
                $sub_array[] = $row["iva"];
                $sub_array[] = $row["descuento"];
                $sub_array[] = '<p class="tx-success tx-bold">'.fechaLocal($row["fechaInicio"]).'</p>';
                $sub_array[] = '<p class="tx-danger tx-bold">'.fechaLocal($row["fechaFin"]).'</p>';
                $sub_array[] = $row["tipo"];
                $sub_array[] = $row["nomPrescripcion"].' '.$row["apePrescripcion"];

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
    
    
    case "listarMatriculacionesGrupos":

        $nombreGrupos = trim($_GET['nombreGrupos']);

        $datos = $proforma->listarMatriculacionesGrupos($nombreGrupos);

        $data = array();
     
        foreach ($datos as $row) {         
                $sub_array = array();
                $tipo = $row["tipo"];
                if($tipo == '1'){
                    $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
                }else{
                    $sub_array[] = "<label class='badge bg-info tx-14'>Alojamiento</label>";
                }
                $sub_array[] = strtoupper($row["codTarifa"]);
                $sub_array[] = $row["nombreTarifa"];
                $sub_array[] = $row["observaciones"];
                $sub_array[] = $row["precio"];
                $sub_array[] = $row["iva"];
                $sub_array[] = $row["descuento"];
                $sub_array[] = '<p class="tx-success tx-bold">'.fechaLocal($row["fechaInicio"]).'</p>';
                $sub_array[] = '<p class="tx-danger tx-bold">'.fechaLocal($row["fechaFin"]).'</p>';
                $sub_array[] = $row["tipo"];
                $sub_array[] = $row["nomPrescripcion"].' '.$row["apePrescripcion"];

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
       
    
    case "transferGruposLlegada":

        $nombreGrupos = trim($_GET['nombreGrupos']);

        $datos = $proforma->transferGruposLlegada($nombreGrupos);

        $data = array();
     
        foreach ($datos as $row) {         
                $sub_array = array();
             
                $sub_array[] = strtoupper($row["codigotariotallegadaTransfer_llegadas"]);
                $sub_array[] = $row["textotariotallegadaTransfer_llegadas"];
                $sub_array[] = $row["ivatariotallegadaTransfer_llegadas"];
                $sub_array[] = $row["importetariotallegadaTransfer_llegadas"];
              
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
    
    case "transferGruposRegreso":

        $nombreGrupos = trim($_GET['nombreGrupos']);

        $datos = $proforma->transferGruposRegreso($nombreGrupos);

        $data = array();
     
        foreach ($datos as $row) {         
                $sub_array = array();
             
                $sub_array[] = strtoupper($row["codigotariotalregresoTransfer_llegadas"]);
                $sub_array[] = $row["textotariotalregresoTransfer_llegadas"];
                $sub_array[] = $row["ivatariotalregresoTransfer_llegadas"];
                $sub_array[] = $row["importetariotalregresoTransfer_llegadas"];
              
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
    case "listarMatriculaciones":
        $idLlegada = $_GET['idLlegada'];

        $datos = $proforma->listarMatriculaciones($idLlegada);

        $data = array();
     
        foreach ($datos as $row) {         
                $sub_array = array();
                $tipo = $row["tipo"];
                if($tipo == '1'){
                    $sub_array[] = "<label class='badge bg-success tx-14'>Matriculación</label>";
                }else{
                    $sub_array[] = "<label class='badge bg-info tx-14'>Alojamiento</label>";
                }
                $sub_array[] = strtoupper($row["codTarifa"]);
                $sub_array[] = $row["nombreTarifa"];
                $sub_array[] = $row["observaciones"];
                $sub_array[] = $row["precio"];
                $sub_array[] = $row["iva"];
                $sub_array[] = $row["descuento"];
                $sub_array[] = '<p class="tx-success tx-bold">'.fechaLocal($row["fechaInicio"]).'</p>';
                $sub_array[] = '<p class="tx-danger tx-bold">'.fechaLocal($row["fechaFin"]).'</p>';
                $sub_array[] = $row["tipo"];

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
    
     case "editarTarifa":
       
        $idEditando = $_POST['idEditando'];
        $codigoFactura = $_POST['codigoFactura'];
        $conceptoFactura = $_POST['conceptoFactura'];
        $tipoFactura = $_POST['tipoFactura'];
        $ivaFactura = $_POST['ivaFactura'];
        $descuentoFactura = $_POST['descuentoFactura'];
        $importeFactura = $_POST['importeFactura'];
        $proforma->editarTarifa( $idEditando,$codigoFactura,$conceptoFactura, $tipoFactura, $ivaFactura, $descuentoFactura, $importeFactura);
    break;
    case "editarTarifa":
       
        $idEditando = $_POST['idEditando'];
        $codigoFactura = $_POST['codigoFactura'];
        $conceptoFactura = $_POST['conceptoFactura'];
        $tipoFactura = $_POST['tipoFactura'];
        $ivaFactura = $_POST['ivaFactura'];
        $descuentoFactura = $_POST['descuentoFactura'];
        $importeFactura = $_POST['importeFactura'];
        $proforma->editarTarifa( $idEditando,$codigoFactura,$conceptoFactura, $tipoFactura, $ivaFactura, $descuentoFactura, $importeFactura);
    break;
    case "guardarFacturaPro":
       
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
        $resultado = $proforma->insertarFacturaPro(
        $nombreCabecera, $cifCabecera, $direcCabecera, $movilCabecera,
        $telefonoCabecera, $cpCabecera, $correoCabecera, $paisCabecera,
        $idLlegada, $numProforma, $serieProforma, $fechaProforma,
        $idAgente, $grupoAmigos, $grupoFacturacion, $quienFactura,
        $aQuienFactura, $idDepartamento, $conceptoExtra
    );

    echo json_encode($resultado); 
    
    break;
    case "guardarFacturaReal":
       
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
        $json_string = json_encode($_POST);
        $file = 'T1.json';
        file_put_contents($file, $json_string);
        $resultado = $proforma->insertarFacturaReal(
        $nombreCabecera, $cifCabecera, $direcCabecera, $movilCabecera, $telefonoCabecera, $cpCabecera, $correoCabecera, $paisCabecera,
        $idLlegada, $numFactura, $serieProforma, $fechaProforma, $idAgente, $grupoAmigos, $grupoFacturacion, $quienFactura, $aQuienFactura, $idDepartamento, $numProforma, $conceptoExtra
    );

    echo json_encode($resultado);

    
    break;
    case "listarFacturasXLlegada":
        $idLlegada = $_GET['idLlegada'];
        $existeFacturaReal = $proforma->recogerFacturaRealXIdLlegada($idLlegada);


        $datos = $proforma->recogerFacturasxIdLlegada($idLlegada);
    
        $data = array();
       
        foreach ($datos as $row) {         
            $sub_array = array();
            $sub_array[] = $row["idPie"];
            $sub_array[] = $row["nombreCabecera"];

            $aQuienFactura = $row["aQuienFactura"];
            if($aQuienFactura == '1'){
                $sub_array[] = "<label class='badge bg-success tx-14'>Alumno</label>";
            }else if($aQuienFactura == '2'){
                $sub_array[] = "<label class='badge bg-info tx-14'>Agente</label>";
            }else{
                $sub_array[] = "<label class='badge bg-warning tx-14'>Grupo</label>";
            }

            $facturaAbonada = $row["abonadaFacturaPro"]; 

            $sub_array[] = $row["serieProformaPie"].'-'.$row["numProformaPie"];
            $sub_array[] = fechaLocal($row["fechProformaPie"]);
            
            if (!empty($facturaAbonada)) {
                // Si contiene algo (no es null ni cadena vacía)
                // Haz una cosa
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
            
            } else {
                // Si está vacía o es null
                // Haz otra cosa
                $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaDatatable(' . $row["numProformaPie"] . ', 1, ' . $row["idLlegada_Pie"] . ')"><div><i class="fa-solid fa-file"></i></div></button>';

                $sub_array[] = '<a href="../../view/Factura_Edu/index.php?idLlegada=' . $row["idLlegada_Pie"] . '&idFacturaPro=' . $row["numProformaPie"] . '&tipoFactura=1" type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura"><div><i class="fa-solid fa-file-invoice"></i></div></a>';

                if ($existeFacturaReal == 1) {
                    // Existe factura real, deshabilitar el botón
                    $sub_array[] = '<span title="Abone primero la factura">
                    <button type="button" disabled class="btn btn-danger btn-icon">
                        <div><i class="fa-solid fa-file-excel"></i></div>
                    </button>
                </span>';


                } else {
                    // No existe, botón normal
                    $sub_array[] = '<button type="button" onclick="realizarAbono(\''.$row["idPie"].'\',\''.$row["serieProformaPie"].$row["numProformaPie"].'\')" class="btn btn-danger btn-icon" data-placement="top" title="Abono">
                        <div><i class="fa-solid fa-file-excel"></i></div>
                    </button>';
                }
                // Calcular el total a pagar proforma usando el método del modelo
                $totalAPagar = $proforma->calcularTotalAPagarProforma($row["numProformaPie"], $idLlegada);

                // Calcular el total pagado usando el método del modelo
                $totalPagado = $proforma->calcularTotalPagadoRealPro($idLlegada);

                // Calcular el pago pendiente
                $pagoPendiente = $totalAPagar - $totalPagado;

                // Si el pago pendiente es 0, mostrar "Pagado"
                if ($pagoPendiente == 0) {
                    $pagoPendienteTexto = "Pagado";
                    $btnClass = "btn-success";
                } else {
                    $pagoPendienteTexto = number_format($pagoPendiente, 2, ',', '.') . " €";
                    $btnClass = "btn-warning";
                }

                     // Botón que muestre ambos valores
            /*
                $sub_array[] = "
                <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                    <button type='button' class='btn btn-info btn-sm' style='font-weight:bold;' title='Total pagado y total a pagar'>
                        Pagado: ".number_format($totalPagado, 2, ',', '.')." € / Total: ".number_format($totalAPagar, 2, ',', '.')." €
                    </button>
                </div>
            ";
            */

            // Mostrar botón del pago pendiente centrado
                
                $sub_array[] = "
                    <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                        <button type='button' class='btn $btnClass btn-sm' style='font-weight:bold;'>
                            $pagoPendienteTexto
                        </button>
                    </div>
                ";
                
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


    case "listarFacturasXLlegadaReal":
        $idLlegada = $_GET['idLlegada'];

        $datos = $proforma->recogerFacturasxIdLlegadaReal($idLlegada);

        $data = array();

        // numProformaPie es el número de la factura, IMPORTANTE PARA CALCULAR EL TOTAL AHORA

        foreach ($datos as $row) {         
            $sub_array = array();
            $sub_array[] = $row["idPie"];
            $sub_array[] = $row["nombreCabecera"];

            $aQuienFactura = $row["aQuienFactura"];
            if($aQuienFactura == '1'){
                $sub_array[] = "<label class='badge bg-success tx-14'>Alumno</label>";
            }else if($aQuienFactura == '2'){
                $sub_array[] = "<label class='badge bg-info tx-14'>Agente</label>";
            }else{
                $sub_array[] = "<label class='badge bg-warning tx-14'>Grupo</label>";
            }
            $sub_array[] = $row["serieProformaPie"].'-'.$row["numProformaPie"];
            $sub_array[] = fechaLocal($row["fechProformaPie"]);
            $sub_array[] = $row["numFacturaPro"];

            $facturaAbonada = $row["abonadaFactura"]; 
            if (!empty($facturaAbonada)) {
                // Si contiene algo (no es null ni cadena vacía)
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";

            } else {
                // Si está vacía o es null
                $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaDatatable(' . $row["numProformaPie"] . ', 1, ' . $row["idLlegada_Pie"] . ')"><div><i class="fa-solid fa-file"></i></div></button>';

                $sub_array[] = '<button type="button" onclick="realizarAbono(\''.$row["idPie"].'\',\''.$row["serieProformaPie"].$row["numProformaPie"].'\')"  class="btn btn-danger btn-icon" data-placement="top" title="Abono"><div><i class="fa-solid fa-file-excel"></i></div></button>';

                // Mostrar badge según si la factura está pagada o no
                if ($row["facturaPagada"] == 1) {
                    $sub_array[] = "
                        <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                            <label class='badge bg-success tx-14'>Sí</label>
                        </div>
                    ";
                } elseif ($row["facturaPagada"] == 0) {
                    $sub_array[] = "
                        <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                            <label class='badge bg-danger tx-14'>No</label>
                        </div>
                    ";
                }

            }

            // Calcular el total a pagar usando el método del modelo
                $totalAPagar = $proforma->calcularTotalAPagarReal($row["numProformaPie"], $idLlegada);

                // Calcular el total pagado usando el método del modelo
                $totalPagado = $proforma->calcularTotalPagadoRealPro($idLlegada);

                // Calcular el pago pendiente
                $pagoPendiente = $totalAPagar - $totalPagado;

                // Si el pago pendiente es 0, mostrar "Pagado"
                if ($pagoPendiente == 0) {
                    $pagoPendienteTexto = "Pagado";
                    $btnClass = "btn-success";
                } else {
                    $pagoPendienteTexto = number_format($pagoPendiente, 2, ',', '.') . " €";
                    $btnClass = "btn-warning";
                }

            // Botón que muestre ambos valores
        /*
            $sub_array[] = "
            <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                <button type='button' class='btn btn-info btn-sm' style='font-weight:bold;' title='Total pagado y total a pagar'>
                    Pagado: ".number_format($totalPagado, 2, ',', '.')." € / Total: ".number_format($totalAPagar, 2, ',', '.')." €
                </button>
            </div>
        ";
        */
        
        // Mostrar botón del pago pendiente centrado
        // DESCOMENTAR CUANDO SE QUIERA VER CLARAMENTE QUE ES EL PAGO PENDIENTE
        
            $sub_array[] = "
                <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                    <button type='button' class='btn $btnClass btn-sm' style='font-weight:bold;'>
                        $pagoPendienteTexto
                    </button>
                </div>
            ";


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


    
    /*
    MÉTODO ANTERIOR A INTENTAR HACER APARTADO 6 (PROBABLEMENTE LO NECESITE DE NUEVO COMO ESTABA ANTES)
     case "listarFacturasXLlegadaReal":
        $idLlegada = $_GET['idLlegada'];

        $datos = $proforma->recogerFacturasxIdLlegadaReal($idLlegada);
      
        $data = array();

        // numProformaPie es el número de la factura, IMPORTANTE PARA CALCULAR EL TOTAL AHORA
     
        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = $row["idPie"];
                $sub_array[] = $row["nombreCabecera"];

                $aQuienFactura = $row["aQuienFactura"];
                if($aQuienFactura == '1'){
                    $sub_array[] = "<label class='badge bg-success tx-14'>Alumno</label>";
                }else if($aQuienFactura == '2'){
                    $sub_array[] = "<label class='badge bg-info tx-14'>Agente</label>";
                }else{
                    $sub_array[] = "<label class='badge bg-warning tx-14'>Grupo</label>";
                }
                $sub_array[] = $row["serieProformaPie"].'-'.$row["numProformaPie"];
                $sub_array[] = fechaLocal($row["fechProformaPie"]);
                $sub_array[] = $row["numFacturaPro"];

                $facturaAbonada = $row["abonadaFactura"]; 
                if (!empty($facturaAbonada)) {
                    // Si contiene algo (no es null ni cadena vacía)
                    // Haz una cosa
                    $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                    $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                    $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";
                    $sub_array[] = "<label class='badge bg-danger tx-14'>Abonada</label>";

                } else {
                    // Si está vacía o es null
                    // Haz otra cosa
                        
                    $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaDatatable(' . $row["idLlegada_Pie"] . ', 1, ' . $row["numProformaPie"] . ')"><div><i class="fa-solid fa-file"></i></div></button>';

                    $sub_array[] = '<button type="button" onclick="realizarAbono(\''.$row["idPie"].'\',\''.$row["serieProformaPie"].$row["numProformaPie"].'\')"  class="btn btn-danger btn-icon" data-placement="top" title="Abono"><div><i class="fa-solid fa-file-excel"></i></div></button>';

                    // Mostrar badge según si la factura está pagada o no
                    if ($row["facturaPagada"] == 1) {
                        $sub_array[] = "
                            <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                                <label class='badge bg-success tx-14'>Sí</label>
                            </div>
                        ";
                    } elseif ($row["facturaPagada"] == 0) {
                        $sub_array[] = "
                            <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                                <label class='badge bg-danger tx-14'>No</label>
                            </div>
                        ";
                    }

                    //$sub_array[] = " <div class='text-center'> <button class='btn btn-success btn-sm d-inline-flex align-items-center gap-2' onclick='pagarFactura(" . $row["idPie"] . ")'><i class='fas fa-check-circle'></i> Gestionar Pago</button></div>";
                    $sub_array[] = " <div class='text-center'>Pago pendiente</div>";


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
    */
    case "guardarTarifasTodas":
     
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
        $proforma->insertarFactura($idLlegada, $codigoFactura,$conceptoFactura, $tipoFactura, $ivaFactura, $descuentoFactura, $importeFactura, $fecha_inicio, $fecha_fin);

    break;   
    case "abonarFacturaPro":
        $idPie = $_POST['idPie'];
        $motivoAbono = $_POST['motivo'];
        $idDepartamento = $_POST['idDepartamento'];

        $json_string = json_encode('as');
        $file = 'APATA.json';
        file_put_contents($file, $json_string);


        $proforma->abonarFacturaPro($idPie,$motivoAbono,$idDepartamento);

    break;
    case "abonarFacturaReal":
        $idPie = $_POST['idPie'];
        $motivoAbono = $_POST['motivo'];
        $idDepartamento = $_POST['idDepartamento'];


        $proforma->abonarFacturaReal($idPie,$motivoAbono,$idDepartamento);

    break;
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
             $aQuienFactura = $row["aQuienFactura"];
            if($aQuienFactura == '1'){
                $sub_array[] = "<label class='badge bg-success tx-14'>Alumno</label>";
            }else if($aQuienFactura == '2'){
                $sub_array[] = "<label class='badge bg-info tx-14'>Agente</label>";
            }else{
                $sub_array[] = "<label class='badge bg-warning tx-14'>Grupo</label>";
            }
            $sub_array[] = fechaLocal($row["fechProformaPie"]);

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
            $existeFacturaReal = $proforma->recogerFacturaRealXIdLlegada($row["idLlegada_Pie"]);

            if ($existeFacturaReal == 1) {
                    // Existe factura real, deshabilitar el botón
                    $sub_array[] = '<span title="Abone primero la factura">
                    <button type="button" disabled class="btn btn-danger btn-icon">
                        <div><i class="fa-solid fa-file-excel"></i></div>
                    </button>
                </span>';


            } else {
                // No existe, botón normal
                $sub_array[] = '<button type="button" onclick="realizarAbono(\'' . $row["idPie"] . '\',\'' . $row["serieProformaPie"] . $row["numProformaPie"] . '\', \'' . $row["idLlegada_Pie"] . '\', \'Pro\')" class="btn btn-danger btn-icon" data-placement="top" title="Abono"><div><i class="fa-solid fa-file-excel"></i></div></button>';

            }
            $totalAPagar = $proforma->calcularTotalAPagarProforma($row["numProformaPie"], $row["idLlegada_Pie"]);

            // Calcular total pagado
            $totalPagadoProforma = $proforma->calcularTotalPagadoRealPro($row["idLlegada_Pie"]);

            // Calcular pago pendiente
            $pagoPendiente = $totalAPagar - $totalPagadoProforma;

            if ($pagoPendiente <= 0) {
                $pagoPendienteTexto = "Pagado";
                $btnClass = "btn-success";
            } else {
                $pagoPendienteTexto = number_format($pagoPendiente, 2, ',', '.') . " €";
                $btnClass = "btn-warning";
            }

            // Mostrar pago pendiente como botón centrado
            $sub_array[] = "
                <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                    <button type='button' class='btn $btnClass btn-sm' style='font-weight:bold;'>
                        $pagoPendienteTexto
                    </button>
                </div>
            ";
            $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaDatatablePro(' . $row["numProformaPie"] . ', 1, ' . $row["idLlegada_Pie"] . ')"><div><i class="fa-solid fa-file"></i></div></button>';

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

        case "listarProformaSinFacturaEnFacturacion":

        $datos = $proforma->listarProformaSinFacturaFacturacion();
       
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
            $sub_array[] = fechaLocal($row["fechProformaPie"]);
            $sub_array[] = '<a href="../../view/Factura_Edu/index.php?idLlegada=' . $row["idLlegada_Pie"] . '&idFacturaPro=' . $row["numProformaPie"] . '&tipoFactura=1" type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura"><div><i class="fa-solid fa-file-invoice"></i></div></a>';

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

            $totalAPagar = $proforma->calcularTotalAPagarProforma($row["numProformaPie"], $row["idLlegada_Pie"]);

            // Calcular total pagado
            $totalPagadoProforma = $proforma->calcularTotalPagadoRealPro($row["idLlegada_Pie"]);

            // Calcular pago pendiente
            $pagoPendiente = $totalAPagar - $totalPagadoProforma;

            if ($pagoPendiente <= 0) {
                $pagoPendienteTexto = "Pagado";
                $btnClass = "btn-success";
            } else {
                $pagoPendienteTexto = number_format($pagoPendiente, 2, ',', '.') . " €";
                $btnClass = "btn-warning";
            }

            // Mostrar pago pendiente como botón centrado
            $sub_array[] = "
                <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                    <button type='button' class='btn $btnClass btn-sm' style='font-weight:bold;'>
                        $pagoPendienteTexto
                    </button>
                </div>
            ";

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

        case "listarProformaAbonoEnFacturacion":

        $datos = $proforma->listarProformaAbonoFacturacion();
       
        $json_string = json_encode($datos);
        $file = 'facturaProformaAbono.json';
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
            $sub_array[] = $row["abonadaFacturaPro"];
            $sub_array[] = $row["serieProformaPie"] . "" . $row["numProformaPie"];
            $sub_array[] = $row["nombreCabecera"];
            $sub_array[] = $row["cifCabecera"];
            
            $aQuienFactura = $row["aQuienFactura"];
            if($aQuienFactura == '1'){
                $sub_array[] = "<label class='badge bg-success tx-14'>Alumno</label>";
            }else if($aQuienFactura == '2'){
                $sub_array[] = "<label class='badge bg-info tx-14'>Agente</label>";
            }else{
                $sub_array[] = "<label class='badge bg-warning tx-14'>Grupo</label>";
            }
            $sub_array[] = fechaLocal($row["fechProformaPie"]);
            $sub_array[] = FechaHoraLocal_string($row["abonadaFechaFacturaPro"]);
            $sub_array[] = $row["abonadaMotivoFacturaPro"];

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

            $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaAbonoDatatable(' 
                . $row["numProformaPie"] . ', 1, ' . $row["idLlegada_Pie"] . ', 0)"><div><i class="fa-solid fa-file"></i></div></button>';

            $data[] = $sub_array;
        }

        $json_string = json_encode($data);
        $file = 'facturaProformaAbonoResultado.json';
        file_put_contents($file, $json_string);

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
         $aQuienFactura = $row["aQuienFactura"];
            if($aQuienFactura == '1'){
                $sub_array[] = "<label class='badge bg-success tx-14'>Alumno</label>";
            }else if($aQuienFactura == '2'){
                $sub_array[] = "<label class='badge bg-info tx-14'>Agente</label>";
            }else{
                $sub_array[] = "<label class='badge bg-warning tx-14'>Grupo</label>";
            }
        $sub_array[] = fechaLocal($row["fechProformaPie"]);
        $sub_array[] = $row["numFacturaPro"];

        // Mostrar badge según si la factura está pagada o no
        if ($row["facturaPagada"] == 1) {
        $sub_array[] = "<label class='badge bg-success tx-14' data-pagado='1'>Sí</label>";
        } else {
            $sub_array[] = "<label class='badge bg-danger tx-14' data-pagado='0'>No</label>";
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

        $sub_array[] = '<button type="button" onclick="realizarAbono(\'' . $row["idPie"] . '\',\'' . $row["serieProformaPie"] . $row["numProformaPie"] . '\', \'' . $row["idLlegada_Pie"] . '\', \'Real\')" class="btn btn-danger btn-icon" data-placement="top" title="Abono"><div><i class="fa-solid fa-file-excel"></i></div></button>';

        $totalAPagar = $proforma->calcularTotalAPagarReal($row["numProformaPie"], $row["idLlegada_Pie"]);

        // Calcular total pagado
        $totalPagadoReal = $proforma->calcularTotalPagadoRealPro($row["idLlegada_Pie"]);

        // Calcular pago pendiente
        $pagoPendiente = $totalAPagar - $totalPagadoReal;

        if ($pagoPendiente <= 0) {
            $pagoPendienteTexto = "Pagado";
            $btnClass = "btn-success";
        } else {
            $pagoPendienteTexto = number_format($pagoPendiente, 2, ',', '.') . " €";
            $btnClass = "btn-warning";
        }

        // Mostrar pago pendiente como botón centrado
        $sub_array[] = "
            <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                <button type='button' class='btn $btnClass btn-sm' style='font-weight:bold;'>
                    $pagoPendienteTexto
                </button>
            </div>
        ";
       $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaDatatable(' . $row["numProformaPie"] . ', 1, ' . $row["idLlegada_Pie"] . ')"><div><i class="fa-solid fa-file"></i></div></button>';
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

         case "listarFacturaAbonoEnFacturacion":

        $datos = $proforma->listarFacturaAbonoFacturacion();
       
        $json_string = json_encode($datos);
        $file = 'facturaFacturaAbono.json';
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
            $sub_array[] = $row["abonadaFactura"];
            $sub_array[] = $row["serieProformaPie"] . "" . $row["numProformaPie"];
            $sub_array[] = $row["nombreCabecera"];
            $sub_array[] = $row["cifCabecera"];
            $aQuienFactura = $row["aQuienFactura"];
            if($aQuienFactura == '1'){
                $sub_array[] = "<label class='badge bg-success tx-14'>Alumno</label>";
            }else if($aQuienFactura == '2'){
                $sub_array[] = "<label class='badge bg-info tx-14'>Agente</label>";
            }else{
                $sub_array[] = "<label class='badge bg-warning tx-14'>Grupo</label>";
            }
            $sub_array[] = fechaLocal($row["fechProformaPie"]);
            $sub_array[] = $row["numProformaPie"];
            $sub_array[] = FechaHoraLocal_string($row["abonadaFechaFactura"]);
            $sub_array[] = $row["abonadaMotivoFactura"];

            $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaAbonoDatatable(' 
                . $row["numProformaPie"] . ', 1, ' . $row["idLlegada_Pie"] . ', 1)"><div><i class="fa-solid fa-file"></i></div></button>';
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

            $data[] = $sub_array;
        }

        $json_string = json_encode($data);
        $file = 'facturaAbonoResultado.json';
        file_put_contents($file, $json_string);

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
    case "recogerSuplidosXLlegada":
        $idLlegada = $_GET['idLlegada'];
        $datos = $proforma->recogerSuplidosXLlegada($idLlegada);
        $json_string = json_encode($datos);
        $file = 'AY.json';
        file_put_contents($file, $json_string);
        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idSuplido"];
            $sub_array[] = $row["descripcionSuplido"];
            $sub_array[] = $row["importeSuplido"].'€';

            $data[] = $sub_array;
        }

  
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        $json_string = json_encode($sql);
        $file = 'AQ.json';
        file_put_contents($file, $json_string);
        echo json_encode($results);

        // FIN del archivo LOG
    break;
    
    // OPCIÓN DE PROFORMA USADO EN LA VISTA DE Llegadas, CON EL OBJETIVO DE SABER SI
    // EXISTE ALGUNA FACTURA PROFORMA O REAL DE ESA LLEGADA
    case "comprobarFacturasActivas":
        $idLlegada = $_POST['idLlegada']; // Lo recibes del AJAX
        $datos = $proforma->comprobarFacturasProformaRealesActivasSinAbonar($idLlegada);
        echo json_encode($datos);
    break;

     case "listarFacturaPerfilAlum":
        $idTokenUsu = $_GET["idTokenUsu"];
        $json_string = json_encode($idTokenUsu);
        $file = 'idTokenuus.json';
        file_put_contents($file, $json_string);

        $datos = $proforma->recogerFacturasxIdToken($idTokenUsu);
        $json_string = json_encode($datos);
        $file = 'CALABACIN2.json';
        file_put_contents($file, $json_string);

        $data = array();

         foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idPie"];
            $sub_array[] = $row["serieProformaPie"] . "" . $row["numProformaPie"];
            $sub_array[] = $row["nombreCabecera"];
            $sub_array[] = $row["cifCabecera"];
            $sub_array[] = fechaLocal($row["fechProformaPie"]);
            $sub_array[] = $row["numFacturaPro"];

            // Mostrar badge según si la factura está pagada o no
            if ($row["facturaPagada"] == 1) {
            $sub_array[] = "<label class='badge bg-success tx-14' data-pagado='1'>Sí</label>";
            } else {
                $sub_array[] = "<label class='badge bg-danger tx-14' data-pagado='0'>No</label>";
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

            $sub_array[] = '<button type="button" onclick="realizarAbono(\'' . $row["idPie"] . '\',\'' . $row["serieProformaPie"] . $row["numProformaPie"] . '\', \'' . $row["idLlegada_Pie"] . '\', \'Real\')" class="btn btn-danger btn-icon" data-placement="top" title="Abono"><div><i class="fa-solid fa-file-excel"></i></div></button>';

            $totalAPagar = $proforma->calcularTotalAPagarReal($row["numProformaPie"], $row["idLlegada_Pie"]);

            // Calcular total pagado
            $totalPagadoReal = $proforma->calcularTotalPagadoRealPro($row["idLlegada_Pie"]);

            // Calcular pago pendiente
            $pagoPendiente = $totalAPagar - $totalPagadoReal;

            if ($pagoPendiente <= 0) {
                $pagoPendienteTexto = "Pagado";
                $btnClass = "btn-success";
            } else {
                $pagoPendienteTexto = number_format($pagoPendiente, 2, ',', '.') . " €";
                $btnClass = "btn-warning";
            }

            // Mostrar pago pendiente como botón centrado
            $sub_array[] = "
                <div class='d-flex justify-content-center align-items-center' style='height: 100%; min-height: 40px;'>
                    <button type='button' class='btn $btnClass btn-sm' style='font-weight:bold;'>
                        $pagoPendienteTexto
                    </button>
                </div>
            ";
            $sub_array[] = '<button type="button" class="btn btn-primary btn-icon" data-placement="top" title="Apartado Factura" onclick="imprimirFacturaDatatable(' . $row["numProformaPie"] . ', 1, ' . $row["idLlegada_Pie"] . ')"><div><i class="fa-solid fa-file"></i></div></button>';
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
     
}

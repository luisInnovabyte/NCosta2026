<?php
// Habilitar reporte de errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/TarifaAloja_Edu.php");
session_start();
require_once("../models/Log.php");

$tarifasAloja = new TarifaAloja();


switch ($_GET["op"]) {

    case "listarTarifasAloja":

        $datos = $tarifasAloja->listarTarifaAloja();



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tarifaAloja.php", "Lista las tarifas de alojamiento");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["idTarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["cod_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["nombre_tarifa"] . '</p>';
            if(!empty($row["unidades_tarifa"]) || !empty($row["unidad_tarifa"])){
                $sub_array[] = '<span class="badge bg-warning tx-14-force">' . $row["unidades_tarifa"]." ".$row["unidad_tarifa"] . '</span>';

            } else {
                $sub_array[] = '';
            }
            $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $row["precio_tarifa"] .  ' €</p>';
            $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $row["descuento_tarifa"] .  ' %</p>';
            $sub_array[] = '<p class="">' . $row["cuenta1_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["cuenta2_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["cuenta3_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["tipo_tarifa"] . '</p>';
            $sub_array[] = '<span class="badge bg-info tx-14-force">' . $row["descrIva"] . ' %' . '</span>';
            if ($row["estTarifa"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-14-force tx-bold text-center">Activo</p>';
            } elseif ($row["estTarifa"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-14-force tx-bold text-center">Desactivado</p>';
            }  
            // BOTONES DE ACCIONES
            if ($row["estTarifa"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idTarifa'] . ')"  id="' . $row["idTarifa"] . '" class="btn btn-primary btn-icon" data-bs-target="#editar-tarifaAloja-modal" data-bs-toggle="modal" data-placement="top" title="Editar Tarifa Alojamiento"><div><i class="fa fa-edit"></i></div></button> 
                
                <button type="button" onClick="cambiarEstado(' . $row["idTarifa"] . ');"  id="' . $row["idTarifa"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Tarifa Alojamiento"><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' . $row['idTarifa'] . ')"  id="' . $row["idTarifa"] . '" class="btn btn-primary btn-icon" data-bs-target="#editar-tarifaAloja-modal" data-bs-toggle="modal" data-placement="top" title="Editar Tarifa Alojamiento"><div><i class="fa fa-edit"></i></div></button>


                <button type="button" onClick="cambiarEstado(' . $row["idTarifa"] . ');"  id="' . $row["idTarifa"] . '" class="btn btn-success btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Tarifa Alojamiento"><div><i class="fa-solid fa-check"></i></div></button>';
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
        
         case "listarTarifasAll":
            $datos = $tarifasAloja->listarTarifaFactAll();
    
            $json_string = json_encode($datos);
            $file = 'JAGGER.json';
            file_put_contents($file, $json_string);
  
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "tarifaAloja.php", "Lista las tarifas de alojamiento");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
    
    
            $data = array();
    
    
            foreach ($datos as $row) {
                $sub_array = array();
    
                $sub_array[] = $row["idTarifa"] ;
                $sub_array[] = $row["cod_tarifa"];
                $sub_array[] = $row["nombre_tarifa"];
                if(!empty($row["unidades_tarifa"]) || !empty($row["unidad_tarifa"])){
                    $sub_array[] = '<span class="badge bg-warning tx-14-force">' . $row["unidades_tarifa"]." ".$row["unidad_tarifa"] . '</span>';
    
                } else {
                    $sub_array[] = '';
                }
                $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $row["descuento_tarifa"] .  ' %</p>';
                $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $row["iva_tarifa"] .  ' %</p>';
                $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $row["precio_tarifa"] .  ' €</p>';
                $sub_array[] = '<p class="text-right badge bg-info tx-14-force">' . $row["tipo_tarifa"] .  '</p>';

    
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
        
        case "listarTarifasAlojaFactura":
            $datatype = $_GET["datatype"];
            $datos = $tarifasAloja->listarTarifaAlojaFact($datatype);
    
  
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "tarifaAloja.php", "Lista las tarifas de alojamiento");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
    
    
            $data = array();
    
    
            foreach ($datos as $row) {
                $sub_array = array();
    
                $sub_array[] = $row["idTarifa"] ;
                $sub_array[] = $row["cod_tarifa"];
                $sub_array[] = $row["nombre_tarifa"];
                if(!empty($row["unidades_tarifa"]) || !empty($row["unidad_tarifa"])){
                    $sub_array[] = '<span class="badge bg-warning tx-14-force">' . $row["unidades_tarifa"]." ".$row["unidad_tarifa"] . '</span>';
    
                } else {
                    $sub_array[] = '';
                }
                $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $row["descuento_tarifa"] .  ' %</p>';
                // Usar valorIva si iva_tarifa está vacío
                $ivaValue = !empty($row["iva_tarifa"]) ? $row["iva_tarifa"] : (!empty($row["valorIva"]) ? $row["valorIva"] : "0");
                $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $ivaValue .  ' %</p>';
                $sub_array[] = '<p class="text-right badge bg-orange tx-14-force">' . $row["precio_tarifa"] .  ' €</p>';
                
    
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
        
            case "listarTarifasAlojaInput":
                $search = $_POST["search"];
                $datatype = $_POST["dataType"];
                
                $data = $tarifasAloja->listarTarifasAlojaInput($datatype,$search);
        
        
                echo json_encode($data);
        
        
                break;
            case "recogerDatosPorCodigo":
                $codigo = $_POST["codigo"];
                $data = $tarifasAloja->recogerDatosPorCodigo($codigo);
        
        
                echo json_encode($data);
        

                break;
        //////////////////////////////////////////////
        // LISTA LAS TARIFAS DEL MODAL FACTURACION //
        ////////////////////////////////////////////
    case "listarTarifasAlojaxId":
        $tipoTarifa = $_GET['idTiposAloja'];
        $datos = $tarifasAloja->listarTarifaAlojaxIdActivo($tipoTarifa);

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idTarifasAloja"];
            $sub_array[] = '<p class="">' . $row["descripcion_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["unidades_tarifa"]." ".$row["unidad_tarifa"] . ' / ' . $row["descrMedidaAloja"] . '</p>';
            $sub_array[] = '<p class="">' . $row["impTarifaAloja"] . '</p>';
            $sub_array[] = '<label class="label label-success">' . $row["ivaTarifa"] . '%</label>';


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
        ////////////////////////////////////////////
        ///////////////////////////////////////////
        //////////////////////////////////////////

    case "insertarTarifasAloja":

        $nombre = $_POST["DescrTarifaAloja"];
        $codigo = $_POST["codTarifaAloja"];
        $unidades = $_POST["unidadTarifasAloja"];
        $unidadMedidaPlural = $_POST["unidadMedidaTarifaPlural"];
        $unidadMedidaSingul = $_POST["unidadMedidaTarifaSingular"];
        $precio = reemplazarComaPorPunto($_POST["importeTarifasAloja"]);
        $descuento = $_POST["descuentoTarifas"];
        $cta1TarifasAloja = reemplazarComaPorPunto($_POST["cta1TarifasAloja"]);
        $cta2TarifasAloja = reemplazarComaPorPunto($_POST["cta2TarifasAloja"]);
        $cta3TarifasAloja = reemplazarComaPorPunto($_POST["cta3TarifasAloja"]);
        $selectIva = $_POST["selectIva"];
        $departamentoTarifa = $_POST["departamentoTarifa"];
        $tipoTarifa = $_POST["tipoTarifa"];
        $descripcion = $_POST["textTarifasAloja"];

        // VALIDACION VAN A IR AQUI
        $datos = $tarifasAloja->insertarTarifaAloja($nombre,$codigo,$unidades,$unidadMedidaPlural,$unidadMedidaSingul,$precio,$descuento,$cta1TarifasAloja,$cta2TarifasAloja,$cta3TarifasAloja,$selectIva,$departamentoTarifa,$tipoTarifa,$descripcion);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tarifaAloja.php", "Se inserta una nueva tarifa de alojamiento");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        echo $datos;
        
        break;

    case "recogerEditar":
        $sub_array = array();

        $datos = $tarifasAloja->get_tarifaAloja_x_id($_POST["idTarifaAloja"]);
        echo json_encode($datos);

        

        break;

    case "editarTarifasAloja":

        $idTarifasAloja = $_POST["idTarifasAloja"];
        $nombre = $_POST["DescrTarifaAlojaE"];
        $codigo = $_POST["codTarifaAlojaE"];
        $unidades = $_POST["unidadTarifasAlojaE"];
        $unidadMedidaPlural = $_POST["unidadMedidaTarifaPluralE"];
        $unidadMedidaSingul = $_POST["unidadMedidaTarifaSingularE"];
        $precio = reemplazarComaPorPunto($_POST["importeTarifasAlojaE"]);
        $descuento = $_POST["descuentoTarifasE"];
        $cta1TarifasAloja = reemplazarComaPorPunto($_POST["cta1TarifasAlojaE"]);
        $cta2TarifasAloja = reemplazarComaPorPunto($_POST["cta2TarifasAlojaE"]);
        $cta3TarifasAloja = reemplazarComaPorPunto($_POST["cta3TarifasAlojaE"]);
        $selectIva = $_POST["selectIvaE"];
        $departamentoTarifa = $_POST["departamentoTarifaE"];
        $tipoTarifa = $_POST["tipoTarifaE"];
        $descripcion = $_POST["textTarifasAlojaE"];


        
        // VALIDACION VAN A IR AQUI
        $tarifasAloja->editarTarifaAloja($idTarifasAloja,$nombre,$codigo,$unidades,$unidadMedidaPlural,$unidadMedidaSingul,$precio,$descuento,$cta1TarifasAloja,$cta2TarifasAloja,$cta3TarifasAloja,$selectIva,$departamentoTarifa,$tipoTarifa,$descripcion);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tarifaAloja.php", "Se edita la tarifa de alojamiento " . $_POST["idTarifasAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "activarTarifaAloja":

        $tarifasAloja->activarTarifaAloja($_POST["idTarifa"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tarifaAloja.php", "Se activa la tarifa de alojamiento " . $_POST["idTarifasAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "desactivarTarifaAloja":

        $tarifasAloja->desactivarTarifaAloja($_POST["idTarifa"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tarifaAloja.php", "Se desactiva la tarifa de alojamiento " . $_POST["idTarifasAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "listaTiposAlojaSelect":
        $datos = $tarifasAloja->listarTiposAlojaSelect();
        echo json_encode($datos);
        break;

    case "listarTarifasTipoAloja":


        $datos = $tarifasAloja->listarTarifasTiposAloja($_GET["tipoAloja"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "tarifaAloja.php", "Se hace un filtro sobre en la lista de tarifas de alojamiento ");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["idTarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["descripcion_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["nombre_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["unidades_tarifa"]." ".$row["unidad_tarifa"] . '</p>';
            $sub_array[] = '<p class="">' . $row["descrMedidaAloja"] . '</p>';
            $sub_array[] = '<p class="">' . $row["impTarifaAloja"] .  ' €</p>';
            $sub_array[] = '<p class="">' . $row["cta1TarifaAloja"] . '</p>';
            $sub_array[] = '<p class="">' . $row["cta2TarifaAloja"] . '</p>';
            
            if ($row["estTarifa"] == 1) {
                $sub_array[] = '<p class="tx-success tx-bold">Activo</p>';
            } elseif ($row["estTarifa"] == 0) {
                $sub_array[] = '<p class="tx-warning tx-bold">Desactivado</p>';
            }
            // BOTONES DE ACCIONES
            if ($row["estTarifa"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarDatosEditar(' . $row['idTarifa'] . ')"  id="' . $row["idTarifa"] . '" class="btn btn-primary btn-icon  col-lg-5 col-5" data-target="#editar-tarifaAloja-modal" data-toggle="modal" data-placement="top" title="Editar Tarifa Alojamiento"><div><i class="fa fa-edit"></i></div></button> 
                    
                    <button type="button" onClick="desactivar(' . $row["idTarifa"] . ');"  id="' . $row["idTarifa"] . '" class="btn btn-danger btn-icon mt-1 mt-lg-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Tarifa Alojamiento"><div><i class="fa-solid fa-xmark  col-lg-5 col-7 m-1 mt-lg-0"></i></div></button>';
            } else {
                $sub_array[] = ' <button type="button" onClick="cargarDatosEditar(' . $row['idTarifa'] . ')"  id="' . $row["idTarifa"] . '" class="btn btn-primary btn-icon col-lg-5 col-5" data-target="#editar-tarifaAloja-modal" data-toggle="modal" data-placement="top" title="Editar Tarifa Alojamiento"><div><i class="fa fa-edit"></i></div></button>
    
    
                    <button type="button" onClick="activar(' . $row["idTarifa"] . ');"  id="' . $row["idTarifa"] . '" class="btn btn-success btn-icon col-lg-5 col-7 mt-1 mt-lg-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Tarifa Alojamiento"><div><i class="fa-solid fa-check"></i></div></button>';
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

    case "listarIvaSelect":
        $datos = $tarifasAloja->listarIvaSelect();
        echo json_encode($datos);


        break;
        case "listarDepartamentosSelect":
            $datos = $tarifasAloja->listarDepartamentosSelect();
            echo json_encode($datos);
    
    
            break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $nuevoEstado = $tarifasAloja->cambiarEstado($idElemento);
            echo json_encode(["nuevoEstado" => $nuevoEstado]);
            break;
}

<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Contrato.php");
session_start();
require_once("../models/Log.php");

$contrato = new Contrato();


switch ($_GET["op"]) {

    case "listarContrato":
        $datos = $contrato->get_contrato_x_id($_GET["idPersonal"]);
       
   

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["idpersonal_PersoContrato"] . '</p>';
            $sub_array[] = '<p class="">' . $row["descrTipoContrato"] . ' ' . $row["textTipoContrato"] . '</p>';
          
            $sub_array[] = '<p class="">' . FechaLocal($row["fecInicioPersoContrato"]) . ' / ' .  FechaLocal($row["fecFinalPersoContrato"]);
            $sub_array[] = '<p class=""> '.$row["categoriaContrato"].' </p>';
            $sub_array[] = '<p class=""> '.$row["jornadaContrato"].' </p>';
            $sub_array[] = '<p class=""> '.$row["duracionContrato"].' </p>';

            if ($row["estContrato"] == 1) {
                $sub_array[] = '<span class="tx-bold badge bg-primary tx-14-force"> Activo </span>';
            } else {
                $sub_array[] = '<span class="tx-bold badge bg-secondary tx-14-force"> Desactivado </span>';
            }
            $sub_array[] = '<p class=""> '.$row["textPersoContrato"].' </p>';


            if ($row["estContrato"] == 1) {
                $sub_array[] = '

                <button type="button" onClick="cargarElemento(' . $row['idPersoContrato'] . ')"   class="btn btn-primary btn-icon" data-target="#editar-contrato-modal" data-toggle="modal" data-placement="top" title="Editar Contrato"><div><i class="fa fa-edit"></i></div></button> 
                <button type="button" onClick="cambiarEstado(' . $row["idPersoContrato"] . ');" class="btn btn-danger btn-icon mt-1 mt-lg-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Contrato"><div><i class="fa fa-user-slash"></i></div></button>';
            } else {
                $sub_array[] = '
                <button type="button" onClick="cargarElemento(' . $row['idPersoContrato'] . ')"  class="btn btn-primary btn-icon" data-target="#editar-contrato-modal" data-toggle="modal" data-placement="top" title="Editar Contrato"><div><i class="fa fa-edit"></i></div></button>                 
                <button type="button" onClick="cambiarEstado(' . $row["idPersoContrato"] . ');" class="btn btn-success btn-icon mt-1 mt-lg-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Contrato"><div><i class="fa fa-user-check "></i></div></button>';
            
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
        
        case "recogerDatosContrato":
            $idElemento = $_POST["idElemento"];
            $datos = $contrato->recogerDatosContrato($idElemento);
            echo json_encode($datos);
            break;

    case "recogerContrato":

        $datosContrato = $contrato->listarContrato();

        echo json_encode($datosContrato);


        break;
        
        case "cambiarEstado":
            $idContrato = $_POST["idElemento"];
            $datos = $contrato->cambiarEstado($idContrato);
    
            echo json_encode($datos);
    
            break;


    case "insertarContrato":
        $idContrato = $_POST["idContrato"];
        $fechaIni = $_POST["fecInicioPersoContrato"];
        $fechaFin = $_POST["fecFinalPersoContrato"];
        $textPersoContrato = $_POST["textTipoContrato"];
        $idTipoContrato = $_POST["tipoPersonal"];
        
        $textJornada = $_POST["textJornada"];
        $textCategoria = $_POST["textCategoria"];
        $textDuracion = $_POST["textDuracion"];
        
        // VALIDACION VAN A IR AQUI
        $contrato->insertarContrato($idContrato,  $fechaIni, $fechaFin, $textPersoContrato, $idTipoContrato,$textJornada,$textCategoria,$textDuracion);

       
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "contrato.php", "Interta un nuevo contrato ");
        $logI->grabarLinea();
        unset($logI);

        break;

    case "recogerEditar":
        $sub_array = array();
        $datos = $contrato->get_contrato_x_id($_POST["idContrato"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {


                $sub_array[] = $row["idContrato"];
                $sub_array[] = $row["nomContrato"];
                $sub_array[] = $row["apeContrato"];
                $sub_array[] = $row["dirContrato"];
                $sub_array[] = $row["poblaContrato"];
                $sub_array[] = $row["cpContrato"];
                $sub_array[] = $row["provContrato"];
                $sub_array[] = $row["paisContrato"];
                $sub_array[] = $row["tlfContrato"];
                $sub_array[] = $row["movilContrato"];
                $sub_array[] = $row["emailContrato"];
            }

            echo json_encode($sub_array);
        }
        break;

    case "editarContrato":

        $idContrato = $_POST["idContratoE"];
        $fechaIni = $_POST["fecInicioPersoContratoE"];
        $fechaFin = $_POST["fecFinalPersoContratoE"];
        $textPersoContrato = $_POST["textTipoContratoE"];
        $idTipoContrato = $_POST["tipoPersonalE"];

        $textCategoria = $_POST["textCategoriaE"];
        $textJornada = $_POST["textJornadaE"];
        $textDuracion = $_POST["textDuracionE"];

        // VALIDACION VAN A IR AQUI
        $contrato->editarContrato($idContrato,  $fechaIni, $fechaFin, $textPersoContrato, $idTipoContrato, $textCategoria, $textJornada, $textDuracion);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "contrato.php", "Edita el contrato " . $_POST["idContratoE"]);
        $logI->grabarLinea();
        unset($logI);

        break;

        //EDITAR
    case "obtenerContratoId":

        $datos = $contrato->get_contrato_x_id($_POST["idTipoContrato"]);

        echo json_encode($datos);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "contrato.php", "Se edita el contrato " . $_POST["idTipoContrato"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

      
        case "eliminar":
            $contrato->delete_contrato($_POST["idContrato"]);
            // Archivo LOG
            $idUsuario = $_POST["idContrato"];
    
            session_start();
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "contrato.php", "DESACTIVA contrato ID:$idUsuario");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
            break;
    
    
        case "activar":

            $contrato->activar_contrato($_POST["idContrato"]);
    
            // Archivo LOG
            $idUsu = $_POST["idContrato"];
            session_start();
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "contrato.php", "ACTIVA contrato ID:$idUsu");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
            break;
}
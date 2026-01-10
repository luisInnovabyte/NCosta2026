<?php

class Llegadas extends Conectar
{

    public function recogerLlegadasHome($idPrescriptor)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_llegadas_edu LEFT JOIN tm_departamento_edu ON tm_llegadas_edu.iddepartamento_llegadas = tm_departamento_edu.idDepartamentoEdu WHERE `idprescriptor_llegadas` = $idPrescriptor";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerLlegadasHomexId($llegadaSelect)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_llegadas_edu LEFT JOIN tm_departamento_edu ON tm_llegadas_edu.iddepartamento_llegadas = tm_departamento_edu.idDepartamentoEdu LEFT JOIN tm_agentes_edu  ON tm_llegadas_edu.agente_llegadas = tm_agentes_edu.idAgente  WHERE `id_llegada` = $llegadaSelect ";
       $json_string = json_encode($sql);
       $file = 'XTRES.json';
       file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function totalPagado($llegadaSelect)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT SUM(importePagoAnticipado) AS totalImporte
        FROM tm_pagoanticipadollegadas_edu
        WHERE idLlegada_pagoAnticipado = $llegadaSelect;
        ";
       $json_string = json_encode($sql);
       $file = 'XTRES.json';
       file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerLlegadasHomeDocencia($idPrescriptor)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_llegadas_edu LEFT JOIN tm_departamento_edu ON tm_llegadas_edu.iddepartamento_llegadas = tm_departamento_edu.idDepartamentoEdu WHERE `idprescriptor_llegadas` = $idPrescriptor AND estLlegada = 1";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerLlegadas($idPrescriptor)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    llegadas_departamentos.*,
                    evaluacionFinal.*,
                    alertas.nivel_alerta,
                    alertas.color_alerta,
                    alertas.mensaje_alerta,
                    alertas.prioridad,
                    alertas.score_urgencia,
                    tm_prescriptores.tokenPrescriptores AS prescriptor_token
                FROM 
                    llegadas_departamentos
                LEFT JOIN 
                    evaluacionFinal 
                    ON llegadas_departamentos.id_llegada = evaluacionFinal.idLlegadaEvaluacionFinal
                LEFT JOIN
                    view_llegadas_alertas_pago AS alertas
                    ON llegadas_departamentos.id_llegada = alertas.id_llegada
                LEFT JOIN
                    tm_prescriptores
                    ON llegadas_departamentos.idprescriptor_llegadas = tm_prescriptores.idPrescripcion
                WHERE 
                    llegadas_departamentos.idprescriptor_llegadas = ?
                ORDER BY 
                    CASE 
                        WHEN llegadas_departamentos.estLlegada = 1 THEN 0  -- En Proceso
                        WHEN llegadas_departamentos.estLlegada = 2 THEN 1  -- En Espera
                        WHEN llegadas_departamentos.estLlegada = 3 THEN 2  -- Finalizada
                        WHEN llegadas_departamentos.estLlegada = 0 THEN 3  -- Cancelado
                        WHEN llegadas_departamentos.estLlegada = 4 THEN 4  -- Sin Servicio
                        ELSE 5
                    END,
                    llegadas_departamentos.fechallegada_llegadas ASC;
                ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idPrescriptor);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function recogerLlegadasPorToken($tokenUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    llegadas_departamentos.*,
                    evaluacionFinal.*
                FROM 
                    llegadas_departamentos
                LEFT JOIN 
                    evaluacionFinal 
                    ON llegadas_departamentos.id_llegada = evaluacionFinal.idLlegadaEvaluacionFinal
                LEFT JOIN 
                    tm_prescriptores 
                    ON llegadas_departamentos.idprescriptor_llegadas = tm_prescriptores.idPrescripcion
                WHERE 
                    tm_prescriptores.tokenPrescriptores = ?
                ORDER BY 
                    CASE 
                        WHEN llegadas_departamentos.estLlegada = 1 THEN 0  -- En Proceso
                        WHEN llegadas_departamentos.estLlegada = 2 THEN 1  -- En Espera
                        WHEN llegadas_departamentos.estLlegada = 3 THEN 2  -- Finalizada
                        WHEN llegadas_departamentos.estLlegada = 0 THEN 3  -- Cancelado
                        WHEN llegadas_departamentos.estLlegada = 4 THEN 4  -- Sin Servicio
                        ELSE 5
                    END,
                    llegadas_departamentos.fechallegada_llegadas ASC;
                ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $tokenUsuario); // <-- aquí usas el token, no el ID
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    
    public function recogerLlegadasXID($idLlegadas)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT le.*, ag.nombreAgente, 
                       alertas.nivel_alerta, 
                       alertas.color_alerta, 
                       alertas.mensaje_alerta, 
                       alertas.prioridad, 
                       alertas.score_urgencia 
                FROM tm_llegadas_edu le 
                LEFT JOIN tm_agentes_edu ag ON le.agente_llegadas = ag.idAgente 
                LEFT JOIN view_llegadas_alertas_pago alertas ON le.id_llegada = alertas.id_llegada 
                WHERE le.id_llegada = '$idLlegadas'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
        
    }
    public function recogerLlegadasXGrupo($grupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_llegadas_edu WHERE `grupo_llegadas` = '$grupo' AND `estProforma` = 0 ORDER BY id_llegada ASC, grupo_llegadas ASC";
       
        
   
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function guardarProforma($dataFactura)
    {
        
        $conectar = parent::conexion();
        parent::set_names();


        $dataFactura = json_encode($dataFactura);
                
        $dataFactura = json_decode($dataFactura, true);
        

        
        $idLlegada = $dataFactura["idLlegada"];
        $paisFact = $dataFactura["paisFact"];
        $provFact = $dataFactura["provFact"];
        $ciudadFact = $dataFactura["ciudadFact"];
        $cpFact = $dataFactura["cpFact"];
        $direcFact = $dataFactura["direcFact"];
        $tefFact = $dataFactura["tefFact"];
        $movilFact = $dataFactura["movilFact"];
        $correoFact = $dataFactura["correoFact"];
        $cifFact = $dataFactura["cifFact"];
        $nombreFacturacion = $dataFactura["nombreFacturacion"];
        $llegadaNum = $dataFactura["llegadaNum"];
        $nombreAlumno = $dataFactura["nombreAlumno"];
        $sexoAlumno = $dataFactura["sexoAlumno"];
        $matriculacion = json_encode($dataFactura["matriculacion"]);
        $alojamiento = json_encode($dataFactura["alojamiento"]);
        $otros = json_encode($dataFactura["otros"]);
        $idTransferLlegada = $dataFactura["idTransferLlegada"];
        $idTransferLlegadaDia = $dataFactura["idTransferLlegadaDia"];
        $idTransferLlegadaLugar = $dataFactura["idTransferLlegadaLugar"];
        $idTransferLlegadaLugarEntrega = $dataFactura["idTransferLlegadaLugarEntrega"];
        $idTransferRecogida = $dataFactura["idTransferRecogida"];
        $idTransferRecogidaDia = $dataFactura["idTransferRecogidaDia"];
        $idTransferRecogidaLugar = $dataFactura["idTransferRecogidaLugar"];
        $idTransferRecogidaLugarEntrega = $dataFactura["idTransferRecogidaLugarEntrega"];
        $llegadaDia = $dataFactura["llegadaDia"];
        $llegadaSemana = $dataFactura["llegadaSemana"];
        $fechaHoyFactura = $dataFactura["fechaHoyFactura"];
        $numProforma = $dataFactura["numProforma"];
        $serie = $dataFactura["serie"];
        $agenteProforma = $dataFactura["agenteProforma"];
        $grupoFact = $dataFactura["grupoFact"];
        $grupoAmigos = $dataFactura["grupoAmigos"];
        $aQuienFacturar = $dataFactura["aQuienFacturar"];
        $YaPagado = $dataFactura["YaPagado"];


        if($aQuienFacturar == "Alumno"){
            $sql = "UPDATE `tm_llegadas_edu` SET `estProforma`=1,`numProforma`='$numProforma' WHERE `id_llegada` = $idLlegada AND `estProforma` = 0";
            $facturarA = "Llegada";
        } else if($aQuienFacturar == "Grupo"){
            $sql = "UPDATE `tm_llegadas_edu` SET `estProforma`=1,`numProforma`='$numProforma' WHERE `grupo_llegadas` = '$grupoFact' AND `estProforma` = 0";
            $facturarA = $grupoFact;
        }
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();

        $sql = "INSERT INTO `cabecera-factura`(`nombreCabecera`, `cifCabecera`, `correoCabecera`, `movilCabecera`, `tefCabecera`, `direcCabecera`, `cpCabecera`, `ciudadCabecera`, `paisCabecera`,`provCabecera`) 
        VALUES ('$nombreFacturacion','$cifFact','$correoFact','$movilFact','$tefFact','$direcFact','$cpFact','$ciudadFact','$paisFact','$provFact')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $lastIdCabecera = $conectar->lastInsertId(); // Obtén el último ID insertado
        $resultado = $sql->fetchAll();

        $sql = "INSERT INTO `pie-factura`(`idCabecera_Pie`, `idLlegada_Pie`, `numProformaPie`, `matriculacionPie`, `alojamientoPie`, `otrosPie`, `fechProformaPie`, `agentePie`, `grupoFactPie`, `grupoAmigPie`, `quienFacturaPie`,`yaPagado`,`serieProformaPie`, `estProforma`)VALUES ($lastIdCabecera,$idLlegada,'$numProforma','$matriculacion','$alojamiento','$otros',now(),'$agenteProforma','$grupoFact','$grupoAmigos','$aQuienFacturar','$YaPagado','$serie',0)";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();


        $sql = "SELECT * FROM `tm_llegadas_edu` WHERE `id_llegada` = $idLlegada";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();

        $idDepartamento = $resultado[0]["iddepartamento_llegadas"];
        
        $sql = "UPDATE `tm_departamento_edu` SET `numFacturaProDepa` = `numFacturaProDepa` + 1 WHERE `idDepartamentoEdu` = $idDepartamento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();


    }
    public function actualizarProforma($dataFactura)
    {
        
        $conectar = parent::conexion();
        parent::set_names();


        $dataFactura = json_encode($dataFactura);
                
        $dataFactura = json_decode($dataFactura, true);
        

        
        $idLlegada = $dataFactura["idLlegada"];
        $paisFact = $dataFactura["paisFact"];
        $ciudadFact = $dataFactura["ciudadFact"];
        $cpFact = $dataFactura["cpFact"];
        $direcFact = $dataFactura["direcFact"];
        $tefFact = $dataFactura["tefFact"];
        $movilFact = $dataFactura["movilFact"];
        $correoFact = $dataFactura["correoFact"];
        $cifFact = $dataFactura["cifFact"];
        $nombreFacturacion = $dataFactura["nombreFacturacion"];
        $llegadaNum = $dataFactura["llegadaNum"];
        $nombreAlumno = $dataFactura["nombreAlumno"];
        $sexoAlumno = $dataFactura["sexoAlumno"];
        $matriculacion = json_encode($dataFactura["matriculacion"]);
        $alojamiento = json_encode($dataFactura["alojamiento"]);
        $otros = json_encode($dataFactura["otros"]);
        $idTransferLlegada = $dataFactura["idTransferLlegada"];
        $idTransferLlegadaDia = $dataFactura["idTransferLlegadaDia"];
        $idTransferLlegadaLugar = $dataFactura["idTransferLlegadaLugar"];
        $idTransferLlegadaLugarEntrega = $dataFactura["idTransferLlegadaLugarEntrega"];
        $idTransferRecogida = $dataFactura["idTransferRecogida"];
        $idTransferRecogidaDia = $dataFactura["idTransferRecogidaDia"];
        $idTransferRecogidaLugar = $dataFactura["idTransferRecogidaLugar"];
        $idTransferRecogidaLugarEntrega = $dataFactura["idTransferRecogidaLugarEntrega"];
        $llegadaDia = $dataFactura["llegadaDia"];
        $llegadaSemana = $dataFactura["llegadaSemana"];
        $fechaHoyFactura = $dataFactura["fechaHoyFactura"];
        $numProforma = $dataFactura["numProforma"];
        $agenteProforma = $dataFactura["agenteProforma"];
        $grupoFact = $dataFactura["grupoFact"];
        $grupoAmigos = $dataFactura["grupoAmigos"];
        $aQuienFacturar = $dataFactura["aQuienFacturar"];
        $YaPagado = $dataFactura["YaPagado"];
        $idCabecera = $dataFactura["idCabecera"];
        $idPie = $dataFactura["idPie"];

/* 
        if($aQuienFacturar == "Alumno"){
            $sql = "UPDATE `tm_llegadas_edu` SET `estProforma`=1,`numProforma`='$numProforma' WHERE `id_llegada` = $idLlegada AND `estProforma` = 0";
            $facturarA = "Llegada";
        } else if($aQuienFacturar == "Grupo"){
            $sql = "UPDATE `tm_llegadas_edu` SET `estProforma`=1,`numProforma`='$numProforma' WHERE `grupo_llegadas` = '$grupoFact' AND `estProforma` = 0";
            $facturarA = $grupoFact;
        } */
   /* 
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(); */

        $sql = "UPDATE `cabecera-factura` SET  `nombreCabecera` = '$nombreFacturacion', `cifCabecera` = '$cifFact', `correoCabecera` = '$correoFact', `movilCabecera` = '$movilFact', `tefCabecera` = '$tefFact', `direcCabecera` = '$direcFact', `cpCabecera` = '$cpFact', `ciudadCabecera` = '$ciudadFact', `paisCabecera` = '$paisFact' WHERE  `idCabecera` = $idCabecera;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();

        $sql = "UPDATE `pie-factura` SET `matriculacionPie` = '$matriculacion', `alojamientoPie` = '$alojamiento', `otrosPie` = '$otros', `yaPagado` = '$YaPagado' WHERE  `idPie` = $idPie;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();




    }
    
    public function guardarLlegada(
    $idLlegada, $diaInscripcion, $idPrescriptorDatos, $departamentoSelect, 
    $nombreApellidos, $sexo, $pais, $idAgente, $idGrupo, $idGrupoAmigo, $fechaLlegada, 
    $lugarLlegada, $recogeAlumno
) {
    // Manejar valores NULL
    $fechaLlegada = !empty($fechaLlegada) ? "'$fechaLlegada'" : "NULL";
    $idAgente = !empty($idAgente) ? $idAgente : "NULL";

    $conectar = parent::conexion();
    parent::set_names();

    $sql = "INSERT INTO tm_llegadas_edu (
        `diainscripcion_llegadas`, 
        `idprescriptor_llegadas`, 
        `iddepartamento_llegadas`, 
        `agente_llegadas`, 
        `grupo_llegadas`, 
        `grupoAmigos`, 
        `fechallegada_llegadas`, 
        `lugarllegada_llegadas`, 
        `quienrecogealumno_llegadas`
    ) VALUES (
        '$diaInscripcion',
        '$idPrescriptorDatos',
        '$departamentoSelect',
        $idAgente,
        '$idGrupo',
        '$idGrupoAmigo',
        $fechaLlegada,
        '$lugarLlegada',
        '$recogeAlumno'
    );";

    // Preparar y ejecutar la consulta
    $sql = $conectar->prepare($sql);
    $sql->execute();
    
    // Obtener el ID de la última inserción
    $lastInsertId = $conectar->lastInsertId();

    // Generar resultado
    $resultado = [
        "status" => "success",
        "message" => "Registro insertado correctamente",
        "lastInsertId" => $lastInsertId
    ];

    // Generar el JSON
    $json_string = json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $file = 'resultado_guardar_llegada.json';
    file_put_contents($file, $json_string);

    // Retorna solo el ID
    return $lastInsertId;
}


    public function editarLlegada(
        $idLlegada,
            $diaInscripcion,
            $idPrescriptorDatos,
            $departamentoSelect,
            $nombreApellidos,
            $sexo,
            $pais,
            $idAgente,
            $idGrupo,
            $idGrupoAmigo,
            $fechaLlegada,
            $lugarLlegada,
            $recogeAlumno
    ) {

        $conectar = parent::conexion();

        parent::set_names();
        $fechaLlegada = !empty($fechaLlegada) ? "'$fechaLlegada'" : "NULL";
        $idAgente = !empty($idAgente) ? "'$idAgente'" : "NULL";

        $sql = "UPDATE `tm_llegadas_edu` SET  
        `diainscripcion_llegadas` = '$diaInscripcion', 
        `idprescriptor_llegadas` = '$idPrescriptorDatos', 
        `iddepartamento_llegadas` = '$departamentoSelect', 
        `agente_llegadas` = $idAgente, 
        `grupo_llegadas` = '$idGrupo', 
        `grupoAmigos` = '$idGrupoAmigo', 
        `fechallegada_llegadas` = $fechaLlegada, 
        `lugarllegada_llegadas` = '$lugarLlegada', 
        `quienrecogealumno_llegadas` = '$recogeAlumno' 
        WHERE `id_llegada` = '$idLlegada';";

$json_string = json_encode($sql);
$file = 'ALLEGADAS.json';
file_put_contents($file, $json_string);
    
        // Preparar y ejecutar la consulta
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // NUEVAS LLEGADAS JOSE //

    // TRAEMOS MATRICULACION POR LLEGADA
    public function listarMatriculaciones($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_matriculacionllegadas_edu` WHERE idLlegada_matriculacion  = '$idLlegada'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarMatriculacion($idLlegada,$inicioDocencia,
    $finalDocencia,
    $codDocencia,
    $textEditar,
    $importeDocencia,
    $ivaDocencia,
    $descDocencia,
    $observacionesDocencias
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_matriculacionllegadas_edu`(`idLlegada_matriculacion`, `idIvaTarifa_matriculacion`, `codTarifa_matriculacion`, `nombreTarifa_matriculacion`,`precioTarifa_matriculacion`,`fechaInicioMatriculacion`, `fechaFinMatriculacion`, `estMatriculacion_llegadas`, `obsMatriculacion`, `descuento_matriculacion`) VALUES ('$idLlegada','$ivaDocencia','$codDocencia','$textEditar','$importeDocencia','$inicioDocencia','$finalDocencia',null,'$observacionesDocencias','$descDocencia')";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function editarMatriculacion($idMatriculaEditando,$idLlegada, $inicioDocencia,$finalDocencia, $codDocencia,$descripcion, $importeDocencia, $ivaDocencia,$descDocencia, $observacionesDocencias)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_matriculacionllegadas_edu` 
        SET 
            `idLlegada_matriculacion` = '$idLlegada',
            `idIvaTarifa_matriculacion` = '$ivaDocencia',
            `codTarifa_matriculacion` = '$codDocencia',
            `nombreTarifa_matriculacion` = '$descripcion',
            `precioTarifa_matriculacion` = '$importeDocencia',
            `fechaInicioMatriculacion` = '$inicioDocencia',
            `fechaFinMatriculacion` = '$finalDocencia',
            `obsMatriculacion` = '$observacionesDocencias',
            `descuento_matriculacion` = '$descDocencia'
        WHERE `idMatriculacionLlegada` = '$idMatriculaEditando'";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function eliminarMatricula($idMatricula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM `tm_matriculacionllegadas_edu`  WHERE idMatriculacionLlegada = '$idMatricula'";

      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerMatriculaxId($idMatricula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_matriculacionllegadas_edu` WHERE idMatriculacionLlegada = '$idMatricula'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
 
    
    public function insertarNivel($idLlegada,$nivelDocencia,$observacionesNivel,$nivelDocenciaAsignado,$semanaDocenciaAsignado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_llegadas_edu` SET `niveldice_llegadas` = '$nivelDocencia', `nivelobservaciones_llegadas` = '$observacionesNivel', `nivelasignado_llegadas` = '$nivelDocenciaAsignado', `semanaasignada_llegadas` = '$semanaDocenciaAsignado' WHERE `id_llegada` = '$idLlegada'";

  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarSuplidos($idLlegada,$importeSuplido,$descrSuplido) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_suplidosLlegadas_edu`(`idsuplido_tmLlegadas`, `importeSuplido`, `descripcionSuplido`) 
        VALUES ('$idLlegada','$importeSuplido','$descrSuplido')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarTransfer(
        $idLlegada,
        $codigoTarifasLlegada,
        $textoTarifasLlegada,
        $importeTarifasLlegada,
        $ivaTarifasLlegada,
        $diaLlegada,
        $horaLlegada,
        $lugarRecogidaLlegada,
        $lugarEntregaLlegada,
        $quienRecogeLlegada,
        $codigoTarifasRegreso,
        $textoTarifasRegreso,
        $importeTarifasRegreso,
        $ivaTarifasRegreso,
        $diaRegreso,
        $horaRegreso,
        $lugarRecogidaRegreso,
        $lugarEntregaRegreso,
        $quienRecogeRegreso,
        $observaciones
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $diaLlegada = !empty($diaLlegada) ? "'$diaLlegada'" : "NULL";
        $horaLlegada = !empty($horaLlegada) ? "'$horaLlegada'" : "NULL";
        $diaRegreso = !empty($diaRegreso) ? "'$diaRegreso'" : "NULL";
        $horaRegreso = !empty($horaRegreso) ? "'$horaRegreso'" : "NULL";

        $sql = "UPDATE `tm_llegadas_edu` SET
        codigotariotallegadaTransfer_llegadas = '$codigoTarifasLlegada',
        textotariotallegadaTransfer_llegadas = '$textoTarifasLlegada',
        importetariotallegadaTransfer_llegadas = '$importeTarifasLlegada',
        ivatariotallegadaTransfer_llegadas = '$ivaTarifasLlegada',
        diallegadaTransferTransfer_llegadas = $diaLlegada,
        horallegadaTransferTransfer_llegadas = $horaLlegada,
        lugarllegadallegadaTransfer_llegadas = '$lugarRecogidaLlegada',
        lugarentregallegadaTransfer_llegadas = '$lugarEntregaLlegada',
        quienrecogealumnollegadaTransfer_llegadas = '$quienRecogeLlegada',
        codigotariotalregresoTransfer_llegadas = '$codigoTarifasRegreso',
        textotariotalregresoTransfer_llegadas = '$textoTarifasRegreso',
        importetariotalregresoTransfer_llegadas = '$importeTarifasRegreso',
        ivatariotalregresoTransfer_llegadas = '$ivaTarifasRegreso',
        diaregresoTransfer_llegadas = $diaRegreso,
        horaregresoTransfer_llegadas = $horaRegreso,
        lugarrecogidaregresaTransfer_llegadas = '$lugarRecogidaRegreso',
        lugarentregaregresaTransfer_llegadas = '$lugarEntregaRegreso',
        quienrecogealumnoregresaTransfer_llegadas = '$quienRecogeRegreso',
        campoobservacionesgeneralTransfer_llegadas = '$observaciones'
        WHERE id_llegada = '$idLlegada'";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarPagoAnticipado($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_pagoanticipadollegadas_edu` LEFT JOIN tm_mediopago ON `tm_pagoanticipadollegadas_edu`.`medioPagoAnticipado` = tm_mediopago.idMedioPago  WHERE idLlegada_pagoAnticipado = '$idLlegada'";

   
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarPagoAnticipado($idLlegada,$importePago,
    $fechaPago,
    $medioPago,
    $comentarioPago
    )
    {

        $conectar = parent::conexion();
        parent::set_names(); 
        $sql = "INSERT INTO `tm_pagoanticipadollegadas_edu`(`idLlegada_pagoAnticipado`, `importePagoAnticipado`, `fechaPagoAnticipado`, `medioPagoAnticipado`, `observacionPagoAnticipado`) 
        VALUES ('$idLlegada','$importePago','$fechaPago','$medioPago','$comentarioPago')";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function guardarEdicionPago($idPagoEditando,$importePago,$fechaPago,$medioPago,$comentarioPago
    )
    {

        $conectar = parent::conexion();
        parent::set_names(); 
        $sql = "UPDATE `tm_pagoanticipadollegadas_edu` SET
        `importePagoAnticipado`='$importePago',`fechaPagoAnticipado`='$fechaPago',`medioPagoAnticipado`='$medioPago',`observacionPagoAnticipado`='$comentarioPago' WHERE idPagoAnticipado = '$idPagoEditando'";

   
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function eliminarPagoAnticipado($idPago)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM `tm_pagoanticipadollegadas_edu`  WHERE idPagoAnticipado  = '$idPago'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function eliminarSuplidos($idSuplidos)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM `tm_suplidosLlegadas_edu`  WHERE idSuplido = '$idSuplidos'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function recogerPagoxId($idPago)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_pagoanticipadollegadas_edu` WHERE idPagoAnticipado = '$idPago'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function actualizarVisado($idLlegada,$visadoCheck,$fechaAdmision,$denegacionFecha,$denegacionMotivo)
    {
        
  
        $conectar = parent::conexion();
        parent::set_names();
        $fechaAdmision = !empty($fechaAdmision) ? "'$fechaAdmision'" : "NULL";
        $denegacionFecha = !empty($denegacionFecha) ? "'$denegacionFecha'" : "NULL";
        $sql = "UPDATE `tm_llegadas_edu` SET
        `tieneVisado`='$visadoCheck',`fechCartaAdmision`=$fechaAdmision,`denegacionFecha`=$denegacionFecha,
        `denegacionMotivo`='$denegacionMotivo' WHERE id_llegada = '$idLlegada'";

       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
        
        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estMatriculaxidLlegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_matriculacion_xidllegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estAlojamientoxidLlegada($idLlegada);";
     
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_alojamiento_xidllegada($idLlegada);";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    
    public function listarSuplidos($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_suplidosLlegadas_edu`  WHERE idsuplido_tmLlegadas = '$idLlegada'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    // AÑADIR CANCELACION
    public function insertarCancelacion($idLlegada,$fechaCancelacion,$motivoCancelacion)
    {
        
       
        $conectar = parent::conexion();
        parent::set_names();
        $fechaCancelacion = !empty($fechaCancelacion) ? "'$fechaCancelacion'" : "NULL";

        $sql = "UPDATE `tm_llegadas_edu` SET
        `fechacancelacion_llegadas`=$fechaCancelacion,`motivocancelacion_llegadas`='$motivoCancelacion' WHERE id_llegada = '$idLlegada'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        
        
        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estMatriculaxidLlegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_matriculacion_xidllegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estAlojamientoxidLlegada($idLlegada);";
            
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_alojamiento_xidllegada($idLlegada);";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        
    }
    public function eliminarCancelacion($idLlegada)
    {
        
       
        $conectar = parent::conexion();
        parent::set_names();
      

        $sql = "UPDATE `tm_llegadas_edu` SET
        `fechacancelacion_llegadas`=NULL,`motivocancelacion_llegadas`='' WHERE id_llegada = '$idLlegada'";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        
        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estMatriculaxidLlegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_matriculacion_xidllegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estAlojamientoxidLlegada($idLlegada);";
            
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_alojamiento_xidllegada($idLlegada);";

        $sql = $conectar->prepare($sql);
        $sql->execute();

    }

    public function actualizarMatriculacion($idLlegada)
    {
        
       
        $conectar = parent::conexion();
        parent::set_names();
        ###############################################################################
        ##   ESTADOS DE LAS LINEAS de MATRICULACION  (estMatriculacion_llegadas)   
        ##     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)           
        ##     1 = ACTIVO ENTRE LAS FECHAS DE LA MATRICULACION                     
        ##     2 - ESPERANDO INICIO DE LA MATRICULACION                           
        ##     3 - FINALIZADA LA MATRICULACIÓN                                     
        ##     4 - NO TIENE MATRICULACIÓN                                          
        ###############################################################################

        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estMatriculaxidLlegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_matriculacion_xidllegada($idLlegada);";
        $sql = $conectar->prepare($sql);
        $sql->execute();


        return $resultado = $sql->fetchAll();
    }

    public function actualizarAlojamiento($idLlegada)
    {
        
  
        $conectar = parent::conexion();
        parent::set_names();
        ###############################################################################
        ##   ESTADOS DE LAS LINEAS de MATRICULACION  (estMatriculacion_llegadas)   
        ##     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)           
        ##     1 = ACTIVO ENTRE LAS FECHAS DE LA MATRICULACION                     
        ##     2 - ESPERANDO INICIO DE LA MATRICULACION                           
        ##     3 - FINALIZADA LA MATRICULACIÓN                                     
        ##     4 - NO TIENE MATRICULACIÓN                                          
        ###############################################################################

        // CABECERA ESTADO LLEGADA
        $sql = "CALL actualizar_estAlojamientoxidLlegada($idLlegada);";
     
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // PIES MATRICULA ESTADOS
        $sql = "CALL actualizar_estLlegada_alojamiento_xidllegada($idLlegada);";

        $sql = $conectar->prepare($sql);
        $sql->execute();



        

        return $resultado = $sql->fetchAll();
    }


    // ALOJAMIENTOS

    // TRAEMOS ALOJAMIENTOS POR LLEGADA
    public function listarAlojamientos($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_alojamientosllegadas_edu` WHERE idLlegada_alojamientos  = '$idLlegada'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function insertarAlojamiento($idLlegada,$entradaAlojamiento,
    $salidaAlojamiento,
    $codAlojamiento,
    $textEditar,
    $importeAlojamiento,
    $ivaAlojamiento,
    $descuentoAlojamiento,
    $observacionesAlojamiento
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
  
        $sql = "INSERT INTO `tm_alojamientosllegadas_edu`(`idLlegada_alojamientos`, `idIvaTarifa_alojamientos`, `codTarifa_alojamientos`, 
        `nombreTarifa_alojamientos`,`precioTarifa_alojamientos`,`fechaInicioAlojamientos`, `fechaFinAlojamientos`, `estAlojamientos_llegadas`, 
        `obsAlojamientos`, `descuento_Alojamientos`) VALUES 
        ('$idLlegada','$ivaAlojamiento','$codAlojamiento','$textEditar','$importeAlojamiento','$entradaAlojamiento','$salidaAlojamiento',null,'$observacionesAlojamiento','$descuentoAlojamiento')";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerAlojamientoxId($idAlojamiento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_alojamientosllegadas_edu` WHERE idAlojamientoLlegada   = '$idAlojamiento'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
        
    public function editarAlojamiento($idAlojamientoEditando,$idLlegada,$entradaAlojamiento,$salidaAlojamiento,$codAlojamiento,$descripcionAloja,$importeAlojamiento,$ivaAlojamiento,$descuentoAlojamiento,$observacionesAlojamiento)
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "UPDATE `tm_alojamientosllegadas_edu` 
    SET 
        `idLlegada_alojamientos` = '$idLlegada',
        `idIvaTarifa_alojamientos` = '$ivaAlojamiento',
        `codTarifa_alojamientos` = '$codAlojamiento',
        `nombreTarifa_alojamientos` = '$descripcionAloja',
        `precioTarifa_alojamientos` = '$importeAlojamiento',
        `fechaInicioAlojamientos` = '$entradaAlojamiento',
        `fechaFinAlojamientos` = '$salidaAlojamiento',
        `obsAlojamientos` = '$observacionesAlojamiento',
        `descuento_Alojamientos` = '$descuentoAlojamiento'
    WHERE `idAlojamientoLlegada` = '$idAlojamientoEditando'";
    $json_string = json_encode($sql);
    $file = 'Atm_alojamientosllegadas_edu.json';
    file_put_contents($file, $json_string);
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }
    
    public function eliminarAlojamiento($idAlojamiento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM `tm_alojamientosllegadas_edu`  WHERE idAlojamientoLlegada  = '$idAlojamiento'";

 
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     public function grupoFacturado($idGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // NOS DEVUELVE SI ESE GRUPO TIENE FACTURA ACTIVA
        $sql = "SELECT * FROM factura_pie LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera WHERE abonadaFacturaPro IS NULL 
        AND aQuienFactura = 3 AND factura_cabecera.nombreCabecera = '$idGrupo';";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    
}

<?php

class Proforma extends Conectar
{

    public function listarProforma()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM view_cabecera_pie_factura";
        
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerProforma($idProforma)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_cabecera_pie_factura` WHERE `idPie` = $idProforma";
        
     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
       public function cargarProductoId($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_contenido` WHERE `idLlegadaFactura` = $idLlegada AND numFactura IS NULL";
       $json_string = json_encode($sql);
       $file = 'TRIGLICERIDOS.json';
       file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
        public function cargarProductoIdFactura($idFactura)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_contenido` WHERE `numFactura` = $idFactura";
       $json_string = json_encode($sql);
       $file = 'yyy.json';
       file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarProductoIdFacturaReal($idFactura)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_contenido_real` WHERE `numFactura` = $idFactura";
       $json_string = json_encode($sql);
       $file = 'yyy.json';
       file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarFactura($idLlegada,$codigoFactura, $conceptoFactura, $tipoFactura, $ivaFactura, $descuentoFactura, $importeFactura, $fecha_inicio, $fecha_fin)
    {
      
        $conectar = parent::conexion();
        parent::set_names();
        $fechaInicio = !empty($fecha_inicio) ? "'" . FechaRemota($fecha_inicio) . "'" : "NULL";
        $fechaFin    = !empty($fecha_fin)    ? "'" . FechaRemota($fecha_fin) . "'" : "NULL";


        $sql = "INSERT INTO `factura_contenido`(`codigoFacturaContenido`, `conceptoFacturaContenido`, `tipoFacturaContenido`, `ivaFacturaContenido`, `descuentoFacturaContenido`, `importeFacturaContenido`, `idPieFacturaContenido`, `idCabeceraFacturaContenido`, `idLlegadaFactura`, `fechaInicioFacturaContenido`, `fechaFinFacturaContenido`) 
        VALUES ('$codigoFactura','$conceptoFactura','$tipoFactura','$ivaFactura','$descuentoFactura','$importeFactura','$idLlegada','$idLlegada','$idLlegada',$fechaInicio,$fechaFin)";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
    }
      public function editarTarifa($idEditando,$codigoFactura, $conceptoFactura, $tipoFactura, $ivaFactura, $descuentoFactura, $importeFactura)
    {
       
         $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `factura_contenido` 
        SET `conceptoFacturaContenido` = '$conceptoFactura',
            `tipoFacturaContenido` = '$tipoFactura',
            `ivaFacturaContenido` = '$ivaFactura',
            `descuentoFacturaContenido` = '$descuentoFactura',
            `importeFacturaContenido` = '$importeFactura',
            `codigoFacturaContenido` = '$codigoFactura'

        WHERE `idContenidoFactura` = '$idEditando'";

        $json_string = json_encode($sql);
        $file = 'a66.json';
        file_put_contents($file, $json_string);
     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
    }
          public function recogerDatosEditar($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_contenido` WHERE `idContenidoFactura` = $idElemento";
       
     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function eliminarTarifa($idTarifa)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM `factura_contenido` WHERE `idContenidoFactura` = $idTarifa";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    
    
    // TRAEMOS MATRICULACION POR LLEGADA
    public function listarMatriculaciones($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT '1' AS tipo, codTarifa_matriculacion AS codTarifa, nombreTarifa_matriculacion AS nombreTarifa, obsMatriculacion AS observaciones, precioTarifa_matriculacion AS precio, idIvaTarifa_matriculacion AS iva, descuento_matriculacion AS descuento, fechaInicioMatriculacion AS fechaInicio, fechaFinMatriculacion AS fechaFin FROM tm_matriculacionllegadas_edu WHERE idLlegada_matriculacion = $idLlegada 
        UNION ALL SELECT '2' AS tipo, codTarifa_alojamientos AS codTarifa, nombreTarifa_alojamientos AS nombreTarifa, obsAlojamientos AS observaciones, precioTarifa_alojamientos AS precio, idIvaTarifa_alojamientos AS iva, descuento_Alojamientos AS descuento, fechaInicioAlojamientos AS fechaInicio, fechaFinAlojamientos AS fechaFin FROM tm_alojamientosllegadas_edu WHERE idLlegada_alojamientos = $idLlegada ;";
        $json_string = json_encode($sql);
        $file = 'MISTEROLIS.json';
        file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarMatriculacionesGrupos($nombreGrupos)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT '1' AS tipo, codTarifa_matriculacion AS codTarifa, nombreTarifa_matriculacion AS nombreTarifa, obsMatriculacion AS observaciones, precioTarifa_matriculacion AS precio, idIvaTarifa_matriculacion AS iva, descuento_matriculacion AS descuento, fechaInicioMatriculacion AS fechaInicio, fechaFinMatriculacion AS fechaFin, tm_llegadas_edu.*,  tm_prescriptores.* FROM tm_matriculacionllegadas_edu LEFT JOIN tm_llegadas_edu ON tm_matriculacionllegadas_edu.idLlegada_matriculacion = tm_llegadas_edu.id_llegada  LEFT JOIN tm_prescriptores ON tm_prescriptores.idPrescripcion
= tm_llegadas_edu.idprescriptor_llegadas WHERE tm_llegadas_edu.`grupoAmigos` = '$nombreGrupos' UNION ALL SELECT '2' AS tipo, codTarifa_alojamientos AS codTarifa, nombreTarifa_alojamientos AS nombreTarifa, obsAlojamientos AS observaciones, precioTarifa_alojamientos AS precio, idIvaTarifa_alojamientos AS iva, descuento_Alojamientos AS descuento, fechaInicioAlojamientos AS fechaInicio, fechaFinAlojamientos AS fechaFin, tm_llegadas_edu.*,  tm_prescriptores.* FROM tm_alojamientosllegadas_edu LEFT JOIN tm_llegadas_edu ON tm_alojamientosllegadas_edu.idLlegada_alojamientos = tm_llegadas_edu.id_llegada  LEFT JOIN tm_prescriptores ON tm_prescriptores.idPrescripcion
= tm_llegadas_edu.idprescriptor_llegadas WHERE tm_llegadas_edu.`grupoAmigos` = '$nombreGrupos';";
        $json_string = json_encode($sql);
        $file = 'MISTEROLISGruos.json';
        file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
   public function transferGruposLlegada($nombreGrupos)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `codigotariotallegadaTransfer_llegadas`,`textotariotallegadaTransfer_llegadas`,`importetariotallegadaTransfer_llegadas`,`ivatariotallegadaTransfer_llegadas`,`codigotariotalregresoTransfer_llegadas`,`textotariotalregresoTransfer_llegadas`,`importetariotalregresoTransfer_llegadas`,`ivatariotalregresoTransfer_llegadas` 
        FROM `tm_llegadas_edu` WHERE `grupo_llegadas` = '$nombreGrupos'  AND codigotariotallegadaTransfer_llegadas IS NOT NULL;";
        $json_string = json_encode($sql);
        $file = 'MISTEROLISGruos2222.json';
        file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     public function transferGruposRegreso($nombreGrupos)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `codigotariotalregresoTransfer_llegadas`,`textotariotalregresoTransfer_llegadas`,`importetariotalregresoTransfer_llegadas`,`ivatariotalregresoTransfer_llegadas` 
        FROM tm_llegadas_edu WHERE grupo_llegadas = '$nombreGrupos' AND codigotariotalregresoTransfer_llegadas IS NOT NULL;";
        $json_string = json_encode($sql);
        $file = 'MISTEROLISGruos2222.json';
        file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarFacturaPro($nombreCabecera,$cifCabecera,$direcCabecera, $movilCabecera,$telefonoCabecera,$cpCabecera,$correoCabecera,$paisCabecera,$idLlegada,$numProforma,$serieProforma,$fechaProforma,$idAgente,$grupoAmigos,$grupoFacturacion,$quienFactura,$aQuienFactura,$idDepartamento,$conceptoExtra)
    {
        $conectar = parent::conexion();
        parent::set_names();

        try {
            // Iniciar transacción
            $conectar->beginTransaction();
            $json_string = json_encode('');
            $file = 'u01.json';
            file_put_contents($file, $json_string);
            // 1. Obtener el número de factura actual
            $sql = "SELECT numFacturaProDepa,prefijoFacturaProEdu FROM `tm_departamento_edu` WHERE idDepartamentoEdu = $idDepartamento";
             $json_string = json_encode($sql);
            $file = 'u1.json';
            file_put_contents($file, $json_string);
            $sql = $conectar->prepare($sql);
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
          
            if (!$resultado) {
                throw new Exception("No se encontró el departamento con ID $idDepartamento");
            }
            $prefijoFactura = $resultado['prefijoFacturaProEdu'];
            $numFacturaActual = (int)$resultado['numFacturaProDepa'];
            $numProforma = $numFacturaActual + 1;
            $json_string = json_encode($numProforma);
            $file = 'u2.json';
            file_put_contents($file, $json_string);
            // 2. Actualizar el número de factura
            $sql = "UPDATE `tm_departamento_edu` SET numFacturaProDepa = $numProforma WHERE idDepartamentoEdu = $idDepartamento";
                        $json_string = json_encode($sql);
            $file = 'u3.json';
            file_put_contents($file, $json_string);
            $sql = $conectar->prepare($sql);
            $sql->execute();

            // 3. Insertar en factura_cabecera
            $sql = "INSERT INTO `factura_cabecera`(`nombreCabecera`, `cifCabecera`, `correoCabecera`, `movilCabecera`, `tefCabecera`, `direcCabecera`, `cpCabecera`, `paisCabecera`, `numFactura_cabe`) 
                    VALUES ('$nombreCabecera','$cifCabecera','$correoCabecera','$movilCabecera','$telefonoCabecera','$direcCabecera','$cpCabecera','$paisCabecera','$numProforma')";
                    $json_string = json_encode($sql);
            $file = 'u4.json';
            file_put_contents($file, $json_string);
            $sql = $conectar->prepare($sql);
            $sql->execute();
    
            // Obtener la última ID insertada
            $ultima_id = $conectar->lastInsertId();

            // 4. Insertar en factura_pie
            $sql = "INSERT INTO `factura_pie`(`idCabecera_Pie`, `idLlegada_Pie`, `numProformaPie`, `serieProformaPie`, `fechProformaPie`, `agentePie`, `grupoFactPie`, `grupoAmigPie`, `quienFacturaPie`, `estProforma`, `aQuienFactura`, `textoLibreFacturaProforma`) 
                    VALUES ('$ultima_id','$idLlegada','$numProforma','$prefijoFactura','$fechaProforma','$idAgente','$grupoFacturacion','$grupoAmigos','$quienFactura','1','$aQuienFactura', '$conceptoExtra')";
           $json_string = json_encode($sql);
            $file = 'u5.json';
            file_put_contents($file, $json_string);
           $sql = $conectar->prepare($sql);
            $sql->execute();
            
            // 5. Actualizar numFactura en factura_contenido
            $sql = "UPDATE `factura_contenido` SET numFactura = $numProforma WHERE idLlegadaFactura = $idLlegada  AND numFactura IS NULL;";
             $json_string = json_encode($sql);
            $file = 'u6.json';
            file_put_contents($file, $json_string);
            $sql = $conectar->prepare($sql);
            $sql->execute();
           
            // Confirmar transacción
            $conectar->commit();

            return [
            "numProforma" => $numProforma,
            "idLlegada" => $idLlegada
        ];

        } catch (Exception $e) {
            $conectar->rollBack();
            echo "Error al generar la factura: " . $e->getMessage();
        }
      
        

    }
    public function insertarFacturaReal($nombreCabecera, $cifCabecera, $direcCabecera, $movilCabecera, $telefonoCabecera, $cpCabecera, $correoCabecera, $paisCabecera,
        $idLlegada, $numFactura, $serieProforma, $fechaProforma, $idAgente, $grupoAmigos, $grupoFacturacion, $quienFactura, $aQuienFactura, $idDepartamento, $numProforma, $conceptoExtra)
        {
            $conectar = parent::conexion();
            parent::set_names();

        try {
            // Habilitar errores PDO
            $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Iniciar transacción
            $conectar->beginTransaction();

            // 1. Obtener número actual de factura
            $sql = "SELECT numFacturaDepa, prefijoFactDepa FROM tm_departamento_edu WHERE idDepartamentoEdu = $idDepartamento";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resultado) {
                throw new Exception("No se encontró el departamento con ID $idDepartamento");
            }

            $prefijoFactura = $resultado['prefijoFactDepa'];
            $numFacturaActual = (int)$resultado['numFacturaDepa'];
            $numFactura = $numFacturaActual + 1;

            // 2. Actualizar número de factura
            $sql = "UPDATE tm_departamento_edu SET numFacturaDepa = $numFactura WHERE idDepartamentoEdu = $idDepartamento";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            // 3. Insertar cabecera
            $sql = "INSERT INTO factura_cabecera_real (
                        nombreCabecera, cifCabecera, correoCabecera, movilCabecera, tefCabecera,
                        direcCabecera, cpCabecera, paisCabecera, numFactura_cabe
                    ) VALUES (
                        '$nombreCabecera', '$cifCabecera', '$correoCabecera', '$movilCabecera', '$telefonoCabecera',
                        '$direcCabecera', '$cpCabecera', '$paisCabecera', '$numFactura'
                    )";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            $ultima_id = $conectar->lastInsertId(); // idCabecera generado

            // 4. Insertar pie
            $sql = "INSERT INTO factura_pie_real (
                        idCabecera_Pie, idLlegada_Pie, numProformaPie, serieProformaPie, fechProformaPie,
                        agentePie, grupoFactPie, grupoAmigPie, quienFacturaPie, estProforma, aQuienFactura, numFacturaPro, textoLibreFacturaReal
                    ) VALUES (
                        '$ultima_id', '$idLlegada', '$numFactura', '$prefijoFactura', '$fechaProforma',
                        '$idAgente', '$grupoFacturacion', '$grupoAmigos', '$quienFactura', '1', '$aQuienFactura', '$numProforma', '$conceptoExtra'
                    )";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            // 5. Insertar contenidos relacionados
            $sql = "SELECT * FROM factura_contenido WHERE numFactura = '$numProforma'";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datos as $fila) {
                $codigo = $fila['codigoFacturaContenido'];
                $concepto = $fila['conceptoFacturaContenido'];
                $tipo = $fila['tipoFacturaContenido'];
                $iva = $fila['ivaFacturaContenido'];
                $descuento = $fila['descuentoFacturaContenido'];
                $importe = $fila['importeFacturaContenido'];

                // Reasignamos a la nueva factura real
                $idPie = $conectar->lastInsertId(); // también podrías guardarlo antes
                $idCabecera = $ultima_id;
                $idLlegada = $fila['idLlegadaFactura'];
                $numFacturaPro = $fila['numFactura'];

                // Fechas
                $fechaInicio = !empty($fila['fechainicioFacturaContenido']) ? "'" . FechaRemota($fila['fechainicioFacturaContenido']) . "'" : "NULL";
                $fechaFin    = !empty($fila['fechafinFacturaContenido'])    ? "'" . FechaRemota($fila['fechafinFacturaContenido']) . "'" : "NULL";

                $sqlInsert = "
                    INSERT INTO factura_contenido_real (
                        codigoFacturaContenido, conceptoFacturaContenido, tipoFacturaContenido,
                        ivaFacturaContenido, descuentoFacturaContenido, importeFacturaContenido,
                        idPieFacturaContenido, idCabeceraFacturaContenido, idLlegadaFactura,
                        numFactura, fechaInicioFacturaContenido, fechaFinFacturaContenido, numFacturaPro
                    ) VALUES (
                        '$codigo', '$concepto', '$tipo',
                        '$iva', '$descuento', '$importe',
                        '$idPie', '$idCabecera', '$idLlegada',
                        '$numFactura', $fechaInicio, $fechaFin, '$numFacturaPro'
                    )";

                $stmtInsert = $conectar->prepare($sqlInsert);
                $stmtInsert->execute();
            }

            // ✅ Todo correcto → Confirmar cambios
            $conectar->commit();

            return [
                "numFactura" => $numFactura,
                "idLlegada" => $idLlegada
            ];


        } catch (Exception $e) {
            // ❌ Revertir si hay error
            $conectar->rollBack();
            file_put_contents('error_log_factura.json', json_encode([
                'error' => $e->getMessage(),
                'linea' => $e->getLine()
            ]));
            throw $e;
        }
    }
 
    public function recogerFacturasxIdLlegada($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_pie` LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera WHERE factura_pie.idLlegada_Pie = $idLlegada";
    
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
      public function recogerFacturasxIdToken($idToken)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * 
        FROM factura_pie_real
        LEFT JOIN factura_cabecera_real 
            ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera
        LEFT JOIN tm_alumno_edu 
            ON factura_cabecera_real.cifCabecera COLLATE utf8mb3_general_ci 
               = tm_alumno_edu.identificadorPersonal COLLATE utf8mb3_general_ci
        WHERE tokenUsu = '$idToken' 
          AND abonadaFactura IS NULL
        LIMIT 0, 25;";
        $json_string = json_encode($sql);
        $file = 'TYR.json';
        file_put_contents($file, $json_string);
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    // MÉTODO HECHO PARA COMPROBAR AL ENTRAR A FacturaPro_Edu SI HAY ALGUNA FACTURA PROFORMA ACTIVA ACTUALMENTE
    // EN CASO DE HABER ALGUNA FACTURA PROFORMA ACTIVA, SE ANULA PODER CREAR OTRAS HASTA QUE SE ABONE LA FACTURA ACTUAL
    public function comprobarFacturaProExistente($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS total 
                FROM factura_pie 
                LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera
                WHERE factura_pie.idLlegada_Pie = $idLlegada 
                AND factura_pie.estProforma = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();

        return ($resultado[0]['total'] > 0) ? 1 : 0;
    }

    public function recogerFacturasxIdLlegadaReal($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_pie_real` LEFT JOIN factura_cabecera_real ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera WHERE factura_pie_real.idLlegada_Pie = $idLlegada";
    
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    // MÉTODO HECHO PARA COMPROBAR AL ENTRAR A Factura_Edu SI HAY ALGUNA FACTURA REAL ACTIVA ACTUALMENTE
    // EN CASO DE HABER ALGUNA FACTURA REAL ACTIVA, SE ANULA PODER CREAR OTRAS HASTA QUE SE ABONE LA FACTURA ACTUAL
    public function comprobarFacturaRealExistente($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS total 
                FROM factura_pie_real 
                LEFT JOIN factura_cabecera_real 
                ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera 
                WHERE factura_pie_real.idLlegada_Pie = $idLlegada 
                AND factura_pie_real.estProforma = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();

        return ($resultado[0]['total'] > 0) ? 1 : 0;
    }

    // MÉTODO HECHO PARA COMPROBAR AL ENTRAR A Llegadas SI HAY ALGUNA FACTURA REAL O PROFORMA ACTIVA Y SIN ABONAR ACTUALMENTE
    // EN CASO DE HABER ALGUNA FACTURA REAL ACTIVA O PROFORMA ACTIVA Y SIN ABONAR ACTUALMENTE
    // SE BLOQUEA EN LLEGADAS LA MODIFICACIÓN DE LOS SERVICIOS MATRICULACIÓN Y ALOJAMIENTO
    public function comprobarFacturasProformaRealesActivasSinAbonar($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sqlProforma = "SELECT COUNT(*) AS totalProforma
                        FROM factura_pie
                        LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera
                        WHERE factura_pie.idLlegada_Pie = $idLlegada
                        AND factura_pie.estProforma = 1
                        AND factura_pie.abonadaFacturaPro IS NULL";

        $sqlProforma = $conectar->prepare($sqlProforma);
        $sqlProforma->execute();
        $resultadoProforma = $sqlProforma->fetch();

        $sqlReal = "SELECT COUNT(*) AS totalReal
                    FROM factura_pie_real
                    LEFT JOIN factura_cabecera_real ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera
                    WHERE factura_pie_real.idLlegada_Pie = $idLlegada
                    AND factura_pie_real.estProforma = 1
                    AND factura_pie_real.abonadaFactura IS NULL";

        $sqlReal = $conectar->prepare($sqlReal);
        $sqlReal->execute();
        $resultadoReal = $sqlReal->fetch();

        return [
            'factura_proforma' => ($resultadoProforma['totalProforma'] > 0) ? 1 : 0,
            'factura_real' => ($resultadoReal['totalReal'] > 0) ? 1 : 0
        ];

    }

    public function recogerFacturasxIdFactura($idFactura)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_pie` LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera WHERE factura_pie.numProformaPie = $idFactura";
        $json_string = json_encode($sql);
        $file = 'a112.json';
        file_put_contents($file, $json_string);
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     public function recogerFacturasxIdFacturaReal($idFactura)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `factura_pie_real` LEFT JOIN factura_cabecera_real ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera WHERE factura_pie_real.numProformaPie = $idFactura";
        $json_string = json_encode($sql);
        $file = 'A1.json';
        file_put_contents($file, $json_string);
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

     public function abonarFacturaPro($idPie, $motivoAbono,$idDepartamento)
    {
      
        $conectar = parent::conexion();
        parent::set_names();
      
            // 1. Obtener número actual de factura
            $sql = "SELECT numFacturaProNegDepa, prefijoAbonoProEdu FROM tm_departamento_edu WHERE idDepartamentoEdu = $idDepartamento";
              $json_string = json_encode($sql);
        $file = 'Ab.json';
        file_put_contents($file, $json_string);
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resultado) {
                throw new Exception("No se encontró el departamento con ID $idDepartamento");
            }

            $prefijoFactura = $resultado['prefijoAbonoProEdu'];
            $numFacturaActual = (int)$resultado['numFacturaProNegDepa'];
            $numFacturaAbono = $numFacturaActual + 1;

             // 2. Actualizar número de factura
            $sql = "UPDATE tm_departamento_edu SET numFacturaProNegDepa = $numFacturaAbono WHERE idDepartamentoEdu = $idDepartamento";
            $json_string = json_encode($sql);
            $file = 'A234.json';
            file_put_contents($file, $json_string);
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            date_default_timezone_set('Europe/Madrid');
            $fecha = date('Y-m-d H:i:s');

        $sql = "UPDATE `factura_pie` 
        SET `estProforma`='0',`abonadaFacturaPro`='$numFacturaAbono',`abonadaFechaFacturaPro` = '$fecha',abonadaMotivoFacturaPro ='$motivoAbono' WHERE idPie = '$idPie'";
        $json_string = json_encode($sql);
        $file = 'A1Rea3s.json';
        file_put_contents($file, $json_string);
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
  public function abonarFacturaReal($idPie, $motivoAbono,$idDepartamento)
    {
      
        $conectar = parent::conexion();
        parent::set_names();
      
            // 1. Obtener número actual de factura
            $sql = "SELECT numFacturaNegDepa, prefijoAbonoEdu FROM tm_departamento_edu WHERE idDepartamentoEdu = $idDepartamento";
              $json_string = json_encode($sql);
        $file = 'Aabono.json';
        file_put_contents($file, $json_string);
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resultado) {
                throw new Exception("No se encontró el departamento con ID $idDepartamento");
            }

            $prefijoFactura = $resultado['prefijoAbonoEdu'];
            $numFacturaActual = (int)$resultado['numFacturaNegDepa'];
            $numFactura = $numFacturaActual + 1;

             // 2. Actualizar número de factura
            $sql = "UPDATE tm_departamento_edu SET numFacturaNegDepa = $numFactura WHERE idDepartamentoEdu = $idDepartamento";
           
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            date_default_timezone_set('Europe/Madrid');
            $fecha = date('Y-m-d H:i:s');

            $sql = "UPDATE `factura_pie_real` 
            SET `estProforma`='0',`abonadaFactura`='$numFactura',`abonadaFechaFactura` = '$fecha',abonadaMotivoFactura ='$motivoAbono' WHERE idPie = '$idPie'";
            $json_string = json_encode($sql);
            $file = 'Atr2.json';
            file_put_contents($file, $json_string);
        
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
    }
    public function listarProformaFacturacion(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM factura_pie LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera WHERE abonadaFacturaPro IS NULL ORDER BY `idPie` DESC;
";
    
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarProformaAbonoFacturacion(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT factura_pie.*, factura_cabecera.*, tm_departamento_edu.prefijoAbonoProEdu 
                FROM factura_pie 
                LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera 
                LEFT JOIN tm_llegadas_edu ON factura_pie.idLlegada_Pie = tm_llegadas_edu.id_llegada
                LEFT JOIN tm_departamento_edu ON tm_llegadas_edu.iddepartamento_llegadas = tm_departamento_edu.idDepartamentoEdu
                WHERE abonadaFacturaPro IS NOT NULL 
                ORDER BY `factura_pie`.`idPie` DESC";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

   public function listarProformaSinFacturaFacturacion(){
    $conexion = parent::conexion();
    parent::set_names();


    $sql = "SELECT fp.*, fc.* FROM factura_pie fp LEFT JOIN factura_cabecera fc ON fp.idCabecera_Pie = fc.idCabecera LEFT JOIN factura_pie_real fpr ON fpr.numFacturaPro = fp.numProformaPie AND fpr.abonadaFactura IS NULL WHERE fp.abonadaFacturaPro IS NULL AND fpr.numFacturaPro IS NULL ORDER BY `fp`.`idPie` DESC;        -- no hay factura real viva

    ";

    $sql = $conexion->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
}



    public function listarFacturaFacturacion(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT *
                FROM factura_pie_real
                LEFT JOIN factura_cabecera_real ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera
                WHERE abonadaFactura IS NULL
                ORDER BY
                CASE WHEN facturaPagada = 0 OR facturaPagada IS NULL THEN 0 ELSE 1 END ASC,
                CASE WHEN facturaPagada = 0 OR facturaPagada IS NULL THEN fechProformaPie END ASC,
                CASE WHEN facturaPagada = 1 THEN numProformaPie END DESC
                ;";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarFacturaAbonoFacturacion(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT factura_pie_real.*, factura_cabecera_real.*, tm_departamento_edu.prefijoAbonoEdu 
                FROM factura_pie_real 
                LEFT JOIN factura_cabecera_real ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera 
                LEFT JOIN tm_llegadas_edu ON factura_pie_real.idLlegada_Pie = tm_llegadas_edu.id_llegada
                LEFT JOIN tm_departamento_edu ON tm_llegadas_edu.iddepartamento_llegadas = tm_departamento_edu.idDepartamentoEdu
                WHERE abonadaFactura IS NOT NULL 
                ORDER BY `factura_pie_real`.`idPie` DESC";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function desactivarFacturaModelo($idPie)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie_real` SET `facturaPagada` = 0 WHERE `idPie` = $idPie";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function activarFacturaModelo($idPie)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie_real` SET `facturaPagada` = 1 WHERE `idPie` = $idPie";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarFacturaProformaModelo($idPie)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie` SET `facturaPagada` = 0 WHERE `idPie` = $idPie";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
    }

    public function activarFacturaProformaModelo($idPie)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie` SET `facturaPagada` = 1 WHERE `idPie` = $idPie";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function recogerSuplidosXLlegada($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `tm_suplidosLlegadas_edu` WHERE `idsuplido_tmLlegadas` = $idLlegada";
        $json_string = json_encode($sql);
        $file = 'SUPLIDOS.json';
        file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
        public function recogerSuplidosXLlegadaSuma($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT SUM(importeSuplido) AS totalImporte 
        FROM `tm_suplidosLlegadas_edu` 
        WHERE `idsuplido_tmLlegadas` = $idLlegada";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['totalImporte'];

    }


    public function calcularTotalAPagarReal($idFactura, $idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Obtener productos de la factura
        $sqlProd = "SELECT * FROM `factura_contenido_real` WHERE `numFactura` = $idFactura";
        $stmtProd = $conectar->prepare($sqlProd);
        $stmtProd->execute();
        $productos = $stmtProd->fetchAll();

        $totalProductos = 0;

        foreach ($productos as $prod) {
            $importe = floatval(str_replace(',', '.', $prod["importeFacturaContenido"]));
            $iva = floatval($prod["ivaFacturaContenido"]);
            $descuento = floatval($prod["descuentoFacturaContenido"]);

            // Aplicar descuento a base sin IVA
            $importeDescuento = $importe - ($importe * $descuento / 100);

            // Aplicar IVA
            $importeConIva = $importeDescuento + ($importeDescuento * $iva / 100);

            $totalProductos += $importeConIva;
        }

        // Obtener suplidos de la llegada
        $sqlSup = "SELECT * FROM `tm_suplidosLlegadas_edu` WHERE `idsuplido_tmLlegadas` = $idLlegada";
        $stmtSup = $conectar->prepare($sqlSup);
        $stmtSup->execute();
        $suplidos = $stmtSup->fetchAll();

        $totalSuplidos = 0;
        foreach ($suplidos as $s) {
            $totalSuplidos += floatval(str_replace(',', '.', $s["importeSuplido"]));
        }

        // Total final a pagar
        $totalAPagar = $totalProductos + $totalSuplidos;

        return $totalAPagar;
    }

    /* POR LO QUE HE HABLADO CON LUIS, EL TOTAL PAGADO (SUPLIDOS) SE SACA DEL MISMO SITIO, TANTO EN
       FACTURA PROFORMA COMO EN FACTURA REAL */
    public function calcularTotalPagadoRealPro($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT importePagoAnticipado 
                FROM tm_pagoanticipadollegadas_edu 
                WHERE idLlegada_pagoAnticipado = $idLlegada";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $pagos = $stmt->fetchAll();

        $totalPagado = 0;

        foreach ($pagos as $pago) {
            $importe = str_replace(',', '.', $pago["importePagoAnticipado"]);
            $totalPagado += floatval($importe);
        }

        return $totalPagado;
    }

    public function calcularTotalAPagarProforma($idFactura, $idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Obtener productos de la factura (tabla factura_contenido)
        $sqlProd = "SELECT * FROM `factura_contenido` WHERE `numFactura` = $idFactura";
        $stmtProd = $conectar->prepare($sqlProd);
        $stmtProd->execute();
        $productos = $stmtProd->fetchAll();

        $totalProductos = 0;

        foreach ($productos as $prod) {
            $importe = floatval(str_replace(',', '.', $prod["importeFacturaContenido"]));
            $iva = floatval($prod["ivaFacturaContenido"]);
            $descuento = floatval($prod["descuentoFacturaContenido"]);

            // Aplicar descuento a base sin IVA
            $importeDescuento = $importe - ($importe * $descuento / 100);

            // Aplicar IVA
            $importeConIva = $importeDescuento + ($importeDescuento * $iva / 100);

            $totalProductos += $importeConIva;
        }

        // Obtener suplidos de la llegada
        $sqlSup = "SELECT * FROM `tm_suplidosLlegadas_edu` WHERE `idsuplido_tmLlegadas` = $idLlegada";
        $stmtSup = $conectar->prepare($sqlSup);
        $stmtSup->execute();
        $suplidos = $stmtSup->fetchAll();

        $totalSuplidos = 0;
        foreach ($suplidos as $s) {
            $totalSuplidos += floatval(str_replace(',', '.', $s["importeSuplido"]));
        }

        // Total final a pagar
        $totalAPagar = $totalProductos + $totalSuplidos;

        return $totalAPagar;
    }
    public function recogerFacturaRealXIdLlegada($idLlegada)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT *
            FROM factura_pie_real
            LEFT JOIN factura_cabecera_real 
            ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera
            WHERE abonadaFactura IS NULL AND idLlegada_Pie = :idLlegada";

    $stmt = $conectar->prepare($sql);
    $stmt->bindValue(':idLlegada', $idLlegada, PDO::PARAM_INT);
    $stmt->execute();

    $pagos = $stmt->fetchAll();

    // Devolver 1 si encuentra al menos un registro, 0 si no
    return !empty($pagos) ? 1 : 0;
}

    
}

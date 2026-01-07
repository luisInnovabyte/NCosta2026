<?php


class Alojamientos extends Conectar
{

    public function listarAlojamiento()
    {
        $conectar = parent::conexion();
        parent::set_names();

/*         $sql = "SELECT * FROM `rating_alojacompleto`";
 */     

        $sql = "SELECT 
            a.*, 
            t.*, 
            COALESCE(avgOpi.MediaAloja, 0) AS MediaAloja
        FROM tm_aloja a
        LEFT JOIN tm_tiposaloja t 
            ON a.idTipoAloja_TipoAloja = t.idTiposAloja
        LEFT JOIN (
            SELECT 
                idAloja_idOpi, 
                ROUND(AVG(ratingOpi), 1) AS MediaAloja
            FROM tm_alojaopis
            WHERE estOpi = 1  -- opcional: solo opiniones activas
            GROUP BY idAloja_idOpi
        ) AS avgOpi
            ON a.idAloja = avgOpi.idAloja_idOpi;
        ";
 

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarAlojamiento2($idAlumn)
    {
        $conectar = parent::conexion();
        parent::set_names();
        session_start();
        $token = $_SESSION['usu_token'];
        $sql = "SELECT * FROM `td_alumaloja` LEFT JOIN tm_aloja ON td_alumaloja.idAloja_AlumAloja = tm_aloja.idAloja LEFT JOIN tm_tiposaloja ON tm_tiposaloja.idTiposAloja = tm_aloja.idTipoAloja_TipoAloja LEFT JOIN tm_alumno_edu on td_alumaloja.idAlum_AlumAloja = tm_alumno_edu.tokenUsu WHERE `idAlum_AlumAloja` = '$token' AND estAloja = 1 AND td_alumaloja.fecMostrarAlumAloja <= now() ORDER BY `fecMostrarAlumAloja` DESC ";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

      public function listarAlojamientoHistorico($idAlumn)
    {
        $conectar = parent::conexion();
        parent::set_names();
        session_start();
        $token = $_SESSION['usu_token'];
        $sql = "SELECT * FROM `td_alumaloja` 
                LEFT JOIN tm_aloja ON td_alumaloja.idAloja_AlumAloja = tm_aloja.idAloja 
                LEFT JOIN tm_tiposaloja ON tm_tiposaloja.idTiposAloja = tm_aloja.idTipoAloja_TipoAloja 
                LEFT JOIN tm_alumno_edu ON td_alumaloja.idAlum_AlumAloja = tm_alumno_edu.tokenUsu 
                WHERE `idAlum_AlumAloja` = '$token' 
                AND estAloja = 1 
                AND CONCAT(td_alumaloja.fecSalidaAlumAloja, ' ', td_alumaloja.horaSalidaAlumAloja) <= NOW()
                ORDER BY `fecMostrarAlumAloja` DESC";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

public function listarAlumnosPorTokenAlojamiento($tokenAlojamiento)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "
        SELECT 
            td.idAlumAloja, 
            td.fecEntradaAlumAloja,
            td.fecSalidaAlumAloja,
            td.horaSalidaAlumAloja,
            td.estAlumAloja,
            
            tm.token AS tokenAlojamiento,
            CONCAT(tm.nombreAloja, ' ', tm.apeAloja) AS nombreCompletoAlojamiento,

            alu.nomAlumno,
            alu.apeAlumno,
            alu.tokenUsu

        FROM td_alumaloja td
        INNER JOIN tm_aloja tm 
            ON td.idAloja_AlumAloja = tm.idAloja
        LEFT JOIN tm_alumno_edu alu 
            ON td.idAlum_AlumAloja = alu.tokenUsu

        WHERE tm.token = ?
        ORDER BY td.fecEntradaAlumAloja ASC
    ";

    $stmt = $conectar->prepare($sql);
    $stmt->bindValue(1, $tokenAlojamiento);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function listarVisitasAlojamiento($id)
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM tm_alojavis WHERE idAloja_AlojaVi = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Guardar error en un archivo
        $errorData = [
            "error" => $e->getMessage(),
            "code"  => $e->getCode(),
            "time"  => date("Y-m-d H:i:s")
        ];

        file_put_contents("error_db_listar.json", json_encode($errorData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Puedes retornar un array para manejar desde el controlador
        return [
            "success" => false,
            "message" => "Error al listar visitas",
            "details" => $e->getMessage()
        ];
    }
}


    public function listarAlumnosAloja($id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `td_alumaloja`LEFT JOIN tm_aloja ON tm_aloja.idAloja = td_alumaloja.idAloja_AlumAloja LEFT JOIN tm_tiposaloja ON `tm_aloja`.`idTipoAloja_TipoAloja` = `tm_tiposaloja`.`idTiposAloja` LEFT JOIN tm_alumno_edu ON td_alumaloja.idAlum_AlumAloja = tm_alumno_edu.tokenUsu WHERE `idAloja_AlumAloja` = '$id' ORDER BY `estAlumAloja` DESC;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function comprobarEstado($idTipo,$idUsuario,$idAlumAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `albaalumaloja` WHERE `idAloja_AlbaranAlumAloja` = $idTipo AND `idUsuario_AlbaranAlumAloja` = $idUsuario ORDER BY idAlbaranAlumAloja DESC LIMIT 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarAlumnosAlojaxId($id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `totalmentecompletoaloja` WHERE `idAloja_AlumAloja` = '$id' ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
   
    public function listarAlumnosAlojaAlumxId( $idTipoAloja, $idAlum) // LISTAR ALUMNO DE ALOJAX ID  - ALUMNO X ID
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `totalmentecompletoaloja` WHERE `idTipoAloja_TipoAloja` = '$idTipoAloja' and  `idUsuario` = $idAlum";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
  
    public function eliminarVisita($id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = " DELETE FROM `tm_alojavis` WHERE `IdAlojaVis` = $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function eliminarOpi($id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = " DELETE FROM `tm_alojaopis` WHERE `idOpi` = $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function eliminarAlumno($id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = " DELETE FROM `td_alumaloja` WHERE `idAlumAloja` = $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }



    public function activarAlojamiento($idAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_aloja`
         SET `fecModiAloja`= now() ,
         `fecBajaAloja`= null,
         `estAloja`= 1 
         WHERE `idAloja`= $idAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarAlojamiento($idAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_aloja`
        SET `fecModiAloja`= now() ,
        `fecBajaAloja`= now() ,
        `estAloja`= 0 
        WHERE `idAloja`= $idAloja";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    ///////////////////////////////////
    ///////// DATOS ALOJAMIENTO //////////////
    /////////////////////////////////

    public function newToken($idAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $token = $idAloja; //565846
        $idAlojamiento = decryptNumber($idAloja); // 1 - 2 - 3 id
        $sql = "UPDATE `tm_aloja` SET token= $token WHERE idAloja= $idAlojamiento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function comprobarToken($idAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_aloja` WHERE token='$idAloja';";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function getAlojamiento_x_idAlumno($idAloja, $idAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
       
        $sql = "SELECT * FROM `td_alumaloja` LEFT JOIN tm_aloja ON td_alumaloja.idAloja_AlumAloja = tm_aloja.idAloja LEFT JOIN tm_tiposaloja ON tm_tiposaloja.idTiposAloja = tm_aloja.idTipoAloja_TipoAloja LEFT JOIN tm_alumno_edu on td_alumaloja.idAlum_AlumAloja = tm_alumno_edu.tokenUsu 
        WHERE `idAlum_AlumAloja` = '$idAlumno' AND estAloja = 1 AND td_alumaloja.fecMostrarAlumAloja <= now() AND tm_aloja.token = '$idAloja' ORDER BY `fecMostrarAlumAloja` DESC;";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    ////////////////////////////////
    ///////////////////////////////
    //////////////////////////////

    public function insertarVisitas($idAloja_AlojaVi, $quienAlojaVis, $fechaAlojaVis, $descrImpreAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_alojavis`(`idAloja_AlojaVi`, `fechaAlojaVis`, `quienAlojaVis`, `descrImpreAloja`) VALUES ('$idAloja_AlojaVi','$fechaAlojaVis','$quienAlojaVis','$descrImpreAloja')";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function insertarAlojamiento($nombreAloja, $apeAloja, $idTipoAloja_TipoAloja, $emailAloja, $nif, $telAloja, $movilAloja, $dirAloja, $poblaAloja, $proviAloja, $cpAloja, $textDatosPublicAloja, $textDatosPrivateAloja, $metrosAloja, $wcAloja, $interAloja, $fumaAloja, $descrFumaAloja, $HabIndiAloja, $HabDobleAloja, $HabTripleAloja, $comidasAloja, $descrAnimalesAloja, $textCasaAloja, $nomPadreAloja, $nomMadreAloja, $nacPadreAloja, $nacMadreAloja, $profPadreAloja, $profMadreAloja, $descrHijosVivenAloja, $aficAloja, $linkSituacionAloja, $apieAloja, $lineaAutobusAloja, $minAutobusAloja, $lineaMetroAloja, $minMetroAloja, $hospitalPublicAloja, $consultAloja, $hospitalPrivAloja, $pagoAloja, $motvBajaAloja, $estAloja, $tokenAlojamiento,$idAlojamientoTexto)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $nacPadreAloja = empty($nacPadreAloja) ? '1970-01-01' : $nacPadreAloja;
        $nacMadreAloja = empty($nacMadreAloja) ? '1970-01-01' : $nacMadreAloja;

        $sql = "INSERT INTO `tm_aloja`(
            `idTipoAloja_TipoAloja`, `nifAloja`, `apeAloja`, `nombreAloja`, `dirAloja`, `cpAloja`, `poblaAloja`, 
            `proviAloja`, `telAloja`, `movilAloja`, `emailAloja`, `textDatosPublicAloja`, `textDatosPrivateAloja`, 
            `metrosAloja`, `wcAloja`, `HabIndiAloja`, `HabDobleAloja`, `HabTripleAloja`, `interAloja`, `descrAnimalesAloja`, 
            `fumaAloja`, `descrFumaAloja`, `comidasAloja`, `textCasaAloja`, `nomPadreAloja`, `nacPadreAloja`, `profPadreAloja`, 
            `nomMadreAloja`, `nacMadreAloja`, `profMadreAloja`, `descrHijosVivenAloja`, `aficAloja`, `apieAloja`, `lineaAutobusAloja`, 
            `minAutobusAloja`, `lineaMetroAloja`, `minMetroAloja`, `linkSituacionAloja`, `hospitalPrivAloja`, `consultAloja`, 
            `hospitalPublicAloja`, `pagoAloja`, `estAloja`, `motvBajaAloja`, `fecAltaAloja`, `token`, `idAlojamientoTexto`
        ) VALUES (
            '$idTipoAloja_TipoAloja', '$nif', '$apeAloja', '$nombreAloja', '$dirAloja', '$cpAloja', '$poblaAloja', 
            '$proviAloja', '$telAloja', '$movilAloja', '$emailAloja', '$textDatosPublicAloja', '$textDatosPrivateAloja', 
            '$metrosAloja', '$wcAloja', '$HabIndiAloja', '$HabDobleAloja', '$HabTripleAloja', '$interAloja', '$descrAnimalesAloja', 
            '$fumaAloja', '$descrFumaAloja', '$comidasAloja', '$textCasaAloja', '$nomPadreAloja', '$nacPadreAloja', '$profPadreAloja', 
            '$nomMadreAloja', '$nacMadreAloja', '$profMadreAloja', '$descrHijosVivenAloja', '$aficAloja', '$apieAloja', '$lineaAutobusAloja', 
            '$minAutobusAloja', '$lineaMetroAloja', '$minMetroAloja', '$linkSituacionAloja', '$hospitalPrivAloja', '$consultAloja', 
            '$hospitalPublicAloja', '$pagoAloja', '$estAloja', '$motvBajaAloja', NOW(), '$tokenAlojamiento', '$idAlojamientoTexto')";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();

    }

    public function editarAlojamientoAdmin($idAloja, $nombreAloja, $apeAloja, $idTipoAloja_TipoAloja, $emailAloja, $nif, $telAloja, $movilAloja, $dirAloja, $poblaAloja, $proviAloja, $cpAloja, $textDatosPublicAloja, $textDatosPrivateAloja, $metrosAloja, $wcAloja, $interAloja, $fumaAloja, $descrFumaAloja, $HabIndiAloja, $HabDobleAloja, $HabTripleAloja, $comidasAloja, $descrAnimalesAloja, $textCasaAloja, $nomPadreAloja, $nomMadreAloja, $nacPadreAloja, $nacMadreAloja, $profPadreAloja, $profMadreAloja, $descrHijosVivenAloja, $aficAloja, $linkSituacionAloja, $apieAloja, $lineaAutobusAloja, $minAutobusAloja, $lineaMetroAloja, $minMetroAloja, $hospitalPublicAloja, $consultAloja, $hospitalPrivAloja, $pagoAloja, $motvBajaAloja, $estAloja, $idAlojamientoTexto)
    {
        $conectar = parent::conexion();
        parent::set_names();

       $sql = "UPDATE `tm_aloja` SET 
            `nombreAloja` = '$nombreAloja',
            `apeAloja` = '$apeAloja',
            `idTipoAloja_TipoAloja` = '$idTipoAloja_TipoAloja',
            `emailAloja` = '$emailAloja',
            `nifAloja` = '$nif',
            `telAloja` = '$telAloja',
            `movilAloja` = '$movilAloja',
            `dirAloja` = '$dirAloja',
            `poblaAloja` = '$poblaAloja',
            `proviAloja` = '$proviAloja',
            `cpAloja` = '$cpAloja',
            `textDatosPublicAloja` = '$textDatosPublicAloja',
            `textDatosPrivateAloja` = '$textDatosPrivateAloja',
            `metrosAloja` = '$metrosAloja',
            `wcAloja` = '$wcAloja',
            `HabIndiAloja` = '$HabIndiAloja',
            `HabDobleAloja` = '$HabDobleAloja',
            `HabTripleAloja` = '$HabTripleAloja',
            `interAloja` = '$interAloja',
            `descrAnimalesAloja` = '$descrAnimalesAloja',
            `fumaAloja` = '$fumaAloja',
            `descrFumaAloja` = '$descrFumaAloja',
            `comidasAloja` = '$comidasAloja',
            `textCasaAloja` = '$textCasaAloja',
            `nomPadreAloja` = '$nomPadreAloja',
            `nacPadreAloja` = '$nacPadreAloja',
            `profPadreAloja` = '$profPadreAloja',
            `nomMadreAloja` = '$nomMadreAloja',
            `nacMadreAloja` = '$nacMadreAloja',
            `profMadreAloja` = '$profMadreAloja',
            `descrHijosVivenAloja` = '$descrHijosVivenAloja',
            `aficAloja` = '$aficAloja',
            `linkSituacionAloja` = '$linkSituacionAloja',
            `apieAloja` = '$apieAloja',
            `lineaAutobusAloja` = '$lineaAutobusAloja',
            `minAutobusAloja` = '$minAutobusAloja',
            `lineaMetroAloja` = '$lineaMetroAloja',
            `minMetroAloja` = '$minMetroAloja',
            `hospitalPublicAloja` = '$hospitalPublicAloja',
            `consultAloja` = '$consultAloja',
            `hospitalPrivAloja` = '$hospitalPrivAloja',
            `pagoAloja` = '$pagoAloja',
            `motvBajaAloja` = '$motvBajaAloja',
            `estAloja` = '$estAloja',
            `fecModiAloja` = NOW(),
            `idAlojamientoTexto` = '$idAlojamientoTexto'
        WHERE `token` = '$idAloja'";
         $json_string = json_encode($sql);
         $file = 'EDITALOJA1.json';
         file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function editarAlojamientoNOAdmin($idAloja, $nombreAloja, $apeAloja, $idTipoAloja_TipoAloja, $emailAloja, $nif, $telAloja, $movilAloja, $dirAloja, $poblaAloja, $proviAloja, $cpAloja, $textDatosPublicAloja, $textDatosPrivateAloja, $metrosAloja, $wcAloja, $interAloja, $fumaAloja, $descrFumaAloja, $HabIndiAloja, $HabDobleAloja, $HabTripleAloja, $comidasAloja, $descrAnimalesAloja, $textCasaAloja, $nomPadreAloja, $nomMadreAloja, $nacPadreAloja, $nacMadreAloja, $profPadreAloja, $profMadreAloja, $descrHijosVivenAloja, $aficAloja, $linkSituacionAloja, $apieAloja, $lineaAutobusAloja, $minAutobusAloja, $lineaMetroAloja, $minMetroAloja)
    {

       $nacPadreAloja = empty($nacPadreAloja) ? '1970-01-01' : $nacPadreAloja;
       $nacMadreAloja = empty($nacMadreAloja) ? '1970-01-01' : $nacMadreAloja;
        $metrosAloja = empty($metrosAloja) ? 0 : $metrosAloja; //SI ESTA VACIO PONER 0
        $wcAloja = empty($wcAloja) ? 0 : $wcAloja; //SI ESTA VACIO PONER 0
        $HabIndiAloja = empty($HabIndiAloja) ? 0 : $HabIndiAloja; //SI ESTA VACIO PONER 0
        $HabDobleAloja = empty($HabDobleAloja) ? 0 : $HabDobleAloja; //SI ESTA VACIO PONER 0
        $HabTripleAloja = empty($HabTripleAloja) ? 0 : $HabTripleAloja; //SI ESTA VACIO PONER 0
        $interAloja = empty($interAloja) ? 0 : $interAloja; //SI ESTA VACIO PONER 0
        $fumaAloja = empty($fumaAloja) ? 0 : $fumaAloja; //SI ESTA VACIO PONER 0
        $apieAloja = empty($apieAloja) ? 0 : $apieAloja; //SI ESTA VACIO PONER 0
        $minAutobusAloja = empty($minAutobusAloja) ? 0 : $minAutobusAloja; //SI ESTA VACIO PONER 0
        $lineaMetroAloja = empty($lineaMetroAloja) ? 0 : $lineaMetroAloja; //SI ESTA VACIO PONER 0
        $minMetroAloja = empty($minMetroAloja) ? 0 : $minMetroAloja; //SI ESTA VACIO PONER 0

        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "UPDATE `tm_aloja` SET `nombreAloja`='$nombreAloja', `apeAloja`='$apeAloja', 
        `idTipoAloja_TipoAloja`='$idTipoAloja_TipoAloja', 
        `emailAloja`='$emailAloja', `nifAloja`='$nif', `telAloja`='$telAloja', 
        `movilAloja`='$movilAloja', `dirAloja`='$dirAloja', `poblaAloja`='$poblaAloja',
        `proviAloja`='$proviAloja', `cpAloja`='$cpAloja', `textDatosPublicAloja`='$textDatosPublicAloja',
        `textDatosPrivateAloja`='$textDatosPrivateAloja', `metrosAloja`=$metrosAloja, `wcAloja`='$wcAloja', 
        `HabIndiAloja`='$HabIndiAloja', `HabDobleAloja`='$HabDobleAloja', `HabTripleAloja`='$HabTripleAloja', 
        `interAloja`='$interAloja', `descrAnimalesAloja`='$descrAnimalesAloja', `fumaAloja`='$fumaAloja', 
        `descrFumaAloja`='$descrFumaAloja', `comidasAloja`='$comidasAloja', `textCasaAloja`='$textCasaAloja', 
        `nomPadreAloja`='$nomPadreAloja', `nacPadreAloja`='$nacPadreAloja', `profPadreAloja`='$profPadreAloja', 
        `nomMadreAloja`='$nomMadreAloja', `nacMadreAloja`='$nacMadreAloja', `profMadreAloja`='$profMadreAloja', 
        `descrHijosVivenAloja`='$descrHijosVivenAloja' , `aficAloja`='$aficAloja' , `linkSituacionAloja`='$linkSituacionAloja' ,
        `apieAloja`='$apieAloja' , `lineaAutobusAloja`='$lineaAutobusAloja' , `minAutobusAloja`='$minAutobusAloja' , 
        `lineaMetroAloja`='$lineaMetroAloja' , `minMetroAloja`='$minMetroAloja' , `fecModiAloja`=NOW()  WHERE `token`='$idAloja'";

        $sql = $conectar->prepare($sql);
        $sql->execute();

      

    }
    public function getAlojamiento_x_id($idAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_aloja` LEFT JOIN tm_tiposaloja ON `tm_aloja`.`idTipoAloja_TipoAloja` = `tm_tiposaloja`.`idTiposAloja` WHERE idAloja = '$idAloja'";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function getAlojamiento_x_token($idAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_aloja` LEFT JOIN tm_tiposaloja ON `tm_aloja`.`idTipoAloja_TipoAloja` = `tm_tiposaloja`.`idTiposAloja` WHERE token = '$idAloja'";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarUsuariosFiltrado($id)
    {
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `td_alumaloja`LEFT JOIN tm_aloja ON tm_aloja.idAloja = td_alumaloja.idAloja_AlumAloja LEFT JOIN tm_tiposaloja ON `tm_aloja`.`idTipoAloja_TipoAloja` = `tm_tiposaloja`.`idTiposAloja` LEFT JOIN tm_alumno_edu ON td_alumaloja.idAlum_AlumAloja = tm_alumno_edu.tokenUsu WHERE `idAloja_AlumAloja` = '$id' ORDER BY `estAlumAloja` DESC;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarUsuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_usuario`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarAlumnos($idAlumno, $idAloja, $fecEntradaAlumAloja, $fecSalidaAlumAloja, $horaSalidaAlumAloja, $fechaMuestra, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        if ($estado == 1) {
            $fechaMuestra = 'CURDATE()';
        } else {
            $fechaMuestra = "'$fechaMuestra'";
        }
        $sql = "INSERT INTO `td_alumaloja`(`idAlum_AlumAloja`, `idAloja_AlumAloja`, `fecEntradaAlumAloja`,`fecSalidaAlumAloja`,`horaSalidaAlumAloja`, `estAlumAloja`, `fecMostrarAlumAloja`, `estMostrarAlumAloja` ) VALUES ('$idAlumno', '$idAloja', '$fecEntradaAlumAloja', '$fecSalidaAlumAloja', '$horaSalidaAlumAloja', '1', $fechaMuestra, '$estado' );";
     
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function getopi($idAloja, $idUsu)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sqlDatos = "SELECT * FROM tm_alojaopis WHERE idUsu_IdOpi = $idUsu AND IdAloja_idOpi = $idAloja;";
     
        $sqlDatos = $conectar->prepare($sqlDatos);
        $sqlDatos->execute();
        $resultado = $sqlDatos->fetchAll();

        return $resultado;
    }


    public function comprobarOpisAloja($idUsu_IdOpi, $IdAloja_idOpi, $score, $descrOpi, $fechaOpi)
    {
        $conectar = parent::conexion();
        parent::set_names();

        /* $sqlComprobar = "SELECT CASE WHEN descrOpi = '' THEN 'false' ELSE 'true' END AS estado_descrOpi FROM tm_alojaopis WHERE idUsu_IdOpi = $idUsu_IdOpi AND IdAloja_idOpi = $IdAloja_idOpi;"; */
        $sqlComprobar = "SELECT * FROM tm_alojaopis WHERE idUsu_IdOpi = $idUsu_IdOpi AND IdAloja_idOpi = $IdAloja_idOpi;";
  
        $sqlComprobar = $conectar->prepare($sqlComprobar);
        $sqlComprobar->execute();

        $resultado = $sqlComprobar->fetchAll();
        if (empty($resultado)) {
            $sql = "INSERT INTO `tm_alojaopis`(`idUsu_IdOpi`, `IdAloja_idOpi`,`ratingOpi`, `descrOpi`, `fechaOpi`) VALUES ('$idUsu_IdOpi','$IdAloja_idOpi','$score','$descrOpi','$fechaOpi')";

            $sql = $conectar->prepare($sql);
            $sql->execute();
        } else {
            $idAlumn = $resultado[0][1];
            $idAloja = $resultado[0][2];
            $sqlDatos = "SELECT * FROM tm_alojaopis WHERE idUsu_IdOpi = $idAlumn AND IdAloja_idOpi = $idAloja;";
            $sqlDatos = $conectar->prepare($sqlDatos);
            $sqlDatos->execute();

            $sql = "UPDATE `tm_alojaopis` SET `ratingOpi`='$score',`descrOpi`='$descrOpi',`fechaOpi`='$fechaOpi' WHERE `idUsu_IdOpi` = '$idAlumn' AND IdAloja_idOpi = '$idAloja'";
            $sql = $conectar->prepare($sql);
            $sql->execute();
        }
    }

    public function listarOpisAloja($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_alojaopis` LEFT JOIN tm_alumno_edu ON tm_alojaopis.idUsu_IdOpi = tm_alumno_edu.idAlumno  WHERE IdAloja_idOpi = $id";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function getVisita_x_id($idVis)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT * FROM `tm_alojavis` WHERE IdAlojaVis = ?";
    $stmt = $conectar->prepare($sql);
    $stmt->execute([$idVis]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function editarVisita($idVis, $quienAlojaVis, $fechaAlojaVis, $descrImpreAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_alojavis` SET `fechaAlojaVis`='$fechaAlojaVis',`quienAlojaVis`='$quienAlojaVis',`descrImpreAloja`='$descrImpreAloja' WHERE `IdAlojaVis` = '$idVis'";

        $sql = $conectar->prepare($sql);

        $sql->execute();
    }

    public function activarOpi($idOpi)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_alojaopis`
         SET `estOpi`= 1 
         WHERE `idOpi`= $idOpi";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarOpi($idOpi)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_alojaopis`
        SET `estOpi`= 0 
        WHERE `idOpi`= $idOpi";


        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function get_Opi_x_id($idOpi)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_alojaopis` WHERE idOpi = $idOpi";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarOpi($idOpi, $rating, $descrImpreAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_alojaopis` SET 
        `ratingOpi` = '$rating',
        `descrOpi` = '$descrImpreAloja'
        WHERE `idOpi` = '$idOpi'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_AlumnAloja_x_id($idAlumAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `td_alumaloja` LEFT JOIN tm_alumno_edu ON td_alumaloja.idAlum_AlumAloja = tm_alumno_edu.tokenUsu WHERE idAlumAloja = $idAlumAloja";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarAlumnAloja($idAlumAloja, $fechamuestra, $fechaentrada, $fechasalida, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `td_alumaloja` SET 
        `fecMostrarAlumAloja` = '$fechamuestra',
        `fecEntradaAlumAloja` = '$fechaentrada',
        `fecSalidaAlumAloja` = '$fechasalida',
        `estMostrarAlumAloja` = '$estado'
        WHERE `idAlumAloja` = '$idAlumAloja'";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        // SI FECHA DE MUESTRA == FECHA ACTUAL: FECHA MUESTRA (TRUE) //
        date_default_timezone_set('Europe/Madrid');
        $fechaActual = date('Y-m-d');
        if($fechamuestra == $fechaActual || $estado == 1){

            $sql = "UPDATE `td_alumaloja` SET `fecMostrarAlumAloja` = now(),`estMostrarAlumAloja` = '1' WHERE `idAlumAloja` = '$idAlumAloja'";
            $sql = $conectar->prepare($sql);
            $sql->execute();
        }
    }
    // select add alumno //
    
    public function comprobarAlumnoSelect($idAlumno, $idAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM td_alumaloja WHERE idAlum_AlumAloja = $idAlumno AND idAloja_AlumAloja = $idAloja;";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    public function activarAlumnAloja($idAlumnAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `td_alumaloja`
         SET `estAlumAloja`= 1 
         WHERE `idAlumAloja`= $idAlumnAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarAlumnAloja($idAlumnAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `td_alumaloja`
        SET `estAlumAloja`= 0 
        WHERE `idAlumAloja`= $idAlumnAloja";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function obtenerHistorial($idAlumAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `totalmentecompletoaloja` WHERE idAlum_AlumAloja = $idAlumAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function consultarOpinionxId($idUsuario, $idAlojamiento)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT ratingOpi FROM tm_alojaopis WHERE idUsu_IdOpi = $idUsuario AND IdAloja_idOpi = $idAlojamiento;";
 


        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_COLUMN);
        return $resultado;
    }
    public function listarMediosPago()
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "SELECT * FROM `tm_mediopago` ";

    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }

    public function listarAlumnosAlojaTarifa()
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "SELECT tm_llegadas_edu.id_llegada, tm_llegadas_edu.grupoAmigos, tm_llegadas_edu.nivelasignado_llegadas, tm_prescriptores.nomPrescripcion, tm_prescriptores.apePrescripcion, tm_prescriptores.tokenPrescriptores, ruta_completo.codIdioma, ruta_completo.codTipo, ruta_completo.codNivel, tm_alojamientosllegadas_edu.nombreTarifa_alojamientos, MAX(tm_alojamientosllegadas_edu.fechaFinAlojamientos) AS fechaFinAlojamientos, MIN(tm_alojamientosllegadas_edu.fechaInicioAlojamientos) AS fechaInicioAlojamientos FROM tm_llegadas_edu LEFT JOIN tm_prescriptores ON tm_llegadas_edu.idprescriptor_llegadas = tm_prescriptores.idPrescripcion LEFT JOIN ruta_completo ON ruta_completo.id_ruta = tm_llegadas_edu.nivelasignado_llegadas LEFT JOIN tm_alojamientosllegadas_edu ON tm_llegadas_edu.id_llegada = tm_alojamientosllegadas_edu.idLlegada_alojamientos WHERE estAlojamiento IN (1, 2) GROUP BY tm_llegadas_edu.id_llegada, tm_alojamientosllegadas_edu.nombreTarifa_alojamientos;";


    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }


   
    
}

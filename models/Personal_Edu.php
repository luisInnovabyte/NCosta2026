<?php

class Personal extends Conectar
{

    public function listarPersonal()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_personal WHERE estPersonal = 1  ORDER BY rolUsuario DESC ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cargarRutasPersonal($idPersonal)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT rutasPersonal.*, tm_personal.*, tm_idioma.*, tm_tipocurso.*, tm_nivelDesde.codNivel AS codNivelDesde, tm_nivelDesde.descrNivel AS descrNivelDesde, tm_nivelHasta.codNivel AS codNivelHasta, tm_nivelHasta.descrNivel AS descrNivelHasta FROM rutasPersonal LEFT JOIN tm_personal ON rutasPersonal.id_personalRPersonal = tm_personal.idPersonal LEFT JOIN tm_idioma ON rutasPersonal.idIdioma_RPersonal = tm_idioma.idIdioma LEFT JOIN tm_tipocurso ON rutasPersonal.idtipo_RPersonal = tm_tipocurso.idTipo LEFT JOIN tm_nivel AS tm_nivelDesde ON rutasPersonal.nivelDesde_RPersonal = tm_nivelDesde.idNivel LEFT JOIN tm_nivel AS tm_nivelHasta ON rutasPersonal.nivelHasta_RPersonal = tm_nivelHasta.idNivel WHERE id_personalRPersonal = $idPersonal;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function listarPersonalTodos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_personal ORDER BY rolUsuario DESC ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function depaPersonalxId($idPersonal)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT d.idDepartamentoEdu, d.nombreDepartamento, d.colorDepartamento FROM tm_departamento_edu d JOIN tm_personal p ON FIND_IN_SET(d.idDepartamentoEdu, p.departamentosPersonal) WHERE p.idPersonal = $idPersonal AND d.estDepa = 1;";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
        return $resultado = $sql->fetchAll();
    }
    
    public function get_ruta_x_perso($idProfesorado,$selectCurso,$selectIdioma)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `rutasPersonal` WHERE id_personalRPersonal = '$idProfesorado' AND idIdioma_RPersonal ='$selectIdioma' AND idtipo_RPersonal = '$selectCurso'";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarPersonalCurso($idProfesorado,$selectCurso,$selectIdioma,$nivelDesdeSelect,$nivelHastaSelect)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `rutasPersonal` (`id_personalRPersonal`, `idIdioma_RPersonal`, `idtipo_RPersonal`, `nivelDesde_RPersonal`, `nivelHasta_RPersonal`) VALUES ('$idProfesorado','$selectIdioma','$selectCurso','$nivelDesdeSelect','$nivelHastaSelect')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function recogerDepaHomexId($llegadaSelect)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_llegadas_edu LEFT JOIN tm_departamento_edu ON tm_llegadas_edu.iddepartamento_llegadas = tm_departamento_edu.idDepartamentoEdu WHERE `id_llegada` = $llegadaSelect ";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarPersonal($nomPersonal, $apePersonal, $usuPersonal, $senaPersonal, $dirPersonal, $poblaPersonal, $cpPersonal, $provPersonal, $paisPersonal, $tlfPersonal, $movilPersonal, $emailPersonal, $rolUsu, $estadoUsu, $departamentosUsu, $tokenPersonal)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "INSERT INTO `tm_personal`(`nomPersonal`, `emailUsuario`, `senaUsuario`, `apePersonal`, `dirPersonal`, `poblaPersonal`, `cpPersonal`, `provPersonal`, `paisPersonal`, `tlfPersonal`, `movilPersonal`, `emailPersonal`, `fecAltaPersonal`, `fecBajaPersonal`, `fecModiPersonal`, `rolUsuario`, `estPersonal`, `tokenPers`, `departamentosPersonal`,`idUsuario_tmpersonal`) VALUES 
        ('$nomPersonal', '$usuPersonal', MD5('ProfeCosta12$@'), '$apePersonal', '$dirPersonal', '$poblaPersonal', '$cpPersonal', '$provPersonal', '$paisPersonal', '$tlfPersonal', '$movilPersonal', '$usuPersonal', CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'), NULL, NULL, '$rolUsu', '$estadoUsu', '$tokenPersonal', '$departamentosUsu',null);";
     
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $lastInsertIdPersonal = $conectar->lastInsertId();

        if($lastInsertIdPersonal != ''){

            $sql = "INSERT INTO `tm_usuario`(`nickUsu`, `correoUsu`, `senaUsu`, `rolUsu`, `estUsu`, `obsUsu`, `avatarUsu`, `generoUsu`, `fecAltaUsu`, `fecBajaUsu`, `fecModiUsu`, `motivoBajaUsu`, `nombreUsu`, `apellidosUsu`, `fechaNacimientoUsu`, `telefonoUsu`, `movilUsu`, `razonSocialFacturacionUsu`, `identificacionFiscalUsu`, `direccionFacturacionUsu`, `codigoPostalUsu`, `provinciaUsu`, `ciudadPuebloUsu`, `paisUsu`, `personalizacionUsu`, `idiomaUsu`, `recibirNotificacionesUsu`, `registroInicioSesionUsu`, `accesoPrivadoUsu`, `ipUsu`, `tokenUsu`, `registroUsu`, `uuidUsu`, `idSoporte_tmUsuario`, `idTransportista_transportistas-Transporte`, `idAlumno_tmusuario`, `idInscripcion_tmusuario`) VALUES 
            ('$nomPersonal','$usuPersonal',MD5('ProfeCosta12$@'),'$rolUsu','$estadoUsu','Creado desde nuevo personal','profesorAvatar.png','x',CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),null,null,null,'$nomPersonal','$apePersonal','2020-10-10','$tlfPersonal','MOVIL',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$tokenPersonal',NULL,NULL,NULL,NULL,NULL,$lastInsertIdPersonal)";

            $sql = $conectar->prepare($sql);
            $sql->execute();
            $resultado = $sql->fetchAll();
        }
        // Ahora que el nickname es único, puedes proceder con la inserción
   
        // Obtener el último ID insertado
    }
    
    public function get_personal_x_id($idPersonal)
    {
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_personal` WHERE idPersonal = $idPersonal";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarPersonal($idPersonal, $nomPersonal, $apePersonal, $usuPersonal, $senPersonal,  $dirPersonal, $poblaPersonal, $cpPersonal, $provPersonal, $paisPersonal, $tlfPersonal, $movilPersonal, $emailPersonal, $rolUsuario, $estUsu, $departamentos)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_personal`
        SET `fecModiPersonal`= now(), 
            `nomPersonal`= '$nomPersonal', 
            `apePersonal`= '$apePersonal', 
            `emailUsuario` = '$usuPersonal',
            `dirPersonal`= '$dirPersonal', 
         `poblaPersonal`= '$poblaPersonal', 
         `cpPersonal`= '$cpPersonal', 
         `provPersonal`= '$provPersonal', 
         `paisPersonal`= '$paisPersonal', 
         `tlfPersonal`= '$tlfPersonal', 
         `movilPersonal`= '$movilPersonal', 
         `emailPersonal`= '$emailPersonal', 
         `rolUsuario` = '$rolUsuario', 
         `estPersonal` = '$estUsu',
         `departamentosPersonal` = '$departamentos' WHERE `idPersonal`= $idPersonal";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        $sql = "
        UPDATE `tm_usuario`
        SET 
            `nickUsu`= '$usuPersonal', 
            `correoUsu`= '$usuPersonal', 
            `nombreUsu`= '$nomPersonal',
            `apellidosUsu`= '$apePersonal',  
            `estUsu`= '$estUsu' WHERE `idInscripcion_tmusuario` = $idPersonal";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "
        UPDATE `tm_usuario`
        SET 
            `estUsu` = NOT `estUsu`,
            `fecModiUsu` = now(),
            `fecBajaUsu` = IF(`estUsu` = 1, NULL, now())
        WHERE `idInscripcion_tmusuario` = $idElemento;
    ";        

        $sql = $conectar->prepare($sql);
        $sql->execute();

        $sql = "
        UPDATE `tm_personal`
        SET 
            `estPersonal` = NOT `estPersonal`,
            `fecModiPersonal` = now(),
            `fecBajaPersonal` = IF(`estPersonal` = 1, NULL, now())
        WHERE `idPersonal` = $idElemento;
    ";        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function activarPersonal($idPersonal)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_personal`
         SET `fecModiPersonal`= now() ,
         `fecBajaPersonal`= null,
         `estPersonal`= 1 
         WHERE `idPersonal`= $idPersonal";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarPersonal($idPersonal)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_personal`
        SET `fecModiPersonal`= now() ,
        `fecBajaPersonal`= now() ,
        `estPersonal`= 0 
        WHERE `idPersonal`= $idPersonal";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function listarImagenesPersonal($idPersonal)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `imagenes_personal` WHERE `idPersonal` = $idPersonal AND imgPersoImg IS NOT NULL";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    public function insertarDocumentoPersonal($idPersonal, $descrPersoImg, $nomImg)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "INSERT INTO `tm_persoimg`(`idPersonal_PersoImg`, `descrPersoImg`, `imgPersoImg`, `fecAltaPersoImg`) VALUES ('$idPersonal','$descrPersoImg','$nomImg', NOW())";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function eliminarDocumentoPersonal($idPersoImg)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "DELETE FROM `tm_persoimg` WHERE `idPersoImg` = '$idPersoImg'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function getDocumento_x_id($idVis)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_alojavis`  WHERE IdAlojaVis = $idVis";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarDocumento($idVis, $quienAlojaVis, $fechaAlojaVis, $descrImpreAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_alojavis` SET `fechaAlojaVis`='$fechaAlojaVis',`quienAlojaVis`='$quienAlojaVis',`descrImpreAloja`='$descrImpreAloja' WHERE `IdAlojaVis` = '$idVis'";

        $sql = $conectar->prepare($sql);

        $sql->execute();
    }
    public function eliminarRuta($idRutaPersonal)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "DELETE FROM `rutasPersonal` WHERE `idRutasProfesorado` = '$idRutaPersonal'";

        $sql = $conectar->prepare($sql);

        $sql->execute();
    }
    
    public function recogerNivelHasta($nivelDesde,$selectIdiomaModal,$selectCursoModal)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `ruta_completo`  WHERE `idiomaId_ruta` = $selectIdiomaModal  AND `tipoId_ruta` = $selectCursoModal AND `pesoRuta` >= (SELECT pesoRuta FROM ruta_completo WHERE nivelId_ruta = $nivelDesde LIMIT 1);";

        $sql = $conectar->prepare($sql);

        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    public function recogerNivelDesde($selectIdiomaModal,$selectCursoModal)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `ruta_completo`  WHERE `idiomaId_ruta` = $selectIdiomaModal  AND `tipoId_ruta` = $selectCursoModal";

        $sql = $conectar->prepare($sql);

        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    
}

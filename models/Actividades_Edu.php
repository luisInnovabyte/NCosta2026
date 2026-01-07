<?php

class Actividades extends Conectar
{

///////////////////////////
// VISTA DE ACTIVIDADESCOMPLETO ANTIGUA
//////////////////////////

/* 
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = newcosta@localhost 
    SQL SECURITY DEFINER
VIEW actividadescompleto AS
    SELECT 
        tm_actividad_edu.idAct AS idAct,
        tm_actividad_edu.descrAct AS descrAct,
        tm_actividad_edu.obsAct AS obsAct,
        tm_actividad_edu.fecActDesde AS fecActDesde,
        tm_actividad_edu.fecActHasta AS fecActHasta,
        tm_actividad_edu.fecActFinSolicitud AS fecActFinSolicitud,
        tm_actividad_edu.estadoAct AS estadoAct,
        tm_actividad_edu.horaInicioAct AS horaInicioAct,
        tm_actividad_edu.horaFinAct AS horaFinAct,
        tm_actividad_edu.horasLectivasAct AS horasLectivasAct,
        tm_actividad_edu.minAlumAct AS minAlumAct,
        tm_actividad_edu.maxAlumAct AS maxAlumAct,
        tm_actividad_edu.departamentoDisponible AS departamentoDisponible,
        tm_actividad_edu.imgAct AS imgAct,
        tm_actividad_edu.fecAltaAct AS fecAltaAct,
        tm_actividad_edu.fecBajaAct AS fecBajaAct,
        tm_actividad_edu.fecModiAct AS fecModiAct,
        tm_actividad_edu.puntoEncuentroAct AS puntoEncuentroAct,
        tm_actividad_edu.idPersonal_guiaAct AS idPersonal_guiaAct,
        tm_personal.idPersonal AS idPersonal,
        tm_personal.nomPersonal AS nomPersonal,
        tm_personal.apePersonal AS apePersonal,
        tm_personal.dirPersonal AS dirPersonal,
        tm_personal.poblaPersonal AS poblaPersonal,
        tm_personal.cpPersonal AS cpPersonal,
        tm_personal.provPersonal AS provPersonal,
        tm_personal.paisPersonal AS paisPersonal,
        tm_personal.tlfPersonal AS tlfPersonal,
        tm_personal.movilPersonal AS movilPersonal,
        tm_personal.emailPersonal AS emailPersonal,
        tm_personal.fecAltaPersonal AS fecAltaPersonal,
        tm_personal.fecBajaPersonal AS fecBajaPersonal,
        tm_personal.fecModiPersonal AS fecModiPersonal,
        tm_personal.estPersonal AS estPersonal
    FROM
        (tm_actividad_edu
        LEFT JOIN tm_personal ON ((tm_actividad_edu.idPersonal_guiaAct = tm_personal.idPersonal)))
*/

///////////////////////////
// VISTA DE ACTIVIDADESCOMPLETO NUEVA
//////////////////////////

/* 
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `newcosta`@`localhost` 
    SQL SECURITY DEFINER
VIEW `actividadescompleto` AS
    SELECT 
        `tm_actividad_edu`.`idAct` AS `idAct`,
        `tm_actividad_edu`.`descrAct` AS `descrAct`,
        `tm_actividad_edu`.`obsAct` AS `obsAct`,
        `tm_actividad_edu`.`fecActDesde` AS `fecActDesde`,
        `tm_actividad_edu`.`fecActHasta` AS `fecActHasta`,
        `tm_actividad_edu`.`fecActFinSolicitud` AS `fecActFinSolicitud`,
        `tm_actividad_edu`.`estadoAct` AS `estadoAct`,
        `tm_actividad_edu`.`horaInicioAct` AS `horaInicioAct`,
        `tm_actividad_edu`.`horaFinAct` AS `horaFinAct`,
        `tm_actividad_edu`.`horasLectivasAct` AS `horasLectivasAct`,
        `tm_actividad_edu`.`minAlumAct` AS `minAlumAct`,
        `tm_actividad_edu`.`maxAlumAct` AS `maxAlumAct`,
        `tm_actividad_edu`.`departamentoDisponible` AS `departamentoDisponible`,
        `tm_actividad_edu`.`imgAct` AS `imgAct`,
        `tm_actividad_edu`.`fecAltaAct` AS `fecAltaAct`,
        `tm_actividad_edu`.`fecBajaAct` AS `fecBajaAct`,
        `tm_actividad_edu`.`fecModiAct` AS `fecModiAct`,
        `tm_actividad_edu`.`puntoEncuentroAct` AS `puntoEncuentroAct`,
        `tm_actividad_edu`.`idPersonal_guiaAct` AS `idPersonal_guiaAct`,
        `tm_personal`.`idPersonal` AS `idPersonal`,
        `tm_personal`.`nomPersonal` AS `nomPersonal`,
        `tm_personal`.`apePersonal` AS `apePersonal`,
        `tm_personal`.`dirPersonal` AS `dirPersonal`,
        `tm_personal`.`poblaPersonal` AS `poblaPersonal`,
        `tm_personal`.`cpPersonal` AS `cpPersonal`,
        `tm_personal`.`provPersonal` AS `provPersonal`,
        `tm_personal`.`paisPersonal` AS `paisPersonal`,
        `tm_personal`.`tlfPersonal` AS `tlfPersonal`,
        `tm_personal`.`movilPersonal` AS `movilPersonal`,
        `tm_personal`.`emailPersonal` AS `emailPersonal`,
        `tm_personal`.`fecAltaPersonal` AS `fecAltaPersonal`,
        `tm_personal`.`fecBajaPersonal` AS `fecBajaPersonal`,
        `tm_personal`.`fecModiPersonal` AS `fecModiPersonal`,
        `tm_personal`.`estPersonal` AS `estPersonal`,
        `td_actividadDepartamento`.`idDepartamento_actividadDepartamento` AS `idDepartamento_actividadDepartamento`,
        `td_actividadDepartamento`.`estActividadDepartamento` AS `estActividadDepartamento`
    FROM
        ((`tm_actividad_edu`
        LEFT JOIN `tm_personal` ON ((`tm_actividad_edu`.`idPersonal_guiaAct` = `tm_personal`.`idPersonal`)))
        LEFT JOIN `td_actividadDepartamento` ON ((`tm_actividad_edu`.`idAct` = `td_actividadDepartamento`.`idActividad_actividadDepartamento`)))
*/

///////////////////////////
// VISTA DE VISTA ALUMNOS ACTIVIDAD ANTIGUA
//////////////////////////

/* 
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = newcosta@% 
    SQL SECURITY DEFINER
VIEW vista_alumnos_actividad AS
    SELECT 
        td_usuarioact_edu.idUsuarioAct AS idUsuarioAct,
        td_usuarioact_edu.idUsuario_UsuarioAct AS idUsuario_UsuarioAct,
        td_usuarioact_edu.idAct_UsuarioAct AS idAct_UsuarioAct,
        td_usuarioact_edu.asisUsuarioAct AS asisUsuarioAct,
        td_usuarioact_edu.fecAltaUsuarioAct AS fecAltaUsuarioAct,
        td_usuarioact_edu.estUsuarioAct AS estUsuarioAct,
        tm_alumno_edu.idAlumno AS idAlumno,
        tm_alumno_edu.nomUsuario AS nomUsuario,
        tm_alumno_edu.emailUsuario AS emailUsuario,
        tm_alumno_edu.senaUsuario AS senaUsuario,
        tm_alumno_edu.fecAltaUsuario AS fecAltaUsuario,
        tm_alumno_edu.fecBajaUsuario AS fecBajaUsuario,
        tm_alumno_edu.fecModiUsuario AS fecModiUsuario,
        tm_alumno_edu.avatarUsuario AS avatarUsuario,
        tm_alumno_edu.estUsu AS estUsu,
        tm_alumno_edu.nomAlumno AS nomAlumno,
        tm_alumno_edu.apeAlumno AS apeAlumno,
        tm_alumno_edu.fecNacAlumno AS fecNacAlumno,
        tm_alumno_edu.nacioAlumno AS nacioAlumno,
        tm_alumno_edu.ProfeEstuAlumno AS ProfeEstuAlumno,
        tm_alumno_edu.EmpresaAlumno AS EmpresaAlumno,
        tm_alumno_edu.UniAlumno AS UniAlumno,
        tm_alumno_edu.teleAlumno AS teleAlumno,
        tm_alumno_edu.domValAlumno AS domValAlumno,
        tm_alumno_edu.domOrigenAlumno AS domOrigenAlumno,
        tm_alumno_edu.lenMatAlumno AS lenMatAlumno,
        tm_alumno_edu.lenCon1Alumno AS lenCon1Alumno,
        tm_alumno_edu.lenCon2Alumno AS lenCon2Alumno,
        tm_alumno_edu.lenCon3Alumno AS lenCon3Alumno,
        tm_alumno_edu.lenCon4Alumno AS lenCon4Alumno,
        tm_alumno_edu.estEspAlumno AS estEspAlumno,
        tm_alumno_edu.nivEspAlumno AS nivEspAlumno,
        tm_alumno_edu.tiemEspAlumno AS tiemEspAlumno,
        tm_alumno_edu.lugEspAlumno AS lugEspAlumno,
        tm_alumno_edu.porEspAlumno AS porEspAlumno,
        tm_alumno_edu.mejEspAlumno AS mejEspAlumno,
        tm_alumno_edu.aprEspAlumno AS aprEspAlumno,
        tm_alumno_edu.act1Alumno AS act1Alumno,
        tm_alumno_edu.act2Alumno AS act2Alumno,
        tm_alumno_edu.act3Alumno AS act3Alumno,
        tm_alumno_edu.act4Alumno AS act4Alumno,
        tm_alumno_edu.act5Alumno AS act5Alumno,
        tm_alumno_edu.act6Alumno AS act6Alumno,
        tm_alumno_edu.act7Alumno AS act7Alumno,
        tm_alumno_edu.gustaTraAlumno AS gustaTraAlumno,
        tm_alumno_edu.gus1EspAlumno AS gus1EspAlumno,
        tm_alumno_edu.gus2EspAlumno AS gus2EspAlumno,
        tm_alumno_edu.gus3EspAlumno AS gus3EspAlumno,
        tm_alumno_edu.gus4EspAlumno AS gus4EspAlumno,
        tm_alumno_edu.gus5EspAlumno AS gus5EspAlumno,
        tm_alumno_edu.gusTextEspAlumno AS gusTextEspAlumno,
        tm_alumno_edu.conAlumno AS conAlumno,
        tm_alumno_edu.conRecoAlumno AS conRecoAlumno,
        tm_alumno_edu.conAgenAlumno AS conAgenAlumno,
        tm_alumno_edu.actSocialesAlumno AS actSocialesAlumno,
        tm_alumno_edu.actCultAlumno AS actCultAlumno,
        tm_alumno_edu.actGastroAlumno AS actGastroAlumno,
        tm_alumno_edu.actDepoAlumno AS actDepoAlumno,
        tm_alumno_edu.partActAlumno AS partActAlumno,
        tm_alumno_edu.numActAlumno AS numActAlumno,
        tm_alumno_edu.UltimaSesion AS UltimaSesion,
        tm_alumno_edu.tokenUsu AS tokenUsu,
        tm_alumno_edu.identificadorPersonal AS identificadorPersonal,
        tm_alumno_edu.perfilBloqueado AS perfilBloqueado,
        tm_alumno_edu.idInscripcion_tmAlumno AS idInscripcion_tmAlumno,
        tm_alumno_edu.idUsuario_tmalumno AS idUsuario_tmalumno,
        tm_actividad_edu.idAct AS idAct,
        tm_actividad_edu.descrAct AS descrAct,
        tm_actividad_edu.obsAct AS obsAct,
        tm_actividad_edu.fecActDesde AS fecActDesde,
        tm_actividad_edu.fecActHasta AS fecActHasta,
        tm_actividad_edu.fecActFinSolicitud AS fecActFinSolicitud,
        tm_actividad_edu.estadoAct AS estadoAct,
        tm_actividad_edu.horaInicioAct AS horaInicioAct,
        tm_actividad_edu.horaFinAct AS horaFinAct,
        tm_actividad_edu.horasLectivasAct AS horasLectivasAct,
        tm_actividad_edu.imgAct AS imgAct,
        tm_actividad_edu.fecAltaAct AS fecAltaAct,
        tm_actividad_edu.fecBajaAct AS fecBajaAct,
        tm_actividad_edu.fecModiAct AS fecModiAct,
        tm_actividad_edu.puntoEncuentroAct AS puntoEncuentroAct,
        tm_actividad_edu.idPersonal_guiaAct AS idPersonal_guiaAct,
        tm_actividad_edu.minAlumAct AS minAlumAct,
        tm_actividad_edu.maxAlumAct AS maxAlumAct,
        tm_actividad_edu.departamentoDisponible AS departamentoDisponible
    FROM
        ((td_usuarioact_edu
        LEFT JOIN tm_alumno_edu ON ((td_usuarioact_edu.idUsuario_UsuarioAct = tm_alumno_edu.idUsuario_tmalumno)))
        LEFT JOIN tm_actividad_edu ON ((td_usuarioact_edu.idAct_UsuarioAct = tm_actividad_edu.idAct)))
*/

///////////////////////////
// VISTA DE VISTA ALUMNOS ACTIVIDAD NUEVA
//////////////////////////

/* 
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `newcosta`@`%` 
    SQL SECURITY DEFINER
VIEW `vista_alumnos_actividad` AS
    SELECT 
        `td_usuarioact_edu`.`idUsuarioAct` AS `idUsuarioAct`,
        `td_usuarioact_edu`.`idUsuario_UsuarioAct` AS `idUsuario_UsuarioAct`,
        `td_usuarioact_edu`.`idAct_UsuarioAct` AS `idAct_UsuarioAct`,
        `td_usuarioact_edu`.`asisUsuarioAct` AS `asisUsuarioAct`,
        `td_usuarioact_edu`.`fecAltaUsuarioAct` AS `fecAltaUsuarioAct`,
        `td_usuarioact_edu`.`estUsuarioAct` AS `estUsuarioAct`,
        `tm_alumno_edu`.`idAlumno` AS `idAlumno`,
        `tm_alumno_edu`.`nomUsuario` AS `nomUsuario`,
        `tm_alumno_edu`.`emailUsuario` AS `emailUsuario`,
        `tm_alumno_edu`.`senaUsuario` AS `senaUsuario`,
        `tm_alumno_edu`.`fecAltaUsuario` AS `fecAltaUsuario`,
        `tm_alumno_edu`.`fecBajaUsuario` AS `fecBajaUsuario`,
        `tm_alumno_edu`.`fecModiUsuario` AS `fecModiUsuario`,
        `tm_alumno_edu`.`avatarUsuario` AS `avatarUsuario`,
        `tm_alumno_edu`.`estUsu` AS `estUsu`,
        `tm_alumno_edu`.`nomAlumno` AS `nomAlumno`,
        `tm_alumno_edu`.`apeAlumno` AS `apeAlumno`,
        `tm_alumno_edu`.`fecNacAlumno` AS `fecNacAlumno`,
        `tm_alumno_edu`.`nacioAlumno` AS `nacioAlumno`,
        `tm_alumno_edu`.`ProfeEstuAlumno` AS `ProfeEstuAlumno`,
        `tm_alumno_edu`.`EmpresaAlumno` AS `EmpresaAlumno`,
        `tm_alumno_edu`.`UniAlumno` AS `UniAlumno`,
        `tm_alumno_edu`.`teleAlumno` AS `teleAlumno`,
        `tm_alumno_edu`.`domValAlumno` AS `domValAlumno`,
        `tm_alumno_edu`.`domOrigenAlumno` AS `domOrigenAlumno`,
        `tm_alumno_edu`.`lenMatAlumno` AS `lenMatAlumno`,
        `tm_alumno_edu`.`lenCon1Alumno` AS `lenCon1Alumno`,
        `tm_alumno_edu`.`lenCon2Alumno` AS `lenCon2Alumno`,
        `tm_alumno_edu`.`lenCon3Alumno` AS `lenCon3Alumno`,
        `tm_alumno_edu`.`lenCon4Alumno` AS `lenCon4Alumno`,
        `tm_alumno_edu`.`estEspAlumno` AS `estEspAlumno`,
        `tm_alumno_edu`.`nivEspAlumno` AS `nivEspAlumno`,
        `tm_alumno_edu`.`tiemEspAlumno` AS `tiemEspAlumno`,
        `tm_alumno_edu`.`lugEspAlumno` AS `lugEspAlumno`,
        `tm_alumno_edu`.`porEspAlumno` AS `porEspAlumno`,
        `tm_alumno_edu`.`mejEspAlumno` AS `mejEspAlumno`,
        `tm_alumno_edu`.`aprEspAlumno` AS `aprEspAlumno`,
        `tm_alumno_edu`.`act1Alumno` AS `act1Alumno`,
        `tm_alumno_edu`.`act2Alumno` AS `act2Alumno`,
        `tm_alumno_edu`.`act3Alumno` AS `act3Alumno`,
        `tm_alumno_edu`.`act4Alumno` AS `act4Alumno`,
        `tm_alumno_edu`.`act5Alumno` AS `act5Alumno`,
        `tm_alumno_edu`.`act6Alumno` AS `act6Alumno`,
        `tm_alumno_edu`.`act7Alumno` AS `act7Alumno`,
        `tm_alumno_edu`.`gustaTraAlumno` AS `gustaTraAlumno`,
        `tm_alumno_edu`.`gus1EspAlumno` AS `gus1EspAlumno`,
        `tm_alumno_edu`.`gus2EspAlumno` AS `gus2EspAlumno`,
        `tm_alumno_edu`.`gus3EspAlumno` AS `gus3EspAlumno`,
        `tm_alumno_edu`.`gus4EspAlumno` AS `gus4EspAlumno`,
        `tm_alumno_edu`.`gus5EspAlumno` AS `gus5EspAlumno`,
        `tm_alumno_edu`.`gusTextEspAlumno` AS `gusTextEspAlumno`,
        `tm_alumno_edu`.`conAlumno` AS `conAlumno`,
        `tm_alumno_edu`.`conRecoAlumno` AS `conRecoAlumno`,
        `tm_alumno_edu`.`conAgenAlumno` AS `conAgenAlumno`,
        `tm_alumno_edu`.`actSocialesAlumno` AS `actSocialesAlumno`,
        `tm_alumno_edu`.`actCultAlumno` AS `actCultAlumno`,
        `tm_alumno_edu`.`actGastroAlumno` AS `actGastroAlumno`,
        `tm_alumno_edu`.`actDepoAlumno` AS `actDepoAlumno`,
        `tm_alumno_edu`.`partActAlumno` AS `partActAlumno`,
        `tm_alumno_edu`.`numActAlumno` AS `numActAlumno`,
        `tm_alumno_edu`.`UltimaSesion` AS `UltimaSesion`,
        `tm_alumno_edu`.`tokenUsu` AS `tokenUsu`,
        `tm_alumno_edu`.`identificadorPersonal` AS `identificadorPersonal`,
        `tm_alumno_edu`.`perfilBloqueado` AS `perfilBloqueado`,
        `tm_alumno_edu`.`idInscripcion_tmAlumno` AS `idInscripcion_tmAlumno`,
        `tm_alumno_edu`.`idUsuario_tmalumno` AS `idUsuario_tmalumno`,
        `tm_actividad_edu`.`idAct` AS `idAct`,
        `tm_actividad_edu`.`descrAct` AS `descrAct`,
        `tm_actividad_edu`.`obsAct` AS `obsAct`,
        `tm_actividad_edu`.`fecActDesde` AS `fecActDesde`,
        `tm_actividad_edu`.`fecActHasta` AS `fecActHasta`,
        `tm_actividad_edu`.`fecActFinSolicitud` AS `fecActFinSolicitud`,
        `tm_actividad_edu`.`estadoAct` AS `estadoAct`,
        `tm_actividad_edu`.`horaInicioAct` AS `horaInicioAct`,
        `tm_actividad_edu`.`horaFinAct` AS `horaFinAct`,
        `tm_actividad_edu`.`horasLectivasAct` AS `horasLectivasAct`,
        `tm_actividad_edu`.`imgAct` AS `imgAct`,
        `tm_actividad_edu`.`fecAltaAct` AS `fecAltaAct`,
        `tm_actividad_edu`.`fecBajaAct` AS `fecBajaAct`,
        `tm_actividad_edu`.`fecModiAct` AS `fecModiAct`,
        `tm_actividad_edu`.`puntoEncuentroAct` AS `puntoEncuentroAct`,
        `tm_actividad_edu`.`idPersonal_guiaAct` AS `idPersonal_guiaAct`,
        `tm_actividad_edu`.`minAlumAct` AS `minAlumAct`,
        `tm_actividad_edu`.`maxAlumAct` AS `maxAlumAct`,
        `tm_actividad_edu`.`departamentoDisponible` AS `departamentoDisponible`
    FROM
        ((`td_usuarioact_edu`
        LEFT JOIN `tm_alumno_edu` ON ((`td_usuarioact_edu`.`idUsuario_UsuarioAct` = `tm_alumno_edu`.`idUsuario_tmalumno`)))
        LEFT JOIN `tm_actividad_edu` ON ((`td_usuarioact_edu`.`idAct_UsuarioAct` = `tm_actividad_edu`.`idAct`)))
*/

/////////////////////////
// MÉTODO CAMBIADO Y FUNCIONAL, AHORA EL NOMBRE DEL DEPARTAMENTO SE CONSIGUE DIRECTAMENTE EN LA VISTA DE ACTIVIDADESCOMPLETO, FUNCIONA
/////////////////////////
public function mostrarActAdmin()
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = " 
            SELECT 
                idAct, 
                descrAct, 
                fecActDesde,
                horaInicioAct,
                fecActHasta,
                horaFinAct,
                horasLectivasAct,
                puntoEncuentroAct,
                nombresDepartamentos,  
                minAlumAct,
                maxAlumAct,
                estadoAct
            FROM actividadescompleto
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();

    } catch (PDOException $e) {
        $errorData = [
            'error' => true,
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'time' => date('Y-m-d H:i:s')
        ];
        file_put_contents(__DIR__ . '/error_mostrarActAdmin2.json', json_encode($errorData, JSON_PRETTY_PRINT));
        return false;
    }
}


/////////////////////////
// MÉTODO CAMBIADO (HAY QUE COMPROBAR MÁS ADELANTE QUE FUNCIONA ADECUADAMENTE)
/////////////////////////
        public function mostrarActUsuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        session_start();

        $departamento = $_SESSION['llegada_idDepartamento'];

        /*
        SQL ANTERIOR
        $sql = "
            SELECT ac.*
            FROM actividadescompleto ac
            INNER JOIN td_actividadDepartamento ad
                ON ac.idAct = ad.idActividad_actividadDepartamento
            WHERE ac.estadoAct = 1
            AND ad.idDepartamento_actividadDepartamento = ?
        ";
        */
    // SQL NUEVA
    $sql = "
        SELECT *
        FROM actividadescompleto
        WHERE estadoAct = 1
          AND FIND_IN_SET(?, idsDepartamentos) > 0
    ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $departamento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

        /////////////////////////
    // MÉTODO CAMBIADO Y FUNCIONAL
    /////////////////////////
    public function mostrarActUsuarioPerfil($idUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM vista_alumnos_actividad
                WHERE idUsuario_UsuarioAct = ?
                AND STR_TO_DATE(CONCAT(fecActHasta, ' ', horaFinAct), '%Y-%m-%d %H:%i:%s') < NOW()
                ORDER BY STR_TO_DATE(CONCAT(fecActHasta, ' ', horaFinAct), '%Y-%m-%d %H:%i:%s') DESC";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        /////////////////////////
    // MÉTODO SIGUE FUNCIONANDO DESPUÉS DE CAMBIO DE VISTA
    /////////////////////////
    public function mostrarAlum($idAct)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `vista_alumnos_actividad` WHERE  `idAct` = $idAct ";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function mostrarListaAlum($depaAct) {
    $conectar = parent::conexion();
    parent::set_names();
    session_start();

    $sql = "SELECT 
                a.idAlumno,
                a.nomUsuario,
                a.nomAlumno,
                a.idUsuario_tmalumno,
                a.apeAlumno,
                a.emailUsuario,
                a.teleAlumno,
                a.fecNacAlumno,
                IF(ua.idUsuarioAct IS NOT NULL, 1, 0) AS estadoInscripcion
            FROM 
                tm_alumno_edu a
            LEFT JOIN 
                td_usuarioact_edu ua 
                ON a.idUsuario_tmalumno = ua.idUsuario_UsuarioAct 
                AND ua.idAct_UsuarioAct = ?
            WHERE 
                a.estUsu = 1";

    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $depaAct);
    $sql->execute();
    return $resultado = $sql->fetchAll();
}


  public function mostrarListaAlumMatriculados($idAct) {
    $conectar = parent::conexion();
    parent::set_names();
    session_start();

    $sql = "SELECT
        l.id_llegada AS idLlegada,
        a.nomUsuario AS nickname,
        a.nomAlumno,
        a.apeAlumno,
        a.fecNacAlumno,
        a.emailUsuario,
        a.teleAlumno,
        l.diainscripcion_llegadas AS fechaInicioMatricula,
        l.fechallegada_llegadas AS fechaFinMatricula,
        a.idUsuario_tmalumno,
        a.idAlumno,
        CASE
            WHEN ua.idUsuarioAct IS NOT NULL THEN 1
            ELSE 0
        END AS estadoInscripcion
    FROM
        tm_llegadas_edu l
    LEFT JOIN
        tm_alumno_edu a ON l.idprescriptor_llegadas = a.idAlumno
    LEFT JOIN
        td_usuarioact_edu ua 
            ON ua.idUsuario_UsuarioAct = a.idUsuario_tmalumno
            AND ua.idAct_UsuarioAct = ?
    WHERE
        l.estLlegada = 1
        AND l.iddepartamento_llegadas IN (
            SELECT ad.idDepartamento_actividadDepartamento
            FROM td_actividadDepartamento ad
            WHERE ad.idActividad_actividadDepartamento = ?
        );";

    // Se pasa el mismo idActividad dos veces: para el JOIN y para el filtro de departamentos
    $sql = $conectar->prepare($sql);
    $sql->execute([$idAct, $idAct]);

    return $sql->fetchAll();
}


        /////////////////////////
// MÉTODO PARA COMPROBAR A LA HORA DE INSERTAR A UN ALUMNO A UNA ACTIVIDAD SI PRIMERO EL ID
// DE LA ACTIVIDAD EXISTE, PARA EVITAR PROBLEMAS MAYORES
/////////////////////////
    public function comprobarActividadExisteModelo($idAct)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT 1 FROM tm_actividad_edu WHERE idAct = ? LIMIT 1";
    $stmt = $conectar->prepare($sql);
    $stmt->bindValue(1, $idAct, PDO::PARAM_INT);
    $stmt->execute();

    // Si hay al menos una fila, existe la actividad
    return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
}

// MÉTODO PARA COMPROBAR A LA HORA DE INSCRIBIR A UN ALUMNO SI ESTA O NO YA REGISTRADO A ESA ACTIVIDAD
    public function comprobarAlumnoInscrito($idAct, $idAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT COUNT(*) AS total 
                FROM vista_alumnos_actividad 
                WHERE idAct = ? AND idAlumno = ?";
        
        $sql = $conectar->prepare($sql);
        $sql->execute([$idAct, $idAlumno]);

        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        return ($resultado['total'] > 0);  // true si existe inscripción, false si no
    }

    /////////////////////////
// MÉTODO CAMBIADO (HAY QUE COMPROBAR MÁS ADELANTE QUE FUNCIONA ADECUADAMENTE)
/////////////////////////

    public function mostrarActProf($depaActivo)
{
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "SELECT * FROM actividadescompleto WHERE estadoAct != 0 AND FIND_IN_SET(?, idsDepartamentos) > 0";
    $stmt = $conectar->prepare($sql);
    $stmt->execute([$depaActivo]);
    return $stmt->fetchAll();
}


    public function delete_Actusuario($idUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_actividad_edu
                    SET
                        estadoAct=0,
                        fecBajaAct=now()
                    WHERE
                        idAct = $idUsuario";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function activar_Actusuario($idUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_actividad_edu
                    SET
                        estadoAct=1,
                        fecBajaAct=null
                    WHERE
                        idAct = $idUsuario";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

          /////////////////////////
    // MÉTODO CAMBIADO Y FUNCIONAL
    /////////////////////////
    public function insertarActividad($descrAct, $fecActFinSolicitud, $fecActDesde, $fecActHasta, $horaInicioAct, $horaFinAct, $horasLectivasAct, $puntoEncuentroAct, $idPersonal_guiaAct, $obsAct, $imgAct, $minAlumTipo, $maxAlumTipo, $departamentos) {
        $conectar = parent::conexion();
        parent::set_names();

        $departamentoDisponible = 'NULL'; // Usamos NULL directamente en la SQL

        // INSERT en tm_actividad_edu
        $sql = "INSERT INTO tm_actividad_edu 
            (descrAct, obsAct, fecActDesde, fecActHasta, fecActFinSolicitud,
            horaInicioAct, horaFinAct, horasLectivasAct, imgAct, fecAltaAct,
            puntoEncuentroAct, idPersonal_guiaAct, estadoAct, minAlumAct, maxAlumAct, departamentoDisponible)
            VALUES (
                '$descrAct', 
                '$obsAct', 
                '$fecActDesde', 
                '$fecActHasta', 
                '$fecActFinSolicitud',
                '$horaInicioAct', 
                '$horaFinAct', 
                '$horasLectivasAct', 
                '$imgAct', 
                NOW(), 
                '$puntoEncuentroAct', 
                '$idPersonal_guiaAct', 
                1, 
                '$minAlumTipo', 
                '$maxAlumTipo', 
                $departamentoDisponible
            )";
        $json_string = json_encode($sql);
        $file = 'CreateActividades.json';
        file_put_contents($file, $json_string);
        $conectar->exec($sql);

        $lastIdActividad = $conectar->lastInsertId();

        // INSERTAR en td_actividadDepartamento
        $departamentosArray = explode(',', $departamentos);
        $json_string = json_encode($departamentosArray);
        $file = 'CreateDepartamentos.json';
        file_put_contents($file, $json_string);
        foreach ($departamentosArray as $departamento) {
            $departamento = intval(trim($departamento));
            if ($departamento > 0) {
                $sql = "INSERT INTO td_actividadDepartamento 
                    (idActividad_actividadDepartamento, idDepartamento_actividadDepartamento, estActividadDepartamento)
                    VALUES ($lastIdActividad, $departamento, 1)";
                    $json_string = json_encode($sql);
                    $file = 'CreateDEPA.json';
                    file_put_contents($file, $json_string);
                $conectar->exec($sql);
            }
        }
    }



            /////////////////////////
    // MÉTODO CAMBIADO Y FUNCIONAL
    /////////////////////////
    public function editarActividad($idAct, $descrAct, $fecActFinSolicitud, $fecActDesde, $fecActHasta, $horaInicioAct, $horaFinAct, $horasLectivasAct, $puntoEncuentroAct, $idPersonal_guiaAct, $obsAct, $nomImg, $min, $max, $departamentos){
        $conectar = parent::conexion();
        parent::set_names();

        // Campo departamentoDisponible a NULL 
        $departamentoDisponible = null; 
        
        // SE ACTUALIZA LA ACTIVIDAD, Y PONGO EL CAMPO DE DEPARTAMENTO DISPONIBLE A NULO, YA QUE LO VOY A QUITAR
        $sql = "UPDATE tm_actividad_edu SET descrAct = ?, obsAct = ?, fecActDesde = ?, fecActHasta = ?, fecActFinSolicitud = ?, horaInicioAct = ?, horaFinAct = ?, horasLectivasAct = ?, 
            imgAct = ?, fecModiAct = NOW(),puntoEncuentroAct = ?, idPersonal_guiaAct = ?, minAlumAct = ?, maxAlumAct = ?, departamentoDisponible = ? WHERE idAct = ?";
        $json_string = json_encode($sql);
        $file = 'Resultado.json';
        file_put_contents($file, $json_string);
        $stmt = $conectar->prepare($sql);
        $stmt->execute([
            $descrAct, $obsAct, $fecActDesde, $fecActHasta, $fecActFinSolicitud, $horaInicioAct, $horaFinAct, $horasLectivasAct, $nomImg, $puntoEncuentroAct, $idPersonal_guiaAct, $min, $max, $departamentoDisponible, $idAct
        ]);

        // YA QUE SE EDITA LA ACTIVIDAD, Y AL HACERLO SE PUEDE CAMBIAR EN LOS DEPARTAMENTOS QUE VA A ESTAR DISPONIBLE, SE ELIMINAN LOS DEPARTAMENTOS A LOS QUE ESTABAN
        // ASOCIADOS LA ACTIVIDAD, Y DESPUÉS SE VUELVEN A INSERTAR DE NUEVO, PARA TENER TODOS LOS CAMBIOS ACTUALIZADOS ADECUADAMENTE
        $sql = "DELETE FROM td_actividadDepartamento WHERE idActividad_actividadDepartamento = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$idAct]);

        // SE INSERTA AHORA LOS DEPARTAMENTOS ASOCIADOS A LA ACTIVIDAD DE MANERA ACTUALIZADA
        $departamentosArray = explode(',', $departamentos);
        foreach ($departamentosArray as $departamento) {
            $departamento = intval(trim($departamento));
            if ($departamento > 0) {
                $sql = "INSERT INTO td_actividadDepartamento 
                        (idActividad_actividadDepartamento, idDepartamento_actividadDepartamento, estActividadDepartamento)
                        VALUES (?, ?, 1)";
                $stmt = $conectar->prepare($sql);
                $stmt->execute([$idAct, $departamento]);
            }
        }
    }


    public function desactivarActividad($idAct)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_actividad_edu` SET `fecModiAct`= now() ,`fecBajaAct`= now() ,`estadoAct`= 0 WHERE `idAct`= $idAct";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function activarActividad($idAct)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_actividad_edu` SET `fecModiAct`= now() , `fecBajaAct`= null, `estadoAct`= 1 WHERE `idAct`= $idAct";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    //////////////////////
    // MÉTODO PARA CARGAR LA EDICIÓN DE UNA ACTIVIDAD CAMBIADO EXITOSAMENTE
    // ANTES SE USABA EL CAMPO departamentoDisponibles como campo para almacenar el id de cada departamento en la propia vista de la actividad
    // AHORA SE FORMA DINÁMICAMENTE CON idsDepartamentos los departamentos de los que forma parte esa actividad 
    /////////////////////
    public function cargarDatosEditarModelo($idAct)
{
    $conectar = parent::conexion();
    parent::set_names();

        $sql = "
        SELECT 
            ac.idAct,
            ac.descrAct,
            ac.obsAct,
            ac.fecActDesde,
            ac.fecActHasta,
            ac.fecActFinSolicitud,
            ac.horaInicioAct,
            ac.horaFinAct,
            ac.horasLectivasAct,
            ac.minAlumAct,
            ac.maxAlumAct,
            ac.puntoEncuentroAct,
            ac.idPersonal_guiaAct,
            ac.estadoAct,
            ac.imgAct,
            ac.idsDepartamentos
        FROM 
            actividadescompleto ac
        WHERE 
            ac.idAct = ?
    ";

    $stmt = $conectar->prepare($sql);
    $stmt->bindValue(1, $idAct, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// ESTE MÉTODO LO HE DEJADO DE USAR AL EDITAR, SE SIGUE USANDO EN EL CONTROLADOR DE ALUMNO, YA QUE ALLÍ SE ESPERA EL FETCH ALL
    public function getActividad_x_id($idAct)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `actividadescompleto` WHERE idAct = '$idAct'";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

public function obtenerActividadesPorLlegadaCertificado($idLlegada) 
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        session_start();
        $idUsuario = $_SESSION['usu_id'] ?? null;

        $sql = "
            SELECT 
                ac.descrAct AS nombreActividad,
                SUM(ac.horasLectivasAct) AS totalHorasLectivas
            FROM 
                td_usuarioact_edu
            LEFT JOIN 
                actividadescompleto ac ON td_usuarioact_edu.idAct_UsuarioAct = ac.idAct
            WHERE 
                td_usuarioact_edu.idUsuario_UsuarioAct = ?
                AND td_usuarioact_edu.asisUsuarioAct = 1
                AND td_usuarioact_edu.idLlegada_UsuarioAct = ?
            GROUP BY 
                ac.descrAct;
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);   
        $stmt->bindValue(2, $idLlegada, PDO::PARAM_INT);  
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Throwable $e) {
        // Crear array con datos del error
        $errorData = [
            "error" => true,
            "mensaje" => "Error al obtener actividades.",
            "detalle" => $e->getMessage(),
            "fecha" => date("Y-m-d H:i:s"),
            "datos_enviados" => [
                "idUsuario" => $idUsuario ?? null,
                "idLlegada" => $idLlegada
            ]
        ];

        // Guardar JSON del error
        file_put_contents("error_actividades_certificado.json", json_encode($errorData, JSON_PRETTY_PRINT));

        // Mostrar el error como JSON directamente
        header('Content-Type: application/json');
        echo json_encode($errorData, JSON_PRETTY_PRINT);
        exit;
    }
}

public function obtenerActividadesPorLlegadaEvaluacion($idLlegada, $tokenUsu) 
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        // Buscar el ID del usuario a partir del token
        $sqlUsuario = "SELECT idUsu FROM tm_usuario WHERE tokenUsu = ?";
        $stmtUsuario = $conectar->prepare($sqlUsuario);
        $stmtUsuario->bindValue(1, $tokenUsu, PDO::PARAM_STR);
        $stmtUsuario->execute();

        $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || empty($usuario["idUsu"])) {
            throw new Exception("Token de usuario no válido o no encontrado.");
        }

        $idUsuario = $usuario["idUsu"];

        // Consulta de actividades
        $sql = "
            SELECT 
                ac.idAct,
                ac.descrAct,
                ac.fecActDesde,
                ac.horaInicioAct,
                ac.fecActHasta,
                ac.horaFinAct,
                ac.horasLectivasAct,
                ac.puntoEncuentroAct,
                ac.nombresDepartamentos,
                ac.minAlumAct,
                ac.maxAlumAct,
                ac.estadoAct
            FROM 
                td_usuarioact_edu
            LEFT JOIN 
                actividadescompleto ac ON td_usuarioact_edu.idAct_UsuarioAct = ac.idAct
            WHERE 
                td_usuarioact_edu.idUsuario_UsuarioAct = ?
                AND td_usuarioact_edu.asisUsuarioAct = 1
                AND td_usuarioact_edu.idLlegada_UsuarioAct = ?
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
        $stmt->bindValue(2, $idLlegada, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Throwable $e) {
        $errorData = [
            "error" => true,
            "mensaje" => "Error al obtener actividades.",
            "detalle" => $e->getMessage(),
            "fecha" => date("Y-m-d H:i:s"),
            "datos_enviados" => [
                "tokenUsu" => $tokenUsu,
                "idLlegada" => $idLlegada
            ]
        ];

        file_put_contents("error_actividades_certificado.json", json_encode($errorData, JSON_PRETTY_PRINT));
        header('Content-Type: application/json');
        echo json_encode($errorData, JSON_PRETTY_PRINT);
        exit;
    }
}

 public function insertarAlumnoActividad($idAct, $selectAlumno, $idLlegada = null)
{
    $conectar = parent::conexion();
    parent::set_names();

    // Verificar si ya está inscrito
    $checkSql = "SELECT COUNT(*) AS existe FROM td_usuarioact_edu WHERE idUsuario_UsuarioAct = ? AND idAct_UsuarioAct = ?";
    $stmtCheck = $conectar->prepare($checkSql);
    $stmtCheck->execute([$selectAlumno, $idAct]);
    $resultado = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultado['existe'] > 0) {
        // Ya está inscrito, no hacemos nada
        return false;
    } else {
        // Preparar la inserción, con o sin idLlegada
        if ($idLlegada !== null) {
            $sql = "INSERT INTO td_usuarioact_edu (
                        idUsuario_UsuarioAct, 
                        idAct_UsuarioAct, 
                        idLlegada_UsuarioAct, 
                        fecAltaUsuarioAct
                    ) VALUES (?, ?, ?, NOW())";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$selectAlumno, $idAct, $idLlegada]);
        } else {
            $sql = "INSERT INTO td_usuarioact_edu (
                        idUsuario_UsuarioAct, 
                        idAct_UsuarioAct, 
                        fecAltaUsuarioAct
                    ) VALUES (?, ?, NOW())";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$selectAlumno, $idAct]);
        }

        return true;
    }
}


/*
    public function insertarAlumnoLlegadaActividad($idAct, $selectLlegada)
{
    $conectar = parent::conexion();
    parent::set_names();

    // Primero comprobar si el alumno ya está registrado en la actividad
    $checkSql = "SELECT COUNT(*) AS existe FROM td_usuarioact_edu WHERE idUsuario_UsuarioAct = ? AND idAct_UsuarioAct = ?";
    $stmtCheck = $conectar->prepare($checkSql);
    $stmtCheck->execute([$selectAlumno, $idAct]);
    $resultado = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultado['existe'] > 0) {
        // El alumno ya está registrado en esta actividad
        return false;
    } else {
        // No existe, insertamos
        $sql = "INSERT INTO td_usuarioact_edu (idUsuario_UsuarioAct, idAct_UsuarioAct, fecAltaUsuarioAct) VALUES (?, ?, NOW())";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$selectAlumno, $idAct]);
        return true;
    }
}
*/

    public function consultarAlumnoApuntado($idUsuario, $idActividad)
{
    $conectar = parent::conexion();
    parent::set_names();

    $checkSql = "SELECT COUNT(*) AS existe FROM td_usuarioact_edu WHERE idUsuario_UsuarioAct = ? AND idAct_UsuarioAct = ?";
    $stmtCheck = $conectar->prepare($checkSql);
    $stmtCheck->execute([$idUsuario, $idActividad]);
    $resultado = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultado['existe'] > 0) {
        // El alumno ya está registrado en esta actividad
        return true;
    } else {
        // No está registrado
        return false;
    }
}


    public function apuntarse($idUsu, $idAct, $idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "INSERT INTO `td_usuarioact_edu`( `idUsuario_UsuarioAct`, `idAct_UsuarioAct`, `asisUsuarioAct`, `fecAltaUsuarioAct`, `estUsuarioAct`, `idLlegada_UsuarioAct`) VALUES ( '$idUsu', '$idAct' , 0, NOW(), 1, '$idLlegada')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desapuntarse($idUsuario, $idActividad)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "DELETE FROM `td_usuarioact_edu` WHERE `idAct_UsuarioAct` = $idActividad AND `idUsuario_UsuarioAct` = $idUsuario ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function asistir($idUsuarioAct)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE td_usuarioact_edu
                    SET
                    asisUsuarioAct=1
                    WHERE
                    idUsuarioAct = $idUsuarioAct";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function noAsistir($idUsuarioAct)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE td_usuarioact_edu
                    SET
                    asisUsuarioAct=0,
                    fecAltaUsuarioAct = now()
                    WHERE
                    idUsuarioAct = $idUsuarioAct";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function darBaja($idUsuarioAct)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "DELETE FROM `td_usuarioact_edu` WHERE `idUsuarioAct` = $idUsuarioAct";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    ////////////////////////////////////
    ////////// NOTI - ACTIVIDADES /////
    //////////////////////////////////
    public function actividadNotificacion()
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM actividadescompleto WHERE estadoAct=1 ORDER BY idAct DESC LIMIT 5;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //////////////////////////////////
    /////////////////////////////////
    ////////////////////////////////
    public function totalAlumnoActividad($idActividad)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT count(*) AS TOTAL FROM `td_usuarioact_edu` WHERE idAct_UsuarioAct = $idActividad";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //////////////////////////////////
    //
}

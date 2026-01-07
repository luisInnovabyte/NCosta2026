-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-01-2026 a las 08:51:49
-- Versión del servidor: 8.0.40-0ubuntu0.24.10.1
-- Versión de PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `newcosta`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estado_actividad` ()   BEGIN
    -- Poner estAct en 0 cuando la fecha actual supere fecActHasta
    UPDATE tm_actividad_edu 
    SET estadoAct = 0 
    WHERE DATE(fecActHasta) < CURDATE() 
        AND (estadoAct != 0 or estadoAct != 2)$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estado_actividades` ()   BEGIN
    -- Actualizar estadoAct basado en el número de alumnos inscritos
    UPDATE tm_actividad_edu AS act
    SET estadoAct = 
        CASE 
            WHEN (SELECT COUNT(*) FROM td_usuarioact_edu WHERE idAct_usuarioAct = act.idAct) < act.minAlumAct THEN 2
            ELSE 3
        END
    WHERE estadoAct = 1 and DATE(fecActFinSolicitud) >= curdate()$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estado_actividades_program` (IN `idAct_param` INT)   BEGIN
    -- Actualizar estadoAct basado en el número de alumnos inscritos
    UPDATE tm_actividad_edu AS act
    SET estadoAct = 
        CASE 
            WHEN (SELECT COUNT(*) FROM td_usuarioact_edu WHERE idAct_usuarioAct = act.idAct) < act.minAlumAct THEN 2
            ELSE 3
        END
    WHERE estadoAct = 1 
    and DATE(fecActFinSolicitud) >= curdate()
    and idAct = idAct_param$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estado_actividad_program` (IN `idAct_param` INT)   BEGIN
    -- Poner estAct en 0 cuando la fecha actual supere fecActHasta
    UPDATE tm_actividad_edu 
    SET estadoAct = 0 
    WHERE DATE(fecActHasta) < CURDATE() 
        AND (estadoAct != 2) AND
        idAct = idAct_param$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estAlojamiento` ()   BEGIN
    -- Declarar variables necesarias
    ## Esta marca el final del bucle
    DECLARE done INT DEFAULT 0$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estAlojamientoxidLlegada` (IN `idLlegada_param` INT)   BEGIN
    -- Declarar variables necesarias
    ## Esta marca el final del bucle
    DECLARE done INT DEFAULT 0$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estLlegada_alojamiento` ()   BEGIN
     ## pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya ha finalizado el curso).
     UPDATE tm_alojamientosllegadas_edu SET estAlojamientos_llegadas=3  where DATE(fechaFinAlojamientos)<CURDATE()$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estLlegada_alojamiento_xidllegada` (IN `idLlegada_alojamiento_param` INT)   BEGIN
    -- Pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya hafinalizado el curso)
    UPDATE tm_alojamientosllegadas_edu 
    SET estAlojamientos_llegadas = 3
    WHERE DATE(fechaFinAlojamientos) < CURDATE() 
    AND idLlegada_alojamientos = idLlegada_alojamiento_param$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estLlegada_matriculacion` ()   BEGIN
     ## pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya ha finalizado el curso).
     UPDATE tm_matriculacionllegadas_edu SET estMatriculacion_llegadas=3  where DATE(fechaFinMatriculacion)<CURDATE()$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estLlegada_matriculacion_xidllegada` (IN `idLlegada_matriculacion_param` INT)   BEGIN
    -- Pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya hafinalizado el curso)
    UPDATE tm_matriculacionllegadas_edu 
    SET estMatriculacion_llegadas = 3
    WHERE DATE(fechaFinMatriculacion) < CURDATE() 
    AND idLlegada_matriculacion = idLlegada_matriculacion_param$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estMatricula` ()   BEGIN
    -- Declarar variables necesarias
    ## Esta marca el final del bucle
    DECLARE done INT DEFAULT 0$$

CREATE DEFINER=`root`@`%` PROCEDURE `actualizar_estMatriculaxidLlegada` (IN `idLlegada_param` INT)   BEGIN
    -- Declarar variables necesarias
    ## Esta marca el final del bucle
    DECLARE done INT DEFAULT 0$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calcularDiferenciaFechas` (`fecha_inicio` DATETIME, `fecha_fin` DATETIME) RETURNS VARCHAR(255) CHARSET utf8mb3 COLLATE utf8mb3_spanish2_ci DETERMINISTIC BEGIN
    DECLARE diff_months INT$$

CREATE DEFINER=`root`@`%` FUNCTION `calcular_fecha_ruta` (`p_fecha` DATE, `p_numero` INT, `p_periodicidad` INT) RETURNS DATE DETERMINISTIC BEGIN
    DECLARE fecha_resultante DATE$$

CREATE DEFINER=`root`@`%` FUNCTION `calcular_fecha_ruta_europeo` (`p_fecha` DATE, `p_numero` INT, `p_periodicidad` INT) RETURNS DATE DETERMINISTIC BEGIN
    DECLARE fecha_resultante DATE$$

CREATE DEFINER=`root`@`%` FUNCTION `estado_alojamiento` (`id_llegada_param` INT) RETURNS INT DETERMINISTIC BEGIN
    DECLARE resultado INT DEFAULT 0$$

CREATE DEFINER=`root`@`%` FUNCTION `estado_matriculacion` (`id_llegada_param` INT) RETURNS INT DETERMINISTIC BEGIN
    DECLARE resultado INT DEFAULT 0$$

CREATE DEFINER=`root`@`%` FUNCTION `validar_ruta_unica` (`p_idiomaId` INT, `p_tipoId` INT, `p_nivelId` INT) RETURNS TINYINT(1) DETERMINISTIC BEGIN
    DECLARE existe INT$$

CREATE DEFINER=`root`@`%` FUNCTION `validar_ruta_unica_orden` (`p_idiomaId` INT, `p_tipoId` INT, `p_peso` INT) RETURNS TINYINT(1) DETERMINISTIC BEGIN
    DECLARE existe INT$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `actividadescompleto`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `actividadescompleto` (
`idAct` int
,`descrAct` varchar(100)
,`obsAct` mediumtext
,`fecActDesde` date
,`fecActHasta` date
,`fecActFinSolicitud` date
,`estadoAct` int
,`horaInicioAct` time
,`horaFinAct` time
,`horasLectivasAct` varchar(11)
,`minAlumAct` int
,`maxAlumAct` int
,`departamentoDisponible` longtext
,`imgAct` varchar(225)
,`fecAltaAct` datetime
,`fecBajaAct` datetime
,`fecModiAct` datetime
,`puntoEncuentroAct` varchar(105)
,`idPersonal_guiaAct` int
,`idPersonal` int
,`nomPersonal` varchar(40)
,`apePersonal` varchar(70)
,`dirPersonal` varchar(60)
,`poblaPersonal` varchar(70)
,`cpPersonal` varchar(7)
,`provPersonal` varchar(70)
,`paisPersonal` varchar(70)
,`tlfPersonal` varchar(12)
,`movilPersonal` varchar(12)
,`emailPersonal` varchar(60)
,`fecAltaPersonal` datetime
,`fecBajaPersonal` datetime
,`fecModiPersonal` datetime
,`estPersonal` varchar(45)
,`idsDepartamentos` text
,`nombresDepartamentos` text
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaalumaloja`
--

CREATE TABLE `albaalumaloja` (
  `idAlbaranAlumAloja` int NOT NULL,
  `numAlbaran` int DEFAULT NULL COMMENT 'Numero aleatorio para la factura no repetido EJ: 21749',
  `numAlbaranPro` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `numFactura` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `idAloja_AlbaranAlumAloja` int DEFAULT NULL COMMENT 'Viene de la tabla TM_Aloja',
  `conceptoAlbaranAlumAloja` varchar(145) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT '1 semana... 2semanas Alojamiento Familiar... (Tipo de Aloajmiento tm) ',
  `tipoAlojaAlbaranAlumAloja` varchar(140) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Tipo de Alojamiento',
  `obsAlbaranAlumAloja` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'Observacion de la facturacion',
  `fecAltaAlbaranAlumAloja` datetime DEFAULT NULL COMMENT 'Fecha de creacion de la Factura',
  `fecAltaAlbaranProAlumAloja` datetime DEFAULT NULL,
  `fecAltaFacturaAlumAloja` datetime DEFAULT NULL,
  `ivaAlbaranAlumAloja` int DEFAULT NULL,
  `cantidadAlbaranAlumAloja` int DEFAULT NULL,
  `precioAlbaranAlumAloja` float NOT NULL COMMENT 'PrecioUnitario',
  `idUsuario_AlbaranAlumAloja` int DEFAULT NULL COMMENT 'Viene de la tabla tm_usuario',
  `idAlumAloja_AlbaranAlumAloja` int DEFAULT NULL,
  `idGrupo` int DEFAULT NULL COMMENT 'De la tabla tm_grupos',
  `cantidadPagoAlbaranAlumAloja` float DEFAULT '0' COMMENT 'cantidad ? pago a cuenta',
  `fechaPagoAlbaranAlumAloja` datetime DEFAULT NULL COMMENT 'Fecha del pago a cuenta',
  `medioPago_AlbaranAlumAloja` int DEFAULT NULL COMMENT 'Viene de la tabla Medio de Pago',
  `idAlojaAloja_albaalumaloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Facturaci?n del Alumno';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaalumdoc`
--

CREATE TABLE `albaalumdoc` (
  `idAlbaranAlumDoc` int NOT NULL,
  `numAlbaranAlumDoc` int DEFAULT NULL COMMENT 'Numero aleatorio para la factura no repetido EJ: 21749',
  `numAlbaranProAlumDoc` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Numero para la factura PROFORMA no repetido EJ: 21749',
  `numFacturaAlumDoc` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Numero de factura final',
  `idiomaAlbaranAlumDoc` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Nombre idioma',
  `conceptoAlbaranAlumDoc` varchar(145) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tipoCursoAlbaranAlumDoc` varchar(140) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Tipo de Curso',
  `obsAlbaranAlumDoc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'Observacion de la facturacion',
  `fecAltaAlbaranAlumDoc` datetime DEFAULT NULL COMMENT 'Fecha de creacion de la Factura',
  `fecAltaAlbaranProAlumDoc` int DEFAULT NULL COMMENT 'Fecha de la factura Proforma',
  `fecAltaFacturaAlumDoc` int DEFAULT NULL COMMENT 'Fecha de la factura final',
  `ivaAlbaranAlumDoc` int DEFAULT NULL,
  `cantidadAlbaranAlumDoc` int DEFAULT NULL,
  `precioAlbaranAlumDoc` float NOT NULL COMMENT 'PrecioUnitario',
  `idUsuario_AlbaranAlumDoc` int DEFAULT NULL COMMENT 'Viene de la tabla tm_usuario',
  `idGrupo_albalumdoc` int DEFAULT NULL COMMENT 'De la tabla tm_gruos',
  `cantidadPagoAlbaranAlumDoc` float DEFAULT '0' COMMENT 'cantidad ? pago a cuenta',
  `fechaPagoAlbaranAlumDoc` datetime DEFAULT NULL COMMENT 'Fecha del pago a cuenta',
  `medioPago_AlbaranAlumDoc` int DEFAULT NULL COMMENT 'Viene de la tabla Medio de Pago'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Facturaci?n del Alumno';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aloja_tiposaloja`
--

CREATE TABLE `aloja_tiposaloja` (
  `idAloja` int DEFAULT NULL,
  `idTipoAloja_TipoAloja` int DEFAULT NULL,
  `nifAloja` varchar(9) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `apeAloja` varchar(100) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nombreAloja` varchar(160) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpAloja` varchar(7) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `proviAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `telAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `movilAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailAloja` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textDatosPublicAloja` text COLLATE utf8mb3_spanish2_ci,
  `textDatosPrivateAloja` text COLLATE utf8mb3_spanish2_ci,
  `metrosAloja` int DEFAULT NULL,
  `wcAloja` int DEFAULT NULL,
  `HabIndiAloja` int DEFAULT NULL,
  `HabDobleAloja` int DEFAULT NULL,
  `HabTripleAloja` int DEFAULT NULL,
  `interAloja` int DEFAULT NULL,
  `descrAnimalesAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fumaAloja` int DEFAULT NULL,
  `descrFumaAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `comidasAloja` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textCasaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `nomPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacPadreAloja` date DEFAULT NULL,
  `profPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nomMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacMadreAloja` date DEFAULT NULL,
  `profMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrHijosVivenAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `aficAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `apieAloja` int DEFAULT NULL,
  `lineaAutobusAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minAutobusAloja` int DEFAULT NULL,
  `lineaMetroAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minMetroAloja` int DEFAULT NULL,
  `linkSituacionAloja` varchar(245) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `hospitalPrivAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `consultAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `hospitalPublicAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `pagoAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `estAloja` int DEFAULT NULL,
  `motvBajaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaAloja` datetime DEFAULT NULL,
  `fecBajaAloja` datetime DEFAULT NULL,
  `fecModiAloja` datetime DEFAULT NULL,
  `idTiposAloja` int DEFAULT NULL,
  `descrTiposAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTiposAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaTiposAloja` datetime DEFAULT NULL,
  `fecBajaTiposAloja` datetime DEFAULT NULL,
  `fecModiTiposAloja` datetime DEFAULT NULL,
  `estTiposAloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionAulasGrupo`
--

CREATE TABLE `asignacionAulasGrupo` (
  `idAsignacion` int NOT NULL,
  `idGrupoAsignacion` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'De la tabla cursos',
  `idAulasAsignacion` int DEFAULT NULL COMMENT 'De la tabla tm_aulas',
  `idHorariosAsignacion` int DEFAULT NULL COMMENT 'Relacionado con el planing de horario',
  `estAulasAsignacion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionProfesorGrupo`
--

CREATE TABLE `asignacionProfesorGrupo` (
  `idAsignacionProfe` int NOT NULL,
  `idGrupoAsignacionProfe` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'de la tabla cursos',
  `idProfeAsignacionProfe` int DEFAULT NULL COMMENT 'de la tabla tm_personal',
  `idHorariosAsignacionProfe` int DEFAULT NULL,
  `estAsignacionProfe` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `idasistencia` int NOT NULL,
  `idPersonal_asistencia` int DEFAULT NULL COMMENT 'IdPersonal Asistencia',
  `inicioAsistencia` datetime DEFAULT NULL COMMENT 'Momento en el que se genera la presencia',
  `finAsistencia` datetime DEFAULT NULL COMMENT 'Momento en el que se cierra la asistencia',
  `motivoAsistencia` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT '''Motivo de la Asistencia'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `asistencia_tmpersonal`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `asistencia_tmpersonal` (
`idasistencia` int
,`idPersonal_asistencia` int
,`inicioAsistencia` datetime
,`finAsistencia` datetime
,`motivoAsistencia` longtext
,`idPersonal` int
,`nomPersonal` varchar(40)
,`emailUsuario` varchar(50)
,`senaUsuario` varchar(45)
,`apePersonal` varchar(70)
,`dirPersonal` varchar(60)
,`poblaPersonal` varchar(70)
,`cpPersonal` varchar(7)
,`provPersonal` varchar(70)
,`paisPersonal` varchar(70)
,`tlfPersonal` varchar(12)
,`movilPersonal` varchar(12)
,`emailPersonal` varchar(60)
,`fecAltaPersonal` datetime
,`fecBajaPersonal` datetime
,`fecModiPersonal` datetime
,`rolUsuario` int
,`estPersonal` varchar(45)
,`estado` varchar(18)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas_idiomas`
--

CREATE TABLE `aulas_idiomas` (
  `idAula` int DEFAULT NULL,
  `descrAula` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirAula` varchar(80) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaAula` varchar(80) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpAula` varchar(7) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `provAula` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `paisAula` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `tlfAula` varchar(12) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailAula` varchar(20) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `capaAula` int DEFAULT NULL,
  `textAula` mediumtext COLLATE utf8mb3_spanish2_ci,
  `idIdioma_Aula` int DEFAULT NULL,
  `fecAltaAula` datetime DEFAULT NULL,
  `fecBajaAula` datetime DEFAULT NULL,
  `fecModiAula` datetime DEFAULT NULL,
  `estAula` int DEFAULT NULL,
  `idIdioma` int DEFAULT NULL,
  `descrIdioma` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `codIdioma` varchar(2) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textIdioma` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaIdioma` datetime DEFAULT NULL,
  `fecModiIdioma` datetime DEFAULT NULL,
  `fecBajaIdioma` datetime DEFAULT NULL,
  `estIdioma` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacidad_aloja`
--

CREATE TABLE `capacidad_aloja` (
  `Alojamiento` int DEFAULT NULL,
  `capacidad_ocupado` bigint DEFAULT NULL,
  `capacidad_total` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacidad_alojacompleto_tiposaloja`
--

CREATE TABLE `capacidad_alojacompleto_tiposaloja` (
  `idAloja` int DEFAULT NULL,
  `idTipoAloja_TipoAloja` int DEFAULT NULL,
  `nifAloja` varchar(9) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `apeAloja` varchar(100) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nombreAloja` varchar(160) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpAloja` varchar(7) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `proviAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `telAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `movilAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailAloja` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textDatosPublicAloja` text COLLATE utf8mb3_spanish2_ci,
  `textDatosPrivateAloja` text COLLATE utf8mb3_spanish2_ci,
  `metrosAloja` int DEFAULT NULL,
  `wcAloja` int DEFAULT NULL,
  `HabIndiAloja` int DEFAULT NULL,
  `HabDobleAloja` int DEFAULT NULL,
  `HabTripleAloja` int DEFAULT NULL,
  `interAloja` int DEFAULT NULL,
  `descrAnimalesAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fumaAloja` int DEFAULT NULL,
  `descrFumaAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `comidasAloja` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textCasaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `nomPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacPadreAloja` date DEFAULT NULL,
  `profPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nomMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacMadreAloja` date DEFAULT NULL,
  `profMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrHijosVivenAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `aficAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `apieAloja` int DEFAULT NULL,
  `lineaAutobusAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minAutobusAloja` int DEFAULT NULL,
  `lineaMetroAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minMetroAloja` int DEFAULT NULL,
  `linkSituacionAloja` varchar(245) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `hospitalPrivAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `consultAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `hospitalPublicAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `pagoAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `estAloja` int DEFAULT NULL,
  `motvBajaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaAloja` datetime DEFAULT NULL,
  `fecBajaAloja` datetime DEFAULT NULL,
  `fecModiAloja` datetime DEFAULT NULL,
  `token` int DEFAULT NULL,
  `Alojamiento` int DEFAULT NULL,
  `capacidad_ocupado` bigint DEFAULT NULL,
  `capacidad_total` bigint DEFAULT NULL,
  `idTiposAloja` int DEFAULT NULL,
  `descrTiposAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTiposAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaTiposAloja` datetime DEFAULT NULL,
  `fecBajaTiposAloja` datetime DEFAULT NULL,
  `fecModiTiposAloja` datetime DEFAULT NULL,
  `estTiposAloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comercial`
--

CREATE TABLE `comercial` (
  `idcomercial` int NOT NULL,
  `nomcomercial` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci COMMENT='Tabla maestra de comerciales';

--
-- Volcado de datos para la tabla `comercial`
--

INSERT INTO `comercial` (`idcomercial`, `nomcomercial`) VALUES
(1, 'Luis'),
(2, 'Jose'),
(3, 'Alejandro'),
(4, 'Rubén');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `idCurso` int NOT NULL,
  `idAlumno_cursos` int DEFAULT NULL COMMENT 'Viene de la tabla tm_alumno_edu',
  `idRuta_cursos` int DEFAULT NULL COMMENT 'Viene de la tabla tm_ruta',
  `fechaCrea_cursos` date DEFAULT NULL COMMENT 'Fecha de creacion del grupo. Vale para la perioridicdad',
  `est_cursos` int NOT NULL COMMENT 'Estado del curso',
  `idLlegada_cursos` int DEFAULT NULL COMMENT 'Llegada asociada de tm_lñlegadas',
  `idGrupo` int DEFAULT NULL COMMENT 'Si al insertar es NULL, le suamremos +1',
  `codGrupo` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Codigo real del grupo',
  `fechaNuevaCursos` date DEFAULT NULL,
  `fecFinCurso` datetime DEFAULT NULL COMMENT 'Fecha finalizacion del curso x persona',
  `tipoGrupo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Si son futuros,etc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`idCurso`, `idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`, `idGrupo`, `codGrupo`, `fechaNuevaCursos`, `fecFinCurso`, `tipoGrupo`) VALUES
(40, 18, 1, '2025-10-29', 0, 3, 1, 'ESINA1202510291', NULL, '2025-10-29 14:43:37', NULL),
(41, 28, 10, '2025-10-29', 0, 17, 1, 'ESINB2202510291', NULL, '2025-10-29 14:42:34', NULL),
(42, 20, 3, '2025-10-29', 0, 8, 1, 'ESINEI202510291', NULL, '2025-10-29 13:32:04', NULL),
(43, 20, 1, '2025-10-29', 1, 8, 1, 'ESINA1202510291', '2025-10-29', NULL, NULL),
(44, 18, 9, '2025-10-29', 0, 3, 1, 'ESINB1202510291', NULL, '2025-10-29 14:43:47', NULL),
(45, 47, 2, '2025-10-29', 0, 47, 1, 'ESINA1202510291', NULL, '2025-12-10 11:43:57', NULL),
(46, 50, 24, '2025-12-10', 1, 50, 1, 'ESGRAA1202512101', NULL, NULL, NULL),
(47, 47, 24, '2025-12-10', 1, 47, 2, 'ESGRAA1202512102', NULL, NULL, NULL),
(48, 51, 14, '2025-12-19', 1, 57, 1, 'ALINALE A4202512191', NULL, NULL, NULL),
(49, 51, 14, '2025-12-19', 1, 57, 2, 'ALINALE A4202512192', NULL, NULL, NULL),
(50, 51, 13, '2025-12-19', 1, 59, 1, 'ALINALE A3202512191', NULL, NULL, NULL),
(51, 51, 11, '2025-12-19', 1, 60, 1, 'ALINALE A1202512191', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `c_llamadas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `c_llamadas` (
`idllamadas` int
,`comercialid` int
,`fechaLlamada` datetime
,`estado` int
,`nombreComercial` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int NOT NULL,
  `descrEmpresa` varchar(80) DEFAULT NULL,
  `dirEmpresa` varchar(150) DEFAULT NULL,
  `poblaEmpresa` varchar(80) DEFAULT NULL,
  `cpEmpresa` varchar(7) DEFAULT NULL,
  `provEmpresa` varchar(70) DEFAULT NULL,
  `paisEmpresa` varchar(60) DEFAULT NULL,
  `webEmpresa` varchar(150) DEFAULT NULL,
  `tlfEmpresa` varchar(12) DEFAULT NULL,
  `emailEmpresa` varchar(20) DEFAULT NULL,
  `nifEmpresa` varchar(16) DEFAULT NULL,
  `regEmpresa` varchar(250) DEFAULT NULL COMMENT 'Este es el texto que aparece como "Empresa registrada en ....."',
  `numFacturaPro` int DEFAULT NULL,
  `numFactura` int DEFAULT NULL,
  `numFacturaNeg` int DEFAULT NULL,
  `prefijoPro` varchar(120) NOT NULL,
  `prefijoFact` varchar(120) NOT NULL,
  `idEmpresa_config` int DEFAULT NULL COMMENT 'De la tabla tm_config relacion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Es la tabla con los datos de la empresa (en principio solo hay una)';

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `descrEmpresa`, `dirEmpresa`, `poblaEmpresa`, `cpEmpresa`, `provEmpresa`, `paisEmpresa`, `webEmpresa`, `tlfEmpresa`, `emailEmpresa`, `nifEmpresa`, `regEmpresa`, `numFacturaPro`, `numFactura`, `numFacturaNeg`, `prefijoPro`, `prefijoFact`, `idEmpresa_config`) VALUES
(15, 'Leader Transport', 'C. del Dr. Josep Juan Dómine, 18, 1, Poblats Marítims', 'Valencia', '46011', 'Valencia', 'España', 'https://leader-transport.com/', '654654654', 'contabilidad@leader-', 'B44761906', 'Registro Mercantil de Valencia\r\nDiario 1003 Asiento 189\r\nTomo 11327 Folio 128 Inscripción 1ª', 1030, 1004, NULL, '2023PRO', '2023FACT', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacionFinal`
--

CREATE TABLE `evaluacionFinal` (
  `idEvaluacionFinal` int NOT NULL COMMENT 'Tabla encargada de los alumnos finalziados ',
  `idLlegadaEvaluacionFinal` int NOT NULL COMMENT 'De la tabla tm_llegadas_edu',
  `idAlumnoTokenEvaluacionFinal` varchar(255) COLLATE utf8mb3_spanish2_ci NOT NULL COMMENT 'de la tabla tm_alumno_edu',
  `minutosCertificadoEvaluacionFinal` varchar(220) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Minutos para evaluacion final',
  `mostrarCertificadoEvaluacionFinal` int DEFAULT NULL COMMENT 'Le habilita al alumno a verlo',
  `estadoLlegadaEvaluacionFinal` int DEFAULT NULL COMMENT 'Estados de la evaluacion, \r\n0 Sin Evaluar\r\n1 Aprobado\r\n2 Suspendido\r\n3 Cancelado\r\n',
  `codGrupoEvaluacionFinal` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Solo si es certificado indidual',
  `individualEvaluacionFinal` int DEFAULT NULL COMMENT 'Solo si es certificado indidual\r\n1= lo es 0 = No lo es',
  `textoDescripcionEvaluacionFinal` longtext COLLATE utf8mb3_spanish2_ci COMMENT 'Texto que se mostrará en el certificado',
  `jornadaClaseEvaluacionFinal` int DEFAULT NULL COMMENT 'Tiempo que dura las clases, 50 minutos 60...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `evaluacionFinal`
--

INSERT INTO `evaluacionFinal` (`idEvaluacionFinal`, `idLlegadaEvaluacionFinal`, `idAlumnoTokenEvaluacionFinal`, `minutosCertificadoEvaluacionFinal`, `mostrarCertificadoEvaluacionFinal`, `estadoLlegadaEvaluacionFinal`, `codGrupoEvaluacionFinal`, `individualEvaluacionFinal`, `textoDescripcionEvaluacionFinal`, `jornadaClaseEvaluacionFinal`) VALUES
(1, 3, 'kityj11efb98a977f64e2c4de414b', '50', 1, 1, 'ESINA1202509111', 1, 'fdsds', 10),
(2, 3, 'kityj11efb98a977f64e2c4de414b', '30', 1, 1, '', 0, '', 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_cabecera`
--

CREATE TABLE `factura_cabecera` (
  `idCabecera` int NOT NULL,
  `nombreCabecera` varchar(255) DEFAULT NULL,
  `cifCabecera` varchar(255) DEFAULT NULL,
  `correoCabecera` varchar(255) DEFAULT NULL,
  `movilCabecera` varchar(255) DEFAULT NULL,
  `tefCabecera` varchar(255) DEFAULT NULL,
  `direcCabecera` varchar(255) DEFAULT NULL,
  `cpCabecera` varchar(255) DEFAULT NULL,
  `paisCabecera` varchar(255) DEFAULT NULL,
  `numFactura_cabe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `factura_cabecera`
--

INSERT INTO `factura_cabecera` (`idCabecera`, `nombreCabecera`, `cifCabecera`, `correoCabecera`, `movilCabecera`, `tefCabecera`, `direcCabecera`, `cpCabecera`, `paisCabecera`, `numFactura_cabe`) VALUES
(116, 'Luis Carlos Pérez', '21451574A', 'luiscarlos@ra82.es', '660300923', '965262384', 'C/Vinagea, 6 nº23', '46139 Albatera', 'España', '1'),
(117, 'Luis Carlos', '202508261245LC', 'jose.mvb.cc@gmail.com', '', '', '', '', '', '2'),
(118, 'Luis Carlos Pérez', '21451574A', 'luiscarlos@ra82.es', '660300923', '965262384', 'C/Vinagea, 6 nº23', '46139 Albatera', 'España', '3'),
(119, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '4'),
(120, 'Uno AlumnoUno', '1111111', 'manuel.villamayor@uv.es', '+963610367', '', '', '', '', '5'),
(121, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '6'),
(122, 'pernales2510', '', '', '', '', '', '', '', '7'),
(123, 'pernales2510', '', '', '', '', '', '', '', '8'),
(124, 'Graham White', '25101702', 'nomelose@mail.es', '', '', '', '', '', '9'),
(125, 'Antonio prieto', '1112225k', 'prieto@uv.es', '', '', '', '', '', '10'),
(126, 'maria santos', '333356644g', 'santos@uv.es', '', '', '', '', '', '1'),
(127, 'javier perez', '55646666l', 'perez@uv.es', '', '', '', '', '', '2'),
(128, 'hermanos', 'K6545465466', '', '', '', '', '', '', '2'),
(129, 'test test', '202510281234TT', 'jose.mvv.cc@gmail.com', '', '', '', '', '', '11'),
(130, 'pernales2510', '', '', '', '', '', '', '', '12'),
(131, 'pernales2510', '', '', '', '', '', '', '', '13'),
(132, 'pernales2510', '', '', '', '', '', '', '', '14'),
(133, 'pernales2510', '', '', '', '', '', '', '', '15'),
(134, 'Manolo Grillo', '202511251132MG', 'im@uv.es', '', '', '', '', '', '16'),
(135, 'Manolo Grillo el padre', '202511251132MG', 'im@uv.es', '', '', '', '', '', '17'),
(136, 'Jose Test', '202512011304JT', 'jose.mvb.cc@gmail.com', '', '', '', '', '', '18'),
(137, 'Jose Test', '202512011304JT', 'jose.mvb.cc@gmail.com', '', '', '', '', '', '19'),
(138, 'Jose Test', '202512011304JT', 'jose.mvb.cc@gmail.com', '', '', '', '', '', '20'),
(139, 'Frances fr', 'fr555', 'fr01@uv.es', '', '', '', '', '', '2'),
(140, 'Frances fr', 'fr555', 'fr01@uv.es', '', '', '', '', '', '3'),
(141, 'Nuevo ESP esp', '202512101230NE', 'jose@gmail.com', '', '', '', '', '', '21'),
(142, 'Nuevo ESP esp', '202512101230NE', 'jose@gmail.com', '', '', '', '', '', '22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_cabecera_real`
--

CREATE TABLE `factura_cabecera_real` (
  `idCabecera` int NOT NULL,
  `nombreCabecera` varchar(255) DEFAULT NULL,
  `cifCabecera` varchar(255) DEFAULT NULL,
  `correoCabecera` varchar(255) DEFAULT NULL,
  `movilCabecera` varchar(255) DEFAULT NULL,
  `tefCabecera` varchar(255) DEFAULT NULL,
  `direcCabecera` varchar(255) DEFAULT NULL,
  `cpCabecera` varchar(255) DEFAULT NULL,
  `paisCabecera` varchar(255) DEFAULT NULL,
  `numFactura_cabe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `factura_cabecera_real`
--

INSERT INTO `factura_cabecera_real` (`idCabecera`, `nombreCabecera`, `cifCabecera`, `correoCabecera`, `movilCabecera`, `tefCabecera`, `direcCabecera`, `cpCabecera`, `paisCabecera`, `numFactura_cabe`) VALUES
(73, 'Luis Carlos Pérez', '21451574A', 'luiscarlos@ra82.es', '660300923', '965262384', 'C/Vinagea, 6 nº23', '46139 Albatera', 'España', '1'),
(74, 'Luis Carlos Pérez', '21451574A', 'luiscarlos@ra82.es', '660300923', '965262384', 'C/Vinagea, 6 nº23', '46139 Albatera', 'España', '2'),
(75, 'Luis Carlos', '202508261245LC', 'jose.mvb.cc@gmail.com', '', '', '', '', '', '3'),
(76, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '4'),
(77, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '5'),
(78, 'Uno AlumnoUno', '1111111', 'manuel.villamayor@uv.es', '+963610367', '', '', '', '', '6'),
(79, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '7'),
(80, 'Luis Carlos Pérez', '21451574A', 'luiscarlos@ra82.es', '660300923', '965262384', 'C/Vinagea, 6 nº23', '46139 Albatera', 'España', '8'),
(81, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '9'),
(82, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '10'),
(83, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '11'),
(84, 'Shoei Kaneyama', '202509111050SK', 'luiscarlospm@gmail.com', '611499662', '', 'C/ Vinatea 2', '46970', 'España', '12'),
(85, 'pernales2510', '', '', '', '', '', '', '', '13'),
(86, 'test test', '202510281234TT', 'jose.mvv.cc@gmail.com', '', '', '', '', '', '14'),
(87, 'pernales2510', '', '', '', '', '', '', '', '15'),
(88, 'Manolo Grillo el padre', '202511251132MG', 'im@uv.es', '', '', '', '', '', '16'),
(89, 'Jose Test', '202512011304JT', 'jose.mvb.cc@gmail.com', '', '', '', '', '', '17'),
(90, 'Nuevo ESP esp', '202512101230NE', 'jose@gmail.com', '', '', '', '', '', '18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_contenido`
--

CREATE TABLE `factura_contenido` (
  `idContenidoFactura` int NOT NULL COMMENT 'El contenido es lo que se factura',
  `codigoFacturaContenido` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'cp0,cp15...',
  `conceptoFacturaContenido` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Clases particulares 15 horas',
  `tipoFacturaContenido` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Matriculacion =  1 Alojamiento = 2 Otros = 3',
  `ivaFacturaContenido` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Se almacena el numero',
  `descuentoFacturaContenido` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Sea lamcena descuento por porcentaje',
  `importeFacturaContenido` decimal(10,2) DEFAULT NULL COMMENT 'Importe que modifica y decide el administrador que va a mostrar',
  `idPieFacturaContenido` int DEFAULT NULL COMMENT 'De la tabla  factura_cabecera',
  `idCabeceraFacturaContenido` int DEFAULT NULL COMMENT 'De la tabla  factura_pie',
  `idLlegadaFactura` int DEFAULT NULL COMMENT 'De la tabla tm:_llegadas-edu',
  `numFactura` int DEFAULT NULL COMMENT 'Proviene ya de una factura',
  `fechaInicioFacturaContenido` date DEFAULT NULL,
  `fechaFinFacturaContenido` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `factura_contenido`
--

INSERT INTO `factura_contenido` (`idContenidoFactura`, `codigoFacturaContenido`, `conceptoFacturaContenido`, `tipoFacturaContenido`, `ivaFacturaContenido`, `descuentoFacturaContenido`, `importeFacturaContenido`, `idPieFacturaContenido`, `idCabeceraFacturaContenido`, `idLlegadaFactura`, `numFactura`, `fechaInicioFacturaContenido`, `fechaFinFacturaContenido`) VALUES
(321, 'FAD13', 'Alojamiento en familia, AD', '', '16 ', '0 ', 2390.00, 1, 1, 1, 1, '2025-08-22', '2025-11-25'),
(322, 'I20', 'Curso intensivo,', '1', '16 ', '10', 2740.00, 1, 1, 1, 1, '2025-08-25', '2026-01-12'),
(328, 'ta1', 'Transporte aeropuerto, ', '1', '16', '0', 50.00, 1, 1, 1, 3, NULL, NULL),
(329, 'CP12', 'Clases particulares,', '', '16 ', '0 ', 420.00, 2, 2, 2, 2, '2025-09-05', '2025-09-26'),
(330, 'cp3', 'Transfer', '1', '12', '12', 1222.00, 2, 2, 2, 2, NULL, NULL),
(331, 'ta1', 'Transporte aeropuerto, ', '1', '16', '0', 50.00, 1, 1, 1, 3, NULL, NULL),
(332, 'ta2', 'Transporte aeropuerto, ', '4', '16', '0', 30.00, 1, 1, 1, 3, NULL, NULL),
(333, 'HI6', '', '', '16 ', '0 ', 915.00, 3, 3, 3, 4, '2025-09-21', '2025-11-01'),
(334, 'I52', 'Curso intensivo,', '', '16 ', '0 ', 5800.00, 3, 3, 3, 4, '2025-09-22', '2026-09-18'),
(335, 'ta1', 'Transporte aeropuerto, ', '4', '16', '0', 50.00, 3, 3, 3, 4, NULL, NULL),
(336, 'CP5', '', '', 'null ', '0 ', 200.00, 7, 7, 7, 5, '2025-10-06', '2025-10-11'),
(337, 'HI3', '', '', 'null ', '0 ', 465.00, 7, 7, 7, 5, '2025-09-28', '2025-10-11'),
(338, 'I2', '', '', 'null ', '0 ', 350.00, 7, 7, 7, 5, '2025-10-06', '2025-10-17'),
(339, 'C2', '', '', 'null ', '0 ', 210.00, 7, 7, 7, 5, '2025-10-06', '2025-10-17'),
(340, 'HI6', '', '', '16 ', '0 ', 915.00, 3, 3, 3, 6, '2025-09-21', '2025-11-01'),
(341, 'I52', 'Curso intensivo,', '', '16 ', '', 5800.00, 3, 3, 3, 6, '2025-09-11', '2026-09-18'),
(343, 'I1', '', '', '16 ', '0 ', 180.00, 14, 14, 14, 7, '2025-10-13', '2025-10-17'),
(344, 'I1', '', '', '16 ', '0 ', 180.00, 14, 14, 14, 8, '2025-10-13', '2025-10-17'),
(346, 'HD3', '', '', '16 ', '0 ', 370.00, 17, 17, 17, 9, '2025-10-20', '2025-11-18'),
(347, 'I3', '', '', '16 ', '0 ', 515.00, 17, 17, 17, 9, '2025-10-27', '2025-11-14'),
(348, 'I1', '', '', '16 ', '0 ', 180.00, 19, 19, 19, 10, '2025-10-20', '2025-10-25'),
(349, 'I2', '', '', '16 ', '0 ', 350.00, 20, 20, 20, 1, '2025-10-20', '2025-10-25'),
(350, 'I2', '', '', '16 ', '0 ', 350.00, 21, 21, 21, 2, '2025-10-27', '2025-10-31'),
(351, 'c2', '(2 semanas)', '1', '16', '0', 210.00, 24, 24, 24, 2, NULL, NULL),
(352, 'c2', '(2 semanas)', '1', '16', '0', 210.00, 24, 24, 24, 2, NULL, NULL),
(353, 'c2', '(2 semanas)', '1', '16', '0', 210.00, 24, 24, 24, 2, NULL, NULL),
(354, 'c2', '(2 semanas)', '1', '16', '0', 210.00, 24, 24, 24, 2, NULL, NULL),
(355, 'CP15', 'Clases particulares,', '', '16 ', '0 ', 525.00, 37, 37, 37, 11, '2025-10-29', '2025-11-06'),
(356, 'CP5', '', '', '16 ', '0 ', 200.00, 15, 15, 15, 12, '2025-10-13', '2025-10-17'),
(357, 'CP5', 'Cars', '1', '16', '0', 200.00, 15, 15, 15, 13, NULL, NULL),
(359, 'I1', '', 'jaime pernales', '16 ', '0 ', 180.00, 15, 15, 15, 14, '2025-10-13', '2025-10-17'),
(360, 'CP5', '', 'maria pernales', '16 ', '0 ', 200.00, 15, 15, 15, 14, '2025-10-13', '2025-10-17'),
(361, 'CP5', '', 'maria pernales', '16 ', '0 ', 200.00, 15, 15, 15, 14, '2025-10-13', '2025-10-17'),
(362, 'I1', '', 'jaime pernales', '16 ', '0 ', 180.00, 15, 15, 15, 14, '2025-10-13', '2025-10-17'),
(363, 'CP5', '', '', '16 ', '0 ', 200.00, 15, 15, 15, 14, '2025-10-13', '2025-10-17'),
(364, 'CP5', 'd', '1', '16', '0', 200.00, 15, 15, 15, 14, NULL, NULL),
(365, 'I1', '', 'jaime pernales', '16 ', '0 ', 180.00, 14, 14, 14, 15, '2025-10-13', '2025-10-17'),
(366, 'CP5', '', 'maria pernales', '16 ', '0 ', 200.00, 14, 14, 14, 15, '2025-10-13', '2025-10-17'),
(373, 'CP15', 'Clases particulares,', '', '16 ', '0 ', 525.00, 37, 37, 37, NULL, '2025-10-29', '2025-11-06'),
(374, 'fp1', '', 'TRANSFER_LLEGADA', '16', '0', 365.00, 37, 37, 37, NULL, NULL, NULL),
(375, 'deles', 'Simulacro examen DELE:', 'TRANSFER_REGRESO', '16', '0', 110.00, 37, 37, 37, NULL, NULL, NULL),
(397, 'FAD16', 'Alojamiento en familia, AD', 'maria pernales', '16 ', '0 ', 2930.00, 14, 14, 14, NULL, '2025-10-13', '2026-01-31'),
(398, 'I1', '', 'jaime pernales', '16 ', '0 ', 180.00, 14, 14, 14, NULL, '2025-10-13', '2025-10-17'),
(399, 'CP5', '', 'maria pernales', '16 ', '0 ', 200.00, 14, 14, 14, NULL, '2025-10-13', '2025-10-17'),
(400, 'HI2', '', '', '16 ', '0 ', 315.00, 29, 29, 29, NULL, '2025-10-26', '2025-11-08'),
(401, 'HIE', '', '', '16 ', '0 ', 30.00, 29, 29, 29, NULL, '2025-11-08', '2025-11-09'),
(402, 'C2', '', '', '16 ', '0 ', 210.00, 29, 29, 29, NULL, '2025-10-27', '2025-11-07'),
(403, 'deles', 'Simulacro examen DELE:', 'TRANSFER_REGRESO', '16', '0', 110.00, 29, 29, 29, NULL, NULL, NULL),
(404, 'fp1', '', 'TRANSFER_LLEGADA', '16', '0', 365.00, 29, 29, 29, NULL, NULL, NULL),
(405, 'HI2', '', '', '16 ', '0 ', 315.00, 29, 29, 29, NULL, '2025-10-26', '2025-11-08'),
(406, 'HIE', '', '', '16 ', '0 ', 30.00, 29, 29, 29, NULL, '2025-11-08', '2025-11-09'),
(407, 'C2', '', '', '16 ', '0 ', 210.00, 29, 29, 29, NULL, '2025-10-27', '2025-11-07'),
(408, 'fp1', '', 'TRANSFER_LLEGADA', '16', '0', 365.00, 29, 29, 29, NULL, NULL, NULL),
(409, 'deles', 'Simulacro examen DELE:', 'TRANSFER_REGRESO', '16', '0', 110.00, 29, 29, 29, NULL, NULL, NULL),
(410, 'CP15', 'Clases particulares,', '', '16 ', '0 ', 525.00, 37, 37, 37, NULL, '2025-10-29', '2025-11-06'),
(411, 'fp1', '', 'TRANSFER_LLEGADA', '16', '0', 365.00, 37, 37, 37, NULL, NULL, NULL),
(412, 'deles', 'Simulacro examen DELE:', 'TRANSFER_REGRESO', '16', '0', 110.00, 37, 37, 37, NULL, NULL, NULL),
(413, 'HI2', '', '', '16 ', '0 ', 315.00, 42, 42, 42, 16, '2025-12-02', '2025-12-13'),
(414, 'HIE', '', '', '16 ', '0 ', 30.00, 42, 42, 42, 16, '2025-12-13', '2025-12-14'),
(415, 'I2', 'Curso intensivo,', '', '16 ', '0 ', 350.00, 42, 42, 42, 16, '2025-12-01', '2025-12-12'),
(416, 'ta1', 'Transporte aeropuerto,', 'TRANSFER_LLEGADA', '16', '0', 50.00, 42, 42, 42, 16, NULL, NULL),
(417, 'ta1', 'Transporte aeropuerto,', 'TRANSFER_REGRESO', '16', '0', 50.00, 42, 42, 42, 16, NULL, NULL),
(418, 'HI2', '', '', '16 ', '0 ', 315.00, 42, 42, 42, 17, '2025-12-02', '2025-12-13'),
(419, 'HIE', '', '', '16 ', '0 ', 30.00, 42, 42, 42, 17, '2025-12-13', '2025-12-14'),
(420, 'I2', 'Curso intensivo,', '', '16 ', '0 ', 350.00, 42, 42, 42, 17, '2025-12-01', '2025-12-12'),
(421, 'ta1', 'Transporte aeropuerto,', 'TRANSFER_LLEGADA', '16', '0', 50.00, 42, 42, 42, 17, NULL, NULL),
(422, 'ta1', 'Transporte aeropuerto,', 'TRANSFER_REGRESO', '16', '0', 50.00, 42, 42, 42, 17, NULL, NULL),
(423, 'FAD2', '', '', '16 ', '0 ', 390.00, 46, 46, 46, 18, '2025-12-01', '2025-12-12'),
(424, 'deles', 'Simulacro examen DELE:', 'TRANSFER_LLEGADA', '16', '0', 110.00, 46, 46, 46, 18, NULL, NULL),
(425, 'che', 'Gastos cheque:', 'TRANSFER_REGRESO', '', '0', 0.00, 46, 46, 46, 18, NULL, NULL),
(426, 'CUL2', 'Curso cultura,', '', '16 ', '0 ', 210.00, 45, 45, 45, 19, '2025-12-08', '2025-12-19'),
(427, 'CUL2', 'Curso cultura,', '', '16 ', '0 ', 210.00, 45, 45, 45, 20, '2025-12-08', '2025-12-19'),
(428, 'I1', '', '', '16 ', '0 ', 180.00, 48, 48, 48, 2, '2025-12-10', '2025-12-12'),
(429, 'I1', '', '', '16 ', '0 ', 180.00, 48, 48, 48, 3, '2025-12-10', '2025-12-12'),
(430, 'C16', '', '', '16 ', '0 ', 1680.00, 50, 50, 50, 21, '2025-12-10', '2026-03-27'),
(431, 'CP100', 'Clases particulares,', '', '16 ', '0 ', 3300.00, 51, 51, 51, 22, '2025-12-15', '2025-12-16'),
(432, 'EM8', 'Extensivo Mini:', '', '16 ', '0 ', 360.00, 51, 51, 51, 22, '2025-12-15', '2026-02-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_contenido_real`
--

CREATE TABLE `factura_contenido_real` (
  `idContenidoFactura` int NOT NULL COMMENT 'El contenido es lo que se factura',
  `codigoFacturaContenido` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'cp0,cp15...',
  `conceptoFacturaContenido` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Clases particulares 15 horas',
  `tipoFacturaContenido` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Matriculacion =  1 Alojamiento = 2 Otros = 3',
  `ivaFacturaContenido` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Se almacena el numero',
  `descuentoFacturaContenido` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Sea lamcena descuento por porcentaje',
  `importeFacturaContenido` decimal(10,2) DEFAULT NULL COMMENT 'Importe que modifica y decide el administrador que va a mostrar',
  `idPieFacturaContenido` int DEFAULT NULL COMMENT 'De la tabla  factura_cabecera',
  `idCabeceraFacturaContenido` int DEFAULT NULL COMMENT 'De la tabla  factura_pie',
  `idLlegadaFactura` int DEFAULT NULL COMMENT 'De la tabla tm:_llegadas-edu',
  `numFactura` int DEFAULT NULL COMMENT 'Proviene ya de una factura',
  `fechaInicioFacturaContenido` date DEFAULT NULL,
  `fechaFinFacturaContenido` date DEFAULT NULL,
  `numFacturaPro` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `factura_contenido_real`
--

INSERT INTO `factura_contenido_real` (`idContenidoFactura`, `codigoFacturaContenido`, `conceptoFacturaContenido`, `tipoFacturaContenido`, `ivaFacturaContenido`, `descuentoFacturaContenido`, `importeFacturaContenido`, `idPieFacturaContenido`, `idCabeceraFacturaContenido`, `idLlegadaFactura`, `numFactura`, `fechaInicioFacturaContenido`, `fechaFinFacturaContenido`, `numFacturaPro`) VALUES
(205, 'FAD13', 'Alojamiento en familia, AD', '', '16 ', '0 ', 2390.00, 0, 73, 1, 1, NULL, NULL, '1'),
(206, 'I20', 'Curso intensivo,', '1', '16 ', '10', 2740.00, 205, 73, 1, 1, NULL, NULL, '1'),
(207, 'FAD13', 'Alojamiento en familia, AD', '', '16 ', '0 ', 2390.00, 0, 74, 1, 2, NULL, NULL, '1'),
(208, 'I20', 'Curso intensivo,', '1', '16 ', '10', 2740.00, 207, 74, 1, 2, NULL, NULL, '1'),
(209, 'CP12', 'Clases particulares,', '', '16 ', '0 ', 420.00, 0, 75, 2, 3, NULL, NULL, '2'),
(210, 'cp3', 'Transfer', '1', '12', '12', 1222.00, 209, 75, 2, 3, NULL, NULL, '2'),
(211, 'HI6', '', '', '16 ', '0 ', 915.00, 0, 76, 3, 4, NULL, NULL, '4'),
(212, 'I52', 'Curso intensivo,', '', '16 ', '0 ', 5800.00, 211, 76, 3, 4, NULL, NULL, '4'),
(213, 'ta1', 'Transporte aeropuerto, ', '4', '16', '0', 50.00, 212, 76, 3, 4, NULL, NULL, '4'),
(214, 'HI6', '', '', '16 ', '0 ', 915.00, 0, 77, 3, 5, NULL, NULL, '4'),
(215, 'I52', 'Curso intensivo,', '', '16 ', '0 ', 5800.00, 214, 77, 3, 5, NULL, NULL, '4'),
(216, 'ta1', 'Transporte aeropuerto, ', '4', '16', '0', 50.00, 215, 77, 3, 5, NULL, NULL, '4'),
(217, 'CP5', '', '', 'null ', '0 ', 200.00, 0, 78, 7, 6, NULL, NULL, '5'),
(218, 'HI3', '', '', 'null ', '0 ', 465.00, 217, 78, 7, 6, NULL, NULL, '5'),
(219, 'I2', '', '', 'null ', '0 ', 350.00, 218, 78, 7, 6, NULL, NULL, '5'),
(220, 'C2', '', '', 'null ', '0 ', 210.00, 219, 78, 7, 6, NULL, NULL, '5'),
(221, 'HI6', '', '', '16 ', '0 ', 915.00, 0, 79, 3, 7, NULL, NULL, '6'),
(222, 'I52', 'Curso intensivo,', '', '16 ', '', 5800.00, 221, 79, 3, 7, NULL, NULL, '6'),
(223, 'ta1', 'Transporte aeropuerto, ', '1', '16', '0', 50.00, 0, 80, 1, 8, NULL, NULL, '3'),
(224, 'ta1', 'Transporte aeropuerto, ', '1', '16', '0', 50.00, 223, 80, 1, 8, NULL, NULL, '3'),
(225, 'ta2', 'Transporte aeropuerto, ', '4', '16', '0', 30.00, 224, 80, 1, 8, NULL, NULL, '3'),
(226, 'HI6', '', '', '16 ', '0 ', 915.00, 0, 81, 3, 9, NULL, NULL, '6'),
(227, 'I52', 'Curso intensivo,', '', '16 ', '', 5800.00, 226, 81, 3, 9, NULL, NULL, '6'),
(228, 'HI6', '', '', '16 ', '0 ', 915.00, 0, 82, 3, 10, NULL, NULL, '6'),
(229, 'I52', 'Curso intensivo,', '', '16 ', '', 5800.00, 228, 82, 3, 10, NULL, NULL, '6'),
(230, 'HI6', '', '', '16 ', '0 ', 915.00, 0, 83, 3, 11, NULL, NULL, '6'),
(231, 'I52', 'Curso intensivo,', '', '16 ', '', 5800.00, 230, 83, 3, 11, NULL, NULL, '6'),
(232, 'HI6', '', '', '16 ', '0 ', 915.00, 0, 84, 3, 12, NULL, NULL, '6'),
(233, 'I52', 'Curso intensivo,', '', '16 ', '', 5800.00, 232, 84, 3, 12, NULL, NULL, '6'),
(234, 'I1', '', '', '16 ', '0 ', 180.00, 0, 85, 14, 13, NULL, NULL, '7'),
(235, 'CP15', 'Clases particulares,', '', '16 ', '0 ', 525.00, 0, 86, 37, 14, NULL, NULL, '11'),
(236, 'I1', '', 'jaime pernales', '16 ', '0 ', 180.00, 0, 87, 14, 15, NULL, NULL, '15'),
(237, 'CP5', '', 'maria pernales', '16 ', '0 ', 200.00, 236, 87, 14, 15, NULL, NULL, '15'),
(238, 'HI2', '', '', '16 ', '0 ', 315.00, 0, 88, 42, 16, NULL, NULL, '17'),
(239, 'HIE', '', '', '16 ', '0 ', 30.00, 238, 88, 42, 16, NULL, NULL, '17'),
(240, 'I2', 'Curso intensivo,', '', '16 ', '0 ', 350.00, 239, 88, 42, 16, NULL, NULL, '17'),
(241, 'ta1', 'Transporte aeropuerto,', 'TRANSFER_LLEGADA', '16', '0', 50.00, 240, 88, 42, 16, NULL, NULL, '17'),
(242, 'ta1', 'Transporte aeropuerto,', 'TRANSFER_REGRESO', '16', '0', 50.00, 241, 88, 42, 16, NULL, NULL, '17'),
(243, 'CUL2', 'Curso cultura,', '', '16 ', '0 ', 210.00, 0, 89, 45, 17, NULL, NULL, '20'),
(244, 'C16', '', '', '16 ', '0 ', 1680.00, 0, 90, 50, 18, NULL, NULL, '21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_pie`
--

CREATE TABLE `factura_pie` (
  `idPie` int NOT NULL,
  `idCabecera_Pie` int DEFAULT NULL,
  `idLlegada_Pie` int DEFAULT NULL,
  `numProformaPie` varchar(255) DEFAULT NULL,
  `serieProformaPie` varchar(255) DEFAULT NULL,
  `fechProformaPie` date DEFAULT NULL,
  `agentePie` varchar(255) DEFAULT NULL,
  `grupoFactPie` varchar(255) DEFAULT NULL,
  `grupoAmigPie` varchar(255) DEFAULT NULL,
  `quienFacturaPie` varchar(255) DEFAULT NULL,
  `estProforma` int DEFAULT NULL,
  `aQuienFactura` int DEFAULT NULL COMMENT '1 = Alumno 2 =  Agente 3 = Grupo',
  `facturaPagada` varchar(255) DEFAULT NULL COMMENT 'Factura Pagada o no',
  `textoLibreFacturaProforma` longtext COMMENT 'Para poner lo que queira en la factura',
  `abonadaFacturaPro` varchar(255) DEFAULT NULL COMMENT 'Factura Abonada',
  `abonadaFechaFacturaPro` datetime DEFAULT NULL COMMENT ', si no esta null y hay fecha es que esta abonada',
  `abonadaMotivoFacturaPro` longtext COMMENT 'Motivo de abono'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `factura_pie`
--

INSERT INTO `factura_pie` (`idPie`, `idCabecera_Pie`, `idLlegada_Pie`, `numProformaPie`, `serieProformaPie`, `fechProformaPie`, `agentePie`, `grupoFactPie`, `grupoAmigPie`, `quienFacturaPie`, `estProforma`, `aQuienFactura`, `facturaPagada`, `textoLibreFacturaProforma`, `abonadaFacturaPro`, `abonadaFechaFacturaPro`, `abonadaMotivoFacturaPro`) VALUES
(116, 116, 1, '1', 'PRO', '2025-08-22', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 'Este es el concepto extra.', '1', '2025-08-25 12:31:00', 'sedf'),
(117, 117, 2, '2', 'PRO', '2025-09-05', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, '', '2', '2025-09-09 16:30:21', 'ft'),
(118, 118, 1, '3', 'PRO', '2025-09-05', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(119, 119, 3, '4', 'PRO', '2025-09-11', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, '', '3', '2025-09-11 12:20:55', 'mas serv'),
(120, 120, 7, '5', 'PRO', '2025-09-26', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(121, 121, 3, '6', 'PRO', '2025-09-26', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(122, 122, 14, '7', 'PRO', '2025-10-13', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 3, NULL, '', '4', '2025-10-13 23:09:06', 'prueba1'),
(123, 123, 14, '8', 'PRO', '2025-10-13', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 3, NULL, '', '8', '2025-11-05 12:43:48', 'vbvb'),
(124, 124, 17, '9', 'PRO', '2025-10-17', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(125, 125, 19, '10', 'PRO', '2025-10-20', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(126, 126, 20, '1', 'PRO', '2025-10-20', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(127, 127, 21, '2', 'PRO', '2025-10-20', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(128, 128, 24, '2', 'ING', '2025-10-26', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 3, NULL, '', NULL, NULL, NULL),
(129, 129, 37, '11', 'PRO', '2025-10-29', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, '', '9', '2025-11-10 11:11:43', ','),
(130, 130, 15, '12', 'PRO', '2025-11-03', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 3, NULL, '', '5', '2025-11-03 11:32:58', 'error'),
(131, 131, 15, '13', 'PRO', '2025-11-03', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 3, NULL, '', '6', '2025-11-03 13:57:19', 'fff'),
(132, 132, 15, '14', 'PRO', '2025-11-03', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 3, NULL, '', '7', '2025-11-05 12:43:08', 'fg'),
(133, 133, 14, '15', 'PRO', '2025-11-05', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 3, NULL, '', '10', '2025-11-11 12:59:11', 'jjj'),
(134, 134, 42, '16', 'PRO', '2025-11-25', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, '', '11', '2025-11-25 11:48:30', 'preuba'),
(135, 135, 42, '17', 'PRO', '2025-11-25', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(136, 136, 46, '18', 'PRO', '2025-12-01', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(137, 137, 45, '19', 'PRO', '2025-12-02', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, '', '12', '2025-12-02 12:21:47', 'xcv'),
(138, 138, 45, '20', 'PRO', '2025-12-02', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa', NULL, NULL, NULL),
(139, 139, 48, '2', 'FR', '2025-12-10', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, '', '2', '2025-12-10 12:29:31', 'hhf'),
(140, 140, 48, '3', 'FR', '2025-12-10', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(141, 141, 50, '21', 'PRO', '2025-12-10', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL),
(142, 142, 51, '22', 'PRO', '2025-12-16', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_pie_real`
--

CREATE TABLE `factura_pie_real` (
  `idPie` int NOT NULL,
  `idCabecera_Pie` int DEFAULT NULL,
  `idLlegada_Pie` int DEFAULT NULL,
  `numProformaPie` varchar(255) DEFAULT NULL,
  `serieProformaPie` varchar(255) DEFAULT NULL,
  `fechProformaPie` date DEFAULT NULL,
  `agentePie` varchar(255) DEFAULT NULL,
  `grupoFactPie` varchar(255) DEFAULT NULL,
  `grupoAmigPie` varchar(255) DEFAULT NULL,
  `quienFacturaPie` varchar(255) DEFAULT NULL,
  `estProforma` int DEFAULT NULL,
  `aQuienFactura` int DEFAULT NULL COMMENT '1 = Alumno 2 =  Agente 3 = Grupo',
  `facturaPagada` varchar(255) DEFAULT NULL COMMENT 'Factura Pagada o no',
  `numFacturaPro` int DEFAULT NULL COMMENT 'De la tabla factura proforma',
  `textoLibreFacturaReal` longtext COMMENT 'Texto que sale de proforma y aqui no se edita. Para mostrar en factura',
  `abonadaFactura` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `abonadaFechaFactura` datetime DEFAULT NULL,
  `abonadaMotivoFactura` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `factura_pie_real`
--

INSERT INTO `factura_pie_real` (`idPie`, `idCabecera_Pie`, `idLlegada_Pie`, `numProformaPie`, `serieProformaPie`, `fechProformaPie`, `agentePie`, `grupoFactPie`, `grupoAmigPie`, `quienFacturaPie`, `estProforma`, `aQuienFactura`, `facturaPagada`, `numFacturaPro`, `textoLibreFacturaReal`, `abonadaFactura`, `abonadaFechaFactura`, `abonadaMotivoFactura`) VALUES
(73, 73, 1, '1', 'FAC', '2025-08-22', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 1, 'Este es el concepto extra.', '1', '2025-08-22 12:53:31', 'Prueba de abono'),
(74, 74, 1, '2', 'FAC', '2025-08-22', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 1, 'Este es el concepto extra.', '2', '2025-08-22 12:59:39', 'hhhhy'),
(75, 75, 2, '3', 'FAC', '2025-09-05', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 2, '', '3', '2025-09-09 16:30:13', 'fcgvb'),
(76, 76, 3, '4', 'FAC', '2025-09-11', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 4, 'otros', '4', '2025-09-11 11:42:50', 'Por que si'),
(77, 77, 3, '5', 'FAC', '2025-09-11', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 4, '', '5', '2025-09-11 12:20:45', 'Mas servicios'),
(78, 78, 7, '6', 'FAC', '2025-09-26', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, 5, '', NULL, NULL, NULL),
(79, 79, 3, '7', 'FAC', '2025-09-26', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 6, '', '6', '2025-09-30 13:46:02', 'ghj'),
(80, 80, 1, '8', 'FAC', '2025-09-30', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, 3, '', NULL, NULL, NULL),
(81, 81, 3, '9', 'FAC', '2025-09-30', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 6, '', '7', '2025-09-30 13:48:05', 'hgj'),
(82, 82, 3, '10', 'FAC', '2025-09-30', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 6, '', '8', '2025-09-30 13:48:34', 'asd'),
(83, 83, 3, '11', 'FAC', '2025-09-30', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 6, '', '9', '2025-09-30 13:51:56', 'jkl'),
(84, 84, 3, '12', 'FAC', '2025-09-30', '1', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, 6, '', NULL, NULL, NULL),
(85, 85, 14, '13', 'FAC', '2025-10-13', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 7, '', '10', '2025-11-05 12:43:34', 'gnng'),
(86, 86, 37, '14', 'FAC', '2025-10-29', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 1, NULL, 11, '', '11', '2025-11-10 11:11:32', 'l.'),
(87, 87, 14, '15', 'FAC', '2025-11-05', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 0, 3, NULL, 15, '', '12', '2025-11-11 12:59:00', 'lkk'),
(88, 88, 42, '16', 'FAC', '2025-11-25', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, 17, '', NULL, NULL, NULL),
(89, 89, 45, '17', 'FAC', '2025-12-02', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, 20, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa', NULL, NULL, NULL),
(90, 90, 50, '18', 'FAC', '2025-12-10', '', 'NoNecesario', 'NoNecesario', 'NoNecesario', 1, 1, NULL, 21, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_personal`
--

CREATE TABLE `imagenes_personal` (
  `idPersoImg` int DEFAULT NULL,
  `idPersonal_PersoImg` int DEFAULT NULL,
  `descrPersoImg` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `imgPersoImg` varchar(225) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaPersoImg` datetime DEFAULT NULL,
  `estPersoImg` int DEFAULT NULL,
  `idPersonal` int DEFAULT NULL,
  `nomPersonal` varchar(40) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailUsuario` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `senaUsuario` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `apePersonal` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirPersonal` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaPersonal` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpPersonal` varchar(7) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `provPersonal` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `paisPersonal` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `tlfPersonal` varchar(12) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `movilPersonal` varchar(12) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailPersonal` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaPersonal` datetime DEFAULT NULL,
  `fecBajaPersonal` datetime DEFAULT NULL,
  `fecModiPersonal` datetime DEFAULT NULL,
  `rolUsuario` int DEFAULT NULL,
  `estPersonal` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `tokenPers` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listaactividadcompleta`
--

CREATE TABLE `listaactividadcompleta` (
  `idUsuarioAct` int DEFAULT NULL,
  `idUsuario_UsuarioAct` int DEFAULT NULL,
  `idAct_UsuarioAct` int DEFAULT NULL,
  `asisUsuarioAct` int DEFAULT NULL,
  `fecAltaUsuarioAct` datetime DEFAULT NULL,
  `estUsuarioAct` int DEFAULT NULL,
  `idAct` int DEFAULT NULL,
  `descrAct` varchar(100) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `obsAct` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecActDesde` date DEFAULT NULL,
  `fecActHasta` date DEFAULT NULL,
  `fecActFinSolicitud` date DEFAULT NULL,
  `estadoAct` int DEFAULT NULL,
  `horaInicioAct` time DEFAULT NULL,
  `horaFinAct` time DEFAULT NULL,
  `horasLectivasAct` varchar(11) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `imgAct` varchar(225) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaAct` datetime DEFAULT NULL,
  `fecBajaAct` datetime DEFAULT NULL,
  `fecModiAct` datetime DEFAULT NULL,
  `puntoEncuentroAct` varchar(105) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `idPersonal_guiaAct` int DEFAULT NULL,
  `idUsuario` int DEFAULT NULL,
  `nomUsuario` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailUsuario` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaUsuario` datetime DEFAULT NULL,
  `fecModiUsuario` datetime DEFAULT NULL,
  `estUsu` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listaDiariaClase`
--

CREATE TABLE `listaDiariaClase` (
  `idLista` int NOT NULL COMMENT 'ID de la lista a gestionar',
  `idAlumnoLista` int DEFAULT NULL COMMENT 'id del alumno en cuestión',
  `idProfesorLista` int DEFAULT NULL COMMENT 'Profesor que realiza la acción, idPersonal',
  `idHorarioLista` int DEFAULT NULL COMMENT 'id de la lista de la tabla tm_horarioGrupo',
  `idCodigoCursoLista` varchar(225) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'id Codigo largo del curso',
  `estadoAsistenciaLista` int DEFAULT NULL COMMENT '0 = Sin Registrar | 1= Presente | 2 = Ausente | 3 Llego tarde | 4 = Justificado',
  `horasAsistenciaLista` time DEFAULT NULL COMMENT 'Catidad de horas que ha asistido',
  `horaLlegadaLista` time DEFAULT NULL COMMENT 'Hora de llegada',
  `motivoRetrasoLista` longtext COLLATE utf8mb3_spanish2_ci COMMENT 'Motivo de retraso o Justificacion',
  `tareasRealizadasLista` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Numero de tareas realizadas en el dia de hoy',
  `obsDiariaLista` longtext COLLATE utf8mb3_spanish2_ci COMMENT 'Observaciones diarias',
  `estListaDiariaClase` int DEFAULT NULL COMMENT 'estado General de la lista',
  `tareaIndividualListaDiaria` longtext COLLATE utf8mb3_spanish2_ci COMMENT 'Tareas asignadas al alumno individualmente',
  `idLlegadaListaDiariaClase` int DEFAULT NULL COMMENT 'De la tabla tm_llegadas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `listaDiariaClase`
--

INSERT INTO `listaDiariaClase` (`idLista`, `idAlumnoLista`, `idProfesorLista`, `idHorarioLista`, `idCodigoCursoLista`, `estadoAsistenciaLista`, `horasAsistenciaLista`, `horaLlegadaLista`, `motivoRetrasoLista`, `tareasRealizadasLista`, `obsDiariaLista`, `estListaDiariaClase`, `tareaIndividualListaDiaria`, `idLlegadaListaDiariaClase`) VALUES
(1, 18, 29, 1, 'ESINA1202509111', 1, '00:50:00', '16:00:00', '', '1', '', 1, 'Haz esto', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamadas`
--

CREATE TABLE `llamadas` (
  `idllamadas` int NOT NULL,
  `comercialid` int NOT NULL,
  `fechaLlamada` datetime DEFAULT NULL,
  `estado` int DEFAULT NULL COMMENT '1 - Asignada, 2 - Con contacto, sin cierre, 3 - Cita cerrada, 4 - Presupuesto, 5 - Ganada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci COMMENT='tabla de llamadas recibidas por el comercial';

--
-- Volcado de datos para la tabla `llamadas`
--

INSERT INTO `llamadas` (`idllamadas`, `comercialid`, `fechaLlamada`, `estado`) VALUES
(1, 1, '2025-04-23 00:00:00', 1),
(2, 1, '2025-03-25 00:00:00', 2),
(3, 1, '2025-03-26 00:00:00', 3),
(4, 1, '2025-04-15 00:00:00', 4),
(5, 1, '2025-04-20 00:00:00', 5),
(6, 2, '2025-04-25 00:00:00', 1),
(7, 3, '2025-03-02 00:00:00', 3),
(8, 4, '2025-02-12 00:00:00', 5),
(9, 2, '2025-03-01 00:00:00', 2),
(10, 2, '2025-04-23 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `llegadas_departamentos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `llegadas_departamentos` (
`id_llegada` int
,`diainscripcion_llegadas` date
,`idprescriptor_llegadas` int
,`iddepartamento_llegadas` int
,`agente_llegadas` int
,`grupo_llegadas` varchar(100)
,`grupoAmigos` varchar(255)
,`fechallegada_llegadas` datetime
,`horallegada_llegadas` time
,`lugarllegada_llegadas` text
,`quienrecogealumno_llegadas` varchar(255)
,`fechacancelacion_llegadas` date
,`motivocancelacion_llegadas` text
,`codigotariotallegadaTransfer_llegadas` varchar(50)
,`textotariotallegadaTransfer_llegadas` text
,`importetariotallegadaTransfer_llegadas` varchar(100)
,`ivatariotallegadaTransfer_llegadas` varchar(100)
,`diallegadaTransferTransfer_llegadas` date
,`horallegadaTransferTransfer_llegadas` time
,`lugarllegadallegadaTransfer_llegadas` text
,`lugarentregallegadaTransfer_llegadas` text
,`quienrecogealumnollegadaTransfer_llegadas` varchar(255)
,`codigotariotalregresoTransfer_llegadas` varchar(50)
,`textotariotalregresoTransfer_llegadas` text
,`importetariotalregresoTransfer_llegadas` varchar(100)
,`ivatariotalregresoTransfer_llegadas` varchar(100)
,`diaregresoTransfer_llegadas` date
,`horaregresoTransfer_llegadas` time
,`lugarrecogidaregresaTransfer_llegadas` text
,`lugarentregaregresaTransfer_llegadas` text
,`quienrecogealumnoregresaTransfer_llegadas` varchar(255)
,`campoobservacionesgeneralTransfer_llegadas` text
,`niveldice_llegadas` text
,`nivelobservaciones_llegadas` text
,`nivelasignado_llegadas` varchar(100)
,`semanaasignada_llegadas` varchar(100)
,`tieneVisado` int
,`fechCartaAdmision` date
,`denegacionFecha` date
,`denegacionMotivo` longtext
,`estProforma` int
,`numProforma` varchar(255)
,`estLlegada` int
,`suplidoImporte` varchar(100)
,`suplidoDescr` varchar(255)
,`estMatricula` int
,`estAlojamiento` int
,`cursoFinalizado` int
,`idDepartamentoEdu` int
,`nombreDepartamento` varchar(225)
,`numFacturaProDepa` varchar(225)
,`numFacturaDepa` varchar(225)
,`numFacturaNegDepa` varchar(225)
,`prefijoFactDepa` varchar(225)
,`prefijoFacturaProEdu` varchar(225)
,`prefijoAbonoEdu` varchar(225)
,`estDepa` int
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `llegadas_matriculaciones`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `llegadas_matriculaciones` (
`id_llegada` int
,`diainscripcion_llegadas` date
,`idprescriptor_llegadas` int
,`iddepartamento_llegadas` int
,`agente_llegadas` int
,`grupo_llegadas` varchar(100)
,`grupoAmigos` varchar(255)
,`fechallegada_llegadas` datetime
,`horallegada_llegadas` time
,`lugarllegada_llegadas` text
,`quienrecogealumno_llegadas` varchar(255)
,`fechacancelacion_llegadas` date
,`motivocancelacion_llegadas` text
,`codigotariotallegadaTransfer_llegadas` varchar(50)
,`textotariotallegadaTransfer_llegadas` text
,`importetariotallegadaTransfer_llegadas` varchar(100)
,`ivatariotallegadaTransfer_llegadas` varchar(100)
,`diallegadaTransferTransfer_llegadas` date
,`horallegadaTransferTransfer_llegadas` time
,`lugarllegadallegadaTransfer_llegadas` text
,`lugarentregallegadaTransfer_llegadas` text
,`quienrecogealumnollegadaTransfer_llegadas` varchar(255)
,`codigotariotalregresoTransfer_llegadas` varchar(50)
,`textotariotalregresoTransfer_llegadas` text
,`importetariotalregresoTransfer_llegadas` varchar(100)
,`ivatariotalregresoTransfer_llegadas` varchar(100)
,`diaregresoTransfer_llegadas` date
,`horaregresoTransfer_llegadas` time
,`lugarrecogidaregresaTransfer_llegadas` text
,`lugarentregaregresaTransfer_llegadas` text
,`quienrecogealumnoregresaTransfer_llegadas` varchar(255)
,`campoobservacionesgeneralTransfer_llegadas` text
,`niveldice_llegadas` text
,`nivelobservaciones_llegadas` text
,`nivelasignado_llegadas` varchar(100)
,`semanaasignada_llegadas` varchar(100)
,`tieneVisado` int
,`fechCartaAdmision` date
,`denegacionFecha` date
,`denegacionMotivo` longtext
,`estProforma` int
,`numProforma` varchar(255)
,`estLlegada` int
,`suplidoImporte` varchar(100)
,`suplidoDescr` varchar(255)
,`estMatricula` int
,`idMatriculacionLlegada` int
,`idLlegada_matriculacion` int
,`idIvaTarifa_matriculacion` varchar(225)
,`idDepartamentoTarifa_matriculacion` varchar(225)
,`codTarifa_matriculacion` varchar(255)
,`nombreTarifa_matriculacion` varchar(255)
,`unidadTarifa_matriculacion` varchar(255)
,`precioTarifa_matriculacion` varchar(255)
,`cuenta1Tarifa_matriculacion` varchar(225)
,`cuenta2Tarifa_matriculacion` varchar(225)
,`cuenta3Tarifa_matriculacion` varchar(225)
,`tipoTarifa_matriculacion` varchar(225)
,`descripcionTarifa_matriculacion` varchar(225)
,`fechaInicioMatriculacion` date
,`fechaFinMatriculacion` date
,`estMatriculacion_llegadas` int
,`obsMatriculacion` longtext
,`descuento_matriculacion` varchar(4)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `personal_contratos_tipocontratos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `personal_contratos_tipocontratos` (
`idPersoContrato` int
,`idpersonal_PersoContrato` int
,`idcontrato_PersoContrato` int
,`fecInicioPersoContrato` date
,`fecFinalPersoContrato` date
,`textPersoContrato` mediumtext
,`estContrato` int
,`categoriaContrato` varchar(255)
,`jornadaContrato` varchar(255)
,`duracionContrato` varchar(255)
,`idTipoContrato` int
,`descrTipoContrato` varchar(70)
,`textTipoContrato` mediumtext
,`fecAltaTipoContrato` datetime
,`fecBajaTipoContrato` datetime
,`fecModiTipoContrato` datetime
,`estTipoContrato` int
,`idPersonal` int
,`nomPersonal` varchar(40)
,`emailUsuario` varchar(50)
,`senaUsuario` varchar(45)
,`apePersonal` varchar(70)
,`dirPersonal` varchar(60)
,`poblaPersonal` varchar(70)
,`cpPersonal` varchar(7)
,`provPersonal` varchar(70)
,`paisPersonal` varchar(70)
,`tlfPersonal` varchar(12)
,`movilPersonal` varchar(12)
,`emailPersonal` varchar(60)
,`fecAltaPersonal` datetime
,`fecBajaPersonal` datetime
,`fecModiPersonal` datetime
,`rolUsuario` int
,`estPersonal` varchar(45)
,`tokenPers` varchar(225)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ratingporaloja`
--

CREATE TABLE `ratingporaloja` (
  `IdAloja_idOpi` int DEFAULT NULL,
  `media_ratingOpi` decimal(14,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rating_alojacompleto`
--

CREATE TABLE `rating_alojacompleto` (
  `IdAloja_idOpi` int DEFAULT NULL,
  `media_ratingOpi` decimal(14,4) DEFAULT NULL,
  `idAloja` int DEFAULT NULL,
  `idTipoAloja_TipoAloja` int DEFAULT NULL,
  `nifAloja` varchar(9) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `apeAloja` varchar(100) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nombreAloja` varchar(160) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpAloja` varchar(7) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `proviAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `telAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `movilAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailAloja` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textDatosPublicAloja` text COLLATE utf8mb3_spanish2_ci,
  `textDatosPrivateAloja` text COLLATE utf8mb3_spanish2_ci,
  `metrosAloja` int DEFAULT NULL,
  `wcAloja` int DEFAULT NULL,
  `HabIndiAloja` int DEFAULT NULL,
  `HabDobleAloja` int DEFAULT NULL,
  `HabTripleAloja` int DEFAULT NULL,
  `interAloja` int DEFAULT NULL,
  `descrAnimalesAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fumaAloja` int DEFAULT NULL,
  `descrFumaAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `comidasAloja` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textCasaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `nomPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacPadreAloja` date DEFAULT NULL,
  `profPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nomMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacMadreAloja` date DEFAULT NULL,
  `profMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrHijosVivenAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `aficAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `apieAloja` int DEFAULT NULL,
  `lineaAutobusAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minAutobusAloja` int DEFAULT NULL,
  `lineaMetroAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minMetroAloja` int DEFAULT NULL,
  `linkSituacionAloja` varchar(245) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `hospitalPrivAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `consultAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `hospitalPublicAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `pagoAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `estAloja` int DEFAULT NULL,
  `motvBajaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaAloja` datetime DEFAULT NULL,
  `fecBajaAloja` datetime DEFAULT NULL,
  `fecModiAloja` datetime DEFAULT NULL,
  `token` int DEFAULT NULL,
  `Alojamiento` int DEFAULT NULL,
  `capacidad_ocupado` bigint DEFAULT NULL,
  `capacidad_total` bigint DEFAULT NULL,
  `idTiposAloja` int DEFAULT NULL,
  `descrTiposAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTiposAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaTiposAloja` datetime DEFAULT NULL,
  `fecBajaTiposAloja` datetime DEFAULT NULL,
  `fecModiTiposAloja` datetime DEFAULT NULL,
  `estTiposAloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutasPersonal`
--

CREATE TABLE `rutasPersonal` (
  `idRutasProfesorado` int NOT NULL,
  `id_personalRPersonal` int DEFAULT NULL COMMENT 'viene de la tabla tm_personal',
  `idIdioma_RPersonal` int DEFAULT NULL COMMENT 'viene de la tabla tm_idiomas',
  `idtipo_RPersonal` int DEFAULT NULL COMMENT 'viene de la tabla tm_tipocurso',
  `nivelDesde_RPersonal` int DEFAULT NULL COMMENT 'De la tabla tm_nivel desde este curso',
  `nivelHasta_RPersonal` int DEFAULT NULL COMMENT 'De la tabla tm_nivel Hasta este curso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `rutasPersonal`
--

INSERT INTO `rutasPersonal` (`idRutasProfesorado`, `id_personalRPersonal`, `idIdioma_RPersonal`, `idtipo_RPersonal`, `nivelDesde_RPersonal`, `nivelHasta_RPersonal`) VALUES
(2, 29, 1, 1, 1, 2),
(3, 34, 1, 4, 1, 6),
(4, 35, 1, 1, 1, 1),
(5, 36, 1, 1, 1, 5),
(6, 36, 9, 1, 8, 8);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ruta_completo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ruta_completo` (
`id_ruta` int
,`idiomaId_ruta` int
,`descrIdioma` varchar(60)
,`codIdioma` varchar(2)
,`tipoId_ruta` int
,`descrTipo` varchar(60)
,`codTipo` varchar(3)
,`nivelId_ruta` int
,`descrNivel` varchar(30)
,`codNivel` varchar(10)
,`maxAlum_ruta` int
,`minAlum_ruta` int
,`perRefresco_ruta` int
,`medidaRefresco_ruta` int
,`descrRefresco` varchar(16)
,`estadoRuta` int
,`pesoRuta` int
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareasDiariaClase`
--

CREATE TABLE `tareasDiariaClase` (
  `idTareasDiaria` int NOT NULL,
  `idProfesorTareas` int DEFAULT NULL COMMENT 'Profesor que realiza la tarea',
  `idHorarioTareas` int DEFAULT NULL COMMENT 'id de la lista de la hora',
  `idCodigoCursoTarea` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'id Codigo largo del curso',
  `duracionTareas` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descripcionTarea` longtext COLLATE utf8mb3_spanish2_ci,
  `estTareas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `tareasDiariaClase`
--

INSERT INTO `tareasDiariaClase` (`idTareasDiaria`, `idProfesorTareas`, `idHorarioTareas`, `idCodigoCursoTarea`, `duracionTareas`, `descripcionTarea`, `estTareas`) VALUES
(1, 29, 1, 'ESINA1202509111', '0', '<p>Ej1 pag 3</p>', 1),
(2, 29, 1, 'ESINA1202509111', '0', '<p>Ej1 pag 3</p>', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifascompleto`
--

CREATE TABLE `tarifascompleto` (
  `idTarifaAloja` int UNSIGNED DEFAULT NULL,
  `idTiposAloja_TarifaAloja` int DEFAULT NULL,
  `descrTarifaAlojaInterna` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrTarifaAlojaExterna` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cantidadTarifaAloja` int DEFAULT NULL,
  `idMedidaAloja_TarifaAloja` int DEFAULT NULL,
  `impTarifaAloja` float(7,2) DEFAULT NULL,
  `cta1TarifaAloja` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cta2TarifaAloja` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaTarifaAloja` datetime DEFAULT NULL,
  `fecBajaTarifaAloja` datetime DEFAULT NULL,
  `fecModiTarifaAloja` datetime DEFAULT NULL,
  `estTarifaaloja` int DEFAULT NULL,
  `ivaTarifa` int DEFAULT NULL,
  `idTiposAloja` int DEFAULT NULL,
  `descrTiposAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTiposAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaTiposAloja` datetime DEFAULT NULL,
  `fecBajaTiposAloja` datetime DEFAULT NULL,
  `fecModiTiposAloja` datetime DEFAULT NULL,
  `estTiposAloja` int DEFAULT NULL,
  `idMedidaAloja` int DEFAULT NULL,
  `descrMedidaAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textMedidaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaMedidaAloja` datetime DEFAULT NULL,
  `fecBajaMedidaAloja` datetime DEFAULT NULL,
  `fecModiMedidaAloja` datetime DEFAULT NULL,
  `estMedidaAloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas_completo_docencia`
--

CREATE TABLE `tarifas_completo_docencia` (
  `idTarifaDoc` int UNSIGNED DEFAULT NULL,
  `idIdioma_TarifaDoc` int DEFAULT NULL,
  `idTipoCurso_TarifaDoc` int DEFAULT NULL,
  `descrTarifaDocInterna` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrTarifaDocExterna` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cantidadTarifaDoc` int DEFAULT NULL,
  `idMedida` int DEFAULT NULL,
  `impTarifaDoc` float(7,2) DEFAULT NULL,
  `cta1TarifaDoc` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cta2TarifaDoc` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaTarifaDoc` datetime DEFAULT NULL,
  `fecBajaTarifaDoc` datetime DEFAULT NULL,
  `fecModiTarifaDoc` datetime DEFAULT NULL,
  `estTarifaDoc` int DEFAULT NULL,
  `idIva_tarifaDoc` int DEFAULT NULL,
  `idIdioma` int DEFAULT NULL,
  `descrIdioma` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `codIdioma` varchar(2) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textIdioma` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaIdioma` datetime DEFAULT NULL,
  `fecModiIdioma` datetime DEFAULT NULL,
  `fecBajaIdioma` datetime DEFAULT NULL,
  `estIdioma` int DEFAULT NULL,
  `idTipo` int DEFAULT NULL,
  `descrTipo` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `codTipo` varchar(3) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTipo` mediumtext COLLATE utf8mb3_spanish2_ci,
  `minAlumTipo` int DEFAULT NULL,
  `maxAlumTipo` int DEFAULT NULL,
  `fecAltaTipoCurso` datetime DEFAULT NULL,
  `fecModiTipoCurso` datetime DEFAULT NULL,
  `fecBajaTipoCurso` datetime DEFAULT NULL,
  `estTipoCurso` int DEFAULT NULL,
  `idIva` int DEFAULT NULL,
  `descrIva` varchar(145) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `valorIva` int DEFAULT NULL,
  `textIva` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `idMedidaAloja` int DEFAULT NULL,
  `descrMedidaAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_actividadDepartamento`
--

CREATE TABLE `td_actividadDepartamento` (
  `idActividadDepartamento` int NOT NULL COMMENT 'Tabla de los departamentos que tiene una actividad',
  `idActividad_actividadDepartamento` int DEFAULT NULL COMMENT 'id de la tabla tm_actividad_edu',
  `idDepartamento_actividadDepartamento` int DEFAULT NULL COMMENT 'id de la tabla tm_departamento_edu',
  `estActividadDepartamento` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `td_actividadDepartamento`
--

INSERT INTO `td_actividadDepartamento` (`idActividadDepartamento`, `idActividad_actividadDepartamento`, `idDepartamento_actividadDepartamento`, `estActividadDepartamento`) VALUES
(1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_alumaloja`
--

CREATE TABLE `td_alumaloja` (
  `idAlumAloja` int NOT NULL COMMENT 'Es el id de la tabla',
  `idAlum_AlumAloja` varchar(255) COLLATE utf32_spanish2_ci DEFAULT NULL COMMENT 'Es el campo de uni?n con los alojamientos',
  `idAloja_AlumAloja` int DEFAULT NULL COMMENT 'Es la uni?n con la tabla de alumnos',
  `fecEntradaAlumAloja` date DEFAULT NULL COMMENT 'Fecha de entrada del alumno al alojamiento',
  `fecSalidaAlumAloja` date DEFAULT NULL COMMENT 'Fecha de salida del alumno del alojamiento',
  `horaSalidaAlumAloja` time DEFAULT NULL COMMENT 'Hora de salida del alumno del alojamiento',
  `fecAltaAlumAloja` datetime DEFAULT NULL,
  `fecBajaAlumAloja` datetime DEFAULT NULL,
  `estAlumAloja` int DEFAULT NULL,
  `fecMostrarAlumAloja` date DEFAULT NULL COMMENT 'Es la fecha a partir de la cual se le ha mostrado el alumno la ficha del alojamiento elegido, antes no podr? verlo, aunque esta ficha este creada.',
  `estMostrarAlumAloja` int DEFAULT NULL COMMENT '0 = Todavia no se le ha mostrado la ficha del alojamiento al Alumno \n1 = Ya se le mostrado la ficha del alojamiento al usuario-alumno'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci COMMENT='Es la tabla que contiene los alumnos que est?n en los alojamientos';

--
-- Volcado de datos para la tabla `td_alumaloja`
--

INSERT INTO `td_alumaloja` (`idAlumAloja`, `idAlum_AlumAloja`, `idAloja_AlumAloja`, `fecEntradaAlumAloja`, `fecSalidaAlumAloja`, `horaSalidaAlumAloja`, `fecAltaAlumAloja`, `fecBajaAlumAloja`, `estAlumAloja`, `fecMostrarAlumAloja`, `estMostrarAlumAloja`) VALUES
(1, 'kityj11efb98a977f64e2c4de414b', 1, '2025-09-21', '2025-11-01', '11:56:00', NULL, NULL, 1, '2025-09-11', 1),
(2, 'yityjve616c6be54ef2d7b17d8d18', 1, '2025-09-28', '2025-10-11', '18:39:00', NULL, NULL, 1, '2025-09-29', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_alumcurso`
--

CREATE TABLE `td_alumcurso` (
  `idAlumCurso` int NOT NULL COMMENT 'Relacion entre tm_usuario y tm_cursos',
  `idUsuario_alumcurso` int NOT NULL COMMENT 'idUsuario de la tabla tm_usuario',
  `idCurso_alumcurso` int NOT NULL COMMENT 'idCurso de la tabla tm_cursos',
  `fecAltaAlumCurso` date NOT NULL COMMENT 'Fecha de Alta del Alumno',
  `fecBajaAlumCurso` date DEFAULT NULL COMMENT 'Fecha en la que a pasado de curso',
  `alumnoActivoAlumCurso` int NOT NULL COMMENT '0/1, si el alumno sigue en el curso.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_asistenciaCurso`
--

CREATE TABLE `td_asistenciaCurso` (
  `idAsistenciaCurso` int NOT NULL,
  `idAlumno_asistenciaCurso` int NOT NULL COMMENT 'Relacionado con la tabla idUsuario - tm_usuario',
  `idCurso_asistenciaCurso` int NOT NULL COMMENT 'Relacionado con el curso idCurso - tm_cursos',
  `fechaDiaActual` date NOT NULL COMMENT 'D?a de hoy',
  `asistencia` int NOT NULL COMMENT '0/1 Ha asistido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_contenido_alumno`
--

CREATE TABLE `td_contenido_alumno` (
  `idContAlum` int NOT NULL,
  `idCurso_ContAlum` int DEFAULT NULL,
  `idCont_ContAlum` int DEFAULT NULL,
  `completado_ContAlum` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_objetivos_alumno`
--

CREATE TABLE `td_objetivos_alumno` (
  `idObjAlum` int NOT NULL,
  `idAlumno_ObjAlum` int DEFAULT NULL,
  `idCurso_ObjAlum` int DEFAULT NULL,
  `idObjetivo_ObjAlum` int DEFAULT NULL,
  `completado_ObjAlum` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_persocontrato`
--

CREATE TABLE `td_persocontrato` (
  `idPersoContrato` int NOT NULL,
  `idpersonal_PersoContrato` int NOT NULL,
  `idcontrato_PersoContrato` int NOT NULL,
  `fecInicioPersoContrato` date NOT NULL,
  `fecFinalPersoContrato` date NOT NULL,
  `textPersoContrato` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `estContrato` int NOT NULL,
  `categoriaContrato` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `jornadaContrato` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `duracionContrato` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci COMMENT='Esta es la tabla que relaciona al personal (tm_personal) con los contratos (tm_tipocontrato)';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_profecurso`
--

CREATE TABLE `td_profecurso` (
  `idProfeCurso` int NOT NULL,
  `idProfe_profecurso` int DEFAULT NULL,
  `idCurso_profecurso` int DEFAULT NULL,
  `fecAltaprofecurso` datetime DEFAULT NULL,
  `fecBajaprofecurso` datetime DEFAULT NULL,
  `profeActivoprofecurso` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_usuarioact`
--

CREATE TABLE `td_usuarioact` (
  `idUsuarioAct` int NOT NULL,
  `idUsuario_UsuarioAct` int DEFAULT NULL COMMENT 'Relaci?n idUsuario de la tabla tm_usuario. Alumno apuntado.',
  `idAct_UsuarioAct` int DEFAULT NULL COMMENT 'id de Actividad de la tabla tm_Actividad. Actividad que se ha apuntado',
  `asisUsuarioAct` int DEFAULT NULL COMMENT 'Marca 0 si el usuario no ha asistido a la actividad (Pasando lista)\nMarcar 1 si el usuario ha asistido a la actividad (Pasando Lista) = Certificado',
  `fecAltaUsuarioAct` datetime DEFAULT NULL COMMENT 'Fecha de Alta del usuario a la actividad',
  `estUsuarioAct` int DEFAULT NULL COMMENT 'Estado del usuario con la actividad. 1 = Activo (asiste a la act) 0 = Inactivo (no va ha asistir)'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci COMMENT='Aqu? relacionamos los alumnos (tm_usuario) con las Actividades (tm_actividad) Gente apuntada.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_usuarioact_edu`
--

CREATE TABLE `td_usuarioact_edu` (
  `idUsuarioAct` int NOT NULL,
  `idUsuario_UsuarioAct` int DEFAULT NULL COMMENT 'Relación idUsuario de la tabla tm_alumno_edu. Alumno apuntado.',
  `idLlegada_UsuarioAct` int DEFAULT NULL,
  `idAct_UsuarioAct` int DEFAULT NULL COMMENT 'id de Actividad de la tabla tm_Actividad. Actividad que se ha apuntado',
  `asisUsuarioAct` int DEFAULT NULL COMMENT 'Marca 0 si el usuario no ha asistido a la actividad (Pasando lista)\nMarcar 1 si el usuario ha asistido a la actividad (Pasando Lista) = Certificado',
  `fecAltaUsuarioAct` datetime DEFAULT NULL COMMENT 'Fecha de Alta del usuario a la actividad',
  `estUsuarioAct` int DEFAULT NULL COMMENT 'Estado del usuario con la actividad. 1 = Activo (asiste a la act) 0 = Inactivo (no va ha asistir)'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci COMMENT='Aquí relacionamos los alumnos (tm_usuario) con las Actividades (tm_actividad) Gente apuntada.';

--
-- Volcado de datos para la tabla `td_usuarioact_edu`
--

INSERT INTO `td_usuarioact_edu` (`idUsuarioAct`, `idUsuario_UsuarioAct`, `idLlegada_UsuarioAct`, `idAct_UsuarioAct`, `asisUsuarioAct`, `fecAltaUsuarioAct`, `estUsuarioAct`) VALUES
(2, 24, NULL, 2, NULL, '2025-09-05 09:26:57', NULL),
(4, 25, 3, 2, 0, '2025-09-11 10:32:31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testdeniveledu`
--

CREATE TABLE `testdeniveledu` (
  `idTestNivel` int NOT NULL,
  `nombreTest` varchar(255) DEFAULT NULL,
  `archivoTest_pdf` varchar(255) DEFAULT NULL,
  `tipo_curso` varchar(255) DEFAULT NULL COMMENT 'Viene de la tabla Tipo Curso',
  `idiomaTest` varchar(50) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `activo` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `testdeniveledu`
--

INSERT INTO `testdeniveledu` (`idTestNivel`, `nombreTest`, `archivoTest_pdf`, `tipo_curso`, `idiomaTest`, `fecha_creacion`, `activo`) VALUES
(1, 'Test de Ingles A2', 'english-a2.pdf', '2', 'Ingles', '2024-10-04', '1');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `testnivel&tipocurso`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `testnivel&tipocurso` (
`idTestNivel` int
,`nombreTest` varchar(255)
,`archivoTest_pdf` varchar(255)
,`tipo_curso` varchar(255)
,`idiomaTest` varchar(50)
,`fecha_creacion` date
,`activo` varchar(2)
,`idTipo` int
,`descrTipo` varchar(60)
,`codTipo` varchar(3)
,`textTipo` mediumtext
,`minAlumTipo` int
,`maxAlumTipo` int
,`fecAltaTipoCurso` datetime
,`fecModiTipoCurso` datetime
,`fecBajaTipoCurso` datetime
,`estTipoCurso` int
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmaloja_tarifascompleto`
--

CREATE TABLE `tmaloja_tarifascompleto` (
  `idAloja` int DEFAULT NULL,
  `idTipoAloja_TipoAloja` int DEFAULT NULL,
  `nifAloja` varchar(9) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `apeAloja` varchar(100) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nombreAloja` varchar(160) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpAloja` varchar(7) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `proviAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `telAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `movilAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailAloja` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textDatosPublicAloja` text COLLATE utf8mb3_spanish2_ci,
  `textDatosPrivateAloja` text COLLATE utf8mb3_spanish2_ci,
  `metrosAloja` int DEFAULT NULL,
  `wcAloja` int DEFAULT NULL,
  `HabIndiAloja` int DEFAULT NULL,
  `HabDobleAloja` int DEFAULT NULL,
  `HabTripleAloja` int DEFAULT NULL,
  `interAloja` int DEFAULT NULL,
  `descrAnimalesAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fumaAloja` int DEFAULT NULL,
  `descrFumaAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `comidasAloja` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textCasaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `nomPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacPadreAloja` date DEFAULT NULL,
  `profPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nomMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacMadreAloja` date DEFAULT NULL,
  `profMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrHijosVivenAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `aficAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `apieAloja` int DEFAULT NULL,
  `lineaAutobusAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minAutobusAloja` int DEFAULT NULL,
  `lineaMetroAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minMetroAloja` int DEFAULT NULL,
  `linkSituacionAloja` varchar(245) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `hospitalPrivAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `consultAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `hospitalPublicAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `pagoAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `estAloja` int DEFAULT NULL,
  `motvBajaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaAloja` datetime DEFAULT NULL,
  `fecBajaAloja` datetime DEFAULT NULL,
  `fecModiAloja` datetime DEFAULT NULL,
  `token` int DEFAULT NULL,
  `idTarifaAloja` int UNSIGNED DEFAULT NULL,
  `idTiposAloja_TarifaAloja` int DEFAULT NULL,
  `descrTiposAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrTarifaAlojaInterna` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrTarifaAlojaExterna` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cantidadTarifaAloja` int DEFAULT NULL,
  `idMedidaAloja_TarifaAloja` int DEFAULT NULL,
  `descrMedidaAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `impTarifaAloja` float(7,2) DEFAULT NULL,
  `cta1TarifaAloja` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cta2TarifaAloja` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaTarifaAloja` datetime DEFAULT NULL,
  `fecBajaTarifaAloja` datetime DEFAULT NULL,
  `fecModiTarifaAloja` datetime DEFAULT NULL,
  `estTarifaaloja` int DEFAULT NULL,
  `idTiposAloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_actividad_edu`
--

CREATE TABLE `tm_actividad_edu` (
  `idAct` int NOT NULL,
  `descrAct` varchar(100) CHARACTER SET utf32 COLLATE utf32_spanish2_ci DEFAULT NULL COMMENT 'Titulo de la Actividad',
  `obsAct` mediumtext CHARACTER SET utf32 COLLATE utf32_spanish2_ci COMMENT 'Observaciones Summernote',
  `fecActDesde` date DEFAULT NULL COMMENT 'Fecha de inicio de la Actividad',
  `fecActHasta` date DEFAULT NULL COMMENT 'Fecha Fin de la Actividad',
  `fecActFinSolicitud` date DEFAULT NULL COMMENT 'Fecha max para apuntarse a la Actividad',
  `estadoAct` int DEFAULT NULL COMMENT '0 = No Activo. \n1 = Activa\n2 = Cancelada (La cancela el sistema cuando llega la fecha tope de inscripcion y no se ha llegado al mínimo de alumnos designado) 3 -Fin de la solicitud (no permite apuntarse) y está a la espera de iniciarse la actividad.',
  `horaInicioAct` time DEFAULT NULL COMMENT 'Hora de Inicio Real Actividad. Texto Informativo',
  `horaFinAct` time DEFAULT NULL COMMENT 'Hora de Fin Real Actividad. Texto Informativo',
  `horasLectivasAct` varchar(11) CHARACTER SET utf32 COLLATE utf32_spanish2_ci DEFAULT NULL COMMENT 'Horas totales para el certificado',
  `imgAct` varchar(225) CHARACTER SET utf32 COLLATE utf32_spanish2_ci DEFAULT NULL COMMENT 'Imagen de la Actividad',
  `fecAltaAct` datetime DEFAULT NULL COMMENT 'Fecha de Creacion',
  `fecBajaAct` datetime DEFAULT NULL COMMENT 'Fecha de Baja',
  `fecModiAct` datetime DEFAULT NULL COMMENT 'Fecha de Modificacion',
  `puntoEncuentroAct` varchar(105) CHARACTER SET utf32 COLLATE utf32_spanish2_ci DEFAULT NULL COMMENT 'Ubicación de encuentro de la Acti',
  `idPersonal_guiaAct` int DEFAULT NULL COMMENT 'RELACION: ID del trabajador (tm_usuario) de la actividad. Es el Guia/Responsable de la actividad. Viene de la tabla tm_usuario con ROL 2',
  `minAlumAct` int DEFAULT NULL,
  `maxAlumAct` int DEFAULT NULL,
  `departamentoDisponible` longtext CHARACTER SET utf32 COLLATE utf32_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci COMMENT='Tabla mantenimiento de Actividades Extras.';

--
-- Volcado de datos para la tabla `tm_actividad_edu`
--

INSERT INTO `tm_actividad_edu` (`idAct`, `descrAct`, `obsAct`, `fecActDesde`, `fecActHasta`, `fecActFinSolicitud`, `estadoAct`, `horaInicioAct`, `horaFinAct`, `horasLectivasAct`, `imgAct`, `fecAltaAct`, `fecBajaAct`, `fecModiAct`, `puntoEncuentroAct`, `idPersonal_guiaAct`, `minAlumAct`, `maxAlumAct`, `departamentoDisponible`) VALUES
(1, 'Visita al Centro Histu00f3rico', '<p>geg</p>', '2025-09-03', '2025-09-03', '2025-09-02', 0, '16:27:00', '18:27:00', '2', '160.jpeg', '2025-09-02 13:47:14', NULL, NULL, 'El instituto Palau', 29, 1, 2, NULL),
(2, 'Visita al Centro Histórico', '<p>geg</p>', '2025-09-03', '2025-09-03', '2025-09-02', 0, '16:27:00', '18:27:00', '2', '160.jpeg', '2025-09-02 13:47:30', NULL, '2025-09-11 10:11:31', 'El instituto Palau', 29, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_agentes_edu`
--

CREATE TABLE `tm_agentes_edu` (
  `idAgente` int NOT NULL COMMENT 'El encargado de responsable de un grupo de alumnos',
  `nombreAgente` varchar(225) DEFAULT NULL,
  `identificacionFiscal` varchar(15) DEFAULT NULL COMMENT 'DNI,CIF:....',
  `domicilioFiscal` varchar(225) DEFAULT NULL COMMENT 'Calle',
  `correoAgente` varchar(255) DEFAULT NULL COMMENT 'Correo par aenivar datos',
  `estAgente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_agentes_edu`
--

INSERT INTO `tm_agentes_edu` (`idAgente`, `nombreAgente`, `identificacionFiscal`, `domicilioFiscal`, `correoAgente`, `estAgente`) VALUES
(1, 'Tsuyoshi', '03160886L', 'Dvvfdvf', 'josee@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_albaran`
--

CREATE TABLE `tm_albaran` (
  `idAlbaran` int NOT NULL,
  `numFact_albaran` int DEFAULT NULL,
  `idMaterial_albaran` int DEFAULT NULL,
  `idTarifa_albaran` int DEFAULT NULL,
  `idCliente_albaran` int DEFAULT NULL,
  `idGrupo_albaran` int DEFAULT NULL,
  `fecAlta_albaran` datetime DEFAULT NULL,
  `fecBaja_albaran` datetime DEFAULT NULL,
  `fecModi_albaran` datetime DEFAULT NULL,
  `pagoACuenta_albaran` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_aloja`
--

CREATE TABLE `tm_aloja` (
  `idAloja` int NOT NULL,
  `idTipoAloja_TipoAloja` int DEFAULT NULL COMMENT 'Por EJ: Alojamiento en familia - Hotel',
  `nifAloja` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT '''El campo servira para el CIF o NIF''',
  `apeAloja` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'En caso de familia apellidos - en caso de local el nombre a facturar',
  `nombreAloja` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'En caso de familia sera el nombre - en caso de local se dejara Libre',
  `dirAloja` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Dirección del alojamiento',
  `cpAloja` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'código postal del alojamiento',
  `poblaAloja` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Poblacion del alojamiento',
  `proviAloja` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Provincia del aloja',
  `telAloja` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Teléfono del propietario del alojamiento',
  `movilAloja` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `emailAloja` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Email del propietario del alojamiento',
  `textDatosPublicAloja` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'Esta campo es una campo de observaciones de esta primera solapa y será visible por la familia',
  `textDatosPrivateAloja` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT ' Esta campo es una campo de observaciones de esta primera solapa- esta solapa debe ser privada de la academia y en nigún caso deberá enviarse a la familia.',
  `metrosAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'metros cuadrados de la vivienda. (CASA)',
  `wcAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'número de asesos de la vivienda. (CASA)',
  `HabIndiAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Habitaciones individuales disponibles. (CASA)',
  `HabDobleAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Habitaciones dobles disponibles. (CASA)',
  `HabTripleAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Habitaciones triples disponibles.(CASA)',
  `interAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT '1=Si que hay internet disponble - 0 = No hay internet disponible. (CASA)',
  `descrAnimalesAloja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'por ej si tienen Perro - Gato - etc.. (CASA)',
  `fumaAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT ' 1=Permitido fumar - 0=No permitido fumar. (CASA)',
  `descrFumaAloja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Donde se permite fumar.(CASA)',
  `comidasAloja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'campos descr para que muestren el horario de comidas.  (CASA)',
  `textCasaAloja` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT ' Campo de observaciones de la CASA. (CASA)',
  `nomPadreAloja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'nombre del Padre (MIEMBROS)',
  `nacPadreAloja` date DEFAULT NULL COMMENT 'fecha de nacimiento del Padre  (MIEMBROS)',
  `profPadreAloja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'profesión del Padre  (MIEMBROS)',
  `nomMadreAloja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'nombre de la Madre  (MIEMBROS)',
  `nacMadreAloja` date DEFAULT NULL COMMENT 'fecha de nacimiento de la Madre  (MIEMBROS)',
  `profMadreAloja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'profesión de la Madre  (MIEMBROS)',
  `descrHijosVivenAloja` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'hijos que viven en casa- nombres- edades - etc...  (MIEMBROS)',
  `aficAloja` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT ' Aficiones que hay en la casa  (MIEMBROS)',
  `apieAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT ' tiempo en minutos que se tarda en llegar a la escuela a pie. (SITUACIÓN) ',
  `lineaAutobusAloja` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'linea de autobus que se puede cojer para llegar a la escuela.  (SITUACIÓN) ',
  `minAutobusAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'minutos que tarda la linea de autobus en llegar a la escuela. (SITUACIÓN) ',
  `lineaMetroAloja` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT ' linea de metro que se puede coger para llegar a la escuela. (SITUACIÓN) ',
  `minMetroAloja` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT ' minutos que tarda la linea de metro en llegar a la escuela. (SITUACIÓN) ',
  `linkSituacionAloja` varchar(245) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT ' link de google para acceder a la situación (SITUACIÓN) ',
  `hospitalPrivAloja` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'introducir la dirección del hospital privado cercano al alojamiento. (ADMINISTRACIÓN)',
  `consultAloja` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT ', introducir la dirección del consultorio cercano al alojamiento. (ADMINISTRACIÓN)',
  `hospitalPublicAloja` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'introducir la dirección del hospital público cercano al alojamiento. (ADMINISTRACIÓN)',
  `pagoAloja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT ' Cuenta bancaria de pago a la familia (ADMINISTRACIÓN)',
  `estAloja` int DEFAULT NULL COMMENT '1=Alta 0=Baja (ADMINISTRACIÓN)',
  `motvBajaAloja` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'motivo por el que se ha dado de baja. (ADMINISTRACIÓN)',
  `fecAltaAloja` datetime DEFAULT NULL,
  `fecBajaAloja` datetime DEFAULT NULL,
  `fecModiAloja` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'TOKEN PARA LA FAMILIA. PERMISOS DE EDICION. SI ESTA VACIO NO PUEDE EDITAR',
  `idAlojamientoTexto` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Id en texto que quiere  F23'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_aloja`
--

INSERT INTO `tm_aloja` (`idAloja`, `idTipoAloja_TipoAloja`, `nifAloja`, `apeAloja`, `nombreAloja`, `dirAloja`, `cpAloja`, `poblaAloja`, `proviAloja`, `telAloja`, `movilAloja`, `emailAloja`, `textDatosPublicAloja`, `textDatosPrivateAloja`, `metrosAloja`, `wcAloja`, `HabIndiAloja`, `HabDobleAloja`, `HabTripleAloja`, `interAloja`, `descrAnimalesAloja`, `fumaAloja`, `descrFumaAloja`, `comidasAloja`, `textCasaAloja`, `nomPadreAloja`, `nacPadreAloja`, `profPadreAloja`, `nomMadreAloja`, `nacMadreAloja`, `profMadreAloja`, `descrHijosVivenAloja`, `aficAloja`, `apieAloja`, `lineaAutobusAloja`, `minAutobusAloja`, `lineaMetroAloja`, `minMetroAloja`, `linkSituacionAloja`, `hospitalPrivAloja`, `consultAloja`, `hospitalPublicAloja`, `pagoAloja`, `estAloja`, `motvBajaAloja`, `fecAltaAloja`, `fecBajaAloja`, `fecModiAloja`, `token`, `idAlojamientoTexto`) VALUES
(1, 1, '03160886L', 'B11', 'Costa AAA', 'C/ Costa', '46970', 'Alaquas', 'Valencia', '965965965', '654654654', 'jose.mvb.cc@gmail.com', '', '', '92', '2', '3', '3', '1', '1', '', '0', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '0', '', '0', '0', '0', '', 'Este', 'Mas cercano', 'Clinico', 'Es58545885445', 0, '', '2025-09-11 09:52:26', NULL, '2025-10-01 13:11:42', 'kityk1zz3b03d684ece07c8beb331643', NULL),
(2, 1, 'B96754593', '', 'Costa de Valencia, SL', 'Avda. Blasco Ibáñez, 66', '46021', 'Valencia', 'Valencia', 'NULL', '696699493', 'info@costadevalencia.com', '', '', '0', '2', '2', '2', '0', '1', 'NO', '0', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '2', '', '0', '0', '0', '', 'HOSPITAL QUIRÓN', 'Av. de Blasco Ibáñez, 17, \r\n46010 València, Valencia\r\nTeléfono: 961 97 35 00\r\n', 'HOSPITAL CLÍNICO UNIVERSITARIO', 'ES66 0081 0229 8500 0125 7529', 1, '', '2025-09-24 18:25:07', NULL, '2025-10-01 12:05:53', 'xitytyg9900374075bd860b1caf11cb', NULL),
(3, 1, '', '', 'EA24', '', '', '', '', '', '', 'manuel@costadevalencia.com', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '', '2025-09-24 18:49:57', NULL, '2025-09-24 18:50:20', 'xityt1w11efe02295e3c72e54b8ade32', NULL),
(4, 2, '', '', 'Hjhj', '', '', '', '', 'NULL', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '', '2025-10-07 09:34:14', NULL, '2025-10-07 13:05:54', 'gjtyk1hnce84d493ea7f81437aa0557f', ''),
(5, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '2025-10-07 12:18:35', NULL, '2025-10-07 12:18:54', 'gjtynr1i91ca26a6683d3a743241cbe2', 'F001 familia-333'),
(6, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '1', '', '', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '', '2025-10-17 10:28:40', NULL, '2025-10-17 10:30:54', 'qjtyl1b1na3bcd253337e5e6c4752c6', 'BI11.1'),
(7, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '', '2025-10-17 10:29:29', NULL, '2025-10-17 10:30:58', 'qjtyl1c1c90a647d7bbbd344c10d886', 'BI11.2'),
(8, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '', '1', '', '', '', '', '', '', '1970-01-01', '', '', '1970-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '', '2025-10-17 10:30:02', NULL, '2025-10-17 10:31:02', 'qjtyl1dbd66e9012cfefe67246c4d709', 'BI11.3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_alojaimpr`
--

CREATE TABLE `tm_alojaimpr` (
  `IdAlojaImp` int NOT NULL,
  `idAloja_AlojaImpr` int NOT NULL COMMENT 'es el campo de unión con la tabla tm_Aloja',
  `fechaAlojaImpr` date DEFAULT NULL COMMENT 'fecha de la alta de la impresión',
  `descrImpreAlojaIm` mediumtext CHARACTER SET utf32 COLLATE utf32_spanish2_ci COMMENT 'impresiones del alumno'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_alojamientosllegadas_edu`
--

CREATE TABLE `tm_alojamientosllegadas_edu` (
  `idAlojamientoLlegada` int NOT NULL,
  `idLlegada_alojamientos` int NOT NULL COMMENT 'Viene de la tabla Llegadas',
  `idIvaTarifa_alojamientos` varchar(225) DEFAULT NULL COMMENT 'El Iva asociado a la tarifa',
  `idDepartamentoTarifa_alojamientos` varchar(225) DEFAULT NULL COMMENT 'El departamento asociado a la tarifa',
  `codTarifa_alojamientos` varchar(255) DEFAULT NULL COMMENT 'El codTarifa asociado a la tarifa',
  `nombreTarifa_alojamientos` varchar(255) DEFAULT NULL COMMENT 'El nombreTarifa asociado a la tarifa',
  `unidadTarifa_alojamientos` varchar(255) DEFAULT NULL COMMENT 'El unidadTarifa_alojamientos asociado a la tarifa',
  `precioTarifa_alojamientos` varchar(255) DEFAULT NULL COMMENT 'El precioTarifa_alojamientos asociado a la tarifa',
  `cuenta1Tarifa_alojamientos` varchar(225) DEFAULT NULL COMMENT 'El cuenta1Tarifa_alojamientos asociado a la tarifa',
  `cuenta2Tarifa_alojamientos` varchar(225) DEFAULT NULL COMMENT 'El cuenta2Tarifa_alojamientos a la tarifa',
  `cuenta3Tarifa_alojamientos` varchar(225) DEFAULT NULL COMMENT 'El cuenta3Tarifa_alojamientos a la tarifa',
  `tipoTarifa_alojamientos` varchar(225) DEFAULT NULL COMMENT 'El tipoTarifa_alojamientos a la tarifa',
  `descripcionTarifa_alojamientos` varchar(225) DEFAULT NULL COMMENT 'El descripcionTarifa_alojamientos a la tarifa',
  `fechaInicioAlojamientos` date DEFAULT NULL COMMENT 'Fecha de inciio de alojamientos, suele ser un Lunes',
  `fechaFinAlojamientos` date DEFAULT NULL,
  `estAlojamientos_llegadas` int DEFAULT NULL COMMENT ' ESTADOS DE LAS LINEAS de ALOJAMIENTOS  (estAlojamientos_llegadas)     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)   1 = ACTIVO ENTRE LAS FECHAS DE LA ALOJAMIENTO         2 - ESPERANDO INICIO DEL ALOJAMIENTO    3 - FINALIZADO EL ALOJAMIENTO    4 - NO TIENE ALOJAMIENTO',
  `obsAlojamientos` longtext,
  `descuento_Alojamientos` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_alojamientosllegadas_edu`
--

INSERT INTO `tm_alojamientosllegadas_edu` (`idAlojamientoLlegada`, `idLlegada_alojamientos`, `idIvaTarifa_alojamientos`, `idDepartamentoTarifa_alojamientos`, `codTarifa_alojamientos`, `nombreTarifa_alojamientos`, `unidadTarifa_alojamientos`, `precioTarifa_alojamientos`, `cuenta1Tarifa_alojamientos`, `cuenta2Tarifa_alojamientos`, `cuenta3Tarifa_alojamientos`, `tipoTarifa_alojamientos`, `descripcionTarifa_alojamientos`, `fechaInicioAlojamientos`, `fechaFinAlojamientos`, `estAlojamientos_llegadas`, `obsAlojamientos`, `descuento_Alojamientos`) VALUES
(1, 1, '16 %', NULL, 'fad13', 'Alojamiento en familia, AD', NULL, '2.390,00€', NULL, NULL, NULL, NULL, NULL, '2025-08-22', '2025-11-25', 3, '', '0 %'),
(2, 3, '16 %', NULL, 'hi6', '', NULL, '915,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-21', '2025-11-01', 3, '', '0 %'),
(3, 7, 'null %', NULL, 'hi3', '', NULL, '465,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-28', '2025-10-11', 3, '', '0 %'),
(4, 9, 'null %', NULL, 'hi2', '', NULL, '315,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-01', '2025-10-21', 3, '', '0 %'),
(5, 9, 'null %', NULL, 'hie5', '', NULL, '150,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-01', '2025-10-05', 3, '', '0 %'),
(6, 10, '16 %', NULL, 'hi2', '', NULL, '315,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-18', 3, '', '0 %'),
(7, 10, '16 %', NULL, 'hie', '', NULL, '30,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-18', '2025-10-19', 3, '', '0 %'),
(9, 11, '16 %', NULL, 'hd2', '', NULL, '250,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-18', 3, '', '0 %'),
(10, 11, '16 %', NULL, 'hde', '', NULL, '25,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-18', '2025-10-19', 3, '', '0 %'),
(11, 12, '16 %', NULL, 'hd2', '', NULL, '250,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-18', 3, '', '0 %'),
(12, 12, '16 %', NULL, 'hde', '', NULL, '25,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-18', '2025-10-19', 3, '', '0 %'),
(13, 17, '16 %', NULL, 'hd3', '', NULL, '370,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-11-18', 3, '', '0 %'),
(14, 28, '16 %', NULL, 'hi2', '', NULL, '315,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-26', '2025-11-08', 3, '', '0 %'),
(15, 29, '16 %', NULL, 'hi2', '', NULL, '315,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-26', '2025-11-08', 3, '', '0 %'),
(16, 30, '16 %', NULL, 'hi2', '', NULL, '315,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-26', '2025-11-08', 3, '', '0 %'),
(19, 29, '16 %', NULL, 'hie', '', NULL, '30,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-08', '2025-11-09', 3, '', '0 %'),
(20, 6, '16 %', NULL, 'fpc2', 'Alojamiento en familia, PC', NULL, '480,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-29', '2025-10-11', 3, '', '0 %'),
(21, 4, '16 %', NULL, 'fad10', 'Alojamiento en familia, AD', NULL, '1.850,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-20', '2026-01-24', 1, '', '0 %'),
(22, 39, '16 %', NULL, 'fad13', 'Alojamiento en familia, AD', NULL, '2.390,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-02', '2026-02-28', 1, '', '0 %'),
(23, 38, '16 %', NULL, 'fad15', 'Alojamiento en familia, AD', NULL, '2.750,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2026-02-14', 1, '', '0 %'),
(24, 15, '16 %', NULL, 'fad16', 'Alojamiento en familia, AD', NULL, '2.930,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-13', '2026-01-31', 1, '', '0 %'),
(25, 42, '16 %', NULL, 'hi2', '', NULL, '315,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-02', '2025-12-13', 3, '', '0 %'),
(26, 42, '16 %', NULL, 'hie', '', NULL, '30,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-13', '2025-12-14', 3, '', '0 %'),
(27, 44, '16 %', NULL, 'fad14', 'Alojamiento en familia, AD', NULL, '2.570,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-01', '2026-03-07', 1, '', '0 %'),
(28, 46, '16 %', NULL, 'fad2', '', NULL, '390,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-01', '2025-12-12', 3, '', '0 %'),
(29, 49, '16 %', NULL, 'fad12', 'Alojamiento en familia, AD', NULL, '2.210,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-10', '2026-02-28', 1, '', '0 %');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_alojaopis`
--

CREATE TABLE `tm_alojaopis` (
  `idOpi` int NOT NULL,
  `idUsu_IdOpi` int NOT NULL COMMENT 'id usuario relaci?n con la tabla tm_usuario',
  `IdAloja_idOpi` int NOT NULL COMMENT 'id alojamiento relaci?n con la tabla tm_aloja',
  `descrOpi` varchar(200) CHARACTER SET utf32 COLLATE utf32_spanish2_ci NOT NULL,
  `ratingOpi` int NOT NULL COMMENT 'VALORACIONES ESTRELLAS - 1 - 2 - 3 - 4 - 5',
  `fechaOpi` date DEFAULT NULL,
  `estOpi` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_alojaopis`
--

INSERT INTO `tm_alojaopis` (`idOpi`, `idUsu_IdOpi`, `IdAloja_idOpi`, `descrOpi`, `ratingOpi`, `fechaOpi`, `estOpi`) VALUES
(1, 18, 1, '<p>Me gusto mucho</p>', 5, '2025-09-11', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_alojavis`
--

CREATE TABLE `tm_alojavis` (
  `IdAlojaVis` int NOT NULL,
  `idAloja_AlojaVi` varchar(255) COLLATE utf32_spanish2_ci NOT NULL COMMENT 'es el campo de unión con la tabla tm_Aloja',
  `fechaAlojaVis` date DEFAULT NULL COMMENT 'fecha de la visita',
  `quienAlojaVis` varchar(250) CHARACTER SET utf32 COLLATE utf32_spanish2_ci NOT NULL COMMENT 'quien realiza a visita. (Se coloca un varchar- por que no podemos asegurar que sea el personal',
  `descrImpreAloja` mediumtext CHARACTER SET utf32 COLLATE utf32_spanish2_ci COMMENT 'impresiones de la visita'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_alojavis`
--

INSERT INTO `tm_alojavis` (`IdAlojaVis`, `idAloja_AlojaVi`, `fechaAlojaVis`, `quienAlojaVis`, `descrImpreAloja`) VALUES
(1, 'kityk1zz3b03d684ece07c8beb331643', '2025-09-11', 'Ruben', '<p>fdfsfd</p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_alumno_edu`
--

CREATE TABLE `tm_alumno_edu` (
  `idAlumno` int NOT NULL,
  `nomUsuario` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Nombre del usuario que va a acceder',
  `emailUsuario` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `senaUsuario` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Contraseña del usuario que va a acceder',
  `fecAltaUsuario` datetime DEFAULT NULL,
  `fecBajaUsuario` datetime DEFAULT NULL,
  `fecModiUsuario` datetime DEFAULT NULL,
  `avatarUsuario` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'avatarUsuario',
  `estUsu` int DEFAULT NULL,
  `nomAlumno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Nombre del alumno',
  `apeAlumno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Apellido del alumno',
  `fecNacAlumno` date DEFAULT NULL COMMENT '1- Fecha de nacimiento del alumno',
  `nacioAlumno` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '1- Nacionalidad del alumno (Española, Inglesa, etc..)',
  `ProfeEstuAlumno` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '1- Profesión, Estudios máximos del alumno',
  `EmpresaAlumno` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '1- En el caso de trabajar, nombre de la empresa',
  `UniAlumno` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '1- Si proviene de universidad, el nombre de la misma',
  `teleAlumno` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '1-Teléfono del alumno',
  `domValAlumno` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '1- Domicilio en Valencia',
  `domOrigenAlumno` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '1- Domicilio en el pais de origen',
  `lenMatAlumno` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2 - A - Lenguajes maternos',
  `lenCon1Alumno` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2- A - Lenguajes que conoce - 1 (De un total de 4)',
  `lenCon2Alumno` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2- A - Lenguajes que conoce - 2 (De un total de 4)',
  `lenCon3Alumno` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2- A - Lenguajes que conoce - 3 (De un total de 4)',
  `lenCon4Alumno` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2- A - Lenguajes que conoce - 4 (De un total de 4)',
  `estEspAlumno` int DEFAULT NULL COMMENT '2 - A - ¿Has estudiado antes español? (Si = 1, 0 = No)',
  `nivEspAlumno` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2 - A - Nivel alcanzado de Español',
  `tiemEspAlumno` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2 - A - Cuanto tiempo has estudiado español',
  `lugEspAlumno` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '2 - A - donde has estudiado español?',
  `porEspAlumno` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci COMMENT '2 - B - Por que quieres aprender español.',
  `mejEspAlumno` int DEFAULT NULL COMMENT '2 - B - ¿que necesitas mejorar en Español?\n1 = Comprensión auditiva\n2 = Comprensión lectora\n3 = Expresión oral\n4 = Expresión escrita\n5 = Pronunciación\n6 = Vocabulario\n7 = Gramática\n8 = Cultura',
  `aprEspAlumno` int DEFAULT NULL COMMENT '2 - C - ¿Como aprendo?\n1 = Leer\n2 = Escuchar\n3 = Escribir\n4 = Hablar\n5 = Traducir a mi idioma\n6 = Estar con nativos',
  `act1Alumno` int DEFAULT NULL COMMENT '2 - C - ¿que actividades te gusta hacer en clase? \nActividades comunicativas\n1 = Si, 0 = No (1 / 7)',
  `act2Alumno` int DEFAULT NULL COMMENT '2 - C - ¿que actividades te gusta hacer en clase? \nAprender Vocabulario\n1 = Si, 0 = No (2 / 7)',
  `act3Alumno` int DEFAULT NULL COMMENT '2 - C - ¿que actividades te gusta hacer en clase? \nAprender con juegos\n1 = Si, 0 = No (3 / 7)',
  `act4Alumno` int DEFAULT NULL COMMENT '2 - C - ¿que actividades te gusta hacer en clase? \nPracticar gramática\n1 = Si, 0 = No (4 / 7)',
  `act5Alumno` int DEFAULT NULL COMMENT '2 - C - ¿que actividades te gusta hacer en clase? \nActividades Audiovisuales\n1 = Si, 0 = No (5 / 7)',
  `act6Alumno` int DEFAULT NULL COMMENT '2 - C - ¿que actividades te gusta hacer en clase? \nActividades interactivas\n1 = Si, 0 = No (6 / 7)',
  `act7Alumno` int DEFAULT NULL COMMENT '2 - C - ¿que actividades te gusta hacer en clase? \nHacer deberes\n1 = Si, 0 = No (7 / 7)',
  `gustaTraAlumno` int DEFAULT NULL COMMENT '2 - C - ¿como te gusta trabajar?\n1 = solo\n2 = En parejas\n3 = Grupos',
  `gus1EspAlumno` int DEFAULT NULL COMMENT '2 - D - Durante mi curso de Español me gustaría.\nGanar fluidez y seguridad al comunicarme\n1 = Si, 0 = No',
  `gus2EspAlumno` int DEFAULT NULL COMMENT '2 - D - Durante mi curso de Español me gustaría.\nrevisar contenidos dificiles para mi\n1 = Si, 0 = No',
  `gus3EspAlumno` int DEFAULT NULL COMMENT '2 - D - Durante mi curso de Español me gustaría.\nMejorar mis calificaciones de español\n1 = Si, 0 = No',
  `gus4EspAlumno` int DEFAULT NULL COMMENT '2 - D - Durante mi curso de Español me gustaría.\nAprender nuevos contenidos\n1 = Si, 0 = No',
  `gus5EspAlumno` int DEFAULT NULL COMMENT '2 - D - Durante mi curso de Español me gustaría.\nOtros\n1 = Si, 0 = No',
  `gusTextEspAlumno` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Se activará cuando se gus5EspAlumno = 1 (otros)',
  `conAlumno` int DEFAULT NULL COMMENT '3 - como nos ha conocido\n1 = Internet\n2 = Recomendacion\n3 = Agencia\n4 = Anuncio',
  `conRecoAlumno` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '3 - en caso de que conAlumno= 2 habilitamos para este añadir descripción',
  `conAgenAlumno` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '3 - En caso de que conAlumno = 3, habilitar este campo para meter nombre de la agencia',
  `actSocialesAlumno` int DEFAULT NULL COMMENT '4 - Actividades extraacadémicas\nActividades Sociales\n1 = Si 0=No',
  `actCultAlumno` int DEFAULT NULL COMMENT '4 - Actividades extraacadémicas\nActividades culturales\n1 = Si 0=No',
  `actGastroAlumno` int DEFAULT NULL COMMENT '4 - Actividades extraacadémicas\nActividades Gastronómicas\n1 = Si 0=No',
  `actDepoAlumno` int DEFAULT NULL COMMENT '4 - Actividades extraacadémicas\nActividades Deportivas\n1 = Si 0=No',
  `partActAlumno` int DEFAULT NULL COMMENT '4 - ¿Te gustaría participar?\n1 = Si 0=No',
  `numActAlumno` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '4 - Actividades extraacadémicas\ntu número de móvil para participar en grupo de WhatsApp',
  `UltimaSesion` date DEFAULT NULL,
  `tokenUsu` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `identificadorPersonal` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'NIF, DNI, Numero identificativo',
  `perfilBloqueado` tinyint(1) DEFAULT '0',
  `idInscripcion_tmAlumno` int DEFAULT NULL COMMENT 'Viene de la tabla de inscripcion al crear la isncripcion',
  `idUsuario_tmalumno` int DEFAULT NULL COMMENT 'Viene de la tabla tm_usuario al crear el usuario ',
  `depaActivo` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT '0/1 si tiene un departamento PAGADO Activo. Cuando se caduque sera 0',
  `depasNameActivos` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'Nos dira concretamente que departametnos estan activos',
  `agoraAlumno` int DEFAULT NULL COMMENT 'Es agorofobico. Espacios cerrados',
  `minusvaliaAlumno` int DEFAULT NULL COMMENT 'minusvalia',
  `obsMinusvaliaAlumno` longtext COLLATE utf8mb3_spanish2_ci COMMENT 'motivos, que le ocurre, medicamentos, etc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci COMMENT='Tabla de usuarios';

--
-- Volcado de datos para la tabla `tm_alumno_edu`
--

INSERT INTO `tm_alumno_edu` (`idAlumno`, `nomUsuario`, `emailUsuario`, `senaUsuario`, `fecAltaUsuario`, `fecBajaUsuario`, `fecModiUsuario`, `avatarUsuario`, `estUsu`, `nomAlumno`, `apeAlumno`, `fecNacAlumno`, `nacioAlumno`, `ProfeEstuAlumno`, `EmpresaAlumno`, `UniAlumno`, `teleAlumno`, `domValAlumno`, `domOrigenAlumno`, `lenMatAlumno`, `lenCon1Alumno`, `lenCon2Alumno`, `lenCon3Alumno`, `lenCon4Alumno`, `estEspAlumno`, `nivEspAlumno`, `tiemEspAlumno`, `lugEspAlumno`, `porEspAlumno`, `mejEspAlumno`, `aprEspAlumno`, `act1Alumno`, `act2Alumno`, `act3Alumno`, `act4Alumno`, `act5Alumno`, `act6Alumno`, `act7Alumno`, `gustaTraAlumno`, `gus1EspAlumno`, `gus2EspAlumno`, `gus3EspAlumno`, `gus4EspAlumno`, `gus5EspAlumno`, `gusTextEspAlumno`, `conAlumno`, `conRecoAlumno`, `conAgenAlumno`, `actSocialesAlumno`, `actCultAlumno`, `actGastroAlumno`, `actDepoAlumno`, `partActAlumno`, `numActAlumno`, `UltimaSesion`, `tokenUsu`, `identificadorPersonal`, `perfilBloqueado`, `idInscripcion_tmAlumno`, `idUsuario_tmalumno`, `depaActivo`, `depasNameActivos`, `agoraAlumno`, `minusvaliaAlumno`, `obsMinusvaliaAlumno`) VALUES
(6, 'Jose Manuel748', 'jose@efeuno.es', NULL, NULL, NULL, '2025-05-28 11:06:34', NULL, 1, 'Jose Manuel', 'Vilar Beas', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, '', NULL, 'zatyq1md4aa4b527a70225157e7626', '202501261726JV', 0, 6, 9, NULL, NULL, 1, 1, 'Alergia a las abejas'),
(7, 'Luis997', 'costavalencia@ra82.es', NULL, NULL, NULL, '2025-05-27 10:01:10', NULL, 1, 'Luis', 'Marquez', '2025-01-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zatyt1l1f34ec0d3c9b1080059971', '202501262037LM', 0, 7, 10, NULL, NULL, NULL, NULL, NULL),
(14, 'Alejandro928', 'alejandrojimenez4286@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'Alejandro', 'Jimenez', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bgtymv1yee172551132e4092dcf4e0', '202507021322AJ', 0, 14, 21, NULL, NULL, NULL, NULL, NULL),
(16, 'Luis Carlos408', 'luiscarlos@ra82.es', NULL, NULL, NULL, NULL, NULL, 1, 'Luis Carlos', 'Pérez', '1964-05-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vhtyk1m1be1635bce84fe9b9c3a65', '21451574A', 0, 16, 23, NULL, NULL, NULL, NULL, NULL),
(17, 'luis630', 'jose.mvb.cc@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'luis', 'Carlos', '1999-02-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zhtyl1s1b88f882ea9a25a5bbc009', '202508261245LC', 0, 17, 24, NULL, NULL, NULL, NULL, NULL),
(18, 'shoei497', 'luiscarlospm@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'shoei', 'Kaneyama', '1999-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kityj11efb98a977f64e2c4de414b', '202509111050SK', 0, 18, 25, NULL, NULL, NULL, NULL, NULL),
(19, 'uno134', 'manuel.villamayor@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'uno', 'AlumnoUno', '1980-11-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yityjve616c6be54ef2d7b17d8d18', '1111111', 0, 19, 26, NULL, NULL, NULL, NULL, NULL),
(20, 'dos436', 'mail@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'dos', 'AlumnoDOS', '2012-03-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1cityr1ypfcfba871ae229af87372', 'B9675493', 0, 20, 27, NULL, NULL, NULL, NULL, NULL),
(21, 'peter767', 'mail2@mail.es', NULL, NULL, NULL, NULL, NULL, 1, 'peter', 'kyo', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ajtyn1oe01d3a11d05578784a9261', '202510011359PK', 0, 21, 28, NULL, NULL, NULL, NULL, NULL),
(22, 'son726', 'mail2@mail.es', NULL, NULL, NULL, NULL, NULL, 1, 'son', 'kyo', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ajtyna1j7d6475c8490f504e684db1', '202510011401SK', 0, 22, 29, NULL, NULL, NULL, NULL, NULL),
(23, 'hija767', 'mail2@mail.es', NULL, NULL, NULL, NULL, NULL, 1, 'hija', 'Kyo', '2010-10-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ajtyncx76be660144c230119b2877', '202510011402HK', 0, 23, 30, NULL, NULL, NULL, NULL, NULL),
(24, 'jaime898', 'jaime@ominio.es', NULL, NULL, NULL, NULL, NULL, 1, 'jaime', 'pernales', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mjtyo1tsb8b4898ef68773ff177572', '123142hhh', 0, 24, 31, NULL, NULL, NULL, NULL, NULL),
(25, 'maria623', 'maria@dominio.es', NULL, NULL, NULL, NULL, NULL, 1, 'maria', 'pernales', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mjtyo1u1lc20608d3660deb1c2fd2', '12345kkk', 0, 25, 32, NULL, NULL, NULL, NULL, NULL),
(26, 'pablo839', 'mi@mal.es', NULL, NULL, NULL, NULL, NULL, 1, 'pablo', 'picasso', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mjtyw1s1w12ffbe1c62c458461b2b', 'B96754533', 0, 26, 33, NULL, NULL, NULL, NULL, NULL),
(27, 'mobin862', 'nolotengo@mail.es', NULL, NULL, NULL, NULL, NULL, 1, 'mobin', 'Bibakesfahlan', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'qjtyl1j1zead9b9c75147f867108c', '25101701', 0, 27, 35, NULL, NULL, NULL, NULL, NULL),
(28, 'haesun564', 'nomelose@mail.es', NULL, NULL, NULL, NULL, NULL, 1, 'haesun', 'Jin', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'qjtyl1m11g60ce93d96cfe55192e04', '25101702', 0, 28, 36, NULL, NULL, NULL, NULL, NULL),
(29, 'antonio390', 'prieto@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'antonio', 'prieto', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytfod9e3e8fe7b091f4986cd25', '1112225k', 0, 29, 39, NULL, NULL, NULL, NULL, NULL),
(30, 'jose456', 'jz@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'jose', 'zorrilla', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytgf7ff70096672128067e1fff', '333335655h', 0, 30, 40, NULL, NULL, NULL, NULL, NULL),
(31, 'maria427', 'santos@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'maria', 'santos', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytnh833d36ce6c5139fd8076c3', '333356644g', 0, 31, 41, NULL, NULL, NULL, NULL, NULL),
(32, 'javier655', 'perez@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'javier', 'perez', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytp1gee17089b615589faabff90', '55646666l', 0, 32, 42, NULL, NULL, NULL, NULL, NULL),
(33, 'roberto393', 'feliz@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'roberto', 'Feliz', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtyttm6cba6471161f253c0f9fb8', '44455555k', 0, 33, 43, NULL, NULL, NULL, NULL, NULL),
(34, 'jesus220', 'jesus@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'jesus', 'vazquez', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtyt1lo5f565b107e6481ca87b35d', '45566665', 0, 34, 44, NULL, NULL, NULL, NULL, NULL),
(35, 'primer887', 'primer@hermano.es', NULL, NULL, NULL, NULL, NULL, 1, 'primer', 'HERMANO', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysh1ke70b26b2eea80b8ddb1739', '1H', 0, 35, 45, NULL, NULL, NULL, NULL, NULL),
(36, 'segundo828', 'segundo@hermano.es', NULL, NULL, NULL, NULL, NULL, 1, 'segundo', 'hermano', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysild71d48e970374323d7d5cc', '2h', 0, 36, 46, NULL, NULL, NULL, NULL, NULL),
(37, 'tercer790', 'tercer@hermano.es', NULL, NULL, NULL, NULL, NULL, 1, 'tercer', 'hermano', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysi1r11afe9467bd33c28778e9f', '3h', 0, 37, 47, NULL, NULL, NULL, NULL, NULL),
(38, 'cuarto406', 'cuarto@hermano.es', NULL, NULL, NULL, NULL, NULL, 1, 'cuarto', 'hermano', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysj1se6ec09ef9d0bbf9eb52b97', '4h', 0, 38, 48, NULL, NULL, NULL, NULL, NULL),
(39, 'primer692', 'ingles1@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'primer', 'ingles', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysk1dc3cea6632706240517de45', '1i', 0, 39, 49, NULL, NULL, NULL, NULL, NULL),
(40, 'segundo968', 'ingles2@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'segundo', 'ingles', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtyslkafbe7af4867171461b6694', '2i', 0, 40, 50, NULL, NULL, NULL, NULL, NULL),
(41, 'tercer650', 'ingles3@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'tercer', 'ingles', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysl1k6420df2d7648bde63f4d2c', '3i', 0, 41, 51, NULL, NULL, NULL, NULL, NULL),
(42, 'test164', 'jose.mvv.cc@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'test', 'test', '2025-10-28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1bjtyl1ht9c924d0b584cc703863c', '202510281234TT', 0, 42, 54, NULL, NULL, NULL, NULL, NULL),
(43, 'pepitol918', 'grill@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'pepitol', 'Grillo', '2005-01-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yktykq1u4fd7ebcfd96193b3f54d45', '22356885HHH', 0, 43, 55, NULL, NULL, NULL, NULL, NULL),
(44, 'manolo759', 'im@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'manolo', 'Grillo', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yktyk1fu9c0f419968c98af151bafb', '202511251132MG', 0, 44, 56, NULL, NULL, NULL, NULL, NULL),
(45, 'egerg778', 'jose.mvb.cc@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'egerg', 'reer', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zktylon1299a7b1bd1338648143ba', '202511261215ER', 0, 45, 57, NULL, NULL, NULL, NULL, NULL),
(46, 'jose448', 'jose.mvb.cc@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'jose', 'Test', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'altymd11c68991dbb83f7bfcaf254', '202512011304JT', 0, 46, 58, NULL, NULL, NULL, NULL, NULL),
(47, 'ignacio567', 'ign@uv.com', NULL, NULL, NULL, NULL, NULL, 1, 'ignacio', 'Bel', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyk1y1z2f8c9c832c4ad1e3b12b', '202512101151IB', 0, 47, 59, NULL, NULL, NULL, NULL, NULL),
(48, 'frances393', 'fr01@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'frances', 'fr', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyls1n87254d9c49fc68c961d3b2', 'fr555', 0, 48, 60, NULL, NULL, NULL, NULL, NULL),
(49, 'fracncis827', '66@uv.es', NULL, NULL, NULL, NULL, NULL, 1, 'fracncis', 'fr', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyltxa12e704083996cd49cce4b', 'fr66', 0, 49, 61, NULL, NULL, NULL, NULL, NULL),
(50, 'nuevoesp731', 'jose@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'nuevoesp', 'esp', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyl1ec17275c0669cdb5675aa1c5', '202512101230NE', 0, 50, 62, NULL, NULL, NULL, NULL, NULL),
(51, 'jose823', 'josetest@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, 'jose', 'Beas', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sltyq1g1rba008e94350460b53cf1', '202512191733JB', 0, 51, 63, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_aulas`
--

CREATE TABLE `tm_aulas` (
  `idAula` int NOT NULL,
  `nombreAula` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `localizacionAula` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `capacidadAula` varchar(225) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `departamentoAula` int DEFAULT NULL COMMENT 'Viene de mantenimiento de departamtentos',
  `observacionesAula` longtext COLLATE utf8mb3_spanish2_ci,
  `estAula` int DEFAULT NULL,
  `hibridoAula` int DEFAULT NULL COMMENT 'Característica',
  `kidsAula` int DEFAULT NULL COMMENT 'Característica',
  `paraliticosAula` int DEFAULT NULL COMMENT 'Característica',
  `agoraAula` int DEFAULT NULL COMMENT 'Característica'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_aulas`
--

INSERT INTO `tm_aulas` (`idAula`, `nombreAula`, `localizacionAula`, `capacidadAula`, `departamentoAula`, `observacionesAula`, `estAula`, `hibridoAula`, `kidsAula`, `paraliticosAula`, `agoraAula`) VALUES
(10, 'Aula Primera', 'C/ Cardenal Benlloch, 30', '2', 1, 'Es una prueba de textarea de Aulas', 1, 1, 0, 1, 0),
(11, 'Aula segunda - DESAC', 'La misma que el anterior', '10', 1, 'Prueba de segunda aula - Desactivada', 0, 0, 0, 0, 1),
(12, 'Aula 0', 'BI66', '8', 1, '', 1, 1, 0, 0, 1),
(13, 'Aula 1', 'BI66', '8', 1, '', 1, 1, 0, 0, 1),
(14, 'Aula 3', 'BI66', '8', 1, '', 1, 1, 0, 0, 1),
(15, 'Aula 4', 'BI66', '5', 1, '', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_bildungsurlaub_edu`
--

CREATE TABLE `tm_bildungsurlaub_edu` (
  `idBildun` int NOT NULL,
  `nombreBildun` varchar(225) NOT NULL,
  `estBildun` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_bildungsurlaub_edu`
--

INSERT INTO `tm_bildungsurlaub_edu` (`idBildun`, `nombreBildun`, `estBildun`) VALUES
(9, 'Bildungsurlaub - act', 1),
(10, 'Bildungsurlaub - Des', 0),
(11, 'Berlin.de', 1),
(12, 'Bildungsurlaub.de', 1),
(13, 'Bildungsurlaub-Aprov', 1),
(14, 'ECOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_config`
--

CREATE TABLE `tm_config` (
  `idConfig` int NOT NULL,
  `nombreEmpresa` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logotipoDark` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Logotipo Modo Claro',
  `faviconDark` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Logotipo Favicon Modo Claro',
  `logotipoWhite` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Logotipo Modo Oscuro',
  `faviconWhite` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Logotipo Favicon Modo Oscuro',
  `footerEmpresa` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'LogoTipiFooter',
  `mostrarSancion` tinyint(1) NOT NULL COMMENT '0-1 Mostrar mensaje y tiempo de sanción / Ban. O mostrar: Cuenta deshabilitada',
  `mostrarMeses` tinyint(1) NOT NULL COMMENT '0-1 Mostrar meses a la hora de facturación',
  `mostrarQuincenas` tinyint(1) NOT NULL COMMENT '0-1 Mostrar quincena a la hora de facturar.',
  `mostrarTrimestral` tinyint(1) NOT NULL COMMENT '0-1 Mostrar trimestral en facturación',
  `mostrarContPrecinto` int DEFAULT NULL,
  `redsys` int DEFAULT NULL COMMENT '0/1 ACTIVAR METODO DE PAGO',
  `paypal` int DEFAULT NULL COMMENT '0/1 ACTIVAR METODO DE PAGO',
  `bizum` int DEFAULT NULL COMMENT '0/1 ACTIVAR METODO DE PAGO',
  `tipoPresupusto` int DEFAULT '0' COMMENT '0 - Factura Proforma / 1- Presupuesto',
  `colorPrincipal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `api_key` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'API',
  `api_propietario` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ID CLAVE API',
  `idEmpresa_empresa` int DEFAULT NULL COMMENT 'De la tabla EMPRESA relacion',
  `cliente_gesdoc` tinyint(1) DEFAULT NULL COMMENT 'Activar Sistema en GESDOC de Clientes. Organizacion de Documentos',
  `departamento_gesdoc` tinyint(1) DEFAULT NULL COMMENT 'Activar Sistema en GESDOC de Departamentos. Organizacion de documentos',
  `smtp_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `snto_auth` tinyint(1) DEFAULT NULL,
  `smtp_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `smtp_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `smtp_port` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `smtp_receptor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `version_efeuno` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Version de Efeuno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tm_config`
--

INSERT INTO `tm_config` (`idConfig`, `nombreEmpresa`, `logotipoDark`, `faviconDark`, `logotipoWhite`, `faviconWhite`, `footerEmpresa`, `mostrarSancion`, `mostrarMeses`, `mostrarQuincenas`, `mostrarTrimestral`, `mostrarContPrecinto`, `redsys`, `paypal`, `bizum`, `tipoPresupusto`, `colorPrincipal`, `api_key`, `api_propietario`, `idEmpresa_empresa`, `cliente_gesdoc`, `departamento_gesdoc`, `smtp_host`, `snto_auth`, `smtp_username`, `smtp_pass`, `smtp_port`, `smtp_receptor`, `version_efeuno`) VALUES
(1, 'Leader Transport', 'logoDark.png', 'favDark.png', 'leadertransport.png', 'favWhite.png', 'logocontexto.png', 1, 1, 1, 1, 0, NULL, NULL, NULL, 1, '#0ea816', NULL, NULL, 1, 1, 1, 'smtp.ionos.es', 1, 'software@efeuno.com.es', 'M4r10.efeuno', '587', 'software@efeuno.es', '1.0.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_conocimientos`
--

CREATE TABLE `tm_conocimientos` (
  `idConocimiento` int NOT NULL,
  `nombreConocimiento` varchar(255) DEFAULT NULL,
  `tipoConocimiento` int DEFAULT NULL,
  `estConocimiento` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_conocimientos`
--

INSERT INTO `tm_conocimientos` (`idConocimiento`, `nombreConocimiento`, `tipoConocimiento`, `estConocimiento`) VALUES
(3, 'Internet', NULL, 0),
(4, 'Amigo', NULL, 1),
(6, 'Anuncio', NULL, 1),
(7, 'Www', NULL, 1),
(8, 'Agencia', NULL, 1),
(9, 'Es ex-alumno', NULL, 1),
(10, 'Es ex-interesado', NULL, 1),
(11, 'Feria', NULL, 1),
(12, 'Mailing', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_contenido`
--

CREATE TABLE `tm_contenido` (
  `idContenido` int NOT NULL,
  `idtitContenido_titContenido` int DEFAULT NULL,
  `idTipoContenido_tipoCurso` int DEFAULT NULL,
  `idNivelContenido_nivel` int DEFAULT NULL,
  `descrContenido` varchar(255) DEFAULT NULL,
  `obsContenido` mediumtext,
  `estContenido` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `tm_contenido_titulares_tipo_nivel`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `tm_contenido_titulares_tipo_nivel` (
`idContenido` int
,`idtitContenido_titContenido` int
,`idTipoContenido_tipoCurso` int
,`idNivelContenido_nivel` int
,`descrContenido` varchar(255)
,`obsContenido` mediumtext
,`estContenido` tinyint(1)
,`idTitContenido` int
,`descrTitContenido` varchar(255)
,`obsTitContenido` mediumtext
,`idTipo` int
,`descrTipo` varchar(60)
,`codTipo` varchar(3)
,`textTipo` mediumtext
,`minAlumTipo` int
,`maxAlumTipo` int
,`fecAltaTipoCurso` datetime
,`fecModiTipoCurso` datetime
,`fecBajaTipoCurso` datetime
,`estTipoCurso` int
,`idNivel` int
,`descrNivel` varchar(30)
,`codNivel` varchar(10)
,`textNivel` mediumtext
,`semanasNivel` int
,`fecAltaNivel` datetime
,`fecBajaNivel` datetime
,`fecModiNivel` datetime
,`estNivel` int
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_departamento_edu`
--

CREATE TABLE `tm_departamento_edu` (
  `idDepartamentoEdu` int NOT NULL,
  `nombreDepartamento` varchar(225) DEFAULT NULL,
  `numFacturaProDepa` varchar(225) DEFAULT NULL COMMENT 'Para facturación campo Factura profomra',
  `numFacturaDepa` varchar(225) DEFAULT NULL COMMENT 'Para facturación campo numro Factura',
  `numFacturaNegDepa` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Número de factura de abono . ABONO NUM REAL',
  `prefijoFactDepa` varchar(225) DEFAULT NULL COMMENT 'Serie de facturación',
  `prefijoFacturaProEdu` varchar(225) DEFAULT NULL COMMENT 'Prefijo Factura Proforma',
  `prefijoAbonoEdu` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Prefijo Abono Proforma. PREFIJO ABONO REAL',
  `estDepa` int NOT NULL COMMENT 'Estado del departamento',
  `colorDepartamento` text,
  `prefijoAbonoProEdu` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Prefijo de Abono Proforma. PREFIJO ABONO PRO',
  `numFacturaProNegDepa` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'Numeracion de Abono Proforma. NUMERO ABONO PRO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_departamento_edu`
--

INSERT INTO `tm_departamento_edu` (`idDepartamentoEdu`, `nombreDepartamento`, `numFacturaProDepa`, `numFacturaDepa`, `numFacturaNegDepa`, `prefijoFactDepa`, `prefijoFacturaProEdu`, `prefijoAbonoEdu`, `estDepa`, `colorDepartamento`, `prefijoAbonoProEdu`, `numFacturaProNegDepa`) VALUES
(1, 'Departamento Español', '22', '18', '12', 'FAC', 'PRO', 'ABO', 1, '#3bb4ed ', 'ABOPRO', '12'),
(11, 'Departamento Aleman', '2', '0', '0', 'FAC', 'PRO', 'ABO', 1, '#007BFF ', 'ABOPRO', '0'),
(12, 'Departamento Ingles', '2', '01', '01', 'INGLES', 'ING', 'INGRE', 1, '#ff7800 ', 'INGRE', '01'),
(13, 'Frances', '3', '1', '1', 'FR', 'FR', 'FR', 1, '#007BFF', 'PAFR', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_erasmus_edu`
--

CREATE TABLE `tm_erasmus_edu` (
  `idErasmus` int NOT NULL,
  `nombreErasmus` varchar(225) NOT NULL COMMENT 'Ejemplo\r\nErasmus nn\r\nErasmus UV\r\nErasmus UPV\r\nErasmus UCV\r\nErasmus CEU\r\n\r\n',
  `estErasmus` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_grupos`
--

CREATE TABLE `tm_grupos` (
  `idGrupo` int NOT NULL,
  `nomGrupo` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Nombre del grupo',
  `direcGrupo` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Dirección del grupo',
  `telGrupo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Teléfono del grupo',
  `cifGrupo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'CIF grupo',
  `fecAltaGrupo` datetime DEFAULT NULL,
  `fecBajaGrupo` datetime DEFAULT NULL,
  `fecModiGrupo` datetime DEFAULT NULL,
  `estGrupo` int NOT NULL COMMENT 'Estado Grupos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_horarioGrupo`
--

CREATE TABLE `tm_horarioGrupo` (
  `idHorario` int NOT NULL,
  `idCurso_horario` varchar(255) COLLATE utf8mb3_spanish2_ci NOT NULL COMMENT 'Codigo completo ESIGA21(1)202504082, cursos se repite probablemente',
  `idAula_horario` varchar(255) COLLATE utf8mb3_spanish2_ci NOT NULL COMMENT 'id del Aula de tm_aulas',
  `idProfesor_horario` int NOT NULL COMMENT 'de tm_personal',
  `descripcion_horario` longtext COLLATE utf8mb3_spanish2_ci COMMENT 'Descripcion para cualqueir cosa',
  `diaInicio_horario` date NOT NULL COMMENT 'Dia de la clase 13/5/2025',
  `horaInicio_horario` time NOT NULL COMMENT 'Empieza a las 08:00',
  `horaFin_horario` time NOT NULL COMMENT 'Finaliza a las 8:50',
  `estHorario` int DEFAULT NULL COMMENT 'Estadod el horario.. activo, cancelado...',
  `publicadoHorario` int DEFAULT NULL COMMENT '0/1 Si esta publicado o no',
  `gestionadoHorario` int DEFAULT NULL COMMENT 'Para que el profesor diga que ya esta gestionado. Y sepa que ya no tiene que asignar nada mas',
  `tareaHorario` int DEFAULT NULL COMMENT 'Indicativo si tiene tarea o no',
  `tokenHorario` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_horarioGrupo`
--

INSERT INTO `tm_horarioGrupo` (`idHorario`, `idCurso_horario`, `idAula_horario`, `idProfesor_horario`, `descripcion_horario`, `diaInicio_horario`, `horaInicio_horario`, `horaFin_horario`, `estHorario`, `publicadoHorario`, `gestionadoHorario`, `tareaHorario`, `tokenHorario`) VALUES
(1, 'ESINA1202509111', '10', 29, 'Traer libreta', '2025-09-10', '16:00:00', '16:50:00', 1, 1, NULL, NULL, NULL),
(2, 'ESINA1202509111', '10', 29, 'Traer libreta', '2025-09-11', '16:00:00', '16:50:00', 1, 1, NULL, NULL, NULL),
(3, 'ESINA1202509111', '10', 29, 'Traer libreta', '2025-09-12', '16:00:00', '16:50:00', 1, 1, NULL, NULL, NULL),
(4, 'ESINA1202509111', '10', 29, 'Traer libreta', '2025-09-13', '16:00:00', '16:50:00', 1, 1, NULL, NULL, NULL),
(5, 'ESINA2202510131', '13', 29, '', '2025-10-13', '11:30:00', '12:20:00', 1, 0, NULL, NULL, NULL),
(6, 'ESINA2202510131', '13', 29, '', '2025-10-14', '11:30:00', '12:20:00', 1, 0, NULL, NULL, NULL),
(7, 'ESINA2202510131', '13', 29, '', '2025-10-15', '11:30:00', '12:20:00', 1, 0, NULL, NULL, NULL),
(8, 'ESINA2202510131', '13', 29, '', '2025-10-17', '11:30:00', '12:20:00', 1, 0, NULL, NULL, NULL),
(9, 'ESINA2202510131', '13', 29, '', '2025-10-18', '11:30:00', '12:20:00', 1, 0, NULL, NULL, NULL),
(10, 'ESCPA1202510131', '12', 34, '', '2025-10-13', '11:00:00', '11:50:00', 1, 1, NULL, NULL, NULL),
(11, 'ESCPA1202510131', '12', 34, '', '2025-10-14', '11:00:00', '11:50:00', 1, 1, NULL, NULL, NULL),
(12, 'ESCPA1202510131', '12', 34, '', '2025-10-15', '11:00:00', '11:50:00', 1, 1, NULL, NULL, NULL),
(13, 'ESCPA1202510131', '12', 34, '', '2025-10-16', '11:00:00', '11:50:00', 1, 1, NULL, NULL, NULL),
(14, 'ESCPA1202510131', '12', 34, '', '2025-10-17', '11:00:00', '11:50:00', 1, 1, NULL, NULL, NULL),
(15, 'ESCPA2202510131', '15', 34, '', '2025-10-13', '10:00:00', '10:50:00', 1, 0, NULL, NULL, NULL),
(16, 'ESCPA2202510131', '15', 34, '', '2025-10-14', '10:00:00', '10:50:00', 1, 0, NULL, NULL, NULL),
(17, 'ESCPA2202510131', '15', 34, '', '2025-10-15', '10:00:00', '10:50:00', 1, 0, NULL, NULL, NULL),
(18, 'ESCPA2202510131', '15', 34, '', '2025-10-16', '10:00:00', '10:50:00', 1, 0, NULL, NULL, NULL),
(19, 'ESCPA2202510131', '15', 34, '', '2025-10-17', '10:00:00', '10:50:00', 1, 0, NULL, NULL, NULL),
(20, 'ESINB2202510171', '', 36, '', '2025-10-13', '10:00:00', '10:50:00', 1, 1, NULL, NULL, NULL),
(21, 'ESINB2202510171', '', 36, '', '2025-10-14', '10:00:00', '10:50:00', 1, 1, NULL, NULL, NULL),
(22, 'ESINB2202510171', '14', 36, '', '2025-10-15', '10:00:00', '10:50:00', 1, 1, NULL, NULL, NULL),
(23, 'ESINB2202510171', '14', 36, '', '2025-10-16', '10:00:00', '10:50:00', 1, 1, NULL, NULL, NULL),
(25, 'ESINB2202510171', '13', 36, '', '2025-10-17', '10:00:00', '10:50:00', 1, 1, NULL, NULL, NULL),
(26, 'ESINA1202510291', '10', 29, '', '2025-11-11', '12:30:00', '13:20:00', 1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_idioma`
--

CREATE TABLE `tm_idioma` (
  `idIdioma` int NOT NULL,
  `descrIdioma` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `codIdioma` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `textIdioma` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `fecAltaIdioma` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de alta idioma',
  `fecModiIdioma` datetime DEFAULT NULL COMMENT 'Fecha de modificacion idioma',
  `fecBajaIdioma` datetime DEFAULT NULL COMMENT 'Fecha de baja idioma',
  `estIdioma` int NOT NULL COMMENT 'Estado del idioma'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_idioma`
--

INSERT INTO `tm_idioma` (`idIdioma`, `descrIdioma`, `codIdioma`, `textIdioma`, `fecAltaIdioma`, `fecModiIdioma`, `fecBajaIdioma`, `estIdioma`) VALUES
(1, 'ESPAÑOL', 'ES', '', '2023-09-26 12:35:06', NULL, NULL, 1),
(2, 'INGLÉS', 'EN', '<p><br></p>', '2023-09-26 12:35:41', '2025-10-30 09:39:33', NULL, 1),
(9, 'ALEMAN', 'AL', '', '2025-08-22 09:24:06', '2025-09-24 17:57:32', NULL, 1),
(10, 'FRANCÉS', 'FR', '', '2025-09-24 17:58:06', NULL, NULL, 1),
(11, 'Otra formación', 'CF', 'Costa de Valencia, Centro de Formación', '2025-09-25 08:05:45', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_iva`
--

CREATE TABLE `tm_iva` (
  `idIva` int NOT NULL,
  `valorIva` int DEFAULT NULL,
  `descrIva` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fechAlta_iva` datetime DEFAULT NULL,
  `fechModi_iva` datetime DEFAULT NULL,
  `fechBaja_iva` datetime DEFAULT NULL,
  `estIva` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_iva`
--

INSERT INTO `tm_iva` (`idIva`, `valorIva`, `descrIva`, `fechAlta_iva`, `fechModi_iva`, `fechBaja_iva`, `estIva`) VALUES
(0, 0, 'SIN IVA', NULL, NULL, NULL, 1),
(2, 16, 'IVA 16', NULL, NULL, NULL, 1),
(3, 21, 'IVA 21', '2024-03-05 13:37:55', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_llegadas_edu`
--

CREATE TABLE `tm_llegadas_edu` (
  `id_llegada` int NOT NULL,
  `diainscripcion_llegadas` date DEFAULT NULL,
  `idprescriptor_llegadas` int DEFAULT NULL,
  `iddepartamento_llegadas` int DEFAULT NULL,
  `agente_llegadas` int DEFAULT NULL,
  `grupo_llegadas` varchar(100) DEFAULT NULL,
  `grupoAmigos` varchar(255) DEFAULT NULL,
  `fechallegada_llegadas` datetime DEFAULT NULL,
  `horallegada_llegadas` time DEFAULT NULL,
  `lugarllegada_llegadas` text,
  `quienrecogealumno_llegadas` varchar(255) DEFAULT NULL,
  `fechacancelacion_llegadas` date DEFAULT NULL,
  `motivocancelacion_llegadas` text,
  `codigotariotallegadaTransfer_llegadas` varchar(50) DEFAULT NULL,
  `textotariotallegadaTransfer_llegadas` text,
  `importetariotallegadaTransfer_llegadas` varchar(100) DEFAULT NULL,
  `ivatariotallegadaTransfer_llegadas` varchar(100) DEFAULT NULL,
  `diallegadaTransferTransfer_llegadas` date DEFAULT NULL,
  `horallegadaTransferTransfer_llegadas` time DEFAULT NULL,
  `lugarllegadallegadaTransfer_llegadas` text,
  `lugarentregallegadaTransfer_llegadas` text,
  `quienrecogealumnollegadaTransfer_llegadas` varchar(255) DEFAULT NULL,
  `codigotariotalregresoTransfer_llegadas` varchar(50) DEFAULT NULL,
  `textotariotalregresoTransfer_llegadas` text,
  `importetariotalregresoTransfer_llegadas` varchar(100) DEFAULT NULL,
  `ivatariotalregresoTransfer_llegadas` varchar(100) DEFAULT NULL,
  `diaregresoTransfer_llegadas` date DEFAULT NULL,
  `horaregresoTransfer_llegadas` time DEFAULT NULL,
  `lugarrecogidaregresaTransfer_llegadas` text,
  `lugarentregaregresaTransfer_llegadas` text,
  `quienrecogealumnoregresaTransfer_llegadas` varchar(255) DEFAULT NULL,
  `campoobservacionesgeneralTransfer_llegadas` text,
  `niveldice_llegadas` text,
  `nivelobservaciones_llegadas` text,
  `nivelasignado_llegadas` varchar(100) DEFAULT NULL,
  `semanaasignada_llegadas` varchar(100) DEFAULT NULL,
  `tieneVisado` int DEFAULT NULL,
  `fechCartaAdmision` date DEFAULT NULL,
  `denegacionFecha` date DEFAULT NULL,
  `denegacionMotivo` longtext,
  `estProforma` int DEFAULT '0',
  `numProforma` varchar(255) DEFAULT NULL,
  `estLlegada` int NOT NULL DEFAULT '1',
  `suplidoImporte` varchar(100) DEFAULT NULL,
  `suplidoDescr` varchar(255) DEFAULT NULL,
  `estMatricula` int DEFAULT '4' COMMENT 'Estaedo de la matricula (Valor del 1 al 4)',
  `estAlojamiento` int DEFAULT '4' COMMENT 'Si tiene alojamiento o no (Valor del 1 al 4)',
  `cursoFinalizado` int DEFAULT NULL COMMENT 'Cuando un alumno finaliza 100% un curso, para certificado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_llegadas_edu`
--

INSERT INTO `tm_llegadas_edu` (`id_llegada`, `diainscripcion_llegadas`, `idprescriptor_llegadas`, `iddepartamento_llegadas`, `agente_llegadas`, `grupo_llegadas`, `grupoAmigos`, `fechallegada_llegadas`, `horallegada_llegadas`, `lugarllegada_llegadas`, `quienrecogealumno_llegadas`, `fechacancelacion_llegadas`, `motivocancelacion_llegadas`, `codigotariotallegadaTransfer_llegadas`, `textotariotallegadaTransfer_llegadas`, `importetariotallegadaTransfer_llegadas`, `ivatariotallegadaTransfer_llegadas`, `diallegadaTransferTransfer_llegadas`, `horallegadaTransferTransfer_llegadas`, `lugarllegadallegadaTransfer_llegadas`, `lugarentregallegadaTransfer_llegadas`, `quienrecogealumnollegadaTransfer_llegadas`, `codigotariotalregresoTransfer_llegadas`, `textotariotalregresoTransfer_llegadas`, `importetariotalregresoTransfer_llegadas`, `ivatariotalregresoTransfer_llegadas`, `diaregresoTransfer_llegadas`, `horaregresoTransfer_llegadas`, `lugarrecogidaregresaTransfer_llegadas`, `lugarentregaregresaTransfer_llegadas`, `quienrecogealumnoregresaTransfer_llegadas`, `campoobservacionesgeneralTransfer_llegadas`, `niveldice_llegadas`, `nivelobservaciones_llegadas`, `nivelasignado_llegadas`, `semanaasignada_llegadas`, `tieneVisado`, `fechCartaAdmision`, `denegacionFecha`, `denegacionMotivo`, `estProforma`, `numProforma`, `estLlegada`, `suplidoImporte`, `suplidoDescr`, `estMatricula`, `estAlojamiento`, `cursoFinalizado`) VALUES
(1, '2025-11-13', 16, 1, NULL, '', 'Efeuno', '2025-08-21 11:00:00', NULL, 'Aeropuerto de Valencia', 'Jose con  su moto', NULL, NULL, '', '', '', '', NULL, NULL, 'Aeropuerto de Valencia', '', '', '', '', '', '', NULL, NULL, '', '', '', '', 'A1 en Español', 'Este no tiene Rutas asignadas.', '', '0', 1, '2025-08-22', NULL, '', 0, NULL, 1, NULL, NULL, 1, 3, NULL),
(2, '2025-08-26', 17, 1, NULL, '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(3, '2025-09-11', 18, 1, 1, '', 'The Japos', '2025-09-21 17:00:00', NULL, 'Costa', 'Ruben', NULL, NULL, 'ta1', 'Transporte aeropuerto, ', '50,00', '16', '2025-09-21', '17:00:00', 'Costa', 'Apartamento', 'Ruben', '', '', '0,00€', '', '2025-11-01', '11:00:00', '', 'Costa', 'Ruben', '', 'A1', '', '1', '0', 1, '2025-02-20', NULL, '', 0, NULL, 1, NULL, NULL, 1, 3, NULL),
(4, '2025-08-22', 16, 1, NULL, '', '', '2025-11-20 12:00:00', NULL, '', '', NULL, NULL, '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 4, 1, NULL),
(5, '2025-08-22', 16, 1, NULL, '', '', '2025-09-23 14:35:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(6, '2025-08-22', 16, 1, NULL, '', '', '2025-09-23 14:35:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(7, '2025-09-25', 19, 1, NULL, '', '', '2025-09-29 09:00:00', NULL, 'Escuela', 'alguien', NULL, NULL, 'ta1', 'Transporte aeropuerto,', '50,00', '', '2025-09-28', '16:00:00', 'aeropuerto', 'Apartamento BI11', '', '', '', '', '', NULL, NULL, 'Apartamento BI11', 'aeropuerto', 'rubén', '', 'a2', '', '2', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(8, '2025-09-29', 20, 1, 1, '2509Kio', 'Kio', '2025-10-01 10:00:00', NULL, 'Escuela', 'alguien', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '3', '0', NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 1, 4, NULL),
(9, '2025-09-29', 20, 1, NULL, '', '', '2025-10-01 10:00:00', NULL, 'Escuela', 'alguien', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(10, '2025-10-01', 21, 1, NULL, '251005Kyo', 'kyo', '2025-10-06 09:00:00', NULL, 'Escuela', 'alguien', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2', '', '2', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(11, '2025-10-01', 22, 1, NULL, '251005Kyo', 'Kio', '2025-10-06 09:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2', '', '2', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(12, '2025-10-01', 23, 1, NULL, '251005Kyo', 'kyo', '2025-10-06 09:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a1', '', '4', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(13, '2025-09-25', 19, 1, NULL, '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(14, '2025-10-13', 24, 1, NULL, 'pernales2510', 'pernales2510', '2025-10-13 10:00:00', NULL, '', '', NULL, NULL, 'fp1', '', '365,00€', '16', '2025-10-13', '10:00:00', '', '', '', 'ta2', 'Transporte aeropuerto,', '30,00€', '16', NULL, NULL, '', '', '', '', 'a1', '', '4', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(15, '2025-10-13', 25, 1, NULL, 'pernales2510', 'pernales2510', '2025-10-13 10:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2', '', '5', '0', NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 3, 1, NULL),
(16, '2025-10-13', 26, 1, NULL, '', '', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(17, '2025-10-17', 28, 1, NULL, '', '2 white', '2025-10-20 09:00:00', NULL, 'Escuela', 'alguien', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B1.2', '', '10', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(18, '2025-10-20', 30, 11, NULL, '', '', '2025-10-20 10:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2', '', '12', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(19, '2025-10-20', 29, 1, NULL, '', '', '2025-10-20 10:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2', '', '12', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(20, '2025-10-20', 31, 11, NULL, '', '', '2025-10-20 10:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2', '', '12', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(21, '2025-10-20', 32, 11, NULL, '', '', '2025-10-20 10:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a3', '', '16', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(22, '2025-10-20', 33, 1, NULL, '', '', '2025-10-20 10:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a4', '', '14', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(23, '2025-10-20', 34, 1, NULL, '', '', '2025-10-20 10:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2', '', '12', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(24, '2025-10-25', 35, 12, NULL, 'hermanos', 'hermanos', '2025-10-25 20:00:00', NULL, 'Escuela', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(25, '2025-10-25', 36, 12, NULL, 'hermanos', 'hermanos', '2025-10-26 10:00:00', NULL, 'Escuela', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(26, '2025-10-25', 37, 12, NULL, 'hermanos', 'hermanos', '2025-10-27 13:01:00', NULL, 'Escuela', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(27, '2025-10-25', 38, 12, NULL, 'hermanos', '', '2025-10-27 13:10:00', NULL, 'Escuela', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(28, '2025-10-25', 39, 12, NULL, '', '', '2025-10-26 13:11:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(29, '2025-10-25', 40, 12, NULL, '', '', '2025-10-26 13:13:00', NULL, '', '', NULL, NULL, 'fp1', '', '365,00€', '16', '2025-10-26', '13:13:00', '', '', '', 'deles', 'Simulacro examen DELE:', '110,00€', '16', NULL, NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(30, '2025-10-25', 41, 12, NULL, '', '', '2025-10-26 13:14:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(37, '2025-10-28', 42, 1, NULL, '', '', '2025-10-29 11:15:00', NULL, '', '', NULL, NULL, 'fp1', '', '365,00€', '16', '2025-10-29', '11:15:00', '', '', '', 'deles', 'Simulacro examen DELE:', '110,00€', '16', '2025-11-20', '17:02:00', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(38, '2025-10-13', 25, 1, NULL, '', '', '2025-11-03 15:52:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 4, 1, NULL),
(39, '2025-10-13', 25, 1, NULL, '', '', '2025-11-03 16:05:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 4, 1, NULL),
(40, '2025-10-28', 42, 1, NULL, '', '', '2025-11-10 11:12:00', NULL, '', '', NULL, NULL, 'd5', 'Descuento por grupo:', '0,00€', '16', '2025-11-10', '11:12:00', '', '', '', '', '', '', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(41, '2025-11-25', 43, 1, NULL, '', '', '2025-11-25 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(42, '2025-11-25', 44, 1, NULL, '', '', '2025-12-02 12:00:00', NULL, 'escuela', 'nadie', NULL, NULL, 'ta1', 'Transporte aeropuerto,', '50,00€', '16', NULL, '12:00:00', 'escuela', '', 'nadie', 'ta1', 'Transporte aeropuerto,', '50,00€', '16', '2025-12-14', '11:00:00', '', 'escuela', 'nadie', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 3, NULL),
(43, '2025-11-26', 45, 1, NULL, '', '', '2025-11-26 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 1, 4, NULL),
(44, '2025-11-20', 45, 1, NULL, '', '', '2025-11-26 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 3, 1, NULL),
(45, '2025-12-01', 46, 1, NULL, '', '', '2025-12-02 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(46, '2025-12-01', 46, 1, NULL, '', '', '2025-12-01 12:00:00', NULL, '', '', NULL, NULL, 'deles', 'Simulacro examen DELE:', '110,00', '16', '2025-12-01', '12:00:00', '', '', '', 'che', 'Gastos cheque:', '0,00', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 4, 3, NULL),
(47, '2025-12-10', 47, 1, NULL, '', '', '2025-12-10 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A2', '', '2', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(48, '2025-12-08', 48, 13, NULL, '', '', '2025-12-10 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a1', '', '24', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(49, '2025-12-10', 49, 13, NULL, '', '', '2025-12-10 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A2', '', '25', '0', NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 3, 1, NULL),
(50, '2025-12-10', 50, 1, NULL, '', '', '2025-12-10 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a1', '', '24', '0', NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 1, 4, NULL),
(51, '2025-12-10', 50, 1, NULL, '', '', '2025-12-15 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 1, 4, NULL),
(52, '2025-12-10', 48, 1, NULL, '', '', '2025-12-15 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(53, '2025-12-10', 48, 1, NULL, '', '', '2025-12-15 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(54, '2025-12-10', 48, 1, NULL, '', '', '2025-12-15 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(55, '2025-12-10', 48, 1, NULL, '', '', '2025-12-15 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, NULL, NULL, 4, 4, NULL),
(56, '2025-12-10', 48, 1, NULL, '', '', '2025-12-15 12:00:00', NULL, '', '', NULL, NULL, 'd10', 'Descuento por grupo:', '0,00€', '16', '2025-12-15', '12:00:00', '', '', '', 'dex', 'Descuento antiguo alumno:', '0,00€', '16', NULL, NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(57, '2025-12-19', 51, 11, 1, '', '', '2025-12-19 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '14', '0', NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 1, 4, NULL),
(58, '2025-12-19', 51, 11, 1, '', '', '2025-12-19 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '13', '0', NULL, NULL, NULL, NULL, 0, NULL, 3, NULL, NULL, 3, 4, NULL),
(59, '2025-12-19', 51, 11, NULL, '', '', '2025-12-19 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '13', '0', NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 1, 4, NULL),
(60, '2025-12-19', 51, 11, NULL, '', '', '2025-12-19 12:00:00', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '11', '0', NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, 1, 4, NULL);

--
-- Disparadores `tm_llegadas_edu`
--
DELIMITER $$
CREATE TRIGGER `llegadas_before_insert_visado` BEFORE INSERT ON `tm_llegadas_edu` FOR EACH ROW BEGIN
     IF NEW.denegacionFecha IS NOT NULL THEN
         SET NEW.estLlegada = 0$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `llegadas_before_update_visado` BEFORE UPDATE ON `tm_llegadas_edu` FOR EACH ROW BEGIN
     IF NEW.denegacionFecha IS NOT NULL THEN
         SET NEW.estLlegada = 0$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_before_insert_estLlegada` BEFORE INSERT ON `tm_llegadas_edu` FOR EACH ROW BEGIN
    DECLARE nuevo_valor INT$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_before_update_estLlegada` BEFORE UPDATE ON `tm_llegadas_edu` FOR EACH ROW BEGIN
    DECLARE nuevo_valor INT$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_matriculacionllegadas_edu`
--

CREATE TABLE `tm_matriculacionllegadas_edu` (
  `idMatriculacionLlegada` int NOT NULL,
  `idLlegada_matriculacion` int NOT NULL COMMENT 'Viene de la tabla Llegadas',
  `idIvaTarifa_matriculacion` varchar(225) DEFAULT NULL COMMENT 'El Iva asociado a la tarifa',
  `idDepartamentoTarifa_matriculacion` varchar(225) DEFAULT NULL COMMENT 'El departamento asociado a la tarifa',
  `codTarifa_matriculacion` varchar(255) DEFAULT NULL COMMENT 'El codTarifa asociado a la tarifa',
  `nombreTarifa_matriculacion` varchar(255) DEFAULT NULL COMMENT 'El nombreTarifa asociado a la tarifa',
  `unidadTarifa_matriculacion` varchar(255) DEFAULT NULL COMMENT 'El unidadTarifa_matriculacion asociado a la tarifa',
  `precioTarifa_matriculacion` varchar(255) DEFAULT NULL COMMENT 'El precioTarifa_matriculacion asociado a la tarifa',
  `cuenta1Tarifa_matriculacion` varchar(225) DEFAULT NULL COMMENT 'El cuenta1Tarifa_matriculacionasociado a la tarifa',
  `cuenta2Tarifa_matriculacion` varchar(225) DEFAULT NULL COMMENT 'El cuenta2Tarifa_matriculacion a la tarifa',
  `cuenta3Tarifa_matriculacion` varchar(225) DEFAULT NULL COMMENT 'El cuenta3Tarifa_matriculacion a la tarifa',
  `tipoTarifa_matriculacion` varchar(225) DEFAULT NULL COMMENT 'El tipoTarifa_matriculacion a la tarifa',
  `descripcionTarifa_matriculacion` varchar(225) DEFAULT NULL COMMENT 'El descripcionTarifa_matriculacion a la tarifa',
  `fechaInicioMatriculacion` date DEFAULT NULL COMMENT 'Fecha de inciio de matriculacion, suele ser un Lunes',
  `fechaFinMatriculacion` date DEFAULT NULL,
  `estMatriculacion_llegadas` int DEFAULT NULL COMMENT '0/1 ',
  `obsMatriculacion` longtext,
  `descuento_matriculacion` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_matriculacionllegadas_edu`
--

INSERT INTO `tm_matriculacionllegadas_edu` (`idMatriculacionLlegada`, `idLlegada_matriculacion`, `idIvaTarifa_matriculacion`, `idDepartamentoTarifa_matriculacion`, `codTarifa_matriculacion`, `nombreTarifa_matriculacion`, `unidadTarifa_matriculacion`, `precioTarifa_matriculacion`, `cuenta1Tarifa_matriculacion`, `cuenta2Tarifa_matriculacion`, `cuenta3Tarifa_matriculacion`, `tipoTarifa_matriculacion`, `descripcionTarifa_matriculacion`, `fechaInicioMatriculacion`, `fechaFinMatriculacion`, `estMatriculacion_llegadas`, `obsMatriculacion`, `descuento_matriculacion`) VALUES
(1, 1, '16 %', NULL, 'i20', 'Curso intensivo, ', NULL, '2.740,00€', NULL, NULL, NULL, NULL, NULL, '2025-08-25', '2026-01-12', 1, 'Pruebas de magriculación', '0 %'),
(2, 2, '16 %', NULL, 'cp12', 'Clases particulares, ', NULL, '420,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-05', '2025-09-26', 3, '', '0 %'),
(3, 3, '16 %', NULL, 'i52', 'Curso intensivo, ', NULL, '5.800,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-11', '2026-09-18', 1, '', ''),
(4, 7, 'null %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-17', 3, '', '0 %'),
(5, 7, 'null %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-17', 3, '', '0 %'),
(6, 7, 'null %', NULL, 'cp5', '', NULL, '200,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-11', 3, '', '0 %'),
(8, 9, 'null %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-17', 3, '', '0 %'),
(9, 8, '16 %', NULL, 'cp14', 'Clases particulares,', NULL, '490,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-30', '2025-10-02', 3, '', '0 %'),
(10, 8, 'null %', NULL, 'i16', 'Clases particulares,', NULL, '2.280,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-30', '2026-01-16', 1, '', '0 %'),
(11, 10, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-17', 3, '', '0 %'),
(12, 11, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-17', 3, '', '0 %'),
(13, 12, '16 %', NULL, 'cp20', '', NULL, '660,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-06', '2025-10-17', 3, '', '0 %'),
(14, 14, '16 %', NULL, 'i1', '', NULL, '180,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-13', '2025-10-17', 3, '', '0 %'),
(15, 15, '16 %', NULL, 'cp5', '', NULL, '200,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-13', '2025-10-17', 3, '', '0 %'),
(16, 17, '16 %', NULL, 'i3', '', NULL, '515,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-11-14', 3, '', '0 %'),
(17, 12, '16 %', NULL, 'cp12', 'Clases particulares,', NULL, '420,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-10-23', 3, '', '0 %'),
(18, 18, '16 %', NULL, 'i1', '', NULL, '180,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-10-25', 3, '', '0 %'),
(19, 18, '16 %', NULL, 'c1', '', NULL, '105,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-10-25', 3, '', '0 %'),
(20, 19, '16 %', NULL, 'i1', '', NULL, '180,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-10-25', 3, '', '0 %'),
(21, 20, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-10-25', 3, '', '0 %'),
(22, 21, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-10-31', 3, '', '0 %'),
(23, 22, '16 %', NULL, 'i1', '', NULL, '180,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-10-24', 3, '', '0 %'),
(24, 22, '16 %', NULL, 'c1', '', NULL, '105,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-10-24', 3, '', '0 %'),
(25, 23, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-20', '2025-11-07', 3, '', '0 %'),
(26, 12, '16 %', NULL, 'cp20', 'Clases particulares,', NULL, '660,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-22', '2025-10-23', 3, '', '0 %'),
(27, 24, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-10-31', 3, '', '0 %'),
(28, 25, '16 %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-11-07', 3, '', '0 %'),
(29, 26, '16 %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2025-11-07', 3, '', '0 %'),
(30, 27, '16 %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-11-07', 3, '', '0 %'),
(31, 28, '16 %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-11-07', 3, '', '0 %'),
(32, 29, '16 %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-11-07', 3, '', '0 %'),
(33, 30, '16 %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-11-07', 3, '', '0 %'),
(34, 30, '16 %', NULL, 'cp1', '', NULL, '50,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-27', '2025-10-27', 3, '', '0 %'),
(35, 31, '16 %', NULL, 'c2', '', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2025-11-14', 3, '', '0 %'),
(36, 32, '16 %', NULL, 'cp14', 'Clases particulares,', NULL, '490,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2025-11-04', 3, '', '0 %'),
(37, 33, '16 %', NULL, 'sk19', 'Clases skype,', NULL, '6.175,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2025-11-07', 3, '', '0 %'),
(38, 34, '16 %', NULL, 'cp14', 'Clases particulares,', NULL, '490,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2025-11-06', 3, '', '0 %'),
(39, 35, '16 %', NULL, 'cp51', 'Clases particulares,', NULL, '1.683,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2025-11-09', 3, '', '0 %'),
(40, 36, '16 %', NULL, 'em12', 'Extensivo Mini:', NULL, '540,00€', NULL, NULL, NULL, NULL, NULL, '2025-11-03', '2026-01-23', 1, '', '0 %'),
(41, 37, '16 %', NULL, 'cp15', 'Clases particulares,', NULL, '525,00€', NULL, NULL, NULL, NULL, NULL, '2025-10-29', '2025-11-06', 3, '', '0 %'),
(42, 6, '16 %', NULL, 'si2', 'Curso extensivo 10h,', NULL, '225,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-29', '2025-10-10', 3, '', '0 %'),
(43, 5, '16 %', NULL, 'abitur2', 'Curso abitur,', NULL, '920,00€', NULL, NULL, NULL, NULL, NULL, '2025-09-29', '2025-10-10', 3, '', '0 %'),
(44, 42, '16 %', NULL, 'i2', 'Curso intensivo,', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-01', '2025-12-12', 3, '', '0 %'),
(45, 44, '16 %', NULL, 'em4', 'Extensivo Mini:', NULL, '180,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-01', '2025-12-26', 3, '', '0 %'),
(46, 43, '16 %', NULL, 'em12', 'Extensivo Mini:', NULL, '540,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-01', '2026-02-20', 1, '', '0 %'),
(47, 43, '16 %', NULL, 'cul2', 'Curso cultura,', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-01', '2025-12-12', 3, '', '0 %'),
(48, 45, '16 %', NULL, 'cul2', 'Curso cultura,', NULL, '210,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-08', '2025-12-19', 3, '', '0 %'),
(49, 47, '16 %', NULL, 'pron4', '', NULL, '420,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-10', '2026-01-02', 3, '', '0 %'),
(50, 47, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-10', '2025-12-19', 3, '', '0 %'),
(51, 48, '16 %', NULL, 'i1', '', NULL, '180,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-10', '2025-12-12', 3, '', '0 %'),
(52, 49, '16 %', NULL, 'i2', '', NULL, '350,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-10', '2025-12-19', 3, '', '0 %'),
(53, 50, '16 %', NULL, 'c16', '', NULL, '1.680,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-10', '2026-03-27', 1, '', '0 %'),
(54, 51, '16 %', NULL, 'cp100', 'Clases particulares,', NULL, '3.300,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-15', '2025-12-16', 3, '', '0 %'),
(55, 51, '16 %', NULL, 'em8', 'Extensivo Mini:', NULL, '360,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-15', '2026-02-06', 1, '', '0 %'),
(56, 56, '16 %', NULL, 'cp11', 'Clases particulares,', NULL, '385,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-15', '2025-12-17', 3, '', '0 %'),
(57, 57, '16 %', NULL, 'c9', '', NULL, '945,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-22', '2026-02-20', 1, '', '0 %'),
(58, 58, '16 %', NULL, 'c1', '', NULL, '105,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-22', '2025-12-26', 3, '', '0 %'),
(59, 59, '16 %', NULL, 'c4', '', NULL, '420,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-22', '2026-01-16', 1, '', '0 %'),
(60, 60, '16 %', NULL, 'cul8', 'Curso cultura,', NULL, '840,00€', NULL, NULL, NULL, NULL, NULL, '2025-12-22', '2026-02-13', 1, '', '0 %');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_medidaaloja`
--

CREATE TABLE `tm_medidaaloja` (
  `idMedidaAloja` int NOT NULL,
  `descrMedidaAloja` varchar(70) DEFAULT NULL,
  `textMedidaAloja` mediumtext,
  `fecAltaMedidaAloja` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecBajaMedidaAloja` datetime DEFAULT NULL,
  `fecModiMedidaAloja` datetime DEFAULT NULL,
  `estMedidaAloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_mediopago`
--

CREATE TABLE `tm_mediopago` (
  `idMedioPago` int NOT NULL,
  `nomMedioPago` varchar(245) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecAltaMedioPago` datetime DEFAULT NULL,
  `fecBajaMedioPago` datetime DEFAULT NULL,
  `fecModiMedioPago` datetime DEFAULT NULL,
  `estMedioPago` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_mediopago`
--

INSERT INTO `tm_mediopago` (`idMedioPago`, `nomMedioPago`, `fecAltaMedioPago`, `fecBajaMedioPago`, `fecModiMedioPago`, `estMedioPago`) VALUES
(1, 'Transferencia BS (Banco Santander)', NULL, NULL, NULL, 1),
(3, 'Efectivo', NULL, NULL, NULL, 1),
(4, 'TPV Datafono', NULL, NULL, '2025-09-24 17:54:38', 1),
(10, 'TPV Virtual', NULL, NULL, NULL, 1),
(11, 'Tarjeta', NULL, NULL, NULL, 1),
(12, 'Transferencia BBVA', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_nivel`
--

CREATE TABLE `tm_nivel` (
  `idNivel` int NOT NULL,
  `descrNivel` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `codNivel` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `textNivel` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `semanasNivel` int DEFAULT '0',
  `fecAltaNivel` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecBajaNivel` datetime DEFAULT NULL,
  `fecModiNivel` datetime DEFAULT NULL,
  `estNivel` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_nivel`
--

INSERT INTO `tm_nivel` (`idNivel`, `descrNivel`, `codNivel`, `textNivel`, `semanasNivel`, `fecAltaNivel`, `fecBajaNivel`, `fecModiNivel`, `estNivel`) VALUES
(1, 'Español A1', 'A1', 'Es el A1 de Español', 0, '2025-08-22 09:26:28', NULL, NULL, 1),
(2, 'A2 de Español', 'A2', 'Es el A2 de Español', 0, '2025-08-22 09:26:47', NULL, NULL, 1),
(3, 'B1 Español', 'B1', 'Es el B1 de Español - Desactivado', 0, '2025-08-22 09:27:13', NULL, '2025-10-13 14:06:26', 1),
(4, 'Español Intensivo20h', 'EI', '', 0, '2025-09-25 08:09:05', NULL, NULL, 1),
(5, 'Español B2', 'B2', '', 0, '2025-10-13 14:07:18', NULL, NULL, 1),
(6, 'Español C1', 'C1', '', 0, '2025-10-13 14:07:53', NULL, NULL, 1),
(7, 'Inglés A1', 'A1i', '', 0, '2025-10-13 14:08:53', NULL, NULL, 1),
(8, 'Aleman A1', 'ALE A1', '', 0, '2025-10-18 08:44:44', NULL, NULL, 1),
(9, 'Aleman A2', 'ALE A2', '', 0, '2025-10-20 12:12:49', NULL, NULL, 1),
(10, 'Aleman A3', 'ALE A3', '', 0, '2025-10-20 12:13:15', NULL, NULL, 1),
(11, 'Aleman A4', 'ALE A4', '', 0, '2025-10-20 12:15:09', NULL, NULL, 1),
(12, 'Aleman B1', 'ALE B1', '', 0, '2025-10-20 12:22:11', NULL, NULL, 1),
(13, 'Aleman B2', 'ALE B2', '', 0, '2025-10-20 12:22:37', NULL, NULL, 1),
(14, 'Inglés A1', 'ING A1', '', 0, '2025-10-25 17:05:43', NULL, NULL, 1),
(15, 'Inglés A2', 'ING A2', '', 0, '2025-10-25 17:06:24', NULL, NULL, 1),
(16, 'Inglés A3', 'ING A3', '', 0, '2025-10-25 17:06:44', NULL, NULL, 1),
(17, 'Inglés A4', 'ING A4', '', 0, '2025-10-25 17:07:08', NULL, NULL, 1),
(18, 'Frances A1', 'FR A1', '', 0, '2025-12-10 11:12:54', NULL, NULL, 1),
(19, 'FR A2', 'FR A2', '', 0, '2025-12-10 11:13:19', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_nivelesllegadas_edu`
--

CREATE TABLE `tm_nivelesllegadas_edu` (
  `idNivelesLlegadas` int NOT NULL,
  `idLlegada_niveles` int NOT NULL COMMENT 'Viene de la tabla Llegadas',
  `nivelDice_niveles` varchar(225) DEFAULT NULL COMMENT 'El nivel que dice que tiene',
  `textoObservado_niveles` longtext COMMENT 'Es el texto que describe el nivel qeu se aprecia del alumno',
  `nivelAsignado_niveles` varchar(225) DEFAULT NULL COMMENT 'El nivel que se le asigna al alumno',
  `semanaAsignada_niveles` varchar(225) DEFAULT NULL COMMENT 'Semana asignada dependiendo del nivel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_objetivos`
--

CREATE TABLE `tm_objetivos` (
  `idObjetivo` int NOT NULL,
  `idtitObjetivo_titObjetivo` int DEFAULT NULL,
  `idNivelObjetivo_nivel` int DEFAULT NULL,
  `descrObjetivo` varchar(255) DEFAULT NULL,
  `obsObjetivo` mediumtext,
  `estObjetivo` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `tm_objetivos_titulares_nivel`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `tm_objetivos_titulares_nivel` (
`idObjetivo` int
,`idtitObjetivo_titObjetivo` int
,`idNivelObjetivo_nivel` int
,`descrObjetivo` varchar(255)
,`obsObjetivo` mediumtext
,`estObjetivo` int
,`idTitObjetivo` int
,`descrTitObjetivo` varchar(255)
,`obsTitObjetivo` mediumtext
,`idNivel` int
,`descrNivel` varchar(30)
,`codNivel` varchar(10)
,`textNivel` mediumtext
,`semanasNivel` int
,`fecAltaNivel` datetime
,`fecBajaNivel` datetime
,`fecModiNivel` datetime
,`estNivel` int
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_pagoanticipadollegadas_edu`
--

CREATE TABLE `tm_pagoanticipadollegadas_edu` (
  `idPagoAnticipado` int NOT NULL,
  `idLlegada_pagoAnticipado` int NOT NULL COMMENT 'viene de la tabla Llegada',
  `importePagoAnticipado` varchar(225) DEFAULT NULL,
  `fechaPagoAnticipado` date DEFAULT NULL,
  `medioPagoAnticipado` int DEFAULT NULL COMMENT 'Banco, TPV virtual, Datafono TPV, Tarjeta, Paypal, Cheque, Efectivo, Bizzum - Un selec con autobuscador',
  `observacionPagoAnticipado` longtext COMMENT 'texto de 128 posiciones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_pagoanticipadollegadas_edu`
--

INSERT INTO `tm_pagoanticipadollegadas_edu` (`idPagoAnticipado`, `idLlegada_pagoAnticipado`, `importePagoAnticipado`, `fechaPagoAnticipado`, `medioPagoAnticipado`, `observacionPagoAnticipado`) VALUES
(1, 1, '35', '2025-08-22', 3, 'Es un pago aplazado'),
(2, 3, '6000', '2025-05-20', 1, ''),
(3, 3, '865', '2025-05-21', 1, ''),
(4, 3, '-150', '2025-09-02', 3, ''),
(5, 7, '150', '2025-09-22', 10, ''),
(7, 50, '10', '2025-12-10', 3, ''),
(8, 48, '180', '2025-12-10', 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_personal`
--

CREATE TABLE `tm_personal` (
  `idPersonal` int NOT NULL,
  `nomPersonal` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailUsuario` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL COMMENT 'email para iniciar sesión',
  `senaUsuario` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL COMMENT 'contraseña para iniciar sesion',
  `apePersonal` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirPersonal` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaPersonal` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpPersonal` varchar(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `provPersonal` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `paisPersonal` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `tlfPersonal` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `movilPersonal` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailPersonal` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaPersonal` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecBajaPersonal` datetime DEFAULT NULL,
  `fecModiPersonal` datetime DEFAULT NULL,
  `rolUsuario` int NOT NULL COMMENT 'ROL DE USUARIO. 3 es ALUMNO y 1 es newcosta. 2 JEFE DE ESTUDIOS --> No se utiliza	ROL DE USUARIO. 0 es PROFESOR y 1 es newcosta. 2 JEFE DE ESTUDIOS --> Este es el qyue se utiliza',
  `estPersonal` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `tokenPers` varchar(225) DEFAULT NULL,
  `departamentosPersonal` varchar(225) DEFAULT NULL COMMENT 'new - Departamentos asignados',
  `idUsuario_tmpersonal` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_personal`
--

INSERT INTO `tm_personal` (`idPersonal`, `nomPersonal`, `emailUsuario`, `senaUsuario`, `apePersonal`, `dirPersonal`, `poblaPersonal`, `cpPersonal`, `provPersonal`, `paisPersonal`, `tlfPersonal`, `movilPersonal`, `emailPersonal`, `fecAltaPersonal`, `fecBajaPersonal`, `fecModiPersonal`, `rolUsuario`, `estPersonal`, `tokenPers`, `departamentosPersonal`, `idUsuario_tmpersonal`) VALUES
(2, 'Software newcosta', 'software@efeuno.es', 'fca3d97bb6bbd55138f9af6ac121acda', 'Software', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-18 11:51:07', NULL, '2025-05-29 10:44:36', 1, '1', NULL, NULL, NULL),
(29, 'José', 'jose@efeuno.es', 'd98ae89d2fa4cd834e937adb7899f74d', 'Vilar Beas', '', '', '46970', 'Valencia', 'España', '911499662', '', '', NULL, NULL, '2025-05-27 10:03:39', 2, '1', 'natymgh959096f230a206458a20b3', '1,2,3', NULL),
(34, 'ProfeUNO', 'micorreo@correos.net', 'd98ae89d2fa4cd834e937adb7899f74d', 'UNO PROFE', '', '', '', '', '', '', '', 'micorreo@correos.net', NULL, NULL, NULL, 2, '1', 'ojtys1r1labbcfe7d5690b983042d', '1', NULL),
(35, 'Pepe', 'pep@botella.es', 'd98ae89d2fa4cd834e937adb7899f74d', 'Botella', '', '', '', '', '', '', '', 'pep@botella.es', NULL, NULL, NULL, 2, '1', 'rjtyjq1x68cc806586b9937f26a121', '1', NULL),
(36, 'Bilingue', 'manuel.villamayor@uv.es', 'd98ae89d2fa4cd834e937adb7899f74d', 'Poliglota', '', '', '', '', '', '', '', '', NULL, NULL, '2025-10-22 09:17:26', 2, '1', 'rjtyj1p11d2f37f65ac55589ff1498', '1,11', NULL),
(37, 'Profe', 'profe1@ing.es', 'd98ae89d2fa4cd834e937adb7899f74d', 'Primero', '', '', '', '', '', '', '', 'profe1@ing.es', NULL, NULL, NULL, 2, '1', 'yjtysmw52c3c8b6288a5b2ec37c87', '12', NULL),
(38, 'Profe', 'profe2@ing.es', 'd98ae89d2fa4cd834e937adb7899f74d', 'Segungo', '', '', '', '', '', '', '', 'profe2@ing.es', NULL, NULL, NULL, 2, '1', 'yjtysnaa373776f4d59ec2630c280', '12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_prescriptores`
--

CREATE TABLE `tm_prescriptores` (
  `idPrescripcion` int NOT NULL,
  `nomPrescripcion` varchar(255) DEFAULT NULL,
  `apePrescripcion` varchar(255) DEFAULT NULL,
  `sexoPrescripcion` varchar(255) DEFAULT NULL,
  `fecNacPrescripcion` date DEFAULT NULL,
  `anoPrevistoPrescripcion` varchar(255) DEFAULT NULL,
  `emailCasaPrescripcion` varchar(255) DEFAULT NULL,
  `emailAltPrescripcion` varchar(255) DEFAULT NULL,
  `fechContactoPrescripcion` date DEFAULT NULL,
  `dirCasaPrescripcion` varchar(255) DEFAULT NULL,
  `dirAltPrescripcion` varchar(255) DEFAULT NULL,
  `cursoPrescripcion` varchar(255) DEFAULT NULL,
  `cpCasaPrescripcion` varchar(255) DEFAULT NULL,
  `cpAltPrescripcion` varchar(255) DEFAULT NULL,
  `cono1Prescripcion` varchar(255) DEFAULT NULL,
  `ciudadCasaPrescripcion` varchar(255) DEFAULT NULL,
  `ciudadAltPrescripcion` varchar(255) DEFAULT NULL,
  `cono2Prescripcion` varchar(255) DEFAULT NULL,
  `paisCasaPrescripcion` varchar(255) DEFAULT NULL,
  `paisAltPrescripcion` varchar(255) DEFAULT NULL,
  `cono3Prescripcion` varchar(255) DEFAULT NULL,
  `tefCasaPrescripcion` varchar(255) DEFAULT NULL,
  `tefAltPrescripcion` varchar(255) DEFAULT NULL,
  `probablementePrescripcion` varchar(255) DEFAULT NULL,
  `movilCasaPrescripcion` varchar(255) DEFAULT NULL,
  `movilAltPrescripcion` varchar(255) DEFAULT NULL,
  `grupoPrescripcion` varchar(255) DEFAULT NULL,
  `erasmusPrescripcion` varchar(255) DEFAULT NULL,
  `uniOrigenPrescripcion` varchar(255) DEFAULT NULL,
  `bildungsurlaub` varchar(255) DEFAULT NULL,
  `auPair` varchar(255) DEFAULT NULL,
  `fechMatConfirmacion` date DEFAULT NULL,
  `matCurso` varchar(255) DEFAULT NULL,
  `matAloja` varchar(255) DEFAULT NULL,
  `matFechInicio` date DEFAULT NULL,
  `obsPrescriptor` longtext,
  `estPrescripcion` int DEFAULT '1',
  `tokenPrescriptores` longtext COMMENT 'Token Preinscriptor',
  `numLlegada` varchar(225) DEFAULT NULL COMMENT 'Es el numero de llegada de l apersona, se traslada posteriormente a facturacion',
  `idDepartamentoEdu_prescriptores` int DEFAULT NULL COMMENT 'Viene de la tabla  tm_departamento_edu',
  `fecPrescripcion` date DEFAULT NULL,
  `tipoDocumento` varchar(225) DEFAULT NULL COMMENT 'Hae referencia al tipo, dni pasaporte...',
  `identificadorDocumento` varchar(225) DEFAULT NULL COMMENT 'Numero del identificador',
  `nombreMadrePre` varchar(225) DEFAULT NULL COMMENT 'Nombre y apellidos de la madre',
  `nombrePadrePre` varchar(225) DEFAULT NULL COMMENT 'Nombre y apellidos de la Padre',
  `numPadrePre` varchar(20) DEFAULT NULL COMMENT 'Telefono del padre',
  `numMadrePre` varchar(20) DEFAULT NULL COMMENT 'Telefono de la madre',
  `interesadoOnlinePre` int DEFAULT NULL COMMENT '0/1 Interesado en curso online',
  `nacionalidadPreinscriptor` varchar(255) DEFAULT NULL COMMENT 'Nacionalidad o idioma',
  `preferenciaHoraria` int DEFAULT '0' COMMENT '1= MAñanas 2=Tardes 0=Sin preferencais'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_prescriptores`
--

INSERT INTO `tm_prescriptores` (`idPrescripcion`, `nomPrescripcion`, `apePrescripcion`, `sexoPrescripcion`, `fecNacPrescripcion`, `anoPrevistoPrescripcion`, `emailCasaPrescripcion`, `emailAltPrescripcion`, `fechContactoPrescripcion`, `dirCasaPrescripcion`, `dirAltPrescripcion`, `cursoPrescripcion`, `cpCasaPrescripcion`, `cpAltPrescripcion`, `cono1Prescripcion`, `ciudadCasaPrescripcion`, `ciudadAltPrescripcion`, `cono2Prescripcion`, `paisCasaPrescripcion`, `paisAltPrescripcion`, `cono3Prescripcion`, `tefCasaPrescripcion`, `tefAltPrescripcion`, `probablementePrescripcion`, `movilCasaPrescripcion`, `movilAltPrescripcion`, `grupoPrescripcion`, `erasmusPrescripcion`, `uniOrigenPrescripcion`, `bildungsurlaub`, `auPair`, `fechMatConfirmacion`, `matCurso`, `matAloja`, `matFechInicio`, `obsPrescriptor`, `estPrescripcion`, `tokenPrescriptores`, `numLlegada`, `idDepartamentoEdu_prescriptores`, `fecPrescripcion`, `tipoDocumento`, `identificadorDocumento`, `nombreMadrePre`, `nombrePadrePre`, `numPadrePre`, `numMadrePre`, `interesadoOnlinePre`, `nacionalidadPreinscriptor`, `preferenciaHoraria`) VALUES
(6, 'Jose Manuel', 'Vilar Beas', 'M', '1988-10-27', '2025', 'jose@efeuno.es', 'luiscarlos@efeuno.es', '2025-01-26', '', '', 'Ingles Intensivo ', '46930', '', '1', 'C/ Vinatea 1º', '', '4', 'España', '', '4', '965956854', '965896569', '1', '632456456', '658785456', 'Los Efeuno', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', 'Viene con amigos', 1, 'zatyq1md4aa4b527a70225157e7626', '11', 2, '2025-01-26', '1', '202501261726JV', '', '', '', '', 0, 'Francia', 2),
(13, 'Alejandro', 'Jiménez Cabrera', 'M', '2003-02-10', '2025', 'alejandrosolvam@gmail.com', '', '2025-05-27', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '+34 635908583', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, '1aetyi1gs717940410c04f89e6d84', '11', 2, '2025-05-27', '1', '202505270932AJ', '', '', '', '', 0, 'Español', 0),
(16, 'Luis Carlos', 'Pérez', 'M', '1970-01-01', '2025', 'luiscarlos@ra82.es', 'luiscarlospm@gmail.com', '2025-08-22', '', '', 'Español para ingleses', '46139 Albatera', '', '', 'C/Vinagea, 6 nº23', '', '', 'España', 'Rusia', '', '965262384', '', '1', '660300923', '660300923', 'Efeuno ', '', '', '9', '2', '1970-10-10', '', '', '1970-01-01', 'Es una prueba de observaciones de interesados', 1, 'vhtyk1m1be1635bce84fe9b9c3a65', '11', 1, '2025-08-22', '1', '21451574A', '', '', '', '', 1, 'Español', 1),
(17, 'Luis', 'Carlos', 'M', '1999-02-01', '2025', 'jose.mvb.cc@gmail.com', '', '2025-08-26', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'zhtyl1s1b88f882ea9a25a5bbc009', '11', 1, '2025-08-26', '1', '202508261245LC', '', '', '', '', 0, 'Frances', 0),
(18, 'Shoei', 'Kaneyama', 'M', '1999-06-09', '2025', 'luiscarlospm@gmail.com', '', '2025-09-11', '', '', 'Español Intensivo', '46970', '98778', '1', 'C/ Vinatea 2', 'Chaulin 34', '', 'España', 'Japon', '', '', '', '1', '611499662', '', 'The Japos', '', '', '9', '2', '1970-01-01', '', '', '1970-01-01', 'Es dislexico ', 1, 'kityj11efb98a977f64e2c4de414b', '11', 1, '2025-09-11', '1', '202509111050SK', '', '', '', '', 1, 'Japones', 1),
(19, 'Uno', 'AlumnoUno', 'F', '1980-11-05', '2025', 'manuel.villamayor@uv.es', '', '2025-09-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '+963610367', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yityjve616c6be54ef2d7b17d8d18', '11', 1, '2025-09-25', '1', '1111111', '', '', '', '', 0, 'frances', 0),
(20, 'dos', 'AlumnoDOS', 'F', '2012-03-31', '2025', 'mail@gmail.com', '', '2025-09-29', '', '', 'Ingles Intensivo  ', '', '', '', '', '', '', '', '', '', '96133225', '', '1', '961222222', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', 'este alumno es menor', 1, '1cityr1ypfcfba871ae229af87372', '11', 1, '2025-09-29', '3', 'B9675493', 'Dolores Pérez', 'Pedro Pardo', '', '', 0, '', 0),
(21, 'peter', 'kyo', 'M', '1970-01-01', '2025', 'mail2@mail.es', '', '2025-10-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'ajtyn1oe01d3a11d05578784a9261', '11', 1, '2025-10-01', '1', '202510011359PK', '', '', '', '', 0, 'Japonés', 0),
(22, 'Son', 'kyo', 'M', '1970-01-01', '2025', 'mail2@mail.es', '', '2025-10-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'ajtyna1j7d6475c8490f504e684db1', '11', 1, '2025-10-01', '1', '202510011401SK', '', '', '', '', 0, 'Japonés', 0),
(23, 'Hija', 'Kyo', 'F', '2010-10-20', '2025', 'mail2@mail.es', '', '2025-10-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'ajtyncx76be660144c230119b2877', '11', 1, '2025-10-01', '1', '202510011402HK', '', 'Peter Kyo', '', '', 0, 'Japonés', 0),
(24, 'jaime', 'pernales', '', '1970-01-01', '2025', 'jaime@ominio.es', '', '2025-10-13', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'mjtyo1tsb8b4898ef68773ff177572', '11', 1, '2025-10-13', '1', '123142hhh', '', '', '', '', 0, '', 0),
(25, 'maria', 'pernales', '', '1970-01-01', '2025', 'maria@dominio.es', '', '2025-10-13', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'mjtyo1u1lc20608d3660deb1c2fd2', '11', 1, '2025-10-13', '1', '12345kkk', '', '', '', '', 0, '', 0),
(26, 'pablo', 'picasso', '', '1970-01-01', '2025', 'mi@mal.es', '', '2025-10-13', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'mjtyw1s1w12ffbe1c62c458461b2b', '11', 1, '2025-10-13', '1', 'B96754533', '', '', '', '', 0, 'Japonés', 0),
(27, 'Laura', 'Engel', '', '1970-01-01', '2025', 'nolotengo@mail.es', '', '2025-10-17', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'qjtyl1j1zead9b9c75147f867108c', '11', 1, '2025-10-17', '1', '25101701', '', '', '', '', 0, 'Noruego', 0),
(28, 'Graham', 'White', '', '1970-01-01', '2025', 'nomelose@mail.es', '', '2025-10-17', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'qjtyl1m11g60ce93d96cfe55192e04', '11', 1, '2025-10-17', '1', '25101702', '', '', '', '', 0, 'Alemán', 0),
(29, 'Antonio', 'prieto', '', '1970-01-01', '2025', 'prieto@uv.es', '', '2025-10-20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'tjtytfod9e3e8fe7b091f4986cd25', '11', 1, '2025-10-20', '1', '1112225k', '', '', '', '', 0, '', 0),
(30, 'jose', 'zorrilla', '', '1970-01-01', '2025', 'jz@uv.es', '', '2025-10-20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'tjtytgf7ff70096672128067e1fff', '11', 11, '2025-10-20', '1', '333335655h', '', '', '', '', 0, '', 0),
(31, 'maria', 'santos', '', '1970-01-01', '2025', 'santos@uv.es', '', '2025-10-20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'tjtytnh833d36ce6c5139fd8076c3', '11', 11, '2025-10-20', '1', '333356644g', '', '', '', '', 0, '', 0),
(32, 'javier', 'perez', '', '1970-01-01', '2025', 'perez@uv.es', '', '2025-10-20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'tjtytp1gee17089b615589faabff90', '11', 1, '2025-10-20', '1', '55646666l', '', '', '', '', 0, '', 0),
(33, 'roberto', 'Feliz', '', '1970-01-01', '2025', 'feliz@uv.es', '', '2025-10-20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'tjtyttm6cba6471161f253c0f9fb8', '11', 1, '2025-10-20', '1', '44455555k', '', '', '', '', 0, '', 0),
(34, 'jesus', 'vazquez', '', '1970-01-01', '2025', 'jesus@uv.es', '', '2025-10-20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'tjtyt1lo5f565b107e6481ca87b35d', '11', 1, '2025-10-20', '1', '45566665', '', '', '', '', 0, '', 0),
(35, 'pRIMER ', 'HERMANO', '', '1970-01-01', '2025', 'PRIMER@HERMANO.ES', '', '2025-10-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yjtysh1ke70b26b2eea80b8ddb1739', '11', 12, '2025-10-25', '1', '1H', '', '', '', '', 0, '', 0),
(36, 'segundo', 'hermano', '', '1970-01-01', '2025', 'segundo@hermano.es', '', '2025-10-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yjtysild71d48e970374323d7d5cc', '11', 12, '2025-10-25', '1', '2h', '', '', '', '', 0, '', 0),
(37, 'tercer', 'hermano', '', '1970-01-01', '2025', 'tercer@hermano.es', '', '2025-10-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yjtysi1r11afe9467bd33c28778e9f', '11', 12, '2025-10-25', '1', '3h', '', '', '', '', 0, '', 0),
(38, 'cuarto', 'hermano', '', '1970-01-01', '2025', 'cuarto@hermano.es', '', '2025-10-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yjtysj1se6ec09ef9d0bbf9eb52b97', '11', 12, '2025-10-25', '1', '4h', '', '', '', '', 0, '', 0),
(39, 'primer', 'ingles', '', '1970-01-01', '2025', 'ingles1@uv.es', '', '2025-10-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yjtysk1dc3cea6632706240517de45', '11', 12, '2025-10-25', '1', '1i', '', '', '', '', 0, '', 0),
(40, 'segundo', 'ingles', '', '1970-01-01', '2025', 'ingles2@uv.es', '', '2025-10-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yjtyslkafbe7af4867171461b6694', '11', 12, '2025-10-25', '1', '2i', '', '', '', '', 0, '', 0),
(41, 'tercer', 'ingles', '', '1970-01-01', '2025', 'ingles3@uv.es', '', '2025-10-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yjtysl1k6420df2d7648bde63f4d2c', '11', 12, '2025-10-25', '1', '3i', '', '', '', '', 0, '', 0),
(42, 'test', 'test', 'F', '2025-10-28', '2025', 'jose.mvb.cc@gmail.com', 'jose.mvv.cc@gmail.com', '2025-10-28', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, '1bjtyl1ht9c924d0b584cc703863c', '11', 1, '2025-10-28', '1', '202510281234TT', '', '', '', '', 0, '', 0),
(43, 'Pepito l', 'Grillo', 'M', '2005-01-10', '2025', 'GRILL@UV.ES', '', '2025-11-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yktykq1u4fd7ebcfd96193b3f54d45', '11', 1, '2025-11-25', '1', '22356885HHH', '', '', '', '', 0, 'Español', 0),
(44, 'Manolo', 'Grillo', '', '1970-01-01', '2025', 'im@uv.es', '', '2025-11-25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'yktyk1fu9c0f419968c98af151bafb', '11', 1, '2025-11-25', '1', '202511251132MG', '', '', '', '', 0, 'Español', 0),
(45, 'egerg', 'reer', '', '1970-01-01', '2025', 'jose.mvb.cc@gmail.com', 'jose.mvb.cc@gmail.com', '2025-11-26', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'zktylon1299a7b1bd1338648143ba', '11', 1, '2025-11-26', '1', '202511261215ER', '', '', '', '', 0, 'Español', 0),
(46, 'Jose', 'Test', '', '1970-01-01', '2025', 'jose.mvb.cc@gmail.com', '', '2025-12-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'altymd11c68991dbb83f7bfcaf254', '11', 1, '2025-12-01', '1', '202512011304JT', '', '', '', '', 0, '', 0),
(47, 'Ignacio', 'Bel', '', '1970-01-01', '2025', 'ign@uv.com', '', '2025-12-10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'jltyk1y1z2f8c9c832c4ad1e3b12b', '11', 1, '2025-12-10', '1', '202512101151IB', '', '', '', '', 0, 'Español', 0),
(48, 'Frances', 'fr', '', '1970-01-01', '2025', 'fr01@uv.es', '', '2025-12-10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'jltyls1n87254d9c49fc68c961d3b2', '11', 1, '2025-12-10', '1', 'fr555', '', '', '', '', 0, '', 0),
(49, 'Fracncis', 'fr', '', '1970-01-01', '2025', '66@uv.es', '', '2025-12-10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-10-10', '', '', '1970-01-01', '', 1, 'jltyltxa12e704083996cd49cce4b', '11', 1, '2025-12-10', '1', 'fr66', '', '', '', '', 0, '', 0),
(50, 'Nuevo ESP', 'esp', '', '1970-01-01', '2025', 'jose@gmail.com', '', '2025-12-10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'jltyl1ec17275c0669cdb5675aa1c5', '11', 1, '2025-12-10', '1', '202512101230NE', '', '', '', '', 0, '', 0),
(51, 'Jose', 'Beas', '', '1970-01-01', '2025', 'josetest@gmail.com', '', '2025-12-19', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '1970-01-01', '', '', '1970-01-01', '', 1, 'sltyq1g1rba008e94350460b53cf1', '11', 11, '2025-12-19', '1', '202512191733JB', '', '', '', '', 0, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_ruta`
--

CREATE TABLE `tm_ruta` (
  `id_ruta` int NOT NULL,
  `idiomaId_ruta` int DEFAULT NULL,
  `tipoId_ruta` int DEFAULT NULL,
  `nivelId_ruta` int DEFAULT NULL,
  `maxAlum_ruta` int DEFAULT NULL,
  `minAlum_ruta` int DEFAULT '1',
  `perRefresco_ruta` int DEFAULT '0' COMMENT 'Es la periodicidad de cada cuanto se le tiene que recordar el paso de nivel (Este campo es el valor numérico y el siguiente medidaRefresco_ruta es el tipo "diario, semanas o meses), si figura 0 no se avisará del  cambio y deberá ser totalmente manual.',
  `medidaRefresco_ruta` int DEFAULT '0' COMMENT '0 - Sin medida // 1 - dias // 2 - Semanas // 3 - meses',
  `est_ruta` int NOT NULL DEFAULT '1' COMMENT '0 - Desactivado // 1 - Activado',
  `peso_ruta` int NOT NULL DEFAULT '1' COMMENT 'Es el peso que va a tener el nivel dentro del IDIOMA / TIPO de CURSO (Dentroi de IDIOMA, TIPO de curso ordenaremos por este campo).'
) ;

--
-- Volcado de datos para la tabla `tm_ruta`
--

INSERT INTO `tm_ruta` (`id_ruta`, `idiomaId_ruta`, `tipoId_ruta`, `nivelId_ruta`, `maxAlum_ruta`, `minAlum_ruta`, `perRefresco_ruta`, `medidaRefresco_ruta`, `est_ruta`, `peso_ruta`) VALUES
(1, 1, 1, 1, 8, 1, 1, 2, 1, 1),
(2, 1, 1, 2, 8, 1, 1, 2, 1, 2),
(3, 1, 1, 4, 15, 1, 1, 1, 1, 3),
(4, 1, 4, 1, 3, 1, 1, 1, 1, 1),
(5, 1, 4, 2, 3, 1, 1, 1, 1, 2),
(6, 1, 4, 3, 2, 1, 1, 1, 1, 3),
(7, 1, 4, 5, 2, 1, 1, 1, 1, 4),
(8, 1, 4, 6, 1, 1, 1, 1, 1, 5),
(9, 1, 1, 3, 8, 1, 1, 2, 1, 4),
(10, 1, 1, 5, 8, 1, 1, 2, 1, 5),
(11, 9, 1, 8, 20, 1, 10, 3, 1, 1),
(12, 9, 1, 9, 2, 1, 1, 1, 1, 2),
(13, 9, 1, 10, 3, 1, 2, 1, 1, 3),
(14, 9, 1, 11, 4, 1, 2, 1, 1, 4),
(17, 2, 1, 7, 2, 1, 1, 0, 1, 1),
(18, 2, 3, 14, 2, 1, 1, 1, 1, 1),
(19, 2, 3, 15, 2, 1, 1, 1, 1, 2),
(20, 2, 3, 16, 2, 1, 1, 1, 1, 3),
(21, 2, 3, 17, 2, 1, 1, 1, 1, 4),
(22, 10, 1, 18, 4, 4, 1, 1, 1, 1),
(23, 10, 1, 19, 4, 2, 1, 1, 1, 2),
(24, 1, 2, 1, 6, 1, 1, 1, 1, 1),
(25, 1, 2, 2, 6, 1, 1, 1, 1, 2),
(26, 9, 3, 1, 8, 1, 1, 2, 1, 1),
(27, 9, 3, 2, 8, 1, 1, 2, 1, 2),
(28, 9, 3, 4, 15, 1, 1, 1, 1, 3),
(29, 9, 3, 3, 8, 1, 1, 2, 1, 4),
(30, 9, 3, 5, 8, 1, 1, 2, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_suplidosLlegadas_edu`
--

CREATE TABLE `tm_suplidosLlegadas_edu` (
  `idSuplido` int NOT NULL,
  `idsuplido_tmLlegadas` int NOT NULL COMMENT 'id de la tabla TM_LLEGADAS',
  `importeSuplido` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL COMMENT 'importe del suplido',
  `descripcionSuplido` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_suplidosLlegadas_edu`
--

INSERT INTO `tm_suplidosLlegadas_edu` (`idSuplido`, `idsuplido_tmLlegadas`, `importeSuplido`, `descripcionSuplido`) VALUES
(3, 2, '6', 'test'),
(4, 3, '50', 'DELE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_suscripcion`
--

CREATE TABLE `tm_suscripcion` (
  `idSuscripcion` int NOT NULL COMMENT 'Suscripcion nueva. Será para cada suscripcion pagada.',
  `idSoftware` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT '"API" cifrada del usuario de la suscripcion',
  `nombreDominio` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT '"Dominio" de la empresa para verificación y identificación',
  `gesdoc_m` tinyint(1) DEFAULT NULL COMMENT 'Modulo de Gestion de Documentos',
  `cms_m` tinyint(1) DEFAULT NULL COMMENT 'Modulo de CMS. Página Web Personalizable',
  `inscripciones_m` tinyint(1) DEFAULT NULL COMMENT 'Modulo de Inscripciones. Diseñado para apuntarse a concurso etc..',
  `facturacion_m` tinyint(1) DEFAULT NULL COMMENT 'Modulo de Facturación. ',
  `helpdesk_m` tinyint(1) DEFAULT NULL COMMENT 'Modulo de Tickets. Formulario con incidencias y registro de tickets',
  `transporte_m` int DEFAULT NULL COMMENT 'Modulo de documentos de transportistas',
  `avisos_m` tinyint(1) NOT NULL COMMENT 'Avisos Fontaneria elevtricista etc',
  `educacion_m` tinyint DEFAULT NULL COMMENT 'Modulo Educación Costa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_suscripcion`
--

INSERT INTO `tm_suscripcion` (`idSuscripcion`, `idSoftware`, `nombreDominio`, `gesdoc_m`, `cms_m`, `inscripciones_m`, `facturacion_m`, `helpdesk_m`, `transporte_m`, `avisos_m`, `educacion_m`) VALUES
(3, '5e229fa1ad48b23125bf8d7611db6e3d', 'leader.efeuno.com.es', 0, 0, 0, 0, 0, 1, 0, 0),
(4, 'e09d872026ee369ad89b179e7c03c2ad', 'leader-transport.com', 0, 0, 0, 0, 0, 1, 0, 0),
(5, '20dbbc187c601e5c90d7b79a83bead2f', 'newcosta.efeuno.com.es', 1, 1, 1, 1, 1, 1, 1, 0),
(6, '5c40abbf1071a62d26ec17465ae0d3df', 'granangularfoto.com', 1, 1, 1, 1, 1, 1, 1, 1),
(11, '0ef96da43cfde4ba21a16a4d473841', 'http://localhost/', 1, 1, 1, 1, 1, 1, 1, 1),
(12, '421aa90e079fa326b6494f812ad13e79', 'localhost', 1, 1, 1, 1, 1, 1, 1, 1),
(13, '4ad0555706c402a9fa46c9ebfcede163', 'costavalencia.efeuno.com.es', 1, 1, 1, 1, 1, 1, 1, 1),
(14, '623d438fa71145d726be1d4be0743a82', '192.168.31.35', 1, 1, 1, 1, 1, 1, 1, 1),
(15, '8aeaf6b323b2403a639b95e1cd1f0370', 'costavalencia.ra82.es', 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_tarifa`
--

CREATE TABLE `tm_tarifa` (
  `idTarifa` int NOT NULL COMMENT 'id tarifa',
  `idIva_tarifa` int DEFAULT NULL COMMENT 'id del iva',
  `idDepartament_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cod_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `nombre_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `unidades_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `unidad_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `precio_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cuenta1_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cuenta2_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cuenta3_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tipo_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `descuento_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `descripcion_tarifa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fechaInsert` datetime DEFAULT NULL,
  `estTarifa` tinyint(1) DEFAULT '1',
  `iva_tarifa` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_tarifa`
--

INSERT INTO `tm_tarifa` (`idTarifa`, `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`, `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`, `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`, `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`) VALUES
(1, 16, '1', 'com', 'Agente', '', '', '0', '705000000000', '555000000000', '555500000000', 'Alojamiento', '10', 'Agente', '2025-09-23 13:48:52', 0, 16),
(2, 16, '1', 'fad0', 'Alojamiento en familia, AD', '', '', '0', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(3, 0, '1', 'fad1', 'Alojamiento en familia, AD', '1', 'semana', '200', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 0),
(4, 16, '1', 'fad10', 'Alojamiento en familia, AD', '10', 'semanas', '1850', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(5, 16, '1', 'fad11', 'Alojamiento en familia, AD', '11', 'semanas', '2030', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(6, 16, '1', 'fad12', 'Alojamiento en familia, AD', '12', 'semanas', '2210', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(7, 16, '1', 'fad13', 'Alojamiento en familia, AD', '13', 'semanas', '2390', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(8, 16, '1', 'fad14', 'Alojamiento en familia, AD', '14', 'semanas', '2570', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(9, 16, '1', 'fad15', 'Alojamiento en familia, AD', '15', 'semanas', '2750', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(10, 16, '1', 'fad16', 'Alojamiento en familia, AD', '16', 'semanas', '2930', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(11, 16, '1', 'fad17', 'Alojamiento en familia, AD', '17', 'semanas', '3110', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(12, 16, '1', 'fad2', 'Alojamiento en familia, AD', '2', 'semanas', '390', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(13, 16, '1', 'fad20', 'Alojamiento en familia, AD', '20', 'semanas', '3650', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(14, 16, '1', 'fad21', 'Alojamiento en familia, AD', '21', 'semanas', '3830', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(15, 16, '1', 'fad22', 'Alojamiento en familia, AD', '22', 'semanas', '4010', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(16, 16, '1', 'fad23', 'Alojamiento en familia, AD', '23', 'semanas', '4190', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(17, 16, '1', 'fad24', 'Alojamiento en familia, AD', '24', 'semanas', '4370', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(18, 16, '1', 'fad25', 'Alojamiento en familia, AD', '25', 'semanas', '4550', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(19, 16, '1', 'fad26', 'Alojamiento en familia, AD', '26', 'semanas', '4730', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(20, 16, '1', 'fad27', 'Alojamiento en familia, AD', '27', 'semanas', '4910', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(21, 16, '1', 'fad28', 'Alojamiento en familia, AD', '28', 'semanas', '5090', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(22, 16, '1', 'fad29', 'Alojamiento en familia, AD', '29', 'semanas', '5270', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(23, 16, '1', 'fad3', 'Alojamiento en familia, AD', '3', 'semanas', '580', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(24, 16, '1', 'fad30', 'Alojamiento en familia, AD', '30', 'semanas', '5450', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(25, 16, '1', 'fad31', 'Alojamiento en familia, AD', '31', 'semanas', '5630', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(26, 16, '1', 'fad32', 'Alojamiento en familia, AD', '32', 'semanas', '5810', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(27, 16, '1', 'fad33', 'Alojamiento en familia, AD', '33', 'semanas', '5990', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(28, 16, '1', 'fad34', 'Alojamiento en familia, AD', '34', 'semanas', '6170', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(29, 16, '1', 'fad35', 'Alojamiento en familia, AD', '35', 'semanas', '6350', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(30, 16, '1', 'fad36', 'Alojamiento en familia, AD', '36', 'semanas', '6530', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(31, 16, '1', 'fad37', 'Alojamiento en familia, AD', '37', 'semanas', '6710', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(32, 16, '1', 'fad38', 'Alojamiento en familia, AD', '38', 'semanas', '6890', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(33, 16, '1', 'fad39', 'Alojamiento en familia, AD', '39', 'semanas', '7070', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(34, 16, '1', 'fad4', 'Alojamiento en familia, AD', '4', 'semanas', '770', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(35, 16, '1', 'fad40', 'Alojamiento en familia, AD', '40', 'semanas', '7250', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(36, 16, '1', 'fad41', 'Alojamiento en familia, AD', '41', 'semanas', '7430', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(37, 16, '1', 'fad42', 'Alojamiento en familia, AD', '42', 'semanas', '7610', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(38, 16, '1', 'fad43', 'Alojamiento en familia, AD', '43', 'semanas', '7790', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(39, 16, '1', 'fad44', 'Alojamiento en familia, AD', '44', 'semanas', '7970', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(40, 16, '1', 'fad45', 'Alojamiento en familia, AD', '45', 'semanas', '8150', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(41, 16, '1', 'fad46', 'Alojamiento en familia, AD', '46', 'semanas', '8330', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(42, 16, '1', 'fad47', 'Alojamiento en familia, AD', '47', 'semanas', '8510', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(43, 16, '1', 'fad48', 'Alojamiento en familia, AD', '48', 'semanas', '8690', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(44, 16, '1', 'fad49', 'Alojamiento en familia, AD', '49', 'semanas', '8870', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(45, 16, '1', 'fad5', 'Alojamiento en familia, AD', '5', 'semanas', '950', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(46, 16, '1', 'fad50', 'Alojamiento en familia, AD', '50', 'semanas', '9050', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(47, 16, '1', 'fad51', 'Alojamiento en familia, AD', '51', 'semanas', '9230', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(48, 16, '1', 'fad52', 'Alojamiento en familia, AD', '52', 'semanas', '9410', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(49, 16, '1', 'fad53', 'Alojamiento en familia, AD', '53', 'semanas', '9590', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(50, 16, '1', 'fad6', 'Alojamiento en familia, AD', '6', 'semanas', '1130', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(51, 16, '1', 'fad7', 'Alojamiento en familia, AD', '7', 'semanas', '1310', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(52, 16, '1', 'fad8', 'Alojamiento en familia, AD', '8', 'semanas', '1490', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(53, 16, '1', 'fad9', 'Alojamiento en familia, AD', '9', 'semanas', '1670', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(54, 16, '1', 'fade', 'Alojamiento en familia, AD', '1', '', '28', '705100000000', '752100000001', '752100000001', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(55, 16, '1', 'fade2', 'Alojamiento en familia, AD', '2', '', '56', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(56, 16, '1', 'fade3', 'Alojamiento en familia, AD', '3', '', '84', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(57, 16, '1', 'fade4', 'Alojamiento en familia, AD', '4', '', '112', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(58, 16, '1', 'fade5', 'Alojamiento en familia, AD', '5', '', '140', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(59, 16, '1', 'fade6', 'Alojamiento en familia, AD', '6', '', '168', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, AD', '2025-09-23 13:48:52', 1, 16),
(60, 16, '1', 'fmp0', 'Alojamiento en familia, MP', '', '', '0', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(61, 16, '1', 'fmp1', 'Alojamiento en familia, MP', '1', 'semana', '220', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(62, 16, '1', 'fmp10', 'Alojamiento en familia, MP', '10', 'semanas', '2050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(63, 16, '1', 'fmp11', 'Alojamiento en familia, MP', '11', 'semanas', '2250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(64, 16, '1', 'fmp12', 'Alojamiento en familia, MP', '12', 'semanas', '2450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(65, 16, '1', 'fmp13', 'Alojamiento en familia, MP', '13', 'semanas', '2650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(66, 16, '1', 'fmp14', 'Alojamiento en familia, MP', '14', 'semanas', '2850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(67, 16, '1', 'fmp15', 'Alojamiento en familia, MP', '15', 'semanas', '3050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(68, 16, '1', 'fmp16', 'Alojamiento en familia, MP', '16', 'semanas', '3250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(69, 16, '1', 'fmp17', 'Alojamiento en familia, MP', '17', 'semanas', '3450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(70, 16, '1', 'fmp18', 'Alojamiento en familia, MP', '18', 'semanas', '3650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '10', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(71, 16, '1', 'fmp19', 'Alojamiento en familia, MP', '19', 'semanas', '3850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '10', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(72, 16, '1', 'fmp2', 'Alojamiento en familia, MP', '2', 'semanas', '430', '705100000000', '752100000002', '752100000002', 'Alojamiento', '10', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(73, 16, '1', 'fmp20', 'Alojamiento en familia, MP', '20', 'semanas', '4050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '10', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(74, 16, '1', 'fmp21', 'Alojamiento en familia, MP', '21', 'semanas', '4250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '10', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(75, 16, '1', 'fmp22', 'Alojamiento en familia, MP', '22', 'semanas', '4450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(76, 16, '1', 'fmp23', 'Alojamiento en familia, MP', '23', 'semanas', '4650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(77, 16, '1', 'fmp24', 'Alojamiento en familia, MP', '24', 'semanas', '4850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(78, 16, '1', 'fmp25', 'Alojamiento en familia, MP', '25', 'semanas', '5050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(79, 16, '1', 'fmp26', 'Alojamiento en familia, MP', '26', 'semanas', '5250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(80, 16, '1', 'fmp27', 'Alojamiento en familia, MP', '27', 'semanas', '5450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(81, 16, '1', 'fmp28', 'Alojamiento en familia, MP', '28', 'semanas', '5650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(82, 16, '1', 'fmp29', 'Alojamiento en familia, MP', '29', 'semanas', '5850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(83, 16, '1', 'fmp3', 'Alojamiento en familia, MP', '3', 'semanas', '640', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(84, 16, '1', 'fmp30', 'Alojamiento en familia, MP', '30', 'semanas', '6050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(85, 16, '1', 'fmp31', 'Alojamiento en familia, MP', '31', 'semanas', '6250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(86, 16, '1', 'fmp32', 'Alojamiento en familia, MP', '32', 'semanas', '6450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(87, 16, '1', 'fmp33', 'Alojamiento en familia, MP', '33', 'semanas', '6650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(88, 16, '1', 'fmp34', 'Alojamiento en familia, MP', '34', 'semanas', '6850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(89, 16, '1', 'fmp35', 'Alojamiento en familia, MP', '35', 'semanas', '7050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(90, 16, '1', 'fmp36', 'Alojamiento en familia, MP', '36', 'semanas', '7250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(91, 16, '1', 'fmp37', 'Alojamiento en familia, MP', '37', 'semanas', '7450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(92, 16, '1', 'fmp38', 'Alojamiento en familia, MP', '38', 'semanas', '7650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(93, 16, '1', 'fmp39', 'Alojamiento en familia, MP', '39', 'semanas', '7850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(94, 16, '1', 'fmp4', 'Alojamiento en familia, MP', '4', 'semanas', '850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(95, 16, '1', 'fmp40', 'Alojamiento en familia, MP', '40', 'semanas', '8050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(96, 16, '1', 'fmp41', 'Alojamiento en familia, MP', '41', 'semanas', '8250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(97, 16, '1', 'fmp42', 'Alojamiento en familia, MP', '42', 'semanas', '8450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(98, 16, '1', 'fmp43', 'Alojamiento en familia, MP', '43', 'semanas', '8650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(99, 16, '1', 'fmp44', 'Alojamiento en familia, MP', '44', 'semanas', '8850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(100, 16, '1', 'fmp45', 'Alojamiento en familia, MP', '45', 'semanas', '9050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(101, 16, '1', 'fmp46', 'Alojamiento en familia, MP', '46', 'semanas', '9250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(102, 16, '1', 'fmp47', 'Alojamiento en familia, MP', '47', 'semanas', '9450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(103, 16, '1', 'fmp48', 'Alojamiento en familia, MP', '48', 'semanas', '9650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(104, 16, '1', 'fmp49', 'Alojamiento en familia, MP', '49', 'semanas', '9850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(105, 16, '1', 'fmp5', 'Alojamiento en familia, MP', '5', 'semanas', '1050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(106, 16, '1', 'fmp50', 'Alojamiento en familia, MP', '50', 'semanas', '10050', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(107, 16, '1', 'fmp51', 'Alojamiento en familia, MP', '51', 'semanas', '10250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(108, 16, '1', 'fmp52', 'Alojamiento en familia, MP', '52', 'semanas', '10450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(109, 16, '1', 'fmp53', 'Alojamiento en familia, MP', '53', 'semanas', '10650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(110, 16, '1', 'fmp6', 'Alojamiento en familia, MP', '6', 'semanas', '1250', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(111, 16, '1', 'fmp7', 'Alojamiento en familia, MP', '7', 'semanas', '1450', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(112, 16, '1', 'fmp8', 'Alojamiento en familia, MP', '8', 'semanas', '1650', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(113, 16, '1', 'fmp9', 'Alojamiento en familia, MP', '9', 'semanas', '1850', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(114, 16, '1', 'fmpe', 'Alojamiento en familia, MP', '1', '', '30', '705100000000', '752100000002', '752100000002', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(115, 16, '1', 'fmpe2', 'Alojamiento en familia, MP', '2', '', '60', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(116, 16, '1', 'fmpe3', 'Alojamiento en familia, MP', '3', '', '90', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(117, 16, '1', 'fmpe4', 'Alojamiento en familia, MP', '4', '', '120', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(118, 16, '1', 'fmpe5', 'Alojamiento en familia, MP', '5', '', '150', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(119, 16, '1', 'fmpe6', 'Alojamiento en familia, MP', '6', '', '180', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, MP', '2025-09-23 13:48:52', 1, 16),
(120, 16, '1', 'fpc0', 'Alojamiento en familia, PC', '', '', '0', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(121, 16, '1', 'fpc1', 'Alojamiento en familia, PC', '1', 'semana', '240', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(122, 16, '1', 'fpc10', 'Alojamiento en familia, PC', '10', 'semanas', '2310', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(123, 16, '1', 'fpc11', 'Alojamiento en familia, PC', '11', 'semanas', '2535', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(124, 16, '1', 'fpc12', 'Alojamiento en familia, PC', '12', 'semanas', '2760', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(125, 16, '1', 'fpc13', 'Alojamiento en familia, PC', '13', 'semanas', '2985', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(126, 16, '1', 'fpc14', 'Alojamiento en familia, PC', '14', 'semanas', '3210', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(127, 16, '1', 'fpc15', 'Alojamiento en familia, PC', '15', 'semanas', '3435', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(128, 16, '1', 'fpc16', 'Alojamiento en familia, PC', '16', 'semanas', '3660', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(129, 16, '1', 'fpc17', 'Alojamiento en familia, PC', '17', 'semanas', '3885', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(130, 16, '1', 'fpc18', 'Alojamiento en familia, PC', '18', 'semanas', '4110', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(131, 16, '1', 'fpc19', 'Alojamiento en familia, PC', '19', 'semanas', '4335', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(132, 16, '1', 'fpc2', 'Alojamiento en familia, PC', '2', 'semanas', '480', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(133, 16, '1', 'fpc20', 'Alojamiento en familia, PC', '20', 'semanas', '4560', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(134, 16, '1', 'fpc21', 'Alojamiento en familia, PC', '21', 'semanas', '4785', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(135, 16, '1', 'fpc22', 'Alojamiento en familia, PC', '22', 'semanas', '5010', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(136, 16, '1', 'fpc23', 'Alojamiento en familia, PC', '23', 'semanas', '5235', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(137, 16, '1', 'fpc24', 'Alojamiento en familia, PC', '24', 'semanas', '5460', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(138, 16, '1', 'fpc25', 'Alojamiento en familia, PC', '25', 'semanas', '5685', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(139, 16, '1', 'fpc26', 'Alojamiento en familia, PC', '26', 'semanas', '5910', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(140, 16, '1', 'fpc27', 'Alojamiento en familia, PC', '27', 'semanas', '6135', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(141, 16, '1', 'fpc28', 'Alojamiento en familia, PC', '28', 'semanas', '6360', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(142, 16, '1', 'fpc29', 'Alojamiento en familia, PC', '29', 'semanas', '6585', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(143, 16, '1', 'fpc3', 'Alojamiento en familia, PC', '3', 'semanas', '720', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(144, 16, '1', 'fpc30', 'Alojamiento en familia, PC', '30', 'semanas', '6810', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(145, 16, '1', 'fpc31', 'Alojamiento en familia, PC', '31', 'semanas', '7035', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(146, 16, '1', 'fpc32', 'Alojamiento en familia, PC', '32', 'semanas', '7260', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(147, 16, '1', 'fpc33', 'Alojamiento en familia, PC', '33', 'semanas', '7485', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(148, 16, '1', 'fpc34', 'Alojamiento en familia, PC', '34', 'semanas', '7710', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(149, 16, '1', 'fpc35', 'Alojamiento en familia, PC', '35', 'semanas', '7935', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(150, 16, '1', 'fpc36', 'Alojamiento en familia, PC', '36', 'semanas', '8160', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(151, 16, '1', 'fpc37', 'Alojamiento en familia, PC', '37', 'semanas', '8385', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(152, 16, '1', 'fpc38', 'Alojamiento en familia, PC', '38', 'semanas', '8610', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(153, 16, '1', 'fpc39', 'Alojamiento en familia, PC', '39', 'semanas', '8835', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(154, 16, '1', 'fpc4', 'Alojamiento en familia, PC', '4', 'semanas', '960', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(155, 16, '1', 'fpc40', 'Alojamiento en familia, PC', '40', 'semanas', '9060', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(156, 16, '1', 'fpc41', 'Alojamiento en familia, PC', '41', 'semanas', '9285', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(157, 16, '1', 'fpc42', 'Alojamiento en familia, PC', '42', 'semanas', '9510', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(158, 16, '1', 'fpc43', 'Alojamiento en familia, PC', '43', 'semanas', '9735', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(159, 16, '1', 'fpc44', 'Alojamiento en familia, PC', '44', 'semanas', '9960', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(160, 16, '1', 'fpc45', 'Alojamiento en familia, PC', '45', 'semanas', '10185', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(161, 16, '1', 'fpc46', 'Alojamiento en familia, PC', '46', 'semanas', '10410', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(162, 16, '1', 'fpc47', 'Alojamiento en familia, PC', '47', 'semanas', '10635', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(163, 16, '1', 'fpc48', 'Alojamiento en familia, PC', '48', 'semanas', '10860', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(164, 16, '1', 'fpc49', 'Alojamiento en familia, PC', '49', 'semanas', '11085', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(165, 16, '1', 'fpc5', 'Alojamiento en familia, PC', '5', 'semanas', '1185', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(166, 16, '1', 'fpc50', 'Alojamiento en familia, PC', '50', 'semanas', '11310', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(167, 16, '1', 'fpc51', 'Alojamiento en familia, PC', '51', 'semanas', '11535', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(168, 16, '1', 'fpc52', 'Alojamiento en familia, PC', '52', 'semanas', '11760', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(169, 16, '1', 'fpc53', 'Alojamiento en familia, PC', '53', 'semanas', '11985', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(170, 16, '1', 'fpc6', 'Alojamiento en familia, PC', '6', 'semanas', '1410', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(171, 16, '1', 'fpc7', 'Alojamiento en familia, PC', '7', 'semanas', '1635', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(172, 16, '1', 'fpc8', 'Alojamiento en familia, PC', '8', 'semanas', '1860', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(173, 16, '1', 'fpc9', 'Alojamiento en familia, PC', '9', 'semanas', '2085', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(174, 16, '1', 'fpce', 'Alojamiento en familia, PC', '1', '', '35', '705100000000', '752100000003', '752100000003', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(175, 16, '1', 'fpce2', 'Alojamiento en familia, PC', '2', '', '70', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(176, 16, '1', 'fpce3', 'Alojamiento en familia, PC', '3', '', '105', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(177, 16, '1', 'fpce4', 'Alojamiento en familia, PC', '4', '', '140', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(178, 16, '1', 'fpce5', 'Alojamiento en familia, PC', '5', '', '175', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(179, 16, '1', 'fpce6', 'Alojamiento en familia, PC', '6', '', '210', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Alojamiento en familia, PC', '2025-09-23 13:48:52', 1, 16),
(180, 16, '1', 'a0', 'Alojamiento:', '', 'oferta especial', '0', '705100000000', '705100000000', '752100000000', 'Alojamiento', '0', 'Alojamiento:', '2025-09-23 13:48:52', 1, 16),
(181, 16, '1', 'anu', '', '', '', '0', '', '', '', 'Otro', '100', '', '2025-09-23 13:48:52', 1, 16),
(182, 16, '1', 'cp0', 'Clases particulares,', '', '', '0', '705000000000', '700000000011', '700000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(183, 16, '1', 'cp1', 'Clases particulares,', '1', 'hora', '50', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(184, 16, '1', 'cp10', 'Clases particulares,', '10', 'horas', '350', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(185, 16, '1', 'cp100', 'Clases particulares,', '100', 'horas', '3300', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(186, 16, '1', 'cp100', 'Clases particulares,', '20', 'horas', '660', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(187, 16, '1', 'cp11', 'Clases particulares,', '11', 'horas', '385', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(188, 16, '1', 'cp12', 'Clases particulares,', '12', 'horas', '420', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(189, 16, '1', 'cp13', 'Clases particulares,', '13', 'horas', '455', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(190, 16, '1', 'cp14', 'Clases particulares,', '14', 'horas', '490', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(191, 16, '1', 'cp15', 'Clases particulares,', '15', 'horas', '525', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(192, 16, '1', 'cp16', 'Clases particulares,', '16', 'horas', '560', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(193, 16, '1', 'cp17', 'Clases particulares,', '17', 'horas', '595', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(194, 16, '1', 'cp18', 'Clases particulares,', '18', 'horas', '630', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(195, 16, '1', 'cp19', 'Clases particulares,', '19', 'horas', '665', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(196, 16, '1', 'cp2', 'Clases particulares,', '2', 'horas', '100', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(197, 16, '1', 'cp20', 'Clases particulares,', '20', 'horas', '660', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(198, 16, '1', 'cp21', 'Clases particulares,', '21', 'horas', '693', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(199, 16, '1', 'cp22', 'Clases particulares,', '22', 'horas', '726', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(200, 16, '1', 'cp23', 'Clases particulares,', '23', 'horas', '759', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(201, 16, '1', 'cp24', 'Clases particulares,', '24', 'horas', '792', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(202, 16, '1', 'cp25', 'Clases particulares,', '25', 'horas', '825', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(203, 16, '1', 'cp26', 'Clases particulares,', '26', 'horas', '858', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(204, 16, '1', 'cp27', 'Clases particulares,', '27', 'horas', '891', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(205, 16, '1', 'cp28', 'Clases particulares,', '28', 'horas', '924', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(206, 16, '1', 'cp29', 'Clases particulares,', '29', 'horas', '957', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(207, 16, '1', 'cp3', 'Clases particulares,', '3', 'horas', '150', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(208, 16, '1', 'cp30', 'Clases particulares,', '30', 'horas', '990', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(209, 16, '1', 'cp31', 'Clases particulares,', '31', 'horas', '1023', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(210, 16, '1', 'cp32', 'Clases particulares,', '32', 'horas', '1056', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(211, 16, '1', 'cp33', 'Clases particulares,', '33', 'horas', '1089', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(212, 16, '1', 'cp34', 'Clases particulares,', '34', 'horas', '1122', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(213, 16, '1', 'cp35', 'Clases particulares,', '35', 'horas', '1155', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(214, 16, '1', 'cp36', 'Clases particulares,', '36', 'horas', '1188', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(215, 16, '1', 'cp37', 'Clases particulares,', '37', 'horas', '1221', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(216, 16, '1', 'cp38', 'Clases particulares,', '38', 'horas', '1254', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(217, 16, '1', 'cp39', 'Clases particulares,', '39', 'horas', '1287', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(218, 16, '1', 'cp4', 'Clases particulares,', '4', 'horas', '175', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(219, 16, '1', 'cp40', 'Clases particulares,', '40', 'horas', '1320', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(220, 16, '1', 'cp41', 'Clases particulares,', '41', 'horas', '1353', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(221, 16, '1', 'cp42', 'Clases particulares,', '42', 'horas', '1386', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(222, 16, '1', 'cp43', 'Clases particulares,', '43', 'horas', '1419', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(223, 16, '1', 'cp44', 'Clases particulares,', '44', 'horas', '1452', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(224, 16, '1', 'cp45', 'Clases particulares,', '45', 'horas', '1485', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(225, 16, '1', 'cp46', 'Clases particulares,', '46', 'horas', '1518', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(226, 16, '1', 'cp47', 'Clases particulares,', '47', 'horas', '1551', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(227, 16, '1', 'cp48', 'Clases particulares,', '48', 'horas', '1584', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(228, 16, '1', 'cp49', 'Clases particulares,', '49', 'horas', '1617', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(229, 16, '1', 'cp5', 'Clases particulares,', '5', 'horas', '200', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(230, 16, '1', 'cp50', 'Clases particulares,', '50', 'horas', '1650', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(231, 16, '1', 'cp51', 'Clases particulares,', '51', 'horas', '1683', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(232, 16, '1', 'cp52', 'Clases particulares,', '52', 'horas', '1716', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(233, 16, '1', 'cp53', 'Clases particulares,', '53', 'horas', '1749', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(234, 16, '1', 'cp54', 'Clases particulares,', '54', 'horas', '1782', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(235, 16, '1', 'cp55', 'Clases particulares,', '55', 'horas', '1815', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(236, 16, '1', 'cp56', 'Clases particulares,', '56', 'horas', '1848', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(237, 16, '1', 'cp57', 'Clases particulares,', '57', 'horas', '1881', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(238, 16, '1', 'cp58', 'Clases particulares,', '58', 'horas', '1914', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(239, 16, '1', 'cp59', 'Clases particulares,', '59', 'horas', '1947', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(240, 16, '1', 'cp6', 'Clases particulares,', '6', 'horas', '240', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(241, 16, '1', 'cp60', 'Clases particulares,', '60', 'horas', '1980', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(242, 16, '1', 'cp61', 'Clases particulares,', '61', 'horas', '2013', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(243, 16, '1', 'cp62', 'Clases particulares,', '62', 'horas', '2046', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(244, 16, '1', 'cp63', 'Clases particulares,', '63', 'horas', '2079', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(245, 16, '1', 'cp64', 'Clases particulares,', '64', 'horas', '2112', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(246, 16, '1', 'cp65', 'Clases particulares,', '65', 'horas', '2145', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(247, 16, '1', 'cp66', 'Clases particulares,', '66', 'horas', '2178', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(248, 16, '1', 'cp67', 'Clases particulares,', '67', 'horas', '2211', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(249, 16, '1', 'cp68', 'Clases particulares,', '68', 'horas', '2244', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(250, 16, '1', 'cp69', 'Clases particulares,', '69', 'horas', '2277', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16);
INSERT INTO `tm_tarifa` (`idTarifa`, `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`, `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`, `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`, `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`) VALUES
(251, 16, '1', 'cp7', 'Clases particulares,', '7', 'horas', '280', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(252, 16, '1', 'cp70', 'Clases particulares,', '70', 'horas', '2310', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(253, 16, '1', 'cp71', 'Clases particulares,', '71', 'horas', '2343', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(254, 16, '1', 'cp72', 'Clases particulares,', '72', 'horas', '2376', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(255, 16, '1', 'cp73', 'Clases particulares,', '73', 'horas', '2409', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(256, 16, '1', 'cp74', 'Clases particulares,', '74', 'horas', '2442', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(257, 16, '1', 'cp75', 'Clases particulares,', '75', 'horas', '2475', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(258, 16, '1', 'cp76', 'Clases particulares,', '76', 'horas', '2508', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(259, 16, '1', 'cp77', 'Clases particulares,', '77', 'horas', '2541', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(260, 16, '1', 'cp78', 'Clases particulares,', '78', 'horas', '2574', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(261, 16, '1', 'cp79', 'Clases particulares,', '79', 'horas', '2607', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(262, 16, '1', 'cp8', 'Clases particulares,', '8', 'horas', '320', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(263, 16, '1', 'cp80', 'Clases particulares,', '80', 'horas', '2640', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(264, 16, '1', 'cp81', 'Clases particulares,', '81', 'horas', '2673', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(265, 16, '1', 'cp82', 'Clases particulares,', '82', 'horas', '2706', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(266, 16, '1', 'cp83', 'Clases particulares,', '83', 'horas', '2739', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(267, 16, '1', 'cp84', 'Clases particulares,', '84', 'horas', '2772', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(268, 16, '1', 'cp85', 'Clases particulares,', '85', 'horas', '2805', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(269, 16, '1', 'cp86', 'Clases particulares,', '86', 'horas', '2838', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(270, 16, '1', 'cp87', 'Clases particulares,', '87', 'horas', '2871', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(271, 16, '1', 'cp88', 'Clases particulares,', '88', 'horas', '2904', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(272, 16, '1', 'cp89', 'Clases particulares,', '89', 'horas', '2937', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(273, 16, '1', 'cp9', 'Clases particulares,', '9', 'horas', '360', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(274, 16, '1', 'cp90', 'Clases particulares,', '90', 'horas', '2970', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(275, 16, '1', 'cp91', 'Clases particulares,', '91', 'horas', '3003', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(276, 16, '1', 'cp92', 'Clases particulares,', '92', 'horas', '3036', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(277, 16, '1', 'cp93', 'Clases particulares,', '93', 'horas', '3069', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(278, 16, '1', 'cp94', 'Clases particulares,', '94', 'horas', '3102', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(279, 16, '1', 'cp95', 'Clases particulares,', '95', 'horas', '3135', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(280, 16, '1', 'cp96', 'Clases particulares,', '96', 'horas', '3168', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(281, 16, '1', 'cp97', 'Clases particulares,', '97', 'horas', '3201', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(282, 16, '1', 'cp98', 'Clases particulares,', '98', 'horas', '3234', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(283, 16, '1', 'cp99', 'Clases particulares,', '99', 'horas', '3267', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(284, 16, '1', 'cpb10', 'Clases particulares,', '10', 'horas', '350', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(285, 16, '1', 'cpb5', 'Clases particulares,', '5', 'horas', '200', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases particulares,', '2025-09-23 13:48:52', 1, 16),
(286, 16, '1', 'sk0', 'Clases skype,', '', '', '0', '705000000000', '700000000011', '700000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(287, 16, '1', 'sk1', 'Clases skype,', '1', 'hora', '50', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(288, 16, '1', 'sk11', 'Clases skype,', '11', 'horas', '357.5', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(289, 16, '1', 'sk12', 'Clases skype,', '12', 'horas', '390', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(290, 16, '1', 'sk13', 'Clases skype,', '13', 'horas', '422.5', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(291, 16, '1', 'sk14', 'Clases skype,', '14', 'horas', '455', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(292, 16, '1', 'sk15', 'Clases skype,', '15', 'horas', '487.5', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(293, 16, '1', 'sk16', 'Clases skype,', '16', 'horas', '520', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(294, 16, '1', 'sk17', 'Clases skype,', '17', 'horas', '552.5', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(295, 16, '1', 'sk18', 'Clases skype,', '18', 'horas', '585', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(296, 16, '1', 'sk19', 'Clases skype,', '19', 'horas', '617.5', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(297, 16, '1', 'sk2', 'Clases skype,', '2', 'horas', '90', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(298, 16, '1', 'sk21', 'Clases skype,', '21', 'horas', '630', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(299, 16, '1', 'sk22', 'Clases skype,', '22', 'horas', '660', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(300, 16, '1', 'sk23', 'Clases skype,', '23', 'horas', '690', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(301, 16, '1', 'sk24', 'Clases skype,', '24', 'horas', '720', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(302, 16, '1', 'sk25', 'Clases skype,', '25', 'horas', '750', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(303, 16, '1', 'sk26', 'Clases skype,', '26', 'horas', '780', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(304, 16, '1', 'sk27', 'Clases skype,', '27', 'horas', '810', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(305, 16, '1', 'sk28', 'Clases skype,', '28', 'horas', '840', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(306, 16, '1', 'sk29', 'Clases skype,', '29', 'horas', '870', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(307, 16, '1', 'sk3', 'Clases skype,', '3', 'horas', '120', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(308, 16, '1', 'sk30', 'Clases skype,', '30', 'horas', '900', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(309, 16, '1', 'sk31', 'Clases skype,', '31', 'horas', '930', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(310, 16, '1', 'sk32', 'Clases skype,', '32', 'horas', '960', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(311, 16, '1', 'sk33', 'Clases skype,', '33', 'horas', '990', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(312, 16, '1', 'sk34', 'Clases skype,', '34', 'horas', '1020', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(313, 16, '1', 'sk35', 'Clases skype,', '35', 'horas', '1050', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(314, 16, '1', 'sk36', 'Clases skype,', '36', 'horas', '1080', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(315, 16, '1', 'sk37', 'Clases skype,', '37', 'horas', '1110', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(316, 16, '1', 'sk38', 'Clases skype,', '38', 'horas', '1140', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(317, 16, '1', 'sk39', 'Clases skype,', '39', 'horas', '1170', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(318, 16, '1', 'sk4', 'Clases skype,', '4', 'horas', '150', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(319, 16, '1', 'sk40', 'Clases skype,', '40', 'horas', '1200', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(320, 16, '1', 'sk41', 'Clases skype,', '41', 'horas', '1230', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(321, 16, '1', 'sk42', 'Clases skype,', '42', 'horas', '1260', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(322, 16, '1', 'sk43', 'Clases skype,', '43', 'horas', '1290', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(323, 16, '1', 'sk44', 'Clases skype,', '44', 'horas', '1320', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(324, 16, '1', 'sk45', 'Clases skype,', '45', 'horas', '1350', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(325, 16, '1', 'sk46', 'Clases skype,', '46', 'horas', '1380', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(326, 16, '1', 'sk47', 'Clases skype,', '47', 'horas', '1410', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(327, 16, '1', 'sk48', 'Clases skype,', '48', 'horas', '1440', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(328, 16, '1', 'sk49', 'Clases skype,', '49', 'horas', '1470', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(329, 16, '1', 'sk50', 'Clases skype,', '50', 'horas', '1500', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(330, 16, '1', 'sk6', 'Clases skype,', '6', 'horas', '210', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(331, 16, '1', 'sk7', 'Clases skype,', '7', 'horas', '245', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(332, 16, '1', 'sk8', 'Clases skype,', '8', 'horas', '280', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(333, 16, '1', 'sk9', 'Clases skype,', '9', 'horas', '315', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype,', '2025-09-23 13:48:52', 1, 16),
(334, 16, '1', 'sk10', 'Clases skype, bono 10 horas', '10', 'horas', '325', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype, bono 10 horas', '2025-09-23 13:48:52', 1, 16),
(335, 16, '1', 'sk20', 'Clases skype, bono 10 horas', '20', 'horas', '600', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype, bono 10 horas', '2025-09-23 13:48:52', 1, 16),
(336, 16, '1', 'sk5', 'Clases skype, bono 5 horas', '5', 'horas', '175', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype, bono 5 horas', '2025-09-23 13:48:52', 1, 16),
(337, 16, '1', 'skb', 'Clases skype, bono bienvenida', '5', 'horas', '150', '705000000000', '700000000011', '705000000500', 'Docencia', '0', 'Clases skype, bono bienvenida', '2025-09-23 13:48:52', 1, 16),
(338, 16, '1', 'abitur1', 'Curso abitur,', '1', 'semana', '490', '705000000000', '700000000005', '700000000701', 'Docencia', '0', 'Curso abitur,', '2025-09-23 13:48:52', 1, 16),
(339, 16, '1', 'abitur2', 'Curso abitur,', '2', 'semanas', '920', '705000000000', '700000000005', '700000000701', 'Docencia', '0', 'Curso abitur,', '2025-09-23 13:48:52', 1, 16),
(340, 16, '1', 'abitur3', 'Curso abitur,', '3', 'semanas', '1370', '705000000000', '700000000005', '700000000701', 'Docencia', '0', 'Curso abitur,', '2025-09-23 13:48:52', 1, 16),
(341, 16, '1', 'abitur4', 'Curso abitur,', '4', 'semanas', '1820', '705000000000', '705000000002', '700000000701', 'Docencia', '0', 'Curso abitur,', '2025-09-23 13:48:52', 1, 16),
(342, 16, '1', 'uned-g', 'Curso acceso UNED,', '', '', '4200', '705000000520', '705000000011', '555000000007', 'Docencia', '0', 'Curso acceso UNED,', '2025-09-23 13:48:52', 1, 16),
(343, 16, '1', 'uned-m', 'Curso acceso UNED,', '', '', '120', '705600000000', '705600000000', '555000000007', 'Docencia', '0', 'Curso acceso UNED,', '2025-09-23 13:48:52', 1, 16),
(344, 16, '1', 'cul1', 'Curso cultura,', '1', 'semana', '105', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(345, 16, '1', 'cul10', 'Curso cultura,', '10', 'semanas', '1050', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(346, 16, '1', 'cul11', 'Curso cultura,', '11', 'semanas', '1155', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(347, 16, '1', 'cul12', 'Curso cultura,', '12', 'semanas', '1260', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(348, 16, '1', 'cul13', 'Curso cultura,', '13', 'semanas', '1365', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(349, 16, '1', 'cul14', 'Curso cultura,', '14', 'semanas', '1470', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(350, 16, '1', 'cul2', 'Curso cultura,', '2', 'semanas', '210', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(351, 16, '1', 'cul3', 'Curso cultura,', '3', 'semanas', '315', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(352, 16, '1', 'cul4', 'Curso cultura,', '4', 'semanas', '420', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(353, 16, '1', 'cul5', 'Curso cultura,', '5', 'semanas', '525', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(354, 16, '1', 'cul6', 'Curso cultura,', '6', 'semanas', '630', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(355, 16, '1', 'cul7', 'Curso cultura,', '7', 'semanas', '735', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(356, 16, '1', 'cul8', 'Curso cultura,', '8', 'semanas', '840', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(357, 16, '1', 'cul9', 'Curso cultura,', '9', 'semanas', '945', '705000000000', '705000000020', '700000000610', 'Docencia', '0', 'Curso cultura,', '2025-09-23 13:48:52', 1, 16),
(358, 16, '1', 'c0', '', '', '', '0', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(359, 16, '1', 'c1', '', '1', 'semana', '105', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(360, 16, '1', 'c10', '', '10', 'semanas', '1050', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(361, 16, '1', 'c11', '', '11', 'semanas', '1155', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(362, 16, '1', 'c12', '', '12', 'semanas', '1260', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(363, 16, '1', 'c13', '', '13', 'semanas', '1365', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(364, 16, '1', 'c14', '', '14', 'semanas', '1470', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(365, 16, '1', 'c15', '', '15', 'semanas', '1575', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(366, 16, '1', 'c16', '', '16', 'semanas', '1680', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(367, 16, '1', 'c2', '', '2', 'semanas', '210', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(368, 16, '1', 'c3', '', '3', 'semanas', '315', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(369, 16, '1', 'c4', '', '4', 'semanas', '420', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(370, 16, '1', 'c5', '', '5', 'semanas', '525', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(371, 16, '1', 'c6', '', '6', 'semanas', '630', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(372, 16, '1', 'c7', '', '7', 'semanas', '735', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(373, 16, '1', 'c8', '', '8', 'semanas', '840', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(374, 16, '1', 'c9', '', '9', 'semanas', '945', '705000000000', '705000000002', '700000000400', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(375, 16, '1', 'pron1', '', '1', 'semana', '105', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(376, 16, '1', 'pron2', '', '2', 'semanas', '210', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(377, 16, '1', 'pron3', '', '3', 'semanas', '315', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(378, 16, '1', 'pron4', '', '4', 'semanas', '420', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(379, 16, '1', 'pron5', '', '5', 'semanas', '525', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(380, 16, '1', 'pron6', '', '6', 'semanas', '630', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(381, 16, '1', 'pron7', '', '7', 'semanas', '735', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(382, 16, '1', 'pron8', '', '8', 'semanas', '840', '705000000000', '700000000005', '700000001300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(383, 16, '1', 'n0', '', '', 'oferta especial', '0', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(384, 16, '1', 'n1', '', '1', 'semana', '105', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(385, 16, '1', 'n2', '', '2', 'semanas', '210', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(386, 16, '1', 'n3', '', '3', 'semanas', '315', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(387, 16, '1', 'n4', '', '4', 'semanas', '420', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(388, 16, '1', 'n5', '', '5', 'semanas', '525', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(389, 16, '1', 'n6', '', '6', 'semanas', '630', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(390, 16, '1', 'n7', '', '7', 'semanas', '735', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(391, 16, '1', 'n8', '', '8', 'semanas', '840', '705000000000', '700000000005', '700000000300', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(392, 16, '1', 'msi', 'Curso extensivo 10h,', '', '', '15', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(393, 16, '1', 'si0', 'Curso extensivo 10h,', '', 'oferta especial', '0', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(394, 16, '1', 'si1', 'Curso extensivo 10h,', '1', 'semanas', '125', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(395, 16, '1', 'si10', 'Curso extensivo 10h,', '10', 'semanas', '800', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(396, 16, '1', 'si11', 'Curso extensivo 10h,', '11', 'semanas', '880', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(397, 16, '1', 'si12', 'Curso extensivo 10h,', '12', 'semanas', '900', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(398, 16, '1', 'si13', 'Curso extensivo 10h,', '13', 'semanas', '975', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(399, 16, '1', 'si14', 'Curso extensivo 10h,', '14', 'semanas', '1050', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(400, 16, '1', 'si15', 'Curso extensivo 10h,', '15', 'semanas', '1125', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(401, 16, '1', 'si16', 'Curso extensivo 10h,', '16', 'semanas', '1160', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(402, 16, '1', 'si17', 'Curso extensivo 10h,', '17', 'semanas', '1230', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(403, 16, '1', 'si18', 'Curso extensivo 10h,', '18', 'semanas', '1300', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(404, 16, '1', 'si19', 'Curso extensivo 10h,', '19', 'semanas', '1370', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(405, 16, '1', 'si2', 'Curso extensivo 10h,', '2', 'semanas', '225', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(406, 16, '1', 'si20', 'Curso extensivo 10h,', '20', 'semanas', '1400', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(407, 16, '1', 'si21', 'Curso extensivo 10h,', '21', 'semanas', '1460', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(408, 16, '1', 'si22', 'Curso extensivo 10h,', '22', 'semanas', '1520', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(409, 16, '1', 'si23', 'Curso extensivo 10h,', '23', 'semanas', '1580', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(410, 16, '1', 'si24', 'Curso extensivo 10h,', '24', 'semanas', '1590', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(411, 16, '1', 'si25', 'Curso extensivo 10h,', '25', 'semanas', '1640', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(412, 16, '1', 'si26', 'Curso extensivo 10h,', '26', 'semanas', '1690', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(413, 16, '1', 'si27', 'Curso extensivo 10h,', '27', 'semanas', '1740', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(414, 16, '1', 'si28', 'Curso extensivo 10h,', '28', 'semanas', '1790', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(415, 16, '1', 'si29', 'Curso extensivo 10h,', '29', 'semanas', '1840', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(416, 16, '1', 'si3', 'Curso extensivo 10h,', '3', 'semanas', '300', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(417, 16, '1', 'si30', 'Curso extensivo 10h,', '30', 'semanas', '1890', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(418, 16, '1', 'si31', 'Curso extensivo 10h,', '31', 'semanas', '1940', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(419, 16, '1', 'si32', 'Curso extensivo 10h,', '32', 'semanas', '1990', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(420, 16, '1', 'si33', 'Curso extensivo 10h,', '33', 'semanas', '2040', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(421, 16, '1', 'si34', 'Curso extensivo 10h,', '34', 'semanas', '2090', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(422, 16, '1', 'si35', 'Curso extensivo 10h,', '35', 'semanas', '2140', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(423, 16, '1', 'si36', 'Curso extensivo 10h,', '36', 'semanas', '2190', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(424, 16, '1', 'si37', 'Curso extensivo 10h,', '37', 'semanas', '2240', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(425, 16, '1', 'si38', 'Curso extensivo 10h,', '38', 'semanas', '2290', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(426, 16, '1', 'si39', 'Curso extensivo 10h,', '39', 'semanas', '2340', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(427, 16, '1', 'si4', 'Curso extensivo 10h,', '4', 'semanas', '350', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(428, 16, '1', 'si40', 'Curso extensivo 10h,', '40', 'semanas', '2390', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(429, 16, '1', 'si41', 'Curso extensivo 10h,', '41', 'semanas', '2440', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(430, 16, '1', 'si42', 'Curso extensivo 10h,', '42', 'semanas', '2490', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(431, 16, '1', 'si43', 'Curso extensivo 10h,', '43', 'semanas', '2540', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(432, 16, '1', 'si44', 'Curso extensivo 10h,', '44', 'semanas', '2590', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(433, 16, '1', 'si45', 'Curso extensivo 10h,', '45', 'semanas', '2640', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(434, 16, '1', 'si46', 'Curso extensivo 10h,', '46', 'semanas', '2690', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(435, 16, '1', 'si47', 'Curso extensivo 10h,', '47', 'semanas', '2740', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(436, 16, '1', 'si48', 'Curso extensivo 10h,', '48', 'semanas', '2790', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(437, 16, '1', 'si49', 'Curso extensivo 10h,', '49', 'semanas', '2840', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(438, 16, '1', 'si5', 'Curso extensivo 10h,', '5', 'semanas', '437.5', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(439, 16, '1', 'si50', 'Curso extensivo 10h,', '50', 'semanas', '2890', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(440, 16, '1', 'si51', 'Curso extensivo 10h,', '51', 'semanas', '2940', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(441, 16, '1', 'si52', 'Curso extensivo 10h,', '52', 'semanas', '2990', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(442, 16, '1', 'si53', 'Curso extensivo 10h,', '53', 'semanas', '3040', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(443, 16, '1', 'si6', 'Curso extensivo 10h,', '6', 'semanas', '525', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(444, 16, '1', 'si7', 'Curso extensivo 10h,', '7', 'semanas', '612.5', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(445, 16, '1', 'si8', 'Curso extensivo 10h,', '8', 'semanas', '640', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(446, 16, '1', 'si9', 'Curso extensivo 10h,', '9', 'semanas', '720', '705000000000', '700000000005', '700000000860', 'Docencia', '0', 'Curso extensivo 10h,', '2025-09-23 13:48:52', 1, 16),
(447, 16, '1', 'e0', 'Curso extensivo 4h,', '', 'oferta especial', '0', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(448, 16, '1', 'e1', 'Curso extensivo 4h,', '1', 'semana', '50', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(449, 16, '1', 'e10', 'Curso extensivo 4h,', '10', 'semanas', '320', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(450, 16, '1', 'e11', 'Curso extensivo 4h,', '11', 'semanas', '350', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(451, 16, '1', 'e12', 'Curso extensivo 4h,', '12', 'semanas', '360', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(452, 16, '1', 'e13', 'Curso extensivo 4h,', '13', 'semanas', '380', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(453, 16, '1', 'e14', 'Curso extensivo 4h,', '14', 'semanas', '400', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(454, 16, '1', 'e15', 'Curso extensivo 4h,', '15', 'semanas', '420', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(455, 16, '1', 'e16', 'Curso extensivo 4h,', '16', 'semanas', '440', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(456, 16, '1', 'e17', 'Curso extensivo 4h,', '17', 'semanas', '455', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(457, 16, '1', 'e18', 'Curso extensivo 4h,', '18', 'semanas', '470', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(458, 16, '1', 'e19', 'Curso extensivo 4h,', '19', 'semanas', '485', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(459, 16, '1', 'e2', 'Curso extensivo 4h,', '2', 'semanas', '90', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(460, 16, '1', 'e20', 'Curso extensivo 4h,', '20', 'semanas', '500', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(461, 16, '1', 'e21', 'Curso extensivo 4h,', '21', 'semanas', '525', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(462, 16, '1', 'e22', 'Curso extensivo 4h,', '22', 'semanas', '550', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(463, 16, '1', 'e23', 'Curso extensivo 4h,', '23', 'semanas', '575', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(464, 16, '1', 'e24', 'Curso extensivo 4h,', '24', 'semanas', '600', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(465, 16, '1', 'e25', 'Curso extensivo 4h,', '25', 'semanas', '625', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(466, 16, '1', 'e26', 'Curso extensivo 4h,', '26', 'semanas', '650', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(467, 16, '1', 'e27', 'Curso extensivo 4h,', '27', 'semanas', '675', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(468, 16, '1', 'e28', 'Curso extensivo 4h,', '28', 'semanas', '700', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(469, 16, '1', 'e29', 'Curso extensivo 4h,', '29', 'semanas', '725', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(470, 16, '1', 'e3', 'Curso extensivo 4h,', '3', 'semanas', '120', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(471, 16, '1', 'e30', 'Curso extensivo 4h,', '30', 'semanas', '750', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(472, 16, '1', 'e31', 'Curso extensivo 4h,', '31', 'semanas', '775', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(473, 16, '1', 'e32', 'Curso extensivo 4h,', '32', 'semanas', '800', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(474, 16, '1', 'e33', 'Curso extensivo 4h,', '33', 'semanas', '825', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(475, 16, '1', 'e34', 'Curso extensivo 4h,', '34', 'semanas', '850', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(476, 16, '1', 'e35', 'Curso extensivo 4h,', '35', 'semanas', '875', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(477, 16, '1', 'e36', 'Curso extensivo 4h,', '36', 'semanas', '900', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(478, 16, '1', 'e37', 'Curso extensivo 4h,', '37', 'semanas', '925', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(479, 16, '1', 'e38', 'Curso extensivo 4h,', '38', 'semanas', '950', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(480, 16, '1', 'e39', 'Curso extensivo 4h,', '39', 'semanas', '975', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(481, 16, '1', 'e4', 'Curso extensivo 4h,', '4', 'semanas', '140', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(482, 16, '1', 'e40', 'Curso extensivo 4h,', '40', 'semanas', '1000', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(483, 16, '1', 'e5', 'Curso extensivo 4h,', '5', 'semanas', '175', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(484, 16, '1', 'e6', 'Curso extensivo 4h,', '6', 'semanas', '210', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(485, 16, '1', 'e7', 'Curso extensivo 4h,', '7', 'semanas', '245', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(486, 16, '1', 'e8', 'Curso extensivo 4h,', '8', 'semanas', '260', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(487, 16, '1', 'e9', 'Curso extensivo 4h,', '9', 'semanas', '290', '705000000000', '705000000024', '700000000860', 'Docencia', '0', 'Curso extensivo 4h,', '2025-09-23 13:48:52', 1, 16),
(488, 16, '1', 'g0', '', '', 'oferta especial', '0', '705000000000', '705000000011', '700000000100', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(489, 16, '1', 'g1', '', '1', 'semana', '105', '705000000000', '705000000011', '700000000101', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(490, 16, '1', 'g2', '', '2', 'semanas', '210', '705000000000', '705000000011', '700000000102', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(491, 16, '1', 'g3', '', '3', 'semanas', '315', '705000000000', '705000000011', '700000000103', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(492, 16, '1', 'g4', '', '4', 'semanas', '420', '705000000000', '705000000011', '700000000104', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(493, 16, '1', 'g5', '', '5', 'semanas', '525', '705000000000', '705000000011', '700000000105', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(494, 16, '1', 'g6', '', '6', 'semanas', '630', '705000000000', '705000000011', '700000000106', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(495, 16, '1', 'g7', '', '7', 'semanas', '735', '705000000000', '705000000011', '700000000107', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(496, 16, '1', 'g8', '', '8', 'semanas', '840', '705000000000', '705000000011', '700000000108', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(497, 16, '1', 'icp1', 'Curso intensivo 20 + 10', '1', 'semana', '490', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(498, 16, '1', 'icp2', 'Curso intensivo 20 + 10', '2', 'semanas', '920', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(499, 16, '1', 'icp3', 'Curso intensivo 20 + 10', '3', 'semanas', '1370', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(500, 16, '1', 'icp4', 'Curso intensivo 20 + 10', '4', 'semanas', '1820', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(501, 16, '1', 'icp5', 'Curso intensivo 20 + 10', '5', 'semanas', '2135', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(502, 16, '1', 'icp6', 'Curso intensivo 20 + 10', '6', 'semanas', '2545', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(503, 16, '1', 'icp7', 'Curso intensivo 20 + 10', '7', 'semanas', '2950', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(504, 16, '1', 'icp8', 'Curso intensivo 20 + 10', '8', 'semanas', '3350', '705000000000', '705000000013', '700000000501', 'Docencia', '0', 'Curso intensivo 20 + 10', '2025-09-23 13:48:52', 1, 16),
(505, 16, '1', 'ic1', '', '1', 'semana', '285', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(506, 16, '1', 'ic2', '', '2', 'semanas', '560', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(507, 16, '1', 'ic3', '', '3', 'semanas', '830', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(508, 16, '1', 'ic4', '', '4', 'semanas', '1100', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(509, 16, '1', 'ic5', '', '5', 'semanas', '1355', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(510, 16, '1', 'ic6', '', '6', 'semanas', '1610', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(511, 16, '1', 'ic7', '', '7', 'semanas', '1855', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(512, 16, '1', 'ic8', '', '8', 'semanas', '2100', '705000000000', '705000000012', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(513, 16, '1', 'icu1', 'Curso intensivo plus / cultura,', '1', 'semana', '285', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(514, 16, '1', 'icu2', 'Curso intensivo plus / cultura,', '2', 'semanas', '560', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(515, 16, '1', 'icu3', 'Curso intensivo plus / cultura,', '3', 'semanas', '830', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(516, 16, '1', 'icu4', 'Curso intensivo plus / cultura,', '4', 'semanas', '1100', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(517, 16, '1', 'icu5', 'Curso intensivo plus / cultura,', '5', 'semanas', '1355', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(518, 16, '1', 'icu6', 'Curso intensivo plus / cultura,', '6', 'semanas', '1610', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(519, 16, '1', 'icu7', 'Curso intensivo plus / cultura,', '7', 'semanas', '1855', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(520, 16, '1', 'icu8', 'Curso intensivo plus / cultura,', '8', 'semanas', '2100', '705000000000', '705000000014', '700000000501', 'Docencia', '0', 'Curso intensivo plus / cultura,', '2025-09-23 13:48:52', 1, 16),
(521, 16, '1', 'if1', '', '1', 'semana', '285', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(522, 16, '1', 'if2', '', '2', 'semanas', '560', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(523, 16, '1', 'if3', '', '3', 'semanas', '830', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(524, 16, '1', 'if4', '', '4', 'semanas', '1100', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(525, 16, '1', 'if5', '', '5', 'semanas', '1355', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(526, 16, '1', 'if6', '', '6', 'semanas', '1610', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(527, 16, '1', 'if7', '', '7', 'semanas', '1855', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(528, 16, '1', 'if8', '', '8', 'semanas', '2100', '705000000000', '705000000015', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(529, 16, '1', 'ig1', '', '1', 'semana', '285', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(530, 16, '1', 'ig2', '', '2', 'semanas', '560', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(531, 16, '1', 'ig3', '', '3', 'semanas', '830', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16);
INSERT INTO `tm_tarifa` (`idTarifa`, `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`, `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`, `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`, `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`) VALUES
(532, 16, '1', 'ig4', '', '4', 'semanas', '1100', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(533, 16, '1', 'ig5', '', '5', 'semanas', '1355', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(534, 16, '1', 'ig6', '', '6', 'semanas', '1610', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(535, 16, '1', 'ig7', '', '7', 'semanas', '1855', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(536, 16, '1', 'ig8', '', '8', 'semanas', '2100', '705000000000', '705000000016', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(537, 16, '1', 'in1', 'Curso intensivo plus / negocios,', '1', 'semana', '285', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(538, 16, '1', 'in2', 'Curso intensivo plus / negocios,', '2', 'semanas', '560', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(539, 16, '1', 'in3', 'Curso intensivo plus / negocios,', '3', 'semanas', '830', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(540, 16, '1', 'in4', 'Curso intensivo plus / negocios,', '4', 'semanas', '1100', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(541, 16, '1', 'in5', 'Curso intensivo plus / negocios,', '5', 'semanas', '1355', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(542, 16, '1', 'in6', 'Curso intensivo plus / negocios,', '6', 'semanas', '1610', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(543, 16, '1', 'in7', 'Curso intensivo plus / negocios,', '7', 'semanas', '1855', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(544, 16, '1', 'in8', 'Curso intensivo plus / negocios,', '8', 'semanas', '2100', '705000000000', '705000000017', '700000000501', 'Docencia', '0', 'Curso intensivo plus / negocios,', '2025-09-23 13:48:52', 1, 16),
(545, 16, '1', 'ip1', '', '1', 'semana', '285', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(546, 16, '1', 'ip2', '', '2', 'semanas', '560', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(547, 16, '1', 'ip3', '', '3', 'semanas', '830', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(548, 16, '1', 'ip4', '', '4', 'semanas', '1100', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(549, 16, '1', 'ip5', '', '5', 'semanas', '1355', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(550, 16, '1', 'ip6', '', '6', 'semanas', '1610', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(551, 16, '1', 'ip7', '', '7', 'semanas', '1855', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(552, 16, '1', 'ip8', '', '8', 'semanas', '2100', '705000000000', '705000000018', '700000000501', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(553, 16, '1', 'i0', 'Curso intensivo,', '', 'oferta especial', '0', '705000000000', '705000000000', '700000000501', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(554, 16, '1', 'i1', 'Curso intensivo,', '1', 'semana', '180', '705000000000', '705000000000', '700000000001', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(555, 16, '1', 'i10', 'Curso intensivo,', '10', 'semanas', '1530', '705000000000', '705000000000', '700000000010', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(556, 16, '1', 'i11', 'Curso intensivo,', '11', 'semanas', '1660', '705000000000', '705000000000', '700000000011', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(557, 16, '1', 'i12', 'Curso intensivo,', '12', 'semanas', '1790', '705000000000', '705000000000', '700000000012', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(558, 16, '1', 'i13', 'Curso intensivo,', '13', 'semanas', '1915', '705000000000', '705000000000', '700000000013', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(559, 16, '1', 'i14', 'Curso intensivo,', '14', 'semanas', '2040', '705000000000', '705000000000', '700000000014', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(560, 16, '1', 'i15', 'Curso intensivo,', '15', 'semanas', '2160', '705000000000', '705000000000', '700000000015', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(561, 16, '1', 'i16', 'Curso intensivo,', '16', 'semanas', '2280', '705000000000', '705000000000', '700000000016', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(562, 16, '1', 'i17', 'Curso intensivo,', '17', 'semanas', '2395', '705000000000', '705000000000', '700000000017', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(563, 16, '1', 'i18', 'Curso intensivo,', '18', 'semanas', '2510', '705000000000', '705000000000', '700000000018', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(564, 16, '1', 'i19', 'Curso intensivo,', '19', 'semanas', '2625', '705000000000', '705000000000', '700000000019', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(565, 16, '1', 'i2', 'Curso intensivo,', '2', 'semanas', '350', '705000000000', '705000000000', '700000000002', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(566, 16, '1', 'i20', 'Curso intensivo,', '20', 'semanas', '2740', '705000000000', '705000000000', '700000000020', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(567, 16, '1', 'i21', 'Curso intensivo,', '21', 'semanas', '2850', '705000000000', '705000000000', '700000000021', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(568, 16, '1', 'i22', 'Curso intensivo,', '22', 'semanas', '2960', '705000000000', '705000000000', '700000000022', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(569, 16, '1', 'i23', 'Curso intensivo,', '23', 'semanas', '3070', '705000000000', '705000000000', '700000000023', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(570, 16, '1', 'i24', 'Curso intensivo,', '24', 'semanas', '3175', '705000000000', '705000000000', '700000000024', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(571, 16, '1', 'i25', 'Curso intensivo,', '25', 'semanas', '3280', '705000000000', '705000000000', '700000000025', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(572, 16, '1', 'i26', 'Curso intensivo,', '26', 'semanas', '3385', '705000000000', '705000000000', '700000000026', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(573, 16, '1', 'i27', 'Curso intensivo,', '27', 'semanas', '3485', '705000000000', '705000000000', '700000000027', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(574, 16, '1', 'i28', 'Curso intensivo,', '28', 'semanas', '3585', '705000000000', '705000000000', '700000000028', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(575, 16, '1', 'i29', 'Curso intensivo,', '29', 'semanas', '3685', '705000000000', '705000000000', '700000000029', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(576, 16, '1', 'i3', 'Curso intensivo,', '3', 'semanas', '515', '705000000000', '705000000000', '700000000003', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(577, 16, '1', 'i30', 'Curso intensivo,', '30', 'semanas', '3785', '705000000000', '705000000000', '700000000030', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(578, 16, '1', 'i31', 'Curso intensivo,', '31', 'semanas', '3885', '705000000000', '705000000000', '700000000031', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(579, 16, '1', 'i32', 'Curso intensivo,', '32', 'semanas', '3980', '705000000000', '705000000000', '700000000032', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(580, 16, '1', 'i33', 'Curso intensivo,', '33', 'semanas', '4075', '705000000000', '705000000000', '700000000033', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(581, 16, '1', 'i34', 'Curso intensivo,', '34', 'semanas', '4170', '705000000000', '705000000000', '700000000034', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(582, 16, '1', 'i35', 'Curso intensivo,', '35', 'semanas', '4265', '705000000000', '705000000000', '700000000035', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(583, 16, '1', 'i36', 'Curso intensivo,', '36', 'semanas', '4360', '705000000000', '705000000000', '700000000036', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(584, 16, '1', 'i37', 'Curso intensivo,', '37', 'semanas', '4450', '705000000000', '705000000000', '700000000037', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(585, 16, '1', 'i38', 'Curso intensivo,', '38', 'semanas', '4540', '705000000000', '705000000000', '700000000038', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(586, 16, '1', 'i39', 'Curso intensivo,', '39', 'semanas', '4630', '705000000000', '705000000000', '700000000039', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(587, 16, '1', 'i4', 'Curso intensivo,', '4', 'semanas', '680', '705000000000', '705000000000', '700000000004', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(588, 16, '1', 'i40', 'Curso intensivo,', '40', 'semanas', '4720', '705000000000', '705000000000', '700000000040', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(589, 16, '1', 'i41', 'Curso intensivo,', '41', 'semanas', '4810', '705000000000', '705000000000', '700000000041', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(590, 16, '1', 'i42', 'Curso intensivo,', '42', 'semanas', '4900', '705000000000', '705000000000', '700000000042', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(591, 16, '1', 'i43', 'Curso intensivo,', '43', 'semanas', '4990', '705000000000', '705000000000', '700000000043', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(592, 16, '1', 'i44', 'Curso intensivo,', '44', 'semanas', '5080', '705000000000', '705000000000', '700000000044', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(593, 16, '1', 'i45', 'Curso intensivo,', '45', 'semanas', '5170', '705000000000', '705000000000', '700000000045', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(594, 16, '1', 'i46', 'Curso intensivo,', '46', 'semanas', '5260', '705000000000', '705000000000', '700000000046', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(595, 16, '1', 'i47', 'Curso intensivo,', '47', 'semanas', '5350', '705000000000', '705000000000', '700000000047', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(596, 16, '1', 'i48', 'Curso intensivo,', '48', 'semanas', '5440', '705000000000', '705000000000', '700000000048', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(597, 16, '1', 'i49', 'Curso intensivo,', '49', 'semanas', '5530', '705000000000', '705000000000', '700000000049', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(598, 16, '1', 'i5', 'Curso intensivo,', '5', 'semanas', '830', '705000000000', '705000000000', '700000000005', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(599, 16, '1', 'i50', 'Curso intensivo,', '50', 'semanas', '5620', '705000000000', '705000000000', '700000000050', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(600, 16, '1', 'i51', 'Curso intensivo,', '51', 'semanas', '5710', '705000000000', '705000000000', '700000000051', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(601, 16, '1', 'i52', 'Curso intensivo,', '52', 'semanas', '5800', '705000000000', '705000000000', '700000000052', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(602, 16, '1', 'i6', 'Curso intensivo,', '6', 'semanas', '980', '705000000000', '705000000000', '700000000006', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(603, 16, '1', 'i7', 'Curso intensivo,', '7', 'semanas', '1120', '705000000000', '705000000000', '700000000007', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(604, 16, '1', 'i8', 'Curso intensivo,', '8', 'semanas', '1260', '705000000000', '705000000000', '700000000008', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(605, 16, '1', 'i9', 'Curso intensivo,', '9', 'semanas', '1400', '705000000000', '705000000000', '700000000009', 'Docencia', '0', 'Curso intensivo,', '2025-09-23 13:48:52', 1, 16),
(606, 16, '1', 'kids1', 'Curso kids,', '1', 'semana', '195', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(607, 16, '1', 'kids10', 'Curso kids,', '10', 'semanas', '1950', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(608, 16, '1', 'kids11', 'Curso kids,', '11', 'semanas', '2145', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(609, 16, '1', 'kids12', 'Curso kids,', '12', 'semanas', '2340', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(610, 16, '1', 'kids13', 'Curso kids,', '13', 'semanas', '2535', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(611, 16, '1', 'kids14', 'Curso kids,', '14', 'semanas', '2730', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(612, 16, '1', 'kids2', 'Curso kids,', '2', 'semanas', '390', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(613, 16, '1', 'kids3', 'Curso kids,', '3', 'semanas', '585', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(614, 16, '1', 'kids4', 'Curso kids,', '4', 'semanas', '780', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(615, 16, '1', 'kids5', 'Curso kids,', '5', 'semanas', '975', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(616, 16, '1', 'kids6', 'Curso kids,', '6', 'semanas', '1170', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(617, 16, '1', 'kids7', 'Curso kids,', '7', 'semanas', '1365', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(618, 16, '1', 'kids8', 'Curso kids,', '8', 'semanas', '1560', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(619, 16, '1', 'kids9', 'Curso kids,', '9', 'semanas', '1755', '705000000000', '705000000020', '705000000014', 'Docencia', '0', 'Curso kids,', '2025-09-23 13:48:52', 1, 16),
(620, 16, '1', 'a2', '', '', 'oferta especial', '150', '705000000000', '700000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(621, 16, '1', 'dele', '', '3', 'semanas', '495', '705000000000', '705000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(622, 16, '1', 'dele0', '', '', 'oferta especial', '0', '705000000000', '705000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(623, 16, '1', 'dele1', '', '1', 'semana', '220', '705000000000', '705000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(624, 16, '1', 'dele2', '', '2', 'semanas', '341', '705000000000', '705000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(625, 16, '1', 'dele3', '', '3', 'semanas', '495', '705000000000', '705000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(626, 16, '1', 'dele4', '', '4', 'semanas', '682', '705000000000', '705000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(627, 16, '1', 'dele5', '', '5', 'semanas', '869', '705000000000', '705000000005', '700000000600', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(628, 16, '1', 'exa1', '', '1', 'semana', '470', '705000000000', '705000000030', '705000000016', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(629, 16, '1', 'exa2', '', '2', 'semanas', '875', '705000000000', '705000000030', '705000000016', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(630, 16, '1', 'exa2', '', '4', 'semanas', '1730', '705000000000', '705000000030', '705000000016', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(631, 16, '1', 'exa3', '', '3', 'semanas', '1300', '705000000000', '705000000030', '705000000016', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(632, 16, '1', 's0', 'Curso superintensivo,', '', 'oferta especial', '0', '705000000000', '700000000005', '700000000100', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(633, 16, '1', 's1', 'Curso superintensivo,', '1', 'semana', '105', '705000000000', '700000000005', '700000000101', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(634, 16, '1', 's2', 'Curso superintensivo,', '2', 'semanas', '210', '705000000000', '700000000005', '700000000102', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(635, 16, '1', 's3', 'Curso superintensivo,', '3', 'semanas', '315', '705000000000', '700000000005', '700000000103', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(636, 16, '1', 's4', 'Curso superintensivo,', '4', 'semanas', '420', '705000000000', '700000000005', '700000000104', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(637, 16, '1', 's5', 'Curso superintensivo,', '5', 'semanas', '525', '705000000000', '700000000005', '700000000105', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(638, 16, '1', 's6', 'Curso superintensivo,', '6', 'semanas', '630', '705000000000', '700000000005', '700000000106', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(639, 16, '1', 's7', 'Curso superintensivo,', '7', 'semanas', '735', '705000000000', '700000000005', '700000000107', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(640, 16, '1', 's8', 'Curso superintensivo,', '8', 'semanas', '840', '705000000000', '700000000005', '700000000108', 'Docencia', '0', 'Curso superintensivo,', '2025-09-23 13:48:52', 1, 16),
(641, 16, '1', 'teen1', 'Curso teen,', '1', 'semana', '195', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(642, 16, '1', 'teen10', 'Curso teen,', '10', 'semanas', '1950', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(643, 16, '1', 'teen11', 'Curso teen,', '11', 'semanas', '2145', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(644, 16, '1', 'teen12', 'Curso teen,', '12', 'semanas', '2340', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(645, 16, '1', 'teen13', 'Curso teen,', '13', 'semanas', '2535', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(646, 16, '1', 'teen14', 'Curso teen,', '14', 'semanas', '2730', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(647, 16, '1', 'teen2', 'Curso teen,', '2', 'semanas', '390', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(648, 16, '1', 'teen3', 'Curso teen,', '3', 'semanas', '585', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(649, 16, '1', 'teen4', 'Curso teen,', '4', 'semanas', '780', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(650, 16, '1', 'teen5', 'Curso teen,', '5', 'semanas', '975', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(651, 16, '1', 'teen6', 'Curso teen,', '6', 'semanas', '1170', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(652, 16, '1', 'teen7', 'Curso teen,', '7', 'semanas', '1365', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(653, 16, '1', 'teen8', 'Curso teen,', '8', 'semanas', '1560', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(654, 16, '1', 'teen9', 'Curso teen,', '9', 'semanas', '1755', '705000000000', '700000000005', '705000000015', 'Docencia', '0', 'Curso teen,', '2025-09-23 13:48:52', 1, 16),
(655, 16, '1', 'dep', '', '', '', '0', '705000000000', '700000000005', '555000000007', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(656, 16, '1', 'da', 'Descuento alojamiento:', '', '', '0', '705100000000', '705100000000', '555000000007', 'Otro', '0', 'Descuento alojamiento:', '2025-09-23 13:48:52', 1, 16),
(657, 16, '1', 'dex', 'Descuento antiguo alumno:', '', '-10 %', '0', '705000000000', '700000000005', '555000000007', 'Otro', '0', 'Descuento antiguo alumno:', '2025-09-23 13:48:52', 1, 16),
(658, 16, '1', 'd10', 'Descuento por grupo:', '', '-10 %', '0', '705000000000', '700000000005', '555000000007', 'Otro', '0', 'Descuento por grupo:', '2025-09-23 13:48:52', 1, 16),
(659, 16, '1', 'd5', 'Descuento por grupo:', '', '-5 %', '0', '705000000000', '700000000005', '555000000007', 'Otro', '0', 'Descuento por grupo:', '2025-09-23 13:48:52', 1, 16),
(660, 16, '1', 'dg', 'Descuento por grupo:', '', '-10 %', '0', '705000000000', '700000000005', '555000000007', 'Otro', '0', 'Descuento por grupo:', '2025-09-23 13:48:52', 1, 16),
(661, 16, '1', 'd', 'Descuento:', '', '', '0', '705000000000', '700000000005', '555000000007', 'Otro', '0', 'Descuento:', '2025-09-23 13:48:52', 1, 16),
(662, 16, '1', 'des', 'Descuento:', '', '', '0', '705000000000', '700000000005', '555000000007', 'Otro', '0', 'Descuento:', '2025-09-23 13:48:52', 1, 16),
(663, 16, '1', 'el', '', '', '', '0', '', '', '', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(664, 16, '1', 'elg', '', '', '', '0', '705000000055', '705000000055', '700000005555', 'Docencia', '0', '', '2025-09-23 13:48:52', 1, 16),
(665, 16, '1', 'em0', 'Extensivo Mini:', '', 'oferta especial', '0', '705000000000', '705000000000', '700000000700', 'Docencia', '0', 'Extensivo Mini:', '2025-09-23 13:48:52', 1, 16),
(666, 16, '1', 'em12', 'Extensivo Mini:', '12', 'semanas', '540', '705000000000', '705000000000', '700000000700', 'Docencia', '0', 'Extensivo Mini:', '2025-09-23 13:48:52', 1, 16),
(667, 16, '1', 'em4', 'Extensivo Mini:', '4', 'semanas', '180', '705000000000', '705000000000', '700000000700', 'Docencia', '0', 'Extensivo Mini:', '2025-09-23 13:48:52', 1, 16),
(668, 16, '1', 'em8', 'Extensivo Mini:', '8', 'semanas', '360', '705000000000', '705000000000', '700000000700', 'Docencia', '0', 'Extensivo Mini:', '2025-09-23 13:48:52', 1, 16),
(669, 16, '1', 'fp1', '', '1', 'semana', '365', '705000000000', '700000000016', '704000000000', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(670, 16, '1', 'fp2', '', '2', 'semanas', '375', '705000000000', '700000000016', '704000000000', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(671, 16, '1', 'che', 'Gastos cheque:', '', '', '0', '705600000000', '705600000000', '555000000007', 'Otro', '0', 'Gastos cheque:', '2025-09-23 13:48:52', 1, 16),
(672, 16, '1', 'can', '', '', '', '0', '705600000000', '705600000000', '555000000007', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(673, 16, '1', 'mod', '', '', '', '15', '705600000000', '705600000000', '555000000007', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(674, 16, '1', 'duib0', '', '', 'oferta especial', '0', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(675, 16, '1', 'duib1', '', '1', 'semana', '225', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(676, 16, '1', 'duib10', '', '10', 'semanas', '2250', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(677, 16, '1', 'duib11', '', '11', 'semanas', '2475', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(678, 16, '1', 'duib12', '', '12', 'semanas', '2700', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(679, 16, '1', 'duib13', '', '13', 'semanas', '2925', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(680, 16, '1', 'duib14', '', '14', 'semanas', '3150', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(681, 16, '1', 'duib15', '', '15', 'semanas', '3375', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(682, 16, '1', 'duib16', '', '16', 'semanas', '3600', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(683, 16, '1', 'duib17', '', '17', 'semanas', '3825', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(684, 16, '1', 'duib18', '', '18', 'semanas', '4050', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(685, 16, '1', 'duib19', '', '19', 'semanas', '4275', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(686, 16, '1', 'duib2', '', '2', 'semanas', '450', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(687, 16, '1', 'duib20', '', '20', 'semanas', '4500', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(688, 16, '1', 'duib21', '', '21', 'semanas', '4725', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(689, 16, '1', 'duib22', '', '22', 'semanas', '4950', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(690, 16, '1', 'duib23', '', '23', 'semanas', '5175', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(691, 16, '1', 'duib24', '', '24', 'semanas', '5400', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(692, 16, '1', 'duib25', '', '25', 'semanas', '5625', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(693, 16, '1', 'duib26', '', '26', 'semanas', '5850', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(694, 16, '1', 'duib27', '', '27', 'semanas', '6075', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(695, 16, '1', 'duib28', '', '28', 'semanas', '6300', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(696, 16, '1', 'duib29', '', '29', 'semanas', '6525', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(697, 16, '1', 'duib3', '', '3', 'semanas', '675', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(698, 16, '1', 'duib30', '', '30', 'semanas', '6750', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(699, 16, '1', 'duib31', '', '31', 'semanas', '6975', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(700, 16, '1', 'duib32', '', '32', 'semanas', '7200', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(701, 16, '1', 'duib33', '', '33', 'semanas', '7425', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(702, 16, '1', 'duib34', '', '34', 'semanas', '7650', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(703, 16, '1', 'duib35', '', '35', 'semanas', '7875', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(704, 16, '1', 'duib36', '', '36', 'semanas', '8100', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(705, 16, '1', 'duib37', '', '37', 'semanas', '8325', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(706, 16, '1', 'duib38', '', '38', 'semanas', '8550', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(707, 16, '1', 'duib39', '', '39', 'semanas', '8775', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(708, 16, '1', 'duib4', '', '4', 'semanas', '900', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(709, 16, '1', 'duib40', '', '40', 'semanas', '9000', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(710, 16, '1', 'duib41', '', '41', 'semanas', '9225', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(711, 16, '1', 'duib42', '', '42', 'semanas', '9450', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(712, 16, '1', 'duib43', '', '43', 'semanas', '9675', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(713, 16, '1', 'duib44', '', '44', 'semanas', '9900', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(714, 16, '1', 'duib45', '', '45', 'semanas', '10125', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(715, 16, '1', 'duib46', '', '46', 'semanas', '10350', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(716, 16, '1', 'duib47', '', '47', 'semanas', '10575', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(717, 16, '1', 'duib48', '', '48', 'semanas', '10800', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(718, 16, '1', 'duib49', '', '49', 'semanas', '11025', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(719, 16, '1', 'duib5', '', '5', 'semanas', '1125', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(720, 16, '1', 'duib50', '', '50', 'semanas', '11250', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(721, 16, '1', 'duib51', '', '51', 'semanas', '11475', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(722, 16, '1', 'duib52', '', '52', 'semanas', '11700', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(723, 16, '1', 'duib53', '', '53', 'semanas', '11925', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(724, 16, '1', 'duib6', '', '6', 'semanas', '1350', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(725, 16, '1', 'duib7', '', '7', 'semanas', '1575', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(726, 16, '1', 'duib8', '', '8', 'semanas', '1800', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(727, 16, '1', 'duib9', '', '9', 'semanas', '2025', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(728, 16, '1', 'duibe', '', '1', '', '50', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(729, 16, '1', 'duibe2', '', '2', '', '100', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(730, 16, '1', 'duibe3', '', '3', '', '150', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(731, 16, '1', 'duibe4', '', '4', '', '200', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(732, 16, '1', 'dui0', 'Hab. doble, uso Individual,', '', 'oferta especial', '0', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(733, 16, '1', 'dui1', 'Hab. doble, uso Individual,', '1', 'semana', '190', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(734, 16, '1', 'dui10', 'Hab. doble, uso Individual,', '10', 'semanas', '1900', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(735, 16, '1', 'dui11', 'Hab. doble, uso Individual,', '11', 'semanas', '2090', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(736, 16, '1', 'dui12', 'Hab. doble, uso Individual,', '12', 'semanas', '2280', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(737, 16, '1', 'dui13', 'Hab. doble, uso Individual,', '13', 'semanas', '2470', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(738, 16, '1', 'dui14', 'Hab. doble, uso Individual,', '14', 'semanas', '2660', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(739, 16, '1', 'dui15', 'Hab. doble, uso Individual,', '15', 'semanas', '2850', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(740, 16, '1', 'dui16', 'Hab. doble, uso Individual,', '16', 'semanas', '3040', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(741, 16, '1', 'dui17', 'Hab. doble, uso Individual,', '17', 'semanas', '3230', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(742, 16, '1', 'dui18', 'Hab. doble, uso Individual,', '18', 'semanas', '3420', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(743, 16, '1', 'dui19', 'Hab. doble, uso Individual,', '19', 'semanas', '3610', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(744, 16, '1', 'dui2', 'Hab. doble, uso Individual,', '2', 'semanas', '380', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(745, 16, '1', 'dui20', 'Hab. doble, uso Individual,', '20', 'semanas', '3800', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(746, 16, '1', 'dui21', 'Hab. doble, uso Individual,', '21', 'semanas', '3990', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(747, 16, '1', 'dui22', 'Hab. doble, uso Individual,', '22', 'semanas', '4180', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(748, 16, '1', 'dui23', 'Hab. doble, uso Individual,', '23', 'semanas', '4370', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(749, 16, '1', 'dui24', 'Hab. doble, uso Individual,', '24', 'semanas', '4560', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(750, 16, '1', 'dui25', 'Hab. doble, uso Individual,', '25', 'semanas', '4750', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(751, 16, '1', 'dui26', 'Hab. doble, uso Individual,', '26', 'semanas', '4940', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(752, 16, '1', 'dui27', 'Hab. doble, uso Individual,', '27', 'semanas', '5130', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(753, 16, '1', 'dui28', 'Hab. doble, uso Individual,', '28', 'semanas', '5320', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(754, 16, '1', 'dui29', 'Hab. doble, uso Individual,', '29', 'semanas', '5510', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(755, 16, '1', 'dui3', 'Hab. doble, uso Individual,', '3', 'semanas', '570', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(756, 16, '1', 'dui30', 'Hab. doble, uso Individual,', '30', 'semanas', '5700', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(757, 16, '1', 'dui31', 'Hab. doble, uso Individual,', '31', 'semanas', '5890', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(758, 16, '1', 'dui32', 'Hab. doble, uso Individual,', '32', 'semanas', '6080', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(759, 16, '1', 'dui33', 'Hab. doble, uso Individual,', '33', 'semanas', '6270', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(760, 16, '1', 'dui34', 'Hab. doble, uso Individual,', '34', 'semanas', '6460', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(761, 16, '1', 'dui35', 'Hab. doble, uso Individual,', '35', 'semanas', '6650', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(762, 16, '1', 'dui36', 'Hab. doble, uso Individual,', '36', 'semanas', '6840', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(763, 16, '1', 'dui37', 'Hab. doble, uso Individual,', '37', 'semanas', '7030', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(764, 16, '1', 'dui38', 'Hab. doble, uso Individual,', '38', 'semanas', '7220', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(765, 16, '1', 'dui39', 'Hab. doble, uso Individual,', '39', 'semanas', '7410', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(766, 16, '1', 'dui4', 'Hab. doble, uso Individual,', '4', 'semanas', '760', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(767, 16, '1', 'dui40', 'Hab. doble, uso Individual,', '40', 'semanas', '7600', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(768, 16, '1', 'dui41', 'Hab. doble, uso Individual,', '41', 'semanas', '7790', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(769, 16, '1', 'dui42', 'Hab. doble, uso Individual,', '42', 'semanas', '7980', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(770, 16, '1', 'dui43', 'Hab. doble, uso Individual,', '43', 'semanas', '8170', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(771, 16, '1', 'dui44', 'Hab. doble, uso Individual,', '44', 'semanas', '8360', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(772, 16, '1', 'dui45', 'Hab. doble, uso Individual,', '45', 'semanas', '8550', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(773, 16, '1', 'dui46', 'Hab. doble, uso Individual,', '46', 'semanas', '8740', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(774, 16, '1', 'dui47', 'Hab. doble, uso Individual,', '47', 'semanas', '8930', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(775, 16, '1', 'dui48', 'Hab. doble, uso Individual,', '48', 'semanas', '9120', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(776, 16, '1', 'dui49', 'Hab. doble, uso Individual,', '49', 'semanas', '9310', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(777, 16, '1', 'dui5', 'Hab. doble, uso Individual,', '5', 'semanas', '950', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(778, 16, '1', 'dui50', 'Hab. doble, uso Individual,', '50', 'semanas', '9500', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(779, 16, '1', 'dui51', 'Hab. doble, uso Individual,', '51', 'semanas', '9690', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(780, 16, '1', 'dui52', 'Hab. doble, uso Individual,', '52', 'semanas', '9880', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(781, 16, '1', 'dui53', 'Hab. doble, uso Individual,', '53', 'semanas', '10070', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(782, 16, '1', 'dui6', 'Hab. doble, uso Individual,', '6', 'semanas', '1140', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(783, 16, '1', 'dui7', 'Hab. doble, uso Individual,', '7', 'semanas', '1330', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(784, 16, '1', 'dui8', 'Hab. doble, uso Individual,', '8', 'semanas', '1520', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(785, 16, '1', 'dui9', 'Hab. doble, uso Individual,', '9', 'semanas', '1710', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(786, 16, '1', 'duie', 'Hab. doble, uso Individual,', '1', '', '40', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(787, 16, '1', 'duie2', 'Hab. doble, uso Individual,', '2', '', '80', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(788, 16, '1', 'duie3', 'Hab. doble, uso Individual,', '3', '', '120', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(789, 16, '1', 'duie4', 'Hab. doble, uso Individual,', '4', '', '160', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(790, 16, '1', 'duie5', 'Hab. doble, uso Individual,', '5', '', '200', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Hab. doble, uso Individual,', '2025-09-23 13:48:52', 1, 16),
(791, 16, '1', 'hd0', '', '', 'oferta especial', '0', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(792, 16, '1', 'hd1', '', '1', 'semana', '125', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(793, 16, '1', 'hd10', '', '10', 'semanas', '1170', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(794, 16, '1', 'hd11', '', '11', 'semanas', '1280', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(795, 16, '1', 'hd12', '', '12', 'semanas', '1390', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(796, 16, '1', 'hd13', '', '13', 'semanas', '1500', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(797, 16, '1', 'hd14', '', '14', 'semanas', '1610', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(798, 16, '1', 'hd15', '', '15', 'semanas', '1720', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(799, 16, '1', 'hd16', '', '16', 'semanas', '1830', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(800, 16, '1', 'hd17', '', '17', 'semanas', '1940', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(801, 16, '1', 'hd18', '', '18', 'semanas', '2050', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(802, 16, '1', 'hd19', '', '19', 'semanas', '2160', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(803, 16, '1', 'hd2', '', '2', 'semanas', '250', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(804, 16, '1', 'hd20', '', '20', 'semanas', '2270', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(805, 16, '1', 'hd21', '', '21', 'semanas', '2380', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(806, 16, '1', 'hd22', '', '22', 'semanas', '2490', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(807, 16, '1', 'hd23', '', '23', 'semanas', '2600', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(808, 16, '1', 'hd24', '', '24', 'semanas', '2710', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(809, 16, '1', 'hd25', '', '25', 'semanas', '2820', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(810, 16, '1', 'hd26', '', '26', 'semanas', '2930', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(811, 16, '1', 'hd27', '', '27', 'semanas', '3040', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(812, 16, '1', 'hd28', '', '28', 'semanas', '3150', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(813, 16, '1', 'hd29', '', '29', 'semanas', '3260', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(814, 16, '1', 'hd3', '', '3', 'semanas', '370', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(815, 16, '1', 'hd30', '', '30', 'semanas', '3370', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(816, 16, '1', 'hd31', '', '31', 'semanas', '3480', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16);
INSERT INTO `tm_tarifa` (`idTarifa`, `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`, `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`, `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`, `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`) VALUES
(817, 16, '1', 'hd32', '', '32', 'semanas', '3590', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(818, 16, '1', 'hd33', '', '33', 'semanas', '3700', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(819, 16, '1', 'hd34', '', '34', 'semanas', '3810', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(820, 16, '1', 'hd35', '', '35', 'semanas', '3920', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(821, 16, '1', 'hd36', '', '36', 'semanas', '4030', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(822, 16, '1', 'hd37', '', '37', 'semanas', '4140', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(823, 16, '1', 'hd38', '', '38', 'semanas', '4250', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(824, 16, '1', 'hd39', '', '39', 'semanas', '4360', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(825, 16, '1', 'hd4', '', '4', 'semanas', '490', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(826, 16, '1', 'hd40', '', '40', 'semanas', '4470', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(827, 16, '1', 'hd41', '', '41', 'semanas', '4580', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(828, 16, '1', 'hd42', '', '42', 'semanas', '4690', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(829, 16, '1', 'hd43', '', '43', 'semanas', '4800', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(830, 16, '1', 'hd44', '', '44', 'semanas', '4910', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(831, 16, '1', 'hd45', '', '45', 'semanas', '5020', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(832, 16, '1', 'hd46', '', '46', 'semanas', '5130', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(833, 16, '1', 'hd47', '', '47', 'semanas', '5240', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(834, 16, '1', 'hd48', '', '48', 'semanas', '5350', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(835, 16, '1', 'hd49', '', '49', 'semanas', '5460', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(836, 16, '1', 'hd5', '', '5', 'semanas', '610', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(837, 16, '1', 'hd50', '', '50', 'semanas', '5570', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(838, 16, '1', 'hd51', '', '51', 'semanas', '5680', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(839, 16, '1', 'hd52', '', '52', 'semanas', '5790', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(840, 16, '1', 'hd53', '', '53', 'semanas', '5900', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(841, 16, '1', 'hd6', '', '6', 'semanas', '730', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(842, 16, '1', 'hd7', '', '7', 'semanas', '840', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(843, 16, '1', 'hd8', '', '8', 'semanas', '950', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(844, 16, '1', 'hd9', '', '9', 'semanas', '1060', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(845, 16, '1', 'hde', '', '1', '', '25', '705100000000', '752000000002', '752000000002', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(846, 16, '1', 'hde2', '', '2', '', '50', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(847, 16, '1', 'hde3', '', '3', '', '75', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(848, 16, '1', 'hde4', '', '4', '', '100', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(849, 16, '1', 'hde5', '', '5', '', '125', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(850, 16, '1', 'hi0', '', '', 'oferta especial', '0', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(851, 16, '1', 'hi1', '', '1', 'semana', '160', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(852, 16, '1', 'hi10', '', '10', 'semanas', '1495', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(853, 16, '1', 'hi11', '', '11', 'semanas', '1640', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(854, 16, '1', 'hi12', '', '12', 'semanas', '1785', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(855, 16, '1', 'hi13', '', '13', 'semanas', '1930', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(856, 16, '1', 'hi14', '', '14', 'semanas', '2075', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(857, 16, '1', 'hi15', '', '15', 'semanas', '2220', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(858, 16, '1', 'hi16', '', '16', 'semanas', '2365', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(859, 16, '1', 'hi17', '', '17', 'semanas', '2510', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(860, 16, '1', 'hi18', '', '18', 'semanas', '2655', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(861, 16, '1', 'hi19', '', '19', 'semanas', '2800', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(862, 16, '1', 'hi2', '', '2', 'semanas', '315', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(863, 16, '1', 'hi20', '', '20', 'semanas', '2945', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(864, 16, '1', 'hi21', '', '21', 'semanas', '3090', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(865, 16, '1', 'hi22', '', '22', 'semanas', '3235', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(866, 16, '1', 'hi23', '', '23', 'semanas', '3380', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(867, 16, '1', 'hi24', '', '24', 'semanas', '3525', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(868, 16, '1', 'hi25', '', '25', 'semanas', '3670', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(869, 16, '1', 'hi26', '', '26', 'semanas', '3815', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(870, 16, '1', 'hi27', '', '27', 'semanas', '3960', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(871, 16, '1', 'hi28', '', '28', 'semanas', '4105', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(872, 16, '1', 'hi29', '', '29', 'semanas', '4250', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(873, 16, '1', 'hi3', '', '3', 'semanas', '465', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(874, 16, '1', 'hi30', '', '30', 'semanas', '4395', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(875, 16, '1', 'hi31', '', '31', 'semanas', '4540', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(876, 16, '1', 'hi32', '', '32', 'semanas', '4685', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(877, 16, '1', 'hi33', '', '33', 'semanas', '4830', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(878, 16, '1', 'hi34', '', '34', 'semanas', '4975', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(879, 16, '1', 'hi35', '', '35', 'semanas', '5120', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(880, 16, '1', 'hi36', '', '36', 'semanas', '5265', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(881, 16, '1', 'hi37', '', '37', 'semanas', '5410', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(882, 16, '1', 'hi38', '', '38', 'semanas', '5555', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(883, 16, '1', 'hi39', '', '39', 'semanas', '5700', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(884, 16, '1', 'hi4', '', '4', 'semanas', '615', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(885, 16, '1', 'hi40', '', '40', 'semanas', '5845', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(886, 16, '1', 'hi41', '', '41', 'semanas', '5990', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(887, 16, '1', 'hi42', '', '42', 'semanas', '6135', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(888, 16, '1', 'hi43', '', '43', 'semanas', '6280', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(889, 16, '1', 'hi44', '', '44', 'semanas', '6425', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(890, 16, '1', 'hi45', '', '45', 'semanas', '6570', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(891, 16, '1', 'hi46', '', '46', 'semanas', '6715', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(892, 16, '1', 'hi47', '', '47', 'semanas', '6860', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(893, 16, '1', 'hi48', '', '48', 'semanas', '7005', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(894, 16, '1', 'hi49', '', '49', 'semanas', '7150', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(895, 16, '1', 'hi5', '', '5', 'semanas', '765', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(896, 16, '1', 'hi50', '', '50', 'semanas', '7295', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(897, 16, '1', 'hi51', '', '51', 'semanas', '7440', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(898, 16, '1', 'hi52', '', '52', 'semanas', '7585', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(899, 16, '1', 'hi53', '', '53', 'semanas', '7730', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(900, 16, '1', 'hi6', '', '6', 'semanas', '915', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(901, 16, '1', 'hi7', '', '7', 'semanas', '1060', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(902, 16, '1', 'hi8', '', '8', 'semanas', '1205', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(903, 16, '1', 'hi9', '', '9', 'semanas', '1350', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(904, 16, '1', 'hie', '', '1', '', '30', '705100000000', '752000000001', '752000000001', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(905, 16, '1', 'hie2', '', '2', '', '60', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(906, 16, '1', 'hie3', '', '3', '', '90', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(907, 16, '1', 'hie4', '', '4', '', '120', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(908, 16, '1', 'hie5', '', '5', '', '150', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', '', '2025-09-23 13:48:52', 1, 16),
(909, 16, '1', 'ej', 'Libreta  de ejercicios:', '', '', '15', '705600000000', '705600000000', '710800000005', 'Otro', '0', 'Libreta  de ejercicios:', '2025-09-23 13:48:52', 1, 16),
(910, 16, '1', 'lib', 'Libro:', '', '', '25', '705600000000', '705600000000', '710800000005', 'Otro', '0', 'Libro:', '2025-09-23 13:48:52', 1, 16),
(911, 16, '1', 'me', '', '', '', '15', '705000000000', '700000000005', '700000000860', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(912, 16, '1', 'me', '', '', '', '15', '705000000000', '700000000005', '700000000860', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(913, 16, '1', 'm', '', '', '', '35', '705600000000', '705600000000', '555000000007', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(914, 16, '1', 'rdad1', 'Residencia hab. doble, AD,', '1', 'semana', '235', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(915, 16, '1', 'rdad10', 'Residencia hab. doble, AD,', '10', 'semanas', '2350', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(916, 16, '1', 'rdad11', 'Residencia hab. doble, AD,', '11', 'semanas', '2585', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(917, 16, '1', 'rdad12', 'Residencia hab. doble, AD,', '12', 'semanas', '2820', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(918, 16, '1', 'rdad13', 'Residencia hab. doble, AD,', '13', 'semanas', '3055', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(919, 16, '1', 'rdad14', 'Residencia hab. doble, AD,', '14', 'semanas', '3290', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(920, 16, '1', 'rdad15', 'Residencia hab. doble, AD,', '15', 'semanas', '3525', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(921, 16, '1', 'rdad16', 'Residencia hab. doble, AD,', '16', 'semanas', '3760', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(922, 16, '1', 'rdad17', 'Residencia hab. doble, AD,', '17', 'semanas', '3995', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(923, 16, '1', 'rdad18', 'Residencia hab. doble, AD,', '18', 'semanas', '4230', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(924, 16, '1', 'rdad19', 'Residencia hab. doble, AD,', '19', 'semanas', '4465', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(925, 16, '1', 'rdad2', 'Residencia hab. doble, AD,', '2', 'semanas', '470', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(926, 16, '1', 'rdad20', 'Residencia hab. doble, AD,', '20', 'semanas', '4700', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(927, 16, '1', 'rdad21', 'Residencia hab. doble, AD,', '21', 'semanas', '4935', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(928, 16, '1', 'rdad22', 'Residencia hab. doble, AD,', '22', 'semanas', '5170', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(929, 16, '1', 'rdad23', 'Residencia hab. doble, AD,', '23', 'semanas', '5405', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(930, 16, '1', 'rdad24', 'Residencia hab. doble, AD,', '24', 'semanas', '5640', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(931, 16, '1', 'rdad25', 'Residencia hab. doble, AD,', '25', 'semanas', '5875', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(932, 16, '1', 'rdad26', 'Residencia hab. doble, AD,', '26', 'semanas', '6110', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(933, 16, '1', 'rdad27', 'Residencia hab. doble, AD,', '27', 'semanas', '6345', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(934, 16, '1', 'rdad28', 'Residencia hab. doble, AD,', '28', 'semanas', '6580', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(935, 16, '1', 'rdad29', 'Residencia hab. doble, AD,', '29', 'semanas', '6815', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(936, 16, '1', 'rdad3', 'Residencia hab. doble, AD,', '3', 'semanas', '705', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(937, 16, '1', 'rdad30', 'Residencia hab. doble, AD,', '30', 'semanas', '7050', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(938, 16, '1', 'rdad31', 'Residencia hab. doble, AD,', '31', 'semanas', '7285', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(939, 16, '1', 'rdad32', 'Residencia hab. doble, AD,', '32', 'semanas', '7520', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(940, 16, '1', 'rdad33', 'Residencia hab. doble, AD,', '33', 'semanas', '7755', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(941, 16, '1', 'rdad34', 'Residencia hab. doble, AD,', '34', 'semanas', '7990', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(942, 16, '1', 'rdad35', 'Residencia hab. doble, AD,', '35', 'semanas', '8225', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(943, 16, '1', 'rdad36', 'Residencia hab. doble, AD,', '36', 'semanas', '8460', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(944, 16, '1', 'rdad37', 'Residencia hab. doble, AD,', '37', 'semanas', '8695', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(945, 16, '1', 'rdad38', 'Residencia hab. doble, AD,', '38', 'semanas', '8930', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(946, 16, '1', 'rdad39', 'Residencia hab. doble, AD,', '39', 'semanas', '9165', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(947, 16, '1', 'rdad4', 'Residencia hab. doble, AD,', '4', 'semanas', '940', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(948, 16, '1', 'rdad40', 'Residencia hab. doble, AD,', '40', 'semanas', '9400', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(949, 16, '1', 'rdad41', 'Residencia hab. doble, AD,', '41', 'semanas', '9635', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(950, 16, '1', 'rdad42', 'Residencia hab. doble, AD,', '42', 'semanas', '9870', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(951, 16, '1', 'rdad43', 'Residencia hab. doble, AD,', '43', 'semanas', '10105', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(952, 16, '1', 'rdad44', 'Residencia hab. doble, AD,', '44', 'semanas', '10340', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(953, 16, '1', 'rdad45', 'Residencia hab. doble, AD,', '45', 'semanas', '10575', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(954, 16, '1', 'rdad46', 'Residencia hab. doble, AD,', '46', 'semanas', '10810', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(955, 16, '1', 'rdad47', 'Residencia hab. doble, AD,', '47', 'semanas', '11045', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(956, 16, '1', 'rdad48', 'Residencia hab. doble, AD,', '48', 'semanas', '11280', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(957, 16, '1', 'rdad49', 'Residencia hab. doble, AD,', '49', 'semanas', '11515', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(958, 16, '1', 'rdad5', 'Residencia hab. doble, AD,', '5', 'semanas', '1175', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(959, 16, '1', 'rdad50', 'Residencia hab. doble, AD,', '50', 'semanas', '11750', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(960, 16, '1', 'rdad51', 'Residencia hab. doble, AD,', '51', 'semanas', '11985', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(961, 16, '1', 'rdad52', 'Residencia hab. doble, AD,', '52', 'semanas', '12220', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(962, 16, '1', 'rdad53', 'Residencia hab. doble, AD,', '53', 'semanas', '11925', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(963, 16, '1', 'rdad6', 'Residencia hab. doble, AD,', '6', 'semanas', '1410', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(964, 16, '1', 'rdad7', 'Residencia hab. doble, AD,', '7', 'semanas', '1645', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(965, 16, '1', 'rdad8', 'Residencia hab. doble, AD,', '8', 'semanas', '1880', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(966, 16, '1', 'rdad9', 'Residencia hab. doble, AD,', '9', 'semanas', '2115', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(967, 16, '1', 'rdade', 'Residencia hab. doble, AD,', '1', '', '40', '705100000000', '752320000001', '752320000001', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(968, 16, '1', 'rdade2', 'Residencia hab. doble, AD,', '2', '', '80', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(969, 16, '1', 'rdade3', 'Residencia hab. doble, AD,', '3', '', '120', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(970, 16, '1', 'rdade4', 'Residencia hab. doble, AD,', '4', '', '160', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(971, 16, '1', 'rdade5', 'Residencia hab. doble, AD,', '5', '', '200', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(972, 16, '1', 'rdade6', 'Residencia hab. doble, AD,', '6', '', '240', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, AD,', '2025-09-23 13:48:52', 1, 16),
(973, 16, '1', 'rd0', 'Residencia hab. doble, Aloj.,', '', 'oferta especial', '0', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(974, 16, '1', 'rd1', 'Residencia hab. doble, Aloj.,', '1', 'semana', '200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(975, 16, '1', 'rd10', 'Residencia hab. doble, Aloj.,', '10', 'semanas', '2000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(976, 16, '1', 'rd11', 'Residencia hab. doble, Aloj.,', '11', 'semanas', '2200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(977, 16, '1', 'rd12', 'Residencia hab. doble, Aloj.,', '12', 'semanas', '2400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(978, 16, '1', 'rd13', 'Residencia hab. doble, Aloj.,', '13', 'semanas', '2600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(979, 16, '1', 'rd14', 'Residencia hab. doble, Aloj.,', '14', 'semanas', '2800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(980, 16, '1', 'rd15', 'Residencia hab. doble, Aloj.,', '15', 'semanas', '3000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(981, 16, '1', 'rd16', 'Residencia hab. doble, Aloj.,', '16', 'semanas', '3200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(982, 16, '1', 'rd17', 'Residencia hab. doble, Aloj.,', '17', 'semanas', '3400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(983, 16, '1', 'rd18', 'Residencia hab. doble, Aloj.,', '18', 'semanas', '3600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(984, 16, '1', 'rd19', 'Residencia hab. doble, Aloj.,', '19', 'semanas', '3800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(985, 16, '1', 'rd2', 'Residencia hab. doble, Aloj.,', '2', 'semanas', '400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(986, 16, '1', 'rd20', 'Residencia hab. doble, Aloj.,', '20', 'semanas', '4000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(987, 16, '1', 'rd21', 'Residencia hab. doble, Aloj.,', '21', 'semanas', '4200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(988, 16, '1', 'rd22', 'Residencia hab. doble, Aloj.,', '22', 'semanas', '4400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(989, 16, '1', 'rd23', 'Residencia hab. doble, Aloj.,', '23', 'semanas', '4600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(990, 16, '1', 'rd24', 'Residencia hab. doble, Aloj.,', '24', 'semanas', '4800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(991, 16, '1', 'rd25', 'Residencia hab. doble, Aloj.,', '25', 'semanas', '5000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(992, 16, '1', 'rd26', 'Residencia hab. doble, Aloj.,', '26', 'semanas', '5200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(993, 16, '1', 'rd27', 'Residencia hab. doble, Aloj.,', '27', 'semanas', '5400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(994, 16, '1', 'rd28', 'Residencia hab. doble, Aloj.,', '28', 'semanas', '5600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(995, 16, '1', 'rd29', 'Residencia hab. doble, Aloj.,', '29', 'semanas', '5800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(996, 16, '1', 'rd3', 'Residencia hab. doble, Aloj.,', '3', 'semanas', '600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(997, 16, '1', 'rd30', 'Residencia hab. doble, Aloj.,', '30', 'semanas', '6000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(998, 16, '1', 'rd31', 'Residencia hab. doble, Aloj.,', '31', 'semanas', '6200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(999, 16, '1', 'rd32', 'Residencia hab. doble, Aloj.,', '32', 'semanas', '6400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1000, 16, '1', 'rd33', 'Residencia hab. doble, Aloj.,', '33', 'semanas', '6600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1001, 16, '1', 'rd34', 'Residencia hab. doble, Aloj.,', '34', 'semanas', '6800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1002, 16, '1', 'rd35', 'Residencia hab. doble, Aloj.,', '35', 'semanas', '7000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1003, 16, '1', 'rd36', 'Residencia hab. doble, Aloj.,', '36', 'semanas', '7200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1004, 16, '1', 'rd37', 'Residencia hab. doble, Aloj.,', '37', 'semanas', '7400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1005, 16, '1', 'rd38', 'Residencia hab. doble, Aloj.,', '38', 'semanas', '7600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1006, 16, '1', 'rd39', 'Residencia hab. doble, Aloj.,', '39', 'semanas', '7800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1007, 16, '1', 'rd4', 'Residencia hab. doble, Aloj.,', '4', 'semanas', '800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1008, 16, '1', 'rd40', 'Residencia hab. doble, Aloj.,', '40', 'semanas', '8000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1009, 16, '1', 'rd41', 'Residencia hab. doble, Aloj.,', '41', 'semanas', '8200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1010, 16, '1', 'rd42', 'Residencia hab. doble, Aloj.,', '42', 'semanas', '8400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1011, 16, '1', 'rd43', 'Residencia hab. doble, Aloj.,', '43', 'semanas', '8600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1012, 16, '1', 'rd44', 'Residencia hab. doble, Aloj.,', '44', 'semanas', '8800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1013, 16, '1', 'rd45', 'Residencia hab. doble, Aloj.,', '45', 'semanas', '9000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1014, 16, '1', 'rd46', 'Residencia hab. doble, Aloj.,', '46', 'semanas', '9200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1015, 16, '1', 'rd47', 'Residencia hab. doble, Aloj.,', '47', 'semanas', '9400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1016, 16, '1', 'rd48', 'Residencia hab. doble, Aloj.,', '48', 'semanas', '9600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1017, 16, '1', 'rd49', 'Residencia hab. doble, Aloj.,', '49', 'semanas', '9800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1018, 16, '1', 'rd5', 'Residencia hab. doble, Aloj.,', '5', 'semanas', '1000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1019, 16, '1', 'rd50', 'Residencia hab. doble, Aloj.,', '50', 'semanas', '10000', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1020, 16, '1', 'rd51', 'Residencia hab. doble, Aloj.,', '51', 'semanas', '10200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1021, 16, '1', 'rd52', 'Residencia hab. doble, Aloj.,', '52', 'semanas', '10400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1022, 16, '1', 'rd53', 'Residencia hab. doble, Aloj.,', '53', 'semanas', '10600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1023, 16, '1', 'rd6', 'Residencia hab. doble, Aloj.,', '6', 'semanas', '1200', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1024, 16, '1', 'rd7', 'Residencia hab. doble, Aloj.,', '7', 'semanas', '1400', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1025, 16, '1', 'rd8', 'Residencia hab. doble, Aloj.,', '8', 'semanas', '1600', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1026, 16, '1', 'rd9', 'Residencia hab. doble, Aloj.,', '9', 'semanas', '1800', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1027, 16, '1', 'rde', 'Residencia hab. doble, Aloj.,', '1', '', '33.5', '705100000000', '752320000000', '752320000000', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1028, 16, '1', 'rde2', 'Residencia hab. doble, Aloj.,', '2', '', '67', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1029, 16, '1', 'rde3', 'Residencia hab. doble, Aloj.,', '3', '', '100.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1030, 16, '1', 'rde4', 'Residencia hab. doble, Aloj.,', '4', '', '134', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1031, 16, '1', 'rde5', 'Residencia hab. doble, Aloj.,', '5', '', '167.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1032, 16, '1', 'rde6', 'Residencia hab. doble, Aloj.,', '6', '', '201', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1033, 16, '1', 'rdmp1', 'Residencia hab. doble, MP,', '1', 'semana', '275', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1034, 16, '1', 'rdmp10', 'Residencia hab. doble, MP,', '10', 'semanas', '2750', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1035, 16, '1', 'rdmp11', 'Residencia hab. doble, MP,', '11', 'semanas', '3025', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1036, 16, '1', 'rdmp12', 'Residencia hab. doble, MP,', '12', 'semanas', '3300', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1037, 16, '1', 'rdmp13', 'Residencia hab. doble, MP,', '13', 'semanas', '3575', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1038, 16, '1', 'rdmp14', 'Residencia hab. doble, MP,', '14', 'semanas', '3850', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1039, 16, '1', 'rdmp15', 'Residencia hab. doble, MP,', '15', 'semanas', '4125', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1040, 16, '1', 'rdmp16', 'Residencia hab. doble, MP,', '16', 'semanas', '4400', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1041, 16, '1', 'rdmp17', 'Residencia hab. doble, MP,', '17', 'semanas', '4675', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1042, 16, '1', 'rdmp18', 'Residencia hab. doble, MP,', '18', 'semanas', '4950', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1043, 16, '1', 'rdmp19', 'Residencia hab. doble, MP,', '19', 'semanas', '5225', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1044, 16, '1', 'rdmp2', 'Residencia hab. doble, MP,', '2', 'semanas', '550', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1045, 16, '1', 'rdmp20', 'Residencia hab. doble, MP,', '20', 'semanas', '5500', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1046, 16, '1', 'rdmp21', 'Residencia hab. doble, MP,', '21', 'semanas', '5775', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1047, 16, '1', 'rdmp22', 'Residencia hab. doble, MP,', '22', 'semanas', '6050', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1048, 16, '1', 'rdmp23', 'Residencia hab. doble, MP,', '23', 'semanas', '6325', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1049, 16, '1', 'rdmp24', 'Residencia hab. doble, MP,', '24', 'semanas', '6600', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1050, 16, '1', 'rdmp25', 'Residencia hab. doble, MP,', '25', 'semanas', '6875', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1051, 16, '1', 'rdmp26', 'Residencia hab. doble, MP,', '26', 'semanas', '7150', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1052, 16, '1', 'rdmp27', 'Residencia hab. doble, MP,', '27', 'semanas', '7425', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1053, 16, '1', 'rdmp28', 'Residencia hab. doble, MP,', '28', 'semanas', '7700', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1054, 16, '1', 'rdmp29', 'Residencia hab. doble, MP,', '29', 'semanas', '7975', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1055, 16, '1', 'rdmp3', 'Residencia hab. doble, MP,', '3', 'semanas', '825', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1056, 16, '1', 'rdmp30', 'Residencia hab. doble, MP,', '30', 'semanas', '8250', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1057, 16, '1', 'rdmp31', 'Residencia hab. doble, MP,', '31', 'semanas', '8525', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1058, 16, '1', 'rdmp32', 'Residencia hab. doble, MP,', '32', 'semanas', '8800', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1059, 16, '1', 'rdmp33', 'Residencia hab. doble, MP,', '33', 'semanas', '9075', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1060, 16, '1', 'rdmp34', 'Residencia hab. doble, MP,', '34', 'semanas', '9350', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1061, 16, '1', 'rdmp35', 'Residencia hab. doble, MP,', '35', 'semanas', '9625', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1062, 16, '1', 'rdmp36', 'Residencia hab. doble, MP,', '36', 'semanas', '9900', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1063, 16, '1', 'rdmp37', 'Residencia hab. doble, MP,', '37', 'semanas', '10175', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1064, 16, '1', 'rdmp38', 'Residencia hab. doble, MP,', '38', 'semanas', '10450', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1065, 16, '1', 'rdmp39', 'Residencia hab. doble, MP,', '39', 'semanas', '10725', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1066, 16, '1', 'rdmp4', 'Residencia hab. doble, MP,', '4', 'semanas', '1100', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1067, 16, '1', 'rdmp40', 'Residencia hab. doble, MP,', '40', 'semanas', '11000', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1068, 16, '1', 'rdmp41', 'Residencia hab. doble, MP,', '41', 'semanas', '11275', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1069, 16, '1', 'rdmp42', 'Residencia hab. doble, MP,', '42', 'semanas', '11550', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1070, 16, '1', 'rdmp43', 'Residencia hab. doble, MP,', '43', 'semanas', '11825', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1071, 16, '1', 'rdmp44', 'Residencia hab. doble, MP,', '44', 'semanas', '12100', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1072, 16, '1', 'rdmp45', 'Residencia hab. doble, MP,', '45', 'semanas', '12375', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1073, 16, '1', 'rdmp46', 'Residencia hab. doble, MP,', '46', 'semanas', '12650', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1074, 16, '1', 'rdmp47', 'Residencia hab. doble, MP,', '47', 'semanas', '12925', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1075, 16, '1', 'rdmp48', 'Residencia hab. doble, MP,', '48', 'semanas', '13200', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1076, 16, '1', 'rdmp49', 'Residencia hab. doble, MP,', '49', 'semanas', '13475', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1077, 16, '1', 'rdmp5', 'Residencia hab. doble, MP,', '5', 'semanas', '1375', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1078, 16, '1', 'rdmp50', 'Residencia hab. doble, MP,', '50', 'semanas', '13750', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1079, 16, '1', 'rdmp51', 'Residencia hab. doble, MP,', '51', 'semanas', '14025', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1080, 16, '1', 'rdmp52', 'Residencia hab. doble, MP,', '52', 'semanas', '14300', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1081, 16, '1', 'rdmp53', 'Residencia hab. doble, MP,', '53', 'semanas', '14575', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16);
INSERT INTO `tm_tarifa` (`idTarifa`, `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`, `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`, `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`, `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`) VALUES
(1082, 16, '1', 'rdmp6', 'Residencia hab. doble, MP,', '6', 'semanas', '1650', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1083, 16, '1', 'rdmp7', 'Residencia hab. doble, MP,', '7', 'semanas', '1925', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1084, 16, '1', 'rdmp8', 'Residencia hab. doble, MP,', '8', 'semanas', '2200', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1085, 16, '1', 'rdmp9', 'Residencia hab. doble, MP,', '9', 'semanas', '2475', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1086, 16, '1', 'rdmpe', 'Residencia hab. doble, MP,', '1', '', '46.5', '705100000000', '752320000002', '752320000002', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1087, 16, '1', 'rdmpe2', 'Residencia hab. doble, MP,', '2', '', '93', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1088, 16, '1', 'rdmpe3', 'Residencia hab. doble, MP,', '3', '', '139.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1089, 16, '1', 'rdmpe4', 'Residencia hab. doble, MP,', '4', '', '186', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1090, 16, '1', 'rdmpe5', 'Residencia hab. doble, MP,', '5', '', '232.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1091, 16, '1', 'rdmpe6', 'Residencia hab. doble, MP,', '6', '', '279', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, MP,', '2025-09-23 13:48:52', 1, 16),
(1092, 16, '1', 'rdpc1', 'Residencia hab. doble, PC,', '1', 'semana', '315', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1093, 16, '1', 'rdpc10', 'Residencia hab. doble, PC,', '10', 'semanas', '3150', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1094, 16, '1', 'rdpc11', 'Residencia hab. doble, PC,', '11', 'semanas', '3465', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1095, 16, '1', 'rdpc12', 'Residencia hab. doble, PC,', '12', 'semanas', '3780', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1096, 16, '1', 'rdpc13', 'Residencia hab. doble, PC,', '13', 'semanas', '4095', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1097, 16, '1', 'rdpc14', 'Residencia hab. doble, PC,', '14', 'semanas', '4410', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1098, 16, '1', 'rdpc15', 'Residencia hab. doble, PC,', '15', 'semanas', '4725', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1099, 16, '1', 'rdpc16', 'Residencia hab. doble, PC,', '16', 'semanas', '5040', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1100, 16, '1', 'rdpc17', 'Residencia hab. doble, PC,', '17', 'semanas', '5355', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1101, 16, '1', 'rdpc18', 'Residencia hab. doble, PC,', '18', 'semanas', '5670', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1102, 16, '1', 'rdpc19', 'Residencia hab. doble, PC,', '19', 'semanas', '5985', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1103, 16, '1', 'rdpc2', 'Residencia hab. doble, PC,', '2', 'semanas', '630', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1104, 16, '1', 'rdpc20', 'Residencia hab. doble, PC,', '20', 'semanas', '6300', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1105, 16, '1', 'rdpc21', 'Residencia hab. doble, PC,', '21', 'semanas', '6615', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1106, 16, '1', 'rdpc22', 'Residencia hab. doble, PC,', '22', 'semanas', '6930', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1107, 16, '1', 'rdpc23', 'Residencia hab. doble, PC,', '23', 'semanas', '7245', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1108, 16, '1', 'rdpc24', 'Residencia hab. doble, PC,', '24', 'semanas', '7560', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1109, 16, '1', 'rdpc25', 'Residencia hab. doble, PC,', '25', 'semanas', '7875', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1110, 16, '1', 'rdpc26', 'Residencia hab. doble, PC,', '26', 'semanas', '8190', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1111, 16, '1', 'rdpc27', 'Residencia hab. doble, PC,', '27', 'semanas', '8505', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1112, 16, '1', 'rdpc28', 'Residencia hab. doble, PC,', '28', 'semanas', '8820', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1113, 16, '1', 'rdpc29', 'Residencia hab. doble, PC,', '29', 'semanas', '9135', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1114, 16, '1', 'rdpc3', 'Residencia hab. doble, PC,', '3', 'semanas', '945', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1115, 16, '1', 'rdpc30', 'Residencia hab. doble, PC,', '30', 'semanas', '9450', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1116, 16, '1', 'rdpc31', 'Residencia hab. doble, PC,', '31', 'semanas', '9765', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1117, 16, '1', 'rdpc32', 'Residencia hab. doble, PC,', '32', 'semanas', '10080', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1118, 16, '1', 'rdpc33', 'Residencia hab. doble, PC,', '33', 'semanas', '10395', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1119, 16, '1', 'rdpc34', 'Residencia hab. doble, PC,', '34', 'semanas', '10710', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1120, 16, '1', 'rdpc35', 'Residencia hab. doble, PC,', '35', 'semanas', '11025', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1121, 16, '1', 'rdpc36', 'Residencia hab. doble, PC,', '36', 'semanas', '11340', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1122, 16, '1', 'rdpc37', 'Residencia hab. doble, PC,', '37', 'semanas', '11655', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1123, 16, '1', 'rdpc38', 'Residencia hab. doble, PC,', '38', 'semanas', '11970', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1124, 16, '1', 'rdpc39', 'Residencia hab. doble, PC,', '39', 'semanas', '12285', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1125, 16, '1', 'rdpc4', 'Residencia hab. doble, PC,', '4', 'semanas', '1260', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1126, 16, '1', 'rdpc40', 'Residencia hab. doble, PC,', '40', 'semanas', '12600', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1127, 16, '1', 'rdpc41', 'Residencia hab. doble, PC,', '41', 'semanas', '12915', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1128, 16, '1', 'rdpc42', 'Residencia hab. doble, PC,', '42', 'semanas', '13230', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1129, 16, '1', 'rdpc43', 'Residencia hab. doble, PC,', '43', 'semanas', '13545', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1130, 16, '1', 'rdpc44', 'Residencia hab. doble, PC,', '44', 'semanas', '13860', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1131, 16, '1', 'rdpc45', 'Residencia hab. doble, PC,', '45', 'semanas', '14175', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1132, 16, '1', 'rdpc46', 'Residencia hab. doble, PC,', '46', 'semanas', '14490', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1133, 16, '1', 'rdpc47', 'Residencia hab. doble, PC,', '47', 'semanas', '14805', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1134, 16, '1', 'rdpc48', 'Residencia hab. doble, PC,', '48', 'semanas', '15120', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1135, 16, '1', 'rdpc49', 'Residencia hab. doble, PC,', '49', 'semanas', '15435', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1136, 16, '1', 'rdpc5', 'Residencia hab. doble, PC,', '5', 'semanas', '1575', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1137, 16, '1', 'rdpc50', 'Residencia hab. doble, PC,', '50', 'semanas', '15750', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1138, 16, '1', 'rdpc51', 'Residencia hab. doble, PC,', '51', 'semanas', '16065', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1139, 16, '1', 'rdpc52', 'Residencia hab. doble, PC,', '52', 'semanas', '16380', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1140, 16, '1', 'rdpc53', 'Residencia hab. doble, PC,', '53', 'semanas', '16695', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1141, 16, '1', 'rdpc6', 'Residencia hab. doble, PC,', '6', 'semanas', '1890', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1142, 16, '1', 'rdpc7', 'Residencia hab. doble, PC,', '7', 'semanas', '2205', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1143, 16, '1', 'rdpc8', 'Residencia hab. doble, PC,', '8', 'semanas', '2520', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1144, 16, '1', 'rdpc9', 'Residencia hab. doble, PC,', '9', 'semanas', '2835', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1145, 16, '1', 'rdpce', 'Residencia hab. doble, PC,', '1', '', '53', '705100000000', '752320000003', '752320000003', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1146, 16, '1', 'rdpce2', 'Residencia hab. doble, PC,', '2', '', '106', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1147, 16, '1', 'rdpce3', 'Residencia hab. doble, PC,', '3', '', '159', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1148, 16, '1', 'rdpce4', 'Residencia hab. doble, PC,', '4', '', '212', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1149, 16, '1', 'rdpce5', 'Residencia hab. doble, PC,', '5', '', '265', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1150, 16, '1', 'rdpce6', 'Residencia hab. doble, PC,', '6', '', '318', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. doble, PC,', '2025-09-23 13:48:52', 1, 16),
(1151, 16, '1', 'riad1', 'Residencia hab. individual, AD,', '1', 'semana', '310', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1152, 16, '1', 'riad10', 'Residencia hab. individual, AD,', '10', 'semanas', '3100', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1153, 16, '1', 'riad11', 'Residencia hab. individual, AD,', '11', 'semanas', '3410', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1154, 16, '1', 'riad12', 'Residencia hab. individual, AD,', '12', 'semanas', '3720', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1155, 16, '1', 'riad13', 'Residencia hab. individual, AD,', '13', 'semanas', '4030', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1156, 16, '1', 'riad14', 'Residencia hab. individual, AD,', '14', 'semanas', '4340', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1157, 16, '1', 'riad15', 'Residencia hab. individual, AD,', '15', 'semanas', '4650', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1158, 16, '1', 'riad16', 'Residencia hab. individual, AD,', '16', 'semanas', '4960', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1159, 16, '1', 'riad17', 'Residencia hab. individual, AD,', '17', 'semanas', '5270', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1160, 16, '1', 'riad18', 'Residencia hab. individual, AD,', '18', 'semanas', '5580', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1161, 16, '1', 'riad19', 'Residencia hab. individual, AD,', '19', 'semanas', '5890', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1162, 16, '1', 'riad2', 'Residencia hab. individual, AD,', '2', 'semanas', '620', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1163, 16, '1', 'riad20', 'Residencia hab. individual, AD,', '20', 'semanas', '6200', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1164, 16, '1', 'riad21', 'Residencia hab. individual, AD,', '21', 'semanas', '6510', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1165, 16, '1', 'riad22', 'Residencia hab. individual, AD,', '22', 'semanas', '6820', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1166, 16, '1', 'riad23', 'Residencia hab. individual, AD,', '23', 'semanas', '7130', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1167, 16, '1', 'riad24', 'Residencia hab. individual, AD,', '24', 'semanas', '7440', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1168, 16, '1', 'riad25', 'Residencia hab. individual, AD,', '25', 'semanas', '7750', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1169, 16, '1', 'riad26', 'Residencia hab. individual, AD,', '26', 'semanas', '8060', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1170, 16, '1', 'riad27', 'Residencia hab. individual, AD,', '27', 'semanas', '8370', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1171, 16, '1', 'riad28', 'Residencia hab. individual, AD,', '28', 'semanas', '8680', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1172, 16, '1', 'riad29', 'Residencia hab. individual, AD,', '29', 'semanas', '8990', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1173, 16, '1', 'riad3', 'Residencia hab. individual, AD,', '3', 'semanas', '930', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1174, 16, '1', 'riad30', 'Residencia hab. individual, AD,', '30', 'semanas', '9300', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1175, 16, '1', 'riad31', 'Residencia hab. individual, AD,', '31', 'semanas', '9610', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1176, 16, '1', 'riad32', 'Residencia hab. individual, AD,', '32', 'semanas', '9920', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1177, 16, '1', 'riad33', 'Residencia hab. individual, AD,', '33', 'semanas', '10230', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1178, 16, '1', 'riad34', 'Residencia hab. individual, AD,', '34', 'semanas', '10540', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1179, 16, '1', 'riad35', 'Residencia hab. individual, AD,', '35', 'semanas', '10850', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1180, 16, '1', 'riad36', 'Residencia hab. individual, AD,', '36', 'semanas', '11160', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1181, 16, '1', 'riad37', 'Residencia hab. individual, AD,', '37', 'semanas', '11470', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1182, 16, '1', 'riad38', 'Residencia hab. individual, AD,', '38', 'semanas', '11780', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1183, 16, '1', 'riad39', 'Residencia hab. individual, AD,', '39', 'semanas', '12090', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1184, 16, '1', 'riad4', 'Residencia hab. individual, AD,', '4', 'semanas', '1240', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1185, 16, '1', 'riad40', 'Residencia hab. individual, AD,', '40', 'semanas', '12400', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1186, 16, '1', 'riad41', 'Residencia hab. individual, AD,', '41', 'semanas', '12710', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1187, 16, '1', 'riad42', 'Residencia hab. individual, AD,', '42', 'semanas', '13020', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1188, 16, '1', 'riad43', 'Residencia hab. individual, AD,', '43', 'semanas', '13330', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1189, 16, '1', 'riad44', 'Residencia hab. individual, AD,', '44', 'semanas', '13640', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1190, 16, '1', 'riad45', 'Residencia hab. individual, AD,', '45', 'semanas', '13950', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1191, 16, '1', 'riad46', 'Residencia hab. individual, AD,', '46', 'semanas', '14260', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1192, 16, '1', 'riad47', 'Residencia hab. individual, AD,', '47', 'semanas', '14570', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1193, 16, '1', 'riad48', 'Residencia hab. individual, AD,', '48', 'semanas', '14880', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1194, 16, '1', 'riad49', 'Residencia hab. individual, AD,', '49', 'semanas', '15190', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1195, 16, '1', 'riad5', 'Residencia hab. individual, AD,', '5', 'semanas', '1550', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1196, 16, '1', 'riad50', 'Residencia hab. individual, AD,', '50', 'semanas', '15500', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1197, 16, '1', 'riad51', 'Residencia hab. individual, AD,', '51', 'semanas', '15810', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1198, 16, '1', 'riad52', 'Residencia hab. individual, AD,', '52', 'semanas', '16120', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1199, 16, '1', 'riad53', 'Residencia hab. individual, AD,', '53', 'semanas', '16430', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1200, 16, '1', 'riad6', 'Residencia hab. individual, AD,', '6', 'semanas', '1860', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1201, 16, '1', 'riad7', 'Residencia hab. individual, AD,', '7', 'semanas', '2170', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1202, 16, '1', 'riad8', 'Residencia hab. individual, AD,', '8', 'semanas', '2480', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1203, 16, '1', 'riad9', 'Residencia hab. individual, AD,', '9', 'semanas', '2790', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1204, 16, '1', 'riade', 'Residencia hab. individual, AD,', '1', '', '47.5', '705100000000', '752300000001', '752300000001', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1205, 16, '1', 'riade2', 'Residencia hab. individual, AD,', '2', '', '95', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1206, 16, '1', 'riade3', 'Residencia hab. individual, AD,', '3', '', '142.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1207, 16, '1', 'riade4', 'Residencia hab. individual, AD,', '4', '', '190', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1208, 16, '1', 'riade5', 'Residencia hab. individual, AD,', '5', '', '237.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1209, 16, '1', 'riade6', 'Residencia hab. individual, AD,', '6', '', '285', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, AD,', '2025-09-23 13:48:52', 1, 16),
(1210, 16, '1', 'ri0', 'Residencia hab. individual, Aloj.,', '', 'oferta especial', '0', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1211, 16, '1', 'ri1', 'Residencia hab. individual, Aloj.,', '1', 'semana', '280', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1212, 16, '1', 'ri10', 'Residencia hab. individual, Aloj.,', '10', 'semanas', '2800', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1213, 16, '1', 'ri11', 'Residencia hab. individual, Aloj.,', '11', 'semanas', '3080', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1214, 16, '1', 'ri12', 'Residencia hab. individual, Aloj.,', '12', 'semanas', '3360', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1215, 16, '1', 'ri13', 'Residencia hab. individual, Aloj.,', '13', 'semanas', '3640', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1216, 16, '1', 'ri14', 'Residencia hab. individual, Aloj.,', '14', 'semanas', '3920', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1217, 16, '1', 'ri15', 'Residencia hab. individual, Aloj.,', '15', 'semanas', '4200', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1218, 16, '1', 'ri16', 'Residencia hab. individual, Aloj.,', '16', 'semanas', '4480', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1219, 16, '1', 'ri17', 'Residencia hab. individual, Aloj.,', '17', 'semanas', '4760', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1220, 16, '1', 'ri18', 'Residencia hab. individual, Aloj.,', '18', 'semanas', '5040', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1221, 16, '1', 'ri19', 'Residencia hab. individual, Aloj.,', '19', 'semanas', '5320', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1222, 16, '1', 'ri2', 'Residencia hab. individual, Aloj.,', '2', 'semanas', '560', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1223, 16, '1', 'ri20', 'Residencia hab. individual, Aloj.,', '20', 'semanas', '5600', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1224, 16, '1', 'ri21', 'Residencia hab. individual, Aloj.,', '21', 'semanas', '5880', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1225, 16, '1', 'ri22', 'Residencia hab. individual, Aloj.,', '22', 'semanas', '6160', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1226, 16, '1', 'ri23', 'Residencia hab. individual, Aloj.,', '23', 'semanas', '6440', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1227, 16, '1', 'ri24', 'Residencia hab. individual, Aloj.,', '24', 'semanas', '6720', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1228, 16, '1', 'ri25', 'Residencia hab. individual, Aloj.,', '25', 'semanas', '7000', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1229, 16, '1', 'ri26', 'Residencia hab. individual, Aloj.,', '26', 'semanas', '7280', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1230, 16, '1', 'ri27', 'Residencia hab. individual, Aloj.,', '27', 'semanas', '7560', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1231, 16, '1', 'ri28', 'Residencia hab. individual, Aloj.,', '28', 'semanas', '7840', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1232, 16, '1', 'ri29', 'Residencia hab. individual, Aloj.,', '29', 'semanas', '8120', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1233, 16, '1', 'ri3', 'Residencia hab. individual, Aloj.,', '3', 'semanas', '840', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1234, 16, '1', 'ri30', 'Residencia hab. individual, Aloj.,', '30', 'semanas', '8400', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1235, 16, '1', 'ri31', 'Residencia hab. individual, Aloj.,', '31', 'semanas', '8680', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1236, 16, '1', 'ri32', 'Residencia hab. individual, Aloj.,', '32', 'semanas', '8960', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1237, 16, '1', 'ri33', 'Residencia hab. individual, Aloj.,', '33', 'semanas', '9240', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1238, 16, '1', 'ri34', 'Residencia hab. individual, Aloj.,', '34', 'semanas', '9520', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1239, 16, '1', 'ri35', 'Residencia hab. individual, Aloj.,', '35', 'semanas', '9800', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1240, 16, '1', 'ri36', 'Residencia hab. individual, Aloj.,', '36', 'semanas', '10080', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1241, 16, '1', 'ri37', 'Residencia hab. individual, Aloj.,', '37', 'semanas', '10360', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1242, 16, '1', 'ri38', 'Residencia hab. individual, Aloj.,', '38', 'semanas', '10640', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1243, 16, '1', 'ri39', 'Residencia hab. individual, Aloj.,', '39', 'semanas', '10920', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1244, 16, '1', 'ri4', 'Residencia hab. individual, Aloj.,', '4', 'semanas', '1120', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1245, 16, '1', 'ri40', 'Residencia hab. individual, Aloj.,', '40', 'semanas', '11200', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1246, 16, '1', 'ri41', 'Residencia hab. individual, Aloj.,', '41', 'semanas', '11480', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1247, 16, '1', 'ri42', 'Residencia hab. individual, Aloj.,', '42', 'semanas', '11760', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1248, 16, '1', 'ri43', 'Residencia hab. individual, Aloj.,', '43', 'semanas', '12040', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1249, 16, '1', 'ri44', 'Residencia hab. individual, Aloj.,', '44', 'semanas', '12320', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1250, 16, '1', 'ri45', 'Residencia hab. individual, Aloj.,', '45', 'semanas', '12600', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1251, 16, '1', 'ri46', 'Residencia hab. individual, Aloj.,', '46', 'semanas', '12880', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1252, 16, '1', 'ri47', 'Residencia hab. individual, Aloj.,', '47', 'semanas', '13160', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1253, 16, '1', 'ri48', 'Residencia hab. individual, Aloj.,', '48', 'semanas', '13440', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1254, 16, '1', 'ri49', 'Residencia hab. individual, Aloj.,', '49', 'semanas', '13720', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1255, 16, '1', 'ri5', 'Residencia hab. individual, Aloj.,', '5', 'semanas', '1400', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1256, 16, '1', 'ri50', 'Residencia hab. individual, Aloj.,', '50', 'semanas', '14000', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1257, 16, '1', 'ri51', 'Residencia hab. individual, Aloj.,', '51', 'semanas', '14280', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1258, 16, '1', 'ri52', 'Residencia hab. individual, Aloj.,', '52', 'semanas', '14560', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1259, 16, '1', 'ri53', 'Residencia hab. individual, Aloj.,', '53', 'semanas', '14840', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1260, 16, '1', 'ri6', 'Residencia hab. individual, Aloj.,', '6', 'semanas', '1680', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1261, 16, '1', 'ri7', 'Residencia hab. individual, Aloj.,', '7', 'semanas', '1960', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1262, 16, '1', 'ri8', 'Residencia hab. individual, Aloj.,', '8', 'semanas', '2240', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1263, 16, '1', 'ri9', 'Residencia hab. individual, Aloj.,', '9', 'semanas', '2520', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1264, 16, '1', 'rie', 'Residencia hab. individual, Aloj.,', '1', '', '41', '705100000000', '752300000000', '752300000000', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1265, 16, '1', 'rie2', 'Residencia hab. individual, Aloj.,', '2', '', '82', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1266, 16, '1', 'rie3', 'Residencia hab. individual, Aloj.,', '3', '', '123', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1267, 16, '1', 'rie4', 'Residencia hab. individual, Aloj.,', '4', '', '164', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1268, 16, '1', 'rie5', 'Residencia hab. individual, Aloj.,', '5', '', '205', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1269, 16, '1', 'rie6', 'Residencia hab. individual, Aloj.,', '6', '', '246', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, Aloj.,', '2025-09-23 13:48:52', 1, 16),
(1270, 16, '1', 'rimp1', 'Residencia hab. individual, MP,', '1', 'semana', '340', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1271, 16, '1', 'rimp10', 'Residencia hab. individual, MP,', '10', 'semanas', '3400', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1272, 16, '1', 'rimp11', 'Residencia hab. individual, MP,', '11', 'semanas', '3740', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1273, 16, '1', 'rimp12', 'Residencia hab. individual, MP,', '12', 'semanas', '4080', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1274, 16, '1', 'rimp13', 'Residencia hab. individual, MP,', '13', 'semanas', '4420', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1275, 16, '1', 'rimp14', 'Residencia hab. individual, MP,', '14', 'semanas', '4760', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1276, 16, '1', 'rimp15', 'Residencia hab. individual, MP,', '15', 'semanas', '5100', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1277, 16, '1', 'rimp16', 'Residencia hab. individual, MP,', '16', 'semanas', '5440', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1278, 16, '1', 'rimp17', 'Residencia hab. individual, MP,', '17', 'semanas', '5780', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1279, 16, '1', 'rimp18', 'Residencia hab. individual, MP,', '18', 'semanas', '6120', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1280, 16, '1', 'rimp19', 'Residencia hab. individual, MP,', '19', 'semanas', '6460', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1281, 16, '1', 'rimp2', 'Residencia hab. individual, MP,', '2', 'semanas', '680', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1282, 16, '1', 'rimp20', 'Residencia hab. individual, MP,', '20', 'semanas', '6800', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1283, 16, '1', 'rimp21', 'Residencia hab. individual, MP,', '21', 'semanas', '7140', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1284, 16, '1', 'rimp22', 'Residencia hab. individual, MP,', '22', 'semanas', '7480', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1285, 16, '1', 'rimp23', 'Residencia hab. individual, MP,', '23', 'semanas', '7820', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1286, 16, '1', 'rimp24', 'Residencia hab. individual, MP,', '24', 'semanas', '8160', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1287, 16, '1', 'rimp25', 'Residencia hab. individual, MP,', '25', 'semanas', '8500', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1288, 16, '1', 'rimp26', 'Residencia hab. individual, MP,', '26', 'semanas', '8840', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1289, 16, '1', 'rimp27', 'Residencia hab. individual, MP,', '27', 'semanas', '9180', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1290, 16, '1', 'rimp28', 'Residencia hab. individual, MP,', '28', 'semanas', '9520', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1291, 16, '1', 'rimp29', 'Residencia hab. individual, MP,', '29', 'semanas', '9860', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1292, 16, '1', 'rimp3', 'Residencia hab. individual, MP,', '3', 'semanas', '1020', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1293, 16, '1', 'rimp30', 'Residencia hab. individual, MP,', '30', 'semanas', '10200', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1294, 16, '1', 'rimp31', 'Residencia hab. individual, MP,', '31', 'semanas', '10540', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1295, 16, '1', 'rimp32', 'Residencia hab. individual, MP,', '32', 'semanas', '10880', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1296, 16, '1', 'rimp33', 'Residencia hab. individual, MP,', '33', 'semanas', '11220', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1297, 16, '1', 'rimp34', 'Residencia hab. individual, MP,', '34', 'semanas', '11560', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1298, 16, '1', 'rimp35', 'Residencia hab. individual, MP,', '35', 'semanas', '11900', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1299, 16, '1', 'rimp36', 'Residencia hab. individual, MP,', '36', 'semanas', '12240', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1300, 16, '1', 'rimp37', 'Residencia hab. individual, MP,', '37', 'semanas', '12580', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1301, 16, '1', 'rimp38', 'Residencia hab. individual, MP,', '38', 'semanas', '12920', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1302, 16, '1', 'rimp39', 'Residencia hab. individual, MP,', '39', 'semanas', '13260', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1303, 16, '1', 'rimp4', 'Residencia hab. individual, MP,', '4', 'semanas', '1360', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1304, 16, '1', 'rimp40', 'Residencia hab. individual, MP,', '40', 'semanas', '13600', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1305, 16, '1', 'rimp41', 'Residencia hab. individual, MP,', '41', 'semanas', '13940', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1306, 16, '1', 'rimp42', 'Residencia hab. individual, MP,', '42', 'semanas', '14280', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1307, 16, '1', 'rimp43', 'Residencia hab. individual, MP,', '43', 'semanas', '14620', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1308, 16, '1', 'rimp44', 'Residencia hab. individual, MP,', '44', 'semanas', '14960', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1309, 16, '1', 'rimp45', 'Residencia hab. individual, MP,', '45', 'semanas', '15300', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1310, 16, '1', 'rimp46', 'Residencia hab. individual, MP,', '46', 'semanas', '15640', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1311, 16, '1', 'rimp47', 'Residencia hab. individual, MP,', '47', 'semanas', '15980', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16);
INSERT INTO `tm_tarifa` (`idTarifa`, `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`, `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`, `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`, `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`) VALUES
(1312, 16, '1', 'rimp48', 'Residencia hab. individual, MP,', '48', 'semanas', '16320', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1313, 16, '1', 'rimp49', 'Residencia hab. individual, MP,', '49', 'semanas', '16660', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1314, 16, '1', 'rimp5', 'Residencia hab. individual, MP,', '5', 'semanas', '1700', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1315, 16, '1', 'rimp50', 'Residencia hab. individual, MP,', '50', 'semanas', '17000', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1316, 16, '1', 'rimp51', 'Residencia hab. individual, MP,', '51', 'semanas', '17340', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1317, 16, '1', 'rimp52', 'Residencia hab. individual, MP,', '52', 'semanas', '17680', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1318, 16, '1', 'rimp53', 'Residencia hab. individual, MP,', '53', 'semanas', '18020', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1319, 16, '1', 'rimp6', 'Residencia hab. individual, MP,', '6', 'semanas', '2040', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1320, 16, '1', 'rimp7', 'Residencia hab. individual, MP,', '7', 'semanas', '2380', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1321, 16, '1', 'rimp8', 'Residencia hab. individual, MP,', '8', 'semanas', '2720', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1322, 16, '1', 'rimp9', 'Residencia hab. individual, MP,', '9', 'semanas', '3060', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1323, 16, '1', 'rimpe', 'Residencia hab. individual, MP,', '1', '', '54', '705100000000', '752300000002', '752300000002', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1324, 16, '1', 'rimpe2', 'Residencia hab. individual, MP,', '2', '', '108', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1325, 16, '1', 'rimpe3', 'Residencia hab. individual, MP,', '3', '', '162', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1326, 16, '1', 'rimpe4', 'Residencia hab. individual, MP,', '4', '', '216', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1327, 16, '1', 'rimpe5', 'Residencia hab. individual, MP,', '5', '', '270', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1328, 16, '1', 'rimpe6', 'Residencia hab. individual, MP,', '6', '', '324', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, MP,', '2025-09-23 13:48:52', 1, 16),
(1329, 16, '1', 'ripc1', 'Residencia hab. individual, PC,', '1', 'semana', '375', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1330, 16, '1', 'ripc10', 'Residencia hab. individual, PC,', '10', 'semanas', '3750', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1331, 16, '1', 'ripc11', 'Residencia hab. individual, PC,', '11', 'semanas', '4125', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1332, 16, '1', 'ripc12', 'Residencia hab. individual, PC,', '12', 'semanas', '4500', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1333, 16, '1', 'ripc13', 'Residencia hab. individual, PC,', '13', 'semanas', '4875', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1334, 16, '1', 'ripc14', 'Residencia hab. individual, PC,', '14', 'semanas', '5250', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1335, 16, '1', 'ripc15', 'Residencia hab. individual, PC,', '15', 'semanas', '5625', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1336, 16, '1', 'ripc16', 'Residencia hab. individual, PC,', '16', 'semanas', '6000', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1337, 16, '1', 'ripc17', 'Residencia hab. individual, PC,', '17', 'semanas', '6375', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1338, 16, '1', 'ripc18', 'Residencia hab. individual, PC,', '18', 'semanas', '6750', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1339, 16, '1', 'ripc19', 'Residencia hab. individual, PC,', '19', 'semanas', '7125', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1340, 16, '1', 'ripc2', 'Residencia hab. individual, PC,', '2', 'semanas', '750', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1341, 16, '1', 'ripc20', 'Residencia hab. individual, PC,', '20', 'semanas', '7500', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1342, 16, '1', 'ripc21', 'Residencia hab. individual, PC,', '21', 'semanas', '7875', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1343, 16, '1', 'ripc22', 'Residencia hab. individual, PC,', '22', 'semanas', '8250', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1344, 16, '1', 'ripc23', 'Residencia hab. individual, PC,', '23', 'semanas', '8625', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1345, 16, '1', 'ripc24', 'Residencia hab. individual, PC,', '24', 'semanas', '9000', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1346, 16, '1', 'ripc25', 'Residencia hab. individual, PC,', '25', 'semanas', '9375', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1347, 16, '1', 'ripc26', 'Residencia hab. individual, PC,', '26', 'semanas', '9750', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1348, 16, '1', 'ripc27', 'Residencia hab. individual, PC,', '27', 'semanas', '10125', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1349, 16, '1', 'ripc28', 'Residencia hab. individual, PC,', '28', 'semanas', '10500', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1350, 16, '1', 'ripc29', 'Residencia hab. individual, PC,', '29', 'semanas', '10875', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1351, 16, '1', 'ripc3', 'Residencia hab. individual, PC,', '3', 'semanas', '1125', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1352, 16, '1', 'ripc30', 'Residencia hab. individual, PC,', '30', 'semanas', '11250', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1353, 16, '1', 'ripc31', 'Residencia hab. individual, PC,', '31', 'semanas', '11625', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1354, 16, '1', 'ripc32', 'Residencia hab. individual, PC,', '32', 'semanas', '12000', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1355, 16, '1', 'ripc33', 'Residencia hab. individual, PC,', '33', 'semanas', '12375', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1356, 16, '1', 'ripc34', 'Residencia hab. individual, PC,', '34', 'semanas', '12750', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1357, 16, '1', 'ripc35', 'Residencia hab. individual, PC,', '35', 'semanas', '13125', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1358, 16, '1', 'ripc36', 'Residencia hab. individual, PC,', '36', 'semanas', '13500', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1359, 16, '1', 'ripc37', 'Residencia hab. individual, PC,', '37', 'semanas', '13875', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1360, 16, '1', 'ripc38', 'Residencia hab. individual, PC,', '38', 'semanas', '14250', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1361, 16, '1', 'ripc39', 'Residencia hab. individual, PC,', '39', 'semanas', '14625', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1362, 16, '1', 'ripc4', 'Residencia hab. individual, PC,', '4', 'semanas', '1500', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1363, 16, '1', 'ripc40', 'Residencia hab. individual, PC,', '40', 'semanas', '15000', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1364, 16, '1', 'ripc41', 'Residencia hab. individual, PC,', '41', 'semanas', '15375', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1365, 16, '1', 'ripc42', 'Residencia hab. individual, PC,', '42', 'semanas', '15750', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1366, 16, '1', 'ripc43', 'Residencia hab. individual, PC,', '43', 'semanas', '16125', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1367, 16, '1', 'ripc44', 'Residencia hab. individual, PC,', '44', 'semanas', '16500', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1368, 16, '1', 'ripc45', 'Residencia hab. individual, PC,', '45', 'semanas', '16875', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1369, 16, '1', 'ripc46', 'Residencia hab. individual, PC,', '46', 'semanas', '17250', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1370, 16, '1', 'ripc47', 'Residencia hab. individual, PC,', '47', 'semanas', '17625', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1371, 16, '1', 'ripc48', 'Residencia hab. individual, PC,', '48', 'semanas', '18000', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1372, 16, '1', 'ripc49', 'Residencia hab. individual, PC,', '49', 'semanas', '18375', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1373, 16, '1', 'ripc5', 'Residencia hab. individual, PC,', '5', 'semanas', '1875', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1374, 16, '1', 'ripc50', 'Residencia hab. individual, PC,', '50', 'semanas', '18750', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1375, 16, '1', 'ripc51', 'Residencia hab. individual, PC,', '51', 'semanas', '19125', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1376, 16, '1', 'ripc52', 'Residencia hab. individual, PC,', '52', 'semanas', '19500', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1377, 16, '1', 'ripc53', 'Residencia hab. individual, PC,', '53', 'semanas', '19875', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1378, 16, '1', 'ripc6', 'Residencia hab. individual, PC,', '6', 'semanas', '2250', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1379, 16, '1', 'ripc7', 'Residencia hab. individual, PC,', '7', 'semanas', '2625', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1380, 16, '1', 'ripc8', 'Residencia hab. individual, PC,', '8', 'semanas', '3000', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1381, 16, '1', 'ripc9', 'Residencia hab. individual, PC,', '9', 'semanas', '3375', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1382, 16, '1', 'ripce', 'Residencia hab. individual, PC,', '1', '', '60.5', '705100000000', '752300000003', '752300000003', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1383, 16, '1', 'ripce2', 'Residencia hab. individual, PC,', '2', '', '121', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1384, 16, '1', 'ripce3', 'Residencia hab. individual, PC,', '3', '', '181.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1385, 16, '1', 'ripce4', 'Residencia hab. individual, PC,', '4', '', '242', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1386, 16, '1', 'ripce5', 'Residencia hab. individual, PC,', '5', '', '302.5', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1387, 16, '1', 'ripce6', 'Residencia hab. individual, PC,', '6', '', '363', '705100000000', '752000000004', '752000000004', 'Alojamiento', '0', 'Residencia hab. individual, PC,', '2025-09-23 13:48:52', 1, 16),
(1388, 16, '1', 'deles', 'Simulacro examen DELE:', '', '', '110', '705600000000', '705600000000', '700000000600', 'Otro', '0', 'Simulacro examen DELE:', '2025-09-23 13:48:52', 1, 16),
(1389, 16, '1', 'f', 'Suplemento Fallas:', '', '', '0', '705600000000', '705600000000', '555000000007', 'Otro', '10', 'Suplemento Fallas:', '2025-09-23 13:48:52', 1, 16),
(1390, 16, '1', 'ne', 'Suplemento no estudiante:', '', '', '0', '705600000000', '705600000000', '752000000006', 'Otro', '30', 'Suplemento no estudiante:', '2025-09-23 13:48:52', 1, 16),
(1391, 16, '1', 'v', 'Suplemento temporada verano:', '', '', '0', '705600000000', '705600000000', '555000000007', 'Otro', '10', 'Suplemento temporada verano:', '2025-09-23 13:48:52', 1, 16),
(1392, 16, '1', 'sup', 'Suplemento:', '', '', '0', '705600000000', '705600000000', '555000000007', 'Otro', '10', 'Suplemento:', '2025-09-23 13:48:52', 1, 16),
(1393, 16, '1', 'Siele', 'Tasa examen', '', '', '155', '705000000012', '705600000000', '', 'Otro', '0', 'Tasa examen', '2025-09-23 13:48:52', 1, 16),
(1394, 16, '1', 'te', 'Tasas examen:', '', '', '90', '705000000012', '705600000000', '555000000007', 'Otro', '0', 'Tasas examen:', '2025-09-23 13:48:52', 1, 16),
(1395, 16, '1', 'ta1', 'Transporte aeropuerto,', '1', 'viaje', '50', '705200000000', '705200000000', '710400000001', 'Otro', '0', 'Transporte aeropuerto,', '2025-09-23 13:48:52', 1, 16),
(1396, 16, '1', 'ta2', 'Transporte aeropuerto,', '1', 'viaje', '30', '705200000000', '705200000000', '710400000001', 'Otro', '0', 'Transporte aeropuerto,', '2025-09-23 13:48:52', 1, 16),
(1397, 16, '1', 'tb1', '', '1', 'viaje', '30', '705200000000', '705200000000', '710400000002', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16),
(1398, 16, '1', 'tb2', '', '1', 'viaje', '20', '705200000000', '705200000000', '710400000002', 'Otro', '0', '', '2025-09-23 13:48:52', 1, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_tipocontrato`
--

CREATE TABLE `tm_tipocontrato` (
  `idTipoContrato` int NOT NULL,
  `descrTipoContrato` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTipoContrato` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `fecAltaTipoContrato` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecBajaTipoContrato` datetime DEFAULT NULL,
  `fecModiTipoContrato` datetime DEFAULT NULL,
  `estTipoContrato` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci COMMENT='Es el maestro de tipos de contrato';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_tipocurso`
--

CREATE TABLE `tm_tipocurso` (
  `idTipo` int NOT NULL,
  `descrTipo` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `codTipo` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `textTipo` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `minAlumTipo` int DEFAULT '0',
  `maxAlumTipo` int DEFAULT '0',
  `fecAltaTipoCurso` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de alta del tipo de curso',
  `fecModiTipoCurso` datetime DEFAULT NULL COMMENT 'fecha de modificación de tipo de curso',
  `fecBajaTipoCurso` datetime DEFAULT NULL COMMENT 'fecha de baja de tipo de curso',
  `estTipoCurso` int DEFAULT NULL COMMENT 'Estado tipo curso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_tipocurso`
--

INSERT INTO `tm_tipocurso` (`idTipo`, `descrTipo`, `codTipo`, `textTipo`, `minAlumTipo`, `maxAlumTipo`, `fecAltaTipoCurso`, `fecModiTipoCurso`, `fecBajaTipoCurso`, `estTipoCurso`) VALUES
(1, 'Intensivo', 'IN', 'Es una ejemplo de curso intensivo', 0, 0, '2025-08-22 09:24:39', NULL, NULL, 1),
(2, 'GRAMATICA', 'GRA', 'Es un curso de gramática', 0, 0, '2025-08-22 09:25:08', NULL, NULL, 1),
(3, 'CONVERSACION', 'CON', 'Es de conversación - DESACTIVADO', 0, 0, '2025-08-22 09:25:40', '2025-10-20 12:23:35', NULL, 1),
(4, 'Clase particular', 'CP', '', 0, 0, '2025-10-13 14:03:31', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_tipoidentificativo_edu`
--

CREATE TABLE `tm_tipoidentificativo_edu` (
  `idTipoIdentificativo` int NOT NULL,
  `nombreIdentificativo` varchar(225) NOT NULL COMMENT 'Hace referencia al tipo de Documento. Pasaporte, tarjeta estudiante, dni, tarjerta residencia',
  `estTipoIdentificativo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_tipoidentificativo_edu`
--

INSERT INTO `tm_tipoidentificativo_edu` (`idTipoIdentificativo`, `nombreIdentificativo`, `estTipoIdentificativo`) VALUES
(1, 'DNI', 1),
(3, 'PASAPORTE', 1),
(6, 'Carnet conducir', 1),
(7, 'Carnet manipu. Desc.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_tiposaloja`
--

CREATE TABLE `tm_tiposaloja` (
  `idTiposAloja` int NOT NULL,
  `descrTiposAloja` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTiposAloja` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `fecAltaTiposAloja` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecBajaTiposAloja` datetime DEFAULT NULL,
  `fecModiTiposAloja` datetime DEFAULT NULL,
  `estTiposAloja` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tm_tiposaloja`
--

INSERT INTO `tm_tiposaloja` (`idTiposAloja`, `descrTiposAloja`, `textTiposAloja`, `fecAltaTiposAloja`, `fecBajaTiposAloja`, `fecModiTiposAloja`, `estTiposAloja`) VALUES
(1, 'Piso compartido', '<p>Apartamento Compartido con estudiantes de la escuela<br></p>', '2023-09-26 11:53:51', NULL, '2025-09-24 18:00:46', 1),
(2, 'Familia española', '', '2023-09-26 11:59:22', NULL, NULL, 1),
(3, 'Residencia de estudiantes', '<p><br></p>', '2023-09-26 11:59:36', NULL, NULL, 1),
(4, 'Albergue', '<p><br></p>', '2023-09-26 11:59:46', NULL, NULL, 1),
(5, 'Hotel', '<p><br></p>', '2023-09-26 11:59:53', NULL, NULL, 1),
(6, 'Residencia', '', '2024-02-20 17:13:18', '2024-02-20 17:13:25', '2024-02-20 17:13:25', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_titulares_contenido`
--

CREATE TABLE `tm_titulares_contenido` (
  `idTitContenido` int NOT NULL,
  `descrTitContenido` varchar(255) DEFAULT NULL,
  `obsTitContenido` mediumtext,
  `fecAltaTitContenido` date DEFAULT NULL,
  `fecBajaTitContenido` date DEFAULT NULL,
  `fecModiTitContenido` date DEFAULT NULL,
  `estTitContenido` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_titulares_objetivos`
--

CREATE TABLE `tm_titulares_objetivos` (
  `idTitObjetivo` int NOT NULL,
  `descrTitObjetivo` varchar(255) DEFAULT NULL,
  `obsTitObjetivo` mediumtext,
  `fecAltaTitObjetivo` date DEFAULT NULL,
  `fecBajaTitObjetivo` date DEFAULT NULL,
  `fecModiTitObjetivo` date DEFAULT NULL,
  `estTitObjetivo` tinyint(1) DEFAULT '1',
  `idiomaSelect` int DEFAULT NULL,
  `tipoSelect` int DEFAULT NULL,
  `nivelSelect` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_usuario`
--

CREATE TABLE `tm_usuario` (
  `idUsu` int NOT NULL,
  `nickUsu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'NickName - Nombre Rapido para login',
  `correoUsu` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Correo del Usuario, se puede usar en login',
  `senaUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Contraseña Usuario',
  `rolUsu` int DEFAULT NULL COMMENT '0 = Usuario | 1 = Administradores | 3 = Alumnos Otros..\r\n10 = Soporte Tickets 11 = Clientes Tickets',
  `estUsu` tinyint DEFAULT NULL COMMENT 'Estado del Usuario\r\n0 = Desactivado\r\n1 = Activado',
  `obsUsu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci,
  `avatarUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Avatar foto de perfil',
  `generoUsu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Genero',
  `fecAltaUsu` datetime DEFAULT NULL COMMENT 'Fecha de Alta',
  `fecBajaUsu` datetime DEFAULT NULL COMMENT 'Fecha de Baja',
  `fecModiUsu` datetime DEFAULT NULL COMMENT 'Fecha Modificación',
  `motivoBajaUsu` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'Motivo de Baja / Ban',
  `nombreUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Nombre del usuario',
  `apellidosUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Apellidos del usuario',
  `fechaNacimientoUsu` date DEFAULT NULL COMMENT 'Fecha de nacimiento del usuario',
  `telefonoUsu` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Número de teléfono del usuario',
  `movilUsu` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Número de celular del usuario',
  `razonSocialFacturacionUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Razón social para facturación',
  `identificacionFiscalUsu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Número de identificación fiscal',
  `direccionFacturacionUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Dirección de facturación',
  `codigoPostalUsu` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `provinciaUsu` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `ciudadPuebloUsu` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `paisUsu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'PAIS',
  `personalizacionUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Campo pra meter preferencias personalizacion',
  `idiomaUsu` int DEFAULT NULL COMMENT 'Preferencia de idioma',
  `recibirNotificacionesUsu` tinyint(1) DEFAULT NULL COMMENT 'Consentimiento para recibir notificaciones',
  `registroInicioSesionUsu` date DEFAULT NULL COMMENT 'Último registro de inicio de sesión',
  `accesoPrivadoUsu` int DEFAULT NULL COMMENT '0/1, acceso privado al CRM. Para activar cuando el periodo de pago este activo',
  `ipUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'IP Ultima conexion',
  `tokenUsu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci COMMENT 'Token Usuario',
  `registroUsu` int DEFAULT NULL COMMENT '0/1 Acceso a una area privada',
  `uuidUsu` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Numero de usuario en la API en caso de tener o ID secundaria',
  `idSoporte_tmUsuario` int DEFAULT NULL COMMENT 'De la tabla Soporte-Ticket',
  `idTransportista_transportistas-Transporte` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'De la tabla Id Trabajadores del modulo de Transporte transportistas-Transporte',
  `idAlumno_tmusuario` int DEFAULT NULL COMMENT 'Vieene de tm_alumno_edu, relaciona el login con su usuario ',
  `idInscripcion_tmusuario` int DEFAULT NULL COMMENT 'id de la inscripción, relaciona con la tabla tm_preinscripciones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tm_usuario`
--

INSERT INTO `tm_usuario` (`idUsu`, `nickUsu`, `correoUsu`, `senaUsu`, `rolUsu`, `estUsu`, `obsUsu`, `avatarUsu`, `generoUsu`, `fecAltaUsu`, `fecBajaUsu`, `fecModiUsu`, `motivoBajaUsu`, `nombreUsu`, `apellidosUsu`, `fechaNacimientoUsu`, `telefonoUsu`, `movilUsu`, `razonSocialFacturacionUsu`, `identificacionFiscalUsu`, `direccionFacturacionUsu`, `codigoPostalUsu`, `provinciaUsu`, `ciudadPuebloUsu`, `paisUsu`, `personalizacionUsu`, `idiomaUsu`, `recibirNotificacionesUsu`, `registroInicioSesionUsu`, `accesoPrivadoUsu`, `ipUsu`, `tokenUsu`, `registroUsu`, `uuidUsu`, `idSoporte_tmUsuario`, `idTransportista_transportistas-Transporte`, `idAlumno_tmusuario`, `idInscripcion_tmusuario`) VALUES
(1, 'Nickname', 'software@efeuno.es', 'fca3d97bb6bbd55138f9af6ac121acda', 1, 1, NULL, '13_11_2024__14_36_55.jpg', NULL, '2023-09-05 14:19:08', '2023-09-08 16:32:09', '2024-03-05 10:10:00', NULL, 'Software', 'Efeuno Dev', '1990-05-13', '654654654', '961 86 1100', 'RazonSocial', '03160886L', 'Jose Gonzalez Huguet', '46930', 'Valencia', 'Quart de Poblet', NULL, '', NULL, 1, '2024-01-03', NULL, NULL, '1fcce077af6034560902b2b5ae4a34', 1, NULL, NULL, '03160886L', NULL, NULL),
(2, 'Jose113', 'jose@efeuno.es', 'fca3d97bb6bbd55138f9af6ac121acda', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'Jose', 'Vilar', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kltxn1ovab6fa7a2c7c912f117b5fe', NULL, NULL, NULL, NULL, NULL, 1),
(7, 'jose@efeuno.es', 'jose@efeuno.es', 'fca3d97bb6bbd55138f9af6ac121acda', 2, 1, 'Creado desde nuevo personal', 'profesorAvatar.png', 'x', NULL, NULL, '2025-05-27 10:03:39', NULL, 'José', 'Vilar Beas', '2020-10-10', '911499662', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'natymgh959096f230a206458a20b3', NULL, NULL, NULL, NULL, NULL, 29),
(23, 'Luis Carlos408', 'luiscarlos@ra82.es', 'fca3d97bb6bbd55138f9af6ac121acda', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'Luis Carlos', 'Pérez', '2020-10-10', '965262384', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vhtyk1m1be1635bce84fe9b9c3a65', NULL, NULL, NULL, NULL, NULL, 16),
(24, 'luis630', 'jose.mvb.cc@gmail.com', '70f539321b10948f9c0dae818b12c36e', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'luis', 'Carlos', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zhtyl1s1b88f882ea9a25a5bbc009', NULL, NULL, NULL, NULL, NULL, 17),
(25, 'shoei497', 'luiscarlospm@gmail.com', 'fca3d97bb6bbd55138f9af6ac121acda', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'shoei', 'Kaneyama', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kityj11efb98a977f64e2c4de414b', NULL, NULL, NULL, NULL, NULL, 18),
(26, 'uno134', 'manuel.villamayor@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'uno', 'AlumnoUno', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yityjve616c6be54ef2d7b17d8d18', NULL, NULL, NULL, NULL, NULL, 19),
(27, 'dos436', 'mail@gmail.com', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'dos', 'AlumnoDOS', '2020-10-10', '96133225', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1cityr1ypfcfba871ae229af87372', NULL, NULL, NULL, NULL, NULL, 20),
(28, 'peter767', 'mail2@mail.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'peter', 'kyo', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ajtyn1oe01d3a11d05578784a9261', NULL, NULL, NULL, NULL, NULL, 21),
(29, 'son726', 'mail2@mail.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'son', 'kyo', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ajtyna1j7d6475c8490f504e684db1', NULL, NULL, NULL, NULL, NULL, 22),
(30, 'hija767', 'mail2@mail.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'hija', 'Kyo', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ajtyncx76be660144c230119b2877', NULL, NULL, NULL, NULL, NULL, 23),
(31, 'jaime898', 'jaime@ominio.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'jaime', 'pernales', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mjtyo1tsb8b4898ef68773ff177572', NULL, NULL, NULL, NULL, NULL, 24),
(32, 'maria623', 'maria@dominio.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'maria', 'pernales', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mjtyo1u1lc20608d3660deb1c2fd2', NULL, NULL, NULL, NULL, NULL, 25),
(33, 'pablo839', 'mi@mal.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'pablo', 'picasso', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mjtyw1s1w12ffbe1c62c458461b2b', NULL, NULL, NULL, NULL, NULL, 26),
(34, 'ProfeUNO', 'micorreo@correos.net', 'd98ae89d2fa4cd834e937adb7899f74d', 2, 1, 'Creado desde nuevo personal', 'profesorAvatar.png', 'x', NULL, NULL, NULL, NULL, 'ProfeUNO', 'UNO PROFE', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ojtys1r1labbcfe7d5690b983042d', NULL, NULL, NULL, NULL, NULL, 34),
(35, 'mobin862', 'nolotengo@mail.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'mobin', 'Bibakesfahlan', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'qjtyl1j1zead9b9c75147f867108c', NULL, NULL, NULL, NULL, NULL, 27),
(36, 'haesun564', 'nomelose@mail.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'haesun', 'Jin', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'qjtyl1m11g60ce93d96cfe55192e04', NULL, NULL, NULL, NULL, NULL, 28),
(37, 'Pepe', 'pep@botella.es', 'd98ae89d2fa4cd834e937adb7899f74d', 2, 1, 'Creado desde nuevo personal', 'profesorAvatar.png', 'x', NULL, NULL, NULL, NULL, 'Pepe', 'Botella', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rjtyjq1x68cc806586b9937f26a121', NULL, NULL, NULL, NULL, NULL, 35),
(38, 'manuel.villamayor@uv.es', 'manuel.villamayor@uv.es', 'd98ae89d2fa4cd834e937adb7899f74d', 2, 1, 'Creado desde nuevo personal', 'profesorAvatar.png', 'x', NULL, NULL, NULL, NULL, 'Bilingue', 'Poliglota', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rjtyj1p11d2f37f65ac55589ff1498', NULL, NULL, NULL, NULL, NULL, 36),
(39, 'antonio390', 'prieto@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'antonio', 'prieto', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytfod9e3e8fe7b091f4986cd25', NULL, NULL, NULL, NULL, NULL, 29),
(40, 'jose456', 'jz@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'jose', 'zorrilla', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytgf7ff70096672128067e1fff', NULL, NULL, NULL, NULL, NULL, 30),
(41, 'maria427', 'santos@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'maria', 'santos', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytnh833d36ce6c5139fd8076c3', NULL, NULL, NULL, NULL, NULL, 31),
(42, 'javier655', 'perez@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'javier', 'perez', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtytp1gee17089b615589faabff90', NULL, NULL, NULL, NULL, NULL, 32),
(43, 'roberto393', 'feliz@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'roberto', 'Feliz', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtyttm6cba6471161f253c0f9fb8', NULL, NULL, NULL, NULL, NULL, 33),
(44, 'jesus220', 'jesus@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'jesus', 'vazquez', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tjtyt1lo5f565b107e6481ca87b35d', NULL, NULL, NULL, NULL, NULL, 34),
(45, 'primer887', 'primer@hermano.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'primer', 'HERMANO', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysh1ke70b26b2eea80b8ddb1739', NULL, NULL, NULL, NULL, NULL, 35),
(46, 'segundo828', 'segundo@hermano.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'segundo', 'hermano', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysild71d48e970374323d7d5cc', NULL, NULL, NULL, NULL, NULL, 36),
(47, 'tercer790', 'tercer@hermano.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'tercer', 'hermano', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysi1r11afe9467bd33c28778e9f', NULL, NULL, NULL, NULL, NULL, 37),
(48, 'cuarto406', 'cuarto@hermano.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'cuarto', 'hermano', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysj1se6ec09ef9d0bbf9eb52b97', NULL, NULL, NULL, NULL, NULL, 38),
(49, 'primer692', 'ingles1@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'primer', 'ingles', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysk1dc3cea6632706240517de45', NULL, NULL, NULL, NULL, NULL, 39),
(50, 'segundo968', 'ingles2@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'segundo', 'ingles', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtyslkafbe7af4867171461b6694', NULL, NULL, NULL, NULL, NULL, 40),
(51, 'tercer650', 'ingles3@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'tercer', 'ingles', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysl1k6420df2d7648bde63f4d2c', NULL, NULL, NULL, NULL, NULL, 41),
(52, 'Profe', 'profe1@ing.es', 'd98ae89d2fa4cd834e937adb7899f74d', 2, 1, 'Creado desde nuevo personal', 'profesorAvatar.png', 'x', NULL, NULL, NULL, NULL, 'Profe', 'Primero', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysmw52c3c8b6288a5b2ec37c87', NULL, NULL, NULL, NULL, NULL, 37),
(53, 'Profe', 'profe2@ing.es', 'd98ae89d2fa4cd834e937adb7899f74d', 2, 1, 'Creado desde nuevo personal', 'profesorAvatar.png', 'x', NULL, NULL, NULL, NULL, 'Profe', 'Segungo', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yjtysnaa373776f4d59ec2630c280', NULL, NULL, NULL, NULL, NULL, 38),
(54, 'test164', 'jose.mvv.cc@gmail.com', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'test', 'test', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1bjtyl1ht9c924d0b584cc703863c', NULL, NULL, NULL, NULL, NULL, 42),
(55, 'pepitol918', 'grill@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'pepitol', 'Grillo', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yktykq1u4fd7ebcfd96193b3f54d45', NULL, NULL, NULL, NULL, NULL, 43),
(56, 'manolo759', 'im@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'manolo', 'Grillo', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yktyk1fu9c0f419968c98af151bafb', NULL, NULL, NULL, NULL, NULL, 44),
(57, 'egerg778', 'jose.mvb.cc@gmail.com', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'egerg', 'reer', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zktylon1299a7b1bd1338648143ba', NULL, NULL, NULL, NULL, NULL, 45),
(58, 'jose448', 'jose.mvb.cc@gmail.com', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'jose', 'Test', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'altymd11c68991dbb83f7bfcaf254', NULL, NULL, NULL, NULL, NULL, 46),
(59, 'ignacio567', 'ign@uv.com', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'ignacio', 'Bel', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyk1y1z2f8c9c832c4ad1e3b12b', NULL, NULL, NULL, NULL, NULL, 47),
(60, 'frances393', 'fr01@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'frances', 'fr', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyls1n87254d9c49fc68c961d3b2', NULL, NULL, NULL, NULL, NULL, 48),
(61, 'fracncis827', '66@uv.es', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'fracncis', 'fr', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyltxa12e704083996cd49cce4b', NULL, NULL, NULL, NULL, NULL, 49),
(62, 'nuevoesp731', 'jose@gmail.com', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'nuevoesp', 'esp', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jltyl1ec17275c0669cdb5675aa1c5', NULL, NULL, NULL, NULL, NULL, 50),
(63, 'jose823', 'josetest@gmail.com', 'bd001472d43af8798a217dd802cc4841', 3, 1, 'Creado desde interesados', 'alumnoAvatar.png', 'x', NULL, NULL, NULL, NULL, 'jose', 'Beas', '2020-10-10', '', 'MOVIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sltyq1g1rba008e94350460b53cf1', NULL, NULL, NULL, NULL, NULL, 51);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_albaalumaloja_mediopago`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_albaalumaloja_mediopago` (
`idAlbaranAlumAloja` int
,`numAlbaran` int
,`numAlbaranPro` varchar(120)
,`numFactura` varchar(120)
,`idAloja_AlbaranAlumAloja` int
,`conceptoAlbaranAlumAloja` varchar(145)
,`tipoAlojaAlbaranAlumAloja` varchar(140)
,`obsAlbaranAlumAloja` longtext
,`fecAltaAlbaranAlumAloja` datetime
,`fecAltaAlbaranProAlumAloja` datetime
,`fecAltaFacturaAlumAloja` datetime
,`ivaAlbaranAlumAloja` int
,`cantidadAlbaranAlumAloja` int
,`precioAlbaranAlumAloja` float
,`idUsuario_AlbaranAlumAloja` int
,`idAlumAloja_AlbaranAlumAloja` int
,`idGrupo` int
,`cantidadPagoAlbaranAlumAloja` float
,`fechaPagoAlbaranAlumAloja` datetime
,`medioPago_AlbaranAlumAloja` int
,`idMedioPago` int
,`nomMedioPago` varchar(245)
,`fecAltaMedioPago` datetime
,`fecBajaMedioPago` datetime
,`fecModiMedioPago` datetime
,`estMedioPago` int
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `view_alumaloja_usuariostipos`
--

CREATE TABLE `view_alumaloja_usuariostipos` (
  `idAlumAloja` int DEFAULT NULL,
  `idAlum_AlumAloja` int DEFAULT NULL,
  `idAloja_AlumAloja` int DEFAULT NULL,
  `fecEntradaAlumAloja` date DEFAULT NULL,
  `fecSalidaAlumAloja` date DEFAULT NULL,
  `horaSalidaAlumAloja` time DEFAULT NULL,
  `fecAltaAlumAloja` datetime DEFAULT NULL,
  `fecBajaAlumAloja` datetime DEFAULT NULL,
  `estAlumAloja` int DEFAULT NULL,
  `fecMostrarAlumAloja` date DEFAULT NULL,
  `estMostrarAlumAloja` int DEFAULT NULL,
  `idAloja` int DEFAULT NULL,
  `idTipoAloja_TipoAloja` int DEFAULT NULL,
  `nifAloja` varchar(9) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `apeAloja` varchar(100) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nombreAloja` varchar(160) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `dirAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `cpAloja` varchar(7) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `poblaAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `proviAloja` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `telAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `movilAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailAloja` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textDatosPublicAloja` text COLLATE utf8mb3_spanish2_ci,
  `textDatosPrivateAloja` text COLLATE utf8mb3_spanish2_ci,
  `metrosAloja` int DEFAULT NULL,
  `wcAloja` int DEFAULT NULL,
  `HabIndiAloja` int DEFAULT NULL,
  `HabDobleAloja` int DEFAULT NULL,
  `HabTripleAloja` int DEFAULT NULL,
  `interAloja` int DEFAULT NULL,
  `descrAnimalesAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fumaAloja` int DEFAULT NULL,
  `descrFumaAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `comidasAloja` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textCasaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `nomPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacPadreAloja` date DEFAULT NULL,
  `profPadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nomMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `nacMadreAloja` date DEFAULT NULL,
  `profMadreAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `descrHijosVivenAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `aficAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `apieAloja` int DEFAULT NULL,
  `lineaAutobusAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minAutobusAloja` int DEFAULT NULL,
  `lineaMetroAloja` varchar(15) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `minMetroAloja` int DEFAULT NULL,
  `linkSituacionAloja` varchar(245) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `hospitalPrivAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `consultAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `hospitalPublicAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `pagoAloja` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `estAloja` int DEFAULT NULL,
  `motvBajaAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaAloja` datetime DEFAULT NULL,
  `fecBajaAloja` datetime DEFAULT NULL,
  `fecModiAloja` datetime DEFAULT NULL,
  `token` int DEFAULT NULL,
  `idUsuario` int DEFAULT NULL,
  `nomUsuario` varchar(60) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `emailUsuario` varchar(50) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `senaUsuario` varchar(45) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecAltaUsuario` datetime DEFAULT NULL,
  `fecBajaUsuario` datetime DEFAULT NULL,
  `fecModiUsuario` datetime DEFAULT NULL,
  `avatarUsuario` varchar(225) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `estUsu` int DEFAULT NULL,
  `nomAlumno` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `apeAlumno` varchar(255) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `fecNacAlumno` date DEFAULT NULL,
  `nacioAlumno` varchar(75) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `ProfeEstuAlumno` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `EmpresaAlumno` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `UniAlumno` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `teleAlumno` varchar(20) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `domValAlumno` varchar(200) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `domOrigenAlumno` varchar(200) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `lenMatAlumno` varchar(120) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `lenCon1Alumno` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `lenCon2Alumno` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `lenCon3Alumno` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `lenCon4Alumno` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `estEspAlumno` int DEFAULT NULL,
  `nivEspAlumno` varchar(120) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `tiemEspAlumno` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `lugEspAlumno` varchar(120) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `porEspAlumno` longtext COLLATE utf8mb3_spanish2_ci,
  `mejEspAlumno` int DEFAULT NULL,
  `aprEspAlumno` int DEFAULT NULL,
  `act1Alumno` int DEFAULT NULL,
  `act2Alumno` int DEFAULT NULL,
  `act3Alumno` int DEFAULT NULL,
  `act4Alumno` int DEFAULT NULL,
  `act5Alumno` int DEFAULT NULL,
  `act6Alumno` int DEFAULT NULL,
  `act7Alumno` int DEFAULT NULL,
  `gustaTraAlumno` int DEFAULT NULL,
  `gus1EspAlumno` int DEFAULT NULL,
  `gus2EspAlumno` int DEFAULT NULL,
  `gus3EspAlumno` int DEFAULT NULL,
  `gus4EspAlumno` int DEFAULT NULL,
  `gus5EspAlumno` int DEFAULT NULL,
  `gusTextEspAlumno` varchar(200) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `conAlumno` int DEFAULT NULL,
  `conRecoAlumno` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `conAgenAlumno` varchar(150) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `actSocialesAlumno` int DEFAULT NULL,
  `actCultAlumno` int DEFAULT NULL,
  `actGastroAlumno` int DEFAULT NULL,
  `actDepoAlumno` int DEFAULT NULL,
  `partActAlumno` int DEFAULT NULL,
  `numActAlumno` varchar(20) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `tokenUsu` int DEFAULT NULL,
  `idTiposAloja` int DEFAULT NULL,
  `descrTiposAloja` varchar(70) COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `textTiposAloja` mediumtext COLLATE utf8mb3_spanish2_ci,
  `fecAltaTiposAloja` datetime DEFAULT NULL,
  `fecBajaTiposAloja` datetime DEFAULT NULL,
  `fecModiTiposAloja` datetime DEFAULT NULL,
  `estTiposAloja` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_empresa_config`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_empresa_config` (
`idEmpresa` int
,`descrEmpresa` varchar(80)
,`dirEmpresa` varchar(150)
,`poblaEmpresa` varchar(80)
,`cpEmpresa` varchar(7)
,`provEmpresa` varchar(70)
,`paisEmpresa` varchar(60)
,`webEmpresa` varchar(150)
,`tlfEmpresa` varchar(12)
,`emailEmpresa` varchar(20)
,`nifEmpresa` varchar(16)
,`regEmpresa` varchar(250)
,`numFacturaPro` int
,`numFactura` int
,`numFacturaNeg` int
,`prefijoPro` varchar(120)
,`prefijoFact` varchar(120)
,`idEmpresa_config` int
,`idConfig` int
,`nombreEmpresa` varchar(225)
,`logotipoDark` varchar(225)
,`faviconDark` varchar(225)
,`logotipoWhite` varchar(225)
,`faviconWhite` varchar(225)
,`footerEmpresa` varchar(225)
,`mostrarSancion` tinyint(1)
,`mostrarMeses` tinyint(1)
,`mostrarQuincenas` tinyint(1)
,`mostrarTrimestral` tinyint(1)
,`mostrarContPrecinto` int
,`redsys` int
,`paypal` int
,`bizum` int
,`tipoPresupusto` int
,`colorPrincipal` varchar(50)
,`api_key` longtext
,`api_propietario` varchar(225)
,`idEmpresa_empresa` int
,`cliente_gesdoc` tinyint(1)
,`departamento_gesdoc` tinyint(1)
,`smtp_host` varchar(255)
,`snto_auth` tinyint(1)
,`smtp_username` varchar(255)
,`smtp_pass` varchar(255)
,`smtp_port` varchar(255)
,`smtp_receptor` varchar(255)
,`version_efeuno` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_tarifa_iva`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_tarifa_iva` (
`idTarifa` int
,`idIva_tarifa` int
,`idDepartament_tarifa` varchar(255)
,`cod_tarifa` varchar(255)
,`nombre_tarifa` varchar(255)
,`unidades_tarifa` varchar(255)
,`unidad_tarifa` varchar(255)
,`precio_tarifa` varchar(255)
,`cuenta1_tarifa` varchar(255)
,`cuenta2_tarifa` varchar(255)
,`cuenta3_tarifa` varchar(255)
,`tipo_tarifa` varchar(255)
,`descuento_tarifa` varchar(255)
,`descripcion_tarifa` varchar(255)
,`estTarifa` tinyint(1)
,`iva_tarifa` int
,`idIva` int
,`valorIva` int
,`descrIva` varchar(11)
,`fechAlta_iva` datetime
,`fechModi_iva` datetime
,`fechBaja_iva` datetime
,`estIva` int
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_alumnos_actividad`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_alumnos_actividad` (
`idUsuarioAct` int
,`idLlegada_UsuarioAct` int
,`idUsuario_UsuarioAct` int
,`idAct_UsuarioAct` int
,`asisUsuarioAct` int
,`fecAltaUsuarioAct` datetime
,`estUsuarioAct` int
,`idAlumno` int
,`nomUsuario` varchar(60)
,`emailUsuario` varchar(50)
,`senaUsuario` varchar(45)
,`fecAltaUsuario` datetime
,`fecBajaUsuario` datetime
,`fecModiUsuario` datetime
,`avatarUsuario` varchar(225)
,`estUsu` int
,`nomAlumno` varchar(255)
,`apeAlumno` varchar(255)
,`fecNacAlumno` date
,`nacioAlumno` varchar(75)
,`ProfeEstuAlumno` varchar(150)
,`EmpresaAlumno` varchar(150)
,`UniAlumno` varchar(150)
,`teleAlumno` varchar(20)
,`domValAlumno` varchar(200)
,`domOrigenAlumno` varchar(200)
,`lenMatAlumno` varchar(120)
,`lenCon1Alumno` varchar(70)
,`lenCon2Alumno` varchar(70)
,`lenCon3Alumno` varchar(70)
,`lenCon4Alumno` varchar(70)
,`estEspAlumno` int
,`nivEspAlumno` varchar(120)
,`tiemEspAlumno` varchar(70)
,`lugEspAlumno` varchar(120)
,`porEspAlumno` longtext
,`mejEspAlumno` int
,`aprEspAlumno` int
,`act1Alumno` int
,`act2Alumno` int
,`act3Alumno` int
,`act4Alumno` int
,`act5Alumno` int
,`act6Alumno` int
,`act7Alumno` int
,`gustaTraAlumno` int
,`gus1EspAlumno` int
,`gus2EspAlumno` int
,`gus3EspAlumno` int
,`gus4EspAlumno` int
,`gus5EspAlumno` int
,`gusTextEspAlumno` varchar(200)
,`conAlumno` int
,`conRecoAlumno` varchar(150)
,`conAgenAlumno` varchar(150)
,`actSocialesAlumno` int
,`actCultAlumno` int
,`actGastroAlumno` int
,`actDepoAlumno` int
,`partActAlumno` int
,`numActAlumno` varchar(20)
,`UltimaSesion` date
,`tokenUsu` longtext
,`identificadorPersonal` varchar(120)
,`perfilBloqueado` tinyint(1)
,`idInscripcion_tmAlumno` int
,`idUsuario_tmalumno` int
,`idAct` int
,`descrAct` varchar(100)
,`obsAct` mediumtext
,`fecActDesde` date
,`fecActHasta` date
,`fecActFinSolicitud` date
,`estadoAct` int
,`horaInicioAct` time
,`horaFinAct` time
,`horasLectivasAct` varchar(11)
,`imgAct` varchar(225)
,`fecAltaAct` datetime
,`fecBajaAct` datetime
,`fecModiAct` datetime
,`puntoEncuentroAct` varchar(105)
,`idPersonal_guiaAct` int
,`minAlumAct` int
,`maxAlumAct` int
,`idsDepartamentos` text
);

-- --------------------------------------------------------

--
-- Estructura para la vista `actividadescompleto`
--
DROP TABLE IF EXISTS `actividadescompleto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newcosta`@`localhost` SQL SECURITY DEFINER VIEW `actividadescompleto`  AS SELECT `a`.`idAct` AS `idAct`, `a`.`descrAct` AS `descrAct`, `a`.`obsAct` AS `obsAct`, `a`.`fecActDesde` AS `fecActDesde`, `a`.`fecActHasta` AS `fecActHasta`, `a`.`fecActFinSolicitud` AS `fecActFinSolicitud`, `a`.`estadoAct` AS `estadoAct`, `a`.`horaInicioAct` AS `horaInicioAct`, `a`.`horaFinAct` AS `horaFinAct`, `a`.`horasLectivasAct` AS `horasLectivasAct`, `a`.`minAlumAct` AS `minAlumAct`, `a`.`maxAlumAct` AS `maxAlumAct`, `a`.`departamentoDisponible` AS `departamentoDisponible`, `a`.`imgAct` AS `imgAct`, `a`.`fecAltaAct` AS `fecAltaAct`, `a`.`fecBajaAct` AS `fecBajaAct`, `a`.`fecModiAct` AS `fecModiAct`, `a`.`puntoEncuentroAct` AS `puntoEncuentroAct`, `a`.`idPersonal_guiaAct` AS `idPersonal_guiaAct`, `p`.`idPersonal` AS `idPersonal`, `p`.`nomPersonal` AS `nomPersonal`, `p`.`apePersonal` AS `apePersonal`, `p`.`dirPersonal` AS `dirPersonal`, `p`.`poblaPersonal` AS `poblaPersonal`, `p`.`cpPersonal` AS `cpPersonal`, `p`.`provPersonal` AS `provPersonal`, `p`.`paisPersonal` AS `paisPersonal`, `p`.`tlfPersonal` AS `tlfPersonal`, `p`.`movilPersonal` AS `movilPersonal`, `p`.`emailPersonal` AS `emailPersonal`, `p`.`fecAltaPersonal` AS `fecAltaPersonal`, `p`.`fecBajaPersonal` AS `fecBajaPersonal`, `p`.`fecModiPersonal` AS `fecModiPersonal`, `p`.`estPersonal` AS `estPersonal`, group_concat(distinct `d`.`idDepartamento_actividadDepartamento` separator ',') AS `idsDepartamentos`, group_concat(distinct `dep`.`nombreDepartamento` separator ', ') AS `nombresDepartamentos` FROM (((`tm_actividad_edu` `a` left join `tm_personal` `p` on((`a`.`idPersonal_guiaAct` = `p`.`idPersonal`))) left join `td_actividadDepartamento` `d` on((`a`.`idAct` = `d`.`idActividad_actividadDepartamento`))) left join `tm_departamento_edu` `dep` on((`d`.`idDepartamento_actividadDepartamento` = `dep`.`idDepartamentoEdu`))) GROUP BY `a`.`idAct` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `asistencia_tmpersonal`
--
DROP TABLE IF EXISTS `asistencia_tmpersonal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `asistencia_tmpersonal`  AS SELECT `asistencia`.`idasistencia` AS `idasistencia`, `asistencia`.`idPersonal_asistencia` AS `idPersonal_asistencia`, `asistencia`.`inicioAsistencia` AS `inicioAsistencia`, `asistencia`.`finAsistencia` AS `finAsistencia`, `asistencia`.`motivoAsistencia` AS `motivoAsistencia`, `tm_personal`.`idPersonal` AS `idPersonal`, `tm_personal`.`nomPersonal` AS `nomPersonal`, `tm_personal`.`emailUsuario` AS `emailUsuario`, `tm_personal`.`senaUsuario` AS `senaUsuario`, `tm_personal`.`apePersonal` AS `apePersonal`, `tm_personal`.`dirPersonal` AS `dirPersonal`, `tm_personal`.`poblaPersonal` AS `poblaPersonal`, `tm_personal`.`cpPersonal` AS `cpPersonal`, `tm_personal`.`provPersonal` AS `provPersonal`, `tm_personal`.`paisPersonal` AS `paisPersonal`, `tm_personal`.`tlfPersonal` AS `tlfPersonal`, `tm_personal`.`movilPersonal` AS `movilPersonal`, `tm_personal`.`emailPersonal` AS `emailPersonal`, `tm_personal`.`fecAltaPersonal` AS `fecAltaPersonal`, `tm_personal`.`fecBajaPersonal` AS `fecBajaPersonal`, `tm_personal`.`fecModiPersonal` AS `fecModiPersonal`, `tm_personal`.`rolUsuario` AS `rolUsuario`, `tm_personal`.`estPersonal` AS `estPersonal`, (case when ((`asistencia`.`inicioAsistencia` is not null) and (`asistencia`.`finAsistencia` is null)) then 'Trabajando' when (`asistencia`.`finAsistencia` is not null) then 'Jornada finalizada' else 'Pendiente' end) AS `estado` FROM (`asistencia` left join `tm_personal` on((`asistencia`.`idPersonal_asistencia` = `tm_personal`.`idPersonal`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `c_llamadas`
--
DROP TABLE IF EXISTS `c_llamadas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `c_llamadas`  AS SELECT `llamadas`.`idllamadas` AS `idllamadas`, `llamadas`.`comercialid` AS `comercialid`, `llamadas`.`fechaLlamada` AS `fechaLlamada`, `llamadas`.`estado` AS `estado`, (select `comercial`.`nomcomercial` from `comercial` where (`comercial`.`idcomercial` = `llamadas`.`comercialid`)) AS `nombreComercial` FROM `llamadas` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `llegadas_departamentos`
--
DROP TABLE IF EXISTS `llegadas_departamentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `llegadas_departamentos`  AS SELECT `tm_llegadas_edu`.`id_llegada` AS `id_llegada`, `tm_llegadas_edu`.`diainscripcion_llegadas` AS `diainscripcion_llegadas`, `tm_llegadas_edu`.`idprescriptor_llegadas` AS `idprescriptor_llegadas`, `tm_llegadas_edu`.`iddepartamento_llegadas` AS `iddepartamento_llegadas`, `tm_llegadas_edu`.`agente_llegadas` AS `agente_llegadas`, `tm_llegadas_edu`.`grupo_llegadas` AS `grupo_llegadas`, `tm_llegadas_edu`.`grupoAmigos` AS `grupoAmigos`, `tm_llegadas_edu`.`fechallegada_llegadas` AS `fechallegada_llegadas`, `tm_llegadas_edu`.`horallegada_llegadas` AS `horallegada_llegadas`, `tm_llegadas_edu`.`lugarllegada_llegadas` AS `lugarllegada_llegadas`, `tm_llegadas_edu`.`quienrecogealumno_llegadas` AS `quienrecogealumno_llegadas`, `tm_llegadas_edu`.`fechacancelacion_llegadas` AS `fechacancelacion_llegadas`, `tm_llegadas_edu`.`motivocancelacion_llegadas` AS `motivocancelacion_llegadas`, `tm_llegadas_edu`.`codigotariotallegadaTransfer_llegadas` AS `codigotariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`textotariotallegadaTransfer_llegadas` AS `textotariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`importetariotallegadaTransfer_llegadas` AS `importetariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`ivatariotallegadaTransfer_llegadas` AS `ivatariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`diallegadaTransferTransfer_llegadas` AS `diallegadaTransferTransfer_llegadas`, `tm_llegadas_edu`.`horallegadaTransferTransfer_llegadas` AS `horallegadaTransferTransfer_llegadas`, `tm_llegadas_edu`.`lugarllegadallegadaTransfer_llegadas` AS `lugarllegadallegadaTransfer_llegadas`, `tm_llegadas_edu`.`lugarentregallegadaTransfer_llegadas` AS `lugarentregallegadaTransfer_llegadas`, `tm_llegadas_edu`.`quienrecogealumnollegadaTransfer_llegadas` AS `quienrecogealumnollegadaTransfer_llegadas`, `tm_llegadas_edu`.`codigotariotalregresoTransfer_llegadas` AS `codigotariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`textotariotalregresoTransfer_llegadas` AS `textotariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`importetariotalregresoTransfer_llegadas` AS `importetariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`ivatariotalregresoTransfer_llegadas` AS `ivatariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`diaregresoTransfer_llegadas` AS `diaregresoTransfer_llegadas`, `tm_llegadas_edu`.`horaregresoTransfer_llegadas` AS `horaregresoTransfer_llegadas`, `tm_llegadas_edu`.`lugarrecogidaregresaTransfer_llegadas` AS `lugarrecogidaregresaTransfer_llegadas`, `tm_llegadas_edu`.`lugarentregaregresaTransfer_llegadas` AS `lugarentregaregresaTransfer_llegadas`, `tm_llegadas_edu`.`quienrecogealumnoregresaTransfer_llegadas` AS `quienrecogealumnoregresaTransfer_llegadas`, `tm_llegadas_edu`.`campoobservacionesgeneralTransfer_llegadas` AS `campoobservacionesgeneralTransfer_llegadas`, `tm_llegadas_edu`.`niveldice_llegadas` AS `niveldice_llegadas`, `tm_llegadas_edu`.`nivelobservaciones_llegadas` AS `nivelobservaciones_llegadas`, `tm_llegadas_edu`.`nivelasignado_llegadas` AS `nivelasignado_llegadas`, `tm_llegadas_edu`.`semanaasignada_llegadas` AS `semanaasignada_llegadas`, `tm_llegadas_edu`.`tieneVisado` AS `tieneVisado`, `tm_llegadas_edu`.`fechCartaAdmision` AS `fechCartaAdmision`, `tm_llegadas_edu`.`denegacionFecha` AS `denegacionFecha`, `tm_llegadas_edu`.`denegacionMotivo` AS `denegacionMotivo`, `tm_llegadas_edu`.`estProforma` AS `estProforma`, `tm_llegadas_edu`.`numProforma` AS `numProforma`, `tm_llegadas_edu`.`estLlegada` AS `estLlegada`, `tm_llegadas_edu`.`suplidoImporte` AS `suplidoImporte`, `tm_llegadas_edu`.`suplidoDescr` AS `suplidoDescr`, `tm_llegadas_edu`.`estMatricula` AS `estMatricula`, `tm_llegadas_edu`.`estAlojamiento` AS `estAlojamiento`, `tm_llegadas_edu`.`cursoFinalizado` AS `cursoFinalizado`, `tm_departamento_edu`.`idDepartamentoEdu` AS `idDepartamentoEdu`, `tm_departamento_edu`.`nombreDepartamento` AS `nombreDepartamento`, `tm_departamento_edu`.`numFacturaProDepa` AS `numFacturaProDepa`, `tm_departamento_edu`.`numFacturaDepa` AS `numFacturaDepa`, `tm_departamento_edu`.`numFacturaNegDepa` AS `numFacturaNegDepa`, `tm_departamento_edu`.`prefijoFactDepa` AS `prefijoFactDepa`, `tm_departamento_edu`.`prefijoFacturaProEdu` AS `prefijoFacturaProEdu`, `tm_departamento_edu`.`prefijoAbonoEdu` AS `prefijoAbonoEdu`, `tm_departamento_edu`.`estDepa` AS `estDepa` FROM (`tm_llegadas_edu` left join `tm_departamento_edu` on((`tm_llegadas_edu`.`iddepartamento_llegadas` = `tm_departamento_edu`.`idDepartamentoEdu`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `llegadas_matriculaciones`
--
DROP TABLE IF EXISTS `llegadas_matriculaciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `llegadas_matriculaciones`  AS SELECT `tm_llegadas_edu`.`id_llegada` AS `id_llegada`, `tm_llegadas_edu`.`diainscripcion_llegadas` AS `diainscripcion_llegadas`, `tm_llegadas_edu`.`idprescriptor_llegadas` AS `idprescriptor_llegadas`, `tm_llegadas_edu`.`iddepartamento_llegadas` AS `iddepartamento_llegadas`, `tm_llegadas_edu`.`agente_llegadas` AS `agente_llegadas`, `tm_llegadas_edu`.`grupo_llegadas` AS `grupo_llegadas`, `tm_llegadas_edu`.`grupoAmigos` AS `grupoAmigos`, `tm_llegadas_edu`.`fechallegada_llegadas` AS `fechallegada_llegadas`, `tm_llegadas_edu`.`horallegada_llegadas` AS `horallegada_llegadas`, `tm_llegadas_edu`.`lugarllegada_llegadas` AS `lugarllegada_llegadas`, `tm_llegadas_edu`.`quienrecogealumno_llegadas` AS `quienrecogealumno_llegadas`, `tm_llegadas_edu`.`fechacancelacion_llegadas` AS `fechacancelacion_llegadas`, `tm_llegadas_edu`.`motivocancelacion_llegadas` AS `motivocancelacion_llegadas`, `tm_llegadas_edu`.`codigotariotallegadaTransfer_llegadas` AS `codigotariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`textotariotallegadaTransfer_llegadas` AS `textotariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`importetariotallegadaTransfer_llegadas` AS `importetariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`ivatariotallegadaTransfer_llegadas` AS `ivatariotallegadaTransfer_llegadas`, `tm_llegadas_edu`.`diallegadaTransferTransfer_llegadas` AS `diallegadaTransferTransfer_llegadas`, `tm_llegadas_edu`.`horallegadaTransferTransfer_llegadas` AS `horallegadaTransferTransfer_llegadas`, `tm_llegadas_edu`.`lugarllegadallegadaTransfer_llegadas` AS `lugarllegadallegadaTransfer_llegadas`, `tm_llegadas_edu`.`lugarentregallegadaTransfer_llegadas` AS `lugarentregallegadaTransfer_llegadas`, `tm_llegadas_edu`.`quienrecogealumnollegadaTransfer_llegadas` AS `quienrecogealumnollegadaTransfer_llegadas`, `tm_llegadas_edu`.`codigotariotalregresoTransfer_llegadas` AS `codigotariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`textotariotalregresoTransfer_llegadas` AS `textotariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`importetariotalregresoTransfer_llegadas` AS `importetariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`ivatariotalregresoTransfer_llegadas` AS `ivatariotalregresoTransfer_llegadas`, `tm_llegadas_edu`.`diaregresoTransfer_llegadas` AS `diaregresoTransfer_llegadas`, `tm_llegadas_edu`.`horaregresoTransfer_llegadas` AS `horaregresoTransfer_llegadas`, `tm_llegadas_edu`.`lugarrecogidaregresaTransfer_llegadas` AS `lugarrecogidaregresaTransfer_llegadas`, `tm_llegadas_edu`.`lugarentregaregresaTransfer_llegadas` AS `lugarentregaregresaTransfer_llegadas`, `tm_llegadas_edu`.`quienrecogealumnoregresaTransfer_llegadas` AS `quienrecogealumnoregresaTransfer_llegadas`, `tm_llegadas_edu`.`campoobservacionesgeneralTransfer_llegadas` AS `campoobservacionesgeneralTransfer_llegadas`, `tm_llegadas_edu`.`niveldice_llegadas` AS `niveldice_llegadas`, `tm_llegadas_edu`.`nivelobservaciones_llegadas` AS `nivelobservaciones_llegadas`, `tm_llegadas_edu`.`nivelasignado_llegadas` AS `nivelasignado_llegadas`, `tm_llegadas_edu`.`semanaasignada_llegadas` AS `semanaasignada_llegadas`, `tm_llegadas_edu`.`tieneVisado` AS `tieneVisado`, `tm_llegadas_edu`.`fechCartaAdmision` AS `fechCartaAdmision`, `tm_llegadas_edu`.`denegacionFecha` AS `denegacionFecha`, `tm_llegadas_edu`.`denegacionMotivo` AS `denegacionMotivo`, `tm_llegadas_edu`.`estProforma` AS `estProforma`, `tm_llegadas_edu`.`numProforma` AS `numProforma`, `tm_llegadas_edu`.`estLlegada` AS `estLlegada`, `tm_llegadas_edu`.`suplidoImporte` AS `suplidoImporte`, `tm_llegadas_edu`.`suplidoDescr` AS `suplidoDescr`, `tm_llegadas_edu`.`estMatricula` AS `estMatricula`, `tm_matriculacionllegadas_edu`.`idMatriculacionLlegada` AS `idMatriculacionLlegada`, `tm_matriculacionllegadas_edu`.`idLlegada_matriculacion` AS `idLlegada_matriculacion`, `tm_matriculacionllegadas_edu`.`idIvaTarifa_matriculacion` AS `idIvaTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`idDepartamentoTarifa_matriculacion` AS `idDepartamentoTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`codTarifa_matriculacion` AS `codTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`nombreTarifa_matriculacion` AS `nombreTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`unidadTarifa_matriculacion` AS `unidadTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`precioTarifa_matriculacion` AS `precioTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`cuenta1Tarifa_matriculacion` AS `cuenta1Tarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`cuenta2Tarifa_matriculacion` AS `cuenta2Tarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`cuenta3Tarifa_matriculacion` AS `cuenta3Tarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`tipoTarifa_matriculacion` AS `tipoTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`descripcionTarifa_matriculacion` AS `descripcionTarifa_matriculacion`, `tm_matriculacionllegadas_edu`.`fechaInicioMatriculacion` AS `fechaInicioMatriculacion`, `tm_matriculacionllegadas_edu`.`fechaFinMatriculacion` AS `fechaFinMatriculacion`, `tm_matriculacionllegadas_edu`.`estMatriculacion_llegadas` AS `estMatriculacion_llegadas`, `tm_matriculacionllegadas_edu`.`obsMatriculacion` AS `obsMatriculacion`, `tm_matriculacionllegadas_edu`.`descuento_matriculacion` AS `descuento_matriculacion` FROM (`tm_llegadas_edu` left join `tm_matriculacionllegadas_edu` on((`tm_llegadas_edu`.`id_llegada` = `tm_matriculacionllegadas_edu`.`idLlegada_matriculacion`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `personal_contratos_tipocontratos`
--
DROP TABLE IF EXISTS `personal_contratos_tipocontratos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `personal_contratos_tipocontratos`  AS SELECT `td_persocontrato`.`idPersoContrato` AS `idPersoContrato`, `td_persocontrato`.`idpersonal_PersoContrato` AS `idpersonal_PersoContrato`, `td_persocontrato`.`idcontrato_PersoContrato` AS `idcontrato_PersoContrato`, `td_persocontrato`.`fecInicioPersoContrato` AS `fecInicioPersoContrato`, `td_persocontrato`.`fecFinalPersoContrato` AS `fecFinalPersoContrato`, `td_persocontrato`.`textPersoContrato` AS `textPersoContrato`, `td_persocontrato`.`estContrato` AS `estContrato`, `td_persocontrato`.`categoriaContrato` AS `categoriaContrato`, `td_persocontrato`.`jornadaContrato` AS `jornadaContrato`, `td_persocontrato`.`duracionContrato` AS `duracionContrato`, `tm_tipocontrato`.`idTipoContrato` AS `idTipoContrato`, `tm_tipocontrato`.`descrTipoContrato` AS `descrTipoContrato`, `tm_tipocontrato`.`textTipoContrato` AS `textTipoContrato`, `tm_tipocontrato`.`fecAltaTipoContrato` AS `fecAltaTipoContrato`, `tm_tipocontrato`.`fecBajaTipoContrato` AS `fecBajaTipoContrato`, `tm_tipocontrato`.`fecModiTipoContrato` AS `fecModiTipoContrato`, `tm_tipocontrato`.`estTipoContrato` AS `estTipoContrato`, `tm_personal`.`idPersonal` AS `idPersonal`, `tm_personal`.`nomPersonal` AS `nomPersonal`, `tm_personal`.`emailUsuario` AS `emailUsuario`, `tm_personal`.`senaUsuario` AS `senaUsuario`, `tm_personal`.`apePersonal` AS `apePersonal`, `tm_personal`.`dirPersonal` AS `dirPersonal`, `tm_personal`.`poblaPersonal` AS `poblaPersonal`, `tm_personal`.`cpPersonal` AS `cpPersonal`, `tm_personal`.`provPersonal` AS `provPersonal`, `tm_personal`.`paisPersonal` AS `paisPersonal`, `tm_personal`.`tlfPersonal` AS `tlfPersonal`, `tm_personal`.`movilPersonal` AS `movilPersonal`, `tm_personal`.`emailPersonal` AS `emailPersonal`, `tm_personal`.`fecAltaPersonal` AS `fecAltaPersonal`, `tm_personal`.`fecBajaPersonal` AS `fecBajaPersonal`, `tm_personal`.`fecModiPersonal` AS `fecModiPersonal`, `tm_personal`.`rolUsuario` AS `rolUsuario`, `tm_personal`.`estPersonal` AS `estPersonal`, `tm_personal`.`tokenPers` AS `tokenPers` FROM ((`td_persocontrato` left join `tm_tipocontrato` on((`td_persocontrato`.`idcontrato_PersoContrato` = `tm_tipocontrato`.`idTipoContrato`))) left join `tm_personal` on((`td_persocontrato`.`idpersonal_PersoContrato` = `tm_personal`.`idPersonal`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ruta_completo`
--
DROP TABLE IF EXISTS `ruta_completo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `ruta_completo`  AS SELECT `ruta`.`id_ruta` AS `id_ruta`, `ruta`.`idiomaId_ruta` AS `idiomaId_ruta`, (select upper(`tm_idioma`.`descrIdioma`) from `tm_idioma` where (`tm_idioma`.`idIdioma` = `ruta`.`idiomaId_ruta`)) AS `descrIdioma`, (select `tm_idioma`.`codIdioma` from `tm_idioma` where (`tm_idioma`.`idIdioma` = `ruta`.`idiomaId_ruta`)) AS `codIdioma`, `ruta`.`tipoId_ruta` AS `tipoId_ruta`, (select upper(`tm_tipocurso`.`descrTipo`) from `tm_tipocurso` where (`tm_tipocurso`.`idTipo` = `ruta`.`tipoId_ruta`)) AS `descrTipo`, (select `tm_tipocurso`.`codTipo` from `tm_tipocurso` where (`tm_tipocurso`.`idTipo` = `ruta`.`tipoId_ruta`)) AS `codTipo`, `ruta`.`nivelId_ruta` AS `nivelId_ruta`, (select upper(`tm_nivel`.`descrNivel`) from `tm_nivel` where (`tm_nivel`.`idNivel` = `ruta`.`nivelId_ruta`)) AS `descrNivel`, (select `tm_nivel`.`codNivel` from `tm_nivel` where (`tm_nivel`.`idNivel` = `ruta`.`nivelId_ruta`)) AS `codNivel`, `ruta`.`maxAlum_ruta` AS `maxAlum_ruta`, `ruta`.`minAlum_ruta` AS `minAlum_ruta`, `ruta`.`perRefresco_ruta` AS `perRefresco_ruta`, `ruta`.`medidaRefresco_ruta` AS `medidaRefresco_ruta`, (case when (`ruta`.`medidaRefresco_ruta` = 1) then 'Día' when (`ruta`.`medidaRefresco_ruta` = 2) then 'Semana' when (`ruta`.`medidaRefresco_ruta` = 3) then 'Mes' else 'Sin periodicidad' end) AS `descrRefresco`, `ruta`.`est_ruta` AS `estadoRuta`, `ruta`.`peso_ruta` AS `pesoRuta` FROM `tm_ruta` AS `ruta` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `testnivel&tipocurso`
--
DROP TABLE IF EXISTS `testnivel&tipocurso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newcosta`@`localhost` SQL SECURITY DEFINER VIEW `testnivel&tipocurso`  AS SELECT `testdeniveledu`.`idTestNivel` AS `idTestNivel`, `testdeniveledu`.`nombreTest` AS `nombreTest`, `testdeniveledu`.`archivoTest_pdf` AS `archivoTest_pdf`, `testdeniveledu`.`tipo_curso` AS `tipo_curso`, `testdeniveledu`.`idiomaTest` AS `idiomaTest`, `testdeniveledu`.`fecha_creacion` AS `fecha_creacion`, `testdeniveledu`.`activo` AS `activo`, `tm_tipocurso`.`idTipo` AS `idTipo`, `tm_tipocurso`.`descrTipo` AS `descrTipo`, `tm_tipocurso`.`codTipo` AS `codTipo`, `tm_tipocurso`.`textTipo` AS `textTipo`, `tm_tipocurso`.`minAlumTipo` AS `minAlumTipo`, `tm_tipocurso`.`maxAlumTipo` AS `maxAlumTipo`, `tm_tipocurso`.`fecAltaTipoCurso` AS `fecAltaTipoCurso`, `tm_tipocurso`.`fecModiTipoCurso` AS `fecModiTipoCurso`, `tm_tipocurso`.`fecBajaTipoCurso` AS `fecBajaTipoCurso`, `tm_tipocurso`.`estTipoCurso` AS `estTipoCurso` FROM (`testdeniveledu` left join `tm_tipocurso` on((`testdeniveledu`.`tipo_curso` = `tm_tipocurso`.`idTipo`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `tm_contenido_titulares_tipo_nivel`
--
DROP TABLE IF EXISTS `tm_contenido_titulares_tipo_nivel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newcosta`@`%` SQL SECURITY DEFINER VIEW `tm_contenido_titulares_tipo_nivel`  AS SELECT `tm_contenido`.`idContenido` AS `idContenido`, `tm_contenido`.`idtitContenido_titContenido` AS `idtitContenido_titContenido`, `tm_contenido`.`idTipoContenido_tipoCurso` AS `idTipoContenido_tipoCurso`, `tm_contenido`.`idNivelContenido_nivel` AS `idNivelContenido_nivel`, `tm_contenido`.`descrContenido` AS `descrContenido`, `tm_contenido`.`obsContenido` AS `obsContenido`, `tm_contenido`.`estContenido` AS `estContenido`, `tm_titulares_contenido`.`idTitContenido` AS `idTitContenido`, `tm_titulares_contenido`.`descrTitContenido` AS `descrTitContenido`, `tm_titulares_contenido`.`obsTitContenido` AS `obsTitContenido`, `tm_tipocurso`.`idTipo` AS `idTipo`, `tm_tipocurso`.`descrTipo` AS `descrTipo`, `tm_tipocurso`.`codTipo` AS `codTipo`, `tm_tipocurso`.`textTipo` AS `textTipo`, `tm_tipocurso`.`minAlumTipo` AS `minAlumTipo`, `tm_tipocurso`.`maxAlumTipo` AS `maxAlumTipo`, `tm_tipocurso`.`fecAltaTipoCurso` AS `fecAltaTipoCurso`, `tm_tipocurso`.`fecModiTipoCurso` AS `fecModiTipoCurso`, `tm_tipocurso`.`fecBajaTipoCurso` AS `fecBajaTipoCurso`, `tm_tipocurso`.`estTipoCurso` AS `estTipoCurso`, `tm_nivel`.`idNivel` AS `idNivel`, `tm_nivel`.`descrNivel` AS `descrNivel`, `tm_nivel`.`codNivel` AS `codNivel`, `tm_nivel`.`textNivel` AS `textNivel`, `tm_nivel`.`semanasNivel` AS `semanasNivel`, `tm_nivel`.`fecAltaNivel` AS `fecAltaNivel`, `tm_nivel`.`fecBajaNivel` AS `fecBajaNivel`, `tm_nivel`.`fecModiNivel` AS `fecModiNivel`, `tm_nivel`.`estNivel` AS `estNivel` FROM (((`tm_contenido` left join `tm_titulares_contenido` on((`tm_contenido`.`idtitContenido_titContenido` = `tm_titulares_contenido`.`idTitContenido`))) left join `tm_tipocurso` on((`tm_contenido`.`idTipoContenido_tipoCurso` = `tm_tipocurso`.`idTipo`))) left join `tm_nivel` on((`tm_contenido`.`idNivelContenido_nivel` = `tm_nivel`.`idNivel`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `tm_objetivos_titulares_nivel`
--
DROP TABLE IF EXISTS `tm_objetivos_titulares_nivel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newcosta`@`%` SQL SECURITY DEFINER VIEW `tm_objetivos_titulares_nivel`  AS SELECT `tm_objetivos`.`idObjetivo` AS `idObjetivo`, `tm_objetivos`.`idtitObjetivo_titObjetivo` AS `idtitObjetivo_titObjetivo`, `tm_objetivos`.`idNivelObjetivo_nivel` AS `idNivelObjetivo_nivel`, `tm_objetivos`.`descrObjetivo` AS `descrObjetivo`, `tm_objetivos`.`obsObjetivo` AS `obsObjetivo`, `tm_objetivos`.`estObjetivo` AS `estObjetivo`, `tm_titulares_objetivos`.`idTitObjetivo` AS `idTitObjetivo`, `tm_titulares_objetivos`.`descrTitObjetivo` AS `descrTitObjetivo`, `tm_titulares_objetivos`.`obsTitObjetivo` AS `obsTitObjetivo`, `tm_nivel`.`idNivel` AS `idNivel`, `tm_nivel`.`descrNivel` AS `descrNivel`, `tm_nivel`.`codNivel` AS `codNivel`, `tm_nivel`.`textNivel` AS `textNivel`, `tm_nivel`.`semanasNivel` AS `semanasNivel`, `tm_nivel`.`fecAltaNivel` AS `fecAltaNivel`, `tm_nivel`.`fecBajaNivel` AS `fecBajaNivel`, `tm_nivel`.`fecModiNivel` AS `fecModiNivel`, `tm_nivel`.`estNivel` AS `estNivel` FROM ((`tm_objetivos` left join `tm_titulares_objetivos` on((`tm_objetivos`.`idtitObjetivo_titObjetivo` = `tm_titulares_objetivos`.`idTitObjetivo`))) left join `tm_nivel` on((`tm_objetivos`.`idNivelObjetivo_nivel` = `tm_nivel`.`idNivel`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_albaalumaloja_mediopago`
--
DROP TABLE IF EXISTS `view_albaalumaloja_mediopago`;

CREATE ALGORITHM=UNDEFINED DEFINER=`c1dev_costa`@`localhost` SQL SECURITY DEFINER VIEW `view_albaalumaloja_mediopago`  AS SELECT `albaalumaloja`.`idAlbaranAlumAloja` AS `idAlbaranAlumAloja`, `albaalumaloja`.`numAlbaran` AS `numAlbaran`, `albaalumaloja`.`numAlbaranPro` AS `numAlbaranPro`, `albaalumaloja`.`numFactura` AS `numFactura`, `albaalumaloja`.`idAloja_AlbaranAlumAloja` AS `idAloja_AlbaranAlumAloja`, `albaalumaloja`.`conceptoAlbaranAlumAloja` AS `conceptoAlbaranAlumAloja`, `albaalumaloja`.`tipoAlojaAlbaranAlumAloja` AS `tipoAlojaAlbaranAlumAloja`, `albaalumaloja`.`obsAlbaranAlumAloja` AS `obsAlbaranAlumAloja`, `albaalumaloja`.`fecAltaAlbaranAlumAloja` AS `fecAltaAlbaranAlumAloja`, `albaalumaloja`.`fecAltaAlbaranProAlumAloja` AS `fecAltaAlbaranProAlumAloja`, `albaalumaloja`.`fecAltaFacturaAlumAloja` AS `fecAltaFacturaAlumAloja`, `albaalumaloja`.`ivaAlbaranAlumAloja` AS `ivaAlbaranAlumAloja`, `albaalumaloja`.`cantidadAlbaranAlumAloja` AS `cantidadAlbaranAlumAloja`, `albaalumaloja`.`precioAlbaranAlumAloja` AS `precioAlbaranAlumAloja`, `albaalumaloja`.`idUsuario_AlbaranAlumAloja` AS `idUsuario_AlbaranAlumAloja`, `albaalumaloja`.`idAlumAloja_AlbaranAlumAloja` AS `idAlumAloja_AlbaranAlumAloja`, `albaalumaloja`.`idGrupo` AS `idGrupo`, `albaalumaloja`.`cantidadPagoAlbaranAlumAloja` AS `cantidadPagoAlbaranAlumAloja`, `albaalumaloja`.`fechaPagoAlbaranAlumAloja` AS `fechaPagoAlbaranAlumAloja`, `albaalumaloja`.`medioPago_AlbaranAlumAloja` AS `medioPago_AlbaranAlumAloja`, `tm_mediopago`.`idMedioPago` AS `idMedioPago`, `tm_mediopago`.`nomMedioPago` AS `nomMedioPago`, `tm_mediopago`.`fecAltaMedioPago` AS `fecAltaMedioPago`, `tm_mediopago`.`fecBajaMedioPago` AS `fecBajaMedioPago`, `tm_mediopago`.`fecModiMedioPago` AS `fecModiMedioPago`, `tm_mediopago`.`estMedioPago` AS `estMedioPago` FROM (`albaalumaloja` left join `tm_mediopago` on((`albaalumaloja`.`medioPago_AlbaranAlumAloja` = `tm_mediopago`.`idMedioPago`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_empresa_config`
--
DROP TABLE IF EXISTS `view_empresa_config`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newcosta`@`%` SQL SECURITY DEFINER VIEW `view_empresa_config`  AS SELECT `empresa`.`idEmpresa` AS `idEmpresa`, `empresa`.`descrEmpresa` AS `descrEmpresa`, `empresa`.`dirEmpresa` AS `dirEmpresa`, `empresa`.`poblaEmpresa` AS `poblaEmpresa`, `empresa`.`cpEmpresa` AS `cpEmpresa`, `empresa`.`provEmpresa` AS `provEmpresa`, `empresa`.`paisEmpresa` AS `paisEmpresa`, `empresa`.`webEmpresa` AS `webEmpresa`, `empresa`.`tlfEmpresa` AS `tlfEmpresa`, `empresa`.`emailEmpresa` AS `emailEmpresa`, `empresa`.`nifEmpresa` AS `nifEmpresa`, `empresa`.`regEmpresa` AS `regEmpresa`, `empresa`.`numFacturaPro` AS `numFacturaPro`, `empresa`.`numFactura` AS `numFactura`, `empresa`.`numFacturaNeg` AS `numFacturaNeg`, `empresa`.`prefijoPro` AS `prefijoPro`, `empresa`.`prefijoFact` AS `prefijoFact`, `empresa`.`idEmpresa_config` AS `idEmpresa_config`, `tm_config`.`idConfig` AS `idConfig`, `tm_config`.`nombreEmpresa` AS `nombreEmpresa`, `tm_config`.`logotipoDark` AS `logotipoDark`, `tm_config`.`faviconDark` AS `faviconDark`, `tm_config`.`logotipoWhite` AS `logotipoWhite`, `tm_config`.`faviconWhite` AS `faviconWhite`, `tm_config`.`footerEmpresa` AS `footerEmpresa`, `tm_config`.`mostrarSancion` AS `mostrarSancion`, `tm_config`.`mostrarMeses` AS `mostrarMeses`, `tm_config`.`mostrarQuincenas` AS `mostrarQuincenas`, `tm_config`.`mostrarTrimestral` AS `mostrarTrimestral`, `tm_config`.`mostrarContPrecinto` AS `mostrarContPrecinto`, `tm_config`.`redsys` AS `redsys`, `tm_config`.`paypal` AS `paypal`, `tm_config`.`bizum` AS `bizum`, `tm_config`.`tipoPresupusto` AS `tipoPresupusto`, `tm_config`.`colorPrincipal` AS `colorPrincipal`, `tm_config`.`api_key` AS `api_key`, `tm_config`.`api_propietario` AS `api_propietario`, `tm_config`.`idEmpresa_empresa` AS `idEmpresa_empresa`, `tm_config`.`cliente_gesdoc` AS `cliente_gesdoc`, `tm_config`.`departamento_gesdoc` AS `departamento_gesdoc`, `tm_config`.`smtp_host` AS `smtp_host`, `tm_config`.`snto_auth` AS `snto_auth`, `tm_config`.`smtp_username` AS `smtp_username`, `tm_config`.`smtp_pass` AS `smtp_pass`, `tm_config`.`smtp_port` AS `smtp_port`, `tm_config`.`smtp_receptor` AS `smtp_receptor`, `tm_config`.`version_efeuno` AS `version_efeuno` FROM (`empresa` left join `tm_config` on((`empresa`.`idEmpresa_config` = `tm_config`.`idConfig`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_tarifa_iva`
--
DROP TABLE IF EXISTS `view_tarifa_iva`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newcosta`@`%` SQL SECURITY DEFINER VIEW `view_tarifa_iva`  AS SELECT `tm_tarifa`.`idTarifa` AS `idTarifa`, `tm_tarifa`.`idIva_tarifa` AS `idIva_tarifa`, `tm_tarifa`.`idDepartament_tarifa` AS `idDepartament_tarifa`, `tm_tarifa`.`cod_tarifa` AS `cod_tarifa`, `tm_tarifa`.`nombre_tarifa` AS `nombre_tarifa`, `tm_tarifa`.`unidades_tarifa` AS `unidades_tarifa`, `tm_tarifa`.`unidad_tarifa` AS `unidad_tarifa`, `tm_tarifa`.`precio_tarifa` AS `precio_tarifa`, `tm_tarifa`.`cuenta1_tarifa` AS `cuenta1_tarifa`, `tm_tarifa`.`cuenta2_tarifa` AS `cuenta2_tarifa`, `tm_tarifa`.`cuenta3_tarifa` AS `cuenta3_tarifa`, `tm_tarifa`.`tipo_tarifa` AS `tipo_tarifa`, `tm_tarifa`.`descuento_tarifa` AS `descuento_tarifa`, `tm_tarifa`.`descripcion_tarifa` AS `descripcion_tarifa`, `tm_tarifa`.`estTarifa` AS `estTarifa`, `tm_tarifa`.`iva_tarifa` AS `iva_tarifa`, `tm_iva`.`idIva` AS `idIva`, `tm_iva`.`valorIva` AS `valorIva`, `tm_iva`.`descrIva` AS `descrIva`, `tm_iva`.`fechAlta_iva` AS `fechAlta_iva`, `tm_iva`.`fechModi_iva` AS `fechModi_iva`, `tm_iva`.`fechBaja_iva` AS `fechBaja_iva`, `tm_iva`.`estIva` AS `estIva` FROM (`tm_tarifa` left join `tm_iva` on((`tm_tarifa`.`idIva_tarifa` = `tm_iva`.`idIva`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_alumnos_actividad`
--
DROP TABLE IF EXISTS `vista_alumnos_actividad`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newcosta`@`%` SQL SECURITY DEFINER VIEW `vista_alumnos_actividad`  AS SELECT `ua`.`idUsuarioAct` AS `idUsuarioAct`, `ua`.`idLlegada_UsuarioAct` AS `idLlegada_UsuarioAct`, `ua`.`idUsuario_UsuarioAct` AS `idUsuario_UsuarioAct`, `ua`.`idAct_UsuarioAct` AS `idAct_UsuarioAct`, `ua`.`asisUsuarioAct` AS `asisUsuarioAct`, `ua`.`fecAltaUsuarioAct` AS `fecAltaUsuarioAct`, `ua`.`estUsuarioAct` AS `estUsuarioAct`, `al`.`idAlumno` AS `idAlumno`, `al`.`nomUsuario` AS `nomUsuario`, `al`.`emailUsuario` AS `emailUsuario`, `al`.`senaUsuario` AS `senaUsuario`, `al`.`fecAltaUsuario` AS `fecAltaUsuario`, `al`.`fecBajaUsuario` AS `fecBajaUsuario`, `al`.`fecModiUsuario` AS `fecModiUsuario`, `al`.`avatarUsuario` AS `avatarUsuario`, `al`.`estUsu` AS `estUsu`, `al`.`nomAlumno` AS `nomAlumno`, `al`.`apeAlumno` AS `apeAlumno`, `al`.`fecNacAlumno` AS `fecNacAlumno`, `al`.`nacioAlumno` AS `nacioAlumno`, `al`.`ProfeEstuAlumno` AS `ProfeEstuAlumno`, `al`.`EmpresaAlumno` AS `EmpresaAlumno`, `al`.`UniAlumno` AS `UniAlumno`, `al`.`teleAlumno` AS `teleAlumno`, `al`.`domValAlumno` AS `domValAlumno`, `al`.`domOrigenAlumno` AS `domOrigenAlumno`, `al`.`lenMatAlumno` AS `lenMatAlumno`, `al`.`lenCon1Alumno` AS `lenCon1Alumno`, `al`.`lenCon2Alumno` AS `lenCon2Alumno`, `al`.`lenCon3Alumno` AS `lenCon3Alumno`, `al`.`lenCon4Alumno` AS `lenCon4Alumno`, `al`.`estEspAlumno` AS `estEspAlumno`, `al`.`nivEspAlumno` AS `nivEspAlumno`, `al`.`tiemEspAlumno` AS `tiemEspAlumno`, `al`.`lugEspAlumno` AS `lugEspAlumno`, `al`.`porEspAlumno` AS `porEspAlumno`, `al`.`mejEspAlumno` AS `mejEspAlumno`, `al`.`aprEspAlumno` AS `aprEspAlumno`, `al`.`act1Alumno` AS `act1Alumno`, `al`.`act2Alumno` AS `act2Alumno`, `al`.`act3Alumno` AS `act3Alumno`, `al`.`act4Alumno` AS `act4Alumno`, `al`.`act5Alumno` AS `act5Alumno`, `al`.`act6Alumno` AS `act6Alumno`, `al`.`act7Alumno` AS `act7Alumno`, `al`.`gustaTraAlumno` AS `gustaTraAlumno`, `al`.`gus1EspAlumno` AS `gus1EspAlumno`, `al`.`gus2EspAlumno` AS `gus2EspAlumno`, `al`.`gus3EspAlumno` AS `gus3EspAlumno`, `al`.`gus4EspAlumno` AS `gus4EspAlumno`, `al`.`gus5EspAlumno` AS `gus5EspAlumno`, `al`.`gusTextEspAlumno` AS `gusTextEspAlumno`, `al`.`conAlumno` AS `conAlumno`, `al`.`conRecoAlumno` AS `conRecoAlumno`, `al`.`conAgenAlumno` AS `conAgenAlumno`, `al`.`actSocialesAlumno` AS `actSocialesAlumno`, `al`.`actCultAlumno` AS `actCultAlumno`, `al`.`actGastroAlumno` AS `actGastroAlumno`, `al`.`actDepoAlumno` AS `actDepoAlumno`, `al`.`partActAlumno` AS `partActAlumno`, `al`.`numActAlumno` AS `numActAlumno`, `al`.`UltimaSesion` AS `UltimaSesion`, `al`.`tokenUsu` AS `tokenUsu`, `al`.`identificadorPersonal` AS `identificadorPersonal`, `al`.`perfilBloqueado` AS `perfilBloqueado`, `al`.`idInscripcion_tmAlumno` AS `idInscripcion_tmAlumno`, `al`.`idUsuario_tmalumno` AS `idUsuario_tmalumno`, `act`.`idAct` AS `idAct`, `act`.`descrAct` AS `descrAct`, `act`.`obsAct` AS `obsAct`, `act`.`fecActDesde` AS `fecActDesde`, `act`.`fecActHasta` AS `fecActHasta`, `act`.`fecActFinSolicitud` AS `fecActFinSolicitud`, `act`.`estadoAct` AS `estadoAct`, `act`.`horaInicioAct` AS `horaInicioAct`, `act`.`horaFinAct` AS `horaFinAct`, `act`.`horasLectivasAct` AS `horasLectivasAct`, `act`.`imgAct` AS `imgAct`, `act`.`fecAltaAct` AS `fecAltaAct`, `act`.`fecBajaAct` AS `fecBajaAct`, `act`.`fecModiAct` AS `fecModiAct`, `act`.`puntoEncuentroAct` AS `puntoEncuentroAct`, `act`.`idPersonal_guiaAct` AS `idPersonal_guiaAct`, `act`.`minAlumAct` AS `minAlumAct`, `act`.`maxAlumAct` AS `maxAlumAct`, group_concat(distinct `dd`.`idDepartamento_actividadDepartamento` separator ',') AS `idsDepartamentos` FROM (((`td_usuarioact_edu` `ua` left join `tm_alumno_edu` `al` on((`ua`.`idUsuario_UsuarioAct` = `al`.`idUsuario_tmalumno`))) left join `tm_actividad_edu` `act` on((`ua`.`idAct_UsuarioAct` = `act`.`idAct`))) left join `td_actividadDepartamento` `dd` on((`act`.`idAct` = `dd`.`idActividad_actividadDepartamento`))) GROUP BY `ua`.`idUsuarioAct`, `ua`.`idUsuario_UsuarioAct`, `ua`.`idAct_UsuarioAct`, `ua`.`asisUsuarioAct`, `ua`.`fecAltaUsuarioAct`, `ua`.`estUsuarioAct`, `al`.`idAlumno`, `al`.`nomUsuario`, `al`.`emailUsuario`, `al`.`senaUsuario`, `al`.`fecAltaUsuario`, `al`.`fecBajaUsuario`, `al`.`fecModiUsuario`, `al`.`avatarUsuario`, `al`.`estUsu`, `al`.`nomAlumno`, `al`.`apeAlumno`, `al`.`fecNacAlumno`, `al`.`nacioAlumno`, `al`.`ProfeEstuAlumno`, `al`.`EmpresaAlumno`, `al`.`UniAlumno`, `al`.`teleAlumno`, `al`.`domValAlumno`, `al`.`domOrigenAlumno`, `al`.`lenMatAlumno`, `al`.`lenCon1Alumno`, `al`.`lenCon2Alumno`, `al`.`lenCon3Alumno`, `al`.`lenCon4Alumno`, `al`.`estEspAlumno`, `al`.`nivEspAlumno`, `al`.`tiemEspAlumno`, `al`.`lugEspAlumno`, `al`.`porEspAlumno`, `al`.`mejEspAlumno`, `al`.`aprEspAlumno`, `al`.`act1Alumno`, `al`.`act2Alumno`, `al`.`act3Alumno`, `al`.`act4Alumno`, `al`.`act5Alumno`, `al`.`act6Alumno`, `al`.`act7Alumno`, `al`.`gustaTraAlumno`, `al`.`gus1EspAlumno`, `al`.`gus2EspAlumno`, `al`.`gus3EspAlumno`, `al`.`gus4EspAlumno`, `al`.`gus5EspAlumno`, `al`.`gusTextEspAlumno`, `al`.`conAlumno`, `al`.`conRecoAlumno`, `al`.`conAgenAlumno`, `al`.`actSocialesAlumno`, `al`.`actCultAlumno`, `al`.`actGastroAlumno`, `al`.`actDepoAlumno`, `al`.`partActAlumno`, `al`.`numActAlumno`, `al`.`UltimaSesion`, `al`.`tokenUsu`, `al`.`identificadorPersonal`, `al`.`perfilBloqueado`, `al`.`idInscripcion_tmAlumno`, `al`.`idUsuario_tmalumno`, `act`.`idAct`, `act`.`descrAct`, `act`.`obsAct`, `act`.`fecActDesde`, `act`.`fecActHasta`, `act`.`fecActFinSolicitud`, `act`.`estadoAct`, `act`.`horaInicioAct`, `act`.`horaFinAct`, `act`.`horasLectivasAct`, `act`.`imgAct`, `act`.`fecAltaAct`, `act`.`fecBajaAct`, `act`.`fecModiAct`, `act`.`puntoEncuentroAct`, `act`.`idPersonal_guiaAct`, `act`.`minAlumAct`, `act`.`maxAlumAct` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacionAulasGrupo`
--
ALTER TABLE `asignacionAulasGrupo`
  ADD PRIMARY KEY (`idAsignacion`);

--
-- Indices de la tabla `asignacionProfesorGrupo`
--
ALTER TABLE `asignacionProfesorGrupo`
  ADD PRIMARY KEY (`idAsignacionProfe`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`idasistencia`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idCurso`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `evaluacionFinal`
--
ALTER TABLE `evaluacionFinal`
  ADD PRIMARY KEY (`idEvaluacionFinal`);

--
-- Indices de la tabla `factura_cabecera`
--
ALTER TABLE `factura_cabecera`
  ADD PRIMARY KEY (`idCabecera`);

--
-- Indices de la tabla `factura_cabecera_real`
--
ALTER TABLE `factura_cabecera_real`
  ADD PRIMARY KEY (`idCabecera`);

--
-- Indices de la tabla `factura_contenido`
--
ALTER TABLE `factura_contenido`
  ADD PRIMARY KEY (`idContenidoFactura`);

--
-- Indices de la tabla `factura_contenido_real`
--
ALTER TABLE `factura_contenido_real`
  ADD PRIMARY KEY (`idContenidoFactura`);

--
-- Indices de la tabla `factura_pie`
--
ALTER TABLE `factura_pie`
  ADD PRIMARY KEY (`idPie`);

--
-- Indices de la tabla `factura_pie_real`
--
ALTER TABLE `factura_pie_real`
  ADD PRIMARY KEY (`idPie`);

--
-- Indices de la tabla `listaDiariaClase`
--
ALTER TABLE `listaDiariaClase`
  ADD PRIMARY KEY (`idLista`);

--
-- Indices de la tabla `rutasPersonal`
--
ALTER TABLE `rutasPersonal`
  ADD PRIMARY KEY (`idRutasProfesorado`);

--
-- Indices de la tabla `tareasDiariaClase`
--
ALTER TABLE `tareasDiariaClase`
  ADD PRIMARY KEY (`idTareasDiaria`);

--
-- Indices de la tabla `td_actividadDepartamento`
--
ALTER TABLE `td_actividadDepartamento`
  ADD PRIMARY KEY (`idActividadDepartamento`),
  ADD KEY `FK_actividadDepar_actividad_idx` (`idActividad_actividadDepartamento`),
  ADD KEY `FK_actividadDepar_departam_idx` (`idDepartamento_actividadDepartamento`);

--
-- Indices de la tabla `td_alumaloja`
--
ALTER TABLE `td_alumaloja`
  ADD PRIMARY KEY (`idAlumAloja`);

--
-- Indices de la tabla `td_persocontrato`
--
ALTER TABLE `td_persocontrato`
  ADD PRIMARY KEY (`idPersoContrato`),
  ADD KEY `FK_persoContrato_personal_idx` (`idpersonal_PersoContrato`);

--
-- Indices de la tabla `td_usuarioact_edu`
--
ALTER TABLE `td_usuarioact_edu`
  ADD PRIMARY KEY (`idUsuarioAct`),
  ADD KEY `FK_usuario_idx` (`idUsuario_UsuarioAct`);

--
-- Indices de la tabla `testdeniveledu`
--
ALTER TABLE `testdeniveledu`
  ADD PRIMARY KEY (`idTestNivel`);

--
-- Indices de la tabla `tm_actividad_edu`
--
ALTER TABLE `tm_actividad_edu`
  ADD PRIMARY KEY (`idAct`);

--
-- Indices de la tabla `tm_agentes_edu`
--
ALTER TABLE `tm_agentes_edu`
  ADD PRIMARY KEY (`idAgente`);

--
-- Indices de la tabla `tm_albaran`
--
ALTER TABLE `tm_albaran`
  ADD PRIMARY KEY (`idAlbaran`);

--
-- Indices de la tabla `tm_aloja`
--
ALTER TABLE `tm_aloja`
  ADD PRIMARY KEY (`idAloja`);

--
-- Indices de la tabla `tm_alojamientosllegadas_edu`
--
ALTER TABLE `tm_alojamientosllegadas_edu`
  ADD PRIMARY KEY (`idAlojamientoLlegada`),
  ADD KEY `FK_alojaLlegadas_idx` (`idLlegada_alojamientos`);

--
-- Indices de la tabla `tm_alojaopis`
--
ALTER TABLE `tm_alojaopis`
  ADD PRIMARY KEY (`idOpi`);

--
-- Indices de la tabla `tm_alojavis`
--
ALTER TABLE `tm_alojavis`
  ADD PRIMARY KEY (`IdAlojaVis`);

--
-- Indices de la tabla `tm_alumno_edu`
--
ALTER TABLE `tm_alumno_edu`
  ADD PRIMARY KEY (`idAlumno`);

--
-- Indices de la tabla `tm_aulas`
--
ALTER TABLE `tm_aulas`
  ADD PRIMARY KEY (`idAula`);

--
-- Indices de la tabla `tm_bildungsurlaub_edu`
--
ALTER TABLE `tm_bildungsurlaub_edu`
  ADD PRIMARY KEY (`idBildun`);

--
-- Indices de la tabla `tm_config`
--
ALTER TABLE `tm_config`
  ADD PRIMARY KEY (`idConfig`);

--
-- Indices de la tabla `tm_conocimientos`
--
ALTER TABLE `tm_conocimientos`
  ADD PRIMARY KEY (`idConocimiento`);

--
-- Indices de la tabla `tm_contenido`
--
ALTER TABLE `tm_contenido`
  ADD PRIMARY KEY (`idContenido`),
  ADD UNIQUE KEY `idContenido` (`idContenido`);

--
-- Indices de la tabla `tm_departamento_edu`
--
ALTER TABLE `tm_departamento_edu`
  ADD PRIMARY KEY (`idDepartamentoEdu`);

--
-- Indices de la tabla `tm_erasmus_edu`
--
ALTER TABLE `tm_erasmus_edu`
  ADD PRIMARY KEY (`idErasmus`);

--
-- Indices de la tabla `tm_grupos`
--
ALTER TABLE `tm_grupos`
  ADD PRIMARY KEY (`idGrupo`);

--
-- Indices de la tabla `tm_horarioGrupo`
--
ALTER TABLE `tm_horarioGrupo`
  ADD PRIMARY KEY (`idHorario`);

--
-- Indices de la tabla `tm_idioma`
--
ALTER TABLE `tm_idioma`
  ADD PRIMARY KEY (`idIdioma`);

--
-- Indices de la tabla `tm_iva`
--
ALTER TABLE `tm_iva`
  ADD PRIMARY KEY (`idIva`);

--
-- Indices de la tabla `tm_llegadas_edu`
--
ALTER TABLE `tm_llegadas_edu`
  ADD PRIMARY KEY (`id_llegada`),
  ADD KEY `FK_llegadas_edu_departamento_edu_idx` (`iddepartamento_llegadas`),
  ADD KEY `FK_llegadas_edu_prescriptores_idx` (`idprescriptor_llegadas`);

--
-- Indices de la tabla `tm_matriculacionllegadas_edu`
--
ALTER TABLE `tm_matriculacionllegadas_edu`
  ADD PRIMARY KEY (`idMatriculacionLlegada`,`idLlegada_matriculacion`),
  ADD KEY `FK_matriculacionllegadas_edu_llegadas_edur_idx` (`idLlegada_matriculacion`);

--
-- Indices de la tabla `tm_medidaaloja`
--
ALTER TABLE `tm_medidaaloja`
  ADD PRIMARY KEY (`idMedidaAloja`);

--
-- Indices de la tabla `tm_mediopago`
--
ALTER TABLE `tm_mediopago`
  ADD PRIMARY KEY (`idMedioPago`);

--
-- Indices de la tabla `tm_nivel`
--
ALTER TABLE `tm_nivel`
  ADD PRIMARY KEY (`idNivel`);

--
-- Indices de la tabla `tm_nivelesllegadas_edu`
--
ALTER TABLE `tm_nivelesllegadas_edu`
  ADD PRIMARY KEY (`idNivelesLlegadas`);

--
-- Indices de la tabla `tm_objetivos`
--
ALTER TABLE `tm_objetivos`
  ADD PRIMARY KEY (`idObjetivo`);

--
-- Indices de la tabla `tm_pagoanticipadollegadas_edu`
--
ALTER TABLE `tm_pagoanticipadollegadas_edu`
  ADD PRIMARY KEY (`idPagoAnticipado`);

--
-- Indices de la tabla `tm_personal`
--
ALTER TABLE `tm_personal`
  ADD PRIMARY KEY (`idPersonal`);

--
-- Indices de la tabla `tm_prescriptores`
--
ALTER TABLE `tm_prescriptores`
  ADD PRIMARY KEY (`idPrescripcion`);

--
-- Indices de la tabla `tm_ruta`
--
ALTER TABLE `tm_ruta`
  ADD PRIMARY KEY (`id_ruta`),
  ADD KEY `FK_tipocurso_idx` (`tipoId_ruta`),
  ADD KEY `FK_nivel_idx` (`nivelId_ruta`),
  ADD KEY `FK_idioma_idx` (`idiomaId_ruta`);

--
-- Indices de la tabla `tm_suplidosLlegadas_edu`
--
ALTER TABLE `tm_suplidosLlegadas_edu`
  ADD PRIMARY KEY (`idSuplido`);

--
-- Indices de la tabla `tm_suscripcion`
--
ALTER TABLE `tm_suscripcion`
  ADD PRIMARY KEY (`idSuscripcion`);

--
-- Indices de la tabla `tm_tarifa`
--
ALTER TABLE `tm_tarifa`
  ADD PRIMARY KEY (`idTarifa`);

--
-- Indices de la tabla `tm_tipocontrato`
--
ALTER TABLE `tm_tipocontrato`
  ADD PRIMARY KEY (`idTipoContrato`);

--
-- Indices de la tabla `tm_tipocurso`
--
ALTER TABLE `tm_tipocurso`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `tm_tipoidentificativo_edu`
--
ALTER TABLE `tm_tipoidentificativo_edu`
  ADD PRIMARY KEY (`idTipoIdentificativo`);

--
-- Indices de la tabla `tm_tiposaloja`
--
ALTER TABLE `tm_tiposaloja`
  ADD PRIMARY KEY (`idTiposAloja`);

--
-- Indices de la tabla `tm_titulares_contenido`
--
ALTER TABLE `tm_titulares_contenido`
  ADD PRIMARY KEY (`idTitContenido`);

--
-- Indices de la tabla `tm_titulares_objetivos`
--
ALTER TABLE `tm_titulares_objetivos`
  ADD PRIMARY KEY (`idTitObjetivo`);

--
-- Indices de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  ADD PRIMARY KEY (`idUsu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacionAulasGrupo`
--
ALTER TABLE `asignacionAulasGrupo`
  MODIFY `idAsignacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignacionProfesorGrupo`
--
ALTER TABLE `asignacionProfesorGrupo`
  MODIFY `idAsignacionProfe` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `idasistencia` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idCurso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `evaluacionFinal`
--
ALTER TABLE `evaluacionFinal`
  MODIFY `idEvaluacionFinal` int NOT NULL AUTO_INCREMENT COMMENT 'Tabla encargada de los alumnos finalziados ', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura_cabecera`
--
ALTER TABLE `factura_cabecera`
  MODIFY `idCabecera` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `factura_cabecera_real`
--
ALTER TABLE `factura_cabecera_real`
  MODIFY `idCabecera` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `factura_contenido`
--
ALTER TABLE `factura_contenido`
  MODIFY `idContenidoFactura` int NOT NULL AUTO_INCREMENT COMMENT 'El contenido es lo que se factura', AUTO_INCREMENT=433;

--
-- AUTO_INCREMENT de la tabla `factura_contenido_real`
--
ALTER TABLE `factura_contenido_real`
  MODIFY `idContenidoFactura` int NOT NULL AUTO_INCREMENT COMMENT 'El contenido es lo que se factura', AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT de la tabla `factura_pie`
--
ALTER TABLE `factura_pie`
  MODIFY `idPie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `factura_pie_real`
--
ALTER TABLE `factura_pie_real`
  MODIFY `idPie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `listaDiariaClase`
--
ALTER TABLE `listaDiariaClase`
  MODIFY `idLista` int NOT NULL AUTO_INCREMENT COMMENT 'ID de la lista a gestionar', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rutasPersonal`
--
ALTER TABLE `rutasPersonal`
  MODIFY `idRutasProfesorado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tareasDiariaClase`
--
ALTER TABLE `tareasDiariaClase`
  MODIFY `idTareasDiaria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `td_actividadDepartamento`
--
ALTER TABLE `td_actividadDepartamento`
  MODIFY `idActividadDepartamento` int NOT NULL AUTO_INCREMENT COMMENT 'Tabla de los departamentos que tiene una actividad', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `td_alumaloja`
--
ALTER TABLE `td_alumaloja`
  MODIFY `idAlumAloja` int NOT NULL AUTO_INCREMENT COMMENT 'Es el id de la tabla', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `td_persocontrato`
--
ALTER TABLE `td_persocontrato`
  MODIFY `idPersoContrato` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `td_usuarioact_edu`
--
ALTER TABLE `td_usuarioact_edu`
  MODIFY `idUsuarioAct` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `testdeniveledu`
--
ALTER TABLE `testdeniveledu`
  MODIFY `idTestNivel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tm_actividad_edu`
--
ALTER TABLE `tm_actividad_edu`
  MODIFY `idAct` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tm_agentes_edu`
--
ALTER TABLE `tm_agentes_edu`
  MODIFY `idAgente` int NOT NULL AUTO_INCREMENT COMMENT 'El encargado de responsable de un grupo de alumnos', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tm_albaran`
--
ALTER TABLE `tm_albaran`
  MODIFY `idAlbaran` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_aloja`
--
ALTER TABLE `tm_aloja`
  MODIFY `idAloja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tm_alojamientosllegadas_edu`
--
ALTER TABLE `tm_alojamientosllegadas_edu`
  MODIFY `idAlojamientoLlegada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tm_alojaopis`
--
ALTER TABLE `tm_alojaopis`
  MODIFY `idOpi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tm_alojavis`
--
ALTER TABLE `tm_alojavis`
  MODIFY `IdAlojaVis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tm_alumno_edu`
--
ALTER TABLE `tm_alumno_edu`
  MODIFY `idAlumno` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tm_aulas`
--
ALTER TABLE `tm_aulas`
  MODIFY `idAula` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tm_bildungsurlaub_edu`
--
ALTER TABLE `tm_bildungsurlaub_edu`
  MODIFY `idBildun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tm_config`
--
ALTER TABLE `tm_config`
  MODIFY `idConfig` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tm_conocimientos`
--
ALTER TABLE `tm_conocimientos`
  MODIFY `idConocimiento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tm_contenido`
--
ALTER TABLE `tm_contenido`
  MODIFY `idContenido` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_departamento_edu`
--
ALTER TABLE `tm_departamento_edu`
  MODIFY `idDepartamentoEdu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tm_erasmus_edu`
--
ALTER TABLE `tm_erasmus_edu`
  MODIFY `idErasmus` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_grupos`
--
ALTER TABLE `tm_grupos`
  MODIFY `idGrupo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_horarioGrupo`
--
ALTER TABLE `tm_horarioGrupo`
  MODIFY `idHorario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tm_idioma`
--
ALTER TABLE `tm_idioma`
  MODIFY `idIdioma` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tm_iva`
--
ALTER TABLE `tm_iva`
  MODIFY `idIva` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tm_llegadas_edu`
--
ALTER TABLE `tm_llegadas_edu`
  MODIFY `id_llegada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `tm_matriculacionllegadas_edu`
--
ALTER TABLE `tm_matriculacionllegadas_edu`
  MODIFY `idMatriculacionLlegada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `tm_medidaaloja`
--
ALTER TABLE `tm_medidaaloja`
  MODIFY `idMedidaAloja` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_mediopago`
--
ALTER TABLE `tm_mediopago`
  MODIFY `idMedioPago` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tm_nivel`
--
ALTER TABLE `tm_nivel`
  MODIFY `idNivel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tm_nivelesllegadas_edu`
--
ALTER TABLE `tm_nivelesllegadas_edu`
  MODIFY `idNivelesLlegadas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_objetivos`
--
ALTER TABLE `tm_objetivos`
  MODIFY `idObjetivo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_pagoanticipadollegadas_edu`
--
ALTER TABLE `tm_pagoanticipadollegadas_edu`
  MODIFY `idPagoAnticipado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tm_personal`
--
ALTER TABLE `tm_personal`
  MODIFY `idPersonal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT de la tabla `tm_prescriptores`
--
ALTER TABLE `tm_prescriptores`
  MODIFY `idPrescripcion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tm_ruta`
--
ALTER TABLE `tm_ruta`
  MODIFY `id_ruta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_suplidosLlegadas_edu`
--
ALTER TABLE `tm_suplidosLlegadas_edu`
  MODIFY `idSuplido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tm_suscripcion`
--
ALTER TABLE `tm_suscripcion`
  MODIFY `idSuscripcion` int NOT NULL AUTO_INCREMENT COMMENT 'Suscripcion nueva. Será para cada suscripcion pagada.', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tm_tarifa`
--
ALTER TABLE `tm_tarifa`
  MODIFY `idTarifa` int NOT NULL AUTO_INCREMENT COMMENT 'id tarifa', AUTO_INCREMENT=1399;

--
-- AUTO_INCREMENT de la tabla `tm_tipocontrato`
--
ALTER TABLE `tm_tipocontrato`
  MODIFY `idTipoContrato` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_tipocurso`
--
ALTER TABLE `tm_tipocurso`
  MODIFY `idTipo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tm_tipoidentificativo_edu`
--
ALTER TABLE `tm_tipoidentificativo_edu`
  MODIFY `idTipoIdentificativo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tm_tiposaloja`
--
ALTER TABLE `tm_tiposaloja`
  MODIFY `idTiposAloja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tm_titulares_contenido`
--
ALTER TABLE `tm_titulares_contenido`
  MODIFY `idTitContenido` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_titulares_objetivos`
--
ALTER TABLE `tm_titulares_objetivos`
  MODIFY `idTitObjetivo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  MODIFY `idUsu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `td_actividadDepartamento`
--
ALTER TABLE `td_actividadDepartamento`
  ADD CONSTRAINT `FK_actividadDepar_departam` FOREIGN KEY (`idDepartamento_actividadDepartamento`) REFERENCES `tm_departamento_edu` (`idDepartamentoEdu`);

--
-- Filtros para la tabla `td_usuarioact_edu`
--
ALTER TABLE `td_usuarioact_edu`
  ADD CONSTRAINT `FK_usuario` FOREIGN KEY (`idUsuario_UsuarioAct`) REFERENCES `tm_usuario` (`idUsu`);

--
-- Filtros para la tabla `tm_alojamientosllegadas_edu`
--
ALTER TABLE `tm_alojamientosllegadas_edu`
  ADD CONSTRAINT `FK_alojaLlegadas` FOREIGN KEY (`idLlegada_alojamientos`) REFERENCES `tm_llegadas_edu` (`id_llegada`);

--
-- Filtros para la tabla `tm_llegadas_edu`
--
ALTER TABLE `tm_llegadas_edu`
  ADD CONSTRAINT `FK_llegadas_edu_departamento_edu` FOREIGN KEY (`iddepartamento_llegadas`) REFERENCES `tm_departamento_edu` (`idDepartamentoEdu`),
  ADD CONSTRAINT `FK_llegadas_edu_prescriptores` FOREIGN KEY (`idprescriptor_llegadas`) REFERENCES `tm_prescriptores` (`idPrescripcion`);

--
-- Filtros para la tabla `tm_matriculacionllegadas_edu`
--
ALTER TABLE `tm_matriculacionllegadas_edu`
  ADD CONSTRAINT `FK_matriculacionllegadas_edu_llegadas_edur` FOREIGN KEY (`idLlegada_matriculacion`) REFERENCES `tm_llegadas_edu` (`id_llegada`);

--
-- Filtros para la tabla `tm_ruta`
--
ALTER TABLE `tm_ruta`
  ADD CONSTRAINT `FK_idioma` FOREIGN KEY (`idiomaId_ruta`) REFERENCES `tm_idioma` (`idIdioma`),
  ADD CONSTRAINT `FK_nivel` FOREIGN KEY (`nivelId_ruta`) REFERENCES `tm_nivel` (`idNivel`),
  ADD CONSTRAINT `FK_tipocurso` FOREIGN KEY (`tipoId_ruta`) REFERENCES `tm_tipocurso` (`idTipo`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`%` EVENT `actualizar_estLlegada_evento_08_00` ON SCHEDULE EVERY 1 DAY STARTS '2025-02-05 08:00:00' ON COMPLETION NOT PRESERVE ENABLE DO # POR SI HACE FALTA METER MAS DE UNA LINEA
 BEGIN
    CALL actualizar_estMatricula();
    CALL actualizar_estLlegada_matriculacion();
    
    CALL actualizar_estAlojamiento();
    CALL actualizar_estLlegada_alojamiento();
    
    CALL actualizar_estado_actividad();
    CALL actualizar_estado_actividades();
 END$$

CREATE DEFINER=`root`@`%` EVENT `actualizar_estLlegada_evento_12_01` ON SCHEDULE EVERY 1 DAY STARTS '2025-02-05 00:01:00' ON COMPLETION NOT PRESERVE ENABLE DO # POR SI HACE FALTA METER MAS DE UNA LINEA
 BEGIN
    CALL actualizar_estMatricula();
    CALL actualizar_estLlegada_matriculacion();
    
    CALL actualizar_estAlojamiento();
    CALL actualizar_estLlegada_alojamiento();
    
    CALL actualizar_estado_actividad();
    CALL actualizar_estado_actividades();
 END$$

CREATE DEFINER=`root`@`%` EVENT `actualizar_estLlegada_evento_16_00` ON SCHEDULE EVERY 1 DAY STARTS '2025-02-05 16:00:00' ON COMPLETION NOT PRESERVE ENABLE DO # POR SI HACE FALTA METER MAS DE UNA LINEA
 BEGIN
    CALL actualizar_estMatricula();
    CALL actualizar_estLlegada_matriculacion();
    
    CALL actualizar_estAlojamiento();
    CALL actualizar_estLlegada_alojamiento();
    
    CALL actualizar_estado_actividad();
    CALL actualizar_estado_actividades();
 END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

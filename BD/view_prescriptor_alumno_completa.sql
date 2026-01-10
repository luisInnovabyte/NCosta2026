-- =====================================================
-- Vista: view_prescriptor_alumno_completa
-- Descripción: Vista que relaciona las tablas tm_prescriptores y tm_alumno_edu
-- con todos sus campos para obtener información completa de prescriptores y alumnos
-- =====================================================
-- Fecha de creación: 2026-01-10
-- Relación: tm_prescriptores.idPrescripcion = tm_alumno_edu.idInscripcion_tmAlumno
-- 
-- CONCEPTO:
-- - PRESCRIPTOR: Persona interesada que solo se ha informado (aún no ha concretado)
-- - ALUMNO: Prescriptor que se ha dado de alta en una llegada (ha materializado su interés)
-- =====================================================

CREATE OR REPLACE VIEW view_prescriptor_alumno_completa AS
SELECT 
    -- Campos de tm_prescriptores (prefijo 'p_')
    p.idPrescripcion AS p_idPrescripcion,
    p.nomPrescripcion AS p_nomPrescripcion,
    p.apePrescripcion AS p_apePrescripcion,
    p.sexoPrescripcion AS p_sexoPrescripcion,
    p.fecNacPrescripcion AS p_fecNacPrescripcion,
    p.anoPrevistoPrescripcion AS p_anoPrevistoPrescripcion,
    p.emailCasaPrescripcion AS p_emailCasaPrescripcion,
    p.emailAltPrescripcion AS p_emailAltPrescripcion,
    p.fechContactoPrescripcion AS p_fechContactoPrescripcion,
    p.dirCasaPrescripcion AS p_dirCasaPrescripcion,
    p.dirAltPrescripcion AS p_dirAltPrescripcion,
    p.cursoPrescripcion AS p_cursoPrescripcion,
    p.cpCasaPrescripcion AS p_cpCasaPrescripcion,
    p.cpAltPrescripcion AS p_cpAltPrescripcion,
    p.cono1Prescripcion AS p_cono1Prescripcion,
    p.ciudadCasaPrescripcion AS p_ciudadCasaPrescripcion,
    p.ciudadAltPrescripcion AS p_ciudadAltPrescripcion,
    p.cono2Prescripcion AS p_cono2Prescripcion,
    p.paisCasaPrescripcion AS p_paisCasaPrescripcion,
    p.paisAltPrescripcion AS p_paisAltPrescripcion,
    p.cono3Prescripcion AS p_cono3Prescripcion,
    p.tefCasaPrescripcion AS p_tefCasaPrescripcion,
    p.tefAltPrescripcion AS p_tefAltPrescripcion,
    p.probablementePrescripcion AS p_probablementePrescripcion,
    p.movilCasaPrescripcion AS p_movilCasaPrescripcion,
    p.movilAltPrescripcion AS p_movilAltPrescripcion,
    p.grupoPrescripcion AS p_grupoPrescripcion,
    p.erasmusPrescripcion AS p_erasmusPrescripcion,
    p.uniOrigenPrescripcion AS p_uniOrigenPrescripcion,
    p.bildungsurlaub AS p_bildungsurlaub,
    p.auPair AS p_auPair,
    p.fechMatConfirmacion AS p_fechMatConfirmacion,
    p.matCurso AS p_matCurso,
    p.matAloja AS p_matAloja,
    p.matFechInicio AS p_matFechInicio,
    p.obsPrescriptor AS p_obsPrescriptor,
    p.estPrescripcion AS p_estPrescripcion,
    p.tokenPrescriptores AS p_tokenPrescriptores,
    p.numLlegada AS p_numLlegada,
    p.idDepartamentoEdu_prescriptores AS p_idDepartamentoEdu_prescriptores,
    p.fecPrescripcion AS p_fecPrescripcion,
    p.tipoDocumento AS p_tipoDocumento,
    p.identificadorDocumento AS p_identificadorDocumento,
    p.nombreMadrePre AS p_nombreMadrePre,
    p.nombrePadrePre AS p_nombrePadrePre,
    p.numPadrePre AS p_numPadrePre,
    p.numMadrePre AS p_numMadrePre,
    p.interesadoOnlinePre AS p_interesadoOnlinePre,
    p.nacionalidadPreinscriptor AS p_nacionalidadPreinscriptor,
    p.preferenciaHoraria AS p_preferenciaHoraria,
    
    -- Campos de tm_alumno_edu (prefijo 'a_')
    a.idAlumno AS a_idAlumno,
    a.nomUsuario AS a_nomUsuario,
    a.emailUsuario AS a_emailUsuario,
    a.senaUsuario AS a_senaUsuario,
    a.fecAltaUsuario AS a_fecAltaUsuario,
    a.fecBajaUsuario AS a_fecBajaUsuario,
    a.fecModiUsuario AS a_fecModiUsuario,
    a.avatarUsuario AS a_avatarUsuario,
    a.estUsu AS a_estUsu,
    a.nomAlumno AS a_nomAlumno,
    a.apeAlumno AS a_apeAlumno,
    a.fecNacAlumno AS a_fecNacAlumno,
    a.nacioAlumno AS a_nacioAlumno,
    a.ProfeEstuAlumno AS a_ProfeEstuAlumno,
    a.EmpresaAlumno AS a_EmpresaAlumno,
    a.UniAlumno AS a_UniAlumno,
    a.teleAlumno AS a_teleAlumno,
    a.domValAlumno AS a_domValAlumno,
    a.domOrigenAlumno AS a_domOrigenAlumno,
    a.lenMatAlumno AS a_lenMatAlumno,
    a.lenCon1Alumno AS a_lenCon1Alumno,
    a.lenCon2Alumno AS a_lenCon2Alumno,
    a.lenCon3Alumno AS a_lenCon3Alumno,
    a.lenCon4Alumno AS a_lenCon4Alumno,
    a.estEspAlumno AS a_estEspAlumno,
    a.nivEspAlumno AS a_nivEspAlumno,
    a.tiemEspAlumno AS a_tiemEspAlumno,
    a.lugEspAlumno AS a_lugEspAlumno,
    a.porEspAlumno AS a_porEspAlumno,
    a.mejEspAlumno AS a_mejEspAlumno,
    a.aprEspAlumno AS a_aprEspAlumno,
    a.act1Alumno AS a_act1Alumno,
    a.act2Alumno AS a_act2Alumno,
    a.act3Alumno AS a_act3Alumno,
    a.act4Alumno AS a_act4Alumno,
    a.act5Alumno AS a_act5Alumno,
    a.act6Alumno AS a_act6Alumno,
    a.act7Alumno AS a_act7Alumno,
    a.gustaTraAlumno AS a_gustaTraAlumno,
    a.gus1EspAlumno AS a_gus1EspAlumno,
    a.gus2EspAlumno AS a_gus2EspAlumno,
    a.gus3EspAlumno AS a_gus3EspAlumno,
    a.gus4EspAlumno AS a_gus4EspAlumno,
    a.gus5EspAlumno AS a_gus5EspAlumno,
    a.gusTextEspAlumno AS a_gusTextEspAlumno,
    a.conAlumno AS a_conAlumno,
    a.conRecoAlumno AS a_conRecoAlumno,
    a.conAgenAlumno AS a_conAgenAlumno,
    a.actSocialesAlumno AS a_actSocialesAlumno,
    a.actCultAlumno AS a_actCultAlumno,
    a.actGastroAlumno AS a_actGastroAlumno,
    a.actDepoAlumno AS a_actDepoAlumno,
    a.partActAlumno AS a_partActAlumno,
    a.numActAlumno AS a_numActAlumno,
    a.UltimaSesion AS a_UltimaSesion,
    a.tokenUsu AS a_tokenUsu,
    a.identificadorPersonal AS a_identificadorPersonal,
    a.perfilBloqueado AS a_perfilBloqueado,
    a.idInscripcion_tmAlumno AS a_idInscripcion_tmAlumno,
    a.idUsuario_tmalumno AS a_idUsuario_tmalumno,
    a.depaActivo AS a_depaActivo,
    a.depasNameActivos AS a_depasNameActivos,
    a.agoraAlumno AS a_agoraAlumno,
    a.minusvaliaAlumno AS a_minusvaliaAlumno,
    a.obsMinusvaliaAlumno AS a_obsMinusvaliaAlumno
FROM 
    tm_prescriptores p
LEFT JOIN 
    tm_alumno_edu a ON p.idPrescripcion = a.idInscripcion_tmAlumno;

-- =====================================================
-- NOTAS DE USO:
-- =====================================================
-- Esta vista proporciona una visión completa de los prescriptores (interesados)
-- y su conversión a alumnos cuando se dan de alta en una llegada.
--
-- FLUJO DE DATOS:
-- 1. Una persona interesada se registra como PRESCRIPTOR (solo información)
-- 2. Si ese prescriptor se da de alta en una llegada, se convierte en ALUMNO
-- 3. La relación se establece: idPrescripcion -> idInscripcion_tmAlumno
--
-- Los campos están prefijados con:
-- - 'p_' para los campos de tm_prescriptores (datos del interesado)
-- - 'a_' para los campos de tm_alumno_edu (datos del alumno confirmado)
--
-- Se utiliza LEFT JOIN para incluir:(interesados y convertidos):
-- SELECT * FROM view_prescriptor_alumno_completa;
--
-- 2. Obtener solo PRESCRIPTORES que NO se han convertido en alumnos (solo interesados):
-- SELECT p_nomPrescripcion, p_apePrescripcion, p_emailCasaPrescripcion
-- FROM view_prescriptor_alumno_completa
-- WHERE a_idAlumno IS NULL;
--
-- 3. Obtener solo PRESCRIPTORES que SÍ se han convertido en alumnos:
-- SELECT p_nomPrescripcion, p_apePrescripcion, a_nomAlumno, a_apeAlumno, a_emailUsuario
-- FROM view_prescriptor_alumno_completa
-- WHERE a_idAlumno IS NOT NULL;
--
-- 4. Obtener prescriptores convertidos en alumnos activos:
-- SELECT p_nomPrescripcion, p_apePrescripcion, a_nomAlumno, a_apeAlumno
-- FROM view_prescriptor_alumno_completa
-- WHERE a_idAlumno IS NOT NULL AND a_estUsu = 1;
--
-- 5. Buscar prescriptor específico y ver si se ha convertido en alumno:
-- SELECT * FROM view_prescriptor_alumno_completa
-- WHERE p_idPrescripcion = 6;
--
-- 6. Estadística de conversión (prescriptores vs alumnos):
-- SELECT 
--   COUNT(DISTINCT p_idPrescripcion) as total_prescriptores,
--   COUNT(DISTINCT a_idAlumno) as total_convertidos_alumno,
--   COUNT(DISTINCT p_idPrescripcion) - COUNT(DISTINCT a_idAlumno) as solo_interesados
-- FROM view_prescriptor_alumno_completa
--
-- 4. Contar cuántos alumnos tiene cada prescriptor:
-- SELECT p_idPrescripcion, p_nomPrescripcion, p_apePrescripcion, 
--        COUNT(a_idAlumno) as total_alumnos
-- FROM view_prescriptor_alumno_completa
-- GROUP BY p_idPrescripcion, p_nomPrescripcion, p_apePrescripcion;
--
-- =====================================================

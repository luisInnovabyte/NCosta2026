-- =====================================================
-- Vista: vista_transfer
-- Descripción: Vista para gestionar los transfers de llegadas
-- con información del alumno/prescriptor
-- =====================================================
-- Fecha de creación: 2026-01-12
-- Relación: tm_llegadas_edu -> tm_prescriptores -> tm_alumno_edu
-- =====================================================

DROP VIEW IF EXISTS vista_transfer;

CREATE VIEW vista_transfer AS
SELECT 
    -- Datos de la llegada (transfer)
    l.id_llegada,
    l.idprescriptor_llegadas,
    l.fechallegada_llegadas,
    l.horallegada_llegadas,
    l.lugarllegada_llegadas,
    l.quienrecogealumno_llegadas,
    l.grupo_llegadas,
    l.estLlegada,
    l.iddepartamento_llegadas,
    l.agente_llegadas,
    
    -- Información del prescriptor/alumno (nombre completo)
    p.nomPrescripcion AS prescriptor_nombre,
    p.apePrescripcion AS prescriptor_apellidos,
    CONCAT(IFNULL(p.nomPrescripcion,''), ' ', IFNULL(p.apePrescripcion,'')) AS alumno_nombre_completo,
    p.emailCasaPrescripcion AS prescriptor_email,
    p.tefCasaPrescripcion AS prescriptor_telefono,
    p.movilCasaPrescripcion AS prescriptor_movil,
    p.paisCasaPrescripcion AS prescriptor_pais,
    p.tokenPrescriptores AS prescriptor_token,
    
    -- Información del alumno (si existe)
    a.tokenUsu AS alumno_token,
    a.nomUsuario AS alumno_usuario,
    a.emailUsuario AS alumno_email,
    a.estUsu AS alumno_estado,
    
    -- Información del departamento
    d.nombreDepartamento AS departamento_nombre,
    
    -- Información del agente
    ag.nombreAgente AS agente_nombre,
    
    -- Cálculo de días hasta la llegada
    DATEDIFF(l.fechallegada_llegadas, CURDATE()) AS dias_hasta_llegada,
    
    -- Clasificación de urgencia del transfer
    CASE 
        WHEN DATEDIFF(l.fechallegada_llegadas, CURDATE()) < 0 THEN 'PASADO'
        WHEN DATEDIFF(l.fechallegada_llegadas, CURDATE()) = 0 THEN 'HOY'
        WHEN DATEDIFF(l.fechallegada_llegadas, CURDATE()) = 1 THEN 'MAÑANA'
        WHEN DATEDIFF(l.fechallegada_llegadas, CURDATE()) <= 3 THEN 'PRÓXIMO'
        WHEN DATEDIFF(l.fechallegada_llegadas, CURDATE()) <= 7 THEN 'ESTA SEMANA'
        WHEN DATEDIFF(l.fechallegada_llegadas, CURDATE()) <= 15 THEN 'PRÓXIMAS 2 SEMANAS'
        ELSE 'FUTURO'
    END AS clasificacion_transfer

FROM tm_llegadas_edu l
LEFT JOIN tm_prescriptores p ON l.idprescriptor_llegadas = p.idPrescripcion
LEFT JOIN tm_alumno_edu a ON a.idInscripcion_tmAlumno = p.idPrescripcion
LEFT JOIN tm_departamento_edu d ON l.iddepartamento_llegadas = d.idDepartamentoEdu
LEFT JOIN tm_agentes_edu ag ON l.agente_llegadas = ag.idAgente
WHERE l.estLlegada = 1;  -- Solo llegadas activas

-- =====================================================
-- NOTAS DE USO:
-- =====================================================
-- Esta vista proporciona información completa de los transfers de llegadas
-- con los datos del alumno/prescriptor asociado.
--
-- EJEMPLOS DE CONSULTAS:
--
-- 1. Obtener todos los transfers:
-- SELECT * FROM vista_transfer;
--
-- 2. Transfers de hoy:
-- SELECT * FROM vista_transfer 
-- WHERE clasificacion_transfer = 'HOY'
-- ORDER BY horallegada_llegadas;
--
-- 3. Transfers próximos (3 días):
-- SELECT * FROM vista_transfer 
-- WHERE dias_hasta_llegada BETWEEN 0 AND 3
-- ORDER BY fechallegada_llegadas, horallegada_llegadas;
--
-- 4. Transfers por departamento:
-- SELECT departamento_nombre, COUNT(*) as total_transfers
-- FROM vista_transfer
-- WHERE dias_hasta_llegada >= 0
-- GROUP BY departamento_nombre;
--
-- 5. Transfers de esta semana:
-- SELECT alumno_nombre_completo, fechallegada_llegadas, horallegada_llegadas, lugarllegada_llegadas
-- FROM vista_transfer
-- WHERE clasificacion_transfer IN ('HOY', 'MAÑANA', 'PRÓXIMO', 'ESTA SEMANA')
-- ORDER BY fechallegada_llegadas, horallegada_llegadas;
--
-- 6. Transfers sin persona asignada para recoger:
-- SELECT * FROM vista_transfer
-- WHERE quienrecogealumno_llegadas IS NULL OR quienrecogealumno_llegadas = ''
-- AND dias_hasta_llegada >= 0
-- ORDER BY fechallegada_llegadas;
--
-- =====================================================

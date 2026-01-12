-- =====================================================
-- Vista: view_llegadas_totales
-- Propósito: Consolidar todos los datos de llegadas con información completa del prescriptor,
--            totales calculados de matriculaciones, alojamientos, pagos y suplidos
-- Se incluye el token del prescriptor para integraciones externas
-- Fecha: 2026-01-10
-- =====================================================

DROP VIEW IF EXISTS view_llegadas_totales;

CREATE VIEW view_llegadas_totales AS
SELECT 
    -- Datos principales de la llegada
    l.id_llegada,
    l.idprescriptor_llegadas,
    l.diainscripcion_llegadas,
    l.fechallegada_llegadas AS fecha_inicio_curso,
    l.estLlegada,
    l.grupo_llegadas,
    l.grupoAmigos,
    l.campoobservacionesgeneralTransfer_llegadas AS observaciones,
    l.niveldice_llegadas,
    l.nivelobservaciones_llegadas,
    l.iddepartamento_llegadas,
    l.agente_llegadas,
    l.estMatricula,
    l.estAlojamiento,
    l.cursoFinalizado,
    l.estProforma,
    l.numProforma,
    
    -- Información completa del prescriptor
    p.nomPrescripcion AS prescriptor_nombre,
    p.apePrescripcion AS prescriptor_apellidos,
    CONCAT(IFNULL(p.nomPrescripcion,''), ' ', IFNULL(p.apePrescripcion,'')) AS prescriptor_nombre_completo,
    p.dirCasaPrescripcion AS prescriptor_direccion,
    p.cpCasaPrescripcion AS prescriptor_codigoPostal,
    p.ciudadCasaPrescripcion AS prescriptor_poblacion,
    p.paisCasaPrescripcion AS prescriptor_pais,
    p.emailCasaPrescripcion AS prescriptor_email,
    p.tefCasaPrescripcion AS prescriptor_telefono,
    p.movilCasaPrescripcion AS prescriptor_movil,
    p.obsPrescriptor AS prescriptor_observaciones,
    p.nacionalidadPreinscriptor AS prescriptor_nacionalidad,
    p.tipoDocumento AS prescriptor_tipoDocumento,
    p.identificadorDocumento AS prescriptor_documento,
    p.tokenPrescriptores AS prescriptor_token,
    
    -- Token del alumno para integraciones
    ae.tokenUsu AS alumno_token,
    
    -- Información del departamento
    d.nombreDepartamento AS departamento_nombre,
    
    -- Información del agente
    a.nombreAgente AS agente_nombre,
    
    -- Total de matriculaciones (con IVA) - Convertir euros a decimal
    COALESCE((
        SELECT SUM(
            CAST(
                REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
                AS DECIMAL(10,2)
            )
        )
        FROM tm_matriculacionllegadas_edu m
        WHERE m.idLlegada_matriculacion = l.id_llegada
        AND COALESCE(m.estMatriculacion_llegadas, 1) != 0
    ), 0) AS total_matriculaciones,
    
    -- Total de alojamientos (con IVA) - Convertir euros a decimal
    COALESCE((
        SELECT SUM(
            CAST(
                REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
                AS DECIMAL(10,2)
            )
        )
        FROM tm_alojamientosllegadas_edu al
        WHERE al.idLlegada_alojamientos = l.id_llegada
        AND COALESCE(al.estAlojamientos_llegadas, 1) != 0
    ), 0) AS total_alojamientos,
    
    -- Total de suplidos
    COALESCE((
        SELECT SUM(
            CAST(
                REPLACE(REPLACE(REPLACE(s.importeSuplido, '€', ''), '.', ''), ',', '.') 
                AS DECIMAL(10,2)
            )
        )
        FROM tm_suplidosLlegadas_edu s
        WHERE s.idsuplido_tmLlegadas = l.id_llegada
    ), 0) AS total_suplidos,
    
    -- Total de pagos anticipados realizados
    COALESCE((
        SELECT SUM(
            CAST(
                REPLACE(REPLACE(REPLACE(pa.importePagoAnticipado, '€', ''), '.', ''), ',', '.') 
                AS DECIMAL(10,2)
            )
        )
        FROM tm_pagoanticipadollegadas_edu pa
        WHERE pa.idLlegada_pagoAnticipado = l.id_llegada
    ), 0) AS total_pagos_realizados,
    
    -- TOTAL GENERAL (con IVA) = Matriculaciones + Alojamientos + Suplidos
    (
        COALESCE((
            SELECT SUM(
                CAST(
                    REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
                    AS DECIMAL(10,2)
                )
            )
            FROM tm_matriculacionllegadas_edu m
            WHERE m.idLlegada_matriculacion = l.id_llegada
            AND COALESCE(m.estMatriculacion_llegadas, 1) != 0
        ), 0) + 
        COALESCE((
            SELECT SUM(
                CAST(
                    REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
                    AS DECIMAL(10,2)
                )
            )
            FROM tm_alojamientosllegadas_edu al
            WHERE al.idLlegada_alojamientos = l.id_llegada
            AND COALESCE(al.estAlojamientos_llegadas, 1) != 0
        ), 0) +
        COALESCE((
            SELECT SUM(
                CAST(
                    REPLACE(REPLACE(REPLACE(s.importeSuplido, '€', ''), '.', ''), ',', '.') 
                    AS DECIMAL(10,2)
                )
            )
            FROM tm_suplidosLlegadas_edu s
            WHERE s.idsuplido_tmLlegadas = l.id_llegada
        ), 0)
    ) AS total_general,
    
    -- PAGO PENDIENTE = Total General - Pagos Realizados
    (
        (
            COALESCE((
                SELECT SUM(
                    CAST(
                        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
                        AS DECIMAL(10,2)
                    )
                )
                FROM tm_matriculacionllegadas_edu m
                WHERE m.idLlegada_matriculacion = l.id_llegada
                AND COALESCE(m.estMatriculacion_llegadas, 1) != 0
            ), 0) + 
            COALESCE((
                SELECT SUM(
                    CAST(
                        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
                        AS DECIMAL(10,2)
                    )
                )
                FROM tm_alojamientosllegadas_edu al
                WHERE al.idLlegada_alojamientos = l.id_llegada
                AND COALESCE(al.estAlojamientos_llegadas, 1) != 0
            ), 0) +
            COALESCE((
                SELECT SUM(
                    CAST(
                        REPLACE(REPLACE(REPLACE(s.importeSuplido, '€', ''), '.', ''), ',', '.') 
                        AS DECIMAL(10,2)
                    )
                )
                FROM tm_suplidosLlegadas_edu s
                WHERE s.idsuplido_tmLlegadas = l.id_llegada
            ), 0)
        ) - 
        COALESCE((
            SELECT SUM(
                CAST(
                    REPLACE(REPLACE(REPLACE(pa.importePagoAnticipado, '€', ''), '.', ''), ',', '.') 
                    AS DECIMAL(10,2)
                )
            )
            FROM tm_pagoanticipadollegadas_edu pa
            WHERE pa.idLlegada_pagoAnticipado = l.id_llegada
        ), 0)
    ) AS pago_pendiente,
    
    -- Porcentaje de pago realizado
    CASE 
        WHEN (
            COALESCE((
                SELECT SUM(
                    CAST(
                        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
                        AS DECIMAL(10,2)
                    )
                )
                FROM tm_matriculacionllegadas_edu m
                WHERE m.idLlegada_matriculacion = l.id_llegada
                AND COALESCE(m.estMatriculacion_llegadas, 1) != 0
            ), 0) + 
            COALESCE((
                SELECT SUM(
                    CAST(
                        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
                        AS DECIMAL(10,2)
                    )
                )
                FROM tm_alojamientosllegadas_edu al
                WHERE al.idLlegada_alojamientos = l.id_llegada
                AND COALESCE(al.estAlojamientos_llegadas, 1) != 0
            ), 0) +
            COALESCE((
                SELECT SUM(
                    CAST(
                        REPLACE(REPLACE(REPLACE(s.importeSuplido, '€', ''), '.', ''), ',', '.') 
                        AS DECIMAL(10,2)
                    )
                )
                FROM tm_suplidosLlegadas_edu s
                WHERE s.idsuplido_tmLlegadas = l.id_llegada
            ), 0)
        ) = 0 THEN 0
        ELSE ROUND(
            (
                COALESCE((
                    SELECT SUM(
                        CAST(
                            REPLACE(REPLACE(REPLACE(pa.importePagoAnticipado, '€', ''), '.', ''), ',', '.') 
                            AS DECIMAL(10,2)
                        )
                    )
                    FROM tm_pagoanticipadollegadas_edu pa
                    WHERE pa.idLlegada_pagoAnticipado = l.id_llegada
                ), 0) * 100.0
            ) / 
            (
                COALESCE((
                    SELECT SUM(
                        CAST(
                            REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
                            AS DECIMAL(10,2)
                        )
                    )
                    FROM tm_matriculacionllegadas_edu m
                    WHERE m.idLlegada_matriculacion = l.id_llegada
                    AND COALESCE(m.estMatriculacion_llegadas, 1) != 0
                ), 0) + 
                COALESCE((
                    SELECT SUM(
                        CAST(
                            REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
                            AS DECIMAL(10,2)
                        )
                    )
                    FROM tm_alojamientosllegadas_edu al
                    WHERE al.idLlegada_alojamientos = l.id_llegada
                    AND COALESCE(al.estAlojamientos_llegadas, 1) != 0
                ), 0) +
                COALESCE((
                    SELECT SUM(
                        CAST(
                            REPLACE(REPLACE(REPLACE(s.importeSuplido, '€', ''), '.', ''), ',', '.') 
                            AS DECIMAL(10,2)
                        )
                    )
                    FROM tm_suplidosLlegadas_edu s
                    WHERE s.idsuplido_tmLlegadas = l.id_llegada
                ), 0)
            ), 2
        )
    END AS porcentaje_pago,
    
    -- Días hasta el inicio del curso
    DATEDIFF(l.fechallegada_llegadas, CURDATE()) AS dias_hasta_inicio

FROM tm_llegadas_edu l
LEFT JOIN tm_prescriptores p ON l.idprescriptor_llegadas = p.idPrescripcion
LEFT JOIN tm_alumno_edu ae ON ae.idInscripcion_tmAlumno = p.idPrescripcion
LEFT JOIN tm_departamento_edu d ON l.iddepartamento_llegadas = d.idDepartamentoEdu
LEFT JOIN tm_agentes_edu a ON l.agente_llegadas = a.idAgente;

-- =====================================================
-- ÍNDICES SUGERIDOS (crear después de la vista)
-- =====================================================
-- CREATE INDEX idx_llegadas_estado ON tm_llegadas_edu(estLlegada);
-- CREATE INDEX idx_llegadas_fecha ON tm_llegadas_edu(fechallegada_llegadas);
-- CREATE INDEX idx_llegadas_prescriptor ON tm_llegadas_edu(idprescriptor_llegadas);
-- CREATE INDEX idx_llegadas_departamento ON tm_llegadas_edu(iddepartamento_llegadas);
-- CREATE INDEX idx_llegadas_agente ON tm_llegadas_edu(agente_llegadas);
-- CREATE INDEX idx_matriculaciones_llegada ON tm_matriculacionllegadas_edu(idLlegada_matriculacion);
-- CREATE INDEX idx_alojamientos_llegada ON tm_alojamientosllegadas_edu(idLlegada_alojamientos);
-- CREATE INDEX idx_pagos_llegada ON tm_pagoanticipadollegadas_edu(idLlegada_pagoAnticipado);
-- CREATE INDEX idx_suplidos_llegada ON tm_suplidosLlegadas_edu(idsuplido_tmLlegadas);

-- =====================================================
-- EJEMPLOS DE USO
-- =====================================================

-- 1. Obtener todas las llegadas con pagos pendientes y alerta (dentro de 30 días)
-- SELECT * FROM view_llegadas_totales 
-- WHERE pago_pendiente > 0 
-- AND dias_hasta_inicio <= 30 
-- AND dias_hasta_inicio >= 0
-- ORDER BY dias_hasta_inicio ASC;

-- 2. Llegadas por departamento con totales
-- SELECT 
--     departamento_nombre,
--     COUNT(*) as total_llegadas,
--     SUM(total_general) as suma_total,
--     SUM(pago_pendiente) as suma_pendiente,
--     AVG(porcentaje_pago) as promedio_pago
-- FROM view_llegadas_totales
-- GROUP BY departamento_nombre;

-- 3. Llegadas de un prescriptor específico
-- SELECT * FROM view_llegadas_totales 
-- WHERE idprescriptor_llegadas = 123
-- ORDER BY fecha_inicio_curso DESC;

-- 4. Llegadas con alta morosidad (menos del 50% pagado y curso en menos de 15 días)
-- SELECT 
--     id_llegada,
--     prescriptor_nombre_completo,
--     fecha_inicio_curso,
--     total_general,
--     pago_pendiente,
--     porcentaje_pago,
--     dias_hasta_inicio
-- FROM view_llegadas_totales 
-- WHERE porcentaje_pago < 50 
-- AND dias_hasta_inicio <= 15 
-- AND dias_hasta_inicio >= 0
-- ORDER BY dias_hasta_inicio ASC;

-- 5. Resumen por agente
-- SELECT 
--     agente_nombre,
--     COUNT(*) as total_llegadas,
--     SUM(total_general) as total_facturado,
--     SUM(total_pagos_realizados) as total_cobrado,
--     SUM(pago_pendiente) as total_pendiente
-- FROM view_llegadas_totales
-- GROUP BY agente_nombre
-- ORDER BY total_facturado DESC;

-- 6. Llegadas del mes actual
-- SELECT * FROM view_llegadas_totales 
-- WHERE MONTH(fecha_inicio_curso) = MONTH(CURDATE()) 
-- AND YEAR(fecha_inicio_curso) = YEAR(CURDATE())
-- ORDER BY fecha_inicio_curso;

-- 7. Estado de pagos por nacionalidad
-- SELECT 
--     prescriptor_nacionalidad,
--     COUNT(*) as total_llegadas,
--     AVG(porcentaje_pago) as promedio_pago,
--     SUM(pago_pendiente) as total_pendiente
-- FROM view_llegadas_totales
-- GROUP BY prescriptor_nacionalidad
-- ORDER BY total_pendiente DESC;

-- 8. Llegadas con pagos completos
-- SELECT * FROM view_llegadas_totales 
-- WHERE pago_pendiente <= 0
-- ORDER BY fecha_inicio_curso DESC;

-- 9. Top 10 prescriptores por volumen de negocio
-- SELECT 
--     prescriptor_nombre_completo,
--     prescriptor_pais,
--     COUNT(*) as total_llegadas,
--     SUM(total_general) as volumen_total,
--     AVG(porcentaje_pago) as promedio_pago
-- FROM view_llegadas_totales
-- GROUP BY prescriptor_nombre_completo, prescriptor_pais
-- ORDER BY volumen_total DESC
-- LIMIT 10;

-- 10. Alertas de pago críticas (rojo: 0-3 días, naranja: 4-15 días)
-- SELECT 
--     id_llegada,
--     prescriptor_nombre_completo,
--     fecha_inicio_curso,
--     dias_hasta_inicio,
--     total_general,
--     pago_pendiente,
--     porcentaje_pago,
--     CASE 
--         WHEN dias_hasta_inicio <= 3 THEN 'ROJO - CRÍTICO'
--         WHEN dias_hasta_inicio <= 15 THEN 'NARANJA - URGENTE'
--         WHEN dias_hasta_inicio <= 30 THEN 'AMARILLO - AVISO'
--         ELSE 'VERDE - NORMAL'
--     END as nivel_alerta
-- FROM view_llegadas_totales 
-- WHERE pago_pendiente > 0 
-- AND dias_hasta_inicio <= 30
-- ORDER BY dias_hasta_inicio ASC;

-- =====================================================
-- Vista: view_matriculaciones_detalle
-- Propósito: Detalle completo de cada matriculación con información relacionada
--            de llegadas, prescriptor, precios calculados con IVA y descuentos
-- Fecha: 2026-01-09
-- =====================================================

DROP VIEW IF EXISTS view_matriculaciones_detalle;

CREATE VIEW view_matriculaciones_detalle AS
SELECT 
    -- Datos de la matriculación
    m.idMatriculacionLlegada,
    m.idLlegada_matriculacion,
    m.codTarifa_matriculacion,
    m.nombreTarifa_matriculacion,
    m.descripcionTarifa_matriculacion,
    m.unidadTarifa_matriculacion,
    m.tipoTarifa_matriculacion,
    m.fechaInicioMatriculacion,
    m.fechaFinMatriculacion,
    m.estMatriculacion_llegadas,
    m.obsMatriculacion,
    
    -- Estado descriptivo
    CASE 
        WHEN m.estMatriculacion_llegadas = 0 THEN 'Cancelado'
        WHEN m.estMatriculacion_llegadas = 1 THEN 'Activo'
        WHEN m.estMatriculacion_llegadas = 2 THEN 'Pendiente inicio'
        WHEN m.estMatriculacion_llegadas = 3 THEN 'Finalizado'
        WHEN m.estMatriculacion_llegadas = 4 THEN 'Sin matriculación'
        ELSE 'Activo'
    END AS estado_descripcion,
    
    -- Información de la llegada
    l.id_llegada,
    l.grupo_llegadas,
    l.estLlegada AS estado_llegada,
    l.fechallegada_llegadas AS fecha_llegada,
    
    -- Información del prescriptor
    p.idPrescripcion,
    p.nomPrescripcion AS prescriptor_nombre,
    p.apePrescripcion AS prescriptor_apellidos,
    CONCAT(IFNULL(p.nomPrescripcion,''), ' ', IFNULL(p.apePrescripcion,'')) AS prescriptor_nombre_completo,
    p.emailCasaPrescripcion AS prescriptor_email,
    p.nacionalidadPreinscriptor AS prescriptor_nacionalidad,
    
    -- Departamento
    d.nombreDepartamento AS departamento_nombre,
    
    -- Conversión de IVA a porcentaje numérico
    CAST(
        REPLACE(REPLACE(m.idIvaTarifa_matriculacion, '%', ''), ' ', '') 
        AS DECIMAL(5,2)
    ) AS iva_porcentaje,
    
    -- Conversión de descuento a porcentaje numérico
    CAST(
        REPLACE(REPLACE(COALESCE(m.descuento_matriculacion, '0'), '%', ''), ' ', '') 
        AS DECIMAL(5,2)
    ) AS descuento_porcentaje,
    
    -- Precio original (con IVA incluido según tarifa)
    CAST(
        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) AS precio_tarifa,
    
    -- Precio sin IVA (base imponible)
    CAST(
        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) / (1 + (CAST(REPLACE(REPLACE(m.idIvaTarifa_matriculacion, '%', ''), ' ', '') AS DECIMAL(5,2)) / 100)) 
    AS precio_sin_iva,
    
    -- IVA en euros
    CAST(
        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) - 
    (CAST(
        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) / (1 + (CAST(REPLACE(REPLACE(m.idIvaTarifa_matriculacion, '%', ''), ' ', '') AS DECIMAL(5,2)) / 100)))
    AS importe_iva,
    
    -- Descuento en euros (sobre precio con IVA)
    (CAST(
        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) * CAST(REPLACE(REPLACE(COALESCE(m.descuento_matriculacion, '0'), '%', ''), ' ', '') AS DECIMAL(5,2))) / 100
    AS importe_descuento,
    
    -- Precio final con descuento aplicado
    CAST(
        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) - 
    ((CAST(
        REPLACE(REPLACE(REPLACE(m.precioTarifa_matriculacion, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) * CAST(REPLACE(REPLACE(COALESCE(m.descuento_matriculacion, '0'), '%', ''), ' ', '') AS DECIMAL(5,2))) / 100)
    AS precio_final,
    
    -- Duración del curso en días
    DATEDIFF(m.fechaFinMatriculacion, m.fechaInicioMatriculacion) AS duracion_dias,
    
    -- Duración en semanas
    CEIL(DATEDIFF(m.fechaFinMatriculacion, m.fechaInicioMatriculacion) / 7) AS duracion_semanas,
    
    -- Días hasta el inicio
    DATEDIFF(m.fechaInicioMatriculacion, CURDATE()) AS dias_hasta_inicio,
    
    -- Días hasta el fin
    DATEDIFF(m.fechaFinMatriculacion, CURDATE()) AS dias_hasta_fin,
    
    -- Estado temporal
    CASE 
        WHEN CURDATE() < m.fechaInicioMatriculacion THEN 'Futuro'
        WHEN CURDATE() BETWEEN m.fechaInicioMatriculacion AND m.fechaFinMatriculacion THEN 'En curso'
        WHEN CURDATE() > m.fechaFinMatriculacion THEN 'Finalizado'
        ELSE 'Sin definir'
    END AS estado_temporal,
    
    -- Cuentas contables
    m.cuenta1Tarifa_matriculacion,
    m.cuenta2Tarifa_matriculacion,
    m.cuenta3Tarifa_matriculacion

FROM tm_matriculacionllegadas_edu m
LEFT JOIN tm_llegadas_edu l ON m.idLlegada_matriculacion = l.id_llegada
LEFT JOIN tm_prescriptores p ON l.idprescriptor_llegadas = p.idPrescripcion
LEFT JOIN tm_departamento_edu d ON l.iddepartamento_llegadas = d.idDepartamentoEdu;

-- =====================================================
-- ÍNDICES SUGERIDOS (crear después de la vista)
-- =====================================================
-- CREATE INDEX idx_matriculacion_llegada ON tm_matriculacionllegadas_edu(idLlegada_matriculacion);
-- CREATE INDEX idx_matriculacion_estado ON tm_matriculacionllegadas_edu(estMatriculacion_llegadas);
-- CREATE INDEX idx_matriculacion_fecha_inicio ON tm_matriculacionllegadas_edu(fechaInicioMatriculacion);
-- CREATE INDEX idx_matriculacion_fecha_fin ON tm_matriculacionllegadas_edu(fechaFinMatriculacion);

-- =====================================================
-- EJEMPLOS DE USO
-- =====================================================

-- 1. Matriculaciones activas (en curso)
-- SELECT * FROM view_matriculaciones_detalle 
-- WHERE estado_temporal = 'En curso'
-- AND COALESCE(estMatriculacion_llegadas, 1) = 1
-- ORDER BY fechaInicioMatriculacion;

-- 2. Matriculaciones por iniciar próximamente (próximos 7 días)
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_matriculacion,
--     nombreTarifa_matriculacion,
--     fechaInicioMatriculacion,
--     dias_hasta_inicio,
--     precio_final
-- FROM view_matriculaciones_detalle 
-- WHERE dias_hasta_inicio BETWEEN 0 AND 7
-- ORDER BY dias_hasta_inicio;

-- 3. Resumen de ingresos por departamento
-- SELECT 
--     departamento_nombre,
--     COUNT(*) as total_matriculaciones,
--     SUM(precio_sin_iva) as total_base_imponible,
--     SUM(importe_iva) as total_iva,
--     SUM(precio_final) as total_con_descuento
-- FROM view_matriculaciones_detalle
-- WHERE COALESCE(estMatriculacion_llegadas, 1) != 0
-- GROUP BY departamento_nombre;

-- 4. Matriculaciones con descuento aplicado
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_matriculacion,
--     precio_tarifa,
--     descuento_porcentaje,
--     importe_descuento,
--     precio_final
-- FROM view_matriculaciones_detalle 
-- WHERE descuento_porcentaje > 0
-- ORDER BY descuento_porcentaje DESC;

-- 5. Cursos por nacionalidad
-- SELECT 
--     prescriptor_nacionalidad,
--     COUNT(*) as total_matriculaciones,
--     AVG(duracion_dias) as duracion_promedio_dias,
--     SUM(precio_final) as volumen_total
-- FROM view_matriculaciones_detalle
-- WHERE COALESCE(estMatriculacion_llegadas, 1) != 0
-- GROUP BY prescriptor_nacionalidad
-- ORDER BY volumen_total DESC;

-- 6. Matriculaciones de un grupo específico
-- SELECT * FROM view_matriculaciones_detalle 
-- WHERE grupo_llegadas = 'GRUPO-2025-A'
-- ORDER BY fechaInicioMatriculacion;

-- 7. Análisis de IVA recaudado por periodo
-- SELECT 
--     DATE_FORMAT(fechaInicioMatriculacion, '%Y-%m') as periodo,
--     COUNT(*) as total_matriculaciones,
--     SUM(precio_sin_iva) as base_imponible,
--     SUM(importe_iva) as iva_recaudado,
--     SUM(precio_final) as total_facturado
-- FROM view_matriculaciones_detalle
-- WHERE COALESCE(estMatriculacion_llegadas, 1) != 0
-- GROUP BY periodo
-- ORDER BY periodo DESC;

-- 8. Matriculaciones canceladas
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_matriculacion,
--     fechaInicioMatriculacion,
--     precio_final,
--     obsMatriculacion
-- FROM view_matriculaciones_detalle 
-- WHERE estMatriculacion_llegadas = 0
-- ORDER BY fechaInicioMatriculacion DESC;

-- 9. Cursos de larga duración (más de 8 semanas)
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_matriculacion,
--     nombreTarifa_matriculacion,
--     duracion_semanas,
--     fechaInicioMatriculacion,
--     fechaFinMatriculacion,
--     precio_final
-- FROM view_matriculaciones_detalle 
-- WHERE duracion_semanas > 8
-- ORDER BY duracion_semanas DESC;

-- 10. Detalle completo de una llegada específica
-- SELECT * FROM view_matriculaciones_detalle 
-- WHERE idLlegada_matriculacion = 48
-- ORDER BY fechaInicioMatriculacion;

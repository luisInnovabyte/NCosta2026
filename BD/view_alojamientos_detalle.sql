-- =====================================================
-- Vista: view_alojamientos_detalle
-- Propósito: Detalle completo de cada alojamiento con información relacionada
--            de llegadas, prescriptor, precios calculados con IVA y descuentos
-- Fecha: 2026-01-09
-- =====================================================

DROP VIEW IF EXISTS view_alojamientos_detalle;

CREATE VIEW view_alojamientos_detalle AS
SELECT 
    -- Datos del alojamiento
    al.idAlojamientoLlegada,
    al.idLlegada_alojamientos,
    al.codTarifa_alojamientos,
    al.nombreTarifa_alojamientos,
    al.descripcionTarifa_alojamientos,
    al.unidadTarifa_alojamientos,
    al.tipoTarifa_alojamientos,
    al.fechaInicioAlojamientos,
    al.fechaFinAlojamientos,
    al.estAlojamientos_llegadas,
    al.obsAlojamientos,
    
    -- Estado descriptivo
    CASE 
        WHEN al.estAlojamientos_llegadas = 0 THEN 'Cancelado'
        WHEN al.estAlojamientos_llegadas = 1 THEN 'Activo'
        WHEN al.estAlojamientos_llegadas = 2 THEN 'Pendiente inicio'
        WHEN al.estAlojamientos_llegadas = 3 THEN 'Finalizado'
        WHEN al.estAlojamientos_llegadas = 4 THEN 'Sin alojamiento'
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
        REPLACE(REPLACE(al.idIvaTarifa_alojamientos, '%', ''), ' ', '') 
        AS DECIMAL(5,2)
    ) AS iva_porcentaje,
    
    -- Conversión de descuento a porcentaje numérico
    CAST(
        REPLACE(REPLACE(COALESCE(al.descuento_Alojamientos, '0'), '%', ''), ' ', '') 
        AS DECIMAL(5,2)
    ) AS descuento_porcentaje,
    
    -- Precio original (con IVA incluido según tarifa)
    CAST(
        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) AS precio_tarifa,
    
    -- Precio sin IVA (base imponible)
    CAST(
        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) / (1 + (CAST(REPLACE(REPLACE(al.idIvaTarifa_alojamientos, '%', ''), ' ', '') AS DECIMAL(5,2)) / 100)) 
    AS precio_sin_iva,
    
    -- IVA en euros
    CAST(
        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) - 
    (CAST(
        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) / (1 + (CAST(REPLACE(REPLACE(al.idIvaTarifa_alojamientos, '%', ''), ' ', '') AS DECIMAL(5,2)) / 100)))
    AS importe_iva,
    
    -- Descuento en euros (sobre precio con IVA)
    (CAST(
        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) * CAST(REPLACE(REPLACE(COALESCE(al.descuento_Alojamientos, '0'), '%', ''), ' ', '') AS DECIMAL(5,2))) / 100
    AS importe_descuento,
    
    -- Precio final con descuento aplicado
    CAST(
        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) - 
    ((CAST(
        REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
        AS DECIMAL(10,2)
    ) * CAST(REPLACE(REPLACE(COALESCE(al.descuento_Alojamientos, '0'), '%', ''), ' ', '') AS DECIMAL(5,2))) / 100)
    AS precio_final,
    
    -- Duración del alojamiento en días (noches)
    DATEDIFF(al.fechaFinAlojamientos, al.fechaInicioAlojamientos) AS duracion_dias,
    
    -- Duración en semanas
    CEIL(DATEDIFF(al.fechaFinAlojamientos, al.fechaInicioAlojamientos) / 7) AS duracion_semanas,
    
    -- Días hasta el check-in
    DATEDIFF(al.fechaInicioAlojamientos, CURDATE()) AS dias_hasta_checkin,
    
    -- Días hasta el check-out
    DATEDIFF(al.fechaFinAlojamientos, CURDATE()) AS dias_hasta_checkout,
    
    -- Estado temporal
    CASE 
        WHEN CURDATE() < al.fechaInicioAlojamientos THEN 'Futuro'
        WHEN CURDATE() BETWEEN al.fechaInicioAlojamientos AND al.fechaFinAlojamientos THEN 'Ocupado'
        WHEN CURDATE() > al.fechaFinAlojamientos THEN 'Finalizado'
        ELSE 'Sin definir'
    END AS estado_temporal,
    
    -- Precio por noche (solo si tiene duración)
    CASE 
        WHEN DATEDIFF(al.fechaFinAlojamientos, al.fechaInicioAlojamientos) > 0 THEN
            CAST(
                REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
                AS DECIMAL(10,2)
            ) / DATEDIFF(al.fechaFinAlojamientos, al.fechaInicioAlojamientos)
        ELSE NULL
    END AS precio_por_noche,
    
    -- Precio por semana (solo si tiene duración)
    CASE 
        WHEN DATEDIFF(al.fechaFinAlojamientos, al.fechaInicioAlojamientos) >= 7 THEN
            (CAST(
                REPLACE(REPLACE(REPLACE(al.precioTarifa_alojamientos, '€', ''), '.', ''), ',', '.') 
                AS DECIMAL(10,2)
            ) / DATEDIFF(al.fechaFinAlojamientos, al.fechaInicioAlojamientos)) * 7
        ELSE NULL
    END AS precio_por_semana,
    
    -- Cuentas contables
    al.cuenta1Tarifa_alojamientos,
    al.cuenta2Tarifa_alojamientos,
    al.cuenta3Tarifa_alojamientos

FROM tm_alojamientosllegadas_edu al
LEFT JOIN tm_llegadas_edu l ON al.idLlegada_alojamientos = l.id_llegada
LEFT JOIN tm_prescriptores p ON l.idprescriptor_llegadas = p.idPrescripcion
LEFT JOIN tm_departamento_edu d ON l.iddepartamento_llegadas = d.idDepartamentoEdu;

-- =====================================================
-- ÍNDICES SUGERIDOS (crear después de la vista)
-- =====================================================
-- CREATE INDEX idx_alojamiento_llegada ON tm_alojamientosllegadas_edu(idLlegada_alojamientos);
-- CREATE INDEX idx_alojamiento_estado ON tm_alojamientosllegadas_edu(estAlojamientos_llegadas);
-- CREATE INDEX idx_alojamiento_fecha_inicio ON tm_alojamientosllegadas_edu(fechaInicioAlojamientos);
-- CREATE INDEX idx_alojamiento_fecha_fin ON tm_alojamientosllegadas_edu(fechaFinAlojamientos);

-- =====================================================
-- EJEMPLOS DE USO
-- =====================================================

-- 1. Alojamientos activos (ocupados actualmente)
-- SELECT * FROM view_alojamientos_detalle 
-- WHERE estado_temporal = 'Ocupado'
-- AND COALESCE(estAlojamientos_llegadas, 1) = 1
-- ORDER BY fechaInicioAlojamientos;

-- 2. Check-ins próximos (próximos 7 días)
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_alojamientos,
--     nombreTarifa_alojamientos,
--     fechaInicioAlojamientos,
--     dias_hasta_checkin,
--     precio_final
-- FROM view_alojamientos_detalle 
-- WHERE dias_hasta_checkin BETWEEN 0 AND 7
-- ORDER BY dias_hasta_checkin;

-- 3. Check-outs próximos (próximos 3 días)
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_alojamientos,
--     fechaFinAlojamientos,
--     dias_hasta_checkout,
--     duracion_dias
-- FROM view_alojamientos_detalle 
-- WHERE dias_hasta_checkout BETWEEN 0 AND 3
-- AND estado_temporal = 'Ocupado'
-- ORDER BY dias_hasta_checkout;

-- 4. Resumen de ingresos por alojamiento
-- SELECT 
--     departamento_nombre,
--     COUNT(*) as total_alojamientos,
--     SUM(duracion_dias) as total_noches,
--     SUM(precio_sin_iva) as total_base_imponible,
--     SUM(importe_iva) as total_iva,
--     SUM(precio_final) as total_con_descuento,
--     AVG(precio_por_noche) as precio_promedio_noche
-- FROM view_alojamientos_detalle
-- WHERE COALESCE(estAlojamientos_llegadas, 1) != 0
-- GROUP BY departamento_nombre;

-- 5. Alojamientos con descuento aplicado
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_alojamientos,
--     precio_tarifa,
--     descuento_porcentaje,
--     importe_descuento,
--     precio_final
-- FROM view_alojamientos_detalle 
-- WHERE descuento_porcentaje > 0
-- ORDER BY descuento_porcentaje DESC;

-- 6. Estadías largas (más de 4 semanas)
-- SELECT 
--     prescriptor_nombre_completo,
--     nombreTarifa_alojamientos,
--     duracion_semanas,
--     duracion_dias,
--     fechaInicioAlojamientos,
--     fechaFinAlojamientos,
--     precio_final,
--     precio_por_semana
-- FROM view_alojamientos_detalle 
-- WHERE duracion_semanas > 4
-- ORDER BY duracion_semanas DESC;

-- 7. Análisis de ocupación por periodo
-- SELECT 
--     DATE_FORMAT(fechaInicioAlojamientos, '%Y-%m') as periodo,
--     COUNT(*) as total_alojamientos,
--     SUM(duracion_dias) as total_noches,
--     AVG(duracion_dias) as promedio_noches,
--     SUM(precio_final) as total_facturado,
--     AVG(precio_por_noche) as tarifa_promedio_noche
-- FROM view_alojamientos_detalle
-- WHERE COALESCE(estAlojamientos_llegadas, 1) != 0
-- GROUP BY periodo
-- ORDER BY periodo DESC;

-- 8. Alojamientos cancelados
-- SELECT 
--     prescriptor_nombre_completo,
--     codTarifa_alojamientos,
--     fechaInicioAlojamientos,
--     fechaFinAlojamientos,
--     precio_final,
--     obsAlojamientos
-- FROM view_alojamientos_detalle 
-- WHERE estAlojamientos_llegadas = 0
-- ORDER BY fechaInicioAlojamientos DESC;

-- 9. Comparativa de tarifas por tipo de alojamiento
-- SELECT 
--     tipoTarifa_alojamientos,
--     COUNT(*) as total_reservas,
--     AVG(duracion_dias) as duracion_promedio,
--     MIN(precio_por_noche) as precio_min_noche,
--     AVG(precio_por_noche) as precio_promedio_noche,
--     MAX(precio_por_noche) as precio_max_noche,
--     SUM(precio_final) as volumen_total
-- FROM view_alojamientos_detalle
-- WHERE COALESCE(estAlojamientos_llegadas, 1) != 0
-- AND precio_por_noche IS NOT NULL
-- GROUP BY tipoTarifa_alojamientos
-- ORDER BY volumen_total DESC;

-- 10. Detalle completo de alojamientos de una llegada
-- SELECT * FROM view_alojamientos_detalle 
-- WHERE idLlegada_alojamientos = 48
-- ORDER BY fechaInicioAlojamientos;

-- 11. Alojamientos por nacionalidad del estudiante
-- SELECT 
--     prescriptor_nacionalidad,
--     COUNT(*) as total_alojamientos,
--     SUM(duracion_dias) as total_noches,
--     AVG(duracion_dias) as promedio_noches,
--     AVG(precio_por_noche) as tarifa_promedio,
--     SUM(precio_final) as volumen_total
-- FROM view_alojamientos_detalle
-- WHERE COALESCE(estAlojamientos_llegadas, 1) != 0
-- GROUP BY prescriptor_nacionalidad
-- ORDER BY volumen_total DESC;

-- 12. Calendario de ocupación (próximos 30 días)
-- SELECT 
--     fechaInicioAlojamientos AS fecha_evento,
--     'Check-in' AS tipo_evento,
--     prescriptor_nombre_completo,
--     codTarifa_alojamientos,
--     duracion_dias
-- FROM view_alojamientos_detalle 
-- WHERE dias_hasta_checkin BETWEEN 0 AND 30
-- UNION ALL
-- SELECT 
--     fechaFinAlojamientos AS fecha_evento,
--     'Check-out' AS tipo_evento,
--     prescriptor_nombre_completo,
--     codTarifa_alojamientos,
--     duracion_dias
-- FROM view_alojamientos_detalle 
-- WHERE dias_hasta_checkout BETWEEN 0 AND 30
-- ORDER BY fecha_evento;

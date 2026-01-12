-- =====================================================
-- Vista: view_llegadas_alertas_pago
-- Propósito: Vista optimizada para alertas de pago pendiente según urgencia
--            Filtra solo llegadas con pagos pendientes y curso próximo
-- Fecha: 2026-01-09
-- =====================================================

DROP VIEW IF EXISTS view_llegadas_alertas_pago;

CREATE VIEW view_llegadas_alertas_pago AS
SELECT 
    -- Datos básicos de la llegada
    vl.id_llegada,
    vl.idprescriptor_llegadas,
    vl.grupo_llegadas,
    vl.fecha_inicio_curso,
    vl.estLlegada,
    
    -- Información del prescriptor
    vl.prescriptor_nombre_completo,
    vl.prescriptor_email,
    vl.prescriptor_telefono,
    vl.prescriptor_movil,
    vl.prescriptor_pais,
    vl.prescriptor_nacionalidad,
    vl.prescriptor_token,
    vl.alumno_token,
    
    -- Información del departamento y agente
    vl.departamento_nombre,
    vl.agente_nombre,
    
    -- Datos financieros
    vl.total_matriculaciones,
    vl.total_alojamientos,
    vl.total_suplidos,
    vl.total_general,
    vl.total_pagos_realizados,
    vl.pago_pendiente,
    vl.porcentaje_pago,
    
    -- Información temporal
    vl.dias_hasta_inicio,
    
    -- Nivel de alerta basado en días hasta inicio
    CASE 
        WHEN vl.dias_hasta_inicio < 0 THEN 'VENCIDO'
        WHEN vl.dias_hasta_inicio <= 3 THEN 'CRÍTICO'
        WHEN vl.dias_hasta_inicio <= 7 THEN 'URGENTE'
        WHEN vl.dias_hasta_inicio <= 15 THEN 'IMPORTANTE'
        WHEN vl.dias_hasta_inicio <= 30 THEN 'AVISO'
        ELSE 'NORMAL'
    END AS nivel_alerta,
    
    -- Color para el indicador visual
    CASE 
        WHEN vl.dias_hasta_inicio < 0 THEN '#8B0000'           -- Rojo oscuro (vencido)
        WHEN vl.dias_hasta_inicio <= 3 THEN '#DC143C'          -- Rojo brillante (crítico)
        WHEN vl.dias_hasta_inicio <= 7 THEN '#FF4500'          -- Naranja rojizo (urgente)
        WHEN vl.dias_hasta_inicio <= 15 THEN '#FFA500'         -- Naranja (importante)
        WHEN vl.dias_hasta_inicio <= 30 THEN '#FFD700'         -- Amarillo (aviso)
        ELSE '#32CD32'                                          -- Verde (normal)
    END AS color_alerta,
    
    -- Prioridad numérica (1 = máxima urgencia)
    CASE 
        WHEN vl.dias_hasta_inicio < 0 THEN 1
        WHEN vl.dias_hasta_inicio <= 3 THEN 2
        WHEN vl.dias_hasta_inicio <= 7 THEN 3
        WHEN vl.dias_hasta_inicio <= 15 THEN 4
        WHEN vl.dias_hasta_inicio <= 30 THEN 5
        ELSE 6
    END AS prioridad,
    
    -- Mensaje descriptivo de la alerta
    CASE 
        WHEN vl.dias_hasta_inicio < 0 THEN 
            CONCAT('CURSO INICIADO - Pago vencido desde hace ', ABS(vl.dias_hasta_inicio), ' día(s)')
        WHEN vl.dias_hasta_inicio = 0 THEN 
            'CURSO HOY - Pago pendiente urgente'
        WHEN vl.dias_hasta_inicio = 1 THEN 
            'CURSO MAÑANA - Pago pendiente crítico'
        WHEN vl.dias_hasta_inicio <= 3 THEN 
            CONCAT('Curso en ', vl.dias_hasta_inicio, ' días - Pago crítico')
        WHEN vl.dias_hasta_inicio <= 7 THEN 
            CONCAT('Curso en ', vl.dias_hasta_inicio, ' días - Pago urgente')
        WHEN vl.dias_hasta_inicio <= 15 THEN 
            CONCAT('Curso en ', vl.dias_hasta_inicio, ' días - Pago importante')
        WHEN vl.dias_hasta_inicio <= 30 THEN 
            CONCAT('Curso en ', vl.dias_hasta_inicio, ' días - Aviso de pago')
        ELSE 
            CONCAT('Curso en ', vl.dias_hasta_inicio, ' días - Seguimiento normal')
    END AS mensaje_alerta,
    
    -- Porcentaje pendiente
    ROUND(100 - vl.porcentaje_pago, 2) AS porcentaje_pendiente,
    
    -- Clasificación por monto pendiente
    CASE 
        WHEN vl.pago_pendiente > 5000 THEN 'Alto monto'
        WHEN vl.pago_pendiente > 2000 THEN 'Monto medio'
        WHEN vl.pago_pendiente > 500 THEN 'Monto bajo'
        ELSE 'Monto mínimo'
    END AS clasificacion_monto,
    
    -- Score combinado de urgencia (menor = más urgente)
    -- Combina días restantes y porcentaje pendiente
    (vl.dias_hasta_inicio * 0.7) + ((100 - vl.porcentaje_pago) * 0.3) AS score_urgencia

FROM view_llegadas_totales vl
WHERE 
    -- Solo llegadas con pago pendiente positivo
    vl.pago_pendiente > 0
    -- Y curso en los próximos 45 días o ya vencido
    AND vl.dias_hasta_inicio <= 45
    -- Excluir llegadas canceladas
    AND vl.estLlegada != 0;

-- =====================================================
-- ÍNDICES SUGERIDOS
-- =====================================================
-- Los índices se crean en la tabla base view_llegadas_totales
-- Ya están sugeridos en ese archivo

-- =====================================================
-- EJEMPLOS DE USO
-- =====================================================

-- 1. Alertas críticas ordenadas por urgencia
-- SELECT 
--     id_llegada,
--     prescriptor_nombre_completo,
--     nivel_alerta,
--     mensaje_alerta,
--     dias_hasta_inicio,
--     pago_pendiente,
--     porcentaje_pago,
--     prescriptor_telefono
-- FROM view_llegadas_alertas_pago 
-- WHERE nivel_alerta IN ('CRÍTICO', 'VENCIDO')
-- ORDER BY prioridad, dias_hasta_inicio;

-- 2. Todas las alertas ordenadas por score de urgencia
-- SELECT 
--     nivel_alerta,
--     prescriptor_nombre_completo,
--     dias_hasta_inicio,
--     pago_pendiente,
--     porcentaje_pendiente,
--     score_urgencia,
--     color_alerta
-- FROM view_llegadas_alertas_pago 
-- ORDER BY score_urgencia;

-- 3. Dashboard de alertas por nivel
-- SELECT 
--     nivel_alerta,
--     COUNT(*) as total_casos,
--     SUM(pago_pendiente) as total_pendiente,
--     AVG(dias_hasta_inicio) as promedio_dias,
--     AVG(porcentaje_pendiente) as promedio_pendiente
-- FROM view_llegadas_alertas_pago 
-- GROUP BY nivel_alerta, prioridad
-- ORDER BY prioridad;

-- 4. Alertas por departamento
-- SELECT 
--     departamento_nombre,
--     nivel_alerta,
--     COUNT(*) as total_alertas,
--     SUM(pago_pendiente) as monto_pendiente,
--     AVG(porcentaje_pendiente) as promedio_pendiente
-- FROM view_llegadas_alertas_pago 
-- GROUP BY departamento_nombre, nivel_alerta
-- ORDER BY departamento_nombre, prioridad;

-- 5. Lista de contacto urgente (cursos en 3 días o menos)
-- SELECT 
--     prescriptor_nombre_completo,
--     prescriptor_email,
--     prescriptor_telefono,
--     prescriptor_movil,
--     nivel_alerta,
--     dias_hasta_inicio,
--     pago_pendiente,
--     mensaje_alerta
-- FROM view_llegadas_alertas_pago 
-- WHERE dias_hasta_inicio <= 3
-- ORDER BY dias_hasta_inicio;

-- 6. Alertas con alto monto pendiente
-- SELECT 
--     id_llegada,
--     prescriptor_nombre_completo,
--     clasificacion_monto,
--     pago_pendiente,
--     total_general,
--     porcentaje_pago,
--     dias_hasta_inicio,
--     nivel_alerta
-- FROM view_llegadas_alertas_pago 
-- WHERE clasificacion_monto = 'Alto monto'
-- ORDER BY pago_pendiente DESC;

-- 7. Cursos vencidos (ya empezaron sin pago completo)
-- SELECT 
--     id_llegada,
--     prescriptor_nombre_completo,
--     fecha_inicio_curso,
--     dias_hasta_inicio,
--     pago_pendiente,
--     total_pagos_realizados,
--     total_general,
--     prescriptor_telefono,
--     mensaje_alerta
-- FROM view_llegadas_alertas_pago 
-- WHERE nivel_alerta = 'VENCIDO'
-- ORDER BY dias_hasta_inicio;

-- 8. Resumen por agente
-- SELECT 
--     agente_nombre,
--     COUNT(*) as total_alertas,
--     SUM(CASE WHEN nivel_alerta IN ('VENCIDO', 'CRÍTICO') THEN 1 ELSE 0 END) as alertas_criticas,
--     SUM(pago_pendiente) as total_pendiente,
--     AVG(dias_hasta_inicio) as promedio_dias
-- FROM view_llegadas_alertas_pago 
-- GROUP BY agente_nombre
-- ORDER BY alertas_criticas DESC, total_pendiente DESC;

-- 9. Tendencia semanal de alertas
-- SELECT 
--     CASE 
--         WHEN dias_hasta_inicio < 0 THEN 'Vencidos'
--         WHEN dias_hasta_inicio <= 7 THEN 'Esta semana'
--         WHEN dias_hasta_inicio <= 14 THEN 'Próxima semana'
--         WHEN dias_hasta_inicio <= 21 THEN '2-3 semanas'
--         ELSE 'Más de 3 semanas'
--     END as periodo,
--     COUNT(*) as total_casos,
--     SUM(pago_pendiente) as monto_total,
--     AVG(porcentaje_pendiente) as promedio_pendiente
-- FROM view_llegadas_alertas_pago 
-- GROUP BY periodo
-- ORDER BY MIN(dias_hasta_inicio);

-- 10. Alertas por país del estudiante
-- SELECT 
--     prescriptor_pais,
--     COUNT(*) as total_alertas,
--     SUM(pago_pendiente) as total_pendiente,
--     AVG(porcentaje_pendiente) as promedio_pendiente,
--     AVG(dias_hasta_inicio) as promedio_dias
-- FROM view_llegadas_alertas_pago 
-- GROUP BY prescriptor_pais
-- ORDER BY total_pendiente DESC;

-- 11. Widget de indicadores para dashboard principal
-- SELECT 
--     COUNT(*) as total_alertas,
--     SUM(CASE WHEN nivel_alerta = 'VENCIDO' THEN 1 ELSE 0 END) as vencidos,
--     SUM(CASE WHEN nivel_alerta = 'CRÍTICO' THEN 1 ELSE 0 END) as criticos,
--     SUM(CASE WHEN nivel_alerta = 'URGENTE' THEN 1 ELSE 0 END) as urgentes,
--     SUM(CASE WHEN nivel_alerta = 'IMPORTANTE' THEN 1 ELSE 0 END) as importantes,
--     SUM(pago_pendiente) as monto_total_pendiente,
--     AVG(porcentaje_pendiente) as promedio_pendiente
-- FROM view_llegadas_alertas_pago;

-- 12. Top 10 casos más urgentes para seguimiento inmediato
-- SELECT 
--     id_llegada,
--     prescriptor_nombre_completo,
--     prescriptor_telefono,
--     mensaje_alerta,
--     pago_pendiente,
--     color_alerta,
--     score_urgencia
-- FROM view_llegadas_alertas_pago 
-- ORDER BY score_urgencia
-- LIMIT 10;

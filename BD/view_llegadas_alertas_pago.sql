-- PASO 2: Actualizar view_llegadas_alertas_pago
DROP VIEW IF EXISTS view_llegadas_alertas_pago;

CREATE VIEW view_llegadas_alertas_pago AS
SELECT 
    vl.*,
    
    CASE 
        WHEN vl.dias_hasta_inicio < 0 THEN 'VENCIDO'
        WHEN vl.dias_hasta_inicio <= 3 THEN 'CRÍTICO'
        WHEN vl.dias_hasta_inicio <= 7 THEN 'URGENTE'
        WHEN vl.dias_hasta_inicio <= 15 THEN 'IMPORTANTE'
        WHEN vl.dias_hasta_inicio <= 30 THEN 'AVISO'
        ELSE 'NORMAL'
    END AS nivel_alerta,
    
    CASE 
        WHEN vl.dias_hasta_inicio < 0 THEN '#8B0000'
        WHEN vl.dias_hasta_inicio <= 3 THEN '#DC143C'
        WHEN vl.dias_hasta_inicio <= 7 THEN '#FF4500'
        WHEN vl.dias_hasta_inicio <= 15 THEN '#FFA500'
        WHEN vl.dias_hasta_inicio <= 30 THEN '#FFD700'
        ELSE '#32CD32'
    END AS color_alerta,
    
    CASE 
        WHEN vl.dias_hasta_inicio < 0 THEN 1
        WHEN vl.dias_hasta_inicio <= 3 THEN 2
        WHEN vl.dias_hasta_inicio <= 7 THEN 3
        WHEN vl.dias_hasta_inicio <= 15 THEN 4
        WHEN vl.dias_hasta_inicio <= 30 THEN 5
        ELSE 6
    END AS prioridad,
    
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
    
    ROUND(100 - vl.porcentaje_pago, 2) AS porcentaje_pendiente,
    
    CASE 
        WHEN vl.pago_pendiente > 5000 THEN 'Alto monto'
        WHEN vl.pago_pendiente > 2000 THEN 'Monto medio'
        WHEN vl.pago_pendiente > 500 THEN 'Monto bajo'
        ELSE 'Monto mínimo'
    END AS clasificacion_monto,
    
    (vl.dias_hasta_inicio * 0.7) + ((100 - vl.porcentaje_pago) * 0.3) AS score_urgencia

FROM view_llegadas_totales vl
WHERE 
    vl.pago_pendiente > 0
    AND vl.dias_hasta_inicio <= 45
    AND vl.estLlegada != 0;
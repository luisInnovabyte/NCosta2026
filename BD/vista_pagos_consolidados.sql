-- ============================================================================
-- VISTA: view_pagos_consolidados
-- Descripción: Consolida todos los pagos de un usuario por todos los conceptos
-- Fecha: 09/01/2026
-- ============================================================================
-- Esta vista unifica todos los pagos realizados en el sistema agrupados por:
-- - Pagos Anticipados (tabla: tm_pagoanticipadollegadas_edu)
-- - Puede extenderse para incluir otros conceptos de pago en el futuro
-- ============================================================================

DROP VIEW IF EXISTS view_pagos_consolidados;

CREATE VIEW view_pagos_consolidados AS

-- PAGOS ANTICIPADOS (conceptos generales)
SELECT 
    pa.idPagoAnticipado AS id_pago,
    'Pago Anticipado' AS concepto_tipo,
    pa.observacionPagoAnticipado AS concepto_detalle,
    l.id_llegada AS id_llegada,
    l.idprescriptor_llegadas AS id_prescriptor,
    p.nomPrescripcion AS nombre_usuario,
    p.apePrescripcion AS apellido_usuario,
    CONCAT(p.nomPrescripcion, ' ', p.apePrescripcion) AS nombre_completo,
    pa.importePagoAnticipado AS importe,
    pa.fechaPagoAnticipado AS fecha_pago,
    pa.medioPagoAnticipado AS medio_pago,
    pa.observacionPagoAnticipado AS observaciones,
    l.diainscripcion_llegadas AS fecha_inscripcion,
    l.estLlegada AS estado_llegada
FROM 
    tm_pagoanticipadollegadas_edu pa
    INNER JOIN tm_llegadas_edu l ON pa.idLlegada_pagoAnticipado = l.id_llegada
    INNER JOIN tm_prescriptores p ON l.idprescriptor_llegadas = p.idPrescripcion
WHERE 
    l.estLlegada = 1

-- Aquí se pueden agregar más UNION para otros tipos de pago
-- Por ejemplo: pagos de suplidos, pagos de visados, etc.

ORDER BY 
    fecha_pago DESC, 
    id_llegada;


-- ============================================================================
-- ÍNDICES SUGERIDOS PARA OPTIMIZAR CONSULTAS
-- ============================================================================
-- Si aún no existen, considera crear estos índices:

-- CREATE INDEX idx_pagoAnticipado_idLlegada ON tm_pagoanticipadollegadas_edu(idLlegada_pagoAnticipado);
-- CREATE INDEX idx_pagoAnticipado_fecha ON tm_pagoanticipadollegadas_edu(fechaPagoAnticipado);
-- CREATE INDEX idx_llegadas_prescriptor ON tm_llegadas_edu(idprescriptor_llegadas);


-- ============================================================================
-- CONSULTAS DE EJEMPLO PARA USAR LA VISTA
-- ============================================================================

-- 1. Ver todos los pagos de una llegada específica
-- SELECT * FROM view_pagos_consolidados WHERE id_llegada = 123;

-- 2. Ver todos los pagos de un prescriptor/usuario
-- SELECT * FROM view_pagos_consolidados WHERE id_prescriptor = 456;

-- 3. Ver total pagado por llegada
-- SELECT 
--     id_llegada,
--     nombre_completo,
--     SUM(importe) AS total_pagado,
--     COUNT(*) AS cantidad_pagos
-- FROM view_pagos_consolidados
-- GROUP BY id_llegada, nombre_completo;

-- 4. Ver pagos por rango de fechas
-- SELECT * FROM view_pagos_consolidados 
-- WHERE fecha_pago BETWEEN '2026-01-01' AND '2026-12-31'
-- ORDER BY fecha_pago DESC;

-- 5. Ver pagos por medio de pago
-- SELECT 
--     medio_pago,
--     COUNT(*) AS cantidad_transacciones,
--     SUM(importe) AS total_importe
-- FROM view_pagos_consolidados
-- GROUP BY medio_pago
-- ORDER BY total_importe DESC;

-- 6. Reporte completo de pagos con totales
-- SELECT 
--     id_llegada,
--     nombre_completo,
--     concepto_tipo,
--     concepto_detalle,
--     DATE_FORMAT(fecha_pago, '%d/%m/%Y') AS fecha,
--     CONCAT(FORMAT(importe, 2, 'es_ES'), ' €') AS importe_formato,
--     medio_pago
-- FROM view_pagos_consolidados
-- WHERE id_prescriptor = ? -- Parámetro del usuario
-- ORDER BY fecha_pago DESC;

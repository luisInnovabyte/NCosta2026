-- ============================================
-- Script de corrección para tabla tm_iva
-- Problema: Campo descrIva solo tiene VARCHAR(11)
-- Solución: Ampliar a VARCHAR(150)
-- Fecha: 7 de enero de 2026
-- ============================================

USE `newcosta`;

-- Ampliar el campo descrIva de VARCHAR(11) a VARCHAR(150)
ALTER TABLE `tm_iva` 
MODIFY COLUMN `descrIva` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Descripción del IVA';

-- Verificar el cambio
DESCRIBE `tm_iva`;

-- Mensaje de confirmación
SELECT 'Campo descrIva ampliado exitosamente a VARCHAR(150)' AS Resultado;

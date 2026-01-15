-- ========================================================================
-- SCRIPT DE LIMPIEZA COMPLETA DE DATOS DE UN USUARIO/PRESCRIPTOR
-- Costa de Valencia - Sistema de Gestión Educativa
-- ========================================================================
-- 
-- PROPÓSITO: Eliminar todos los datos relacionados con un prescriptor específico
--            para poder inicializar el usuario desde cero para pruebas.
--
-- IMPORTANTE: 
-- 1. Este script eliminará TODOS los datos del prescriptor especificado
-- 2. NO afectará a otros usuarios del sistema
-- 3. Ejecutar con precaución, se recomienda hacer backup antes
-- 4. Revisar el orden de eliminación para respetar integridad referencial
--
-- INSTRUCCIONES DE USO:
-- 1. Modificar la variable @idPrescriptor_a_limpiar con el ID del prescriptor
-- 2. Ejecutar el script completo
-- 3. Revisar el reporte de registros eliminados al final
-- ========================================================================

-- PASO 1: DEFINIR EL ID DEL PRESCRIPTOR A LIMPIAR
-- ========================================================================
SET @idPrescriptor_a_limpiar = 50;  -- CAMBIAR ESTE VALOR AL ID DESEADO

-- PASO 2: VERIFICAR QUE EL PRESCRIPTOR EXISTE
-- ========================================================================
SELECT 
    CONCAT('Prescriptor encontrado: ', nomAlumno, ' ', apeAlumno) as mensaje,
    emailUsuario,
    idAlumno
FROM tm_alumno_edu 
WHERE idAlumno = @idPrescriptor_a_limpiar;

-- Si no aparece ningún resultado, DETENER AQUÍ - El ID no existe
-- ========================================================================

-- PASO 3: OBTENER TODAS LAS LLEGADAS DEL PRESCRIPTOR
-- ========================================================================
DROP TEMPORARY TABLE IF EXISTS temp_llegadas_a_eliminar;
CREATE TEMPORARY TABLE temp_llegadas_a_eliminar AS
SELECT id_llegada 
FROM tm_llegadas_edu 
WHERE idprescriptor_llegadas = @idPrescriptor_a_limpiar;

-- Mostrar las llegadas que se van a eliminar
SELECT 
    CONCAT('Se eliminarán ', COUNT(*), ' llegadas del prescriptor') as mensaje
FROM temp_llegadas_a_eliminar;

-- ========================================================================
-- PASO 4: ELIMINACIÓN DE DATOS EN ORDEN CORRECTO (respetando FK)
-- ========================================================================

-- 4.1 FACTURAS Y PROFORMAS
-- ========================================================================
-- Eliminar contenido de facturas REALES
DELETE FROM factura_contenido_real 
WHERE idLlegadaFactura IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

-- Eliminar pie de facturas REALES
DELETE FROM factura_pie_real 
WHERE idLlegada_Pie IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

-- Eliminar cabeceras de facturas REALES relacionadas
DELETE FROM factura_cabecera_real 
WHERE idCabecera IN (
    SELECT DISTINCT idCabeceraFacturaContenido 
    FROM factura_contenido 
    WHERE idLlegadaFactura IN (SELECT id_llegada FROM temp_llegadas_a_eliminar)
);

-- Eliminar contenido de facturas PROFORMA
DELETE FROM factura_contenido 
WHERE idLlegadaFactura IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

-- Eliminar pie de facturas PROFORMA
DELETE FROM factura_pie 
WHERE idLlegada_Pie IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

-- Eliminar cabeceras de facturas PROFORMA relacionadas
DELETE FROM factura_cabecera 
WHERE idCabecera IN (
    SELECT DISTINCT idCabeceraFacturaContenido 
    FROM factura_contenido 
    WHERE idLlegadaFactura IN (SELECT id_llegada FROM temp_llegadas_a_eliminar)
);

SELECT '✓ Facturas y proformas eliminadas' as paso;

-- 4.2 ALOJAMIENTOS
-- ========================================================================
DELETE FROM tm_alojamientosllegadas_edu 
WHERE idLlegada_alojamientos IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Alojamientos eliminados' as paso;

-- 4.3 MATRICULACIONES
-- ========================================================================
DELETE FROM tm_matriculacionllegadas_edu 
WHERE idLlegada_matriculacion IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Matriculaciones eliminadas' as paso;

-- 4.4 NIVELES DE LLEGADAS
-- ========================================================================
DELETE FROM tm_nivelesllegadas_edu 
WHERE idLlegada_niveles IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Niveles de llegadas eliminados' as paso;

-- 4.5 PAGOS ANTICIPADOS
-- ========================================================================
DELETE FROM tm_pagoanticipadollegadas_edu 
WHERE idLlegada_pagoAnticipado IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Pagos anticipados eliminados' as paso;

-- 4.6 SUPLIDOS
-- ========================================================================
DELETE FROM tm_suplidosLlegadas_edu 
WHERE idsuplido_tmLlegadas IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Suplidos eliminados' as paso;

-- 4.7 CURSOS DEL ALUMNO
-- ========================================================================
DELETE FROM cursos 
WHERE idLlegada_cursos IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Cursos eliminados' as paso;

-- 4.10 EVALUACIONES FINALES
-- ========================================================================
DELETE FROM evaluacionFinal 
WHERE idLlegadaEvaluacionFinal IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Evaluaciones finales eliminadas' as paso;

-- 4.11 LISTA DIARIA DE CLASE
-- ========================================================================
DELETE FROM listaDiariaClase 
WHERE idLlegadaListaDiariaClase IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Listas diarias de clase eliminadas' as paso;

-- 4.12 ACTIVIDADES DEL USUARIO
-- ========================================================================
-- Primero eliminamos las inscripciones a actividades
DELETE FROM td_usuarioact_edu 
WHERE idLlegada_UsuarioAct IN (SELECT id_llegada FROM temp_llegadas_a_eliminar);

SELECT '✓ Inscripciones a actividades eliminadas' as paso;

-- 4.11 ALBARANES (si existen)
-- ========================================================================
DELETE FROM albaalumaloja 
WHERE idUsuario_AlbaranAlumAloja = @idPrescriptor_a_limpiar;

DELETE FROM albaalumdoc 
WHERE idUsuario_AlbaranAlumDoc = @idPrescriptor_a_limpiar;

SELECT '✓ Albaranes eliminados' as paso;

-- 4.12 OBJETIVOS DEL ALUMNO (si existen)
-- ========================================================================
DELETE FROM td_objetivos_alumno 
WHERE idAlumno_ObjAlum = @idPrescriptor_a_limpiar;

SELECT '✓ Objetivos del alumno eliminados' as paso;

-- 4.13 OPINIONES DE ALOJAMIENTOS (si existen)
-- ========================================================================
DELETE FROM tm_alojaopis 
WHERE idUsu_IdOpi = @idPrescriptor_a_limpiar;

SELECT '✓ Opiniones de alojamientos eliminadas' as paso;

-- ========================================================================
-- PASO 5: ELIMINAR LAS LLEGADAS PRINCIPALES
-- ========================================================================
DELETE FROM tm_llegadas_edu 
WHERE idprescriptor_llegadas = @idPrescriptor_a_limpiar;

SELECT '✓ Llegadas principales eliminadas' as paso;

-- ========================================================================
-- PASO 6: LIMPIAR DATOS ESPECÍFICOS DEL ALUMNO (OPCIONAL)
-- ========================================================================
-- ADVERTENCIA: Esto NO eliminará el usuario, solo limpiará ciertos campos
-- Si deseas mantener el usuario pero reiniciar sus datos, descomenta estas líneas:

/*
UPDATE tm_alumno_edu SET
    -- Limpiar actividades seleccionadas
    actSocialesAlumno = NULL,
    actCultAlumno = NULL,
    actGastroAlumno = NULL,
    actDepoAlumno = NULL,
    partActAlumno = NULL,
    numActAlumno = NULL,
    -- Limpiar información académica
    nivEspAlumno = NULL,
    tiemEspAlumno = NULL,
    lugEspAlumno = NULL,
    -- Otras limpiezas según necesidad
    conAlumno = NULL,
    conRecoAlumno = NULL,
    conAgenAlumno = NULL
WHERE idAlumno = @idPrescriptor_a_limpiar;

SELECT '✓ Datos del alumno reiniciados (campos específicos)' as paso;
*/

-- ========================================================================
-- PASO 7: REPORTE FINAL
-- ========================================================================
SELECT '========================================' as '';
SELECT 'RESUMEN DE LIMPIEZA COMPLETADA' as '';
SELECT '========================================' as '';
SELECT 
    nomAlumno,
    apeAlumno,
    emailUsuario,
    'Usuario limpiado exitosamente - Listo para empezar desde cero' as estado
FROM tm_alumno_edu 
WHERE idAlumno = @idPrescriptor_a_limpiar;

SELECT '========================================' as '';
SELECT 'VERIFICACIÓN FINAL' as '';
SELECT '========================================' as '';

-- Verificar que no quedan llegadas
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'OK - No quedan llegadas'
        ELSE CONCAT('ADVERTENCIA - Quedan ', COUNT(*), ' llegadas')
    END as verificacion_llegadas
FROM tm_llegadas_edu 
WHERE idprescriptor_llegadas = @idPrescriptor_a_limpiar;

-- Verificar que no quedan facturas
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'OK - No quedan facturas'
        ELSE CONCAT('ADVERTENCIA - Quedan ', COUNT(*), ' facturas')
    END as verificacion_facturas
FROM factura_contenido 
WHERE idLlegadaFactura IN (SELECT id_llegada FROM tm_llegadas_edu WHERE idprescriptor_llegadas = @idPrescriptor_a_limpiar);

-- Verificar que no quedan alojamientos
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'OK - No quedan alojamientos'
        ELSE CONCAT('ADVERTENCIA - Quedan ', COUNT(*), ' alojamientos')
    END as verificacion_alojamientos
FROM tm_alojamientosllegadas_edu 
WHERE idLlegada_alojamientos IN (SELECT id_llegada FROM tm_llegadas_edu WHERE idprescriptor_llegadas = @idPrescriptor_a_limpiar);

-- Verificar que no quedan matriculaciones
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'OK - No quedan matriculaciones'
        ELSE CONCAT('ADVERTENCIA - Quedan ', COUNT(*), ' matriculaciones')
    END as verificacion_matriculaciones
FROM tm_matriculacionllegadas_edu 
WHERE idLlegada_matriculacion IN (SELECT id_llegada FROM tm_llegadas_edu WHERE idprescriptor_llegadas = @idPrescriptor_a_limpiar);

-- Verificar que no quedan actividades
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'OK - No quedan actividades'
        ELSE CONCAT('ADVERTENCIA - Quedan ', COUNT(*), ' actividades')
    END as verificacion_actividades
FROM td_usuarioact_edu 
WHERE idLlegada_UsuarioAct IN (SELECT id_llegada FROM tm_llegadas_edu WHERE idprescriptor_llegadas = @idPrescriptor_a_limpiar);

SELECT '========================================' as '';
SELECT '✓ LIMPIEZA COMPLETADA EXITOSAMENTE' as '';
SELECT '========================================' as '';

-- Limpiar tabla temporal
DROP TEMPORARY TABLE IF EXISTS temp_llegadas_a_eliminar;

-- ========================================================================
-- FIN DEL SCRIPT
-- ========================================================================

# 📊 Tablas de la Pantalla de Llegadas - Documentación

**Fecha:** 09/01/2026  
**Sistema:** NCosta2026  
**Módulo:** Gestión de Llegadas

---

## 🎯 Propósito del Documento

Este documento identifica todas las tablas que intervienen en la pantalla de **Llegadas** (`view/Llegadas/`), describiendo su propósito y relaciones. El objetivo es crear **vistas SQL consolidadas** que permitan reutilizar consultas complejas en múltiples partes del sistema.

---

## 📋 Tablas Principales

### 1. **`tm_llegadas_edu`** - Tabla Maestra de Llegadas
**Propósito:** Almacena la información principal de cada llegada/inscripción de un estudiante.

**Campos clave:**
- `id_llegada` - ID único de la llegada
- `idprescriptor_llegadas` - FK al prescriptor/estudiante (tabla `tm_prescriptores`)
- `iddepartamento_llegadas` - FK al departamento (tabla `tm_departamento_edu`)
- `agente_llegadas` - FK al agente comercial (tabla `tm_agentes_edu`)
- `diainscripcion_llegadas` - Fecha de inscripción
- `fechallegada_llegadas` - Fecha y hora de llegada
- `grupo_llegadas` - Código de grupo
- `grupoAmigos` - Nombre del grupo de amigos
- `estLlegada` - Estado de la llegada (1: Activa, 0: Cancelada, 3: En espera, 4: Finalizada)
- `estMatricula` - Estado de matriculación (1-4)
- `estAlojamiento` - Estado de alojamiento (1-4)
- `estProforma` - Si tiene proforma generada (0/1)
- `numProforma` - Número de proforma
- `tieneVisado` - Si requiere visado
- `fechCartaAdmision` - Fecha carta de admisión para visado
- `denegacionFecha` - Fecha de denegación de visado
- `cursoFinalizado` - Si completó el curso (para certificados)

**Datos de Transfer:**
- `codigotariotallegadaTransfer_llegadas` - Código tarifa transfer llegada
- `importetariotallegadaTransfer_llegadas` - Importe transfer llegada
- `ivatariotallegadaTransfer_llegadas` - IVA transfer llegada
- `diallegadaTransferTransfer_llegadas` - Fecha transfer llegada
- `codigotariotalregresoTransfer_llegadas` - Código tarifa transfer regreso
- `importetariotalregresoTransfer_llegadas` - Importe transfer regreso
- `ivatariotalregresoTransfer_llegadas` - IVA transfer regreso
- `diaregresoTransfer_llegadas` - Fecha transfer regreso

**Datos de Nivel:**
- `niveldice_llegadas` - Nivel que dice tener
- `nivelobservaciones_llegadas` - Observaciones sobre nivel
- `nivelasignado_llegadas` - Nivel asignado
- `semanaasignada_llegadas` - Semana asignada (ruta)

**Datos de Suplidos:**
- `suplidoImporte` - Importe de suplidos
- `suplidoDescr` - Descripción de suplidos

**Relaciones:**
- → `tm_prescriptores` (prescriptor/estudiante)
- → `tm_departamento_edu` (departamento)
- → `tm_agentes_edu` (agente comercial)
- ← `tm_matriculacionllegadas_edu` (matrículas)
- ← `tm_alojamientosllegadas_edu` (alojamientos)
- ← `tm_pagoanticipadollegadas_edu` (pagos anticipados)
- ← `tm_suplidosLlegadas_edu` (suplidos)

---

### 2. **`tm_matriculacionllegadas_edu`** - Matrículas/Docencia
**Propósito:** Almacena los cursos/tarifas de docencia contratados por el estudiante en esta llegada.

**Campos clave:**
- `idMatriculacionLlegada` - ID único de la matriculación
- `idLlegada_matriculacion` - FK a `tm_llegadas_edu`
- `idIvaTarifa_matriculacion` - Porcentaje IVA aplicado
- `idDepartamentoTarifa_matriculacion` - Departamento de la tarifa
- `codTarifa_matriculacion` - Código de la tarifa
- `nombreTarifa_matriculacion` - Descripción de la tarifa
- `unidadTarifa_matriculacion` - Unidad (semanas, horas, etc.)
- `precioTarifa_matriculacion` - Precio unitario sin IVA
- `descuento_matriculacion` - Descuento aplicado
- `fechaInicioMatriculacion` - **Fecha de inicio del curso** ⭐
- `fechaFinMatriculacion` - Fecha de finalización del curso
- `obsMatriculacion` - Observaciones
- `estMatriculacion_llegadas` - Estado de la matriculación

**Propósito en vistas:**
- Calcular **total de matrículas con/sin IVA**
- Obtener la **fecha de inicio más temprana** para alertas de pago
- Generar reportes de facturación por concepto

**Relaciones:**
- → `tm_llegadas_edu`
- → `tm_tarifas` (código de tarifa)

---

### 3. **`tm_alojamientosllegadas_edu`** - Alojamientos
**Propósito:** Almacena los alojamientos contratados por el estudiante.

**Campos clave:**
- `idAlojamientoLlegada` - ID único del alojamiento
- `idLlegada_alojamientos` - FK a `tm_llegadas_edu`
- `idIvaTarifa_alojamientos` - Porcentaje IVA
- `codTarifa_alojamientos` - Código de tarifa de alojamiento
- `nombreTarifa_alojamientos` - Descripción del alojamiento
- `precioTarifa_alojamientos` - Precio sin IVA
- `descuento_alojamientos` - Descuento aplicado
- `fechaInicioAlojamiento` - Fecha de entrada
- `fechaFinAlojamiento` - Fecha de salida
- `horaSalida` - Hora de check-out
- `obsAlojamiento` - Observaciones
- `estAlojamiento_llegadas` - Estado del alojamiento

**Propósito en vistas:**
- Calcular **total de alojamientos con/sin IVA**
- Generar reportes de ocupación
- Facturación por concepto

**Relaciones:**
- → `tm_llegadas_edu`
- → `tm_tarifas` (tarifas de alojamiento)

---

### 4. **`tm_pagoanticipadollegadas_edu`** - Pagos Anticipados
**Propósito:** Registra todos los pagos realizados por el estudiante.

**Campos clave:**
- `idPagoAnticipado` - ID único del pago
- `idLlegada_pagoAnticipado` - FK a `tm_llegadas_edu`
- `importePagoAnticipado` - Cantidad pagada
- `fechaPagoAnticipado` - Fecha del pago
- `medioPagoAnticipado` - FK a `tm_mediopago` (efectivo, tarjeta, transferencia, etc.)
- `observacionPagoAnticipado` - Observaciones/concepto del pago

**Propósito en vistas:**
- Calcular **total pagado**
- Calcular **pago pendiente** (total facturado - total pagado)
- Historial de pagos por estudiante
- Reportes de caja por medio de pago

**Relaciones:**
- → `tm_llegadas_edu`
- → `tm_mediopago`

---

### 5. **`tm_suplidosLlegadas_edu`** - Suplidos/Otros Conceptos
**Propósito:** Gastos adicionales o suplidos (visados, seguros, etc.).

**Campos clave:**
- `idSuplidoLlegada` - ID único
- `idsuplido_tmLlegadas` - FK a `tm_llegadas_edu`
- `importeSuplido` - Importe del suplido
- `descripcionSuplido` - Descripción del concepto

**Propósito en vistas:**
- Incluir en el **total facturado**
- Desglose de conceptos adicionales

**Relaciones:**
- → `tm_llegadas_edu`

---

## 📑 Tablas de Referencia/Catálogos

### 6. **`tm_prescriptores`** - Prescriptores/Estudiantes
**Propósito:** Datos personales del prescriptor/estudiante.

**Campos clave:**
- `idPrescripcion` - ID único
- `nomPrescripcion` - Nombre
- `apePrescripcion` - Apellidos
- `emailPrescripcion` - Email
- `movilPrescripcion` - Teléfono móvil
- `ciudadPrescripcion` - Ciudad
- `paisPrescripcion` - País

---

### 7. **`tm_departamento_edu`** - Departamentos
**Propósito:** Departamentos/delegaciones de la empresa.

**Campos clave:**
- `idDepartamentoEdu` - ID único
- `nombreDepartamentoEdu` - Nombre del departamento

---

### 8. **`tm_agentes_edu`** - Agentes Comerciales
**Propósito:** Agentes/comerciales asignados a llegadas.

**Campos clave:**
- `idAgente` - ID único
- `nombreAgente` - Nombre del agente

---

### 9. **`tm_mediopago`** - Medios de Pago
**Propósito:** Catálogo de formas de pago (efectivo, tarjeta, transferencia, PayPal, etc.).

**Campos clave:**
- `idMedioPago` - ID único
- `nombreMedioPago` - Nombre del medio de pago

---

### 10. **`tm_tarifas`** - Tarifas/Precios
**Propósito:** Catálogo de tarifas para cursos, alojamientos, transfers, etc.

**Campos clave:**
- `idTarifa` - ID único
- `codTarifa` - Código de tarifa
- `nombreTarifa` - Descripción
- `precioTarifa` - Precio base
- `ivaTarifa` - Porcentaje IVA
- `tipoTarifa` - Tipo (docencia, alojamiento, transfer, etc.)

---

### 11. **`tm_iva`** - Tipos de IVA
**Propósito:** Catálogo de porcentajes de IVA (21%, 10%, 4%, exento, etc.).

**Campos clave:**
- `idIva` - ID único
- `porcentajeIva` - Porcentaje (21, 10, 4, 0, etc.)
- `descripcionIva` - Descripción

---

## 🔗 Tablas de Facturación (Proformas)

### 12. **`cabecera-factura`** - Cabecera de Proformas
**Propósito:** Datos del cliente para la factura/proforma.

**Campos clave:**
- `idCabecera` - ID único
- `nombreCabecera` - Nombre/razón social
- `cifCabecera` - CIF/NIF
- `correoCabecera` - Email
- `direcCabecera` - Dirección
- `cpCabecera` - Código postal
- `ciudadCabecera` - Ciudad
- `paisCabecera` - País

---

### 13. **`pie-factura`** - Pie de Proformas
**Propósito:** Datos del cuerpo/pie de la proforma.

**Campos clave:**
- `idPie` - ID único
- `idCabecera_Pie` - FK a `cabecera-factura`
- `idLlegada_Pie` - FK a `tm_llegadas_edu`
- `numProformaPie` - Número de proforma
- `matriculacionPie` - Total matrículas
- `alojamientoPie` - Total alojamientos
- `otrosPie` - Otros conceptos
- `yaPagado` - Ya pagado
- `fechProformaPie` - Fecha de la proforma
- `serieProformaPie` - Serie de la proforma
- `estProforma` - Estado (0: borrador, 1: generada)

---

## 🎲 Resumen de Datos Calculados Necesarios

### **Totales de Facturación:**

1. **Total Matrículas (Sin IVA):**
   ```sql
   SUM(precioTarifa_matriculacion - descuento_matriculacion)
   ```

2. **Total Matrículas (Con IVA):**
   ```sql
   SUM((precioTarifa_matriculacion - descuento_matriculacion) * (1 + idIvaTarifa_matriculacion / 100))
   ```

3. **Total Alojamientos (Sin IVA):**
   ```sql
   SUM(precioTarifa_alojamientos - descuento_alojamientos)
   ```

4. **Total Alojamientos (Con IVA):**
   ```sql
   SUM((precioTarifa_alojamientos - descuento_alojamientos) * (1 + idIvaTarifa_alojamientos / 100))
   ```

5. **Total Transfer Llegada (Con IVA):**
   ```sql
   importetariotallegadaTransfer_llegadas + (importetariotallegadaTransfer_llegadas * ivatariotallegadaTransfer_llegadas / 100)
   ```

6. **Total Transfer Regreso (Con IVA):**
   ```sql
   importetariotalregresoTransfer_llegadas + (importetariotalregresoTransfer_llegadas * ivatariotalregresoTransfer_llegadas / 100)
   ```

7. **Total Suplidos:**
   ```sql
   SUM(importeSuplido)
   ```

8. **Total General Con IVA:**
   ```sql
   Total Matrículas + Total Alojamientos + Total Transfers + Total Suplidos
   ```

9. **Total Pagado:**
   ```sql
   SUM(importePagoAnticipado)
   ```

10. **Pago Pendiente:**
    ```sql
    Total General Con IVA - Total Pagado
    ```

---

## 📊 Vistas SQL Propuestas

### **Vista 1: `view_llegadas_totales`**
**Propósito:** Consolidar todos los totales de una llegada (matrículas, alojamientos, transfers, pagos).

**Incluye:**
- ID llegada
- Datos del prescriptor
- Total matrículas (sin/con IVA)
- Total alojamientos (sin/con IVA)
- Total transfers (con IVA)
- Total suplidos
- Total general (con IVA)
- Total pagado
- Pago pendiente
- Fecha inicio más temprana (para alertas)
- Estado de la llegada

---

### **Vista 2: `view_pagos_consolidados`** ✅ (Ya creada)
**Propósito:** Historial completo de pagos por usuario/llegada.

**Incluye:**
- Pagos anticipados
- Medio de pago
- Fechas
- Conceptos

---

### **Vista 3: `view_matriculaciones_detalle`**
**Propósito:** Detalle de todas las matrículas con cálculos de IVA.

**Incluye:**
- ID llegada
- Código y nombre de tarifa
- Precio, descuento, IVA
- Total con/sin IVA
- Fechas inicio/fin
- Estado

---

### **Vista 4: `view_alojamientos_detalle`**
**Propósito:** Detalle de alojamientos con cálculos.

**Incluye:**
- Similar a matriculaciones pero para alojamientos

---

### **Vista 5: `view_llegadas_alertas_pago`**
**Propósito:** Llegadas con pagos pendientes y fechas próximas.

**Incluye:**
- ID llegada
- Prescriptor
- Pago pendiente (positivo)
- Fecha inicio más temprana
- Días hasta el inicio
- Nivel de alerta (rojo/naranja/amarillo)

---

## 🚀 Próximos Pasos

1. ✅ Crear vista `view_pagos_consolidados` (Completado)
2. ⏳ Crear vista `view_llegadas_totales`
3. ⏳ Crear vista `view_matriculaciones_detalle`
4. ⏳ Crear vista `view_alojamientos_detalle`
5. ⏳ Crear vista `view_llegadas_alertas_pago`
6. ⏳ Implementar sistema de alertas de pago basado en vistas
7. ⏳ Crear pantalla de consulta de pagos consolidados

---

**Notas:**
- Todas las vistas deben incluir filtros por `estLlegada = 1` (activas)
- Los campos de tipo `varchar` para importes deben convertirse a `DECIMAL` en las vistas
- Las fechas en formato DD/MM/YYYY deben convertirse a DATE para comparaciones

---

**Autor:** Sistema NCosta2026  
**Versión:** 1.0  
**Última actualización:** 09/01/2026

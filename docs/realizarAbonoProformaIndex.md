# Función realizarAbonoProformaIndex()

## Descripción General

La función `realizarAbonoProformaIndex()` gestiona el proceso de abono de facturas proforma en el sistema de facturación educativa NCosta2026. Esta función se encarga de anular una factura proforma existente mediante un abono negativo, registrando el motivo del abono y actualizando el estado de la factura en la base de datos.

## Ubicación

**Archivo:** [view/Factura_Edu/index.js](../view/Factura_Edu/index.js#L1168)  
**Línea:** 1168

## Firma de la Función

```javascript
function realizarAbonoProformaIndex(idPie, numFactura)
```

## Parámetros

| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `idPie` | String | ID del registro en la tabla `factura_pie` que identifica de forma única la factura proforma |
| `numFactura` | String | Número de la factura proforma (solo informativo para mostrar al usuario) |

### Origen de los Parámetros

Los parámetros provienen del botón PHP ubicado en [view/Factura_Edu/index.php](../view/Factura_Edu/index.php#L637):

```php
<?php if ($existeFacturaReal == 0): ?>
    <button type="button" class="btn btn-danger btn-icon" 
            onclick="realizarAbonoProformaIndex('<?php echo $idPie; ?>','<?php echo $numeroFactura;?>')">
        <div> Abonar Proformas</div>
    </button>
<?php else: ?>
    <button type="button" class="btn btn-secondary btn-icon" disabled>
        <div> Abonar Proforma</div>
    </button>
<?php endif; ?>
```

**Nota:** El botón solo está habilitado cuando `$existeFacturaReal == 0`, es decir, cuando NO existe una factura real asociada.

## Flujo de Ejecución

### 1. Cierre de Modal Bootstrap

```javascript
$('#buscar-facturas-modal').modal('hide');
idDepartamento = $('#idDepartamento').val();
```

- Cierra cualquier modal de búsqueda de facturas que pueda estar abierto
- Captura el ID del departamento desde un campo oculto del formulario

### 2. Confirmación con SweetAlert2

```javascript
setTimeout(() => {
    swal.fire({
        title: 'Abonar',
        html: `
            <p>¿Desea abonar la Proforma?</p>
            <textarea id="motivoAbono" class="swal2-textarea" placeholder="Motivo del abono"></textarea>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Abonar',
        cancelButtonText: 'No',
        reverseButtons: true,
        focusConfirm: false,
        didOpen: () => {
            $('#motivoAbono').focus();
        }
    })
}, 300);
```

- Espera 300ms para asegurar que el modal anterior se cerró correctamente
- Muestra un diálogo de confirmación con SweetAlert2
- Incluye un campo de texto `<textarea>` para que el usuario ingrese el motivo del abono
- El campo de texto recibe el foco automáticamente al abrir el diálogo

### 3. Validación del Motivo

```javascript
const motivoAbono = $('#motivoAbono').val().trim();

if (!motivoAbono) {
    swal.fire('Error', 'Debe ingresar un motivo para el abono', 'error');
    return;
}
```

- Captura el valor del motivo del abono y elimina espacios en blanco
- **Validación obligatoria:** Si el motivo está vacío, muestra un error y detiene la ejecución

### 4. Petición AJAX al Backend

```javascript
$.post("../../controller/proforma.php?op=abonarFacturaPro", {
    idPie: idPie,
    motivo: motivoAbono,
    idDepartamento: idDepartamento
}, function (data) {
    $('#facturas_table').DataTable().ajax.reload();
    
    Swal.fire(
        'Abonada',
        'La factura ha sido abonada',
        'success'
    ).then(() => {
        setTimeout(() => {
            location.reload();
        }, 1000);
    });
});
```

- Envía una petición POST al controlador `proforma.php` con la operación `abonarFacturaPro`
- **Datos enviados:**
  - `idPie`: ID de la factura proforma
  - `motivo`: Motivo del abono ingresado por el usuario
  - `idDepartamento`: ID del departamento educativo
- **Callback de éxito:**
  - Recarga la tabla DataTable de facturas
  - Muestra mensaje de éxito con SweetAlert2
  - Recarga la página completa después de 1 segundo

## Backend - Controlador

**Archivo:** [controller/proforma.php](../controller/proforma.php#L992)  
**Operación:** `abonarFacturaPro`

```php
case "abonarFacturaPro":
    $idPie = $_POST['idPie'];
    $motivoAbono = $_POST['motivo'];
    $idDepartamento = $_POST['idDepartamento'];
    
    $proforma->abonarFacturaPro($idPie, $motivoAbono, $idDepartamento);
    break;
```

El controlador recibe los parámetros POST y delega la lógica de negocio al modelo `Proforma`.

## Backend - Modelo

**Archivo:** [models/Proforma.php](../models/Proforma.php#L529)  
**Método:** `abonarFacturaPro()`

### Lógica de Negocio

1. **Obtiene el número de abono actual del departamento:**

```php
$sql = "SELECT numFacturaProNegDepa, prefijoAbonoProEdu 
        FROM tm_departamento_edu 
        WHERE idDepartamentoEdu = $idDepartamento";
```

2. **Incrementa el contador de abonos:**

```php
$numFacturaActual = (int)$resultado['numFacturaProNegDepa'];
$numFacturaAbono = $numFacturaActual + 1;
```

3. **Actualiza el contador en la tabla de departamentos:**

```php
$sql = "UPDATE tm_departamento_edu 
        SET numFacturaProNegDepa = $numFacturaAbono 
        WHERE idDepartamentoEdu = $idDepartamento";
```

4. **Actualiza el estado de la factura proforma:**

```php
date_default_timezone_set('Europe/Madrid');
$fecha = date('Y-m-d H:i:s');

$sql = "UPDATE `factura_pie` 
        SET `estProforma`='0',
            `abonadaFacturaPro`='$numFacturaAbono',
            `abonadaFechaFacturaPro` = '$fecha',
            `abonadaMotivoFacturaPro` = '$motivoAbono' 
        WHERE idPie = '$idPie'";
```

### Campos Actualizados en `factura_pie`

| Campo | Valor | Descripción |
|-------|-------|-------------|
| `estProforma` | `'0'` | Marca la proforma como abonada (0 = abonada, 1 = facturada, NULL = en proforma) |
| `abonadaFacturaPro` | Número de abono generado | Número secuencial del abono de proforma |
| `abonadaFechaFacturaPro` | Fecha y hora actual (Europe/Madrid) | Timestamp del momento del abono |
| `abonadaMotivoFacturaPro` | Motivo ingresado por el usuario | Justificación del abono para auditoría |

## Tablas de Base de Datos Involucradas

### `tm_departamento_edu`
- **Campo usado:** `numFacturaProNegDepa` - Contador de abonos de proforma
- **Campo usado:** `prefijoAbonoProEdu` - Prefijo para el número de abono
- **Operación:** Lectura y actualización del contador

### `factura_pie`
- **Campos actualizados:** 
  - `estProforma` → `'0'`
  - `abonadaFacturaPro` → Número de abono
  - `abonadaFechaFacturaPro` → Timestamp actual
  - `abonadaMotivoFacturaPro` → Motivo del abono
- **Operación:** Actualización del registro identificado por `idPie`

## Ejemplo de Uso

### Desde la Vista PHP

```php
<!-- Botón solo visible cuando NO existe factura real -->
<?php if ($existeFacturaReal == 0): ?>
    <button type="button" class="btn btn-danger btn-icon" 
            onclick="realizarAbonoProformaIndex('<?php echo $idPie; ?>','<?php echo $numeroFactura;?>')">
        <div> Abonar Proformas</div>
    </button>
<?php endif; ?>
```

### Llamada Directa desde JavaScript

```javascript
// Ejemplo: Abonar la factura proforma con ID "12345" y número "PRO-2024-001"
realizarAbonoProformaIndex('12345', 'PRO-2024-001');
```

## Validaciones y Controles

1. ✅ **Validación de motivo obligatorio:** No permite abonar sin especificar un motivo
2. ✅ **Confirmación del usuario:** Requiere confirmación explícita mediante diálogo
3. ✅ **Control de estado:** El botón solo se habilita cuando `$existeFacturaReal == 0`
4. ✅ **Registro de auditoría:** Guarda el motivo, fecha y número de abono en BD
5. ✅ **Actualización automática:** Recarga la página después de la operación exitosa

## Dependencias

### JavaScript
- **jQuery:** Para manipulación del DOM y peticiones AJAX
- **SweetAlert2:** Para diálogos modales de confirmación y alertas
- **DataTables:** Para la recarga automática de la tabla de facturas

### PHP
- **Clase Proforma:** Modelo que contiene la lógica de negocio
- **Sesión PHP:** Para obtener datos del usuario logueado
- **PDO:** Para la conexión y ejecución de consultas SQL

## Posibles Mejoras

1. **Manejo de errores AJAX:** Agregar callback de error para manejar fallos de red o del servidor
2. **Validación de longitud del motivo:** Establecer un mínimo de caracteres para el motivo
3. **Uso de prepared statements:** El modelo debería usar consultas preparadas para prevenir SQL injection
4. **Respuesta JSON del backend:** El controlador podría retornar JSON con estado de éxito/error
5. **Logs de auditoría:** Registrar en una tabla de logs quién realizó el abono y cuándo

## Notas Importantes

- ⚠️ **Estado `estProforma`:** El valor `'0'` significa "abonada", lo cual puede ser contraintuitivo. Considerar renombrar o documentar claramente estos estados.
- ⚠️ **SQL Injection:** El código actual es vulnerable a SQL injection. Se recomienda usar prepared statements con parámetros vinculados.
- ⚠️ **Timezone:** La función usa `Europe/Madrid` hardcodeado. Considerar mover a configuración global.
- ⚠️ **Archivos JSON de debug:** El código genera archivos `.json` para debug (`Ab.json`, `A234.json`, `A1Rea3s.json`) que deberían eliminarse en producción.

## Estados de Factura Proforma

| Valor `estProforma` | Significado | Descripción |
|---------------------|-------------|-------------|
| `NULL` o no definido | En Proforma | Factura proforma activa, no convertida a real |
| `'1'` | Facturada | Convertida a factura real/oficial |
| `'0'` | Abonada | Factura proforma abonada (anulada) |

## Historial de Cambios

- **2026-01-14:** Documentación inicial de la función `realizarAbonoProformaIndex()`

---

**Autor de la documentación:** GitHub Copilot  
**Última actualización:** 14 de enero de 2026

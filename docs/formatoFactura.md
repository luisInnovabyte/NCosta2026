# Formato de Factura - Costa de Valencia

## Descripción General
Documento que describe el diseño y formato visual aplicado a las facturas de Costa de Valencia, para ser replicado en las facturas de abono.

## Estructura del Documento

### 1. Dimensiones y Contenedor Principal
```css
.factura {
    width: 850px;
    min-height: 980px;
    margin: 40px auto;
    padding: 45px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.05);
}
```

### 2. Cabecera (Header)

#### Logo y Datos de la Empresa
- **Ubicación**: Lado izquierdo
- **Ancho máximo**: 50%
- **Contenido**:
  - Logo (altura: 70px)
  - Dirección
  - Teléfono y Fax
  - Web

```css
.logo-section {
    max-width: 50%;
    font-size: 13px;
    color: #64748b;
    line-height: 1.8;
}
```

#### Cuadro de Cliente
- **Ubicación**: Lado derecho
- **Ancho**: 48%
- **Diseño**: Fondo degradado azul con información del cliente
- **Etiqueta "FACTURA"**: Posición absoluta superior derecha

```css
.factura-titulo {
    width: 48%;
    padding: 25px;
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25);
    color: white;
}
```

**Campos mostrados** (condicionales):
- Nombre del cliente
- CIF/NIF
- Dirección completa
- Email
- Teléfono/Móvil

### 3. Información de la Factura

Dos tablas pequeñas lado a lado:
- **Fecha**
- **Número de factura**

```css
.info-factura {
    display: flex;
    gap: 30px;
    margin: 30px 0;
}
```

Estilo de tablas:
- Cabecera: Degradado azul (#3b82f6 → #60a5fa)
- Cuerpo: Fondo blanco con borde
- Border-radius: 8px

### 4. Tabla Principal de Conceptos

#### Columnas
1. Código
2. Concepto
3. Tipo
4. Descuento (%)
5. Base Imponible (€)
6. IVA (%)
7. Total (€)

#### Estilo
```css
#facturaTabla {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* Cabecera */
thead th {
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    padding: 14px 16px;
}

/* Filas alternadas */
tbody tr:nth-child(odd) {
    background-color: #f8fafc;
}

tbody tr:nth-child(even) {
    background-color: white;
}

/* Hover */
tbody tr:hover {
    background-color: #dbeafe !important;
    transform: scale(1.01);
}
```

### 5. Tabla de Totales Horizontales

```css
.totales-horizontal {
    width: 100%;
    margin-top: 30px;
    font-size: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
```

**Columnas**:
- Base Imponible
- IVA (%)
- IVA (Euros)
- TOTAL (IVA Incl.)

**Estilo de cabecera**: Degradado azul oscuro (#2563eb → #3b82f6)

### 6. Sección de Suplidos

Tabla compacta con estilo minimalista:
```css
#suplidosTabla {
    font-size: 0.85rem;
    border: none;
    background: transparent;
}

#suplidosTabla th,
#suplidosTabla td {
    padding: 4px 8px;
    border: none;
    background: transparent;
}
```

**Columnas**:
- Descripción
- Importe Suplido

### 7. Tabla Resumen Final

Muestra:
- Total (IVA Incl.)
- Total Suplidos
- Total General

### 8. Pie de Página

#### Texto Libre
- Muestra `textoLibreFacturaReal` si existe
- Muestra información de pagos anticipados si existen

#### Forma de Pago
```
FORMA DE PAGO: Efectivo o transferencia bancaria
IBAN: ES25 0049 0780 4421 1185 6713
SWIFT: BSCH ES MM XXX
```

#### Pie Legal
```
COSTA DE VALENCIA S.L. · Avda. Blasco Ibáñez 66, 46021 Valencia
CIF: B96734593 · Tel.: (+34) 963 610 367
Email: info@costadevalencia.com
```

## Paleta de Colores

| Elemento | Color Principal | Color Secundario |
|----------|----------------|------------------|
| Gradientes principales | `#3b82f6` | `#60a5fa` |
| Gradiente totales | `#2563eb` | `#3b82f6` |
| Fondo alternado | `#f8fafc` | `#ffffff` |
| Hover filas | `#dbeafe` | - |
| Texto gris | `#64748b` | `#1e293b` |
| Bordes | `#e2e8f0` | `#f0f0f0` |

## Tipografía

- **Fuente principal**: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI'
- **Fuente URL**: `https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700`

### Tamaños
- Cuerpo general: 13-14px
- Cabeceras tabla: 12px
- Título "FACTURA": 28px
- Pie de página: 11px

## Consideraciones para Impresión

```css
@media print {
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        width: 210mm;
        height: 297mm;
        margin: 10mm;
    }

    .factura {
        box-shadow: none !important;
    }
}
```

### Compactación para Impresión
- Márgenes reducidos a 0
- Padding de celdas: 2-4px
- Line-height: 1.1
- Espaciado entre secciones mínimo

## Notas de Implementación

### Condicionales PHP
Todos los campos del cliente se muestran condicionalmente:
```php
<?php if (!empty($nombreCabecera)): ?>
    <div class="cliente-nombre">...</div>
<?php endif; ?>
```

### IDs JavaScript Importantes
- `#idFactura`, `#tipoFactura`, `#idLlegada`: Inputs ocultos
- `#fechaFactura`, `#numeroFactura`: Labels de info
- `#baseImponible`, `#ivaTotal`, `#totalConIva`: Totales
- `#totalSuplidos`, `#totalConSuplidos`: Resumen suplidos

### Archivos de Depuración
El código genera archivos JSON para debug:
- `IDFACTURA.json`: Parámetros recibidos
- `DTS21.json`: Datos recuperados de BD

## Aplicación en Facturas de Abono

Para replicar este formato en facturas de abono:

1. **Cambiar etiqueta**: "FACTURA" → "FACTURA DE ABONO"
2. **Mantener toda la estructura** visual y de colores
3. **Mantener tabla de conceptos** con las mismas columnas
4. **Adaptar totales** si es necesario (importes negativos)
5. **Revisar texto libre** específico para abonos
6. **Mantener sección de suplidos** si aplica

### Diferencias Esperadas
- Números de factura diferentes (serie de abono)
- Posibles importes negativos
- Referencia a factura original (añadir campo si es necesario)
# Diseño Modal de Confirmación - Generación de Facturas

## Descripción
Este documento describe el diseño profesional y colorido del modal de confirmación utilizado en el proceso de generación de facturas proforma. El modal está implementado con **SweetAlert2** y presenta un diseño moderno con degradado azul corporativo.

---

## 📋 Características del Diseño

### Elementos Visuales
- **Header con degradado azul** (#0066cc) en la parte superior
- **Título en azul corporativo** (#0066cc) con emoji 📋
- **Icono de advertencia naranja** (#ff9800) para llamar la atención
- **Caja de información destacada** con fondo azul claro (#e3f2fd)
- **Borde lateral azul** (5px solid #0066cc) en información principal
- **Animación de entrada** (zoomIn) dinámica
- **Backdrop oscuro** (40% opacidad) para resaltar el modal

### Paleta de Colores
| Color | Código | Uso |
|-------|--------|-----|
| Azul corporativo | `#0066cc` | Título, bordes, botón confirmar |
| Azul claro | `#e3f2fd` | Fondo caja información |
| Azul oscuro | `#1565c0` | Texto principal en caja |
| Naranja | `#ff9800` | Icono warning |
| Gris | `#757575` | Botón cancelar |
| Gris texto | `#424242` | Texto descriptivo |

---

## 💻 Código Completo

```javascript
Swal.fire({
    title: '<div style="color:#0066cc; font-size:1.9rem; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.05);">📋 Generar Factura Proforma</div>',
    html: `
        <div style="background:#ffffff; border:2px solid #0066cc; padding:1.5rem; margin:1.5rem 0; border-radius:8px; box-shadow:0 2px 8px rgba(0,102,204,0.1);">
            <div style="background:#e3f2fd; padding:1rem; border-radius:6px; margin-bottom:1rem; border-left:5px solid #0066cc;">
                <p style="font-size:1.05rem; color:#1565c0; margin:0; font-weight:600; line-height:1.6;">
                    <i class="fa-solid fa-file-invoice" style="margin-right:8px; font-size:1.2rem;"></i>
                    Esta acción generará una <strong>Factura Proforma Oficial</strong>
                </p>
            </div>
            <div style="padding:0.75rem 0;">
                <p style="font-size:0.95rem; color:#424242; margin:0 0 0.5rem 0; line-height:1.6;">
                    ✓ Se utilizarán los datos de facturación actuales
                </p>
                <p style="font-size:0.95rem; color:#424242; margin:0; line-height:1.6;">
                    ⚠️ Solo podrá anularse mediante proceso de abono
                </p>
            </div>
        </div>
    `,
    icon: 'warning',
    iconColor: '#ff9800',
    showCancelButton: true,
    confirmButtonText: '<i class="fa-solid fa-check-circle" style="margin-right:10px;"></i>Sí, Generar Factura',
    cancelButtonText: '<i class="fa-solid fa-times-circle" style="margin-right:8px;"></i>Cancelar',
    confirmButtonColor: '#0066cc',
    cancelButtonColor: '#757575',
    background: 'linear-gradient(to bottom, #0066cc 60px, #ffffff 60px)',
    width: '650px',
    padding: '0 0 2rem 0',
    customClass: {
        popup: 'shadow-lg',
        title: 'pt-3 pb-2',
        htmlContainer: 'px-4 pb-4',
        confirmButton: 'btn btn-primary px-5 py-2 fw-bold',
        cancelButton: 'btn btn-secondary px-4 py-2 ms-3',
        actions: 'pb-3'
    },
    buttonsStyling: false,
    showClass: {
        popup: 'animate__animated animate__zoomIn animate__faster'
    },
    backdrop: 'rgba(0,0,0,0.4)'
}).then((result) => {
    if (result.isConfirmed) {
        // Código a ejecutar al confirmar
    }
});
```

---

## 🔧 Parámetros Configurables

### Título
```javascript
title: '<div style="color:#0066cc; font-size:1.9rem; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.05);">
    📋 [TU TÍTULO AQUÍ]
</div>'
```
- **Emoji**: Cambiar 📋 por el icono deseado
- **Texto**: Reemplazar "Generar Factura Proforma"

### Contenido HTML
La sección `html` contiene dos bloques:

1. **Caja destacada** (fondo azul claro):
```html
<div style="background:#e3f2fd; padding:1rem; border-radius:6px; margin-bottom:1rem; border-left:5px solid #0066cc;">
    <p style="...">
        <i class="fa-solid fa-file-invoice"></i>
        [MENSAJE PRINCIPAL]
    </p>
</div>
```

2. **Lista de puntos**:
```html
<div style="padding:0.75rem 0;">
    <p style="...">✓ [PUNTO 1]</p>
    <p style="...">⚠️ [PUNTO 2]</p>
</div>
```

### Botones
```javascript
confirmButtonText: '<i class="fa-solid fa-check-circle" style="margin-right:10px;"></i>[TEXTO CONFIRMAR]',
cancelButtonText: '<i class="fa-solid fa-times-circle" style="margin-right:8px;"></i>[TEXTO CANCELAR]'
```

### Dimensiones
- **Ancho**: `width: '650px'` - Ajustar según necesidad
- **Padding inferior**: `padding: '0 0 2rem 0'` - Espacio debajo de botones

---

## 📦 Variantes Disponibles

### Variante Éxito (Success)
```javascript
icon: 'success',
iconColor: '#28a745',
background: 'linear-gradient(to bottom, #28a745 60px, #ffffff 60px)',
confirmButtonColor: '#28a745',
title: '<div style="color:#28a745; ...">✅ [TÍTULO]</div>'
```

### Variante Error
```javascript
icon: 'error',
iconColor: '#dc3545',
background: 'linear-gradient(to bottom, #dc3545 60px, #ffffff 60px)',
confirmButtonColor: '#dc3545',
title: '<div style="color:#dc3545; ...">❌ [TÍTULO]</div>'
```

### Variante Información
```javascript
icon: 'info',
iconColor: '#17a2b8',
background: 'linear-gradient(to bottom, #17a2b8 60px, #ffffff 60px)',
confirmButtonColor: '#17a2b8',
title: '<div style="color:#17a2b8; ...">ℹ️ [TÍTULO]</div>'
```

---

## 🎨 Iconos Font Awesome

### Iconos Recomendados
- **Factura**: `fa-file-invoice`, `fa-file-invoice-dollar`
- **Confirmación**: `fa-check-circle`, `fa-circle-check`
- **Cancelar**: `fa-times-circle`, `fa-circle-xmark`
- **Guardar**: `fa-save`, `fa-floppy-disk`
- **Imprimir**: `fa-print`, `fa-file-pdf`
- **Editar**: `fa-edit`, `fa-pen-to-square`
- **Eliminar**: `fa-trash`, `fa-trash-can`

---

## 📋 Ejemplos de Uso

### Ejemplo 1: Generación de Factura Real
```javascript
Swal.fire({
    title: '<div style="color:#0066cc; font-size:1.9rem; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.05);">💰 Generar Factura Real</div>',
    html: `
        <div style="background:#ffffff; border:2px solid #0066cc; padding:1.5rem; margin:1.5rem 0; border-radius:8px; box-shadow:0 2px 8px rgba(0,102,204,0.1);">
            <div style="background:#e3f2fd; padding:1rem; border-radius:6px; margin-bottom:1rem; border-left:5px solid #0066cc;">
                <p style="font-size:1.05rem; color:#1565c0; margin:0; font-weight:600; line-height:1.6;">
                    <i class="fa-solid fa-file-invoice-dollar" style="margin-right:8px; font-size:1.2rem;"></i>
                    Esta acción generará una <strong>Factura Real Oficial</strong>
                </p>
            </div>
            <div style="padding:0.75rem 0;">
                <p style="font-size:0.95rem; color:#424242; margin:0 0 0.5rem 0; line-height:1.6;">
                    ✓ Se enviará automáticamente al cliente
                </p>
                <p style="font-size:0.95rem; color:#424242; margin:0; line-height:1.6;">
                    ⚠️ Esta acción es irreversible
                </p>
            </div>
        </div>
    `,
    icon: 'warning',
    iconColor: '#ff9800',
    confirmButtonText: '<i class="fa-solid fa-check-circle" style="margin-right:10px;"></i>Sí, Generar Factura',
    // ... resto de configuración
});
```

### Ejemplo 2: Confirmación de Eliminación
```javascript
Swal.fire({
    title: '<div style="color:#dc3545; font-size:1.9rem; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.05);">🗑️ Eliminar Registro</div>',
    html: `
        <div style="background:#ffffff; border:2px solid #dc3545; padding:1.5rem; margin:1.5rem 0; border-radius:8px; box-shadow:0 2px 8px rgba(220,53,69,0.1);">
            <div style="background:#f8d7da; padding:1rem; border-radius:6px; margin-bottom:1rem; border-left:5px solid #dc3545;">
                <p style="font-size:1.05rem; color:#721c24; margin:0; font-weight:600; line-height:1.6;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right:8px; font-size:1.2rem;"></i>
                    ¿Está seguro de eliminar este registro?
                </p>
            </div>
            <div style="padding:0.75rem 0;">
                <p style="font-size:0.95rem; color:#424242; margin:0 0 0.5rem 0; line-height:1.6;">
                    ⚠️ Esta acción no se puede deshacer
                </p>
                <p style="font-size:0.95rem; color:#424242; margin:0; line-height:1.6;">
                    ℹ️ Se eliminarán todos los datos asociados
                </p>
            </div>
        </div>
    `,
    icon: 'warning',
    iconColor: '#dc3545',
    confirmButtonText: '<i class="fa-solid fa-trash" style="margin-right:10px;"></i>Sí, Eliminar',
    confirmButtonColor: '#dc3545',
    // ... resto de configuración
});
```

### Ejemplo 3: Confirmación de Guardado
```javascript
Swal.fire({
    title: '<div style="color:#28a745; font-size:1.9rem; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.05);">💾 Guardar Cambios</div>',
    html: `
        <div style="background:#ffffff; border:2px solid #28a745; padding:1.5rem; margin:1.5rem 0; border-radius:8px; box-shadow:0 2px 8px rgba(40,167,69,0.1);">
            <div style="background:#d4edda; padding:1rem; border-radius:6px; margin-bottom:1rem; border-left:5px solid #28a745;">
                <p style="font-size:1.05rem; color:#155724; margin:0; font-weight:600; line-height:1.6;">
                    <i class="fa-solid fa-save" style="margin-right:8px; font-size:1.2rem;"></i>
                    Los cambios realizados se guardarán permanentemente
                </p>
            </div>
            <div style="padding:0.75rem 0;">
                <p style="font-size:0.95rem; color:#424242; margin:0 0 0.5rem 0; line-height:1.6;">
                    ✓ Se actualizarán todos los registros
                </p>
                <p style="font-size:0.95rem; color:#424242; margin:0; line-height:1.6;">
                    ℹ️ Puede revertir los cambios posteriormente
                </p>
            </div>
        </div>
    `,
    icon: 'info',
    iconColor: '#28a745',
    confirmButtonText: '<i class="fa-solid fa-check-circle" style="margin-right:10px;"></i>Guardar',
    confirmButtonColor: '#28a745',
    // ... resto de configuración
});
```

---

## ⚙️ Clases CSS Utilizadas

### Bootstrap 5
- `btn btn-primary` - Botón principal
- `btn btn-secondary` - Botón secundario
- `px-4, px-5` - Padding horizontal (4 = 1.5rem, 5 = 3rem)
- `py-2` - Padding vertical (2 = 0.5rem)
- `pt-3, pb-2, pb-3, pb-4` - Padding top/bottom
- `fw-bold` - Font weight bold
- `shadow-lg` - Sombra grande

### Animate.css
- `animate__animated` - Clase base para animaciones
- `animate__zoomIn` - Animación de zoom al aparecer
- `animate__faster` - Velocidad de animación más rápida

---

## 🔍 Notas Importantes

### Dependencias Requeridas
1. **SweetAlert2** (v11+)
   ```html
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   ```

2. **Font Awesome** (v6+)
   ```html
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   ```

3. **Animate.css** (v4+)
   ```html
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
   ```

4. **Bootstrap 5** (para clases de botones)
   ```html
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   ```

### Mejores Prácticas
1. **Consistencia**: Mantener el mismo diseño en todos los modales del sistema
2. **Accesibilidad**: Asegurar que los colores tengan suficiente contraste
3. **Responsive**: El modal se adapta a pantallas pequeñas (width: 650px máximo)
4. **UX**: El backdrop oscuro mejora la visibilidad del modal
5. **Feedback**: Usar iconos y colores apropiados según el tipo de acción

### Personalización
Para adaptar a otros sistemas:
- Cambiar `#0066cc` por el color corporativo deseado
- Ajustar `width` según las necesidades del contenido
- Modificar los textos de advertencia según el contexto
- Adaptar los iconos Font Awesome al tipo de operación

---

## 📝 Checklist de Implementación

- [ ] Verificar que SweetAlert2 esté instalado
- [ ] Confirmar que Font Awesome esté disponible
- [ ] Incluir Animate.css para animaciones
- [ ] Asegurar Bootstrap 5 para estilos de botones
- [ ] Copiar el código del modal
- [ ] Personalizar título y emoji
- [ ] Adaptar mensajes del contenido HTML
- [ ] Ajustar textos de botones
- [ ] Configurar colores según el tipo de acción
- [ ] Implementar lógica en `then((result) => {...})`
- [ ] Probar en diferentes navegadores
- [ ] Validar responsive en móviles

---

## 📍 Ubicación del Código Original

**Archivo**: `view/FacturaPro_Edu/index.js`  
**Líneas**: 1205-1247  
**Función**: `$("#guardarFacturaBoton").on("click", function() { ... })`

---

## 🔄 Historial de Versiones

### v1.0 (14/01/2026)
- Diseño inicial con degradado azul corporativo
- Título en color azul #0066cc
- Iconos Font Awesome integrados
- Animación zoomIn implementada
- Espaciado inferior optimizado (2rem padding)
- Backdrop oscuro al 40%

---

**Última actualización**: 14 de enero de 2026  
**Autor**: Equipo de Desarrollo NCosta2026  
**Estado**: ✅ Aprobado y en uso

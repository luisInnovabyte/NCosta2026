# Formato Maestro - Estilos de Interfaz Costa de Valencia

Este documento describe los estilos profesionales a aplicar en todas las páginas de mantenimiento y gestión de la aplicación.

---

## 🎨 Colores Corporativos

| Color | Código HEX | Uso |
|-------|------------|-----|
| Azul Costa de Valencia | `#1AA3E8` | Color primario, headers, botones |
| Azul Bootstrap | `#0d6efd` | Color secundario para gradientes |
| Gris texto | `#6c757d` | Texto tabs inactivos |
| Blanco | `#fff` | Texto sobre fondos azules |

---

## 📋 CSS a Incluir en la Sección `<style>`

```css
/* Estilos profesionales para la página */
.page-header-custom {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
}
.page-header-custom h2 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
}
.page-header-custom p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 0.9rem;
}
.nav-tabs-custom .nav-link {
    border: none;
    color: #6c757d;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
    transition: all 0.2s ease;
}
.nav-tabs-custom .nav-link:hover {
    color: #1AA3E8;
    background-color: rgba(26, 163, 232, 0.1);
}
.nav-tabs-custom .nav-link.active {
    color: #fff;
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
}
.btn-add-record {
    background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-add-record:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 163, 232, 0.4);
}
```

---

## 🏷️ Header de Página

Reemplazar títulos genéricos como `<h2 class="card-title">Título</h2>` por:

```html
<!-- Header profesional -->
<div class="page-header-custom">
    <h2><i class='bx bx-ICONO me-2'></i>Título de la Sección</h2>
    <p>Descripción breve de lo que hace esta sección</p>
</div>
```

### Iconos sugeridos por sección (BoxIcons):
- Configuración: `bx-cog`
- Usuarios: `bx-user`
- Cursos: `bx-book`
- Alojamientos: `bx-home`
- Facturas: `bx-receipt`
- Horarios: `bx-calendar`
- Reportes: `bx-bar-chart-alt-2`

---

## 📑 Tabs de Navegación

Cambiar `nav-danger`, `nav-primary`, etc. por la clase personalizada:

```html
<!-- ANTES -->
<ul class="nav nav-tabs nav-danger" role="tablist">

<!-- DESPUÉS -->
<ul class="nav nav-tabs nav-tabs-custom" role="tablist">
```

---

## ➕ Botones de Agregar

Uniformizar todos los botones de agregar registros:

```html
<!-- ANTES -->
<div class="col-12 d-flex justify-content-end mg-b-10">
    <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#modal-id">
        Agregar Elemento
    </button>
</div>

<!-- DESPUÉS -->
<div class="col-12 d-flex justify-content-end mb-3">
    <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#modal-id">
        <i class="bx bx-plus me-1"></i>Agregar Elemento
    </button>
</div>
```

---

## 🗑️ Elementos a Eliminar

1. **Secciones de "Mostrar Leyenda"** - Son redundantes, los iconos estándar (editar, activar, desactivar) son autoexplicativos.

2. **Clases de ancho fijo en botones** - Eliminar `col-12 col-lg-1`, `col-12 col-lg-2`, etc. de los botones de agregar.

3. **Márgenes personalizados obsoletos** - Cambiar `mg-b-10` por `mb-3` (Bootstrap 5).

---

## ✅ Checklist de Aplicación

Al modificar una página, verificar:

- [ ] CSS de estilos incluido en `<style>`
- [ ] Header con clase `page-header-custom`
- [ ] Tabs con clase `nav-tabs-custom`
- [ ] Botones de agregar con clase `btn-add-record` e icono `bx-plus`
- [ ] Eliminada sección de leyenda (si existía)
- [ ] Márgenes actualizados a Bootstrap 5

---

## 📁 Páginas donde aplicar

- [ ] `view/MntPreinscriptores_Edu/index.php` ✅ (Ya aplicado)
- [ ] `view/Alumnos_Edu/index.php`
- [ ] `view/Cursos_Edu/index.php`
- [ ] `view/Horarios_Edu/index.php`
- [ ] `view/Facturacion/index.php`
- [ ] (Agregar más según se identifiquen)

---

**Última actualización:** 7 de enero de 2026

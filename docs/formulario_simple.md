# Guía de Estilo: Formulario Modal Profesional

Este documento describe la estructura y estilos aplicados a los modales de formulario para mantener consistencia visual en toda la aplicación.

---

## Estructura Base del Modal

```html
<div id="[nombre]-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header bg-[color] bg-gradient text-white py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-[icono]"></i> Título del Modal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            
            <!-- Body -->
            <div class="modal-body p-4">
                <form id="[nombreForm]" method="POST">
                    <div class="row g-4">
                        <!-- Campos aquí -->
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-[color] px-4" title="Guardar" onClick="[funcion]()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
```

---

## Colores por Tipo de Acción

| Acción | Color Header | Color Botón | Icono Sugerido |
|--------|--------------|-------------|----------------|
| **Agregar/Crear** | `bg-primary` | `btn-primary` | `bi-plus-circle`, `bi-person-plus-fill` |
| **Editar** | `bg-warning text-dark` | `btn-warning` | `bi-pencil-square`, `bi-pen` |
| **Eliminar** | `bg-danger` | `btn-danger` | `bi-trash`, `bi-x-circle` |
| **Ver/Info** | `bg-info` | `btn-info` | `bi-eye`, `bi-info-circle` |
| **Configuración** | `bg-secondary` | `btn-secondary` | `bi-gear`, `bi-sliders` |

> **Nota:** Para headers con `bg-warning`, usar `text-dark` en lugar de `text-white` y `btn-close` sin la clase `btn-close-white`.

---

## Estructura de Campo de Formulario

### Campo con Input Group (Recomendado)

```html
<div class="col-12 col-lg-6">
    <label for="[idCampo]" class="form-label fw-semibold text-secondary">
        <i class="bi bi-[icono] me-1"></i> Nombre del Campo <span class="text-danger">*</span>
    </label>
    <div class="input-group">
        <span class="input-group-text bg-light border-end-0">
            <i class="bi bi-[icono] text-[color]"></i>
        </span>
        <input type="text" 
               class="form-control border-start-0 ps-0" 
               id="[idCampo]" 
               name="[nombreCampo]" 
               placeholder="Texto de ayuda"
               data-type="[tipo]" 
               data-min="[min]" 
               data-max="[max]" 
               data-new-input="1" 
               data-descripcion="1" 
               data-required="[0|1]">
    </div>
</div>
```

### Iconos Sugeridos por Tipo de Campo

| Campo | Icono Label | Icono Input |
|-------|-------------|-------------|
| Nombre/Persona | `bi-person` | `bi-person` |
| Email | `bi-envelope` | `bi-envelope` |
| Teléfono | `bi-telephone` | `bi-telephone` |
| Dirección | `bi-geo-alt` | `bi-house-door` |
| Identificación Fiscal | `bi-card-text` | `bi-upc-scan` |
| Fecha | `bi-calendar` | `bi-calendar-event` |
| Contraseña | `bi-lock` | `bi-key` |
| Búsqueda | `bi-search` | `bi-search` |
| Comentario | `bi-chat-text` | `bi-chat-dots` |
| Empresa | `bi-building` | `bi-building` |
| Web/URL | `bi-globe` | `bi-link-45deg` |
| Dinero | `bi-currency-euro` | `bi-cash` |

---

## Tipos de Validación (data-type)

| data-type | Descripción | Ejemplo de uso |
|-----------|-------------|----------------|
| `0` | Solo letras, acentos, espacios | Nombres simples |
| `1` | Correo electrónico | Email |
| `2` | Teléfono móvil español | Móvil |
| `3` | Letras, números, símbolos comunes | Nombre agente, ID fiscal |
| `4` | Teléfono fijo español | Teléfono fijo |
| `5` | Solo números | Cantidades |
| `6` | Contraseña segura | Passwords |
| `7` | DNI español | DNI |
| `8` | DNI, NIE o CIF español | Documentos fiscales estrictos |
| `9` | Géneros (F/M/O/N) | Selector género |
| `10` | Año (4 dígitos) | Años |
| `11` | Código postal | CP |
| `12` | Teléfono internacional | Tel. internacional |
| `13` | Direcciones completas | Domicilio fiscal, direcciones |
| `14` | Código postal internacional | CP internacional |

---

## Anchos de Columna

```html
<!-- Campo ancho completo -->
<div class="col-12">

<!-- Campo mitad en desktop, completo en móvil -->
<div class="col-12 col-lg-6">

<!-- Campo un tercio en desktop -->
<div class="col-12 col-lg-4">

<!-- Campo dos tercios en desktop -->
<div class="col-12 col-lg-8">
```

---

## Ejemplo Completo: Modal Agregar

```html
<div id="agregar-ejemplo-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary bg-gradient text-white py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Nuevo Elemento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="insertarElemento" method="POST">
                    <div class="row g-4">
                        <!-- Campo Nombre -->
                        <div class="col-12 col-lg-6">
                            <label for="nombre" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person me-1"></i> Nombre <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nombre" name="nombre" placeholder="Ingrese el nombre" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <!-- Campo Email -->
                        <div class="col-12 col-lg-6">
                            <label for="email" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-envelope me-1"></i> Correo Electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="email" name="email" placeholder="ejemplo@correo.com" data-type="1" data-min="5" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary px-4" title="Guardar" onClick="agregarElemento()">
                    <i class="bi bi-check-lg me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
```

---

## Ejemplo Completo: Modal Editar

```html
<div id="editar-ejemplo-modal" class="modal fade" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning bg-gradient text-dark py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Editar Elemento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editarElementoForm" method="POST">
                    <input type="hidden" name="id-elemento" id="id-elemento" value="">
                    <div class="row g-4">
                        <!-- Campo Nombre -->
                        <div class="col-12 col-lg-6">
                            <label for="nombreE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person me-1"></i> Nombre <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nombreE" name="nombreE" placeholder="Ingrese el nombre" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                            </div>
                        </div>
                        <!-- Campo Email -->
                        <div class="col-12 col-lg-6">
                            <label for="emailE" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-envelope me-1"></i> Correo Electrónico
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-warning"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="emailE" name="emailE" placeholder="ejemplo@correo.com" data-type="1" data-min="5" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top-0 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-warning px-4" title="Actualizar" onClick="editarElemento()">
                    <i class="bi bi-check-lg me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
```

---

## Clases CSS Clave

| Clase | Propósito |
|-------|-----------|
| `modal-dialog-centered` | Centra el modal verticalmente |
| `border-0` | Elimina bordes del contenido |
| `shadow` | Añade sombra al modal |
| `bg-gradient` | Añade gradiente sutil al header |
| `btn-close-white` | Botón cerrar blanco (para headers oscuros) |
| `fw-semibold` | Peso de fuente semi-negrita |
| `text-secondary` | Color gris para labels |
| `border-start-0` / `border-end-0` | Elimina borde para unir input con icono |
| `ps-0` | Padding start 0 (acerca texto al icono) |
| `g-4` | Gap de 1.5rem entre filas |
| `px-4` | Padding horizontal en botones |
| `py-3` | Padding vertical en header/footer |

---

## Checklist para Nuevo Formulario

- [ ] Definir ID único del modal
- [ ] Elegir color según tipo de acción
- [ ] Añadir icono descriptivo al título
- [ ] Crear campos con input-group
- [ ] Marcar campos obligatorios con `*`
- [ ] Configurar `data-type` correcto para validación
- [ ] Añadir placeholders descriptivos
- [ ] Configurar función onClick del botón guardar
- [ ] Para modales de edición: añadir input hidden para el ID

---

*Última actualización: Enero 2026*

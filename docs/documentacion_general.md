# Documentación General - Sistema de Gestión para Academia de Idiomas

## 📋 Descripción General

**NCosta2026** es un sistema de gestión integral desarrollado en PHP para la administración de academias de idiomas. El sistema está diseñado específicamente para **Costa Valencia** (academia de español), permitiendo gestionar todos los aspectos operativos: desde la matriculación de alumnos hasta la facturación, pasando por alojamientos, actividades educativas y evaluaciones.

---

## 🏗️ Arquitectura del Sistema

El proyecto sigue un patrón de arquitectura **MVC (Modelo-Vista-Controlador)** con la siguiente estructura:

```
NCosta2026/
├── BD/                    # Dumps de base de datos MySQL
│   └── Proc_func_Event/   # Procedimientos, funciones y eventos SQL
├── config/                # Configuración del sistema
│   ├── conexion.php       # Conexión a base de datos (PDO)
│   ├── config.php         # Configuración general
│   ├── funciones.php      # Funciones auxiliares globales
│   ├── modalAyudas/       # Sistema de ayuda contextual
│   └── settings/          # Configuraciones por dominio (multi-tenant)
├── controller/            # Controladores (lógica de negocio)
├── models/                # Modelos (acceso a datos)
├── view/                  # Vistas (interfaz de usuario)
├── public/                # Recursos públicos
│   ├── assets/            # Assets estáticos
│   ├── css/               # Hojas de estilo
│   ├── js/                # JavaScript
│   ├── vendor/            # Dependencias (Composer)
│   └── img/               # Imágenes
└── docs/                  # Documentación
```

---

## 🔧 Tecnologías Utilizadas

| Categoría | Tecnología |
|-----------|------------|
| **Backend** | PHP 7.x/8.x |
| **Base de Datos** | MySQL (MariaDB) |
| **Frontend** | HTML5, CSS3, JavaScript |
| **Framework CSS** | Bootstrap |
| **Tablas de Datos** | DataTables |
| **Email** | PHPMailer |
| **Autenticación** | Google Login (OAuth) |
| **Gestión de Dependencias** | Composer |

---

## 📦 Módulos Principales

### 1. 🎓 **Módulo de Educación (_Edu)**

El núcleo del sistema dedicado a la gestión académica:

| Componente | Descripción |
|------------|-------------|
| **Alumnos** | Gestión completa de estudiantes |
| **Matriculaciones** | Inscripción en cursos y programas |
| **Grupos** | Organización de clases y grupos de estudio |
| **Niveles** | Clasificación por niveles de idioma |
| **Departamentos** | Organización por áreas educativas |
| **Idiomas** | Gestión de idiomas impartidos |
| **Contenidos** | Material didáctico y currículum |
| **Objetivos** | Metas y objetivos de aprendizaje |
| **Test de Nivel** | Evaluación inicial de estudiantes |
| **Evaluación Final** | Sistema de certificación y evaluaciones finales |

### 2. 🏠 **Módulo de Alojamientos**

Gestión de hospedaje para estudiantes internacionales:

- **Tipos de Alojamiento**: Familias, apartamentos, residencias
- **Habitaciones**: Individual, doble, triple
- **Capacidad y Ocupación**: Control de plazas disponibles
- **Valoraciones**: Sistema de opiniones y puntuación
- **Visitas**: Registro de inspecciones a alojamientos
- **Medidas**: Gestión de tamaños y características

### 3. 🎯 **Módulo de Actividades**

Gestión de actividades extracurriculares:

- Programación de eventos y excursiones
- Control de inscripciones de alumnos
- Horas lectivas y puntos de encuentro
- Gestión de guías/personal responsable

### 4. 📄 **Módulo de Facturación**

Sistema completo de facturación:

| Tipo | Descripción |
|------|-------------|
| **Facturas normales** | Facturación estándar |
| **Proformas** | Presupuestos previos |
| **Abonos** | Devoluciones y rectificaciones |
| **Series** | Numeración por series |
| **IVA** | Gestión de tipos impositivos |
| **Conceptos adicionales** | Suplidos y otros conceptos |

### 5. 🚐 **Módulo de Transfers/Llegadas**

Gestión logística de estudiantes:

- Registro de llegadas y salidas
- Transfers desde/hacia aeropuerto
- Rutas y transportes
- Conductores asignados

### 6. 👥 **Módulo de Personal**

Administración de recursos humanos:

- Personal docente y administrativo
- Contratos y tipos de contrato
- Trabajadores y profesiones
- Asistencia

### 7. 📧 **Módulo de Comunicaciones**

- Configuración SMTP
- Plantillas de email
- Sistema de avisos
- Tickets de soporte

### 8. 👤 **Módulo de Usuarios**

- Autenticación y autorización
- Roles de usuario
- Login con Google
- Recuperación de contraseña
- Zona de alumnos (portal estudiantes)

---

## 🔐 Sistema Multi-Tenant

El sistema soporta **múltiples instancias/clientes** mediante archivos de configuración JSON en `config/settings/`:

```json
{
  "General": {
    "tituloSitio": "Costa Valencia - Educación",
    "logotipo": "logo_pequeno.png"
  },
  "database": {
    "host": "servidor",
    "port": 3308,
    "dbname": "nombre_bd",
    "username": "usuario",
    "password": "contraseña"
  },
  "ftpConfig": {
    "ipFTP": "84.127.234.85",
    "userFTP": "usuario_ftp",
    "passFTP": "contraseña_ftp",
    "portFTP": 21
  }
}
```

La configuración se carga dinámicamente según el **subdominio** de acceso.

---

## 🗄️ Base de Datos

### Tablas Principales (Prefijos)

| Prefijo | Descripción |
|---------|-------------|
| `tm_` | Tablas maestras |
| `td_` | Tablas de detalle/transacciones |
| `view_` | Vistas SQL |

### Entidades Clave

- `tm_usuario` - Usuarios del sistema
- `tm_alumno_edu` - Alumnos
- `tm_prescriptores` - Interesados/Preinscripciones
- `tm_llegadas_edu` - Llegadas de estudiantes
- `tm_matriculacionllegadas_edu` - Matriculaciones
- `tm_aloja` - Alojamientos
- `tm_personal` - Personal
- `tm_actividades` - Actividades

---

## 🔄 Funcionalidades Destacadas

### Seguridad
- Encriptación de IDs en URLs (`encryptNumber`/`decryptNumber`)
- Generación de tokens seguros (32 caracteres)
- Validación de contraseñas (mayúsculas, minúsculas, números)
- Sistema de sesiones PHP

### Logging
- Registro de acciones de usuarios
- Archivos de log por usuario
- Trazabilidad de operaciones

### Utilidades
- Transformación de fechas a formato local
- Formateo de teléfonos y emails como enlaces
- Cálculo de tiempo transcurrido
- Manejo de uploads (imágenes, documentos)

---

## 📁 Archivos de Entrada

| Archivo | Función |
|---------|---------|
| `index.php` | Redirección a login |
| `view/Login/` | Página de inicio de sesión |
| `view/Home/` | Dashboard principal |

---

## 🎨 Personalización

El sistema permite personalización visual por empresa:
- Modo claro/oscuro
- Logotipos personalizables
- Colores principales configurables
- Favicon personalizado

---

## 📝 Notas para el Desarrollo

### Patrón de Controladores

Los controladores utilizan un **switch** basado en el parámetro `$_GET["op"]`:

```php
switch ($_GET["op"]) {
    case "listar":
        // Lógica de listado
        break;
    case "insertar":
        // Lógica de inserción
        break;
    case "editar":
        // Lógica de edición
        break;
}
```

### Respuestas AJAX

Los controladores devuelven datos en formato JSON para DataTables:

```php
$results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
);
echo json_encode($results);
```

---

## 🚀 Despliegue

1. Configurar archivo JSON en `config/settings/[dominio].json`
2. Importar dump de base de datos desde `BD/`
3. Configurar servidor web (Apache/Nginx)
4. Ejecutar `composer install` en `/public`
5. Verificar permisos de escritura en carpetas de uploads

---

## 📌 Información del Proyecto

- **Cliente Principal**: Costa Valencia (Academia de Español)
- **Desarrollador**: Efeuno
- **Tipo**: Sistema de Gestión ERP para Academias
- **Base**: PHP Nativo con estructura MVC

---

*Documentación generada el 7 de enero de 2026*

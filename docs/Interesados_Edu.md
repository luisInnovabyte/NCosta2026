# Documentación Técnica - Módulo Interesados_Edu

**Fecha de creación:** 7 de enero de 2026  
**Módulo:** Gestión de Interesados  
**Ubicación:** `view/Interesados_Edu/`

---

## 📁 Estructura de Archivos

### Archivos de Vista (View)
- **Ubicación:** `view/Interesados_Edu/`
- **Archivos principales:**
  - `index.php` - Vista principal del módulo
  - `index.js` - Lógica JavaScript/jQuery del módulo
  - `modalInfo.php` - Modal de información
  - `modalInformacion.php` - Modal adicional de información
  - `modalGestion.php` - Modal de gestión de interesados
  - `modalTarifas.php` - Modal de tarifas

### Archivos de Controlador (Controller)
- **Ubicación:** `controller/`
- **Archivo:** `prescriptor.php`
- **Descripción:** Controlador principal que maneja todas las operaciones CRUD y lógica de negocio del módulo de interesados

### Archivos de Modelo (Model)
- **Ubicación:** `models/`
- **Archivo:** `Prescriptor.php`
- **Descripción:** Modelo que contiene las consultas SQL y operaciones de base de datos

---

## 🗄️ Base de Datos

### Tabla Principal
**Nombre:** `tm_prescriptores`

**Descripción:** Almacena la información completa de personas interesadas en los programas educativos.

**Campos principales:**
- `idPrescripcion` - ID único del interesado (PK)
- `nomPrescripcion` - Nombre
- `apePrescripcion` - Apellidos
- `sexoPrescripcion` - Sexo
- `fecNacPrescripcion` - Fecha de nacimiento
- `anoPrevistoPrescripcion` - Año previsto de inscripción
- `emailCasaPrescripcion` - Email principal
- `emailAltPrescripcion` - Email alternativo
- `fechContactoPrescripcion` - Fecha de primer contacto
- `dirCasaPrescripcion` - Dirección principal
- `dirAltPrescripcion` - Dirección alternativa
- `cursoPrescripcion` - Curso deseado
- `cpCasaPrescripcion` - Código postal principal
- `cpAltPrescripcion` - Código postal alternativo
- `cono1Prescripcion` - Primer conocimiento (FK)
- `cono2Prescripcion` - Segundo conocimiento (FK)
- `cono3Prescripcion` - Tercer conocimiento (FK)
- `ciudadCasaPrescripcion` - Ciudad principal
- `ciudadAltPrescripcion` - Ciudad alternativa
- `paisCasaPrescripcion` - País principal
- `paisAltPrescripcion` - País alternativo
- `tefCasaPrescripcion` - Teléfono fijo principal
- `tefAltPrescripcion` - Teléfono fijo alternativo
- `movilCasaPrescripcion` - Móvil principal
- `movilAltPrescripcion` - Móvil alternativo
- `probablementePrescripcion` - Probabilidad de inscripción
- `grupoPrescripcion` - Indica si viene en grupo
- `erasmusPrescripcion` - Indica si es Erasmus
- `uniOrigenPrescripcion` - Universidad de origen
- `bildungsurlaub` - Indica si es Bildungsurlaub (FK)
- `auPair` - Indica si es Au Pair
- `preferenciaHoraria` - Preferencia de horario
- `fechMatConfirmacion` - Fecha de confirmación de matrícula
- `matCurso` - Matrícula de curso
- `matAloja` - Matrícula de alojamiento
- `matFechInicio` - Fecha de inicio de matrícula
- `obsPrescriptor` - Observaciones
- `estPrescripcion` - Estado del registro
- `tokenPrescriptores` - Token único
- `numLlegada` - Número de llegada
- `idDepartamentoEdu_prescriptores` - Departamento educativo (FK)
- `fecPrescripcion` - Fecha de registro
- `tipoDocumento` - Tipo de documento de identificación
- `identificadorDocumento` - Número de documento (ÚNICO por departamento)
- `nombreMadrePre` - Nombre de la madre
- `nombrePadrePre` - Nombre del padre
- `numPadrePre` - Teléfono del padre
- `numMadrePre` - Teléfono de la madre
- `interesadoOnlinePre` - Indica si el interesado es online
- `nacionalidadPreinscriptor` - Nacionalidad del interesado

---

### Tablas Relacionadas

#### 1. `tm_usuario`
**Relación:** LEFT JOIN con `tm_prescriptores`  
**Campo de unión:** `tm_usuario.idInscripcion_tmusuario = tm_prescriptores.idPrescripcion`  
**Descripción:** Tabla de usuarios del sistema. Al crear un interesado, automáticamente se crea un usuario con rol 3 (Alumno).  
**Filtro:** `rolUsu = 3` (solo muestra usuarios de tipo alumno)

**Campos relevantes:**
- `idUsuario` - ID único del usuario
- `nickUsu` - Nickname generado automáticamente (nombre + número aleatorio 100-999)
- `correoUsu` - Correo electrónico
- `senaUsu` - Contraseña (MD5: 'AlumnoCosta12' por defecto)
- `rolUsu` - Rol del usuario (3 = Alumno)
- `idInscripcion_tmusuario` - FK a tm_prescriptores

#### 2. `tm_alumno_edu`
**Relación:** Se inserta automáticamente al crear un interesado  
**Campos de unión:**
- `idInscripcion_tmAlumno` → `tm_prescriptores.idPrescripcion`
- `idUsuario_tmalumno` → `tm_usuario.idUsuario`

**Descripción:** Almacena información específica del alumno educativo.

**Campos principales:**
- `idAlumnoEdu` - ID único
- `nomUsuario` - Nickname del usuario
- `emailUsuario` - Email
- `nomAlumno` - Nombre del alumno
- `apeAlumno` - Apellidos del alumno
- `fecNacAlumno` - Fecha de nacimiento
- `identificadorPersonal` - Documento de identidad
- `tokenUsu` - Token único

#### 3. `tm_departamento_edu`
**Relación:** Foreign Key desde `tm_prescriptores`  
**Campo:** `idDepartamentoEdu_prescriptores`  
**Descripción:** Define el departamento educativo al que pertenece el interesado.

**Campos principales:**
- `idDepartamentoEdu` - ID único
- `nombreDepartamentoEdu` - Nombre del departamento
- `numeroFactura` - Número de factura asociado

#### 4. `tm_conocimientos`
**Relación:** Foreign Keys múltiples desde `tm_prescriptores`  
**Campos:** `cono1Prescripcion`, `cono2Prescripcion`, `cono3Prescripcion`  
**Descripción:** Catálogo de conocimientos/fuentes por las que el interesado conoció la institución (hasta 3 opciones).

**Filtro:** `estConocimiento = 1` (solo activos)

**Campos principales:**
- `idConocimiento` - ID único
- `nombreConocimiento` - Nombre del conocimiento
- `estConocimiento` - Estado (1=activo, 0=inactivo)

#### 5. `tm_agentes_edu`
**Relación:** Consultada por ID específico  
**Descripción:** Tabla de agentes educativos que pueden estar relacionados con los interesados.

**Campos principales:**
- `idAgente` - ID único
- (otros campos específicos del agente)

#### 6. `tm_tipocurso`
**Relación:** Indirecta mediante el campo `cursoPrescripcion`  
**Filtro:** `estTipoCurso = 1` (solo activos)  
**Descripción:** Catálogo de tipos de cursos disponibles.

**Campos principales:**
- `idTipoCurso` - ID único
- `nombreTipoCurso` - Nombre del tipo de curso
- `estTipoCurso` - Estado (1=activo, 0=inactivo)

---

## 🔄 Operaciones Principales del Controlador

El archivo `controller/prescriptor.php` maneja las siguientes operaciones (parámetro `?op=`):

1. **`mostrarElementos`** - Lista todos los interesados con sus usuarios asociados (rol 3)
2. **`recogerInfo`** - Obtiene información completa de un interesado específico por ID
3. **`agregarElemento`** - Crea un nuevo interesado y genera automáticamente:
   - Usuario en `tm_usuario` (rol 3, contraseña por defecto)
   - Registro en `tm_alumno_edu`
   - Nickname único (nombre + número aleatorio)
4. **`editarElemento`** - Actualiza los datos de un interesado existente
5. **`actualizarPrescriptor`** - Actualización completa de todos los campos del interesado
6. **`recogerConocimiento`** - Obtiene el catálogo de conocimientos activos
7. **`recogerDepartamento`** - Obtiene información de departamentos educativos

---

## 🔑 Reglas de Negocio

### Identificador Único
- **Campo:** `identificadorDocumento`
- **Restricción:** No pueden existir dos interesados con el mismo identificador **dentro del mismo departamento**
- **Query de validación:**
  ```sql
  SELECT * FROM tm_prescriptores 
  WHERE identificadorDocumento = '$identificador' 
  AND idDepartamentoEdu_prescriptores = '$departamentoSelect'
  ```

### Generación de Nickname
- **Patrón:** `{nombre}{número_aleatorio_3_dígitos}`
- **Ejemplo:** Si el nombre es "Juan", el nickname podría ser `Juan457`
- **Proceso:** Se genera un número aleatorio entre 100-999 y se verifica que no exista en `tm_usuario.nickUsu`
- **Bucle:** Se repite hasta encontrar un nickname único (máximo 4 intentos antes de alertar)

### Creación Automática de Usuario
Al crear un interesado, se generan automáticamente:
1. **Usuario en `tm_usuario`:**
   - Rol: 3 (Alumno)
   - Contraseña: MD5('AlumnoCosta12')
   - Estado: Activo (1)
   - Avatar: 'alumnoAvatar.png'

2. **Registro en `tm_alumno_edu`:**
   - Vinculado al interesado mediante `idInscripcion_tmAlumno`
   - Vinculado al usuario mediante `idUsuario_tmalumno`

### Fechas por Defecto
Cuando una fecha está vacía, se asigna `'1970-01-01'` en los siguientes campos:
- `fecNacPrescripcion`
- `anoPrevistoPrescripcion`
- `fechContactoPrescripcion`
- `fechMatConfirmacion`
- `matFechInicio`

### Menores de Edad
Los interesados menores de 18 años se muestran con estilo visual diferenciado (azul claro) en la tabla.

---

## 📊 DataTables - Configuración

**ID de la tabla:** `prescriptor_table`

**Columnas mostradas:**
1. ID (oculta)
2. Nickname
3. Nombre
4. Identificador (DNI/NIF/NIE)
5. Correo
6. Contacto (teléfono)
7. Nacimiento (tipo date)

**Búsqueda en footer:** Cada columna (excepto ID) tiene un input de búsqueda individual.

**Orden:** DESC por `idPrescripcion` (más recientes primero)

**Server-side:** `true` - Los datos se cargan desde el servidor via AJAX

---

## 🎨 Características de la Interfaz

### Header Profesional
- Gradiente azul corporativo (#1AA3E8 → #0d6efd)
- Icono: `bx-user-check`
- Título: "Gestión de Interesados"
- Botón de ayuda con modal informativo

### Formulario de Edición
Dividido en 5 secciones con cards de colores:
1. **Datos Generales** (fondo azul claro - #e3f2fd)
2. **Datos del Estudiante** (fondo amarillo claro - #fff3e0)
3. **Datos de Contacto** (fondo verde claro - #e8f5e9)
4. **Ubicación** (fondo verde pálido - #f0f4c3)
5. **Observación** (fondo lila claro - #ede4f5)

### Botones Laterales Flotantes
1. **Agregar nuevo** (verde - colorBoton5) - `#newClient`
2. **Gestionar interesado** (rosa - colorBoton6) - `#btnGestion`
3. **Ir a llegadas** (naranja - colorBoton2) - `#btnPreforma`

### Animaciones
- **Entrada del formulario:** `swing-in-top-fwd`
- **Salida del formulario:** `swing-out-top-bck`

---

## 🔗 Integraciones

### Select2
Usado en los siguientes campos:
- `nacionalidadCliente`
- `conocimiento1`, `conocimiento2`, `conocimiento3`
- `departamentoSelect`
- `Bildungsurlaub`
- `tipoDocumento`

### Módulos Relacionados
1. **Llegadas** - Botón para ir directamente al módulo de llegadas
2. **Gestión** - Modal para gestionar información adicional del interesado
3. **Tarifas** - Modal para consultar/asignar tarifas

---

## 📝 Notas Importantes

1. **Token único:** Cada interesado tiene un `tokenPrescriptores` que también se asigna al usuario y alumno creados.

2. **Sincronización de datos:** Al actualizar un interesado, considerar que también puede requerir actualización en `tm_usuario` y `tm_alumno_edu`.

3. **Validación de correos:** Se normaliza el correo (trim y lowercase) antes de guardarlo.

4. **Sanearización de login:** Se aplica función `sanearLogin()` al nombre antes de generar el nickname.

5. **Campos alternativo/casa:** Muchos campos tienen versión "Casa" y "Alt" (alternativa) para mayor flexibilidad de datos.

6. **Edad calculada:** Se calcula dinámicamente en base a `fecNacPrescripcion` para mostrar en la interfaz.

7. **Integración con configuración:** Algunos campos se ocultan/muestran según `$configJsonSetting['MntPrescriptores_Edu']`:
   - `camposAlternativosContacto`
   - `camposAlternativosUbicacion`
   - `campoGrupo`
   - `campoBildungsurlaub`
   - `campoAuPair`
   - `botonFactura`

---

**Última actualización:** 7 de enero de 2026  
**Mantenido por:** Equipo de Desarrollo Costa de Valencia

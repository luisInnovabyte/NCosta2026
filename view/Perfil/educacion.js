/*==================================*/
/*     INICIO DEL DATATABLES        */
/*==================================*/

/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES      */
/*============================================================*/
/*===========================================================*/

// Está en un archivo aparte comunDataTables.js

/*===============================================================*/
/*==============================================================*/
/*                             FIN                             */
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES     */
/*===========================================================*/
/*==========================================================*/

/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LA PARTE PARTICULAR DEL DATATABLES         */
/*============================================================*/
/*===========================================================*/
//datatable index.php

/*===============================================================*/
/*==============================================================*/
/*    DATATABLE DE MATRICULACIONES (SEGUNDA PESTAÑA DE EDUCACIÓN) */
/*============================================================*/
/*===========================================================*/

function getParamFromURL(name) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(name);
}

const tokenUsuario = getParamFromURL("tokenUsuario");

var llegadasTable = $("#llegadas_table").DataTable({
  select: false, // No seleccionable

  language: {
    emptyTable: "Currently, there are no courses available"
  },

  columns: [
    { name: "Nº Llegada", className: "text-center" },           // índice 0
    { name: "Dia Inscripción", className: "text-center" },       // índice 1
    { name: "Fecha Llegada", className: "text-center" },         // índice 2
    { name: "Departamento", className: "text-center" },          // índice 3
    { name: "Matriculas - Alojamiento", className: "text-center" }, // índice 4
    { name: "Estado", className: "text-center" }                  // índice 5
  ],

  columnDefs: [
    { targets: [0, 1, 2, 3, 4, 5], orderable: false }
  ],


  order: [],  // Desactiva el orden inicial por defecto

  searchBuilder: {
    columns: [0, 1, 2, 3, 4, 5]  // búsquedas en todas las columnas visibles
  },

  ajax: {
    url: "../../controller/llegadas.php?op=recogerLlegadasPerfil",
    type: "GET",
    dataType: "json",
    cache: false,

    // Cambiado a false porque no tienes lógica serverSide implementada
    serverSide: false,
    data: function (d) {
      // Agregar el token a los datos enviados
      d.tokenUsuario = tokenUsuario;
    },

    dataSrc: function (json) {
      console.log("Respuesta del servidor:", json);
      if (!json || !json.aaData || json.aaData.length === 0) {
        console.warn("No hay datos para mostrar");
        /* alert("No se encontraron datos para mostrar en la tabla."); */
      }
      return json.aaData || [];
    },

    beforeSend: function () {
      // opcional
    },

    complete: function () {
      $("#llegadas_table").addClass("width-100");
    },

    error: function (e) {
      console.error("Error al cargar el DataTable:", e);
    }
  },

  dom: 'Brtip',
  // Necesario para que aparezcan los botones
  buttons: [],

});

/*===============================================================*/
/*==============================================================*/
/*    DATATABLE DE MIS CURSOS (PRIMERA PESTAÑA DE EDUCACIÓN) */
/*============================================================*/
/*===========================================================*/
idLlegadaMisCursos = $('#idLlegada').val();
if (idLlegadaMisCursos && idLlegadaMisCursos.trim() !== '') {

  var cursos_table = $('#cursos_table').DataTable({

    // Definimos las columnas visibles (orden debe coincidir con lo devuelto por PHP)
    columns: [
      { name: "Ruta", className: "text-center" },                     // 0: Ruta del curso con badges
      { name: "Fecha Inicio", className: "text-center" },             // 1: fechaNuevaCursos (si existe) o fechaCrea_cursos
      { name: "Fecha Fin", className: "text-center" },                // 2: fecFinCurso
      { name: "Acciones", className: "text-center" }  // 3: botones o acciones personalizadas
    ],

    // Configuración avanzada por columna
    columnDefs: [
      // Ruta del curso
      { targets: [0], orderData: [0], visible: true },

      // Fecha de inicio
      { targets: [1], orderData: [1], visible: true, type: "date" },

      // Fecha fin del curso
      { targets: [2], orderData: [2], visible: true, type: "date" },

      // Acciones (botones u otras interacciones)
      { targets: [3], orderable: false, className: "text-center", visible: true }
    ],

    // Fuente de datos vía Ajax
    ajax: {
      url: "../../controller/zonaAlumnos.php?op=listarCursosPorLlegada", // Tu endpoint PHP
      type: "get",
      dataType: "json",
      cache: false,
      serverSide: false,     // Aquí lo dejas en false si no paginas desde el servidor
      processData: true,
      beforeSend: function () {
        // Aquí puedes poner un loader si lo deseas
      },
      complete: function (data) {
        // Opcional: ejecutar algo tras la carga
      },
      error: function (e) {
        console.log(e.responseText);
      }
    },

    // Ordenar por Fecha Inicio por defecto
    orderFixed: [[1, "asc"]],
    dom: 'Brtip',
    // Necesario para que aparezcan los botones
    buttons: [],
  });

  // ANCHO DEL DATATABLE
  $("#cursos_table").addClass("width-100");

  /**************************************************/
  /************ FILTRO DE LOS  PIES  ***************/
  /************************************************/
  $('#FootTipo').on('keyup', function () {
    cursos_table
      .columns(2)
      .search(this.value)
      .draw();
  });

  $('#FootDireccion').on('keyup', function () {
    cursos_table
      .columns(3)
      .search(this.value)
      .draw();
  });
  /************************************************/
  /*    FIN DE LOS FILTROS DE LOS PIES        ****/
  /**********************************************/

  $('#cursos_table').DataTable().on('draw.dt', function () {
    controlarFiltros('cursos_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });
}
//////////////////////////////////////
// DATATABLE DE LLEGADAS DEFINICIÓN //
/////////////////////////////////////

// DATATABLE AL HACER CLICK EN BOTÓN CURSOS DE MATRICULACIONES

var cursosmatriculaciones_table; // Variable global para el DataTable

function cargarModalCursos(idElemento) {
  console.log("Filtrando por ID:", idElemento);

  // Si el DataTable ya está inicializado, solo actualizamos la URL y recargamos los datos
  if ($.fn.DataTable.isDataTable('#cursosMatriculaciones_table')) {
    cursosmatriculaciones_table.ajax.url("../../controller/zonaAlumnos.php?op=listarCursosPorLlegadaSeleccionada&idLlegada=" + idElemento).load();
  } else {
    // Si no está inicializado, lo creamos por primera vez
    cursosmatriculaciones_table = $("#cursosMatriculaciones_table").DataTable({
      buttons: [],
      select: false,
      columns: [
        // Estas son las columnas visibles en la tabla del modal: Ruta, Fecha Inicio, Fecha Fin
        { name: "ruta", title: "Ruta", className: "text-center" },
        { name: "fechaInicio", title: "Fecha Inicio", className: "text-center" },
        { name: "fechaFin", title: "Fecha Fin", className: "text-center" }
      ],
      columnDefs: [
        { targets: [0], orderData: [0], visible: true },
        { targets: [1], orderData: [1], visible: true },
        { targets: [2], orderData: [2], visible: true }
      ],
      orderFixed: [[0, "asc"]],
      searchBuilder: {
        columns: [0, 1, 2]
      },
      ajax: {
        url: "../../controller/zonaAlumnos.php?op=listarCursosPorLlegadaSeleccionada&idLlegada=" + idElemento,
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        beforeSend: function () {
          console.log("Cargando datos para DataTable...");
        },
        error: function (xhr, status, error) {
          console.error("Error en DataTables:");
          console.error("Estado:", status);
          console.error("Error:", error);
          console.error("Respuesta del servidor:", xhr.responseText);

          alert("Error al cargar la tabla: " + error);

          // Mostrar mensaje de error en la tabla
          $("#cursosMatriculaciones_table tbody").html(
            '<tr><td colspan="3" class="text-center text-danger">Error al cargar los datos.</td></tr>'
          );
        }
      },
      dom: 'Brtip',
      // Necesario para que aparezcan los botones
      buttons: [],
    });
  }

  $("#cursosMatriculaciones_table").addClass("width-100"); // Hace la tabla responsive
  $("#cursosmatriculaciones-modal").modal("show");
}

/***************************************/
/****** DATATABLE ACTIVIDADES *********/
/*************************************/

var act_usuario_table = $("#act_usuario_table").DataTable({
  select: false, // No seleccionable

  language: {
    emptyTable: "No hay actividades disponibles"
  },
  dom: 'Brtip',
  buttons: [],
  columns: [
    { name: "actividad", className: "text-center" },           // 0
    { name: "fechaActividad", className: "text-center" },      // 1
    { name: "horasLectivas", className: "text-center" },       // 2
    { name: "puntoEncuentro", className: "text-center" },      // 3
    { name: "cartel", className: "text-center" }               // 4
  ],

  columnDefs: [
    { targets: [0, 1, 2, 3, 4], orderable: false }
  ],

  order: [], // Sin orden inicial

  searchBuilder: {
    columns: [0, 1, 2, 3, 4]  // todas las columnas son buscables
  },

  ajax: {
    url: "../../controller/actividades_edu.php?op=mostrarActUsuarioPerfil",
    type: "GET",
    dataType: "json",
    cache: false,
    serverSide: false,

    // Añadir parámetro idUsuario del input hidden
    data: function (d) {
      d.idUsuario = $("#idUsuario").val();
    },


    beforeSend: function () {
      // Opcional: mostrar loading
    },

    complete: function () {
      $("#act_usuario_table").addClass("width-100");
    },

    error: function (e) {
      console.error("Error al cargar el DataTable:", e);
    }
  }
});

$('#act_usuario_table').on('draw.dt', function () {
  controlarFiltros('act_usuario_table');
});


//////////////////////////////
// DATATABLE DE ALOJAMIENTOS//
//////////////////////////////

var idAlumn = $("#idAlumn").val();

$('#alojamientos_table').DataTable({
  columns: [
    { name: "ID", className: "text-center" },
    { name: "Tipo Alojamiento", className: "text-center" },
    { name: "Nombre", className: "text-center" },
    { name: "Fecha Entrada", className: "text-center" },
    { name: "Fecha Salida", className: "text-center" },
    { name: "Dirección", className: "text-center" },
    { name: "Ver", className: "text-center" }
  ],
  columnDefs: [
    { targets: [0], visible: false, className: 'secundariaDef' },
    { targets: [1], orderData: [1], visible: true },
    { targets: [2], orderData: [1], visible: true },
    { targets: [3], orderData: [3], visible: true },
    { targets: [4], orderData: [4], visible: true },
    { targets: [5], orderData: [5], visible: true },
    { targets: [6], orderable: false, visible: true }
  ],
  ajax: {
    url: "../../controller/alojamientos.php?op=listarAlojamientoHistorico&idAlumn=" + idAlumn,
    type: "GET",
    dataType: "json",
    cache: false,
    serverSide: true,
    processData: true,
    beforeSend: function () {
      // Loader opcional
    },
    complete: function (data) {
      console.log("Datos cargados:", data);
    },
    error: function (e) {
      console.error("Error cargando DataTable:", e.responseText);
    }
  },
  dom: 'rtip',  // Quitamos 'B'
  buttons: [],   // Por si acaso, aunque ya no se usa con 'dom'
  orderFixed: [[1, "asc"]]
  // searchBuilder eliminado
});

// Asignar ancho al DataTable
$("#alojamientos_table").addClass("width-100");

$('#alojamientos_table').DataTable().on('draw.dt', function () {
  controlarFiltros('alojamientos_table');
  // La función está en el mainJs.php, es común para todos
  // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*    DATATABLE DE CERTIFICADOS     */
/*==================================*/

$('#certificados_table').DataTable({
  columns: [
    { name: "Nº Llegada", className: "text-center" },
    { name: "Día Inscripción", className: "text-center" },
    { name: "Departamento", className: "text-center" },
    { name: "Estado", className: "text-center" },
    { name: "Acciones", className: "text-center" }
  ],
  columnDefs: [
    { targets: [0, 1, 2, 3, 4], orderable: false }
  ],
  ajax: {
    url: "../../controller/llegadas.php?op=recogerCertificadosPerfil",
    type: "GET",
    dataType: "json",
    cache: false,
    serverSide: false,
    data: function (d) {
      // Agregar el token a los datos enviados
      d.tokenUsuario = tokenUsuario;
    },
    dataSrc: function (json) {
      console.log("Datos recibidos del servidor CERTIFICADO:", json);
      /* if (!json || !json.aaData || json.aaData.length === 0) {
        alert("No se encontraron certificados para mostrar.");
      } */
      return json.aaData || [];
    },
    error: function (e) {
      console.error("Error cargando certificados_table:", e.responseText);
    }
  },
  language: {
    emptyTable: "No hay certificados disponibles"
  },
  dom: 'rtip',
  buttons: [],
  orderFixed: []
});

// Asignar ancho al DataTable
$("#certificados_table").addClass("width-100");

// Control de filtro activo (si tienes esa función común)
$('#certificados_table').on('draw.dt', function () {
  controlarFiltros('certificados_table');
});

// MENSAJE PARA MOSTRAR EL NO CERTIFICADO
$(document).on('click', '.btn-no-certificado', function () {
    Swal.fire({
        icon: 'info',
        title: 'Certificate not available',
        text: 'Your certificate is not available. Please check with your teacher.',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        background: '#f1f1f1',
        customClass: { popup: 'shadow rounded' }
    });
});


/////////////////////////////////
// ABRIR PÁGINA DE CERTIFICADO //
/////////////////////////////////

$("body").on("click", ".printDocumento", function () {
 
    nuevaVentana = window.open(
      "certificado.php?idOrden=" +
        tokenId +
        "&tipoDocumento=" +
        tipoDocumento +
        "&contenedorActivo=" +
        contenedorActivo +
        "&tipoOrdenTransporte=" +
        tipoOrden,
      "_blank",
      width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes
    );
  
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/
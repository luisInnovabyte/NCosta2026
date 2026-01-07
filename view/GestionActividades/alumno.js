/* CARGAR DATOS SELECT MEDIDA TIPO ALOJAMIENTO */
depasActividad = $('#depasActividad').val();

/////////////////////////////////////
// DATATABLE ALUMNOS MATRICULADOS //
///////////////////////////////////

var tablaLlegadasMatriculado = $('#tablaMatriculados').DataTable({
    columns: [
        { name: "IdLlegada" },
        { name: "UsuarioCompleto" },      // Nickname - Nombre Apellidos juntos
        { name: "Edad", className: "text-center" },
        { name: "CorreoTelefono" },       // Correo / Teléfono juntos
        { name: "FechaInicioMatricula", className: "text-center" }, // Fecha inicio matrícula
        { name: "FechaFinMatricula", className: "text-center" },   // Fecha fin matrícula
        { name: "IdUsuario" },               // Nueva columna para idAlumno
        { name: "Inscripcion", visible: false } 
    ],
    columnDefs: [
        { targets: [0], visible: false, searchable: false, className: "text-center" }, // IdLlegada oculto
        { targets: [1], orderable: true, className: "text-center" },                    // UsuarioCompleto
        { targets: [2], orderable: true, className: "text-center" },                    // Edad
        { targets: [3], orderable: true, className: "text-center" },                    // Correo / Teléfono
        { targets: [4], orderable: true, className: "text-center" },                    // Fecha inicio
        { targets: [5], orderable: true, className: "text-center" },                    // Fecha fin
        { targets: [6], visible: false, searchable: false },                             // IdUsuario oculto
        { targets: [7], visible: false, searchable: false }                             // inscripción oculta
    ],
    ajax: {
        url: '../../controller/actividades_edu.php?op=mostrarListaAlumMatriculados&idAct=' + encodeURIComponent($('#idAct').val()),
        type: 'GET',
        dataType: 'json',
        cache: false,
        serverSide: true,
        processData: true,
        dataSrc: function(json) {
            console.log('Datos recibidos:', json);
            return json.aaData;  // o como sea el array de datos que devuelves
        },
        error: function(e) {
            console.error('Error cargando alumnos matriculados:', e.responseText);
        }
    },
    orderFixed: [[1, 'asc']], // Orden por UsuarioCompleto (nombre)
    searchBuilder: {
        columns: [1, 2, 3, 4, 5]
    },
    createdRow: function(row, data, dataIndex) {
        console.log(row);
                if (data[7] == 1) {
                    $(row).addClass('disabled-row');
                }
            },
});

// ANCHO del DATATABLE
$("#tablaMatriculados").addClass("width-100");

// ACCIÓN AL HACER CLICK EN ALGÚN TR DE LA TABLA DE MATRICULADOS
$('#tablaMatriculados tbody').on('click', 'tr', function () {
  var tabla = $('#tablaMatriculados').DataTable();
  var data = tabla.row(this).data();
  var idUsuario = data[6];   // Suponiendo que esta es la columna del ID del alumno
  var idLlegada = data[0];  // Ajusta al índice correcto del ID llegada
  var idAct = getParameterByName('idAct');
  var inscripcion = data[7]; // Columna del estado de inscripción

  if (inscripcion === 0) {
    insertarAlumnoEnActividad(idUsuario, idAct, idLlegada); //  Pasamos también idLlegada
  } else if (inscripcion === 1){
    toastr.warning('Este alumno ya está inscrito en esta actividad.');
  }
});

////////////////////////////////////////
// DATATABLE ALUMNOS NO MATRICULADOS //
//////////////////////////////////////

var tablaalumnosnomatriculados = $('#tablaNoMatriculados').DataTable({
    columns: [
        { name: "IdAlumno", className: "text-center" },
        { name: "UsuarioCompleto", className: "text-center" },
        { name: "Edad", className: "text-center" },
        { name: "CorreoTelefono", className: "text-center" },
        { name: "IdUsuario", className: "text-center" },
        { name: "Inscripcion", visible: false } 

    ],
    columnDefs: [
        { targets: [0], orderable: true, className: "text-center" },
        { targets: [1], orderable: true, className: "text-center" },
        { targets: [2], orderable: true, className: "text-center" },
        { targets: [3], orderable: true, className: "text-center" },
        { targets: [4], visible: false, searchable: false },
        { targets: [5], visible: true, searchable: false },

    ],
    ajax: {
        url: '../../controller/actividades_edu.php?op=mostrarListaAlum&idAct=' + encodeURIComponent($('#idAct').val()),
        type: 'GET',
        dataType: 'json',
        cache: false,
        serverSide: false,
        processData: true,
        dataSrc: function(json) {
            console.log('Datos recibidos:', json);
            return json.aaData;
        },
        error: function(e) {
            console.error('Error cargando alumnos matriculados:', e.responseText);
        }
    },
    orderFixed: [[1, 'asc']],
    searchBuilder: {
        columns: [0, 1, 2]
    },
    createdRow: function(row, data, dataIndex) {
        console.log(row);
                if (data[5] == 1) {
                    $(row).addClass('disabled-row');
                }
            },
});


// ANCHO del DATATABLE
$("#tablaNoMatriculados").addClass("width-100");

// ACCIÓN AL HACER CLICK EN ALGÚN TR DE LA TABLA DE NO MATRICULADOS
$('#tablaNoMatriculados tbody').on('click', 'tr', function () {
  var tabla = $('#tablaNoMatriculados').DataTable();
  var data = tabla.row(this).data();
  var idUsuario = data[4]; // Columna del ID usuario
  var idAct = getParameterByName('idAct');
  var inscripcion = data[5]; // Columna del estado de inscripción

  if (inscripcion === 0) {
    insertarAlumnoEnActividad(idUsuario, idAct);
  } else if (inscripcion === 1){
    toastr.warning('Este alumno ya está inscrito en esta actividad.');
  }
});


// MÉTODO PARA COMPROBAR QUE EN LA URL EXISTE LA VARIABLE DE IDACT
function getParameterByName(name) {
  const url = window.location.href;
  name = name.replace(/[\\[]/, "\\[").replace(/[\\]]/, "\\]");
  const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// AL HACER CLICK EN LA TABLA DE MATRICULADOS O NO MATRICULADOS, SE INSERTA UN ALUMNO SI CUMPLE CON CIERTOS REQUISITOS
// - ID ACTIVIDAD EXISTENTE EN LA BD
// - QUE EL ALUMNO SELECCIONADO NO ESTE REGISTRADO
// INSERTA AL ALUMNO EN CASO DE NO OCURRIR NADA DE ESOS DOS CASOS 

function insertarAlumnoEnActividad(idAlumno, idAct, idLlegada = null) {
  if (!idAct) {
    toastr.error("Falta el parámetro 'idAct' en la URL. No se puede continuar.", "Error");
    return;
  }
  if (!idAlumno) {
    toastr.error("No se encontró el ID del alumno.", "Error");
    return;
  }

  const formData = new FormData();
  formData.append("idAct", idAct);

  $.ajax({
    url: "../../controller/actividades_edu.php?op=comprobarActividadExiste",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.existe === true) {
        const formDataInsert = new FormData();
        formDataInsert.append("idAct", idAct);
        formDataInsert.append("selectAlumno", idAlumno);
        if (idLlegada) {
          formDataInsert.append("idLlegada", idLlegada);
        }

        $.ajax({
          url: "../../controller/actividades_edu.php?op=insertarAlumnoActividad",
          type: "POST",
          data: formDataInsert,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (insertResp) {
            if (insertResp.status === "success") {
              toastr.success(insertResp.message, "Éxito");
              $('#alumno_table').DataTable().ajax.reload(null, false);

              $('#tablaNoMatriculados').DataTable().ajax.reload(null, false);
              $('#tablaMatriculados').DataTable().ajax.reload(null, false);
              $('#insertar-alumno-modal').modal('hide');
            } else {
              toastr.error(insertResp.message || "No se pudo insertar al alumno.", "Error");
            }
          },
          error: function () {
            toastr.error("Error al insertar al alumno.", "Error del servidor");
          }
        });
      } else {
        toastr.warning("La actividad no existe.", "Error");
      }
    },
    error: function () {
      toastr.error("Error al verificar la actividad.", "Error del servidor");
    }
  });
}




// FORM AÑADIR ALUMNO
// FORM AÑADIR ALUMNO
/*
$("#insertar-alumno-form").on("submit", function (event) {
    event.preventDefault();

    var formData = new FormData($("#insertar-alumno-form")[0]);

    $.ajax({
        url: "../../controller/actividades_edu.php?op=insertarAlumnoActividad",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json", // ← importante para interpretar el JSON del back-end
        success: function (respuesta) {

            if (respuesta.status === "success") {
                Swal.fire(
                    'Lista de Alumnos',
                    'Alumno añadido a la actividad',
                    'success'
                );
            } else {
                Swal.fire(
                    'Atención',
                    respuesta.message, // ← por ejemplo: "El alumno ya está registrado en esta actividad."
                    'warning'
                );
            }

            $('#alumno_table').DataTable().ajax.reload();
            $('#insertar-alumno-modal').modal('hide');

        },
        error: function () {
            Swal.fire(
                'Error',
                'Hubo un problema al registrar el alumno',
                'error'
            );
        }
    });
});
*/

/***************************************/
/*********** BOTONES DE ACTIVAR Y DESACTIVAR *********/
/*************************************/
function asistir(idAct) {
    swal.fire({
        title: 'Lista de Alumnos',
        text: "¿El alumno se ha presentado a la actividad?",
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: 'Sí',
        denyButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Código para cuando el usuario ha confirmado la acción
            $.post("../../controller/actividades_edu.php?op=asistir", { idUsuarioAct: idAct }, function (data) {
                $('#alumno_table').DataTable().ajax.reload();
            });
        } else if (result.dismissed === "overlay") {
            // Código para cuando el usuario ha hecho clic fuera del diálogo
            // No se realiza ninguna acción
        } else {
            // Código para cuando el usuario ha descartado la acción haciendo clic en el botón "No"

            $.post("../../controller/actividades_edu.php?op=noAsistir", { idUsuarioAct: idAct }, function (data) {
                $('#alumno_table').DataTable().ajax.reload();
            });
        }
    });
}


function darBaja(idUsuarioAct) {
    swal.fire({
        title: 'Alumno',
        text: "¿Desea dar de baja al alumno de la actividad?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/actividades_edu.php?op=darBaja", { idUsuarioAct: idUsuarioAct }, function (data) {
                $('#alumno_table').DataTable().ajax.reload();
            });

            swal.fire(
                'Alumno',
                'Se ha eliminado el alumno',
                'success'
            )
        }
    })
}


/***************************************/
/*********** DATATABLE Alumno *********/
/*************************************/
idActividad = $('#idActividad').val();

var documentos_table = $('#alumno_table').DataTable({

    columns: [
        { name: "id", "className": "text-center" },
        { name: "nombre", "className": "text-center" },
        { name: "fechaAlta", "className": "text-center" },
        { name: "edad", "className": "text-center" },
        { name: "darBaja", "className": "text-center" },
        { name: "asistencia", "className": "text-center" }
    ],
    columnDefs: [

        //idUsu
        { targets: [0], orderData: [0], visible: false },
        //nombre
        { targets: [1], orderData: [1], visible: true },
        //fechaAlta
        { targets: [2], orderData: [1], visible: true },
        //edad
        { targets: [3], orderData: [1], visible: true },
        //darBaja
        { targets: [4], orderData: false, visible: true },
        //asistencia
        { targets: [5], orderData: false, visible: true }
    ],

    "ajax": {

        url: "../../controller/actividades_edu.php?op=mostrarAlumno&idAct=" + idActividad,
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            //    $('.submitBtn').attr("disabled","disabled");
            //    $('#usuario_data').css("opacity","");
        }, complete: function (data) {

            $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();



        },
        error: function (e) {
            console.log(e.responseText);
        }
    },
    orderFixed: [[1, "asc"]],
    searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
        columns: [0, 1, 2, 3, 4]
    },
}); // del DATATABLE

$('#alumno_table').DataTable().on('draw.dt', function () {
    controlarFiltros('alumno_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});
/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/
/***************************************/
/*********** RESPONSIVE DATATABLE *********/
/*************************************/
$('#alumno_table').addClass('width-100'); //responsive

//DESABILITAR BOTON AÑADIR
$('#añadir').prop('disabled', true);
$(document).ready(function () {
    $('#selectAlumno').on('change', function () {
        var valor = $(this).val();
        if (valor == 0) {
            $('#añadir').prop('disabled', true);
        } else {
            $('#añadir').prop('disabled', false);
        }
    });
});

////////////////////////////////////////////
// CODIGO DE MODAL DE INSERTAR ALUMNO NUEVO PARA CAMBIAR EL SWITCH CORRECTAMENTE
////////////////////////////////////////////
$(document).ready(function () {
  const $switch = $('#matriculadoSwitch');
  const $inputHidden = $('#alumnoMatriculado');
  const $tablaMatriculados = $('#tablaLlegadasMatriculados');
  const $tablaNoMatriculados = $('#tablaAlumnosNoMatriculados');
  const $mensajeHoras = $('#mensaje-horas-lectivas');

  // Función para actualizar el mensaje según estado (0 = matriculado, 1 = no matriculado)
  function actualizarMensajeHoras(estado) {
    if (estado === 0) {
      $mensajeHoras.text('Contará para las horas lectivas').removeClass('text-danger').addClass('text-success');
    } else {
      $mensajeHoras.text('No contará para las horas lectivas').removeClass('text-success').addClass('text-danger');
    }
  }

  // Leer el estado inicial desde el input oculto (0 = matriculado, 1 = no matriculado)
  let estadoActual = $inputHidden.val() === '1' ? 1 : 0;

  // Forzar el estado visual del checkbox (checked = NO matriculado)
  $switch.prop('checked', estadoActual === 1);

  // Mostrar la tabla correcta y mensaje al cargar
  if (estadoActual === 0) {
    $tablaMatriculados.removeClass('d-none');
    $tablaNoMatriculados.addClass('d-none');
  } else {
    $tablaMatriculados.addClass('d-none');
    $tablaNoMatriculados.removeClass('d-none');
  }
  actualizarMensajeHoras(estadoActual);

  $switch.on('change', function () {
    const nuevoEstado = $(this).is(':checked') ? 1 : 0;

    // Revertir visualmente hasta que se confirme
    $(this).prop('checked', estadoActual === 1);

    const mensaje = nuevoEstado === 0
      ? "¿Deseas ver los alumnos matriculados?"
      : "¿Deseas ver los alumnos NO matriculados?";

    Swal.fire({
      title: "¿Cambiar grupo de alumnos?",
      text: mensaje,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, cambiar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        estadoActual = nuevoEstado;
        $switch.prop('checked', nuevoEstado === 1);
        $inputHidden.val(nuevoEstado);

        if (nuevoEstado === 0) {
          $tablaMatriculados.removeClass('d-none');
          $tablaNoMatriculados.addClass('d-none');
        } else {
          $tablaMatriculados.addClass('d-none');
          $tablaNoMatriculados.removeClass('d-none');
        }
        actualizarMensajeHoras(estadoActual);
      }
    });
  });
});

//LIMPIAR FORMULARIO AL DARLE A CANCELAR
$(document).ready(function () {
    // Al cargar la página, comprobamos si el select tiene el valor 0
    if ($("#selectAlumno").val() == "0") {
        // Si el valor es 0, deshabilitamos el botón
        $("#insertar-alumno-form button[type='submit']").prop("disabled", true);
    }

    // Cuando cambia el valor del select, comprobamos si es distinto de 0
    $("#selectAlumno").change(function () {
        if ($(this).val() != "0") {
            // Si es distinto de 0, habilitamos el botón
            $("#insertar-alumno-form button[type='submit']").prop("disabled", false);
        } else {
            // Si es 0, deshabilitamos el botón
            $("#insertar-alumno-form button[type='submit']").prop("disabled", true);
        }
    });

    // Cuando se pulsa el botón "Cerrar", se limpia el select
    $("#insertar-alumno-form button[type='button']").click(function () {
        $("#selectAlumno").val("0").trigger("change");
    });
});


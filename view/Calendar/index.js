
//================================================//
//              CARGAR CURSOS                     //
//===============================================//
function abrirModalRutas() {
    $("#buscar-rutas-modal").modal("show");
}

// Variable global
var cursosTablaTodos = null;

// Solo se crea una vez
function cargarTablaCursosTodos() {
    if (!$.fn.DataTable.isDataTable('#cursosTablaTodos')) {
        cursosTablaTodos = $("#cursosTablaTodos").DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            select: false,
            columns: [
                { name: "idCurso" },
                { name: "Ruta", className: "text-center" },
                { name: "Codigo", className: "text-center" },
                { name: "Fecha", className: "text-center" },
                { name: "Alumnos Apuntados", className: "text-center" },
                { name: "Capacidad", className: "text-center" },
                { name: "idGrupo", className: "text-center" },
                { name: "codGrupo", className: "text-center" },
                { name: "semana_actual", className: "text-center" },
                { name: "semana_siguiente", className: "text-center" },
                { name: "idRuta", className: "d-none" },
                { name: "codIdioma", className: "d-none"},
                { name: "codTipoCurso", className: "d-none" },
                { name: "idNumIdioma", className: "d-none"},
                { name: "idNumcodTipoCurso", className: "d-none" },
                { name: "est_cursos", className: "d-none" }

            ],
            columnDefs: [
                { targets: [0], visible: false }
            ],
            searchBuilder: {
                columns: [1,2,3,4,5,6,7,8,9,10,11]
            },
            ajax: {
                url: "../../controller/grupos.php?op=mostrarGruposTodosCalendar",
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
                error: function (e) {
                    console.error("Error en la carga de la tabla:", e);
                }
            },createdRow: function(row, data, dataIndex) {
                // est_cursos está en la columna 15 (índice 15)
                if (data[15] == 0) {
                    $(row).addClass('disabled-row');
                }
            },
        });
    }
    
}

// Inicializa la tabla al cargar la página
$(document).ready(function () {
    cargarTablaCursosTodos();
      // Cuando se muestre el modal, recarga la tabla
    $('#buscar-rutas-modal').on('shown.bs.modal', function () {
        if (cursosTablaTodos) {
            cursosTablaTodos.ajax.reload(null, false); // false = mantiene la página actual
        }
    });
});
//================================================//
//              CARGAR PROFESORES                //
//===============================================//

// solo se mostrará aquellos disponibles del nivel.
function cargarProfesores(codSeleccionado){
    $.post("../../controller/horario.php?op=listarProfesores", {
        codSeleccionado: codSeleccionado,
       
    }, function(respuesta) {

    let profesores = JSON.parse(respuesta); // Si el backend devuelve JSON como string

    let select = $('#selectProfesores');
    select.empty(); // Limpia el select por si ya tenía opciones
    select.append('<option value="">Seleccione un profesor</option>');

    profesores.forEach(function(profesor) {
        select.append(`<option value="${profesor.idPersonal}">(${profesor.idPersonal}) ${profesor.nomPersonal} ${profesor.apePersonal}</option>`);
    });
     console.log("Respuesta del servidor:", profesores);

    });
}

function cargarAulas() {
    $.post("../../controller/horario.php?op=listarAulas", {}, function(respuesta) {
        let aulas = JSON.parse(respuesta);
        console.log("Respuesta del servidor:", aulas); // <- este está bien ahora

        let select = $('#selectAulas');
        select.empty();
        select.append('<option value="">Seleccione un aula</option>');

        aulas.forEach(function(aula) {
            select.append(`<option value="${aula.idAula}">(${aula.idAula}) ${aula.nombreAula} - ${aula.capacidadAula}👥  - ${aula.hibridoAula ? '🖥️' : ''}${aula.kidsAula ? '🧒' : ''}${aula.paraliticosAula ? '♿' : ''}${aula.agoraAula ? '🧠' : ''}
</option>`);
        });
    });
}


let calendar; // Variable global

$("#cursosTablaTodos tbody").on("click", "tr", function () {
    var tabla = $("#cursosTablaTodos").DataTable();
    var data = tabla.row(this).data();
    let idGrupo = data[7];
    $('#modal-titlehorario').text('Añadir Horario');

    $('#switchPublicado').removeClass('d-none');

    $("#rutaSeleccionada").val(idGrupo);
    cargarProfesores(idGrupo)
    cargarAulas();
    cargarAlumnos(idGrupo); 
    $('#botonAsignar').text(idGrupo).addClass('btn-success').removeClass('btn-danger');
    $('#botonConsultar').removeClass('d-none');

    $('#codClase').val(idGrupo);

    $("#buscar-rutas-modal").modal("hide");

    // Destruir calendario anterior si ya existe
    if (calendar) {
        calendar.destroy();
    }

    let calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        firstDay: 1,
        locale: 'es',
        slotMinTime: "07:00:00",
        slotMaxTime: "20:00:00",
        slotDuration: '00:30:00',
        slotLabelInterval: '01:00',
        editable: false,
        selectable: true,

        selectAllow: function (selectInfo) {
            const isSameDay = selectInfo.start.toDateString() === selectInfo.end.toDateString();
            const duration = selectInfo.end - selectInfo.start;
            return isSameDay && duration <= 60 * 60 * 1000;
        },
        select: function (info) {
            const start = new Date(info.start);
            const fecha = start.toLocaleDateString('es-ES');
            const horaInicio = start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

            // Limpieza
            $('#startDate').val('');
            $('#fecIni').val('');
            $('#horaIni').val('');
            $('#horaFin').val('');
            $('#descripcion').val('');
            $('#selectAulas').val('');
            $('#selectProfesores').val('');

            // Valores seleccionados
            $('#startDate').val(info.startStr);
            $('#fechaSeleccionadaTexto').text(`Inicio: ${fecha} a las ${horaInicio}`);
            $('#fecIni').val(fecha);
            $('#horaIni').val(horaInicio);

            $('#contenedor-checkboxes').removeClass('d-none');

            // Calcular hora fin
            const end = new Date(start.getTime() + 50 * 60000);
            const horaFinStr = end.toTimeString().slice(0, 5);
            $('#horaFin').val(horaFinStr);

            // Habilitar
            $('#selectAulas').prop('disabled', false);
            $('#horaFin').prop('disabled', false);
            $('#descripcion').prop('disabled', false);
            $('#selectProfesores').prop('disabled', false);

            // 👇 Aquí va la llamada para marcar los días
            rellenarCheckboxesSemana(start);

            // Mostrar modal
            $('#modalFechaSeleccionada').modal('show');

            cargarAulas()
            cargarProfesores()
            $('.noeditar').removeClass('d-none');
            $('.editar').addClass('d-none');
            $('#modal-titlehorario').text('Añadir Horario');

          
        },  
        datesSet: function (info) {

            actualizarTextoSemana(info);

            // Si el modal está abierto, actualizamos los checkboxes también
            if ($('#modalFechaSeleccionada').hasClass('show')) {
                const fechaActual = new Date($('#startDate').val());
                rellenarCheckboxesSemana(fechaActual);
            }

        },
        eventClick: function (info) {
            const evento = info.event;

            const fecha = new Date(evento.start).toLocaleDateString('es-ES');
            const horaInicio = evento.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            const horaFin = evento.end ? evento.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) : '';
            const descripcion = evento.extendedProps.descripcion || '';
            const profesor = evento.extendedProps.profesor || '0';
            const aula = evento.extendedProps.aula || '0';
            const idHorario = evento.extendedProps.idHorario || '0';

            $('.editar').removeClass('d-none');
            $('.noeditar').addClass('d-none');
            $('#modal-titlehorario').text('Editar Horario');

            $('#fecIni').val(fecha);
            $('#horaIni').val(horaInicio);
            $('#horaFin').val(horaFin);
            $('#descripcion').val(descripcion);
            $('#selectProfesores').val(profesor);
            $('#selectAulas').val(aula);
            $('#idHorario').val(idHorario);

            $('#contenedor-checkboxes').addClass('d-none');
            /* $('#selectAulas').prop('disabled', true);
            $('#horaFin').prop('disabled', true);
            $('#descripcion').prop('disabled', true);
            $('#selectProfesores').prop('disabled', true); */

            
            $('#modalFechaSeleccionada').modal('show');

           /*  Swal.fire({
                title: 'Evento seleccionado',
                html: `
                    <b>Título:</b> ${evento.title}<br>
                    <b>Fecha:</b> ${fecha}<br>
                    <b>Horario:</b> ${horaInicio} - ${horaFin}<br>
                    <b>Descripción:</b> ${descripcion}
                `,
                icon: 'info'
            }); */
        },
        eventDidMount: function (info) {
            const descripcion = info.event.extendedProps.descripcion || '';
            const aula = info.event.extendedProps.aula || 'No asignada';
            const profesor = info.event.extendedProps.profesor || 'No asignado';
            const titulo = info.event.title;

            let contenidoTooltip = `
                <strong>${titulo}</strong><br>
                <b>Descripción:</b> ${descripcion}<br>
                <b>Aula ID:</b> ${aula}<br>
                <b>Profesor ID:</b> ${profesor}
            `;

            tippy(info.el, {
                content: contenidoTooltip,
                placement: 'top',
                allowHTML: true,
                arrow: true,
                theme: 'light-border',
            });
        },

        events: '../../controller/horario.php?op=listarhorario&idCurso=' + idGrupo
    });

    calendar.render();
});
function actualizarTextoSemana(info) {
  const startView = new Date(info.start);

  // Calcular lunes
  const inicioSemana = new Date(startView);
  const diaSemana = inicioSemana.getDay(); // 0=domingo, …,6=sábado
  const diasARestar = diaSemana === 0 ? 6 : diaSemana - 1;
  inicioSemana.setDate(inicioSemana.getDate() - diasARestar);

  // Calcular domingo
  const finSemana = new Date(inicioSemana);
  finSemana.setDate(inicioSemana.getDate() + 6);

  // Para mostrar (texto corto, local)
  const opciones = { day: 'numeric', month: 'short', year: 'numeric' };
  $('#diaInicioSemana').text(inicioSemana.toLocaleDateString('es-ES', opciones));
  $('#diaFinSemana').text(finSemana.toLocaleDateString('es-ES', opciones));

  // Para tus inputs hidden (formato local YYYY-MM-DD)
  $('#diaInicioSemanaImp').val(formatoLocalYYYYMMDD(inicioSemana));
  $('#diaFinSemanaImp').val(formatoLocalYYYYMMDD(finSemana));

   comprobarSwitch();

}
function formatoLocalYYYYMMDD(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, '0');
  const d = String(date.getDate()).padStart(2, '0');
  return `${y}-${m}-${d}`;
}

function rellenarCheckboxesSemana(diaSeleccionado) {
    const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado','Domingo'];
    const inicioSemana = new Date(diaSeleccionado);
    inicioSemana.setDate(inicioSemana.getDate() - ((inicioSemana.getDay() + 6) % 7));

    console.log('Inicio de la semana:', inicioSemana.toLocaleDateString('es-ES'), 'getDay:', inicioSemana.getDay());

    

    console.log('Inicio de la semana ajustado a lunes:', inicioSemana.toLocaleDateString('es-ES'), 'getDay:', inicioSemana.getDay());
    console.log('Día seleccionado:', diaSeleccionado.toLocaleDateString('es-ES'), 'getDay:', diaSeleccionado.getDay());

    let nombres = '';
    let fechas = '';
    let checkboxes = '';

    for (let i = 0; i < 7; i++) {
        const fecha = new Date(inicioSemana);
        fecha.setDate(inicioSemana.getDate() + i);

        const fechaIso = fecha.toISOString().split('T')[0];
        const fechaTexto = fecha.toLocaleDateString('es-ES');
        const diaJS = fecha.getDay();
        const diaNombre = diasSemana[(diaJS + 6) % 7];

       

        console.log('Fecha iterada:', fechaTexto, 'getDay:', diaJS, 'Dia nombre:', diaNombre);

        const esSeleccionado = diaSeleccionado.toISOString().split('T')[0] === fechaIso;

        const colores = ['blue', 'green', 'purple', 'red', 'blue', 'green', 'purple'];

        nombres += `<div class="col text-center fw-bold">${diaNombre}</div>`;
        fechas += `<div class="col text-center">${fechaTexto}</div>`;

        checkboxes += `
            <div class="col text-center">
              <label class="ios-checkbox ${colores[i]}">
                <input type="checkbox" class="checkbox-dia" value="${fechaIso}" ${esSeleccionado ? 'checked' : ''}>
                <div class="checkbox-wrapper">
                  <div class="checkbox-bg"></div>
                  <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                    <path
                      stroke-linejoin="round"
                      stroke-linecap="round"
                      stroke-width="3"
                      stroke="currentColor"
                      d="M4 12L10 18L20 6"
                      class="check-path"
                    ></path>
                  </svg>
                </div>
              </label>
            </div>
        `;
    }

    const html = `
        <div class="row mb-2">${nombres}</div>
        <div class="row mb-2">${fechas}</div>
        <div class="row checkbox-container">${checkboxes}</div>
    `;

    $('#contenedor-checkboxes').html(html);
}
//===============================================//
//===============================================//
//===============================================//




//===============================================//
//========= === GUARDAR CLASE  =================//
//===============================================//





$('#eventForm').on('submit', function (event) {
     event.preventDefault(); // evita que se recargue la página

    const codClase = $('#codClase').val();
    if (codClase === '') {
        toastr.error('Error al editar, recargue la página.');
        return;
    }

    const selectProfesores = $('#selectProfesores');
    if (selectProfesores.val() === '') {
        toastr.error('Por favor, seleccione un profesor', 'Error de Validación');
        return;
    }

    const selectAulas = $('#selectAulas');
    if (selectAulas.val() === '') {
        toastr.error('Por favor, seleccione un aula', 'Error de Validación');
        return;
    }

    const horaFin = $('#horaFin').val();

    if (!horaFin || horaFin.trim() === '') {
        toastr.error('Por favor, introduzca una hora de fin.', 'Error de Validación');
        return;
    }

    // Solo acepta formato exacto 24h, por ejemplo 00:00 a 23:59
    const regexHora = /^(?:[01]\d|2[0-3]):[0-5]\d$/;

    if (!regexHora.test(horaFin)) {
        toastr.error('La hora de fin debe tener el formato HH:MM (de 00:00 a 23:59).', 'Error de Validación');
        return;
    }
    const diasSeleccionados = $('.checkbox-dia:checked').map(function () {
        return this.value;
    }).get();
    

   var datosFormulario = {
        codClase: codClase,
        fecIni: $("#fecIni").val(),
        horaIni: $("#horaIni").val(),
        selectProfesores: $("#selectProfesores").val(),
        selectAulas: $("#selectAulas").val(),
        descripcion: $("#descripcion").val(),
        horaFin: $("#horaFin").val(),
        dias: diasSeleccionados,
        publicadoHorario: $("#filter").is(":checked") ? 1 : 0

    };


    console.log(datosFormulario)
    $.ajax({
    url: "../../controller/horario.php?op=insertarHorarios",
    type: "POST",
    data: datosFormulario,
    dataType: "json",
    success: function (respuesta) {
        console.log(respuesta);

        if (respuesta.status === "ok") {
            Swal.fire('Añadido', respuesta.mensaje || 'El horario se ha añadido correctamente.', 'success');
            calendar.refetchEvents();
        } else if (respuesta.status === "parcial") {
            let exitos = [];
            let errores = [];

            respuesta.resumen.forEach(item => {
                const texto = `📅 ${item.fecha}: ${item.mensaje || 'Insertado correctamente.'}`;
                if (item.estado === "ok") {
                    exitos.push(texto);
                } else {
                    errores.push(`❌ ${item.fecha}: ${item.mensaje}`);
                }
            });

            let html = '';

            if (exitos.length > 0) {
                html += `<b>Días insertados con éxito:</b><br>${exitos.join('<br>')}<br><br>`;
            }

            if (errores.length > 0) {
                html += `<b>Días con errores:</b><br>${errores.join('<br>')}`;
            }

            Swal.fire({
                title: 'Resultado parcial',
                html: html,
                icon: errores.length > 0 ? 'warning' : 'info',
                width: 600
            });

            calendar.refetchEvents();
        } else {
            Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
        }
    }
});


});



function editarHorario(){


    const codClase = $('#codClase').val();
    if (codClase === '') {
        toastr.error('Error al editar, recargue la página.');
        return;
    }

    const selectProfesores = $('#selectProfesores');
    if (selectProfesores.val() === '') {
        toastr.error('Por favor, seleccione un profesor', 'Error de Validación');
        return;
    }

    const selectAulas = $('#selectAulas');
    if (selectAulas.val() === '') {
        toastr.error('Por favor, seleccione un aula', 'Error de Validación');
        return;
    }

    const horaFin = $('#horaFin').val();

    if (!horaFin || horaFin.trim() === '') {
        toastr.error('Por favor, introduzca una hora de fin.', 'Error de Validación');
        return;
    }

    // Solo acepta formato exacto 24h, por ejemplo 00:00 a 23:59
    const regexHora = /^(?:[01]\d|2[0-3]):[0-5]\d$/;

    if (!regexHora.test(horaFin)) {
        toastr.error('La hora de fin debe tener el formato HH:MM (de 00:00 a 23:59).', 'Error de Validación');
        return;
    }

   var datosFormulario = {
        codClase: codClase,
        fecIni: $("#fecIni").val(),
        horaIni: $("#horaIni").val(),
        selectProfesores: $("#selectProfesores").val(),
        selectAulas: $("#selectAulas").val(),
        descripcion: $("#descripcion").val(),
        horaFin: $("#horaFin").val(),
        idHorarioActual: $("#idHorario").val()
    };

  
        
        // VOY POR AQUI POR VALIDACION NO SE COMO HACERLA
    console.log(datosFormulario)
    $.ajax({
        url: "../../controller/horario.php?op=editarHorarios",
        type: "POST",
        data: datosFormulario,
        dataType: "json",  // <-- aquí
        success: function (respuesta) {
            console.log(respuesta);

            if (respuesta.status === "ok") {
                Swal.fire('Añadido', respuesta.mensaje || 'El horario se ha añadido correctamente.', 'success');
                calendar.refetchEvents();
            } else if (respuesta.status === "parcial") {
                let exitos = [];
                let errores = [];

                respuesta.resumen.forEach(item => {
                    const texto = `📅 ${item.fecha}: ${item.mensaje || 'Insertado correctamente.'}`;
                    if (item.estado === "ok") {
                        exitos.push(texto);
                    } else {
                        errores.push(`❌ ${item.fecha}: ${item.mensaje}`);
                    }
                });

                let html = '';

                if (exitos.length > 0) {
                    html += `<b>Días editados con éxito:</b><br>${exitos.join('<br>')}<br><br>`;
                }

                if (errores.length > 0) {
                    html += `<b>Días con errores:</b><br>${errores.join('<br>')}`;
                }

                Swal.fire({
                    title: 'Resultado parcial',
                    html: html,
                    icon: errores.length > 0 ? 'warning' : 'info',
                    width: 600
                });

                calendar.refetchEvents();
            } else {
                Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
            }
        }
    });

};

function eliminarEvento(){
    idHorario = $('#idHorario').val();
    if(idHorario == ''){
        alert('Error critico, recargue la pagina.');
    }
    $.ajax({
        url: "../../controller/horario.php?op=eliminarEvento",
        type: "POST",
        data: { idHorario: idHorario },  // Aquí pasas un objeto con la clave y valor
        dataType: "json",  // <-- aquí
        success: function (respuesta) {
            console.log(respuesta);
            Swal.fire('Horario', 'Horario eliminado', 'warning');
            
            calendar.refetchEvents();
            $('#modalFechaSeleccionada').modal('hide');

        }
    });
}
$(document).ready(function () {
    let estadoAnterior = $('#filter').is(':checked');

    $('#filter').on('change', function (e) {
        let switchElement = $(this);
        let nuevoEstado = switchElement.is(':checked');

        // Detenemos el cambio hasta que el usuario confirme
        e.preventDefault();
        switchElement.prop('checked', estadoAnterior); // Revierte de inmediato

        Swal.fire({
            title: '¿Estás seguro?',
            text: `Vas a cambiar el estado a ${nuevoEstado ? 'Publicado' : 'Provisional'}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                estadoAnterior = nuevoEstado; // Aceptado: actualiza el estado
                switchElement.prop('checked', nuevoEstado); // Aplica el cambio
                

               
                // Llamada con el estado como texto
                cambiarEstadoCalendario(nuevoEstado ? '1' : '0');

                // Si necesitas también pasar un ID u otro valor:
                // cambiarEstadoCalendario(1, nuevoEstado ? 'Publicado' : 'Provisional');
            } else {
                switchElement.prop('checked', estadoAnterior);
            }
        });
    });
});

function cambiarEstadoCalendario(estado){
    console.log(estado);
        inicioSemana = $('#diaInicioSemanaImp').val()
        finSemana = $('#diaFinSemanaImp').val();
        rutaSeleccionada = $('#rutaSeleccionada').val()


      $.post("../../controller/horario.php?op=visibilidadHorario",  {
            inicioSemana:inicioSemana,
            finSemana:finSemana,
            rutaSeleccionada:rutaSeleccionada,
            estado: estado
        }, function(respuesta) {
                   calendar.refetchEvents();


        });
}
function comprobarSwitch(){
    console.log('comprobando');
    inicioSemana = $('#diaInicioSemanaImp').val()
    finSemana = $('#diaFinSemanaImp').val();
    rutaSeleccionada = $('#rutaSeleccionada').val()

    $.post("../../controller/horario.php?op=cargarEstadoSwitch",  {
            inicioSemana:inicioSemana,
            finSemana:finSemana,
            rutaSeleccionada:rutaSeleccionada
        }, function(respuesta) {
            console.log(respuesta);
                   calendar.refetchEvents();



            if (respuesta == 1) {
            $('#filter').prop('checked', true);
            } else {
            $('#filter').prop('checked', false);
            }

        });
}



/* SECCION ALUMNOS*/

function abrirModalAlumnos() {
    cargarTablaCursosTodos(); // Solo se crea una vez
    console.log(cursosTablaTodos); // ¿Está null o undefined?
    if (cursosTablaTodos) {
        cursosTablaTodos.ajax.reload(); // Solo se recarga si existe
    }
    cargarTablaCursosTodos();

    $("#modalAlumnos").modal("show");
}



function cargarAlumnos(idCursoSeleccionado){
    console.log(idCursoSeleccionado)
    var alumnosTabla = $("#alumnosTablaGrupo").DataTable({
            pageLength: 5, // Muestra solo 5 registros por página
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
            buttons:[],
            columns: [
                { name: "idAlumno" },
                { name: "Nombre", className: "text-center" },
                { name: "Contacto", className: "text-center" },
                { name: "Condiciones", className: "text-center" },
                { name: "Preferencia", className: "text-center" },
                { name: "grupoamigos", className: "text-center" },
                { name: "PreferenciaGrupo", className: "text-center" }

            ],
            columnDefs: [
                {
                    targets: [0],
                    visible: false, // Oculta la columna ID
                }
            ],
            searchBuilder: {
                columns: [1, 2, 3, 4,5,6,7,8], // Ajustado a las columnas existentes
            },
            ajax: {
                url: "../../controller/horario.php?op=recogerAlumnosGrupo",
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
                data: { idCursoSeleccionado: idCursoSeleccionado},
                beforeSend: function () {
                    // Aquí puedes agregar acciones antes de la solicitud
                },
                complete: function (data) {
                    // Aquí puedes agregar acciones después de la solicitud
                },
                error: function (e) {
                    console.error("Error en la carga de la tabla:", e);
                }
            },
               initComplete: function() {
                    var api = this.api();
                    var counts = {
                        "Sin Preferencias": 0,
                        "Mañanas": 0,
                        "Tardes": 0
                    };

                    // Columna "Preferencia Horaria" es la 4 (0-based), pero ojo que la columna 0 está oculta, si las columnas visibles van 0..6, la 4 es preferencia horaria
                    // Vamos a recorrer las filas visibles para contar
                    api.column(4, {search: 'applied'}).nodes().each(function(cell, i){
                        // cell es td con html, extraemos solo el texto
                        var text = $(cell).text().trim();
                        if(text in counts){
                            counts[text]++;
                        }
                    });

                    // Buscar la preferencia con máximo count
                    var maxPref = null;
                    var maxCount = 0;
                    for(var key in counts){
                        if(counts[key] > maxCount){
                            maxCount = counts[key];
                            maxPref = key;
                        }
                    }

                    // Poner en footer
                    // Footer en la tabla PHP debe estar ya generado
                    $(api.column(4).footer()).html('<b>Mayoría: </b>' + maxPref + ' (' + maxCount + ')');
                }

        });
        alumnosTabla.page.len(10).draw();

        $("#alumnosTabla").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
 
    
}
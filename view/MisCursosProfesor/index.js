$.ajax({
  url: '../../controller/zonaAlumnos.php?op=listarCursos',
  type: "GET",
  processData: false,
  contentType: false,
  error: function (error) {
      console.log(error);
  },
  success: function (res) {
    console.log(res)
    var datos = jQuery.parseJSON(res);
    if(datos == ''){
      token = $('#idToken').val();
      var html = `
      <div class="col-md-6">
        <div class="course-card p-3">
          <h5>Sin cursos disponibles. Comprueba matriculación. (No courses available. Check enrollment)</h5>
         
          
          <a href="../Perfil/?tokenUsuario=${token}" class="btn w-100 mt-3 btn-success">
          Revisar Inscripción - Check enrollment
          </a>
        </div>
      </div>
    `;
    
      $("#todosCursos").append(html);

    }else{
      for (var x of datos) {
        pintar(x);
    }
    }
      

  }
});

function pintar(x) {
 
  pesoRuta = x.peso_ruta;
  pesoMax = x.max_peso;
  console.log(pesoRuta)
  console.log(pesoMax)
  let porcentaje = '0%';
  
  if (pesoMax > 0) {
    let porcentajeNum = (pesoRuta / pesoMax) * 100;
    porcentaje = porcentajeNum.toFixed(1) + '%';  // con un decimal
  }
  console.log(x);
  var html = `
  <div class="col-md-6">
    <div class="course-card p-3">
      <h5>${x.descrIdioma} - ${x.descrTipo} / ${x.descrNivel}</h5>
      <div class="d-flex align-items-center mb-3">
        <img src="cursoss.png" alt="Python" class="course-image me-3">
        <div class="flex-grow-1">
          <small>${porcentaje} completado</small>
          <div class="progress mt-1">
            <div class="progress-bar bg-primary" style="width: ${porcentaje};"></div>
          </div>
        </div>
      </div>
  
  
      <a href="#" 
        class="btn w-100 mt-3 ${x.est_cursos == 0 ? 'btn-danger' : 'btn-success'}"
        ${x.est_cursos == 1 ? `onclick="verCalendario('${x.codGrupo}')"` : ''}>
        ${x.est_cursos == 1 ? 'Ver Calendario / View Calendar' : 'Finalizado'}
      </a>
    </div>
  </div>
`;

  $("#todosCursos").append(html);
}
   /*  <div class="course-dates d-flex justify-content-between">
        <div><strong>Inicio Matricula:</strong> ${x.fechaInicioMatriculacion}</div>
        <div><strong>Fin:</strong> ${x.fechaFinMatriculacion}</div>
      </div> */


// CALENDARIO //
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
verCalendario();

function verCalendario(){

    $('#todosCursos').addClass('d-none');
    $('.viewcalendar').removeClass('d-none');

    let idGrupo = 'x';

    $('#botonAsignar').text(idGrupo).addClass('btn-success').removeClass('btn-danger');
    $('#codClase').val(idGrupo);

    

    // Destruir calendario anterior si ya existe
    if (calendar) {
        calendar.destroy();
    }
    console.log('calamardo');
    let calendarEl = document.getElementById('calendar');
    const isMobile = window.innerWidth < 768;
    const initialView = isMobile ? 'listWeek' : 'timeGridWeek';
    calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: initialView,
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
            $('#startDate').val('');
            $('#fecIni').val('');
            $('#horaIni').val('');
            $('#horaFin').val('');
            $('#descripcion').val('');
            $('#selectAulas').val('');
            $('#selectProfesores').val('');


            $('#startDate').val(info.startStr);
            $('#fechaSeleccionadaTexto').text(`Inicio: ${fecha} a las ${horaInicio}`);
            $('#fecIni').val(fecha);
            $('#horaIni').val(horaInicio);

            const end = new Date(start.getTime() + 50 * 60000);
            const horaFinStr = end.toTimeString().slice(0, 5);
           
        },
         datesSet: function (info) {
            actualizarTextoSemana(info);


            // Si el modal está abierto, actualizamos los checkboxes también
            if ($('#modalFechaSeleccionada').hasClass('show')) {
                const fechaActual = new Date($('#startDate').val());
                rellenarCheckboxesSemana(fechaActual);
            }

        },
        noEventsContent: function() {
          return '📅 No classes scheduled this week';
        },
         eventDidMount: function (info) {
            const descripcion = info.event.extendedProps.descripcion || '';
            const aula = info.event.extendedProps.aula || 'No asignada';
            const profesor = info.event.extendedProps.profesor || 'No asignado';
            const titulo = info.event.title;

            let contenidoTooltip = `
                <strong>${titulo}</strong><br>
                <b>Descripción:</b> ${descripcion}<br>
                <b>Aula ID:</b> ${aula}
              
            `;

            tippy(info.el, {
                content: contenidoTooltip,
                placement: 'top',
                allowHTML: true,
                arrow: true,
                theme: 'light-border',
            });
        },

        eventClick: function (info) {
           const evento = info.event;
          console.log(evento);
           const fecha = new Date(evento.start).toLocaleDateString('es-ES');
            const horaInicio = evento.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            const horaFin = evento.end ? evento.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) : '';

            // Variables extendidas con fallback
            const descripcion = evento.extendedProps.descripcion || 'Sin descripción / No description';
            const profesor = evento.extendedProps.profesor || 'No asignado / Not assigned';
            const aula = evento.extendedProps.aula || 'Sin aula / No room';
            const idHorario = evento.extendedProps.idHorario || 'N/A';
            const idCurso = evento.extendedProps.idCurso || 'N/A';
            let txtCursoNoDisponible = ''; // ✅ Inicialización segura
            const estCurso = evento.extendedProps.estCurso; // 0 o 1 directamente
            if (estCurso == 0) {
              txtCursoNoDisponible = `<b style="font-size: 20px; color:rgb(245, 17, 17);">Curso Finalizado</b><br>`;
            }

            Swal.fire({
                title: `<b style="font-size: 30px; color: #4CAF50;"> ${idCurso}</b> `,
                html: `
                  <div style="text-align: center;">
                    ${txtCursoNoDisponible}
                    <b>Fecha</b> ${fecha}<br>
                    <b>Horario</b> ${horaInicio} - ${horaFin}<br>
                    <b>Aula</b> ${aula}<br>
                    <b>Descripción</b> ${descripcion}<br>
                  </div>
                `,
                icon: 'info',
                confirmButtonText: 'Gestionar Curso',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                reverseButtons: true  // Cambia el orden de los botones para que 'Cerrar' esté primero
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se hace click en "Gestionar Curso"
                    const baseUrl = new URL('gestionarCurso.php', window.location.origin + window.location.pathname);
                    baseUrl.searchParams.set('idCurso', idCurso);
                    baseUrl.searchParams.set('idHorario', idHorario);
                    window.location.href = baseUrl.toString();


                } else if (result.isDismissed) {
                    // Si se hace click en "Cerrar"
                    Swal.close();
                }
            });

        },

        events: '../../controller/horario.php?op=listarhorarioProfesores'
    });

    calendar.render();
}


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
  console.log(inicioSemana)
    console.log(finSemana)
    console.log(rutaSeleccionada)

    $.post("../../controller/horario.php?op=cargarEstadoSwitch",  {
            inicioSemana:inicioSemana,
            finSemana:finSemana,
            rutaSeleccionada:rutaSeleccionada
        }, function(respuesta) {
            console.log(respuesta);
                   calendar.refetchEvents();

            if (respuesta == 1) {
              $('.txtPublicado').removeClass('d-none');
              $('.txtProvisional').addClass('d-none');

            } else {
              $('.txtPublicado').addClass('d-none');
              $('.txtProvisional').removeClass('d-none');

            }

        });
}

window.addEventListener('resize', function () {
  
    const newView = window.innerWidth < 768 ? 'listWeek' : 'timeGridWeek';
    if (calendar.view.type !== newView) {
        calendar.changeView(newView);
    }
});


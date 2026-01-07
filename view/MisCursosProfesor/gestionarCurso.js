
codigoCurso = $('#idCursoImput').val();
idHorario = $('#idHorarioImput').val();

var listaAlumnosClase = $("#listaAlumnosClase").DataTable({
    select: false,

    columns: [
        { name: "id", className: 'secundariaDef' },      
        { name: "Avatar", className: 'secundariaDef' },    
        { name: "Nombre", className: 'secundariaDef' },    
        { name: "DNI", className: 'text-center' },         
        { name: "Asistencia", className: 'text-center' },             
        { name: "Observaciones", className: 'text-center' },       
        { name: "idAlumno", className: 'text-center', width: "9%" },
        { name: "idLlegada", className: 'text-center', width: "9%" } 
    ],

    columnDefs: [
        { targets: [0], orderable: true, visible: true },
        { targets: [1], orderable: true, visible: true },
        { targets: [2], orderable: true, visible: true },
        { targets: [3], orderable: true, visible: true },
        { targets: [4], orderable: true, visible: true },
        { targets: [5], orderable: true, visible: true },
        { targets: [6], orderable: true, visible: true },
        { targets: [7], orderable: true, visible: true }

    ],

    searchBuilder: {
        columns: [0, 1, 2, 3, 4, 5, 6,7]
    },

    ajax: {
        url: "../../controller/grupos.php?op=recogerAlumnosClaseTabla", 
        type: "POST",
        dataType: "json",
        data: function (d) {
            d.codigoCurso = codigoCurso;
            d.idHorario = idHorario;
        },
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () { },
        complete: function () { },
        error: function (e) {
            console.error("Error en la carga de datos:", e);
        }
    },

    footerCallback: function (row, data, start, end, display) {
        // Opcional
    },

    createdRow: function (row, data, dataIndex) {
        // Personalización de filas
    }

});

listaAlumnosClase.column(6).visible(false);

$("#listaAlumnosClase").addClass("width-100");

// INSERTO EL BOTÓN ANTES DEL BUSCAR, PARA QUE QUEDE CENTRADO Y ORDENADO
$("#listaAlumnosClase_filter").before(`
    <div style="margin-bottom: 10px; text-align: center;">
        <span style="font-weight: bold; margin-right: 15px;">Marcar todos como asistencia</span>
        <button id="marcarTodosAsistencia" class="btn btn-success btn-sm">Marcar todos</button>
    </div>
`);

$("#marcarTodosAsistencia").on("click", function() {
    // VARIABLE QUE VOY A UTILIZAR PARA COMPROBAR SI HAY O NO REGISTROS EN LA TABLA
    const info = listaAlumnosClase.page.info();
    // RECOJO EL ID DEL HORARIO
    const idHorario = $('#idHorarioImput').val();
    // CALCULO LAS HORAS DE LA CLASE
    calcularDiferenciaHoras(); 
    // RECOJO TANTO LAS HORAS CALCULADAS DE LA CLASE COMO LA HORA DE COMIENZO
    const horaClase = $("#horaInicio_horario").val();
    const horasAsistidas = $('input[name="horas_asistencia"]').val();
    // EN CASO DE NO EXISTIR REGISTROS EN LA TABLA, NO DEJO AL USUARIO CONTINUAR, Y LE NOTIFICO
    if (info.recordsDisplay === 0) {
        Swal.fire({
            icon: 'info',
            title: 'No hay alumnos',
            text: 'No hay alumnos visibles para marcar asistencia.',
            background: 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)',
            customClass: { popup: 'shadow-lg rounded-3' },
            timer: 3000,
            showConfirmButton: true,
            confirmButtonText: 'Cerrar'
        });
        return;
    }
    // EN CASO DE QUE SI HAYAN REGISTROS, SE PREGUNTA SI QUIERE PONER A TODOS COMO PRESENTES
    Swal.fire({
        title: '<strong style="color:#2e7d32;">¿Quieres marcar a todos como presentes?</strong>',
        html: '<p style="font-size:1.1rem; color:#555;">Esta acción marcará la asistencia de <b>todos los alumnos visibles</b> en la tabla.</p>',
        iconHtml: '<i class="fa-solid fa-check-circle" style="color:#2e7d32; font-size:4rem;"></i>',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check" style="margin-right:8px;"></i> Sí, marcar todos',
        cancelButtonText: '<i class="fa-solid fa-times" style="margin-right:8px;"></i> Cancelar',
        confirmButtonColor: '#2e7d32',
        cancelButtonColor: '#c62828',
        background: 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)',
        customClass: {
            popup: 'shadow-lg rounded-3',
            title: 'mb-3',
            htmlContainer: 'mb-4',
            confirmButton: 'btn btn-success px-4 py-2',
            cancelButton: 'btn btn-danger px-4 py-2 ms-3'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
          // AJAX QUE SE ENCARGA DE MARCAR A TODOS LOS ALUMNOS DE ESA CLASE
            $.ajax({
                url: '../../controller/horario.php?op=marcarTodosPresentes',
                type: 'POST',
                data: {
                    codigoCurso: codigoCurso,
                    idHorario: idHorario,
                    horaClase: horaClase,
                    horasAsistidas: horasAsistidas
                },
                success: () => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Listo!',
                        text: 'Todos los alumnos han sido marcados como presentes.',
                        timer: 2500,
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar',
                        background: 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)',
                        customClass: { popup: 'shadow-lg rounded-3' }
                    });
                    listaAlumnosClase.ajax.reload(null, false);
                },
                error: () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar la asistencia.',
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    });
                }
            });
        }
    });
});



  //==================//
  // ZONA PASAR LISTA //
  //==================//
  //Comprueba si ya a pàsado lista el alumno o no. 
  function comprobarListaAlumno(idAlumno){
        $('#idLista').val();
          // Desactiva todos los botones
        $('.attendance-btn').removeClass('active');

        // Activa el botón correspondiente
        $('.attendance-btn[data-value="0"]').addClass('active');
            // Desactiva todos los botones
        $('.attendance-btn[data-value="0"]').click();
        
      console.log(idAlumno)
      horario = $('#idHorarioImput').val();
    $.post(
      "../../controller/horario.php?op=comprobarListaAlumno", // Ruta a tu backend
      {
        alumno: idAlumno,
        horario: horario
      },
      function (response) {
          console.log(response);
        // Intenta convertir respuesta JSON
        const data = JSON.parse(response);
        console.log("Respuesta parseada:", data);

        // Si es array, tomamos el primer objeto
        const resultado = Array.isArray(data) ? data[0] : data;

        // Si no hay datos, asumimos nuevo registro
        if (!resultado || Object.keys(resultado).length === 0) {
          
          $('.attendance-btn').removeClass('active');
          $(`.attendance-btn[data-value="${0}"]`).addClass('active');
          $('#asistenciaIn').val(0);

          console.warn("No se encontró pase de lista. Se asumirá nuevo registro.");
        
          return;
        }

        console.log(resultado.estadoAsistenciaLista)
        // ✅ Si hay datos, rellenamos
        estadoCargadoBtn = resultado.estadoAsistenciaLista;
            // Desactiva todos los botones
        $('.attendance-btn').removeClass('active');

        // Activa el botón correspondiente
        $('.attendance-btn[data-value="' + estadoCargadoBtn + '"]').addClass('active');
            // Desactiva todos los botones
        $('.attendance-btn[data-value="' + estadoCargadoBtn + '"]').click();

      // Activa el botón correspondiente
        $('#horas_llegada').val(resultado.horaLlegadaLista);
        $('#horas_asistencia').val(resultado.horasAsistenciaLista);
        $('#motivoRetraso').val(resultado.motivoRetrasoLista);
        $('#tareas').val(resultado.tareasRealizadasLista);
        $('#obsDiaria').val(resultado.obsDiariaLista);
        $('#idLista').val(resultado.idLista);
         // Asignar valor al summernote
        $('#tareaAlumno').summernote('code', resultado.tareaIndividualListaDiaria);

      }
    );
  }
    $('#listaAlumnosClase tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===

      var tabla = $('#listaAlumnosClase').DataTable();
      
        // Obtén el objeto de datos de la fila actual
        var data = tabla.row(this).data();
        var idAlumno = data[6];
        var nombreAlumno = data[2];
        var avatar = data[1];
        var idLlegada = data[7];
        console.log(idAlumno);
        console.log(avatar);

        $('#nombreAlumno').text(nombreAlumno)
        $('#avatar').html(avatar)
        $('#idAlumnoSelect').val(idAlumno)
        $('#idLlegadaSelect').val(idLlegada)


        comprobarListaAlumno(idAlumno);

        $("#gestionarLista").modal("show");

 
    });
    
$(document).ready(function () {
  $(".attendance-btn").on("click", function () {
      console.log("Botón clicado:", $(this).data("value"));

    // Cambia visualmente el botón activo
    $(".attendance-btn").removeClass("active");
    $(this).addClass("active");

    // Asigna valor al input oculto
    const valor = $(this).data("value");
    console.log(valor);
    console.log($('#asistencia').length); // Debe ser 1

    $('#asistenciaIn').val(valor)

    valorSeleccionado = $('#asistenciaIn').val()

    const horaInicio = $('#horaInicio_horario').val();

    // Ocultar todos los bloques
    $('#horasAsistidasDiv, #horaLlegadaDiv, #motivoDiv, #tareasDiv').addClass('d-none');
    $('input[name="horas_llegada"]').val('00:00');
    $('input[name="horas_asistencia"]').val('00:00');

    switch (valorSeleccionado) {
      case '0':
        $('input[name="horas_llegada"]').val('00:00');
        $('input[name="horas_asistencia"]').val('00:00');
        $('input[name="tareas_realizadas"]').val('0');
      break;

      case '1':
        $('#horasAsistidasDiv, #horaLlegadaDiv, #tareasDiv').removeClass('d-none');
        $('input[name="horas_llegada"]').val(horaInicio);
        calcularDiferenciaHoras();
        break;

      case '2':
        toastr.warning('Por ausencia, no se contarán horas lectivas.');
         $('input[name="horas_llegada"]').val('00:00');
        $('input[name="horas_asistencia"]').val('00:00');
        $('input[name="tareas_realizadas"]').val('0');

      break;

      case '3':
        const [h, m] = horaInicio.split(':');
        let hora = parseInt(h, 10);
        let minutos = parseInt(m, 10) + 10;
        if (minutos >= 60) {
          hora += 1;
          minutos -= 60;
        }
        const horaLlegadaTarde = `${hora.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}`;
        $('#horas_llegada').val(horaLlegadaTarde);
        
        $('#horasAsistidasDiv, #horaLlegadaDiv, #tareasDiv').removeClass('d-none');
        toastr.warning('La hora de llegada se ha ajustado 10 minutos más tarde de la hora de inicio.');
        calcularDiferenciaHoras();
        break;

      case '4':
        $('#motivoDiv, #tareasDiv').removeClass('d-none');
        $('#horasAsistidasDiv, #horaLlegadaDiv, #tareasDiv').removeClass('d-none');

        calcularDiferenciaHoras();
        toastr.warning('Las horas de asistencia se tendrán en cuenta en el visado.');

        toastr.warning('Debido a la ausencia, no se contabilizarán horas lectivas.');
        break;
    }

    console.log("Valor seleccionado:", valorSeleccionado);
  });
});



('#horas_llegada').on('change', function () {
    const valorAsistencia = $('select[name="asistencia"]').val();
    const horaInicio = $('#horaInicio_horario').val();
    const horaLlegada = $(this).val();

    if (valorAsistencia === '3') {
        if (horaLlegada === horaInicio) {
            // Sumar 10 minutos automáticamente
            const [h, m] = horaInicio.split(':');
            let hora = parseInt(h, 10);
            let minutos = parseInt(m, 10) + 10;

            if (minutos >= 60) {
                hora += 1;
                minutos -= 60;
            }

            const nuevaHora = `${hora.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}`;
            $(this).val(nuevaHora);

            toastr.warning('La hora de llegada no puede ser igual a la de inicio. Se ha ajustado automáticamente.');
        }
    }

    // Siempre recalcular
    calcularDiferenciaHoras();
    });
     function calcularDiferenciaHoras() {
        const horaInicio = $('#horaInicio_horario').val(); // formato HH:mm:ss
        const horaFin = $('#horaFin_horario').val();       // formato HH:mm:ss

        if (horaInicio && horaFin) {
            const inicio = new Date(`1970-01-01T${horaInicio}`);
            const fin = new Date(`1970-01-01T${horaFin}`);

            let diffMs = fin - inicio;

            if (diffMs < 0) {
                // si la hora fin es menor (por error), evitar resultado negativo
                diffMs = 0;
            }

            const totalMinutos = Math.floor(diffMs / 60000);
            const horas = Math.floor(totalMinutos / 60);
            const minutos = totalMinutos % 60;

            // Formato H:mm (ej. 2:07)
            const resultado = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}`;
            console.log(resultado)
            $('input[name="horas_asistencia"]').val(resultado);
        }
    }



    // CALCULAR AUTOMATICAMENTE HORAS LECTIVAS
    $(document).ready(function () {
        $('#horas_llegada').on('change', function () {
            const horaLlegada = $(this).val(); // HH:mm
            const horaFin = $('#horaFin_horario').val(); // HH:mm o HH:mm:ss
            const horaInicio = $('#horaInicio_horario').val(); // HH:mm o HH:mm:ss

            if (horaLlegada && horaFin) {
                const horaFinNormalizada = horaFin.length > 5 ? horaFin.substring(0, 5) : horaFin;
                const horaInicioNormalizada = horaInicio.length > 5 ? horaInicio.substring(0, 5) : horaInicio;

                const inicio = new Date(`1970-01-01T${horaLlegada}`);
                const fin = new Date(`1970-01-01T${horaFinNormalizada}`);

                if (inicio >= fin) {
                    toastr.error('La hora de llegada no puede ser mayor o igual que la hora de fin.');

                    $('#horas_llegada').val(horaInicioNormalizada);
                    $('input[name="horas_asistencia"]').val('');
                    calcularDiferenciaHoras();
                    return;
                }

                // Calcular diferencia
                let diffMs = fin - inicio;
                const totalMinutos = Math.floor(diffMs / 60000);
                const horas = Math.floor(totalMinutos / 60);
                const minutos = totalMinutos % 60;

                const resultado = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}`;

                $('input[name="horas_asistencia"]').val(resultado);
            }
        });
    });



   function agregarEditarElemento() {
    // RECOGE LA ID PARA SABER SI ESTA EDITANDO O INSERTANDO
    let idLista = $('#idLista').val();

    // Recolectar todos los datos del formulario
    let formData = {
      idLista: idLista,
      idAlumno: $('#idAlumnoSelect').val(),
      idCurso: $('#idCursoImput').val(),
      idHorario: $('#idHorarioImput').val(),
      asistenciaIn: $('#asistenciaIn').val(),
      horas_llegada: $('#horas_llegada').val(),
      horas_asistencia: $('[name="horas_asistencia"]').val(),
      motivo: $('#motivoRetraso').val(),
      tareas_realizadas: $('[name="tareas_realizadas"]').val(),
      observaciones: $('#obsDiaria').val(),
      tareaAlumno: $('#tareaAlumno').val(),
      idLlegadaSelect: $('#idLlegadaSelect').val()

    };

    // Lógica según si se está editando o insertando
    if (idLista !== '') {
       console.log('Editando existente con datos:', formData);
         $.ajax({
        type: 'POST',
        url: "../../controller/horario.php?op=editarLista", // Ruta a tu backend
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response) {
             toastr.success('Asistencia actualizada');
             $('#listaAlumnosClase').DataTable().ajax.reload(null, false);

            // Aquí podrías limpiar el formulario o recargar la página/tablas
          } else {
            alert('Error: ' + response.message);
          }
        },
     
   
      });
    } else {
      console.log('Insertando nuevo con datos:', formData);
       $.ajax({
        type: 'POST',
        url: "../../controller/horario.php?op=insertarLista", // Ruta a tu backend
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response) {
             toastr.success('Asistencia actualizada');
             $('#listaAlumnosClase').DataTable().ajax.reload(null, false);

            // Aquí podrías limpiar el formulario o recargar la página/tablas
          } else {
            alert('Error: ' + response.message);
          }
        },
     
      });
    }


    $("#gestionarLista").modal("hide");

  }





  //====================//
  //  TAREAS DE CLASE   //
  //====================//
  function guardarTareaClase(){
    if($('#tareasCreadas').val() == ''){
      console.log('Creando Tarea');
        
      let formData = {
        idCurso: $('#idCursoImput').val(),
        idHorario: $('#idHorarioImput').val(),
        tareaHoy: $('#tareaHoy').summernote('code') // ✅ Así se recoge el contenido del editor
      };

      $.ajax({
        type: 'POST',
        url: "../../controller/horario.php?op=insertarTareaDiaria", // Ruta a tu backend
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response) {
              toastr.success('Tarea actualizada');
              $('#btnSaveTarea').addClass('d-none');
              $('#btnSaveTarea').removeClass('d-none');
          // 🔁 Reemplazar botón
              $('#btnGuardarContainer').html(`
                <button id="btnGuardar" onclick="guardarTareaClase()" class="btn btn-warning px-4 py-2 fw-semibold">💾 Editar tarea</button>
              `);
            // Aquí podrías limpiar el formulario o recargar la página/tablas
          } else {
            alert('Error: ' + response.message);
          }
        },
      
    
      });
    }else{
      console.log('Editando Tarea');
        
      let formData = {
        idTarea: $('#tareasCreadas').val(),
        idCurso: $('#idCursoImput').val(),
        idHorario: $('#idHorarioImput').val(),
        tareaHoy: $('#tareaHoy').summernote('code') // ✅ Así se recoge el contenido del editor
      };

      $.ajax({
        type: 'POST',
        url: "../../controller/horario.php?op=editarTareaDiaria", // Ruta a tu backend
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response) {
              toastr.success('Tarea actualizada');
              $('#btnSaveTarea').addClass('d-none');
              $('#btnSaveTarea').removeClass('d-none');
          // 🔁 Reemplazar botón
              $('#btnGuardarContainer').html(`
                <button id="btnGuardar" onclick="guardarTareaClase()" class="btn btn-warning px-4 py-2 fw-semibold">💾 Editar tarea</button>
              `);
            // Aquí podrías limpiar el formulario o recargar la página/tablas
          } else {
            alert('Error: ' + response.message);
          }
        },
      
    
      });
      

    
    }
  }

  // CARGAR TAREAS

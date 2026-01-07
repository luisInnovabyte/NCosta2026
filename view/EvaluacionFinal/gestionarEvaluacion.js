/*==================================*/
/*    DATATABLE DE CURSOS     */
/*==================================*/

console.log("Script iniciado");

function getParamFromURL(name) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(name);
}

const tokenUsuario = getParamFromURL("tokenUsu");
console.log(tokenUsuario);
const idLlegada = getParamFromURL("idLlegada");

console.log("ID Llegada:", idLlegada);
console.log("token:", tokenUsuario);


$('#cursos_table').DataTable({
  destroy: true,
  columns: [
    { title: "Ruta", className: "text-center" },
    { title: "Fecha Inicio", className: "text-center" },
    { title: "Estado y Fecha Fin", className: "text-center" },
    { title: "Estado Curso", className: "text-center" },
    { title: "Acciones", className: "text-center" } // ✅ columna del botón
  ],
  columnDefs: [
    { targets: [0, 1, 2, 3, 4], orderable: false } // ✅ evita ordenamiento en todas
  ],
  ajax: {
    url: "../../controller/zonaAlumnos.php?op=listarCursosPorLlegadaSeleccionada",
    type: "GET",
    dataType: "json",
    cache: false,
    data: function (d) {
      d.idLlegada = idLlegada; // asegúrate de definir esta variable global
    },
    dataSrc: function (json) {
      console.log("Datos recibidos del servidor:", json);
      if (!json || !json.aaData || json.aaData.length === 0) {
        console.log("No se encontraron cursos para mostrar.");
      }
      return json.aaData || [];
    },
    error: function (e) {
      console.error("Error cargando cursos_table:", e.responseText);
    }
  },
  language: {
    emptyTable: "No hay cursos disponibles"
  },
  dom: 'rtip',
  buttons: [],
  orderFixed: []
});


// Estilo de ancho
$("#cursos_table").addClass("width-100");

// Control de filtro activo si aplica
$('#cursos_table').on('draw.dt', function () {
  controlarFiltros('cursos_table');
});


$('#actividades_table').DataTable({
  columns: [
    { data: "nombreActividad", title: "Actividad", className: "text-center" },
    { data: "fechaActividad", title: "Fecha", className: "text-center" },
    { data: "horasLectivas", title: "Horas", className: "text-center" },
    { data: "puntoEncuentro", title: "Punto de Encuentro", className: "text-center" }
  ],
  columnDefs: [
    { targets: [0, 1, 2, 3], orderable: false }
  ],
  ajax: {
    url: "../../controller/evaluacionFinal.php?op=obtenerActividadesYHorasEvaluacion",
    type: "POST",
    dataType: "json",
    cache: false,
    serverSide: false,
    data: function (d) {
      d.idLlegada = idLlegada;
      d.tokenUsu = tokenUsuario;  // Asegúrate que tokenUsuario está definido en tu JS
    },
    dataSrc: function (json) {
      console.log("Actividades recibidas del servidor:", json);
      return json.aaData || [];
    },
    error: function (e) {
      console.error("Error cargando actividades_table:", e.responseText);
    }
  },
  language: {
    emptyTable: "No hay actividades disponibles"
  },
  dom: 'rtip',
  buttons: [],
  orderFixed: []
});

// Asignar ancho completo
$("#actividades_table").addClass("width-100");

// Control de filtro activo si tienes esa función definida
$('#actividades_table').on('draw.dt', function () {
  controlarFiltros('actividades_table');
});

function obtenerParametroURL(nombre) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(nombre);
}

/////////////////////////////////////////////////////
// ACCIÓN PARA ABRIR EL CERTIFICADO PARA DESCARGAR///
/////////////////////////////////////////////////////
 
// AJAX PARA OBTENER LA INFORMACIÓN DE LOS OBJETIVOS 
function obtenerObjetivosAlumno(idLlegada) {
  return $.ajax({
    url: "../../controller/evaluacionFinal.php?op=mostrarObjetivosAlumno",
    type: "get",
    dataType: "json",
    cache: false,
    serverSide: true,
    data: {
      idLlegada: idLlegada
    },
    beforeSend: function () {
      console.log("Solicitando objetivos del alumno con idLlegada =", idLlegada);
    },
    success: function (response) {
      console.log("Respuesta recibida:", response);
    },
    complete: function () {
      console.log("Solicitud completada.");
    },
    error: function (e) {
      console.error("Error al obtener objetivos:", e);
    }
  });
}

// CLICK DEL BOTÓN PARA IMPRIMIR LA EVALUACIÓN COMPLETA
$("body").on("click", ".imprimirEvaluacion", function () {
 
  /*
  LA FINALIDAD SERÁ QUE HAYA UN CÓDIGO ASÍ, PERO POR AHORA ME FALTA TENER LOS DATOS
  CORRECTAMENTE PARA PODER HACERLO
    nuevaVentana = window.open(
      "orden.php?idOrden=" +
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
  */
  
  const idLlegada = obtenerParametroURL("idLlegada");

  if (!idLlegada) {
    console.warn("idLlegada no encontrado en la URL");
    return;
  }

  nuevaVentana = window.open(
    "certificado.php?idLlegada=" + encodeURIComponent(idLlegada),
    "_blank",
    "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
  );
});


// CLICK DEL BOTÓN PARA IMPRIMIR EL CURSO SELECCIONADO
$("#certAlumno_generarCertificado").on("click", function() {
/*   const idLlegada = $('#certAlumno_idLlegada').val();
  const codigoGrupo = $('#certAlumno_codigoGrupo').val();
  const horasRealizadas = $('#certAlumno_horasRealizadas').val();
  const resultadoEvaluacion = $('#certAlumno_resultadoEvaluacion').val();
  const idCertificado = $('#certAlumno_idCertificado').val();  // <-- Capturamos el id certificado

  // Log de datos para depuración
  console.log("Generar Certificado - Datos recogidos:");
  console.log("ID Llegada:", idLlegada);
  console.log("Código Grupo:", codigoGrupo);
  console.log("Horas Realizadas:", horasRealizadas);
  console.log("Resultado Evaluación:", resultadoEvaluacion);
  console.log("ID Certificado:", idCertificado);

  if (!idLlegada || !codigoGrupo) {
    alert("Faltan datos necesarios para generar el certificado.");
    return;
  }
 */
  // NUEVA VALIDACION: si no existe idCertificado
 /*  if (!idCertificado) {
    toastr.error('Primero debe crear el certificado antes de imprimirlo.');
    return;
  } */
  const resultadoEvaluacion = $('#certAlumno_resultadoEvaluacion').val();
  const codigoGrupo = $('#certAlumno_codigoGrupo').val();
  const idLlegada = $('#idLlegada').val();

  if (resultadoEvaluacion !== "1") {
    toastr.warning('No se puede imprimir un certificado de curso que no está aprobado.');
    return;
  }

  const url = "certificado.php?idLlegada=" + encodeURIComponent(idLlegada) +
              "&codigoGrupo=" + encodeURIComponent(codigoGrupo);
  window.open(
    url,
    "_blank",
    "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
  );
});

// CLICK DEL BOTÓN PARA IMPRIMIR EL CERTIFICADO GENERAL
$("#generarCertificado").on("click", function() {

  const idLlegada = $('#idLlegada').val();
  const resultadoEvaluacion = $('#resultadoEvaluacion').val();


  if (resultadoEvaluacion !== "1") {
    toastr.warning('No se puede imprimir un certificado general que no está aprobado.');
    return;
  }

  const url = "certificado.php?idLlegada=" + encodeURIComponent(idLlegada);
  window.open(
    url,
    "_blank",
    "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
  );
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/

// GESTIONAR CERTIFICADO 

// GESTIONAR CERTIFICADO 
function convertirHorasATexto(horaStr) {
  const [hh, mm, _] = horaStr.split(':').map(Number);
  const horasTexto = [];

  if (hh > 0) horasTexto.push(`${hh} hora${hh !== 1 ? 's' : ''}`);
  if (mm > 0) horasTexto.push(`${mm} minuto${mm !== 1 ? 's' : ''}`);

  return horasTexto.join(' y ');
}

/////////////////////////////////////////////////////////////
// MÉTODO PARA CALCULAR EL RESULTADO DE MINUTOS / JORNADA //
///////////////////////////////////////////////////////////

function calcularResultadoTexto(modo) {
  let minutosCertificado, jornadaClase, resultadoTextoSelector;

  if (modo === 'individual') {
    minutosCertificado = parseFloat($('#certAlumno_minutosCertificado').val());
    jornadaClase = parseFloat($('#certAlumno_jornadaClase').val());
    resultadoTextoSelector = '#certAlumno_resultadoTexto';
  } else if (modo === 'completo'){
    minutosCertificado = parseFloat($('#minutosCertificado').val());
    jornadaClase = parseFloat($('#jornadaClase').val());
    resultadoTextoSelector = '#resultadoTexto';
  }

  if (!isNaN(minutosCertificado) && !isNaN(jornadaClase) && jornadaClase !== 0) {
    const resultado = minutosCertificado / jornadaClase;
    $(resultadoTextoSelector).text(resultado.toFixed(2)); // Igual que antes, solo text()
  } else {
    $(resultadoTextoSelector).text(''); // Vaciar si no es válido
  }
}

///////////////////////////////////////////////////////////////////////////////////////////////
// EVENTOS PARA QUE CUANDO SE HAGA CHANGE O KEYUP, HABILITE EL MÉTODO EN EL MODAL INDIVIDUAL //
///////////////////////////////////////////////////////////////////////////////////////////////

$('#certAlumno_jornadaClase, #certAlumno_minutosCertificado').on('keyup change', function() {
  calcularResultadoTexto('individual');
});

/////////////////////////////////////////////////////////////////////////////////////////////
// EVENTOS PARA QUE CUANDO SE HAGA CHANGE O KEYUP, HABILITE EL MÉTODO EN EL MODAL COMPLETO //
/////////////////////////////////////////////////////////////////////////////////////////////

$('#jornadaClase, #minutosCertificado').on('keyup change', function() {
  calcularResultadoTexto('completo');
});

//////////////////////////////////////////////////////////////////////
// EVENTOS PARA LÍMITE DE CARÁCTERES DE SUMMERNOTE DE MODAL GENERAL //
//////////////////////////////////////////////////////////////////////
    // NO FUNCIONA, PERO SERÍA UN BUEN AÑADIDO
/*
  const maxCaracteres = 200; // Límite de caracteres
const $editor = $('#observacionesCertificado');
const $contador = $('#contador-caracteres');

// Función que actualiza el contador
function actualizarContador() {
    const texto = $editor.val();
    const caracteresUsados = texto.length;
    
    // Mostrar el conteo (ejemplo: "85/200")
    $contador.text(caracteresUsados + '/' + maxCaracteres);
    
    // Cambiar color si se excede el límite
    $contador.css('color', caracteresUsados > maxCaracteres ? 'red' : '#666');
}

// Eventos que activan el contador (escribir Y pegar)
$editor.on('input paste', function() {
    // Pequeño delay para asegurar que se captura el texto pegado
    setTimeout(actualizarContador, 10);
});

// Actualizar al cargar la página
actualizarContador();
*/
//////////////////////////////////////////////////
// ABRIR Y CARGAR MODAL DE CERTIFICADO GENERAL //
////////////////////////////////////////////////

function mostrarModalCertificado(idLlegada) {
    // Aquí muestras el modal (usa Bootstrap, SweetAlert, o el que uses)
    console.log("ID llegada:", idLlegada);

    $.post(
        '../../controller/evaluacionFinal.php?op=recogerEvaluacionFinalAlumno',
        { idLlegada: idLlegada },
        function(response) {
            console.log(response); 

            var horasReales = response[0].total_horas_asistencia;
            var horasJustificadas = response[0].total_horas_justificadas;

            var idCertificado = response[0].idCertificado;
            var horasTotal = response[0].total_horas;
            var horasTotalTexto = convertirHorasATexto(horasTotal);
            var observacionesGenerales = response[0].textoDescripcionEvaluacionFinal;

            console.log("total horas:", horasTotal);

            // Mostrar u ocultar el botón de generar certificado según si hay ID
            if (idCertificado) {
                $('#generarCertificado').show();
            } else {
                $('#generarCertificado').hide();
            }

            // Asignar idCertificado al input hidden correcto (idCertificadoG en el modal)
            $('#idCertificadoG').val(idCertificado);
            // Asignar idLlegada al input hidden correcto
            $('#idLlegada').val(idLlegada);
            console.log("id certificado:", $('#idCertificadoG').val());
            
            // Asignar horas justificadas al input correcto
            $('#horasJustificadas').val(horasJustificadas);
            
            // Asignamos horas reales al input correspondiente
            $('#horasReales').val(horasReales);

            $('#horasRj').val(horasTotalTexto);
            
            $('#observacionesCertificado').summernote('code', observacionesGenerales); 

            // Configurar el checkbox para mostrar certificado
            var mostrar = response[0].mostrarCertificadoEvaluacionFinal;
            $('#mostrarCertificado').prop('checked', mostrar == 1);

            // Asignar resultado de evaluación
            $('#resultadoEvaluacion').val(response[0].estadoLlegadaEvaluacionFinal);

            // Asignar minutosCertificadoEvaluacionFinal si existe, sino calcular minutos y ponerlos
            var minutosCertificado = response[0].minutosCertificadoEvaluacionFinal;
            if (minutosCertificado === null || minutosCertificado === undefined) {
                var minutosCalculados = convertirHorasAMinutos(horasReales);
                $('#minutosCertificado').val(minutosCalculados);
            } else {
                $('#minutosCertificado').val(minutosCertificado);
            }

            // Completar jornadaClase si existe
            var jornadaClase = response[0].jornadaClaseEvaluacionFinal;
            if (jornadaClase !== null && jornadaClase !== undefined) {
                $('#jornadaClase').val(jornadaClase);
            } else {
                $('#jornadaClase').val('');
            }

            // Calcular resultadoTexto al abrir el modal
            calcularResultadoTexto("completo");

        },
        'json' 
    );

    // Mostrar el modal al usuario
    $('#mostrarModalCertificado').modal('show');
}

/////////////////////////////////////////////////////
// ABRIR Y CARGAR MODAL DE CERTIFICADO INDIVIDUAL //
/////////////////////////////////////////////////// 

function mostrarModalCertificadoPorCurso(idLlegada, idAlumno, codigoGrupo, idCertificado = null) {
    console.log("ID Llegada:", idLlegada);
    console.log("ID Alumno:", idAlumno);
    console.log("Código Grupo:", codigoGrupo);
    console.log("ID Certificado:", idCertificado);

    // Mostrar u ocultar botón Generar Certificado
    if (idCertificado) {
        $('#certAlumno_generarCertificado').show();
    } else {
        $('#certAlumno_generarCertificado').hide();
    }

    $.post(
        '../../controller/evaluacionFinal.php?op=recogerEvaluacionFinalAlumnoPorCurso',
        { idLlegada: idLlegada, idAlumno: idAlumno, codigoGrupo: codigoGrupo },
        function(response) {
            console.log(response);

            if (response && response.length > 0) {
                const data = response[0];

                const horasReales = data.total_horas_asistencia || "00:00:00";
                const horasJustificadas = data.total_horas_justificadas || "00:00:00";
                const horasTotalTexto = convertirHorasATexto(data.total_horas); 
                const minutosCertificado = data.minutosCertificadoEvaluacionFinal;
                const jornadaClase = data.jornadaClaseEvaluacionFinal;
                const observaciones = data.textoDescripcionEvaluacionFinal;

                // Asignar campos
                $('#certAlumno_horasReales').val(horasReales);
                $('#certAlumno_horasJustificadas').val(horasJustificadas);
                $('#certAlumno_horasRj').val(horasTotalTexto || '');

                // Asignar minutosCertificadoEvaluacionFinal si existe, sino calcular minutos y ponerlos
                if (minutosCertificado === null || minutosCertificado === undefined) {
                    var minutosCalculados = convertirHorasAMinutos(horasReales);
                    $('#certAlumno_minutosCertificado').val(minutosCalculados);
                } else {
                    $('#certAlumno_minutosCertificado').val(minutosCertificado);
                }

                // Completar jornadaClase si existe
                if (jornadaClase !== null && jornadaClase !== undefined) {
                    $('#certAlumno_jornadaClase').val(jornadaClase);
                } else {
                    $('#certAlumno_jornadaClase').val('');
                }

                $('#certAlumno_resultadoEvaluacion').val(data.estadoLlegadaEvaluacionFinal);
                $('#certAlumno_mostrarCertificado').prop('checked', data.mostrarCertificadoEvaluacionFinal == 1);

                // Asignar observaciones al summernote
                $('#certAlumno_observacionesCertificado').summernote('code', observaciones || '');

            } else {
                // Si no hay datos
                $('#certAlumno_horasReales').val('');
                $('#certAlumno_horasJustificadas').val('');
                $('#certAlumno_horasRj').val('');
                $('#certAlumno_minutosCertificado').val('');
                $('#certAlumno_jornadaClase').val('');
                $('#certAlumno_resultadoEvaluacion').val('');
                $('#certAlumno_mostrarCertificado').prop('checked', false);
                $('#certAlumno_observacionesCertificado').summernote('code', '');

                toastr.error('El alumno no ha realizado clases');
            }

            // Siempre guardar valores ocultos
            $('#certAlumno_idCertificado').val(idCertificado || '');
            $('#certAlumno_codigoGrupo').val(codigoGrupo);
            $('#idLlegada').val(idLlegada);

            // Actualizar resultado texto si lo estás usando
            calcularResultadoTexto("individual");
        },
        'json'
    );

    // Mostrar el modal
    $('#modalCertificadoAlumno').modal('show');
}

  // EVENTO CLICK DEL MODAL INDIVIDUAL PARA GUARDAR/EDITAR EL CERTIFICADO SELECCIONADO (modalCertificadoCurso)
$('#certAlumno_btnGuardarCambios').on('click', function() {
  guardarEditarCertificadoAlumno('individual');
});

 // EVENTO CLICK DEL MODAL INDIVIDUAL PARA GUARDAR/EDITAR EL CERTIFICADO COMPLETO (modalCertificado)
$('#btnGuardarCertificadoCompleto').on('click', function() {
    guardarEditarCertificadoAlumno('completo');
});

// FUNCIÓN PARA INSERTAR/EDITAR EL CERTIFICADO, TIENE EN CUENTA DESDE EL TIPO DE MODAL QUE QUIERE CREAR/EDITAR EL CERTIFICADO (INDIVIDUAL O GENERAL/COMPLETO)
function guardarEditarCertificadoAlumno(modo) {
  let idCertificado, idLlegada, tokenUsu, horasReales, mostrarCertificado, resultadoEvaluacion, codigoGrupo, jornadaClase, minutosCertificado, observaciones;

  // SI ES INDIVIDUAL SE GUARDAN LOS DATOS DEL MODAL INDIVIDUAL
  if (modo === 'individual') {
    idCertificado = $('#certAlumno_idCertificado').val();
    idLlegada = $('#idLlegada').val();
    codigoGrupo = $('#certAlumno_codigoGrupo').val();
    tokenUsu = $('#tokenUsu').val();
    horasReales = $('#certAlumno_horasReales').val();
    mostrarCertificado = $('#certAlumno_mostrarCertificado').is(':checked') ? 1 : 0;
    resultadoEvaluacion = $('#certAlumno_resultadoEvaluacion').val();
    jornadaClase = $('#certAlumno_jornadaClase').val();
    minutosCertificado = $('#certAlumno_minutosCertificado').val();
    observaciones = $('#certAlumno_observacionesCertificado').summernote('code');
    // SI ES EL GENERAL, SE GUARDAN LOS DATOS DEL MODAL DE GENERAL
  } else if (modo === 'completo') {
    idCertificado = $('#idCertificadoG').val();
    idLlegada = $('#idLlegada').val();
    codigoGrupo = null;
    tokenUsu = $('#tokenUsu').val();
    horasReales = $('#horasReales').val();
    mostrarCertificado = $('#mostrarCertificado').is(':checked') ? 1 : 0;
    resultadoEvaluacion = $('#resultadoEvaluacion').val();
    jornadaClase = $('#jornadaClase').val();
    minutosCertificado = $('#minutosCertificado').val();
    observaciones = $('#observacionesCertificado').summernote('code');
  }

  // VALIDACIÓN PARA COMPROBAR QUE LOS CAMPOS ESTÁN COMPLETOS
  if (!idLlegada || !tokenUsu || !horasReales || !resultadoEvaluacion || resultadoEvaluacion === 'Seleccione un resultado' || !minutosCertificado || !jornadaClase) {
    toastr.error('Faltan campos por completar');
    return;
  }

  // GUARDO LOS DATOS QUE VOY A QUERER INSERTAR/EDITAR
  let formData = {
    idCertificado: idCertificado,
    idLlegada: idLlegada,
    codigoGrupo: codigoGrupo,
    tokenUsu: tokenUsu,
    horasReales: horasReales,
    mostrarCertificado: mostrarCertificado,
    resultadoEvaluacion: resultadoEvaluacion,
    minutosCertificado: minutosCertificado,
    jornadaClase: jornadaClase,
    textoDescripcion: observaciones,
    modo: modo
  };

  // SI EXISTE EL ID CERTIFICADO, ES QUE QUEREMOS EDITAR
  if (idCertificado) {
    $.ajax({
      type: 'POST',
      url: "../../controller/evaluacionFinal.php?op=editarEvaluacion",
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response) {
          toastr.success('Certificado actualizado');
          $('#cursos_table').DataTable().ajax.reload(null, false);
        } else {
          toastr.error('Error al actualizar el certificado');
        }
      }
    });

    // SI EL MODO ES INDIVIDUAL, SE CIERRA EL MODAL INDIVIDUAL, SI ES EL GENERAL, SE CIERRA EL GENERAL
    if (modo === 'individual') {
      $('#modalCertificadoAlumno').modal('hide');
    } else if (modo === 'completo') {
      $('#mostrarModalCertificado').modal('hide');
    }

  } else {
    // EN CASO DE NO EXISTIR EL ID CERTIFICADO, SE PASA A INSERTAR
    // EN EL CASO DE QUE SE QUIERA INSERTAR EN EL MODAL DE GENERAL,
    // SE PREGUNTA AL USUARIO SI VA A QUERER DESACTIVAR TODOS LOS CURSOS
    // EN CASO AFIRMATIVO, PRIMERO INSERTA EL CERTIFICADO, Y DESPUÉS 
    // DESACTIVA LOS CURSOS
    if (modo === 'completo') {
      Swal.fire({
        title: '¿Estás seguro?',
        text: 'Se desactivarán los cursos asociados. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        focusCancel: true
      }).then(function(result) {
        if (result.isConfirmed) {
          // AJAX QUE SE ENCARGA DE INSERTAR EL CERTIFICADO GENERAL
          $.ajax({
            type: 'POST',
            url: "../../controller/evaluacionFinal.php?op=insertarEvaluacion",
            data: formData,
            dataType: 'json',
            success: function(response) {
              if (response) {
                toastr.success('Certificado creado');
                $('#cursos_table').DataTable().ajax.reload(null, false);

                // SI SE HA INSERTADO CORRECTAMENTE EL CERTIFICADO GENERAL, SE
                // HACE OTRO AJAX PARA DESACTIVAR LOS CURSOS

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS */
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS */
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS */
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS *//* DESACTIVAR CURSOS */
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
                $.ajax({
                  type: 'POST',
                  url: "../../controller/evaluacionFinal.php?op=desactivarCursos",
                  data: { idLlegada: idLlegada },
                  dataType: 'json',
                  success: function(respuesta) {
                    if (respuesta.success === true) {
                      toastr.success("Cursos desactivados correctamente");
                    } else {
                      toastr.error("No se pudieron desactivar los cursos");
                    }
                    console.log("Respuesta desactivarCursos:", respuesta);
                  },
                  error: function() {
                    toastr.warning("Hubo un problema al desactivar los cursos");
                  }
                });

                $('#mostrarModalCertificado').modal('hide');

              } else {
                toastr.error('Error al insertar el certificado');
              }
            }
          });
        }
      });
    } else {
      // SI EL CERTIFICADO ES INDIVIDUAL, DIRECTAMENTE SE INSERTA EL CERTIFICADO
      $.ajax({
        type: 'POST',
        url: "../../controller/evaluacionFinal.php?op=insertarEvaluacion",
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response) {
            toastr.success('Certificado creado');
            $('#cursos_table').DataTable().ajax.reload(null, false);
          } else {
            toastr.error('Error al insertar el certificado');
          }
        }
      });

      $('#modalCertificadoAlumno').modal('hide');
    }
  }
}


/*
function guardarCertificadoAlumno() {
    // Aquí muestras el modal (usa Bootstrap, SweetAlert, o el que uses)
    console.log("ID llegada:", idLlegada);
    $('#horasRealizadas').val();
     $.post(
      '../../controller/evaluacionFinal.php?op=recogerEvaluacionFinalAlumno',
      { idLlegada: idLlegada },
      function(response) {
       
        $('#horasRealizadas').response[0].horasCertificadoEvaluacionFinal;
        var mostrar = response[0].mostrarCertificadoEvaluacionFinal;
        $('#mostrarCertificado').prop('checked', mostrar == 1);
        console.log(response[0].estadoLlegadaEvaluacionFinal);
        $('#resultadoEvaluacion').val(response[0].estadoLlegadaEvaluacionFinal);

        
      },
      'json' // <- IMPORTANTE: esto fuerza a jQuery a interpretar como JSON
    );


    $('#mostrarModalCertificado').modal('show');
}
    */

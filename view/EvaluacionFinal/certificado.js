function actualizarPaginacion() {
  $('.pagenum').each(function(index) {
    $(this).text("Página " + (index + 1) + " de " + $('.pagenum').length);
  });
}


$(document).ready(function () {
  // RECOJO EL ID LLEGADA POR UN HIDDEN OCULTO
  const idLlegada = $('#idLlegadaURL').val();
  const codigoGrupoVal = $('#codigoGrupoURL').val();
  const horasRealizadasVal = $('#horasRealizadasURL').val();

  const codigoGrupo = codigoGrupoVal !== '' ? codigoGrupoVal : null;
  const horasRealizadas = horasRealizadasVal !== '' ? horasRealizadasVal : null;

  console.log("IDLlegada:",idLlegada);
  console.log("codigoGrupo:",codigoGrupo);

  // Definimos certificadoData con valores estáticos por defecto
  let certificadoData = {
    nombre: "Alexander",
    fechaInicio: "21 de octubre",
    fechaFin: "20 de diciembre de 2024",
    horasCurso: "153",
    tipoCurso: "Curso Intensivo Español",
    fechaCertificado: "Valencia, a 20 de diciembre de 2024",
    firmas: [
      {
        img: "firma1.png",
        alt: "Firma Adela",
        nombre: "Adela Sanz Esteve",
        cargo: "Jefa de estudios de Costa de Valencia, escuela de español"
      },
      {
        img: "firma2.png",
        alt: "Firma Andreas",
        nombre: "Andreas Tessmer",
        cargo: "Director de Costa de Valencia, escuela de español"
      }
    ]
  };

  if (codigoGrupo) {
  // Si hay código de grupo, primero obtener detalles dinámicos para certificadoData
  /*
  $.ajax({
    url: "../../controller/evaluacionFinal.php?op=obtenerDetallesCursoAlumno",
    type: "GET",
    dataType: "json",
    data: { idLlegada: idLlegada, codigoGrupo: codigoGrupo },
    beforeSend: function() {
      console.log("Solicitando detalles del alumno y curso para idLlegada =", idLlegada);
    },
    success: function(response) {
      if (response && response.nombreAlumno && Array.isArray(response.detallesCurso) && response.detallesCurso.length > 0) {
        const curso = response.detallesCurso[0]; // Tomamos el primer curso

        certificadoData = {
          nombre: response.nombreAlumno,
          fechaInicio: curso.fechaInicio,
          fechaFin: curso.fechaFin,
          horasCurso: horasRealizadas || "0",
          tipoCurso: curso.tipoCurso,
          codigoGrupo: curso.codigoGrupo,
          fechaCertificado: curso.fechaCertificado,
          firmas: certificadoData.firmas // mantenemos las firmas predeterminadas
        };
      }
*/
      // Luego hacemos el ajax para objetivos por grupo
      $.ajax({
        url: "../../controller/evaluacionFinal.php?op=mostrarObjetivosPorGrupo",
        type: "get",
        dataType: "json",
        cache: false,
        data: { idLlegada: idLlegada, codigoGrupo: codigoGrupo },
        beforeSend: function () {
          console.log("Solicitando objetivos del alumno con idLlegada =", idLlegada, "y codigoGrupo =", codigoGrupo);
        },
        success: function (response) {
          console.log("Respuesta recibida para grupo:", response);
          procesarRespuesta(response, certificadoData);
        },
        complete: function () {
          console.log("Solicitud completada para grupo.");
        },
        error: function (e) {
          console.error("Error al obtener objetivos por grupo:", e);
        }
      });
    /*},

    error: function(err) {
      console.error("Error al obtener detalles del curso y alumno:", err);
    }
    */
  //});
} else {
    // Si NO hay código de grupo, directamente usamos los datos estáticos
    // Y hacemos ajax para objetivos sin código de grupo
    $.ajax({
      url: "../../controller/evaluacionFinal.php?op=mostrarObjetivosAlumno",
      type: "get",
      dataType: "json",
      cache: false,
      data: { idLlegada: idLlegada },
      beforeSend: function () {
        console.log("Solicitando objetivos del alumno con idLlegada =", idLlegada);
      },
      success: function (response) {
        console.log("Respuesta recibida:", response);
        procesarRespuesta(response, certificadoData);
      },
      complete: function () {
        console.log("Solicitud completada.");
      },
      error: function (e) {
        console.error("Error al obtener objetivos:", e);
      }
    });
  }

  // FUNCIÓN QUE RELLENA EL CERTIFICADO CON LOS DATOS RECIBIDOS
  function procesarRespuesta(response, certificadoData) {
    const contenidosCursos = response.aaData;
    if (!contenidosCursos || contenidosCursos.length === 0) {
      console.warn("No se encontraron contenidos para el alumno.");
      return;
    }

    const contenidoCurso = contenidosCursos[0];

    // RELLENO LOS DATOS DE LA PRIMERA PÁGINA, APROVECHANDO ALGÚN DATO
    // DEL AJAX
    $('#nombre').text(certificadoData.nombre);
    $('#fechaInicio').text(certificadoData.fechaInicio);
    $('#fechaFin').text(certificadoData.fechaFin);
    $('#totalHoras').text(certificadoData.totalHoras);
    //$('#horasCurso').text(certificadoData.horasCurso);
    $('#tipoCurso').text(certificadoData.tipoCurso);
    //$('#nivel').text(contenidoCurso.nivel);
    //$('#horasParticulares').text(certificadoData.horasParticulares);
   // $('#horasAutonomo').text(certificadoData.horasAutonomo);
    //$('#horasSocioculturales').text(certificadoData.horasSocioculturales);
    //$('#fechaCertificado').text(certificadoData.fechaCertificado);

    // PONER IMAGENES DE FIRMAS DE LA PRIMERA PÁGINA
    $('.row.text-center > .col-md-6').each(function(index) {
      if (certificadoData.firmas[index]) {
        const firma = certificadoData.firmas[index];
        $(this).find('img.firma-img').attr('src', firma.img).attr('alt', firma.alt);
        $(this).find('.nombre-firma').text(firma.nombre);
        $(this).find('.cargo-firma').text(firma.cargo);
      }
    });

    // TÍTULO PRINCIPAL DE LA SEGUNDA PÁGINA Y SU NIVEL
    $('.bloque-titulos').html(`
      <div class="row">
        <div class="col-12">
          <div class="titulo-principal text-start">
            ${contenidoCurso.titulo} ${contenidoCurso.tituloGeneral}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="bloque-nivel text-end">
            <b>NIVEL BÁSICO <span>(${contenidoCurso.nivel})</span></b>
          </div>
        </div>
      </div>
    `);

    // RECORRER TODAS LAS SECCIONES QUE HA RETORNADO EL AJAX, Y EN BASE A LAS QUE HAYA, CREAR APARTADOS DE SECCIONES, CON SU CONTENIDO
    const seccionesContenedor = $('.secciones');
    seccionesContenedor.empty();

    contenidoCurso.contenidos.forEach((seccion, index) => {
      const idContenido = `contenidos-${index}`;
      const bloqueHTML = `
        <div class="col-3">
          <div class="seccion">
            <h3>${seccion.tituloSeccion}</h3>
            <div class="texto-contenido" id="${idContenido}">
              <ul>
                ${seccion.contenido.map(obj => `<li>${obj}</li>`).join('')}
              </ul>
            </div>
          </div>
        </div>
      `;
      seccionesContenedor.append(bloqueHTML);
    });

    // NOTA QUE TIENE HORAS, POR AHORA ESTÁTICA (A FUTURO DEBERÍA DE SER ESTÁTICA)
    $('.nota').text(`La duración prevista del nivel ${contenidoCurso.nivel} es de 80 horas lectivas, aunque puede variar según el ritmo de aprendizaje.`);

    $('.cert-container').show();
    actualizarPaginacion();
    window.print();
  }
});






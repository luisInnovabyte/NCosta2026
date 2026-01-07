function actualizarPaginacion() {
  $('.pagenum').each(function(index) {
    $(this).text("Página " + (index + 1) + " de " + $('.pagenum').length);
  });
}

function inicializarYimprimir() {
  // DATOS ESTÁTICOS POR AHORA, AQUÍ IRÁ LA INFORMACIÓN CORRECTA
  const certificadoData = {
    nombre: "Alexander",
    fechaInicio: "21 de octubre",
    fechaFin: "20 de diciembre de 2024",
    totalHoras: "198.5",
    horasCurso: "153",
    tipoCurso: "Curso Intensivo Español",
    nivel: "A2",
    horasParticulares: "15",
    horasAutonomo: "26.5",
    horasSocioculturales: "4",
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

  const data = certificadoData;

  // Actualizar el contenido con las variables
  $('#nombre').text(data.nombre);
  $('#fechaInicio').text(data.fechaInicio);
  $('#fechaFin').text(data.fechaFin);
  $('#totalHoras').text(data.totalHoras);
  $('#horasCurso').text(data.horasCurso);
  $('#tipoCurso').text(data.tipoCurso);
  $('#nivel').text(data.nivel);
  $('#horasParticulares').text(data.horasParticulares);
  $('#horasAutonomo').text(data.horasAutonomo);
  $('#horasSocioculturales').text(data.horasSocioculturales);
  $('#fechaCertificado').text(data.fechaCertificado);

  // Actualizar firmas existentes
  $('.row.text-center > .col-md-6').each(function(index) {
    if (data.firmas[index]) {
      const firma = data.firmas[index];
      $(this).find('img.firma-img').attr('src', firma.img).attr('alt', firma.alt);
      $(this).find('.nombre-firma').text(firma.nombre);
      $(this).find('.cargo-firma').text(firma.cargo);
    }
  });

  // Contenidos del curso
  const contenidosCurso = {
    titulo: "CONTENIDOS TRATADOS DURANTE EL CURSO DE ESPAÑOL PARA EXTRANJEROS - ",
    nivel: "NIVEL BÁSICO <span>(A2)</span>",
    funcionales: `– Dar y entender instrucciones para llegar a un lugar.<br>
      – Entender y elaborar biografías breves.<br>
      – Expresar la obligación o el deber de hacer algo.<br>
      – Desenvolverse en entrevistas dando y pidiendo información sobre acontecimientos pasados.<br>
      – Contrastar y comparar costumbres y hábitos del pasado con el presente.<br>
      – Solicitar y dar información para el alquiler de una vivienda.<br>
      – Reformular el discurso para evitar repeticiones.<br>
      – Relatar experiencias, acciones o narrar historias en el pasado.<br>
      – Desenvolverse en establecimientos como hoteles, restaurantes o tiendas.<br>
      – Expresar deseos, planes e intenciones.<br>
      – Elaborar recetas de cocina.<br>
      – Realizar predicciones.`,
    gramaticales: `– Tiempos pasados de indicativo: perfecto, indefinido, imperfecto.<br>
      – Imperativo afirmativo y negativo (“tú” y “usted”).<br>
      – Revisión ortográfica.<br>
      – Perífrasis de obligación, deseo e intención.<br>
      – Presente continuo.<br>
      – Comparaciones: igualdad, superioridad, inferioridad.<br>
      – Pronombres OD y OI.<br>
      – Posesivos.<br>
      – Preposiciones básicas. “por” vs. “para”.<br>
      – “Ser” vs. “estar”.<br>
      – Apócope de adjetivos.<br>
      – Superlativo absoluto y relativo.<br>
      – Introducción al régimen preposicional.<br>
      – Futuro simple.<br>
      – Género de sustantivos irregulares.`,
    lexicos: `– Adverbios y locuciones del pasado.<br>
      – La ciudad.<br>
      – La música.<br>
      – Profesiones y trabajo.<br>
      – Relaciones personales.<br>
      – Aspecto y carácter.<br>
      – Descripción de objetos.<br>
      – La vivienda y el alquiler.<br>
      – Cuentos y lectura.<br>
      – Viajes y transportes.<br>
      – Hotel y servicios.<br>
      – Números ordinales.<br>
      – Ropa y tiendas.<br>
      – Cine.<br>
      – Alimentación y cocina.<br>
      – Marcadores temporales del futuro.<br>
      – Predicciones y suerte.`,
    culturales: `– Valencia ciudad.<br>
      – Músicos hispanoamericanos.<br>
      – Costumbres laborales.<br>
      – Situación laboral en España.<br>
      – Festividades en España.<br>
      – Tolerancia cultural.<br>
      – La comida en España.<br>
      – Eventos culturales.<br>
      – Cine y series españolas.<br>
      – Cuentos y leyendas.<br>
      – Personajes históricos.<br>
      – Lugares turísticos.<br>
      – Fiestas populares.<br>
      – La música en la cultura española.`,
    nota: "La duración prevista del nivel A2 es de 80 horas lectivas, aunque puede variar según el ritmo de aprendizaje."
  };

  $('.titulo-principal').html(contenidosCurso.titulo + "<b class='bloque-nivel'>" + contenidosCurso.nivel + "</b>");
  $('#contenidos-funcionales').html(contenidosCurso.funcionales);
  $('#contenidos-gramaticales').html(contenidosCurso.gramaticales);
  $('#contenidos-lexicos').html(contenidosCurso.lexicos);
  $('#contenidos-culturales').html(contenidosCurso.culturales);
  $('.nota').text(contenidosCurso.nota);

  // Actualizar paginación
  actualizarPaginacion();

  // Mostrar el certificado
  $('.cert-container').show();

  // Finalmente imprimir (no cerrar ventana)
  window.print();
}

$(document).ready(function () {
  // Ejecutar todo al cargar la página
  inicializarYimprimir();

  // Botón regresar
  $('#btn-regresar').click(function() {
    window.history.back();
  });

  // Botón imprimir: vuelve a ejecutar TODO desde cero
  $('#btn-imprimir').click(function() {
    inicializarYimprimir();
  });
});

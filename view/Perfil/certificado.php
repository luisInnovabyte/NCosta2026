<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Certificado y Contenidos Curso A2</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    /* --- CSS para CONTENIDOS CURSO A2 --- */
    body {
      font-family: 'Open Sans', sans-serif;
      margin: 0;
      padding: 2rem;
      background-color: white;
    }
   
    .barra-superior {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    .bloque-logos {
      display: flex;
      gap: 1rem;
    }
/* 
    .secciones {
      display: flex;
      justify-content: space-between;
      gap: 1rem;
      margin-top: 2rem;
      flex-wrap: nowrap;
    } */

    @media (max-width: 1024px) {
      .secciones {
        flex-wrap: wrap;
      }
    }
    

    .bloque-logos img {
      height: 50px;
    }

    .bloque-titulos {
      text-align: right;
      color: #002c60;
    }

    .titulo-principal {
      font-weight: bold;
      font-size: 1.1rem;
      text-transform: uppercase;
    }

    .bloque-nivel {
      font-size: 1.5rem;
      font-weight: bold;
      color: #002c60;
    }

    .bloque-nivel span {
      color: #1ca5f9;
    }

    .seccion {
      border: 2px dotted #f7a700;
      padding: 1rem;
      background-color: #fff;
      min-height: 100%;
    }

    .seccion h3 {
      text-align: center;
      font-weight: bold;
      font-size: 0.8rem;
      color: #111;
      text-transform: uppercase;
      border-bottom: 2px solid #f7a700;
      padding-bottom: 0.3rem;
      margin-bottom: 1rem;
    }

    .texto-contenido {
      font-size: 0.80rem;
      color: #000; /* negro puro */
      line-height: 1.0;
    }

    .nota {
    text-align: center;
    font-size: 0.60rem;
    color: #002c60;
    line-height: 1.2;
      margin-bottom: 0;

  }

    .pie {
      background-color: #5ca9dd;
      color: white;
      text-align: center;
      font-size: 0.60rem;
      padding: 1rem;
    }

    em {
      font-style: italic;
    }


    /* --- CSS para CERTIFICADO --- */
    body.certificado-body {
      background-color: #f4f4f4;
      font-family: 'Open Sans', sans-serif;
    }

    .cert-container {
      max-width: 1080px;
      background-image: url('imagenCertificadoCosta.png');
      background-size: cover;
      background-position: center;
      aspect-ratio: 1080 / 768;
      display: none; /* Oculto al inicio */
    }

    .text-cert {
      color: #002c60;
    }

    .nombre-firma {
      font-weight: 600;
      font-size: 14px;
      color: #002c60;
    }

    .cargo-firma {
      font-size: 13px;
    }

    .contenido-cert {
      font-size: 17px;
      line-height: 1.5;
      color: #000;
      text-align: center;
    }

    .lista-cert {
      display: inline-block;
      text-align: left;
      margin: 0 auto;
    }

    .lista-cert .linea {
      display: block;
    }

    .firma-img {
      max-height: 90px;
    }

    .fecha-certificado {
      font-size: 15px !important;
    }

    @media (max-width: 768px) {
      .contenido-cert {
        font-size: 15px;
      }

      .nombre-firma,
      .cargo-firma {
        font-size: 12px;
      }

      .fw-bold.display-6 {
        font-size: 1.5rem;
      }

      .fecha-certificado {
        font-size: 13px !important;
      }
    }

    @media print {
      body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      #btn-regresar,
      #btn-imprimir,
      .container.my-3.text-center {
        display: none !important;
      }
    }
  </style>
</head>
<body>
    <!-- Botones para regresar o imprimir -->
  <div class="container my-3 text-center">
    <button id="btn-regresar" class="btn btn-secondary me-2">Regresar</button>
    <button id="btn-imprimir" class="btn btn-primary">Imprimir de nuevo</button>
  </div>
   <!-- --- CERTIFICADO --- -->
  <div class="cert-container mx-auto" style="display:block;">
    <div class="container h-100 d-flex flex-column">

      <!-- Espacio fijo arriba -->
      <div style="height: 200px;"></div>

      <!-- Nombre del estudiante -->
      <div class="row">
        <div class="col-12 text-center">
          <h1 class="fw-bold display-6 text-cert" id="nombre">Uwe Hockenjos</h1>
        </div>
      </div>

      <!-- Detalle del curso -->
      <div class="row justify-content-center mt-3">
        <div class="col-10 contenido-cert" id="contenido">
          ha realizado una estancia lingüística en
          <strong class="text-cert">Costa de Valencia, escuela de español</strong>, del
          <span id="fechaInicio">21 de octubre</span> al
          <span id="fechaFin">20 de diciembre de 2024</span>, de una duración equivalente a
          <strong class="text-cert"><span id="totalHoras">198.5</span></strong>*, divididas en:<br /><br />

          <div class="lista-cert">
            <span class="linea">- <span id="horasCurso">153</span> horas lectivas de <em><span id="tipoCurso">Curso Intensivo y de Conversación</span></em> de español de <strong class="text-cert">nivel <span id="nivel">A2</span></strong></span>
            <span class="linea">- <span id="horasParticulares">15</span> horas lectivas de Clases Particulares</span>
            <span class="linea">- <span id="horasAutonomo">26.5</span> horas de trabajo autónomo y realización de tareas</span>
            <span class="linea">- <span id="horasSocioculturales">4</span> horas de actividades socioculturales</span>
          </div>
        </div>
      </div>

      <!-- Fecha -->
      <div class="row justify-content-center mt-4">
        <div class="col-10 text-center">
          <div class="text-cert fecha-certificado" id="fechaCertificado">
            Valencia, a 20 de diciembre de 2024
          </div>
        </div>
      </div>

      <!-- Firmas -->
      <div class="row text-center g-3 mt-4" style="position: relative; top: -60px;">
        <div class="col-md-6 mb-3 mb-md-0">
          <img src="firma1.png" alt="Firma Adela" class="firma-img mb-2" />
          <div class="nombre-firma">Adela Sanz Esteve</div>
          <div class="cargo-firma">Jefa de estudios de Costa de Valencia, escuela de español</div>
        </div>
        <div class="col-md-6">
          <img src="firma2.png" alt="Firma Andreas" class="firma-img mb-2" />
          <div class="nombre-firma">Andreas Tessmer</div>
          <div class="cargo-firma">Director de Costa de Valencia, escuela de español</div>
        </div>
      </div>

    </div>
  </div>
  
  <!-- --- CONTENIDOS CURSO A2 --- -->
  <div class="container">

    <div class="row justify-content-between align-items-start mb-4 barra-superior">
      <div class="col-auto d-flex gap-3 align-items-center bloque-logos">
        <img src="costaLogo.png" alt="Logo Costa" style="height: 80px;">
        <img src="imagenAcreditado.png" alt="Acreditado" style="height: 80px;">
      </div> 
      <div class="col-auto bloque-titulos text-end">
        <div class="titulo-principal">CONTENIDOS TRATADOS DURANTE EL CURSO DE ESPAÑOL PARA EXTRANJEROS - <b class="bloque-nivel">NIVEL BÁSICO <span>(A2)</span></b></div>
      </div>
    </div>

    <div class="row g-3 secciones">
      <div class="col-3">
        <div class="seccion">
          <h3>Funcionales</h3>
          <div class="texto-contenido" id="contenidos-funcionales">
            – Dar y entender instrucciones para llegar a un lugar.<br>
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
            – Realizar predicciones.
          </div>
        </div>
      </div>

      <div class="col-3">
        <div class="seccion">
          <h3>Gramaticales</h3>
          <div class="texto-contenido" id="contenidos-gramaticales">
            – Tiempos pasados de indicativo: perfecto, indefinido, imperfecto.<br>
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
            – Género de sustantivos irregulares.
          </div>
        </div>
      </div>

      <div class="col-3">
        <div class="seccion">
          <h3>Léxicos</h3>
          <div class="texto-contenido" id="contenidos-lexicos">
            – Adverbios y locuciones del pasado.<br>
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
            – Predicciones y suerte.
          </div>
        </div>
      </div>

      <div class="col-3">
        <div class="seccion">
          <h3>Culturales</h3>
          <div class="texto-contenido" id="contenidos-culturales">
            – Valencia ciudad.<br>
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
            – La música en la cultura española.
          </div>
        </div>
      </div>
    </div>

    <p class="nota">
      La duración prevista del nivel A2 es de 80 horas lectivas, aunque puede variar según el ritmo de aprendizaje.
    </p>

    <div class="pie">
      <strong>Costa de Valencia, escuela de español</strong> es CENTRO ACREDITADO POR EL INSTITUTO CERVANTES PARA LA ENSEÑANZA DE ESPAÑOL A EXTRANJEROS.<br>
      <em>Costa de Valencia, escuela de español</em>, es una denominación comercial de Costa de Valencia, S.L., formación no reglada. Avda. Blasco Ib.
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="certificado.js"></script>

</body>
</html>

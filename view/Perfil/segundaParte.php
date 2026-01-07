<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Contenidos Curso A2</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
  <style>
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

    .secciones {
      display: flex;
      justify-content: space-between;
      gap: 1rem;
      margin-top: 2rem;
      flex-wrap: nowrap;
    }

    .seccion {
      flex: 1;
      min-width: 200px;
      border: 2px dotted #f7a700;
      padding: 1rem;
      background-color: #fff;
    }

    .seccion h3 {
      text-align: center;
      font-weight: bold;
      font-size: 1.1rem;
      color: #111;
      text-transform: uppercase;
      border-bottom: 2px solid #f7a700;
      padding-bottom: 0.3rem;
      margin-bottom: 1rem;
    }

    .texto-contenido {
    font-size: 0.95rem;
    color: #000; /* Aquí está el cambio a negro puro */
    line-height: 1.5;
    }


    .nota {
      text-align: center;
      font-size: 0.85rem;
      color: #002c60;
      margin-top: 1.5rem;
    }

    .pie {
      background-color: #5ca9dd;
      color: white;
      text-align: center;
      font-size: 0.85rem;
      padding: 1rem;
      margin-top: 1.5rem;
      line-height: 1.5;
    }

    em {
      font-style: italic;
    }

    @media (max-width: 1024px) {
      .secciones {
        flex-wrap: wrap;
      }
    }
  </style>
</head>
<body>

  <div class="barra-superior">
    <div class="bloque-logos">
      <img src="costaLogo.png" alt="Logo Costa" style="height: 80px;">
      <img src="imagenAcreditado.png" alt="Acreditado" style="height: 80px;">
    </div>
    <div class="bloque-titulos">
      <div class="titulo-principal">CONTENIDOS TRATADOS DURANTE EL CURSO DE ESPAÑOL PARA EXTRANJEROS</div>
      <div class="bloque-nivel">NIVEL BÁSICO <span>(A2)</span></div>
    </div>
  </div>

  <div class="secciones">
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

    <div class="seccion">
      <h3>Culturales</h3>
      <div class="texto-contenido" id="contenidos-culturales">
        – Valencia ciudad.<br>
        – Músicos hispanoamericanos.<br>
        – Costumbres laborales.<br>
        – Situación laboral española.<br>
        – Uso del espacio personal.<br>
        – España antes y ahora.<br>
        – Vivienda en España.<br>
        – Leyendas y tradiciones (ej: Sant Jordi).<br>
        – Turismo español.<br>
        – Hábitos de consumo.<br>
        – Cine español.<br>
        – Dieta mediterránea.<br>
        – Actitudes ante la comida.<br>
        – Buena y mala suerte.
      </div>
    </div>
  </div>

  <p class="nota">La duración prevista del nivel A2 es de 80 horas lectivas, aunque puede variar según el ritmo de aprendizaje.</p>

  <div class="pie">
    <strong>Costa de Valencia, escuela de español</strong> es CENTRO ACREDITADO POR EL INSTITUTO CERVANTES PARA LA ENSEÑANZA DE ESPAÑOL A EXTRANJEROS.<br>
    <em>Costa de Valencia, escuela de español</em>, es una denominación comercial de Costa de Valencia, S.L., formación no reglada. Avda. Blasco Ib

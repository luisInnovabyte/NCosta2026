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

  <?php 

    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    require_once("../../models/EvaluacionFinal.php");
    $idLlegada = $_GET['idLlegada'];
    $codigoGrupo = $_GET['codigoGrupo'];

    $evaluacionFinal = new EvaluacionFinal();
    if($codigoGrupo == ''){
      $datosEvaluacionFinal = $evaluacionFinal->obtenerCertificadoGeneral($idLlegada);
    }else{
      $datosEvaluacionFinal = $evaluacionFinal->obtenerCertificadoIndividual($idLlegada,$codigoGrupo);
    }


    
    $nombreAlum = $datosEvaluacionFinal[0]['nomAlumno']. ' '.$datosEvaluacionFinal[0]['apeAlumno'];
      
    
    if (isset($datosEvaluacionFinal[0]['fechaInicio']) && !empty($datosEvaluacionFinal[0]['fechaInicio'])) {
        $fechaInicio = formatearFechaEsp($datosEvaluacionFinal[0]['fechaInicio']);
    } else {
        $fechaInicio = ''; // o "Sin registrar"
        $json_string = json_encode('asd');
        $file = 'CASPER.json';
        file_put_contents($file, $json_string);
    }

    if (isset($datosEvaluacionFinal[0]['fechaFin']) && !empty($datosEvaluacionFinal[0]['fechaFin'])) {
        $fechaFin = formatearFechaEsp($datosEvaluacionFinal[0]['fechaFin']);
    } else {
        $fechaFin = '';
        $json_string = json_encode('');
        $file = 'CASPIR.json';
        file_put_contents($file, $json_string);
    }

    $json_string = json_encode('sa');
    $file = 'Rata.json';
    file_put_contents($file, $json_string);

    $hoy = new DateTime();
    $fechaHoy = formatearFechaEsp($hoy->format('Y-m-d')); // También: 2025-06-30

    $minutosCertificado = $datosEvaluacionFinal[0]['minutosCertificadoEvaluacionFinal'] ?? 0;
    $jornadaClase       = $datosEvaluacionFinal[0]['jornadaClaseEvaluacionFinal'] ?? 0;
    $textoDescripcion   = $datosEvaluacionFinal[0]['textoDescripcionEvaluacionFinal'] ?? 0;

    // Evitar división por 0
    if ($jornadaClase > 0) {
        $horasRealizadas = round($minutosCertificado / $jornadaClase, 2);
    } else {
        $horasRealizadas = 0;
    }

    $cantidadAsistencias = $evaluacionFinal->cantidadAsistencias($idLlegada) ?? 0;


    // Si total_asistencia es null, poner 0
    if (is_null($cantidadAsistencias["total_asistencia"])) {
        $cantidadAsistencias["total_asistencia"] = 0;
    }    

    function formatearFechaEsp($fecha) {
      $meses = [
          1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
          5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
          9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
      ];

      // Validar formato y fecha
      $partes = explode('-', $fecha);
      if (count($partes) !== 3) return null;

      [$año, $mes, $dia] = $partes;

      if (!checkdate((int)$mes, (int)$dia, (int)$año)) return null;

      // Formatear con nombre del mes en español
      $dia = ltrim($dia, '0');
      $mesNombre = $meses[(int)$mes];

      return "$dia de $mesNombre de $año";
  }


  ?>
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
    }
  </style>
</head>
<body>

   <!-- --- CERTIFICADO --- -->
  <div class="cert-container mx-auto" style="display:block;">
    <div class="container h-100 d-flex flex-column">

      <!-- Espacio fijo arriba -->
      <div style="height: 200px;"></div>
      <input type="hidden" id="idLlegadaURL" value="<?php echo $_GET['idLlegada']?>">

      <input type="hidden" id="codigoGrupoURL" value="<?php echo isset($_GET['codigoGrupo']) ? $_GET['codigoGrupo'] : ''; ?>">
      <input type="hidden" id="horasRealizadasURL" value="<?php echo isset($_GET['horasRealizadas']) ? $_GET['horasRealizadas'] : ''; ?>">

      <!-- Nombre del estudiante -->
      <div class="row">
        <div class="col-12 text-center">
          <h1 class="fw-bold display-6 text-cert" id=""><?php echo $nombreAlum; ?></h1>
        </div>
      </div>

      <!-- Detalle del curso -->
      <div class="row justify-content-center mt-3">
        <div class="col-10 contenido-cert" id="contenido">
          ha realizado una estancia lingüística en
          <strong class="text-cert">Costa de Valencia, escuela de español</strong>, del
          <span id=""><?php echo $fechaInicio;?></span> al
          <span id="fechaFin"><?php echo $fechaFin;?></span>, de una duración equivalente a
          <strong class="text-cert"><span id="totalHoras"><?php echo $horasRealizadas;?></span></strong>*, divididas en:<br /><br />

        <div class="lista-cert">
            <div class="col-10" id="observaciones">
              <?php 
                $textoLimpio = trim(strip_tags($textoDescripcion));
                
                if ($textoLimpio === '') {
                    echo '<span style="white-space: nowrap;">Actividades realizadas: ' . $cantidadAsistencias['total_asistencia'] . '</span>';
                } else {
                    echo $textoDescripcion;
                }
              ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Fecha -->
      <div class="row justify-content-center mt-4">
        <div class="col-10 text-center">
          <div class="text-cert fecha-certificado" id="fechaCertificado">
            Valencia, a <?php echo $fechaHoy;?>
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
    <div class="col-12 bloque-titulos">
    <div class="row">
      <div class="col-12">
        <div class="titulo-principal text-start">
          CONTENIDOS TRATADOS DURANTE EL CURSO DE ESPAÑOL PARA EXTRANJEROS -
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="bloque-nivel text-end">
          <b>NIVEL BÁSICO <span>(A2)</span></b>
        </div>
      </div>
    </div>
  </div>


  <!-- 🔽 AQUÍ SE INSERTARÁN LAS SECCIONES DINÁMICAMENTE -->
  <div class="row g-3 secciones">
    <!-- Ejemplo de sección que se insertará con JS:
    <div class="col-3">
      <div class="seccion">
        <h3>Funcionales</h3>
        <div class="texto-contenido" id="contenidos-funcionales">…contenido…</div>
      </div>
    </div>
    -->
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

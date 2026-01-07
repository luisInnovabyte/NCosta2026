<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->
<head>

<?php include("../../config/templates/mainHead.php"); ?>
<?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
     checkAccess(['1','0','2','3']);

    ?>
<!--end head-->
  <style>
        /* Efecto de elevación para el card al hacer hover en un input */
        .card-hover {
              transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
          }

          .card-hover:hover,
          .card-hover.active {
              transform: translateY(-5px);
              box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
          }
          #departamentosDiv {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center;    /* Centra verticalmente */
            flex-direction: column; /* Asegura que los elementos estén en columna */
            height: 100%;           /* Si quieres que ocupe todo el alto del contenedor */
          }
          #departamentosDivProfe {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center;    /* Centra verticalmente */
            flex-direction: column; /* Asegura que los elementos estén en columna */
            height: 100%;           /* Si quieres que ocupe todo el alto del contenedor */
          }
@media (max-width: 768px) {
  #departamentosDiv {
    display: flex;
    flex-direction: column; /* Asegura que las tarjetas estén en columna */
    align-items: center; /* Centra las tarjetas horizontalmente */
    padding: 10px; /* Añade espacio alrededor */
  }
  #departamentosDivProfe {
    display: flex;
    flex-direction: column; /* Asegura que las tarjetas estén en columna */
    align-items: center; /* Centra las tarjetas horizontalmente */
    padding: 10px; /* Añade espacio alrededor */
  }

  .card {
    width: 90%; /* Reduce el ancho de las tarjetas en pantallas pequeñas */
    max-width: 400px; /* Define un ancho máximo */
  }

  .fm-icon-box {
    font-size: 24px; /* Ajusta el tamaño del icono si es necesario */
  }
}
/* Añade una animación de giro continuo */




  </style>
</head>



<body>

  <!--start mainHeader-->
  <?php include("../../config/templates/mainHeader.php"); ?>
  <!--end mainHeader-->


  <!--start sidebar-->
  <?php include("../../config/templates/mainSidebar.php"); ?>
  <!--end sidebar-->


  <!--start main content-->
  <main class="page-content">
    
    <!-- Título de la empresa -->
    <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 60vh;">
      <h1 style="color: #1AA3E8; font-weight: 700; font-size: 4.5rem; margin-bottom: 0; font-family: 'Arial', sans-serif;">Costa de Valencia</h1>
      <p style="color: #1AA3E8; font-weight: 400; font-size: 1.5rem; letter-spacing: 3px; margin-top: 5px;">ESCUELA DE ESPAÑOL</p>
    </div>

    <input type="hidden" id="rolUsuInput" value="<?php echo $_SESSION['usu_rol']; ?>">
    <input type="hidden" id="depaSelect" value="<?php echo $_SESSION['llegada_idDepartamento']; ?>">
      <?php  if($_SESSION['usu_rol'] == 3 ){ ?>

        <!--alumno-->
        <div class="card p-4 text-center shadow-lg border-0 rounded-4" style="background-color: #f9f9f9;">
        <h4 class="mb-4" style="color: #333; font-weight: 600;">Selecciona un departamento para acceder a tus cursos</h4>

        <div id="departamentosDiv" class="my-4">
          
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center mt-4">
          <p style="color: #555;">¿Has completado ya tu perfil?</p>
          <a href="../Perfil/?tokenUsuario=<?php echo $tokenUsu; ?>" class="btn btn-outline-info px-5 rounded-pill d-flex align-items-center">
            <span class="material-symbols-outlined me-2">emoji_people</span> Ver Perfil
          </a>
        </div>
      </div>

      <?php  } ?>
      <?php  if($_SESSION['usu_rol'] == 2 ){ ?>
        <!--profesor-->

      <div class="card p-4 text-center shadow-lg border-0 rounded-4" style="background-color: #f9f9f9;">
        <h4 class="mb-4" style="color: #333; font-weight: 600;">Selecciona un departamento para acceder a tus cursos</h4>

        <div id="departamentosDivProfe" class="my-4 border-animation">
          
        </div>

      
      </div>
      <?php  } ?>

   <!--      <input id="test" class="form-control fechaFullpick form-control-sm">
        <input id="test1" class="form-control fechaSinHorapick form-control-sm">
        <button onclick="probar()">Pres</button>
 -->

<script>
  function probar(){
    test = formatearFechaConHora($('#test').val());
    test1 = formatearFechaSinHora($('#test1').val());
    console.log(test);
        console.log(test1);

  }

</script>

  </main>
  <!--end main content-->


  <!--start overlay-->
  <div class="overlay btn-toggle-menu"></div>
  <!--end overlay-->

  <!-- Search Modal -->
  <?php include("../../config/templates/searchModal.php"); ?>
<?php include("../../config/templates/mainFooter.php"); ?>



  <!--start theme customization-->
  <?php include("../../config/templates/mainThemeCustomization.php"); ?>

  <!--end theme customization-->



  <!--BS Scripts-->
  <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



  <!--start plugins extra-->
   <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
   <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
  <!--end plugins extra-->
  <script src="index.js"></script>



</body>

</html>
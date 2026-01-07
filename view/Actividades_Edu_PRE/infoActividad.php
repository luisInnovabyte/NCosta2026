<?php
session_start();
require '../../config/funciones.php';
require '../../config/conexion.php';

require_once("../../models/Actividades_Edu.php");

$idActividad = $_GET['idAct'];

$actividad = new Actividades();

$datosActividad =  $actividad->getActividad_x_id($idActividad);

if ($idActividad == '') {
  header("Location: index.php");
}
$maxAlum = $datosActividad[0]['maxAlumAct'];

$minAlum = $datosActividad[0]['minAlumAct'];

?>
<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Efeuno Dev">


  <!-- Required meta tags -->
  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">
  <link rel="shortcut icon" href="../../public/img/favicon.png">
  <!-- Site Title -->
  <title><?php echo $idActividad ?> - <?php echo $datosActividad[0]['descrAct']; ?></title>

  <link rel="stylesheet" href="../../public/js/libs/pdfActividades/assets/css/efeuno.css">
  <link rel="stylesheet" href="../../public/js/libs/pdfActividades/assets/css/style.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../../public/assets/plugins/notifications/css/lobibox.min.css">
  <!-- CSS de Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" integrity="sha512-mS+8SaxMTJj0z7Vvjc0xwW8AukJL6mOR7Vv/g2QnnW8rA/2bJy/6zOT5O5PT5TV3qNfLgjJlrO9D0G8Hxnj/g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- TOASTR Encargado de las alertas -->
<link href="../../public/assets/js/toastr/build/toastr.css" rel="stylesheet">
</head>
<body>

  <input type="hidden" value="<?php echo $idActividad ?>" id="idActividad">
  <input type="hidden" value="<?php echo $datosActividad[0]['maxAlumAct'] ?>" id="alumnosMaximos">

  
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">

        <div class="tm_invoice_in">

          <div class="tm_invoice_head tm_mb20">
            <div class="tm_invoice_left mg-20">
              <div class="tm_logo"><img src="../../public/img/logo_pequeno.png" alt="Logo"></div>
            </div>
            <div class="tm_invoice_right">
              <div class="tm_grid_row tm_col_3">
                <div>
                  <b class="tm_primary_color">Email</b> <br>
                  info@costadevalencia.com<br>

                </div>
                <div>
                  <b class="tm_primary_color">Teléfono</b> <br>
                  (+34) 96 361 03 67
                </div>
                <div class="tx-break">
                  <b class="tm_primary_color">Ubicación</b><br>Av. de Blasco Ibáñez, 66, València
                </div>
              </div>
            </div>
          </div>


          <div class="tm_padd_20 tm_mb20">

            <!-- TITULO Y IMAGEN -->
            <img src="../../public/img/actividades/<?php echo $datosActividad[0]['imgAct']; ?>" class="wd-100p img-fluid" style="height: 250px !important;" alt="">
            <h1 class="tx-hind tx-center mg-t-20 mg-b-20" id="tituloActividad"><?php echo $datosActividad[0]['descrAct']; ?></h1>

            <div class="tm_grid_row tm_col_3 tm_align_center  tm_text_center  mg-t-20">
              <div class="tm_border_right tm_accent_border_20 tm_border_none_sm">
                <i class="fa-regular fa-calendar-xmark tx-30 tx-primary"></i><br>
                <p><b>Fecha Límite</b></p>
                <p class="">
                  <?php echo fechaLocal($datosActividad[0]['fecActFinSolicitud']); ?>
                </p>
              </div>
              <div class="tm_border_right tm_accent_border_20 tm_border_none_sm">
                <i class="fa-regular fa-calendar-days tx-30 tx-primary"></i><br>
                <p><b>Fecha de Actividad</b></p>
                <p class="">
                  <?php echo fechaLocal($datosActividad[0]['fecActDesde']); ?>
                </p>
              </div>
              <div>
                <div class=" tm_accent_border_20 tm_border_none_sm">
                  <i class="fa-regular fa-clock tx-30 tx-primary "></i><br>
                  <p><b>Duración Estimada</b></p>
                  <p class="">
                    <?php
                    $horasEstimadas = $datosActividad[0]['horasLectivasAct'];
                    $plural = ($horasEstimadas == '1') ? '' : 's';
                    echo $horasEstimadas . ' Hora' . $plural;

                    ?>

                  </p>
                </div>

              </div>
            </div>

            <!-- DESCRIPCION DE LA ACTIVIDAD -->
            <div class="tm_note tm_font_style_normal">
              <hr class="tm_mb15">
              <p class="tm_mb2 tx-15"><b class="tm_primary_color">Descripción de la actividad</b></p>
              <p class="tm_m0"><?php echo $datosActividad[0]['obsAct']; ?></p>

              <!-- PUNTO DE ENCUENTRO -->
                <p class="tm_mb2 tx-15"><b class="tm_primary_color">Punto de encuentro:</b> <?php echo $datosActividad[0]['puntoEncuentroAct']; ?></p>
              <!-- GUÍA -->
                <p class="tm_mb2 tx-15"><b class="tm_primary_color">Guía:</b> <?php echo $datosActividad[0]['nomPersonal']; ?> <?php echo $datosActividad[0]['apePersonal']; ?> </p><br>
               
                <p class="tm_mb2 tx-15"><b class="tm_primary_color">Máximo <?php echo $datosActividad[0]['maxAlumAct'].$plural = ($maxAlum == '1') ? '👤 Alumno' : '👥 Alumnos'; ?>  para realizar la actividad</b> |
                <b class="tm_primary_color">Mínimo <?php echo $datosActividad[0]['minAlumAct'].$plural = ($minAlum == '1') ? '👤 Alumno' : '👥 Alumnos'; ?> para realizar la actividad</b> </p> 
              </div><!-- .tm_note -->
         
            </div>
          </div>
        </div>
        <div class="tm_invoice_btns tm_hide_print">
          <a href="javascript:preparePrint()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                <circle cx="392" cy="184" r="24" fill='currentColor' />
              </svg>
            </span>
            <span class="tm_btn_text">Imprimir</span>
          </a>
        </div>
      </div>
    </div>
    <!-- <?php //require '../../config/templates/mainJs.php'; ?>
    <script src="../../public/js/libs/pdfActividades/assets/js/jspdf.min.js"></script>
    <script src="../../public/js/libs/pdfActividades/assets/js/html2canvas.min.js"></script>
    <script src="../../public/js/libs/pdfActividades/assets/js/main.js"></script> -->
    <!-- <script src="actividadesIndex.js"></script>
 -->

<!-- jQuery desde el CDN oficial de jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- JS de Bootstrap 5 (requiere jQuery) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js" integrity="sha512-Ehik9PxoMgukzqktcvgJHBBx+dtb+W/0Z2t94ZJtPI1+X+rL73j+wJyDvlz0FmQ2e0+4w4TmnMnfTmT0j9LmSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Toastr CSS -->


 
<!-- TOASTR -->
<script src="../../public/assets/js/toastr/toastr.js"></script>
<script src="../../public/assets/js/lobibox/lobibox.min.js"></script>

<script>
  //* ALERTAS DE USUARIOS EN LA ACTIVIDAD*//

  // Función personalizada para ocultar Lobibox antes de imprimir
  function preparePrint() {
      // Remueve todas las notificaciones Lobibox activas
      $(".lobibox-notify").remove(); // Clase generada por Lobibox para las notificaciones

      // Opcional: Ocultar o desactivar cualquier otra clase que interfiera con la impresión
      $(".lobitoBox").hide();

      // Llamar a la función de impresión
      window.print();

      // Opcional: Restaurar después de imprimir
      $(".lobitoBox").show();
  }


$(document).ready(function() {

  
  idActividad = $('#idActividad').val();
  alumnosMaximos = $('#alumnosMaximos').val();
  $.post(
    "../../controller/actividades_edu.php?op=totalActividad", //! NO TOCAR
    { actividad: idActividad }, //! NO TOCAR
    function (data) {

      console.log(data); // Verificar el contenido completo del array

        // Convertir el string JSON en un objeto JavaScript
        const parsedData = JSON.parse(data);

        // Accede al primer objeto del array y a la clave "TOTAL"
        const totalCount = parsedData[0]["TOTAL"];

        console.log(totalCount); // Debería imprimir "1"

        // Convierte el valor a número
        const total = parseInt(totalCount, 10);

        console.log(total); // Debería imprimir 1 como número
        
        // Determina el texto basado en la cantidad de alumnos
        let plural = total === 1 ? '👤 Alumno' : '👥 Alumnos';
        let pluralApuntados = total === 1 ? 'apuntado' : 'apuntados';

        if (total < alumnosMaximos) {
                    if (alumnosMaximos - total <= 2) {
                        // Cerca del límite
                        // Cerrar notificaciones activas de Lobibox antes de crear una nueva
                        var notification = Lobibox.notify("warning", {
                            pauseDelayOnHover: true, // Pausar el temporizador al pasar el mouse
                            continueDelayOnInactiveTab: false, // No continuar el retraso si la pestaña está inactiva
                            position: "bottom center", // Posición en la parte superior central
                            icon: "fa-solid fa-user", // Icono FontAwesome
                            delay: false, // Duración infinita
                            title: "Cupo Limitado", // Título personalizado
                            msg: `¡Quedan pocos lugares! Hay un total de <b>${total}</b> ${plural} ${pluralApuntados} a la actividad de ${alumnosMaximos} máximos.`, // HTML en el mensaje
                            closeOnClick: false,
                            closable: false, // Eliminar el botón de cierre
                            class: "lobitoBox" // Clase personalizada

                          });
                       
                    } else {
                        // Hay suficiente espacio
                        var notification = Lobibox.notify("success", {
                            pauseDelayOnHover: true, // Pausar el temporizador al pasar el mouse
                            continueDelayOnInactiveTab: false, // No continuar el retraso si la pestaña está inactiva
                            position: "bottom center", // Posición en la parte superior central
                            icon: "fa-solid fa-user", // Icono FontAwesome
                            delay: false, // Duración infinita
                            title: "Alumnos Apuntados", // Título personalizado
                            msg: `Hay un total de <b>${total}</b> ${plural} ${pluralApuntados} a la actividad de ${alumnosMaximos} máximos.`, // HTML en el mensaje
                            closeOnClick: false,
                            closable: false, // Eliminar el botón de cierre
                            class: "lobitoBox" // Clase personalizada

                        });
                      
                    }
                } else {
                    // Actividad llena
                    var notification = Lobibox.notify("error", {
                            pauseDelayOnHover: true, // Pausar el temporizador al pasar el mouse
                            continueDelayOnInactiveTab: false, // No continuar el retraso si la pestaña está inactiva
                            position: "bottom center", // Posición en la parte superior central
                            icon: "fa-solid fa-user", // Icono FontAwesome
                            delay: false, // Duración infinita
                            title: "Actividad Llena", // Título personalizado
                            msg: `La actividad está llena. Se alcanzó el máximo de <b>${alumnosMaximos}</b> alumnos.`, // HTML en el mensaje
                            closeOnClick: false,
                            closable: false, // Eliminar el botón de cierre
                            class: "lobitoBox" // Clase personalizada

                    });
                  
                }



    }
  );



});


</script>

</body>

</html>
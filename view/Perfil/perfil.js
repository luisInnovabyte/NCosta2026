////////////////////////////////////////////////////////////////
////////////////////// PERFIL - USUARIO ///////////////////////
//////////////////////////////////////////////////////////////


//################################################//
//############# INSERT DATOS CUENTA ##############//
//################################################//

$("#insertar-cuenta-form").on("submit", function (e) {

    e.preventDefault();
  
    var formData = new FormData($("#insertar-cuenta-form")[0]);
  
  
    $.ajax({
      url: "../../controller/perfil.php?op=actualizarCuentaPerfil",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        toastr["success"]("Datos de cuenta actualizados", "Cuenta");
        console.log($("#idUsuarioAvatar").val());
        actualizarCampos($("#idUsuarioAvatar").val()); 
      },
      
    });
  
  
  
  });
  //################################################//
  //################################################//
  //################################################//
  
  //################################################//
  //############# RESTABLECER CONTRASEÑA ###########//
  //################################################//
  $(document).ready(function () {
    // Código a ejecutar cuando el DOM esté listo
  
    // Ejemplo: mostrar un mensaje en la consola
  
    // Realizar otras acciones o manipulaciones del DOM
    // ...
  
    $("#enviarCorreo").click(function () {
  
      $.ajax({
        url: "../../controller/usuario.php?op=recogerUsuariosBD&correo=" + $("#emailUsuario").val(),
        type: "GET",
        dataType: "text",
        error: function (error) {
          console.log(error);
        },
        success: function (res) {
          if (res == 1) {
  
            $.ajax({
              url: "../../controller/usuario.php?op=enviarCorreo&correo=" + $("#emailUsuario").val(),
              type: "GET",
              dataType: "text",
              error: function (error) {
                console.log(error);
              },
              success: function (res) {
  
                swal.fire(
                  'Enviado',
                  'El correo se ha enviado',
                  'success'
                )
              },
              complete: function (res) {
  
              },
            });
          } else {
  
            swal.fire(
              'Error',
              'Este correo no existe',
              'error'
            )
          }
        },
        complete: function (res) {
          /*  var  jsonObject = JSON.parse(res);
           console.log(jsonObject); // 1 */
  
        },
      });
    })
  });
  
  //###################################################//
  //############# DATOS DE CONOCIMIENTO  ##############//
  //###################################################//
  
  // SI HAY DATOS EN LA BD, PONER SWITCH TRUE
  if ($('#estudiadoSpanish').val() == 1) {
  
    // Establecer el valor del Bootstrap Switch a TRUE
    $("#estudiadoSpanish").bootstrapSwitch("state", false);
  } else {
    $("#estudiadoSpanish").bootstrapSwitch("state", true);
  
  }
  
  
  $("#insertar-conocimientos-form").on("submit", function (e) {
  
    e.preventDefault();
  
    var formData = new FormData($("#insertar-conocimientos-form")[0]);
  
  
    // Obtener el estado actual del switch - ¿Has estudiado antes español?
    var switchValue = $("#estudiadoSpanish").bootstrapSwitch("state");
  
    // Verificar el estado del switch
    if (switchValue) { // SWITCH ACTIVO = NO
      formData.append("estEspAlumno", '0');
    } else { // SWITCH ACTIVO = SI
      formData.append("estEspAlumno", '1');
    }
  
  
    $.ajax({
      url: "../../controller/perfil.php?op=actualizarConocimientosPerfil",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        toastr["success"]("Datos de Conocimientos actualizados", "Conocimientos");
      }
    });
  
  
  
  });
  $(document).ready(function () {
    // Inicializar el switch
    $("#estudiadoSpanish").bootstrapSwitch();
  
    // Obtener el estado actual del switch
    var switchValue = $("#estudiadoSpanish").bootstrapSwitch("state");
  
    // Verificar el estado del switch
    if (switchValue) {
      $('.onSpanish').addClass('d-none');
  
    } else {
      $('.onSpanish').removeClass('d-none');
  
    }
  
    // Capturar el evento de cambio del switch
    $("#estudiadoSpanish").on("switchChange.bootstrapSwitch", function (event, state) {
      // Obtener el estado actual del switch
      var switchValue = state;
  
      // Verificar el estado del switch y realizar acciones
      if (switchValue) {
        $('.onSpanish').addClass('d-none');
        $('#nivEspAlumno').val('0');
        $('#tiemEspAlumno').val('');
        $('#lugEspAlumno').val('');
        // Realizar acciones adicionales cuando el switch está encendido
      } else {
        $('.onSpanish').removeClass('d-none');
        // Realizar acciones adicionales cuando el switch está apagado
      }
    });
  });
  
  
  //################################################//
  //############# DATOS DE APRENDIZAJE ##############//
  //################################################//
  
  $("#insertar-aprendizaje-form").on("submit", function (e) {
  
    e.preventDefault();
  
    var formData = new FormData($("#insertar-aprendizaje-form")[0]);
  
    // Obtener el valor de cada checkbox y asignar 0 o 1 en función de si están marcados o no
    var act1AlumnoValue = $("#act1Alumno").is(":checked") ? 1 : 0;
    var act2AlumnoValue = $("#act2Alumno").is(":checked") ? 1 : 0;
    var act3AlumnoValue = $("#act3Alumno").is(":checked") ? 1 : 0;
    var act4AlumnoValue = $("#act4Alumno").is(":checked") ? 1 : 0;
    var act5AlumnoValue = $("#act5Alumno").is(":checked") ? 1 : 0;
    var act6AlumnoValue = $("#act6Alumno").is(":checked") ? 1 : 0;
    var act7AlumnoValue = $("#act7Alumno").is(":checked") ? 1 : 0;
  
    // Append de cada variable en formData
    formData.append("act1Alumno", act1AlumnoValue);
    formData.append("act2Alumno", act2AlumnoValue);
    formData.append("act3Alumno", act3AlumnoValue);
    formData.append("act4Alumno", act4AlumnoValue);
    formData.append("act5Alumno", act5AlumnoValue);
    formData.append("act6Alumno", act6AlumnoValue);
    formData.append("act7Alumno", act7AlumnoValue);
  
  
    $.ajax({
      url: "../../controller/perfil.php?op=insertarAprendizajePerfil",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        toastr["success"]("Datos de aprendizaje actualizados", "Aprendizaje");
      }
    });
  
  });
  
  
  //################################################//
  //############# DATOS DE OBJETIVOS ##############//
  //################################################//
  
  if ($('#gus5EspAlumno').is(':checked')) {
    $('#gusTextEspAlumnoDiv').removeClass('d-none');
  } else {
    $('#gusTextEspAlumnoDiv').addClass('d-none');
  }
  
  // Función para cambiar la visibilidad del campo cuando se produzca un cambio en el checkbox
  $('#gus5EspAlumno').on('change', function () {
    if ($(this).is(':checked')) {
      $('#gusTextEspAlumnoDiv').removeClass('d-none');
    } else {
      $('#gusTextEspAlumnoDiv').addClass('d-none');
    }
  });
  
  //################################################//
  // Filtros de la visibilidad del campo TEXTO //
  //################################################//
  
  var conAlumno2 = $('#conAlumno2');
  var conRecoAlumnoDiv = $('#conRecoAlumnoDiv');
  
  function toggleConRecoAlumnoDiv() {
    if (conAlumno2.is(':checked')) {
      conRecoAlumnoDiv.removeClass('d-none');
    } else {
      conRecoAlumnoDiv.addClass('d-none');
      $('#conRecoAlumno').val('');
    }
  }
  
  $('input[name="conAlumno"]').change(function () {
    toggleConRecoAlumnoDiv();
  });
  
  toggleConRecoAlumnoDiv();
  
  //###//
  
  var conAlumno3 = $('#conAlumno3');
  var conAgenAlumnoDiv = $('#conAgenAlumnoDiv');
  
  function toggleAgenAlumnoDiv() {
    if (conAlumno3.is(':checked')) {
      conAgenAlumnoDiv.removeClass('d-none');
    } else {
      conAgenAlumnoDiv.addClass('d-none');
      $('#conAgenAlumno').val('');
    }
  }
  
  $('input[name="conAlumno"]').change(function () {
    toggleAgenAlumnoDiv();
  });
  
  toggleAgenAlumnoDiv();
  
  //################################################//
  //################################################//
  
  
  
  $("#insertar-objetivos-form").on("submit", function (e) {
  
    e.preventDefault();
  
    var formData = new FormData($("#insertar-objetivos-form")[0]);
  
  
    // Obtener el valor de cada checkbox y asignar 0 o 1 en función de si están marcados o no
    var gus1EspAlumno = $("#gus1EspAlumno").is(":checked") ? 1 : 0;
    var gus2EspAlumno = $("#gus2EspAlumno").is(":checked") ? 1 : 0;
    var gus3EspAlumno = $("#gus3EspAlumno").is(":checked") ? 1 : 0;
    var gus4EspAlumno = $("#gus4EspAlumno").is(":checked") ? 1 : 0;
    var gus5EspAlumno = $("#gus5EspAlumno").is(":checked") ? 1 : 0;
  
  
    // Append de cada variable en formData
    formData.append("gus1EspAlumno", gus1EspAlumno);
    formData.append("gus2EspAlumno", gus2EspAlumno);
    formData.append("gus3EspAlumno", gus3EspAlumno);
    formData.append("gus4EspAlumno", gus4EspAlumno);
    formData.append("gus5EspAlumno", gus5EspAlumno);
  
  
    $.ajax({
      url: "../../controller/perfil.php?op=insertarObjetivosPerfil",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        toastr["success"]("Objetivos actualizados", "Objetivos");
      }
    });
  
  });
  //################################################//
  //############# DATOS DE ACTIVIDADES ##############//
  //################################################//
  
  // switch participar actividades //
  
  $(document).ready(function () {
  
    // SI HAY DATOS EN LA BD, PONER SWITCH TRUE
    if ($('#partActAlumno').val() == 1) {
  
      // Establecer el valor del Bootstrap Switch a TRUE
      $("#partActAlumno").bootstrapSwitch("state", false);
    } else {
      $("#partActAlumno").bootstrapSwitch("state", true);
  
    }
  
  
    // Inicializar el switch
    $("#partActAlumno").bootstrapSwitch();
  
    // Obtener el estado actual del switch
    var switchValuePartActAlumno = $("#partActAlumno").bootstrapSwitch("state");
  
    // Verificar el estado del switch
    if (switchValuePartActAlumno) {
      $('#numActAlumnoDiv').addClass('d-none');
  
    } else {
      $('#numActAlumnoDiv').removeClass('d-none');
  
    }
  
    // Capturar el evento de cambio del switch
    $("#partActAlumno").on("switchChange.bootstrapSwitch", function (event, state) {
      // Obtener el estado actual del switch
      var switchValuePartActAlumno = state;
  
      // Verificar el estado del switch y realizar acciones
      if (switchValuePartActAlumno) {
        $('#numActAlumnoDiv').addClass('d-none');
        $('#numActAlumno').val('');
        // Realizar acciones adicionales cuando el switch está encendido
      } else {
        $('#numActAlumnoDiv').removeClass('d-none');
        // Realizar acciones adicionales cuando el switch está apagado
      }
    });
  });
  
  $("#insertar-actividades-form").on("submit", function (e) {
  
    e.preventDefault();
  
    var formData = new FormData($("#insertar-actividades-form")[0]);
  
    // Obtener el estado actual del switch - ¿Te gustaria participar actividades?
    var switchValuePartActAlumno = $("#partActAlumno").bootstrapSwitch("state");
  
    // Verificar el estado del switch
    if (switchValuePartActAlumno) { // SWITCH ACTIVO = NO
      formData.append("partActAlumno", '0');
    } else { // SWITCH ACTIVO = SI
      formData.append("partActAlumno", '1');
    }
  
  
    // Obtener el valor de cada checkbox y asignar 0 o 1 en función de si están marcados o no
    var actSocialesAlumno = $("#actSocialesAlumno").is(":checked") ? 1 : 0;
    var actGastroAlumno = $("#actGastroAlumno").is(":checked") ? 1 : 0;
    var actCultAlumno = $("#actCultAlumno").is(":checked") ? 1 : 0;
    var actDepoAlumno = $("#actDepoAlumno").is(":checked") ? 1 : 0;
  
  
    // Append de cada variable en formData
    formData.append("actSocialesAlumno", actSocialesAlumno);
    formData.append("actGastroAlumno", actGastroAlumno);
    formData.append("actCultAlumno", actCultAlumno);
    formData.append("actDepoAlumno", actDepoAlumno);
  
  
    $.ajax({
      url: "../../controller/perfil.php?op=insertarActividadesPerfil",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        toastr["success"]("Datos actualizados", "Actividades");
      }
    });
  
  });
  //################################################//
  //########### DATOS DE ADAPTACIONES ##############//
  //################################################//
  $("#guardarAdaptaciones").on("click", function () {

    var formData = new FormData();

    // Obtener el valor de cada checkbox y asignar 0 o 1
    var agoraAlumno = $("#agoraAlumno").is(":checked") ? 1 : 0;
    var minusvaliaAlumno = $("#minusvaliaAlumno").is(":checked") ? 1 : 0;
    var obsMinusvaliaAlumno = $('#obsMinusvaliaAlumno').val();
    var idUsuario = $("input[name='idUsuario']").val();

    // Agregar datos al FormData
    formData.append("agoraAlumno", agoraAlumno);
    formData.append("minusvaliaAlumno", minusvaliaAlumno);
    formData.append("obsMinusvaliaAlumno", obsMinusvaliaAlumno);
    formData.append("idUsuario", idUsuario);

    $.ajax({
        url: "../../controller/perfil.php?op=insertarAdaptacionesPerfil",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            toastr["success"]("Datos actualizados", "Adaptaciones");
        },
        error: function (xhr, status, error) {
            console.error("Error en la petición AJAX:", error);
            toastr["error"]("Hubo un problema al actualizar los datos.");
        }
    });
  });

  //################################################//
  //############# CAMBIAR AVATAR ####################//
  //################################################//
  
  function filePreview(input) {
    var reader = new FileReader();
    reader.readAsDataURL(input.files[0]);
    reader.onload = function (e) {
      //  $('#preAvatar').remove();
      $('#avatarImage').attr("src", e.target.result);
      // console.log($('#preAvatar').attr("src", e.target.result));
    } // del onload
  } // de la defincion de la funcion
  
  
  
  $(document).ready(function () {
    $('#selectAvatarBtn').click(function () {
      $('#avatarInput').click();
    });
  
    $('#avatarInput').change(function () {
      var file = $(this)[0].files[0];
      var maxSize = 2 * 1024 * 1024; // Tamaño máximo de archivo en bytes (2 MB)
  
      filePreview(this);
  
  
      if (file && file.size <= maxSize) {
  
        $('#selectAvatarBtn').addClass('d-none');
        $('#guardarAvatarBtn').removeClass('d-none');
  
        $('#guardarAvatarBtn').click(function () {
  
  
          var formData = new FormData();
          formData.append('idUsuario', $('#idUsuarioAvatar').val());
          formData.append('avatar', file);
  
          $.ajax({
            url: '../../controller/perfil.php?op=editarAvatar',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              // Mostrar SweetAlert con un botón de OK
              toastr["success"]('Avatar cambiado.');
              
            },
            error: function (xhr, status, error) {
              console.log(error);
            }
          });
        })
      } else {
        alert('Por favor, seleccione una imagen menor o igual a 2 MB.');
      }
    });
  });
  //* ==========================================================================================
  //* ======================================VALIDACIONES========================================
  //* ==========================================================================================
  
  $('#nomUsuario').blur(function () {
    campo1 = new validarCampos($(this), /^(?=.*[A-Za-z\d])[A-Za-zñÑáéíóúüÁÉÍÓÚÜ\d\s]+$/gm, $(this).next());
    campo1.validarCrear();
  });
  $('#numActAlumno').blur(function () {
    campo1 = new validarCampos($(this), /^\d+$/, $(this).next());
    campo1.validarCrear();
  });
  
  /*
  $('#teleAlumno').blur(function () {
    campo1 = new validar($(this), /^[0-9]+$/, $(this).next());
    campo1.validarCrear();
  });*/
  
  // Inicializar el campo de entrada de teléfono con la configuración especificada
  $("#teleAlumno").intlTelInput({
    initialCountry: "auto", // País inicial (España en este caso)
    geoIpLookup: function(success, failure) {
      // Obtener la ubicación del usuario a través de una solicitud a ipinfo.io
      $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "";
        success(countryCode); // Llamar a la función success con el código de país obtenido
      });
    },
    utilsScript: "../../public/flags/build/js/utils.js" // Ruta al script de utilidades del plugin
  });
  
  const input = document.querySelector("#teleAlumno"); // Obtener el campo de entrada de teléfono
  const errorMsg = document.querySelector("#error-msg"); // Obtener el elemento del mensaje de error
  const validMsg = document.querySelector("#valid-msg"); // Obtener el elemento del mensaje de validación
  
  // Mapa de errores: el índice se corresponde con el código de error devuelto por getValidationError
  const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
  
  // Inicializar el objeto del plugin
  const iti = window.intlTelInput(input, {
    utilsScript: "/intl-tel-input/js/utils.js?1684676252775" // Ruta al script de utilidades del plugin
  });
  
  var selectedCountryData = iti.getSelectedCountryData(); // Obtener los datos del país seleccionado
  var dialCode = selectedCountryData.dialCode; // Obtener el código de marcación telefónica
  $("#teleAlumno2").val($("#teleAlumno").val());
  
  // Función para restablecer los estilos y mensajes de error
  const reset = () => {
    input.classList.remove("error"); // Eliminar la clase de error del campo de entrada
    errorMsg.innerHTML = ""; // Borrar el contenido del mensaje de error
    errorMsg.classList.add("hide"); // Ocultar el mensaje de error
    validMsg.classList.add("hide"); // Ocultar el mensaje de validación
  };
  
  // Validar al perder el foco del campo de entrada
  input.addEventListener('blur', () => {
    reset(); // Restablecer los estilos y mensajes de error
    
    var selectedCountryData = iti.getSelectedCountryData(); // Obtener los datos del país seleccionado
    var dialCode = selectedCountryData.dialCode; // Obtener el código de marcación telefónica
    $("#teleAlumno2").val("+"+dialCode+" "+input.value);
    if (input.value.trim()) {
      if (iti.isValidNumber()) { // Verificar si el número de teléfono es válido
        validMsg.classList.remove("hide"); // Mostrar el mensaje de validación
        
        $('#agregarGuardar').attr('disabled', false);
        $('#agregarGuardar').removeClass('btn-danger disabled');
        $('#agregarGuardar').addClass('btn btn-success');
  
      } else {
        input.classList.add("error"); // Agregar la clase de error al campo de entrada
        const errorCode = iti.getValidationError(); // Obtener el código de error
        errorMsg.innerHTML = "X"; // Mostrar una marca de error
        errorMsg.classList.remove("hide"); // Mostrar el mensaje de error
                  $('#agregarGuardar').addClass('btn-danger disabled');
                  $('#agregarGuardar').attr('disabled', true);
      }
    }
  });
  
  // Restablecer al cambiar el contenido o seleccionar una bandera asd
  input.addEventListener('change', reset);
  input.addEventListener('keyup', reset);
  
  // Manejar el evento de cambio de país
  input.addEventListener("countrychange", function(e) {
    var selectedCountryData = iti.getSelectedCountryData(); // Obtener los datos del país seleccionado
    var countryCode = selectedCountryData.iso2; // Obtener el código de país (ISO 2 letras)
    var dialCode = selectedCountryData.dialCode; // Obtener el código de marcación telefónica
    console.log("Selected country code:", countryCode);
    console.log("Selected dial code:", dialCode); // Mostrar el código de marcación telefónica, +34, +1...
    $("#teleAlumno2").val("+"+dialCode+" "+$("#teleAlumno").val());
  });
  
  // Establecer el ancho del menú desplegable de la bandera al 100%
  
  $(".iti--allow-dropdown").css("width", "100%");
  
  
  
  
  
  
  $(document).ready(function() {
    // Obtener los elementos de entrada y los elementos h6
    const $teleAlumno = $('#teleAlumno');
    const $domValAlumno = $('#domValAlumno');
    const $domOrigenAlumno = $('#domOrigenAlumno');
    const $emailUsuario = $('#emailUsuario');
    const $nomUsuario = $('#nomUsuario');
  
    const $emailCard = $('#emailCard');
    const $teleCard = $('#teleCard');
    const $domValCard = $('#domValCard');
    const $domOrigenCard = $('#domOrigenCard');
    const $nomCard = $('#nomCard');
  
    // Agregar eventos de entrada a los campos de entrada
    $teleAlumno.on('input', actualizarValorCard);
    $domValAlumno.on('input', actualizarValorCard);
    $domOrigenAlumno.on('input', actualizarValorCard);
    $emailUsuario.on('input', actualizarValorCard);
    $nomUsuario.on('input', actualizarValorCard);
  
    // Actualizar los valores del card
    function actualizarValorCard() {
      $emailCard.text($emailUsuario.val());
      $teleCard.text($teleAlumno.val());
      $domValCard.text($domValAlumno.val());
      $domOrigenCard.text($domOrigenAlumno.val());
      $nomCard.text($nomUsuario.val());
    }
  });
  $("#bloquearEditar").on("change", function() {
    $.ajax({   
    url: '../../controller/usuario.php?op=cambiarBloqueado&id='+$("#idUsuarioPerfil").text(),
    type: 'GET',
    dataType: 'json',
    cache: false,
    serverSide: true,
    processData: true,
    success: function (data) {
    }, 
    complete: function (data) {
    },
    error: function (e) {
    console.log(e.responseText);
    }
    });
  });
  $.ajax({   
  url: '../../controller/usuario.php?op=recogerBloqueado&id='+$("#idUsuarioPerfil").text(),
  type: 'GET',
  dataType: 'json',
  cache: false,
  serverSide: true,
  processData: true,
  success: function (data) {
    console.log("🚀 ~ file: perfil.js:640 ~ data:", data)
    if(data == 1 && $("#sesion_usuario").val() == 3){
      $("input").attr('disabled','disabled');
      $("input, select").prop('disabled', true);
      $("#estudiadoSpanish").bootstrapSwitch('disabled', true);;
    }
  }, 
  complete: function (data) {
  },
  error: function (e) {
  console.log(e.responseText);
  }
  });
  
  
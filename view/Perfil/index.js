if ($("#disableAll").val() == 1) {
  $("input").prop("disabled", true);
}
function editarPass() {
  let password = $("#password_editar").val();
  $.post(
    "../../controller/usuario.php?op=cambiarContrasena",
    { pass: password },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
      toastr.success("Contraseña Cambiada");
    }
  );
}

/* $("#changePassword").on("click", function () {
  var idUsu = $("#idUsu").val();
  console.log(idUsu);
  $.post(
    "../../controller/usuario.php?op=obtenerTokenPorId",
    { idUsu: idUsu },
    function (data) {
      data = JSON.parse(data);
      let token = data[0][0];

      window.location.href = "../../view/CambiarPass?tokenidusu=" + token;
    }
  );
}); */


//esto solo se puede ejecuta si la session y la ID del usuario es la misma por seguridad (si le da problemas al admin crear excepcion para ese usuario)

/*  console.log(data);
        let idUsu = data[0][0];
        let correoUsu = data[0][2];
        let nombreUsu = data[0][13];
        let apellidosUsu = data[0][14];
        let fechaNacimientoUsu = data[0][15];
        let movilUsu = data[0][17];
        let codigoPostalUsu = data[0][21];
        let ciudadPuebloUsu = data[0][23];
     */
//una vez los datos ya estan cargados los cargamos en los input correspondientes
/* 
        $("#correoUsu").val(correoUsu);
        $("#nombreUsu").val(nombreUsu);
        $("#apellidosUsu").val(apellidosUsu);
        $("#fechaNacimientoUsu").val(fechaNacimientoUsu);
        $("#movilUsu").val(movilUsu);
        $("#codigoPostalUsu").val(codigoPostalUsu);
        $("#ciudadPuebloUsu").val(ciudadPuebloUsu); */

/* } else{
    window.location.href = "../Home/";
    //Crear log de registro y destruir sesiones para garantizar la seguridad
}
 */

/**********************/
/** CARGAR DATOS USU **/
/**********************/
/* $(document).ready(function() {
    // Capturamos el evento click en el elemento con id editarPerfil
    to
    $('a[href="#editarPerfil"]').on('click', function() {
        $.post(
            "../../controller/transportes.php?op=recogerConductor_x_token",
            { idViaje: idViaje },
            function (datosViaje) {
              datosViaje = JSON.parse(datosViaje);
              console.log(datosViaje);
          
              
              // ESTO TENDRIA QUE VENIR DE OTRO LDO
              $("#correoInputCliente").val(datosViaje[0]["correoCliente"]);
              $("#nombreInputCliente").val(datosViaje[0]["nombreCliente"]);
              $("#DNIinputCliente").val(datosViaje[0]["dniCliente"]);
        
            
              // Cargar la nueva firma
              var img = new Image();
              img.src = datosViaje[0]["FirmaViajeConductor"];
              img.onload = function () {
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(img, 0, 0, canvas.width, canvas.height);
              };
              
        
            }
        ); 
    });
}); */

/* FIRMA DIGITAL */
/*****************/


/*****************/
/*****************/
/*****************/


$('#guardarAvatarBtn').click(function () {
  var file = $('#profilePicture')[0].files[0];
  var maxSize = 2 * 1024 * 1024; // Tamaño máximo de archivo en bytes (2 MB)

  if (file && file.size <= maxSize) {

   


      var formData = new FormData();
      formData.append('idUsuario', $('#idUsuToken').val());
      formData.append('avatar', file); 

      $.ajax({
        url: '../../controller/perfil.php?op=editarAvatar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Mostrar SweetAlert con un botón de OK
          toastr["success"]('Avatar cambiado. Se recargará la página.');
          setTimeout(function() {
            location.reload();
          }, 3000); // 3000 milisegundos = 3 segundos
          
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      }); 
  
  } else {
    toastr["error"]('Por favor, seleccione una imagen menor o igual a 2 MB.');
  }
});

$("#profilePicture").on("change", function (event) {
  // Comprobar si realmente se ha seleccionado un archivo
  if (this.files && this.files[0]) {
    var file = this.files[0];
    // Aquí puedes realizar la lógica que necesites
    // Por ejemplo, mostrar una vista previa de la imagen
    var reader = new FileReader();
    reader.onload = function (e) {
      // Mostrar la imagen seleccionada en algún lugar del HTML
      $("#profilePreview").attr("src", e.target.result);
    };
    reader.readAsDataURL(file);
  }
});




$("#changePassword").click(function() {
    toastr.success("Revisa tu correo electrónico")
    var correoUsu = $("#correoUsu").val();
    console.log("🚀 ~ $ ~ correoUsu:", correoUsu)
    
    window.location.href = "../../view/RecuperarPass?correoUsu="+correoUsu;
    
});
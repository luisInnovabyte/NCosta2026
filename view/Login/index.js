///////////////////////////////////////
///////////////// LOGIN //////////////
/////////////////////////////////////
//MODO OSCURO / CLARO 

$('#toggle-bs-theme').on('click', function() {
    var htmlElement = $('html');
    var themeIcon = $('#theme-icon');

    // Verifica el tema actual
    if (htmlElement.attr('data-bs-theme') === 'dark') {
        // Cambia a modo claro
        htmlElement.attr('data-bs-theme', 'light');
        themeIcon.text('dark_mode');
        localStorage.setItem('theme', 'light'); // Guarda la preferencia
    } else {
        // Cambia a modo oscuro
        htmlElement.attr('data-bs-theme', 'dark');
        themeIcon.text('light_mode');
        localStorage.setItem('theme', 'dark'); // Guarda la preferencia
    }
});
// FUNCION OJO

$(document).ready(function () {
    $("#show_hide_password a").on('click', function (event) {
      event.preventDefault();
      if ($('#show_hide_password input').attr("type") == "text") {
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password i').addClass("bi-eye-slash-fill");
        $('#show_hide_password i').removeClass("bi-eye-fill");
      } else if ($('#show_hide_password input').attr("type") == "password") {
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password i').removeClass("bi-eye-slash-fill");
        $('#show_hide_password i').addClass("bi-eye-fill");
      }
    });
  });

  // CAMBIAR LOGINS ROLES //
////
$('#changeLoginAlumno').click(function () {
    event.preventDefault()
    $('#login_form').addClass('d-none'); // Muestra o esconde el mensaje
    $('#login_form_alumno').removeClass('d-none'); // Muestra o esconde el mensaje
});
$('#changeLoginProfesor').click(function () {
    event.preventDefault()
    $('#login_form').removeClass('d-none'); // Muestra o esconde el mensaje
    $('#login_form_alumno').addClass('d-none'); // Muestra o esconde el mensaje
});
$("#login_form").submit(function (event) {
    event.preventDefault(); // evita que el formulario se envíe automáticamente
    
    usu_correo = $('#usu_correo').val().trim();
    usu_pass = $('#usu_pass').val().trim();
    console.log('1');
    if(usu_correo.length > 120){
        toastr["warning"]("Revise el correo añadido, si continua podría ser bloqueado.", "Máximos caracteres permitidos");
        return; // Esta línea detendrá la ejecución aquí
    }


    if(validarCamposVacios()){
        toastr["warning"]("Inserte un formato de correo valido.", "Correo invalido");
        return; // Esta línea detendrá la ejecución aquí
    }


    $.post("../../controller/usuario.php?op=comprobarCorreo",{usu_correo:usu_correo},function (data) {
        if(data == 1){ // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
            console.log('4');

            if(usu_correo == '' || usu_pass == ''){
                console.log('5');

                toastr["warning"]("Complete los campos", "Campos Vacíos");
            }else{
                $.post("../../controller/usuario.php?op=login",{usu_correo:usu_correo,usu_pass:usu_pass},function (data) {
                    console.log('5');
                    console.log(data)
                    if(data.trim() == '1'){


                        window.location.href = "../Home/";      



                    }else if(data.trim() == '0'){
                        Swal.fire(
                            'Usuario Deshabilitado',
                            '',
                            'error'
                        )
                    }else if(data.trim() == '2'){
        
                        toastr["error"]('Credenciales inválidas. Inténtalo de nuevo.');
        
                    }else{
                        Swal.fire(
                            'Cuenta Suspendida',
                            data,
                            'error'
                        )
                    }
                });
            }

        }else{
            console.log('6');

            toastr["error"]('Correo no registrado'); // Existe correo - Error personalizado
            return; // Esta línea detendrá la ejecución aquí

        }
    });
    
});

// LOGIN ALUMNO

$(document).ready(function () {

    $("#login_form_alumno").on("submit", function (e) {
        e.preventDefault();
        // Obtener el valor del campo de texto
        const nickname = $("#usu_nickname").val().trim();
        usu_pass = $('#usu_passAlu').val().trim();
        // Expresión regular: nombre seguido de 3 números
        const regex = /^[A-Za-z]+\d{3}$/;

        if(nickname.length > 120){
            toastr["warning"]("Revise el correo añadido, si continua podría ser bloqueado.", "Máximos caracteres permitidos");
            return; // Esta línea detendrá la ejecución aquí
        }
        
 
        // Validar el nickname
        if (regex.test(nickname)) {


            $.post("../../controller/usuario.php?op=comprobarNickname",{nickname:nickname},function (data) {
                if(data == 1){ // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
        
                    if(nickname == '' || usu_pass == ''){
        
                        toastr["warning"]("Complete los campos", "Campos Vacíos");
                    }else{
                        $.post("../../controller/usuario.php?op=loginAlum",{nickname:nickname,usu_pass:usu_pass},function (data) {
                            console.log(data)
                            if(data.trim() == '1'){
        
        
                                window.location.href = "../Home/";     
        
                            }else if(data.trim() == '0'){
                                Swal.fire(
                                    'Usuario Deshabilitado',
                                    '',
                                    'error'
                                )
                            }else if(data.trim() == '2'){
                
                                toastr["error"]('Credenciales inválidas. Inténtalo de nuevo.');
                
                            }else{
                                Swal.fire(
                                    'Cuenta Suspendida',
                                    data,
                                    'error'
                                )
                            }
                        });
                    }
        
                }else{
                    console.log('6');
        
                    toastr["error"]('Usuario no registrado'); // Existe correo - Error personalizado
                    return; // Esta línea detendrá la ejecución aquí
        
                }
            });
        } else {
            toastr.error("El nickname debe contener un nombre seguido de 3 números (ej. Pablo124).");
        }
    });

});
/////////////////////////////////////
//////// FUNCION CODIGO VALIDAR ////
  // Escuchar el evento keyup en los inputs
  $('.digit-input').keyup(function() {
         
    // Limitar la entrada a un solo dígito
    if ($(this).val().length > 1) {
        $(this).val($(this).val().charAt(0));
    }

    // Mover el foco al siguiente input
    if ($(this).val().length === 1) {
        $(this).next('.digit-input').focus();
    }
});

// Escuchar el evento paste en los inputs
$('.digit-input').on('paste', function(e) {
    // Evitar el comportamiento predeterminado del pegado
    e.preventDefault();

    // Obtener el texto pegado del portapapeles
    var pastedText = (e.originalEvent || e).clipboardData.getData('text/plain');

    // Quitar cualquier carácter que no sea un número
    var digits = pastedText.replace(/[^0-9]/g, '').split('').slice(0, 5); // Limitar a 5 dígitos
    // Permitir solo números en los inputs y actualizar en tiempo real
    $('.digit-input').on('input', function(e) {
        // Quitar cualquier carácter que no sea un número
        var inputValue = $(this).val().replace(/[^0-9]/g, '');

        // Asignar el valor limpio de nuevo al input
        $(this).val(inputValue);
    });
    // Asignar cada dígito a un input
    $('.digit-input').each(function(index) {
        var inputValue = $(this).val().replace(/[^0-9]/g, '');

        if (digits[index]) {
            $(this).val(digits[index]);
        } else {
            $(this).val('');
        }
    });

    
    // Asignar el último carácter al input actual
    $(this).val(lastChar);
});

// Permitir solo números en los inputs y actualizar en tiempo real
$('.digit-input').on('input', function(e) {
    // Quitar cualquier carácter que no sea un número
    var inputValue = $(this).val().replace(/[^0-9]/g, '');

    
    // Tomar solo el último carácter del texto pegado
    var lastChar = pastedText.charAt(pastedText.length - 1);
    // Asignar el valor limpio de nuevo al input
    $(this).val(inputValue);
});

///////////////////////////////////////
////// CAMBIOS DE ESTADO LOGIN ///////
/////////////////////////////////////

function estadoCodigo(){ // OCULTA LOGIN MUESTRA VERIFICACION
    var code1 = $('#code1').val('');
    var code2 = $('#code2').val('');
    var code3 = $('#code3').val('');
    var code4 = $('#code4').val('');
    var code5 = $('#code5').val('');
    
     // Validar Correo
     correoRex = new validarCamposRegex($('#usu_correo'), /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/); 
     let resultadoCorreo = correoRex.validarRegex();

    if($('#usu_correo').val() == ''){
        toastr["error"]('Escriba un correo para la recuperación'); 
    }else{

        correoInput = $('#usu_correo').val();
        $('#correoText').text(correoInput)
        codigo = enviarCorreoValidacion(correoInput);

        $('#divLogin').addClass('d-none');
        $('#divValidar').removeClass('d-none');
        $('#divNewPass').addClass('d-none');
    }
    
}

function estadoNewPass(){
    $('#divLogin').addClass('d-none');
    $('#divValidar').addClass('d-none');
    $('#divNewPass').removeClass('d-none');
}

function estadoLogin(){ // MOSTRAR LOGIN
    $('#divLogin').removeClass('d-none');
    $('#divValidar').addClass('d-none');
    $('#divNewPass').addClass('d-none');

    var code1 = $('#code1').val('');
    var code2 = $('#code2').val('');
    var code3 = $('#code3').val('');
    var code4 = $('#code4').val('');
    var code5 = $('#code5').val('');
}
estadoLogin();



// ENVIAR CORREO VERIFICACION


function enviarCorreoValidacion(correo){

    var numeroAleatorio = generarNumeroAleatorio(); // Numero aleatorio que se enviara por correo.
    // MOSTRAR CODIGO console.log(numeroAleatorio);
    function generarNumeroAleatorio() {
        var min = 10000; // Número mínimo de 5 dígitos
        var max = 99999; // Número máximo de 5 dígitos
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    $.post("../../controller/usuario.php?op=correoValidarReg",{correo:correo,numeroAleatorio:numeroAleatorio},function (data) {
        if(data == 1){
            toastr["warning"]('Revise su buzón de correo', 'Correo Enviado');
        }else{
            toastr["error"](data);
        } 
    });

    return numeroAleatorio;
}


function confirmarCodigo(){
    
    let validado = comprobarCodigoVerificacion(codigo);
    if(validado == true){
        // CODIGO VALIDADO HACER AQUI LO QUE SEA
        estadoNewPass();
        correo = $('#usu_correo').val();
        $.post("../../controller/usuario.php?op=recuperarDatosXCorreo",{correo:correo},function (data) {
      
            var data = JSON.parse(data);
            var tokenUsu = data[0].tokenUsu;
            $('#identificador').val(tokenUsu);

        });
    }else{
        toastr["error"]('Código Erróneo');

        var code1 = $('#code1').val('');
        var code2 = $('#code2').val('');
        var code3 = $('#code3').val('');
        var code4 = $('#code4').val('');
        var code5 = $('#code5').val('');
    }
}

function comprobarCodigoVerificacion(codigo){
    
    // Recoger los valores de los campos por sus IDs
    var code1 = $('#code1').val();
    var code2 = $('#code2').val();
    var code3 = $('#code3').val();
    var code4 = $('#code4').val();
    var code5 = $('#code5').val();
    
    // Juntar los valores en una sola variable
    var codigoInput = code1 + code2 + code3 + code4 + code5; 
    if(codigoInput == codigo){
        toastr["success"]('Código Verificado');
        return true;
    }else{
        
        return false;
    }
   
}

function cambiarPass(){

     // Validar usu_pass
     let usu_passReg = new validarCamposRegex($('#new_pass'), /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\/\\])(.{8,})$/); 
     let resultadoPass = usu_passReg.validarRegex();
 
     if(resultadoPass == true){
        idUsu = $('#identificador').val();
        password = $('#new_pass').val();

        $.post("../../controller/usuario.php?op=cambiarPassword",{idUsu:idUsu,password:password},function (data) {

            toastr["success"]('Contraseña actualizada');

            estadoLogin();

        });
    
     }else{
         $('#textError').addClass('tx-danger');
         toastr["error"]('Para garantizar tu seguridad, es necesario que refuerces tu contraseña.', 'Contraseña Insegura');
         return false;
     } 
}


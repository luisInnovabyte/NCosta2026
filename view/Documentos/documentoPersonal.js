//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "personal_table" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "personal_Edu.php" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "insertar-personal-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-personal-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

//* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//

var isDark = isColorDark("#000000"); //? TRUE SI EL COLOR ES OSCURO FALSE SI ES CLARO

var colorLetra = "black";

//* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//

var personal_table = $("#"+idDatatables+"").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [

    { name: "idPersonal" , className: 'secundariaDef'},
    { name: "nombrePersonal", width: "8%" },
    { name: "direccionPersonal" },
    { name: "telefonoPersonal" },
    { name: "emailPersonal" },
    { name: "rol", className: "text-center" },
    { name: "estPersonal", className: "text-center" },
    { name: "accion", className: "text-center", width: "9%"  },
    { name: "contratos", className: "text-center" },
    { name: "documentos", className: "text-center" }
],
columnDefs: [

    //idPersonal
    { targets: [0], orderData: [0], visible: false },
    //nombrePersonal
    { targets: [1], orderData: [1], visible: true },
    //direccionPersonal
    { targets: [2], orderData: [1], visible: true },
    //telefonoPersonal
    { targets: [3], orderData: false, visible: true },
    //emailPersonal
    { targets: [4], orderData: false, visible: true },
    //estPersonal
    { targets: [5], orderData: [0], visible: true },
    //rol
    { targets: [6], orderData: [0], visible: true },
    //accion
    { targets: [7], orderData: false, visible: true , className: 'secundariaDef' },
    //contratos
    { targets: [8], orderData: false, visible: true , className: 'secundariaDef'},
    //documentos
    { targets: [9], orderData: false, visible: true , className: 'secundariaDef'}
],


orderFixed: [[0, "asc"]],
searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1,2,3,4,5,6,7]
},
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/"+phpPrincipal+"?op=listarPersonal",
    type: "get",
    dataType: "json",
    cache: false,
    serverSide: true,
    processData: true,
    beforeSend: function () {
      // $('.submitBtn').attr("disabled","disabled");
      //$('#usuario_data').css("opacity","");
    },
    complete: function (data) {},
    error: function (e) {},
  },
}); // del DATATABLE

//* ************* ********** *////* ************* ********** *////* ************* ********** *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* ************* ********** *////* ************* ********** *////* ************* ********** *//

$("#"+idDatatables+"")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros(idDatatables);
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

  $('#FootNombre').on('keyup', function () {
    personal_table
        .columns(1)
        .search(this.value)
        .draw();
});


$('#FootDirección').on('keyup', function () {
    personal_table
        .columns(2)
        .search(this.value)
        .draw();
});
$('#FootTelefono').on('keyup', function () {
    personal_table
        .columns(3)
        .search(this.value)
        .draw();
});
$('#FootEmail').on('keyup', function () {
    personal_table
        .columns(4)
        .search(this.value)
        .draw();
});

$("#"+idDatatables+"").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

function agregarElemento() {//! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  var formData = new FormData($("#insertar-personal-form")[0]);
  
  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE
    
    $.ajax({
      url: "../../controller/personal_Edu.php?op=insertarPersonal",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (data) {

          if(data == 1){
              $('#personal_table').DataTable().ajax.reload(null, false);

           
              toastr["success"]('Usuario creado correctamente');

              $('#insertar-personal-modal').modal('hide');

                  let emailUsuario = $('#usuPersonal').val();
                  let passUsuario = $('#senaPersonal').val();

                  
                  swal.fire({
                      title: 'Enviar credenciales',
                      text: "¿Desea enviar las credenciales por correo?",
                      icon: 'question',
                      showCancelButton: true,
                      confirmButtonText: 'Si',
                      cancelButtonText: 'No',
                      reverseButtons: true
                  }).then((result) => {
                      if (result.isConfirmed) {
                        
                          enviarCredenciales(emailUsuario,passUsuario);   
                       
                      }
                  });

                     // Vaciar los datos del FormData 
                  formData.forEach(function (value, key) {
                      formData.delete(key);
                  });
                  $("#insertar-personal-form")[0].reset();

              
          }else{

              swal.fire(
                  '¡Problemas!',
                  'Ya existe un usuario con ese correo',
                  'error'
              );

          }
      }
    }); // del success
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarElemento(idElemento) {//! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID
  $.ajax({
    url: "../../controller/personal_Edu.php?op=recogerEditar",
    type: "POST",
    data: { 'idPersonal': idElemento },
    dataType: "json",

    success: function (response) {
        $("#hiddenid").val(response[0])
        $("#nomPersonalE").val(response[1])
        $("#apePersonalE").val(response[2])
        $("#usuPersonalE").val(response[3])
        //$("#senaPersonalE").val(response[4])
        $("#dirPersonalE").val(response[5])
        $("#poblaPersonalE").val(response[6])
        $("#cpPersonalE").val(response[7])
        $("#provPersonalE").val(response[8])
        $("#paisPersonalE").val(response[9])
        $("#tlfPersonalE").val(response[10])
        $("#movilPersonalE").val(response[11])
        $("#emailPersonalE").val(response[12])
        $("input[name='rolE'][value='" + response[13] + "']").prop('checked', true);
        $("input[name='estUsuE'][value='" + response[14] + "']").prop('checked', true);


        $("#"+idModalEditar+"").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

    } // del success
  }); // del ajax
}

function editarElemento() { //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO
  let idElemento = $("#hiddenid").val(); //! NO TOCAR

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  var formData = new FormData($("#editar-personal-form")[0]);

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    
    $.ajax({
      url: "../../controller/personal_Edu.php?op=editarPersonal",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (data) {

          if(data == 1){
              $('#personal_table').DataTable().ajax.reload(null, false);

              swal.fire(
                  'Editado',
                  'El trabajador se ha editado',
                  'success'
              )
              $('#editar-personal-modal').modal('hide');
              
          }else{
              
              swal.fire(
                  '¡Problemas!',
                  'Ya existe un usuario con ese correo',
                  'error'
              );

          }

         
      }
    }); // del success
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//

function cambiarEstado(idElemento) { //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO

  $.post(
    "../../controller/"+phpPrincipal+"?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}

//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//

$("#"+idModalAgregar+"").on("show.bs.modal", function () {//TODO: MODIFICAR ID DEL MODAL DE AGREGAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarModalInputs(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
});


//* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *//
//* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *//
//* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *//
//* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *//
//* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *//

$("#enviarCorreo").click(function () {

  $.ajax({
    url: "../../controller/usuario.php?op=recogerUsuariosPersBD&correo=" + $("#usuPersonalE").val(),
    type: "GET",
    dataType: "text",
    error: function (error) {
      console.log(error);
    },
    success: function (res) {
      if (res == 1) {

        $.ajax({
          url: "../../controller/usuario.php?op=enviarCorreoPers&correo=" + $("#usuPersonalE").val(),
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
});


function enviarCredenciales(email, password){

  $.post("../../controller/personal_Edu.php?op=enviarCredenciales", { email: email,  password:password}, function (data) {
      console.log('AJAX ENVIAR GOOD');
      if (data == '1'){
          swal.fire(
              '¡Credenciales enviadas!',
              'Las credenciales se han enviado',
              'success'
          )
      }else{
          swal.fire(
              'Problemas al enviar',
              ''+data+'',
              'error'
          )
      }
     
  });

}


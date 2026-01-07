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
var personal_table = $("#"+idDatatables+"").DataTable({
  ordering: true,
  order: [[1, "asc"]], // Orden por nombre
  columns: [
      { name: "idPersonal", className: 'secundariaDef' },
      { name: "nombrePersonal", width: "8%" },
      { name: "direccionPersonal" },
      { name: "telefonoPersonal" },
      { name: "emailPersonal" },
      { name: "rol", className: "text-center" },
      { name: "estado", className: "text-center" },  // Asegúrate de incluir esta columna si falta
      { name: "accion", className: "text-center", width: "9%" },
      { name: "cursos", className: "text-center" },
      { name: "contratos", className: "text-center" },
      { name: "gestion", className: "text-center" }
  ],
  columnDefs: [
      { targets: [0], orderable: true, visible: false },
      { targets: [1], orderable: true, visible: true },
      { targets: [2], orderable: true, visible: true },
      { targets: [3], orderable: true, visible: true },
      { targets: [4], orderable: true, visible: true },
      { targets: [5], orderable: true, visible: true },
      { targets: [6], orderable: true, visible: true },  // Estado
      { targets: [7], orderable: false, visible: true }, // Acción
      { targets: [8], orderable: false, visible: true }, // Cursos
      { targets: [9], orderable: false, visible: true }, // Contratos
      { targets: [10], orderable: false, visible: true } // Gestión
  ],
  ajax: {
      url: "../../controller/"+phpPrincipal+"?op=listarPersonal",
      type: "GET",
      dataType: "json",
      cache: false,
      serverSide: true,
      processData: true,
      beforeSend: function () {},
      complete: function (data) {},
      error: function (e) { console.log("Error en la carga de datos:", e); }
  }
});


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

$(document).ready(function() {
  // Función para obtener parámetros de la URL
  function getParameterByName(name) {
      const url = new URL(window.location.href);
      return url.searchParams.get(name);
  }

  // Recuperar el valor del parámetro "buscar"
  const buscarTexto = getParameterByName('buscar') || '';


  try {
    const buscarTexto = getParameterByName('buscar') || '';
    if (buscarTexto) {
        console.log('Buscando:', buscarTexto);
        personal_table.search(buscarTexto).draw();
        $('.dataTables_filter input[type="search"]').val(buscarTexto);
    }
} catch (error) {
    console.error('Error aplicando el filtro:', error);
}

});

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

$('#insertar-personal-modal').on('show.bs.modal', function () {
  const form = $('#insertar-personal-form');

  // 1. Limpiar clases de validación
  form.find('input, select, textarea').removeClass('is-valid is-invalid');

  // 2. Resetear el formulario completo
  form[0].reset();

  // 3. Resetear el checkbox a checked (o a desmarcado si prefieres false)
  $('#estUsu').prop('checked', false);

  // 4. Limpiar el select múltiple
  $('#departamentosSelect').val(null).trigger('change'); // Requiere Select2

  // 5. Resetear el radio (opcional porque ya tiene un default en HTML)
  $('input[name="rolSelec"][value="2"]').prop('checked', true); // Profesor
});


function agregarElemento() {//! NO TOCAR
  var rolSeleccionado = $("input[name='rolSelec']:checked").val();
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  // Crear el FormData del formulario
  var formData = new FormData($("#insertar-personal-form")[0]);


  // Añadir el valor del rol al FormData
  formData.append("rolSelec", rolSeleccionado);

  // Recoger el valor de los departamentos seleccionados
  var departamentosSelect = $('#departamentosSelect').val();
  formData.append("departamentos", departamentosSelect);

  // Recoger si el checkbox está marcado (activo)
  var estUsu = $("#estUsu").is(":checked") ? "1" : "0"; // Si está marcado, "1", si no, "0"

  // Añadir el estado del checkbox al FormData
  formData.append("estUsu", estUsu);


  if(departamentosSelect == ''){
    toastr.error("Seleccione un departamento"); //? INFORMAR QUE HA DADO ERROR
    exit();
  }
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

                  
                  /* swal.fire({
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
                  }); */

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
    }); // del success */
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarElementoSend(idElemento) {//! NO TOCAR
        
        $.ajax({
          url: "../../controller/personal_Edu.php?op=recogerEditar",
          type: "POST",
          data: { 'idPersonal': idElemento },
          dataType: "json",

          success: function (response) {
            console.log(response)
              $("#idSelect").val(response[0])
              $("#correoEnviar").val(response[3])
              $("#correoRes").text(response[3])
              $("#gestion-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

          } // del success
        }); // del ajax
      
      
}
//========================//
// MAIN BOTON //
//========================//

$('#botonEnviarCorreoPersonal').click( function (){
  // Verifica si al menos un checkbox está marcado
  const anyChecked = $(".checki:checked").length > 0;

  idPersonal = $('#idSelect').val();
  correoSelect = $('#correoEnviar').val();
  
  // Validar si el campo está vacío o si no es un correo válido
  if (correoSelect == '' || !validarCorreo(correoSelect)) {
    toastr.error("Por favor, ingresa un correo válido.");
  }

  // Función para validar el formato del correo electrónico
  function validarCorreo(correo) {
    // Expresión regular para correos electrónicos
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(correo);
  }
  nuevoUsuCheck = $('#checkNuevoUsuario').is(':checked') ? 1 : 0;



  // VALIDACION CHECK
  if (anyChecked) {

    $.post(
      "../../controller/personal_Edu.php?op=enviarCorreoPersonal",
      {
        idPersonal: idPersonal,
        correoSelect: correoSelect,
        nuevoUsuCheck: nuevoUsuCheck
     
      },
      function (data) {
        console.log(data);
        descargando();
        toastr.success('Correo enviado');

      }
    );
    

  } else {

    toastr.error('Debe marcar al menos una opción.');

      
  }


  descargando();

});




function cargarElemento(idElemento) {//! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID


  $.ajax({
    url: '../../controller/mntPreinscripciones.php?op=recogerDepartamentosActivo',
    type: 'GET',
    dataType: 'json',
    error: function (error) {
        console.log(error);
    },
    success: function (res) {
        $("#departamentosSelectE").empty(); // Vacía el contenido existente del select
        $("#departamentosSelectE").val(''); // Vacía el contenido existente del select

        if (res.length > 0) {
            for (var i = 0; i < res.length; i++) {
                $("#departamentosSelectE").append("<option value='" + res[i].idDepartamentoEdu + "'>" + res[i].nombreDepartamento + "</option>");
            }
        }
 

        
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
              console.log(response[15]);
              $("input[name='rolE'][value='" + response[13] + "']").prop('checked', true);
              if (response[14] == 0) {
                $("input[name='estUsuE']").prop('checked', false); // Desmarca todos los elementos
              } else {
                  $("input[name='estUsuE'][value='" + response[14] + "']").prop('checked', true); // Marca el correspondiente
              }

                departamentoBD = response[15];
                // Convierte los valores a un array
                var departamentos = departamentoBD.split(',');
                // Asigna los valores al select
                $('#departamentosSelectE').val(departamentos);
                // Actualiza el select2 para reflejar los valores seleccionados
                $('#departamentosSelectE').trigger('change');
                    // Aquí puedes poner cualquier otra acción que desees realizar

              $("#"+idModalEditar+"").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

          } // del success
        }); // del ajax
        
      }
              
      });
}

function editarElemento() { //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO
  let idElemento = $("#hiddenid").val(); //! NO TOCAR

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  var formData = new FormData($("#editar-personal-form")[0]);
    // Recoger el valor de los departamentos seleccionados
    var departamentosSelectE = $('#departamentosSelectE').val();
    formData.append("departamentos", departamentosSelectE);
  if(departamentosSelectE == ''){
    toastr.error("Seleccione un departamento"); //? INFORMAR QUE HA DADO ERROR
    exit();
  }
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

/* $("#"+idModalAgregar+"").on("show.bs.modal", function () {//TODO: MODIFICAR ID DEL MODAL DE AGREGAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarModalInputs(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
}); */


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


$(".js-example-placeholder-multiple").select2({
  theme: "bootstrap-5", // Tema de Bootstrap 5
  allowClear: true, // Permite limpiar la selección
  placeholder: 'Seleccione departamentos',
  language: {
    
      noResults: function () {
          return 'No se encontraron resultados';
      },
      searching: function () {
          return 'Buscando...';
      }
  },

});


$.ajax({
  url: '../../controller/mntPreinscripciones.php?op=recogerDepartamentosActivo',
  type: 'GET',
  dataType: 'json',
  error: function (error) {
      console.log(error);
  },
  success: function (res) {

      if (res.length > 0) {
          for (var i = 0; i < res.length; i++) {
              $("#departamentosSelect").append("<option value='" + res[i].idDepartamentoEdu + "'>" + res[i].nombreDepartamento + "</option>");
          }
      }

      $.ajax({
          url: "../../controller/actividades_edu.php?op=cargarDatosEditar",
          type: "POST",
          data: { 'idAct': idAct },
          dataType: "json",

          success: function (response) {
              console.log(response);
              $("#idAct").val(response[0]['idAct']);
              $("#descrAct").val(response[0]['descrAct']);
              $("#fecActFinSolicitud").val(response[0]['fecActFinSolicitud']);
              $("#fecActDesde").val(response[0]['fecActDesde']);
              $("#fecActHasta").val(response[0]['fecActHasta']);
              var horaInicio = moment(response[0]['horaInicioAct'], "HH:mm:ss").format("HH:mm");
          
              $("#horaInicioAct").val(horaInicio);
              var horaFin = moment(response[0]['horaFinAct'], "HH:mm:ss").format("HH:mm");
              $("#horaFinAct").val(horaFin);
              $("#horasLectivasAct").val(response[0]['horasLectivasAct']);
              $("#minAlumTipo").val(response[0]['minAlumAct']);
              $("#maxAlumTipo").val(response[0]['maxAlumAct']);
              $("#puntoEncuentroAct").val(response[0]['puntoEncuentroAct']);
              // Asignar el valor al select con Select2
              $("#idPersonal_guiaAct").val(response[0]['idPersonal_guiaAct']).trigger('change');

              $("#obsAct").summernote('code', response[0]['obsAct']);
              $("#imgAct").val(response[0]['imgAct']);
              // DROPZONE
              $("#my-great-dropzone").addClass('d-none');
              $("#imgCabecera").removeClass('d-none').attr('src', `../../public/img/actividades/${response[0]['imgAct']}`);
              // MOSTRAR BOTONES ACTIVAR O DESACTIVAR
              if (response[0]['estadoAct'] == 1) {
                  $("#desactivarActividad").removeClass('d-none');
              }
              else if (response[0]['estadoAct'] == 0) {
                  $("#activarActividad").removeClass('d-none');
              }
            
                  departamentoBD = response[0]['idsDepartamentos'];
                  // Convierte los valores a un array
                  var departamentos = departamentoBD.split(',');
                  // Asigna los valores al select
                  $('#departamentosSelect').val(departamentos);
                  // Actualiza el select2 para reflejar los valores seleccionados
                  $('#departamentosSelect').trigger('change');
                      // Aquí puedes poner cualquier otra acción que desees realizar
          

          
          } // del success
      });// del ajax */

      }


          
      
});
$("#selectIdiomaModal").select2({
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $(this).data('placeholder'),
  closeOnSelect: true,
  language: {
      inputTooShort: function (args) {
          var remainingChars = args.minimum - args.input.length;
          return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
      },
      maximumSelected: function (e) {
          return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
      },
      noResults: function () {
          return 'No se encontraron resultados';
      },
      searching: function () {
          return 'Buscando...';
      }
  }
});
$("#nivelDesde").select2({
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $(this).data('placeholder'),
  closeOnSelect: true,
  language: {
      inputTooShort: function (args) {
          var remainingChars = args.minimum - args.input.length;
          return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
      },
      maximumSelected: function (e) {
          return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
      },
      noResults: function () {
          return 'No se encontraron niveles';
      },
      searching: function () {
          return 'Buscando...';
      }
  }
});
$("#nivelHasta").select2({
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $(this).data('placeholder'),
  closeOnSelect: true,
  language: {
      inputTooShort: function (args) {
          var remainingChars = args.minimum - args.input.length;
          return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
      },
      maximumSelected: function (e) {
          return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
      },
      noResults: function () {
          return 'No se encontraron niveles superiores';
      },
      searching: function () {
          return 'Buscando...';
      }
  }
});
$("#nivelDesde").prop("disabled", true);

$("#nivelHasta").prop("disabled", true);

$("#selectCursoModal").select2({
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $(this).data('placeholder'),
  closeOnSelect: true,
  language: {
      inputTooShort: function (args) {
          var remainingChars = args.minimum - args.input.length;
          return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
      },
      maximumSelected: function (e) {
          return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
      },
      noResults: function () {
          return 'No se encontraron cursos';
      },
      searching: function () {
          return 'Buscando...';
      }
  }
});
//=========//
//  CURSOS //
//=========//

var personalruta_table; // Variable global para el DataTable

function cargarModalCursos(idElemento) {
    console.log("Filtrando por ID:", idElemento);
    $('#idPersonal').val(idElemento);
    // Si el DataTable ya está inicializado, solo actualizamos la URL y recargamos los datos
    if ($.fn.DataTable.isDataTable('#personalruta_table')) {
        personalruta_table.ajax.url("../../controller/" + phpPrincipal + "?op=cargarRutasPersonal&idPersonal=" + idElemento).load();
    } else {
        // Si no está inicializado, lo creamos por primera vez
        personalruta_table = $("#personalruta_table").DataTable({
            buttons:[],
            select: false,
            columns: [
                { name: "idPersonal", className: "secundariaDef" },
                { name: "nombrePersonal", width: "8%" },
                { name: "idiomaCurso" },
                { name: "tipoCurso" },
                { name: "nivelDesde", className: "text-center" },
                { name: "nivelHasta", className: "text-center" },

                { name: "gestion", className: "text-center" }
            ],
            columnDefs: [
                { targets: [0], orderData: [0], visible: false },
                { targets: [1], orderData: [1], visible: true },
                { targets: [2], orderData: [1], visible: true },
                { targets: [3], orderData: [1], visible: true },
                { targets: [4], orderData: [1], visible: true },
                { targets: [5], orderData: false, visible: true, className: "secundariaDef" },
                { targets: [6], orderData: false, visible: true, className: "secundariaDef" }
            ],
            orderFixed: [[0, "asc"]],
            searchBuilder: {
                columns: [1, 2, 3, 4,5,6]
            },
            ajax: {
                url: "../../controller/" + phpPrincipal + "?op=cargarRutasPersonal&idPersonal=" + idElemento,
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
                beforeSend: function () {
                    console.log("Cargando datos para DataTable...");
                },
                error: function (xhr, status, error) {
                    console.error("Error en DataTables:");
                    console.error("Estado:", status);
                    console.error("Error:", error);
                    console.error("Respuesta del servidor:", xhr.responseText);
                    
                    alert("Error al cargar la tabla: " + error);

                    // Mostrar mensaje de error en la tabla
                    $("#personalruta_table tbody").html(
                        '<tr><td colspan="5" class="text-center text-danger">Error al cargar los datos.</td></tr>'
                    );
                }
            }
        });
    }
    $("#personalruta_table").addClass("width-100"); // Hace la tabla responsive

    // Mostrar el modal
    $("#selectIdiomaModal").val(null).trigger('change');
  $("#selectCursoModal").val(null).trigger('change');
  $("#nivelDesde").val(null).trigger('change');
  $("#nivelHasta").val(null).trigger('change');
    $("#cursos-modal").modal("show");
}

$("#selectIdiomaModal").val(null).trigger('change');
$("#selectCursoModal").val(null).trigger('change');
$("#nivelDesde").val(null).trigger('change');
$("#nivelHasta").val(null).trigger('change');

function insertarCurso(){//! NO TOCAR
  const selectIdiomaO = $('#selectIdiomaModal');
  if (selectIdiomaO.val() === null || selectIdiomaO.val() === '') {
      toastr.error('Por favor, seleccione un idioma.', 'Error de Validación');
      return; // Salir de la función si no se ha seleccionado un idioma
  }

  const selectCursoO = $('#selectCursoModal');
  if (selectCursoO.val() === null || selectCursoO.val() === '') {
      toastr.error('Por favor, seleccione un curso.', 'Error de Validación');
      return; // Salir de la función si no se ha seleccionado un idioma
  }

  const nivelDesde = $('#nivelDesde');
  const nivelHasta = $('#nivelHasta');

  nivelDesdeSelect = nivelDesde.val();
  nivelHastaSelect = nivelHasta.val();
  if (nivelDesdeSelect === null || nivelDesdeSelect === '') {
      toastr.error('Por favor, seleccione un nivel Desde.', 'Error de Validación');
      return; // Salir de la función si no se ha seleccionado un idioma
  }
  if (nivelHastaSelect === null || nivelHastaSelect === '') {
    toastr.error('Por favor, seleccione un nivel Hasta.', 'Error de Validación');
    return; // Salir de la función si no se ha seleccionado un idioma
}

  idProfesorado = $('#idPersonal').val();
  let selectIdiomaModal = $('#selectIdiomaModal').val();
  let selectCursoModal = $('#selectCursoModal').val();
console.log(nivelHastaSelect);
  $.ajax({
      url: "../../controller/personal_Edu.php?op=insertarPersonalCurso",
      type: "POST",
        data: {
          idProfesorado: idProfesorado,
          selectCurso: selectCursoModal,  // Aquí iba mal
          selectIdioma: selectIdiomaModal, // Aquí iba mal
          nivelDesdeSelect: nivelDesdeSelect, // Aquí iba mal
          nivelHastaSelect: nivelHastaSelect // Aquí iba mal
      },
      
      success: function (data) {
        console.log(data)
          if (data == 1) {
              $('#personalruta_table').DataTable().ajax.reload(null, false);
          } else {
              toastr.error(data);
          }
      },
      error: function (xhr, status, error) {
          console.error("Error en la petición AJAX:", status, error);
      }
  });

 
}


function eliminarRuta(idRutaPersonal){

  $.post("../../controller/personal_Edu.php?op=eliminarRuta", { idRutaPersonal: idRutaPersonal}, function (data) {
      if (data == '1'){
         toastr.success('Ruta eliminada');
         $('#personalruta_table').DataTable().ajax.reload(null, false);

      }else{
          swal.fire(
              'Problemas al enviar',
              ''+data+'',
              'error'
          )
      }
     
  });

}

$("#selectIdiomaModal").on("change", function () { 

   $("#selectCursoModal").val(null).trigger('change');
  $("#nivelDesde").val(null).trigger('change');
  $("#nivelHasta").val(null).trigger('change');

});
$("#selectCursoModal").on("change", function () { 

 
  $("#nivelDesde").val(null).trigger('change');
  $("#nivelHasta").val(null).trigger('change');

});

// DESDE HASTA
$("#selectCursoModal").on("change", function () {
  
  let nivelCurso = $(this).val(); // Obtener el valor seleccionado
  const selectIdiomaO = $('#selectIdiomaModal');
  if (selectIdiomaO.val() === null || selectIdiomaO.val() === '') {
      return; // Salir de la función si no se ha seleccionado un idioma
  }

  const selectCursoO = $('#selectCursoModal');
  if (selectCursoO.val() === null || selectCursoO.val() === '') {
      return; // Salir de la función si no se ha seleccionado un idioma
  }
  let selectIdiomaModal = $('#selectIdiomaModal').val();
  let selectCursoModal = $('#selectCursoModal').val();

  if (nivelCurso) {
      $("#nivelDesde").prop("disabled", false); // Habilitar el select2

      // Realizar la petición AJAX
      $.ajax({
          url: "../../controller/personal_Edu.php?op=cargarDesdeNivel", // Cambia esto por la ruta real
          type: "POST",
          data: { selectIdiomaModal: selectIdiomaModal, selectCursoModal: selectCursoModal },
          dataType: "json",
          success: function (res) {
            console.log(res);
              $("#nivelDesde").empty().append('<option value="">Seleccione un nivel</option>');

              // Agregar opciones al select2
              if (res.length > 0) {
                for (var i = 0; i < res.length; i++) {
                  console.log(res[i].nivelId_ruta);
                    $("#nivelDesde").append("<option value='" + res[i].nivelId_ruta + "'>" + res[i].codNivel + " " + res[i].descrNivel + "</option>");
                }
            }

               // Usar un pequeño retraso para asegurarse de que el DOM se haya actualizado
    setTimeout(function() {
      $("#nivelDesde").trigger("change"); // Refrescar el select2
  }, 100);
          },
          error: function (xhr, status, error) {
              console.error("Error en AJAX:", error);
          }
      }); 
  } else {
      $("#nivelDesde").prop("disabled", true).empty().append('<option value="">Seleccione un nivel</option>');
  }
});

// DESDE HASTA
$("#nivelDesde").on("change.select2", function () { // Usamos 'change.select2' para manejar select2 específicamente
    let nivelDesde = $('#nivelDesde').val(); // Obtener el valor seleccionado
   console.log(nivelDesde);

    const selectIdiomaO = $('#selectIdiomaModal');
    if (selectIdiomaO.val() === null || selectIdiomaO.val() === '') {
        return; // Salir si no se ha seleccionado un idioma
    }

    const selectCursoO = $('#selectCursoModal');
    if (selectCursoO.val() === null || selectCursoO.val() === '') {
        toastr.error('Por favor, seleccione un curso.', 'Error de Validación');
        return; // Salir si no se ha seleccionado un curso
    }

    let selectIdiomaModal = $('#selectIdiomaModal').val();
    let selectCursoModal = $('#selectCursoModal').val();

    if (nivelDesde) {
        $("#nivelHasta").prop("disabled", false); // Habilitar el select2 de "nivelHasta"

        // Realizar la petición AJAX
        $.ajax({
            url: "../../controller/personal_Edu.php?op=cargarHastaNivel", // Ruta real del archivo PHP
            type: "POST",
            data: { nivelDesde: nivelDesde, selectIdiomaModal: selectIdiomaModal, selectCursoModal: selectCursoModal },
            dataType: "json",
            success: function (res) {
                console.log(res);
                $("#nivelHasta").empty().append('<option value="">Seleccione un nivel</option>');

                // Agregar las opciones al select2 de "nivelHasta"
                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {
                        $("#nivelHasta").append("<option value='" + res[i].nivelId_ruta + "'>" + res[i].codNivel + " " + res[i].descrNivel + "</option>");
                    }
                }

                // Refrescar el select2 de "nivelHasta"
                $("#nivelHasta").trigger("change"); 
            },
            error: function (xhr, status, error) {
                console.error("Error en AJAX:", error);
            }
        }); 
    } else {
        $("#nivelHasta").prop("disabled", true).empty().append('<option value="">Seleccione un nivel</option>');
    }
});

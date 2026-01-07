//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//
var idDatatables = "alumnos_table" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "alumnos_Edu.php" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
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

var alumnos_table = $("#"+idDatatables+"").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [

      { name: "idPersonal", className: 'secundariaDef' }, // Corresponde a "ID"
      { name: "nickname", width: "8%" },                  // Corresponde a "Nickname"
      { name: "nombrePersonal" },                         // Corresponde a "Nombre"
      { name: "direccionPersonal" },                      // Corresponde a "Dirección"
      { name: "telefonoPersonal" },                       // Corresponde a "Teléfono"
      { name: "emailPersonal" },      
      { name: "departamentos", className: "text-center" },          // Corresponde a "Rol"
      // Corresponde a "Email"
      { name: "rol", className: "text-center" },          // Corresponde a "Rol"
      { name: "estado", className: "text-center" },       // Corresponde a "Estado"
      { name: "accion", className: "text-center", width: "9%" }, // Corresponde a "Acción"
      { name: "interesado", className: "text-center" },   // Corresponde a "Interesado"
      { name: "perfil", className: "text-center" }        // Corresponde a "Perfil"

],
columnDefs: [
  // ID (no visible, pero ordenable)
  { targets: [0], orderable: true, visible: false },
  // Nickname
  { targets: [1], orderable: true, visible: true },
  // Nombre
  { targets: [2], orderable: true, visible: true },
  // Dirección
  { targets: [3], orderable: true, visible: true },
  // Teléfono
  { targets: [4], orderable: true, visible: true },
  // Email
  { targets: [5], orderable: true, visible: true },
  // Rol
  { targets: [6], orderable: true, visible: true },
  // Estado
  { targets: [7], orderable: true, visible: true },
  // Acción (sin ordenación)
  { targets: [8], orderable: false, visible: true, className: 'secundariaDef' },
  // Interesado
  { targets: [9], orderable: true, visible: true, className: 'secundariaDef' },
  // Perfil
  { targets: [10], orderable: true, visible: true, className: 'secundariaDef' },
    // Perfil
    { targets: [10], orderable: true, visible: true, className: 'secundariaDef' }
],



searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1,2,3,4,5,6,7,8,9,10,11]
},
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/"+phpPrincipal+"?op=listarAlumnos",
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


//========================//
// MAIN BOTON //
//========================//

function cargarElementoSend(idElemento) {//! NO TOCAR

        
  $.ajax({
    url: "../../controller/alumnos_Edu.php?op=recogerEditar",
    type: "POST",
    data: { 'idAlumno': idElemento },
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
$('#botonEnviarCorreoPersonal').click( function (){
  // Verifica si al menos un checkbox está marcado
  const anyChecked = $(".checki:checked").length > 0;

  idAlumno = $('#idSelect').val();
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
console.log(idAlumno)
    $.post(
      "../../controller/alumnos_Edu.php?op=enviarCorreoAlumno",
      {
        idAlumno: idAlumno,
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

function cambiarEstado(idElemento) { //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  console.log(idElemento);
  $.post(
    "../../controller/alumnos_Edu.php?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}


      

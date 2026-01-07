//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "contrato_table" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "contrato.php" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "insertar-contrato-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-contrato-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

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

    { name: "idContrato" },
    { name: "tipo" },
    { name: "fecha" },
    { name: "estado" },
    { name: "textTipoContrato" },
    { name: "categoriaContrato" },
    { name: "jornadaContrato" },
    { name: "duracionContrato" },
    { name: "accion", "className": "text-center" }
],
columnDefs: [

    //idContrato
    { targets: [0], orderData: [0], visible: false },
    //tipo
    { targets: [1], orderData: [1], visible: true },
    
    //fecha
    { targets: [2], orderData: false, visible: true },
    //accion
    { targets: [3], orderData: false, visible: true },

    { targets: [4], orderData: false, visible: true },
    { targets: [5], orderData: false, visible: true },
    { targets: [6], orderData: false, visible: true },

    { targets: [7], orderData: false, visible: true },
    { targets: [8], orderData: false, visible: true }
],


orderFixed: [[0, "asc"]],
searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1,2,3,4,5,6,7,8,9]
},
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/"+phpPrincipal+"?op=listarContrato&idPersonal="+$("#idPersonal").val(),
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

$("#"+idDatatables+"").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

function agregarElemento() {//! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  var formData = new FormData($("#insertar-contrato-form")[0]);

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE
    console.log('aaa');
    $.ajax({
        url: "../../controller/contrato.php?op=insertarContrato",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function () {

            $('#contrato_table').DataTable().ajax.reload(null, false);

            // Vaciar los datos del FormData 
            formData.forEach(function (value, key) {
                formData.delete(key);
            });
            $("#insertar-contrato-form")[0].reset();

            swal.fire(
                'Añadido',
                'Contrato añadido correctamente',
                'success'
            )
            $('#insertar-contrato-modal').modal('hide');
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
  $.post("../../controller/"+phpPrincipal+"?op=recogerDatosContrato",{idElemento:idElemento},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
    data = JSON.parse(data);
    console.log(data);
    $("#idContratoE").val(data[0]["idPersoContrato"]);
    $("#tipoPersonalE").val(data[0]["idTipoContrato"]);
    $("#fecInicioPersoContratoE").next().val(data[0]["fecInicioPersoContrato"]);
    $("#fecFinalPersoContratoE").next().val(data[0]["fecFinalPersoContrato"]);
    $("#fecInicioPersoContratoE").val(data[0]["fecInicioPersoContrato"]);
    $("#fecFinalPersoContratoE").val(data[0]["fecFinalPersoContrato"]);
    $("#textTipoContratoE").val(data[0]["textPersoContrato"]);

    $("#textCategoriaE").val(data[0]["categoriaContrato"]);
    $("#textJornadaE").val(data[0]["jornadaContrato"]);
    $("#textDuracionE").val(data[0]["duracionContrato"]);
    console.log("editar")

    $("#editar-contrato-modal").modal("show");


})
}

function editarElemento() { //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO
  let idElemento = $("#hiddenid").val(); //! NO TOCAR

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  var formData = new FormData($("#editar-contrato-form")[0]);
  console.log($("#tipoPersonalE").val());

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    
    $.ajax({
      url: "../../controller/contrato.php?op=editarContrato",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function () {

          $('#contrato_table').DataTable().ajax.reload(null, false);

          swal.fire(
              'Editado',
              'El contrato se ha editado',
              'success'
          )
          $('#editar-contrato-modal').modal('hide');
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
  $("#idContrato").val($("#idPersonal").val());

});


//* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *//
//* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *//
//* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *//
//* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *////* JS ADICIONAL *//
//* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *////* ** ********* *//



$.ajax({
  url: '../../controller/tiposContrato_Edu.php?op=recogerTiposContrato',
  type: 'GET',
  dataType: 'json',
  error: function (error) {
      console.log(error);
  },
  success: function (res) {
      if (res.length > 0) {
          for (var i = 0; i < res.length; i++) {
              $("#tipoPersonalE").append("<option value='" + res[i].idTipoContrato + "'>" + res[i].descrTipoContrato + "</option>");
              $("#tipoPersonal").append("<option value='" + res[i].idTipoContrato + "'>" + res[i].descrTipoContrato + "</option>");
          }
      }
  }
  // ,
  // complete: function (res) {
  //     var idUsuarioPre = $("#idPersonal_guiaAct").val();
  //     $("#idPersonal_guiaAct").val(idUsuarioPre);
  // }
});
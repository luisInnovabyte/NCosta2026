//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//
$(document).ready(function () {

  // Si quieres que el botón sea "clickeado" automáticamente desde el código:
  $('#btnGestion').click();
});
var idDatatables = "prescriptor_table" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "prescriptor.php" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "agregar-clientes-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-clientes-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

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


var prescriptor_table =  $("#"+idDatatables+"").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [
    { name: "idCliente" },
    { name: "nickname", className: "text-center"},
    { name: "nombreCliente", className: "text-center"},
    { name: "IDENTIFICADOR", className: "text-center"},
    { name: "CORREO", className: "text-center"},
    { name: "CONTACTO", className: "text-center"},
    { name: "NACIMIENTO", className: "text-center"}


  ],
  columnDefs: [
    {
      targets: [0],
      orderData: true,
      visible: false,
      className: "",
    },
    {
      targets: [6], // La columna de Nacimiento (por ejemplo, columna 6)
      type: 'date',  // Especificamos que la columna es de tipo fecha
      orderData: true,
      visible: true,
      className: "",
    }
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1,2,3,4,5,6],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/"+phpPrincipal+"?op=mostrarElementos",
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
$('#FootNick').on('keyup', function () {
  prescriptor_table
      .columns(1)
      .search(this.value)
      .draw();
});
$('#FootNombre').on('keyup', function () {
  prescriptor_table
      .columns(2)
      .search(this.value)
      .draw();
});
$('#FootIdent').on('keyup', function () {
  prescriptor_table
      .columns(3)
      .search(this.value)
      .draw();
});
$('#FootCorreo').on('keyup', function () {
  prescriptor_table
      .columns(4)
      .search(this.value)
      .draw();
});
$('#FootContacto').on('keyup', function () {
  prescriptor_table
      .columns(5)
      .search(this.value)
      .draw();
});
$('#FootFecha').on('keyup', function () {
  prescriptor_table
      .columns(6)
      .search(this.value)
      .draw();
});
//* ************* ********** *////* ************* ********** *////* ************* ********** *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* ************* ********** *////* ************* ********** *////* ************* ********** *//

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
        prescriptor_table.search(buscarTexto).draw();
        $('.dataTables_filter input[type="search"]').val(buscarTexto);
    }
} catch (error) {
    console.error('Error aplicando el filtro:', error);
}

});

$("#"+idDatatables+"")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros(idDatatables);
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });
  $('#prescriptor_table tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
    // Obtén la instancia de la tabla DataTables
    var tabla = $('#prescriptor_table').DataTable();
  
    // Obtén el objeto de datos de la fila actual
    var data = tabla.row(this).data();
  
    var idPrescriptor = data[0];
    var nombreSelec = data[1];
    $("#idSelect").val(idPrescriptor);
    $("#idTextSelect").text(idPrescriptor);
    

    $("#nameSelect").text(nombreSelec);
    $("#prescriptorID").val(idPrescriptor);
    $("#seleccionar-cliente-modal").modal("hide");
    $("#aceptClient").parent().addClass("d-none");
    $("#updateClient").parent().removeClass("d-none");
    $("#btnPreforma").parent().removeClass("d-none");
    $("#btnGestion").parent().removeClass("d-none");

    $("#cancelClient").parent().removeClass("d-none");
    $("#listClient").parent().addClass("d-none");
    $("#mostrarPreforma").removeClass("d-none");
    $("#newClient").parent().removeClass("d-none");
    $("#cardForm").removeClass("d-none");
    $("#cardForm").removeClass("d-none swing-out-top-bck"); // Asegúrate de remover cualquier clase previa
    $("#cardForm").addClass("swing-in-top-fwd"); // Añadir animación de entrada
    $("#nombreCliente").focus();
    
  $("#divDtInteresados").parent().parent().parent().addClass("d-none");
    $.post("../../controller/"+phpPrincipal+"?op=recogerInfo",{idPrescriptor:idPrescriptor},function (data) {
      data = JSON.parse(data)
      console.log(data);
      $("#nombreCliente").val(data[0]["nomPrescripcion"]);
      $("#sexoCliente").val(data[0]["sexoPrescripcion"]);
      $("#completoCliente").val(data[0]["nomPrescripcion"] + " " + data[0]["apePrescripcion"]);
      $("#apellidoCliente").val(data[0]["apePrescripcion"]);
      let fecha = new Date(data[0]["fecNacPrescripcion"]);
      let fechaFormateada = fecha.toLocaleDateString('es-ES'); // => "20/10/1999"
      $("#fechCliente").val(fechaFormateada);

      $("#fechaPrevista").val(data[0]["anoPrevistoPrescripcion"]);
      $("#emailCasa").val(data[0]["emailCasaPrescripcion"]);
      $('#correoSelect').text(data[0]["emailCasaPrescripcion"]);
      $('#correoEnviar').val(data[0]["emailCasaPrescripcion"]);

      
      $("#emailAlt").val(data[0]["emailAltPrescripcion"]);
      $("#fech1Contacto").val(data[0]["fechContactoPrescripcion"]);
      $("#dirCasa").val(data[0]["dirCasaPrescripcion"]);
      $("#dirAlt").val(data[0]["dirAltPrescripcion"]);
      $("#cursoDeseado").val(data[0]["cursoPrescripcion"]);
      $("#cpCasa").val(data[0]["cpCasaPrescripcion"]);
      $("#cpAlt").val(data[0]["cpAltPrescripcion"]);
      $("#conocimiento1").val(data[0]["cono1Prescripcion"]).trigger('change');
      $("#ciudadCasa").val(data[0]["ciudadCasaPrescripcion"]);
      $("#ciudadAlt").val(data[0]["ciudadAltPrescripcion"]);
      $("#conocimiento2").val(data[0]["cono2Prescripcion"]).trigger('change');
      $("#paisCasa").val(data[0]["paisCasaPrescripcion"]);
      $("#paisAlt").val(data[0]["paisAltPrescripcion"]);
      $("#conocimiento3").val(data[0]["cono3Prescripcion"]).trigger('change');
      $("#tefCasa").val(data[0]["tefCasaPrescripcion"]);
      $("#tefAlt").val(data[0]["tefAltPrescripcion"]);
      $("#probablemente").val(data[0]["probablementePrescripcion"]);
      $("#movilCasa").val(data[0]["movilCasaPrescripcion"]);
      $("#movilAlt").val(data[0]["movilAltPrescripcion"]);
      $("#grupoCliente").val(data[0]["grupoPrescripcion"]);
      $("#erasmusCliente").val(data[0]["erasmusPrescripcion"]);
      $("#uniOrigen").val(data[0]["uniOrigenPrescripcion"]);
      $("#Bildungsurlaub").val(data[0]["bildungsurlaub"]).trigger('change');
      $("#aupair").val(data[0]["auPair"]);
      console.log(data[0]["auPair"]);

      $("#preferenciaHoraria").val(data[0]["preferenciaHoraria"]).trigger('change');;
console.log(data[0]["preferenciaHoraria"]);
      $("#fechaConfirmacion").val(data[0]["fechMatConfiracion"]);
      $("#matCurso").val(data[0]["matCurso"]);
      $("#matAlojamiento").val(data[0]["matAloja"]);
      $("#matFechInicio").val(data[0]["matFechInicio"]);
      $("#textTipo").val(data[0]["obsPrescriptor"]);
      $("#departamentoSelect").val(data[0]["idDepartamentoEdu_prescriptores"]).trigger('change');
      $("#identificador").val(data[0]["identificadorDocumento"]);
      $("#tipoDocumento").val(data[0]["tipoDocumento"]).trigger('change');
      $("#nombreMadre").val(data[0]["nombreMadrePre"]);
      $("#nombrePadre").val(data[0]["nombrePadrePre"]);
      $("#tefPadre").val(data[0]["numPadrePre"]);
      $("#tefMadre").val(data[0]["numMadrePre"]);

      
      // Si el valor es 1, marcar el checkbox, si no, desmarcarlo
      if (data[0]["interesadoOnlinePre"] == 1) {
        $("#check-online").prop('checked', true);
      } else {
        $("#check-online").prop('checked', false);
      }
      $("#nacionalidadCliente").val(data[0]["nacionalidadPreinscriptor"]);

      cursoDeseado= data[0]["cursoPrescripcion"];
    $.post("../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",{codigo:cursoDeseado},function (data) {
      data = JSON.parse(data);
      console.log(data)

      $('.docenciaInput').val(data[0]["cod_tarifa"]+" - " + data[0]["nombre_tarifa"].trim() + " ("+data[0]["unidades_tarifa"] +" "+ data[0]["unidad_tarifa"]+")");
  
      $('#cursoDeseado').val(data[0]["cod_tarifa"]);


    })
      $('#btnPreforma').attr('href', '../../view/Llegadas/?tokenPreinscripcion='+data[0]["tokenPrescriptores"]);

    })
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
  let nombreCliente = $("#nombreCliente").val(); 
  let tipoCliente = $("#tipoCliente").val(); 
  let tefCliente = $("#tefCliente").val(); 
  let dirCliente = $("#dirCliente").val(); 
  let emailCliente = $("#emailCliente").val(); 
  let faxCliente = $("#faxCliente").val(); 
  let obsCliente = $("#obsCliente").val(); 
  let notasCliente = $("#notasCliente").val(); 
  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion && !validarArrayVacio(tipoCliente)) {
    //? SI LA VALIDACION DEVUELVE FALSE
    $.post(
      "../../controller/"+phpPrincipal+"?op=agregarElemento",//! NO TOCAR
      { nombreCliente:nombreCliente,tipoCliente:tipoCliente,tefCliente:tefCliente,dirCliente:dirCliente,emailCliente:emailCliente,faxCliente:faxCliente,obsCliente:obsCliente,notasCliente:notasCliente },//TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
      function (data) {
        //? AGREGAR ELEMENTO
        $("#"+idModalAgregar+"").modal("hide"); //! NO TOCAR
        toastr.success("Acción Agregada."); //TODO: MODIFICAR MENSAJE DE SUCCESS
        $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
      }
    );
  } else {
    if(validarArrayVacio(tipoCliente)){
      toastr.error("Por favor selecciona el Tipo de Cliente."); //? INFORMAR QUE HA DADO ERROR

    } ;
    if(validacion) {
      toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR

    };
  }
}


//* ******* ****** *

//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//

$("#"+idModalAgregar+"").on("show.bs.modal", function () {//! NO TOCAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarModalInputs(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
  limpiarSeleccion();
});

//* ** ********* *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* ** ********* *//

function limpiarSeleccion() {
  $('#tipoCliente').val(null).trigger('change');
  deselectFirstElement("tipoCliente");
  $('#tipoClienteE').val(null).trigger('change');
  deselectFirstElement("tipoClienteE");
  
}

function deselectFirstElement(idSelect2) {
  var $select = $('#'+idSelect2);
  var selectedValues = $select.val(); // Obtiene los valores seleccionados

  if (selectedValues && selectedValues.length > 0) {
    selectedValues.shift(); // Elimina el primer elemento
    $select.val(selectedValues).trigger('change'); // Actualiza el select2 con los nuevos valores
  }
}


$.post("../../controller/"+phpPrincipal+"?op=recogerConocimiento",{},function (data) {
  data = JSON.parse(data);
  console.log("cono1");
  console.log(data);
  $.each(data, function(indice, valor){
    $("#conocimiento1").append("<option value='"+data[indice]["idConocimiento"]+"'>"+data[indice]["nombreConocimiento"]+"</option>");
    $("#conocimiento2").append("<option value='"+data[indice]["idConocimiento"]+"'>"+data[indice]["nombreConocimiento"]+"</option>");
    $("#conocimiento3").append("<option value='"+data[indice]["idConocimiento"]+"'>"+data[indice]["nombreConocimiento"]+"</option>");

  });
 
    $("#conocimiento1").select2({
        theme: "bootstrap-5",
        placeholder: $(this).data('placeholder'),
        closeOnSelect: true,
        allowClear: true,  // Habilitar la limpieza de selección
        width: 'resolve',  // Ajusta automáticamente al tamaño del contenedor

        language: {
            inputTooShort: function(args) {
                var remainingChars = args.minimum - args.input.length;
                return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
            },
            maximumSelected: function(e) {
                return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
            },
            noResults: function() {
                return 'No se encontraron resultados';
            },
            searching: function() {
                return 'Buscando...';
            }
        }
    }).val(null).trigger('change');
    $("#conocimiento2").select2({
      theme: "bootstrap-5",
      placeholder: $(this).data('placeholder'),
      closeOnSelect: true,
      allowClear: true,  // Habilitar la limpieza de selección

      language: {
          inputTooShort: function(args) {
              var remainingChars = args.minimum - args.input.length;
              return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
          },
          maximumSelected: function(e) {
              return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
          },
          noResults: function() {
              return 'No se encontraron resultados';
          },
          searching: function() {
              return 'Buscando...';
          }
      }
    }).val(null).trigger('change');
    $("#conocimiento3").select2({
      theme: "bootstrap-5",
      placeholder: $(this).data('placeholder'),
      closeOnSelect: true,
      allowClear: true,  // Habilitar la limpieza de selección

      language: {
          inputTooShort: function(args) {
              var remainingChars = args.minimum - args.input.length;
              return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
          },
          maximumSelected: function(e) {
              return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
          },
          noResults: function() {
              return 'No se encontraron resultados';
          },
          searching: function() {
              return 'Buscando...';
          }
      }
    }).val(null).trigger('change');

})

$('#departamentoSelect').select2( {
  theme: "bootstrap-5",
  placeholder: $(this).data('placeholder'),
  closeOnSelect: true,
  allowClear: true,  // Habilitar la limpieza de selección

  language: {
      inputTooShort: function(args) {
          var remainingChars = args.minimum - args.input.length;
          return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
      },
      maximumSelected: function(e) {
          return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
      },
      noResults: function() {
          return 'No se encontraron resultados';
      },
      searching: function() {
          return 'Buscando...';
      }
  }
}).val(null).trigger('change');
$.post("../../controller/mntPreinscripciones.php?op=recogerDepartamentosActivo",{},function (data) {
  data = JSON.parse(data);
  console.log(data);
 
  $("#departamentoSelect").append("<option value=''>SELECCIONA DEPARTAMENTO</option>");

  $.each(data, function(indice, valor){
     estDepa = data[indice]["estDepa"];
     if(estDepa == 1){
          $("#departamentoSelect").append("<option value='"+data[indice]["idDepartamentoEdu"]+"'>"+data[indice]["nombreDepartamento"]+"</option>");

     }else{
          $("#departamentoSelect").append("<option value='"+data[indice]["idDepartamentoEdu"]+"'>"+data[indice]["nombreDepartamento"]+" - <span class='badge bg-secondary tx-danger tx-14-force'>Inactivo</span></option>");

     }
 

  });

})

$('#tipoDocumento').select2({
  theme: "bootstrap-5", // Tema de Bootstrap 5
  placeholder: $('#tipoDocumento').data('placeholder'), // Obtener el placeholder desde el atributo data-placeholder
  closeOnSelect: true, // Cierra el menú después de seleccionar un elemento
  allowClear: true, // Permite limpiar la selección
  language: {
      inputTooShort: function (args) {
          var remainingChars = args.minimum - args.input.length;
          return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
      },
      maximumSelected: function (args) {
          return 'Solo puedes seleccionar ' + args.maximum + ' elemento';
      },
      noResults: function () {
          return 'No se encontraron resultados';
      },
      searching: function () {
          return 'Buscando...';
      }
  },
  minimumResultsForSearch: 0 // Esto hace que la búsqueda siempre esté visible, incluso con pocos elementos
});




   
$.post("../../controller/mntPreinscripciones.php?op=recogerTipoDocumento",{},function (data) {
  data = JSON.parse(data);
  console.log(data);

  $.each(data, function(indice, valor){
      estDepa = data[indice]["estTipoIdentificativo"];
     if(estDepa == 1){
        $("#tipoDocumento").append("<option value='"+data[indice]["idTipoIdentificativo"]+"'>"+data[indice]["nombreIdentificativo"]+" </option>");

     }else{
        $("#tipoDocumento").append("<option value='"+data[indice]["idTipoIdentificativo"]+"'>"+data[indice]["nombreIdentificativo"]+" - <span class='badge bg-secondary tx-danger tx-14-force'>Inactivo</span></option>");

     }
 

  });
})

$('#Bildungsurlaub').select2( {
  theme: "bootstrap-5",
  placeholder: $(this).data('placeholder'),
  closeOnSelect: true,
  allowClear: true,  // Habilitar la limpieza de selección

  language: {
      inputTooShort: function(args) {
          var remainingChars = args.minimum - args.input.length;
          return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
      },
      maximumSelected: function(e) {
          return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
      },
      noResults: function() {
          return 'No se encontraron resultados';
      },
      searching: function() {
          return 'Buscando...';
      }
  }
}).val(null).trigger('change');
$.post("../../controller/mntPreinscripciones.php?op=recogerBildungsurlaub",{},function (data) {
  data = JSON.parse(data);
  console.log(data);

  $.each(data, function(indice, valor){
    $("#Bildungsurlaub").append("<option value='"+data[indice]["idBildun"]+"'>"+data[indice]["nombreBildun"]+"</option>");
 

  });

})
$('#tipoDocumento').on('change', function (){
  console.log($(this).val());
})
  
    $('#nacionalidadCliente').select2( {
      theme: "bootstrap-5",
      width: "100%",
      closeOnSelect: true,
  
      
    } );
$('#tipoCliente').select2( {
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $( this ).data( 'tipoCliente' ),
  closeOnSelect: true,
  maximumSelectionLength: 1,
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
} );
  $('#tipoClienteE').select2( {
    theme: "bootstrap-5",
    width: "100%",
    placeholder: $( this ).data( 'tipoCliente' ),
    closeOnSelect: true,
    allowClear: true,  // Habilitar la limpieza de selección

    maximumSelectionLength: 1,
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
  } 

);



function validateTextarea(textarea) {
  // 1. Reemplazar múltiples espacios dentro del texto (pero no afecta los saltos de línea)
  textarea.value = textarea.value.replace(/ {2,}/g, ' ');

  // 2. Permitir hasta dos saltos de línea consecutivos, pero no más
  textarea.value = textarea.value.replace(/\n{3,}/g, '\n\n');

  // 3. Limitar el texto a un máximo de 800 caracteres
  let maxLength = parseInt(textarea.getAttribute('data-max'));
  if (textarea.value.length > maxLength) {
      textarea.value = textarea.value.substring(0, maxLength);
  }

  // 4. (Opcional) Eliminar caracteres no válidos (personalizable según tus necesidades)
  // textarea.value = textarea.value.replace(/[^a-zA-Z0-9\s.,]/g, '');
}

$("#newClient").on("click",function(){

  $("#cancelClient").click();
  $("#cardForm").removeClass("d-none");
  $("#cardForm").removeClass("d-none swing-out-top-bck"); // Asegúrate de remover cualquier clase previa
  $("#cardForm").addClass("swing-in-top-fwd"); // Añadir animación de entrada
  $("#btnGestion").parent().addClass("d-none");
  $("#aceptClient").parent().removeClass("d-none");
  $("#updateClient").parent().addClass("d-none");
  $("#btnPreforma").parent().addClass("d-none");
  $("#cancelClient").parent().removeClass("d-none");
  $("#newClient").parent().addClass("d-none");
  $("#listClient").parent().removeClass("d-none");
  $("#mostrarPreforma").addClass("d-none");
  $("#nombreCliente").focus();

  $("#divDtInteresados").parent().parent().parent().addClass("d-none");

  // Obtener el año actual
  var currentYear = new Date().getFullYear();
    
  // Asignar el año actual al campo de entrada con el id "fechaPrevista"
  $('#fechaPrevista').val(currentYear);

     // Obtener la fecha actual
     var today = new Date();
     var day = ("0" + today.getDate()).slice(-2);
     var month = ("0" + (today.getMonth() + 1)).slice(-2);
     var year = today.getFullYear();
 
     // Formatear la fecha en formato YYYY-MM-DD
     var formattedDate = year + '-' + month + '-' + day;
 
     // Asignar la fecha actual al campo de tipo date con el id "fech1Contacto"
     $('#fech1Contacto').val(formattedDate);
});
$("#listClient").on("click",function(){
  $("#seleccionar-cliente-modal").modal("show")
});
$("#cancelClient").on("click",function(){
  $(".card-body").find("input").each(function(){
    $(this).val("");
  });
  $(".card-body").find("textarea").each(function(){
    $(this).val("");
  });
  // Primero eliminar cualquier animación anterior para evitar conflictos
  $("#cardForm").addClass("d-none");
  $("#cardForm").removeClass("swing-in-top-fwd swing-out-top-bck");
  $("#cardForm").addClass("swing-out-top-bck");
  $("#cardForm").on("animationend", function(e){
    if (e.originalEvent.animationName === "swing-out-top-bck") {
        $(this).addClass("d-none");
        $(this).removeClass("swing-out-top-bck"); // Remover la clase de animación de salida
    }

  });
  $("#btnGestion").parent().addClass("d-none");
  $("#aceptClient").parent().addClass("d-none");
  $("#updateClient").parent().addClass("d-none");
  $("#btnPreforma").parent().addClass("d-none");
  $("#cancelClient").parent().addClass("d-none");
  $("#listClient").parent().removeClass("d-none");
  $("#mostrarPreforma").addClass("d-none");
  $("#newClient").parent().removeClass("d-none");
  
  $("#divDtInteresados").parent().parent().parent().removeClass("d-none");
  $("#divDtInteresados").parent().parent().parent().addClass("swing-in-top-fwd");
});

$("#aceptClient").on("click",function(){
  let nombreCliente = $("#nombreCliente").val();
  let sexoCliente = $("#sexoCliente").val();
  let apellidoCliente = $("#apellidoCliente").val();
  let fechCliente = formatearFechaSinHora($("#fechCliente").val());
  let fechaPrevista = $("#fechaPrevista").val();
  let emailCasa = $("#emailCasa").val();
  let emailAlt = $("#emailAlt").val();
  let fech1Contacto = $("#fech1Contacto").val();
  let dirCasa = $("#dirCasa").val();
  let dirAlt = $("#dirAlt").val();
  let cursoDeseado = $("#cursoDeseado").val();
  let cpCasa = $("#cpCasa").val();
  let cpAlt = $("#cpAlt").val();
  let conocimiento1 = $("#conocimiento1").val();
  let ciudadCasa = $("#ciudadCasa").val();
  let ciudadAlt = $("#ciudadAlt").val();
  let conocimiento2 = $("#conocimiento2").val();
  let paisCasa = $("#paisCasa").val();
  let paisAlt = $("#paisAlt").val();
  let conocimiento3 = $("#conocimiento3").val();
  let tefCasa = $("#tefCasa").val();
  let tefAlt = $("#tefAlt").val();
  let probablemente = $("#probablemente").val();
  let movilCasa = $("#movilCasa").val();
  let movilAlt = $("#movilAlt").val();
  let grupoCliente = $("#grupoCliente").val();
  let erasmusCliente = $("#erasmusCliente").val();
  let uniOrigen = $("#uniOrigen").val();
  let Bildungsurlaub = $("#Bildungsurlaub").val();
  let aupair = $("#aupair").val();
  let preferenciaHoraria = $("#preferenciaHoraria").val();

  let fechaConfirmacion = $("#fechaConfirmacion").val();
  let matCurso = $("#matCurso").val();
  let matAlojamiento = $("#matAlojamiento").val();
  let matFechInicio = $("#matFechInicio").val();
  let textTipo = $("#textTipo").val();
  let departamentoSelect = $("#departamentoSelect").val();
  let tipoIdentificador = $("#tipoDocumento").val();
  let identificador = $("#identificador").val();

  let nombreMadrePre = $("#nombreMadre").val();
  let nombrePadrePre = $("#nombrePadre").val();
  let numPadrePre = $("#tefPadre").val();
  let numMadrePre = $("#tefMadre").val();

  let nacionalidadPre = $("#nacionalidadCliente").val();


  if ($("#check-online").is(':checked')) {
    interesadoOnlinePre = 1;
  } else {
    interesadoOnlinePre = 0;
  }
  
  if(departamentoSelect == ''){
    toastr.error('Departamento es un campo obligatorio');
    return;
  }

  $.post("../../controller/prescriptor.php?op=comprobarDocumento",{identificador:identificador,departamentoSelect:departamentoSelect},function (data) {

    if(data == 1){ // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
        
      toastr["error"]('El Identificador ya se encuentra registrado.'); // Existe correo - Error personalizado
      return;

    }else{
      let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
      if (!validacion) {
        $.post("../../controller/prescriptor.php?op=insertarPrescriptor",{nombreCliente:nombreCliente,sexoCliente:sexoCliente,apellidoCliente:apellidoCliente,fechCliente:fechCliente,fechaPrevista:fechaPrevista,emailCasa:emailCasa,emailAlt:emailAlt,fech1Contacto:fech1Contacto,dirCasa:dirCasa,dirAlt:dirAlt,cursoDeseado:cursoDeseado,cpCasa:cpCasa,cpAlt:cpAlt,conocimiento1:conocimiento1,ciudadCasa:ciudadCasa,ciudadAlt:ciudadAlt,conocimiento2:conocimiento2,paisCasa:paisCasa,paisAlt:paisAlt,conocimiento3:conocimiento3,tefCasa:tefCasa,tefAlt:tefAlt,probablemente:probablemente,movilCasa:movilCasa,movilAlt:movilAlt,grupoCliente:grupoCliente,erasmusCliente:erasmusCliente,uniOrigen:uniOrigen,Bildungsurlaub:Bildungsurlaub,aupair:aupair,preferenciaHoraria:preferenciaHoraria,fechaConfirmacion:fechaConfirmacion,matCurso:matCurso,matAlojamiento:matAlojamiento,matFechInicio:matFechInicio,textTipo:textTipo,departamentoSelect:departamentoSelect,tipoIdentificador:tipoIdentificador,identificador:identificador,nombreMadrePre:nombreMadrePre,nombrePadrePre:nombrePadrePre,numPadrePre:numPadrePre,numMadrePre:numMadrePre,interesadoOnlinePre:interesadoOnlinePre,nacionalidadPre:nacionalidadPre},function (data) {
          toastr.success("Interesado creado");
          prescriptor_table.ajax.reload(null, false); // false para mantener la página actual

          $("#cancelClient").trigger("click");
        })
      } else {
        toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
      }
    }

  });

  

})

$("#updateClient").on("click",function(){
  let prescriptorID = $("#prescriptorID").val();
  let nombreCliente = $("#nombreCliente").val();
  let sexoCliente = $("#sexoCliente").val();
  let apellidoCliente = $("#apellidoCliente").val();
  let fechCliente = formatearFechaSinHora($("#fechCliente").val());
  let fechaPrevista = $("#fechaPrevista").val();
  let emailCasa = $("#emailCasa").val();
  let emailAlt = $("#emailAlt").val();
  let fech1Contacto = $("#fech1Contacto").val();
  let dirCasa = $("#dirCasa").val();
  let dirAlt = $("#dirAlt").val();
  let cursoDeseado = $("#cursoDeseado").val();
  let cpCasa = $("#cpCasa").val();
  let cpAlt = $("#cpAlt").val();
  let conocimiento1 = $("#conocimiento1").val();
  let ciudadCasa = $("#ciudadCasa").val();
  let ciudadAlt = $("#ciudadAlt").val();
  let conocimiento2 = $("#conocimiento2").val();
  let paisCasa = $("#paisCasa").val();
  let paisAlt = $("#paisAlt").val();
  let conocimiento3 = $("#conocimiento3").val();
  let tefCasa = $("#tefCasa").val();
  let tefAlt = $("#tefAlt").val();
  let probablemente = $("#probablemente").val();
  let movilCasa = $("#movilCasa").val();
  let movilAlt = $("#movilAlt").val();
  let grupoCliente = $("#grupoCliente").val();
  let erasmusCliente = $("#erasmusCliente").val();
  let uniOrigen = $("#uniOrigen").val();
  let Bildungsurlaub = $("#Bildungsurlaub").val();
  let aupair = $("#aupair").val();
  let preferenciaHoraria = $("#preferenciaHoraria").val();

  
  let fechaConfirmacion = $("#fechaConfirmacion").val();
  let matCurso = $("#matCurso").val();
  let matAlojamiento = $("#matAlojamiento").val();
  let matFechInicio = $("#matFechInicio").val();
  let textTipo = $("#textTipo").val();
  let departamentoSelect = $("#departamentoSelect").val();
  let tipoIdentificador = $("#tipoDocumento").val();
  let identificador = $("#identificador").val();
  
  
  let nombreMadrePre = $("#nombreMadre").val();
  let nombrePadrePre = $("#nombrePadre").val();
  let numPadrePre = $("#tefPadre").val();
  let numMadrePre = $("#tefMadre").val();
  let nacionalidadPre = $("#nacionalidadCliente").val();

  if ($("#check-online").is(':checked')) {
    interesadoOnlinePre = 1;
  } else {
    interesadoOnlinePre = 0;
  }
  
  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
     /*  $.post(
        "../../controller/"+phpPrincipal+"?op=editarElemento", //! NO TOCAR
        { idElemento:idElemento,nombreCliente:nombreCliente,tipoCliente:tipoCliente,tefCliente:tefCliente,dirCliente:dirCliente,emailCliente:emailCliente,faxCliente:faxCliente,obsCliente:obsCliente,notasCliente:notasCliente, tipoIdentificador:tipoIdentificador,identificador:identificador },//TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
        function (data) {
          //? GUARDAR CAMBIOS

          $("#"+idModalEditar+"").modal("hide"); //! NO TOCAR
          toastr.success("Acción Editada."); //TODO: MODIFICAR MENSAJE DE SUCCESS
          $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
        }
      ); */
    
      $.post("../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",{codigo:cursoDeseado},function (data) {
        data = JSON.parse(data);
        console.log(data)

        $('.docenciaInput').val(data[0]["cod_tarifa"]+" - " + data[0]["nombre_tarifa"].trim() + " ("+data[0]["unidades_tarifa"] +" "+ data[0]["unidad_tarifa"]+")");
    
        $('#cursoDeseado').val(data[0]["cod_tarifa"]);


      })

      $.post("../../controller/"+phpPrincipal+"?op=actualizarPrescriptor",{prescriptorID:prescriptorID,nombreCliente:nombreCliente,sexoCliente:sexoCliente,apellidoCliente:apellidoCliente,fechCliente:fechCliente,fechaPrevista:fechaPrevista,emailCasa:emailCasa,emailAlt:emailAlt,fech1Contacto:fech1Contacto,dirCasa:dirCasa,dirAlt:dirAlt,cursoDeseado:cursoDeseado,cpCasa:cpCasa,cpAlt:cpAlt,conocimiento1:conocimiento1,ciudadCasa:ciudadCasa,ciudadAlt:ciudadAlt,conocimiento2:conocimiento2,paisCasa:paisCasa,paisAlt:paisAlt,conocimiento3:conocimiento3,tefCasa:tefCasa,tefAlt:tefAlt,probablemente:probablemente,movilCasa:movilCasa,movilAlt:movilAlt,grupoCliente:grupoCliente,erasmusCliente:erasmusCliente,uniOrigen:uniOrigen,Bildungsurlaub:Bildungsurlaub,aupair:aupair,preferenciaHoraria:preferenciaHoraria,fechaConfirmacion:fechaConfirmacion,matCurso:matCurso,matAlojamiento:matAlojamiento,matFechInicio:matFechInicio,textTipo:textTipo,departamentoSelect:departamentoSelect,tipoIdentificador:tipoIdentificador,identificador:identificador,nombreMadrePre:nombreMadrePre,nombrePadrePre:nombrePadrePre,numPadrePre:numPadrePre,numMadrePre:numMadrePre,interesadoOnlinePre:interesadoOnlinePre,nacionalidadPre:nacionalidadPre},function (data) {
        toastr.success("Interesado editado");
        prescriptor_table.ajax.reload(null, false); // false para mantener la página actual

        $("#cancelClient").trigger("click");
      })
    } else {
      toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
    }

})

$("#nombreCliente").on("input",function(){
  let nombreCliente = $("#nombreCliente").val();
  let apellidoCliente = $("#apellidoCliente").val();
  $("#completoCliente").val(nombreCliente + " " + apellidoCliente);

});

$("#apellidoCliente").on("input",function(){
  let nombreCliente = $("#nombreCliente").val();
  let apellidoCliente = $("#apellidoCliente").val();
  $("#completoCliente").val(nombreCliente + " " + apellidoCliente);

});


$(document).ready(function() {
  $('#fechCliente').on('change', function() {
      // Obtener la fecha ingresada por el usuario
      var inputFecha = new Date($(this).val());
      console.log(inputFecha);
      // Obtener la fecha actual
      var fechaHoy = new Date();
      
      // Calcular la diferencia de años
      var edad = fechaHoy.getFullYear() - inputFecha.getFullYear();
      
      // Ajustar si no ha cumplido años aún este año
      var mes = fechaHoy.getMonth() - inputFecha.getMonth();
      if (mes < 0 || (mes === 0 && fechaHoy.getDate() < inputFecha.getDate())) {
          edad--;
      }
      console.log(edad);

      // Verificar si es menor de 18 años
      if (edad < 18) {

          $('.infoPadres').removeClass('d-none');
      } else {
       
          $('.infoPadres').addClass('d-none');
      }
  });
});




/**************************************************/
/******************** SELECT GRUPOS  **************/
/**************************************************/

$(document).on("input focus", "#grupoCliente", function () {
  var query = $("#grupoCliente").val(); // Captura el valor del input
  var objetoInput = $("#grupoCliente");

  if (query.length > 0) {
    var isSuggestionClick = false; // Variable para controlar si se hizo clic en una sugerencia

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=recogerGruposBuscador", // Archivo PHP donde harás la consulta
      method: "POST",
      data: { search: query }, // Envía el texto al servidor
      success: function (data) {
        data = JSON.parse(data); // Parseamos el JSON recibido
        console.log(data);
        var suggestionsHTML = ""; // Contenedor para las sugerencias
        var suggestionsArray = []; // Arreglo para guardar las sugerencias

        // Recorremos el arreglo de datos
        data.forEach(function (item) {
          suggestionsHTML +=
            '<p class="suggestion-item">' +
            item.grupoPrescripcion +
            " " +
            "</p>"; // Generamos el HTML de cada sugerencia
          suggestionsArray.push(item.grupoPrescripcion +
            " " ); // Guardamos las sugerencias en el array
        });

        // Si hay sugerencias, las mostramos
        if (suggestionsHTML !== "") {
          objetoInput.next().html(suggestionsHTML).show(); // Mostramos el menú de sugerencias
        } else {
          objetoInput.next().hide(); // Si no hay sugerencias, escondemos el contenedor
        }
        var oninputVal = objetoInput.val(); // Valor actual del input
        
        // Usar delegación de eventos para los elementos creados dinámicamente
        $(document).off("click", ".suggestion-item"); // Limpiar eventos previos para evitar múltiples registros
        $(document).on("click", ".suggestion-item", function () {
          var selectedText = $(this).text(); // Obtener el texto completo de la sugerencia
          var selectedValue = selectedText.split(" - ")[0]; // Extraer solo el código antes del " - "
          objetoInput.val(selectedValue); // Cargar solo el código en el inputç
          
          
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });
        $(document).on("mousedown", ".suggestion-item", function () {
          isSuggestionClick = true; // Indica que se hizo clic en una sugerencia
        });
        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        
        
       objetoInput.off("blur").on("blur", function () {
        setTimeout(function () {
          
          if (suggestionsArray.length > 0) {
            // Si hay sugerencias, cargamos la primera en el input
            objetoInput.val(suggestionsArray[0]); // Cargar la primera sugerencia
            objetoInput.next().hide(); // Ocultar el menú de sugerencias
          }
        }, 200); // Timeout para dar tiempo a procesar el clic en la sugerencia antes del blur
      });
        
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});



/**********************************************************/
/******************** SELECT CURSO DESEADO  **************/
/***********************************+*+*******************/

$(document).on("input focus", "#cursoDeseado", function () {
  var query = $("#cursoDeseado").val(); // Captura el valor del input
  var objetoInput = $("#cursoDeseado");

  if (query.length > 0) {
    var isSuggestionClick = false; // Variable para controlar si se hizo clic en una sugerencia

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=recogerCursoBuscador", // Archivo PHP donde harás la consulta
      method: "POST",
      data: { search: query }, // Envía el texto al servidor
      success: function (data) {
        data = JSON.parse(data); // Parseamos el JSON recibido
        console.log(data);
        var suggestionsHTML = ""; // Contenedor para las sugerencias
        var suggestionsArray = []; // Arreglo para guardar las sugerencias

        // Recorremos el arreglo de datos
        data.forEach(function (item) {
          suggestionsHTML +=
            '<p class="suggestion-item">' +
            item.cursoPrescripcion +
            " " +
            "</p>"; // Generamos el HTML de cada sugerencia
          suggestionsArray.push(item.cursoPrescripcion +
            " " ); // Guardamos las sugerencias en el array
        });

        // Si hay sugerencias, las mostramos
        if (suggestionsHTML !== "") {
          objetoInput.next().html(suggestionsHTML).show(); // Mostramos el menú de sugerencias
        } else {
          objetoInput.next().hide(); // Si no hay sugerencias, escondemos el contenedor
        }
        var oninputVal = objetoInput.val(); // Valor actual del input
        
        // Usar delegación de eventos para los elementos creados dinámicamente
        $(document).off("click", ".suggestion-item"); // Limpiar eventos previos para evitar múltiples registros
        $(document).on("click", ".suggestion-item", function () {
          var selectedText = $(this).text(); // Obtener el texto completo de la sugerencia
          var selectedValue = selectedText.split(" - ")[0]; // Extraer solo el código antes del " - "
          objetoInput.val(selectedValue); // Cargar solo el código en el inputç
          
          
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });
        $(document).on("mousedown", ".suggestion-item", function () {
          isSuggestionClick = true; // Indica que se hizo clic en una sugerencia
        });
        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        
        
       objetoInput.off("blur").on("blur", function () {
        setTimeout(function () {
          
          if (suggestionsArray.length > 0) {
            // Si hay sugerencias, cargamos la primera en el input
            objetoInput.val(suggestionsArray[0]); // Cargar la primera sugerencia
            objetoInput.next().hide(); // Ocultar el menú de sugerencias
          }
        }, 200); // Timeout para dar tiempo a procesar el clic en la sugerencia antes del blur
      });
        
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});

$("#sexoCliente").on("input",function(){
  let valor = $(this).val().toUpperCase();

  if (!["F", "M", "O", "N"].includes(valor)) {
      $(this).val(''); // Limpiar campo
      // Mostrar mensaje de error (puedes personalizar esto según tu diseño)
      toastr.error("Por favor, ingresa solo una de las siguientes opciones: F, M, O, N.");
  } else {
      $(this).val(valor); // Mantener valor válido
  }
});




//===============================================================//
//=========== APARTADO GESTION USUARIO INTERESADO ===============//
//===============================================================//
$(document).ready(function () {


    // Verificar si está marcado inicialmente
    if ($('#checkRecordatorioPerfil').is(':checked')) {
        console.log('El checkbox está marcado inicialmente.');
    } else {
        console.log('El checkbox NO está marcado inicialmente.');
    }

  // Detectar cambios en el estado del checkbox
    $('#checkRecordatorioPerfil').change(function () {
        if ($(this).is(':checked')) {
            console.log('El checkbox ahora está marcado.');
        } else {
            console.log('El checkbox ahora NO está marcado.');
        }
    });

});
//========================//
// MAIN BOTON //
//========================//

  $('#botonEnviarCorreo').click( function (){
      // Verifica si al menos un checkbox está marcado
      const anyChecked = $(".checki:checked").length > 0;

      idInteresado = $('#idSelect').val();
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
      recordatorioCheck = $('#checkRecordatorioPerfil').is(':checked') ? 1 : 0;
      nuevoUsuCheck = $('#checkNuevoUsuario').is(':checked') ? 1 : 0;
      facturaCheck = $('#checkFactura').is(':checked') ? 1 : 0;


      // VALIDACION CHECK
      if (anyChecked) {
        cargando();

        $.post(
          "../../controller/prescriptor.php?op=enviarCorreoInteresado",
          {
            idInteresado: idInteresado,
            correoSelect: correoSelect,
            recordatorioCheck: recordatorioCheck,
            nuevoUsuCheck: nuevoUsuCheck,
            facturaCheck: facturaCheck,
          },
          function (data) {
            console.log(data);
            descargando();
            toastr.success('Correo enviado');

          }
        );
        

      } else {
        descargando();
          toastr.error('Debe marcar al menos una opción.');

      }


      descargando();

  });

  //==================================//
  /// GENERAR IDENTIFICADOR ALEATORIO //
  //==================================//

  function generarIdentificador(){
    $('#identificador').val('');

      // Obtener los valores de los campos de nombre y apellido
      const nombreCliente = $.trim($('#nombreCliente').val()) || "";
      const apellidoCliente = $.trim($('#apellidoCliente').val()) || "";
  
      // Obtener la primera letra de cada campo si no están vacíos
      const inicialNombre = nombreCliente ? nombreCliente.charAt(0).toUpperCase() : "";
      const inicialApellido = apellidoCliente ? apellidoCliente.charAt(0).toUpperCase() : "";
  
      // Generar la fecha en formato añomesdiahora (YYYYMMDDHHMMSS)
      const fecha = new Date();
      const fechaFormateada = 
          fecha.getFullYear().toString() + 
          String(fecha.getMonth() + 1).padStart(2, '0') + 
          String(fecha.getDate()).padStart(2, '0') + 
          String(fecha.getHours()).padStart(2, '0') + 
          String(fecha.getMinutes()).padStart(2, '0') 
       
  
      // Concatenar la fecha con las iniciales
      const identificador = `${fechaFormateada}${inicialNombre}${inicialApellido}`;
  
      // Asignar el identificador al campo correspondiente
      $('#identificador').val(identificador);
      toastr.success('Identiciador generado por fecha (AMDHM) y iniciales.')
  }


 
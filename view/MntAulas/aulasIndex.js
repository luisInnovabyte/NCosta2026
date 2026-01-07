// INICIALIZAR Y CONFIG SELECT 2
/* $(document).ready(function () {

    $("#selectIdioma").select2({
        dropdownParent: $('#insertar-aula-modal'),
        language: "es",
    });

    $("#selectPais").select2({
        dropdownParent: $('#insertar-aula-modal'),
        language: "es",
    });

    $("#selectIdiomaE").select2({
        dropdownParent: $('#editar-aula-modal'),
        language: "es",
    });

    $("#selectPaisE").select2({
        dropdownParent: $('#editar-aula-modal'),
        language: "es",
    });

});
 */
//**********************************************************************/
//*********************************************************************/
//********** FUNCION FILTRO Y AJAX PARA MOSTRAR DOCUMENTOS ***********/
//*******************************************************************/
//******************************************************************/


var aulas_table = $("#aulas_table").DataTable({
    select: false, // Nos permite seleccionar filas para exportar

    columns: [
        { name: "idAula" },
        { name: "Nombre" },
        { name: "Localizacion" },
        { name: "Caracteristicas" },
        { name: "Capacidad" },
        { name: "Observación" },
        { name: "estAula", "className": "text-center" },
        { name: "Acción", "className": "text-center" }
    ],

    columnDefs: [
        { targets: [0], orderable: true, visible: true }, // Tarifa
        { targets: [1], orderable: true, visible: true }, // Descripción
        { targets: [2], orderable: true, visible: true }, // Importe
        { targets: [3], orderable: true, visible: true }, // IVA
        { targets: [4], orderable: true, visible: true }, // Descuento
        { targets: [5], orderable: true, visible: true }, // Fecha Inicio
        { targets: [6], orderable: true, visible: true }, // Fecha Fin
        { targets: [7], orderable: true, visible: true } // Fecha Fin


    ],

    searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
    },

    ajax: {
        url: "../../controller/aulas.php?op=listarAulas",
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            // Código opcional antes de enviar
        },
        complete: function (data) {
            // Código opcional al completar
        },
        error: function (e) {
            console.error("Error en la carga de datos:", e);
        }
    },


});

$("#aulas_table").addClass("width-100");




$('#aulas_table').DataTable().on('draw.dt', function () {
    controlarFiltros('aulas_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/
$(document).ready(function () {
  $("#insertarAula").on("click", function () {
    //! LIMPIAR CADA CAMPO MANUALMENTE

    //? Nombre del Aula
    $("#descrAula").val("").removeClass("is-valid is-invalid");

    //? Localización
    $("#localizacionAula").val("").removeClass("is-valid is-invalid");

    //? Capacidad
    $("#capaAula").val("1").removeClass("is-valid is-invalid");

    //? TextArea Summernote
    $('#textAula').summernote('code', ''); // ✅ Vaciar correctamente
    $('#textAula').removeClass('is-valid is-invalid');

    //? Limpiar checkboxes
    $("#flexCheckHibrido").prop("checked", false);
    $("#flexCheckKids").prop("checked", false);
    $("#flexCheckParaliticos").prop("checked", false);
    $("#flexCheckAgorafobia").prop("checked", false);

    //? Limpiar textos auxiliares si aplica
    $("#lonDescrAula").text("");
    $("#lontelfAula").text("");

    //? Mostrar el modal
    $("#insertar-aula-modal").modal("show");
  });
});




/***********************************/
/**********************************/
/*********************************/

function activarAula(idAula) {
    swal.fire({
        title: 'Activar',
        text: "¿Desea activar el aula?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/aulas.php?op=activarAula", { idAula: idAula }, function (data) {

                $('#aulas_table').DataTable().ajax.reload();

                swal.fire(
                    'Activada',
                    'El aula se ha activado',
                    'success'
                )
            });
        }
    })
}


function desactivarAula(idAula) {
    console.log(idAula);
    swal.fire({
        title: 'Desactivar',
        text: "¿Desea desactivar el aula?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/aulas.php?op=desactivarAula", { idAula: idAula }, function (data) {

                $('#aulas_table').DataTable().ajax.reload();

                swal.fire(
                    'Desactivada',
                    'El aula se ha desactivado',
                    'success'
                )
            });
        }
    })
}


/*****************************************************/
/******************** AÑADIR AULA  ******************/
/***************************************************/

/* CARGAR DATOS SELECT IDIOMAS */

$.ajax({
    url: '../../controller/idiomas.php?op=listarIdiomasSelect',
    type: 'GET',
    dataType: 'json',
    error: function (error) {
        console.log(error);
    },
    success: function (res) {
        if (res.length > 0) {
            for (var i = 0; i < res.length; i++) {
                $("#selectIdioma").append("<option value='" + res[i][0] + "'>" + res[i][1] + " (" + res[i][2] + ")</option>");

                //Editar
                $("#selectIdiomaE").append("<option value='" + res[i][0] + "'>" + res[i][1] + " (" + res[i][2] + ")</option>");
            }


        }
    },
    complete: function (res) {
        /* var idUsuarioPre = $("#selectTrabajadores").val();
        $("#selectPais").val(idUsuarioPre); */
    }
});
$.ajax({
    url: "https://restcountries.com/v2/all",
    method: "GET",
    success: function (data) {
        var options = "";
        for (var i = 0; i < data.length; i++) {
            options += "<option value='" + data[i].name + "'>" + data[i].name + "</option>";
        }
        $("#selectPais").append(options);

        //Editar
        $("#selectPaisE").append(options);

    }
});

/*****************************/

/** FUNCION + - */
$("input[name='capaAula']").TouchSpin();

// SUMMERNOTE MODAL INSERTAR
actiSumernote('textAula');





$("#formAula").on("submit", function (event) {
    event.preventDefault();

    const campos = [
        { id: '#descrAula', nombre: 'Nombre ' },
        { id: '#localizacionAula', nombre: 'Localización ' },
        { id: '#capaAula', nombre: 'Capacidad' },
    ];

    // Validar si los campos están vacíos
    for (const campo of campos) {
        if ($(campo.id).val().trim() === '') {
            toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
            return; // Salir de la función si hay un campo vacío
        }
    }

    var datosFormulario = {

        descrAula: $("#descrAula").val(),
        localizacionAula: $("#localizacionAula").val(),
        capaAula: $("#capaAula").val(),
        textAula: $("#textAula").val(),
        hibrido: $("#flexCheckHibrido").is(":checked") ? 1 : 0,
        kids: $("#flexCheckKids").is(":checked") ? 1 : 0,
        paraliticos: $("#flexCheckParaliticos").is(":checked") ? 1 : 0,
        agorafobia: $("#flexCheckAgorafobia").is(":checked") ? 1 : 0
    };

    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }

    $.ajax({
        url: "../../controller/aulas.php?op=insertarAula",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            swal.fire(
                'Aula añadida',
                'El aula se ha añadido',
                'success'
            )


            $('#aulas_table').DataTable().ajax.reload();
            // Vaciar los datos del FormData  
            formData.forEach(function (value, key) {
                formData.delete(key);
            });
            $("#formAula")[0].reset();
            $('#textAula').summernote('reset');

        } // del success
    }); // del ajax
    $('#insertar-aula-modal').modal('hide');



});



/*****************************************************/
/******************** EDITAR AULA  ******************/
/***************************************************/


//FUNCION + - //
$("input[name='capaAulaE']").TouchSpin();


// SUMMERNOTE MODAL EDITAR
actiSumernote('textAulaE');


// CARGAR DATOS CAMPOS EDITAR 
function cargarDatosEditar(idAula) {

    $('#idAulaE').val(idAula);
    console.log(idAula);
    $.post("../../controller/aulas.php?op=obtenerAulaId", { idAula: idAula }, function (data) {

        console.log(idAula);
        var data = JSON.parse(data);

        $('#descrAulaE').val(data[0].nombreAula);
        $('#localizacionE').val(data[0].localizacionAula);
        $('#capaAulaE').val(data[0].capacidadAula);
        $('#textAulaE').summernote('code', data[0].observacionesAula);

        if (data[0].hibridoAula === 1) {
            $('#flexCheckHibridoE').prop('checked', true);
        } else {
            $('#flexCheckHibridoE').prop('checked', false);
        }

        if (data[0].kidsAula === 1) {
            $('#flexCheckKidsE').prop('checked', true);
        } else {
            $('#flexCheckKidsE').prop('checked', false);
        }

        if (data[0].paraliticosAula === 1) {
            $('#flexCheckParaliticosE').prop('checked', true);
        } else {
            $('#flexCheckParaliticosE').prop('checked', false);
        }

        if (data[0].agoraAula === 1) {
            $('#flexCheckAgorafobiaE').prop('checked', true);
        } else {
            $('#flexCheckAgorafobiaE').prop('checked', false);
        }

        $('#editar-aula-modal').modal('show');

    }) // Recuperar datos del cliente
}

// GUARDAR EDITAR
$("#formAulaEditar").on("submit", function (event) {
    event.preventDefault();

    const campos = [
        { id: '#descrAulaE', nombre: 'Nombre ' },
        { id: '#localizacionE', nombre: 'Localización ' },
        { id: '#capaAulaE', nombre: 'Capacidad' },
    ];

    // Validar si los campos están vacíos
    for (const campo of campos) {
        if ($(campo.id).val().trim() === '') {
            toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
            return; // Salir de la función si hay un campo vacío
        }
    }

    var datosFormulario = {
        idAulaE: $("#idAulaE").val(),

        descrAulaE: $("#descrAulaE").val(),
        localizacionE: $("#localizacionE").val(),
        capaAulaE: $("#capaAulaE").val(),
        textAulaE: $("#textAulaE").val(),
        hibridoE: $("#flexCheckHibridoE").is(":checked") ? 1 : 0,
        kidsE: $("#flexCheckKidsE").is(":checked") ? 1 : 0,
        paraliticosE: $("#flexCheckParaliticosE").is(":checked") ? 1 : 0,
        agorafobiaE: $("#flexCheckAgorafobiaE").is(":checked") ? 1 : 0
    };

    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }


    $.ajax({
        url: "../../controller/aulas.php?op=editarAula",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            swal.fire(
                'Editado',
                'Datos del Aula editados.',
                'success'
            )

            $('#aulas_table').DataTable().ajax.reload();


        } // del success
    }); // del ajax

    $('#editar-aula-modal').modal('hide');

});



//autofocus edit

$(document).ready(function () {
    $('#editar-aula-modal').on('shown.bs.modal', function () {
        $('#descrAulaE').focus();
    });
});

//autofocus insert

$(document).ready(function () {
    $('#insertar-aula-modal').on('shown.bs.modal', function () {
        $('#descrAula').focus();
    });
});

/***********************************/
/**********************************/
/*********************************/
/**********VALIDAR INSERTAR********/
/**********************************/
/*********************************/

$('#descrAula').blur(function () {
    campo1 = new validarCampos($('#descrAula'), /^(?=.*[A-Za-z\d])[A-Za-zñÑáéíóúüÁÉÍÓÚÜ\d\s]+$/gm, $('#infoDescrAula'));
    campo1.validar();
});

$('#telfAula').blur(function () {
    campo1 = new validarCampos($('#telfAula'), /^(?=.*[A-Za-z\d])[A-Za-zñÑáéíóúüÁÉÍÓÚÜ\d\s]+$/gm, $('#infotelfAula'));
    campo1.validar();
});



/* $('#emailAula').blur(function () {
    campo1 = new validarCampos($('#emailAula'), /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9ñÑáéíóúüÁÉÍÓÚÜ.-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/gm, $('#infoemailAula'));
    campo1.validar();
});
 */
$(document).ready(function () {
    // Seleccione el campo de entrada "capaAula" por su identificador
    var capaAula = $('#capaAula');

    // Agregue un controlador de eventos para el evento "keypress" en el campo de entrada
    capaAula.on('keypress', function (event) {
        // Obtener el código ASCII de la tecla presionada
        var charCode = (event.which) ? event.which : event.keyCode;

        // Permitir solo caracteres numéricos (códigos ASCII 48-57)
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault(); // Impide la entrada de otros caracteres
        }
    });
});

$('#dirAula').blur(function () {
    campo1 = new validarCampos($('#dirAula'), /^[a-zA-Z0-9\s,./ñÑáéíóúüÁÉÍÓÚÜ-\s]+$/gm, $('#infodirAula'));
    campo1.validar();
});

$('#provAula').blur(function () {
    campo1 = new validarCampos($('#provAula'), /^[a-zA-ZñÑáéíóúüÁÉÍÓÚÜ\s]+$/gm, $('#infoprovAula'));
    campo1.validar();
});

$('#poblaAula').blur(function () {
    campo1 = new validarCampos($('#poblaAula'), /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/igm, $('#infopoblaAula'));
    campo1.validar();
});

$('#cpAula').blur(function () {
    campo1 = new validarCampos($('#cpAula'), /^\d{1,5}$/, $('#infocpAula'));
    campo1.validar();
});



/***********************************/
/**********************************/
/*********************************/
/**********VALIDAR EDITAR********/
/**********************************/
/*********************************/

$('#descrAulaE').blur(function () {
    campo1 = new validarCampos($('#descrAulaE'), /^(?=.*[A-Za-z\d])[A-Za-zñÑáéíóúüÁÉÍÓÚÜ\d\s]+$/gm, $('#infodescrAulaE'));
    campo1.validar();
});


$('#telfAulaE').blur(function () {
    campo1 = new validarCampos($('#telfAulaE'), /^(?=.*[A-Za-z\d])[A-Za-zñÑáéíóúüÁÉÍÓÚÜ\d\s]+$/gm, $('#infotelfAulaE'));
    campo1.validar();
});

/* $('#emailAulaE').blur(function () {
    campo1 = new validarCampos($('#emailAulaE'), /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9ñÑáéíóúüÁÉÍÓÚÜ.-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/gm, $('#infoemailAulaE'));
    campo1.validar();
}); */

$(document).ready(function () {
    // Seleccione el campo de entrada "capaAula" por su identificador
    var capaAula = $('#capaAulaE');

    // Agregue un controlador de eventos para el evento "keypress" en el campo de entrada
    capaAula.on('keypress', function (event) {
        // Obtener el código ASCII de la tecla presionada
        var charCode = (event.which) ? event.which : event.keyCode;

        // Permitir solo caracteres numéricos (códigos ASCII 48-57)
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault(); // Impide la entrada de otros caracteres
        }
    });
});

$('#dirAulaE').blur(function () {
    campo1 = new validarCampos($('#dirAulaE'), /^[a-zA-Z0-9\s,./ñÑáéíóúüÁÉÍÓÚÜ-]+$/gm, $('#infodirAulaE'));
    campo1.validar();
});

$('#provAulaE').blur(function () {
    campo1 = new validarCampos($('#provAulaE'), /^[a-zA-ZñÑáéíóúüÁÉÍÓÚÜ\s]+$/gm, $('#infoprovAulaE'));
    campo1.validar();
});

$('#poblaAulaE').blur(function () {
    campo1 = new validarCampos($('#poblaAulaE'), /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/igm, $('#infopoblaAulaE'));
    campo1.validar();
});

$('#cpAulaE').blur(function () {
    campo1 = new validarCampos($('#cpAulaE'), /^\d{1,5}$/, $('#infocpAulaE'));
    campo1.validar();
});



//DESHABILITAR BOTON GUARDAR - posible conflicto merge
$(document).ready(function () {
    // deshabilitar botón Guardar al cargar la página
    $("#guardar-insert").prop("disabled", true);

    // habilitar botón Guardar si se completan todos los campos excepto teléfono
    $("#formAula").on("keyup change", function () {
        var empty = false;
        var emptyFields = [];
        $("#descrAula, #selectIdioma, #capaAula, #grupo, #selectPais, #cpAula").each(function () {
            if ($(this).val() == "") {
                empty = true;
                emptyFields.push($(this).attr("name"));
            }
        });
        if (empty) {
            $("#guardar-insert").prop("disabled", true);
            $("#error-message").text("Faltan completar los siguientes campos en el formulario: " + emptyFields.join(", "));
        } else {
            $("#guardar-insert").prop("disabled", false);
            $("#error-message").text("");
        }
        // limpiar formulario al hacer clic en el botón "Cancelar"
        $("#cancelar-insert").on("click", function () {
  //? Nombre del Aula
  $("#descrAula").val("").removeClass("is-valid is-invalid");

  //? Localización
  $("#localizacionAula").val("").removeClass("is-valid is-invalid");

  //? Capacidad
  $("#capaAula").val("1").removeClass("is-valid is-invalid");

  //? TextArea Summernote
  $('#textAula').summernote('code', '');
  $('#textAula').removeClass('is-valid is-invalid');

  //? Checkboxes
  $("#flexCheckHibrido").prop("checked", false);
  $("#flexCheckKids").prop("checked", false);
  $("#flexCheckParaliticos").prop("checked", false);
  $("#flexCheckAgorafobia").prop("checked", false);

  //? Textos auxiliares
  $("#lonDescrAula").text("");
  $("#lontelfAula").text("");

  //? Cerrar modal
  $("#insertar-aula-modal").modal("hide");
});


    });
});



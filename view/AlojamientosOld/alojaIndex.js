
/***********************************/
/**********ACTIVAR ALOJA**************/
/*********************************/

$("#nombreOpi").select2({
    placeholder: "Seleccione un alumno"
});
function activarAlojamiento(idAloja) {
    swal.fire({
        title: 'Activar',
        text: "¿Desea activar el alojamiento?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=activarAlojamiento", { idAloja: idAloja }, function (data) {

                $('#aloja_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Activado',
                    'El alojamiento se ha activado',
                    'success'
                )
            });
        }
    })
}
/***********************************/
/**********DESACTIVAR ALOJA**************/
/*********************************/
function desactivarAlojamiento(idAloja) {
    swal.fire({
        title: 'Desactivar',
        text: "¿Desea desactivar el alojamiento?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=desactivarAlojamiento", { idAloja: idAloja }, function (data) {
                $('#aloja_table').DataTable().ajax.reload();

                swal.fire(
                    'Desactivado',
                    'El Alojamiento se ha desactivado',
                    'success'
                )

            });

        }
    })
}


/*==================================*/
/*     INICIO DEL DATATABLES        */
/*==================================*/

/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES      */
/*============================================================*/
/*===========================================================*/

// Está en un archivo aparte comunDataTables.js

/*===============================================================*/
/*==============================================================*/
/*                             FIN                             */
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES     */
/*===========================================================*/
/*==========================================================*/



/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LA PARTE PARTICULAR DEL DATATABLES         */
/*============================================================*/
/*===========================================================*/
//datatable index.php
    // alert(tipo+estado+ocupado);
    var aloja_table = $('#aloja_table').DataTable({

        columns: [

            { name: "ID"},
            { name: "Tipo Alojamiento" },
            { name: "Nombre" },
            { name: "Dirección" },
            { name: "Disponibles", className: "text-center lobilist-title" },
            { name: "Ocupados", className: "text-center lobilist-title" },
            { name: "Valoración", className: "text-center" },
            { name: "Valoración", className: "text-center" }, // Valoración Numerica
            { name: "Estado", className: "text-center" },
            { name: "Acciones", className: "text-center" },
            { name: "Alumnos", className: "text-center" },
            { name: "Visitas", className: "text-center" },
            { name: "Opiniones", className: "text-center" }
        ],
        columnDefs: [
            //ID
            { targets: [0], orderData: [0], visible: false, type: 'num', className: 'secundariaDef'  },
            //Tipo Alojamiento
            { targets: [1], orderData: [1], visible: true },
            //Nombre
            { targets: [2], orderData: [1], visible: true },
            //Dirección
            { targets: [3], orderData: [1], visible: true },
            //Disponibles
            { targets: [4], orderData: [0], visible: true },
            //Ocupados
            { targets: [5], orderData: [0], visible: false },
            //Valoración
            { targets: [6], orderData: [0], visible: true },
            //Estado
            { targets: [7], visible: false , className: 'secundariaDef' },
            //Acciones
            { targets: [8], orderData: false, visible: true },
            //Alumnos
            { targets: [9], orderData: false, visible: true, className: 'secundariaDef' },
            //Visitas
            { targets: [10], orderData: false, visible: true, className: 'secundariaDef' },
            //Opiniones
            { targets: [11], orderData: false, visible: true, className: 'secundariaDef' },

            { targets: [12], orderData: false, visible: true, className: 'secundariaDef' },



        ],

        "ajax": {


            url: "../../controller/alojamientos.php?op=listarAlojamiento",
            //url: "../../controller/alojamientos.php?op=listarAlojamiento",
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
            processData: true,
            beforeSend: function () {
                //    $('.submitBtn').attr("disabled","disabled");
                //    $('#usuario_data').css("opacity","");
            }, complete: function (data) {

            },
            error: function (e) {
                console.log(e.responseText);
            }
        },
        orderFixed: [[1, "asc"]],
        searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
            columns: [1,2,3,4,5,7,8]
        },
    });
    //ANCHO del DATATABLE
    $("#aloja_table").addClass("width-100");
    //No mostrar columna
    aloja_table.columns( [7] ).visible( false );
    aloja_table.columns( [5] ).visible( false );
/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/
$('#FootTipo').on('keyup', function () {
    aloja_table
        .columns(2)
        .search(this.value)
        .draw();
});

$('#FootDireccion').on('keyup', function () {
    aloja_table
        .columns(3)
        .search(this.value)
        .draw();
});
/************************************************/
/*    FIN DE LOS FILTROS DE LOS PIES        ****/
/**********************************************/


$('#aloja_table').DataTable().on('draw.dt', function () {
    controlarFiltros('aloja_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/


////INICIO AGRUPACION
$('#aloja_table').on('init.dt', function () { //INICIO AGRUPACION
    var api = $(this).DataTable();

    // Agregar encabezados
    api.on('draw.dt', function () {
        var rows = api.rows({ page: 'current' }).nodes();

        var last1 = null;


        api.column(1, { page: 'current' }).data().each(function (group1, i) {
            //Que columna quieres que se use para agrupar el segundo grupo
            // Obtener el valor de la segunda columna directamente
            //Grupo1
            if (last1 !== group1) {
                $(rows).eq(i).before(
                    `<tr class="group1" style="font-size: 12px; color: #FFFFF5FE; background: blue; opacity:0.70;"><td colspan="11">${group1}</td></tr>`
                );
                last1 = group1;
            }

        });

        // Agregar manejadores de eventos para hacer clic en los encabezados y desplegarlos
        $('tr.group1').click(function () {
            $(this).nextUntil('tr.group1').toggle();
            $(this).nextUntil('tr.group1').toggle();
        });

    });

    $('#aloja_table').DataTable().ajax.reload();
});
//FIN AGRUPACION


//#######################################################\\
//#######################################################\\
//################ FORMULARIO ALOJAMIENTO ###############\\
//#######################################################\\
//#######################################################\\

//********************************************************//
//******************* ENVIAR CORREO *********************//
//**************** FAMILIA PARA DETALLES ***************//
//*****************************************************//
condicion = $('#condition').val();
if (condicion == 'editAdmin') {
    $('#botonEnviar').removeClass('d-none');
} else {
    $('#botonEnviar').addClass('d-none');
}
function enviarCorreoDatos() {
    var idAloja = $('#idAlojaEncrypt').val();
    var correo = $('#emailAloja').val();

    if (correo !== null && correo != '') {

        swal.fire({
            title: 'Complementar Datos',
            html:
                '¿Enviar un correo para complementar los datos? <br> Se enviará a <b>' + correo + '</b>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText:
                '<i class="fa-solid fa-envelope"></i> Enviar Correo',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {


                $.ajax({
                    url: "../../controller/alojamientos.php?op=enviarCorreoFamilia&idAlojamiento=" + idAloja + "&correo="+ correo ,
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data != '1') {

                            swal.fire(
                                'Correo',
                                '¡Problema con el envío!',
                                'error'
                            )
                        } else {
                            swal.fire(
                                'Alojamiento',
                                '¡Correo enviado con éxito!',
                                'success'
                            )
                        }
                    } // del success
                }); // del ajax

            }
        })

    } else {
        swal.fire(
            'Envio de correo',
            '¡El correo no es válido!',
            'error'
        )

    }


}
//#######################################################\\
//#######################################################\\
//#############Select alumnos########################\\
//#######################################################\\
//#######################################################\\

$.ajax({
    url: '../../controller/alojamientos.php?op=listarUsuariosSelectFiltrado',
    type: 'GET',
    dataType: 'json',
    error: function (error) {
        console.log(error);
    },
    success: function (res) {
        if (res.length > 0) {
            for (var i = 0; i < res.length; i++) {
                $("#nombreOpi").append("<option value='" + res[i][0] + "'>" + res[i][1] + "</option>");

            }


        }
    },
    complete: function (res) {
        /* var idUsuarioPre = $("#selectTrabajadores").val();
        $("#selectPais").val(idUsuarioPre); */
    }
});

//**************************************************//
//*************************************************//
//************************************************//
//***********************************************//

//#######################################################\\
//#######################################################\\
//#######################################################\\
//#######################################################\\
//#######################################################\\





// SUMMERNOTE MODAL INSERTAR
$('#descrImpreAloja').summernote({
    placeholder: 'Observaciones',
    tooltip: false,
    tabsize: 2,
    height: 150,
    disablePicture: true, // Deshabilitar la inserción de imágenes
    callbacks: {
        onPaste: function (e) {
            var clipboardData = e.originalEvent.clipboardData;
            if (clipboardData && clipboardData.items && clipboardData.items.length) {
                var item = clipboardData.items[0];
                if (item.type.indexOf('image') !== -1) {
                    e.preventDefault();
                    toastr["error"]('No se permite pegar imágenes en este editor.');
                }
            }
        }
    },
    lang: 'es-ES', // default: 'en-US'
    toolbar: [

        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['hr']],
        ['view', ['fullscreen']]
    ]
}
);

// SUMMERNOTE MODAL valorar
$('#descrAlojaOpi2').summernote({
    placeholder: 'Observaciones',
    tooltip: false,
    tabsize: 2,
    height: 150,
    disablePicture: true, // Deshabilitar la inserción de imágenes
    callbacks: {
        onPaste: function (e) {
            var clipboardData = e.originalEvent.clipboardData;
            if (clipboardData && clipboardData.items && clipboardData.items.length) {
                var item = clipboardData.items[0];
                if (item.type.indexOf('image') !== -1) {
                    e.preventDefault();
                    toastr["error"]('No se permite pegar imágenes en este editor.');
                }
            }
        }
    },
    lang: 'es-ES', // default: 'en-US'
    toolbar: [

        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['hr']],
        ['view', ['fullscreen']]
    ]
}
);




function getIdAloja($id) {
    $("#idAloja_AlojaVi").val($id);

}
function getIdAlojaOpi($id) {
    $("#idAloja_AlojaOpi").val($id);
}
// FORM AÑADIR VISITAS
$("#insertar-visitas-form").on("submit", function (event) {
    event.preventDefault();


    var formData = new FormData($("#insertar-visitas-form")[0]);

    $.ajax({
        url: "../../controller/alojamientos.php?op=insertarVisitas",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            swal.fire(
                'Visitas',
                'Visita añadida',
                'success'
            )

            $('#aloja_table').DataTable().ajax.reload();

        } // del success
    }); // del ajax

    $('#insertar-visitas-modal').modal('hide');

    // Vaciar los datos del FormData  
    formData.forEach(function (value, key) {
        formData.delete(key);
    });

    $('#descrImpreAloja').summernote('reset');
    $("#insertar-visitas-form")[0].reset();

});



// FORM AÑADIR OPINIONES
$("#insertar-opiniones-form").on("submit", function (event) {
    event.preventDefault();


    var formData = new FormData($("#insertar-opiniones-form")[0]);

    $.ajax({
        url: "../../controller/alojamientos.php?op=insertarOpis",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            swal.fire(
                'Opiniones',
                'Opinión añadida',
                'success'
            )
            $('#aloja_table').DataTable().ajax.reload();

        } // del success
    }); // del ajax

    $('#insertar-opiniones-modal').modal('hide');

    // Vaciar los datos del FormData  
    formData.forEach(function (value, key) {
        formData.delete(key);
    });
    $('#descrAlojaOpi').summernote('reset');
    $("#insertar-opiniones-form")[0].reset();
    $("#default-star-rating-opi").raty('reload');
});


// MOSTRAR 'DONDE SE PERMITE FUMAR'

$('input:radio[name=fumaAloja]').on('change', function () {

    var radioFumaAloja = $("input[name='fumaAloja']:checked").val();

    if (radioFumaAloja == "1") {
        $('#dondeFumar').removeClass('d-none');
    } else {
        $('#dondeFumar').addClass('d-none');
    }
});

//#######################################################\\
//#######################################################\\
//############INSERTAR NUEVO ALOJAMIENTO ########\\
//#######################################################\\
//#######################################################\\

$("#wizard").on("submit", function (event) {
    event.preventDefault();

    var maxAlumTipoRegex = /^(?:[1-9]|[1-9][0-9]{1,2}|999)$/;

    var selectedValue = $("#selectTipoAloja").val();
    var emailAloja = $("#emailAloja").val();

    // COMPROBAR SI CAMPOS OBLIGATORIOS EXISTEN
    if (selectedValue == "0" || emailAloja.trim() === "") {

        if (selectedValue == "0") {
            // El valor seleccionado no es 0, realizar las acciones necesarias
            toastr.error("Selecciona un tipo de alojamiento");
        }

        if (emailAloja.trim() === "") {
            // El campo de correo electrónico está vacío, mostrar un mensaje de error con Toastr
            toastr.error("El campo de correo electrónico está vacío");
            
        }

        return;
    }



    if ($("#idAloja").val() == "") {
        console.log('capasao');
        var formData = new FormData($("#wizard")[0]);

        $.ajax({
            url: "../../controller/alojamientos.php?op=insertarAlojamiento",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (texto) {
                swal.fire(
                    'Alojamiento',
                    'Alojamiento añadido',
                    'success'
                ).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // Redirigir a index.php
                        window.location.href = "index.php";
                    } else {
                        // Código para cuando el usuario ha hecho clic fuera del diálogo
                        window.location.href = "index.php";
                    }
                }) // del success
            }
        }); // del ajax
    }
    //#######################################################\\
    //#######################################################\\
    //############ ACTUALIZAR ALOJAMIENTO ADMIN ########\\
    //#######################################################\\
    //#######################################################\\
    if ($('#idAloja').val() !== "" && $('#condition').val() == 'editAdmin') {

        var formData = new FormData($("#wizard")[0]);

        $.ajax({
            url: "../../controller/alojamientos.php?op=editarAlojamientoAdmin",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (texto) {

                swal.fire(
                    'Alojamiento',
                    'Alojamiento actualizado',
                    'success'
                ).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // Redirigir
                        window.location.href = "index.php";
                    } else {
                        // Código para cuando el usuario ha hecho clic fuera del diálogo
                        window.location.href = "index.php";
                    }
                }) // del success
            }
        }); // del ajax

    }
    //#######################################################\\
    //#######################################################\\
    //##### ACTUALIZAR ALOJAMIENTO FAMILIAS/NEGOCIOS ETC ####\\
    //#######################################################\\
    //#######################################################\\
    if ($('#idAloja').val() !== "" && $('#condition').val() == 'edit') {

        //!! VALIDAR INPUT NUMBER NO SUPEREN 99.
        console.log('EDITANDO FAMILIA');
        var formData = new FormData($("#wizard")[0]);
        console.log("Form Data:");

        formData.forEach(function(value, key){
            console.log(key + ": " + value);
        });
        nacPadreAloja = $('#nacPadreAloja').val();
        nacMadreAloja = $('#nacMadreAloja').val();

        if(nacPadreAloja == '' || nacMadreAloja == ''){
            
            toastr.error("Complete las fechas de nacimientos.","Familia");

        }else{

            $.ajax({
                url: "../../controller/alojamientos.php?op=editarAlojamientoNOAdmin",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (texto) {

                    enviarAvisoAdmin();
                    swal.fire(
                        'Alojamiento',
                        'Alojamiento actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "thanks.html";
                        } else {
                            window.location.href = "thanks.php";
                        }
                    }) 
                }
            }); 

        }
    }

});
function validarNumero(input) {
    // Eliminar cualquier caracter que no sea un dígito
    input.value = input.value.replace(/\D/g, '');

    // Asegurarse de que el número sea positivo
    if (input.value < 0) {
        input.value = '';
    }
}

function enviarAvisoAdmin() {
    var idAloja = $('#idAlojaEncrypt').val();

    $.ajax({
        url: "../../controller/alojamientos.php?op=enviarAvisoAdmin&idAlojamiento=" + idAloja,
        type: "POST",
        contentType: false,
        processData: false,
        success: function (data) {

        } // del success
    }); // del ajax

}
//#######################################################\\
//#######################################################\\
//######### MODO ALUMNO DATOSALOJAMIENTO CONSULTA #######\\
//#######################################################\\
//#######################################################\\


if ($('#condition').val() == 'consult') {
    $('#wizard :input').prop('disabled', true); // inputs desactivados
    $('.fa.fa-info').remove(); // info de los inputs desactivados
    $('#submit-form').remove(); // boton submit desactivado
    $('#back-button').remove(); // boton volver a seccion Admin desactivado
    $('.seccion-admin').remove(); // boton volver a seccion Admin desactivado
    $('.seccion-info').addClass('js-active'); // boton volver a seccion Admin desactivado
    $(".wizard-content-item .subtitulo").hide();        // esconder subtitulos de cada seccion
}
function bloquearDatos(){
    
//#######################################################\\
//#######################################################\\
//######### MODO ALUMNO DATOSALOJAMIENTO CONSULTA #######\\
//#######################################################\\
//#######################################################\\


if ($('#condition').val() == 'consult') {
    $('#wizard :input').prop('disabled', true); // inputs desactivados
    $('.fa.fa-info').remove(); // info de los inputs desactivados
    $('#submit-form').remove(); // boton submit desactivado
    $('#back-button').remove(); // boton volver a seccion Admin desactivado
    $('.seccion-admin').remove(); // boton volver a seccion Admin desactivado
    $('.seccion-info').addClass('js-active'); // boton volver a seccion Admin desactivado
    $(".wizard-content-item .subtitulo").hide();        // esconder subtitulos de cada seccion
}

}



//#######################################################\\
//#######################################################\\   
//############# MODO EDICION NO ADMIN  ##################\\   
//#######################################################\\
//#######################################################\\

if ($('#condition').val() == 'edit') {
    $('#back-button').remove(); // boton volver a seccion Admin desactivado
    $('.seccion-admin').remove(); // boton volver a seccion Admin desactivado
    $('.seccion-info').addClass('js-active'); // boton volver a seccion Admin desactivado
    $(".wizard-content-item .subtitulo").hide();        // esconder subtitulos de cada seccion
}



$('#descrAlojaOpi').summernote({
    placeholder: 'Observaciones',
    tooltip: false,
    tabsize: 2,
    height: 150,
    disablePicture: true, // Deshabilitar la inserción de imágenes
    callbacks: {
        onPaste: function (e) {
            var clipboardData = e.originalEvent.clipboardData;
            if (clipboardData && clipboardData.items && clipboardData.items.length) {
                var item = clipboardData.items[0];
                if (item.type.indexOf('image') !== -1) {
                    e.preventDefault();
                    toastr["error"]('No se permite pegar imágenes en este editor.');
                }
            }
        }
    },
    lang: 'es-ES', // default: 'en-US'
    toolbar: [

        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['hr']],
        ['view', ['fullscreen']]
    ]
}
);





//rating

$(function () {

    $.fn.raty.defaults.path = '../../public/js/images/rating/';

    // Default
    $('#default-star-rating').raty();
    $('#default-star-rating2').raty();
    $('#default-star-rating-opi').raty();
});


// validaciones

$('#quienAlojaVis').blur(function () {
    campo1 = new validarCampos($('#quienAlojaVis'), /^[a-zA-Z ]+$/gm, $('#infoquienAlojaVis'));
    campo1.validar();
});


//desabilitar el boton guardar en opiniones
$(document).ready(function () {

    $('#nombreOpi'); prop('disabled', true);

    // INICIALIZAR Y CONFIG SELECT 2

    $("#selectTipoAloja").select2({
        language: "es",
    });



});
// Seleccionar el formulario y el botón de guardar
var form = $('#insertar-visitas-form');
var btnGuardar = $('#guardar-btn');
btnGuardar.prop('disabled', true);

// Deshabilitar el botón de guardar de insertar visitas si los campos están vacíos
form.on('input', function () {
    var inputs = $(this).find(':input');
    var empty = false;
    inputs.each(function (index) {
        if (index < 2 && $(this).val() === '') {
            empty = true;
        }
    });
    if (empty) {
        btnGuardar.prop('disabled', true);
    } else {
        btnGuardar.prop('disabled', false);
    }
});


// Deshabilitar el botón de guardar de insertar opiniones si no se ha seleccionado las estrellas
$('#insertar-opiniones-form').find('button[type="submit"]').prop('disabled', true);
$('#default-star-rating-opi').on('click', function () {
    // Obtener el valor de la valoración
    var rating = $('#default-star-rating-opi').raty('score');

    // Verificar si el valor está vacío
    if (rating === null) {
        // El valor está vacío
        $('#insertar-opiniones-form').find('button[type="submit"]').prop('disabled', true);
    } else {
        // El valor no está vacío
        $('#insertar-opiniones-form').find('button[type="submit"]').prop('disabled', false);
    }
});
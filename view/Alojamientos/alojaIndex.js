
/***********************************/
/**********ACTIVAR ALOJA**************/
/*********************************/
$(document).ready(function () {
    $("#nombreOpi").select2({
        placeholder: "Seleccione un alumno",
        dropdownParent: $('#agregar-opis-modal'), // Usa el ID del contenedor padre visible

    });
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

    var aloja_table = $('#aloja_table').DataTable({

        columns: [

            { name: "ID"},
            { name: "identificacion" },
            { name: "Dirección" },
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
            { targets: [9], orderData: false, visible: true },
            //Visitas
            { targets: [10], orderData: false, visible: true, className: 'secundariaDef' },
            //Opiniones
            { targets: [11], orderData: false, visible: true, className: 'secundariaDef' },

            { targets: [12], orderData: false, visible: true, className: 'secundariaDef' },

            { targets: [13], orderData: false, visible: true, className: 'secundariaDef' },


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
    aloja_table.columns( [7] ).visible( true );
    aloja_table.columns( [8] ).visible( false );
    console.log('asas');
/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/
$('#identificadorTipo').on('keyup', function () {
    aloja_table
        .columns(2)
        .search(this.value)
        .draw();
});

$('#FootTipo').on('keyup', function () {
    aloja_table
        .columns(3)
        .search(this.value)
        .draw();
});

$('#FootDireccion').on('keyup', function () {
    aloja_table
        .columns(4)
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
                    `<tr class="group1" style="font-size: 12px; color:rgba(185, 185, 47, 1); background: blue; opacity:0.70 !important;"><td colspan="11">${group1}</td></tr>`
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
    $('#botonCopiar').removeClass('d-none');
    
} else {
    $('#botonEnviar').addClass('d-none');
    $('#botonCopiar').addClass('d-none');
}
function enviarCorreoDatos() {
    var idAloja = $('#idAloja').val();
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
                            toastr.danger('¡Problema con el envío!');

                        } else {
                            toastr.success('¡Correo enviado con éxito!');

                          
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




function getIdAloja(id) {
    // Mostrar en consola el ID recibido como parámetro
    console.log("getIdAloja llamado con id:", id);

    // Asignar el ID al campo oculto de la visita
    $("#idAloja_AlojaVi").val(id);
    console.log("Valor input idAloja_AlojaVi:", $("#idAloja_AlojaVi").val());

    // Limpiar el campo de nombre de la visita
    $("#quienAlojaVis").val('');  // Limpiar el campo de texto para el nombre

     // Limpiar el campo de descripción (textarea) antes de abrir el modal
    $('#descrImpreAloja').summernote('reset'); // VACIAR EL CONTENIDO
    $('#descrImpreAloja').summernote('removeFormat'); // Opcional: ELIMINAR FORMATO RESIDUAL

    // Establecer la fecha de la visita al día actual
    const hoy = new Date().toISOString().split('T')[0]; // Obtener la fecha actual en formato YYYY-MM-DD
    $("#fechaAlojaVis").val(hoy);  // Asignar la fecha actual al campo de fecha
}


function getIdAlojaOpi(id) {
    $("#idAloja_AlojaOpi").val(id);
    console.log(id);

    //#######################################################\\
    //#############Select alumnos########################\\
    //#######################################################\\
    // Limpiar el select de alumnos (nombreOpi) al abrir el modal
    $("#nombreOpi").html('');  // Eliminar todas las opciones del select

    // Limpiar el campo de comentario (textarea) antes de abrir el modal
    $('#descrAlojaOpi').summernote('reset'); // VACIAR EL CONTENIDO
    $('#descrAlojaOpi').summernote('removeFormat'); // Opcional: ELIMINAR FORMATO RESIDUAL

    // Llamada AJAX para obtener los alumnos
    $.ajax({
        url: '../../controller/alojamientos.php?op=listarUsuariosSelectFiltrado',
        type: 'GET',
        dataType: 'json',
        data: { id: id },
        error: function (error) {
            console.log(error);
        },
        success: function (res) {
            console.log(res);
            if (res.length > 0) {
                // Añadir las opciones al select
                for (var i = 0; i < res.length; i++) {
                    $("#nombreOpi").append("<option value='" + res[i]['idAlumno'] + "'>" + res[i]['nomAlumno'] + " " + res[i]['apeAlumno'] + "</option>");
                }
            }
        },
        complete: function () {
            // Reiniciar las estrellas a 0 cuando se abre el modal
            $('#default-star-rating-opi').raty(); // Re-inicializar a 0 estrellas

            // Establecer la fecha actual en el campo input[type="date"]
            const hoy = new Date().toISOString().split('T')[0]; // Formato YYYY-MM-DD
            $("#fechaAlojaOpi").val(hoy); // Establecer la fecha actual

            // Mostrar el modal
            $('#agregar-opis-modal').modal('show');
        }
    });
}

// FORM AÑADIR VISITAS
$("#insertar-visitas-form").on("submit", function (event) {
    event.preventDefault();

    // Obtener valores y limpiar espacios
    const quienAlojaVis = $("#quienAlojaVis").val().trim();
    const fechaAlojaVis = $("#fechaAlojaVis").val().trim();
    // Summernote: limpiar HTML para validar texto
    const descrImpreAloja = $("#descrImpreAloja").summernote('code').replace(/<\/?[^>]+(>|$)/g, "").trim();

    let camposVacios = [];

    if (!quienAlojaVis) camposVacios.push("Visitante");
    if (!fechaAlojaVis) camposVacios.push("Fecha de visita");
    if (!descrImpreAloja) camposVacios.push("Descripción");

    if (camposVacios.length > 0) {
        Swal.fire({
            toast: true,
            icon: 'warning',
            title: `Completa los campos: ${camposVacios.join(", ")}`,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
        return;
    }

    // Si todo OK, envía formulario
    var formData = new FormData(this);

    $.ajax({
        url: "../../controller/alojamientos.php?op=insertarVisitas",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {
            Swal.fire({
                toast: true,
                icon: 'success',
                title: 'Visita añadida',
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });

            $('#aloja_table').DataTable().ajax.reload();
            $('#insertar-visitas-modal').modal('hide');
            $("#insertar-visitas-form")[0].reset();
        }
    });
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
            $('#agregar-opis-modal').modal('hide');

            swal.fire(
                'Opiniones',
                'Opinión añadida',
                'success'
            )
            $('#aloja_table').DataTable().ajax.reload();

        } // del success
    }); // del ajax


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
    var formData = new FormData($("#wizard")[0]);

    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    var maxAlumTipoRegex = /^(?:[1-9]|[1-9][0-9]{1,2}|999)$/;

    var selectedValue = $("#selectTipoAloja").val();
    var emailAloja = $("#emailAloja").val();
    console.log('aaad')

    // COMPROBAR SI CAMPOS OBLIGATORIOS EXISTEN
    if (selectedValue == "0") {

        if (selectedValue == "0") {
            // El valor seleccionado no es 0, realizar las acciones necesarias
            toastr.error("Selecciona un tipo de alojamiento");
        }

        /* if (emailAloja.trim() === "") {
            toastr.error("El campo de correo electrónico está vacío");
            
        } */

        return;
    }

    console.log('ad')
    console.log($("#idAloja").val());
    if ($("#idAloja").val() == "") {
        console.log('capasao');
        var formData = new FormData($("#wizard")[0]);

        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
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
                            window.location.href = "thanks.html";
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
    var idAloja = $('#idAloja').val();

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
/* ValidarCampos no existe por ningún sitio, lo he dejado comentado por eso
$('#quienAlojaVis').blur(function () {
    campo1 = new validarCampos($('#quienAlojaVis'), /^[a-zA-Z ]+$/gm, $('#infoquienAlojaVis'));
    campo1.validar();
});
*/

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
// CARGAR LA LIBRERÍA DE GOOGLE CHARTS CON EL PAQUETE CALENDAR
  google.charts.load('current', {
    packages: ['calendar'],
  });

// FUNCIÓN PARA PINTAR EL CALENDARIO CON LOS DATOS DE CLIENTES EN EL ALOJAMIENTO SELECCIONADO
function drawChart(idModal) {
  try {
    // COMPROBAR SI EXISTE EL CONTENDOR SOBRE EL QUE SE VA A PINTAR EL CALENDARIO
    const container = document.getElementById('calendar_basic');
    if (!container) {
      console.error('Error: No se encontró el elemento #calendar_basic');
      return;
    }

    // CREAR UNA NUEVA TABLA DE DATOS PARA GOOGLE CHARTS
    const dataTable = new google.visualization.DataTable();

    // DEFINICIÓN DE COLUMNAS DE FECHA, VALOR Y TOOLTIP
    dataTable.addColumn({ type: 'date', id: 'Día' });
    dataTable.addColumn({ type: 'number', id: 'Eventos' });
    dataTable.addColumn({ type: 'string', role: 'tooltip', p: { html: true } }); // tooltip en HTML para saltos de línea

    // Petición AJAX para obtener los datos del backend según el token del alojamiento
    $.ajax({
      url: "../../controller/alojamientos.php?op=alumnosPorAlojamiento",
      type: "POST",
      dataType: "json",
      data: { token: idModal },
      success: function(response) {
        if (!Array.isArray(response)) {
          console.error("Respuesta inesperada del servidor:", response);
          return;
        }

        // Agrupamos los clientes por fecha para poder pintar un solo día con varios clientes
        const agrupadoPorFecha = {};

        response.forEach(item => {
          const fecha = item.fecha; // Fecha con formato "YYYY-MM-DD"
          if (!agrupadoPorFecha[fecha]) {
            agrupadoPorFecha[fecha] = {
              clientes: [], // Lista de tooltips (clientes) para esa fecha
              valor: 0      // Contador de clientes por fecha
            };
          }
          agrupadoPorFecha[fecha].clientes.push(item.tooltip);
          agrupadoPorFecha[fecha].valor += 1; // Incrementamos contador para esa fecha
        });

        const data = [];

        // Convertimos cada entrada agrupada en una fila para Google Charts
        Object.entries(agrupadoPorFecha).forEach(([fecha, info]) => {
          const dateParts = fecha.split("-");
          const year = parseInt(dateParts[0], 10);
          const month = parseInt(dateParts[1], 10) - 1; // Los meses en JS van de 0 a 11
          const day = parseInt(dateParts[2], 10);

          const dateObj = new Date(year, month, day);

          // Si hay más de un cliente ese día, usamos un valor alto para un azul más fuerte
          const valor = info.valor > 1 ? 10 : 5;

          // Concatenamos todos los clientes con saltos de línea HTML para el tooltip
          const tooltip = info.clientes.join("<br>");

          // Añadimos la fila a los datos
          data.push([dateObj, valor, tooltip]);
        });

        // Añadimos todas las filas a la tabla de datos
        dataTable.addRows(data);

        // Opciones de configuración para el calendario
        const options = {
          title: "Alojamientos",
          height: 600,
          width: 1000,
          calendar: {
            cellSize: 20,
            focusedCellColor: {
              stroke: '#4285F4',
              strokeOpacity: 0.5,
              strokeWidth: 1
            }
          },
          noDataPattern: {
            backgroundColor: '#fff',
            color: '#eee'
          },
          colorAxis: {
            minValue: 0,
            maxValue: 10,
            colors: ['#cfe9ff', '#2196f3'] // degradado azul claro a azul fuerte
          },
          tooltip: { isHtml: true }  // Habilita HTML para los tooltips (importante para <br>)
        };

        // Creamos el gráfico de calendario y lo dibujamos en el contenedor
        const chart = new google.visualization.Calendar(container);
        chart.draw(dataTable, options);
      },
      error: function(xhr, status, error) {
        console.error("Error en la petición AJAX:", error);
        console.log("Detalles:", xhr.responseText);
      }
    });

  } catch (error) {
    console.error('Error general en drawChart:', error);
  }
}
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
// AQUI ES DONDE USO EL SET TIME OUT, HAY QUE CAMBIARLO POR DESTRUIR Y VOLVER A CREAR EL CALENDARIO
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////

// Función para mostrar el modal y cargar el calendario con la ocupación de un alojamiento
function mostrarOcupacion(token,nombre) {
  // Guardamos el token en un input oculto por si se necesita luego
  $('#idModal').val(token);
  $('#nombreAlojaGes').text(nombre);

 
  // Mostramos el modal del calendario
  $("#modal-calendario").show();

  // Esperamos un poco para asegurar que el modal está visible antes de dibujar
  setTimeout(() => {
    if (google.visualization) {
      // Si la librería Google Charts ya está cargada, dibujamos directamente
      drawChart(token);
    } else {
      // Si no está cargada, la cargamos y luego dibujamos
      google.charts.load('current', {
        packages: ['calendar'],
        callback: () => drawChart(token)
      });
    }
  }, 50);
}




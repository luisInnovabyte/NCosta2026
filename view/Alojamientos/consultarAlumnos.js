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
idAloja = $('#idAlumn').val();
var aloja_table = $('#alumn_table').DataTable({

    columns: [

        { name: "ID" },
        { name: "Nombre" },
        { name: "Correo" },
        { name: "Telefono" },
        { name: "Fechaalta" },
        { name: "Fechabaja" },
        { name: "fechaMuestra" },
        { name: "Estado", className: "text-center" },
        { name: "consultarAlojas", className: "text-center" },
        { name: "facturar", className: "text-center" },
        { name: "Acciones", className: "text-center" }
    ],
    columnDefs: [

        //ID
        { targets: [0], orderData: [0], visible: false, type: 'num', className: 'secundariaDef' },
        //Nombre
        { targets: [1], orderData: [1], visible: true },
        //Correo
        { targets: [2], orderData: [2], visible: true },
        //Telefono
        { targets: [3], orderData: [3], visible: true },
        //FechaAlta
        { targets: [4], orderData: [4], visible: true },
        //FechaBaja
        { targets: [5], orderData: [5], visible: true },
        //fechaMuestra
        { targets: [6], orderData: [6], visible: true },
        //Estado
        { targets: [7], orderData: [7], visible: true },
        //consultarAlojas
        { targets: [8], orderData: [8], visible: true, className:"secundariaDeff" },
        //Facturar
        { targets: [9], orderData: [9], visible: true },
        //Acciones
        { targets: [10], orderData: [10], visible: true }


    ],

    "ajax": {


        url: "../../controller/alojamientos.php?op=listarAlumnosAloja&idAloja=" + idAloja,
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
        columns: [1,2,3,4,7]
    },
});
aloja_table.column(9).visible(false);

//ANCHO del DATATABLE
$("#alumn_table").addClass("width-100");
$('#alumn_table').DataTable().on('draw.dt', function () {
    controlarFiltros('alumn_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});$('#Nombre').on('keyup', function () {
    opis_table
        .columns(1)
        .search(this.value)
        .draw();
    });
    $('#Correo').on('keyup', function () {
        opis_table
            .columns(2)
            .search(this.value)
            .draw();
    });
    $('#Telefono').on('keyup', function () {
        opis_table
            .columns(3)
            .search(this.value)
            .draw();
    });



/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/

/************************************************/
/*    FIN DE LOS FILTROS DE LOS PIES        ****/
/**********************************************/


$('#alumn_table').DataTable().on('draw.dt', function () {
    controlarFiltros('alumn_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/

function eliminarAlumno(idAlumn) {
    swal.fire({
        title: 'Alumnos',
        text: "¿Desea eliminar el alumno?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=eliminarAlumno", { idAlumn: idAlumn }, function (data) {

                $('#alumn_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Alumnos',
                    'El alumno se ha eliminado',
                    'success'
                )
            });
        }
    })
}

// select usuarios
$.ajax({
    url: '../../controller/alojamientos.php?op=listarUsuariosSelect',
    type: 'GET',
    dataType: 'json',
    error: function (error) {
        console.log(error);
    },
    success: function (res) {
        if (res.length > 0) {
            for (var i = 0; i < res.length; i++) {
                $("#nombreOpi").append("<option value='" + res[i][0] + "'>" + res[i].nomAlumno + "  "+res[i].apeAlumno+"</option>");

            }


        }
    },
    complete: function (res) {
        /* var idUsuarioPre = $("#selectTrabajadores").val();
        $("#selectPais").val(idUsuarioPre); */
    }
});



function cargarDatosEditarAlumnAloja(idAlumAloja) {
    $('#alumnos-aloja-modal').modal('show');
    $('#idAlumAloja').val(idAlumAloja);

    $.post("../../controller/alojamientos.php?op=cargarDatosEditarAlumnAloja", { idAlumAloja: idAlumAloja }, function (data) {

        var data = JSON.parse(data);
        console.log(data);
        $('#idAlumAloja').val(data[0].idAlumAloja);
        $('#nombreAlum').val(data[0].nomAlumno+' '+data[0].apeAlumno);
        $('#fechamuestra').val(data[0].fecMostrarAlumAloja);
        $("#fechaentrada").val(data[0].fecEntradaAlumAloja);
        $('#fechasalida').val(data[0].fecSalidaAlumAloja);
        if (data[0].estMostrarAlumAloja == 1) {
            $('#estado').prop('checked', true);
        } else {
            $('#estado').prop('checked', false);
        }

    }) // Recuperar datos del cliente
}


// GUARDAR EDITAR
$("#editar-ficha-form").on("submit", function (event) {
    event.preventDefault();

    var formData = new FormData($("#editar-ficha-form")[0]);

    // Obtener el estado del checkbox
    var estadoCheckbox = $('#estado').is(':checked') ? 1 : 0;
console.log(estadoCheckbox)
    // Establecer el valor de estado en el formulario
    formData.append('estado', estadoCheckbox);
    
    var fechaMuestra = $('#fechamuestra').val();
    var fecEntradaAlumAloja = $('#fechaentrada').val();
    var fecSalidaAlumAloja = $('#fechasalida').val();

    
    if (fecEntradaAlumAloja > fecSalidaAlumAloja) {
        // La fecha de muestra es posterior o igual a la fecha de entrada
        // Mostrar ventana de diálogo o mensaje de error
        swal.fire(
            'Error',
            'Debe introducir una fecha de salida posterior a la fecha de entrada',
            'error'
        )

        // Aplicar estilo de resaltado al campo de fecha de muestra
        $('#fecSalidaAlumAloja').addClass('error-input');
        return;
    } else {
        // Si el error se ha corregido, eliminar el estilo de resaltado
        $('#fecSalidaAlumAloja').removeClass('error-input');
    }
    if (fechaMuestra > fecEntradaAlumAloja) {
        // La fecha de muestra es posterior o igual a la fecha de entrada
        // Mostrar ventana de diálogo o mensaje de error
        swal.fire(
            'Error',
            'Debe introducir una fecha de muestra anterior a la fecha de entrada',
            'error'
        )

        // Aplicar estilo de resaltado al campo de fecha de muestra
        $('#fechaMuestra').addClass('error-input');
        return;
    } else {
        // Si el error se ha corregido, eliminar el estilo de resaltado
        $('#fechaMuestra').removeClass('error-input');
    }


    $.ajax({
        url: "../../controller/alojamientos.php?op=editarAlumnAloja",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            swal.fire(
                'Editado',
                'Datos del Alumno editados.',
                'success'
            )

            $('#alumn_table').DataTable().ajax.reload();


        } // del success
    }); // del ajax

    $('#editar-ficha-modal').modal('hide');
    $('#alumnos-aloja-modal').modal('hide');

});




function activarAlumno(idAlumn) {
    swal.fire({
        title: 'Activar',
        text: "¿Desea activar el alumno?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=activarAlumnAloja", { idAlumn: idAlumn }, function (data) {

                $('#alumn_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Activado',
                    'El alumno se ha activado',
                    'success'
                )
            });
        }
    })
}
/***********************************/
/**********DESACTIVAR Alumn**************/
/*********************************/
function desactivarAlumno(idAlumn) {
    swal.fire({
        title: 'Desactivar',
        text: "¿Desea desactivar el alumno?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=desactivarAlumnAloja", { idAlumn: idAlumn }, function (data) {

                $('#alumn_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Desactivado',
                    'El alumno se ha desactivado',
                    'success'
                )
            });
        }
    })
}

function consultarHistorial(idAlumnAloja) {

    $('#idAlumnAloja').val(idAlumnAloja);
    $('#consult_table').DataTable({

        //https://datatables.net/reference/option/
        aProcessing: true,//Activamos el procesamiento del datatables
        aServerSide: true,//Paginación y filtrado realizados por el servidor
        destroy: true,
        // con esto fijamos las cabeceras en la parte superior de la pantalla
        fixedHeader: false,
        responsive: true,
        stateSave: false,
        info: true,  //mostrandio xxx de xx registros
        //https://datatables.net/reference/option/pagingType
        paging: true, //quita no solo la información, sino toda la paginacion, se muestra todo de golpe
        ordering: true,   // quitar la posibilidad de ordenacion de las columnas
        searching: true, // quitar el sistema de busqueda
        // Cambiar el lenguaje - https://datatables.net/plug-ins/i18n/Spanish.html
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json",
            //cdn.datatables.net/plug-ins/1.11.3/i18n/ --> Varios idiomas


        },
        // controla la capacidad para que el usuario cambie la longitud de las lineas que está viendo, si esto está a false, no aparecerá el lengthMenu
        lengthChange: true,
        lengthMenu: [  // para sobreescribir los datos de MOSTRAR
            [10, 20, 30, - 1], [10, 20, 30, 'Todos']   // son dos arrays, el primero son los datos y el segundo es el texto que se va a mostrar (el -1 son Todos)
        ],
        // https://datatables.net/reference/button/ -> lista de botones que podemos colocar
        dom: '<"toolbar">Bfrtip', //Definimos los elementos del control de tabla
        buttons: [

            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                download: 'open',
                footer: true,
                title: 'Alojamiento',
                filename: 'Alojamiento',
                text: '<span class="btn btn-outline-primary" data-toggle="tooltip" title="Imprimir PDF"><i class="fas fa-file-pdf"></i></span>',
                exportOptions: {
                    columns: [0, ':visible']
                },
                className: 'DataTable'
            },

            {
                extend: 'print',
                footer: true,
                filename: 'Alojamiento',

                text: '<span class="btn btn-outline-primary" data-toggle="tooltip" title="Imprimir"><i class="fas fa-print"></i></span>',
                className: 'DataTable'
            },

            {

                extend: 'excelHtml5',
                footer: true,
                title: 'Alojamiento',

                filename: 'Acciones',

                text: '<span  class="btn btn-outline-primary" data-toggle="tooltip" title="Exportar EXCEL"><i class="fas fa-file-excel"></i></span>',
                className: 'DataTable'
            },
            {
                extend: 'csvHtml5',
                footer: true,
                filename: 'Alojamiento',
                text: '<span class="btn btn-outline-primary" data-toggle="tooltip" title="Exportar CSV"><i class="fas fa-file-csv"></i></span>',
                className: 'DataTable'
            },
            {
                extend: 'colvis',
                text: '<span class="btn btn-outline-warning" data-toggle="tooltip" title="Ocultar columnas"><i class="fas fa-columns"></i></span>',
                className: 'DataTable',
                postfixButtons: ['colvisRestore']
            }
        ],
        columns: [

            { name: "ID" },
            { name: "Nombre" },
            { name: "Fechaalta" },
            { name: "Fechabaja" }
        ],
        columnDefs: [

            //ID
            { targets: [0], orderData: [0], visible: false },
            //Nombre
            { targets: [1], orderData: [1], visible: true },
            //FechaAlta
            { targets: [2], orderData: [2], visible: true },
            //FechaBaja
            { targets: [3], orderData: [3], visible: true }


        ],

        "ajax": {


            url: "../../controller/alojamientos.php?op=historialAlumnosAloja&idAlumnAloja=" + idAlumnAloja,
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
        }
    });
    //ANCHO del DATATABLE
    $("#consult_table").addClass("width-100");
}
$('#consult_table').on('init.dt', function () { //INICIO AGRUPACION
    var api = $(this).DataTable();

    // Agregar encabezados
    api.on('draw.dt', function () {
        var rows = api.rows({ page: 'current' }).nodes();

        var last1 = null;
        var selectedGroup1 = "";

        api.column(0, { page: 'current' }).data().each(function (group1, i) {
            //Grupo1

            if (last1 !== group1) {

                selectedGroup1 = group1;
                last1 = group1;
            }
        });

        $("#tituloModal").text("Historial - " + selectedGroup1);
    });

    $('#consult_table').DataTable().ajax.reload();
});//FIN AGRUPACION


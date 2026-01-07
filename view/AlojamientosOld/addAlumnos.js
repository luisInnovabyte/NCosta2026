// COMPROBAR ALUMNO EN ALOJAMIENTO //
    $('#idAlumno').change(function() {
      var idAlumno = $(this).val();
      var idAloja = $('#idAloja').val();

      console.log("Valor seleccionado: " + idAlumno + idAloja);
      $.post("../../controller/alojamientos.php?op=comprobarAlumnoSelect",{idAlumno:idAlumno, idAloja:idAloja},function (data) {
   
        var data = JSON.parse(data);

        if (data.length > 0) {
            $("#usuariosAlojamientos").empty();

            for (var i = 0; i < data.length; i++) {
                var row = data[i];
           
                $("#usuariosAlojamientos").append("<p class='tx-danger tx-bold mg-l-10'>Este usuario ya tiene este alojamiento el "+convertirFormatoFecha(data[i].fecEntradaAlumAloja)+" / "+convertirFormatoFecha(data[i].fecSalidaAlumAloja)+"</p><br>");
            }
        }else{
            $("#usuariosAlojamientos").empty();
            console.log(data.length);

        }
    });
    });

  //////////////
//ALUMNOS SELECT
// $.ajax({
//     url: '../../controller/alojamientos.php?op=listarUsuariosSelect',
//     type: 'GET',
//     dataType: 'json',
//     error: function (error) {
//         console.log(error);
//     },
//     success: function (res) {
//         if (res.length > 0) {
//             for (var i = 0; i < res.length; i++) {
//                 $("#idAlumnos").append("<option value='" + res[i][0] + "'>" + res[i][1] + " (" + res[i][2] + ")</option>");
//             }


//         }
//     },
//     complete: function (res) {
//         /* var idUsuarioPre = $("#selectTrabajadores").val();
//         $("#selectPais").val(idUsuarioPre); */
//     }
// });

//INSERTAR FORM
$("#newAlumn_form").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData($("#newAlumn_form")[0]);
    var checkboxValue = $("#estado").is(":checked") ? "1" : "0";
    var idAlumno = $("#idAlumno").val();
    formData.append("status", checkboxValue);
    formData.append("idAlumno", idAlumno)
    
    //   VALIDACIÓN FECHA MUESTRA ANTES QUE LA DE ENTRADA
    var fechaMuestra = $('#fechaMuestra').val();
    var fecEntradaAlumAloja = $('#fecEntradaAlumAloja').val();
    var fecSalidaAlumAloja = $('#fecSalidaAlumAloja').val();


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

    // FIN VALIDACIÓN


    $.ajax({
        url: "../../controller/alojamientos.php?op=insertarAlumnos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function () {


            // Vaciar los datos del FormData 
            formData.forEach(function (value, key) {
                formData.delete(key);
            });
            $("#newAlumn_form")[0].reset();
            // Limpiar el campo de selección del select2
            // $("#idAlumnos").val(0).trigger("change");

            swal.fire(
                'Alumnos',
                'El Alumno se ha añadido',
                'success',
            ).then((result) => {
                window.location.href = 'index.php'; 
            });

            

        }
    }
    ); // del success
}); // del ajax

//desabilitar boton guardar
$("#botonGuardar").prop("disabled", true);
$(document).ready(function () {
    //select2
    // $("#idAlumnos").select2({
    //     language: "es",
    // });

    // Habilitar o deshabilitar el botón de guardar en función de si los campos están vacíos o no
    $("#newAlumn_form").on("keyup change", function () {
        var inputsVacios = false;
        $(this).find("input").each(function () {
            if ($(this).val() === "") {
                inputsVacios = true;
                return false;
            }
        });
        $("#botonGuardar").prop("disabled", inputsVacios);
    });
});

// DATATABLE SELECCIONAR ALUMNO
var alumnos_table = $('#seleccionar-alumno-table').DataTable({
    columns: [

        { name: "ID Usuario	" },
        { name: "Nombre" },
        { name: "Correo" },
        { name: "Telefono" },
        
    ],
    columnDefs: [
        //ID
        { targets: [0], orderData: [0], visible: false },
        //Nombre    
        { targets: [1], orderData: [1], visible: true },
        //Correo
        { targets: [2], orderData: [1], visible: true },
        //Telefono
        { targets: [3], orderData: [1], visible: true },
    ],

    "ajax": {


        url: "../../controller/usuario.php?op=listarAlumnos",
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
    orderFixed: [[0, "asc"]],
    searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
        columns: [0,1,2,3]
    },
});
//ANCHO del DATATABLE
$("#seleccionar-alumno-table").addClass("width-100");

/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/
$('#Nombre').on('keyup', function () {
alumnos_table
    .columns(1)
    .search(this.value)
    .draw();
});

$('#Correo').on('keyup', function () {
alumnos_table
    .columns(2)
    .search(this.value)
    .draw();
});
$('#Telefono').on('keyup', function () {
alumnos_table
    .columns(3)
    .search(this.value)
    .draw();
});
$('#seleccionar-alumno-table').DataTable().on('draw.dt', function () {
    controlarFiltros('seleccionar-alumno-table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

//ANCHO del DATATABLE
$("#seleccionar-alumno-table").addClass("width-100");

$(document).ready(function() {
    // Agregar controlador de eventos al hacer clic en una fila del DataTable
    $('#seleccionar-alumno-table tbody').on('click', 'tr', function() {
        // Obtener el objeto de DataTable correspondiente a la fila seleccionada
        var rowData = alumnos_table.row(this).data();

        // Obtener los valores de la columna "ID Usuario" y "Nombre" de la fila seleccionada
        var idUsuario = rowData[0]; // Si la columna "ID Usuario" es la primera columna del DataTable
        var nombre = rowData[1]; // Si la columna "Nombre" es la segunda columna del DataTable
        var email = rowData[2];
        var tlf = rowData[3];
        // Asignar los valores a las variables ocultas y al elemento <p> utilizando jQuery
        $('#idAlumno').val(idUsuario);
        $('#nombreAlumno').text(nombre);
        $('#emailAlumno').text(email);
        $('#tlfAlumno').text(tlf);
        // Mostrar etiquetas
        $('#borde').removeClass('d-none');
        $('#etiquetaNombre').removeClass('d-none');
        $('#etiquetaEmail').removeClass('d-none');

        $('#seleccionar-alumno-modal').modal('hide');
    });
});

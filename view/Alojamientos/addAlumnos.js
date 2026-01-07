function cargarModalAlumnos(){
    $('#alumnos-grupo-modal').modal('show');

}

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

        { name: "IDUsuario" },
        { name: "Nombre" },
        { name: "Fecha" },
        { name: "FechaF" },
        { name: "Tipo" },
        { name: "Gestión" },
        { name: "Token" },

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

        { targets: [4], orderData: [1], visible: true },
        { targets: [5], orderData: [1], visible: true },
        { targets: [6], orderData: [1], visible: false }


    ],

    "ajax": {


        url: "../../controller/alojamientos.php?op=listarAlumnosAlojaTarifa",
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
alumnos_table.column(6).visible(false);


//ANCHO del DATATABLE
$("#seleccionar-alumno-table").addClass("width-100");

/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/

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
        var idUsuario = rowData[6]; // Si la columna "ID Usuario" es la primera columna del DataTable
        var nombre = rowData[1]; // Si la columna "Nombre" es la segunda columna del DataTable
        var Tipo = rowData[2];
        var fechaIni = rowData[3]; // Puede ser "16-04-2025" o "16/04/2025"

        if (fechaIni) {
            var delimitador = fechaIni.includes("/") ? "/" : "-";
            var partes = fechaIni.split(delimitador); // ["16", "04", "2025"]

            if (partes.length === 3) {
                var dia = partes[0].padStart(2, '0');
                var mes = partes[1].padStart(2, '0');
                var anio = partes[2];

                var fechaFormateada = `${anio}-${mes}-${dia}`; // Formato "yyyy-MM-dd"
                $('#fecEntradaAlumAloja').val(fechaFormateada);
            } else {
                console.warn("Fecha con formato inesperado:", fechaIni);
            }
        } else {
            console.warn("Fecha vacía o indefinida:", fechaIni);
        }
        if (fechaIni) {
            var delimitador = fechaIni.includes("/") ? "/" : "-";
            var partes = fechaIni.split(delimitador); // ["16", "04", "2025"]

            if (partes.length === 3) {
                var dia = partes[0].padStart(2, '0');
                var mes = partes[1].padStart(2, '0');
                var anio = partes[2];
                // ---- Para #fechaMuestra (2 días antes) ----
                var fechaObj = new Date(`${anio}-${mes}-${dia}`);
                fechaObj.setDate(fechaObj.getDate() - 2); // restar 2 días
                var fechaMenosDos = `${fechaObj.getFullYear()}-${String(fechaObj.getMonth() + 1).padStart(2, '0')}-${String(fechaObj.getDate()).padStart(2, '0')}`;
                $('#fechaMuestra').val(fechaMenosDos);
            } else {
                console.warn("Fecha con formato inesperado:", fechaIni);
            }
        } else {
            console.warn("Fecha vacía o indefinida:", fechaIni);
        }
        var fechaFin = rowData[4]; // Puede ser "16-04-2025" o "16/04/2025"

        if (fechaFin) {
            var delimitador = fechaFin.includes("/") ? "/" : "-";
            var partes = fechaFin.split(delimitador); // ["16", "04", "2025"]

            if (partes.length === 3) {
                var dia = partes[0].padStart(2, '0');
                var mes = partes[1].padStart(2, '0');
                var anio = partes[2];

                var fechaFormateada = `${anio}-${mes}-${dia}`; // Formato "yyyy-MM-dd"
                $('#fecSalidaAlumAloja').val(fechaFormateada);
            } else {
                console.warn("Fecha con formato inesperado:", fechaIni);
            }
        } else {
            console.warn("Fecha vacía o indefinida:", fechaIni);
        }

        // Asignar los valores a las variables ocultas y al elemento <p> utilizando jQuery
        $('#idAlumno').val(idUsuario);
        $('#nombreAlumno').text(nombre);
        $('#tipotarifaAlumno').text(Tipo);


        
        // Mostrar etiquetas
        $('#borde').removeClass('d-none');
        $('#etiquetaNombre').removeClass('d-none');
        $('#etiquetaEmail').removeClass('d-none');

        $('#alumnos-grupo-modal').modal('hide');
    });
});



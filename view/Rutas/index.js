//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "contenido_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "contenido_Edu.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "insertar-contenido-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-nivel-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

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
$(document).ready(function () {
    inicializarDataTable();

    $('#selectIdioma, #selectCurso').on('change', function () {
        actualizarDataTable();
    });
    $('#selectIdiomaModal, #selectCursoModal').on('change', function () {
        let idiomaModal = $("#selectIdiomaModal").val();
        let cursoModal = $("#selectCursoModal").val();
    
        if (!idiomaModal) {
            $('#checkAlert').addClass('d-none');
            $('#duplicarRutBoton').addClass('d-none');

            return;
        }
        if (!cursoModal) {
            $('#checkAlert').addClass('d-none');
            $('#duplicarRutBoton').addClass('d-none');

            return;
        }
        
        let idioma = $("#selectIdioma").val();
        let curso = $("#selectCurso").val();
    
        if (idiomaModal === idioma && cursoModal === curso) {
            toastr.error("Los valores del idioma y curso en el modal son iguales a los seleccionados.");
            $('#checkAlert').addClass('d-none');
            $('#duplicarRutBoton').addClass('d-none');
            return;

        }
        $("#flexCheckCheckedDanger").prop("checked", false);

        $('#checkAlert').removeClass('d-none');
        $('#duplicarRutBoton').removeClass('d-none');

        var textoSeleccionadoIdioma = $("#selectIdiomaModal option:selected").text();
        var textoSeleccionadoCurso = $("#selectCursoModal option:selected").text();
        var textoRutaSeleccionada = textoSeleccionadoIdioma+ ' - '+textoSeleccionadoCurso;
        $('#rutaDestino').text(textoRutaSeleccionada);
    });
});

var rutasTable; // Variable global para almacenar la referencia del DataTable
function inicializarDataTable() {
    rutasTable = $("#rutas_table").DataTable({
        select: false,
        order: [[6, "desc"]], // Ordenar solo por la columna "Peso"
        columns: [
            { name: "id" },
            { name: "Idioma" },
            { name: "Curso" },
            { name: "Nivel" },
            { name: "Alumnos" },
            { name: "Periodicidad" },
            { name: "Peso" },
            { name: "Código" },
            { name: "Estado" },
            { name: "accion", className: "text-center" }
        ],
        columnDefs: [
            { targets: 0, visible: false, width: "50px", orderable: false },
            { targets: 1, width: "100px", className: "small", orderable: false },
            { targets: 2, width: "200px", className: "small", orderable: false },
            { targets: 3, width: "100px", className: "texto-peque", orderable: false },
            { targets: 4, width: "60px", orderable: false },
            { targets: 5, width: "60px", orderable: false },
            { targets: 6, width: "50px", type: "num" }, // Única columna ordenable
            { targets: 7, width: "70px", orderable: false },
            { targets: 8, width: "70px", orderable: false },
            { targets: 9, className: "text-center", width: "80px", orderable: false }
        ],
        searchBuilder: { columns: [1, 2, 3, 4, 5, 6, 7, 8] },
        ajax: {
            url: "../../controller/rutas.php?op=listarRutas",
            type: "POST",
            data: function (d) {
                d.idioma = $("#selectIdioma").val();
                d.curso = $("#selectCurso").val();
            },
            cache: false,
            serverSide: true,
            error: function (e) {
                console.log("Error en AJAX:", e.responseText);
            }
        }
    });
    

    $("#rutas_table").on("draw.dt", function () {
        let rowCount = rutasTable.rows().count(); // Contar filas
        console.log("Número de filas en la tabla:", rowCount);

        if (rowCount === 0) {
            $("#tablaRutas").addClass("d-none"); // Oculta la tabla si está vacía
        } else {
            $("#tablaRutas").removeClass("d-none"); // Muestra la tabla si tiene datos
        }

        controlarFiltros(idDatatables);
    }).addClass("width-100");
}



function actualizarDataTable() {
    const idioma = $("#selectIdioma").val();
    const curso = $("#selectCurso").val();

    if (!idioma) {
        return;
    }
    if (!curso) {
        return;
    }

    console.log("Actualizando tabla con idioma:", idioma, "y curso:", curso);

    if (rutasTable) {
        rutasTable.ajax.reload(null, false); // Recarga sin reiniciar paginación
    }

}


//* ************* ********** *////* ************* ********** *////* ************* ********** *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* ************* ********** *////* ************* ********** *////* ************* ********** *//

/* $('#contenido_table_titular tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
  // Obtén la instancia de la tabla DataTables
  var tabla = $('#contenido_table_titular').DataTable();

  // Obtén el objeto de datos de la fila actual
  var data = tabla.row(this).data();

  var idTitular = data[0];
  var nombreTitular = data[1];
  
  $("#verTitular").text(nombreTitular);
  $("#titularSelect").val(idTitular);
  $("#verTitular1").text(nombreTitular);
  $("#titularSelect1").val(idTitular);
  $("#modal-titulares").modal('hide');
});
$("#contenido_table_titular").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
$("#contenido_table_titular").DataTable().columns([2,4]).visible(false); */
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
/* 
function cambiarEstado(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/" + phpPrincipal + "?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#" + idDatatables + "").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
} */

//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
$(document).ready(function () {
    // Inicializar el select2 con la configuración que ya tienes
    $("#selectIdioma").select2({
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
                return 'No se encontraron resultados';
            },
            searching: function () {
                return 'Buscando...';
            }
        }
    });
    $("#selectCurso").select2({
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
    $("#selectCurso1").select2({
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
    $("#selectIdioma").val(null).trigger('change');
    $("#selectCurso").val(null).trigger('change');
    $("#selectIdiomaModal").val(null).trigger('change');
    $("#selectCursoModal").val(null).trigger('change');
    $("#selectCurso1").val(null).trigger('change');
    $("#selectNivel").select2({
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

    $("#medida").val(null).trigger('change');

    $("#medida").select2({
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

    $("#selectNivel1").select2({
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

    $("#selectNivel").val(null).trigger('change');
    $("#selectNivel1").val(null).trigger('change');
});

//=======================================================//
//               APARTADO RUTAS DE CURSOS                //
//=======================================================//
$(document).ready(function () {
    function validarNumeroEnteroPositivo(input) {
        $(input).on("input", function () {
            let valor = $(this).val();

            // Permite solo números enteros positivos
            if (!/^\d+$/.test(valor)) {
                $(this).val(valor.replace(/\D/g, "")); // Elimina caracteres no numéricos
            }
        });
    }

    // Aplica la validación a los campos
    validarNumeroEnteroPositivo("#minAlumnos");
    validarNumeroEnteroPositivo("#maxAlumnos");
    validarNumeroEnteroPositivo("#peso");
});

// AÑADIR AGREGAR CURSOS RUTA
function agregarContenido() {

    const selectIdioma = $('#selectIdioma');
    if (selectIdioma.val() === null || selectIdioma.val() === '') {
        toastr.error('Por favor, seleccione un idioma.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }

    const selectCurso = $('#selectCurso');
    if (selectCurso.val() === null || selectCurso.val() === '') {
        toastr.error('Por favor, seleccione un curso.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }

    const selectNivel = $('#selectNivel');
    if (selectNivel.val() === null || selectNivel.val() === '') {
        toastr.error('Por favor, seleccione un nivel.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }

    const campos = [

        { id: '#minAlumnos', nombre: 'Min Alumnos' },
        { id: '#maxAlumnos', nombre: 'Max Alumnos' },
        { id: '#periodicidad', nombre: 'Periodicidad' },
        { id: '#medida', nombre: 'Medida' },
        { id: '#peso', nombre: 'Peso' }
    ];

    // Validar si los campos están vacíos
    for (const campo of campos) {
        if ($(campo.id).val().trim() === '') {
            toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
            return; // Salir de la función si hay un campo vacío
        }
    }

    var datosFormulario = {
        idioma: $("#selectIdioma").val(),
        curso: $("#selectCurso").val(),
        nivel: $("#selectNivel").val(),
        minAlumnos: $("#minAlumnos").val(),
        maxAlumnos: $("#maxAlumnos").val(),
        periodicidad: $("#periodicidad").val(),
        medida: $("#medida").val(),
        peso: $("#peso").val()
    };
    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }

    $.ajax({
        url: "../../controller/rutas.php?op=insertarCurso",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            if(texto == 1){
                swal.fire(
                    'Añadido',
                    'El curso se ha añadido',
                    'success'
                )
            }else if(texto == 3){
                swal.fire(
                    'Peso',
                    'Esta ordenación ya existe',
                    'error'
                )
            }else{
                swal.fire(
                    'Existente',
                    'Esta ruta ya existe',
                    'error'
                )
            }
            


            $('#rutas_table').DataTable().ajax.reload();
            // Vaciar los datos del FormData  
            formData.forEach(function (value, key) {
                formData.delete(key);
            });

        } // del success
    }); // del ajax

}

// EDITAR
function cargarDatosEditar(idRuta) {

    $('#idEditando').val(idRuta);
    $('.editCurso').removeClass('d-none');
    $('#agregarContenido').addClass('d-none');


    $.post("../../controller/rutas.php?op=obtenerRutaxId", { idRuta: idRuta }, function (data) {

        var data = JSON.parse(data);
        // Asignar valor al select2
        $("#selectIdioma").val(data[0].idiomaId_ruta).trigger('change');
        $("#selectCurso").val(data[0].tipoId_ruta).trigger('change');
        $("#selectNivel").val(data[0].nivelId_ruta).trigger('change');
        $("#minAlumnos").val(data[0].minAlum_ruta);
        $("#maxAlumnos").val(data[0].maxAlum_ruta);
        $("#periodicidad").val(data[0].perRefresco_ruta);
        $("#medida").val(data[0].medidaRefresco_ruta).trigger('change');
        $("#peso").val(data[0].peso_ruta);
        $("#selectIdioma").prop("disabled", true);
        $("#selectCurso").prop("disabled", true);


        console.log(data)
        /* $('#descrAulaE').val(data[0].descrAula);
        $("#selectIdiomaE").val(data[0].idIdioma_Aula);
        $('#telfAulaE').val(data[0].tlfAula);
        $('#emailAulaE').val(data[0].emailAula);
        $('#capaAulaE').val(data[0].capaAula);
        $('#dirAulaE').val(data[0].dirAula);
        $('#provAulaE').val(data[0].provAula);
        $('#poblaAulaE').val(data[0].poblaAula);
        $('#cpAulaE').val(data[0].cpAula);
        $('#textAulaE').summernote('code', data[0].textAula);
        $("select#selectPaisE").val(data[0].paisAula); */
    }) // Recuperar datos del cliente */
}

function cancelarEditar() {
    $("#selectIdioma").prop("disabled", false);
    $("#selectCurso").prop("disabled", false);

    $('#idEditando').val('');
    $('.editCurso').addClass('d-none');
    $('#agregarContenido').removeClass('d-none');

    $("#selectIdioma").val(null).trigger('change');
    $("#selectCurso").val(null).trigger('change');
    $("#medida").val(null).trigger('change');
    $("#selectNivel").val(null).trigger('change');


    $("#minAlumnos").val('');
    $("#maxAlumnos").val('');
    $("#periodicidad").val('');
    $("#peso").val('');

}
function actualizarCurso() {

    idEditar = $('#idEditando').val();
    if (idEditar == '') {
        toastr.error('Error al editar, recargue la página.');
        return;
    }
    const selectIdioma = $('#selectIdioma');
    if (selectIdioma.val() === null || selectIdioma.val() === '') {
        toastr.error('Por favor, seleccione un idioma.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }

    const selectCurso = $('#selectCurso');
    if (selectCurso.val() === null || selectCurso.val() === '') {
        toastr.error('Por favor, seleccione un curso.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }

    const selectNivel = $('#selectNivel');
    if (selectNivel.val() === null || selectNivel.val() === '') {
        toastr.error('Por favor, seleccione un nivel.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }

    const campos = [

        { id: '#minAlumnos', nombre: 'Min Alumnos' },
        { id: '#maxAlumnos', nombre: 'Max Alumnos' },
        { id: '#periodicidad', nombre: 'Periodicidad' },
        { id: '#medida', nombre: 'Medida' },
        { id: '#peso', nombre: 'Peso' }
    ];

    // Validar si los campos están vacíos
    for (const campo of campos) {
        if ($(campo.id).val().trim() === '') {
            toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
            return; // Salir de la función si hay un campo vacío
        }
    }

    var datosFormulario = {
        idEditar: idEditar,
        idioma: $("#selectIdioma").val(),
        curso: $("#selectCurso").val(),
        nivel: $("#selectNivel").val(),
        minAlumnos: $("#minAlumnos").val(),
        maxAlumnos: $("#maxAlumnos").val(),
        periodicidad: $("#periodicidad").val(),
        medida: $("#medida").val(),
        peso: $("#peso").val()
    };
    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }

    $.ajax({
        url: "../../controller/rutas.php?op=editarCurso",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            swal.fire(
                'Editado',
                'El curso se ha editado',
                'success'
            )


            $('#rutas_table').DataTable().ajax.reload();

            cancelarEditar();

        } // del success
    }); // del ajax

}


function cambiarEstado(idElemento) {
    //! NO TOCAR
    //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
    $.post(
        "../../controller/rutas.php?op=cambiarEstado", //! NO TOCAR
        { idElemento: idElemento }, //! NO TOCAR
        function (data) {
            //? EDITAR ESTADO
            toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
            $('#rutas_table').DataTable().ajax.reload(null, false); //! NO TOCAR
        }
    );
}

// DUPLICAR RUTA
$("#duplicarRutaBoton").on("click", function () {
   
    const selectIdioma = $('#selectIdioma');
    if (selectIdioma.val() === null || selectIdioma.val() === '') {
        toastr.error('Por favor, seleccione un idioma.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }
    const selectCurso = $('#selectCurso');
    if (selectCurso.val() === null || selectCurso.val() === '') {
        toastr.error('Por favor, seleccione un curso.', 'Error de Validación');
        return; // Salir de la función si no se ha seleccionado un idioma
    }
    cargarDuplicarRuta();
     $("#duplicar-modal").modal("show");
});
  

function cargarDuplicarRuta(){

    var textoSeleccionadoIdioma = $("#selectIdioma option:selected").text();
    var textoSeleccionadoCurso = $("#selectCurso option:selected").text();
    var textoRutaSeleccionada = textoSeleccionadoIdioma+ ' - '+textoSeleccionadoCurso;
    $('#cursoNombre').text(textoRutaSeleccionada);
    $('#rutaDuplicar').text(textoRutaSeleccionada);

    
    $("#selectIdiomaModal").val(null).trigger('change');
    $("#selectCursoModal").val(null).trigger('change');
    var table = $('#rutas_table').DataTable();
    $('#rutasCantidad').text(table.rows().count());

    
}
function duplicarRuta(){
    cargando();
    let selectIdioma = $('#selectIdiomaModal');
    if (selectIdioma.val() === null || selectIdioma.val() === '') {
        toastr.error('Por favor, seleccione un idioma.', 'Error de Validación');
        descargando();

        return; // Salir de la función si no se ha seleccionado un idioma
    }

    let selectCurso = $('#selectCursoModal');
    if (selectCurso.val() === null || selectCurso.val() === '') {
        toastr.error('Por favor, seleccione un curso.', 'Error de Validación');
        descargando();

        return; // Salir de la función si no se ha seleccionado un idioma
    }
    
    if (!$("#flexCheckCheckedDanger").is(":checked")) {
        toastr.error("Debes marcar la casilla para continuar.");
        descargando();

        return false; // Evita que continúe la acción
    }

    let idiomaPegar = $("#selectIdiomaModal").val();
    let cursoPegar = $("#selectCursoModal").val();
    let idiomaCopiar = $("#selectIdioma").val();
    let cursoCopiar = $("#selectCurso").val();
    $.ajax({
        url: "../../controller/rutas.php?op=duplicarRuta",
        type: "POST",
        data: {
            idiomaCopiar: idiomaCopiar,
            cursoCopiar: cursoCopiar,
            idiomaPegar: idiomaPegar,
            cursoPegar: cursoPegar
        },
        success: function (texto) {

            descargando();

            swal.fire(
                'Duplicado',
                'La ruta se ha duplicado',
                'success'
            )
            $("#duplicar-modal").modal("hide");




        } // del success
    }); // del ajax
    descargando();

    
}

  //* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//
  //* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
  //* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
  //* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
  //* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//
  var isDark = isColorDark("#000000"); //? TRUE SI EL COLOR ES OSCURO FALSE SI ES CLARO
  
  var colorLetra = "black";
  var alumnosDerecha;
  var alumnosIzquierda;
  //* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//
  //* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
  //* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
  //* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
   
        // Inicializar el select2 con la configuración que ya tienes
        $("#selectDepartamento").select2({
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

        // Inicializar Flatpickr en los dos inputs de filtros de fecha
flatpickr.localize(flatpickr.l10ns.es);

// Ahora sí inicializas cada campo
const pickerMin = flatpickr("#fechaMinimaFiltro", {
    dateFormat: "Y-m-d",
    altFormat: "d-m-Y",
    altInput: true,
    altInputClass: "form-control form-control-sm mi-flatpickr",
    locale: "es",
    allowInput: true,
});

const pickerMax = flatpickr("#fechaMaximaFiltro", {
    dateFormat: "Y-m-d",
    altFormat: "d-m-Y",
    altInput: true,
    altInputClass: "form-control form-control-sm mi-flatpickr",
    locale: "es",
    allowInput: true,
});

// Variable para controlar la primera carga (PARA QUE NO SALGA EL MENSAJE DE QUE HA CARGADO LA TABLA POR PRIMERA VEZ)
let primeraCarga = true;

// CARGAR POR DEPARTAMENTO (SIN FILTRO DE FECHAS)
$("#selectDepartamento").change(function() {
    // Vaciar contenido de los campos fechaInicio y fechaFin
    $("#fechaMinimaFiltro").val('');
    $("#fechaMaximaFiltro").val('');

    cargarTablaAlum(1);

    // Mostrar toast sólo si NO es la primera carga
    if (!primeraCarga) {
        toastr.info('Departamento cambiado. Tabla actualizada.', 'Información');
    } else {
        primeraCarga = false; // Ya pasó la primera carga
    }
});


// NADA MÁS CARGUE LA PÁGINA, SE FILTRA POR EL DEPARTAMENTO DE ESPAÑOL
$(document).ready(function() {
    // Cuando cambia el departamento, carga tabla sin filtro fechas y desde departamento español (modo 1)
    // Al cargar la página, selecciona departamento 1 y carga tabla sin filtro fecha
    $("#selectDepartamento").val(1).trigger('change');
});


    /*
    //////////////////////////////////////////////
    //MÉTODO ANTERIORMENTE A CAMBIOS DE ALEJANDRO // 
    ///////////////////////////////////////////////
    //////////////////////////////////////////////
    //MÉTODO ANTERIORMENTE A CAMBIOS DE ALEJANDRO // 
    ///////////////////////////////////////////////
    //////////////////////////////////////////////
    //MÉTODO ANTERIORMENTE A CAMBIOS DE ALEJANDRO // 
    ///////////////////////////////////////////////
    var evaluacionFinalAlumnos;
    cargarTablaAlum();
    function cargarTablaAlum() {
   
        let rangoFechas = $('.date-range').val();
        let fechaInicio = "";  // Declarar variables fuera del if
        let fechaFin = "";
   
        
        departamento = $("#selectDepartamento").val();

        var evaluacionFinalAlumnos = $("#evaluacionFinalAlumnos").DataTable({
            pageLength: 5, // Muestra solo 5 registros por página
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
            buttons:[],
            columns: [
                { name: "id" },
                { name: "alumno", className: "text-center" },
                { name: "Llegada", className: "text-center" },
                { name: "Código", className: "text-center" },
                { name: "Matriculas", className: "text-center" },
                { name: "FechaInicio", className: "text-center" },
                { name: "Fecha Fin Matricula", className: "text-center" },
                { name: "Resultado", className: "text-center" },
                { name: "Gestionar", className: "text-center" },
                { name: "FechaBusquedaInicial", className: "text-center" },
                { name: "FechaBusquedaFinal", className: "text-center" }

            ],
            columnDefs: [
                {
                    targets: [0],
                    visible: true, // Oculta la columna ID
                }
            ],
            searchBuilder: {
                columns: [1, 2, 3], // Ajustado a las columnas existentes
            },
            ajax: {
                url: "../../controller/evaluacionFinal.php?op=mostrarAlumnosFinal",
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
                data: {
                    idDepartamento: departamento,
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin
                },
                beforeSend: function () {
                    // Aquí puedes agregar acciones antes de la solicitud
                },
                complete: function (data) {
                    // Aquí puedes agregar acciones después de la solicitud
                },
                error: function (e) {
                    console.error("Error en la carga de la tabla:", e);
                }
            }

            });
        // JOSE, TENÍAS PUESTO ANTES ALUMNO LLEGADAS, ESO NO EXISTE EN ESTE CÓDIGO
        // ME IMAGINO QUE QUERÍAS PONER LA VARIABLE DEL DATATABLE...
        //alumnoLlegadas.page.len(10).draw();
        //alumnoLlegadas.column(0).visible(true);
        evaluacionFinalAlumnos.page.len(10).draw();
        evaluacionFinalAlumnos.column(0).visible(true);

        $("#alumnosTabla").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
      

    }
    */
    //////////////////////////////////////////////
    //MÉTODO NUEVO A CAMBIOS DE ALEJANDRO // ////////
    ///////////////////////////////////////////////
   var evaluacionFinalAlumnos; // Variable global

    function cargarTablaAlum(modo = 1) {
        var fechaInicio = "";
        var fechaFin = ""; // Declarar variables fuera del if

        // Obtener departamento seleccionado
        const departamento = $("#selectDepartamento").val();

        if (modo === 2) {
            // En modo con filtro fechas
            const fechaMin = $("#fechaMinimaFiltro").val();
            const fechaMax = $("#fechaMaximaFiltro").val();

            if (fechaMin && fechaMax) {
                // Validar fechas: si la fechaMax es menor que fechaMin, ignorar filtro fechas (puedes ajustar aquí)
                if (new Date(fechaMax) >= new Date(fechaMin)) {
                    fechaInicio = fechaMin;
                    fechaFin = fechaMax;
                } else {
                    // Fechas inválidas: asignamos valores vacíos para excluir resultados
                    fechaInicio = "";
                    fechaFin = "";
                }
            } else if (fechaMin && !fechaMax) {
                // Solo fecha mínima introducida
                fechaInicio = fechaMin;
                fechaFin = ""; // Sin fecha máxima
            } else if (!fechaMin && fechaMax) {
                // Solo fecha máxima introducida
                fechaInicio = ""; // Sin fecha mínima
                fechaFin = fechaMax;
            }
        }

        // modo 1: sin filtro fechas (fechaInicio y fechaFin quedan vacíos)

        var evaluacionFinalAlumnos = $("#evaluacionFinalAlumnos").DataTable({
            pageLength: 5, // Muestra solo 5 registros por página
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
            buttons: [],
            columns: [
                { name: "id" },
                { name: "alumno", className: "text-center" },
                { name: "Llegada", className: "text-center" },
                { name: "Código", className: "text-center" },
                { name: "Matriculas", className: "text-center" },
                { name: "FechaInicio", className: "text-center" },
                { name: "Fecha Fin Matricula", className: "text-center" },
                { name: "Resultado", className: "text-center" },
                { name: "Gestionar", className: "text-center" },
                { name: "FechaBusquedaInicial", className: "text-center" },
                { name: "FechaBusquedaFinal", className: "text-center" }
            ],
            columnDefs: [
                {
                    targets: [0],
                    visible: true, // Oculta la columna ID
                }
            ],
            searchBuilder: {
                columns: [1, 2, 3], // Ajustado a las columnas existentes
            },
            ajax: {
                url: "../../controller/evaluacionFinal.php?op=mostrarAlumnosFinal",
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
                data: {
                    idDepartamento: departamento,
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin
                },
                beforeSend: function () {
                    // Aquí puedes agregar acciones antes de la solicitud
                },
                complete: function (data) {
                    // Aquí puedes agregar acciones después de la solicitud
                },
                error: function (e) {
                    console.error("Error en la carga de la tabla:", e);
                }
            }
        });

        // Forzar que la tabla muestre 10 filas (igual que antes)
        evaluacionFinalAlumnos.page.len(10).draw();
        evaluacionFinalAlumnos.column(0).visible(true);

        $("#evaluacionFinalAlumnos").addClass("width-100"); // Mantener responsividad
    }
    
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
    
    $("#selectIdioma").val(null).trigger('change');





});


$(document).ready(function () {
    /*    
    let idioma = $("#idIiomaTablaT").val();
    let curso = $("#idTipoCursoTablaT").val(); */
       
   
    $("#selectIdioma").val($("#selectIdioma option:first").val()).trigger("change");
    $("#selectCurso").val($("#selectCurso option:first").val()).trigger("change");
   

    $('#selectIdioma, #selectCurso').on('change', function () {
        
        actualizarDataTable();
        
    }); 
 
});


function actualizarDataTable(){
    const idioma = $("#selectIdioma").val();
    const curso = $("#selectCurso").val();

    if (!idioma) {
        return;
    }
    if (!curso) {
        return;
    }

    console.log("Actualizando tabla con idioma:", idioma, "y curso:", curso);
    
    if (cursosTabla) {
        cursosTabla.ajax.reload(null, false); // Recarga sin reiniciar paginación
    }

}



function cargarModalAlumnos(codGrupo){
    $('#alumnos-grupo-modal').modal('show');
    $.post('../../controller/grupos.php?op=recogerAlumnosClase', { codGrupo: codGrupo}, function(response) {
        let alumnos = JSON.parse(response);
        console.log(alumnos)
        let container = $("#divAlumnosGrupo");
        container.empty(); // Limpiar el contenedor antes de agregar nuevos elementos
    
        $.each(alumnos, function(index, alumno) {
            let avatar = alumno.avatarUsu ? `../../public/assets/images/users/${alumno.avatarUsu}` : '../../public/assets/images/default-avatar.png';
            if(alumno.fechaNuevaCursos == null){
                fechaNueva = 'Nuevo Curso';
            }else{
                fechaNueva = 'Fecha Salto: '+alumno.fechaNuevaCursos;
            }
            let card = `
                <div class="col-md-4 mb-4">
                    <div class="card text-center shadow-sm p-3">
                        <div class="d-flex justify-content-center">
                            <img src="${avatar}" width="110" height="110" class="rounded-circle shadow" alt="Avatar">
                        </div>
                        <h5 class="mt-3 mb-0">${alumno.nombreUsu} ${alumno.apellidosUsu}</h5>
                        <p class="mb-3">Nick: ${alumno.nickUsu}</p>
                        <p class="mb-3">ID: ${alumno.idUsu}</p>
                    
                        <p class="mb-3 tx-success">${fechaNueva}</p>

                        <div class="d-grid mt-3">
                            <a href="../Perfil/?tokenUsuario=${alumno.tokenUsu}" target="_blank" class="btn btn-sm btn-outline-primary radius-15">Perfil</a>
                        </div>
                    </div>
                </div>
            `;
            container.append(card);
        });
    });

}
//////////////////////////////////////
// FILTRO DE FECHA MÍNIMA Y MÁXIMA  //
//////////////////////////////////////

    $("#aplicarFiltroFecha").click(function(e) {
        e.preventDefault();

        const fechaMin = $("#fechaMinimaFiltro").val();
        const fechaMax = $("#fechaMaximaFiltro").val();

        // Si ambas fechas están vacías, muestra error
        if (!fechaMin && !fechaMax) {
            toastr.error("Debe introducir al menos una fecha.", "Error");
            return;
        }

        // Si ambas fechas están presentes, valida que el rango sea correcto
        if (fechaMin && fechaMax && new Date(fechaMax) < new Date(fechaMin)) {
            toastr.error("La fecha máxima no puede ser menor que la mínima.", "Error");
            return;
        }

        // Si pasa las validaciones, aplica el filtro
        cargarTablaAlum(2);

        toastr.success("Filtro aplicado.", "Éxito");
    });


    /////////////////////////////////////////////
    // QUITAR FILTRO DE FECHA MÍNIMA Y MÁXIMA  //
    /////////////////////////////////////////////

    // Al quitar filtro fechas y volver a solo departamento
    $("#quitarFiltroFecha").click(function() {
        $("#fechaMinimaFiltro").val('');
        $("#fechaMaximaFiltro").val('');
        pickerMin.clear();  // Limpia visual y lógicamente
        pickerMax.clear();
        cargarTablaAlum(1);
        toastr.warning('Filtro de fechas quitado. Mostrando solo departamento.', 'Advertencia');
    });



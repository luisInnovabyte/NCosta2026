
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
    function cargarTablaAlum(modo) {

        let rangoFechas = $('.date-range').val();
        let fechaInicio = "";  // Declarar variables fuera del if
        let fechaFin = "";
        if(modo == '3'){
            
            fechaInicio = '2000-10-10';
            fechaFin = '2100-10-10';
        }else{
            if (rangoFechas.includes(" to ")) {
                let fechas = rangoFechas.split(" to ");
                fechaInicio = fechas[0];
                fechaFin = fechas[1];
    
                console.log("Fecha de inicio:", fechaInicio);
                console.log("Fecha de fin:", fechaFin);
            } else {
                console.log("Solo se ha seleccionado una fecha:", rangoFechas);
                fechaInicio = rangoFechas;
                fechaFin = rangoFechas;
            }
        }
       
        departamento = $("#selectDepartamento").val();
        
        var alumnoLlegadas = $("#alumnosTabla").DataTable({
            pageLength: 5, // Muestra solo 5 registros por página
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
            buttons:[],
            columns: [
                { name: "id" },
                { name: "Nombre", className: "text-center" },
                { name: "G.Amigos", className: "text-center" },
                { name: "Nivel", className: "text-center" },
                { name: "FechaInicio", className: "text-center" },

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
                url: "../../controller/grupos.php?op=mostrarAlumnosNuevos",
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
        alumnoLlegadas.page.len(10).draw();
        alumnoLlegadas.column(0).visible(true);

        $("#alumnosTabla").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

    }
    function cargarTablaCursos(idAlumno) {
        console.log(idAlumno)
        var cursosTabla = $("#cursosTabla").DataTable({
            pageLength: 5, // Muestra solo 5 registros por página
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
            buttons:[],
            columns: [
                { name: "idCurso" },
                { name: "Ruta", className: "text-center" },
                { name: "Codigo", className: "text-center" },
                { name: "Fecha", className: "text-center" },
                { name: "FechaFin", className: "text-center" },
                { name: "Alumnos Apuntados", className: "text-center" },
                { name: "Capacidad", className: "text-center" },
                { name: "idGrupo", className: "text-center" },
                { name: "codGrupo", className: "text-center" }

            ],
            columnDefs: [
                {
                    targets: [0],
                    visible: false, // Oculta la columna ID
                }
              
            ],
            searchBuilder: {
                columns: [1, 2, 3, 4,5,6,7,8], // Ajustado a las columnas existentes
            },
            ajax: {
                url: "../../controller/grupos.php?op=mostrarGrupos",
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
                data: { idAlumno: idAlumno },
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
        cursosTabla.page.len(5).draw();

        $("#cursosTabla").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

    }




    $('#alumnosTabla tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
        // Obtén la instancia de la tabla DataTables
        toastr.info('Alumno seleccionado');

         $('#divAcciones').removeClass('d-none');

        var tabla = $('#alumnosTabla').DataTable();
      
        // Obtén el objeto de datos de la fila actual
        var data = tabla.row(this).data();
        var idAlumno = data[0];
        console.log(idAlumno)
        var codNivelAlum = data[3];

        $('#divCrearCurso').removeClass('d-none');
        $('#textEnCurso').text('');
        $('#cursoSeleccionado').val('');

        $('#codNivel').val(codNivelAlum);

        $('#divCursosTab').addClass('d-none');
        cargarTablaCursos(idAlumno);

        $.get("../../controller/grupos.php", 
            {
                op: "mostrarAlumnoXId",
                idAlumno: idAlumno
            }, 
            function(response) {                
                try {
                    var data = JSON.parse(response);
                    console.log("Datos procesados:", data);
                    idAlumno = data[0]['idAlumno'];
                    nombreAlumno = data[0]['nomAlumno'];
                    apeAlumno = data[0]['apeAlumno'];
                    tokenUsu = data[0]['tokenUsu'];
                    avatar = data[0]['avatarUsu'];
                    $('#adaptacionesDiv').html('');
                    // CURSOS
                    idLlegada = data[0]['id_llegada'];
                    nivelAsignado = data[0]['nivelasignado_llegadas'];
                  
                    $('#idiomaTxt').text(data[0]['descrIdioma']);
                    $('#tipoTxt').text(data[0]['descrTipo']);
                    $('#nivelTxt').text(data[0]['descrNivel']);

                    if(data[0]['agoraAlumno'] == 1){
                        $('#adaptacionesDiv').append('<span class="badge bg-danger-subtle text-danger border border-opacity-25 border-danger">Agorafobia</span>');
                    }
                    if(data[0]['minusvaliaAlumno'] == 1){
                        $('#adaptacionesDiv').append('<span class="badge bg-warning-subtle text-danger border border-opacity-25 border-warning">Discapacidad ♿</span>');
                    }
                    if (data[0]['obsMinusvaliaAlumno']) {
                        $('#adaptacionesDiv').append('<br><span>Otros: ' + data[0]['obsMinusvaliaAlumno'] + '</span> ');
                    }
                    if (data[0]['preferenciaHoraria']) {
                        if (data[0]['preferenciaHoraria'] == 1) {
                            horarioTexto = "Mañanas";
                        } else if (data[0]['preferenciaHoraria'] == 2) {
                            horarioTexto = "Tardes";
                        } else if (data[0]['preferenciaHoraria'] == 0) {
                            horarioTexto = "Sin Preferencias";
                        }
                    
                        $('#adaptacionesDiv').append('<br><span><b>Horario: ' + horarioTexto + '</b></span>');                   
                    }
                    //perfil
                    $('#idAlumno').val(idAlumno);
                    $('#nombreAlumno').text(nombreAlumno+' '+apeAlumno);
                    $('#botonPerfil').attr('href', '../Perfil/?tokenUsuario='+tokenUsu+'');
                    $('#avatarUsu').attr('src', '../../public/assets/images/users/'+avatar+'');

                    // GRUPO AMIGOS
                    $('#grupoAmigos').html('');
                    $('#listaAmigos').html('');

                    
                    if (data[0]['grupoAmigos']) {
                        $('#grupoAmigos').append('<span class="badge bg-info-subtle text-info border border-info">' + data[0]['grupoAmigos'] + '</span>');
                        let grupoAmigosText = data[0]['grupoAmigos'];
                        console.log(grupoAmigosText)
                         // INFORMACION DE AMIGOS //
                        let depaSelect = $('#selectDepartamento').val();
                        $.get("../../controller/grupos.php", 
                            {
                                op: "recogerGrupoAmigos",
                                nombreGrupo: grupoAmigosText,
                                depaSelect:depaSelect
                            }, 
                            function(response) {                
                                try {
                                    var data = JSON.parse(response);
                                    console.log("Datos amigos:", data);
                                 
                                       // Recorrer cada objeto del array
                                       data.forEach(function(item) {
                                           // Crear un párrafo con la información (puedes ajustar qué mostrar)
                                           let preferenciaHorariaTx = "Sin Preferencias"; // Valor por defecto

                                           if (item.preferenciaHoraria == 1) {
                                               preferenciaHorariaTx = "Mañanas";
                                           } else if (item.preferenciaHoraria == 2) {
                                               preferenciaHorariaTx = "Tardes";
                                           }
                                           let contenido = `<span class="badge bg-success-subtle text-black border border-white tx-15">${item.nomAlumno} - ${preferenciaHorariaTx}</span>`;
                                           console.log(contenido);
                                           // Agregarlo al div
                                           $("#listaAmigos").append(`<label>${contenido}</label>`);
                                       });
                                   
                                } catch (error) {
                                    console.error("Error al parsear JSON:", error);
                                }
                            }
                        ).fail(function(jqXHR, textStatus, errorThrown) {
                            console.error("Error en la petición:", textStatus, errorThrown);
                        });
                    }else{
                        $('#grupoAmigos').append('<span class="badge bg-danger-subtle text-danger border border-danger">Sin Grupo de Amigos</span>');

                    }
                      
                         
                        

                        $('#idLlegada').val(idLlegada);
                        $('#nivelAsignado').val(nivelAsignado);



                        // INFORMACION DE LA LLEGADA //
                        $.get("../../controller/grupos.php", 
                            {
                                op: "mostrarLlegadaXId",
                                idLlegada: idLlegada
                            }, 
                            function(response) {                
                                try {
                                    var data = JSON.parse(response);
                                    console.log("Datos procesados:", data);
                                    
                                    // Seleccionar el div donde se van a agregar los elementos
                                    var matriculasDiv = $("#matriculasDiv");
                        
                                    // Limpiar contenido previo si es necesario
                                    matriculasDiv.empty();
                        
                                    // Recorrer cada objeto del array
                                    data.forEach(function(item) {
                                        // Crear un párrafo con la información (puedes ajustar qué mostrar)
                                        function formatoEuropeo(fecha) {
                                            if (!fecha) return ''; // Manejar valores nulos o indefinidos
                                            let partes = fecha.split('-'); // Suponiendo que viene en formato "YYYY-MM-DD"
                                            if (partes.length === 3) {
                                                return `${partes[2]}/${partes[1]}/${partes[0]}`;
                                            }
                                            return fecha; // En caso de otro formato, devolver sin cambios
                                        }
                                        
                                        var contenido = `<span class="badge bg-info-subtle text-info border border-info tx-15">${item.codTarifa_matriculacion}</span> 
                                                         <span class="badge bg-success-subtle text-success border border-success tx-15">${formatoEuropeo(item.fechaInicioMatriculacion)}</span> 
                                                         <span class="badge bg-danger-subtle text-danger border border-danger tx-15">${formatoEuropeo(item.fechaFinMatriculacion)}</span>`;
                                        // Agregarlo al div
                                        $("#matriculasDiv").append(`<p>${contenido}</p>`);
                                    });
                        
                                } catch (error) {
                                    console.error("Error al parsear JSON:", error);
                                }
                            }
                        ).fail(function(jqXHR, textStatus, errorThrown) {
                            console.error("Error en la petición:", textStatus, errorThrown);
                        });
                        
                } catch (error) {
                    console.error("Error al parsear JSON:", error);
                }
            }
        ).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición:", textStatus, errorThrown);
        });
        
        
        $('#divInfoAlumno').removeClass('d-none');
        $('#divAcciones').removeClass('d-none');

        $('#divCursos').removeClass('d-none');
        $('#alertCursos').addClass('d-none');
      });
    
    

      
    $('#cursosTabla tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
        // Obtén la instancia de la tabla DataTables
        var tabla = $('#cursosTabla').DataTable();
        toastr.info('Curso seleccionado');

            
        // Obtén la celda y extrae el texto en lugar del objeto de datos
        var codSeleccionado = tabla.cell(this, 8).node().textContent.trim();
        var rutaCod = tabla.cell(this, 2).node().textContent.trim();

        var idCurso = tabla.cell(this, 7).node().textContent.trim();
        var fechaCursoSelect = tabla.cell(this, 3).node().textContent.trim();
        var rutaVisual = tabla.cell(0, 1).data(); // Fila 0, columna 2
        var capacidadText = tabla.cell(this, 5).node().textContent.trim();

        //PARA EL MODAL DE AULAS
        $('#grupoSeleccionadoEnd').val(codSeleccionado);



        // Asigna los valores a los inputs
        $('#codSeleccionado').val(codSeleccionado);

        $('#cursoSeleccionado').val(idCurso);
        $('#fechaSeleccionado').val(fechaCursoSelect);

        $('#divCursosTab').removeClass('d-none');

        $('#rutaSeleccionada').html(rutaVisual);
        $('#codSelectText').text(rutaCod);
        $('#fecSelectText').text(fechaCursoSelect);
        $('#capacidadText').html(capacidadText);

        $.post('../../controller/grupos.php?op=recogerAlumnosCurso', { codSeleccionado: codSeleccionado}, function(response) {
            let alumnos = JSON.parse(response); // 🔹 Convierte la respuesta a objeto si es necesario
console.log(alumnos)
            let html = '';
                $.each(alumnos, function (index, alumno) {
                    html += `<a href="../Perfil/?tokenUsuario=${alumno.tokenUsu}" target="_blank">
                                <label>
                                    <span class="badge text-info border border-info">${alumno.idLlegada_cursos} - ${alumno.nomAlumno} ${alumno.apeAlumno}</span>
                                </label>
                             </a>`;
                });
                $('#alumnos').html(html);
                if ($('#nombreAulaModal').length === 0) {
                    console.error("El tbody #nombreAulaModal no existe en el DOM.");
                    return;
                }
                
                // 🔹 Crear filas con datos de los alumnos para la tabla
                let htmlModal = '';
                $.each(alumnos, function (index, alumno) {
                    caracteristicasAlum = [];

                    if (alumno.agoraAlumno == 1) {
                        caracteristicasAlum.push("<b class='tx-danger'>Agorofobia</b>");
                    }

                    if (alumno.minusvaliaAlumno == 1) {
                        caracteristicasAlum.push("<b class='tx-warning'>Necesidades especiales</b>");
                    }


                    htmlModal += `<tr>
                                    <td>${alumno.nomAlumno} ${alumno.apeAlumno}</td>
                                    <td>${caracteristicasAlum}</td>
                                    <td>${alumno.obsMinusvaliaAlumno}</td>
                                </tr>`;
                });

                $('#datosAlumnosModal').html(htmlModal); // 🔹 Usar `html()` para evitar duplicados
        });
        $.post('../../controller/grupos.php?op=cargarAulasGrupo', { codSeleccionado: codSeleccionado}, function(response) {
            let aula = JSON.parse(response); // 🔹 Convierte la respuesta a objeto si es necesario
            
            if (aula.length > 0) { // Verifica si el array tiene elementos
                console.log(aula); // Accede al primer objeto del array
                $('#nombreAulaView').text(aula[0].nombreAula);
                $('#locaAulaView').text(aula[0].localizacionAula);
                $('#capaAulaView').text(aula[0].capacidadAula);
                let checkboxes = '';

                if (aula[0].hibridoAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-danger"> Híbrido </label>';
                }
        
                if (aula[0].kidsAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-success"> Kids </label>';
                }
        
                if (aula[0].paraliticosAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-warning"> Paralíticos </label>';
                }
        
                if (aula[0].agoraAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-info"> Agorafobia </label>';
                }

                $('#caraAulaView').html(checkboxes);
                $('#observacionesAula').html(aula[0].nombreAula);

                $('.tablaViewAula').removeClass('d-none');
             
             
            } else {
                $('.tablaViewAula').addClass('d-none');

                console.log("No hay datos en la respuesta.");
            }
         
        });

        $.post('../../controller/grupos.php?op=cargarProfeGrupo', { codSeleccionado: codSeleccionado}, function(response) {
            let profe = JSON.parse(response); // 🔹 Convierte la respuesta a objeto si es necesario
            
            if (profe.length > 0) { // Verifica si el array tiene elementos
                console.log(profe); // Accede al primer objeto del array
                nombreCompleto =  profe[0].nomPersonal+" "+profe[0].apePersonal;

                $('#nombreSeleccionadoProfeView').text(nombreCompleto);
               


                $('.nombreProfeView').removeClass('d-none');
             
             
            } else {
                $('.nombreProfeView').addClass('d-none');

                console.log("No hay datos en la respuesta.");
            }
         
        });
    });
 

    $(document).ready(function () {
 

        // Obtener las fechas desde los atributos del input
        let defaultStartDate = $(".date-range").data("start");
        let defaultEndDate = $(".date-range").data("end");

        // Inicializar Flatpickr
        let picker = $(".date-range").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "es",
            firstDayOfWeek: 1,
            defaultDate: [defaultStartDate, defaultEndDate],
            onClose: function(selectedDates, dateStr, instance) {
                // Si el usuario borra el input, se restablece el valor por defecto
                if (!dateStr) {
                    instance.setDate([defaultStartDate, defaultEndDate]);
                }
            }
        });

        // Prevenir que el input se quede vacío si pierde el foco
        $(".date-range").on("blur", function () {
            if ($(this).val().trim() === "") {
                picker.setDate([defaultStartDate, defaultEndDate]);
            }
        });

        // Capturar el rango seleccionado
        $(".date-range").on("input", function () {
           /*  cargarTablaAlum(); */
        });

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
      
        $("#selectDepartamento").val(1).trigger('change');

        // FUNCIONALIDAD DE FECHAS
          // Definir fechas desde PHP
     

        $("#selectDepartamento").change(function() {
/*             cargarTablaAlum();
 */
        });

        
    
        cargarTablaAlum();

    });


    function crearCurso(){
            Swal.fire({
            title: '¿Estás seguro?',
            text: 'Se va a crear un nuevo grupo. Es posible que ya exista uno con las mismas características.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, añadir',
            cancelButtonText: 'No, cancelar',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {

                    cargando();
                    idAlumno = $('#idAlumno').val();
                    nivelAsig = $('#nivelAsignado').val();
                    if(nivelAsig == ''){
                        toastr.error('Seleccione un nivel');
                        descargando();

                        return;
                    }
                    idLlegada = $('#idLlegada').val();
                    let codNivel = $('#codNivel').val();
                    
                    if(codNivel == ''){
                        toastr.error('Seleccione un nivel');
                        descargando();

                        return;
                    }
                    var fechaActual = new Date().toISOString().split('T')[0].replace(/-/g, ''); 
                    codNivel = codNivel + fechaActual; // Concatena el grupo con la fecha
                    console.log(codNivel);
                    $.post('../../controller/grupos.php?op=crearAlumnosCurso', { idAlumno: idAlumno, nivelAsig: nivelAsig, idLlegada:idLlegada, fechaActual:fechaActual,codNivel:codNivel }, function(response) {
                        descargando();
                        toastr.success('Curso Añadido');
                        var cursosTabla = $('#cursosTabla').DataTable();
                        cursosTabla.ajax.reload(null, false); // false para mantener la página actual

                        var alumnosTabla = $('#alumnosTabla').DataTable();
                        alumnosTabla.ajax.reload(null, false); // false para mantener la página actual

                        /* $('#divCrearCurso').addClass('d-none');
                        $('#textEnCurso').text('En un curso'); */
                    });
                    descargando();

                    var alumnosTabla = $('#alumnosTabla').DataTable();

                    $('#alumnosTabla').DataTable().ajax.reload(null, false);
                     $('#divAcciones').addClass('d-none');
                Swal.fire(
                'Añadido',
                'El grupo se ha añadido correctamente.',
                'success'
                );

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                'Cancelado',
                'El grupo no se ha añadido.',
                'error'
                );
            }
            });
    
    }
    function addCursoAlum(){

        cargando();
        idAlumno = $('#idAlumno').val();
        nivelAsig = $('#nivelAsignado').val();
        if(nivelAsig == ''){
            toastr.error('Seleccione un Nivel');
            descargando();

            return;
        }

        cantidadSeleccionado = $('#cursoSeleccionado').val();
        if(cantidadSeleccionado == ''){
            toastr.error('Seleccione un Grupo');
            descargando();

            return;
        }

        codGrupo = $('#codSeleccionado').val();
        if(codGrupo == ''){
            toastr.error('Seleccione un codigo ERROR.');
            descargando();

            return;
        }
        fechaSeleccionado = $('#fechaSeleccionado').val();
        if(fechaSeleccionado == ''){
            toastr.error('Vacio fechaSeleccionado ERROR.');
            descargando();

            return;
        }

        
        idLlegada = $('#idLlegada').val();
        idDepartamento = $("#selectDepartamento").val();


        
        $.post('../../controller/grupos.php?op=alumnoEnCurso', { idLlegada: idLlegada,idDepartamento:idDepartamento}, function(response) {
          
            // Convertimos la respuesta a número por si llega como texto
            const res = parseInt(response);

            if (res === 1) {
                toastr.error('El Alumno ya pertenece al grupo.', 'Error');
                return; // cancela el resto del flujo
            } else if (res === 0) {
                $.post('../../controller/grupos.php?op=insertarAlumnosCurso', { idAlumno: idAlumno, nivelAsig: nivelAsig, idLlegada:idLlegada, fechaSeleccionado:fechaSeleccionado,cantidadSeleccionado:cantidadSeleccionado,codGrupo:codGrupo }, function(response) {
                    descargando();
                    toastr.success('Alumno añadido al curso','Curso creado');

                    var cursosTabla = $('#cursosTabla').DataTable();
                    cursosTabla.ajax.reload(null, false); // false para mantener la página actual

                    var alumnosTabla = $('#alumnosTabla').DataTable();

                    $('#alumnosTabla').DataTable().ajax.reload(null, false);
                    $('#divAcciones').addClass('d-none');
                    /* $('#divCrearCurso').addClass('d-none');
                    $('#textEnCurso').text('En un curso'); */
                });
                console.log("Todo bien");
           
            } else {
                console.warn("Respuesta desconocida del servidor:", response);
            }

        });


        
          descargando();

    }


    //================================//
    //            CLASES              //
    //================================//

    function seleccionarClases(){
        $('#seleccionarClases').modal('show');


        $('.aulaNoSelectView').removeClass('d-none');
        $('.aulaSelectView').addClass('d-none');




    // Si el DataTable ya está inicializado, solo actualizamos la URL y recargamos los datos
    if ($.fn.DataTable.isDataTable('#aulas_table')) {
        aulas_table.ajax.url("./../controller/grupos.php?op=listarAulas").load();
    } else {
       

        var aulas_table = $("#aulas_table").DataTable({
            select: false, // Nos permite seleccionar filas para exportar
            "hover": true, // Activa el efecto hover

            columns: [
                { name: "idAula" },
                { name: "Nombre" },
                { name: "Localizacion" },
                { name: "Caracteristicas" },
                { name: "Capacidad" },
                { name: "Observación" },
    
            ],
            
            columnDefs: [
                { targets: [0], orderable: true, visible: true }, // Tarifa
                { targets: [1], orderable: true, visible: true }, // Descripción
                { targets: [2], orderable: true, visible: true }, // Importe
                { targets: [3], orderable: true, visible: true }, // IVA
                { targets: [4], orderable: true, visible: true }, // Descuento
                { targets: [5], orderable: true, visible: true }, // Fecha Inicio
  
        
        
            ],
        
            searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
                columns: [0, 1, 2, 3, 4, 5]    
            },
        
            ajax: {
                url: "../../controller/grupos.php?op=listarAulas",
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
        
        aulas_table.page.len(5).draw();

        
        $("#aulas_table").addClass("width-100");

    }
     

    }

    
       
    $('#aulas_table tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
        // Obtén la instancia de la tabla DataTables
        toastr.info('Aula seleccionada');
        $('.aulaNoSelectView').addClass('d-none');
        $('.aulaSelectView').removeClass('d-none');

        var tabla = $('#aulas_table').DataTable();
        $('#nombreAulaModal').text('');
        $('#locaAulaModal').text('');
        $('#capaAulaModal').text('');
        $('#caraAulaModal').html('');
        $('#obsAulaModal').text('');

        // Obtén la celda y extrae el texto en lugar del objeto de datos
        var nombreAula = tabla.cell(this, 1).node().textContent.trim();
        var localizacionAula = tabla.cell(this, 2).node().textContent.trim();
        var capacidadAula = tabla.cell(this, 3).node().textContent.trim();
        var caracteristicasAula = tabla.cell(this, 4).data(); // Fila 0, columna 2
        var idAula = tabla.cell(this, 0).data(); // Fila 0, columna 2

        $('#aulaSeleccionadaEnd').val(idAula);

        var obsAula = tabla.cell(this, 5).node().textContent.trim();

        let capacidadT = parseInt($('#capacidadText').text(), 10);
        let textoA = capacidadT === 1 ? " alumno" : " alumnos";
        $('#totalAlumnosText').text(capacidadT + textoA);
        $('#capacidadModalText').text(capacidadAula);


        $('#nombreAulaModal').text(nombreAula);
        $('#locaAulaModal').text(localizacionAula);
        $('#capaAulaModal').text(capacidadAula);
        $('#caraAulaModal').html(caracteristicasAula);
        $('#obsAulaModal').text(obsAula);

        
    });

    
    function asignarAulaCurso(){

   
        aulaSeleccionada = $('#aulaSeleccionadaEnd').val();
        grupoSeleccionado = $('#grupoSeleccionadoEnd').val();
        if (aulaSeleccionada === null || aulaSeleccionada === '') {
            toastr.error('Por favor, recargue la página.', 'Error de Validación');
            return; // Salir de la función
        }
        if (grupoSeleccionado === null || grupoSeleccionado === '') {
            toastr.error('Por favor, recargue la página.', 'Error de Validación');
            return; // Salir de la función 
        }

        $.post('../../controller/grupos.php?op=insertarAulaGrupo', { aulaSeleccionada: aulaSeleccionada, grupoSeleccionado: grupoSeleccionado }, function(response) {
          
            toastr.success('Aula asignada al grupo','Aula Asignada');
            
            $('#nombreAulaView').text('');
            $('#locaAulaView').text('');
            $('#capaAulaView').text('');
            $('#caraAulaView').html('');
            $('#obsAulaView').text('');
            $('#seleccionarClases').modal('hide');
            $('#nombreAulaView').text($('#nombreAulaModal').text());
            $('#locaAulaView').text($('#locaAulaModal').text());
            $('#capaAulaView').text($('#capaAulaModal').text());
            $('#caraAulaView').html($('#caraAulaModal').html());
            $('#obsAulaView').text($('#obsAulaModal').text());
    
            $('.tablaViewAula').removeClass('d-none');

        });

    }

    
    function seleccionarProfesor(){
        $('#seleccionarProfesor').modal('show');
        $('.viewSelectProfe').addClass('d-none');



    // Si el DataTable ya está inicializado, solo actualizamos la URL y recargamos los datos
    if ($.fn.DataTable.isDataTable('#personal_table')) {
        personal_table.ajax.url("./../controller/grupos.php?op=listarPersonal").load();
        } else {
    
        var idRuta = $('#nivelAsignado').val(); // Reemplázalo con el valor dinámico que necesites

        var personal_table = $("#personal_table").DataTable({
            ordering: true,
            order: [[1, "asc"]], // Orden por nombre
            columns: [
                { name: "idPersonal", className: 'secundariaDef' },
                { name: "nombrePersonal", width: "8%" },
                { name: "direccionPersonal" },
                { name: "telefonoPersonal" },
                { name: "emailPersonal" },
            ],
            columnDefs: [
                { targets: [0], orderable: true, visible: false },
                { targets: [1], orderable: true, visible: true },
                { targets: [2], orderable: true, visible: true },
                { targets: [3], orderable: true, visible: true },
                { targets: [4], orderable: true, visible: true }
            ],
            ajax: {
                url: "../../controller/grupos.php?op=listarPersonal",
                type: "GET",
                dataType: "json",
                cache: false,
                serverSide: true,
                processData: true,
                data: function (d) {
                    d.idRuta = idRuta; // Agregamos el parámetro
                },
                beforeSend: function () {},
                complete: function (data) {},
                error: function (e) { console.log("Error en la carga de datos:", e); }
            }
        });
        
        personal_table.page.len(5).draw();

        
            $("#personal_table").addClass("width-100");

        }



    }

     
    // AULAS SELECT PROFESOR
    $('#personal_table tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
        // Obtén la instancia de la tabla DataTables
        toastr.info('Profesor Seleccionado');
        $('.viewSelectProfe').removeClass('d-none');
        var tabla = $('#personal_table').DataTable();
    

        // Obtén la celda y extrae el texto en lugar del objeto de datos
        var idProfesor = tabla.cell(this, 0).node().textContent.trim();
        var nombreProfesor = tabla.cell(this, 1).node().textContent.trim();

        $('#nombreSeleccionadoProfe').text(nombreProfesor);
        $('#idProfesorSeleccionado').val(idProfesor);
    });

    function asignarProfesor(){
        idProfesorSeleccionado = $('#idProfesorSeleccionado').val();

        if (idProfesorSeleccionado === null || idProfesorSeleccionado === '') {
            toastr.error('Por favor, recargue la página.', 'Error de Validación');
            return; // Salir de la función
        }
        grupoSeleccionado = $('#grupoSeleccionadoEnd').val();
       
        if (grupoSeleccionado === null || grupoSeleccionado === '') {
            toastr.error('Por favor, recargue la página.', 'Error de Validación');
            return; // Salir de la función 
        }

        $.post('../../controller/grupos.php?op=insertarProfesorGrupo', { idProfesorSeleccionado: idProfesorSeleccionado,grupoSeleccionado:grupoSeleccionado}, function(response) {
          
            toastr.success('Profesor asignado al grupo','Profesor Asignado');
            $('#seleccionarProfesor').modal('hide');

            $('#nombreSeleccionadoProfeView').text($('#nombreSeleccionadoProfe').text());
            $('.nombreProfeView').removeClass('d-none');

        });

    }

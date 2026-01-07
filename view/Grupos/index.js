
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
    // Desactivar temporalmente los botones de transferencia
  /*   function desactivarTransferencia() {
        console.log('Desactivando');
        $('.move, .remove, .moveAll, .removeAll').prop('disabled', true);
    }

    // Activar nuevamente los botones de transferencia
    function activarTransferencia() {
        $('.move, .remove, .moveAll, .removeAll').prop('disabled', false);
    } */
    var cursosTabla;
    function cargarTablaCursosTodos() {
        idioma = $("#selectIdioma").val();
        curso = $("#selectCurso").val();

        console.log("Actualizando tabla con idioma:", idioma, "y curso:", curso);

         cursosTabla = $("#cursosTabla").DataTable({
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
           
            columns: [
                { name: "idCurso" },
                { name: "Ruta", className: "text-center" },
                { name: "Codigo", className: "text-center" },
                { name: "Fecha", className: "text-center" },
                { name: "FechaFin", className: "text-center" },
                { name: "Alumnos Apuntados", className: "text-center" },
                { name: "Capacidad", className: "text-center" },
                { name: "idGrupo", className: "text-center" },
                { name: "codGrupo", className: "text-center" },
                { name: "BotonesAulas", className: "text-center" },
                { name: "idRuta", className: "d-none" },
                { name: "codIdioma", className: "d-none"},
                { name: "codTipoCurso", className: "d-none" },
                { name: "idNumIdioma", className: "d-none"},
                { name: "idNumcodTipoCurso", className: "d-none" }
            ],
            columnDefs: [
                { targets: 0, visible: false }, // Oculta la columna ID
                { targets: 1, width: "150px" }, // Ruta
                { targets: 2, width: "100px" }, // Código
                { targets: 3, width: "80px" }, // Fecha
                { targets: 4, width: "60px" }, // Alumnos Apuntados
                { targets: 5, width: "60px" }, // Alumnos Apuntados
                { targets: 6, width: "80px" }, // Capacidad
                { targets: 7, width: "60px" }, // idGrupo
                { targets: 8, width: "100px" }, // codGrupo
                { targets: 9, width: "120px" }, // BotonesAulas
                { targets: [10, 11, 12, 13,14], visible: false } // Oculta estas columnas
            ],
            searchBuilder: {
                columns: [1, 2, 3, 4,5,6,7,8,9,10,11,12], // Ajustado a las columnas existentes
            },
            ajax: {
                url: "../../controller/grupos.php?op=mostrarGruposGeneral",
                type: "POST",
                data: function (d) {
                    d.idioma = $("#selectIdioma").val();
                    d.curso = $("#selectCurso").val();
                },
                dataType: "json",
                cache: false,
                serverSide: true,
               
                beforeSend: function () {
                    console.log("Actualizando tabla con idioma:", idioma, "y curso:", curso);

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
        cursosTabla.page.len(10).draw();

      

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
    cargarTablaCursosTodos();
   

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
                            <a href="../Llegadas/?tokenPreinscripcion=${alumno.tokenUsu}" target="_blank" class="btn btn-sm btn-outline-primary radius-15">Ver Llegada</a>
                        </div>
                    </div>
                </div>
            `;
            container.append(card);
        });
    });

}


// ALUMNO
if($('#rolUsuInput').val() == '3'){
    $(document).ready(function () {
        $.post("../../controller/llegadas.php?op=llegadasUsu", function(data) {
            console.log(data)

            if (data === '[]') {

                console.log('No hay datos');
                var html = `
                   <div class="card border-light shadow-sm rounded-3" style="background-color: #fff;">
                        <div class="card-body">
                            <h5 class=" mb-0" style="color: #888; font-style: italic;">Sin Docencias disponibles</h5>
                        </div>
                    </div>

                    <small>Si has contratado un curso y este no aparece, por favor, contacta con el personal administrativo.</small>
                `;

                $("#departamentosDiv").append(html);
                return; // Salir de la función
            }else if (data == 'only') {

               
                window.location.href = '../MisCursos';
            }else if (data == '') {

                console.log('Respuesta vacía');
                return;
            } else {

                try {
                    var llegadasUsu = jQuery.parseJSON(data); // Intenta parsear el JSON
                    console.log(llegadasUsu); // Asegúrate de que es el formato esperado
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                }
            }
            
            for (var x of llegadasUsu) {

                pintar_departamentos(x);

            }

            function pintar_departamentos(x) {
                console.log(x);
            

                var html = `
                    <div  id="${x.iddepartamento_llegadas}" onclick="seleccionarLlegada(${x.id_llegada})" class="card  wd-500 card-hover shadow-none border radius-15">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <!-- Columna para el icono -->
                                <div class="col-auto">
                                    <div class="fm-icon-box rounded-circle bg-warning text-dark">
                                        <i class="bi bi-building"></i>
                                    </div>
                                </div>
                                <!-- Columna para el texto -->
                                <div class="col text-center">
                                    <h6 class="mt-3 mb-0">Matrícula ${x.id_llegada} - ${x.nombreDepartamento}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $("#departamentosDiv").append(html);

            }

            depa = $('#depaSelect').val();
            $('#' + depa).css('background-color', '#A8E6A3'); // Aplica el color al elemento seleccionado

        });

    });

        
    // seleccionar llegada
    function seleccionarLlegada(llegadaSelect){
        console.log(llegadaSelect);
        $.post("../../controller/llegadas.php?op=guardarDatosLlegada",{llegadaSelect:llegadaSelect}, function(data) {
            var jsonData = JSON.parse(data); // Convierte la cadena JSON en un objeto
            console.log(jsonData);

            if(jsonData == 0){
                toastr.error('La llegada no está disponible.');
            }else if(jsonData == 1){
                console.log(jsonData);
            Swal.fire({
                    title: '¡Departamento seleccionado!',
                    text: 'Revise el menú izquierdo. La página se recargará en breve.',
                    icon: 'success',
                    timer: 3000,                // Tiempo que la alerta permanecerá visible (4 segundos)
                    showConfirmButton: false,   // Ocultar el botón de confirmación
                    allowOutsideClick: false,   // Evita cerrar haciendo clic fuera de la alerta
                    allowEscapeKey: false,      // Evita cerrar usando la tecla ESC
                    allowEnterKey: false,       // Evita cerrar usando la tecla ENTER
                    timerProgressBar: true      // Muestra una barra de progreso mientras se cuenta el tiempo
                });
                cargando();
                        // Recargar la página después de 3 segundos (3000 milisegundos)
                setTimeout(function() {
                    window.location = "../MisCursos";
                }, 4000); 
            }

        });
    }
}

if($('#rolUsuInput').val() == '2'){

// PROFESOR
$(document).ready(function () {
    //recogemos departamentos del usuario
 
    $.post("../../controller/personal_Edu.php?op=recogerDepaPersonalxId", function(data) {
        console.log(data)

        if (data === '[]') {
            console.log('No hay datos');
            var html = `
                <div class="card border-light shadow-sm rounded-3" style="background-color: #fff;">
                    <div class="card-body">
                        <h5 class=" mb-0" style="color: #888; font-style: italic;">Error, no se encontraron departamentos.</h5>
                    </div>
                </div>

                <small>Si no aparece ningún departamento, por favor, contacta con el personal administrativo.</small>
            `;

            $("#departamentosDivProfe").append(html);
            return; // Salir de la función
        }else if (data == 'only') {
           window.location.href = '../GestionActividades';
        }else if (data == '') {
            console.log('Respuesta vacía');
            var html = `
                <div class="card shadow-none border radius-15">
                    <div class="card-body">
                    
                        <h5 class="mt-3 mb-0">Error, no encontrado departamentos.</h5>
                    
                    </div>
                </div>
            `;

            $("#departamentosDivProfe").append(html);
            return;
        } else {
            try {
                var llegadasUsu = jQuery.parseJSON(data); // Intenta parsear el JSON
                console.log(llegadasUsu); // Asegúrate de que es el formato esperado
            } catch (e) {
                console.error('Error al parsear JSON:', e);
            }
        }
        
        for (var x of llegadasUsu) {

            pintar_departamentos(x);

        }

        function pintar_departamentos(x) {
            console.log(x);
           

            var html = `
                <div id="${x.idDepartamentoEdu}" onclick="seleccionarDepaTrabajador(${x.idDepartamentoEdu}, '${x.nombreDepartamento}', '${x.colorDepartamento.trim()}')"
                    class="card card-hover shadow-none border radius-15 card-active wd-500">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <!-- Columna para el icono -->
                            <div class="col-auto">
                                <div class="fm-icon-box rounded-circle bg-warning text-dark">
                                    <i class="bi bi-building"></i>
                                </div>
                            </div>
                            <!-- Columna para el texto -->
                            <div class="col text-center">
                                <h6 class="mt-3 mb-0">${x.nombreDepartamento}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                `;

        

            $("#departamentosDivProfe").append(html);

        }


        depa = $('#depaSelect').val();
        $('#' + depa).css('background-color', '#A8E6A3'); // Aplica el color al elemento seleccionado
    });

  
});

     // seleccionar llegada
     function seleccionarDepaTrabajador(depaSelect,nombreDepartamento,colorDepartamento){
        console.log(depaSelect);
        console.log(nombreDepartamento);
        console.log(colorDepartamento);

        $.post("../../controller/personal_Edu.php?op=guardarDatosDepartamento",{depaSelect:depaSelect,nombreDepartamento:nombreDepartamento,colorDepartamento:colorDepartamento}, function(data) {
        
          
            Swal.fire({
                    title: '¡'+data+' seleccionado!',
                    text: 'Revise el menú izquierdo. La página se recargará en breve.',
                    icon: 'success',
                    timer: 4000,                // Tiempo que la alerta permanecerá visible (4 segundos)
                    showConfirmButton: false,   // Ocultar el botón de confirmación
                    allowOutsideClick: false,   // Evita cerrar haciendo clic fuera de la alerta
                    allowEscapeKey: false,      // Evita cerrar usando la tecla ESC
                    allowEnterKey: false,       // Evita cerrar usando la tecla ENTER
                    timerProgressBar: true      // Muestra una barra de progreso mientras se cuenta el tiempo
                });
                
                        // Recargar la página después de 3 segundos (3000 milisegundos)
                setTimeout(function() {
                    location.reload();
                }, 4000); 
         

        });
    }

}

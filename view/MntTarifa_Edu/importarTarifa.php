<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Excel/CSV con Dropzone.js</title>

    <!-- Incluye Dropzone desde CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

    <style>
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            padding: 50px;
            max-width: 500px;
            margin: 50px auto;
        }

        .resultado {
            padding: 10px;
            background-color: #f4f4f4;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .resultado p {
            margin: 0;
            padding: 5px;
        }
        #loader {
    display: none;
    text-align: center;
    margin-top: 20px;
    font-weight: bold;
}
.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
    margin: 10px auto;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
    </style>
</head>

<body>

    <h1>Subir archivo Excel/CSV</h1>

    <!-- Formulario Dropzone -->
    <form action="error/upload.php" class="dropzone" id="myDropzone"></form>
<div id="loader">
    <div class="spinner"></div>
    Procesando archivo, puede tardar unos minutos, por favor espera...
</div>
    <!-- Sección donde se mostrarán los mensajes y resultados -->
    <div id="resultado" class="resultado"></div>

    <script>
        function obtenerFechaActual() {
            var fecha = new Date();
            var año = fecha.getFullYear();
            var mes = ('0' + (fecha.getMonth() + 1)).slice(-2); // Mes en formato 2 dígitos
            var dia = ('0' + fecha.getDate()).slice(-2); // Día en formato 2 dígitos
            return año + '-' + mes + '-' + dia;
        }
        // Inicializar Dropzone
       Dropzone.options.myDropzone = {
            paramName: "file",
            addRemoveLinks: true,
            maxFiles: 1,
            maxFilesize: 5,
            acceptedFiles: ".csv",
            dictDefaultMessage: "Arrastra tu archivo CSV aquí o haz click para subirlo",
            dictRemoveFile: "Eliminar archivo",
            dictMaxFilesExceeded: "Solo puedes subir 1 archivo",

            init: function() {
                var resultadoDiv = document.getElementById('resultado');
                var loader = document.getElementById('loader');

                this.on("sending", function(file, xhr, formData) {
                    // Mostrar el loader cuando empieza a subir/procesar
                    loader.style.display = "block";
                    resultadoDiv.innerHTML = "";
                });

                this.on("success", function(file, response) {
                    // Ocultar loader al terminar y mostrar resultado
                    loader.style.display = "none";
                    resultadoDiv.innerHTML = "<p><strong>Archivo subido correctamente:</strong></p><pre>" 
                                            + JSON.stringify(response, null, 2) + "</pre>";
                });

                this.on("error", function(file, response) {
                    loader.style.display = "none";
                    resultadoDiv.innerHTML = "<p><strong>Error al subir el archivo:</strong></p><p>" + response + "</p>";
                });

                this.on("removedfile", function() {
                    loader.style.display = "none";
                    resultadoDiv.innerHTML = "";
                });
            }
        };
    </script>

</body>

</html>
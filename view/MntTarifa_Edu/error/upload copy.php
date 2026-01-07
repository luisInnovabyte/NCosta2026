<?php
require_once("../../../config/conexion.php");
require_once("../../../config/funciones.php");
require_once("../../../models/TarifaAloja_Edu.php");

$tarifa = new TarifaAloja();





if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $fileName = basename($_FILES['file']['name']);

    // Obtener la fecha actual en formato 'yyyy-mm-dd'
    $currentDate = date('Y-m-d');

    // Separar el nombre del archivo y la extensión
    $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME); // Nombre base del archivo (sin la extensión)
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // Extensión del archivo

    // Generar la ruta completa con el nombre del archivo, fecha, y extensión
    $uploadFile = $uploadDir . $fileBaseName . "_" . $currentDate . '.' . $fileExtension;

    // Verificamos si el archivo es CSV
    $fileExtension = pathinfo($uploadFile, PATHINFO_EXTENSION);
    if ($fileExtension !== 'csv') {
        echo "Por favor sube un archivo CSV.";
        exit;
    }

    // Mover el archivo subido a la carpeta "uploads"
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        // Procesar el archivo CSV
       if (($handle = fopen($uploadFile, "r")) !== FALSE) {
        // Saltar la fila de encabezados
        fgetcsv($handle, 1000, ";"); 

        $rowNumber = 1;
        $fechaHoraActual = date('Y-m-d H:i:s');
        while (($data = fgetcsv($archivo, 1000, ";")) !== FALSE) {
                echo "Columna 1: " . $data[0] . " | Columna 2: " . $data[1] . "<br>";
            }
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            // Saltar filas vacías o basura
            if ($rowNumber === 1 && $data[0] === "ID") {
                $rowNumber++;
                continue;
            }
            if (count($data) < 11 || trim($data[0]) === '') {
                continue;
            }
        $fechaHoraActual = date('Y-m-d H:i:s');

          /*   $tarifa->insertarTarifaExcel($data, $fechaHoraActual);  */
            $rowNumber++;
        }

        fclose($handle);
    } else {
            echo "Error al abrir el archivo CSV.";
        }
    } else {
        echo "Error al mover el archivo.";
    }
} else {
    echo "Error en la subida del archivo.";
}

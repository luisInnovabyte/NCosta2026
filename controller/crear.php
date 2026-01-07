<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$json_string = json_encode('sad');
$file = 'Crear.json';

$result = file_put_contents($file, $json_string);

if ($result === false) {
    echo "Error: No se pudo crear el archivo.";
} else {
    echo "Archivo creado con éxito.";
}
?>

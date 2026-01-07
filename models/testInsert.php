<?php
// Fichero testinsert.php
// Este fichero se encarga de probar la inserción de un usuario en la base de datos 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Conectar.php';
require_once 'Alojamientos.php';

$alojamientos = new Alojamientos();

//$prod = $producto->insert_producto("pollo frito", 2, "2025-05-12");
$alojamiento = $alojamientos-> insertarVisitas("vdtyj11gn1309b336c4d90a3cea2e51", "Alejandro", "2025-03-23", "Ejemplo de texto");
if ($alojamiento !== false) {
    // Primera forma de mostrar los usuarios
    /*    foreach ($usuarios as $usuario) {
        echo "ID: " . $usuario['id'] . "<br>";
        echo "Nombre: " . $usuario['nombre'] . "<br>";
        echo "Teléfono: " . $usuario['telefono'] . "<br>";
        echo "Email: " . $usuario['email'] . "<br>";
        echo "<hr>";
    }*/
    // Segunda forma de mostrar los usuarios
    print_r('<pre>');
    print_r($alojamiento);
    print_r('</pre>');
} else {
    echo "Error al mostrar el adjunto";
}

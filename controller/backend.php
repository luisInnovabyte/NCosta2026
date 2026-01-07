<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root1234";
$pass = "prueba1234";
$db   = "test";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$sql = "SELECT * FROM `clientes`";
$result = $conexion->query($sql);
   $json_string = json_encode($result);
        $file = 'aaaa.json';
        file_put_contents($file, $json_string);
$usuarios = [];

while ($fila = $result->fetch_assoc()) {
    $usuarios[] = $fila;
}

echo json_encode($usuarios);
<?php
require_once("../../../config/conexion.php");
require_once("../../../config/funciones.php");
require_once("../../../models/TarifaAloja_Edu.php");

$tarifa = new TarifaAloja();

if (isset($_FILES['file'])) {
    $tmpName = $_FILES['file']['tmp_name'];

    // Leer solo las primeras 5 líneas
    $lines = [];
    $handle = fopen($tmpName, "r");
    $maxLines = 5;
    $i = 0;
    while (($line = fgets($handle)) !== false && $i < $maxLines) {
        $lines[] = trim($line);
        $i++;
    }
    fclose($handle);

    // Detectar delimitador (cuenta comas vs punto y coma)
    $delimiterGuess = "desconocido";
    if (!empty($lines)) {
        $firstLine = $lines[0];
        $commas = substr_count($firstLine, ",");
        $semicolons = substr_count($firstLine, ";");

        if ($semicolons > $commas) {
            $delimiterGuess = ";";
        } elseif ($commas > $semicolons) {
            $delimiterGuess = ",";
        }
    }

    // Mostrar preview
    echo "<h3>Preview de tu archivo:</h3>";
    echo "<pre>";
    foreach ($lines as $l) {
        echo htmlspecialchars($l) . "\n";
    }
    echo "</pre>";

    echo "<p><strong>Delimitador detectado:</strong> " . htmlspecialchars($delimiterGuess) . "</p>";

    // Intentar parsear con fgetcsv usando el delimitador detectado
    if ($delimiterGuess !== "desconocido") {
        echo "<h3>Tabla interpretada (primeras 5 filas):</h3>";
        echo "<table border='1' cellpadding='5'>";
        $handle = fopen($tmpName, "r");
        $maxRows = 5;
        $rowCount = 0;
        while (($data = fgetcsv($handle, 1000, $delimiterGuess, '"')) !== FALSE && $rowCount < $maxRows) {
            echo "<tr>";
            foreach ($data as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
            $rowCount++;
        }
        fclose($handle);
        echo "</table>";
    }

    // 🔽 --- NUEVA PARTE: inserción en la BD ---
    echo "<h3>Proceso de inserción en BD:</h3>";

    $fechaHoraActual = date('Y-m-d H:i:s');

    $handle = fopen($tmpName, "r");

    // Saltamos encabezados
    $headers = fgetcsv($handle, 1000, $delimiterGuess, '"');

    $insertadas = 0;
    $saltadas = 0;

    while (($data = fgetcsv($handle, 1000, $delimiterGuess, '"')) !== FALSE) {
        // Validación mínima: que tenga al menos 12 columnas y no esté vacío
        if (count($data) >= 12 && !empty($data[0])) {
            $tarifa->insertarTarifaExcel2($data, $fechaHoraActual);
            echo "✔ Insertada tarifa ID: <strong>" . htmlspecialchars($data[0]) . "</strong>, Código: <strong>" . htmlspecialchars($data[1]) . "</strong><br>";
            $insertadas++;
        } else {
            echo "⚠ Fila saltada (datos incompletos): " . htmlspecialchars(implode(" | ", $data)) . "<br>";
            $saltadas++;
        }
    }

    fclose($handle);

    echo "<p><strong>Total insertadas:</strong> $insertadas</p>";
    echo "<p><strong>Total saltadas:</strong> $saltadas</p>";
}
?>
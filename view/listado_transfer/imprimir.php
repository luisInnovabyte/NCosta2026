<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Transfers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 11px;
        }
        .bg-danger { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; color: #000; }
        .bg-info { background-color: #0dcaf0; color: #000; }
        .bg-primary { background-color: #0d6efd; }
        .bg-secondary { background-color: #6c757d; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Listado de Transfers</h1>
        <p>Fecha de generación: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">ID Llegada</th>
                <th class="text-center">Fecha y Hora</th>
                <th>Lugar</th>
                <th>Quién Recoge</th>
                <th>Alumno</th>
                <th class="text-center">Clasificación</th>
                <th class="text-center">Departamento</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Incluir configuración y modelo
            require_once("../../config/conexion.php");
            require_once("../../models/Listado_transfer.php");

            $transferModel = new Listado_transfer();
            $transfers = $transferModel->listarTransfers();

            if (!empty($transfers)) {
                foreach ($transfers as $transfer) {
                    // Formatear fecha
                    $fechaFormateada = '';
                    if (!empty($transfer['fechallegada_llegadas'])) {
                        $fecha = new DateTime($transfer['fechallegada_llegadas']);
                        $fechaFormateada = $fecha->format('d/m/Y H:i');
                    }

                    // Determinar clase del badge según clasificación
                    $badgeClass = 'bg-secondary';
                    switch($transfer['clasificacion_transfer']) {
                        case 'HOY':
                            $badgeClass = 'bg-danger';
                            break;
                        case 'MAÑANA':
                            $badgeClass = 'bg-warning';
                            break;
                        case 'PRÓXIMO':
                            $badgeClass = 'bg-info';
                            break;
                        case 'ESTA SEMANA':
                            $badgeClass = 'bg-primary';
                            break;
                        case 'FUTURO':
                            $badgeClass = 'bg-secondary';
                            break;
                    }

                    echo "<tr>";
                    echo "<td class='text-center'>" . htmlspecialchars($transfer['id_llegada']) . "</td>";
                    echo "<td class='text-center'>" . htmlspecialchars($fechaFormateada) . "</td>";
                    echo "<td>" . htmlspecialchars($transfer['lugarllegada_llegadas']) . "</td>";
                    echo "<td>" . htmlspecialchars($transfer['quienrecogealumno_llegadas']) . "</td>";
                    echo "<td>" . htmlspecialchars($transfer['alumno_nombre_completo']) . "</td>";
                    echo "<td class='text-center'><span class='badge " . $badgeClass . "'>" . htmlspecialchars($transfer['clasificacion_transfer']) . "</span></td>";
                    echo "<td class='text-center'>" . htmlspecialchars($transfer['departamento_nombre']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No hay transfers disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">Imprimir</button>
        <button onclick="window.close()">Cerrar</button>
    </div>
</body>
</html>

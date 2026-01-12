<?php
/**
 * Controlador para generar PDF de Transfers agrupados por departamento
 */

// Mostrar errores para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../config/conexion.php");
require_once("../models/Listado_transfer.php");

$listado = new Listado_transfer();
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    case "listar":
        $datos = $listado->listarTransfers();
        
        // Debug
        echo "<!-- Total registros: " . count($datos) . " -->\n";
        
        // Agrupar datos por departamento
        $datosPorDepartamento = [];
        foreach ($datos as $row) {
            $dept = !empty($row['departamento_nombre']) ? $row['departamento_nombre'] : 'Sin departamento';
            if (!isset($datosPorDepartamento[$dept])) {
                $datosPorDepartamento[$dept] = [];
            }
            $datosPorDepartamento[$dept][] = $row;
        }
        
        // Debug
        echo "<!-- Departamentos encontrados: " . count($datosPorDepartamento) . " -->\n";
        foreach ($datosPorDepartamento as $dept => $items) {
            echo "<!-- Dept: " . $dept . " = " . count($items) . " registros -->\n";
        }
        
        // Ordenar departamentos alfabéticamente
        ksort($datosPorDepartamento);
        
        // Generar HTML
        $html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Transfers por Departamento</title>
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
            .no-print {
                display: none !important;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 9pt;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #1AA3E8;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #1AA3E8;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 10pt;
        }
        
        .dept-header {
            margin-top: 25px;
            margin-bottom: 10px;
            padding: 10px;
            background: linear-gradient(135deg, #1AA3E8 0%, #0066CC 100%);
            color: white;
            border-radius: 5px;
        }
        .dept-header h3 {
            margin: 0;
            font-size: 14pt;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead {
            background: linear-gradient(135deg, #1AA3E8 0%, #0066CC 100%);
            color: white;
        }
        th {
            padding: 10px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9pt;
            border: 1px solid #fff;
        }
        td {
            padding: 8px 6px;
            border: 1px solid #ddd;
            font-size: 9pt;
        }
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #e8f4fd;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .badge {
            padding: 4px 8px;
            border-radius: 3px;
            color: white;
            font-size: 8pt;
            font-weight: bold;
            display: inline-block;
        }
        .badge-hoy { background-color: #dc3545; }
        .badge-mañana { background-color: #ffc107; color: #333; }
        .badge-próximo { background-color: #17a2b8; }
        .badge-esta { background-color: #007bff; }
        .badge-futuro { background-color: #6c757d; }
        .badge-pasado { background-color: #343a40; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Listado de Transfers por Departamento</h1>
        <p>Fecha de generación: ' . date('d/m/Y H:i') . '</p>
        <p>Total de transfers: ' . count($datos) . '</p>
    </div>';
        
        // Generar tabla por cada departamento
        foreach ($datosPorDepartamento as $departamento => $transfers) {
            $cantidadDept = count($transfers);
            
            $html .= '
    <div class="dept-header">
        <h3>📍 ' . htmlspecialchars($departamento) . ' <span style="font-size: 11pt; font-weight: normal;">(' . $cantidadDept . ' transfer' . ($cantidadDept != 1 ? 's' : '') . ')</span></h3>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">ID</th>
                <th style="width: 12%;" class="text-center">Fecha/Hora</th>
                <th style="width: 18%;">Lugar</th>
                <th style="width: 15%;">Quién Recoge</th>
                <th style="width: 20%;">Alumno</th>
                <th style="width: 10%;" class="text-center">Clasificación</th>
                <th style="width: 20%;">Contacto</th>
            </tr>
        </thead>
        <tbody>';
            
            foreach ($transfers as $row) {
                // Formatear fecha y hora
                $fechaHora = '-';
                if (!empty($row['fechallegada_llegadas'])) {
                    $fechaObj = DateTime::createFromFormat('Y-m-d H:i:s', $row['fechallegada_llegadas']);
                    $fechaHora = $fechaObj ? $fechaObj->format('d/m/Y H:i') : '-';
                }
                
                // Clasificación badge
                $clasificacion = $row['clasificacion_transfer'] ?? 'FUTURO';
                $badgeClass = 'badge-' . strtolower(explode(' ', $clasificacion)[0]);
                $clasificacionHtml = "<span class='badge {$badgeClass}'>" . htmlspecialchars($clasificacion) . "</span>";
                
                // Contacto
                $contactos = [];
                if (!empty($row['prescriptor_telefono'])) {
                    $contactos[] = '☎ ' . htmlspecialchars($row['prescriptor_telefono']);
                }
                if (!empty($row['prescriptor_movil'])) {
                    $contactos[] = '📱 ' . htmlspecialchars($row['prescriptor_movil']);
                }
                $contactoHtml = !empty($contactos) ? implode('<br>', $contactos) : '-';
                
                $html .= '
            <tr>
                <td class="text-center">' . htmlspecialchars($row['id_llegada']) . '</td>
                <td class="text-center">' . $fechaHora . '</td>
                <td>' . htmlspecialchars($row['lugarllegada_llegadas'] ?? '-') . '</td>
                <td>' . htmlspecialchars($row['quienrecogealumno_llegadas'] ?? '-') . '</td>
                <td>' . htmlspecialchars($row['alumno_nombre_completo'] ?? '-') . '</td>
                <td class="text-center">' . $clasificacionHtml . '</td>
                <td>' . $contactoHtml . '</td>
            </tr>';
            }
            
            $html .= '
        </tbody>
    </table>';
        }
        
        $html .= '
</body>
</html>';
        
        echo $html;
        break;
        
    default:
        echo json_encode(array("error" => "Operación no válida"));
        break;
}

<?php
require_once "../config/conexion.php";
require_once "../models/Listado_criticos_llegadas.php";

$modelo = new Listado_criticos_llegadas();

switch ($_GET["op"]) {
    
    case "listar":
        try {
            // Obtener todas las alertas críticas
            $datos = $modelo->listarAlertasCriticas();
            
            // Calcular estadísticas
            $total = count($datos);
            $vencidos = 0;
            $criticos = 0;
            $urgentes = 0;
            $totalPendiente = 0;
            
            foreach ($datos as $row) {
                $totalPendiente += floatval($row['pago_pendiente']);
                switch ($row['nivel_alerta']) {
                    case 'VENCIDO': $vencidos++; break;
                    case 'CRÍTICO': $criticos++; break;
                    case 'URGENTE': $urgentes++; break;
                }
            }
            
            // Configurar headers para PDF
            header('Content-Type: text/html; charset=utf-8');
            
            // Generar HTML para PDF
            $html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Alertas Críticas de Pago</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm 1cm;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
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
            border-bottom: 3px solid #DC143C;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #DC143C;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header .subtitle {
            color: #666;
            margin: 5px 0;
            font-size: 12px;
        }
        .header .date {
            color: #888;
            margin: 5px 0;
            font-size: 10px;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: #DC143C;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .print-button:hover {
            background-color: #8B0000;
        }
        
        .summary {
            margin-top: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #DC143C;
            display: flex;
            justify-content: space-around;
        }
        .summary-item {
            text-align: center;
        }
        .summary-item .value {
            font-size: 18px;
            font-weight: bold;
            color: #DC143C;
            display: block;
        }
        .summary-item .label {
            font-size: 9px;
            color: #666;
            display: block;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead {
            background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);
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
            font-size: 8.5pt;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 7.5pt;
            white-space: nowrap;
            display: inline-block;
        }
        .badge-vencido { background: #8B0000; color: white; }
        .badge-crítico { background: #DC143C; color: white; }
        .badge-urgente { background: #FF4500; color: white; }
        .badge-importante { background: #FFA500; color: white; }
        .badge-aviso { background: #FFD700; color: #333; }
        .badge-normal { background: #32CD32; color: white; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-danger { color: #dc3545; font-weight: bold; }
        .text-warning { color: #ffc107; font-weight: bold; }
        .text-success { color: #28a745; font-weight: bold; }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 2px solid #ddd;
            padding-top: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            font-style: italic;
            font-size: 14px;
        }
    </style>
    <script>
        function imprimirPDF() {
            window.print();
        }
    </script>
</head>
<body>
    <button class="print-button no-print" onclick="imprimirPDF()">
        🖨️ Imprimir / Guardar como PDF
    </button>
    
    <div class="header">
        <h1>📋 Listado de Alertas Críticas de Pago</h1>
        <p class="subtitle">Llegadas con pagos pendientes ordenadas por fecha de inicio de curso</p>
        <p class="date">Generado el ' . date('d/m/Y H:i:s') . '</p>
    </div>';
            
            if ($total > 0) {
                // Resumen estadístico
                $html .= '
    <div class="summary no-print">
        <div class="summary-item">
            <span class="value">' . $total . '</span>
            <span class="label">Total Alertas</span>
        </div>
        <div class="summary-item">
            <span class="value">' . $vencidos . '</span>
            <span class="label">Vencidos</span>
        </div>
        <div class="summary-item">
            <span class="value">' . $criticos . '</span>
            <span class="label">Críticos</span>
        </div>
        <div class="summary-item">
            <span class="value">' . $urgentes . '</span>
            <span class="label">Urgentes</span>
        </div>
        <div class="summary-item">
            <span class="value">' . number_format($totalPendiente, 2) . '€</span>
            <span class="label">Total Pendiente</span>
        </div>
    </div>';
                
                // Agrupar datos por departamento
                $datosPorDepartamento = [];
                foreach ($datos as $row) {
                    $dept = $row['departamento_nombre'];
                    if (!isset($datosPorDepartamento[$dept])) {
                        $datosPorDepartamento[$dept] = [];
                    }
                    $datosPorDepartamento[$dept][] = $row;
                }
                
                // Ordenar departamentos alfabéticamente
                ksort($datosPorDepartamento);
                
                // Generar tabla por cada departamento
                foreach ($datosPorDepartamento as $departamento => $llegadas) {
                    $cantidadDept = count($llegadas);
                    
                    $html .= '
    <div style="margin-top: 25px; margin-bottom: 10px; padding: 10px; background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%); color: white; border-radius: 5px;">
        <h3 style="margin: 0; font-size: 14pt;">📍 ' . htmlspecialchars($departamento) . ' <span style="font-size: 11pt; font-weight: normal;">(' . $cantidadDept . ' registro' . ($cantidadDept != 1 ? 's' : '') . ')</span></h3>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">ID</th>
                <th style="width: 8%;" class="text-center">Grupo</th>
                <th style="width: 10%;" class="text-center">Fecha Curso</th>
                <th style="width: 25%;">Prescriptor</th>
                <th style="width: 12%;" class="text-center">Nivel</th>
                <th style="width: 6%;" class="text-center">Días</th>
                <th style="width: 12%;" class="text-right">Pendiente</th>
                <th style="width: 8%;" class="text-center">% Pago</th>
                <th style="width: 14%;">Contacto</th>
            </tr>
        </thead>
        <tbody>';
                    
                    foreach ($llegadas as $row) {
                        // Formatear fecha
                        $fecha = '-';
                        if (!empty($row['fecha_inicio_curso'])) {
                            $fechaObj = DateTime::createFromFormat('Y-m-d H:i:s', $row['fecha_inicio_curso']);
                            $fecha = $fechaObj ? $fechaObj->format('d/m/Y') : '-';
                        }
                        
                        // Nivel alerta badge
                        $nivel = htmlspecialchars($row['nivel_alerta']);
                        $badgeClass = 'badge-' . strtolower($nivel);
                        $nivelHtml = "<span class='badge {$badgeClass}'>{$nivel}</span>";
                        
                        // Días hasta inicio
                        $dias = intval($row['dias_hasta_inicio']);
                        $diasHtml = $dias;
                        if ($dias < 0) {
                            $diasHtml = "<span class='text-danger'>⚠️ " . abs($dias) . "</span>";
                        } elseif ($dias <= 3) {
                            $diasHtml = "<span class='text-danger'>{$dias}</span>";
                        } elseif ($dias <= 7) {
                            $diasHtml = "<span class='text-warning'>{$dias}</span>";
                        }
                        
                        // Porcentaje pago
                        $porcentaje = floatval($row['porcentaje_pago']);
                        $clasePorc = $porcentaje >= 80 ? 'text-success' : ($porcentaje >= 50 ? 'text-warning' : 'text-danger');
                        $porcentajeHtml = "<span class='{$clasePorc}'>" . number_format($porcentaje, 2) . "%</span>";
                        
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
                <td class="text-center">' . htmlspecialchars($row['grupo_llegadas'] ?? '-') . '</td>
                <td class="text-center">' . $fecha . '</td>
                <td>' . htmlspecialchars($row['prescriptor_nombre_completo']) . '</td>
                <td class="text-center">' . $nivelHtml . '</td>
                <td class="text-center">' . $diasHtml . '</td>
                <td class="text-right"><strong>' . number_format(floatval($row['pago_pendiente']), 2) . ' €</strong></td>
                <td class="text-center">' . $porcentajeHtml . '</td>
                <td style="font-size: 7.5pt;">' . $contactoHtml . '</td>
            </tr>';
                    }
                    
                    $html .= '
        </tbody>
    </table>';
                }
            } else {
                $html .= '
    <div class="no-data">
        <p>⚠️ No hay alertas críticas en este momento</p>
    </div>';
            }
            
            $html .= '
    <div class="footer">
        <p><strong>NCosta - Sistema de Gestión Educativa</strong></p>
        <p>Total de registros: ' . $total . ' | Generado: ' . date('d/m/Y H:i:s') . '</p>
    </div>
</body>
</html>';
            
            echo $html;
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al generar el listado: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;
    
    case "obtener_datos":
        try {
            // Obtener datos para el DataTable
            $datos = $modelo->listarAlertasCriticas();
            
            echo json_encode([
                'success' => true,
                'data' => $datos
            ], JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener datos: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;
}
?>

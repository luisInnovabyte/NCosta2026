<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alertas Críticas de Pago</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #DC143C;
        }
        
        .header h1 {
            color: #DC143C;
            font-size: 20pt;
            margin-bottom: 5px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 11pt;
        }
        
        .header .date {
            color: #888;
            font-size: 9pt;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
            font-size: 9pt;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tbody tr:hover {
            background-color: #f0f0f0;
        }
        
        .nivel-vencido {
            background-color: #8B0000;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            font-size: 8pt;
        }
        
        .nivel-critico {
            background-color: #DC143C;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            font-size: 8pt;
        }
        
        .nivel-urgente {
            background-color: #FF4500;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            font-size: 8pt;
        }
        
        .nivel-importante {
            background-color: #FFA500;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            font-size: 8pt;
        }
        
        .nivel-aviso {
            background-color: #FFD700;
            color: #333;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            font-size: 8pt;
        }
        
        .nivel-normal {
            background-color: #32CD32;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            font-size: 8pt;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-danger {
            color: #dc3545;
            font-weight: bold;
        }
        
        .text-warning {
            color: #ffc107;
            font-weight: bold;
        }
        
        .text-success {
            color: #28a745;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #888;
            font-size: 8pt;
        }
        
        .summary-box {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .summary-box h3 {
            color: #DC143C;
            font-size: 12pt;
            margin-bottom: 10px;
        }
        
        .summary-stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .stat-item {
            text-align: center;
            flex: 1;
            min-width: 120px;
        }
        
        .stat-value {
            font-size: 18pt;
            font-weight: bold;
            color: #DC143C;
        }
        
        .stat-label {
            font-size: 9pt;
            color: #666;
            margin-top: 5px;
        }
        
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            
            .no-print {
                display: none;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        
        .btn-print {
            background: #DC143C;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 11pt;
            margin: 20px auto;
            display: block;
        }
        
        .btn-print:hover {
            background: #8B0000;
        }
    </style>
</head>
<body>
    <?php
    require_once('../../config/templates/sesion.php');
    require_once("../../config/conexion.php");
    require_once("../../models/Listado_criticos_llegadas.php");
    
    // Verificar sesión manualmente sin redireccionar
    if (!isset($_SESSION['usu_rol']) || $_SESSION['usu_rol'] != '1') {
        die('Acceso denegado. Esta página requiere permisos de administrador.');
    }
    
    // Usar el modelo para obtener datos
    $modelo = new Listado_criticos_llegadas();
    
    // Obtener todas las alertas críticas ordenadas por fecha de inicio de curso
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
            case 'VENCIDO':
                $vencidos++;
                break;
            case 'CRÍTICO':
                $criticos++;
                break;
            case 'URGENTE':
                $urgentes++;
                break;
        }
    }
    ?>
    
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            🖨️ Imprimir / Guardar como PDF
        </button>
    </div>
    
    <div class="header">
        <h1>📋 Listado de Alertas Críticas de Pago</h1>
        <p class="subtitle">Llegadas con pagos pendientes ordenadas por fecha de inicio de curso</p>
        <p class="date">Generado el: <?php echo date('d/m/Y H:i'); ?></p>
    </div>
    
    <div class="summary-box">
        <h3>📊 Resumen Ejecutivo</h3>
        <div class="summary-stats">
            <div class="stat-item">
                <div class="stat-value"><?php echo $total; ?></div>
                <div class="stat-label">Total de Alertas</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo $vencidos; ?></div>
                <div class="stat-label">Vencidos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo $criticos; ?></div>
                <div class="stat-label">Críticos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo $urgentes; ?></div>
                <div class="stat-label">Urgentes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo number_format($totalPendiente, 2); ?>€</div>
                <div class="stat-label">Total Pendiente</div>
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 6%;">ID</th>
                <th style="width: 8%;">Grupo</th>
                <th style="width: 8%;">Fecha Curso</th>
                <th style="width: 18%;">Prescriptor</th>
                <th style="width: 10%;">Nivel</th>
                <th style="width: 7%;">Días</th>
                <th style="width: 10%;">Pendiente</th>
                <th style="width: 7%;">% Pago</th>
                <th style="width: 12%;">Departamento</th>
                <th style="width: 14%;">Contacto</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($datos)): ?>
                <tr>
                    <td colspan="10" class="text-center">No hay alertas críticas en este momento</td>
                </tr>
            <?php else: ?>
                <?php foreach ($datos as $row): ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($row['id_llegada']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['grupo_llegadas'] ?? '-'); ?></td>
                        <td class="text-center">
                            <?php 
                            if (!empty($row['fecha_inicio_curso'])) {
                                $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row['fecha_inicio_curso']);
                                echo $fecha ? $fecha->format('d/m/Y') : '-';
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['prescriptor_nombre_completo']); ?></td>
                        <td class="text-center">
                            <?php
                            $nivel = htmlspecialchars($row['nivel_alerta']);
                            $claseNivel = 'nivel-' . strtolower($nivel);
                            echo "<span class='{$claseNivel}'>{$nivel}</span>";
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            $dias = intval($row['dias_hasta_inicio']);
                            $clase = '';
                            if ($dias < 0) {
                                $clase = 'text-danger';
                                echo "<span class='{$clase}'>⚠️ {$dias}</span>";
                            } elseif ($dias <= 3) {
                                $clase = 'text-danger';
                                echo "<span class='{$clase}'>{$dias}</span>";
                            } elseif ($dias <= 7) {
                                $clase = 'text-warning';
                                echo "<span class='{$clase}'>{$dias}</span>";
                            } else {
                                echo $dias;
                            }
                            ?>
                        </td>
                        <td class="text-right">
                            <strong><?php echo number_format(floatval($row['pago_pendiente']), 2); ?> €</strong>
                        </td>
                        <td class="text-center">
                            <?php
                            $porcentaje = floatval($row['porcentaje_pago']);
                            if ($porcentaje >= 80) {
                                $clase = 'text-success';
                            } elseif ($porcentaje >= 50) {
                                $clase = 'text-warning';
                            } else {
                                $clase = 'text-danger';
                            }
                            echo "<span class='{$clase}'>" . number_format($porcentaje, 2) . "%</span>";
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['departamento_nombre']); ?></td>
                        <td style="font-size: 8pt;">
                            <?php 
                            $contacto = [];
                            if (!empty($row['prescriptor_telefono'])) {
                                $contacto[] = '📞 ' . htmlspecialchars($row['prescriptor_telefono']);
                            }
                            if (!empty($row['prescriptor_movil'])) {
                                $contacto[] = '📱 ' . htmlspecialchars($row['prescriptor_movil']);
                            }
                            echo implode('<br>', $contacto);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p><strong>NCosta - Sistema de Gestión Educativa</strong></p>
        <p>Este documento contiene información confidencial. Úselo únicamente para fines internos.</p>
    </div>
</body>
</html>

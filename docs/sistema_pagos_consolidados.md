# 📊 Sistema de Pagos Consolidados - Guía de Implementación

## 📋 Descripción General

Este documento describe cómo implementar un módulo completo para visualizar todos los pagos de un usuario consolidados por conceptos.

---

## 🗄️ Base de Datos

### Vista Creada: `view_pagos_consolidados`

**Ubicación del script:** `BD/vista_pagos_consolidados.sql`

**Campos principales:**
- `id_pago` - ID único del pago
- `concepto_tipo` - Tipo de concepto (Pago Anticipado, Matrícula, etc.)
- `concepto_detalle` - Detalle específico del concepto
- `id_llegada` - ID de la llegada asociada
- `id_prescriptor` - ID del usuario/prescriptor
- `nombre_completo` - Nombre completo del usuario
- `importe` - Monto del pago
- `fecha_pago` - Fecha del pago
- `medio_pago` - Método de pago utilizado
- `observaciones` - Notas adicionales
- `estado` - Estado del pago (activo/inactivo)

**Ejecutar:** Importar el archivo SQL en la base de datos.

---

## 🔧 Backend - Modelo PHP

### Crear: `models/PagosConsolidados.php`

```php
<?php
require '../config/conexion.php';

class PagosConsolidados
{
    public function __construct()
    {
    }

    // Listar todos los pagos de una llegada
    public function listarPagosPorLlegada($idLlegada)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT * FROM view_pagos_consolidados WHERE id_llegada = :idLlegada ORDER BY fecha_pago DESC";
        $query = $db->prepare($sql);
        $query->bindParam(':idLlegada', $idLlegada);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar todos los pagos de un prescriptor
    public function listarPagosPorPrescriptor($idPrescriptor)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT * FROM view_pagos_consolidados WHERE id_prescriptor = :idPrescriptor ORDER BY fecha_pago DESC";
        $query = $db->prepare($sql);
        $query->bindParam(':idPrescriptor', $idPrescriptor);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener totales de pagos por llegada
    public function obtenerTotalesPorLlegada($idLlegada)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT 
                    COUNT(*) as total_pagos,
                    SUM(importe) as total_importe,
                    concepto_tipo,
                    COUNT(DISTINCT medio_pago) as medios_utilizados
                FROM view_pagos_consolidados 
                WHERE id_llegada = :idLlegada
                GROUP BY concepto_tipo";
        
        $query = $db->prepare($sql);
        $query->bindParam(':idLlegada', $idLlegada);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener pagos por rango de fechas
    public function listarPagosPorFechas($fechaInicio, $fechaFin, $idPrescriptor = null)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT * FROM view_pagos_consolidados 
                WHERE fecha_pago BETWEEN :fechaInicio AND :fechaFin";
        
        if ($idPrescriptor) {
            $sql .= " AND id_prescriptor = :idPrescriptor";
        }
        
        $sql .= " ORDER BY fecha_pago DESC";
        
        $query = $db->prepare($sql);
        $query->bindParam(':fechaInicio', $fechaInicio);
        $query->bindParam(':fechaFin', $fechaFin);
        
        if ($idPrescriptor) {
            $query->bindParam(':idPrescriptor', $idPrescriptor);
        }
        
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Reporte de pagos agrupados por medio de pago
    public function reportePorMedioPago($idLlegada = null)
    {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT 
                    medio_pago,
                    COUNT(*) as cantidad_transacciones,
                    SUM(importe) as total_importe
                FROM view_pagos_consolidados";
        
        if ($idLlegada) {
            $sql .= " WHERE id_llegada = :idLlegada";
        }
        
        $sql .= " GROUP BY medio_pago ORDER BY total_importe DESC";
        
        $query = $db->prepare($sql);
        
        if ($idLlegada) {
            $query->bindParam(':idLlegada', $idLlegada);
        }
        
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
```

---

## 🎮 Backend - Controlador

### Crear: `controller/pagosConsolidados.php`

```php
<?php
require_once("../models/PagosConsolidados.php");

$pagosConsolidados = new PagosConsolidados();

$op = $_GET["op"] ?? '';

switch ($op) {
    case "listarPorLlegada":
        $idLlegada = $_POST["idLlegada"] ?? 0;
        $datos = $pagosConsolidados->listarPagosPorLlegada($idLlegada);
        
        $data = [];
        foreach ($datos as $row) {
            $sub_array = [];
            $sub_array[] = $row["concepto_tipo"];
            $sub_array[] = $row["concepto_detalle"];
            $sub_array[] = number_format($row["importe"], 2, ',', '.') . ' €';
            $sub_array[] = date('d/m/Y', strtotime($row["fecha_pago"]));
            $sub_array[] = $row["medio_pago"];
            $sub_array[] = $row["observaciones"];
            $data[] = $sub_array;
        }
        
        echo json_encode($data);
        break;

    case "listarPorPrescriptor":
        $idPrescriptor = $_POST["idPrescriptor"] ?? 0;
        $datos = $pagosConsolidados->listarPagosPorPrescriptor($idPrescriptor);
        echo json_encode($datos);
        break;

    case "obtenerTotales":
        $idLlegada = $_POST["idLlegada"] ?? 0;
        $datos = $pagosConsolidados->obtenerTotalesPorLlegada($idLlegada);
        echo json_encode($datos);
        break;

    case "listarPorFechas":
        $fechaInicio = $_POST["fechaInicio"] ?? '';
        $fechaFin = $_POST["fechaFin"] ?? '';
        $idPrescriptor = $_POST["idPrescriptor"] ?? null;
        
        $datos = $pagosConsolidados->listarPagosPorFechas($fechaInicio, $fechaFin, $idPrescriptor);
        echo json_encode($datos);
        break;

    case "reporteMedioPago":
        $idLlegada = $_POST["idLlegada"] ?? null;
        $datos = $pagosConsolidados->reportePorMedioPago($idLlegada);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
?>
```

---

## 🎨 Frontend - Vista HTML

### Crear: `view/PagosConsolidados/index.php`

```php
<?php
require_once("../../config/conexion.php");
require_once("../../models/Permisos.php");

// Verificar permisos de usuario aquí
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos Consolidados</title>
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4><i class="fa-solid fa-file-invoice-dollar"></i> Historial de Pagos Consolidados</h4>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>ID Llegada:</label>
                                <input type="number" id="filtroIdLlegada" class="form-control" placeholder="Filtrar por llegada">
                            </div>
                            <div class="col-md-3">
                                <label>Fecha Inicio:</label>
                                <input type="date" id="filtroFechaInicio" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Fecha Fin:</label>
                                <input type="date" id="filtroFechaFin" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button id="btnFiltrar" class="btn btn-success w-100">
                                    <i class="fa-solid fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>

                        <!-- Resumen de Totales -->
                        <div class="row mb-3" id="resumenTotales" style="display: none;">
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h5>Total Pagos</h5>
                                        <h3 id="totalCantidad">0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h5>Total Importe</h5>
                                        <h3 id="totalImporte">0,00 €</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h5>Medios de Pago</h5>
                                        <h3 id="totalMedios">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de Pagos -->
                        <div class="table-responsive">
                            <table id="tablaPagosConsolidados" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Detalle</th>
                                        <th>Importe</th>
                                        <th>Fecha</th>
                                        <th>Medio Pago</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="2" class="text-end">TOTAL:</td>
                                        <td id="footerTotal">0,00 €</td>
                                        <td colspan="3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../public/js/jquery-3.6.0.min.js"></script>
    <script src="../../public/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/js/jquery.dataTables.min.js"></script>
    <script src="../../public/js/dataTables.bootstrap5.min.js"></script>
    <script src="index.js"></script>
</body>
</html>
```

---

## 📜 Frontend - JavaScript

### Crear: `view/PagosConsolidados/index.js`

```javascript
$(document).ready(function() {
    let tabla;

    // Inicializar DataTable
    function inicializarTabla(idLlegada = null) {
        if (tabla) {
            tabla.destroy();
        }

        tabla = $('#tablaPagosConsolidados').DataTable({
            ajax: {
                url: '../../controller/pagosConsolidados.php?op=listarPorLlegada',
                type: 'POST',
                data: function(d) {
                    d.idLlegada = idLlegada || $('#filtroIdLlegada').val();
                },
                dataSrc: ''
            },
            columns: [
                { data: 0 }, // Concepto
                { data: 1 }, // Detalle
                { data: 2, className: 'text-end' }, // Importe
                { data: 3, className: 'text-center' }, // Fecha
                { data: 4 }, // Medio Pago
                { data: 5 } // Observaciones
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            footerCallback: function(row, data, start, end, display) {
                let api = this.api();
                let total = 0;

                // Calcular total
                api.column(2, { search: 'applied' }).data().each(function(value) {
                    let numero = parseFloat(value.replace(/[€.\s]/g, '').replace(',', '.'));
                    if (!isNaN(numero)) {
                        total += numero;
                    }
                });

                $('#footerTotal').html(total.toLocaleString('es-ES', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + ' €');
            },
            pageLength: 25,
            order: [[3, 'desc']] // Ordenar por fecha descendente
        });
    }

    // Cargar totales
    function cargarTotales(idLlegada) {
        $.ajax({
            url: '../../controller/pagosConsolidados.php?op=obtenerTotales',
            type: 'POST',
            data: { idLlegada: idLlegada },
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    let totalPagos = 0;
                    let totalImporte = 0;

                    data.forEach(item => {
                        totalPagos += parseInt(item.total_pagos);
                        totalImporte += parseFloat(item.total_importe);
                    });

                    $('#totalCantidad').text(totalPagos);
                    $('#totalImporte').text(totalImporte.toLocaleString('es-ES', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' €');
                    
                    $('#resumenTotales').fadeIn();
                }
            }
        });
    }

    // Botón filtrar
    $('#btnFiltrar').on('click', function() {
        let idLlegada = $('#filtroIdLlegada').val();
        
        if (idLlegada) {
            inicializarTabla(idLlegada);
            cargarTotales(idLlegada);
        } else {
            toastr.warning('Por favor, introduce un ID de llegada');
        }
    });

    // Inicializar tabla vacía
    inicializarTabla();
});
```

---

## 🚀 Instrucciones de Implementación

1. **Base de Datos:**
   - Ejecutar `BD/vista_pagos_consolidados.sql`
   - Verificar que la vista se creó correctamente

2. **Backend:**
   - Crear `models/PagosConsolidados.php`
   - Crear `controller/pagosConsolidados.php`

3. **Frontend:**
   - Crear carpeta `view/PagosConsolidados/`
   - Crear `index.php` e `index.js`

4. **Menú:**
   - Agregar enlace en el menú principal del sistema

---

## 🔮 Extensiones Futuras

La vista puede extenderse para incluir:

- ✅ Pagos de matrículas específicas
- ✅ Pagos de alojamiento
- ✅ Pagos de suplidos
- ✅ Pagos de visados
- ✅ Pagos de transfers
- ✅ Cualquier otro concepto de pago

Para agregar más conceptos, simplemente añadir más `UNION` en la vista SQL.

---

## 📊 Reportes Adicionales Sugeridos

1. **Reporte por periodo:**
   - Filtro por mes/año
   - Gráficos de tendencias

2. **Reporte por método de pago:**
   - Distribución de pagos por medio
   - Análisis de preferencias

3. **Exportación:**
   - PDF para impresión
   - Excel para análisis

4. **Dashboard:**
   - Tarjetas con totales
   - Gráficos interactivos
   - Comparativas mensuales

---

**Fecha de creación:** 09/01/2026  
**Autor:** Sistema NCosta2026  
**Versión:** 1.0

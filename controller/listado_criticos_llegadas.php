<?php
/**
 * Controlador para Listado de Llegadas Críticas
 * Gestiona las alertas de pago pendiente según urgencia
 * 
 * Operaciones disponibles:
 * - listar: Obtiene todas las alertas ordenadas por urgencia
 * - listarPorNivel: Filtra alertas por nivel específico
 * - listarPorDepartamento: Filtra alertas por departamento
 * - obtenerDetalle: Obtiene detalle de una alerta específica
 * - obtenerResumen: Obtiene resumen estadístico de alertas
 * - obtenerTopUrgentes: Obtiene las alertas más urgentes
 */

require_once("../config/conexion.php");
require_once("../models/Listado_criticos_llegadas.php");

$listado = new Listado_criticos_llegadas();

// Obtener la operación solicitada
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    
    /**
     * Listar todas las alertas críticas
     * Retorna JSON con todas las alertas ordenadas por urgencia
     */
    case "listar":
        $datos = $listado->listarAlertasCriticas();
        
        // Formatear la respuesta para DataTables
        $response = array(
            "data" => $datos
        );
        
        echo json_encode($response);
        break;

    /**
     * Listar alertas por nivel de alerta
     * Parámetro GET: nivel (VENCIDO, CRÍTICO, URGENTE, IMPORTANTE, AVISO, NORMAL)
     */
    case "listarPorNivel":
        $nivel = isset($_GET["nivel"]) ? $_GET["nivel"] : '';
        
        if (empty($nivel)) {
            echo json_encode(array(
                "error" => true,
                "mensaje" => "Debe especificar un nivel de alerta",
                "data" => []
            ));
            break;
        }
        
        $datos = $listado->listarPorNivel($nivel);
        
        $response = array(
            "data" => $datos,
            "nivel" => $nivel
        );
        
        echo json_encode($response);
        break;

    /**
     * Listar alertas por departamento
     * Parámetro GET: departamento
     */
    case "listarPorDepartamento":
        $departamento = isset($_GET["departamento"]) ? $_GET["departamento"] : '';
        
        if (empty($departamento)) {
            echo json_encode(array(
                "error" => true,
                "mensaje" => "Debe especificar un departamento",
                "data" => []
            ));
            break;
        }
        
        $datos = $listado->listarPorDepartamento($departamento);
        
        $response = array(
            "data" => $datos,
            "departamento" => $departamento
        );
        
        echo json_encode($response);
        break;

    /**
     * Obtener detalle de una alerta específica
     * Parámetro GET: id_llegada
     */
    case "obtenerDetalle":
        $id_llegada = isset($_GET["id_llegada"]) ? intval($_GET["id_llegada"]) : 0;
        
        if ($id_llegada <= 0) {
            echo json_encode(array(
                "error" => true,
                "mensaje" => "ID de llegada inválido"
            ));
            break;
        }
        
        $datos = $listado->obtenerDetalle($id_llegada);
        
        echo json_encode($datos);
        break;

    /**
     * Obtener resumen de alertas
     * Para dashboard o indicadores
     */
    case "obtenerResumen":
        $datos = $listado->obtenerResumen();
        
        echo json_encode($datos);
        break;

    /**
     * Obtener top alertas más urgentes
     * Parámetro GET opcional: limite (default: 10)
     */
    case "obtenerTopUrgentes":
        $limite = isset($_GET["limite"]) ? intval($_GET["limite"]) : 10;
        
        $datos = $listado->obtenerTopUrgentes($limite);
        
        $response = array(
            "data" => $datos,
            "limite" => $limite
        );
        
        echo json_encode($response);
        break;

    /**
     * Operación no válida
     */
    default:
        echo json_encode(array(
            "error" => true,
            "mensaje" => "Operación no válida. Operaciones disponibles: listar, listarPorNivel, listarPorDepartamento, obtenerDetalle, obtenerResumen, obtenerTopUrgentes"
        ));
        break;
}
?>

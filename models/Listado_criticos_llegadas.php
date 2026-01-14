<?php

class Listado_criticos_llegadas extends Conectar
{   
    /**
     * Obtener todas las alertas de pago críticas
     * Consulta la vista view_llegadas_alertas_pago
     * 
     * @return array Lista de todas las alertas ordenadas por urgencia
     */
    public function listarAlertasCriticas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT 
                    id_llegada,
                    idprescriptor_llegadas,
                    grupo_llegadas,
                    fecha_inicio_curso,
                    estLlegada,
                    prescriptor_nombre_completo,
                    prescriptor_email,
                    prescriptor_telefono,
                    prescriptor_movil,
                    prescriptor_pais,
                    prescriptor_nacionalidad,
                    departamento_nombre,
                    agente_nombre,
                    total_matriculaciones,
                    total_alojamientos,
                    total_transfer_llegada,
                    total_transfer_regreso,
                    total_suplidos,
                    total_general,
                    total_pagos_realizados,
                    pago_pendiente,
                    porcentaje_pago,
                    dias_hasta_inicio,
                    nivel_alerta,
                    color_alerta,
                    prioridad,
                    mensaje_alerta,
                    porcentaje_pendiente,
                    clasificacion_monto,
                    score_urgencia,
                    prescriptor_token,
                    alumno_token
                FROM view_llegadas_alertas_pago
                ORDER BY fecha_inicio_curso ASC, prioridad ASC";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener alertas filtradas por nivel de alerta
     * 
     * @param string $nivel Nivel de alerta (VENCIDO, CRÍTICO, URGENTE, IMPORTANTE, AVISO, NORMAL)
     * @return array Lista de alertas del nivel especificado
     */
    public function listarPorNivel($nivel)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT * FROM view_llegadas_alertas_pago 
                WHERE nivel_alerta = :nivel
                ORDER BY prioridad ASC, score_urgencia ASC";
        
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener alertas por departamento
     * 
     * @param string $departamento Nombre del departamento
     * @return array Lista de alertas del departamento
     */
    public function listarPorDepartamento($departamento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT * FROM view_llegadas_alertas_pago 
                WHERE departamento_nombre = :departamento
                ORDER BY prioridad ASC, score_urgencia ASC";
        
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':departamento', $departamento, PDO::PARAM_STR);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener detalles de una alerta específica
     * 
     * @param int $id_llegada ID de la llegada
     * @return array Detalles de la alerta
     */
    public function obtenerDetalle($id_llegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT * FROM view_llegadas_alertas_pago 
                WHERE id_llegada = :id_llegada";
        
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':id_llegada', $id_llegada, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener resumen de alertas por nivel
     * Para dashboard o indicadores
     * 
     * @return array Resumen estadístico de alertas
     */
    public function obtenerResumen()
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT 
                    COUNT(*) as total_alertas,
                    SUM(CASE WHEN nivel_alerta = 'VENCIDO' THEN 1 ELSE 0 END) as vencidos,
                    SUM(CASE WHEN nivel_alerta = 'CRÍTICO' THEN 1 ELSE 0 END) as criticos,
                    SUM(CASE WHEN nivel_alerta = 'URGENTE' THEN 1 ELSE 0 END) as urgentes,
                    SUM(CASE WHEN nivel_alerta = 'IMPORTANTE' THEN 1 ELSE 0 END) as importantes,
                    SUM(CASE WHEN nivel_alerta = 'AVISO' THEN 1 ELSE 0 END) as avisos,
                    SUM(pago_pendiente) as monto_total_pendiente,
                    AVG(porcentaje_pendiente) as promedio_pendiente
                FROM view_llegadas_alertas_pago";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener top alertas más urgentes
     * 
     * @param int $limite Número de registros a retornar
     * @return array Top alertas más urgentes
     */
    public function obtenerTopUrgentes($limite = 10)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT * FROM view_llegadas_alertas_pago 
                ORDER BY score_urgencia ASC
                LIMIT :limite";
        
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':limite', $limite, PDO::PARAM_INT);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php

class Listado_transfer extends Conectar
{   
    /**
     * Obtener todos los transfers de llegadas
     * Consulta la vista vista_transfer
     * 
     * @return array Lista de todos los transfers
     */
    public function listarTransfers()
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT 
                    id_llegada,
                    idprescriptor_llegadas,
                    fechallegada_llegadas,
                    horallegada_llegadas,
                    lugarllegada_llegadas,
                    quienrecogealumno_llegadas,
                    grupo_llegadas,
                    estLlegada,
                    prescriptor_nombre,
                    prescriptor_apellidos,
                    alumno_nombre_completo,
                    prescriptor_email,
                    prescriptor_telefono,
                    prescriptor_movil,
                    prescriptor_pais,
                    prescriptor_token,
                    alumno_token,
                    alumno_usuario,
                    alumno_email,
                    departamento_nombre,
                    agente_nombre,
                    dias_hasta_llegada,
                    clasificacion_transfer
                FROM vista_transfer
                ORDER BY fechallegada_llegadas ASC, horallegada_llegadas ASC";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
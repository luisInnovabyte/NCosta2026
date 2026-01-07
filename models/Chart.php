<?php
require_once '../config/conexion.php';
require_once '../config/funciones.php';

class Chart extends Conectar
{
    public function getLlamadasxcomercial()
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "SELECT comercialid, nombrecomercial, COUNT(idllamadas) AS c_llamadas_total 
                    FROM c_llamadas 
                    GROUP BY comercialid, nombrecomercial";

            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Puedes registrar el error aquí si tienes un método para ello
            // error_log("Error en getLlamadasxcomercial: " . $e->getMessage());
            return ["error" => "Error en gráfico: " . $e->getMessage()];
        }
    }

    public function getLlamadasxdia()
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "SELECT fechaLlamada, COUNT(fechaLlamada) AS c_llamadas_total 
                    FROM c_llamadas 
                    GROUP BY fechaLlamada 
                    ORDER BY fechaLlamada";

            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Error en gráfico diario: " . $e->getMessage()];
        }
    }
}
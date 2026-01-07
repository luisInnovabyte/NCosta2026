<?php

class Conectar
{
    protected $dbh;

    protected function Conexion()
    {
        try {
            $Json_conf = __DIR__ . '/conexion.json';

            if (!file_exists($Json_conf)) {
                throw new Exception("Error: El archivo de configuración no existe: " . $Json_conf);
            }

            $json = file_get_contents($Json_conf);
            $config = json_decode($json, true);

            if ($config === null) {
                throw new Exception("Error: No se pudo parsear el archivo de configuración JSON");
            }

            // Leer configuración del JSON
            $dbHost = $config['host'];
            $dbPort = isset($config['port']) ? $config['port'] : '3306';
            $dbName = $config['database'];
            $dbUser = $config['user'];
            $dbPassword = $config['password'];

            $conectar = $this->dbh = new PDO(
                "mysql:host=" . $dbHost . ";port=" . $dbPort . ";dbname=" . $dbName,
                $dbUser,
                $dbPassword
            );

            return $conectar;

        } catch (PDOException $e) {
            echo "¡Error BD 1!: " . $e->getMessage() . "<br/>";
            die();
        } catch (Exception $e) {
            echo "¡Error BD 2!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }
}

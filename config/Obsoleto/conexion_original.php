<?php

class Conectar
{
    protected $dbh;

    protected function Conexion()
    {
        try {
            try {

                
                // Obtener el dominio completo (por ejemplo, "costavalencia.efeuno.com.es")
                $dominioCompleto = $_SERVER['HTTP_HOST'];
                
                // Dividir el dominio por los puntos
                $partes = explode('.', $dominioCompleto);

                // Calcular el número total de partes
                $totalPartes = count($partes);

                // Determinar el dominio principal
                if ($totalPartes > 2) {
                    // Tomar las dos últimas partes como dominio principal (por ejemplo, "com.es")
                    $dominioPrincipal = $partes[$totalPartes - 2] . '.' . $partes[$totalPartes - 1];

                    // Tomar todo lo anterior como subdominio (por ejemplo, "costavalencia.efeuno")
                    $subdominio = implode('.', array_slice($partes, 0, $totalPartes - 2));
                } else {
                    // Si no hay subdominios, usar la primera parte como dominio principal
                    $dominioPrincipal = $partes[0];
                    $subdominio = ''; // No hay subdominio
                }

                // Construir el nombre del archivo JSON basado en el subdominio o dominio principal
                if (!empty($subdominio)) {
                    $nombreDominio = $subdominio; // Usar el subdominio como identificador
                } else {
                    $nombreDominio = $dominioPrincipal; // Usar el dominio principal si no hay subdominio
                }

                // Construir la ruta al archivo de configuración basado en el nombre del dominio
                $jsonContentSettings = file_get_contents(__DIR__ . '/settings/' . $nombreDominio . '.json');

                // Convertir el JSON a un arreglo asociativo de PHP
                $configJsonSetting = json_decode($jsonContentSettings, true);


                // Acceder a las variables de entorno de la base de datos
                $dbHost = $configJsonSetting['database']['host'];
                $dbPort = $configJsonSetting['database']['port'];
                $dbName = $configJsonSetting['database']['dbname'];
                $dbUser = $configJsonSetting['database']['username'];
                $dbPassword = $configJsonSetting['database']['password'];
        
                $conectar = $this->dbh = new PDO("mysql:host=".$dbHost.";port=".$dbPort.";dbname=".$dbName."", "".$dbUser."", "".$dbPassword."");
                //$conectar = $this->dbh = new PDO("mysql:host=localhost;port=3306;dbname=c1newproject", "root", "root");
                
                return $conectar; 
            } catch (PDOException $e) {
                echo "¡Error BD 1!: " . $e->getMessage() . "<br/>";
                die();
            
            }
        
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


/* class UsuarioModel extends Conectar
{
    public function obtenerUsuarios()
    {
        try {
            $conexion = $this->Conexion();
            $this->set_names();

            $query = "SELECT * FROM tm_usuario";
            $stmt = $conexion->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener usuarios: " . $e->getMessage();
            return false;
        }
    }
}

$usuarioModel = new UsuarioModel();
$usuarios = $usuarioModel->obtenerUsuarios();

if ($usuarios !== false) {
    foreach ($usuarios as $usuario) {
        echo "ID: " . $usuario['idUsu'] . "<br>";
        echo "Nick: " . $usuario['nickUsu'] . "<br>";
        echo "<br>";
    }
} else {
    echo "No se pudieron obtener los usuarios.";
}

 */




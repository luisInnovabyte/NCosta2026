<?php
class Rutas extends Conectar
{
    public function comprobarExisteRutas($idioma,$curso,$nivel,$peso)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
      

        // Consulta SQL para insertar los datos
        $sql = "SELECT validar_ruta_unica_orden($idioma, $curso, $nivel, $peso)";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarCurso($idioma,$curso,$nivel,$minAlumnos,$maxAlumnos,$periodicidad,$medida,$peso)
    {
       
        $conectar = parent::conexion();
        parent::set_names();


        
        // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
        $sql = "SELECT validar_ruta_unica('$idioma', '$curso', '$nivel') AS resultado;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        // Consulta SQL para insertar los datos
        $resultadoExiste = $sql->fetch(PDO::FETCH_ASSOC);
        $valor = (bool) $resultadoExiste['resultado'];

        if($valor == true){
             // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
            $sql = "SELECT validar_ruta_unica_orden('$idioma', '$curso','$peso') AS resultado;";
           
            $sql = $conectar->prepare($sql);
            $sql->execute();
            // Consulta SQL para insertar los datos

            $resultadoExiste = $sql->fetch(PDO::FETCH_ASSOC);
            $valor = (bool) $resultadoExiste['resultado'];
            if($valor == true){
                // Consulta SQL para insertar los datos
                $sql = "INSERT INTO `tm_ruta`  (`idiomaId_ruta`, `tipoId_ruta`, `nivelId_ruta`, `minAlum_ruta`, `maxAlum_ruta`, `perRefresco_ruta`, `medidaRefresco_ruta`, `est_ruta`, `peso_ruta`)  VALUES  ('$idioma', '$curso', '$nivel', '$minAlumnos', '$maxAlumnos', '$periodicidad', '$medida', '1', '$peso')";
                $sql = $conectar->prepare($sql);
                $sql->execute();
                return 1;
            }else{
                return 3;
            }
        }else{
            return 0;

        }

     
    

        
       
    }
    public function editarCurso($idEditar,$idioma,$curso,$nivel,$minAlumnos,$maxAlumnos,$periodicidad,$medida,$peso)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
      

        // Consulta SQL para insertar los datos
        $sql = "UPDATE `tm_ruta`  
        SET 
            `idiomaId_ruta` = '$idioma', 
            `tipoId_ruta` = '$curso', 
            `nivelId_ruta` = '$nivel', 
            `minAlum_ruta` = '$minAlumnos', 
            `maxAlum_ruta` = '$maxAlumnos', 
            `perRefresco_ruta` = '$periodicidad', 
            `medidaRefresco_ruta` = '$medida', 
            `est_ruta` = '1', 
            `peso_ruta` = '$peso'  
            WHERE `id_ruta` = '$idEditar';
        ";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function listarRutas($idioma,$curso)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
      

        // Consulta SQL para insertar los datos
        $sql = "SELECT * FROM ruta_completo WHERE `idiomaId_ruta` = '$idioma' AND `tipoId_ruta` = '$curso';";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarRutasActivas()
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
      

        // Consulta SQL para insertar los datos
        $sql = "SELECT * FROM ruta_completo WHERE estadoRuta = 1;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_ruta_x_id($idRuta)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
      

        // Consulta SQL para insertar los datos
        $sql = "SELECT * FROM tm_ruta WHERE `id_ruta` = '$idRuta';";

    

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function obtenerRutaxIdView($idRuta)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        // Asegúrate de que los valores estén correctamente escapados para evitar inyecciones SQL
      

        // Consulta SQL para insertar los datos
        $sql = "SELECT * FROM ruta_completo WHERE `id_ruta` = '$idRuta';";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "UPDATE `tm_ruta` SET `est_ruta` = NOT `est_ruta` WHERE `id_ruta` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function duplicarRuta($idiomaCopiar, $cursoCopiar, $idiomaPegar, $cursoPegar)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // ELIMINAMOS TODOS ANTES
        $sqlDelete = "DELETE FROM tm_ruta WHERE idiomaId_ruta = '$idiomaPegar' AND tipoId_ruta = '$cursoPegar';";
        $sql = $conectar->prepare($sqlDelete);
        $sql->execute();

        // Consulta sin parámetros preparados
        $sqlSelect = "SELECT * FROM tm_ruta WHERE idiomaId_ruta = '$idiomaCopiar' AND tipoId_ruta = '$cursoCopiar';";
        $sql = $conectar->prepare($sqlSelect);
        $sql->execute();
        $result = $sql->fetchAll();
        
    

        // Verificar si hay resultados
        if (count($result) > 0) {
            // Recorrer todos los resultados y hacer un INSERT por cada uno
            foreach ($result as $row) {
                // Realizar el INSERT con los datos obtenidos y modificados
                $sqlInsert = "INSERT INTO tm_ruta 
                            (idiomaId_ruta, tipoId_ruta, nivelId_ruta, minAlum_ruta, maxAlum_ruta, perRefresco_ruta, medidaRefresco_ruta, est_ruta, peso_ruta) 
                            VALUES 
                            ('$idiomaPegar', '$cursoPegar', '{$row['nivelId_ruta']}', '{$row['minAlum_ruta']}', '{$row['maxAlum_ruta']}', '{$row['perRefresco_ruta']}', '{$row['medidaRefresco_ruta']}', 1, '{$row['peso_ruta']}')";

                // Ejecutar el INSERT
                if ($conectar->query($sqlInsert) === TRUE) {
                    echo "Duplicado exitoso!<br>";
                } else {
                    echo "Error al duplicar: " . $conectar->error . "<br>";
                }
            }
        } else {
            echo "No se encontraron datos a duplicar.";
        }
    }


    
}

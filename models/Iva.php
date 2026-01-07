<?php

class Iva extends Conectar
{   
   
   
    public function mostrarIva()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_iva`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    
   public function insertarIva($valorIva,$descrIva,$fechAlta_iva)
    {
        $conectar = parent::conexion();
        parent::set_names();
        //TODO: 14/03/24 añado try catch para la deteccion de errores
        try {
        //TODO: 14/03/24 modificamos sql para que inserta mas datos y no solo el nombre del cliente y su estado
        $sql = "INSERT INTO `tm_iva` (`valorIva`, `descrIva`, `fechAlta_iva`, `estIva`) VALUES (?, ?, ?, 1)";

        $sql = $conectar->prepare($sql);

        $sql->execute([$valorIva, $descrIva, $fechAlta_iva]);

        return true; // Éxito en la inserción

        }catch (PDOException $e){
            return "Error en la inserción: " . $e->getMessage();
        }
    }
    public function cambiarEstado($idIva){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_iva` SET `estIva`= NOT `estIva` WHERE idIva = $idIva";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();


        $sqlEstado = "SELECT `estIva` FROM `tm_iva` WHERE idIva = $idIva";


        $sqlEstado = $conectar->prepare($sqlEstado);
        $sqlEstado->execute();
        return $resultado = $sqlEstado->fetchAll();

    }
    
    public function recogerDatosIva($idIva){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_iva` WHERE idIva = $idIva";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
        

    public function editarIva($idIva,$valorIva,$descrIva,$fechModi_iva){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_iva` SET `valorIva`='$valorIva', `descrIva`='$descrIva', `fechModi_iva` = '$fechModi_iva' WHERE idIva = $idIva";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // DESACTIVAR (FECHA) IVA//
    public function desactivarIva($idIva, $fechBaja_iva)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_iva` SET `fechBaja_iva`= '$fechBaja_iva' WHERE idIva = $idIva";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    // ACTIVAR (FECHA) IVA//
    public function activarIva($idIva)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_iva` SET `fechBaja_iva`= null WHERE idIva = $idIva";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    


}



<?php

class Tarifa extends Conectar
{   
   
    public function mostrarTarifas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_tarifa LEFT JOIN tm_iva ON tm_tarifa.idIva_tarifa = tm_iva.idIva;";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function listarIva(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_iva` WHERE `estIva` = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



    public function insertarTarifa($comentarioTarifa, $precioTarifa, $fechAlta_tarifa, $valorIva)
    {
        $conectar = parent::conexion();
        parent::set_names();
        //TODO: 15/05/24 añado try catch para la deteccion de errores
        try {
        //TODO: 15/05/24 modificamos sql para que inserta mas datos y no solo el nombre del cliente y su estado
        $sql = "INSERT INTO `tm_tarifa` (`comentarioTarifa`, `precioTarifa`, `fechAlta_tarifa`,`idIva_tarifa`, `estTarifa`) VALUES ('$comentarioTarifa',$precioTarifa, '$fechAlta_tarifa',$valorIva, 1)";




        $sql = $conectar->prepare($sql);

        $sql->execute();

        return true; // Éxito en la inserción

        return $resultado = $sql->fetchAll();
        }catch (PDOException $e){
            return "Error en la inserción: " . $e->getMessage();
        }
    }

    public function recogerDatosTarifa($idTarifa){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tarifa` WHERE idTarifa = $idTarifa";

        
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarTarifa($idTarifa, $comentarioTarifa, $precioTarifa,$valorIva , $fechModi_tarifa){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tarifa` SET `precioTarifa`= $precioTarifa, `comentarioTarifa`= '$comentarioTarifa',`idIva_tarifa`= $valorIva , `fechModi_tarifa` = '$fechModi_tarifa' WHERE idTarifa = $idTarifa";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function cambiarEstado($idTarifa){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tarifa` SET `estTarifa`= NOT `estTarifa` WHERE idTarifa = $idTarifa";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();


        $sqlEstado = "SELECT `estTarifa` FROM `tm_tarifa` WHERE idTarifa = $idTarifa";


        $sqlEstado = $conectar->prepare($sqlEstado);
        $sqlEstado->execute();
        return $resultado = $sqlEstado->fetchAll();

    }

    public function desactivarTarifa($idTarifa, $fechBaja_tarifa)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tarifa` SET `fechBaja_tarifa`= '$fechBaja_tarifa' WHERE idTarifa = $idTarifa";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function activarTarifa($idTarifa)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tarifa` SET `fechBaja_tarifa`= null WHERE idTarifa = $idTarifa";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
   

    
}
?>
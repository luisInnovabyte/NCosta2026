<?php

class Almacen extends Conectar
{   
   
   
    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_almacenes`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($nombreAlmacen,$dirAlmacen,$tefAlmacen,$emailAlmacen)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_almacenes` (`nombreAlmacen`,`dirAlmacen`,`tefAlmacen`,`emailAlmacen`) VALUES ('$nombreAlmacen','$dirAlmacen','$tefAlmacen','$emailAlmacen')";
        
   
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_almacenes` WHERE `idAlmacen` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento,$nombreAlmacen,$dirAlmacen,$tefAlmacen,$emailAlmacen)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_almacenes` SET `nombreAlmacen` = '$nombreAlmacen', `dirAlmacen`='$dirAlmacen', `tefAlmacen`='$tefAlmacen',`emailAlmacen`='$emailAlmacen' WHERE `idAlmacen` = $idElemento ";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_almacenes` SET `estAlmacen` = NOT `estAlmacen` WHERE `idAlmacen` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}



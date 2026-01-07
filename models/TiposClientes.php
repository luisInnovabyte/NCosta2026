<?php

class TipoCliente extends Conectar
{   
   
   
    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes-tipo-avisos`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarElementosActivos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes-tipo-avisos` WHERE `estTipo_cliente` = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `clientes-tipo-avisos` (`descripcion_tipo_cliente`) VALUES ('$descripcion')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes-tipo-avisos` WHERE `idTipoCliente` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento, $descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `clientes-tipo-avisos` SET `descripcion_tipo_cliente` = '$descripcion' WHERE `idTipoCliente` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `clientes-tipo-avisos` SET `estTipo_cliente` = NOT `estTipo_cliente` WHERE `idTipoCliente` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}



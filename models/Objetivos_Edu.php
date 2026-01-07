<?php

class Objetivo extends Conectar
{

    public function listarObjetivo($idTitular)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_objetivos_titulares_nivel WHERE idtitObjetivo_titObjetivo = $idTitular";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function agregarObjetivo($titular,$contenido)
    {   
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_objetivos`(`idtitObjetivo_titObjetivo`,  `descrObjetivo`) VALUES ($titular, '$contenido')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function editarObjetivo($idObjetivo,$contenido)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_objetivos` SET `descrObjetivo`='$contenido' WHERE `idObjetivo` = $idObjetivo";
      
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idObjetivo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_objetivos` SET `estObjetivo`= NOT `estObjetivo` WHERE `idObjetivo` = $idObjetivo";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
}

<?php

class Serie extends Conectar
{

    public function listarSeries()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_series";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarIva($descrSerie, $valorSerie)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_series`(`Descripcion`, `Nombre`) VALUES ('$descrSerie','$valorSerie')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function eliminar($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM `tm_series` WHERE `ID` = '$id'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    

}

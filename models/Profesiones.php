<?php
class Profesion extends Conectar
{

    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `profesiones-avisos`";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarElementosActivos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `profesiones-avisos` WHERE `estProfesion` = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($descripcion, $color)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `profesiones-avisos` (`descripcion_profesiones`,`color_profesiones`) VALUES ('$descripcion','$color')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `profesiones-avisos` WHERE `idProfesion` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento, $descripcion,$color)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `profesiones-avisos` SET `descripcion_profesiones` = '$descripcion', `color_profesiones` = '$color' WHERE `idProfesion` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `profesiones-avisos` SET `estProfesion` = NOT `estProfesion` WHERE `idProfesion` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

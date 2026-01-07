<?php

class Idiomas extends Conectar
{

    public function listarIdiomas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_idioma";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarIdiomasSelect()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_idioma WHERE estIdioma = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarIdioma($descrIdioma, $codIdioma, $textIdioma)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_idioma`(`descrIdioma`, `codIdioma`, `textIdioma`,`estIdioma` ) VALUES ('$descrIdioma', '$codIdioma', '$textIdioma', 1 );";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_idioma_x_id($idIdioma)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_idioma` WHERE idIdioma = $idIdioma";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarIdioma($idIdioma, $descrIdioma, $codIdioma, $textIdioma)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_idioma`
         SET `fecModiIdioma`= now() ,
         `descrIdioma`= '$descrIdioma',
         `codIdioma`= '$codIdioma',
         `textIdioma`= '$textIdioma'
         WHERE `idIdioma`= $idIdioma";
        $sql = $conectar->prepare($sql);
        
        $sql->execute();
    }

    public function activarIdioma($idIdioma)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_idioma`
         SET `fecModiIdioma`= now() ,
         `fecBajaIdioma`= null,
         `estIdioma`= 1 
         WHERE `idIdioma`= $idIdioma";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarIdioma($idIdioma)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_idioma`
        SET `fecModiIdioma`= now() ,
        `fecBajaIdioma`= now() ,
        `estIdioma`= 0 
        WHERE `idIdioma`= $idIdioma";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_idioma` SET `estIdioma` = NOT `estIdioma`, `fecModiIdioma` = now(), `fecBajaIdioma` = IF(`estIdioma` = 1, NULL, now()) WHERE `idIdioma` = $idElemento ";
            

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

<?php

class Contenido extends Conectar
{

    public function listarContenido()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_contenido_titulares_tipo_nivel";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarContenido($titular,$curso,$nivel,$contenido)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_contenido`(`idtitContenido_titContenido`, `idTipoContenido_tipoCurso`, `idNivelContenido_nivel`, `descrContenido`) VALUES ($titular,$curso,$nivel,'$contenido')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function editarContenido($idCont,$titular,$curso,$nivel,$contenido)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_contenido` SET `idtitContenido_titContenido`=$titular,`idTipoContenido_tipoCurso`=$curso,`idNivelContenido_nivel`=$nivel,`descrContenido`='$contenido' WHERE `idContenido` = $idCont";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_contenido` SET `estContenido` = NOT `estContenido` WHERE `idContenido` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

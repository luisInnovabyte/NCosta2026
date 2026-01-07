<?php

class Grupos extends Conectar
{

    public function listarGrupos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_grupos";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerGruposBuscador($query)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT DISTINCT `grupo_llegadas` FROM tm_llegadas_edu WHERE `grupo_llegadas` LIKE '%$query%'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerGruposAmigosBuscador($query)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT DISTINCT `grupoAmigos` FROM tm_llegadas_edu WHERE `grupoAmigos` LIKE '%$query%'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarGrupo($nomGrupo, $cifGrupo, $direcGrupo, $telGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_grupos`(`nomGrupo`, `direcGrupo`, `telGrupo`, `cifGrupo`, `fecAltaGrupo`, `fecBajaGrupo`, `fecModiGrupo`, `estGrupo`)
         VALUES ('$nomGrupo','$direcGrupo','$telGrupo','$cifGrupo', now(),null,null,1)";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_grupo_x_id($idGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_grupos` WHERE idGrupo = $idGrupo";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarGrupo($idGrupo, $nomGrupo, $cifGrupo, $direcGrupo, $telGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_grupos`
         SET `fecModiGrupo`= now() ,
         `nomGrupo`= '$nomGrupo',
         `direcGrupo`= '$direcGrupo',
         `telGrupo`= '$telGrupo',
         `cifGrupo`= '$cifGrupo'

         WHERE `idGrupo`= $idGrupo";
        $sql = $conectar->prepare($sql);
        
        $sql->execute();
    }

    public function activarGrupo($idGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_grupos`
         SET `fecModiGrupo`= now() ,
         `fecBajaGrupo`= null,
         `estGrupo`= 1 
         WHERE `idGrupo`= $idGrupo";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarGrupo($idGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_grupos`
        SET `fecModiGrupo`= now() ,
        `fecBajaGrupo`= now() ,
        `estGrupo`= 0 
        WHERE `idGrupo`= $idGrupo";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "
        UPDATE `tm_grupos`
        SET 
            `estGrupo` = NOT `estGrupo`,
            `fecModiGrupo` = now(),
            `fecBajaGrupo` = IF(`estGrupo` = 1, NULL, now())
        WHERE `idGrupo` = $idElemento;
    ";        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

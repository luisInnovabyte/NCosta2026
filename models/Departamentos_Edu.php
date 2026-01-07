<?php

class Departamentos extends Conectar
{

    public function listarDepartamentos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_departamento_edu";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarDepartamento($nomDepartamento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_departamento_edu`( `nombreDepartamento`) VALUES ('$nomDepartamento')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        
    }
    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_departamento_edu WHERE `idDepartamento` = $idElemento";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarDepaActivo()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_departamento_edu WHERE `estDepa` = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    

    public function editarTipoCurso($idTipoCurso, $descrTipoCurso, $codTipo, $textTipo, $minAlumnTipo, $maxAlumTipo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocurso`
         SET `fecModiTipoCurso`= now() ,
         `descrTipo`= '$descrTipoCurso',
         `codTipo` = '$codTipo',
         'textTipo' = '$textTipo',
         'minAlumTipo' = '$minAlumnTipo',
         'maxAlumTipo' = '$maxAlumTipo'
         WHERE `idTipo`= $idTipoCurso";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function updateDepartamento($idDepartamentos, $nomDepartamentoE)
    {

        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_departamento_edu SET nombreDepartamento='$nomDepartamentoE' WHERE idDepartamento = $idDepartamentos";    
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_departamento_edu` SET `estDepartamento` = NOT `estDepartamento` WHERE `idDepartamento` = $idElemento ";
            
           
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

<?php

class TipoCurso extends Conectar
{

    public function listarTipoCurso()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_tipocurso";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarTipoCursoSelect()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_tipocurso WHERE estTipoCurso = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function insertarTipoCurso($descrTipoCurso, $codTipo, $textTipo, $minAlumnTipo, $maxAlumTipo)
    {
       
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipocurso` WHERE `codTipo` = '$codTipo'";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        
        if(empty($resultado)){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `tm_tipocurso`( `descrTipo`, `codTipo`, `textTipo`, `minAlumTipo`, `maxAlumTipo`, `fecAltaTipoCurso`, `estTipoCurso`) VALUES ('$descrTipoCurso', '$codTipo', '$textTipo', '$minAlumnTipo', '$maxAlumTipo', now(), 1)";
          
            
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return "1";
        } else {
            return "0";
        }
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

    public function update_tipocurso($idTipo, $descrTipoCurso, $codTipo,$observaciones)
    {
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipocurso` WHERE `codTipo` = '$codTipo'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
     
        if(empty($resultado)){
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "UPDATE `tm_tipocurso` SET `descrTipo`='$descrTipoCurso',`codTipo`='$codTipo',`textTipo`='$observaciones',`fecModiTipoCurso`=CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid') WHERE `idTipo`='$idTipo'";    
                  
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return 1;
        } else {
       
            return 0;
        }
    }

    public function activarTipoCurso($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocurso`
         SET `fecModiTipoCurso`= now() ,
         `fecBajaTipoCurso`= null,
         `estTipoCurso`= 1 
         WHERE `idTipo`= $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarTipoCurso($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocurso`
         SET `fecModiTipoCurso`= now() ,
         `fecBajaTipoCurso`= now(),
         `estTipoCurso`= 0
         WHERE `idTipo`= $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_tipocurso_x_id($idTipo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_tipocurso
        WHERE idTipo = '$idTipo'";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocurso` SET `estTipoCurso` = NOT `estTipoCurso`, `fecModiTipoCurso` = now(), `fecBajaTipoCurso` = IF(`estTipoCurso` = 1, NULL, now()) WHERE `idTipo` = $idElemento ";
            
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
}

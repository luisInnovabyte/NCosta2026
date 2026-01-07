<?php

class Alumnos extends Conectar
{

    public function listarAlumnosTodos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_prescriptores` LEFT JOIN tm_usuario ON tm_prescriptores.idPrescripcion = tm_usuario.idInscripcion_tmusuario LEFT JOIN `tm_alumno_edu` ON tm_prescriptores.idPrescripcion = `tm_alumno_edu`.`idInscripcion_tmAlumno`;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_alumno_x_id($idAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_prescriptores` LEFT JOIN tm_usuario ON tm_prescriptores.idPrescripcion = tm_usuario.idInscripcion_tmusuario LEFT JOIN `tm_alumno_edu` ON tm_prescriptores.idPrescripcion = `tm_alumno_edu`.`idInscripcion_tmAlumno` WHERE `tm_alumno_edu`.`idInscripcion_tmAlumno` = '$idAlumno';";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cambiarEstado($idElemento)
    {

        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "
        UPDATE `tm_usuario`
        SET 
            `estUsu` = NOT `estUsu`,
            `fecModiUsu` = now(),
            `fecBajaUsu` = IF(`estUsu` = 1, NULL, now())
        WHERE `idInscripcion_tmusuario` = $idElemento;
    ";        
    
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $sql = "
        UPDATE `tm_alumno_edu`
        SET 
            `estUsu` = NOT `estUsu`,
            `fecModiUsuario` = now(),
            `fecBajaUsuario` = IF(`estUsu` = 1, NULL, now())
        WHERE `idInscripcion_tmAlumno` = $idElemento;
    ";        

   
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
   
}

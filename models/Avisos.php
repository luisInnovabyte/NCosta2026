<?php
class Aviso extends Conectar
{

    public function mostrarAvisos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_avisos_cliente_tipo_prioridad_estado`";

    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

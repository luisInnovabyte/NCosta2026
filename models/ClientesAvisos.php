<?php
class Cliente extends Conectar
{

    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_avisos_cliente_tipo`";


    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($nombreCliente,$tipoCliente,$tefCliente,$dirCliente,$emailCliente,$faxCliente,$obsCliente,$notasCliente)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $tipoCliente = $tipoCliente[0];
        $sql = "INSERT INTO `clientes-avisos` ( `idTipoCliente_clientes`, `nombreCliente`, `telCliente`, `dirCliente`, `emailCliente`, `faxCliente`, `obsCliente`, `notasCliente`) VALUES ($tipoCliente,'$nombreCliente','$tefCliente','$dirCliente','$emailCliente','$faxCliente','$obsCliente','$notasCliente')";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes-avisos` WHERE `idCliAviso` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento, $nombreCliente,$tipoCliente,$tefCliente,$dirCliente,$emailCliente,$faxCliente,$obsCliente,$notasCliente)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $tipoCliente = $tipoCliente[0];
        $sql = "UPDATE `clientes-avisos` SET `idTipoCliente_clientes`=$tipoCliente,`nombreCliente`='$nombreCliente',`telCliente`='$tefCliente',`dirCliente`='$dirCliente',`emailCliente`='$emailCliente',`faxCliente`='$faxCliente',`obsCliente`='$obsCliente',`notasCliente`='$notasCliente' WHERE `idCliAviso` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `clientes-avisos` SET `estCliente` = NOT `estCliente` WHERE `idCliAviso` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

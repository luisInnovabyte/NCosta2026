<?php

class ProformaAle extends Conectar
{

 

    public function listarProformaFacturacion(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM factura_pie LEFT JOIN factura_cabecera ON factura_pie.idCabecera_Pie = factura_cabecera.idCabecera";
    
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarFacturaFacturacion(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM factura_pie_real LEFT JOIN factura_cabecera_real ON factura_pie_real.idCabecera_Pie = factura_cabecera_real.idCabecera";
    
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function desactivarFacturaModelo($idPie)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie_real` SET `facturaPagada` = 0 WHERE `idPie` = $idPie";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function activarFacturaModelo($idPie)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie_real` SET `facturaPagada` = 1 WHERE `idPie` = $idPie";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarFacturaProformaModelo($idPie)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie` SET `facturaPagada` = 0 WHERE `idPie` = $idPie";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
    }

    public function activarFacturaProformaModelo($idPie)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `factura_pie` SET `facturaPagada` = 1 WHERE `idPie` = $idPie";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }


}

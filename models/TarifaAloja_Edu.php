<?php
class TarifaAloja extends Conectar
{

    public function listarTarifaAloja()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_tarifa_iva` ORDER BY `idTarifa` ASC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarTarifaAlojaFact($datatype)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // Si el tipo es "Otro" o "Otros", buscar ambos
        if ($datatype === 'Otro' || $datatype === 'Otros') {
            $sql = "SELECT * FROM `view_tarifa_iva` WHERE `estTarifa` = 1 AND (`tipo_tarifa`='Otro' OR `tipo_tarifa`='Otros') ORDER BY `idTarifa` ASC";
        } else {
            $sql = "SELECT * FROM `view_tarifa_iva` WHERE `estTarifa` = 1 AND `tipo_tarifa`='$datatype' ORDER BY `idTarifa` ASC";
        }
            

    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     public function listarTarifaFactAll()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_tarifa_iva` WHERE `estTarifa` = 1 ORDER BY `idTarifa` ASC";
        

    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarTarifasAlojaInput($datatype,$search)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // Si el tipo es "Otro" o "Otros", buscar ambos
        if ($datatype === 'Otro' || $datatype === 'Otros') {
            $sql = "SELECT `cod_tarifa`, `nombre_tarifa`,`unidades_tarifa`,`unidad_tarifa` FROM `view_tarifa_iva` WHERE `estTarifa` = 1 AND (`tipo_tarifa`='Otro' OR `tipo_tarifa`='Otros') AND (`cod_tarifa` LIKE '$search%' OR `nombre_tarifa` LIKE '%$search%')  ORDER BY `idTarifa` ASC";
        } else {
            $sql = "SELECT `cod_tarifa`, `nombre_tarifa`,`unidades_tarifa`,`unidad_tarifa` FROM `view_tarifa_iva` WHERE `estTarifa` = 1 AND `tipo_tarifa`='$datatype' AND (`cod_tarifa` LIKE '$search%' OR `nombre_tarifa` LIKE '%$search%')  ORDER BY `idTarifa` ASC";
        }
     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerDatosPorCodigo($codigo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_tarifa_iva` WHERE `estTarifa` = 1 AND `cod_tarifa`='$codigo'";
        
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarTarifaAloja($nombre,$codigo,$unidades,$unidadMedidaPlural,$unidadMedidaSingul,$precio,$descuento,$cta1TarifasAloja,$cta2TarifasAloja,$cta3TarifasAloja,$selectIva,
    $departamentoTarifa,$tipoTarifa,$descripcion)
    {
        $opcionesSingular = [
            0 => 'SIN UNIDAD DE MEDIDA',
            1 => 'Día',
            2 => 'Día extra',
            3 => 'Semana',
            4 => 'Quincena',
            5 => 'Mes',
            6 => 'Trimestre',
            7 => 'Año',
            8 => 'Oferta especial',
            9 => 'Hora',
            10 => 'Descuento',
            11 => 'Viaje'
            
        ];

        // Array asociativo para unidades en plural
        $opcionesPlural = [
            0 => 'SIN UNIDAD DE MEDIDA',
            1 => 'Días',
            2 => 'Días extra',
            3 => 'Semanas',
            4 => 'Quincenas',
            5 => 'Meses',
            6 => 'Trimestres',
            7 => 'Años',
            8 => 'Oferta especial',
            9 => 'Horas',
            10 => 'Descuento',
            11 => 'Viajes'
            
        ];
        // Verificación para saber si es singular o plural
        if ($unidades == 1) {
            $unidadMedia = $unidadMedidaSingul;  // Asignar valor de unidad
            $unidadMedia = $opcionesSingular[$unidadMedia];  // Obtener texto de la opción
        } else {
            $unidadMedia = $unidadMedidaPlural;  // Asignar valor de unidad
            $unidadMedia = $opcionesPlural[$unidadMedia];  // Obtener texto de la opción
        }


        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_tarifa`(`idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`, `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`, `cuenta2_tarifa`, 
        `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`, `descripcion_tarifa`,`fechaInsert`, `estTarifa`) VALUES  ('$selectIva', '$departamentoTarifa', '$codigo', '$nombre', '$unidades', '$unidadMedia', '$precio', '$cta1TarifasAloja', '$cta2TarifasAloja', 
        '$cta3TarifasAloja', '$tipoTarifa', '$descuento', '$descripcion',now(), 1);";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return "1";
    }
  
    public function insertarTarifaExcel2($data, $fechaHoraActual) {
        
        // ⚠ Ajusta los índices según el orden real en tu CSV
        // Basado en tu cabecera: ID, Código, Nombre, Medida, Importe, Descuento, Cuenta1, Cuenta2, Cuenta3, Tipo, IVA, Estado
        $conectar = parent::conexion();
        parent::set_names();
          $sql = "UPDATE `tm_tarifa` 
                SET `estTarifa` = 0 
                WHERE `fechaInsert` < '$fechaHoraActual'";
        $sql = $conectar->prepare($sql);
        
        $sql->execute();

        $departamento = 1;

        $id_tarifa          = isset($data[0]) ? trim($data[0]) : null;
        $cod_tarifa         = isset($data[1]) ? trim($data[1]) : null;
        $nombre_tarifa      = isset($data[2]) ? trim($data[2]) : null;
      
        // 🔹 Procesar $data[3] para separar número y texto
        $unidad_tarifa = null;
        $unidades_tarifa = null;

        if (!empty($data[3])) {
            $valor = trim($data[3]);

            // Si empieza con número
            if (preg_match('/^(\d+)\s*(.*)$/', $valor, $matches)) {
                $unidades_tarifa = (int)$matches[1];             // el número
                $unidad_tarifa   = !empty($matches[2]) ? $matches[2] : null; // el texto después
            } else {
                // No hay número → todo es texto
                $unidades_tarifa = null;
                $unidad_tarifa   = $valor;
            }
}
        $precio_tarifa = 0.0;
        if (!empty($data[4])) {
            // Quitar símbolo €, espacios, y puntos de miles
            $precio_tarifa = str_replace(['€', ' ', '.'], '', $data[4]);

            // Reemplazar la coma decimal por punto
            $precio_tarifa = str_replace(',', '.', $precio_tarifa);

            // Convertir a float
            $precio_tarifa = floatval($precio_tarifa);
        }

        // 🔹 Descuento (si quieres dejarlo como texto "10 %" o normalizarlo a número)
        $descuento_tarifa = null;
        if (!empty($data[5])) {
            $descuento_tarifa = str_replace(['%', ' '], '', $data[5]);
            $descuento_tarifa = floatval($descuento_tarifa);
        }

        $cuenta1_tarifa     = isset($data[6]) ? trim($data[6]) : null;
        $cuenta2_tarifa     = isset($data[7]) ? trim($data[7]) : null;
        $cuenta3_tarifa     = isset($data[8]) ? trim($data[8]) : null;
        $tipo_tarifa        = isset($data[9]) ? trim($data[9]) : null;

        // 🔹 Limpiar IVA: quitar % y espacios, convertir a número
        $iva_tarifa = null;
        if (!empty($data[10])) {
            $iva_tarifa = str_replace(['%', ' '], '', $data[10]);
            $iva_tarifa = floatval($iva_tarifa);
        }

        $estado_tarifa      = isset($data[11]) ? trim($data[11]) : null;

        $sql = "INSERT INTO `tm_tarifa`(
                    `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`,
                    `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`,
                    `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`,
                    `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`
                ) VALUES (
                    '$iva_tarifa','$departamento','$cod_tarifa','$nombre_tarifa',
                    '$unidades_tarifa','$unidad_tarifa','$precio_tarifa','$cuenta1_tarifa',
                    '$cuenta2_tarifa','$cuenta3_tarifa','$tipo_tarifa','$descuento_tarifa',
                    '$nombre_tarifa','$fechaHoraActual','1', '$iva_tarifa'
                )";
              $json_string = json_encode($sql);
              $file = 'PAIRTSO.json';
              file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();

    }
    public function insertarTarifaExcel($data, $fechaHoraActual)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $json_string = json_encode('');
        $file = 'x1.json';
        file_put_contents($file, $json_string);
        // Desactivar tarifas anteriores
        $sql = "UPDATE `tm_tarifa` 
                SET `estTarifa` = 0 
                WHERE `fechaInsert` < '$fechaHoraActual'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        // Insertar nueva tarifa
        $departamento       = 1;
        $cod_tarifa         = htmlspecialchars($data[0]);  // Código
        $nombre_tarifa      = htmlspecialchars($data[1]);  // Curso
        $descripcion_tarifa = htmlspecialchars($data[2]);  // Descripción
        $unidad_tarifa      = htmlspecialchars($data[3]);  // Medida

        // Limpiar precio: quitar € y espacios, reemplazar coma decimal
        $precio_tarifa = str_replace(['€',' '], '', $data[4]);
        $precio_tarifa = str_replace(',', '.', $precio_tarifa);
        $precio_tarifa = floatval($precio_tarifa);

        $descuento_tarifa   = htmlspecialchars($data[5]);  // Descuento
        $cuenta1_tarifa     = htmlspecialchars($data[6]);  // Cuenta1
        $cuenta2_tarifa     = htmlspecialchars($data[7]);  // Cuenta2
        $cuenta3_tarifa     = htmlspecialchars($data[8]);  // Cuenta3
        $tipo_tarifa        = htmlspecialchars($data[9]);  // Tipo

        // Limpiar IVA: quitar % y espacios, convertir a decimal
        $idIva = str_replace(['%',' '], '', $data[10]);
        $idIva = floatval($idIva);
        $iva   = $idIva; // igual para el campo iva_tarifa

        $sql = "INSERT INTO `tm_tarifa`(
                    `idIva_tarifa`, `idDepartament_tarifa`, `cod_tarifa`, `nombre_tarifa`,
                    `unidades_tarifa`, `unidad_tarifa`, `precio_tarifa`, `cuenta1_tarifa`,
                    `cuenta2_tarifa`, `cuenta3_tarifa`, `tipo_tarifa`, `descuento_tarifa`,
                    `descripcion_tarifa`, `fechaInsert`, `estTarifa`, `iva_tarifa`
                ) VALUES (
                    '$idIva','$departamento','$cod_tarifa','$nombre_tarifa',
                    '$unidad_tarifa','$unidad_tarifa','$precio_tarifa','$cuenta1_tarifa',
                    '$cuenta2_tarifa','$cuenta3_tarifa','$tipo_tarifa','$descuento_tarifa',
                    '$descripcion_tarifa','$fechaHoraActual','1', '$iva'
                )";

        // Guardar SQL para depuración
        $json_string = json_encode($sql);
        $file = 'TARIFA.json';
        file_put_contents($file, $json_string);

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_tarifaAloja_x_id($idTarifaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_tarifa_iva` WHERE idTarifa = $idTarifaAloja";
        
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarTarifaAlojaxIdActivo($idTarifaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_tarifa_iva` WHERE idTarifa = $idTarifaAloja and estTarifa = 1 ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function editarTarifaAloja($idTarifasAloja,$nombre,$codigo,$unidades,$unidadMedidaPlural
    ,$unidadMedidaSingul,$precio,$descuento,$cta1TarifasAloja,$cta2TarifasAloja,
    $cta3TarifasAloja,$selectIva,$departamentoTarifa,$tipoTarifa,$descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // Verificación para saber si es singular o plural
        $opcionesSingular = [
            0 => 'SIN UNIDAD DE MEDIDA',
            1 => 'Día',
            2 => 'Día extra',
            3 => 'Semana',
            4 => 'Quincena',
            5 => 'Mes',
            6 => 'Trimestre',
            7 => 'Año',
            8 => 'Oferta especial',
            9 => 'Hora',
            10 => 'Descuento',
            11 => 'Viaje'
        ];

        // Array asociativo para unidades en plural
        $opcionesPlural = [
            0 => 'SIN UNIDAD DE MEDIDA',
            1 => 'Días',
            2 => 'Días extra',
            3 => 'Semanas',
            4 => 'Quincenas',
            5 => 'Meses',
            6 => 'Trimestres',
            7 => 'Años',
            8 => 'Oferta especial',
            9 => 'Horas',
            10 => 'Descuento',
            11 => 'Viajes'
        ];
        // Verificación para saber si es singular o plural
        if ($unidades == 1) {
            $unidadMedia = $unidadMedidaSingul;  // Asignar valor de unidad
            $unidadMedia = $opcionesSingular[$unidadMedia];  // Obtener texto de la opción
        } else {
            $unidadMedia = $unidadMedidaPlural;  // Asignar valor de unidad
            $unidadMedia = $opcionesPlural[$unidadMedia];  // Obtener texto de la opción
        }
        $sql = "UPDATE `tm_tarifa` SET `idIva_tarifa`='$selectIva',`idDepartament_tarifa`='$departamentoTarifa',`cod_tarifa`='$codigo',`nombre_tarifa`='$nombre',`unidades_tarifa`='$unidades',`unidad_tarifa`='$unidadMedia',`precio_tarifa`='$precio',`cuenta1_tarifa`='$cta1TarifasAloja',`cuenta2_tarifa`='$cta2TarifasAloja',`cuenta3_tarifa`='$cta3TarifasAloja',`tipo_tarifa`='$tipoTarifa',`descuento_tarifa`='$descuento',`descripcion_tarifa`='$descripcion' WHERE `idTarifa` = $idTarifasAloja;";


        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function activarTarifaAloja($idTarifaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tarifa`
         SET `fecModiTarifaAloja`= now() ,
         `fecBajaTarifaAloja`= null,
         `estTarifaaloja`= 1 
         WHERE `idTarifaAloja`= $idTarifaAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarTarifaAloja($idTarifaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tarifa` SET `fecModiTarifaAloja`= now() , `fecBajaTarifaAloja`= now() , `estTarifa`= 0 WHERE `idTarifaAloja`= $idTarifaAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function listarTiposAlojaSelect()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tiposaloja` WHERE estTiposAloja = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarTarifasTiposAloja($tipoAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        if ($tipoAloja == 0) {
            $sql = "SELECT * FROM `view_tarifa_iva`";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        } else {
            $sql = "SELECT * FROM `view_tarifa_iva` WHERE `tipo_tarifa` = $tipoAloja";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    }

    public function  listarIvaSelect()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_iva`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function  listarDepartamentosSelect()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_departamento_edu`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tarifa` SET `estTarifa` = NOT `estTarifa` WHERE `idTarifa` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        
        // Obtener el nuevo estado
        $sql2 = "SELECT `estTarifa` FROM `tm_tarifa` WHERE `idTarifa` = $idElemento";
        $sql2 = $conectar->prepare($sql2);
        $sql2->execute();
        $resultado = $sql2->fetch(PDO::FETCH_ASSOC);
        return $resultado['estTarifa'];
    }
}

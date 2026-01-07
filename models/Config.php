<?php

class Config extends Conectar
{

   public function get_datos_empresa(){

   $conectar = parent::conexion();
   parent::set_names();
   $sql = "SELECT * FROM tm_config WHERE `idConfig` = 1";
   $sql = $conectar->prepare($sql);
   $sql->execute();
   return $resultado = $sql->fetchAll();

   }
   public function get_datos_empresaConfig(){

   $conectar = parent::conexion();
   parent::set_names();
   $sql = "SELECT * FROM `view_empresa_config` WHERE `idConfig` = 1";
   
   $sql = $conectar->prepare($sql);
   $sql->execute();
   return $resultado = $sql->fetchAll();
   
   }
   public function get_datos_suscripcion(){

      $conectar = parent::conexion();
      parent::set_names();
      // Obtener el dominio sin protocolo
     // Obtener el dominio completo sin protocolo
      $dominioCompleto = $_SERVER['HTTP_HOST'];

      // Dividir el dominio en partes por los puntos
      $partesDominio = explode('.', $dominioCompleto);

      // Calcular el número de partes
      $totalPartes = count($partesDominio);

      // Construir el nombre canónico del dominio
      if ($totalPartes > 2) {
         // Si tiene subdominio, usar todo el dominio completo
         $dominioCanonico = $dominioCompleto; // Por ejemplo, "costavalencia.efeuno.com.es"
      } else {
         // Si no hay subdominio, usar el dominio directamente
         $dominioCanonico = $dominioCompleto; // Por ejemplo, "efeuno.com.es"
      }

      // Generar el hash MD5 del dominio canónico
      $dominio_md5 = md5($dominioCanonico); 

      // Consulta SQL para verificar la suscripción
      $sql = "SELECT * FROM `tm_suscripcion` WHERE `idSoftware` = '$dominio_md5'"; 

      // Mostrar consulta para depuración
      // echo $sql;

      // Aquí podrías ejecutar la consulta en tu base de datos
      // $result = mysqli_query($conexion, $sql);

      // Lógica adicional para procesar los resultados de la consulta

      $sql = $conectar->prepare($sql);
      $sql->execute();
      return $resultado = $sql->fetchAll();
      
      }
   
}

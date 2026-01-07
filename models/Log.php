<?php

class Log
{
    public $fecha,$priPos,$segPos,$terPos,$fechaActual,$horaActual;
  

    public function __construct($priPos, $segPos, $terPos)
    {
        date_default_timezone_set("Europe/Madrid");
        setlocale(LC_ALL, 'es_ES');
        $this->priPos = $priPos;
        $this->segPos = $segPos;
        $this->terPos = $terPos;
        $this->fechaActual = date('d-m-Y');
        $this->horaActual = date('H:i:s');
    }

    public function nombreFichero()
    {
        date_default_timezone_set("Europe/Madrid");
        setlocale(LC_ALL, 'es_ES');

        $fechaActualNombre = date('Ymd'); //devuelve un string 
        $nombreFinal = '../public/log/' . $fechaActualNombre . '.log';

        return trim($nombreFinal);
    }


    public function grabarLinea()
    {
        try {
            $nombreFic = $this->nombreFichero();
            
            // Verificar si el directorio existe, si no, intentar crearlo
            $directorio = dirname($nombreFic);
            if (!is_dir($directorio)) {
                @mkdir($directorio, 0777, true);
            }
            
            // Intentar abrir el archivo
            $archivo = @fopen($nombreFic, 'a+');
            
            // Si no se puede abrir, salir silenciosamente
            if ($archivo === false) {
                return false;
            }
            
            fwrite($archivo, $this->priPos);
            fwrite($archivo, '; Archivo: ');
            fwrite($archivo, $this->segPos);
            fwrite($archivo, '; Acción: ');
            fwrite($archivo, $this->terPos);
            fwrite($archivo, '; Fecha: ');
            fwrite($archivo, $this->fechaActual);
            fwrite($archivo, '; Hora: ');
            fwrite($archivo, $this->horaActual);
            // baja una linea 
            fwrite($archivo, "\n");
            fclose($archivo);
            
            return true;
        } catch (Exception $e) {
            // Si hay error, no hacer nada (log silencioso)
            return false;
        }
    }
}

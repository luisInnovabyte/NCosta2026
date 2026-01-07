##select idIdioma, ucase(descrIdioma) from tm_idioma;
##select idTipo, ucase(descrTipo) from tm_tipocurso;
##select idNivel, ucase(descrNivel) from tm_nivel;

##############################################################
## Añadir que solo se puedanintroducir valores permitidos  ##
##############################################################
ALTER TABLE tm_ruta 
ADD CONSTRAINT chk_valores_permitidos 
CHECK (medidaRefresco_ruta IN (0, 1, 2, 3));


#################################################################
## Vista con los dscr de los campo de idiomas, tipo y niveles  ##
#################################################################
CREATE OR REPLACE VIEW ruta_completo AS (
select 
  ruta.id_ruta,
  ruta.idiomaId_ruta,
  (select ucase(descrIdioma)  from tm_idioma where idIdioma = ruta.idiomaId_ruta) as descrIdioma, 
  (select codIdioma  from tm_idioma where idIdioma = ruta.idiomaId_ruta) as codIdioma, 
  ruta.tipoId_ruta,
  (select ucase(descrTipo) from tm_tipocurso where idTipo = ruta.tipoId_ruta) as descrTipo, 
  (select codTipo from tm_tipocurso where idTipo = ruta.tipoId_ruta) as codTipo, 
  ruta.nivelId_ruta,
  (select ucase(descrNivel) from tm_nivel where idNivel = ruta.nivelId_ruta) as descrNivel, 
  (select codNivel from tm_nivel where idNivel = ruta.nivelId_ruta) as codNivel, 
  ruta.maxAlum_ruta,
  ruta.minAlum_ruta,
  ruta.perRefresco_ruta,
  ruta.medidaRefresco_ruta,
  CASE
    WHEN ruta.medidaRefresco_ruta = 1 then 'Día'
    WHEN ruta.medidaRefresco_ruta = 2 then 'Semana'
    WHEN ruta.medidaRefresco_ruta = 3 then 'Mes'
    else 'Sin periodicidad'
  END AS descrRefresco,
  est_ruta as estadoRuta,
  peso_ruta as pesoRuta
from 
    tm_ruta as ruta);



###########################################################################
## Funcion que pasada una fecha (formato mysql), un numero y un integer  ##
## que defina una periodicidad nos devuelve                              ##
## la fecha resultante (formatoMYSQL)                                    ##
###########################################################################

DELIMITER $$
CREATE FUNCTION calcular_fecha_ruta(
    p_fecha DATE, 
    p_numero INT, 
    p_periodicidad INT
) RETURNS DATE
DETERMINISTIC
BEGIN
    DECLARE fecha_resultante DATE;

    SET fecha_resultante = CASE 
        WHEN p_periodicidad = 1 THEN DATE_ADD(p_fecha, INTERVAL p_numero DAY)  -- Sumar días
        WHEN p_periodicidad = 2 THEN DATE_ADD(p_fecha, INTERVAL p_numero WEEK) -- Sumar semanas
        WHEN p_periodicidad = 3 THEN DATE_ADD(p_fecha, INTERVAL p_numero MONTH) -- Sumar meses
        ELSE p_fecha -- Si la periodicidad no es válida, devuelve la fecha original
    END;

    RETURN fecha_resultante;
END $$

DELIMITER ;



###########################################################################
## Funcion que pasada una fecha (formato mysql), un numero y un integer  ##
## que defina una periodicidad nos devuelve                              ##
## la fecha resultante (formato europeo)                                 ##
###########################################################################

DELIMITER $$
CREATE FUNCTION calcular_fecha_ruta_europeo(
    p_fecha DATE, 
    p_numero INT, 
    p_periodicidad INT
) RETURNS DATE
DETERMINISTIC
BEGIN
    DECLARE fecha_resultante DATE;

    SET fecha_resultante = CASE 
        WHEN p_periodicidad = 1 THEN DATE_ADD(p_fecha, INTERVAL p_numero DAY)  -- Sumar días
        WHEN p_periodicidad = 2 THEN DATE_ADD(p_fecha, INTERVAL p_numero WEEK) -- Sumar semanas
        WHEN p_periodicidad = 3 THEN DATE_ADD(p_fecha, INTERVAL p_numero MONTH) -- Sumar meses
        ELSE p_fecha -- Si la periodicidad no es válida, devuelve la fecha original
    END;

    -- Retornar la fecha en formato europeo DD-MM-YYYY
    RETURN DATE_FORMAT(fecha_resultante, '%d-%m-%Y');
END $$

DELIMITER ;


###########################################################################
## Funcion que pasados tres parametros (idioma, tipo y nivel             ##
## me devuelve un false si ya existe la combinación en la tabla de rutas ##
## true si no existe y puedo insertar                                    ##
###########################################################################
DELIMITER $$

CREATE FUNCTION validar_ruta_unica(
    p_idiomaId INT,
    p_tipoId INT,
    p_nivelId INT
) RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE existe INT;

    SELECT COUNT(*) INTO existe
    FROM tm_ruta
    WHERE idiomaId_ruta = p_idiomaId
      AND tipoId_ruta = p_tipoId
      AND nivelId_ruta = p_nivelId;

    IF existe > 0 THEN
        RETURN FALSE;
    ELSE
        RETURN TRUE;
    END IF;
END $$

DELIMITER ;

select validar_ruta_unica(1, 6, 1);


###########################################################################
## Funcion que pasados cuatro parametros (idioma, tipo y nivel y peso    ##
## me devuelve un false si ya existe la combinación en la tabla de rutas ##
## true si no existe y puedo insertar                                    ##
###########################################################################
DELIMITER $$

CREATE FUNCTION validar_ruta_unica_orden(
    p_idiomaId INT,
    p_tipoId INT,
    p_peso INT
) RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE existe INT;

    SELECT COUNT(*) INTO existe
    FROM tm_ruta
    WHERE idiomaId_ruta = p_idiomaId
      AND tipoId_ruta = p_tipoId
      AND peso_ruta = p_peso;

    IF existe > 0 THEN
        RETURN FALSE;
    ELSE
        RETURN TRUE;
    END IF;
END $$

DELIMITER ;
DROP TRIGGER IF EXISTS llegadas_before_update_cancela;
DROP TRIGGER IF EXISTS llegadas_before_insert_cancela;
DROP TRIGGER IF EXISTS llegadas_before_update_quita_cancela;

########################################################
##    SE METE UNA FECHA EN CANCELACION DE LLEGADAS    ##
########################################################
### Cuando solo hace un update de la fecha de cancelación de la llegada - UPDATE
DELIMITER $$ 
CREATE TRIGGER llegadas_before_update_cancela 
BEFORE UPDATE ON tm_llegadas_edu 
  FOR EACH ROW BEGIN 
    IF NEW.fechacancelacion_llegadas IS NOT NULL THEN
       SET NEW.estLlegada = 0;
       SET NEW.estMatricula = 0;
       SET NEW.estAlojamiento = 0;
-- Actualiza el estado en tm_matriculacionllegadas_edu
       UPDATE tm_matriculacionllegadas_edu
       SET estMatriculacion_llegadas = 0
       WHERE idLlegada_matriculacion = NEW.id_llegada;
-- Actualiza el estado en tm_alojamientosllegadas_edu
       UPDATE tm_alojamientosllegadas_edu
       SET estAlojamientos_llegadas = 0
       WHERE idLlegada_alojamientos = NEW.id_llegada;
    END IF;

#####################################################
##    SE METE UNA FECHA EN DENEGACION DE VISADO    ##
#####################################################

  IF NEW.denegacionFecha IS NOT NULL THEN
     SET NEW.estLlegada = 0;
     SET NEW.estMatricula = 0;
     SET NEW.estAlojamiento = 0;
-- Actualiza el estado en tm_matriculacionllegadas_edu
    UPDATE tm_matriculacionllegadas_edu
    SET estMatriculacion_llegadas = 0
    WHERE idLlegada_matriculacion = NEW.id_llegada;
-- Actualiza el estado en tm_alojamientosllegadas_edu
    UPDATE tm_alojamientosllegadas_edu
    SET estAlojamientos_llegadas = 0
    WHERE idLlegada_alojamientos = NEW.id_llegada;
  END IF;
     

  set @nuevo_valor=0;
  
  -- Si alguna columna tiene 1, estLlegada será 1
    IF NEW.estMatricula = 1 OR NEW.estAlojamiento = 1 THEN
        SET @nuevo_valor = 1;

    -- Si ambas columnas tienen el mismo valor, estLlegada toma ese valor
    ELSEIF NEW.estMatricula = NEW.estAlojamiento THEN
        SET @nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 4, estLlegada toma el valor de la otra (salvo si ambas son 4)
    ELSEIF NEW.estMatricula = 4 THEN
        SET @nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 4 THEN
        SET @nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 3, estLlegada toma el valor de la otra (salvo si ambas son 3)
    ELSEIF NEW.estMatricula = 3 THEN
        SET @nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 3 THEN
        SET @nuevo_valor = NEW.estMatricula;
    END IF;
    -- Asignar el nuevo valor a estLlegada
    SET NEW.estLlegada = @nuevo_valor;
 END $$ 
  DELIMITER ;


  
### Cuando solo hace un insert de la fecha de cancelación de la llegada - INSERT
DELIMITER $$ CREATE TRIGGER llegadas_before_insert_cancela BEFORE
INSERT ON tm_llegadas_edu 
FOR EACH ROW BEGIN 
  IF NEW.fechacancelacion_llegadas IS NOT NULL THEN
    SET NEW.estLlegada = 0;
    SET NEW.estMatricula = 0;
    SET NEW.estAlojamiento = 0;
-- Actualiza el estado en tm_matriculacionllegadas_edu
    UPDATE tm_matriculacionllegadas_edu
    SET estMatriculacion_llegadas = 0
    WHERE idLlegada_matriculacion = NEW.id_llegada;
-- Actualiza el estado en tm_alojamientosllegadas_edu
     UPDATE tm_alojamientosllegadas_edu
     SET estAlojamientos_llegadas = 0
     WHERE idLlegada_alojamientos = NEW.id_llegada;
  END IF;

#####################################################
##    SE METE UNA FECHA EN DENEGACION DE VISADO    ##
#####################################################

 IF NEW.denegacionFecha IS NOT NULL THEN
     SET NEW.estLlegada = 0;
     SET NEW.estMatricula = 0;
     SET NEW.estAlojamiento = 0;
-- Actualiza el estado en tm_matriculacionllegadas_edu
    UPDATE tm_matriculacionllegadas_edu
    SET estMatriculacion_llegadas = 0
    WHERE idLlegada_matriculacion = NEW.id_llegada;
-- Actualiza el estado en tm_alojamientosllegadas_edu
    UPDATE tm_alojamientosllegadas_edu
    SET estAlojamientos_llegadas = 0
    WHERE idLlegada_alojamientos = NEW.id_llegada;
  END IF;

## Vamos a actualizar el campo de estLlegada con las combinaciones de los valores de estMatricula y EstAlojamiento

##EstMatricula	EstAlojamiento		R = Estllegada						
##  1					1					1						
##  2					1					1						
##  3					1					1						
##  4					1					1						
##  1					2					1						
##  2					2					2						
##  3					2					2						
##  4					2					2						
##  1					3					1						
##  2					3					2						
##  3					3					3						
##  4					3					3						
##  1					4					1						
##  2					4					2						
##  3					4					3						
##  4					4					4						
							
									
##Siempre que haya un 1=>estLlegada=1				
##Siempre que hay un 4 en cualquier columna=>estLlegada es el valor de la otra columna				
##Siempre que haya el mismo valor en las dos columnas=>estLlegada es el valor de las columnas				
##Siempre que hay un 3=>estLlegada es el valor de la otra columna que no tenga el ## 3				
  
   DECLARE nuevo_valor INT;
    -- Si alguna columna tiene 1, estLlegada será 1
    IF NEW.estMatricula = 1 OR NEW.estAlojamiento = 1 THEN
        SET nuevo_valor = 1;

    -- Si ambas columnas tienen el mismo valor, estLlegada toma ese valor
    ELSEIF NEW.estMatricula = NEW.estAlojamiento THEN
        SET nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 4, estLlegada toma el valor de la otra (salvo si ambas son 4)
    ELSEIF NEW.estMatricula = 4 THEN
        SET nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 4 THEN
        SET nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 3, estLlegada toma el valor de la otra (salvo si ambas son 3)
    ELSEIF NEW.estMatricula = 3 THEN
        SET nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 3 THEN
        SET nuevo_valor = NEW.estMatricula;
    END IF;

    -- Asignar el nuevo valor a estLlegada
    SET NEW.estLlegada = nuevo_valor;
   
END $$ 
DELIMITER ;


################################################################
##    SE QUITA LA FECHA EN CANCELACION DE LLEGADAS/VISADOS    ##
################################################################
### Cuando solo hace un update de la fecha de cancelación de la llegada y visados - UPDATE
#DELIMITER $$ 
#CREATE TRIGGER llegadas_before_update_quita_cancela BEFORE UPDATE ON tm_llegadas_edu 
#FOR EACH ROW BEGIN 
#  IF (NEW.fechacancelacion_llegadas IS NULL)
#  AND (NEW.denegacionFecha IS NULL) THEN ####SET NEW.estLlegada = 1; Se ha sustituido por la inferiores.
#      SET NEW.motivocancelacion_llegadas = '';
#      SET NEW.denegacionMotivo = '';
#  ELSEIF (NEW.fechacancelacion_llegadas IS NULL)
#  AND (NEW.denegacionFecha IS NOT NULL) THEN
#     SET NEW.estLlegada = 0;
#     SET NEW.motivocancelacion_llegadas = '';
#  ELSEIF (NEW.fechacancelacion_llegadas IS NOT NULL)
#  AND (NEW.denegacionFecha IS NULL) THEN
#    SET NEW.estLlegada = 0;
#    SET NEW.denegacionMotivo = '';
#  ELSE
#   SET NEW.estLlegada = 0;
#  END IF;
#END $$ 
#DELIMITER;
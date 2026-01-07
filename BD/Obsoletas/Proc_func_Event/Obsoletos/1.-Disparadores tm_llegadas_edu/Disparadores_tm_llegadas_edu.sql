DROP TRIGGER IF EXISTS llegadas_before_update_cancela;
DROP TRIGGER IF EXISTS llegadas_before_insert_cancela;
DROP TRIGGER IF EXISTS llegadas_before_update_visado;
DROP TRIGGER IF EXISTS llegadas_before_insert_visado;
DROP TRIGGER IF EXISTS llegadas_before_update_quita_cancela;
########################################################
##    SE METE UNA FECHA EN CANCELACION DE LLEGADAS    ##
########################################################
### Cuando solo hace un update de la fecha de cancelación de la llegada - UPDATE
DELIMITER $$ CREATE TRIGGER llegadas_before_update_cancela BEFORE
UPDATE ON tm_llegadas_edu FOR EACH ROW BEGIN IF NEW.fechacancelacion_llegadas IS NOT NULL THEN
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
END $$ DELIMITER;
### Cuando solo hace un insert de la fecha de cancelación de la llegada - INSERT
DELIMITER $$ CREATE TRIGGER llegadas_before_insert_cancela BEFORE
INSERT ON tm_llegadas_edu FOR EACH ROW BEGIN IF NEW.fechacancelacion_llegadas IS NOT NULL THEN
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
END $$ DELIMITER;
#####################################################
##    SE METE UNA FECHA EN DENEGACION DE VISADO    ##
#####################################################
### Cuando solo hace un update de la fecha de cancelación del visado - UPDATE
DELIMITER $$ CREATE TRIGGER llegadas_before_update_visado BEFORE
UPDATE ON tm_llegadas_edu FOR EACH ROW BEGIN IF NEW.denegacionFecha IS NOT NULL THEN
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
END $$ DELIMITER;
### Cuando solo hace un insert de la fecha de cancelación del visado - INSERT
DELIMITER $$ CREATE TRIGGER llegadas_before_insert_visado BEFORE
INSERT ON tm_llegadas_edu FOR EACH ROW BEGIN IF NEW.denegacionFecha IS NOT NULL THEN
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
END $$ DELIMITER;
################################################################
##    SE QUITA LA FECHA EN CANCELACION DE LLEGADAS/VISADOS    ##
################################################################
### Cuando solo hace un update de la fecha de cancelación de la llegada y visados - UPDATE
DELIMITER $$ CREATE TRIGGER llegadas_before_update_quita_cancela BEFORE
UPDATE ON tm_llegadas_edu FOR EACH ROW BEGIN IF (NEW.fechacancelacion_llegadas IS NULL)
  AND (NEW.denegacionFecha IS NULL) THEN ####SET NEW.estLlegada = 1; Se ha sustituido por la inferiores.
SET NEW.motivocancelacion_llegadas = '';
SET NEW.denegacionMotivo = '';
ELSEIF (NEW.fechacancelacion_llegadas IS NULL)
AND (NEW.denegacionFecha IS NOT NULL) THEN
SET NEW.estLlegada = 0;
SET NEW.motivocancelacion_llegadas = '';
ELSEIF (NEW.fechacancelacion_llegadas IS NOT NULL)
AND (NEW.denegacionFecha IS NULL) THEN
SET NEW.estLlegada = 0;
SET NEW.denegacionMotivo = '';
ELSE
SET NEW.estLlegada = 0;
END IF;
END $$ DELIMITER;
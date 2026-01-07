######################################################################
####   NO LANZAR - ESTA INCLUIDO EN DISPARADORES_TM_LLEGADAS_EDU #####
######################################################################
CREATE TRIGGER trg_before_insert_estLlegada BEFORE
INSERT ON tm_llegadas_edu FOR EACH ROW BEGIN
DECLARE nuevo_valor INT;
-- Si alguna columna tiene 1, estLlegada será 1
IF NEW.estMatricula = 1
OR NEW.estAlojamiento = 1 THEN
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
END // DELIMITER;
######################################################################
####                      FIN DE NO LANZAR                       #####
######################################################################
######################################################################
####   NO LANZAR - ESTA INCLUIDO EN DISPARADORES_TM_LLEGADAS_EDU #####
######################################################################
DELIMITER // CREATE TRIGGER trg_before_update_estLlegada BEFORE
UPDATE ON tm_llegadas_edu FOR EACH ROW BEGIN
DECLARE nuevo_valor INT;
-- Si alguna columna tiene 1, estLlegada será 1
IF NEW.estMatricula = 1
OR NEW.estAlojamiento = 1 THEN
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
END // DELIMITER;
######################################################################
####                      FIN DE NO LANZAR                       #####
######################################################################
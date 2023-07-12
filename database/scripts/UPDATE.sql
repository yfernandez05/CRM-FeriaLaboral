-- ----------------------
-- TABLA:					empleos
-- ACCION:					ADD COLUMN
-- DESCRIPCIÓN:				nueva columna departamentos
-- FECHA DE CREACIÓN:		12-07-2023
-- CREADO POR:				Yhonatan Fernandez C.
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
ALTER TABLE `empleos` 
ADD COLUMN `coddepartamento` VARCHAR(6) NULL DEFAULT NULL AFTER `titulo`;


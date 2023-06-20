-- use crmmarketing;

-- --------------------------------------------------------------
-- TABLA:					
-- ACCION:					SP_DROP_CONSTRAINT_IF_EXISTS
-- DESCRIPCIÓN:				Store para eliminar constraint
-- FECHA DE CREACIÓN:		05-08-2018
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
DROP PROCEDURE IF EXISTS SP_DROP_CONSTRAINT_IF_EXISTS;
DELIMITER //
CREATE PROCEDURE SP_DROP_CONSTRAINT_IF_EXISTS
( 
	IN p_table_name varchar(100),
	IN p_constraint_name varchar(150)
)
BEGIN
	DECLARE v_constraint_count int;
    DECLARE v_constraint_type varchar(50);
    
    Set v_constraint_count = (SELECT count(CONSTRAINT_NAME) FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = p_table_name COLLATE utf8mb4_unicode_ci AND CONSTRAINT_NAME = p_constraint_name COLLATE utf8mb4_unicode_ci);
            
    Set v_constraint_type = (SELECT distinct CONSTRAINT_TYPE FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = p_table_name COLLATE utf8mb4_unicode_ci AND CONSTRAINT_NAME = p_constraint_name COLLATE utf8mb4_unicode_ci);
            
	IF v_constraint_count>0 THEN
    
		if 'FOREIGN KEY' = v_constraint_type then
        
			SET @s = CONCAT('ALTER TABLE `' , p_table_name , '` DROP FOREIGN KEY `' , p_constraint_name, '`');
            
        elseif 'PRIMARY KEY' = v_constraint_type then
        
			SET @s = CONCAT('ALTER TABLE `' , p_table_name , '` DROP PRIMARY KEY `' , p_constraint_name, '`');
            
		else
			SET @s = CONCAT('ALTER TABLE `' , p_table_name , '` DROP INDEX `' ,  p_constraint_name, '`');
        end if;
		
		PREPARE stmt FROM @s;
		EXECUTE stmt;
        
	END IF;
    
END //
DELIMITER ;
-- call SP_DROP_CONSTRAINT_IF_EXISTS('p_table_name','p_constraint_name');


-- ----------------------
-- TABLA:					
-- ACCION:					SP_DROP_INDEX_IF_EXISTS
-- DESCRIPCIÓN:				Store para eliminar index
-- FECHA DE CREACIÓN:		12-07-2018
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
DROP PROCEDURE IF EXISTS SP_DROP_INDEX_IF_EXISTS;
DELIMITER //
CREATE PROCEDURE SP_DROP_INDEX_IF_EXISTS
( 
	IN p_table_name varchar(100),
	IN p_index_name varchar(150)
)
BEGIN
	DECLARE v_index_count int;
    DECLARE v_index_type varchar(50);
    
    Set v_index_count = (SELECT count(INDEX_NAME) FROM information_schema.statistics 
			WHERE TABLE_SCHEMA = DATABASE() and table_name = p_table_name COLLATE utf8mb4_unicode_ci AND index_name = p_index_name COLLATE utf8mb4_unicode_ci);
            
    Set v_index_type= (SELECT distinct INDEX_TYPE FROM information_schema.statistics 
			WHERE TABLE_SCHEMA = DATABASE() and table_name = p_table_name COLLATE utf8mb4_unicode_ci AND index_name = p_index_name COLLATE utf8mb4_unicode_ci);
            
	IF v_index_count>0 THEN
		if 'FULLTEXT' = v_index_type then
			SET @s = CONCAT('ALTER TABLE `' , p_table_name , '` DROP INDEX `' , p_index_name, '`');
        else
			SET @s = CONCAT('DROP INDEX `' , p_index_name , '` ON `' ,  p_table_name, '`');
        end if;
		
		PREPARE stmt FROM @s;
		EXECUTE stmt;
	END IF;
    
END //
DELIMITER ;
-- call SP_DROP_INDEX_IF_EXISTS('p_table_name','p_index_name');

-- -------------------------------------------------------------
-- TABLA:					
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Store para añadir columnas verificamos que no exista
-- FECHA DE CREACIÓN:		13-07-2018
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
DROP PROCEDURE IF EXISTS SP_ADD_COLUMN_IF_NOT_EXISTS;
DELIMITER //
CREATE PROCEDURE SP_ADD_COLUMN_IF_NOT_EXISTS
( 
	IN p_table_name varchar(100),
	IN p_column_name varchar(150),
    IN p_data_type varchar(150),
    IN p_after_column varchar(150)
)
BEGIN
	DECLARE v_column varchar(50);
	set v_column= (SELECT COLUMN_NAME FROM information_schema.columns 
					WHERE TABLE_SCHEMA = DATABASE() 
					and table_name = p_table_name COLLATE utf8mb4_unicode_ci
					and column_name = p_column_name COLLATE utf8mb4_unicode_ci);

	if v_column is null then
		SET @s = CONCAT('ALTER TABLE `' , p_table_name , '` ADD COLUMN `' , p_column_name, '` ',p_data_type,' AFTER ' ,p_after_column);
		
		PREPARE stmt FROM @s;
		EXECUTE stmt;
	end if;
    
END //
DELIMITER ;
-- CALL SP_ADD_COLUMN_IF_NOT_EXISTS('p_table_name','p_column_name','p_data_type','p_after_column');



-- -------------------------------------------------------------
-- TABLA:					
-- ACCION:					SP_DROP_COLUMN_IF_EXISTS
-- DESCRIPCIÓN:				Store para eliminar columnas verificamos que exista
-- FECHA DE CREACIÓN:		07-08-2018
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
DROP PROCEDURE IF EXISTS SP_DROP_COLUMN_IF_EXISTS;
DELIMITER //
CREATE PROCEDURE SP_DROP_COLUMN_IF_EXISTS
( 
	IN p_table_name varchar(100),
	IN p_column_name varchar(150)
)
BEGIN
	DECLARE v_column varchar(50);
	set v_column= (SELECT COLUMN_NAME FROM information_schema.columns 
					WHERE TABLE_SCHEMA = DATABASE() 
					and table_name = p_table_name COLLATE utf8mb4_unicode_ci
					and column_name = p_column_name COLLATE utf8mb4_unicode_ci);

	if v_column is not null then
		SET @s = CONCAT('ALTER TABLE `' , p_table_name , '` DROP COLUMN `' , p_column_name, '`');
		
		PREPARE stmt FROM @s;
		EXECUTE stmt;
	end if;
    
END //
DELIMITER ;
-- CALL SP_DROP_COLUMN_IF_EXISTS('p_table_name','p_column_name');



-- -------------------------------------------------------------
-- TABLA:					
-- ACCION:					SP_DROP_COLUMN_IF_EXISTS
-- DESCRIPCIÓN:				Store para cambiar columnas verificamos que exista
-- FECHA DE CREACIÓN:		10-08-2018
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
DROP PROCEDURE IF EXISTS SP_CHANGE_COLUMN_IF_EXISTS;
DELIMITER //
CREATE PROCEDURE SP_CHANGE_COLUMN_IF_EXISTS
( 
	IN p_table_name varchar(100),
	IN p_column_name varchar(150),
	IN p_new_column varchar(150),
    IN p_data_type varchar(150)
)
BEGIN
	DECLARE v_column varchar(50);
	set v_column= (SELECT COLUMN_NAME FROM information_schema.columns 
					WHERE TABLE_SCHEMA = DATABASE() 
					and table_name = p_table_name COLLATE utf8mb4_unicode_ci
					and column_name = p_column_name COLLATE utf8mb4_unicode_ci);

	if v_column is not null then
		SET @s = CONCAT('ALTER TABLE `' , p_table_name , '` CHANGE `' , p_column_name, '` `', p_new_column, '` ',p_data_type);

		PREPARE stmt FROM @s;
		EXECUTE stmt;
	end if;
    
END //
DELIMITER ;
-- CALL SP_CHANGE_COLUMN_IF_EXISTS('p_table_name','p_column_name','p_new_column','p_data_type');


-- -------------------------------------------------------------
-- TABLA:					
-- ACCION:					remove_accents
-- DESCRIPCIÓN:				Funtion para remover acentos
-- FECHA DE CREACIÓN:		10-08-2018
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
DROP FUNCTION IF EXISTS `remove_accents`;
DELIMITER //
CREATE FUNCTION `remove_accents`(`str` TEXT)
    RETURNS text
    LANGUAGE SQL
    DETERMINISTIC
    NO SQL
    SQL SECURITY INVOKER
    COMMENT ''

BEGIN

    SET str = REPLACE(str,'Š','S');
    SET str = REPLACE(str,'š','s');
    SET str = REPLACE(str,'Ð','Dj');
    SET str = REPLACE(str,'Ž','Z');
    SET str = REPLACE(str,'ž','z');
    SET str = REPLACE(str,'À','A');
    SET str = REPLACE(str,'Á','A');
    SET str = REPLACE(str,'Â','A');
    SET str = REPLACE(str,'Ã','A');
    SET str = REPLACE(str,'Ä','A');
    SET str = REPLACE(str,'Å','A');
    SET str = REPLACE(str,'Æ','A');
    SET str = REPLACE(str,'Ç','C');
    SET str = REPLACE(str,'È','E');
    SET str = REPLACE(str,'É','E');
    SET str = REPLACE(str,'Ê','E');
    SET str = REPLACE(str,'Ë','E');
    SET str = REPLACE(str,'Ì','I');
    SET str = REPLACE(str,'Í','I');
    SET str = REPLACE(str,'Î','I');
    SET str = REPLACE(str,'Ï','I');
    SET str = REPLACE(str,'Ñ','N');
    SET str = REPLACE(str,'Ò','O');
    SET str = REPLACE(str,'Ó','O');
    SET str = REPLACE(str,'Ô','O');
    SET str = REPLACE(str,'Õ','O');
    SET str = REPLACE(str,'Ö','O');
    SET str = REPLACE(str,'Ø','O');
    SET str = REPLACE(str,'Ù','U');
    SET str = REPLACE(str,'Ú','U');
    SET str = REPLACE(str,'Û','U');
    SET str = REPLACE(str,'Ü','U');
    SET str = REPLACE(str,'Ý','Y');
    SET str = REPLACE(str,'Þ','B');
    SET str = REPLACE(str,'ß','Ss');
    SET str = REPLACE(str,'à','a');
    SET str = REPLACE(str,'á','a');
    SET str = REPLACE(str,'â','a');
    SET str = REPLACE(str,'ã','a');
    SET str = REPLACE(str,'ä','a');
    SET str = REPLACE(str,'å','a');
    SET str = REPLACE(str,'æ','a');
    SET str = REPLACE(str,'ç','c');
    SET str = REPLACE(str,'è','e');
    SET str = REPLACE(str,'é','e');
    SET str = REPLACE(str,'ê','e');
    SET str = REPLACE(str,'ë','e');
    SET str = REPLACE(str,'ì','i');
    SET str = REPLACE(str,'í','i');
    SET str = REPLACE(str,'î','i');
    SET str = REPLACE(str,'ï','i');
    SET str = REPLACE(str,'ð','o');
    SET str = REPLACE(str,'ñ','n');
    SET str = REPLACE(str,'ò','o');
    SET str = REPLACE(str,'ó','o');
    SET str = REPLACE(str,'ô','o');
    SET str = REPLACE(str,'õ','o');
    SET str = REPLACE(str,'ö','o');
    SET str = REPLACE(str,'ø','o');
    SET str = REPLACE(str,'ù','u');
    SET str = REPLACE(str,'ú','u');
    SET str = REPLACE(str,'û','u');
    SET str = REPLACE(str,'ý','y');
    SET str = REPLACE(str,'ý','y');
    SET str = REPLACE(str,'þ','b');
    SET str = REPLACE(str,'ÿ','y');
    SET str = REPLACE(str,'ƒ','f');


    RETURN str;
END
//
DELIMITER ;

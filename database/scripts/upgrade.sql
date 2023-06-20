-- use crmmarketing;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna uuidimportacion
-- FECHA DE CREACIÓN:		26-06-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('clientes','uuidimportacion','char(36) collate utf8mb4_unicode_ci','anioegreso');

-- -------------------------------------------------------------
-- TABLA:					atenciones
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna idcliente
-- FECHA DE CREACIÓN:		03-07-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('atenciones','idcliente','int not null','iduser');
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('atenciones','fechaatencion','timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP','idcliente');
call SP_DROP_CONSTRAINT_IF_EXISTS('atenciones','fk_idcliente_atenciones');
alter table atenciones add constraint fk_idcliente_atenciones FOREIGN KEY (idcliente) REFERENCES clientes (idcliente);

-- -------------------------------------------------------------
-- TABLA:					atenciones
-- ACCION:					Elimminar foreign key y columnas 
-- DESCRIPCIÓN:				
-- FECHA DE CREACIÓN:		04-07-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_DROP_CONSTRAINT_IF_EXISTS('atenciones','fk_idcuenta_atenciones');
call SP_DROP_CONSTRAINT_IF_EXISTS('atenciones','fk_idcampania_atenciones');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','idcuenta');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','idcampania');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','fechaatencioningreso');
call SP_DROP_COLUMN_IF_EXISTS('atenciones','fechaatencionestado');


-- -------------------------------------------------------------
-- TABLA:					tipoatenciones
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna color
-- FECHA DE CREACIÓN:		26-06-2020
-- CREADO POR:				Palomino Rojas J. Abel
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
CALL SP_ADD_COLUMN_IF_NOT_EXISTS('tipoatenciones','color','varchar(30) COLLATE utf8mb4_unicode_ci','tipoatencion');

CALL SP_ADD_COLUMN_IF_NOT_EXISTS('clientes','idtipoatencion','int NOT NULL DEFAULT 1','uuidimportacion');

CALL SP_ADD_COLUMN_IF_NOT_EXISTS('clientes','asistencia','int NOT NULL DEFAULT 0','idtipoatencion');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna fechaasistencia
-- FECHA DE CREACIÓN:		9-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------

call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','fechaasistencia','timestamp','asistencia');

-- -------------------------------------------------------------
-- TABLA:					users
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna api_token
-- FECHA DE CREACIÓN:		9-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------

call SP_ADD_COLUMN_IF_NOT_EXISTS ('users','api_token','varchar(100) collate utf8mb4_unicode_ci','password');

-- -------------------------------------------------------------
-- TABLA:					users
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				UNIQUE
-- FECHA DE CREACIÓN:		03-07-2020
-- CREADO POR:				Yanet Marleni Inga
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------

call SP_DROP_CONSTRAINT_IF_EXISTS('api_token','api_token_UNIQUE');
ALTER TABLE users
ADD UNIQUE INDEX `api_token_UNIQUE` (`api_token` ASC) VISIBLE;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna origen
-- FECHA DE CREACIÓN:		12-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','origen','varchar(100) collate utf8mb4_unicode_ci','carrera');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna grado
-- FECHA DE CREACIÓN:		18-01-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','grado','varchar(150) collate utf8mb4_unicode_ci','utm');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna edad
-- FECHA DE CREACIÓN:		24-03-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','edad','int','telefono');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna evento
-- FECHA DE CREACIÓN:		5-05-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','evento','varchar(150)','origen');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendi columna tipoparticipante
-- FECHA DE CREACIÓN:		5-05-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
call SP_ADD_COLUMN_IF_NOT_EXISTS ('clientes','tipoparticipante','varchar(150)','evento');

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_content
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_content varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_medium
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_medium varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_name
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_name varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_source
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_source varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna campaign_term
-- FECHA DE CREACIÓN:		14-06-2021
-- CREADO POR:				Yanet Marleni Inga Rojas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add campaign_term varchar(300) collate utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					clientes
-- ACCION:					SP_ADD_COLUMN_IF_NOT_EXISTS
-- DESCRIPCIÓN:				Añadiendo columna procedencia
-- FECHA DE CREACIÓN:		15-06-2021
-- CREADO POR:				Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
Alter Table clientes add procedencia varchar(300) collate utf8mb4_unicode_ci;


-- -------------------------------------------------------------
-- TABLA:					insituciones
-- ACCION:					Create table
-- DESCRIPCIÓN:				Creando una nueva tabla
-- FECHA DE CREACIÓN:		27-04-2022
-- CREADO POR:				Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
-- DROP TABLE IF EXISTS instituciones;
CREATE TABLE instituciones (
  idinstitucion int(11) NOT NULL,
  nombresdirector varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  apellidosdirector varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  institucion varchar(150) COLLATE utf8mb4_unicode_ci NULL,  
  email varchar(60) COLLATE utf8mb4_unicode_ci NULL,
  celular varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  telefono varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,  
  cargo varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  pkubigeo char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  departamento varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  distrito varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  sede varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  direccion varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  paginaweb varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  tipoinstitucion varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  procedencia varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  contactoalterno varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  correoalterno varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  cargoalterno varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  idcuenta int(11) NOT NULL,
  idtipoconfirmacion int(11) NOT NULL DEFAULT 1,
  idcampania int(11) NULL,
  estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  uuidimportacion char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  dateinsert timestamp NOT NULL DEFAULT current_timestamp(),
  userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dateupdate timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					insituciones
-- ACCION:					Alter table
-- DESCRIPCIÓN:				Indice de la tabla insituciones
-- FECHA DE CREACIÓN:		27-04-2022
-- CREADO POR:				Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
ALTER TABLE instituciones
  ADD PRIMARY KEY (idinstitucion),
  ADD KEY fk_idcuenta_instituciones (idcuenta);
  
-- -------------------------------------------------------------
-- TABLA:					insituciones
-- ACCION:					Alter table
-- DESCRIPCIÓN:				filtros instituciones - user
-- FECHA DE CREACIÓN:		27-04-2022
-- CREADO POR:				Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
ALTER TABLE instituciones
  ADD CONSTRAINT fk_idcuenta_instituciones FOREIGN KEY (idcuenta) REFERENCES cuentas (idcuenta);
  
-- -------------------------------------------------------------
-- TABLA:					insituciones
-- ACCION:					Alter table
-- DESCRIPCIÓN:				AUTO_INCREMENT de la tabla
-- FECHA DE CREACIÓN:		27-04-2022
-- CREADO POR:				Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------  
ALTER TABLE instituciones
  MODIFY idinstitucion int(11) NOT NULL AUTO_INCREMENT;

-- -------------------------------------------------------------
-- TABLA:					        tipoconfirmacionInstitucion
-- ACCION:				      	Create table
-- DESCRIPCIÓN:			    	nueva tabla de confirmacion
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:			    	Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- -------------------------------------------------------------- 
-- DROP TABLE IF EXISTS tipoconfirmacionInstitucion;
CREATE TABLE tipoconfirmacionInstitucion (
  idtipoconfirmacion int(11) NOT NULL,
  tipoconfirmacion varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  color varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  dateinsert timestamp NOT NULL DEFAULT current_timestamp(),
  userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dateupdate timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					        tipoconfirmacionInstitucion
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	indice de la tabla tipoconfirmacionInstitucion
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:			    	Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- -------------------------------------------------------------- 
ALTER TABLE `tipoconfirmacionInstitucion`
  ADD PRIMARY KEY (`idtipoconfirmacion`),
  ADD UNIQUE KEY `ak_tipoatencion_tipoconfirmacionInstitucion` (`tipoconfirmacion`,`estado`);

-- -------------------------------------------------------------
-- TABLA:					        tipoconfirmacionInstitucion
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	AUTO_INCREMENT de la tabla tipoconfirmacionInstitucion
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:			    	Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- -------------------------------------------------------------- 
ALTER TABLE `tipoconfirmacionInstitucion`
  MODIFY `idtipoconfirmacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7; 

-- -------------------------------------------------------------
-- TABLA:					        tipoconfirmacionInstitucion
-- ACCION:				      	INSERT INTO
-- DESCRIPCIÓN:			    	insersion de datos en tipoconfirmacionInstitucion
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:			    	Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- -------------------------------------------------------------- 
INSERT INTO `tipoconfirmacionInstitucion` (`idtipoconfirmacion`, `tipoconfirmacion`, `color`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Sin Confirmar', 'badge-info', 'A', 'sistemas@padinsolutions.com', '2022-04-27 10:11:50', NULL, '2022-04-27 10:11:50'),
(2, 'Confirmado', 'badge-success', 'A', 'sistemas@padinsolutions.com', '2022-04-27 10:11:50', NULL, '2022-04-27 10:11:50'),
(3, 'No Participa', 'badge-danger', 'A', 'sistemas@padinsolutions.com', '2022-04-27 10:11:50', NULL, '2022-04-27 10:11:50');

-- -------------------------------------------------------------
-- TABLA:					        atencionesInstitucion
-- ACCION:				      	CREATE TABLE
-- DESCRIPCIÓN:			    	nueva tabla de atencion a intituciones
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:			    	Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- -------------------------------------------------------------- 
-- DROP TABLE IF EXISTS atencionesInstitucion;
CREATE TABLE atencionesInstitucion (
  idatencion int(11) NOT NULL,
  iduser int(11) NOT NULL,
  idinstitucion int(11) NOT NULL,
  fechaatencion timestamp NOT NULL DEFAULT current_timestamp(),
  comentario varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  idtipoconfirmacion int(11) NOT NULL DEFAULT 1,
  idcampania int(11) NOT NULL,
  estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  dateinsert timestamp NOT NULL DEFAULT current_timestamp(),
  userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dateupdate timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					        atencionesInstitucion
-- ACCION:				      	Alter table
-- DESCRIPCIÓN:			    	Indice de la tabla atencionesInstitucion
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
ALTER TABLE `atencionesInstitucion`
  ADD PRIMARY KEY (`idatencion`),
  ADD KEY `fk_iduser_atencionesInstitucion` (`iduser`),
  ADD KEY `fk_idtipoconfirmacion_atencionesInstitucion` (`idtipoconfirmacion`),
  ADD KEY `fk_idcampania_atencionesInstitucion` (`idcampania`),
  ADD KEY `fk_idinstitucion_atencionesInstitucion` (`idinstitucion`);

-- -------------------------------------------------------------
-- TABLA:					        atencionesInstitucion
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	AUTO_INCREMENT de la tabla atencionesInstitucion
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
ALTER TABLE `atencionesInstitucion`
  MODIFY `idatencion` int(11) NOT NULL AUTO_INCREMENT;

-- -------------------------------------------------------------
-- TABLA:					        atencionesInstitucion
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	Referencias foraneas en la tabla atencionesInstitucion
-- FECHA DE CREACIÓN:	  	28-04-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			
-- --------------------------------------------------------------
ALTER TABLE `atencionesInstitucion`
ADD CONSTRAINT `fk_idinstitucion_atencionesInstitucion` FOREIGN KEY (`idinstitucion`) REFERENCES `instituciones` (`idinstitucion`),
ADD CONSTRAINT `fk_idtipoconfirmacion_atencionesInstitucion` FOREIGN KEY (`idtipoconfirmacion`) REFERENCES `tipoconfirmacionInstitucion` (`idtipoconfirmacion`),
ADD CONSTRAINT `fk_idcampania_atencionesInstitucion` FOREIGN KEY (`idcampania`) REFERENCES `campanias` (`idcampania`),
ADD CONSTRAINT `fk_iduser_atencionesInstitucion` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	registros nuevos organico default
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    
-- FECHA DE MODIFICACIÓN:	29-04-2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------
ALTER TABLE clientes
CHANGE COLUMN procedencia procedencia VARCHAR(300) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT 'Orgánico' ;

/**********************************************************************/
-- -------------------------------------------------------------
-- TABLA:					        eventos
-- ACCION:				      	Create Table
-- DESCRIPCIÓN:			    	nueva tabla asociada con cliente y campaña
-- FECHA DE CREACIÓN:	  	04-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
DROP TABLE IF EXISTS eventos;
CREATE TABLE eventos (
  idevento int(11) NOT NULL,
  nombreevento varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  fechainicio timestamp NULL DEFAULT NULL,
  fechafin timestamp NULL DEFAULT NULL,
  idcampania int(11) NOT NULL,
  estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  dateinsert timestamp NOT NULL DEFAULT current_timestamp(),
  userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dateupdate timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					        eventos
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	Indice de la tabla eventos
-- FECHA DE CREACIÓN:	  	04-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
ALTER TABLE eventos
  ADD PRIMARY KEY (idevento),
  ADD UNIQUE KEY ak_nombreevento_eventos (nombreevento,estado),
  ADD KEY fk_idcampania_eventos (idcampania);

-- -------------------------------------------------------------
-- TABLA:					        eventos
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	AUTO_INCREMENT de la tabla eventos
-- FECHA DE CREACIÓN:	  	04-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
ALTER TABLE eventos
  MODIFY idevento int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- -------------------------------------------------------------
-- TABLA:					        eventos
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	Filtros para la tabla eventos
-- FECHA DE CREACIÓN:	  	04-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
ALTER TABLE eventos
  ADD CONSTRAINT fk_idcampania_eventos FOREIGN KEY (idcampania) REFERENCES campanias (idcampania);  


-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	valor por defecto coddistrito
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    
-- FECHA DE MODIFICACIÓN:	04-05-2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------
ALTER TABLE clientes
CHANGE COLUMN coddistrito coddistrito CHAR(6) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT '  ' ;

-- -------------------------------------------------------------
-- TABLA:					        importaciones
-- ACCION:				      	ADD
-- DESCRIPCIÓN:			    	agregamos el idcampania par idicar la campaña en el que se subira la importacion de clientes NUEVO
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    
-- FECHA DE MODIFICACIÓN:	04-05-2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------
Alter table importaciones
	add idcampania int(11) null AFTER cantregistros;

/*creamos la tabla evento_cliente*/
-- -------------------------------------------------------------
-- TABLA:					        evento_cliente
-- ACCION:				      	Create TABLE
-- DESCRIPCIÓN:			    	creamos la tabla intemediaria evento_cliente
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    
-- FECHA DE MODIFICACIÓN:	04-05-2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------
-- DROP TABLE IF EXISTS evento_cliente;
CREATE TABLE evento_cliente (
  ideventocliente int (11) NOT NULL,
  idevento int(11) NOT NULL,
  idcliente int(11) NOT NULL,
  
  nombres varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  apellidos varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  telefono varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  edad int NOT NULL,
  dni char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  fecharegistro timestamp NOT NULL DEFAULT current_timestamp(),
  coddistrito char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  utm varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  campaign_content varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  campaign_medium varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  campaign_name varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  campaign_source varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  campaign_term varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  procedencia varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  grado varchar(150) collate utf8mb4_unicode_ci DEFAULT NULL,
  carrera varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  origen varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  tipoparticipante varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  colegio varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  anioegreso int(11) NOT NULL DEFAULT 0,
  uuidimportacion char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  
  asistencia int(11) NOT NULL DEFAULT 0,
  fechaasistencia timestamp null default null,
  estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  dateinsert timestamp NOT NULL DEFAULT current_timestamp(),
  userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dateupdate timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indices de la tabla `eventos`
--
ALTER TABLE evento_cliente
  ADD PRIMARY KEY (ideventocliente,idevento,idcliente),
  ADD KEY fk_idevento_evento_cliente (idevento),
  ADD KEY fk_idcliente_evento_cliente (idcliente);

-- AUTO_INCREMENT de la tabla `campanias`
--
ALTER TABLE evento_cliente
  MODIFY ideventocliente int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


-- Filtros para la tabla `eventos`
--
ALTER TABLE evento_cliente
  ADD CONSTRAINT fk_idevento_evento_cliente FOREIGN KEY (idevento) REFERENCES eventos (idevento),
  ADD CONSTRAINT fk_idcliente_evento_cliente FOREIGN KEY (idcliente) REFERENCES clientes (idcliente);

/*************************************************************/
/***************** Reportes **********************************/
/*************************************************************/
-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Cliente x Fechas
-- FECHA DE CREACIÓN:	  	07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
-- Start 

-- DROP PROCEDURE IF EXISTS SP_REGSITROSFECHAS_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGSITROSFECHAS_CLIENTES
(
	-- idcuenta int(11)
	f_idevento int(11),
	f_idcampania int(11)

)
BEGIN
	declare v_totalcliente int(11);
    SET v_totalcliente = (select count(cl.idcliente) 
							from clientes cl inner join campanias ca on cl.idcampania = ca.idcampania
                            where cl.estado = 'A' and ca.idcampania = f_idcampania);                        

	SET lc_time_names = 'es_ES' ;
   
	if f_idevento > 0 then
        select cl.idcampania, ec.idevento, DATE_FORMAT(cl.fecharegistro,'%M-%d') as fechaGeneral, count(ec.idcliente) as total, v_totalcliente as cantidadprospectos
		FROM clientes cl inner join evento_cliente ec on cl.idcliente = ec.idcliente
		where cl.estado = 'A' 
        and cl.idcampania = f_idcampania
		and ec.idevento = f_idevento 		
		group by fechaGeneral
		order by cl.fecharegistro asc;
    else    
		select idcampania, DATE_FORMAT(fecharegistro,'%M-%d') as fechaGeneral, count(idcliente) as total, v_totalcliente as cantidadprospectos
		FROM clientes
		where estado = 'A' 
        and idcampania = f_idcampania	
		group by fechaGeneral
		order by fecharegistro asc;
    end if;
END//
DELIMITER ;

-- CALL SP_REGSITROSFECHAS_CLIENTES(2,9);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Cliente x carrera
-- FECHA DE CREACIÓN:	  	07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- -------------------------------------------------------------- 
-- DROP PROCEDURE IF EXISTS SP_REGISITROCARRERA_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGISITROCARRERA_CLIENTES
(
	f_idevento int(11),
	f_idcampania int(11)
)
BEGIN

	if f_idevento > 0 then
    
        select ec.carrera, ec.idevento, cl.idcampania, count(ec.idcliente) as total 
		FROM clientes cl INNER JOIN evento_cliente ec ON cl.idcliente = ec.idcliente
		where cl.estado = 'A' and ec.idevento = f_idevento and cl.idcampania = f_idcampania 
		group by ec.carrera
		order by total desc;
    else 
    
        select carrera, idcampania, count(idcliente) as total 
		FROM clientes 
		where estado = 'A' and idcampania = f_idcampania
		group by carrera
		order by total desc;
    end if;
END//
DELIMITER ;
-- CALL SP_REGISITROCARRERA_CLIENTES(0,1);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Evento x Campaña
-- FECHA DE CREACIÓN:	  	07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- -------------------------------------------------------------- 
-- DROP PROCEDURE IF EXISTS SP_REGSITROEVENTOSCAMPANIA_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGSITROEVENTOSCAMPANIA_CLIENTES
(
	f_idevento int(11),
	f_idcampania int(11)
)
BEGIN
	
    if f_idevento > 0 then
		select e.nombreevento, ec.idevento, cl.idcampania, count(ec.idcliente) as total
		FROM clientes cl INNER JOIN evento_cliente ec ON cl.idcliente = ec.idcliente
        inner join eventos e on e.idevento = ec.idevento

		where cl.estado = 'A' and e.idcampania = f_idcampania and ec.idevento = f_idevento
		group by nombreevento
		order by total desc;
        
    else
		select e.nombreevento, ec.idevento, cl.idcampania, count(ec.idcliente) as total
		FROM clientes cl INNER JOIN evento_cliente ec ON cl.idcliente = ec.idcliente
        inner join eventos e on e.idevento = ec.idevento

		where cl.estado = 'A' and e.idcampania = f_idcampania
		group by nombreevento
		order by total desc;
        
	end if;    
    
END//
DELIMITER ;
-- CALL SP_REGSITROEVENTOSCAMPANIA_CLIENTES(0,10);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Cliente procedencia
-- FECHA DE CREACIÓN:	  	07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- -------------------------------------------------------------- 
-- DROP PROCEDURE IF EXISTS SP_REGSITROPROCEDENCIA_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGSITROPROCEDENCIA_CLIENTES
(
	f_idevento int(11),
	f_idcampania int(11)
)
BEGIN
	
    if f_idevento > 0 then

        select ec.procedencia, ec.idevento, cl.idcampania, count(ec.idcliente) as total
		FROM clientes cl INNER JOIN evento_cliente ec ON cl.idcliente = ec.idcliente
        where cl.estado = 'A'  and ec.idevento = f_idevento and cl.idcampania = f_idcampania
		group by procedencia
		order by total desc;
        
	else
        select procedencia, idcampania, count(idcliente) as total
		FROM clientes 
        where estado = 'A' and idcampania = f_idcampania
		group by procedencia
		order by total desc;
	end if;
    
END//
DELIMITER ;
-- CALL SP_REGSITROPROCEDENCIA_CLIENTES(0,10);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Cliente asistemcias
-- FECHA DE CREACIÓN:	  	07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
-- DROP PROCEDURE IF EXISTS SP_REGSITROAASISTENCIAS_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGSITROAASISTENCIAS_CLIENTES
(
	f_idevento int(11),
	f_idcampania int(11)
)
BEGIN
	
    if f_idevento > 0 then    
        select replace(replace(ec.asistencia, '1', 'Si' ) ,'0', 'No') as asistencianame,
		ec.idevento, cl.idcampania, count(ec.idcliente) as total
		FROM clientes cl INNER JOIN evento_cliente ec ON cl.idcliente = ec.idcliente
		where cl.estado = 'A' and ec.idevento = f_idevento and cl.idcampania = f_idcampania 
		group by asistencianame
		order by total desc;
	else        
        select replace(replace(asistencia, '1', 'Si' ) ,'0', 'No') as asistencianame, idcampania, count(idcliente) as total
		FROM clientes 
		where estado = 'A' and idcampania = f_idcampania
		group by asistencianame
		order by total desc;
	end if;
	
END//
DELIMITER ;
-- CALL SP_REGSITROAASISTENCIAS_CLIENTES(4,10);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Cliente edad
-- FECHA DE CREACIÓN:	  	07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
-- DROP PROCEDURE IF EXISTS SP_REGISITROEDAD_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGISITROEDAD_CLIENTES
(
	f_idevento int(11),
	f_idcampania int(11)
)
BEGIN
	if f_idevento > 0 then        
        select ec.edad,  ec.idevento, cl.idcampania, count(ec.idcliente) as total 
		FROM clientes cl INNER JOIN evento_cliente ec on cl.idcliente = ec.idcliente
		where cl.estado = 'A' and ec.idevento = f_idevento and cl.idcampania = f_idcampania 
		group by ec.edad
		order by ec.edad desc;
	else
		select edad, idcampania, count(idcliente) as total 
		FROM clientes 
		where estado = 'A' and idcampania = f_idcampania
		group by edad
		order by edad desc;
	end if;

END//
DELIMITER ;
-- CALL SP_REGISITROEDAD_CLIENTES(0,10);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Cliente colegios
-- FECHA DE CREACIÓN:	  	07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
-- DROP PROCEDURE IF EXISTS SP_REGISITROINSTITUCION_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGISITROINSTITUCION_CLIENTES
(
	f_idevento int(11),
	f_idcampania int(11)
)
BEGIN

	if f_idevento > 0 then        
        select ec.colegio, ec.idevento, cl.idcampania, count(ec.idcliente) as total 
		FROM clientes cl INNER JOIN evento_cliente ec ON cl.idcliente = ec.idcliente
		where cl.estado = 'A' and ec.idevento = f_idevento and cl.idcampania = f_idcampania
		group by ec.colegio
		order by total desc;
	else
		select colegio, idcampania, count(idcliente) as total 
		FROM clientes
		where estado = 'A' and idcampania = f_idcampania
		group by colegio
		order by total desc;
	end if;
	
END//
DELIMITER ;
-- CALL SP_REGISITROINSTITUCION_CLIENTES(0,9);

-- -------------------------------------------------------------
-- TABLA:					        clientes
-- ACCION:				      	CREATE PROCEDURE
-- DESCRIPCIÓN:			    	Reporte Cliente grados
-- FECHA DE CREACIÓN:	  	20-06-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
-- DROP PROCEDURE IF EXISTS SP_REGSITROGRADO_CLIENTES;
DELIMITER //
CREATE PROCEDURE SP_REGSITROGRADO_CLIENTES
(
	f_idevento int(11),
	f_idcampania int(11)
)
BEGIN

    if f_idevento > 0 then    
        select ec.idevento, cl.idcampania, cl.grado, count(ec.idcliente) as total
		FROM clientes cl INNER JOIN evento_cliente ec ON cl.idcliente = ec.idcliente
		where cl.estado = 'A' and ec.idevento = f_idevento and cl.idcampania = f_idcampania 
		group by cl.grado
		order by total desc;
	else        
        select idcampania, grado, count(idcliente) as total
		FROM clientes 
		where estado = 'A' and idcampania = f_idcampania
		group by grado
		order by total desc;
	end if;
	
END//
DELIMITER ;

-- CALL SP_REGSITROGRADO_CLIENTES(0,9);
-- -------------------------------------------------------------
-- TABLA:					        INSTITUCIONES
-- ACCION:				      	ADD telefonoalterno
-- DESCRIPCIÓN:			    	Creamos tala alerta
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	19/05/2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------
alter table instituciones
	add telefonoalterno int(11) NULL AFTER cargoalterno;

-- -------------------------------------------------------------
-- TABLA:					        INSTITUCIONES
-- ACCION:				      	drop foreign key
-- DESCRIPCIÓN:			    	eliminamos referencia 
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	19/05/2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------  
alter table instituciones
  drop foreign key fk_idcuenta_instituciones;

-- -------------------------------------------------------------
-- TABLA:					        INSTITUCIONES
-- ACCION:				      	drop key
-- DESCRIPCIÓN:			    	eliminamos llave unica
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	19/05/2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------  
alter table instituciones
  drop key fk_idcuenta_instituciones;  

-- -------------------------------------------------------------
-- TABLA:					        INSTITUCIONES
-- ACCION:				      	change
-- DESCRIPCIÓN:			    	cambiamos el nombre del atributo idcuenta a iduser 
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	19/05/2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- --------------------------------------------------------------     
alter table instituciones
  change idcuenta iduser int(11) NOT NULL;

-- -------------------------------------------------------------
-- TABLA:					        INSTITUCIONES
-- ACCION:				      	ADD KEY
-- DESCRIPCIÓN:			    	Añadimos Indices
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	19/05/2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- -------------------------------------------------------------- 
ALTER TABLE instituciones
  ADD KEY fk_iduser_instituciones (iduser);

-- -------------------------------------------------------------
-- TABLA:					        INSTITUCIONES
-- ACCION:				      	ADD CONSTRAINT
-- DESCRIPCIÓN:			    	filtros instituciones - user
-- FECHA DE CREACIÓN:	  	
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	19/05/2022
-- MODIFICADO POR:			  Yhonatan Fernandez Cardenas
-- -------------------------------------------------------------- 
ALTER TABLE instituciones
  ADD CONSTRAINT fk_iduser_instituciones FOREIGN KEY (iduser) REFERENCES users (id);
  
-- -------------------------------------------------------------
-- TABLA:					    alertas
-- ACCION:				      	CREATE TABLE
-- DESCRIPCIÓN:			    	Creamos tala alerta
-- FECHA DE CREACIÓN:	  		07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
DROP TABLE IF EXISTS alertas;
CREATE TABLE alertas (
  idalerta int(11) NOT NULL,
  nombrealerta varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  descripcionalerta varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  urlalerta varchar(150) COLLATE utf8mb4_unicode_ci NULL,
  fechainicio timestamp NULL DEFAULT NULL,
  fechafin timestamp NULL DEFAULT NULL,
  idcampania int(11) NOT NULL,
  estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  dateinsert timestamp NOT NULL DEFAULT current_timestamp(),
  userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dateupdate timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- TABLA:					    alertas
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	INDICE ALERTAS
-- FECHA DE CREACIÓN:	  		07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
ALTER TABLE alertas
  ADD PRIMARY KEY (idalerta),
  ADD UNIQUE KEY ak_nombrealerta_alertas (nombrealerta,estado),
  ADD KEY fk_idcampania_alertas (idcampania);
  
-- -------------------------------------------------------------
-- TABLA:					    alertas
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	AUTOINCREMENT ALERTAS
-- FECHA DE CREACIÓN:	  		07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------  
ALTER TABLE alertas
  MODIFY idalerta int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- -------------------------------------------------------------
-- TABLA:					    alertas
-- ACCION:				      	ALTER TABLE
-- DESCRIPCIÓN:			    	FILTROS TABLA ALERTAS
-- FECHA DE CREACIÓN:	  		07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- --------------------------------------------------------------
ALTER TABLE alertas
  ADD CONSTRAINT fk_idcampania_alertas FOREIGN KEY (idcampania) REFERENCES campanias (idcampania);  



  /*****************************************************************************/
 -- -------------------------------------------------------------
-- TABLA:					    Evento_cliente
-- ACCION:				      	store procedure
-- DESCRIPCIÓN:			    	validamos si existe el registro cliente en la tabla evento_cliente
-- FECHA DE CREACIÓN:	  		07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- -------------------------------------------------------------- 
  -- store procedure para la landings
-- DROP PROCEDURE IF EXISTS SP_VALIDATE_CLIENTE_EVENTOS;
DELIMITER //
CREATE PROCEDURE SP_VALIDATE_CLIENTE_EVENTOS
(
	p_idcliente int(11),
    p_idevento int(11)
	-- p_idcampania int(11)	
)  
BEGIN

	declare v_validate char(1);
	-- set v_validate =(SELECT idcampania FROM eventos where idevento = p_idevento and idcampania = p_idcampania);
    SELECT * FROM evento_cliente where idcliente = p_idcliente and idevento = p_idevento;
    
END//
DELIMITER ;

 -- -------------------------------------------------------------
-- TABLA:					    Evento_cliente
-- ACCION:				      	store procedure
-- DESCRIPCIÓN:			    	validar si existe una campaña con el evento.
-- FECHA DE CREACIÓN:	  		07-05-2022
-- CREADO POR:				    Yhonatan Fernandez Cardenas
-- FECHA DE MODIFICACIÓN:	
-- MODIFICADO POR:			  
-- -------------------------------------------------------------- 
-- validar si existe una campaña con el evento
-- DROP PROCEDURE IF EXISTS SP_VALIDATE_CAMPANIA_EVENTO;
DELIMITER //
CREATE PROCEDURE SP_VALIDATE_CAMPANIA_EVENTO(
	vali_idevento int(11)
)
BEGIN
	select ca.nombrecampania, ca.idcampania , e.idevento
    from campanias ca inner join eventos e on ca.idcampania = e.idcampania
    where e.estado = 'A' and e.idevento = vali_idevento;
    
END//
DELIMITER ;

-- agregamops el celular alterno 
  alter table instituciones
	add celularalterno varchar(9) NULL DEFAULT 0 AFTER cargoalterno;

-- VALOR DEFINIDO celular  
  ALTER TABLE instituciones
CHANGE COLUMN `celular` `celular` VARCHAR(20) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT '0' ;

-- Creamos tabla invitaciones 
DROP TABLE IF EXISTS invitaciones;
CREATE TABLE invitaciones (
  idinvitacion int(11) NOT NULL,
  nombreinstitucion varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  nombreencargado varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  fecharegistro timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  idinstitucion int(11) NULL default NULL,  
  iduser int(11) NULL,
  estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  dateinsert timestamp NOT NULL DEFAULT current_timestamp(),
  userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dateupdate timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Indices de la tabla `invitaciones`
ALTER TABLE invitaciones
  ADD KEY fk_iduser_invitaciones (iduser);
  -- ADD KEY fk_coddistrito_instituciones (coddistrito);
  
-- filtros invitaciones - user
ALTER TABLE invitaciones
  ADD CONSTRAINT fk_iduser_invitaciones FOREIGN KEY (iduser) REFERENCES users (id);
  -- ADD CONSTRAINT fk_coddistrito_instituciones FOREIGN KEY (coddistrito) REFERENCES ubigeos (pkubigeo);  
  
  
ALTER TABLE invitaciones
  ADD PRIMARY KEY (idinvitacion),
  ADD UNIQUE KEY ak_nombreencargado_nombreinstitucion__insticuiones (nombreinstitucion,nombreencargado,estado),
  ADD KEY fk_idinstitucion_invitaciones (idinstitucion);
  
-- AUTO_INCREMENT de la tabla `invitaciones`
--
ALTER TABLE invitaciones
  MODIFY idinvitacion int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
-- Filtros para la tabla `invitaciones`
--
ALTER TABLE invitaciones
  ADD CONSTRAINT fk_idinstitucion_invitaciones FOREIGN KEY (idinstitucion) REFERENCES instituciones (idinstitucion);  
  
  
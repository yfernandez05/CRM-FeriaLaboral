use crmchat;


CREATE TABLE `perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userupdate` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idcliente` (`idcliente`),
  FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userupdate` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `roles` (`idrol`, `rol`, `estado`, `userinsert`, `dateinsert`) VALUES ('6', 'EMPRESA LABORAL', 'A', 'sistemas@padinsolutions.com', '2023-06-15 12:53:12');

CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruc` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `razonsocial` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userupdate` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idempresa`),
  UNIQUE KEY `ak_ruc_cuentas` (`ruc`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `empleos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `idempresa` INT(11) NOT NULL,
  `titulo` VARCHAR(150) NOT NULL,
  `descripcion` TEXT,
  `requisitos` TEXT,
  `fecha_publicacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_cierre`  timestamp NULL DEFAULT NULL,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userupdate` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `cliente_empleo` (
  `idcliente_empleo` INT PRIMARY KEY AUTO_INCREMENT,
  `idcliente` INT NOT NULL,
  `idempleo` INT NOT NULL,
  `fecha`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userupdate` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE INDEX `unique_cliente_empleo` (`idcliente`, `idempleo`),
  FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  FOREIGN KEY (`idempleo`) REFERENCES `empleos` (`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `users` ADD COLUMN `idempresa` INT(11) NULL AFTER `idcuenta`;

ALTER TABLE `clientes` 
CHANGE COLUMN `origen` `origen` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL;

-- validar si es necvsario boorar el idempleo
-- ALTER TABLE `clientes` ADD COLUMN `idempleo` INT(11) NULL AFTER `idcampania`;



-- update dni unique and email not unique
ALTER TABLE `clientes` DROP INDEX `ak_email_idcampania_clientes`;
ALTER TABLE `clientes` ADD UNIQUE `ak_dni_idcampania_clientes` (`dni`, `idcampania`, `estado`);

-- update edad no required
ALTER TABLE `clientes` 
CHANGE COLUMN `edad` `edad` INT(11) NULL ;

-- new colum cliente:
ALTER TABLE `clientes` ADD COLUMN `descripcion` TEXT NULL AFTER `dni`;
ALTER TABLE `clientes` ADD COLUMN `direccion` varchar(350) NULL AFTER `descripcion`;
ALTER TABLE `clientes` ADD COLUMN `empresaactual` varchar(350) NULL AFTER `direccion`;
ALTER TABLE `clientes` ADD COLUMN `cargoactual` varchar(350) NULL AFTER `empresaactual`;




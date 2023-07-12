
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `email` varchar(60) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `dni` char(8) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `minsalarial` varchar(100) DEFAULT NULL,
  `maxsalarial` varchar(100) DEFAULT NULL,
  `empresaactual` text DEFAULT NULL,
  `cargoactual` text DEFAULT NULL,
  `idcampania` int(11) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT current_timestamp(),
  `coddistrito` char(6) DEFAULT '',
  `utm` varchar(300) DEFAULT NULL,
  `campaign_content` varchar(300) DEFAULT NULL,
  `campaign_medium` varchar(300) DEFAULT NULL,
  `campaign_name` varchar(300) DEFAULT NULL,
  `campaign_source` varchar(300) DEFAULT NULL,
  `campaign_term` varchar(300) DEFAULT NULL,
  `procedencia` varchar(300) DEFAULT 'Orgánico',
  `grado` varchar(150) DEFAULT NULL,
  `carrera` varchar(150) DEFAULT NULL,
  `origen` text DEFAULT NULL,
  `evento` varchar(150) DEFAULT NULL,
  `tipoparticipante` varchar(150) DEFAULT NULL,
  `colegio` varchar(150) DEFAULT NULL,
  `anioegreso` int(11) NOT NULL DEFAULT 0,
  `uuidimportacion` char(36) DEFAULT NULL,
  `idtipoatencion` int(11) NOT NULL DEFAULT 1,
  `asistencia` int(11) NOT NULL DEFAULT 0,
  `fechaasistencia` timestamp NULL DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `moderador` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

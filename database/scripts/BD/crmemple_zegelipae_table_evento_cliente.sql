
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento_cliente`
--

CREATE TABLE `evento_cliente` (
  `ideventocliente` int(11) NOT NULL,
  `idevento` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `email` varchar(60) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `edad` int(11) NOT NULL,
  `dni` char(8) DEFAULT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT current_timestamp(),
  `coddistrito` char(6) DEFAULT NULL,
  `utm` varchar(300) DEFAULT NULL,
  `campaign_content` varchar(300) DEFAULT NULL,
  `campaign_medium` varchar(300) DEFAULT NULL,
  `campaign_name` varchar(300) DEFAULT NULL,
  `campaign_source` varchar(300) DEFAULT NULL,
  `campaign_term` varchar(300) DEFAULT NULL,
  `procedencia` varchar(300) DEFAULT NULL,
  `grado` varchar(150) DEFAULT NULL,
  `carrera` varchar(150) DEFAULT NULL,
  `origen` varchar(100) DEFAULT NULL,
  `tipoparticipante` varchar(150) DEFAULT NULL,
  `colegio` varchar(150) DEFAULT NULL,
  `anioegreso` int(11) NOT NULL DEFAULT 0,
  `uuidimportacion` char(36) DEFAULT NULL,
  `asistencia` int(11) NOT NULL DEFAULT 0,
  `fechaasistencia` timestamp NULL DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

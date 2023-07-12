
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_laboral`
--

CREATE TABLE `historial_laboral` (
  `id` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `empresa` varchar(200) NOT NULL,
  `actividad` varchar(200) DEFAULT NULL,
  `puesto` varchar(200) DEFAULT NULL,
  `nivel` varchar(150) DEFAULT NULL,
  `area` varchar(200) DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafinalizacion` timestamp NULL DEFAULT NULL,
  `fechapresente` char(1) DEFAULT '0',
  `descripcion` text DEFAULT NULL,
  `personaacargo` varchar(10) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

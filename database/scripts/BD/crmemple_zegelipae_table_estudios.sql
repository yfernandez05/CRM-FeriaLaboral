
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudios`
--

CREATE TABLE `estudios` (
  `id` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `carrera` varchar(250) DEFAULT NULL,
  `tipoestudio` varchar(150) DEFAULT NULL,
  `estadoestudio` varchar(100) DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafinalizacion` timestamp NULL DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

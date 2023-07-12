
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atenciones`
--

CREATE TABLE `atenciones` (
  `idatencion` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fechaatencion` timestamp NOT NULL DEFAULT current_timestamp(),
  `comentario` varchar(500) NOT NULL,
  `idtipoatencion` int(11) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

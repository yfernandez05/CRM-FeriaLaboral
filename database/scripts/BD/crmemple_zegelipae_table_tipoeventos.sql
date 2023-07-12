
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoeventos`
--

CREATE TABLE `tipoeventos` (
  `idtipoevento` int(11) NOT NULL,
  `tipoevento` varchar(150) NOT NULL,
  `backgroundColor` varchar(500) DEFAULT '#d3d3d3',
  `textColor` varchar(500) DEFAULT '#000',
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipoeventos`
--

INSERT INTO `tipoeventos` (`idtipoevento`, `tipoevento`, `backgroundColor`, `textColor`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Presenciales', '#00b9bc', '#ffffff', 'A', 'sistemas@padinsolutions.com', '2023-01-14 05:57:00', 'sistemas@padinsolutions.com', '2023-01-14 06:21:38'),
(2, 'Virtual', '#3035bb', '#ffffff', 'A', 'sistemas@padinsolutions.com', '2023-01-14 06:39:42', NULL, NULL);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoatenciones`
--

CREATE TABLE `tipoatenciones` (
  `idtipoatencion` int(11) NOT NULL,
  `tipoatencion` varchar(150) NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipoatenciones`
--

INSERT INTO `tipoatenciones` (`idtipoatencion`, `tipoatencion`, `color`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Sin Atender', 'badge-danger', 'A', 'sistemas@padinsolutions.com', '2020-06-27 13:11:50', NULL, '2020-07-06 10:20:06'),
(2, 'Atendido', 'badge-success', 'A', 'sistemas@padinsolutions.com', '2020-06-27 13:11:50', NULL, '2020-07-06 10:20:22'),
(3, 'En proceso', 'badge-warning', 'A', 'sistemas@padinsolutions.com', '2020-06-27 13:11:50', NULL, '2020-07-11 01:27:27'),
(4, 'Rechazado', 'badge-secondary', 'A', 'sistemas@padinsolutions.com', '2020-06-27 13:11:50', NULL, '2020-07-06 10:20:55'),
(5, 'Finalizado', 'badge-info', 'A', 'sistemas@padinsolutions.com', '2020-06-27 13:11:50', NULL, '2020-07-06 10:21:09');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(150) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `rol`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Administrador Sistema', 'A', 'sistemas@padinsolutions.com', '2020-06-21 06:53:34', NULL, NULL),
(2, 'Administrador', 'A', 'sistemas@padinsolutions.com', '2020-06-21 06:53:34', NULL, NULL),
(3, 'Estandar ', 'A', 'sistemas@padinsolutions.com', '2020-06-21 06:53:34', NULL, NULL),
(4, 'Editor', 'A', 'sistemas@padinsolutions.com', '2020-06-21 06:53:34', NULL, NULL),
(5, 'Asesor Comercial', 'A', 'sistemas@padinsolutions.com', '2022-05-13 23:37:54', NULL, NULL),
(6, 'EMPRESA LABORAL', 'A', 'sistemas@padinsolutions.com', '2023-06-16 00:53:12', NULL, '2023-06-16 00:55:44');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclo`
--

CREATE TABLE `ciclo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ciclo`
--

INSERT INTO `ciclo` (`id`, `nombre`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'I A III', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:23:27', NULL, NULL),
(2, 'IV', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:23:33', NULL, NULL),
(3, 'V', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:23:40', NULL, NULL),
(4, 'VI', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:23:44', NULL, NULL),
(5, 'VII', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:23:48', NULL, NULL),
(6, 'VIII', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:23:52', NULL, NULL),
(7, 'Egresados', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:23:57', NULL, NULL),
(8, 'Diplomados', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:24:04', NULL, NULL);

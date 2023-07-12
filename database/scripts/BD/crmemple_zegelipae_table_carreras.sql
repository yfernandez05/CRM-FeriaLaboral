
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `idcarrera` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`idcarrera`, `nombre`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Diseño Gráfico', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:13:23', NULL, NULL),
(2, 'Administración Bancaria', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:13:42', NULL, NULL),
(3, 'Administración de Empresas', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:13:50', NULL, NULL),
(4, 'Administración de Negocios', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:01', NULL, NULL),
(5, 'Contabilidad', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:08', NULL, NULL),
(6, 'Logística', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:16', NULL, NULL),
(7, 'Marketing', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:23', NULL, NULL),
(8, 'Negocios Internacionales', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:31', NULL, NULL),
(9, 'Recursos Humanos', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:39', NULL, NULL),
(10, 'Computación e informática', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:48', NULL, NULL),
(11, 'Asesor Financiero', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:14:55', NULL, NULL),
(12, 'Técnico en Farmacia', 'A', 'sistemas@padinsolutions.com', '2023-06-28 21:15:03', NULL, NULL);

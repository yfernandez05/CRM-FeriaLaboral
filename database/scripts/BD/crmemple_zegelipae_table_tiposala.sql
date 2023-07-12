
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposala`
--

CREATE TABLE `tiposala` (
  `idtiposala` int(11) NOT NULL,
  `tiposala` varchar(150) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tiposala`
--

INSERT INTO `tiposala` (`idtiposala`, `tiposala`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'publica', 'A', 'sistemas@padinsolutions.com', '2022-08-02 04:25:47', NULL, NULL),
(2, 'privadas', 'A', 'sistemas@padinsolutions.com', '2022-08-02 04:26:15', NULL, NULL);

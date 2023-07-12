
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campanias`
--

CREATE TABLE `campanias` (
  `idcampania` int(11) NOT NULL,
  `nombrecampania` varchar(150) NOT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `idcuenta` int(11) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `campanias`
--

INSERT INTO `campanias` (`idcampania`, `nombrecampania`, `fechainicio`, `fechafin`, `idcuenta`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Feria Zegel IPAE 2023', '2023-07-10 06:59:59', '2023-07-17 06:59:59', 1, 'A', 'sistemas@padinsolutions.com', '2020-09-09 06:40:55', 'sistemas@padinsolutions.com', '2023-06-29 15:37:22');

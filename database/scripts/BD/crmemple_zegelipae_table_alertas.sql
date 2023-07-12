
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE `alertas` (
  `idalerta` int(11) NOT NULL,
  `nombrealerta` varchar(150) NOT NULL,
  `descripcionalerta` varchar(150) DEFAULT NULL,
  `urlalerta` varchar(150) DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `idcampania` int(11) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alertas`
--

INSERT INTO `alertas` (`idalerta`, `nombrealerta`, `descripcionalerta`, `urlalerta`, `fechainicio`, `fechafin`, `idcampania`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(2, 'Bienvenido !!', 'Bienvenid@s a la feria laboral Zegel IPAE', NULL, '2023-06-29 23:47:33', '2023-06-30 07:00:00', 1, 'A', 'sistemas@padinsolutions.com', '2023-06-29 21:48:23', NULL, NULL);

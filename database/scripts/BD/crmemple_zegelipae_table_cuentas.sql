
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `idcuenta` int(11) NOT NULL,
  `empresa` varchar(150) NOT NULL,
  `ruc` char(11) NOT NULL,
  `razonsocial` varchar(150) NOT NULL,
  `contrato` varchar(60) DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `mensual` decimal(7,2) NOT NULL DEFAULT 0.00,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`idcuenta`, `empresa`, `ruc`, `razonsocial`, `contrato`, `fechainicio`, `mensual`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Zegel IPAE', '20553617627', 'SERVICIO EDUCATIVO EMPRESARIAL S.A.C.', '-', '2020-06-20 22:02:49', 0.00, 'A', 'sistemas@padinsolutions.com', '2020-06-21 06:46:46', 'sistemas@padinsolutions.com', '2023-06-16 22:02:49');

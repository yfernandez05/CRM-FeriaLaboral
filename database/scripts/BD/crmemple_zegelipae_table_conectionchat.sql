
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conectionchat`
--

CREATE TABLE `conectionchat` (
  `idconexion` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `userinsert` varchar(60) DEFAULT 'sistemas@padinsolutions.com',
  `dateinsert` timestamp NOT NULL DEFAULT current_timestamp(),
  `userupdate` varchar(60) DEFAULT NULL,
  `dateupdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `conectionchat`
--

INSERT INTO `conectionchat` (`idconexion`, `nombre`, `descripcion`, `estado`, `userinsert`, `dateinsert`, `userupdate`, `dateupdate`) VALUES
(1, 'Chat Feria', 'conexion con estado de conexion Feria ', 'A', 'sistemas@padinsolutions.com', '2022-08-13 05:10:06', NULL, '2022-08-25 04:04:09');

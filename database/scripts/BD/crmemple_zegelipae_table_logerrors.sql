
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logerrors`
--

CREATE TABLE `logerrors` (
  `id` int(11) NOT NULL,
  `classname` varchar(100) NOT NULL,
  `methodname` varchar(100) NOT NULL,
  `errormessage` text NOT NULL,
  `dateoccurred` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

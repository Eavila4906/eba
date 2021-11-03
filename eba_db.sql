--
-- Estructura de tabla para la tabla `modulo`
--

DROP TABLE IF EXISTS `modulo`;
CREATE TABLE IF NOT EXISTS `modulo` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreModulo` varchar(25) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estadoModulo` int(11) NOT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_modulo`, `nombreModulo`, `descripcion`, `estadoModulo`) VALUES
(1, 'Area personal', 'Area personal de los docentes, estudiantes y usuarios que no tengan rol de super administrador ', 1),
(2, 'Dashboard', 'Dashboard', 1),
(3, 'Sitio publico', 'Sitio publico', 1),
(4, 'Usuarios', 'Usuarios del sistema', 1),
(5, 'Roles y Permisos', 'Roles y permisos para los usuarios', 1),
(7, 'Registrar Pagos', 'Llevar el control de pagos de los estudiantes', 1),
(6, 'Contabilidad', 'Contabilidad de los pagos del estudiante', 1),
(8, 'Pagos', 'Describe y proporciona información de todos los pagos realizados', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(25) NOT NULL,
  `descripRol` varchar(200) NOT NULL,
  `estadoRol` int(11) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombreRol`, `descripRol`, `estadoRol`) VALUES
(1, 'Super Administrador', 'Access to all system functionalities', 1),
(2, 'Administrador', 'second-degree role to that of super administrator', 1),
(3, 'Estudiante', 'Acceso limitado de acuerdo al rol estudiante', 1),
(4, 'Docente', 'Acceso limitado de acuerdo al rol docente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `rol` int NOT NULL,
  `modulo` int NOT NULL,
  `r` int NOT NULL DEFAULT 0,
  `w` int NOT NULL DEFAULT 0,
  `u` int NOT NULL DEFAULT 0,
  `d` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_permiso`),
  FOREIGN KEY (`rol`) REFERENCES `roles` (`id_rol`),
  FOREIGN KEY (`modulo`) REFERENCES `modulo` (`id_modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `rol`, `modulo`, `r`, `w`, `u`, `d`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 1, 2, 1, 1, 1, 1),
(3, 1, 3, 1, 1, 1, 1),
(4, 1, 4, 1, 1, 1, 1),
(5, 1, 5, 1, 1, 1, 1),
(6, 1, 7, 1, 1, 1, 1),
(7, 1, 6, 1, 1, 1, 1),
(8, 1, 8, 1, 1, 1, 1),
(9, 4, 1, 1, 0, 0, 0),
(10, 4, 2, 0, 0, 0, 0),
(11, 4, 3, 0, 0, 0, 0),
(12, 4, 4, 0, 0, 0, 0),
(13, 4, 5, 0, 0, 0, 0),
(14, 4, 6, 0, 0, 0, 0),
(15, 4, 7, 0, 0, 0, 0),
(16, 4, 8, 0, 0, 0, 0),
(17, 3, 1, 1, 0, 0, 0),
(18, 3, 2, 0, 0, 0, 0),
(19, 3, 3, 0, 0, 0, 0),
(20, 3, 4, 0, 0, 0, 0),
(21, 3, 5, 0, 0, 0, 0),
(22, 3, 6, 0, 0, 0, 0),
(23, 3, 7, 0, 0, 0, 0),
(24, 3, 8, 0, 0, 0, 0),
(25, 2, 1, 1, 0, 0, 0),
(26, 2, 2, 0, 0, 0, 0),
(27, 2, 3, 0, 0, 0, 0),
(28, 2, 4, 0, 0, 0, 0),
(29, 2, 5, 0, 0, 0, 0),
(30, 2, 6, 0, 0, 0, 0),
(31, 2, 7, 0, 0, 0, 0),
(32, 2, 8, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `DNI` varchar(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `apellidoP` varchar(35) NOT NULL,
  `apellidoM` varchar(35) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `fechaNaci` date NOT NULL,
  `rol` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE (`DNI`),
  FOREIGN KEY (`rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `DNI`, `username`, `password`, `nombres`, `apellidoP`, `apellidoM`, `email`, `telefono`, `sexo`, `fechaNaci`, `rol`, `token`, `estado`, `photo`) VALUES
(1, '1316847586', 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'Jose David', 'Mora', 'Moreira', 'jmora@eba.com', '0988221245', 'M', '1994-01-19', 1, '', 1, 'img_profilef6b7dd2c1cb2ca11a4a03895e12a7d80.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id_notifications` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `leida` int(11) NOT NULL,
  PRIMARY KEY (`id_notifications`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_notifications`
--

DROP TABLE IF EXISTS `detail_notifications`;
CREATE TABLE IF NOT EXISTS `detail_notifications` (
  `id_detail_notifications` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(10) NOT NULL,
  `notifications` int NOT NULL,
  `date` timestamp NOT NULL,
  PRIMARY KEY (`id_detail_notifications`),
  FOREIGN KEY (`usuario`) REFERENCES `usuario` (`DNI`),
  FOREIGN KEY (`notifications`) REFERENCES `notifications` (`id_notifications`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id_student` int(11) NOT NULL AUTO_INCREMENT,
  `estudiante` varchar(10) NOT NULL,
  `proceso_contable` int(11) DEFAULT 0,
  PRIMARY KEY (`id_student`),
  FOREIGN KEY (`estudiante`) REFERENCES `usuario` (`DNI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `id_teacher` int(11) NOT NULL AUTO_INCREMENT,
  `teacher` varchar(10) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_teacher`),
  FOREIGN KEY (`teacher`) REFERENCES `usuario` (`DNI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `icons`
--

DROP TABLE IF EXISTS `icons`;
CREATE TABLE IF NOT EXISTS `icons` (
  `id_icon` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(9) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `utilidad` int(11) NOT NULL,
  PRIMARY KEY (`id_icon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `icons`
--

INSERT INTO `icons` (`id_icon`, `codigo`, `nombre`, `utilidad`) VALUES
(1, '&#xf0c0;', 'users', 1),
(2, '&#xf0a3;', 'certificate', 1),
(3, '&#xf099;', 'twitter', 2),
(4, '&#xf09a;', 'facebook', 2),
(5, '&#xf16d;', 'instagram', 2),
(6, '&#xf36c;', 'algolia', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeryhome`
--

DROP TABLE IF EXISTS `galeryhome`;
CREATE TABLE IF NOT EXISTS `galeryhome` (
  `id_cont` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `fechaIU` date NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_cont`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `about`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE IF NOT EXISTS `about` (
  `id_cont` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `icon` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_cont`),
  FOREIGN KEY (`icon`) REFERENCES `icons` (`id_icon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `headquarter`
--

DROP TABLE IF EXISTS `headquarter`;
CREATE TABLE IF NOT EXISTS `headquarter` (
  `id_headquarter` int(11) NOT NULL AUTO_INCREMENT,
  `ubicacion` varchar(75) NOT NULL,
  `longitud` varchar(25) NOT NULL,
  `latitud` varchar(25) NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_headquarter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id_contacts` int(11) NOT NULL AUTO_INCREMENT,
  `telefono` varchar(35) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_contacts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socialmedia`
--

DROP TABLE IF EXISTS `socialmedia`;
CREATE TABLE IF NOT EXISTS `socialmedia` (
  `id_socialMedia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icono` int(11) NOT NULL,
  `fechaC` timestamp NULL DEFAULT NULL,
  `fechaA` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_socialMedia`),
  FOREIGN KEY (`icono`) REFERENCES `icons` (`id_icon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Estructura de tabla para la tabla `paymentday`
--

DROP TABLE IF EXISTS `paymentday`;
CREATE TABLE IF NOT EXISTS `paymentday` (
  `id_paymentday` int(11) NOT NULL AUTO_INCREMENT,
  `day` int NOT NULL,
  PRIMARY KEY (`id_paymentday`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `icons`
--

INSERT INTO `paymentday` (`id_paymentday`, `day`) VALUES (1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounting`
--

DROP TABLE IF EXISTS `accounting`;
CREATE TABLE IF NOT EXISTS `accounting` (
  `id_accounting` int(11) NOT NULL AUTO_INCREMENT,
  `estudiante` varchar(10) NOT NULL,
  `fecha_IC` date DEFAULT NULL,
  `fecha_FC` date DEFAULT NULL,
  `fecha_UP` date DEFAULT NULL,
  `fecha_PP` date DEFAULT NULL,
  `cuota` varchar(15) NOT NULL,
  `valor` double(9,2) NOT NULL,
  `valor_total` double(9,2) DEFAULT NULL,
  `descuento` int(11) DEFAULT 0,
  `valor_descuento` decimal(9,2) DEFAULT 0.00,
  `valor_total_descuento` double(9,2) DEFAULT 0.00,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_accounting`),
  FOREIGN KEY (`estudiante`) REFERENCES `student` (`estudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

--
-- Estructura de tabla para la tabla `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_pago` varchar(45) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `valor` double(9,2) NOT NULL,
  `periodo` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `observacion` int(11) NOT NULL DEFAULT 0,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_payment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_payment`
--

DROP TABLE IF EXISTS `detail_payment`;
CREATE TABLE IF NOT EXISTS `detail_payment` (
  `id_detail_payment` int(11) NOT NULL AUTO_INCREMENT,
  `estudiante` varchar(10) NOT NULL,
  `payment` int NOT NULL,
  `date` timestamp NOT NULL,
  PRIMARY KEY (`id_detail_payment`),
  FOREIGN KEY (`estudiante`) REFERENCES `student` (`estudiante`),
  FOREIGN KEY (`payment`) REFERENCES `payment` (`id_payment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-06-2022 a las 02:47:25
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lenti`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_orden`
--

CREATE TABLE `acciones_orden` (
  `id_accion` bigint(20) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `fecha_hora` varchar(25) DEFAULT NULL,
  `accion` varchar(200) DEFAULT NULL,
  `observaciones` varchar(200) NOT NULL,
  `usuario` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acciones_orden`
--

INSERT INTO `acciones_orden` (`id_accion`, `codigo`, `fecha_hora`, `accion`, `observaciones`, `usuario`) VALUES
(1, '06221', '2022-06-22 18:15:11', 'Despacho de Laboratorio * DSP-4', '', '1'),
(2, '06222', '2022-06-22 18:15:11', 'Despacho de Laboratorio * DSP-4', '', '1'),
(3, '06223', '2022-06-22 18:15:11', 'Despacho de Laboratorio * DSP-4', '', '1'),
(4, '06224', '2022-06-22 18:15:11', 'Despacho de Laboratorio * DSP-4', '', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alturas_orden`
--

CREATE TABLE `alturas_orden` (
  `codigo` varchar(45) DEFAULT NULL,
  `paciente` varchar(250) DEFAULT NULL,
  `od_dist_pupilar` varchar(10) DEFAULT NULL,
  `od_altura_pupilar` varchar(10) DEFAULT NULL,
  `od_altura_oblea` varchar(10) DEFAULT NULL,
  `oi_dist_pupilar` varchar(10) DEFAULT NULL,
  `oi_altura_pupilar` varchar(10) DEFAULT NULL,
  `oi_altura_oblea` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alturas_orden`
--

INSERT INTO `alturas_orden` (`codigo`, `paciente`, `od_dist_pupilar`, `od_altura_pupilar`, `od_altura_oblea`, `oi_dist_pupilar`, `oi_altura_pupilar`, `oi_altura_oblea`) VALUES
('06221', '', '', '', '', '', '', ''),
('06221', 'Oscar Antonio Gonzalez', '', '', '', '', '', ''),
('06222', 'Jorge Alberto Rollin', '', '', '', '', '', ''),
('06223', 'Carmen Arely Vasquez', '', '', '', '', '', ''),
('06224', 'Jorge Antonio Gonzalez', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aro_orden`
--

CREATE TABLE `aro_orden` (
  `codigo` varchar(45) NOT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `diseno` varchar(45) DEFAULT NULL,
  `horizontal` varchar(45) DEFAULT NULL,
  `diagonal` varchar(45) DEFAULT NULL,
  `vertical` varchar(45) DEFAULT NULL,
  `puente` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `aro_orden`
--

INSERT INTO `aro_orden` (`codigo`, `modelo`, `marca`, `color`, `diseno`, `horizontal`, `diagonal`, `vertical`, `puente`) VALUES
('06221', '', '', '', '', '', '', '', ''),
('06221', '', '', '', '', '', '', '', ''),
('06222', '', '', '', '', '', '', '', ''),
('06223', '', '', '', '', '', '', '', ''),
('06224', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `id_credito` int(11) NOT NULL,
  `tipo_credito` varchar(75) NOT NULL,
  `monto` varchar(15) NOT NULL,
  `fecha_fact` varchar(15) NOT NULL,
  `hora_fact` varchar(15) NOT NULL,
  `fecha_pago` date NOT NULL,
  `codigo_orden` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `id_optica` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `saldo` varchar(15) NOT NULL,
  `abono` varchar(8) NOT NULL,
  `id_orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `creditos`
--

INSERT INTO `creditos` (`id_credito`, `tipo_credito`, `monto`, `fecha_fact`, `hora_fact`, `fecha_pago`, `codigo_orden`, `estado`, `id_optica`, `id_sucursal`, `id_usuario`, `saldo`, `abono`, `id_orden`) VALUES
(268, '', '56.50', '2022-06-22', '17:50:43', '2022-07-22', '06221', 'Pendiente', 1, 21, 1, '56.50', '0', 1280),
(269, '', '42.00', '2022-06-22', '17:50:53', '2022-07-22', '06222', 'Pendiente', 1, 21, 1, '42.00', '0', 1281);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos_fiscales`
--

CREATE TABLE `creditos_fiscales` (
  `id_ccf` int(11) NOT NULL,
  `n_correlativo` varchar(25) NOT NULL,
  `codigo_orden` varchar(15) NOT NULL,
  `monto` varchar(10) NOT NULL,
  `fecha` varchar(15) NOT NULL,
  `hora` varchar(15) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `creditos_fiscales`
--

INSERT INTO `creditos_fiscales` (`id_ccf`, `n_correlativo`, `codigo_orden`, `monto`, `fecha`, `hora`, `id_sucursal`, `id_usuario`, `estado`) VALUES
(16, 'ccf-1', '06221', '56.50', '2022-06-22', '17:50:43', 21, 1, 'Sin cancelar'),
(17, 'ccf-2', '06222', '42.00', '2022-06-22', '17:50:53', 21, 1, 'Sin cancelar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despacho`
--

CREATE TABLE `despacho` (
  `id_despacho` int(11) NOT NULL,
  `n_despacho` varchar(45) DEFAULT NULL,
  `mensajero` varchar(145) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(15) DEFAULT NULL,
  `cant_ordenes` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `despacho`
--

INSERT INTO `despacho` (`id_despacho`, `n_despacho`, `mensajero`, `fecha`, `hora`, `cant_ordenes`, `id_usuario`) VALUES
(1, 'DSP-1', ' Franklin Salvador', '2022-06-22', '18:07:51', '3', 1),
(2, 'DSP-2', ' Franklin Salvador', '2022-06-22', '18:08:26', '3', 1),
(3, 'DSP-3', ' Franklin Salvador', '2022-06-22', '18:08:27', '3', 1),
(4, 'DSP-4', '', '2022-06-22', '18:15:11', '4', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_despacho`
--

CREATE TABLE `detalle_despacho` (
  `id_detalle_despacho` bigint(20) NOT NULL,
  `n_despacho` varchar(45) DEFAULT NULL,
  `cod_orden` varchar(45) DEFAULT NULL,
  `optica` varchar(105) DEFAULT NULL,
  `sucursal` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_despacho`
--

INSERT INTO `detalle_despacho` (`id_detalle_despacho`, `n_despacho`, `cod_orden`, `optica`, `sucursal`) VALUES
(1, 'DSP-1', '06221', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(2, 'DSP-1', '06222', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(3, 'DSP-1', '06223', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(4, 'DSP-2', '06221', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(5, 'DSP-2', '06222', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(6, 'DSP-2', '06223', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(7, 'DSP-3', '06221', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(8, 'DSP-3', '06222', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(9, 'DSP-3', '06223', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(10, 'DSP-4', '06221', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(11, 'DSP-4', '06222', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(12, 'DSP-4', '06223', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO'),
(13, 'DSP-4', '06224', 'OPTICA AVPLUS', 'SAN SALVADOR METROCENTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disenos_lente`
--

CREATE TABLE `disenos_lente` (
  `id_dis_lente` int(11) NOT NULL,
  `nombre_diseno` varchar(100) DEFAULT NULL,
  `precio` varchar(15) DEFAULT NULL,
  `categoria` varchar(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `disenos_lente`
--

INSERT INTO `disenos_lente` (`id_dis_lente`, `nombre_diseno`, `precio`, `categoria`) VALUES
(1, 'TERMINADO AR BLUE UV', '16.95', 'Vision sencilla'),
(2, 'V/S AURORA', '25', 'Vision sencilla'),
(3, 'Aurora alto indice 1.67', '56.50', 'Vision sencilla'),
(4, 'Aurora serena ocupacional', '56.50', 'Vision sencilla'),
(5, 'BIFOCAL 1.56', '55.00', 'Bifocal'),
(6, 'Invisible Blue UV', '42', 'Bifocal'),
(7, 'Alena', '85', 'Multifocal'),
(8, 'Aurora', '69.75', 'Multifocal'),
(9, 'A CLEAR', '44.75', 'Multifocal'),
(10, 'GEMINI', '-', 'Multifocal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `optica`
--

CREATE TABLE `optica` (
  `id_optica` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `limite_credito` varchar(5) NOT NULL,
  `metodo_cobro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `optica`
--

INSERT INTO `optica` (`id_optica`, `nombre`, `telefono`, `id_usuario`, `limite_credito`, `metodo_cobro`) VALUES
(1, 'OPTICA AVPLUS', '00000', 3, '2000', 'Mensual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id_orden` int(45) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `paciente` varchar(250) NOT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `usuario` varchar(250) DEFAULT NULL,
  `fecha_creacion` varchar(25) DEFAULT NULL,
  `estado` varchar(3) DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL,
  `tipo_lente` varchar(45) DEFAULT NULL,
  `id_optica` int(11) DEFAULT NULL,
  `tipo_orden` varchar(45) DEFAULT NULL,
  `trat_orden` varchar(50) NOT NULL,
  `contenedor` varchar(4) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `antirreflejante` varchar(3) NOT NULL,
  `precio` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id_orden`, `codigo`, `paciente`, `observaciones`, `usuario`, `fecha_creacion`, `estado`, `id_sucursal`, `tipo_lente`, `id_optica`, `tipo_orden`, `trat_orden`, `contenedor`, `marca`, `categoria`, `antirreflejante`, `precio`) VALUES
(1280, '06221', 'Oscar Antonio Gonzalez', '', '1', '22-06-2022 16:07:48', 'dsp', 21, 'Visión Sencilla', 1, 'Laboratorio', 'Blanco + Ar Blue Uv', '2', 'Aurora alto indice 1.67', 'Proceso', 'No', '56.50'),
(1281, '06222', 'Jorge Alberto Rollin', '', '1', '22-06-2022 16:40:48', 'dsp', 21, 'Bifocal', 1, 'Laboratorio', 'FOTOCHROMA', '25', 'BIFOCAL 1.56', 'Proceso', 'No', '42.00'),
(1282, '06223', 'Carmen Arely Vasquez', '', '1', '22-06-2022 16:44:06', 'dsp', 21, 'Bifocal', 1, 'Laboratorio', 'FOTOCHROMA', '4', 'BIFOCAL 1.56', 'Proceso', 'No', '42.00'),
(1283, '06224', 'Jorge Antonio Gonzalez', '', '1', '22-06-2022 16:45:50', 'dsp', 21, 'Bifocal', 1, 'Laboratorio', 'FOTOCHROMA', '6', 'BIFOCAL 1.56', 'Proceso', 'No', '42.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre`) VALUES
(1, 'Ordenes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rx_orden`
--

CREATE TABLE `rx_orden` (
  `codigo` varchar(45) DEFAULT NULL,
  `paciente` varchar(250) DEFAULT NULL,
  `odesferas` varchar(10) DEFAULT NULL,
  `odcindros` varchar(10) DEFAULT NULL,
  `odeje` varchar(10) DEFAULT NULL,
  `odadicion` varchar(10) DEFAULT NULL,
  `odprisma` varchar(10) DEFAULT NULL,
  `oiesferas` varchar(10) DEFAULT NULL,
  `oicindros` varchar(10) DEFAULT NULL,
  `oieje` varchar(10) DEFAULT NULL,
  `oiadicion` varchar(10) DEFAULT NULL,
  `oiprisma` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rx_orden`
--

INSERT INTO `rx_orden` (`codigo`, `paciente`, `odesferas`, `odcindros`, `odeje`, `odadicion`, `odprisma`, `oiesferas`, `oicindros`, `oieje`, `oiadicion`, `oiprisma`) VALUES
('06222', 'Jorge Alberto Rollin', '+2.25', '', '', '', '', '+3.00', '', '', '', ''),
('06223', 'Carmen Arely Vasquez', '+2.36', '', '', '', '', '+1.25', '', '', '', ''),
('06224', 'Jorge Antonio Gonzalez', '+2.50', '', '', '', '', '+3.00', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal_optica`
--

CREATE TABLE `sucursal_optica` (
  `id_sucursal` int(11) NOT NULL,
  `nombre_sucursal` varchar(45) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(250) DEFAULT NULL,
  `encargado` varchar(250) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `id_optica` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `categoria` varchar(50) NOT NULL,
  `fecha_cobro` varchar(50) NOT NULL,
  `forma_pago` varchar(75) NOT NULL,
  `nrc` varchar(50) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `metodo_cobro` varchar(75) NOT NULL,
  `giro` varchar(250) NOT NULL,
  `contribuyente` varchar(3) NOT NULL,
  `fecha_registro` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sucursal_optica`
--

INSERT INTO `sucursal_optica` (`id_sucursal`, `nombre_sucursal`, `direccion`, `telefono`, `correo`, `encargado`, `codigo`, `id_optica`, `id_usuario`, `categoria`, `fecha_cobro`, `forma_pago`, `nrc`, `nit`, `metodo_cobro`, `giro`, `contribuyente`, `fecha_registro`) VALUES
(21, '', 'SAN SALVADOR METROCENTRO', '222222', '22222222', 'OSCAR ANTONIO GONZALEZ', 'SL-1', 1, 1, 'A', '30', 'Credito', '000000', '2222222', 'Mensual', '2255555', 'No', '2022-06-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `telefono` varchar(40) DEFAULT NULL,
  `correo` varchar(250) DEFAULT NULL,
  `dui` varchar(50) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `departamento` varchar(250) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL,
  `codigo_emp` varchar(40) DEFAULT NULL,
  `cargo` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `telefono`, `correo`, `dui`, `direccion`, `usuario`, `departamento`, `pass`, `categoria`, `estado`, `codigo_emp`, `cargo`) VALUES
(1, 'Oscar Antonio Gonzalez', '0000000', '----', '-------', 'ss', 'oscar', 'admin', 'oscar1411', 'Admin', '1', 'LT-211', ''),
(2, 'Jacelin Asuncion Molina', '000', 'jack@avplus.com', '0000', 'San Salvador ', 'jacky', 'ar', 'jack93', '1', '1', '11', '---'),
(3, 'Carlos Andres Vasquez', '00000', '-', '-------', '-----', 'andvas', '-', 'and20vas08', 'super-administrador', '1', NULL, '--'),
(4, 'Andrea Vasques', '0000000', '---', '-------', '----', 'andrea', '-----', 'panconpollo', 'administrador', '1', '-', '-'),
(5, 'Franklin Salvador', '---', '--', '--', '--', 'franklin', 'Mensajeria', 'fanks', 'mensajero', '1', NULL, 'mensajero'),
(6, 'Salud Digna', '---', '--', '--', '--', 'sdigna', '--', 'sdigna', 'a', '1', '-', '-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `id_usuario_permiso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_permiso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`id_usuario_permiso`, `id_usuario`, `id_permiso`) VALUES
(1, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones_orden`
--
ALTER TABLE `acciones_orden`
  ADD PRIMARY KEY (`id_accion`),
  ADD KEY `codigo` (`codigo`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id_credito`),
  ADD UNIQUE KEY `codigo_orden` (`codigo_orden`),
  ADD KEY `id_orden` (`id_orden`),
  ADD KEY `id_optica` (`id_optica`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `creditos_fiscales`
--
ALTER TABLE `creditos_fiscales`
  ADD PRIMARY KEY (`id_ccf`),
  ADD UNIQUE KEY `codigo_orden` (`codigo_orden`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `despacho`
--
ALTER TABLE `despacho`
  ADD PRIMARY KEY (`id_despacho`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_despacho`
--
ALTER TABLE `detalle_despacho`
  ADD PRIMARY KEY (`id_detalle_despacho`);

--
-- Indices de la tabla `disenos_lente`
--
ALTER TABLE `disenos_lente`
  ADD PRIMARY KEY (`id_dis_lente`);

--
-- Indices de la tabla `optica`
--
ALTER TABLE `optica`
  ADD PRIMARY KEY (`id_optica`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id_orden`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_optica` (`id_optica`),
  ADD KEY `paciente` (`paciente`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `sucursal_optica`
--
ALTER TABLE `sucursal_optica`
  ADD PRIMARY KEY (`id_sucursal`),
  ADD KEY `id_optica` (`id_optica`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`id_usuario_permiso`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones_orden`
--
ALTER TABLE `acciones_orden`
  MODIFY `id_accion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT de la tabla `creditos_fiscales`
--
ALTER TABLE `creditos_fiscales`
  MODIFY `id_ccf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `despacho`
--
ALTER TABLE `despacho`
  MODIFY `id_despacho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_despacho`
--
ALTER TABLE `detalle_despacho`
  MODIFY `id_detalle_despacho` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `disenos_lente`
--
ALTER TABLE `disenos_lente`
  MODIFY `id_dis_lente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `optica`
--
ALTER TABLE `optica`
  MODIFY `id_optica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id_orden` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1284;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sucursal_optica`
--
ALTER TABLE `sucursal_optica`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id_usuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones_orden`
--
ALTER TABLE `acciones_orden`
  ADD CONSTRAINT `acciones_orden_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `orden` (`codigo`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD CONSTRAINT `creditos_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `orden` (`id_orden`),
  ADD CONSTRAINT `creditos_ibfk_2` FOREIGN KEY (`id_optica`) REFERENCES `optica` (`id_optica`),
  ADD CONSTRAINT `creditos_ibfk_3` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal_optica` (`id_sucursal`),
  ADD CONSTRAINT `creditos_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `creditos_fiscales`
--
ALTER TABLE `creditos_fiscales`
  ADD CONSTRAINT `creditos_fiscales_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal_optica` (`id_sucursal`),
  ADD CONSTRAINT `creditos_fiscales_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `despacho`
--
ALTER TABLE `despacho`
  ADD CONSTRAINT `despacho_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `optica`
--
ALTER TABLE `optica`
  ADD CONSTRAINT `optica_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `id_sucursal` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal_optica` (`id_sucursal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`id_optica`) REFERENCES `optica` (`id_optica`);

--
-- Filtros para la tabla `sucursal_optica`
--
ALTER TABLE `sucursal_optica`
  ADD CONSTRAINT `sucursal_optica_ibfk_1` FOREIGN KEY (`id_optica`) REFERENCES `optica` (`id_optica`),
  ADD CONSTRAINT `sucursal_optica_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `id_permiso` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

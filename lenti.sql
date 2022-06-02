-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2022 a las 21:55:46
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.2.32

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_lentes`
--

CREATE TABLE `codigos_lentes` (
  `id_codigo` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `identificador_lente` varchar(45) NOT NULL,
  `tipo_lente` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corte_diario_facturacion`
--

CREATE TABLE `corte_diario_facturacion` (
  `id_registro` int(11) NOT NULL,
  `fecha` varchar(15) NOT NULL,
  `hora` varchar(15) NOT NULL,
  `codigo_orden` varchar(11) NOT NULL,
  `correlativo_factura` varchar(25) NOT NULL,
  `paciente` varchar(200) NOT NULL,
  `id_optica` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `monto` varchar(11) NOT NULL,
  `tipo_venta` varchar(25) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `fecha_pago` varchar(25) NOT NULL,
  `codigo_orden` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `id_optica` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `saldo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `nrc` varchar(30) NOT NULL,
  `nit` varchar(30) NOT NULL,
  `giro` varchar(250) NOT NULL,
  `id_optica` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descargos`
--

CREATE TABLE `descargos` (
  `id_descargo` int(11) NOT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `tipo_lente` varchar(125) DEFAULT NULL,
  `codigo_lente` varchar(45) DEFAULT NULL,
  `ojo` varchar(45) DEFAULT NULL,
  `paciente` varchar(150) DEFAULT NULL,
  `medidas` varchar(45) DEFAULT NULL,
  `codigo_orden` varchar(45) DEFAULT NULL,
  `id_optica` int(11) DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingresos_tallado`
--

CREATE TABLE `detalle_ingresos_tallado` (
  `id_ingreso` int(11) NOT NULL,
  `correlativo_ingreso` varchar(45) DEFAULT NULL,
  `codigo_orden` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_lentes_rotos`
--

CREATE TABLE `detalle_lentes_rotos` (
  `id_detalle_lr` int(11) NOT NULL,
  `codigo_lente` varchar(45) DEFAULT NULL,
  `n_reporte` varchar(45) DEFAULT NULL,
  `especificaciones` varchar(55) DEFAULT NULL,
  `codigo_lente_repo` varchar(45) DEFAULT NULL,
  `especificaciones_repo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'VS AURORA', '25', 'Vision sencilla'),
(3, 'Aurora alto indice 1.67', '56.50', 'Vision sencilla'),
(4, 'Aurora serena ocupacional', '56.50', 'Vision sencilla'),
(5, 'BIFOCAL 1.56', '55.00', 'Bifocal'),
(6, 'Invisible Blue UV', '42', 'Bifocal'),
(7, 'Alena', '85', 'Multifocal'),
(8, 'Aurora', '69.75', 'Multifocal'),
(9, 'A CLEAR', '44.75', 'Multifocal'),
(10, 'GEMINI', '-', 'Multifocal'),
(11, 'Dis1', '15', '-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` bigint(15) NOT NULL,
  `correlativo` varchar(25) NOT NULL,
  `monto` int(10) NOT NULL,
  `fecha` int(15) NOT NULL,
  `hora` int(15) NOT NULL,
  `estado` int(25) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_optica` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `numero_orden` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grad_tablas_base`
--

CREATE TABLE `grad_tablas_base` (
  `id_graduacion` int(11) NOT NULL,
  `graduacion` varchar(11) DEFAULT NULL,
  `id_tabla_base` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos_stock`
--

CREATE TABLE `ingresos_stock` (
  `codigo_lente` varchar(100) NOT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `cantidad` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `medidas` varchar(75) DEFAULT NULL,
  `hora` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_tallado`
--

CREATE TABLE `ingreso_tallado` (
  `id_ingreso` int(11) NOT NULL,
  `correlativo_ingreso` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(15) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lentes_rotos`
--

CREATE TABLE `lentes_rotos` (
  `id_reporte` int(11) NOT NULL,
  `n_orden` varchar(45) DEFAULT NULL,
  `reponsable` varchar(100) DEFAULT NULL,
  `reportado_por` varchar(100) DEFAULT NULL,
  `razon` varchar(250) DEFAULT NULL,
  `fecha` varchar(15) DEFAULT NULL,
  `hora` varchar(15) DEFAULT NULL,
  `n_reporte` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lente_terminado`
--

CREATE TABLE `lente_terminado` (
  `id_terminado` int(11) NOT NULL,
  `marca` varchar(60) DEFAULT NULL,
  `diseno` varchar(60) DEFAULT NULL,
  `lente` varchar(100) DEFAULT NULL,
  `identificador` varchar(45) DEFAULT NULL,
  `stock` varchar(45) DEFAULT NULL,
  `esfera` varchar(45) DEFAULT NULL,
  `cilindro` varchar(45) DEFAULT NULL,
  `codigo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `optica`
--

CREATE TABLE `optica` (
  `id_optica` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_bases`
--

CREATE TABLE `stock_bases` (
  `codigo` varchar(75) NOT NULL,
  `identificador` varchar(45) DEFAULT NULL,
  `base` varchar(45) DEFAULT NULL,
  `stock_minimo` varchar(45) DEFAULT NULL,
  `stock` varchar(45) DEFAULT NULL,
  `id_tabla_base` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_bases_adicion`
--

CREATE TABLE `stock_bases_adicion` (
  `id_stock` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `identificador` varchar(45) DEFAULT NULL,
  `base` varchar(45) DEFAULT NULL,
  `adicion` varchar(45) DEFAULT NULL,
  `stock_minimo` varchar(45) DEFAULT NULL,
  `stock` varchar(45) DEFAULT NULL,
  `ojo` varchar(45) DEFAULT NULL,
  `id_tabla_base` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_terminados`
--

CREATE TABLE `stock_terminados` (
  `codigo` varchar(60) NOT NULL,
  `identificador` varchar(25) NOT NULL,
  `id_tabla_term` int(11) DEFAULT NULL,
  `esfera` varchar(15) DEFAULT NULL,
  `cilindro` varchar(15) DEFAULT NULL,
  `stock_min` varchar(5) DEFAULT NULL,
  `stock` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `metodo_cobro` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas_base`
--

CREATE TABLE `tablas_base` (
  `id_tabla_base` int(11) NOT NULL,
  `titulo` varchar(125) DEFAULT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `diseno` varchar(45) DEFAULT NULL,
  `min_base` varchar(45) DEFAULT NULL,
  `max_base` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas_terminado`
--

CREATE TABLE `tablas_terminado` (
  `id_tabla_term` int(11) NOT NULL,
  `titulo` varchar(125) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `diseno` varchar(45) DEFAULT NULL,
  `min_cil` varchar(15) DEFAULT NULL,
  `max_cil` varchar(15) DEFAULT NULL,
  `min_esf` varchar(15) DEFAULT NULL,
  `max_esf` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento_orden`
--

CREATE TABLE `tratamiento_orden` (
  `codigo` varchar(45) NOT NULL,
  `tratamiento` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Oscar Antonio Gonzalez', '0000000', '----', '-------', 'ss', 'oscar', 'admin', 'oscar1411', 'Admin', '1', 'LT1', ''),
(2, 'Jackelin Molina', '000', 'jack@avplus.com', '0000', 'San Salvador ', 'jacky', 'ar', 'jack93', '1', '1', 'LT2', '---'),
(3, 'LILIANA DE ALVARENGA', '----', '----', '0000000', 'SS', 'liliana', 'Bodega', 'liliana2022', 'bodega', '1', 'LT3', 'Jefe de bodega'),
(4, 'OMAR ALVARENGA PEÑA', '0000', '----', '00000', 'SS', 'omar', 'Montaje', 'omar2022', 'operario', '1', 'LT4', 'Montaje'),
(5, 'Franklin Salvador', '0', '0', '0000', '0', 'franklin', 'Mensajeria', 'franklin', 'mensajero', '1', 'LT-05', 'mensajero');

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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones_orden`
--
ALTER TABLE `acciones_orden`
  ADD PRIMARY KEY (`id_accion`),
  ADD KEY `codigo` (`codigo`);

--
-- Indices de la tabla `alturas_orden`
--
ALTER TABLE `alturas_orden`
  ADD KEY `codigo` (`codigo`),
  ADD KEY `paciente` (`paciente`);

--
-- Indices de la tabla `aro_orden`
--
ALTER TABLE `aro_orden`
  ADD KEY `codigo` (`codigo`);

--
-- Indices de la tabla `codigos_lentes`
--
ALTER TABLE `codigos_lentes`
  ADD PRIMARY KEY (`id_codigo`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD UNIQUE KEY `id_lente` (`identificador_lente`);

--
-- Indices de la tabla `corte_diario_facturacion`
--
ALTER TABLE `corte_diario_facturacion`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id_credito`),
  ADD UNIQUE KEY `codigo_orden` (`codigo_orden`);

--
-- Indices de la tabla `creditos_fiscales`
--
ALTER TABLE `creditos_fiscales`
  ADD PRIMARY KEY (`id_ccf`),
  ADD UNIQUE KEY `codigo_orden` (`codigo_orden`);

--
-- Indices de la tabla `descargos`
--
ALTER TABLE `descargos`
  ADD PRIMARY KEY (`id_descargo`),
  ADD KEY `id_optica` (`id_optica`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `despacho`
--
ALTER TABLE `despacho`
  ADD PRIMARY KEY (`id_despacho`),
  ADD KEY `id_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `detalle_despacho`
--
ALTER TABLE `detalle_despacho`
  ADD PRIMARY KEY (`id_detalle_despacho`);

--
-- Indices de la tabla `detalle_ingresos_tallado`
--
ALTER TABLE `detalle_ingresos_tallado`
  ADD PRIMARY KEY (`id_ingreso`);

--
-- Indices de la tabla `detalle_lentes_rotos`
--
ALTER TABLE `detalle_lentes_rotos`
  ADD PRIMARY KEY (`id_detalle_lr`);

--
-- Indices de la tabla `disenos_lente`
--
ALTER TABLE `disenos_lente`
  ADD PRIMARY KEY (`id_dis_lente`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_orden` (`numero_orden`);

--
-- Indices de la tabla `grad_tablas_base`
--
ALTER TABLE `grad_tablas_base`
  ADD PRIMARY KEY (`id_graduacion`),
  ADD KEY `id_tabla_base` (`id_tabla_base`);

--
-- Indices de la tabla `ingresos_stock`
--
ALTER TABLE `ingresos_stock`
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `ingreso_tallado`
--
ALTER TABLE `ingreso_tallado`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD UNIQUE KEY `correlativo_ingreso` (`correlativo_ingreso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `lentes_rotos`
--
ALTER TABLE `lentes_rotos`
  ADD PRIMARY KEY (`id_reporte`);

--
-- Indices de la tabla `lente_terminado`
--
ALTER TABLE `lente_terminado`
  ADD PRIMARY KEY (`id_terminado`);

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
-- Indices de la tabla `rx_orden`
--
ALTER TABLE `rx_orden`
  ADD UNIQUE KEY `codigo` (`codigo`) USING BTREE,
  ADD KEY `paciente` (`paciente`);

--
-- Indices de la tabla `stock_bases`
--
ALTER TABLE `stock_bases`
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_tabla_base_idx` (`id_tabla_base`);

--
-- Indices de la tabla `stock_bases_adicion`
--
ALTER TABLE `stock_bases_adicion`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_tabla_base` (`id_tabla_base`);

--
-- Indices de la tabla `stock_terminados`
--
ALTER TABLE `stock_terminados`
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  ADD KEY `id_tabla_term` (`id_tabla_term`);

--
-- Indices de la tabla `sucursal_optica`
--
ALTER TABLE `sucursal_optica`
  ADD PRIMARY KEY (`id_sucursal`),
  ADD KEY `id_optica` (`id_optica`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tablas_base`
--
ALTER TABLE `tablas_base`
  ADD PRIMARY KEY (`id_tabla_base`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- Indices de la tabla `tablas_terminado`
--
ALTER TABLE `tablas_terminado`
  ADD PRIMARY KEY (`id_tabla_term`),
  ADD UNIQUE KEY `titulo_UNIQUE` (`titulo`);

--
-- Indices de la tabla `tratamiento_orden`
--
ALTER TABLE `tratamiento_orden`
  ADD KEY `codigo` (`codigo`);

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
  MODIFY `id_accion` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `codigos_lentes`
--
ALTER TABLE `codigos_lentes`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corte_diario_facturacion`
--
ALTER TABLE `corte_diario_facturacion`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos_fiscales`
--
ALTER TABLE `creditos_fiscales`
  MODIFY `id_ccf` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `descargos`
--
ALTER TABLE `descargos`
  MODIFY `id_descargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `despacho`
--
ALTER TABLE `despacho`
  MODIFY `id_despacho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_despacho`
--
ALTER TABLE `detalle_despacho`
  MODIFY `id_detalle_despacho` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ingresos_tallado`
--
ALTER TABLE `detalle_ingresos_tallado`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_lentes_rotos`
--
ALTER TABLE `detalle_lentes_rotos`
  MODIFY `id_detalle_lr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `disenos_lente`
--
ALTER TABLE `disenos_lente`
  MODIFY `id_dis_lente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grad_tablas_base`
--
ALTER TABLE `grad_tablas_base`
  MODIFY `id_graduacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_tallado`
--
ALTER TABLE `ingreso_tallado`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lentes_rotos`
--
ALTER TABLE `lentes_rotos`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lente_terminado`
--
ALTER TABLE `lente_terminado`
  MODIFY `id_terminado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `optica`
--
ALTER TABLE `optica`
  MODIFY `id_optica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id_orden` int(45) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stock_bases_adicion`
--
ALTER TABLE `stock_bases_adicion`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucursal_optica`
--
ALTER TABLE `sucursal_optica`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tablas_base`
--
ALTER TABLE `tablas_base`
  MODIFY `id_tabla_base` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tablas_terminado`
--
ALTER TABLE `tablas_terminado`
  MODIFY `id_tabla_term` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id_usuario_permiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones_orden`
--
ALTER TABLE `acciones_orden`
  ADD CONSTRAINT `acciones_orden_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `orden` (`codigo`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `alturas_orden`
--
ALTER TABLE `alturas_orden`
  ADD CONSTRAINT `alturas_orden_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `orden` (`codigo`),
  ADD CONSTRAINT `alturas_orden_ibfk_2` FOREIGN KEY (`paciente`) REFERENCES `orden` (`paciente`);

--
-- Filtros para la tabla `aro_orden`
--
ALTER TABLE `aro_orden`
  ADD CONSTRAINT `aro_orden_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `orden` (`codigo`);

--
-- Filtros para la tabla `descargos`
--
ALTER TABLE `descargos`
  ADD CONSTRAINT `descargos_ibfk_1` FOREIGN KEY (`id_optica`) REFERENCES `optica` (`id_optica`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `descargos_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal_optica` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `descargos_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `grad_tablas_base`
--
ALTER TABLE `grad_tablas_base`
  ADD CONSTRAINT `grad_tablas_base_ibfk_1` FOREIGN KEY (`id_tabla_base`) REFERENCES `tablas_base` (`id_tabla_base`);

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
-- Filtros para la tabla `rx_orden`
--
ALTER TABLE `rx_orden`
  ADD CONSTRAINT `rx_orden_ibfk_3` FOREIGN KEY (`codigo`) REFERENCES `orden` (`codigo`),
  ADD CONSTRAINT `rx_orden_ibfk_4` FOREIGN KEY (`paciente`) REFERENCES `orden` (`paciente`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `stock_bases`
--
ALTER TABLE `stock_bases`
  ADD CONSTRAINT `id_tabla_base` FOREIGN KEY (`id_tabla_base`) REFERENCES `tablas_base` (`id_tabla_base`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `stock_terminados`
--
ALTER TABLE `stock_terminados`
  ADD CONSTRAINT `id_table_term` FOREIGN KEY (`id_tabla_term`) REFERENCES `tablas_terminado` (`id_tabla_term`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sucursal_optica`
--
ALTER TABLE `sucursal_optica`
  ADD CONSTRAINT `sucursal_optica_ibfk_1` FOREIGN KEY (`id_optica`) REFERENCES `optica` (`id_optica`);

--
-- Filtros para la tabla `tratamiento_orden`
--
ALTER TABLE `tratamiento_orden`
  ADD CONSTRAINT `tratamiento_orden_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `orden` (`codigo`);

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

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2024 a las 04:20:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `v_farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `cedula`, `nombre`, `telefono`, `direccion`) VALUES
(4, '123334', 'Consumidor Final', '09999999', 'xxxx'),
(6, '1111', 'Willito 1', '09999999999', 'solando 2'),
(7, '1223', 'Jadithcita', '09999999999', 'solanda'),
(8, '1750625848', 'Danielito Andrade', '0984041656', 'Solanda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `telefono`, `email`, `direccion`) VALUES
(1, 'Administrador', '999999999', 'willianandrademj43@gmail.com', 'San Gabriel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_permisos`
--

CREATE TABLE `detalle_permisos` (
  `id` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_permisos`
--

INSERT INTO `detalle_permisos` (`id`, `id_permiso`, `id_usuario`) VALUES
(15, 3, 9),
(16, 5, 9),
(17, 6, 9),
(18, 7, 9),
(19, 8, 9),
(20, 9, 9),
(30, 1, 1),
(31, 2, 1),
(32, 3, 1),
(33, 4, 1),
(34, 5, 1),
(35, 6, 1),
(36, 7, 1),
(37, 8, 1),
(38, 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `precio_costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `precio` decimal(10,2) NOT NULL,
  `precioPVP` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `id_producto`, `id_venta`, `cantidad`, `descuento`, `precio`, `precioPVP`, `total`) VALUES
(16, 1, 67, 12, 0.00, 0.00, 0.06, 0.72),
(17, 1, 68, 1, 0.00, 3.00, 3.00, 3.00),
(18, 1, 69, 2, 0.00, 3.00, 3.00, 6.00),
(19, 8, 70, 6, 0.00, 0.00, 0.42, 2.52),
(20, 8, 71, 6, 0.00, 0.00, 0.42, 2.52),
(21, 8, 72, 6, 0.00, 0.00, 0.42, 2.52),
(22, 8, 73, 6, 0.00, 0.00, 0.42, 2.52),
(23, 8, 74, 3, 0.00, 0.00, 0.42, 1.26),
(24, 8, 75, 5, 0.00, 0.00, 0.42, 2.10),
(25, 8, 76, 5, 0.00, 0.00, 0.42, 2.10),
(26, 8, 77, 5, 0.00, 0.00, 0.42, 2.10),
(27, 8, 78, 5, 0.00, 0.00, 0.42, 2.10),
(28, 8, 79, 5, 0.00, 0.00, 0.42, 2.10),
(29, 8, 80, 5, 0.00, 0.00, 0.42, 2.10),
(30, 8, 81, 3, 0.00, 0.00, 0.42, 1.26),
(31, 8, 82, 4, 0.00, 0.00, 0.42, 1.68),
(32, 8, 83, 12, 0.00, 0.00, 0.42, 5.04),
(33, 8, 84, 2, 0.00, 0.00, 0.42, 0.84),
(34, 8, 85, 3, 0.00, 0.00, 0.15, 0.45),
(35, 5, 86, 1, 0.00, 23.00, 25.00, 25.00),
(36, 5, 87, 1, 6.25, 23.00, 25.00, 18.75),
(37, 7, 88, 1, 0.00, 3.00, 5.00, 5.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorios`
--

CREATE TABLE `laboratorios` (
  `id` int(11) NOT NULL,
  `laboratorio` varchar(100) NOT NULL,
  `direccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `laboratorios`
--

INSERT INTO `laboratorios` (`id`, `laboratorio`, `direccion`) VALUES
(1, 'Bagó', 'Quito'),
(2, 'Nifa', 'Quito'),
(3, 'Genfar', 'Quito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `archivo` varchar(100) NOT NULL,
  `logo_opcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `archivo`, `logo_opcion`) VALUES
(1, 'configuración', 'config', 'fas fa-cogs mr-2 fa-2x'),
(2, 'usuarios', 'usuarios', 'fas fa-user mr-2 fa-2x'),
(3, 'clientes', 'clientes', 'fas fa-users mr-2 fa-2x'),
(4, 'productos', 'productos', 'fas fa-cubes mr-2 fa-2x'),
(5, 'ventas', 'lista_ventas', 'fas fa-cash-register mr-2 fa-2x'),
(6, 'nueva_venta', 'ventas', 'fas fa-cash-register mr-2 fa-2x'),
(7, 'tipos', 'tipo', 'fas fa-tags mr-2 fa-2x'),
(8, 'presentacion', 'presentacion', 'fas fa-list mr-2 fa-2x'),
(9, 'laboratorios', 'laboratorio', 'fas fa-hospital mr-2 fa-2x');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nombre_corto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`id`, `nombre`, `nombre_corto`) VALUES
(4, 'Caja', 'Caja'),
(5, 'gotero', 'gotero'),
(6, 'sobres', 'sobres'),
(7, 'frasco', 'frasco'),
(8, 'tubo', 'tubo'),
(9, 'botella farmaceutica', 'botella'),
(10, 'viales', 'viales'),
(11, 'stick paks', 'stick'),
(12, 'ampollas', 'ampollas'),
(13, 'tubos', 'tubos'),
(14, 'sobre de papel', 'sobre de p');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codproducto` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `precioPVP` decimal(10,2) NOT NULL,
  `precioFr` decimal(10,2) NOT NULL,
  `precioFr_o` decimal(10,2) NOT NULL,
  `existencia` int(11) NOT NULL,
  `existencia_fr` int(11) NOT NULL,
  `fraccion` int(11) NOT NULL,
  `id_lab` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `vencimiento` varchar(20) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `info_prod` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codproducto`, `codigo`, `descripcion`, `precio`, `precioPVP`, `precioFr`, `precioFr_o`, `existencia`, `existencia_fr`, `fraccion`, `id_lab`, `id_presentacion`, `id_tipo`, `vencimiento`, `iva`, `info_prod`) VALUES
(1, '45454545', 'Cataflan', 3.00, 3.00, 0.12, 0.05, 7, 385, 55, 1, 4, 1, '2030-08-12', 0.00, ''),
(5, '7800063810065', 'Carbamazepina 200mg', 23.00, 25.00, 1.25, 1.25, 2, 38, 20, 1, 4, 1, '2025-02-02', 0.00, 'antiepileptico'),
(6, '8902305015494', 'Betametasona', 5.00, 6.00, 1.20, 1.20, 31, 155, 5, 2, 4, 1, '2025-01-02', 0.00, ''),
(7, '7861132425306', 'Otodine 13 ml', 3.00, 5.00, 0.00, 0.00, 22, 0, 0, 2, 1, 2, '2025-07-01', 0.00, ''),
(8, '7703763320127', 'Loratadina 10mg', 1.00, 2.00, 0.20, 0.20, 5, 50, 10, 1, 4, 1, '2028-04-01', 0.00, 'Antihestaminico para control rapido de alergias como rinitis, estornudos, rinorea y prurito, urticaria.\r\n\r\nDosis: Adultos y niños mayores de 12 años una tableta diaria.\r\n\r\nEfectos secundarios: Mas frecuentes son sefalea fatiga y somnolencia, tambien sequedad naucea y gastritis.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `tipo`) VALUES
(1, 'Tabletas'),
(2, 'Jarabe'),
(3, 'Emulsion'),
(5, 'otro tipo'),
(6, 'pastillas'),
(7, 'polvo'),
(8, 'comprimidos'),
(9, 'gotas'),
(10, 'capsulas'),
(11, 'polvos'),
(12, 'granulados'),
(13, 'soluciones'),
(14, 'solucion inyectable'),
(15, 'ovulos'),
(16, 'supositorios'),
(17, 'jarabes'),
(18, 'suspensiones'),
(19, 'crema'),
(20, 'ungüento'),
(21, 'parches'),
(22, 'líquido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `clave` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`) VALUES
(1, 'Administrador', 'willianandrademj43@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(9, 'Maria Sanchez', 'maria@gmail.com', 'maria', '263bce650e68ab4e23f28263760b9fa5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `total`, `id_usuario`, `fecha`) VALUES
(67, 6, 0.72, 1, '2024-12-01 04:09:12'),
(68, 6, 3.00, 1, '2024-12-01 04:51:29'),
(69, 4, 6.00, 1, '2024-12-01 04:56:57'),
(70, 4, 2.52, 1, '2024-12-01 20:13:56'),
(71, 4, 2.52, 1, '2024-12-01 20:15:20'),
(72, 4, 2.52, 1, '2024-12-01 20:18:27'),
(73, 4, 2.52, 1, '2024-12-01 20:24:43'),
(74, 4, 1.26, 1, '2024-12-01 20:29:24'),
(75, 4, 2.10, 1, '2024-12-01 20:37:48'),
(76, 4, 2.10, 1, '2024-12-01 20:37:49'),
(77, 4, 2.10, 1, '2024-12-01 20:37:55'),
(78, 4, 2.10, 1, '2024-12-01 20:37:56'),
(79, 4, 2.10, 1, '2024-12-01 20:37:57'),
(80, 4, 2.10, 1, '2024-12-01 20:37:57'),
(81, 4, 1.26, 1, '2024-12-01 20:43:07'),
(82, 4, 1.68, 1, '2024-12-01 20:58:24'),
(83, 4, 5.04, 1, '2024-12-01 21:01:07'),
(84, 6, 0.84, 1, '2024-12-01 21:06:19'),
(85, 4, 0.45, 1, '2024-12-01 21:33:38'),
(86, 8, 25.00, 1, '2024-12-01 22:32:00'),
(87, 4, 18.75, 1, '2024-12-01 22:36:26'),
(88, 4, 5.00, 1, '2024-12-03 02:33:31');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vipermisos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vipermisos` (
`id` int(11)
,`nombre` varchar(30)
,`archivo` varchar(100)
,`logo_opcion` varchar(100)
,`id_detalle_per` int(11)
,`id_permiso` int(11)
,`id_usuario` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vipermisos`
--
DROP TABLE IF EXISTS `vipermisos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vipermisos`  AS SELECT `p`.`id` AS `id`, `p`.`nombre` AS `nombre`, `p`.`archivo` AS `archivo`, `p`.`logo_opcion` AS `logo_opcion`, `d`.`id` AS `id_detalle_per`, `d`.`id_permiso` AS `id_permiso`, `d`.`id_usuario` AS `id_usuario` FROM (`permisos` `p` join `detalle_permisos` `d` on(`p`.`id` = `d`.`id_permiso`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_permiso` (`id_permiso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD CONSTRAINT `detalle_permisos_ibfk_1` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_permisos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

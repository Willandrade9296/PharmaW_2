-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2025 a las 03:09:00
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
  `direccion` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `cedula`, `nombre`, `telefono`, `direccion`, `email`) VALUES
(4, '123334', 'Consumidor Final', '09999999', 'xxxx', ''),
(6, '1111', 'Willito 1', '09999999999', 'solando 2', ''),
(7, '1223', 'Jadithcita', '09999999999', 'solanda', ''),
(8, '1750625848', 'Danielito Andrade', '0984041656', 'Solanda', ''),
(9, '1728948348', 'Pamela Yepez', '0987708702', 'Solanda', 'dd@gmail.com');

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
(1, 'Farmacias Reina del Quinche', '999999999', 'willianandrademj43@gmail.com', 'San Gabriel');

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
(59, 3, 9),
(60, 5, 9),
(61, 6, 9),
(89, 3, 12),
(90, 4, 12),
(91, 5, 12),
(92, 6, 12),
(93, 7, 12),
(94, 8, 12),
(95, 9, 12),
(153, 1, 1),
(154, 2, 1),
(155, 3, 1),
(156, 4, 1),
(157, 5, 1),
(158, 6, 1),
(159, 7, 1),
(160, 8, 1),
(161, 9, 1),
(162, 10, 1),
(163, 11, 1),
(164, 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `tipo_prod` varchar(10) NOT NULL,
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
  `tipo_prod` varchar(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `precio` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `precioPVP` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `id_producto`, `id_venta`, `tipo_prod`, `cantidad`, `descuento`, `precio`, `iva`, `precioPVP`, `total`) VALUES
(137, 1, 210, 'F', 2, 0.00, 1.00, 0.00, 1.20, 2.40),
(138, 6, 210, 'F', 4, 0.00, 1.20, 0.00, 1.20, 4.80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_cuerpo`
--

CREATE TABLE `grupo_cuerpo` (
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `detalle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'Hetero', 'Quito'),
(5, 'Lamosan', 'Quito'),
(6, 'Unipharm', 'Suiza'),
(7, 'Farmalaya', 'Duran - Ecuador'),
(8, 'Farmabrand', 'Quito - Ecuador'),
(9, 'Acromax', 'Guayaquil - Ecuador'),
(10, 'La Santé', 'Bogotá - Colombia'),
(11, 'Genfar', 'Cali - Colombia'),
(12, 'ECU', 'Ecuador'),
(13, 'Aurochem', 'Duran - Ecuador'),
(14, 'Menarini', 'Florencia - Italia'),
(15, 'Siegfrid', 'Guayaquil - Ecuador'),
(16, 'Bjamer', 'Guayaquil - Ecuador'),
(17, 'Marcopharma', 'Quito - Ecuador'),
(18, 'Pfizer', 'España'),
(19, 'Novartis', 'EE.UU'),
(20, 'Abbott', 'Ecuador'),
(21, 'Otros', 'Ecuador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `nombre_op` varchar(200) NOT NULL,
  `archivo` varchar(100) NOT NULL,
  `logo_opcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `nombre_op`, `archivo`, `logo_opcion`) VALUES
(1, 'configuración', 'Configuración', 'config', 'fas fa-cogs mr-2 fa-2x'),
(2, 'usuarios', 'Usuarios', 'usuarios', 'fas fa-user mr-2 fa-2x'),
(3, 'clientes', 'Clientes', 'clientes', 'fas fa-users mr-2 fa-2x'),
(4, 'productos', 'Productos', 'productos', 'fas fa-cubes mr-2 fa-2x'),
(5, 'ventas', 'Historial Ventas', 'lista_ventas', 'fas fa-cash-register mr-2 fa-2x'),
(6, 'nueva_venta', 'Nueva Venta', 'ventas', 'fas fa-cash-register mr-2 fa-2x'),
(7, 'tipos', 'Tipos', 'tipo', 'fas fa-tags mr-2 fa-2x'),
(8, 'presentacion', 'Presentaciones', 'presentacion', 'fas fa-list mr-2 fa-2x'),
(9, 'laboratorios', 'Laboratorios', 'laboratorio', 'fas fa-hospital mr-2 fa-2x'),
(10, 'Reportes', 'Reportes', 'report', 'fas fa-file-archive mr-2 fa-2x'),
(11, 'Detalle Utilidad', 'Detalle Utilidad', 'detalle_utilidad', 'fas fa-dollar-sign mr-2 fa-2x'),
(12, 'Grupo Corporal', 'Grupo Corporal', 'grupo_c', 'fas fa-dice-d6 mr-2 fa-2x');

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
(7, 'frasco', 'frasco'),
(9, 'botella farmaceutica', 'botella'),
(10, 'viales', 'viales'),
(11, 'stick paks', 'stick'),
(12, 'ampollas', 'ampollas'),
(13, 'tubos', 'tubos'),
(14, 'sobres', 'sobre');

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
  `precioFr_c` decimal(10,2) NOT NULL,
  `existencia` int(11) NOT NULL,
  `existencia_fr` int(11) NOT NULL,
  `fraccion` int(11) NOT NULL,
  `id_lab` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_grupo` varchar(255) NOT NULL,
  `vencimiento` varchar(20) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `info_prod` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codproducto`, `codigo`, `descripcion`, `precio`, `precioPVP`, `precioFr`, `precioFr_o`, `precioFr_c`, `existencia`, `existencia_fr`, `fraccion`, `id_lab`, `id_presentacion`, `id_tipo`, `id_grupo`, `vencimiento`, `iva`, `info_prod`) VALUES
(1, '45454545', 'Cataflan', 3.00, 5.00, 0.83, 0.83, 0.50, 8, 34, 6, 1, 4, 1, '*', '2028-02-02', 0.00, ''),
(5, '7800063810065', 'Carbamazepina 200mg', 23.00, 25.00, 1.25, 1.25, 0.00, 2, 34, 20, 1, 4, 1, '0', '2025-02-02', 0.00, 'antiepileptico'),
(6, '8902305015494', 'Betametasona', 5.00, 6.00, 1.20, 1.20, 0.00, 29, 141, 5, 2, 4, 1, '0', '2028-04-13', 0.00, ''),
(7, '7861132425306', 'Otodine 13 ml', 3.00, 5.00, 0.00, 0.00, 0.00, 19, 0, 0, 2, 5, 2, '0', '2026-02-23', 0.00, ''),
(11, '8903726290835', 'Tiquepin 25', 3.00, 6.00, 0.20, 0.20, 0.00, 1, 20, 30, 4, 4, 1, '* ', '2026-11-01', 0.00, 'Antisicótico también usado en dosis bajas para dormir. tomar en la noche 1 tab antes de dormir.'),
(12, '7861141105251', 'Carbam 200mg', 2.50, 2.20, 0.07, 0.07, 0.00, 2, 55, 30, 8, 4, 1, '* ', '2026-12-01', 0.00, 'Anticonvulsivo. Tomar 1 tableta cada 12 horas.'),
(13, '7861141105725', 'Acido valproico 500mg', 4.00, 8.00, 0.20, 0.20, 0.00, 3, 118, 40, 8, 4, 1, '*', '2025-03-01', 0.00, 'Anticonvulsivo. Tomar 1 tableta cada día.'),
(14, '764600241736', 'Dolo-medox', 2.00, 4.50, 0.00, 0.00, 0.00, 0, 0, 0, 6, 12, 14, '* ', '2026-11-01', 0.00, 'Alivio del dolor e inflamaciín de músculos, articulaciones, tendones y fifras nerviosas del cuerpo- Dolores provocados por golprs, torceduras, caídas, espalda baja, cuello o mala postura.\r\nDosis: Mayores de 12 años y adultos 1 dosis por vía intramuscular profunda una vez al día. Nota: al mezclsr el contenido de las 2 ampollas esta presenta una coloración lechosa que desaparece inmediatamente al agitar la jeringa.\r\n'),
(15, '7705959881825', 'Tramadol Clorhidrato', 1.00, 2.00, 0.00, 0.00, 0.00, 1, 0, 0, 11, 5, 9, '* ', '2024-05-01', 0.00, 'Se usa para tratar el dolor moderado a grave. Con receta médica.'),
(16, '7861148011675', 'Gentamax', 1.00, 1.60, 0.00, 0.00, 0.00, 1, 0, 0, 9, 13, 19, '*', '2025-09-01', 0.00, 'Para tratamiento tópico de infecciones primarias.'),
(17, '7501033959790', 'Creo 10000', 10.00, 12.60, 0.63, 0.63, 0.00, 2, 30, 20, 20, 4, 10, '* ', '2025-12-01', 0.00, 'Pancreatina. Enzimas pancreaticas que facilitan la digestión y faborecen la absorción de alimentos. \r\nTomar 15 minutos antes, durante o inmediatamwnte después de las comidas.'),
(18, '7861002400174', 'Topident', 3.00, 5.44, 0.00, 0.00, 0.00, 1, 0, 0, 5, 7, 22, '* ', '2023-08-01', 0.00, 'Antinflamatorio. anestesico local. antiséptico. Aplicar en ensias.'),
(19, '7862103554018', 'Bismutol', 7.00, 8.50, 0.00, 0.00, 0.00, 1, 0, 0, 15, 9, 17, '*', '2027-08-01', 0.00, 'Antidiarreico. desinflamatorio intestinal. Antiacido. a\r\nGases, NAUSEA'),
(20, '7500435131803', 'VapoRub', 1.00, 2.00, 0.00, 0.00, 0.00, 1, 0, 0, 21, 7, 5, '*', '2024-08-01', 0.00, 'Alivia la congestión nasal de los resfriados. Dolor y molestias musculares.');

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
(22, 'líquido'),
(23, 'pomada'),
(24, 'pasta'),
(25, 'linimentos'),
(26, 'Aerosol'),
(27, 'Nebulizador');

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
(9, 'Maria Sanchez', 'maria@gmail.com', 'maria', '263bce650e68ab4e23f28263760b9fa5'),
(12, 'Jadith', 'jadith@gmail.com', 'jadith', '32d769defc2f5f9eec5bfc3957ac604b');

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
(210, 6, 2.40, 1, '2025-01-26 01:34:32');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vipermisos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vipermisos` (
`id` int(11)
,`nombre` varchar(30)
,`nombre_op` varchar(200)
,`archivo` varchar(100)
,`logo_opcion` varchar(100)
,`id_detalle_per` int(11)
,`id_permiso` int(11)
,`id_usuario` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viutilidad`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `viutilidad` (
`id_venta` int(11)
,`codproducto` int(11)
,`descripcion` varchar(200)
,`cantidad` int(11)
,`precio` decimal(10,2)
,`precioPVP` decimal(10,2)
,`iva` decimal(10,2)
,`totalCosto` decimal(20,2)
,`totalPVP` decimal(20,2)
,`utilidad` decimal(21,2)
,`fecha_venta` timestamp
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vipermisos`
--
DROP TABLE IF EXISTS `vipermisos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vipermisos`  AS SELECT `p`.`id` AS `id`, `p`.`nombre` AS `nombre`, `p`.`nombre_op` AS `nombre_op`, `p`.`archivo` AS `archivo`, `p`.`logo_opcion` AS `logo_opcion`, `d`.`id` AS `id_detalle_per`, `d`.`id_permiso` AS `id_permiso`, `d`.`id_usuario` AS `id_usuario` FROM (`permisos` `p` join `detalle_permisos` `d` on(`p`.`id` = `d`.`id_permiso`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `viutilidad`
--
DROP TABLE IF EXISTS `viutilidad`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viutilidad`  AS SELECT `d`.`id_venta` AS `id_venta`, `p`.`codproducto` AS `codproducto`, `p`.`descripcion` AS `descripcion`, `d`.`cantidad` AS `cantidad`, `d`.`precio` AS `precio`, `d`.`precioPVP` AS `precioPVP`, `d`.`iva` AS `iva`, `d`.`cantidad`* `d`.`precio` AS `totalCosto`, `d`.`cantidad`* `d`.`precioPVP` AS `totalPVP`, `d`.`cantidad`* `d`.`precioPVP` - `d`.`cantidad` * `d`.`precio` AS `utilidad`, `v`.`fecha` AS `fecha_venta` FROM ((`detalle_venta` `d` join `producto` `p` on(`d`.`id_producto` = `p`.`codproducto`)) join `ventas` `v` on(`v`.`id` = `d`.`id_venta`)) ;

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
-- Indices de la tabla `grupo_cuerpo`
--
ALTER TABLE `grupo_cuerpo`
  ADD PRIMARY KEY (`id_grupo`);

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
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de la tabla `grupo_cuerpo`
--
ALTER TABLE `grupo_cuerpo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

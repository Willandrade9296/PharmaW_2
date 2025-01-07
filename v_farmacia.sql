-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2025 a las 05:36:07
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
(104, 1, 1),
(105, 2, 1),
(106, 3, 1),
(107, 4, 1),
(108, 5, 1),
(109, 6, 1),
(110, 7, 1),
(111, 8, 1),
(112, 9, 1),
(113, 10, 1),
(114, 11, 1);

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
  `precioPVP` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `id_producto`, `id_venta`, `tipo_prod`, `cantidad`, `descuento`, `precio`, `precioPVP`, `total`) VALUES
(55, 8, 106, 'U', 1, 0.00, 0.20, 0.30, 0.30),
(56, 8, 107, 'FR', 10, 0.00, 0.20, 0.30, 3.00),
(57, 8, 108, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(58, 8, 109, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(59, 8, 110, 'FR', 10, 0.00, 0.20, 0.30, 3.00),
(60, 8, 111, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(61, 8, 112, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(62, 8, 113, 'U', 10, 0.00, 0.20, 0.30, 3.00),
(63, 8, 114, 'U', 10, 0.00, 0.20, 0.30, 3.00),
(64, 8, 115, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(65, 8, 116, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(66, 8, 117, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(67, 8, 118, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(68, 8, 122, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(69, 8, 123, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(70, 8, 124, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(71, 8, 125, 'U', 10, 0.00, 0.20, 0.30, 3.00),
(72, 8, 126, 'U', 10, 0.00, 0.20, 0.30, 3.00),
(73, 8, 127, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(74, 8, 128, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(75, 8, 129, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(76, 8, 130, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(77, 8, 131, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(78, 8, 132, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(79, 8, 133, 'U', 2, 0.00, 1.00, 2.00, 4.00),
(80, 8, 134, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(81, 8, 140, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(82, 8, 149, 'U', 3, 0.00, 1.00, 2.00, 12.00),
(83, 8, 150, 'U', 1, 0.00, 0.20, 0.30, 0.30),
(84, 8, 151, 'U', 1, 0.00, 0.20, 0.30, 0.30),
(85, 8, 152, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(86, 8, 153, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(87, 8, 154, 'U', 2, 0.00, 0.20, 0.30, 0.60),
(88, 8, 155, 'U', 1, 0.00, 0.20, 0.30, 0.30),
(89, 8, 156, 'F', 1, 0.00, 0.20, 0.30, 0.30),
(90, 8, 157, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(91, 8, 158, 'F', 10, 0.00, 0.20, 0.30, 3.00),
(92, 8, 159, 'F', 20, 0.00, 0.20, 0.30, 6.00),
(93, 8, 160, 'F', 100, 0.00, 0.20, 0.30, 30.00),
(94, 7, 161, 'U', 3, 0.00, 3.00, 5.00, 15.00),
(95, 8, 162, 'F', 7, 0.00, 0.20, 0.30, 2.10),
(96, 8, 163, 'F', 3, 0.00, 0.20, 0.30, 0.90),
(97, 8, 164, 'F', 8, 0.00, 0.20, 0.30, 2.40),
(98, 8, 165, 'F', 2, 0.00, 0.20, 0.30, 0.60),
(99, 8, 166, 'F', 8, 0.00, 0.20, 0.30, 2.40),
(100, 8, 167, 'F', 3, 0.00, 0.20, 0.30, 0.90),
(101, 8, 168, 'F', 7, 0.00, 0.20, 0.30, 2.10),
(102, 8, 169, 'F', 8, 0.00, 0.20, 0.30, 2.40),
(103, 8, 170, 'F', 8, 0.00, 0.20, 0.30, 2.40),
(104, 8, 171, 'F', 2, 0.00, 0.20, 0.30, 0.60),
(105, 8, 172, 'F', 8, 0.00, 0.20, 0.30, 2.40),
(106, 8, 173, 'F', 2, 0.00, 0.20, 0.30, 0.60),
(107, 8, 174, 'F', 20, 0.00, 0.20, 0.30, 6.00),
(108, 8, 175, 'F', 2, 0.00, 0.20, 0.30, 0.60),
(109, 8, 176, 'F', 8, 0.00, 0.20, 0.30, 2.40),
(110, 8, 177, 'U', 2, 0.00, 1.00, 2.00, 4.00),
(111, 8, 178, 'F', 2, 0.00, 0.20, 0.30, 0.60),
(112, 8, 179, 'F', 2, 0.00, 0.20, 0.30, 0.60),
(113, 8, 180, 'F', 3, 0.00, 0.20, 0.30, 0.90),
(114, 8, 181, 'F', 117, 0.00, 0.20, 0.30, 35.10),
(115, 8, 182, 'F', 8, 0.00, 0.20, 0.30, 2.40),
(116, 8, 183, 'U', 11, 0.00, 1.00, 2.00, 22.00),
(117, 8, 184, 'F', 4, 0.00, 0.20, 0.30, 1.20),
(118, 8, 185, 'F', 132, 0.00, 0.20, 0.30, 39.60),
(119, 8, 186, 'F', 3, 0.00, 0.20, 0.30, 0.90),
(120, 6, 187, 'U', 1, 0.00, 5.00, 6.00, 6.00),
(121, 8, 188, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(122, 5, 188, 'F', 2, 0.00, 1.25, 1.25, 2.50),
(123, 8, 189, 'U', 1, 0.00, 1.00, 2.00, 2.00),
(124, 5, 189, 'F', 2, 0.00, 1.25, 1.25, 2.50),
(125, 8, 190, 'U', 3, 0.00, 1.00, 2.00, 12.00),
(126, 8, 190, 'F', 2, 0.00, 0.20, 0.30, 0.60),
(127, 5, 191, 'F', 2, 0.00, 1.25, 1.25, 2.50),
(128, 8, 191, 'F', 1, 0.00, 0.20, 0.30, 0.30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_cuerpo`
--

CREATE TABLE `grupo_cuerpo` (
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `detalle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo_cuerpo`
--

INSERT INTO `grupo_cuerpo` (`id_grupo`, `nombre`, `detalle`) VALUES
(4, 'Cabeza', 'Todos los dolores que tenga que ver con cabeza'),
(5, 'Pulmones', 'Para tratar dolencias o inconvenientes en los pulmones');

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
(11, 'Grupo Corporal', 'Grupo Corporal', 'grupo_c', 'fas fa-male mr-2 fa-2x');

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
  `id_grupo` int(11) NOT NULL,
  `vencimiento` varchar(20) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `info_prod` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codproducto`, `codigo`, `descripcion`, `precio`, `precioPVP`, `precioFr`, `precioFr_o`, `existencia`, `existencia_fr`, `fraccion`, `id_lab`, `id_presentacion`, `id_tipo`, `id_grupo`, `vencimiento`, `iva`, `info_prod`) VALUES
(1, '45454545', 'Cataflan', 3.00, 3.00, 0.12, 0.60, 10, 50, 5, 1, 4, 1, 0, '2028-02-02', 0.00, ''),
(5, '7800063810065', 'Carbamazepina 200mg', 23.00, 25.00, 1.25, 1.25, 2, 34, 20, 1, 4, 1, 0, '2025-02-02', 0.00, 'antiepileptico'),
(6, '8902305015494', 'Betametasona', 5.00, 6.00, 1.20, 1.20, 29, 145, 5, 2, 4, 1, 0, '2028-04-13', 0.00, ''),
(7, '7861132425306', 'Otodine 13 ml', 3.00, 5.00, 0.00, 0.00, 19, 0, 0, 2, 5, 2, 0, '2026-02-23', 0.00, ''),
(8, '7703763320127', 'Loratadina 10mg', 1.00, 2.00, 0.30, 0.20, 3, 27, 10, 1, 4, 1, 0, '2025-06-02', 0.00, 'Antihestaminico para control rapido de alergias como rinitis, estornudos, rinorea y prurito, urticaria.\r\n\r\nDosis: Adultos y niños mayores de 12 años una tableta diaria.\r\n\r\nEfectos secundarios: Mas frecuentes son sefalea fatiga y somnolencia, tambien sequedad naucea y gastritis.');

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
(106, 4, 0.30, 1, '2024-12-07 00:39:16'),
(107, 4, 3.00, 1, '2024-12-07 00:40:54'),
(108, 4, 2.00, 1, '2024-12-07 00:44:24'),
(109, 4, 2.00, 1, '2024-12-07 00:45:06'),
(110, 4, 3.00, 1, '2024-12-07 00:46:23'),
(111, 4, 2.00, 1, '2024-12-07 00:47:01'),
(112, 4, 2.00, 1, '2024-12-07 00:59:19'),
(113, 4, 3.00, 1, '2024-12-07 01:00:35'),
(114, 4, 3.00, 1, '2024-12-07 01:01:45'),
(115, 4, 2.00, 1, '2024-12-07 01:27:23'),
(116, 4, 0.60, 1, '2024-12-07 01:28:00'),
(117, 4, 2.00, 1, '2024-12-07 01:32:36'),
(118, 4, 2.00, 1, '2024-12-07 01:39:44'),
(119, 4, 0.00, 1, '2024-12-07 01:39:46'),
(120, 4, 0.00, 1, '2024-12-07 01:39:47'),
(121, 4, 0.00, 1, '2024-12-07 01:39:54'),
(122, 4, 2.00, 1, '2024-12-07 01:43:48'),
(123, 4, 2.00, 1, '2024-12-07 01:45:30'),
(124, 4, 2.00, 1, '2024-12-07 01:46:24'),
(125, 4, 3.00, 1, '2024-12-07 01:47:04'),
(126, 4, 3.00, 1, '2024-12-07 01:48:01'),
(127, 4, 2.00, 1, '2024-12-07 01:54:48'),
(128, 4, 0.60, 1, '2024-12-07 01:56:56'),
(129, 4, 0.60, 1, '2024-12-07 01:58:08'),
(130, 4, 0.60, 1, '2024-12-07 02:00:18'),
(131, 4, 0.60, 1, '2024-12-07 02:11:50'),
(132, 4, 0.60, 1, '2024-12-07 02:15:08'),
(133, 4, 4.00, 1, '2024-12-07 02:17:45'),
(134, 4, 0.60, 1, '2024-12-07 02:20:55'),
(135, 4, 0.60, 1, '2024-12-07 02:24:02'),
(136, 4, 0.60, 1, '2024-12-07 02:24:03'),
(137, 4, 0.60, 1, '2024-12-07 02:24:04'),
(138, 4, 0.60, 1, '2024-12-07 02:24:04'),
(139, 4, 0.60, 1, '2024-12-07 02:24:10'),
(140, 4, 0.60, 1, '2024-12-07 02:30:26'),
(141, 4, 0.60, 1, '2024-12-07 02:33:39'),
(142, 4, 0.60, 1, '2024-12-07 02:33:39'),
(143, 4, 0.60, 1, '2024-12-07 02:33:50'),
(144, 4, 0.60, 1, '2024-12-07 02:33:51'),
(145, 4, 2.00, 1, '2024-12-07 04:51:11'),
(146, 4, 2.00, 1, '2024-12-07 04:51:12'),
(147, 4, 2.00, 1, '2024-12-07 04:51:18'),
(148, 4, 2.00, 1, '2024-12-07 04:52:00'),
(149, 4, 12.00, 1, '2024-12-07 04:53:39'),
(150, 4, 0.30, 1, '2024-12-07 04:55:37'),
(151, 4, 0.30, 1, '2024-12-07 05:10:51'),
(152, 4, 2.00, 1, '2024-12-07 05:16:56'),
(153, 4, 0.60, 1, '2024-12-08 22:55:37'),
(154, 4, 0.60, 1, '2024-12-08 23:02:21'),
(155, 4, 0.30, 1, '2024-12-08 23:03:39'),
(156, 4, 0.30, 1, '2024-12-08 23:32:47'),
(157, 4, 2.00, 1, '2024-12-08 23:35:23'),
(158, 4, 3.00, 1, '2024-12-08 23:36:28'),
(159, 4, 6.00, 1, '2024-12-08 23:37:10'),
(160, 4, 30.00, 1, '2024-12-09 00:33:27'),
(161, 4, 15.00, 1, '2024-12-09 00:38:28'),
(162, 4, 2.10, 1, '2024-12-09 02:02:56'),
(163, 6, 0.90, 1, '2024-12-09 02:03:40'),
(164, 4, 2.40, 1, '2024-12-10 00:15:41'),
(165, 4, 0.60, 1, '2024-12-10 00:16:59'),
(166, 4, 2.40, 1, '2024-12-10 00:17:34'),
(167, 4, 0.90, 1, '2024-12-10 00:21:52'),
(168, 4, 2.10, 1, '2024-12-10 00:22:40'),
(169, 4, 2.40, 1, '2024-12-10 00:53:55'),
(170, 4, 2.40, 1, '2024-12-10 00:56:05'),
(171, 4, 0.60, 1, '2024-12-10 00:56:38'),
(172, 4, 2.40, 1, '2024-12-10 01:05:28'),
(173, 4, 0.60, 1, '2024-12-10 01:06:02'),
(174, 4, 6.00, 1, '2024-12-10 01:07:25'),
(175, 4, 0.60, 1, '2024-12-10 01:07:59'),
(176, 6, 2.40, 1, '2024-12-10 01:08:31'),
(177, 6, 4.00, 1, '2024-12-10 01:11:39'),
(178, 4, 0.60, 1, '2024-12-10 01:40:05'),
(179, 6, 0.60, 1, '2024-12-14 02:06:07'),
(180, 4, 0.90, 1, '2024-12-14 02:33:57'),
(181, 4, 35.10, 1, '2024-12-14 02:44:54'),
(182, 4, 2.40, 1, '2024-12-14 02:46:23'),
(183, 4, 22.00, 1, '2024-12-14 03:00:22'),
(184, 4, 1.20, 1, '2024-12-14 03:02:31'),
(185, 4, 39.60, 1, '2024-12-14 03:04:57'),
(186, 6, 0.90, 1, '2024-12-14 03:06:05'),
(187, 4, 6.00, 1, '2024-12-19 01:39:31'),
(188, 4, 4.50, 1, '2024-12-23 02:03:46'),
(189, 4, 2.00, 1, '2025-01-04 01:34:01'),
(190, 4, 0.60, 1, '2025-01-04 01:48:44'),
(191, 6, 0.30, 1, '2025-01-04 02:03:08');

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
-- Estructura para la vista `vipermisos`
--
DROP TABLE IF EXISTS `vipermisos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vipermisos`  AS SELECT `p`.`id` AS `id`, `p`.`nombre` AS `nombre`, `p`.`nombre_op` AS `nombre_op`, `p`.`archivo` AS `archivo`, `p`.`logo_opcion` AS `logo_opcion`, `d`.`id` AS `id_detalle_per`, `d`.`id_permiso` AS `id_permiso`, `d`.`id_usuario` AS `id_usuario` FROM (`permisos` `p` join `detalle_permisos` `d` on(`p`.`id` = `d`.`id_permiso`)) ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `grupo_cuerpo`
--
ALTER TABLE `grupo_cuerpo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

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

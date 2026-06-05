-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 11-07-2023 a las 22:06:16
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `elobrero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_cod` int(11) NOT NULL,
  `cliente_nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cliente_cuit` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_cod`, `cliente_nom`, `cliente_cuit`) VALUES
(1, 'Consumidor Final', '00-00000000-0'),
(12, 'mario', '30389717361'),
(14, 'milton', '301922013'),
(15, 'milfer', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `compra_cod` int(11) NOT NULL,
  `compra_fecha` date DEFAULT NULL,
  `compra_total` decimal(10,2) DEFAULT NULL,
  `compra_estado` int(1) DEFAULT NULL,
  `proveedor_cod` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`compra_cod`, `compra_fecha`, `compra_total`, `compra_estado`, `proveedor_cod`) VALUES
(51, '2021-12-07', '2000.00', 0, 10),
(52, '2021-12-07', '1500.00', 0, 12),
(53, '2021-12-14', '5.00', 1, 11),
(55, '2021-12-16', '2840.00', 1, 10),
(65, '2022-02-07', '1000.00', 1, 10),
(66, '2022-02-08', '25.00', 1, 10),
(72, '2022-03-21', '98.00', 1, 11),
(75, '2022-04-13', '1000.00', 1, 12),
(80, NULL, NULL, NULL, NULL),
(81, NULL, NULL, NULL, NULL),
(82, '2022-10-11', '5.00', 1, 12),
(86, '2022-10-17', '5250.00', 1, 11),
(87, '2022-10-17', '5000.00', 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `detallecompra_cod` int(11) NOT NULL,
  `compra_cod` int(11) DEFAULT NULL,
  `producto_cod` int(11) DEFAULT NULL,
  `cantidad` float(10,2) DEFAULT NULL,
  `ingreso_precio` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detallecompra`
--

INSERT INTO `detallecompra` (`detallecompra_cod`, `compra_cod`, `producto_cod`, `cantidad`, `ingreso_precio`, `subtotal`) VALUES
(31, 52, 23, 15.00, '100.00', '1500.00'),
(35, 55, 24, 5.00, '100.00', '500.00'),
(36, 55, 25, 3.00, '500.00', '1500.00'),
(37, 55, 23, 7.00, '120.00', '840.00'),
(43, 65, 24, 10.00, '100.00', '1000.00'),
(44, 66, 24, 1.00, '13.00', '13.00'),
(45, 66, 666, 1.00, '123.00', '123.00'),
(46, 66, 25, 1.00, '6.00', '6.00'),
(47, 66, 25, 1.00, '6.00', '6.00'),
(48, 72, 22, 49.00, '2.00', '98.00'),
(49, 75, 23, 10.00, '100.00', '1000.00'),
(51, 81, 22, 20.00, '10.00', '200.00'),
(52, 82, 19, 1.00, '5.00', '5.00'),
(54, 86, 19, 150.00, '5.00', '750.00'),
(55, 86, 22, 100.00, '5.00', '500.00'),
(56, 86, 28, 5.00, '800.00', '4000.00'),
(57, 87, 23, 10.00, '230.00', '2300.00'),
(58, 87, 24, 3.00, '600.00', '1800.00'),
(59, 87, 25, 1.00, '900.00', '900.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallenota`
--

CREATE TABLE `detallenota` (
  `detallenota_cod` int(11) NOT NULL,
  `nota_cod` int(11) DEFAULT NULL,
  `producto_cod` int(11) DEFAULT NULL,
  `cantidad` float(10,2) DEFAULT NULL,
  `subtotal` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `detalleventa_cod` int(11) NOT NULL,
  `venta_cod` int(11) DEFAULT NULL,
  `producto_cod` int(11) DEFAULT NULL,
  `producto_precio` decimal(10,2) DEFAULT NULL,
  `cantidad` float(10,2) DEFAULT NULL,
  `subtotal` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalleventa`
--

INSERT INTO `detalleventa` (`detalleventa_cod`, `venta_cod`, `producto_cod`, `producto_precio`, `cantidad`, `subtotal`) VALUES
(82, 446, 22, '5.00', 1.00, 5.00),
(88, 447, 22, '5.00', 1.00, 5.00),
(95, 457, 23, '145.20', 1.00, 145.20),
(96, 457, 26, '50.00', 5.00, 250.00),
(98, 457, 24, '121.00', 6.00, 726.00),
(99, 458, 20, '7.50', 1.00, 7.50),
(100, 459, 24, '121.00', 2.00, 242.00),
(101, 462, 22, '5.00', 1.00, 5.00),
(104, 470, 25, '8.40', 1.00, 8.40),
(105, 498, 22, '5.00', 1.00, 5.00),
(106, 498, 22, '5.00', 1.00, 5.00),
(107, 504, 22, '3.00', 3.00, 9.00),
(108, 505, 33, '40.00', 100.00, 4000.00),
(110, 507, 20, '7.50', 3.00, 22.50),
(111, 507, 34, '700.00', 5.50, 3850.00),
(112, 508, 33, '40.00', 50.00, 2000.00),
(113, 509, 34, '700.00', 1.50, 1050.00),
(114, 510, 32, '210.00', 5.00, 1050.00),
(115, 513, 30, '3500.00', 1.00, 3500.00),
(116, 515, 22, '3.00', 1.00, 3.00),
(117, 515, 23, '90.00', 1.00, 90.00),
(118, 515, 34, '700.00', 1.00, 700.00),
(119, 517, 22, '3.00', 1.80, 5.40),
(138, 544, 19, '7.50', 15.00, 112.50),
(142, 547, 19, '7.50', 1.00, 7.50),
(145, 549, 32, '210.00', 15.00, 3150.00),
(149, 555, 33, '40.00', 200.00, 8000.00),
(151, 557, 36, '500.00', 2.00, 1000.00),
(152, 560, 23, '104.00', 2.00, 208.00),
(153, 561, 23, '104.00', 2.00, 208.00),
(156, 564, 48, '10.00', 1.00, 10.00),
(157, 565, 19, '7.50', 3.00, 22.50),
(165, 578, 33, '40.00', 1.00, 40.00),
(167, 579, 33, '40.00', 2.00, 80.00),
(168, 580, 33, '40.00', 2.00, 80.00),
(169, 582, 33, '40.00', 1.00, 40.00),
(170, 582, 38, '5.00', 1.00, 5.00),
(171, 583, 33, '40.00', 1.00, 40.00),
(172, 584, 38, '5.00', 7.00, 35.00),
(173, 588, 19, '7.50', 12.00, 90.00),
(174, 589, 33, '40.00', 10.00, 400.00),
(175, 590, 38, '5.00', 15.00, 75.00),
(176, 591, 38, '5.00', 1.00, 5.00),
(177, 598, 48, '10.00', 1.00, 10.00),
(178, 598, 32, '210.00', 1.00, 210.00),
(179, 599, 38, '5.00', 10.00, 50.00),
(180, 600, 38, '5.00', 20.00, 100.00),
(181, 601, 33, '40.00', 1.00, 40.00),
(182, 602, 33, '40.00', 1.00, 40.00),
(183, 603, 33, '40.00', 2.00, 80.00),
(184, 604, 33, '40.00', 5.00, 200.00),
(185, 605, 33, '40.00', 5.00, 200.00),
(186, 606, 33, '40.00', 123.00, 4920.00),
(187, 607, 33, '40.00', 10.00, 400.00),
(188, 608, 33, '40.00', 2.50, 100.00),
(189, 609, 33, '40.00', 1.00, 40.00),
(190, 610, 19, '7.50', 1.00, 7.50),
(191, 615, 33, '40.00', 44.50, 1780.00),
(192, 616, 33, '40.00', 1.50, 60.00),
(193, 616, 33, '40.00', 1.75, 70.00),
(194, 616, 33, '40.00', 1.90, 76.00),
(195, 616, 33, '40.00', 1.91, 76.40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notadecredito`
--

CREATE TABLE `notadecredito` (
  `nota_cod` int(11) NOT NULL,
  `nota_fecha` date DEFAULT NULL,
  `nota_total` decimal(10,2) DEFAULT NULL,
  `nota_estado` int(1) DEFAULT NULL,
  `venta_cod` int(11) DEFAULT NULL,
  `usuario_cod` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `notadecredito`
--

INSERT INTO `notadecredito` (`nota_cod`, `nota_fecha`, `nota_total`, `nota_estado`, `venta_cod`, `usuario_cod`) VALUES
(27, '2021-12-14', '34.00', 0, 428, 0),
(35, '2022-01-11', '145.20', 0, 429, 0),
(38, '2022-02-07', '363.00', 0, 458, 15),
(40, '2022-02-08', '290.20', 0, 555, 0),
(41, '2022-02-08', '5.00', 0, 6666, 0),
(43, '2022-02-08', '5.00', 0, 1241243, 0),
(45, '2022-02-08', '5.00', 0, 427, 0),
(57, '2022-03-21', '15.00', 0, 436, 0),
(59, '2022-04-12', '1500.00', 0, 507, 0),
(63, '2022-05-30', '7.50', 0, 520, 0),
(64, NULL, NULL, NULL, NULL, NULL),
(65, '2022-05-30', '7.50', 0, 520, 0),
(66, '0000-00-00', '15.00', 0, 1, 15),
(67, '2022-05-31', '10.00', 0, 554, 0),
(68, '2022-05-31', '10.00', 0, 556, 0),
(69, '2022-05-31', '500.00', 0, 557, 0),
(70, '2022-05-31', '292.00', 0, 561, 0),
(72, '2022-05-31', '100.00', 0, 562, 0),
(73, '2022-05-31', '75.00', 0, 563, 0),
(74, '2022-05-31', '0.00', 1, 569, 0),
(76, '2022-06-06', '40.00', 0, 578, 0),
(77, '2022-06-06', '75.00', 0, 582, 0),
(78, '2022-06-06', '35.00', 0, 583, 0),
(79, '2022-09-29', '252.00', 1, 609, 0),
(80, '2022-09-29', '5.00', 1, 470, 0),
(83, '2022-10-11', '7.50', 1, 470, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `oferta_cod` int(11) NOT NULL,
  `producto_cod` int(11) DEFAULT NULL,
  `oferta_desc` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fecha_cierre` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE `presupuesto` (
  `presupuesto_cod` int(11) NOT NULL,
  `producto_cod` int(11) DEFAULT NULL,
  `cantidad` float(10,2) DEFAULT NULL,
  `subtotal` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_cod` int(11) NOT NULL,
  `fecha_mod` date DEFAULT NULL,
  `producto_desc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `producto_precio` float(10,2) DEFAULT NULL,
  `precio_actual` float(10,2) DEFAULT NULL,
  `producto_cant` float(10,2) DEFAULT NULL,
  `producto_cantmin` float(10,2) DEFAULT NULL,
  `producto_med` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `producto_foto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `proveedor_cod` int(4) DEFAULT NULL,
  `rubro_cod` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_cod`, `fecha_mod`, `producto_desc`, `producto_precio`, `precio_actual`, `producto_cant`, `producto_cantmin`, `producto_med`, `producto_foto`, `proveedor_cod`, `rubro_cod`) VALUES
(19, '2022-05-27', 'tornillo', 8.50, 8.50, 237.00, 50.00, 'Unidad', 'tornillo.jpg', 11, 15),
(20, '2022-04-12', 'lijas', 7.50, 7.50, 178.00, 5.00, NULL, 'lija.jpg', 12, 15),
(22, '2022-10-24', 'gomas para canilla', 8.50, 8.50, 264.00, 30.00, 'Unidad', '0', 12, 12),
(23, '2022-10-24', 'canilla esferica', 391.00, 391.00, 15.00, 5.00, 'Unidad', 'canillaesf.jpg', 10, 12),
(24, '2022-10-25', 'pala corazon', 1020.00, 1020.00, 15.00, 1.00, 'Unidad', 'yeso.jpg', 12, 15),
(25, '2022-11-07', 'pileta lavarropa', 1530.00, 1530.00, 1.00, 2.00, 'Unidad', 'piletalavarropa.jpg', 10, 12),
(26, '2022-11-14', 'espatula', 50.00, 50.00, 50.00, 3.00, 'Unidad', 'espatula.jpg', 12, 15),
(27, '2022-11-14', 'llave ajustable', 100.00, 100.00, 10.00, 3.00, 'Unidad', 'llave.jpg', 12, 15),
(28, '2022-11-21', 'llave para lavabo', 1360.00, 1360.00, 10.00, 3.00, 'Unidad', 'lavabo.jpg', 11, 15),
(29, '2022-06-02', 'pala cuadrada', 2000.00, 2000.00, 5.00, 2.00, 'Unidad', '0', 12, 15),
(30, '2022-03-07', 'tapa medido de gas', 3500.00, 3500.00, 4.00, 1.00, NULL, 'medidorgas.jpg', 12, 13),
(32, '2022-03-07', 'tubo 20 homeplast', 210.00, 210.00, 29.00, 10.00, NULL, 'tubohomeplast.jpg', 12, 14),
(33, '2022-10-24', 'cable 2,5', 40.00, 40.00, 231.00, 50.00, 'Metro', '0', 10, 12),
(34, '2022-05-26', 'alambre x kg', 700.00, 700.00, 492.00, 20.00, NULL, '0', 12, 15),
(35, '2022-11-14', 'pintura latex', 1500.00, 1500.00, 11.00, 2.00, 'Litro', 'pintura latex.jpg', 12, 16),
(36, '2022-11-14', 'pintura sintetica', 500.00, 500.00, 22.00, 3.00, 'Unidad', 'pinturasintetica.jpg', 12, 16),
(38, '2022-11-07', 'Arandela viselada 5mm', 5.00, 5.00, 57.00, 30.00, 'Unidad', '0', 12, 15),
(48, '2022-05-27', 'codo 100 pvc', 10.00, 10.00, 3.00, 5.00, 'Unidad', '0', 12, 12),
(49, '2022-10-24', 'cable 1x1.5', 5.00, 5.00, 3.00, 3.00, 'Metro', '0', 13, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_cod` int(11) NOT NULL,
  `proveedor_nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `proveedor_email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `proveedor_telef` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `proveedor_cbu` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_cod`, `proveedor_nom`, `proveedor_email`, `proveedor_telef`, `proveedor_cbu`) VALUES
(10, 'fiori', 'fiori@gmail.com', '4224454', '1111222233334444500'),
(11, 'tubonor', 'tubono@gmail.com', '4224444', '9223372036854775807'),
(12, '7030', '7030@gmail.com', '4233906', '00000115555555'),
(13, 'RD', 'rd@gmail.com', '4224458', 'Aguila calva'),
(14, 'Horizonte SRL', 'h@gmail.com', '55556666', '000000255588866');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro`
--

CREATE TABLE `rubro` (
  `rubro_cod` int(4) NOT NULL,
  `rubro_desc` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rubro`
--

INSERT INTO `rubro` (`rubro_cod`, `rubro_desc`) VALUES
(12, 'agua'),
(13, 'gas'),
(14, 'electricidad'),
(15, 'herramientas'),
(16, 'pinturas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_cod` int(11) NOT NULL,
  `usuario_nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `usuario_dni` int(10) DEFAULT NULL,
  `usuario_clave` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `usuario_telef` bigint(20) DEFAULT NULL,
  `usuario_cbu` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_cod`, `usuario_nom`, `usuario_dni`, `usuario_clave`, `usuario_telef`, `usuario_cbu`) VALUES
(0, 'Admin', 12345678, '12345678', 88888888, '000001111222'),
(15, 'Milton', 8192201, '1234', 3884105280, '111122223333');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `venta_cod` int(11) NOT NULL,
  `venta_fecha` date DEFAULT NULL,
  `venta_total` float(10,2) DEFAULT NULL,
  `cliente_cod` int(11) DEFAULT NULL,
  `usuario_cod` int(11) DEFAULT NULL,
  `nota_resto` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`venta_cod`, `venta_fecha`, `venta_total`, `cliente_cod`, `usuario_cod`, `nota_resto`) VALUES
(470, '2022-02-09', 8.40, 1, 0, NULL),
(504, '2022-04-11', 9.00, 1, 0, NULL),
(505, '2022-04-11', 4000.00, 12, 0, NULL),
(507, '2022-04-11', 3872.50, 1, 0, NULL),
(508, '2022-04-27', 2000.00, 1, 15, NULL),
(509, '2022-04-27', 1050.00, 1, 15, NULL),
(510, '2022-04-27', 1050.00, 14, 0, NULL),
(513, '2022-05-02', 3500.00, 1, 0, NULL),
(514, NULL, NULL, NULL, NULL, NULL),
(515, '2022-05-17', 793.00, 1, 0, NULL),
(517, '2022-05-26', 5.40, 1, 0, NULL),
(518, NULL, NULL, NULL, NULL, NULL),
(519, '2022-05-27', 15.75, 1, 0, NULL),
(520, NULL, NULL, NULL, NULL, NULL),
(527, '2022-05-30', -2.50, 1, 0, NULL),
(528, '2022-05-30', -2.50, 1, 0, NULL),
(529, '2022-05-30', -2.50, 1, 0, NULL),
(530, NULL, NULL, NULL, NULL, NULL),
(531, NULL, NULL, NULL, NULL, NULL),
(532, '2022-05-30', 0.00, 1, 0, NULL),
(533, NULL, NULL, NULL, NULL, NULL),
(534, '2022-05-30', 142.50, 1, 0, NULL),
(535, '2022-05-30', -2.50, 12, 0, NULL),
(536, NULL, NULL, NULL, NULL, NULL),
(537, '2022-05-30', 0.00, 1, 0, NULL),
(540, NULL, NULL, NULL, NULL, NULL),
(541, '2022-05-30', 5.00, 1, 0, NULL),
(542, '2022-05-30', 5.00, 1, 0, NULL),
(543, NULL, NULL, NULL, NULL, NULL),
(544, '2022-05-30', 110.00, 1, 0, NULL),
(545, '2022-05-30', 92.50, 1, 0, NULL),
(546, '2022-05-30', 97.50, 1, 0, NULL),
(547, '2022-05-30', 7.50, 12, 0, NULL),
(549, '2022-05-30', 2864.80, 1, 0, NULL),
(550, NULL, NULL, NULL, NULL, NULL),
(552, NULL, NULL, NULL, NULL, NULL),
(554, NULL, NULL, NULL, NULL, NULL),
(555, '2022-05-31', 8000.00, 1, 0, NULL),
(556, '2022-05-31', 5.00, 1, 0, NULL),
(557, '2022-05-31', 0.00, 1, 0, 59.00),
(558, '2022-05-31', 0.00, 1, 0, 59.00),
(560, '2022-05-31', 208.00, 1, 0, 0.00),
(561, '2022-05-31', 0.00, 1, 0, 69.00),
(562, '2022-05-31', 125.00, 1, 0, NULL),
(563, '2022-05-31', 0.00, 1, 0, 75.00),
(564, '2022-05-31', 10.00, 1, 0, NULL),
(565, '2022-05-31', 22.50, 1, 0, NULL),
(566, '2022-05-31', 5.00, 1, 0, 0.00),
(568, NULL, NULL, NULL, NULL, NULL),
(569, '2022-05-31', 0.00, 1, 0, 0.00),
(570, NULL, NULL, NULL, NULL, NULL),
(571, '2022-05-31', 0.00, 1, 0, 5.00),
(572, '2022-05-31', 5.00, 1, 0, 0.00),
(575, NULL, NULL, NULL, NULL, NULL),
(578, '2022-06-06', 40.00, 1, 0, 0.00),
(579, '2022-06-06', 0.00, 1, 0, 40.00),
(580, '2022-06-06', 65.00, 1, 0, 15.00),
(581, NULL, NULL, NULL, NULL, NULL),
(582, '2022-06-06', 0.00, 1, 0, 75.00),
(583, '2022-06-06', 0.00, 1, 0, 75.00),
(584, '2022-06-06', 0.00, 1, 0, 35.00),
(588, NULL, NULL, NULL, NULL, NULL),
(589, NULL, NULL, NULL, NULL, NULL),
(590, NULL, NULL, NULL, NULL, NULL),
(591, '2022-09-19', 5.00, 1, 0, 0.00),
(592, NULL, NULL, NULL, NULL, NULL),
(593, NULL, NULL, NULL, NULL, NULL),
(597, NULL, NULL, NULL, NULL, NULL),
(599, NULL, NULL, NULL, NULL, NULL),
(600, '2022-09-29', 100.00, 1, 0, 10.00),
(603, '2022-09-29', 80.00, 1, 0, 0.00),
(605, '2022-09-29', 200.00, 1, 0, 10.00),
(607, '2022-09-29', 390.00, 1, 0, 10.00),
(608, '2022-09-29', 0.00, 1, 0, 100.00),
(609, '2022-09-29', 0.00, 1, 0, 292.00),
(610, '2022-09-29', 7.50, 1, 0, 0.00),
(611, NULL, NULL, NULL, NULL, NULL),
(615, '2022-10-11', 1780.00, 12, 0, 0.00),
(616, '2022-10-11', 282.40, 1, 0, 0.00),
(620, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_cod`) USING BTREE;

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`compra_cod`),
  ADD KEY `proveedor_cod` (`proveedor_cod`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD PRIMARY KEY (`detallecompra_cod`),
  ADD KEY `producto_cod` (`producto_cod`),
  ADD KEY `compra_num` (`compra_cod`);

--
-- Indices de la tabla `detallenota`
--
ALTER TABLE `detallenota`
  ADD PRIMARY KEY (`detallenota_cod`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`detalleventa_cod`),
  ADD KEY `producto_cod` (`producto_cod`),
  ADD KEY `venta_num` (`venta_cod`);

--
-- Indices de la tabla `notadecredito`
--
ALTER TABLE `notadecredito`
  ADD PRIMARY KEY (`nota_cod`),
  ADD KEY `usuario_cod` (`usuario_cod`),
  ADD KEY `venta_num` (`venta_cod`);

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`oferta_cod`),
  ADD KEY `producto_cod` (`producto_cod`);

--
-- Indices de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD PRIMARY KEY (`presupuesto_cod`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_cod`),
  ADD KEY `proveedor_cod` (`proveedor_cod`),
  ADD KEY `rubro_cod` (`rubro_cod`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`proveedor_cod`);

--
-- Indices de la tabla `rubro`
--
ALTER TABLE `rubro`
  ADD PRIMARY KEY (`rubro_cod`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_cod`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`venta_cod`),
  ADD KEY `usuario_cod` (`usuario_cod`),
  ADD KEY `cliente_cod` (`cliente_cod`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `compra_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  MODIFY `detallecompra_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `detallenota`
--
ALTER TABLE `detallenota`
  MODIFY `detallenota_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  MODIFY `detalleventa_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT de la tabla `notadecredito`
--
ALTER TABLE `notadecredito`
  MODIFY `nota_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `oferta_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  MODIFY `presupuesto_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `rubro`
--
ALTER TABLE `rubro`
  MODIFY `rubro_cod` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `venta_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

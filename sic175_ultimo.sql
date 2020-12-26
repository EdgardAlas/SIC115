-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 24, 2020 at 08:56 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sic175`
--

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `periodo` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`id`, `titulo`, `descripcion`, `periodo`, `cuenta`) VALUES
(228, 'clasificacion', 'activo', 21, 239),
(229, 'clasificacion', 'pasivo', 21, 240),
(230, 'clasificacion', 'patrimonio', 21, 241),
(231, 'clasificacion', 'gastos', 21, 275),
(232, 'clasificacion', 'ingresos', 21, 278),
(233, 'cierre', 'pye', 21, 296),
(234, 'cierre', 'iva_credito', 21, 272),
(235, 'cierre', 'iva_debito', 21, 273),
(236, 'cierre', 'impuesto_iva', 21, 270),
(237, 'estado_resultados', 'ventas', 21, 277),
(238, 'estado_resultados', 'rebajas_ventas', 21, 284),
(239, 'estado_resultados', 'compras', 21, 280),
(240, 'estado_resultados', 'gastos_compras', 21, 285),
(241, 'estado_resultados', 'rebajas_compras', 21, 283),
(242, 'estado_resultados', 'inventario', 21, 251),
(243, 'estado_resultados', 'gastos_operacion', 21, 286),
(244, 'estado_resultados', 'otros_productos', 21, 281),
(245, 'estado_resultados', 'otros_gastos', 21, 290),
(246, 'estado_resultados', 'reserva_legal', 21, 292),
(247, 'estado_resultados', 'impuesto_renta', 21, 270),
(248, 'estado_resultados', 'utilidad', 21, 293),
(249, 'estado_resultados', 'perdida', 21, 293),
(422, 'clasificacion', 'activo', 23, 300),
(423, 'clasificacion', 'pasivo', 23, 383),
(424, 'clasificacion', 'patrimonio', 23, 450),
(425, 'clasificacion', 'gastos', 23, 465),
(426, 'clasificacion', 'ingresos', 23, 571),
(427, 'cierre', 'pye', 23, 582),
(428, 'cierre', 'iva_credito', 23, 338),
(429, 'cierre', 'iva_debito', 23, 433),
(430, 'cierre', 'impuesto_iva', 23, 428),
(431, 'estado_resultados', 'ventas', 23, 573),
(432, 'estado_resultados', 'rebajas_ventas', 23, 577),
(433, 'estado_resultados', 'compras', 23, 467),
(434, 'estado_resultados', 'gastos_compras', 23, 470),
(435, 'estado_resultados', 'rebajas_compras', 23, 472),
(436, 'estado_resultados', 'inventario', 23, 341),
(437, 'estado_resultados', 'gastos_operacion', 23, 474),
(438, 'estado_resultados', 'otros_productos', 23, 579),
(439, 'estado_resultados', 'otros_gastos', 23, 568),
(440, 'estado_resultados', 'reserva_legal', 23, 459),
(441, 'estado_resultados', 'impuesto_renta', 23, 427),
(442, 'estado_resultados', 'utilidad', 23, 461),
(443, 'estado_resultados', 'perdida', 23, 461);

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo_saldo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `saldo` decimal(10,2) DEFAULT '0.00',
  `nivel` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `ultimo_nivel` tinyint(4) DEFAULT '1',
  `empresa` int(11) NOT NULL,
  `padre` int(11) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cuenta`
--

INSERT INTO `cuenta` (`id`, `codigo`, `nombre`, `tipo_saldo`, `saldo`, `nivel`, `orden`, `ultimo_nivel`, `empresa`, `padre`, `periodo`) VALUES
(9, '1', 'ACTIVO', 'Deudor', '0.00', 1, 1, 0, 1, NULL, 22),
(10, '11', 'ACTIVOS CORRIENTE', 'Deudor', '0.00', 2, 1, 0, 1, 9, 22),
(11, '1101', 'EFECTIVO Y EQUIVALENTES DE EFECTIVO', 'Deudor', '0.00', 3, 1, 0, 1, 10, 22),
(12, '110101', 'Caja general', 'Deudor', '0.00', 4, 1, 0, 1, 11, 22),
(13, '11010102', 'Caja chica', 'Deudor', '0.00', 5, 1, 1, 1, 12, 22),
(14, '11010103', 'Bancos', 'Deudor', '0.00', 5, 1, 0, 1, 12, 22),
(15, '1101010301', 'Cuenta corriente', 'Deudor', '0.00', 6, 1, 1, 1, 14, 22),
(16, '1101010302', 'Cuenta de ahorro', 'Deudor', '0.00', 6, 1, 1, 1, 14, 22),
(17, '1101010304', 'DepÃ³sitos a plazo', 'Deudor', '0.00', 6, 1, 1, 1, 14, 22),
(18, '1102', 'INVERSIONES A CORTO PLAZO', 'Deudor', '0.00', 3, 1, 0, 1, 10, 22),
(19, '110201', 'Acciones', 'Deudor', '0.00', 4, 1, 1, 1, 18, 22),
(20, '110202', 'Bonos', 'Deudor', '0.00', 4, 1, 1, 1, 18, 22),
(21, '110203', 'Otros tÃ­tulos valores', 'Deudor', '0.00', 4, 1, 1, 1, 18, 22),
(22, '1103', 'CUENTAS POR COBRAR', 'Deudor', '0.00', 3, 1, 1, 1, 10, 22),
(23, '1104', 'DOCUMENTOS POR COBRAR', 'Deudor', '0.00', 3, 1, 1, 1, 10, 22),
(24, '1105', 'ACCIONISTAS', 'Deudor', '0.00', 3, 1, 1, 1, 10, 22),
(25, '1106', 'PRESTAMOS A EMPLEADOS Y ACCIONISTAS', 'Deudor', '0.00', 3, 1, 0, 1, 10, 22),
(26, '110601', 'Accionistas', 'Deudor', '0.00', 4, 1, 1, 1, 25, 22),
(27, '110602', 'Empleados', 'Deudor', '0.00', 4, 1, 1, 1, 25, 22),
(28, '1107', 'OTRAS CUENTAS POR COBRAR', 'Deudor', '0.00', 3, 1, 0, 1, 10, 22),
(29, '110701', 'Anticipo a proveedores', 'Deudor', '0.00', 4, 1, 1, 1, 28, 22),
(30, '110702', 'Anticipo de salarios a empleados', 'Deudor', '0.00', 4, 1, 1, 1, 28, 22),
(31, '1108R', 'ESTIMACION POR CUENTAS INCOBRABLES', 'Acreedor', '0.00', 3, 1, 1, 1, 10, 22),
(32, '1109', 'INVENTARIOS', 'Deudor', '0.00', 3, 1, 1, 1, 10, 22),
(33, '1110R', 'ESTIMACION PARA DETERIORO DE INVENTARIO', 'Acreedor', '0.00', 3, 1, 1, 1, 10, 22),
(34, '1111', 'GASTOS PAGADOS POR ANTICIPADO', 'Deudor', '0.00', 3, 1, 0, 1, 10, 22),
(35, '111101', 'Seguros', 'Deudor', '0.00', 4, 1, 1, 1, 34, 22),
(36, '111102', 'Alquileres', 'Deudor', '0.00', 4, 1, 1, 1, 34, 22),
(37, '111103', 'PapelerÃ­a y Ãºtiles', 'Deudor', '0.00', 4, 1, 1, 1, 34, 22),
(38, '111104', 'Pago a cuenta', 'Deudor', '0.00', 4, 1, 1, 1, 34, 22),
(39, '111105', 'Otros gastos pagados por anticipados', 'Deudor', '0.00', 4, 1, 1, 1, 34, 22),
(40, '1112', 'IVA CREDITO FISCAL', 'Deudor', '0.00', 3, 1, 1, 1, 10, 22),
(41, '1113', 'IVA PAGADO POR ANTICIPADO', 'Deudor', '0.00', 3, 1, 0, 1, 10, 22),
(42, '111301', 'IVA percibido', 'Deudor', '0.00', 4, 1, 1, 1, 41, 22),
(43, '111302', 'IVA Retenido', 'Deudor', '0.00', 4, 1, 1, 1, 41, 22),
(44, '1114', 'PAGO A CUENTA', 'Deudor', '0.00', 3, 1, 1, 1, 10, 22),
(45, '12', 'ACTIVOS NO CORRIENTES', 'Deudor', '0.00', 2, 1, 0, 1, 9, 22),
(46, '1201', 'PROPIEDAD PLANTA Y EQUIPO', 'Deudor', '0.00', 3, 1, 0, 1, 45, 22),
(47, '120101', 'Terrenos', 'Deudor', '0.00', 4, 1, 1, 1, 46, 22),
(48, '120102', 'Edificios', 'Deudor', '0.00', 4, 1, 1, 1, 46, 22),
(49, '120103', 'Intalaciones', 'Deudor', '0.00', 4, 1, 1, 1, 46, 22),
(50, '120104', 'Equipo de reparto', 'Deudor', '0.00', 4, 1, 1, 1, 46, 22),
(51, '120105', 'Mobiliario y equipo', 'Deudor', '0.00', 4, 1, 1, 1, 46, 22),
(52, '1202R', 'DEPRECIACIONES', 'Acreedor', '0.00', 3, 1, 0, 1, 45, 22),
(53, '120201R', 'Edificio', 'Acreedor', '0.00', 4, 1, 1, 1, 52, 22),
(54, '120202R', 'Intalaciones', 'Acreedor', '0.00', 4, 1, 1, 1, 52, 22),
(55, '120203R', 'Equipo de reparto', 'Acreedor', '0.00', 4, 1, 1, 1, 52, 22),
(56, '120204R', 'Mobiliario y equipo', 'Acreedor', '0.00', 4, 1, 1, 1, 52, 22),
(57, '1203', 'INSTANGIBLES', 'Deudor', '0.00', 3, 1, 0, 1, 45, 22),
(58, '120301', 'CrÃ©dito mercantil', 'Deudor', '0.00', 4, 1, 1, 1, 57, 22),
(59, '120302', 'Patentes y marcas', 'Deudor', '0.00', 4, 1, 1, 1, 57, 22),
(60, '120303', 'Licencias', 'Deudor', '0.00', 4, 1, 1, 1, 57, 22),
(61, '1204R', 'AMORTIZACION DE INTANGIBLES', 'Deudor', '0.00', 3, 1, 0, 1, 45, 22),
(62, '120401R', 'CrÃ©dito mercantil', 'Deudor', '0.00', 4, 1, 1, 1, 61, 22),
(63, '120402R', 'Patentes y marcas', 'Deudor', '0.00', 4, 1, 1, 1, 61, 22),
(64, '120403R', 'Licencias', 'Deudor', '0.00', 4, 1, 1, 1, 61, 22),
(65, '1205', 'INVERSIONES PERMANENTES', 'Deudor', '0.00', 3, 1, 1, 1, 45, 22),
(66, '1206', 'IMPUESTO SOBRE LA RENTA DIFERIDO', 'Deudor', '0.00', 3, 1, 1, 1, 45, 22),
(67, '2', 'PASIVO', 'Acreedor', '0.00', 1, 2, 0, 1, NULL, 22),
(68, '21', 'PASIVOS CORRIENTE', 'Acreedor', '0.00', 2, 2, 0, 1, 67, 22),
(69, '2101', 'SOBREGIROS BANCARIOS', 'Acreedor', '0.00', 3, 2, 1, 1, 68, 22),
(70, '2102', 'PROVEEDORES', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(71, '210201', 'Locales', 'Acreedor', '0.00', 4, 2, 1, 1, 70, 22),
(72, '210202', 'Extranjeros', 'Acreedor', '0.00', 4, 2, 1, 1, 70, 22),
(73, '2103', 'DOCUMENTOS POR COBRAR DESCONTADOS', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(74, '210301', 'Pagares', 'Acreedor', '0.00', 4, 2, 1, 1, 73, 22),
(75, '210302', 'Letras de cambio', 'Acreedor', '0.00', 4, 2, 1, 1, 73, 22),
(76, '210303', 'Bonos', 'Acreedor', '0.00', 4, 2, 1, 1, 73, 22),
(77, '210304', 'Otros tÃ­tulos valores', 'Acreedor', '0.00', 4, 2, 1, 1, 73, 22),
(78, '2104', 'DOCUMENTOS POR PAGAR', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(79, '210401', 'Pagares', 'Acreedor', '0.00', 4, 2, 1, 1, 78, 22),
(80, '210402', 'Letras de cambio', 'Acreedor', '0.00', 4, 2, 1, 1, 78, 22),
(81, '210403', 'Bonos', 'Acreedor', '0.00', 4, 2, 1, 1, 78, 22),
(82, '210404', 'Otros tÃ­tulos valores', 'Acreedor', '0.00', 4, 2, 1, 1, 78, 22),
(83, '2105', 'PRESTAMOS POR PAGAR', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(84, '210501', 'Bancarios', 'Acreedor', '0.00', 4, 2, 1, 1, 83, 22),
(85, '210502', 'Accionistas', 'Acreedor', '0.00', 4, 2, 1, 1, 83, 22),
(86, '210503', 'Otros', 'Acreedor', '0.00', 4, 2, 1, 1, 83, 22),
(87, '2106', 'RETENCIONES POR PAGAR', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(88, '210601', 'ISSS (salud)', 'Acreedor', '0.00', 4, 2, 1, 1, 87, 22),
(89, '210602', 'ISSS (pensiÃ³n)', 'Acreedor', '0.00', 4, 2, 1, 1, 87, 22),
(90, '210603', 'AFP', 'Acreedor', '0.00', 4, 2, 1, 1, 87, 22),
(91, '210604', 'RENTA', 'Acreedor', '0.00', 4, 2, 1, 1, 87, 22),
(92, '210605', 'IVA', 'Acreedor', '0.00', 4, 2, 1, 1, 87, 22),
(93, '2107', 'PROVISIONES POR PAGAR', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(94, '210701', 'ISSS (salud)', 'Acreedor', '0.00', 4, 2, 1, 1, 93, 22),
(95, '210702', 'ISSS (pensiÃ³n)', 'Acreedor', '0.00', 4, 2, 1, 1, 93, 22),
(96, '210703', 'AFP', 'Acreedor', '0.00', 4, 2, 1, 1, 93, 22),
(97, '210704', 'INSAFORP', 'Acreedor', '0.00', 4, 2, 1, 1, 93, 22),
(98, '210705', 'Pago a Cuenta', 'Acreedor', '0.00', 4, 2, 1, 1, 93, 22),
(99, '2108', 'DIVIDENDOS POR PAGAR', 'Acreedor', '0.00', 3, 2, 1, 1, 68, 22),
(100, '2109', 'IVA DEBITO FISCAL', 'Acreedor', '0.00', 3, 2, 1, 1, 68, 22),
(101, '2110', 'IVA PERCIBIDO Y RETENIDO POR PAGAR', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(102, '211001', 'Iva Percibido', 'Acreedor', '0.00', 4, 2, 1, 1, 101, 22),
(103, '211002', 'Iva Retenido', 'Acreedor', '0.00', 4, 2, 1, 1, 101, 22),
(104, '2111', 'IMPUESTO POR PAGAR', 'Acreedor', '0.00', 3, 2, 0, 1, 68, 22),
(105, '211101', 'Pago a Cuenta', 'Acreedor', '0.00', 4, 2, 1, 1, 104, 22),
(106, '211102', 'RENTA', 'Acreedor', '0.00', 4, 2, 1, 1, 104, 22),
(107, '211103', 'IVA', 'Acreedor', '0.00', 4, 2, 1, 1, 104, 22),
(108, '211104', 'Otros', 'Acreedor', '0.00', 4, 2, 1, 1, 104, 22),
(109, '2112', 'CUENTAS POR PAGAR', 'Acreedor', '0.00', 3, 2, 1, 1, 68, 22),
(110, '2113', 'INTERESES POR PAGAR', 'Acreedor', '0.00', 3, 2, 1, 1, 68, 22),
(111, '22', 'PASIVO NO CORRIENTE', 'Acreedor', '0.00', 2, 2, 0, 1, 67, 22),
(112, '2201', 'PRESTAMOS POR PAGAR', 'Acreedor', '0.00', 3, 2, 1, 1, 111, 22),
(113, '2202', 'DOCUMENTOS POR PAGAR', 'Acreedor', '0.00', 3, 2, 1, 1, 111, 22),
(114, '2203', 'INGRESOS DIFERIDOS', 'Acreedor', '0.00', 3, 2, 1, 1, 111, 22),
(115, '2204', 'PROVISION PARA OBLIGACIONES LABORALES', 'Acreedor', '0.00', 3, 2, 1, 1, 111, 22),
(116, '2205', 'PASIVO POR IMPUESTO DE RENTA DIFERIDO', 'Acreedor', '0.00', 3, 2, 1, 1, 111, 22),
(117, '3', 'PATRIMONIO', 'Acreedor', '0.00', 1, 3, 0, 1, NULL, 22),
(118, '31', 'CAPITAL CONTABLE', 'Acreedor', '0.00', 2, 3, 0, 1, 117, 22),
(119, '3101', 'CAPITAL SOCIAL', 'Acreedor', '0.00', 3, 3, 1, 1, 118, 22),
(120, '3102', 'RESERVA LEGAL', 'Acreedor', '0.00', 3, 3, 1, 1, 118, 22),
(121, '3103', 'UTILIDADES RETENIDAS', 'Acreedor', '0.00', 3, 3, 1, 1, 118, 22),
(122, '3104', 'UTILIDAD DEL EJERCICIO', 'Acreedor', '0.00', 3, 3, 1, 1, 118, 22),
(123, '3105R', 'PÃ‰RDIDAS', 'Deudor', '0.00', 3, 3, 0, 1, 118, 22),
(124, '310501R', 'PÃ©rdidas acumuladas', 'Deudor', '0.00', 4, 3, 1, 1, 123, 22),
(125, '310502R', 'PÃ©rdidas del presente ejercicio', 'Deudor', '0.00', 4, 3, 1, 1, 123, 22),
(126, '4', 'CUENTAS DE RESULTADO ACREEDORAS', 'Deudor', '0.00', 1, 4, 0, 1, NULL, 22),
(127, '41', 'COSTOS Y GASTOS DE OPERACION', 'Deudor', '0.00', 2, 4, 0, 1, 126, 22),
(128, '4101', 'COMPRAS', 'Deudor', '0.00', 3, 4, 1, 1, 127, 22),
(129, '4102', 'GASTOS SOBRE COMPRAS', 'Deudor', '0.00', 3, 4, 1, 1, 127, 22),
(130, '4103', 'COSTO DE VENTA', 'Deudor', '0.00', 3, 4, 1, 1, 127, 22),
(131, '42', 'GASTOS OPERATIVOS', 'Deudor', '0.00', 2, 4, 0, 1, 126, 22),
(132, '4201', 'GASTOS DE ADMINISTRACION', 'Deudor', '0.00', 3, 4, 0, 1, 131, 22),
(133, '420101', 'Sueldos y salarios', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(134, '420102', 'Comisiones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(135, '420103', 'Vacaciones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(136, '420104', 'Bonificaciones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(137, '420105', 'Aguinaldos', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(138, '420106', 'Horas extras', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(139, '420107', 'ViÃ¡ticos', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(140, '420108', 'Indemnizaciones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(141, '420109', 'Atenciones al personal', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(142, '420110', 'ISSS (salud)', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(143, '420111', 'ISSS (pensiÃ³n)', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(144, '420112', 'AFP', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(145, '420113', 'INSAFORP', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(146, '420114', 'Honorarios', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(147, '420115', 'Seguros', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(148, '420116', 'Transportes', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(149, '420117', 'Agua', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(150, '420118', 'Comunicaciones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(151, '420119', 'EnergÃ­a elÃ©ctrica', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(152, '420120', 'EstimaciÃ³n para cuentas incobrables', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(153, '420121', 'PapelerÃ­a y Ãºtiles', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(154, '420122', 'DepreciaciÃ³n', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(155, '420123', 'Mantenimiento y reparaciÃ³n de mobiliario y equipo', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(156, '420124', 'Mantenimiento y reparaciÃ³n de edificios', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(157, '420125', 'Mantenimiento y reparaciones de equipo de reparto', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(158, '420126', 'Publicidad', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(159, '420127', 'Empaques', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(160, '420128', 'Atenciones a clientes', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(161, '420129', 'Multas', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(162, '420130', 'Combustibles y lubricantes', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(163, '420131', 'Impuestos municipales', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(164, '420132', 'Inscripciones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(165, '420133', 'Limpiezas', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(166, '420134', 'Alquileres', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(167, '420135', 'Matriculas de comercio', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(168, '420136', 'Donaciones y contribuciones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(169, '420137', 'Vigilancias', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(170, '420138', 'Uniformes', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(171, '420139', 'Amortizaciones', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(172, '420140', 'Ornatos', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(173, '420141', 'Otros', 'Deudor', '0.00', 4, 4, 1, 1, 132, 22),
(174, '4202', 'GASTOS DE VENTAS', 'Deudor', '0.00', 3, 4, 0, 1, 131, 22),
(175, '420201', 'Sueldos y salarios', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(176, '4203', 'REBAJAS Y DEVOLUCIONES SOBRE VENTAS', 'Deudor', '0.00', 3, 4, 1, 1, 131, 22),
(177, '4204', 'DESCUENTOS SOBRE VENTAS', 'Deudor', '0.00', 3, 4, 1, 1, 131, 22),
(178, '43', 'GASTOS NO OPERATIVOS', 'Deudor', '0.00', 2, 4, 0, 1, 126, 22),
(179, '4301', 'GASTOS FINANCIEROS', 'Deudor', '0.00', 3, 4, 0, 1, 178, 22),
(180, '430101', 'Intereses', 'Deudor', '0.00', 4, 4, 1, 1, 179, 22),
(181, '430102', 'Comisiones bancarias', 'Deudor', '0.00', 4, 4, 1, 1, 179, 22),
(182, '430103', 'Diferencial cambiario', 'Deudor', '0.00', 4, 4, 1, 1, 179, 22),
(183, '4302', 'PERDIDAS EN VENTA DE ACTIVO FIJO', 'Deudor', '0.00', 3, 4, 1, 1, 178, 22),
(184, '4303', 'GASTOS POR IMPUESTOS', 'Deudor', '0.00', 3, 4, 1, 1, 178, 22),
(185, '4304', 'OTROS GASTOS', 'Deudor', '0.00', 3, 4, 1, 1, 178, 22),
(186, '5', 'CUENTAS DE RESULTADO ACREEDORAS', 'Acreedor', '0.00', 1, 5, 0, 1, NULL, 22),
(187, '51', 'INGRESOS DE OPERACIÃ“N', 'Acreedor', '0.00', 2, 5, 0, 1, 186, 22),
(188, '5101', 'VENTAS', 'Acreedor', '0.00', 3, 5, 1, 1, 187, 22),
(189, '5102', 'REBAJAS Y DEVOLUCIONES SOBRE COMPRAS', 'Acreedor', '0.00', 3, 5, 1, 1, 187, 22),
(190, '5103', 'DESCUENTOS SOBRE COMPRAS', 'Acreedor', '0.00', 3, 5, 1, 1, 187, 22),
(191, '52', 'INGRESOS DE NO OPERACIÃ“N\'', 'Acreedor', '0.00', 2, 5, 0, 1, 186, 22),
(192, '5201', 'INTERESES', 'Acreedor', '0.00', 3, 5, 1, 1, 191, 22),
(193, '5202', 'UTILIDAD EN VENTA DE ACTIVO FIJO', 'Acreedor', '0.00', 3, 5, 1, 1, 191, 22),
(194, '5203', 'OTROS INGRESOS', 'Acreedor', '0.00', 3, 5, 1, 1, 191, 22),
(195, '5204', 'INGRESO POR IMPUESTO DE RENTA DIFERIDO', 'Acreedor', '0.00', 3, 5, 1, 1, 191, 22),
(196, '6', 'CUENTA DE CIERRE', 'Acreedor', '0.00', 1, 6, 0, 1, NULL, 22),
(197, '61', 'CUENTA LIQUIDADORA', 'Acreedor', '0.00', 2, 6, 0, 1, 196, 22),
(198, '6101', 'PÃ‰RDIDAS Y GANANCIAS', 'Acreedor', '0.00', 3, 6, 1, 1, 197, 22),
(199, '420202', 'Comisiones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(200, '420203', 'Vacaciones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(201, '420204', 'Bonificaciones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(202, '420205', 'Aguinaldos', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(203, '420206', 'Horas extras', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(204, '420207', 'ViÃ¡ticos', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(205, '420208', 'Indemnizaciones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(206, '420209', 'Atenciones al personal', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(207, '420210', 'ISSS (salud)', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(208, '420211', 'ISSS (pensiÃ³n)', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(209, '420212', 'AFP', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(210, '420213', 'INSAFORP', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(211, '420214', 'Honorarios', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(212, '420215', 'Seguros', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(213, '420216', 'Transportes', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(214, '420217', 'Agua', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(215, '420218', 'Comunicaciones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(216, '420219', 'EnergÃ­a elÃ©ctrica', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(217, '420220', 'EstimaciÃ³n para cuentas incobrables', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(218, '420221', 'PapelerÃ­a y Ãºtiles', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(219, '420222', 'DepreciaciÃ³n', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(220, '420223', 'Mantenimiento y reparaciÃ³n de mobiliario y equipo', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(221, '420224', 'Mantenimiento y reparaciÃ³n de edificios', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(222, '420225', 'Mantenimiento y reparaciones de equipo de reparto', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(223, '420226', 'Publicidad', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(224, '420227', 'Empaques', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(225, '420228', 'Atenciones a clientes', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(226, '420229', 'Multas', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(227, '420230', 'Combustibles y lubricantes', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(228, '420231', 'Impuestos municipales', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(229, '420232', 'Inscripciones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(230, '420233', 'Limpiezas', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(231, '420234', 'Alquileres', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(232, '420235', 'Matriculas de comercio', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(233, '420236', 'Donaciones y contribuciones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(234, '420237', 'Vigilancias', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(235, '420238', 'Uniformes', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(236, '420239', 'Amortizaciones', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(237, '420240', 'Ornatos', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(238, '420241', 'Otros', 'Deudor', '0.00', 4, 4, 1, 1, 174, 22),
(239, '1', 'Activo', 'Deudor', '19973183.56', 1, 1, 0, 2, NULL, 21),
(240, '2', 'Pasivo', 'Acreedor', '5027533.70', 1, 2, 0, 2, NULL, 21),
(241, '3', 'Capital', 'Acreedor', '14166500.00', 1, 3, 0, 2, NULL, 21),
(242, '11', 'Corriente', 'Deudor', '10317383.56', 2, 1, 0, 2, 239, 21),
(243, '12', 'No Corriente', 'Deudor', '9655800.00', 2, 1, 0, 2, 239, 21),
(244, '21', 'Corriente', 'Acreedor', '4311533.70', 2, 2, 0, 2, 240, 21),
(245, '22', 'No Corriente', 'Acreedor', '716000.00', 2, 2, 0, 2, 240, 21),
(246, '31', 'Capital Contable', 'Acreedor', '14166500.00', 2, 3, 0, 2, 241, 21),
(247, '1101', 'Caja', 'Deudor', '21100.00', 3, 1, 1, 2, 242, 21),
(248, '1102', 'Banco', 'Deudor', '2121961.85', 3, 1, 1, 2, 242, 21),
(249, '1103', 'Cuentas por Cobrar', 'Deudor', '1498896.31', 3, 1, 1, 2, 242, 21),
(250, '1104', 'Deudores Diversos', 'Deudor', '68900.00', 3, 1, 1, 2, 242, 21),
(251, '1105', 'Inventario', 'Deudor', '6550000.00', 3, 1, 1, 2, 242, 21),
(252, '1201', 'Primas de seguro', 'Deudor', '62000.00', 3, 1, 1, 2, 243, 21),
(253, '1202', 'Inversiones Permanentes', 'Deudor', '580000.00', 3, 1, 1, 2, 243, 21),
(254, '1203', 'Equipo de Computo', 'Deudor', '340000.00', 3, 1, 1, 2, 243, 21),
(255, '1204', 'Papeleria y Utiles', 'Deudor', '175000.00', 3, 1, 1, 2, 243, 21),
(256, '1205', 'Terrenos', 'Deudor', '2800000.00', 3, 1, 1, 2, 243, 21),
(257, '1206', 'Gastos de instalacion', 'Deudor', '195000.00', 3, 1, 1, 2, 243, 21),
(258, '1207', 'Edificios', 'Deudor', '4500000.00', 3, 1, 1, 2, 243, 21),
(259, '1208', 'Equipo de Oficina', 'Deudor', '985000.00', 3, 1, 1, 2, 243, 21),
(260, '1209', 'Depositos en Garantia', 'Deudor', '10500.00', 3, 1, 1, 2, 243, 21),
(261, '2101', 'Proveedores', 'Acreedor', '3045012.27', 3, 2, 1, 2, 244, 21),
(262, '2102', 'Renta Cobradas por Anticipado', 'Acreedor', '105000.00', 3, 2, 1, 2, 244, 21),
(263, '2103', 'Intereses Cobrados por Anticiado', 'Acreedor', '150000.00', 3, 2, 1, 2, 244, 21),
(264, '2104', 'Acreedores Diversos', 'Acreedor', '850000.00', 3, 2, 1, 2, 244, 21),
(265, '2201', 'Hipotecas por Pagar', 'Acreedor', '199000.00', 3, 2, 1, 2, 245, 21),
(266, '2202', 'Gastos Acumulados por Pagar', 'Acreedor', '42000.00', 3, 2, 1, 2, 245, 21),
(267, '2203', 'Documentos por Pagar Largo Plazo', 'Acreedor', '475000.00', 3, 2, 1, 2, 245, 21),
(268, '3101', 'Capital Social', 'Acreedor', '14166500.00', 3, 3, 1, 2, 246, 21),
(270, '2105', 'Documentos por Pagar', 'Acreedor', '1750.00', 3, 2, 1, 2, 244, 21),
(271, '1210', 'Patentes', 'Deudor', '8300.00', 3, 1, 1, 2, 243, 21),
(272, '1106', 'IVA Credito Fiscal', 'Deudor', '58425.40', 3, 1, 1, 2, 242, 21),
(273, '2106', 'IVA Debito Fiscal', 'Acreedor', '159771.43', 3, 2, 1, 2, 244, 21),
(274, '1107R', 'Provicion para Cuentas Incobrables', 'Acreedor', '1900.00', 3, 1, 1, 2, 242, 21),
(275, '4', 'Cuentas de Resultado Acreedoras', 'Acreedor', '1262954.86', 1, 4, 0, 2, NULL, 21),
(276, '41', 'Ingresos de Operacion', 'Acreedor', '1254779.86', 2, 4, 0, 2, 275, 21),
(277, '4101', 'Ventas', 'Acreedor', '1239624.00', 3, 4, 1, 2, 276, 21),
(278, '5', 'Cuentas de Resultado Deudoras', 'Deudor', '483805.00', 1, 5, 0, 2, NULL, 21),
(279, '51', 'Costos Operacion', 'Deudor', '433438.00', 2, 5, 0, 2, 278, 21),
(280, '5101', 'Compras', 'Deudor', '416325.00', 3, 5, 1, 2, 279, 21),
(281, '42', 'Otros Productos', 'Acreedor', '8175.00', 2, 4, 0, 2, 275, 21),
(282, '4201', 'Intereses Cobrados', 'Acreedor', '8175.00', 3, 4, 1, 2, 281, 21),
(283, '4102', 'Rebajas y Devoluciones sobre Compras', 'Acreedor', '15155.86', 3, 4, 1, 2, 276, 21),
(284, '5102', 'Rebajas y Devoluciones sobre Ventas', 'Deudor', '10613.00', 3, 5, 1, 2, 279, 21),
(285, '5103', 'Gastos sobre Compras', 'Deudor', '6500.00', 3, 5, 1, 2, 279, 21),
(286, '52', 'Gastos de Operaciones', 'Deudor', '42457.00', 2, 5, 0, 2, 278, 21),
(287, '5201', 'Gastos de Administarcion', 'Deudor', '11067.00', 3, 5, 1, 2, 286, 21),
(288, '5202', 'Gastos de Venta', 'Deudor', '29565.00', 3, 5, 1, 2, 286, 21),
(289, '5203', 'Gastos de Financieros', 'Deudor', '1825.00', 3, 5, 1, 2, 286, 21),
(290, '53', 'Otros Gastos', 'Deudor', '7910.00', 2, 5, 0, 2, 278, 21),
(291, '5301', 'Otros Gastos', 'Deudor', '7910.00', 3, 5, 1, 2, 290, 21),
(292, '3102', 'Reserva Legal', 'Acreedor', '0.00', 3, 3, 1, 2, 246, 21),
(293, '3103', 'Utilidad del ejercicio', 'Acreedor', '0.00', 3, 3, 1, 2, 246, 21),
(296, '6', 'Perdidas y Ganancias', 'Deudor', '0.00', 1, 6, 0, 2, NULL, 21),
(297, '61', 'Perdidas y Ganancias', 'Deudor', '0.00', 2, 6, 0, 2, 296, 21),
(298, '6101', 'Perdidas y Ganancias', 'Deudor', '0.00', 3, 6, 1, 2, 297, 21),
(300, '1', 'ACTIVO', 'Deudor', '716226.73', 1, 1, 0, 7, NULL, 23),
(301, '11', 'ACTIVOS CORRIENTES', 'Deudor', '503668.26', 2, 1, 0, 7, 300, 23),
(302, '1101', 'EFECTIVO Y EQUIVALENTES DE EFECTIVO', 'Deudor', '302171.59', 3, 1, 0, 7, 301, 23),
(303, '110101', 'CAJA GENERAL', 'Deudor', '36160.00', 4, 1, 1, 7, 302, 23),
(304, '110102', 'CAJA CHICA', 'Deudor', '300.00', 4, 1, 1, 7, 302, 23),
(305, '110103', 'EFECTIVO EN BANCOS', 'Deudor', '265711.59', 4, 1, 0, 7, 302, 23),
(306, '11010301', 'CUENTA CORRIENTE', 'Deudor', '262711.59', 5, 1, 0, 7, 305, 23),
(308, '1101030101', 'BANCO CUSCATLAN', 'Deudor', '262711.59', 6, 1, 1, 7, 306, 23),
(309, '1101030102', 'BANCO SALVADOREÃ‘O', 'Deudor', '0.00', 6, 1, 1, 7, 306, 23),
(310, '11010302', 'CUENTA DE AHORRO', 'Deudor', '3000.00', 5, 1, 0, 7, 305, 23),
(311, '1101030201', 'BANCO CUSCATLAN', 'Deudor', '3000.00', 6, 1, 1, 7, 310, 23),
(312, '1101030202', 'BANCO SALVADOREÃ‘O', 'Deudor', '0.00', 6, 1, 1, 7, 310, 23),
(313, '1102', 'CUENTAS Y DOCUMENTOS POR COBRAR', 'Deudor', '75580.00', 3, 1, 0, 7, 301, 23),
(314, '110201', 'CLIENTES NACIONALES', 'Deudor', '74580.00', 4, 1, 0, 7, 313, 23),
(315, '11020101', 'LA MODA', 'Deudor', '74580.00', 5, 1, 1, 7, 314, 23),
(316, '11020102', 'BOUTIQUES BETSABE', 'Deudor', '0.00', 5, 1, 1, 7, 314, 23),
(317, '11020103', 'PRENAS DE VESTIR', 'Deudor', '0.00', 5, 1, 1, 7, 314, 23),
(318, '11020104', 'VARIEDADES LA BONITA', 'Deudor', '0.00', 5, 1, 1, 7, 314, 23),
(319, '11020105', 'ROXANA PINEDA', 'Deudor', '0.00', 5, 1, 1, 7, 314, 23),
(321, '110202', 'CLIENTES EXTRANGEROS', 'Deudor', '0.00', 4, 1, 1, 7, 313, 23),
(322, '110203', 'TARJETAS DE CREDITO', 'Deudor', '0.00', 4, 1, 0, 7, 313, 23),
(323, '11020301', 'VISA', 'Deudor', '0.00', 5, 1, 1, 7, 322, 23),
(324, '11020302', 'CREDOMATIC', 'Deudor', '0.00', 5, 1, 1, 7, 322, 23),
(325, '11020303', 'AVAL CARD', 'Deudor', '0.00', 5, 1, 1, 7, 322, 23),
(326, '110204', 'DEUDORES A CORTO PLAZO', 'Deudor', '1000.00', 4, 1, 0, 7, 313, 23),
(327, '11020401', 'CUENTAS POR COBRAR AL PERSONAL', 'Deudor', '1000.00', 5, 1, 1, 7, 326, 23),
(328, '110205', 'ANTICIPO A PROVEEDORES', 'Deudor', '0.00', 4, 1, 0, 7, 313, 23),
(329, '11020501', 'DISTRIBUIDORA U/P', 'Deudor', '0.00', 5, 1, 1, 7, 328, 23),
(330, '11020502', 'TIENDA SILVESTRE', 'Deudor', '0.00', 5, 1, 1, 7, 328, 23),
(331, '11020503', 'DISTRIBUIDORA LA ELEGANCIA', 'Deudor', '0.00', 5, 1, 1, 7, 328, 23),
(332, '11020504', 'COMERCIAL PRENDAS ESPECIALES', 'Deudor', '0.00', 5, 1, 1, 7, 328, 23),
(333, '110206', 'PRESTAMOS A ACCIONISTAS', 'Deudor', '0.00', 4, 1, 1, 7, 313, 23),
(334, '110207', 'DOCUMENTOS POR COBRAR A LARGO PLAZO', 'Deudor', '0.00', 4, 1, 0, 7, 313, 23),
(335, '11020701', 'LETRAS DE CAMBIO', 'Deudor', '0.00', 5, 1, 1, 7, 334, 23),
(336, '11020702', 'PAGARES', 'Deudor', '0.00', 5, 1, 1, 7, 334, 23),
(337, '1103R', 'ESTIMACION PARA CUENTAS INCOBRABLES', 'Acreedor', '0.00', 3, 1, 1, 7, 301, 23),
(338, '1104', 'IVA CREDITO FISCAL', 'Deudor', '0.00', 3, 1, 0, 7, 301, 23),
(339, '110401', 'COMPRAS LOCALES', 'Deudor', '0.00', 4, 1, 1, 7, 338, 23),
(340, '1105', 'INVENTARIO', 'Deudor', '75000.00', 3, 1, 0, 7, 301, 23),
(341, '110501', 'INVENTARIO DE MERCADERIA PARA LA VENTA', 'Deudor', '75000.00', 4, 1, 1, 7, 340, 23),
(342, '110502', 'ESTIMACION PARA INVENTARIO', 'Deudor', '0.00', 4, 1, 0, 7, 340, 23),
(343, '11050201', 'ESTIMACION POR OBSOLESCENCIA DE INVENTARIO', 'Deudor', '0.00', 5, 1, 1, 7, 342, 23),
(344, '1106', 'INVERSIONES TEMPORALES', 'Deudor', '0.00', 3, 1, 0, 7, 301, 23),
(345, '110601', 'TITULOS VALORES', 'Deudor', '0.00', 4, 1, 1, 7, 344, 23),
(346, '1107', 'GASTOS PAGADOS POR ANTICIPADO', 'Deudor', '1000.00', 3, 1, 0, 7, 301, 23),
(347, '110701', 'SEGUROS Y FINANZAS', 'Deudor', '1000.00', 4, 1, 1, 7, 346, 23),
(348, '110702', 'ALQUILERES', 'Deudor', '0.00', 4, 1, 1, 7, 346, 23),
(349, '110703', 'PAPELERIA Y UTILES', 'Deudor', '0.00', 4, 1, 1, 7, 346, 23),
(350, '1108R', 'AMORTIZACION GASTOS PAGADOS POR ANTICIPADO', 'Acreedor', '83.33', 3, 1, 0, 7, 301, 23),
(351, '110801R', 'SEGUROS Y FINANZAS', 'Acreedor', '83.33', 4, 1, 1, 7, 350, 23),
(352, '1109', 'ACCIONISTAS', 'Deudor', '50000.00', 3, 1, 0, 7, 301, 23),
(353, '110901', 'FERNADO LOPEZ', 'Deudor', '50000.00', 4, 1, 1, 7, 352, 23),
(354, '110902', 'FATIMA MENDEZ', 'Deudor', '0.00', 4, 1, 1, 7, 352, 23),
(355, '110903', 'JUAN CARLOS CASTRO', 'Deudor', '0.00', 4, 1, 1, 7, 352, 23),
(356, '12', 'ACTIVOS NO CORRIENTES', 'Deudor', '212558.47', 2, 1, 0, 7, 300, 23),
(357, '1201', 'PROPIEDAD PLANTA Y EQUIPO', 'Deudor', '210000.00', 3, 1, 0, 7, 356, 23),
(358, '120101', 'BIENES NO DEPRECIABLES', 'Deudor', '40000.00', 4, 1, 0, 7, 357, 23),
(359, '12010101', 'TERRENOS', 'Deudor', '40000.00', 5, 1, 1, 7, 358, 23),
(360, '120102', 'BIENES DEPRECIABLES', 'Deudor', '170000.00', 4, 1, 0, 7, 357, 23),
(361, '12010201', 'EDIFICACIONES', 'Deudor', '170000.00', 5, 1, 1, 7, 360, 23),
(362, '12010202', 'INSTALACIONES', 'Deudor', '0.00', 5, 1, 1, 7, 360, 23),
(363, '12010203', 'MOBILIARIO Y EQUIPO DE OFICINA', 'Deudor', '0.00', 5, 1, 1, 7, 360, 23),
(364, '12010204', 'VEHICULOS', 'Deudor', '0.00', 5, 1, 1, 7, 360, 23),
(365, '12010205', 'OTROS MUEBLES', 'Deudor', '0.00', 5, 1, 1, 7, 360, 23),
(366, '120103', 'MEJORAS A BIENES DEPRECIABLES', 'Deudor', '0.00', 4, 1, 0, 7, 357, 23),
(367, '12010301', 'EDIFICACIONES', 'Deudor', '0.00', 5, 1, 1, 7, 366, 23),
(368, '12010302', 'INSTALACIONES', 'Deudor', '0.00', 5, 1, 1, 7, 366, 23),
(369, '12010303', 'MOBILIARIO Y EQUIPO DE OFICINA', 'Deudor', '0.00', 5, 1, 0, 7, 366, 23),
(370, '1201030301', 'COMPUTADORA TOSHIBA', 'Deudor', '0.00', 6, 1, 1, 7, 369, 23),
(371, '1202R', 'DEPRECIACION ACUMULADA', 'Acreedor', '1208.33', 3, 1, 0, 7, 356, 23),
(372, '120201R', 'EDIFICACIONES', 'Acreedor', '1208.33', 4, 1, 0, 7, 371, 23),
(373, '12020101R', 'EDIFICIOS', 'Acreedor', '1000.00', 5, 1, 1, 7, 372, 23),
(374, '12020102R', 'BODEGA', 'Acreedor', '208.33', 5, 1, 1, 7, 372, 23),
(375, '120202R', 'INSTALACIONES', 'Acreedor', '0.00', 4, 1, 1, 7, 371, 23),
(376, '120203R', 'MOBILIARIO Y EQUIPO DE OFICINA', 'Acreedor', '0.00', 4, 1, 1, 7, 371, 23),
(377, '120204R', 'VEHICULOS', 'Acreedor', '0.00', 4, 1, 1, 7, 371, 23),
(378, '1203', 'ACTIVOS DIFERIDOS', 'Deudor', '3766.80', 3, 1, 0, 7, 356, 23),
(379, '120301', 'IMPUESTO SOBRE LA RENTA', 'Deudor', '0.00', 4, 1, 1, 7, 378, 23),
(380, '120302', 'PAGO A CUENTA EJERCICIOS ANTERIORES', 'Deudor', '0.00', 4, 1, 1, 7, 378, 23),
(381, '120303', 'PAGO A CUENTA PRESENTE EJERCICIO', 'Deudor', '3766.80', 4, 1, 1, 7, 378, 23),
(382, '120304', 'RENTA RETENIDA POR TERCEROS 10%', 'Deudor', '0.00', 4, 1, 1, 7, 378, 23),
(383, '2', 'PASIVO', 'Acreedor', '118389.89', 1, 2, 0, 7, NULL, 23),
(384, '21', 'PASIVO NO CORRIENTE', 'Acreedor', '70288.51', 2, 2, 0, 7, 383, 23),
(385, '2101', 'PRESTAMOS A CORTO PLAZO Y SOBREGIROS BANCARIOS', 'Acreedor', '0.00', 3, 2, 0, 7, 384, 23),
(386, '210101', 'SOBREGIROS BANCARIOS', 'Acreedor', '0.00', 4, 2, 0, 7, 385, 23),
(387, '21010101', 'BANCO CUSCATLAN', 'Acreedor', '0.00', 5, 2, 1, 7, 386, 23),
(388, '210102', 'PRESTAMOS BANCARIOS A CORTO PLAZO', 'Acreedor', '0.00', 4, 2, 0, 7, 385, 23),
(389, '21010201', 'BANCO CUSCATLAN', 'Acreedor', '0.00', 5, 2, 1, 7, 388, 23),
(390, '210103', 'PRESTAMOS DE OTRAS INSTITUCIONES A CORTO PLAZO', 'Acreedor', '0.00', 4, 2, 0, 7, 385, 23),
(391, '21010301', 'TARJETAS DE CREDITO EMPRESIARIALES', 'Acreedor', '0.00', 5, 2, 0, 7, 390, 23),
(392, '2101030101', 'BANCO CUSCATLAN', 'Acreedor', '0.00', 6, 2, 1, 7, 391, 23),
(393, '2101030102', 'BANCO SCOTIABANK', 'Acreedor', '0.00', 6, 2, 1, 7, 391, 23),
(394, '2101030103', 'BANCO CREDOMATIC', 'Acreedor', '0.00', 6, 2, 1, 7, 391, 23),
(395, '2102', 'CUENTAS Y DOCUMENTOS POR PAGAR', 'Acreedor', '56000.00', 3, 2, 0, 7, 384, 23),
(396, '210201', 'PROVEEDORES LOCALES', 'Acreedor', '56000.00', 4, 2, 0, 7, 395, 23),
(397, '21020101', 'DISTRIBUIDORA U/P', 'Acreedor', '0.00', 5, 2, 1, 7, 396, 23),
(398, '21020102', 'TIENDA SILVESTRE', 'Acreedor', '56000.00', 5, 2, 1, 7, 396, 23),
(400, '21020103', 'DISTRIBUIDORA LA ELEGANCIA', 'Acreedor', '0.00', 5, 2, 1, 7, 396, 23),
(401, '21020104', 'COMERCIAL PRENDAS ESPECIALES', 'Acreedor', '0.00', 5, 2, 1, 7, 396, 23),
(402, '210202', 'PROVEEDORES EN EL EXTERIOR', 'Acreedor', '0.00', 4, 2, 1, 7, 395, 23),
(403, '210203', 'ACREEDORES DIVERSOS', 'Acreedor', '0.00', 4, 2, 0, 7, 395, 23),
(404, '21020301', 'ACREEDORES NACIONALES', 'Acreedor', '0.00', 5, 2, 1, 7, 403, 23),
(405, '21020302', 'ACREEDORES EXTRANJEROS', 'Acreedor', '0.00', 5, 2, 1, 7, 403, 23),
(406, '2103', 'DIVIDENDOS POR PAGAR', 'Acreedor', '0.00', 3, 2, 1, 7, 384, 23),
(407, '2104', 'RETENCIONES POR PAGAR', 'Acreedor', '249.03', 3, 2, 0, 7, 384, 23),
(408, '210401', 'RETENCION DEL IMPUESTO SOBRE LA RENTA', 'Acreedor', '95.78', 4, 2, 1, 7, 407, 23),
(409, '210402', 'RETENCIONES A EMPLEADOS', 'Acreedor', '153.25', 4, 2, 0, 7, 407, 23),
(410, '21040201', 'RETENCION ISSS', 'Acreedor', '46.37', 5, 2, 1, 7, 409, 23),
(411, '21040202', 'RETENCION AFP', 'Acreedor', '106.88', 5, 2, 0, 7, 409, 23),
(412, '2104020201', 'AFP CONFIA', 'Acreedor', '0.00', 6, 2, 1, 7, 411, 23),
(413, '2104020202', 'AFP CRECER', 'Acreedor', '106.88', 6, 2, 1, 7, 411, 23),
(414, '21040203', 'RETENCIONES FSV', 'Acreedor', '0.00', 5, 2, 1, 7, 409, 23),
(415, '210403', 'RETENCIONES A TERCEROS', 'Acreedor', '0.00', 4, 2, 0, 7, 407, 23),
(416, '21040301', 'RETENCIONES DE IMPUESTOS  A NO DOMICILIADOS', 'Acreedor', '0.00', 5, 2, 1, 7, 415, 23),
(417, '21040302', 'RETENCIONES ISSS', 'Acreedor', '0.00', 5, 2, 1, 7, 415, 23),
(418, '21040303', 'RETENCION AFP', 'Acreedor', '0.00', 5, 2, 1, 7, 415, 23),
(419, '21040304', 'RETENCIONES FSV', 'Acreedor', '0.00', 5, 2, 1, 7, 415, 23),
(420, '2105', 'PROVISIONES LABORALES', 'Acreedor', '227.08', 3, 2, 0, 7, 384, 23),
(421, '210501', 'CUOTA PATRONAL ISSS', 'Acreedor', '115.93', 4, 2, 1, 7, 420, 23),
(422, '210502', 'INSAFORP', 'Acreedor', '0.00', 4, 2, 1, 7, 420, 23),
(423, '210503', 'CUOTA PATRONAL AFP', 'Acreedor', '111.15', 4, 2, 0, 7, 420, 23),
(424, '21050301', 'AFP CRECER', 'Acreedor', '0.00', 5, 2, 1, 7, 423, 23),
(425, '21050302', 'AFP CONFIA', 'Acreedor', '111.15', 5, 2, 1, 7, 423, 23),
(426, '2106', 'IMPUESTO POR PAGAR', 'Acreedor', '13812.40', 3, 2, 0, 7, 384, 23),
(427, '210601', 'IMPUESTO SOBRE LA RENTA POR PAGAR', 'Acreedor', '0.00', 4, 2, 1, 7, 426, 23),
(428, '210602', 'IMPUESTO POR PAGAR IVA', 'Acreedor', '11195.60', 4, 2, 1, 7, 426, 23),
(429, '210603', 'PAGO CUENTA POR PAGAR', 'Acreedor', '2116.80', 4, 2, 1, 7, 426, 23),
(430, '210604', 'IMPUESTOS MUNICIPALES POR PAGAR', 'Acreedor', '0.00', 4, 2, 1, 7, 426, 23),
(431, '210605', 'IVA RETENIDO POR PAGAR', 'Acreedor', '500.00', 4, 2, 0, 7, 426, 23),
(432, '21060501', 'COMPRAS LOCALES SUJETAS AL 1%', 'Acreedor', '500.00', 5, 2, 1, 7, 431, 23),
(433, '2107', 'IVA DEBITO FISCAL', 'Acreedor', '0.00', 3, 2, 0, 7, 384, 23),
(434, '210701', 'VENTAS LOCALES', 'Acreedor', '0.00', 4, 2, 1, 7, 433, 23),
(435, '2108', 'PORCION CIRCULANTE LARGO PLAZO', 'Acreedor', '0.00', 3, 2, 1, 7, 384, 23),
(436, '2109', 'SUELDOS POR PAGAR', 'Acreedor', '0.00', 3, 2, 0, 7, 384, 23),
(437, '210901', 'SUELDOS LIQUIDOS', 'Acreedor', '0.00', 4, 2, 1, 7, 436, 23),
(438, '22', 'PASIVO NO CORRIENTE', 'Acreedor', '48101.38', 2, 2, 0, 7, 383, 23),
(439, '2201', 'PRESTAMOS A LARGO PLAZO', 'Acreedor', '48101.38', 3, 2, 0, 7, 438, 23),
(440, '220101', 'PRESTAMOS BANCARIOS', 'Acreedor', '48101.38', 4, 2, 1, 7, 439, 23),
(441, '220102', 'PRESTAMOS DE OTRAS INSTITUCIONES', 'Acreedor', '0.00', 4, 2, 1, 7, 439, 23),
(442, '2202', 'CUENTAS POR PAGAR PROVEEDORES A LARGO PLAZO', 'Acreedor', '0.00', 3, 2, 0, 7, 438, 23),
(443, '220201', 'PROVEEDORES LOCALES', 'Acreedor', '0.00', 4, 2, 1, 7, 442, 23),
(444, '220202', 'PROVEEDORES EN EL EXTERIOS', 'Acreedor', '0.00', 4, 2, 1, 7, 442, 23),
(445, '2203', 'CUENTAS POR PAGAR A LOS ACCIONISTAS', 'Acreedor', '0.00', 3, 2, 1, 7, 438, 23),
(446, '2204', 'CUENTAS POR PAGAR ACREEDORES A LARGO PLAZO', 'Acreedor', '0.00', 3, 2, 0, 7, 438, 23),
(447, '220401', 'ACREEDORES', 'Acreedor', '0.00', 4, 2, 1, 7, 446, 23),
(448, '2205', 'PASIVOS DIFERIDOS', 'Acreedor', '0.00', 3, 2, 0, 7, 438, 23),
(449, '220501', 'DEPOSITOS EN GARANTIA', 'Acreedor', '0.00', 4, 2, 1, 7, 448, 23),
(450, '3', 'PATRIMONIO', 'Acreedor', '500000.00', 1, 3, 0, 7, NULL, 23),
(451, '31', 'CAPITAL', 'Acreedor', '500000.00', 2, 3, 0, 7, 450, 23),
(452, '3101', 'CAPITAL SOCIAL', 'Acreedor', '500000.00', 3, 3, 0, 7, 451, 23),
(453, '310101', 'CAPITAL SOCIAL SUSCRITO', 'Acreedor', '500000.00', 4, 3, 1, 7, 452, 23),
(454, '310102', 'CAPITAL SOCIAL MINIMO', 'Acreedor', '0.00', 4, 3, 1, 7, 452, 23),
(455, '32', 'SUPERAVIT POR REVALUACION DE ACTIVO', 'Acreedor', '0.00', 2, 3, 0, 7, 450, 23),
(456, '3201', 'SUPERAVIT POR REVALUACION PROPIEDAD PLANTA  Y EQUIPO', 'Acreedor', '0.00', 3, 3, 1, 7, 455, 23),
(457, '33', 'RESULTADOS ACUMULADOS', 'Acreedor', '0.00', 2, 3, 0, 7, 450, 23),
(458, '3301', 'RESERVA LEGAL', 'Acreedor', '0.00', 3, 3, 0, 7, 457, 23),
(459, '330101', 'PRESENTE EJERCICIO', 'Acreedor', '0.00', 4, 3, 1, 7, 458, 23),
(460, '3302', 'UTILIDADES DEL EJERCICIO', 'Acreedor', '0.00', 3, 3, 0, 7, 457, 23),
(461, '330201', 'EJERCICIO CORRIENTE', 'Acreedor', '0.00', 4, 3, 1, 7, 460, 23),
(462, '330202', 'EJERCICIOS ANTERIORES', 'Acreedor', '0.00', 4, 3, 1, 7, 460, 23),
(463, '330203', 'PERDIDAS POR LIQUIDAR', 'Acreedor', '0.00', 4, 3, 1, 7, 460, 23),
(464, '330204', 'PERDIDAS DEL EJERCICIO ANTERIOR', 'Acreedor', '0.00', 4, 3, 1, 7, 460, 23),
(465, '4', 'CUENTAS DE RESULTADOS DEUDORAS', 'Deudor', '154283.16', 1, 4, 0, 7, NULL, 23),
(466, '41', 'COSTOS', 'Deudor', '137300.00', 2, 4, 0, 7, 465, 23),
(467, '4101', 'COMPRAS', 'Deudor', '140000.00', 3, 4, 0, 7, 466, 23),
(468, '410101', 'COMPRAS DE MERCADERIA PARA LA VENTA', 'Deudor', '140000.00', 4, 4, 1, 7, 467, 23),
(469, '4102', 'COSTO DE VENTAS', 'Deudor', '0.00', 3, 4, 1, 7, 466, 23),
(470, '4103', 'GASTOS SOBRE COMPRAS', 'Deudor', '0.00', 3, 4, 0, 7, 466, 23),
(471, '410301', 'GASTOS SOBRE COMPRAS', 'Deudor', '0.00', 4, 4, 1, 7, 470, 23),
(472, '4104R', 'REBAJAS  Y DEVOLUCIONES SOBRE COMPRA', 'Acreedor', '2700.00', 3, 4, 0, 7, 466, 23),
(473, '410401R', 'COMPRAS DE CONTADO', 'Acreedor', '2700.00', 4, 4, 1, 7, 472, 23),
(474, '42', 'GASTOS OPERATIVOS', 'Deudor', '16983.16', 2, 4, 0, 7, 465, 23),
(475, '4201', 'GASTOS DE VENTAS', 'Deudor', '5128.26', 3, 4, 0, 7, 474, 23),
(476, '420101', 'SUELDO AL PERSONAL', 'Deudor', '360.00', 4, 4, 1, 7, 475, 23),
(477, '420102', 'HORAS EXTRAS', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(478, '420103', 'COMISIONES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(479, '420104', 'BONIFICACIONES Y GRATIFICACIONES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(480, '420105', 'VIATICOS', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(481, '420106', 'VACACIONES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(482, '420107', 'AGUINALDOS', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(483, '420108', 'INDEMNIZACIONES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(484, '420109', 'ATENCION AL PERSONAL', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(485, '420110', 'CUOTA PATRONAL ISSS', 'Deudor', '27.00', 4, 4, 1, 7, 475, 23),
(486, '420111', 'CUOTA PATRONAL INSAFORP', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(487, '420112', 'CUOTA PATRONAL AFP', 'Deudor', '23.40', 4, 4, 0, 7, 475, 23),
(488, '42011201', 'AFP CRECER', 'Deudor', '0.00', 5, 4, 1, 7, 487, 23),
(489, '42011202', 'AFP CONFIA', 'Deudor', '23.40', 5, 4, 1, 7, 487, 23),
(490, '420113', 'CAPACITACION AL PERSONAL', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(491, '420114', 'UNIFORME AL PERSONAL', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(492, '420115', 'SERVICIOS DE VIGILANCIA', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(493, '420116', 'HONORARIOS PROFESIONALES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(494, '420117', 'COMUNICACIONES', 'Deudor', '1000.00', 4, 4, 1, 7, 475, 23),
(495, '420118', 'SERVICIOS DE ENERGIA ELECTRICA', 'Deudor', '500.00', 4, 4, 1, 7, 475, 23),
(496, '420119', 'RECOLECCION DE BASURA Y DESECHOS', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(497, '420120', 'SERVICIOS DE AGUA POTABLE', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(498, '420121', 'PAPELERIA Y UTILES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(499, '420122', 'MEMBRESIA Y SUSCRIPCIONES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(500, '420123', 'IMPUESTOS FISCALES Y MUNICIPALES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(501, '420124', 'MATRICULA DE COMERCIO', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(502, '420125', 'REGISTRO DE MARCAS', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(503, '420126', 'PROPAGANDA Y PUBLICIDAD', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(504, '420127', 'ATENCION A CLIENTES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(505, '420128', 'CUENTAS INCOBRABLES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(506, '420129', 'CONTRIBUCIONES Y DONACIONES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(507, '420130', 'DEPRECIACIONES', 'Deudor', '725.00', 4, 4, 0, 7, 475, 23),
(508, '42013001', 'EDIFICACIONES', 'Deudor', '725.00', 5, 4, 1, 7, 507, 23),
(509, '42013002', 'MAQUINARIA Y  EQUIPO', 'Deudor', '0.00', 5, 4, 1, 7, 507, 23),
(510, '42013003', 'MOBILIARIO Y EQUIPO DE OFICINA', 'Deudor', '0.00', 5, 4, 1, 7, 507, 23),
(511, '42013004', 'VEHICULO DE TRANSPORTE', 'Deudor', '0.00', 5, 4, 1, 7, 507, 23),
(512, '420131', 'SEGUROS Y FIANZAS', 'Deudor', '50.00', 4, 4, 1, 7, 475, 23),
(513, '420132', 'MANTENIMIENTO DE INMOBILIARIO', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(514, '420133', 'COMBUSTIBLE Y LUBRICANTES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(515, '420134', 'MANTENIMIENTO DE VEHICULO', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(516, '420135', 'GASTOS NO DEDUCIBLES', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(517, '420136', 'TRANSPORTE', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(518, '420137', 'FOVIAL', 'Deudor', '0.00', 4, 4, 1, 7, 475, 23),
(519, '420138', 'OTROS GASTOS', 'Deudor', '2442.86', 4, 4, 1, 7, 475, 23),
(520, '4202', 'GASTOS DE ADMINISTRACION', 'Deudor', '10956.20', 3, 4, 0, 7, 474, 23),
(521, '420201', 'SUELDO AL PERSONAL', 'Deudor', '1350.00', 4, 4, 1, 7, 520, 23),
(522, '420202', 'BONIFICACIONES Y GRATIFICACIONES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(523, '420203', 'VIATICOS VACACIONES AGUINALDO', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(524, '420204', 'INDEMNIZACIONES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(525, '420205', 'ATENCION AL PERSONAL', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(526, '420206', 'CUOTA PATRONAL ISSS', 'Deudor', '88.93', 4, 4, 1, 7, 520, 23),
(527, '420207', 'CUOTA PATRONAL INSAFORP', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(528, '420208', 'CUOTA PATRONAL AFP', 'Deudor', '87.75', 4, 4, 0, 7, 520, 23),
(529, '42020801', 'AFP CRECER', 'Deudor', '0.00', 5, 4, 1, 7, 528, 23),
(530, '42020802', 'AFP CONFIA', 'Deudor', '87.75', 5, 4, 1, 7, 528, 23),
(531, '420209', 'CAPACITACION AL PERSONAL', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(532, '420210', 'UNIFORME AL PERSONAL', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(533, '420211', 'SERVICIOS DE VIGILANCIA', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(534, '420212', 'HONORARIOS PROFESIONALES', 'Deudor', '150.00', 4, 4, 1, 7, 520, 23),
(535, '420213', 'SERVICIOS DE VIGILANCIA', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(536, '420214', 'SERVICIOS DE AGUA POTABLE', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(537, '420215', 'PAPELERIA Y UTILES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(538, '420216', 'MEMBRESIA Y SUSCRIPCIONES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(539, '420217', 'IMPUESTOS FISCALES Y MUNICIPALES', 'Deudor', '500.00', 4, 4, 0, 7, 520, 23),
(540, '42021701', 'ALCALDIA MUNICIPAL', 'Deudor', '500.00', 5, 4, 1, 7, 539, 23),
(541, '420218', 'REGISTRO DE COMERCIO', 'Deudor', '262.86', 4, 4, 0, 7, 520, 23),
(542, '42021801', 'MATRICULA DE COMERCIO', 'Deudor', '262.86', 5, 4, 1, 7, 541, 23),
(543, '42021802', 'INSCRIPCION DE BALANCE', 'Deudor', '0.00', 5, 4, 1, 7, 541, 23),
(544, '42021803', 'INSCRIPCION DE ESCRITURA DE CONSTITUCION', 'Deudor', '0.00', 5, 4, 1, 7, 541, 23),
(545, '420219', 'REGISTRO DE MARCAS', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(546, '420220', 'PROPAGANDA Y PUBLICIDAD', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(547, '420221', 'ATENCION A CLIENTES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(548, '420222', 'CUENTAS INCOBRABLES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(549, '420223', 'CONTRIBUCIONES Y DONACIONES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(550, '420224', 'DEPRECIACIONES', 'Deudor', '483.33', 4, 4, 0, 7, 520, 23),
(551, '42022401', 'EDIFICACIONES', 'Deudor', '483.33', 5, 4, 1, 7, 550, 23),
(552, '42022402', 'MAQUINARIA Y  EQUIPO', 'Deudor', '0.00', 5, 4, 1, 7, 550, 23),
(553, '42022403', 'MOBILIARIO Y EQUIPO DE OFICINA', 'Deudor', '0.00', 5, 4, 1, 7, 550, 23),
(554, '42022404', 'VEHICULO DE TRANSPORTE', 'Deudor', '0.00', 5, 4, 1, 7, 550, 23),
(555, '420225', 'GASTOS DE CONSTITUCION', 'Deudor', '4500.00', 4, 4, 1, 7, 520, 23),
(556, '420226', 'MANTENIMIENTO DE MOBILIARIO Y EQUIPO DE OFICINA', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(557, '420227', 'COMBUSTIBLE Y LUBRICANTES', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(558, '420228', 'MANTENIMIENTO DE VEHICULO', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(559, '420229', 'GASTOS NO DEDUCIBLES', 'Deudor', '800.00', 4, 4, 0, 7, 520, 23),
(560, '42022901', 'PASAJES AEREOS', 'Deudor', '800.00', 5, 4, 1, 7, 559, 23),
(561, '420230', 'DEPRECIACION DE VEHICULO', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(562, '420231', 'FOVIAL', 'Deudor', '0.00', 4, 4, 1, 7, 520, 23),
(563, '420232', 'OTROS GASTOS', 'Deudor', '2733.33', 4, 4, 1, 7, 520, 23),
(564, '4203', 'GASTOS FINANCIEROS', 'Deudor', '898.70', 3, 4, 0, 7, 474, 23),
(565, '420301', 'COMISIONES BANCARIAS', 'Deudor', '500.00', 4, 4, 1, 7, 564, 23),
(566, '420302', 'GASTOS BANCARIOS', 'Deudor', '0.00', 4, 4, 1, 7, 564, 23),
(567, '420303', 'INTERESES', 'Deudor', '398.70', 4, 4, 1, 7, 564, 23),
(568, '4204', 'OTROS GASTOS', 'Deudor', '0.00', 3, 4, 0, 7, 474, 23),
(569, '420401', 'NO DEDUCIBLE', 'Deudor', '0.00', 4, 4, 1, 7, 568, 23),
(570, '420402', 'DEDUCIBLES', 'Deudor', '0.00', 4, 4, 1, 7, 568, 23),
(571, '5', 'CUENTAS DE RESULTADOS ACREEDORAS', 'Acreedor', '252120.00', 1, 5, 0, 7, NULL, 23),
(572, '51', 'INGRESOS POR VENTAS', 'Acreedor', '252120.00', 2, 5, 0, 7, 571, 23),
(573, '5101', 'VENTAS', 'Acreedor', '252000.00', 3, 5, 0, 7, 572, 23),
(574, '510101', 'VENTAS LOCALES', 'Acreedor', '252000.00', 4, 5, 0, 7, 573, 23),
(575, '51010101', 'DE CONTADO', 'Acreedor', '252000.00', 5, 5, 1, 7, 574, 23),
(576, '51010102', 'A PLAZO', 'Acreedor', '0.00', 5, 5, 1, 7, 574, 23),
(577, '5102R', 'REBAJAS Y DEVOLUCIONES SOBRE VENTAS', 'Deudor', '880.00', 3, 5, 0, 7, 572, 23),
(578, '510201R', 'DE CONTADO', 'Deudor', '880.00', 4, 5, 1, 7, 577, 23),
(579, '5103', 'OTROS INGRESOS', 'Acreedor', '1000.00', 3, 5, 0, 7, 572, 23),
(580, '510301', 'VENTA DE BIENES Y SERVICIOS DIVERSOS', 'Acreedor', '0.00', 4, 5, 1, 7, 579, 23),
(581, '510302', 'DESECHOS DIVERSOS', 'Acreedor', '1000.00', 4, 5, 1, 7, 579, 23),
(582, '6', 'CUENTAS LIQUIDADORAS', 'Deudor', '0.00', 1, 6, 0, 7, NULL, 23),
(583, '61', 'CUENTAS LIQUIDADORAS', 'Deudor', '0.00', 2, 6, 0, 7, 582, 23),
(584, '6101', 'Perdidas y Ganancias', 'Deudor', '0.00', 3, 6, 1, 7, 583, 23),
(585, '7', 'CUENTAS DE ORDEN', 'Deudor', '0.00', 1, 7, 0, 7, NULL, 23),
(586, '71', 'CUENTAS DE ORDEN DEUDOR', 'Deudor', '0.00', 2, 7, 0, 7, 585, 23),
(587, '7101', 'CUENTAS DE ORDEN DEUDOR', 'Deudor', '0.00', 3, 7, 1, 7, 586, 23),
(588, '8', 'CUENTAS DE ORDEN POR EL CONTRA', 'Acreedor', '0.00', 1, 8, 0, 7, NULL, 23),
(589, '81', 'CUENTAS DE ORDEN POR EL CONTRA', 'Acreedor', '0.00', 2, 8, 0, 7, 588, 23),
(590, '8101', 'CUENTAS DE ORDEN POR EL CONTRA', 'Acreedor', '0.00', 3, 8, 1, 7, 589, 23);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_partida`
--

CREATE TABLE `detalle_partida` (
  `cuenta` int(11) NOT NULL,
  `partida` int(11) NOT NULL,
  `movimiento` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'cargo ó abono',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `detalle_partida`
--

INSERT INTO `detalle_partida` (`cuenta`, `partida`, `movimiento`, `monto`) VALUES
(247, 10, 'Cargo', '25000.00'),
(248, 10, 'Cargo', '2300000.00'),
(251, 10, 'Cargo', '6550000.00'),
(255, 10, 'Cargo', '175000.00'),
(249, 10, 'Cargo', '290000.00'),
(252, 10, 'Cargo', '62000.00'),
(250, 10, 'Cargo', '65000.00'),
(260, 10, 'Cargo', '10500.00'),
(256, 10, 'Cargo', '2800000.00'),
(258, 10, 'Cargo', '4500000.00'),
(259, 10, 'Cargo', '985000.00'),
(254, 10, 'Cargo', '340000.00'),
(253, 10, 'Cargo', '580000.00'),
(257, 10, 'Cargo', '195000.00'),
(267, 10, 'Abono', '475000.00'),
(262, 10, 'Abono', '105000.00'),
(263, 10, 'Abono', '150000.00'),
(266, 10, 'Abono', '42000.00'),
(261, 10, 'Abono', '2890000.00'),
(264, 10, 'Abono', '850000.00'),
(265, 10, 'Abono', '199000.00'),
(268, 10, 'Abono', '14166500.00'),
(249, 11, 'Cargo', '1299500.00'),
(277, 11, 'Abono', '1150000.00'),
(273, 11, 'Abono', '149500.00'),
(280, 12, 'Cargo', '375000.00'),
(272, 12, 'Cargo', '48750.00'),
(248, 12, 'Abono', '254250.00'),
(261, 12, 'Abono', '169500.00'),
(285, 13, 'Cargo', '6500.00'),
(272, 13, 'Cargo', '845.00'),
(248, 13, 'Abono', '7345.00'),
(288, 14, 'Cargo', '7250.00'),
(274, 14, 'Abono', '7250.00'),
(284, 15, 'Cargo', '7800.00'),
(273, 15, 'Cargo', '1014.00'),
(249, 15, 'Abono', '8814.00'),
(261, 16, 'Cargo', '9842.30'),
(283, 16, 'Abono', '8710.00'),
(272, 16, 'Abono', '1132.30'),
(280, 17, 'Cargo', '41325.00'),
(272, 17, 'Cargo', '5372.25'),
(261, 17, 'Abono', '46697.25'),
(261, 18, 'Cargo', '46697.25'),
(248, 18, 'Abono', '44058.86'),
(283, 18, 'Abono', '2334.86'),
(272, 18, 'Abono', '303.53'),
(291, 19, 'Cargo', '7910.00'),
(277, 19, 'Abono', '7000.00'),
(273, 19, 'Abono', '910.00'),
(261, 20, 'Cargo', '4645.43'),
(283, 20, 'Abono', '4111.00'),
(272, 20, 'Abono', '534.43'),
(271, 21, 'Cargo', '8300.00'),
(272, 21, 'Cargo', '1079.00'),
(248, 21, 'Abono', '9379.00'),
(274, 22, 'Cargo', '5350.00'),
(249, 22, 'Abono', '5350.00'),
(248, 23, 'Cargo', '93365.12'),
(277, 23, 'Abono', '82624.00'),
(273, 23, 'Abono', '10741.12'),
(284, 24, 'Cargo', '2813.00'),
(273, 24, 'Cargo', '365.69'),
(249, 24, 'Abono', '3178.69'),
(248, 25, 'Cargo', '73261.00'),
(249, 25, 'Abono', '73261.00'),
(288, 26, 'Cargo', '22315.00'),
(272, 26, 'Cargo', '2900.95'),
(248, 26, 'Abono', '25215.95'),
(287, 27, 'Cargo', '9317.00'),
(272, 27, 'Cargo', '1211.21'),
(248, 27, 'Abono', '10528.21'),
(289, 28, 'Cargo', '1825.00'),
(272, 28, 'Cargo', '237.25'),
(248, 28, 'Abono', '2062.25'),
(248, 29, 'Cargo', '8175.00'),
(282, 29, 'Abono', '8175.00'),
(287, 30, 'Cargo', '1750.00'),
(270, 30, 'Abono', '1750.00'),
(250, 31, 'Cargo', '3900.00'),
(247, 31, 'Abono', '3900.00'),
(303, 60, 'Cargo', '225000.00'),
(341, 60, 'Cargo', '75000.00'),
(359, 60, 'Cargo', '30000.00'),
(361, 60, 'Cargo', '120000.00'),
(353, 60, 'Cargo', '50000.00'),
(453, 60, 'Abono', '500000.00'),
(308, 61, 'Cargo', '225000.00'),
(303, 61, 'Abono', '225000.00'),
(304, 62, 'Cargo', '1000.00'),
(308, 62, 'Abono', '1000.00'),
(542, 63, 'Cargo', '262.86'),
(308, 63, 'Abono', '262.86'),
(540, 64, 'Cargo', '500.00'),
(308, 64, 'Abono', '500.00'),
(339, 65, 'Cargo', '11700.00'),
(468, 65, 'Cargo', '90000.00'),
(308, 65, 'Abono', '98649.00'),
(339, 65, 'Abono', '351.00'),
(473, 65, 'Abono', '2700.00'),
(303, 66, 'Cargo', '124300.00'),
(434, 66, 'Abono', '14300.00'),
(575, 66, 'Abono', '110000.00'),
(308, 67, 'Cargo', '124300.00'),
(303, 67, 'Abono', '124300.00'),
(339, 68, 'Cargo', '585.00'),
(555, 68, 'Cargo', '4500.00'),
(404, 68, 'Abono', '5085.00'),
(404, 69, 'Cargo', '5085.00'),
(308, 69, 'Abono', '4635.00'),
(416, 69, 'Abono', '450.00'),
(311, 70, 'Cargo', '3000.00'),
(308, 70, 'Abono', '3000.00'),
(359, 71, 'Cargo', '10000.00'),
(361, 71, 'Cargo', '50000.00'),
(519, 71, 'Cargo', '942.86'),
(308, 71, 'Abono', '10942.86'),
(440, 71, 'Abono', '50000.00'),
(534, 72, 'Cargo', '150.00'),
(339, 72, 'Cargo', '19.50'),
(308, 72, 'Abono', '169.50'),
(565, 73, 'Cargo', '500.00'),
(308, 73, 'Abono', '500.00'),
(563, 74, 'Cargo', '700.00'),
(304, 74, 'Abono', '700.00'),
(381, 75, 'Cargo', '1650.00'),
(434, 75, 'Cargo', '14300.00'),
(339, 75, 'Abono', '11953.50'),
(428, 75, 'Abono', '2346.50'),
(429, 75, 'Abono', '1650.00'),
(339, 76, 'Cargo', '6500.00'),
(468, 76, 'Cargo', '50000.00'),
(398, 76, 'Abono', '56000.00'),
(432, 76, 'Abono', '500.00'),
(428, 78, 'Cargo', '2346.50'),
(429, 78, 'Cargo', '1650.00'),
(416, 78, 'Cargo', '450.00'),
(308, 78, 'Abono', '4446.50'),
(308, 82, 'Cargo', '48725.60'),
(315, 82, 'Cargo', '74580.00'),
(578, 82, 'Cargo', '880.00'),
(434, 82, 'Abono', '14185.60'),
(575, 82, 'Abono', '110000.00'),
(327, 83, 'Cargo', '1000.00'),
(308, 83, 'Abono', '1000.00'),
(339, 84, 'Cargo', '650.00'),
(476, 84, 'Cargo', '360.00'),
(485, 84, 'Cargo', '27.00'),
(489, 84, 'Cargo', '23.40'),
(494, 84, 'Cargo', '1000.00'),
(495, 84, 'Cargo', '500.00'),
(519, 84, 'Cargo', '1500.00'),
(521, 84, 'Cargo', '1350.00'),
(526, 84, 'Cargo', '88.93'),
(530, 84, 'Cargo', '87.75'),
(563, 84, 'Cargo', '2000.00'),
(308, 84, 'Abono', '5650.00'),
(437, 84, 'Abono', '1460.97'),
(408, 84, 'Abono', '95.78'),
(410, 84, 'Abono', '46.37'),
(413, 84, 'Abono', '106.88'),
(421, 84, 'Abono', '115.93'),
(425, 84, 'Abono', '111.15'),
(437, 85, 'Cargo', '1460.97'),
(308, 85, 'Abono', '1460.97'),
(303, 86, 'Cargo', '1130.00'),
(434, 86, 'Abono', '130.00'),
(581, 86, 'Abono', '1000.00'),
(308, 87, 'Cargo', '1130.00'),
(303, 87, 'Abono', '1130.00'),
(339, 88, 'Cargo', '130.00'),
(347, 88, 'Cargo', '1000.00'),
(308, 88, 'Abono', '1130.00'),
(303, 89, 'Cargo', '36160.00'),
(434, 89, 'Abono', '4160.00'),
(575, 89, 'Abono', '32000.00'),
(560, 90, 'Cargo', '800.00'),
(308, 90, 'Abono', '800.00'),
(381, 91, 'Cargo', '2116.80'),
(434, 91, 'Cargo', '18475.60'),
(339, 91, 'Abono', '7280.00'),
(428, 91, 'Abono', '11195.60'),
(429, 91, 'Abono', '2116.80'),
(440, 92, 'Cargo', '1898.62'),
(567, 92, 'Cargo', '398.70'),
(308, 92, 'Abono', '2297.32'),
(508, 93, 'Cargo', '725.00'),
(551, 93, 'Cargo', '483.33'),
(373, 93, 'Abono', '1000.00'),
(374, 93, 'Abono', '208.33'),
(512, 94, 'Cargo', '50.00'),
(563, 94, 'Cargo', '33.33'),
(351, 94, 'Abono', '83.33');

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `correo` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`id`, `correo`, `nombre`, `usuario`, `contrasena`) VALUES
(1, '', 'Empresa X', 'user12345', '12345678'),
(2, '', 'beer', 'admin123', 'admin123'),
(3, '', 'Empresa X', '123123123', '1231232313'),
(4, '', 'JUE LULUE SA DE CV', '13123123', '123456789'),
(5, '', 'fsadf123', 'dfadfadf', 'adsfdf123'),
(6, '', 'Prueba SA DE CV', 'sinperiodo', 'admin123'),
(7, 'edgardalasu@gmail.com', 'CDM, S.A. DE S.V.', 'master2020', 'master2020'),
(8, '', '11311231321312', '12313123', '12345678'),
(10, 'esphuma1@gmail.com', 'Empresa X 2', 'usuario12345', 'hola123456'),
(11, 'esphuma1@gmail.com', 'Empresa X 2', 'usuario12345', 'hola123456'),
(12, 'esphuma2@gmail.com', 'Empresa Prueba 2', 'user12346', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `partida`
--

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `descripcion` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `partida_cierre` tinyint(4) DEFAULT '0',
  `periodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `partida`
--

INSERT INTO `partida` (`id`, `numero`, `descripcion`, `fecha`, `partida_cierre`, `periodo`) VALUES
(10, 1, 'Inicio de operaciones', '2020-10-24 00:00:00', 0, 21),
(11, 2, 'venta de mercaderÃ­a', '2020-10-24 00:00:00', 0, 21),
(12, 3, 'Compra de mercaderÃ­a, 60% contado y el resto con letra de cambio', '2020-10-24 00:00:00', 0, 21),
(13, 4, 'gastos de enviÃ³ de mercancÃ­a comprada', '2020-10-24 00:00:00', 0, 21),
(14, 5, 'ProvisiÃ³n estimada para cuentas incobrables', '2020-10-24 00:00:00', 0, 21),
(15, 6, 'DevoluciÃ³n sobre venta', '2020-10-24 00:00:00', 0, 21),
(16, 7, 'DevoluciÃ³n sobre compra', '2020-10-24 00:00:00', 0, 21),
(17, 8, 'Compra de mercaderÃ­a al crÃ©dito', '2020-10-24 00:00:00', 0, 21),
(18, 9, 'Pago a proveedores con rebaja por condiciÃ³n 5/10 neto 60', '2020-10-24 00:00:00', 0, 21),
(19, 10, 'Perdida de venta debido a  asalto', '2020-10-24 00:00:00', 0, 21),
(20, 11, 'Descuento de Proveedores', '2020-10-24 00:00:00', 0, 21),
(21, 12, 'Compra de patente amortizable para 5 aÃ±os', '2020-10-24 00:00:00', 0, 21),
(22, 13, 'Se determina valor de cuentas incobrables', '2020-10-24 00:00:00', 0, 21),
(23, 14, 'Venta de mercaderÃ­a al contado', '2020-10-24 00:00:00', 0, 21),
(24, 15, 'DevoluciÃ³n sobre venta', '2020-10-24 00:00:00', 0, 21),
(25, 16, 'Pago de un cliente por venta realizada', '2020-10-24 00:00:00', 0, 21),
(26, 17, 'Pago de cuÃ±as publicitarias', '2020-10-24 00:00:00', 0, 21),
(27, 18, 'Pago de viÃ¡ticos a personal administrativo', '2020-10-24 00:00:00', 0, 21),
(28, 19, 'Pago de comisiÃ³n', '2020-10-24 00:00:00', 0, 21),
(29, 20, 'Cobro de intereses', '2020-10-24 00:00:00', 0, 21),
(30, 21, 'ProvisiÃ³n de recibos de luz, agua y telÃ©fono', '2020-10-24 00:00:00', 0, 21),
(31, 22, 'Retiro de caja para gastos personales', '2020-10-24 00:00:00', 0, 21),
(60, 1, 'Registro por los procedimientos legales de constitucion de la empresa', '2020-12-14 00:00:00', 0, 23),
(61, 2, 'Por la remesa efectuada a la cuenta corriente aperturada en el Banco Cuscatlan', '2020-12-14 00:00:00', 0, 23),
(62, 3, 'Por la constitucion de la Caja Chica', '2020-12-14 00:00:00', 0, 23),
(63, 4, 'Registro por pago de matricula de comercio por primera vez', '2020-12-14 00:00:00', 0, 23),
(64, 5, 'Registro por pago de matricula de comercio por primera vez en alcaldia', '2020-12-14 00:00:00', 0, 23),
(65, 6, 'Compras de mercaderia al contado', '2020-12-14 00:00:00', 0, 23),
(66, 7, 'Ventas locales al contado', '2020-12-15 00:00:00', 0, 23),
(67, 8, 'Remesa efectuada por los valores recibidos de las ventas', '2020-12-15 00:00:00', 0, 23),
(68, 9, 'Provision de los gastos de constitucion por pagar', '2020-12-15 00:00:00', 0, 23),
(69, 10, 'Registro por el pago de constitucion', '2020-12-15 00:00:00', 0, 23),
(70, 11, 'Remesa afectuada por apertura de cuenta de ahorros', '2020-12-15 00:00:00', 0, 23),
(71, 12, 'Registro de la compra al credito de una bodega', '2020-12-15 00:00:00', 0, 23),
(72, 13, 'Registro por el pago de la bodega', '2020-12-15 00:00:00', 0, 23),
(73, 14, 'Comiciones pagadas por transacciones bancarias', '2020-12-15 00:00:00', 0, 23),
(74, 15, 'por el reintregro de gastos a caja chica', '2020-12-15 00:00:00', 0, 23),
(75, 16, 'Provicion pago de cuenta de debito y credito', '2020-12-16 00:00:00', 0, 23),
(76, 17, 'Compra de mercaderia para la venta', '2020-12-16 00:00:00', 0, 23),
(78, 18, 'Pago del impuesto IVA', '2020-12-16 00:00:00', 0, 23),
(82, 19, 'Registro por ventas', '2020-12-16 00:00:00', 0, 23),
(83, 20, 'Registro por prestamo realizado al personal', '2020-12-16 00:00:00', 0, 23),
(84, 21, 'Registro provision para pago de sueldos', '2020-12-16 00:00:00', 0, 23),
(85, 22, 'Pago de sueldos del mes', '2020-12-16 00:00:00', 0, 23),
(86, 23, 'Conocomiento de otros ingresos', '2020-12-16 00:00:00', 0, 23),
(87, 24, 'Remesa efectuada al banco', '2020-12-16 00:00:00', 0, 23),
(88, 25, 'Registro adquisicion de seguro', '2020-12-16 00:00:00', 0, 23),
(89, 26, 'Registro venta de mercaderia', '2020-12-16 00:00:00', 0, 23),
(90, 27, 'Pago de pasaje aereo', '2020-12-16 00:00:00', 0, 23),
(91, 28, 'Provision impuestos por pagar', '2020-12-16 00:00:00', 0, 23),
(92, 29, 'Pago de la primera cuota del prestamo', '2020-12-16 00:00:00', 0, 23),
(93, 30, 'Registro para contabilizar el gasto del periodo', '2020-12-16 00:00:00', 0, 23),
(94, 31, 'Registro para conocer las amortizaciones del periodo', '2020-12-16 00:00:00', 0, 23);

-- --------------------------------------------------------

--
-- Table structure for table `periodo`
--

CREATE TABLE `periodo` (
  `id` int(11) NOT NULL,
  `estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'ACTIVO' COMMENT 'CIERRE, ACTIVO, CERRADO',
  `anio` year(4) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `periodo`
--

INSERT INTO `periodo` (`id`, `estado`, `anio`, `empresa`) VALUES
(21, 'CIERRE', 2020, 2),
(22, 'ACTIVO', 2020, 1),
(23, 'ACTIVO', 2020, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_CONFIGURACION_PERIODOS1_idx` (`periodo`),
  ADD KEY `fk_CONFIGURACION_CUENTAS1_idx` (`cuenta`);

--
-- Indexes for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cuenta_empresa_idx` (`empresa`),
  ADD KEY `fk_CUENTAS_CUENTAS1_idx` (`padre`),
  ADD KEY `fk_cuenta_periodo` (`periodo`) USING BTREE;

--
-- Indexes for table `detalle_partida`
--
ALTER TABLE `detalle_partida`
  ADD KEY `fk_CUENTAS_has_PARTIDA_PARTIDA1_idx` (`partida`),
  ADD KEY `fk_CUENTAS_has_PARTIDA_CUENTAS1_idx` (`cuenta`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_PARTIDA_PERIODOS1_idx` (`periodo`);

--
-- Indexes for table `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_PERIODOS_EMPRESA1_idx` (`empresa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=879;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `FK_configuracion_cuenta` FOREIGN KEY (`cuenta`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_configuracion_periodo` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `FK_cuenta_cuenta` FOREIGN KEY (`padre`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_cuenta_empresa` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_cuenta_periodo` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detalle_partida`
--
ALTER TABLE `detalle_partida`
  ADD CONSTRAINT `FK_detalle_partida_cuenta` FOREIGN KEY (`cuenta`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_detalle_partida_partida` FOREIGN KEY (`partida`) REFERENCES `partida` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `FK_partida_periodo` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `periodo`
--
ALTER TABLE `periodo`
  ADD CONSTRAINT `FK_periodo_empresa` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

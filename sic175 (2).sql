-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2020 at 04:34 AM
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
(249, 'estado_resultados', 'perdida', 21, 293);

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo_saldo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
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
(298, '6101', 'Perdidas y Ganancias', 'Deudor', '0.00', 3, 6, 1, 2, 297, 21);

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
(247, 31, 'Abono', '3900.00');

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `usuario`, `contrasena`) VALUES
(1, 'Empresa X', 'user12345', '12345678'),
(2, 'beer', 'admin123', 'admin123'),
(3, 'Empresa X', '123123123', '1231232313'),
(4, 'JUE LULUE SA DE CV', '13123123', '123456789'),
(5, 'fsadf123', 'dfadfadf', 'adsfdf123'),
(6, 'Prueba SA DE CV', 'sinperiodo', 'admin123');

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
(31, 22, 'Retiro de caja para gastos personales', '2020-10-24 00:00:00', 0, 21);

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
(22, 'ACTIVO', 2020, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

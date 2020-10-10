-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2020 at 01:22 AM
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
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo_configuracion` text COLLATE utf8_spanish_ci NOT NULL,
  `periodo` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo_saldo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `saldo` double DEFAULT '0',
  `nivel` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `ultimo_nivel` tinyint(4) DEFAULT '1',
  `empresa` int(11) NOT NULL,
  `padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cuenta`
--

INSERT INTO `cuenta` (`id`, `codigo`, `nombre`, `tipo_saldo`, `saldo`, `nivel`, `orden`, `ultimo_nivel`, `empresa`, `padre`) VALUES
(9, '1', 'ACTIVO', 'Deudor', 0, 1, 1, 0, 1, NULL),
(10, '11', 'ACTIVOS CORRIENTE', 'Deudor', 0, 2, 1, 0, 1, 9),
(11, '1101', 'EFECTIVO Y EQUIVALENTES DE EFECTIVO', 'Deudor', 0, 3, 1, 0, 1, 10),
(12, '110101', 'Caja general', 'Deudor', 0, 4, 1, 0, 1, 11),
(13, '11010102', 'Caja chica', 'Deudor', 0, 5, 1, 1, 1, 12),
(14, '11010103', 'Bancos', 'Deudor', 0, 5, 1, 0, 1, 12),
(15, '1101010301', 'Cuenta corriente', 'Deudor', 0, 6, 1, 1, 1, 14),
(16, '1101010302', 'Cuenta de ahorro', 'Deudor', 0, 6, 1, 1, 1, 14),
(17, '1101010304', 'DepÃ³sitos a plazo', 'Deudor', 0, 6, 1, 1, 1, 14),
(18, '1102', 'INVERSIONES A CORTO PLAZO', 'Deudor', 0, 3, 1, 0, 1, 10),
(19, '110201', 'Acciones', 'Deudor', 0, 4, 1, 1, 1, 18),
(20, '110202', 'Bonos', 'Deudor', 0, 4, 1, 1, 1, 18),
(21, '110203', 'Otros tÃ­tulos valores', 'Deudor', 0, 4, 1, 1, 1, 18),
(22, '1103', 'CUENTAS POR COBRAR', 'Deudor', 0, 3, 1, 1, 1, 10),
(23, '1104', 'DOCUMENTOS POR COBRAR', 'Deudor', 0, 3, 1, 1, 1, 10),
(24, '1105', 'ACCIONISTAS', 'Deudor', 0, 3, 1, 1, 1, 10),
(25, '1106', 'PRESTAMOS A EMPLEADOS Y ACCIONISTAS', 'Deudor', 0, 3, 1, 0, 1, 10),
(26, '110601', 'Accionistas', 'Deudor', 0, 4, 1, 1, 1, 25),
(27, '110602', 'Empleados', 'Deudor', 0, 4, 1, 1, 1, 25),
(28, '1107', 'OTRAS CUENTAS POR COBRAR', 'Deudor', 0, 3, 1, 0, 1, 10),
(29, '110701', 'Anticipo a proveedores', 'Deudor', 0, 4, 1, 1, 1, 28),
(30, '110702', 'Anticipo de salarios a empleados', 'Deudor', 0, 4, 1, 1, 1, 28),
(31, '1108R', 'ESTIMACION POR CUENTAS INCOBRABLES', 'Acreedor', 0, 3, 1, 1, 1, 10),
(32, '1109', 'INVENTARIOS', 'Deudor', 0, 3, 1, 1, 1, 10),
(33, '1110R', 'ESTIMACION PARA DETERIORO DE INVENTARIO', 'Acreedor', 0, 3, 1, 1, 1, 10),
(34, '1111', 'GASTOS PAGADOS POR ANTICIPADO', 'Deudor', 0, 3, 1, 0, 1, 10),
(35, '111101', 'Seguros', 'Deudor', 0, 4, 1, 1, 1, 34),
(36, '111102', 'Alquileres', 'Deudor', 0, 4, 1, 1, 1, 34),
(37, '111103', 'PapelerÃ­a y Ãºtiles', 'Deudor', 0, 4, 1, 1, 1, 34),
(38, '111104', 'Pago a cuenta', 'Deudor', 0, 4, 1, 1, 1, 34),
(39, '111105', 'Otros gastos pagados por anticipados', 'Deudor', 0, 4, 1, 1, 1, 34),
(40, '1112', 'IVA CREDITO FISCAL', 'Deudor', 0, 3, 1, 1, 1, 10),
(41, '1113', 'IVA PAGADO POR ANTICIPADO', 'Deudor', 0, 3, 1, 0, 1, 10),
(42, '111301', 'IVA percibido', 'Deudor', 0, 4, 1, 1, 1, 41),
(43, '111302', 'IVA Retenido', 'Deudor', 0, 4, 1, 1, 1, 41),
(44, '1114', 'PAGO A CUENTA', 'Deudor', 0, 3, 1, 1, 1, 10),
(45, '12', 'ACTIVOS NO CORRIENTES', 'Deudor', 0, 2, 1, 0, 1, 9),
(46, '1201', 'PROPIEDAD PLANTA Y EQUIPO', 'Deudor', 0, 3, 1, 0, 1, 45),
(47, '120101', 'Terrenos', 'Deudor', 0, 4, 1, 1, 1, 46),
(48, '120102', 'Edificios', 'Deudor', 0, 4, 1, 1, 1, 46),
(49, '120103', 'Intalaciones', 'Deudor', 0, 4, 1, 1, 1, 46),
(50, '120104', 'Equipo de reparto', 'Deudor', 0, 4, 1, 1, 1, 46),
(51, '120105', 'Mobiliario y equipo', 'Deudor', 0, 4, 1, 1, 1, 46),
(52, '1202R', 'DEPRECIACIONES', 'Acreedor', 0, 3, 1, 0, 1, 45),
(53, '120201R', 'Edificio', 'Acreedor', 0, 4, 1, 1, 1, 52),
(54, '120202R', 'Intalaciones', 'Acreedor', 0, 4, 1, 1, 1, 52),
(55, '120203R', 'Equipo de reparto', 'Acreedor', 0, 4, 1, 1, 1, 52),
(56, '120204R', 'Mobiliario y equipo', 'Acreedor', 0, 4, 1, 1, 1, 52),
(57, '1203', 'INSTANGIBLES', 'Deudor', 0, 3, 1, 0, 1, 45),
(58, '120301', 'CrÃ©dito mercantil', 'Deudor', 0, 4, 1, 1, 1, 57),
(59, '120302', 'Patentes y marcas', 'Deudor', 0, 4, 1, 1, 1, 57),
(60, '120303', 'Licencias', 'Deudor', 0, 4, 1, 1, 1, 57),
(61, '1204R', 'AMORTIZACION DE INTANGIBLES', 'Deudor', 0, 3, 1, 0, 1, 45),
(62, '120401R', 'CrÃ©dito mercantil', 'Deudor', 0, 4, 1, 1, 1, 61),
(63, '120402R', 'Patentes y marcas', 'Deudor', 0, 4, 1, 1, 1, 61),
(64, '120403R', 'Licencias', 'Deudor', 0, 4, 1, 1, 1, 61),
(65, '1205', 'INVERSIONES PERMANENTES', 'Deudor', 0, 3, 1, 1, 1, 45),
(66, '1206', 'IMPUESTO SOBRE LA RENTA DIFERIDO', 'Deudor', 0, 3, 1, 1, 1, 45),
(67, '2', 'PASIVO', 'Acreedor', 0, 1, 2, 0, 1, NULL),
(68, '21', 'PASIVOS CORRIENTE', 'Acreedor', 0, 2, 2, 0, 1, 67),
(69, '2101', 'SOBREGIROS BANCARIOS', 'Acreedor', 0, 3, 2, 1, 1, 68),
(70, '2102', 'PROVEEDORES', 'Acreedor', 0, 3, 2, 0, 1, 68),
(71, '210201', 'Locales', 'Acreedor', 0, 4, 2, 1, 1, 70),
(72, '210202', 'Extranjeros', 'Acreedor', 0, 4, 2, 1, 1, 70),
(73, '2103', 'DOCUMENTOS POR COBRAR DESCONTADOS', 'Acreedor', 0, 3, 2, 0, 1, 68),
(74, '210301', 'Pagares', 'Acreedor', 0, 4, 2, 1, 1, 73),
(75, '210302', 'Letras de cambio', 'Acreedor', 0, 4, 2, 1, 1, 73),
(76, '210303', 'Bonos', 'Acreedor', 0, 4, 2, 1, 1, 73),
(77, '210304', 'Otros tÃ­tulos valores', 'Acreedor', 0, 4, 2, 1, 1, 73),
(78, '2104', 'DOCUMENTOS POR PAGAR', 'Acreedor', 0, 3, 2, 0, 1, 68),
(79, '210401', 'Pagares', 'Acreedor', 0, 4, 2, 1, 1, 78),
(80, '210402', 'Letras de cambio', 'Acreedor', 0, 4, 2, 1, 1, 78),
(81, '210403', 'Bonos', 'Acreedor', 0, 4, 2, 1, 1, 78),
(82, '210404', 'Otros tÃ­tulos valores', 'Acreedor', 0, 4, 2, 1, 1, 78),
(83, '2105', 'PRESTAMOS POR PAGAR', 'Acreedor', 0, 3, 2, 0, 1, 68),
(84, '210501', 'Bancarios', 'Acreedor', 0, 4, 2, 1, 1, 83),
(85, '210502', 'Accionistas', 'Acreedor', 0, 4, 2, 1, 1, 83),
(86, '210503', 'Otros', 'Acreedor', 0, 4, 2, 1, 1, 83),
(87, '2106', 'RETENCIONES POR PAGAR', 'Acreedor', 0, 3, 2, 0, 1, 68),
(88, '210601', 'ISSS (salud)', 'Acreedor', 0, 4, 2, 1, 1, 87),
(89, '210602', 'ISSS (pensiÃ³n)', 'Acreedor', 0, 4, 2, 1, 1, 87),
(90, '210603', 'AFP', 'Acreedor', 0, 4, 2, 1, 1, 87),
(91, '210604', 'RENTA', 'Acreedor', 0, 4, 2, 1, 1, 87),
(92, '210605', 'IVA', 'Acreedor', 0, 4, 2, 1, 1, 87),
(93, '2107', 'PROVISIONES POR PAGAR', 'Acreedor', 0, 3, 2, 0, 1, 68),
(94, '210701', 'ISSS (salud)', 'Acreedor', 0, 4, 2, 1, 1, 93),
(95, '210702', 'ISSS (pensiÃ³n)', 'Acreedor', 0, 4, 2, 1, 1, 93),
(96, '210703', 'AFP', 'Acreedor', 0, 4, 2, 1, 1, 93),
(97, '210704', 'INSAFORP', 'Acreedor', 0, 4, 2, 1, 1, 93),
(98, '210705', 'Pago a Cuenta', 'Acreedor', 0, 4, 2, 1, 1, 93),
(99, '2108', 'DIVIDENDOS POR PAGAR', 'Acreedor', 0, 3, 2, 1, 1, 68),
(100, '2109', 'IVA DEBITO FISCAL', 'Acreedor', 0, 3, 2, 1, 1, 68),
(101, '2110', 'IVA PERCIBIDO Y RETENIDO POR PAGAR', 'Acreedor', 0, 3, 2, 0, 1, 68),
(102, '211001', 'Iva Percibido', 'Acreedor', 0, 4, 2, 1, 1, 101),
(103, '211002', 'Iva Retenido', 'Acreedor', 0, 4, 2, 1, 1, 101),
(104, '2111', 'IMPUESTO POR PAGAR', 'Acreedor', 0, 3, 2, 0, 1, 68),
(105, '211101', 'Pago a Cuenta', 'Acreedor', 0, 4, 2, 1, 1, 104),
(106, '211102', 'RENTA', 'Acreedor', 0, 4, 2, 1, 1, 104),
(107, '211103', 'IVA', 'Acreedor', 0, 4, 2, 1, 1, 104),
(108, '211104', 'Otros', 'Acreedor', 0, 4, 2, 1, 1, 104),
(109, '2112', 'CUENTAS POR PAGAR', 'Acreedor', 0, 3, 2, 1, 1, 68),
(110, '2113', 'INTERESES POR PAGAR', 'Acreedor', 0, 3, 2, 1, 1, 68),
(111, '22', 'PASIVO NO CORRIENTE', 'Acreedor', 0, 2, 2, 0, 1, 67),
(112, '2201', 'PRESTAMOS POR PAGAR', 'Acreedor', 0, 3, 2, 1, 1, 111),
(113, '2202', 'DOCUMENTOS POR PAGAR', 'Acreedor', 0, 3, 2, 1, 1, 111),
(114, '2203', 'INGRESOS DIFERIDOS', 'Acreedor', 0, 3, 2, 1, 1, 111),
(115, '2204', 'PROVISION PARA OBLIGACIONES LABORALES', 'Acreedor', 0, 3, 2, 1, 1, 111),
(116, '2205', 'PASIVO POR IMPUESTO DE RENTA DIFERIDO', 'Acreedor', 0, 3, 2, 1, 1, 111),
(117, '3', 'PATRIMONIO', 'Acreedor', 0, 1, 3, 0, 1, NULL),
(118, '31', 'CAPITAL CONTABLE', 'Acreedor', 0, 2, 3, 0, 1, 117),
(119, '3101', 'CAPITAL SOCIAL', 'Acreedor', 0, 3, 3, 1, 1, 118),
(120, '3102', 'RESERVA LEGAL', 'Acreedor', 0, 3, 3, 1, 1, 118),
(121, '3103', 'UTILIDADES RETENIDAS', 'Acreedor', 0, 3, 3, 1, 1, 118),
(122, '3104', 'UTILIDAD DEL EJERCICIO', 'Acreedor', 0, 3, 3, 1, 1, 118),
(123, '3105R', 'PÃ‰RDIDAS', 'Deudor', 0, 3, 3, 0, 1, 118),
(124, '310501R', 'PÃ©rdidas acumuladas', 'Deudor', 0, 4, 3, 1, 1, 123),
(125, '310502R', 'PÃ©rdidas del presente ejercicio', 'Deudor', 0, 4, 3, 1, 1, 123),
(126, '4', 'CUENTAS DE RESULTADO ACREEDORAS', 'Deudor', 0, 1, 4, 0, 1, NULL),
(127, '41', 'COSTOS Y GASTOS DE OPERACION', 'Deudor', 0, 2, 4, 0, 1, 126),
(128, '4101', 'COMPRAS', 'Deudor', 0, 3, 4, 1, 1, 127),
(129, '4102', 'GASTOS SOBRE COMPRAS', 'Deudor', 0, 3, 4, 1, 1, 127),
(130, '4103', 'COSTO DE VENTA', 'Deudor', 0, 3, 4, 1, 1, 127),
(131, '42', 'GASTOS OPERATIVOS', 'Deudor', 0, 2, 4, 0, 1, 126),
(132, '4201', 'GASTOS DE ADMINISTRACION', 'Deudor', 0, 3, 4, 0, 1, 131),
(133, '420101', 'Sueldos y salarios', 'Deudor', 0, 4, 4, 1, 1, 132),
(134, '420102', 'Comisiones', 'Deudor', 0, 4, 4, 1, 1, 132),
(135, '420103', 'Vacaciones', 'Deudor', 0, 4, 4, 1, 1, 132),
(136, '420104', 'Bonificaciones', 'Deudor', 0, 4, 4, 1, 1, 132),
(137, '420105', 'Aguinaldos', 'Deudor', 0, 4, 4, 1, 1, 132),
(138, '420106', 'Horas extras', 'Deudor', 0, 4, 4, 1, 1, 132),
(139, '420107', 'ViÃ¡ticos', 'Deudor', 0, 4, 4, 1, 1, 132),
(140, '420108', 'Indemnizaciones', 'Deudor', 0, 4, 4, 1, 1, 132),
(141, '420109', 'Atenciones al personal', 'Deudor', 0, 4, 4, 1, 1, 132),
(142, '420110', 'ISSS (salud)', 'Deudor', 0, 4, 4, 1, 1, 132),
(143, '420111', 'ISSS (pensiÃ³n)', 'Deudor', 0, 4, 4, 1, 1, 132),
(144, '420112', 'AFP', 'Deudor', 0, 4, 4, 1, 1, 132),
(145, '420113', 'INSAFORP', 'Deudor', 0, 4, 4, 1, 1, 132),
(146, '420114', 'Honorarios', 'Deudor', 0, 4, 4, 1, 1, 132),
(147, '420115', 'Seguros', 'Deudor', 0, 4, 4, 1, 1, 132),
(148, '420116', 'Transportes', 'Deudor', 0, 4, 4, 1, 1, 132),
(149, '420117', 'Agua', 'Deudor', 0, 4, 4, 1, 1, 132),
(150, '420118', 'Comunicaciones', 'Deudor', 0, 4, 4, 1, 1, 132),
(151, '420119', 'EnergÃ­a elÃ©ctrica', 'Deudor', 0, 4, 4, 1, 1, 132),
(152, '420120', 'EstimaciÃ³n para cuentas incobrables', 'Deudor', 0, 4, 4, 1, 1, 132),
(153, '420121', 'PapelerÃ­a y Ãºtiles', 'Deudor', 0, 4, 4, 1, 1, 132),
(154, '420122', 'DepreciaciÃ³n', 'Deudor', 0, 4, 4, 1, 1, 132),
(155, '420123', 'Mantenimiento y reparaciÃ³n de mobiliario y equipo', 'Deudor', 0, 4, 4, 1, 1, 132),
(156, '420124', 'Mantenimiento y reparaciÃ³n de edificios', 'Deudor', 0, 4, 4, 1, 1, 132),
(157, '420125', 'Mantenimiento y reparaciones de equipo de reparto', 'Deudor', 0, 4, 4, 1, 1, 132),
(158, '420126', 'Publicidad', 'Deudor', 0, 4, 4, 1, 1, 132),
(159, '420127', 'Empaques', 'Deudor', 0, 4, 4, 1, 1, 132),
(160, '420128', 'Atenciones a clientes', 'Deudor', 0, 4, 4, 1, 1, 132),
(161, '420129', 'Multas', 'Deudor', 0, 4, 4, 1, 1, 132),
(162, '420130', 'Combustibles y lubricantes', 'Deudor', 0, 4, 4, 1, 1, 132),
(163, '420131', 'Impuestos municipales', 'Deudor', 0, 4, 4, 1, 1, 132),
(164, '420132', 'Inscripciones', 'Deudor', 0, 4, 4, 1, 1, 132),
(165, '420133', 'Limpiezas', 'Deudor', 0, 4, 4, 1, 1, 132),
(166, '420134', 'Alquileres', 'Deudor', 0, 4, 4, 1, 1, 132),
(167, '420135', 'Matriculas de comercio', 'Deudor', 0, 4, 4, 1, 1, 132),
(168, '420136', 'Donaciones y contribuciones', 'Deudor', 0, 4, 4, 1, 1, 132),
(169, '420137', 'Vigilancias', 'Deudor', 0, 4, 4, 1, 1, 132),
(170, '420138', 'Uniformes', 'Deudor', 0, 4, 4, 1, 1, 132),
(171, '420139', 'Amortizaciones', 'Deudor', 0, 4, 4, 1, 1, 132),
(172, '420140', 'Ornatos', 'Deudor', 0, 4, 4, 1, 1, 132),
(173, '420141', 'Otros', 'Deudor', 0, 4, 4, 1, 1, 132),
(174, '4202', 'GASTOS DE VENTAS', 'Deudor', 0, 3, 4, 0, 1, 131),
(175, '420201', 'Sueldos y salarios', 'Deudor', 0, 4, 4, 1, 1, 174),
(176, '4203', 'REBAJAS Y DEVOLUCIONES SOBRE VENTAS', 'Deudor', 0, 3, 4, 1, 1, 131),
(177, '4204', 'DESCUENTOS SOBRE VENTAS', 'Deudor', 0, 3, 4, 1, 1, 131),
(178, '43', 'GASTOS NO OPERATIVOS', 'Deudor', 0, 2, 4, 0, 1, 126),
(179, '4301', 'GASTOS FINANCIEROS', 'Deudor', 0, 3, 4, 0, 1, 178),
(180, '430101', 'Intereses', 'Deudor', 0, 4, 4, 1, 1, 179),
(181, '430102', 'Comisiones bancarias', 'Deudor', 0, 4, 4, 1, 1, 179),
(182, '430103', 'Diferencial cambiario', 'Deudor', 0, 4, 4, 1, 1, 179),
(183, '4302', 'PERDIDAS EN VENTA DE ACTIVO FIJO', 'Deudor', 0, 3, 4, 1, 1, 178),
(184, '4303', 'GASTOS POR IMPUESTOS', 'Deudor', 0, 3, 4, 1, 1, 178),
(185, '4304', 'OTROS GASTOS', 'Deudor', 0, 3, 4, 1, 1, 178),
(186, '5', 'CUENTAS DE RESULTADO ACREEDORAS', 'Acreedor', 0, 1, 5, 0, 1, NULL),
(187, '51', 'INGRESOS DE OPERACIÃ“N', 'Acreedor', 0, 2, 5, 0, 1, 186),
(188, '5101', 'VENTAS', 'Acreedor', 0, 3, 5, 1, 1, 187),
(189, '5102', 'REBAJAS Y DEVOLUCIONES SOBRE COMPRAS', 'Acreedor', 0, 3, 5, 1, 1, 187),
(190, '5103', 'DESCUENTOS SOBRE COMPRAS', 'Acreedor', 0, 3, 5, 1, 1, 187),
(191, '52', 'INGRESOS DE NO OPERACIÃ“N\'', 'Acreedor', 0, 2, 5, 0, 1, 186),
(192, '5201', 'INTERESES', 'Acreedor', 0, 3, 5, 1, 1, 191),
(193, '5202', 'UTILIDAD EN VENTA DE ACTIVO FIJO', 'Acreedor', 0, 3, 5, 1, 1, 191),
(194, '5203', 'OTROS INGRESOS', 'Acreedor', 0, 3, 5, 1, 1, 191),
(195, '5204', 'INGRESO POR IMPUESTO DE RENTA DIFERIDO', 'Acreedor', 0, 3, 5, 1, 1, 191),
(196, '6', 'CUENTA DE CIERRE', 'Acreedor', 0, 1, 6, 0, 1, NULL),
(197, '61', 'CUENTA LIQUIDADORA', 'Acreedor', 0, 2, 6, 0, 1, 196),
(198, '6101', 'PÃ‰RDIDAS Y GANANCIAS', 'Acreedor', 0, 3, 6, 1, 1, 197),
(199, '420202', 'Comisiones', 'Deudor', 0, 4, 4, 1, 1, 174),
(200, '420203', 'Vacaciones', 'Deudor', 0, 4, 4, 1, 1, 174),
(201, '420204', 'Bonificaciones', 'Deudor', 0, 4, 4, 1, 1, 174),
(202, '420205', 'Aguinaldos', 'Deudor', 0, 4, 4, 1, 1, 174),
(203, '420206', 'Horas extras', 'Deudor', 0, 4, 4, 1, 1, 174),
(204, '420207', 'ViÃ¡ticos', 'Deudor', 0, 4, 4, 1, 1, 174),
(205, '420208', 'Indemnizaciones', 'Deudor', 0, 4, 4, 1, 1, 174),
(206, '420209', 'Atenciones al personal', 'Deudor', 0, 4, 4, 1, 1, 174),
(207, '420210', 'ISSS (salud)', 'Deudor', 0, 4, 4, 1, 1, 174),
(208, '420211', 'ISSS (pensiÃ³n)', 'Deudor', 0, 4, 4, 1, 1, 174),
(209, '420212', 'AFP', 'Deudor', 0, 4, 4, 1, 1, 174),
(210, '420213', 'INSAFORP', 'Deudor', 0, 4, 4, 1, 1, 174),
(211, '420214', 'Honorarios', 'Deudor', 0, 4, 4, 1, 1, 174),
(212, '420215', 'Seguros', 'Deudor', 0, 4, 4, 1, 1, 174),
(213, '420216', 'Transportes', 'Deudor', 0, 4, 4, 1, 1, 174),
(214, '420217', 'Agua', 'Deudor', 0, 4, 4, 1, 1, 174),
(215, '420218', 'Comunicaciones', 'Deudor', 0, 4, 4, 1, 1, 174),
(216, '420219', 'EnergÃ­a elÃ©ctrica', 'Deudor', 0, 4, 4, 1, 1, 174),
(217, '420220', 'EstimaciÃ³n para cuentas incobrables', 'Deudor', 0, 4, 4, 1, 1, 174),
(218, '420221', 'PapelerÃ­a y Ãºtiles', 'Deudor', 0, 4, 4, 1, 1, 174),
(219, '420222', 'DepreciaciÃ³n', 'Deudor', 0, 4, 4, 1, 1, 174),
(220, '420223', 'Mantenimiento y reparaciÃ³n de mobiliario y equipo', 'Deudor', 0, 4, 4, 1, 1, 174),
(221, '420224', 'Mantenimiento y reparaciÃ³n de edificios', 'Deudor', 0, 4, 4, 1, 1, 174),
(222, '420225', 'Mantenimiento y reparaciones de equipo de reparto', 'Deudor', 0, 4, 4, 1, 1, 174),
(223, '420226', 'Publicidad', 'Deudor', 0, 4, 4, 1, 1, 174),
(224, '420227', 'Empaques', 'Deudor', 0, 4, 4, 1, 1, 174),
(225, '420228', 'Atenciones a clientes', 'Deudor', 0, 4, 4, 1, 1, 174),
(226, '420229', 'Multas', 'Deudor', 0, 4, 4, 1, 1, 174),
(227, '420230', 'Combustibles y lubricantes', 'Deudor', 0, 4, 4, 1, 1, 174),
(228, '420231', 'Impuestos municipales', 'Deudor', 0, 4, 4, 1, 1, 174),
(229, '420232', 'Inscripciones', 'Deudor', 0, 4, 4, 1, 1, 174),
(230, '420233', 'Limpiezas', 'Deudor', 0, 4, 4, 1, 1, 174),
(231, '420234', 'Alquileres', 'Deudor', 0, 4, 4, 1, 1, 174),
(232, '420235', 'Matriculas de comercio', 'Deudor', 0, 4, 4, 1, 1, 174),
(233, '420236', 'Donaciones y contribuciones', 'Deudor', 0, 4, 4, 1, 1, 174),
(234, '420237', 'Vigilancias', 'Deudor', 0, 4, 4, 1, 1, 174),
(235, '420238', 'Uniformes', 'Deudor', 0, 4, 4, 1, 1, 174),
(236, '420239', 'Amortizaciones', 'Deudor', 0, 4, 4, 1, 1, 174),
(237, '420240', 'Ornatos', 'Deudor', 0, 4, 4, 1, 1, 174),
(238, '420241', 'Otros', 'Deudor', 0, 4, 4, 1, 1, 174),
(239, '1', 'Activo', 'Deudor', 19976983.56, 1, 1, 0, 2, NULL),
(240, '2', 'Pasivo', 'Acreedor', 5027533.7, 1, 2, 0, 2, NULL),
(241, '3', 'Capital', 'Acreedor', 14166500, 1, 3, 0, 2, NULL),
(242, '11', 'Corriente', 'Deudor', 10321183.56, 2, 1, 0, 2, 239),
(243, '12', 'No Corriente', 'Deudor', 9655800, 2, 1, 0, 2, 239),
(244, '21', 'Corriente', 'Acreedor', 4311533.7, 2, 2, 0, 2, 240),
(245, '22', 'No Corriente', 'Acreedor', 716000, 2, 2, 0, 2, 240),
(246, '31', 'Capital Contable', 'Acreedor', 14166500, 2, 3, 0, 2, 241),
(247, '1101', 'Caja', 'Deudor', 21100, 3, 1, 1, 2, 242),
(248, '1102', 'Banco', 'Deudor', 2121961.8499999996, 3, 1, 1, 2, 242),
(249, '1103', 'Cuentas por Cobrar', 'Deudor', 1498896.31, 3, 1, 1, 2, 242),
(250, '1104', 'Deudores Diversos', 'Deudor', 68900, 3, 1, 1, 2, 242),
(251, '1105', 'Inventario', 'Deudor', 6550000, 3, 1, 1, 2, 242),
(252, '1201', 'Primas de seguro', 'Deudor', 62000, 3, 1, 1, 2, 243),
(253, '1202', 'Inversiones Permanentes', 'Deudor', 580000, 3, 1, 1, 2, 243),
(254, '1203', 'Equipo de Computo', 'Deudor', 340000, 3, 1, 1, 2, 243),
(255, '1204', 'Papeleria y Utiles', 'Deudor', 175000, 3, 1, 1, 2, 243),
(256, '1205', 'Terrenos', 'Deudor', 2800000, 3, 1, 1, 2, 243),
(257, '1206', 'Gastos de instalacion', 'Deudor', 195000, 3, 1, 1, 2, 243),
(258, '1207', 'Edificios', 'Deudor', 4500000, 3, 1, 1, 2, 243),
(259, '1208', 'Equipo de Oficina', 'Deudor', 985000, 3, 1, 1, 2, 243),
(260, '1209', 'Depositos en Garantia', 'Deudor', 10500, 3, 1, 1, 2, 243),
(261, '2101', 'Proveedores', 'Acreedor', 3045012.27, 3, 2, 1, 2, 244),
(262, '2102', 'Renta Cobradas por Anticipado', 'Acreedor', 105000, 3, 2, 1, 2, 244),
(263, '2103', 'Intereses Cobrados por Anticiado', 'Acreedor', 150000, 3, 2, 1, 2, 244),
(264, '2104', 'Acreedores Diversos', 'Acreedor', 850000, 3, 2, 1, 2, 244),
(265, '2201', 'Hipotecas por Pagar', 'Acreedor', 199000, 3, 2, 1, 2, 245),
(266, '2202', 'Gastos Acumulados por Pagar', 'Acreedor', 42000, 3, 2, 1, 2, 245),
(267, '2203', 'Documentos por Pagar Largo Plazo', 'Acreedor', 475000, 3, 2, 1, 2, 245),
(268, '3101', 'Capital Social', 'Acreedor', 14166500, 3, 3, 1, 2, 246),
(270, '2105', 'Documentos por Pagar', 'Acreedor', 1750, 3, 2, 1, 2, 244),
(271, '1210', 'Patentes', 'Deudor', 8300, 3, 1, 1, 2, 243),
(272, '1106', 'IVA Credito Fiscal', 'Deudor', 58425.399999999994, 3, 1, 1, 2, 242),
(273, '2106', 'IVA Debito Fiscal', 'Acreedor', 159771.43, 3, 2, 1, 2, 244),
(274, '1107R', 'Provicion para Cuentas Incobrables', 'Acreedor', 1900, 3, 1, 1, 2, 242),
(275, '4', 'Cuentas de Resultado Acreedoras', 'Acreedor', 1262954.86, 1, 4, 0, 2, NULL),
(276, '41', 'Ingresos de Operacion', 'Acreedor', 1254779.86, 2, 4, 0, 2, 275),
(277, '4101', 'Ventas', 'Acreedor', 1239624, 3, 4, 1, 2, 276),
(278, '5', 'Cuentas de Resultado Deudoras', 'Deudor', 483805, 1, 5, 0, 2, NULL),
(279, '51', 'Costos Operacion', 'Deudor', 433438, 2, 5, 0, 2, 278),
(280, '5101', 'Compras', 'Deudor', 416325, 3, 5, 1, 2, 279),
(281, '42', 'Otros Productos', 'Acreedor', 8175, 2, 4, 0, 2, 275),
(282, '4201', 'Intereses Cobrados', 'Acreedor', 8175, 3, 4, 1, 2, 281),
(283, '4102', 'Rebajas y Devoluciones sobre Compras', 'Acreedor', 15155.86, 3, 4, 1, 2, 276),
(284, '5102', 'Rebajas y Devoluciones sobre Ventas', 'Deudor', 10613, 3, 5, 1, 2, 279),
(285, '5103', 'Gastos sobre Compras', 'Deudor', 6500, 3, 5, 1, 2, 279),
(286, '52', 'Gastos de Operaciones', 'Deudor', 42457, 2, 5, 0, 2, 278),
(287, '5201', 'Gastos de Administarcion', 'Deudor', 11067, 3, 5, 1, 2, 286),
(288, '5202', 'Gastos de Venta', 'Deudor', 29565, 3, 5, 1, 2, 286),
(289, '5203', 'Gastos de Financieros', 'Deudor', 1825, 3, 5, 1, 2, 286),
(290, '53', 'Otros Gastos', 'Deudor', 7910, 2, 5, 0, 2, 278),
(291, '5301', 'Otros Gastos', 'Deudor', 7910, 3, 5, 1, 2, 290);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_partida`
--

CREATE TABLE `detalle_partida` (
  `cuenta` int(11) NOT NULL,
  `partida` int(11) NOT NULL,
  `movimiento` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'cargo ó abono',
  `monto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `detalle_partida`
--

INSERT INTO `detalle_partida` (`cuenta`, `partida`, `movimiento`, `monto`) VALUES
(247, 11, 'Cargo', 25000),
(248, 11, 'Cargo', 2300000),
(251, 11, 'Cargo', 6550000),
(255, 11, 'Cargo', 175000),
(249, 11, 'Cargo', 290000),
(252, 11, 'Cargo', 62000),
(250, 11, 'Cargo', 65000),
(260, 11, 'Cargo', 10500),
(256, 11, 'Cargo', 2800000),
(258, 11, 'Cargo', 4500000),
(259, 11, 'Cargo', 985000),
(254, 11, 'Cargo', 340000),
(253, 11, 'Cargo', 580000),
(257, 11, 'Cargo', 195000),
(262, 11, 'Abono', 105000),
(263, 11, 'Abono', 150000),
(266, 11, 'Abono', 42000),
(261, 11, 'Abono', 2890000),
(264, 11, 'Abono', 850000),
(265, 11, 'Abono', 199000),
(267, 11, 'Abono', 475000),
(268, 11, 'Abono', 14166500),
(249, 12, 'Cargo', 1299500),
(277, 12, 'Abono', 1150000),
(273, 12, 'Abono', 149500),
(280, 13, 'Cargo', 375000),
(272, 13, 'Cargo', 48750),
(248, 13, 'Abono', 254250),
(261, 13, 'Abono', 169500),
(285, 14, 'Cargo', 6500),
(272, 14, 'Cargo', 845),
(248, 14, 'Abono', 7345),
(288, 15, 'Cargo', 7250),
(274, 15, 'Abono', 7250),
(284, 16, 'Cargo', 7800),
(273, 16, 'Cargo', 1014),
(249, 16, 'Abono', 8814),
(261, 17, 'Cargo', 9842.3),
(283, 17, 'Abono', 8710),
(272, 17, 'Abono', 1132.3),
(280, 18, 'Cargo', 41325),
(272, 18, 'Cargo', 5372.25),
(261, 18, 'Abono', 46697.25),
(261, 19, 'Cargo', 46697.25),
(248, 19, 'Abono', 44058.86),
(283, 19, 'Abono', 2334.86),
(272, 19, 'Abono', 303.53),
(291, 20, 'Cargo', 7910),
(277, 20, 'Abono', 7000),
(273, 20, 'Abono', 910),
(261, 21, 'Cargo', 4645.43),
(283, 21, 'Abono', 4111),
(272, 21, 'Abono', 534.43),
(271, 22, 'Cargo', 8300),
(272, 22, 'Cargo', 1079),
(248, 22, 'Abono', 9379),
(274, 23, 'Cargo', 5350),
(249, 23, 'Abono', 5350),
(248, 24, 'Cargo', 93365.12),
(277, 24, 'Abono', 82624),
(273, 24, 'Abono', 10741.12),
(284, 25, 'Cargo', 2813),
(273, 25, 'Cargo', 365.69),
(249, 25, 'Abono', 3178.69),
(248, 26, 'Cargo', 73261),
(249, 26, 'Abono', 73261),
(288, 27, 'Cargo', 22315),
(272, 27, 'Cargo', 2900.95),
(248, 27, 'Abono', 25215.95),
(287, 28, 'Cargo', 9317),
(272, 28, 'Cargo', 1211.21),
(248, 28, 'Abono', 10528.21),
(289, 29, 'Cargo', 1825),
(272, 29, 'Cargo', 237.25),
(248, 29, 'Cargo', 8175),
(248, 29, 'Abono', 2062.25),
(282, 29, 'Abono', 8175),
(287, 30, 'Cargo', 1750),
(270, 30, 'Abono', 1750),
(250, 31, 'Cargo', 3900),
(247, 31, 'Abono', 3900);

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
(2, 'beer', 'admin123', 'admin123');

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
(11, 1, 'partida 1', '2020-10-10 00:00:00', 0, 2),
(12, 2, 'partido 2', '2020-10-10 00:00:00', 0, 2),
(13, 3, 'partida 3', '2020-10-10 00:00:00', 0, 2),
(14, 4, 'partida 4', '2020-10-10 00:00:00', 0, 2),
(15, 5, 'partida 5', '2020-10-10 00:00:00', 0, 2),
(16, 6, 'partida 6', '2020-10-10 00:00:00', 0, 2),
(17, 7, 'partida', '2020-10-10 00:00:00', 0, 2),
(18, 8, 'partida 8', '2020-10-10 00:00:00', 0, 2),
(19, 9, 'partida 9', '2020-10-10 00:00:00', 0, 2),
(20, 10, 'partida 10', '2020-10-10 00:00:00', 0, 2),
(21, 11, 'partida 11', '2020-10-10 00:00:00', 0, 2),
(22, 12, 'partida 12', '2020-10-10 00:00:00', 0, 2),
(23, 13, 'partida 13', '2020-10-10 00:00:00', 0, 2),
(24, 14, 'partida 14', '2020-10-10 00:00:00', 0, 2),
(25, 15, 'partida 15', '2020-10-10 00:00:00', 0, 2),
(26, 16, 'partida 16', '2020-10-10 00:00:00', 0, 2),
(27, 17, 'partida 17', '2020-10-10 00:00:00', 0, 2),
(28, 18, 'partida 18', '2020-10-10 00:00:00', 0, 2),
(29, 19, 'partida 19', '2020-10-10 00:00:00', 0, 2),
(30, 20, 'partida 20', '2020-10-10 00:00:00', 0, 2),
(31, 21, 'partida 21', '2020-10-10 00:00:00', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `periodo`
--

CREATE TABLE `periodo` (
  `id` int(11) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `anio` year(4) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `periodo`
--

INSERT INTO `periodo` (`id`, `estado`, `anio`, `empresa`) VALUES
(1, 1, 2020, 1),
(2, 1, 2020, 2);

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
  ADD KEY `fk_CUENTAS_CUENTAS1_idx` (`padre`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `fk_CONFIGURACION_CUENTAS1` FOREIGN KEY (`cuenta`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CONFIGURACION_PERIODOS1` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `fk_CUENTAS_CUENTAS1` FOREIGN KEY (`padre`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cuenta_empresa` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_partida`
--
ALTER TABLE `detalle_partida`
  ADD CONSTRAINT `fk_CUENTAS_has_PARTIDA_CUENTAS1` FOREIGN KEY (`cuenta`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CUENTAS_has_PARTIDA_PARTIDA1` FOREIGN KEY (`partida`) REFERENCES `partida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `fk_PARTIDA_PERIODOS1` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `periodo`
--
ALTER TABLE `periodo`
  ADD CONSTRAINT `fk_PERIODOS_EMPRESA1` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

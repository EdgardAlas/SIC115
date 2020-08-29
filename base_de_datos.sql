-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para sic175
CREATE DATABASE IF NOT EXISTS `sic175` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `sic175`;

-- Volcando estructura para tabla sic175.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo_configuracion` text COLLATE utf8_spanish_ci NOT NULL,
  `periodo` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_CONFIGURACION_PERIODOS1_idx` (`periodo`),
  KEY `fk_CONFIGURACION_CUENTAS1_idx` (`cuenta`),
  CONSTRAINT `fk_CONFIGURACION_CUENTAS1` FOREIGN KEY (`cuenta`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CONFIGURACION_PERIODOS1` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla sic175.configuracion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla sic175.cuenta
CREATE TABLE IF NOT EXISTS `cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo_saldo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `saldo` double DEFAULT '0',
  `nivel` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `ultimo_nivel` tinyint(4) DEFAULT '1',
  `empresa` int(11) NOT NULL,
  `padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_empresa_idx` (`empresa`),
  KEY `fk_CUENTAS_CUENTAS1_idx` (`padre`),
  CONSTRAINT `fk_CUENTAS_CUENTAS1` FOREIGN KEY (`padre`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_empresa` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla sic175.cuenta: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `cuenta` DISABLE KEYS */;
INSERT INTO `cuenta` (`id`, `codigo`, `nombre`, `tipo_saldo`, `saldo`, `nivel`, `orden`, `ultimo_nivel`, `empresa`, `padre`) VALUES
	(9, '1', 'Activo', 'Deudor', 0, 1, 1, 1, 1, NULL);
/*!40000 ALTER TABLE `cuenta` ENABLE KEYS */;

-- Volcando estructura para tabla sic175.detalle_partida
CREATE TABLE IF NOT EXISTS `detalle_partida` (
  `cuenta` int(11) NOT NULL,
  `partida` int(11) NOT NULL,
  `movimiento` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'cargo ó abono',
  `monto` double NOT NULL,
  KEY `fk_CUENTAS_has_PARTIDA_PARTIDA1_idx` (`partida`),
  KEY `fk_CUENTAS_has_PARTIDA_CUENTAS1_idx` (`cuenta`),
  CONSTRAINT `fk_CUENTAS_has_PARTIDA_CUENTAS1` FOREIGN KEY (`cuenta`) REFERENCES `cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CUENTAS_has_PARTIDA_PARTIDA1` FOREIGN KEY (`partida`) REFERENCES `partida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla sic175.detalle_partida: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `detalle_partida` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_partida` ENABLE KEYS */;

-- Volcando estructura para tabla sic175.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla sic175.empresa: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` (`id`, `nombre`, `usuario`, `contrasena`) VALUES
	(1, 'Empresa X', 'user12345', '12345678');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;

-- Volcando estructura para tabla sic175.partida
CREATE TABLE IF NOT EXISTS `partida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `descripcion` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `partida_cierre` tinyint(4) DEFAULT '0',
  `periodo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_PARTIDA_PERIODOS1_idx` (`periodo`),
  CONSTRAINT `fk_PARTIDA_PERIODOS1` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla sic175.partida: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `partida` DISABLE KEYS */;
/*!40000 ALTER TABLE `partida` ENABLE KEYS */;

-- Volcando estructura para tabla sic175.periodo
CREATE TABLE IF NOT EXISTS `periodo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` tinyint(4) NOT NULL,
  `anio` year(4) NOT NULL,
  `empresa` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_PERIODOS_EMPRESA1_idx` (`empresa`),
  CONSTRAINT `fk_PERIODOS_EMPRESA1` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla sic175.periodo: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `periodo` DISABLE KEYS */;
INSERT INTO `periodo` (`id`, `estado`, `anio`, `empresa`) VALUES
	(1, 1, '2020', 1);
/*!40000 ALTER TABLE `periodo` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

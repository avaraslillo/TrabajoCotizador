-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-09-2017 a las 04:00:04
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cotizadorbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE IF NOT EXISTS `imagen` (
  `ID_IMAGEN` int(11) NOT NULL AUTO_INCREMENT,
  `ORDEN_IMAGEN` int(11) NOT NULL,
  `RUTA_IMAGEN` text NOT NULL,
  `ID_MOVIL` int(11) NOT NULL,
  PRIMARY KEY (`ID_IMAGEN`),
  KEY `ID_MOVIL` (`ID_MOVIL`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`ID_IMAGEN`, `ORDEN_IMAGEN`, `RUTA_IMAGEN`, `ID_MOVIL`) VALUES
(6, 1, '../CotizadorOnline/imagenes/imagenes_moviles/Samsung Galaxy S7 Edge/galaxy-s7-front-gold.jpg', 27),
(7, 1, '../CotizadorOnline/imagenes/imagenes_moviles/LG X Style/lg-x-style-front.jpg', 29),
(13, 1, '../CotizadorOnline/imagenes/imagenes_moviles/Huawei P10/p10-listimage-black.png', 31),
(20, 1, '../CotizadorOnline/imagenes/imagenes_moviles/iPhone 7 32 GB/iphone7-32gb-front.jpg', 35),
(22, 1, '../CotizadorOnline/imagenes/imagenes_moviles/moto-g-play.jpg', 37),
(24, 1, '../CotizadorOnline/imagenes/imagenes_moviles/Samsung Galaxy J1 Ace/galaxy-j1-ace-front-black.jpg', 39),
(50, 1, '../CotizadorOnline/imagenes/imagenes_moviles/Nokia 5 Black/nokia-5-black-front.jpg', 65),
(51, 3, '../CotizadorOnline/imagenes/imagenes_moviles/LG X Style/lg-x-style-back.jpg', 29),
(52, 4, '../CotizadorOnline/imagenes/imagenes_moviles/LG X Style/lg-x-style-side-right.jpg', 29),
(53, 2, '../CotizadorOnline/imagenes/imagenes_moviles/LG X Style/lg-x-style-left-side.jpg', 29),
(54, 1, '../CotizadorOnline/imagenes/imagenes_moviles/Moto Z Play/moto z play front.jpg', 66),
(55, 2, '../CotizadorOnline/imagenes/imagenes_moviles/Moto Z Play/Motorola-Moto-Z-Play-White-Left-Side.jpg\n', 66),
(56, 3, '../CotizadorOnline/imagenes/imagenes_moviles/Moto Z Play/moto z play back.jpg', 66),
(57, 4, '../CotizadorOnline/imagenes/imagenes_moviles/Moto Z Play/moto z play right.jpg', 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE IF NOT EXISTS `marca` (
  `ID_MARCA` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_MARCA`),
  KEY `ID_MARCA` (`ID_MARCA`),
  KEY `ID_MARCA_2` (`ID_MARCA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`ID_MARCA`) VALUES
('Apple'),
('Huawei'),
('LG'),
('Motorola'),
('Nokia'),
('Samsung');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movil`
--

CREATE TABLE IF NOT EXISTS `movil` (
  `ID_MOVIL` int(15) NOT NULL AUTO_INCREMENT,
  `MARCA` varchar(30) NOT NULL,
  `MODELO` varchar(30) NOT NULL,
  `TAMANO_PANTALLA` varchar(50) NOT NULL,
  `SISTEMA_OPERATIVO` varchar(20) NOT NULL,
  `CAMARA_TRASERA` varchar(25) NOT NULL,
  `CAMARA_FRONTAL` varchar(25) NOT NULL,
  `PROCESADOR` varchar(60) NOT NULL,
  `MEMORIA_INTERNA` varchar(60) NOT NULL,
  `EXPANSION_DE_MEMORIA` tinyint(1) NOT NULL,
  `PESO` float NOT NULL,
  `CON_2G` tinyint(1) NOT NULL,
  `CON_3G` tinyint(1) NOT NULL,
  `CON_4G` tinyint(1) NOT NULL,
  `BATERIA` float NOT NULL,
  PRIMARY KEY (`ID_MOVIL`),
  KEY `ID_MOVIL` (`ID_MOVIL`),
  KEY `ID_MOVIL_2` (`ID_MOVIL`),
  KEY `ID_MOVIL_3` (`ID_MOVIL`),
  KEY `MARCA` (`MARCA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Volcado de datos para la tabla `movil`
--

INSERT INTO `movil` (`ID_MOVIL`, `MARCA`, `MODELO`, `TAMANO_PANTALLA`, `SISTEMA_OPERATIVO`, `CAMARA_TRASERA`, `CAMARA_FRONTAL`, `PROCESADOR`, `MEMORIA_INTERNA`, `EXPANSION_DE_MEMORIA`, `PESO`, `CON_2G`, `CON_3G`, `CON_4G`, `BATERIA`) VALUES
(27, 'Samsung', 'Samsung Galaxy S7 Edge', '5.5 Pulgadas', 'android', '12 MP', '5 MP', 'Qualcomm Snapdragon 820', '32 GB', 1, 152, 1, 1, 1, 3600),
(29, 'LG', 'LG X Style', '5 Pulgadas', 'android', '8 MP', '5 MP', 'Quad-Core 1.3 GHz', '16 GB', 1, 121, 1, 1, 1, 2100),
(31, 'Huawei', 'Huawei P10', '5.1 Pulgadas', 'android', '12 MP + 20 MP', '8 MP', 'HUAWEI Kirin 960', '32 GB', 1, 145, 1, 1, 1, 3200),
(35, 'Apple', 'iPhone 7 32GB', '4.7 Pulgadas', 'ios', '12 MP', '7 MP', 'Chip A10 Fusion de 64 bits con procesador M10 integrado', '32 GB', 0, 138, 1, 1, 1, 1960),
(37, 'Motorola', 'Moto G 4ta Generacion Play', '5 Pulgadas', 'android', '8 MP', '5 MP', 'QC Snapdragon Octa-Core 1.5 GhZ', '16 GB', 1, 137, 1, 1, 1, 2800),
(39, 'Samsung', 'Samsung Galaxy J1 Ace', '4.3 Pulgadas', 'android', '5 MP', '2 MP', 'Quad-Core 1.5 GHz', '8 GB', 1, 131, 1, 1, 1, 1900),
(65, 'Nokia', 'Nokia 5 Black', '5.2 Pulgadas', 'android', '13 MP', '8 MP', 'Octa Core 4x1,4 GHz + 4x1,1 GHz', '16 GB', 1, 155, 1, 1, 1, 3000),
(66, 'Motorola', 'Moto Z Play', '5.5 Pulgadas', 'android', '16 MP', '5 MP', 'Octa-core Qualcomm Snapdragon 625 de 2 GHz', '32 GB', 1, 165, 1, 1, 1, 3510);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion_tm`
--

CREATE TABLE IF NOT EXISTS `relacion_tm` (
  `ID_MOVIL` int(15) NOT NULL,
  `ID_TIENDA` int(15) NOT NULL,
  `ENLACE_PT` text NOT NULL,
  `PRECIO_CLP` int(11) DEFAULT NULL,
  `PRECIO_EUR` float DEFAULT NULL,
  KEY `ID_MOVIL` (`ID_MOVIL`),
  KEY `ID_TIENDA` (`ID_TIENDA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relacion_tm`
--

INSERT INTO `relacion_tm` (`ID_MOVIL`, `ID_TIENDA`, `ENLACE_PT`, `PRECIO_CLP`, `PRECIO_EUR`) VALUES
(65, 1, 'http://www.falabella.com/falabella-cl/product/5906413/Nokia-5-Black-Movistar', 169990, NULL),
(27, 1, 'http://www.falabella.com/falabella-cl/product/4971748/Smartphone-Galaxy-S7Edge-32GB-Dorado-Liberado', 599990, NULL),
(27, 2, 'https://simple.ripley.cl/samsung-galaxy-s7-edge-plateado-2000357230035p', 559990, NULL),
(29, 1, 'http://www.falabella.com/falabella-cl/product/5720832/Smartphone-Entel-Xstyle-Negro/5720832', 79990, NULL),
(29, 4, 'https://www.abcdin.cl/tienda/es/abcdin/celular-lg-x-style-entel-1112159', 79990, NULL),
(31, 1, 'http://www.falabella.com/falabella-cl/product/5639122/Smartphone-P10-Negro-Liberado', 499990, NULL),
(31, 2, 'https://simple.ripley.cl/huawei-p10-negro-51-2000362921799p', 499990, NULL),
(31, 3, 'https://www.paris.cl/tienda/es/paris/smartphone-huawei-p10-liberado-5-1-dorado-138594-ppp-', 499990, NULL),
(35, 1, 'http://www.falabella.com/falabella-cl/product/5311494/iPhone-7-32GB-Negro-Mate-Liberado', 649990, NULL),
(35, 2, 'https://simple.ripley.cl/iphone-7-32gb-negro-movistar-47-2000364122910p', 699990, NULL),
(35, 3, 'https://www.paris.cl/tienda/es/paris/iphone-7-32gb-negro-liberado-954134-ppp-', 649990, NULL),
(29, 2, 'https://simple.ripley.cl/lg-xstyle-entel-5-2000360578384p', 99990, NULL),
(39, 1, 'http://www.falabella.com/falabella-cl/product/4771874/Smartphone-Galaxy-J1-Ace-LTE-Blanco-WOM', 99990, NULL),
(39, 2, 'https://simple.ripley.cl/samsung-galaxy-j1-ace-negro-43-2000362163618p', 99990, NULL),
(39, 4, 'https://www.abcdin.cl/tienda/ProductDisplay?urlRequestType=Base&productId=46501&catalogId=10001&categoryId=24553&errorViewName=ProductDisplayErrorView&urlLangId=-1000&langId=-1000&top_category=&parent_category_rn=&storeId=10001', 79990, NULL),
(37, 2, 'https://simple.ripley.cl/motorola-moto-g-4ta-generacion-play-negro-wom-5-2000362741267p', 99990, NULL),
(37, 3, 'https://www.paris.cl/tienda/es/paris/smartphone-motorola-g4-play-negro-5-wom-935767-ppp-', 149990, NULL),
(66, 1, 'http://www.falabella.com/falabella-cl/product/5223656/Smartphone-Moto-Z-Play-Negro-+-JBL-Liberado', 549990, NULL),
(66, 2, 'https://simple.ripley.cl/motorola-moto-z-play-black-silver-55-2000360382561p', 499990, NULL),
(66, 4, 'https://www.abcdin.cl/tienda/es/abcdin/celular-motorola-moto-z-play-1116988', 299990, NULL),
(66, 6, 'https://www.pcfactory.cl/producto=23798-Smartphone_Moto_Z_Play_Octa_Core_32GB_5_5__4G_Android_6_0_Black_Silver_Liberado', 399990, NULL),
(27, 3, 'https://www.paris.cl/tienda/es/paris/smartphone-samsung-galaxy-s7-edge-azul-5-5-liberado-129093-ppp-', 549990, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE IF NOT EXISTS `tienda` (
  `ID_TIENDA` int(15) NOT NULL AUTO_INCREMENT,
  `NOMBRE_TIENDA` varchar(30) NOT NULL,
  `DIRECCION_URL` text NOT NULL,
  PRIMARY KEY (`ID_TIENDA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`ID_TIENDA`, `NOMBRE_TIENDA`, `DIRECCION_URL`) VALUES
(1, 'Falabella', 'http://www.falabella.com/falabella-cl/'),
(2, 'Ripley', 'https://simple.ripley.cl/'),
(3, 'Paris', 'https://www.paris.cl/tienda/es/paris'),
(4, 'ABC DIN', 'https://www.abcdin.cl/'),
(5, 'La Polar', 'https://www.lapolar.cl/internet'),
(6, 'PC Factory ', 'https://www.pcfactory.cl/'),
(7, 'Hites', 'https://www.hites.com/tienda/es/hites'),
(8, 'Linio', 'https://www.linio.cl/');

--
-- Disparadores `tienda`
--
DROP TRIGGER IF EXISTS `trigger_tienda`;
DELIMITER //
CREATE TRIGGER `trigger_tienda` BEFORE INSERT ON `tienda`
 FOR EACH ROW BEGIN
  DECLARE next_id INT;

  SET next_id = (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='tienda');
  SET NEW.ID_TIENDA = CONCAT('TI', LPAD(next_id, 8, '0'));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `USER` varchar(30) NOT NULL,
  `PASS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`USER`, `PASS`) VALUES
('a.varaslillo', 'killswitch');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`ID_MOVIL`) REFERENCES `movil` (`ID_MOVIL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movil`
--
ALTER TABLE `movil`
  ADD CONSTRAINT `movil_ibfk_1` FOREIGN KEY (`MARCA`) REFERENCES `marca` (`ID_MARCA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `relacion_tm`
--
ALTER TABLE `relacion_tm`
  ADD CONSTRAINT `relacion_tm_ibfk_3` FOREIGN KEY (`ID_MOVIL`) REFERENCES `movil` (`ID_MOVIL`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relacion_tm_ibfk_4` FOREIGN KEY (`ID_TIENDA`) REFERENCES `tienda` (`ID_TIENDA`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

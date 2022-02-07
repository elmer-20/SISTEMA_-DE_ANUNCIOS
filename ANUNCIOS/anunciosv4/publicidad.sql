-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-12-2018 a las 03:56:38
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `publicidad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `idAnuncio` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `idUsuario` int(11) NOT NULL,
  `contenido` text COLLATE utf8_unicode_ci NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncio`, `titulo`, `imagen`, `fecha`, `idUsuario`, `contenido`, `idCategoria`) VALUES
(19, 'Elantra año 2015', '../../admin/anuncios/imagenes/530828_7226285.jpg', '2018-12-19 14:26:45', 3, '<ul>\r\n	<li>Motor: 1600</li>\r\n	<li>Precio: S/ 20000</li>\r\n	<li>Color: Blanco</li>\r\n	<li>Full equipo</li>\r\n	<li>Recorrido 36000 KM</li>\r\n</ul>\r\n', 1),
(20, 'Laptop toshiba core i5', '../../admin/anuncios/imagenes/48411079_2117340358311923_5358175875915317248_n.jpg', '2018-12-19 14:28:00', 3, '<p>Remato laptop</p>\r\n\r\n<ul>\r\n	<li>Marca: Toshiba</li>\r\n	<li>Generacion: 6ta generaci&oacute;n</li>\r\n	<li>Ocho Nucleos</li>\r\n	<li>Memoria: 8gb</li>\r\n</ul>\r\n', 3),
(21, 'Conjunto de buzo Adidas', '../../admin/anuncios/imagenes/48388427_1269716633176209_9764217305432064_n.jpg', '2018-12-19 14:30:47', 3, '<p>Remato buzos, existen diferentes colores</p>\r\n\r\n<ul>\r\n	<li>Precio negociable: S/ 270</li>\r\n	<li>Colores: negro, blanco, plomo</li>\r\n	<li>Tallas: M, L, S</li>\r\n</ul>\r\n', 9),
(22, 'Zapatillas Nike', '../../admin/anuncios/imagenes/48391840_2350976478249853_6967462149920653312_n.jpg', '2018-12-19 14:32:00', 3, '<p>Remato zapatillas</p>\r\n\r\n<ul>\r\n	<li>Marca: Adidas</li>\r\n	<li>Precio: S/ 250</li>\r\n	<li>Colores:&nbsp; Negro, plomo, blanco</li>\r\n</ul>\r\n', 9),
(23, 'Samsung Galaxy S8', '../../admin/anuncios/imagenes/48388987_214419449477981_4369644446426333184_n.jpg', '2018-12-19 14:34:05', 3, '<ul>\r\n	<li>Marca: Samsung</li>\r\n	<li>Color: Plomo</li>\r\n	<li>Modelo: Galaxy S8</li>\r\n	<li>Bateria: 3600 mA</li>\r\n	<li>Detector de huella digital</li>\r\n	<li>C&aacute;mara: 16px</li>\r\n	<li>Precio: S/ 1200</li>\r\n</ul>\r\n', 5),
(24, 'Camioneta Renault 2017', '../../admin/anuncios/imagenes/464674_4506543.jpg', '2018-12-19 14:37:03', 3, '<p>Remato por motivo de viaje</p>\r\n\r\n<ul>\r\n	<li>Color: rojo</li>\r\n	<li>Amortiguadores hidr&aacute;ulico</li>\r\n	<li>Caja autom&aacute;tica</li>\r\n	<li>Motor 1600</li>\r\n	<li>Recorrido 48000 KM</li>\r\n	<li>Precio: $/ 18000</li>\r\n</ul>\r\n', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nombre`) VALUES
(1, 'Autos'),
(2, 'Muebles'),
(3, 'Electrodomésticos'),
(4, 'Inmuebles'),
(5, 'Teléfonos - Celulare'),
(6, 'Moda y Belleza'),
(7, 'Animales y Mascotas'),
(8, 'Empleos y Servicios'),
(9, 'Ropa y Accesorios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuarios`
--

CREATE TABLE `tipousuarios` (
  `idTipoUsuario` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Volcado de datos para la tabla `tipousuarios`
--

INSERT INTO `tipousuarios` (`idTipoUsuario`, `nombre`) VALUES
(1, 'admin'),
(2, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `correo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idTipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `correo`, `password`, `nombre`, `apellido`, `celular`, `idTipoUsuario`) VALUES
(1, 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Roly', 'Anibal', '064234917', 1),
(3, '123@gmail.com', '202cb962ac59075b964b07152d234b70', 'Charo', 'Lisbet', '06423417', 2),
(5, 'ed@gmail.com', '202cb962ac59075b964b07152d234b70', 'AAA', 'DDD', '123456789', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`idAnuncio`),
  ADD KEY `idAutor` (`idUsuario`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `tipousuarios`
--
ALTER TABLE `tipousuarios`
  ADD PRIMARY KEY (`idTipoUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idTipoUsuario` (`idTipoUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `idAnuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipousuarios`
--
ALTER TABLE `tipousuarios`
  MODIFY `idTipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tipousuarios` (`idTipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

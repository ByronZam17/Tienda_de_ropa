-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-02-2025 a las 06:53:13
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
-- Base de datos: `tienda_ropa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_frecuentes`
--

CREATE TABLE `clientes_frecuentes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes_frecuentes`
--

INSERT INTO `clientes_frecuentes` (`id_cliente`, `nombre`, `correo`, `telefono`, `direccion`) VALUES
(1, 'Juan Pérez', 'juan@example.com', '1234567890', 'Calle Falsa 123'),
(2, 'Ana Gómez', 'ana@example.com', '0987654321', 'Avenida Siempre Viva 742');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargos`
--

CREATE TABLE `encargos` (
  `id_encargo` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `fecha_encargo` date DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encargos`
--

INSERT INTO `encargos` (`id_encargo`, `id_cliente`, `id_producto`, `fecha_encargo`, `cantidad`) VALUES
(1, 1, 1, '2025-02-18', 2),
(2, 2, 2, '2025-02-17', 1),
(3, 1, 3, '2025-02-19', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(100) NOT NULL,
  `cantidad_prendas` int(11) NOT NULL,
  `ventas` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nombre_marca`, `cantidad_prendas`, `ventas`) VALUES
(1, 'Nike', 200, 50),
(2, 'Adidas', 150, 0),
(3, 'Puma', 100, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_marca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `descripcion`, `precio`, `stock`, `id_marca`) VALUES
(1, 'Camiseta Roja Nike', 'Camiseta de algodón roja', 15.99, 50, 1),
(2, 'Zapatillas Adidas', 'Zapatillas deportivas', 60.00, 30, 2),
(3, 'Pantalón Puma', 'Pantalón deportivo', 35.00, 40, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes_frecuentes`
--
ALTER TABLE `clientes_frecuentes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `encargos`
--
ALTER TABLE `encargos`
  ADD PRIMARY KEY (`id_encargo`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_marca` (`id_marca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes_frecuentes`
--
ALTER TABLE `clientes_frecuentes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `encargos`
--
ALTER TABLE `encargos`
  MODIFY `id_encargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `encargos`
--
ALTER TABLE `encargos`
  ADD CONSTRAINT `encargos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes_frecuentes` (`id_cliente`),
  ADD CONSTRAINT `encargos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/* Marcas con al menos 1 prenda vendida */

SELECT * FROM `marcas` WHERE `ventas` > 0;


/* Prendas mas vendidas y su cantidad de stock restante*/
SELECT p.nombre_producto, SUM(e.cantidad) AS total_vendido, p.stock 
FROM `productos` p
JOIN `encargos` e ON p.id_producto = e.id_producto
GROUP BY p.id_producto;


/* Top 5 marcas mas vendidas */
SELECT nombre_marca, ventas 
FROM `marcas` 
ORDER BY ventas DESC 
LIMIT 5;


/*Vistas: */
-- Vista para obtener marcas con al menos una prenda vendida
CREATE VIEW v_marcas_con_ventas AS
SELECT * FROM marcas WHERE ventas > 0;

-- Vista para obtener las prendas más vendidas y su cantidad de stock restante
CREATE VIEW v_prendas_mas_vendidas AS
SELECT p.nombre_producto, SUM(e.cantidad) AS total_vendido, p.stock 
FROM productos p 
JOIN encargos e ON p.id_producto = e.id_producto 
GROUP BY p.id_producto;

-- Vista para obtener el top 5 de marcas más vendidas
CREATE VIEW v_top5_marcas AS
SELECT nombre_marca, ventas 
FROM marcas 
ORDER BY ventas DESC 
LIMIT 5;

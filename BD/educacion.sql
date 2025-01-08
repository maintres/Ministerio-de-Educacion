-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-01-2025 a las 18:27:37
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `educacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hs_catedras`
--

CREATE TABLE `hs_catedras` (
  `id_catedra` int(11) NOT NULL,
  `id_profe` int(11) NOT NULL,
  `num_exp` varchar(50) NOT NULL,
  `num_dictamen` varchar(50) NOT NULL,
  `escuela` varchar(255) NOT NULL,
  `fecha_toma` date NOT NULL,
  `fecha_crea` date NOT NULL,
  `estado` varchar(10) NOT NULL DEFAULT 'Activo',
  `tipo` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hs_catedras`
--

INSERT INTO `hs_catedras` (`id_catedra`, `id_profe`, `num_exp`, `num_dictamen`, `escuela`, `fecha_toma`, `fecha_crea`, `estado`, `tipo`) VALUES
(1, 1, '123456789', '22345678', 'DOMINGO FAUSTINA SARMIENTO', '2024-12-10', '2024-12-22', 'Activo', 1),
(2, 2, '123425675', '2343564', 'MONGITO', '2024-12-21', '2024-12-22', 'Activo', 1),
(3, 3, '34567GTFTFT', '4545667', 'DFGHJKL', '1992-02-12', '2024-12-22', 'Activo', 1),
(4, 4, '123456', '123124', 'DOMINGO FAUSTINA SARMIENTO', '2024-12-25', '2024-12-31', 'Activo', 1),
(5, 5, '123456', '21312412412432432', 'DOMINGO FAUSTINA SARMIENTO', '2025-03-12', '2024-12-31', 'Activo', 1),
(6, 6, '035097', '365', 'COLEGIO SECUNDARIO CACIQUE ANGACO', '2023-11-10', '2024-12-31', 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id_profe` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id_profe`, `nombre`, `apellido`, `dni`) VALUES
(1, 'MAXIMILIANO ANDRE', 'OLMOS BAZAN', 38015715),
(2, 'MAXIMILIANO ANDRE', 'OLMOS BAZAN', 38015715),
(3, 'MAXIMILIANO ANDRE', 'OLMOS BAZAN', 38015715),
(4, 'ANDRÉS SANTIAGO', 'AGUERO CORREA', 32084432),
(5, 'ANDRÉS SANTIAGO', 'AGUERO CORREA', 32084432),
(6, 'LEILA AGUSTINA', 'DIAZ RIVEROS', 39652634);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_tabla`
--

CREATE TABLE `tipo_tabla` (
  `id_tipo` int(11) NOT NULL,
  `nombre_tabla` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_tabla`
--

INSERT INTO `tipo_tabla` (`id_tipo`, `nombre_tabla`) VALUES
(1, 'Horas Cátedra'),
(2, 'Horas Cargo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hs_catedras`
--
ALTER TABLE `hs_catedras`
  ADD PRIMARY KEY (`id_catedra`),
  ADD KEY `id_profe` (`id_profe`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id_profe`);

--
-- Indices de la tabla `tipo_tabla`
--
ALTER TABLE `tipo_tabla`
  ADD PRIMARY KEY (`id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hs_catedras`
--
ALTER TABLE `hs_catedras`
  MODIFY `id_catedra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_tabla`
--
ALTER TABLE `tipo_tabla`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `hs_catedras`
--
ALTER TABLE `hs_catedras`
  ADD CONSTRAINT `hs_catedras_ibfk_1` FOREIGN KEY (`id_profe`) REFERENCES `profesor` (`id_profe`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

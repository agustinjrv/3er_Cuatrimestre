-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2020 a las 19:37:20
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_empleados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Apellido` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Dni` int(11) NOT NULL,
  `Sexo` char(1) COLLATE latin1_spanish_ci NOT NULL,
  `Legajo` int(10) UNSIGNED NOT NULL,
  `Sueldo` double UNSIGNED NOT NULL,
  `Turno` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `PathFoto` varchar(100) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`ID`, `Apellido`, `Nombre`, `Dni`, `Sexo`, `Legajo`, `Sueldo`, `Turno`, `PathFoto`) VALUES
(9, 'Rivola', 'Agustin', 42432112, 'M', 400, 20000, 'Mañana', 'Agustin.173315.jpeg'),
(21, 'Aguado', 'Santiago', 41414141, 'M', 300, 19000, 'Mañana', 'Santiago.180132.png'),
(23, 'Martinez', 'Zaira', 22223333, 'F', 100, 8000, 'Mañana', 'Zaira.190610.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

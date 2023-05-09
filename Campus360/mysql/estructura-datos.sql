-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2023 a las 17:47:53
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `campus360`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `IdAlumno` int(11) NOT NULL,
  `IdPadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`IdAlumno`, `IdPadre`) VALUES
(1, 5),
(6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `Nombre` varchar(30) NOT NULL,
  `Grupo` varchar(1) NOT NULL,
  `Profesor` int(11) NOT NULL,
  `Ciclo` int(11) NOT NULL,
  `Curso` tinyint(4) NOT NULL,
  `Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`Nombre`, `Grupo`, `Profesor`, `Ciclo`, `Curso`, `Id`) VALUES
('Matematicas', 'A', 4, 1, 3, 2),
('Lengua', 'A', 4, 1, 1, 3),
('Quimica', 'A', 7, 1, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `IdAlumno` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `Nota` decimal(10,0) DEFAULT NULL,
  `IdEntrega` int(11) NOT NULL,
  `Porcentaje` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclos`
--

CREATE TABLE `ciclos` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciclos`
--

INSERT INTO `ciclos` (`Id`, `Nombre`) VALUES
(1, 'ESO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregasalumno`
--

CREATE TABLE `entregasalumno` (
  `Id` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `IdAlumno` int(11) NOT NULL,
  `Ruta` varchar(150) NOT NULL,
  `idEntrega` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudianasignaturas`
--

CREATE TABLE `estudianasignaturas` (
  `IdAsignatura` int(11) NOT NULL,
  `IdAlumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudianasignaturas`
--

INSERT INTO `estudianasignaturas` (`IdAsignatura`, `IdAlumno`) VALUES
(2, 1),
(3, 1),
(4, 1),
(4, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_tareas`
--

CREATE TABLE `eventos_tareas` (
  `Id` int(11) NOT NULL,
  `FechaFin` date NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `esentrega` tinyint(1) NOT NULL,
  `HoraFin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeforo`
--

CREATE TABLE `MensajeForo` (
  `id` int(11) NOT NULL,
  `idAutor` int(11) NOT NULL,
  `idAsignatura` int(11) NOT NULL,
  `mensaje` varchar(1024) NOT NULL,
  `autor` varchar(40) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajeforo`
--

INSERT INTO `mensajeforo` (`id`, `idAutor`, `idAsignatura`, `mensaje`, `autor`, `fecha`) VALUES
(1, 7, 4, 'hola', 'Juan', '2023-04-30 10:16:22'),
(2, 1, 4, 'si', 'Pepe', '2023-04-30 16:44:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeprivado`
--

CREATE TABLE `MensajePrivado` (
  `id` int(11) NOT NULL,
  `idAutor` int(11) NOT NULL,
  `idRemitente` int(11) NOT NULL,
  `mensaje` varchar(1024) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajeprivado`
--

INSERT INTO `mensajeprivado` (`id`, `idAutor`, `idRemitente`, `mensaje`, `fecha`) VALUES
(1, 7, 1, 'hola pepe', '2023-04-30 10:16:49'),
(2, 6, 7, 'hola profe', '2023-04-30 10:17:51'),
(3, 7, 2, 'hola hulio', '2023-04-30 10:49:05'),
(4, 1, 7, 'hola', '2023-04-30 16:50:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padres`
--

CREATE TABLE `padres` (
  `IdPadre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `padres`
--

INSERT INTO `padres` (`IdPadre`) VALUES
(5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `IdProfesor` int(11) NOT NULL,
  `Despacho` int(11) NOT NULL,
  `Tutorias` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`IdProfesor`, `Despacho`, `Tutorias`) VALUES
(4, 234, '11:29:00'),
(7, 9, '11:15:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `Id` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `Ruta` varchar(150) NOT NULL,
  `Nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolesusuarios`
--

CREATE TABLE `rolesusuarios` (
  `idUsuario` int(11) NOT NULL,
  `rol` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rolesusuarios`
--

INSERT INTO `rolesusuarios` (`idUsuario`, `rol`) VALUES
(1, 2),
(2, 1),
(4, 4),
(5, 3),
(6, 2),
(7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `NIF` varchar(12) NOT NULL,
  `Telefono` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Apellidos` varchar(60) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `NIF`, `Telefono`, `email`, `direccion`, `Nombre`, `Apellidos`, `password`) VALUES
(1, '45427899H', '+34 651764387', 'user@campus.es', 'Calle Imaginaria 3a', 'Pepe', 'Pepito Pulgoso', '$2y$10$jhhPNs2Nf5JYLVa4hW2jI.j/qA3pdI.lOqTV.5Ra1ZD9VKsP3rbbK'),
(2, '50378400M', '+34 689235422', 'admin@campus.es', 'Calle Rafaela y Barra, 24, 4c', 'Julio', 'Garcia Garcia', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG'),
(4, '32671299U', '+34 6781244', 'profe@campus.es', 'Calle phpAdmin, 12, 1A', 'Eustaquio', 'Abichuela Messi', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG'),
(5, '41842053M', '+21 653278655', 'padre@campus.es', 'Calle imaginaria 3a', 'Juanola', 'Ortega Saiz', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG'),
(6, '87453823A', '+34 987675587', 'user2@campus.es', 'Calle Maliciosa 24', 'Pedro', 'Francisco', '$2y$10$sr6NH2L8hQ1S2ocoRdWrqO4ZOnS8lX6LTvTfJMcEsPTKZmz.p5Ij2'),
(7, '87452323Z', '+34 987675275', 'profe2@campus.es', 'Calle Maliciosa 26', 'Juan', 'Castellano', '$2y$10$pczXzHuXnFqBbXghoCAEzOxDWYjD8Josy3tsWgfxYnpeTK8ELj7yC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`IdAlumno`),
  ADD KEY `IdPadre` (`IdPadre`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Profesor` (`Profesor`),
  ADD KEY `Ciclo` (`Ciclo`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`IdEntrega`,`IdAlumno`) USING BTREE,
  ADD KEY `IdAlumno` (`IdAlumno`),
  ADD KEY `IdAsignatura` (`IdAsignatura`);

--
-- Indices de la tabla `ciclos`
--
ALTER TABLE `ciclos`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `entregasalumno`
--
ALTER TABLE `entregasalumno`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAlumno` (`IdAlumno`),
  ADD KEY `EntregasAlumno_ibfk_2` (`IdAsignatura`),
  ADD KEY `idEntrega` (`idEntrega`);

--
-- Indices de la tabla `estudianasignaturas`
--
ALTER TABLE `estudianasignaturas`
  ADD PRIMARY KEY (`IdAsignatura`,`IdAlumno`),
  ADD KEY `IdAlumno_Profesor` (`IdAlumno`);

--
-- Indices de la tabla `eventos_tareas`
--
ALTER TABLE `eventos_tareas`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAsignatura` (`IdAsignatura`);

--
-- Indices de la tabla `mensajeforo`
--
ALTER TABLE `MensajeForo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAutor` (`idAutor`),
  ADD KEY `idAsignatura` (`idAsignatura`);

--
-- Indices de la tabla `mensajeprivado`
--
ALTER TABLE `MensajePrivado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAutor` (`idAutor`),
  ADD KEY `idRemitente` (`idRemitente`);

--
-- Indices de la tabla `padres`
--
ALTER TABLE `padres`
  ADD PRIMARY KEY (`IdPadre`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`IdProfesor`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAsignatura` (`IdAsignatura`);

--
-- Indices de la tabla `rolesusuarios`
--
ALTER TABLE `rolesusuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `NIF` (`NIF`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ciclos`
--
ALTER TABLE `ciclos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entregasalumno`
--
ALTER TABLE `entregasalumno`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `eventos_tareas`
--
ALTER TABLE `eventos_tareas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mensajeforo`
--
ALTER TABLE `MensajeForo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mensajeprivado`
--
ALTER TABLE `MensajePrivado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `Alumnos_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Alumnos_ibfk_2` FOREIGN KEY (`IdPadre`) REFERENCES `padres` (`IdPadre`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `Asignaturas_ibfk_1` FOREIGN KEY (`Profesor`) REFERENCES `profesores` (`IdProfesor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Asignaturas_ibfk_2` FOREIGN KEY (`Ciclo`) REFERENCES `ciclos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entregasalumno`
--
ALTER TABLE `entregasalumno`
  ADD CONSTRAINT `EntregasAlumno_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `alumnos` (`IdAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EntregasAlumno_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EntregasAlumno_ibfk_3` FOREIGN KEY (`idEntrega`) REFERENCES `eventos_tareas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudianasignaturas`
--
ALTER TABLE `estudianasignaturas`
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `alumnos` (`IdAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `eventos_tareas`
--
ALTER TABLE `eventos_tareas`
  ADD CONSTRAINT `Eventos_Tareas_ibfk_1` FOREIGN KEY (`IdAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajeforo`
--
ALTER TABLE `mensajeforo`
  ADD CONSTRAINT `mensajeforo_ibfk_1` FOREIGN KEY (`idAutor`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajeforo_ibfk_2` FOREIGN KEY (`idAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajeprivado`
--
ALTER TABLE `mensajeprivado`
  ADD CONSTRAINT `mensajeprivado_ibfk_1` FOREIGN KEY (`idAutor`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajeprivado_ibfk_2` FOREIGN KEY (`idRemitente`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `padres`
--
ALTER TABLE `padres`
  ADD CONSTRAINT `Padres_ibfk_1` FOREIGN KEY (`IdPadre`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD CONSTRAINT `Profesores_ibfk_1` FOREIGN KEY (`IdProfesor`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD CONSTRAINT `Recursos_ibfk_1` FOREIGN KEY (`IdAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rolesusuarios`
--
ALTER TABLE `rolesusuarios`
  ADD CONSTRAINT `RolesUsuarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

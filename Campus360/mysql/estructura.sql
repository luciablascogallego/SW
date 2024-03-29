/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `Alumnos`;
DROP TABLE IF EXISTS `Asignaturas`;
DROP TABLE IF EXISTS `Calificaciones`;
DROP TABLE IF EXISTS `Eventos_Tareas`;
DROP TABLE IF EXISTS `Padres`;
DROP TABLE IF EXISTS `Profesores`;
DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `EstudianAsignaturas`;
DROP TABLE IF EXISTS `RolesUsuarios`;
DROP TABLE IF EXISTS `EntregasAlumno`;
DROP TABLE IF EXISTS `Recursos`;
DROP TABLE IF EXISTS `Ciclos`;
DROP TABLE IF EXISTS `MensajeForo`;
DROP TABLE IF EXISTS `MensajePrivado`;
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 10, 2023 at 04:51 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Campus360`
--

-- --------------------------------------------------------

--
-- Table structure for table `Alumnos`
--

CREATE TABLE `Alumnos` (
  `IdAlumno` int(11) NOT NULL,
  `IdPadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Asignaturas`
--

CREATE TABLE `Asignaturas` (
  `Nombre` varchar(30) NOT NULL,
  `Grupo` varchar(1) NOT NULL,
  `Profesor` int(11) NOT NULL,
  `Ciclo` int(11) NOT NULL,
  `Curso` tinyint(4) NOT NULL,
  `Id` int(11) NOT NULL,
  `Primero` int(11) NOT NULL,
  `Segundo` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Calificaciones`
--

CREATE TABLE `Calificaciones` (
  `IdAlumno` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `Nota` decimal(10,2) DEFAULT NULL,
  `IdEntrega` int(11) DEFAULT NULL,
  `Porcentaje` decimal(10,0) NOT NULL,
  `Id` int(11) NOT NULL,
  `Trimestre` tinyint(4) NOT NULL,
  `Nombre` varchar(40) NOT NULL,
  `Comentario` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Ciclos`
--

CREATE TABLE `Ciclos` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `EntregasAlumno`
--

CREATE TABLE `EntregasAlumno` (
  `Id` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `IdAlumno` int(11) NOT NULL,
  `Ruta` varchar(150) NOT NULL,
  `idEntrega` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `EstudianAsignaturas`
--

CREATE TABLE `EstudianAsignaturas` (
  `IdAsignatura` int(11) NOT NULL,
  `IdAlumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Eventos_Tareas`
--

CREATE TABLE `Eventos_Tareas` (
  `Id` int(11) NOT NULL,
  `FechaFin` date NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `esentrega` tinyint(1) NOT NULL,
  `HoraFin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MensajeForo`
--

CREATE TABLE `MensajeForo` (
  `id` int(11) NOT NULL,
  `idAutor` int(11) NOT NULL,
  `idAsignatura` int(11) NOT NULL,
  `mensaje` varchar(1024) NOT NULL,
  `autor` varchar(40) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MensajePrivado`
--

CREATE TABLE `MensajePrivado` (
  `id` int(11) NOT NULL,
  `idAutor` int(11) NOT NULL,
  `idRemitente` int(11) NOT NULL,
  `mensaje` varchar(1024) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Padres`
--

CREATE TABLE `Padres` (
  `IdPadre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Profesores`
--

CREATE TABLE `Profesores` (
  `IdProfesor` int(11) NOT NULL,
  `Despacho` int(11) NOT NULL,
  `Tutorias` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Recursos`
--

CREATE TABLE `Recursos` (
  `Id` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `Ruta` varchar(150) NOT NULL,
  `Nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `RolesUsuarios`
--

CREATE TABLE `RolesUsuarios` (
  `idUsuario` int(11) NOT NULL,
  `rol` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Usuarios`
--

CREATE TABLE `Usuarios` (
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
-- Indexes for table `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD PRIMARY KEY (`IdAlumno`),
  ADD KEY `IdPadre` (`IdPadre`);

--
-- Indexes for table `Asignaturas`
--
ALTER TABLE `Asignaturas`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Profesor` (`Profesor`),
  ADD KEY `Ciclo` (`Ciclo`);

--
-- Indexes for table `Calificaciones`
--
ALTER TABLE `Calificaciones`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAlumno` (`IdAlumno`),
  ADD KEY `IdAsignatura` (`IdAsignatura`),
  ADD KEY `Calificaciones_ibfk_3` (`IdEntrega`);

--
-- Indexes for table `Ciclos`
--
ALTER TABLE `Ciclos`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indexes for table `EntregasAlumno`
--
ALTER TABLE `EntregasAlumno`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAlumno` (`IdAlumno`),
  ADD KEY `EntregasAlumno_ibfk_2` (`IdAsignatura`),
  ADD KEY `idEntrega` (`idEntrega`);

--
-- Indexes for table `EstudianAsignaturas`
--
ALTER TABLE `EstudianAsignaturas`
  ADD PRIMARY KEY (`IdAsignatura`,`IdAlumno`),
  ADD KEY `IdAlumno_Profesor` (`IdAlumno`);

--
-- Indexes for table `Eventos_Tareas`
--
ALTER TABLE `Eventos_Tareas`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAsignatura` (`IdAsignatura`);

--
-- Indexes for table `MensajeForo`
--
ALTER TABLE `MensajeForo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAutor` (`idAutor`),
  ADD KEY `idAsignatura` (`idAsignatura`);

--
-- Indexes for table `MensajePrivado`
--
ALTER TABLE `MensajePrivado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAutor` (`idAutor`),
  ADD KEY `idRemitente` (`idRemitente`);

--
-- Indexes for table `Padres`
--
ALTER TABLE `Padres`
  ADD PRIMARY KEY (`IdPadre`);

--
-- Indexes for table `Profesores`
--
ALTER TABLE `Profesores`
  ADD PRIMARY KEY (`IdProfesor`);

--
-- Indexes for table `Recursos`
--
ALTER TABLE `Recursos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAsignatura` (`IdAsignatura`);

--
-- Indexes for table `RolesUsuarios`
--
ALTER TABLE `RolesUsuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indexes for table `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `NIF` (`NIF`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Asignaturas`
--
ALTER TABLE `Asignaturas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Calificaciones`
--
ALTER TABLE `Calificaciones`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `Ciclos`
--
ALTER TABLE `Ciclos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `EntregasAlumno`
--
ALTER TABLE `EntregasAlumno`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Eventos_Tareas`
--
ALTER TABLE `Eventos_Tareas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `MensajeForo`
--
ALTER TABLE `MensajeForo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `MensajePrivado`
--
ALTER TABLE `MensajePrivado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Recursos`
--
ALTER TABLE `Recursos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD CONSTRAINT `Alumnos_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `Alumnos_ibfk_2` FOREIGN KEY (`IdPadre`) REFERENCES `Padres` (`IdPadre`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `Asignaturas`
--
ALTER TABLE `Asignaturas`
  ADD CONSTRAINT `Asignaturas_ibfk_1` FOREIGN KEY (`Profesor`) REFERENCES `Profesores` (`IdProfesor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Asignaturas_ibfk_2` FOREIGN KEY (`Ciclo`) REFERENCES `Ciclos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Calificaciones`
--
ALTER TABLE `Calificaciones`
  ADD CONSTRAINT `Calificaciones_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Calificaciones_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Calificaciones_ibfk_3` FOREIGN KEY (`IdEntrega`) REFERENCES `Eventos_Tareas` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `EntregasAlumno`
--
ALTER TABLE `EntregasAlumno`
  ADD CONSTRAINT `EntregasAlumno_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EntregasAlumno_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EntregasAlumno_ibfk_3` FOREIGN KEY (`idEntrega`) REFERENCES `Eventos_Tareas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `EstudianAsignaturas`
--
ALTER TABLE `EstudianAsignaturas`
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Eventos_Tareas`
--
ALTER TABLE `Eventos_Tareas`
  ADD CONSTRAINT `Eventos_Tareas_ibfk_1` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `MensajeForo`
--
ALTER TABLE `MensajeForo`
  ADD CONSTRAINT `MensajeForo_ibfk_1` FOREIGN KEY (`idAutor`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MensajeForo_ibfk_2` FOREIGN KEY (`idAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `MensajePrivado`
--
ALTER TABLE `MensajePrivado`
  ADD CONSTRAINT `MensajePrivado_ibfk_1` FOREIGN KEY (`idAutor`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MensajePrivado_ibfk_2` FOREIGN KEY (`idRemitente`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Padres`
--
ALTER TABLE `Padres`
  ADD CONSTRAINT `Padres_ibfk_1` FOREIGN KEY (`IdPadre`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Profesores`
--
ALTER TABLE `Profesores`
  ADD CONSTRAINT `Profesores_ibfk_1` FOREIGN KEY (`IdProfesor`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Recursos`
--
ALTER TABLE `Recursos`
  ADD CONSTRAINT `Recursos_ibfk_1` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `RolesUsuarios`
--
ALTER TABLE `RolesUsuarios`
  ADD CONSTRAINT `RolesUsuarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
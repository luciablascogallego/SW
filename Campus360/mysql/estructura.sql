/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
DROP TABLE IF EXISTS `Alumnos`;
DROP TABLE IF EXISTS `Asignaturas`;
DROP TABLE IF EXISTS `Calificaciones`;
DROP TABLE IF EXISTS `Eventos_Tareas`;
DROP TABLE IF EXISTS `Padres`;
DROP TABLE IF EXISTS `Profesores`;
DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `EstudianAsignaturas`;
DROP TABLE IF EXISTS `RolesUsuario`;
DROP TABLE IF EXISTS `EntregasUsuario`;
DROP TABLE IF EXISTS `Recursos`;
DROP TABLE IF EXISTS `Ciclos`;
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 07, 2023 at 07:09 PM
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
  `Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Calificaciones`
--

CREATE TABLE `Calificaciones` (
  `IdAlumno` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `Nota` decimal(10,0) DEFAULT NULL,
  `IdEntrega` int(11) NOT NULL,
  `Porcentaje` decimal(10,0) NOT NULL
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
  `Ruta` varchar(40) NOT NULL,
  `idEntrega` int(11) NOT NULL
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
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(200) NOT NULL
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
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`IdEntrega`,`IdAlumno`) USING BTREE,
  ADD KEY `IdAlumno` (`IdAlumno`),
  ADD KEY `IdAsignatura` (`IdAsignatura`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Ciclos`
--
ALTER TABLE `Ciclos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `EntregasAlumno`
--
ALTER TABLE `EntregasAlumno`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Recursos`
--
ALTER TABLE `Recursos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD CONSTRAINT `Alumnos_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Alumnos_ibfk_2` FOREIGN KEY (`IdPadre`) REFERENCES `Padres` (`IdPadre`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `Asignaturas`
--
ALTER TABLE `Asignaturas`
  ADD CONSTRAINT `Asignaturas_ibfk_1` FOREIGN KEY (`Profesor`) REFERENCES `Profesores` (`IdProfesor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Asignaturas_ibfk_2` FOREIGN KEY (`Ciclo`) REFERENCES `Ciclos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `EntregasAlumno`
--
ALTER TABLE `EntregasAlumno`
  ADD CONSTRAINT `EntregasAlumno_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EntregasAlumno_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EntregasAlumno_ibfk_3` FOREIGN KEY (`idEntrega`) REFERENCES `Eventos_Tareas` (`Id`);

--
-- Constraints for table `EstudianAsignaturas`
--
ALTER TABLE `EstudianAsignaturas`
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `RolesUsuarios`
--
ALTER TABLE `RolesUsuarios`
  ADD CONSTRAINT `RolesUsuarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
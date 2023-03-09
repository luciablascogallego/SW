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
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 09, 2023 at 08:08 PM
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
  `IdPadre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Asignaturas`
--

CREATE TABLE `Asignaturas` (
  `Nombre` varchar(30) NOT NULL,
  `Grupo` varchar(1) NOT NULL,
  `Profesor` int(11) NOT NULL,
  `Ciclo` varchar(15) NOT NULL,
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
-- Table structure for table `Eventos_Tareas`
--

CREATE TABLE `Eventos_Tareas` (
  `Id` int(11) NOT NULL,
  `FechaFin` date NOT NULL,
  `IdAsignatura` int(11) NOT NULL
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
-- Table structure for table `Usuarios`
--

CREATE TABLE `Usuarios` (
  `Id` int(11) NOT NULL,
  `NIF` varchar(12) NOT NULL,
  `Telefono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dirección` varchar(120) NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Apellidos` varchar(60) NOT NULL,
  `Contraseña` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD PRIMARY KEY (`IdAlumno`);

--
-- Indexes for table `Asignaturas`
--
ALTER TABLE `Asignaturas`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `Calificaciones`
--
ALTER TABLE `Calificaciones`
  ADD PRIMARY KEY (`IdEntrega`,`IdAlumno`) USING BTREE;

--
-- Indexes for table `Eventos_Tareas`
--
ALTER TABLE `Eventos_Tareas`
  ADD PRIMARY KEY (`Id`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Eventos_Tareas`
--
ALTER TABLE `Eventos_Tareas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
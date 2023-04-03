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
-- Generation Time: Apr 03, 2023 at 03:34 PM
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

--
-- Dumping data for table `Alumnos`
--

INSERT INTO `Alumnos` (`IdAlumno`, `IdPadre`) VALUES
(1, 5);

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

--
-- Dumping data for table `Asignaturas`
--

INSERT INTO `Asignaturas` (`Nombre`, `Grupo`, `Profesor`, `Ciclo`, `Curso`, `Id`) VALUES
('Lengua', 'A', 4, 1, 3, 1),
('Matematicas', 'A', 4, 1, 3, 2);

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

--
-- Dumping data for table `Ciclos`
--

INSERT INTO `Ciclos` (`Id`, `Nombre`) VALUES
(1, 'ESO');

-- --------------------------------------------------------

--
-- Table structure for table `EntregasAlumno`
--

CREATE TABLE `EntregasAlumno` (
  `Id` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `IdAlumno` int(11) NOT NULL,
  `Ruta` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `EstudianAsignaturas`
--

CREATE TABLE `EstudianAsignaturas` (
  `IdAsignatura` int(11) NOT NULL,
  `IdAlumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `EstudianAsignaturas`
--

INSERT INTO `EstudianAsignaturas` (`IdAsignatura`, `IdAlumno`) VALUES
(1, 1),
(2, 1);

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

--
-- Dumping data for table `Padres`
--

INSERT INTO `Padres` (`IdPadre`) VALUES
(5);

-- --------------------------------------------------------

--
-- Table structure for table `Profesores`
--

CREATE TABLE `Profesores` (
  `IdProfesor` int(11) NOT NULL,
  `Despacho` int(11) NOT NULL,
  `Tutorias` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Profesores`
--

INSERT INTO `Profesores` (`IdProfesor`, `Despacho`, `Tutorias`) VALUES
(4, 234, '11:29:00');

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

--
-- Dumping data for table `RolesUsuarios`
--

INSERT INTO `RolesUsuarios` (`idUsuario`, `rol`) VALUES
(1, 2),
(2, 1),
(4, 4),
(5, 3);

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
-- Dumping data for table `Usuarios`
--

INSERT INTO `Usuarios` (`Id`, `NIF`, `Telefono`, `email`, `direccion`, `Nombre`, `Apellidos`, `password`) VALUES
(1, '45427899H', '+34 651764387', 'user@campus.es', 'Calle Imaginaria 3a', 'Pepe', 'Pepito Pulgoso', '$2y$10$jhhPNs2Nf5JYLVa4hW2jI.j/qA3pdI.lOqTV.5Ra1ZD9VKsP3rbbK'),
(2, '50378400M', '+34 689235422', 'admin@campus.es', 'Calle Rafaela y Barra, 24, 4c', 'Julio', 'Garcia Garcia', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG'),
(4, '32671299U', '+34 6781244', 'profe@campus.es', 'Calle phpAdmin, 12, 1A', 'Eustaquio', 'Abichuela Messi', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG'),
(5, '41842053M', '+21 653278655', 'padre@campus.es', 'Calle imaginaria 3a', 'Juanola', 'Ortega Saiz', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

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
  ADD KEY `EntregasAlumno_ibfk_2` (`IdAsignatura`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Ciclos`
--
ALTER TABLE `Ciclos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `EntregasAlumno`
--
ALTER TABLE `EntregasAlumno`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Eventos_Tareas`
--
ALTER TABLE `Eventos_Tareas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Recursos`
--
ALTER TABLE `Recursos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD CONSTRAINT `Alumnos_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Usuarios` (`Id`),
  ADD CONSTRAINT `Alumnos_ibfk_2` FOREIGN KEY (`IdPadre`) REFERENCES `Padres` (`IdPadre`);

--
-- Constraints for table `Asignaturas`
--
ALTER TABLE `Asignaturas`
  ADD CONSTRAINT `Asignaturas_ibfk_1` FOREIGN KEY (`Profesor`) REFERENCES `Profesores` (`IdProfesor`),
  ADD CONSTRAINT `Asignaturas_ibfk_2` FOREIGN KEY (`Ciclo`) REFERENCES `Ciclos` (`Id`);

--
-- Constraints for table `Calificaciones`
--
ALTER TABLE `Calificaciones`
  ADD CONSTRAINT `Calificaciones_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`),
  ADD CONSTRAINT `Calificaciones_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`),
  ADD CONSTRAINT `Calificaciones_ibfk_3` FOREIGN KEY (`IdEntrega`) REFERENCES `EntregasAlumno` (`Id`);

--
-- Constraints for table `EntregasAlumno`
--
ALTER TABLE `EntregasAlumno`
  ADD CONSTRAINT `EntregasAlumno_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`),
  ADD CONSTRAINT `EntregasAlumno_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`);

--
-- Constraints for table `EstudianAsignaturas`
--
ALTER TABLE `EstudianAsignaturas`
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_1` FOREIGN KEY (`IdAlumno`) REFERENCES `Alumnos` (`IdAlumno`),
  ADD CONSTRAINT `EstudianAsignaturas_ibfk_2` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`);

--
-- Constraints for table `Eventos_Tareas`
--
ALTER TABLE `Eventos_Tareas`
  ADD CONSTRAINT `Eventos_Tareas_ibfk_1` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`);

--
-- Constraints for table `Padres`
--
ALTER TABLE `Padres`
  ADD CONSTRAINT `Padres_ibfk_1` FOREIGN KEY (`IdPadre`) REFERENCES `Usuarios` (`Id`);

--
-- Constraints for table `Profesores`
--
ALTER TABLE `Profesores`
  ADD CONSTRAINT `Profesores_ibfk_1` FOREIGN KEY (`IdProfesor`) REFERENCES `Usuarios` (`Id`);

--
-- Constraints for table `Recursos`
--
ALTER TABLE `Recursos`
  ADD CONSTRAINT `Recursos_ibfk_1` FOREIGN KEY (`IdAsignatura`) REFERENCES `Asignaturas` (`Id`);

--
-- Constraints for table `RolesUsuarios`
--
ALTER TABLE `RolesUsuarios`
  ADD CONSTRAINT `RolesUsuarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
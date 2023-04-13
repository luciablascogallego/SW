/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE `Alumnos`;
TRUNCATE TABLE `Padres`;
TRUNCATE TABLE `Profesores`;
TRUNCATE TABLE `Usuarios`;
TRUNCATE TABLE `RolesUsuarios`;
TRUNCATE TABLE `Ciclos`;
TRUNCATE TABLE `Asignaturas`;
TRUNCATE TABLE `EstudianAsignaturas`;

/*
  user: userpass
  admin: adminpass
*/
--
-- Dumping data for table `Usuarios`
--

INSERT INTO `Usuarios` (`Id`, `NIF`, `Telefono`, `email`, `direccion`, `Nombre`, `Apellidos`, `password`) VALUES
(1, '45427899H', '+34 651764387', 'user@campus.es', 'Calle Imaginaria 3a', 'Pepe', 'Pepito Pulgoso', '$2y$10$jhhPNs2Nf5JYLVa4hW2jI.j/qA3pdI.lOqTV.5Ra1ZD9VKsP3rbbK'),
(2, '50378400M', '+34 689235422', 'admin@campus.es', 'Calle Rafaela y Barra, 24, 4c', 'Julio', 'Garcia Garcia', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG'),
(4, '32671299U', '+34 6781244', 'profe@campus.es', 'Calle phpAdmin, 12, 1A', 'Eustaquio', 'Abichuela Messi', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG'),
(5, '41842053M', '+21 653278655', 'padre@campus.es', 'Calle imaginaria 3a', 'Juanola', 'Ortega Saiz', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

--
-- Dumping data for table `RolesUsuarios`
--

INSERT INTO `RolesUsuarios` (`idUsuario`, `rol`) VALUES
(1, 2),
(2, 1),
(4, 4),
(5, 3);

--
-- Dumping data for table `Padres`
--

INSERT INTO `Padres` (`IdPadre`) VALUES
(5);

--
-- Dumping data for table `Alumnos`
--

INSERT INTO `Alumnos` (`IdAlumno`, `IdPadre`) VALUES
(1, 5);

--
-- Dumping data for table `Profesores`
--

INSERT INTO `Profesores` (`IdProfesor`, `Despacho`, `Tutorias`) VALUES
(4, 234, '11:29:00');

--
-- Dumping data for table `Ciclos`
--

INSERT INTO `Ciclos` (`Id`, `Nombre`) VALUES
(1, 'ESO');

--
-- Dumping data for table `Asignaturas`
--

INSERT INTO `Asignaturas` (`Nombre`, `Grupo`, `Profesor`, `Ciclo`, `Curso`, `Id`) VALUES
('Matematicas', 'A', 4, 1, 3, 2),
('Lengua', 'A', 4, 1, 1, 3);

--
-- Dumping data for table `EstudianAsignaturas`
--

INSERT INTO `EstudianAsignaturas` (`IdAsignatura`, `IdAlumno`) VALUES
(2, 1),
(3, 1);

SET FOREIGN_KEY_CHECKS = 1;

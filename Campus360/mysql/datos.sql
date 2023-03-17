/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
TRUNCATE TABLE `Alumnos`;
TRUNCATE TABLE `Padres`;
TRUNCATE TABLE `Profesores`;
TRUNCATE TABLE `Usuarios`;

/*
  user: userpass
  admin: adminpass
*/
INSERT INTO `Usuarios` (`Id`, `NIF`, `Telefono`, `email`, `dirección`, `Nombre`, `Apellidos`, `Contraseña`) 
VALUES (NULL, '45427899H', '+34 651764387', 'user@campus.es', 'Calle Imaginaria 3a', 'Pepe', 'Pepito Pulgoso', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

INSERT INTO `Usuarios` (`Id`, `NIF`, `Telefono`, `email`, `direccion`, `Nombre`, `Apellidos`, `password`) 
VALUES (NULL, '50378400M', '+34 689235422', 'admin@campus.es', 'Calle Rafaela y Barra, 24, 4c', 'Julio', 'Garcia Garcia', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

INSERT INTO `Usuarios` (`Id`, `NIF`, `Telefono`, `email`, `direccion`, `Nombre`, `Apellidos`, `password`) 
VALUES (NULL, '32671299U', '+34 6781244', 'profe@campus.es', 'Calle phpAdmin, 12, 1A', 'Eustaquio', 'Abichuela Messi', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

INSERT INTO `Usuarios` (`Id`, `NIF`, `Telefono`, `email`, `direccion`, `Nombre`, `Apellidos`, `password`) 
VALUES (NULL, '41842053M', '+21 653278655', 'padre@campus.es', 'Calle imaginaria 3a', 'Juanola', 'Ortega Saiz', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

INSERT INTO `RolesUsuarios` (`idUsuario`, `rol`) VALUES ('1', '2');

INSERT INTO `RolesUsuarios` (`idUsuario`, `rol`) VALUES ('2', '1'), ('4', '4');

INSERT INTO `RolesUsuarios` (`idUsuario`, `rol`) VALUES ('5', '3');

INSERT INTO `Padres` (`IdPadre`) VALUES ('5');

INSERT INTO `Alumnos` (`IdAlumno`, `IdPadre`) VALUES ('1', '5');

INSERT INTO `Profesores` (`IdProfesor`, `Despacho`, `Tutorias`) VALUES ('4', '234', '11:29:00');

INSERT INTO `Asignaturas` (`Nombre`, `Grupo`, `Profesor`, `Ciclo`, `Curso`, `Id`) 
VALUES ('Lengua', 'A', '4', 'ESO', '3', NULL), ('Matematicas', 'A', '4', 'ESO', '3', NULL);

INSERT INTO `EstudianAsignaturas` (`IdAsignatura`, `IdAlumno`) VALUES ('1', '1'), ('2', '1');



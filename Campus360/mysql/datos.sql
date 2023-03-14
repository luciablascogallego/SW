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
VALUES ('1', '45427899H', '+34 651764387', 'user@campus.es', 'Calle Imaginaria 3a', 'Pepe', 'Pepito Pulgoso', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

INSERT INTO `RolesUsuarios` (`idUsuario`, `rol`) VALUES ('1', '2');



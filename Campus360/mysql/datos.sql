/*
  admin@campus.es: adminpass
  alumno@campus.es: alumnopass (Si alumnoN@campus.es: alumnopassN) Siendo N un número
  profe@campus.es: profepass (Si profeN@campus.es: profepassN) Siendo N un número
  padre@campus.es: padrepass (Si padreN@campus.es: padrepassN) Siendo N un número
*/
--
-- Dumping data for table `Usuarios`
--

INSERT INTO `Usuarios` (`Id`, `NIF`, `Telefono`, `email`, `direccion`, `Nombre`, `Apellidos`, `password`) VALUES
(1, '45427899H', '+34 651764387', 'alumno@campus.es', 'Calle Imaginaria 3a', 'Pepe', 'Pepito Pulgoso', '$2y$10$k1RwsjJkb8cAYmDzLMzmCeZ.cA.INEFYTfsYMAbAe6mFVd5F/f1UO'),
(2, '50378411L', '+34 689235422', 'admin@campus.es', 'Calle Rafaela y Barra, 24, 4c', 'Julio', 'Garcia Garcia', '$2y$10$alcshhszFI9l.Aj.3cM6G.o0khpDlKyWWO2UuulF7.9KD8puObKSa'),
(4, '32671299U', '+34 6781244', 'profe@campus.es', 'Calle phpAdmin, 12, 1A', 'Eustaquio', 'Abichuela Messi', '$2y$10$1S6a30KViQ.DbziiRj.dneUtjJpUpvpwXYwCMEBx8gV.6AW8I/iCS'),
(5, '41842053M', '+21 653278655', 'padre@campus.es', 'Calle imaginaria 3a', 'Juanola', 'Ortega Saiz', '$2y$10$Vh3HDbKPr93TWYi0ClszFe/lfA4vOc9P3VRYJO2bBox0d0toLkrvi'),
(93, '34987607P', '+34 671097287', 'profe2@campus.es', 'Combo 12, 7b', 'Evaristo', 'Ortiga Furbo', '$2y$10$DWo.zI8CiEWrwNYCfFDPQeTquHS80nTigDm9vzHou0K8xi0gwgWDO'),
(94, '50378400M', '+34 689519288', 'alumno2@campus.es', 'Cazalegas 5, 3a', 'Diego', 'Pellicer Lafuente', '$2y$10$hqe3lkfdDzWKJ5L.pNOd2.vQfltadEJO9d86YfuoAgIUSdgLLezby'),
(95, '52870158I', '+34 652670963', 'profe3@campus.es', 'Pelicano 34, 5b', 'Jorge', 'Elcurioso Trece', '$2y$10$Ps5Dvz5xrNcLona9CHIzdek3hwdxh1O/E8gC8SPEyJEGFX.NM22P2'),
(96, '43675489P', '+25 615986500', 'profe4@campus.es', 'Concha 23, bajo a', 'Phineas', 'Wilson Smith', '$2y$10$Y5WSb8NkH2ksjHssx2/QJ.vaSkX.GxKwOS5b6e/1DhaIO2gIxPZR2'),
(97, '65789592F', '+34 653876907', 'padre2@campus.es', 'Mugre 12, 6d', 'Mario', 'Bros Obama', '$2y$10$3wRwFLJRmS6Y3TEn4cnFk.FCAhlzfvPbZmXsHk.0tu29TfexWDbIq'),
(98, '56720912U', '+34 689540957', 'padre3@campus.es', 'Cormes 6, 9a', 'C&eacute;sar', 'Cebolleta Kant', '$2y$10$.kHqaQvyV5HUMWyMXYBm1.pXX.OgkSBJrgN6ivHeiJURCqT9WvK8i'),
(99, '48129847P', '+34 671987540', 'alumno3@campus.es', 'Calle Imaginaria 3a', 'Juanito', 'Pepito Pulgoso', '$2y$10$q2fE8.as7fsytRh2dhXxm.ryT/GiI.g4Wgr/I9LCqKXcAclkGMf/K'),
(100, '45238904E', '+34 671829456', 'alumno4@campus.es', 'Mugre 12, 6d', 'Lucia', 'Bros Manta', '$2y$10$DTzhn0DQL/9zJ2YXPD0uC.U2h9PCu.zHXfu0PRLUvZA0J9CZegD5a'),
(101, '87450163U', '+24 634875692', 'alumno5@campus.es', 'Calle imaginaria 3a', 'Jorge', 'Ortega Saiz', '$2y$10$/A5exvzgywbFktIVGczt0ep6UymRdI7/gKWgeZViTYaJaHLbHzPpu');

--
-- Dumping data for table `RolesUsuarios`
--

INSERT INTO `RolesUsuarios` (`idUsuario`, `rol`) VALUES
(1, 2),
(2, 1),
(4, 4),
(5, 3),
(93, 4),
(94, 2),
(95, 4),
(96, 4),
(97, 3),
(98, 3),
(99, 2),
(100, 2),
(101, 2);

--
-- Dumping data for table `Profesores`
--

INSERT INTO `Profesores` (`IdProfesor`, `Despacho`, `Tutorias`) VALUES
(4, 234, '11:29:00'),
(93, 11, '11:30:00'),
(95, 2, '14:00:00'),
(96, 3, '08:00:00');

--
-- Dumping data for table `Padres`
--

INSERT INTO `Padres` (`IdPadre`) VALUES
(5),
(97),
(98);

--
-- Dumping data for table `Alumnos`
--

INSERT INTO `Alumnos` (`IdAlumno`, `IdPadre`) VALUES
(94, 5),
(101, 5),
(100, 97),
(1, 98),
(99, 98);

--
-- Dumping data for table `Ciclos`
--

INSERT INTO `Ciclos` (`Id`, `Nombre`) VALUES
(1, 'ESO'),
(13, 'Primaria');

--
-- Dumping data for table `Asignaturas`
--

INSERT INTO `Asignaturas` (`Nombre`, `Grupo`, `Profesor`, `Ciclo`, `Curso`, `Id`, `Primero`, `Segundo`, `Tercero`) VALUES
('Matematicas', 'A', 4, 1, 3, 2, 10, 20, 70),
('Lengua Castellana', 'A', 93, 1, 1, 3, 25, 25, 25),
('Pl&aacute;stica', 'A', 93, 13, 1, 15, 30, 30, 40),
('Geograf&iacute;a', 'A', 95, 1, 2, 16, 30, 30, 40),
('Ingl&eacute;s', 'A', 96, 13, 1, 17, 30, 30, 40),
('Matem&aacute;ticas', 'A', 4, 13, 1, 18, 30, 30, 40),
('Ciencias Soci&aacute;les', 'A', 95, 1, 1, 19, 30, 30, 40);

--
-- Dumping data for table `EstudianAsignaturas`
--

INSERT INTO `EstudianAsignaturas` (`IdAsignatura`, `IdAlumno`) VALUES
(2, 1),
(2, 94),
(3, 1),
(3, 94),
(3, 99),
(15, 100),
(15, 101),
(16, 1),
(16, 94),
(16, 99),
(17, 100),
(17, 101),
(18, 99),
(18, 100),
(18, 101),
(19, 1),
(19, 94),
(19, 99);

--
-- Dumping data for table `Eventos_Tareas`
--

INSERT INTO `Eventos_Tareas` (`Id`, `FechaFin`, `IdAsignatura`, `nombre`, `descripcion`, `esentrega`, `HoraFin`) VALUES
(12, '2023-05-15', 18, 'Fundaci&oacute;n Telef&oacute;nica', 'Excursi&oacute;n a la fundaci&oacute;n telef&oacute;nica', 0, '10:00:00'),
(13, '2023-05-14', 16, 'Mapas r&iacute;os de Espa&ntilde;a', 'Rellenar el mapa de los r&iacute;os de Espa&ntilde;a', 1, '11:30:00');
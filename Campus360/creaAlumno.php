<?php

require_once __DIR__.'/includes/config.php';

$id = $_GET['id'];

$formNuevoAlumno = new \es\ucm\fdi\aw\Alumnos\FormularioNuevoAlumno($id);
$formNuevoAlumno = $formNuevoAlumno->gestiona();


$tituloPagina = 'Nuevo Alumno';
$contenidoPrincipal=<<<EOF
  	<h1>Crear nuevo alumno</h1>
    $formNuevoAlumno
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
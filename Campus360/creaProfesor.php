<?php

require_once __DIR__.'/includes/config.php';

$id = $_POST['id'];

$formNuevoProfesor = new \es\ucm\fdi\aw\Profesores\FormularioNuevoProfe($id);
$formNuevoProfesor = $formNuevoProfesor->gestiona();

$tituloPagina = 'Nuevo Profesor';
$contenidoPrincipal=<<<EOF
  	<h1>Crear nuevo profesor</h1>
    $formNuevoProfesor
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
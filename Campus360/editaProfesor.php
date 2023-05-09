<?php

require_once __DIR__.'/includes/config.php';

$id = $_POST['id'];

$formEditaProfesor = new \es\ucm\fdi\aw\Profesores\FormularioEditaProfe($id);
$formEditaProfesor = $formEditaProfesor->gestiona();


$tituloPagina = 'Editar Profesor';
$contenidoPrincipal=<<<EOF
  	<h1>Editar profesor</h1>
    $formEditaProfesor
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
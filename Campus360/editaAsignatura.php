<?php

require_once __DIR__.'/includes/config.php';

$id = $_GET['id'];

$formEditaAsignatura = new \es\ucm\fdi\aw\Asignaturas\FormularioEditaAsignatura($id);
$formEditaAsignatura = $formEditaAsignatura->gestiona();


$tituloPagina = 'Edita Asignatura';
$contenidoPrincipal=<<<EOF
  	<h1>Edita asignatura</h1>
    $formEditaAsignatura
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
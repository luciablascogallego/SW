<?php

require_once __DIR__.'/includes/config.php';

$idAsignatura = $_GET['id'];

$formAñadeAsig = new \es\ucm\fdi\aw\Alumnos\FormularioParticipantesAsignatura($idAsignatura);
$formAñadeAsig = $formAñadeAsig->gestiona();


$tituloPagina = 'Gestionar alumnos asignatura';
$contenidoPrincipal=<<<EOF
  	<h1>Gestionar alumnos de la asignatura</h1>
    $formAñadeAsig
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
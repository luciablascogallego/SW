<?php

require_once __DIR__.'/includes/config.php';

$formCreaAsignatura = new \es\ucm\fdi\aw\Asignaturas\FormularioCreaAsignatura();
$formCreaAsignatura = $formCreaAsignatura->gestiona();


$tituloPagina = 'Nueva Asignatura';
$contenidoPrincipal=<<<EOF
  	<h1>Crear nueva asignatura</h1>
    $formCreaAsignatura
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
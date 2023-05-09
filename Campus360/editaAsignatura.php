<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Asignaturas\Asignatura;

$id = $_POST['id'];

$asignatura = Asignatura::buscaPorId($id);

$formEditaAsignatura = new \es\ucm\fdi\aw\Asignaturas\FormularioEditaAsignatura($asignatura);
$formEditaAsignatura = $formEditaAsignatura->gestiona();

$tituloPagina = 'Editar asignatura';

$contenidoPrincipal=<<<EOF
  	<h1>Edita asignatura</h1>
    $formEditaAsignatura
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
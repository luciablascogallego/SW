<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Asignaturas\Asignatura;

$id = $_POST['id'];

$asignatura = Asignatura::buscaPorId($id);

$formAñadeAsig = new \es\ucm\fdi\aw\Alumnos\FormularioParticipantesAsignatura($asignatura);
$formAñadeAsig = $formAñadeAsig->gestiona();

$tituloPagina = 'Añadir alumnos';

$contenidoPrincipal=<<<EOF
  	<h1>Gestionar alumnos de la asignatura</h1>
    $formAñadeAsig
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
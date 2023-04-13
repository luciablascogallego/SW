<?php

require_once __DIR__.'/includes/config.php';

$id = $_GET['id'];
$entrega = \es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas::buscaPorId($id);
$asignatura = $entrega->getIdAsignatura();


$formEditaEvento = new \es\ucm\fdi\aw\Entregas_Eventos\FormularioEditaEvento($id, $asignatura);
$formEditaEvento = $formEditaEvento->gestiona();


$tituloPagina = 'Edita evento';
$contenidoPrincipal=<<<EOF
  	<h1>Editar evento/tarea</h1>
    $formEditaEvento
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
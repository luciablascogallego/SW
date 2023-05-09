<?php

require_once __DIR__.'/includes/config.php';

$id = $_POST['id'];


$formCreaEvento = new \es\ucm\fdi\aw\Entregas_Eventos\FormularioCreaEvento($id);
$formCreaEvento = $formCreaEvento->gestiona();

$tituloPagina = 'Crear Evento/Tarea';

$contenidoPrincipal=<<<EOF
  	<h1>Crear nuevo evento/tarea</h1>
    $formCreaEvento
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
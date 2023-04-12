<?php

require_once __DIR__.'/includes/config.php';

$id = $_GET['id'];

$formEditaCiclo = new \es\ucm\fdi\aw\Ciclos\FormularioEditaCiclo($id);
$formEditaCiclo = $formEditaCiclo->gestiona();


$tituloPagina = 'Edita Ciclo';
$contenidoPrincipal=<<<EOF
  	<h1>Editar ciclo</h1>
    $formEditaCiclo
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
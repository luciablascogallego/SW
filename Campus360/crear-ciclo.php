<?php

require_once __DIR__.'/includes/config.php';

$formCreaCiclo = new \es\ucm\fdi\aw\usuarios\FormularioCreaCiclo();
$formCreaCiclo = $formCreaCiclo->gestiona();


$tituloPagina = 'Nuevo Ciclo';
$contenidoPrincipal=<<<EOF
  	<h1>Crear nuevo ciclo</h1>
    $formCreaCiclo
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
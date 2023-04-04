<?php

require_once __DIR__.'/includes/config.php';

$formNuevoUsuario = new \es\ucm\fdi\aw\usuarios\FormularioNuevoUsuario();
$formNuevoUsuario = $formNuevoUsuario->gestiona();


$tituloPagina = 'Nuevo Usuario';
$contenidoPrincipal=<<<EOF
  	<h1>Crear nuevo usuario</h1>
    $formNuevoUsuario
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
<?php

require_once __DIR__.'/includes/config.php';

$id = $_GET['id'];

$formEditaUsuario = new \es\ucm\fdi\aw\usuarios\FormularioEditaUsuario($id);
$formEditaUsuario = $formEditaUsuario->gestiona();


$tituloPagina = 'Edita Usuario';
$contenidoPrincipal=<<<EOF
  	<h1>Cambio datos del usuario</h1>
    $formEditaUsuario
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
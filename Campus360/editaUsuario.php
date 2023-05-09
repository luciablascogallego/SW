<?php

require_once __DIR__.'/includes/config.php';

$id = $_POST['id'];

$formEditaUsuario = new \es\ucm\fdi\aw\usuarios\FormularioEditaUsuario($id);
$formEditaUsuario = $formEditaUsuario->gestiona();

$tituloPagina = 'Editar usuario';

$contenidoPrincipal=<<<EOF
  	<h1>Cambio datos del usuario</h1>
    $formEditaUsuario
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
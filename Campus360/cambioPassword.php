<?php

require_once __DIR__.'/includes/config.php';

$formNewPass = new \es\ucm\fdi\aw\usuarios\FormularioNewPass();
$formNewPass = $formNewPass->gestiona();


$tituloPagina = 'Cambio de Contraseña';
$contenidoPrincipal=<<<EOF
  	<h1>Cambio de contraseña</h1>
    $formNewPass
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaLogin.php', $params);
?>
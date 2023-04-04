<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Admin';
$contenidoPrincipal='<h1> Consola de administración Campus360</h1>';

$contenidoPrincipal.= <<<EOS
                    <a href="creaUsuario.php">crear usuario</a>
                    EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
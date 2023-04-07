<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Admin';
$contenidoPrincipal='<h1> Consola de administración Campus360</h1>';

$contenidoPrincipal .= '<ul>';

$contenidoPrincipal.= <<<EOS
                    <li><a href="usuariosAdmin.php">gestionar usuarios</a></li>
                    EOS;

$contenidoPrincipal.= <<<EOS
        <li><a href="asignaturasAdmin.php">gestionar Asignaturas</a></li>
        EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
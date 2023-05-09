<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Admin';
$contenidoPrincipal='<h1> Consola de administración Campus360</h1>';

$contenidoPrincipal .= '<div class="administrar"><ul>';

$contenidoPrincipal.= <<<EOS
                    <li><a href="usuariosAdmin.php">Gestionar Usuarios</a></li>
                    EOS;

$contenidoPrincipal.= <<<EOS
        <li><a href="asignaturasAdmin.php">Gestionar Asignaturas</a></li>
        EOS;

$contenidoPrincipal .= '</ul></div>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
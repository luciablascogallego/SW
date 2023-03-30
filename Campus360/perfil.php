<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil de usuario';

$contenidoPrincipal = '<h1>Perfil de usuario</h1>';

$email = $app->emailUsuario();
$telefono = $app->telefonoUsuario();

$contenidoPrincipal .= '<ul>';
$contenidoPrincipal .= '<li>Nombre: '.$app->nombreUsuario(). '</li>'; 
$contenidoPrincipal .= '<li>Apellidos: '.$app->apellidosUsuario(). '</li>'; 
$contenidoPrincipal .= '<li>NIF: '.$app->NIFUsuario(). '</li>'; 
$contenidoPrincipal .= <<<EOS
    <li>Telefono: <a href="telf:$telefono">$telefono</a> </li>
EOS;  
$contenidoPrincipal .= '<li>Direccion: '.$app->direccionUsuario(). '</li>'; 
$contenidoPrincipal .= <<<EOS
    <li>Email: <a href="mailto:$email">$email</a> </li>
EOS;       
$contenidoPrincipal .= '</ul>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
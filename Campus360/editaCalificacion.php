<?php

require_once __DIR__.'/includes/config.php';

use \es\ucm\fdi\aw\Calificaciones\Calificacion;

$id = $_POST['id'];

$calificacion = Calificacion::buscaPorId($id);


$formEditaCalificacion = new \es\ucm\fdi\aw\Calificaciones\FormularioEditaCalificacion($calificacion);
$formEditaCalificacion = $formEditaCalificacion->gestiona();
$tituloPagina = 'Editar calificacion';

$contenidoPrincipal=<<<EOF
  	<h1>Editar calificación</h1>
    $formEditaCalificacion
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
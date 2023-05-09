<?php

require_once __DIR__.'/includes/config.php';

use \es\ucm\fdi\aw\Calificaciones\Calificacion;

$id = $_POST['id'];

$calificacion = Calificacion::buscaPorId($id);

$formEditCalifEntrega = new \es\ucm\fdi\aw\Calificaciones\FormularioEditCalifEntrega($calificacion);
$formEditCalifEntrega = $formEditCalifEntrega->gestiona();;

$tituloPagina = 'Crear calificación entrega';

$contenidoPrincipal=<<<EOF
  	<h1>Añadir calificación a la entrega</h1>
    $formEditCalifEntrega
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
<?php

require_once __DIR__.'/includes/config.php';

use \es\ucm\fdi\aw\Calificaciones\Calificacion;

$idAlu = $_POST['id'];
$idEntrega = $_POST['id2'];


$formCalifEntrega = new \es\ucm\fdi\aw\Calificaciones\FormularioCalificacionEntrega($idEntrega, $idAlu);
$formCalifEntrega = $formCalifEntrega->gestiona();

$tituloPagina = 'Crear calificación entrega';

$contenidoPrincipal=<<<EOF
  	<h1>Añadir calificación a la entrega</h1>
    $formCalifEntrega
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
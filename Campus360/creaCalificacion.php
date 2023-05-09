<?php

require_once __DIR__.'/includes/config.php';

use \es\ucm\fdi\aw\Calificaciones\Calificacion;

$idAlu = $_POST['id'];
$idAsig = $_POST['id2'];


$formNuevaCalificacion = new \es\ucm\fdi\aw\Calificaciones\FormularioNuevaCalificacion($idAsig, $idAlu);
$formNuevaCalificacion = $formNuevaCalificacion->gestiona();

$tituloPagina = 'Crear calificación';

$contenidoPrincipal=<<<EOF
  	<h1>Crear calificación</h1>
    $formNuevaCalificacion
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
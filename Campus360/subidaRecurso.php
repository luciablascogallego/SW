<?php

require_once __DIR__.'/includes/config.php';

$id = $_POST['id'];


$formSubeArchivo = new \es\ucm\fdi\aw\Recurso\FormularioSubeArchivo($id, null);
$formSubeArchivo = $formSubeArchivo->gestiona();

$tituloPagina = 'Subir recursos';

$contenidoPrincipal=<<<EOF
  	<h1>Añadir recursos a la asignatura</h1>
    $formSubeArchivo
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
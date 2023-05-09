<?php

require_once __DIR__.'/includes/config.php';

$id = $_POST['id'];
$idEntrega = $_POST['id2'];


$formSubeEntrega = new \es\ucm\fdi\aw\Recurso\FormularioSubeArchivo($id, $idEntrega);
$formSubeEntrega = $formSubeEntrega->gestiona();

$tituloPagina = 'Subir entrega';

$contenidoPrincipal=<<<EOF
  	<h1>Subir entrega</h1>
    $formSubeEntrega
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
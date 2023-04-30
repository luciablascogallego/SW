<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\MensajesPrivados\MensajePrivado;

$idA = $_GET['idA'];
$idR = $_GET['idR'];

$listaMensajes = MensajePrivado::getMensajesChat($idA, $idR);

// Convertir el array en un objeto JSON
$json = json_encode($listaMensajes);

// Devolver el objeto JSON como respuesta
echo $json;
?>
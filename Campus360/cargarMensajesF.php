<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\MensajesForo\MensajeForo;

// Recoger datos con json_decode en PHP
$idAsignatura = $_GET['idAsignatura'];

$listaMensajes = MensajeForo::getMensajesAsignatura($idAsignatura);

// Convertir el array en un objeto JSON
$json = json_encode($listaMensajes);

// Devolver el objeto JSON como respuesta
echo $json;
?>
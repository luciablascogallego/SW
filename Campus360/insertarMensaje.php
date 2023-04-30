<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\MensajesForo\MensajeForo;
use es\ucm\fdi\aw\usuarios\Usuario;

// Recoger datos con json_decode en PHP
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$nombreUsuario = $data['nombreUsuario'];
$idUsuario = $data['idUsuario'];
$mensaje = $data['mensaje'];
$asignatura = $data['idAsignatura'];

$usuario = Usuario::buscaPorId($idUsuario);
$nombre = $usuario->getNombre();
$fecha = date('Y-m-d H:i:s');
// Crear un nuevo objeto Mensaje con los datos obtenidos
$nuevoMensaje = MensajeForo::crea(null, $idUsuario, $asignatura, $mensaje, $nombre, $fecha);
?>

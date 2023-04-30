<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\MensajesPrivados\MensajePrivado;
use es\ucm\fdi\aw\usuarios\Usuario;

// Recoger datos con json_decode en PHP
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$idAutor = $data['idUsuario'];
$mensaje = $data['mensaje'];
$idRemitente = $data['idDestinatario'];

$usuario = Usuario::buscaPorId($idRemitente);
$remitente = $usuario->getNombre();
$fecha = date('Y-m-d H:i:s');
// Crear un nuevo objeto Mensaje con los datos obtenidos
$nuevoMensaje = MensajePrivado::crea(null, $idAutor, $idRemitente, $mensaje, $fecha);

echo $remitente;
?>

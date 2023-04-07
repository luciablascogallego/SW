<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Aplicacion;

$idUsuario = $_GET['id'];

Usuario::borraPorId($idUsuario);

Aplicacion::redirige('usuariosAdmin.php');

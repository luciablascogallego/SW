<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Aplicacion;

$idAsignatura = $_GET['id'];

Asignatura::borra($idAsignatura);

Aplicacion::redirige('asignaturasAdmin.php');

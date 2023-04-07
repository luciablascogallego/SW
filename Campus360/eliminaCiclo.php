<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Ciclos\Ciclo;
use es\ucm\fdi\aw\Aplicacion;

$idCiclo = $_GET['id'];

Ciclo::borraPorId($idCiclo);

Aplicacion::redirige('asignaturasAdmin.php');

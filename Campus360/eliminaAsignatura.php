<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Recurso\Recursos;
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Aplicacion;

$idAsignatura = $_GET['id'];

$archivos = Recursos::getRecursosAsignatura($idAsignatura);
$entregas = EntregasAlumno::getEntregasAsignatura($idAsignatura);

if (!empty($archivos)) {
    foreach ($archivos as $archivo) {
        $ruta = $archivo['Ruta'];
        unlink($ruta);
    }
}

if (!empty($entregas)) {
    foreach ($entregas as $entrega) {
        $ruta = $entrega['Ruta'];
        unlink($ruta);
    }
}


Asignatura::borra($idAsignatura);

Aplicacion::redirige('asignaturasAdmin.php');

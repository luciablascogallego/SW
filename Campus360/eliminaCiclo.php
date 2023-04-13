<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Ciclos\Ciclo;
use es\ucm\fdi\aw\Recurso\Recursos;
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Aplicacion;

$idCiclo = $_GET['id'];

$asignaturas = Asignatura::buscaPorCiclo($idCiclo);

if($asignaturas){
    foreach($asignaturas as $asignatura){
        $archivos = Recursos::getRecursosAsignatura($asignatura['Id']);
        $entregas = EntregasAlumno::getEntregasAsignatura($asignatura['Id']);
        
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
    }
}

Ciclo::borraPorId($idCiclo);

Aplicacion::redirige('asignaturasAdmin.php');

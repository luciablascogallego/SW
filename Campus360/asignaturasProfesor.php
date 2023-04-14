<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Profesores\Profesor;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Ciclos\Ciclo;

$tituloPagina = 'Asignaturas profesor';
$contenidoPrincipal = '<h1>Asignaturas impartidas</h1>';


$profesorId = $app->idUsuario();
$profesor = Profesor::buscaPorId($profesorId);
$asignaturas = $profesor->getIdAsignaturas();
if ($asignaturas) {
    $contenidoPrincipal .= '<ul>';
        foreach ($asignaturas as $idAsignatura) {
            $asignatura = Asignatura::buscaPorId($idAsignatura);
            $id = $asignatura->getId();
            echo $id;
            $nombre = $asignatura->getNombre();
            $curso = $asignatura->getCurso();
            $Idciclo = $asignatura->getCiclo();
            $ciclo = Ciclo::buscaPorId($Idciclo);
            $nombreCiclo = $ciclo->getNombre();
            $grupo = $asignatura->getGrupo();
            if($asignatura)
                $contenidoPrincipal .= <<<EOS
                    <li><a href="contenidoAsignatura.php?id=$id">$nombre $nombreCiclo $curso º $grupo</a> </li>
                EOS;  
        } 
    $contenidoPrincipal .= '</ul>';
} else {
    $contenidoPrincipal .= '<p>No se encontraron asignaturas impartidas para el profesor </p>';
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
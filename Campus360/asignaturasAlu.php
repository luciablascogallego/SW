<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Ciclos\Ciclo;

$tituloPagina = 'Asignaturas alumno';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';

    $alumnoId = $app->idUsuario();
    $alumno = Alumno::buscaPorId($alumnoId);
    $asignaturas = $alumno->getIdAsignaturas();
    if ($asignaturas) {
        $contenidoPrincipal .= '<div class="asignaturas"><ul>';
        foreach ($asignaturas as $idAsignatura) {
            $asignatura = Asignatura::buscaPorId($idAsignatura);
            $id = $asignatura->getId();
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
        $contenidoPrincipal .= '</ul></div>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
    } 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
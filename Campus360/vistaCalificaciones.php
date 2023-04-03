<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Asignaturas\Asignatura;

$tituloPagina = 'Calificaciones alumno';

$contenidoPrincipal = '<h1>Asignaturas disponibles para calificaciones</h1>';

if (($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE))) {
    $alumnoId = $app->idUsuario();
    $alumno = Alumno::buscaPorId($alumnoId);
    $asignaturas = $alumno->getIdAsignaturas();
    if ($asignaturas) {
        $contenidoPrincipal .= '<ul>';
        foreach ($asignaturas as $Idasignatura) {
            $asignatura = Asignatura::buscaPorId($Idasignatura);
            $id = $asignatura->getId();
            $nombre = $asignatura->getNombre();
            $curso = $asignatura->getCurso();
            $ciclo = $asignatura->getCiclo();
            $grupo = $asignatura->getGrupo();
            if($asignatura)
            $contenidoPrincipal .= <<<EOS
            <li><a href="calificacionAsignatura.php?id=$Idasignatura">$nombre $ciclo $curso º $grupo</a> </li>
            EOS;              
          }          
        $contenidoPrincipal .= '</ul>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
    }

} 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Profesores\Profesor;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Ciclos\Ciclo;

$tituloPagina = 'Calificaciones';

$contenidoPrincipal = '<h1>Asignaturas disponibles para calificaciones</h1>';

if (($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE))) {
    $alumnoId = $app->idUsuario();
    $alumno = Alumno::buscaPorId($alumnoId);
    $asignaturas = $alumno->getIdAsignaturas();
    if ($asignaturas) {
        $contenidoPrincipal .= '<div class="asignaturas"><ul>';
        foreach ($asignaturas as $Idasignatura) {
            $asignatura = Asignatura::buscaPorId($Idasignatura);
            $id = $asignatura->getId();
            $nombre = $asignatura->getNombre();
            $curso = $asignatura->getCurso();
            $Idciclo = $asignatura->getCiclo();
            $ciclo = Ciclo::buscaPorId($Idciclo);
            $nombreCiclo = $ciclo->getNombre();
            $grupo = $asignatura->getGrupo();
            if($asignatura)
            $contenidoPrincipal .= <<<EOS
            <li><a href="calificacionAsignatura.php?id=$Idasignatura&id2=$alumnoId">$nombre $nombreCiclo $curso º $grupo</a> </li>
            EOS;              
          }          
        $contenidoPrincipal .= '</ul></div>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
    }

} 

if (($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE))) {
    $profesorId = $app->idUsuario();
    $profesor = Profesor::buscaPorId($profesorId);
    $asignaturas = $profesor->getIdAsignaturas();
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

            $contenidoPrincipal .= <<<EOS
            <li><a href="alumnosCalificaciones.php?id=$id">$nombre $nombreCiclo $curso º $grupo</a> </li>
            EOS;              
          }          
        $contenidoPrincipal .= '</ul></div>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el profesor </p>';
    }

}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
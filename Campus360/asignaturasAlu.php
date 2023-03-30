<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Asignaturas\Asignatura;

$tituloPagina = 'Asignaturas alumno';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';

    $alumnoId = $app->idUsuario();
    $alumno = Alumno::buscaPorId($alumnoId);
    if ($alumno) {
        $asignaturas = $alumno->getIdAsignaturas();
        $contenidoPrincipal .= '<ul>';
        foreach ($asignaturas as $idAsignatura) {
            $asignatura = Asignatura::buscaPorId($idAsignatura);
            $id = $asignatura->getId();
            $nombre = $asignatura->getNombre();
            $curso = $asignatura->getCurso();
            $ciclo = $asignatura->getCiclo();
            $grupo = $asignatura->getGrupo();
            if($asignatura)
                $contenidoPrincipal .= <<<EOS
                    <li><a href="contenidoAsignatura.php?id=$id">$nombre $ciclo $curso º $grupo</a> </li>
                EOS;  
          }          
        $contenidoPrincipal .= '</ul>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
    } 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
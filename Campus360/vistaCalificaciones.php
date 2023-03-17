<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Calificaciones alumno';

$contenidoPrincipal = '<h1>Asignaturas disponibles para calificaciones</h1>';

if (($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE))) {
    $alumnoId = $app->idUsuario();
    $asignaturas = es\ucm\fdi\aw\Alumnos\Alumno::asignaturasAlumno($alumnoId);
    if ($asignaturas) {
        $contenidoPrincipal .= '<ul>';
        foreach ($asignaturas as $asignatura) {
            $contenidoPrincipal .= '<li><a href="calificacionAsignatura.php?id='.$asignatura['id'].'">'.$asignatura['nombre'].'</a></li>';
          }          
        $contenidoPrincipal .= '</ul>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
    }

} 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
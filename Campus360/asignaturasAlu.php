<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Asignaturas alumno';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';

if (isset($_GET['alumnoId'])) {
    $padreId = $_GET['alumnoId'];
    $asignaturas = obtenerAsignaturasPorAlumno($alumnohId);
    if ($asignaturas) {
        $contenidoPrincipal .= '<ul>';
        foreach ($asignaturas as $asignatura) {
            $contenidoPrincipal .= '<li><a href="contenidoAsignatura.php?id='.$asignatura['id'].'">'.$asignatura['nombre'].'</a></li>';
          }          
        $contenidoPrincipal .= '</ul>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
    }

} 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
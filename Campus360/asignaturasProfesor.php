<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Asignaturas padres';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';

if (isset($_GET['profesorId'])) {
    $profesorId = $_GET['profesorId'];
    $asignaturas = obtenerAsignaturasPorProfesor($profesorId);
    if ($asignaturas) {
        $contenidoPrincipal .= '<ul>';
        foreach ($asignaturas as $asignatura) {
            $contenidoPrincipal .= '<li><a href="contenidoAsignatura.php?id='.$asignatura->getId().'">'.$asignatura->getNombre().'</a></li>';
          }          
        $contenidoPrincipal .= '</ul>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el profesor </p>';
    }

} 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
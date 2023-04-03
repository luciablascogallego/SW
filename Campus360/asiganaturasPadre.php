<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Asignaturas padre';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';

if (isset($_GET['padreId'])) {
    $padreId = $_GET['padreId'];
    $asignaturas = obtenerAsignaturasPorPadre($padreId);
    if ($asignaturas) {
        $contenidoPrincipal .= '<ul>';
        foreach ($asignaturas as $asignatura) {
            $contenidoPrincipal .= '<li><a href="contenidoAsignatura.php?id='.$asignatura['id'].'">'.$asignatura['nombre'].'</a></li>';
          }          
        $contenidoPrincipal .= '</ul>';
    } else {
        $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para su hijo </p>';
    }

} 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
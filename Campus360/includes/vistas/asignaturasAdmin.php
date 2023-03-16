<?php
require_once __DIR__.'/includes/config.php';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';

if (isset($_GET['curso'])) {
    $cicloId = $_GET['curso'];
    $ciclo = obtenerCicloPorId($cursoId);
    if ($ciclo) {
        $asignaturas = obtenerAsignaturasPorCurso($cicloId);
        if ($asignaturas) {
            $contenidoPrincipal .= '<ul>';
            foreach ($asignaturas as $asignatura) {
                $contenidoPrincipal .= '<li>'.$asignatura['nombre'].'<form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$asignatura['id'].'"><input type="hidden" name="accion" value="eliminar"><button type="submit">Eliminar</button></form><form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$asignatura['id'].'"><input type="hidden" name="accion" value="editar"><button type="submit">Editar</button></form></li>';
            }
            $contenidoPrincipal .= '</ul>';
        } else {
            $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el curso '.$curso['nombre'].'.</p>';
        }
    } else {
        $contenidoPrincipal .= '<p>No se encontró el curso indicado.</p>';
    }
} else {
    $contenidoPrincipal .= '<p>No se indicó un curso para mostrar.</p>';
}

$contenidoPrincipal .= '<a href="crear-asignatura.php">Crear nueva asigantura</a>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
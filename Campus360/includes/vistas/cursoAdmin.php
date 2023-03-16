<?php
require_once __DIR__.'/includes/config.php';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';

if (isset($_GET['ciclo'])) {
    $cicloId = $_GET['ciclo'];
    $ciclo = obtenerCicloPorId($cicloId);
    if ($ciclo) {
        $cursos = obtenerCursosPorCiclo($cicloId);
        if ($cursos) {
            $contenidoPrincipal .= '<ul>';
            foreach ($cursos as $curso) {
                $contenidoPrincipal .= '<li>'.$curso['nombre'].'<form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$curso['id'].'"><input type="hidden" name="accion" value="eliminar"><button type="submit">Eliminar</button></form><form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$curso['id'].'"><input type="hidden" name="accion" value="editar"><button type="submit">Editar</button></form><a href="asignaturasAdmin.php?ciclo='.$curso['id'].'">Ver asignaturas</a></li>';
            }
            $contenidoPrincipal .= '</ul>';
        } else {
            $contenidoPrincipal .= '<p>No se encontraron cursos disponibles para el ciclo '.$ciclo['nombre'].'.</p>';
        }
    } else {
        $contenidoPrincipal .= '<p>No se encontró el ciclo indicado.</p>';
    }
} else {
    $contenidoPrincipal .= '<p>No se indicó un ciclo para mostrar.</p>';
}

$contenidoPrincipal .= '<a href="crear-curso.php">Crear nuevo curso</a>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
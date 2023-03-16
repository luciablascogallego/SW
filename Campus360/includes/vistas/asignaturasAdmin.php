<?php
require_once __DIR__.'/includes/config.php';
$contenidoPrincipal = '<h1>Asignaturas disponibles</h1>';
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if ($accion === 'eliminar' && isset($_POST['id'])) {
        // Aquí deberías agregar el código para eliminar el ciclo con el ID indicado desde la base de datos
        $id = $_POST['id'];
        eliminarAsignatura($id);
    } else if ($accion === 'editar' && isset($_POST['id'])) {
        // Aquí deberías redirigir al usuario a la página de edición del ciclo con el ID indicado
        $id = $_POST['id'];
        header('Location: editar-ciclo.php?id='.$id);
        exit;
    }
}

if (isset($_GET['curso'])) {
    $cursoId = $_GET['curso'];
        $asignaturas = obtenerAsignaturasPorCurso($cursoId);
        if ($asignaturas) {
            $contenidoPrincipal .= '<ul>';
            foreach ($asignaturas as $asignatura) {
                $contenidoPrincipal .= '<li>'.$asignatura['nombre'].'<form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$asignatura['id'].'"><input type="hidden" name="accion" value="eliminar"><button type="submit">Eliminar</button></form><form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$asignatura['id'].'"><input type="hidden" name="accion" value="editar"><button type="submit">Editar</button></form></li>';
            }
            $contenidoPrincipal .= '</ul>';
        } else {
            $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el curso '.$curso['nombre'].'.</p>';
        }
 
} 

$contenidoPrincipal .= '<a href="crear-asignatura.php">Crear nueva asigantura</a>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
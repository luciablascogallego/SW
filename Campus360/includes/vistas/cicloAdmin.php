<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Ciclos';
$contenidoPrincipal = '<h1>Ciclos disponibles</h1>';

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if ($accion === 'eliminar' && isset($_POST['id'])) {
        // Aquí deberías agregar el código para eliminar el ciclo con el ID indicado desde la base de datos
        $id = $_POST['id'];
        eliminarCiclo($id);
    } else if ($accion === 'editar' && isset($_POST['id'])) {
        // Aquí deberías redirigir al usuario a la página de edición del ciclo con el ID indicado
        $id = $_POST['id'];
        header('Location: editar-ciclo.php?id='.$id);
        exit;
    }
}

$ciclos = obtenerCiclos();

if ($ciclos) {
    $contenidoPrincipal .= '<ul>';
    foreach ($ciclos as $ciclo) {
        $contenidoPrincipal .= '<li>'.$ciclo['nombre'].'<form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$ciclo['id'].'"><input type="hidden" name="accion" value="eliminar"><button type="submit">Eliminar</button></form><form method="POST" style="display: inline-block;"><input type="hidden" name="id" value="'.$ciclo['id'].'"><input type="hidden" name="accion" value="editar"><button type="submit">Editar</button></form><a href="cursoAdmin.php?ciclo='.$ciclo['id'].'">Ver cursos</a></li>';
         }
    $contenidoPrincipal .= '</ul>';
} else {
    $contenidoPrincipal .= '<p>No se encontraron ciclos disponibles.</p>';
}

$contenidoPrincipal .= '<a href="crear-ciclo.php">Crear nuevo ciclo</a>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);

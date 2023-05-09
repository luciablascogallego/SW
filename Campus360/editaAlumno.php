<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;

//$id = $_SESSION['idAlumnoEditado'];

$id = $_POST['id'];

$formEditaAlumno = new \es\ucm\fdi\aw\Alumnos\FormularioEditaAlumno($id);
$formEditaAlumno = $formEditaAlumno->gestiona();


$tituloPagina = 'Edita Alumno';
$contenidoPrincipal=<<<EOF
  	<h1>Editar alumno</h1>
    $formEditaAlumno
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
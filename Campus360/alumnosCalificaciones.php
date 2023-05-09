<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\usuarios\Usuario;

$tituloPagina = 'Alumnos asignatura';
$contenidoPrincipal = '<h1>Alumnos</h1><div id="alumnosCalificacion">';

$idAsignatura = $_GET['id'];
$tituloPagina = "Alumnos Calificaciones";

$alumnos = Alumno::estudianAsignatura($idAsignatura);
if ($alumnos) {
    $contenidoPrincipal .= '<fieldset>
        <legend> Alumnos </legend>';
    $contenidoPrincipal .= '<ul>';
    foreach ($alumnos as $alumno) {
        $usuario = Usuario::buscaPorId($alumno['IdAlumno']);
        $id = $usuario->getId();
        $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
        $contenidoPrincipal .= <<<EOS
        <li><a href="calificacionAsignatura.php?id=$idAsignatura&id2=$id">$nombre</a></li>
        EOS;
    }
    $contenidoPrincipal .= '</ul></fieldset>';
}      
    
else {
    $contenidoPrincipal .= '<p>No se encontraron alumnos</p>';
} 

$contenidoPrincipal .= '<button  id="cambiarPorcentajes" value="'.$idAsignatura.'">Cambiar Porcentajes</button></div>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
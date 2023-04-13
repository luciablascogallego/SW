<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Profesores\Profesor;
use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\usuarios\Usuario;

$tituloPagina = 'Usuarios campus';
$contenidoPrincipal = '<h1>Usuarios Campus360</h1>';

$contenidoPrincipal .= <<<EOS
                        <div> <a href="creaUsuario.php"> Crear un nuevo usuario </a> </div>
                    EOS;

$admins = Usuario::admins();
$contenidoPrincipal .= '<fieldset>
<legend> Administradores </legend>';
if ($admins) {
    $contenidoPrincipal .= '<ul>';
    foreach ($admins as $admin) {
        $id = $admin->getId();
        $nombre = $admin->getNombre().' '.$admin->getApellidos();
        $contenidoPrincipal .= <<<EOS
        
        <div>
        <li>$nombre<div class="eliminarU"><a href="eliminaUsuario.php?id=$id"> Eliminar admin</a>        </div>
        ||<a href="editaUsuario.php?id=$id"> Editar </a> </li>
        </div>
        EOS;
    }
    $contenidoPrincipal .= '</ul>';
}      
    
else {
    $contenidoPrincipal .= '<p>No se encontraron administradores</p>';
} 

$contenidoPrincipal .= '</fieldset>';

$profes = Profesor::listaProfesores();
$contenidoPrincipal .= '<fieldset>
<legend> Profesores </legend>';
if ($profes) {
    $contenidoPrincipal .= '<ul>';
    foreach ($profes as $profe) {
        $usuario = Usuario::buscaPorId($profe['IdProfesor']);
        $id = $usuario->getId();
        $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
        $contenidoPrincipal .= <<<EOS
        <<div>
        <li>$nombre<div class="eliminarU"><a href="eliminaUsuario.php?id=$id"> Eliminar admin</a>        </div>
        ||<a href="editaUsuario.php?id=$id"> Editar </a> </li>
        </div>
        EOS;
    }
    $contenidoPrincipal .= '</ul>';
}      
    
else {
    $contenidoPrincipal .= '<p>No se encontraron profesores</p>';
} 
$contenidoPrincipal .= '</fieldset>';

$padres = Padre::padres();
$contenidoPrincipal .= '<fieldset>
<legend> Padres </legend>';
if ($padres) {
    $contenidoPrincipal .= '<ul>';
    foreach ($padres as $padre) {
        $usuario = Usuario::buscaPorId($padre['IdPadre']);
        $id = $usuario->getId();
        $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
        $contenidoPrincipal .= <<<EOS
        <div>
        <li>$nombre<div class="eliminarU"><a href="eliminaUsuario.php?id=$id"> Eliminar padre</a>        </div>
        ||<a href="editaUsuario.php?id=$id"> Editar </a> </li>
        </div>
        EOS;
    }
    $contenidoPrincipal .= '</ul>';
}      
    
else {
    $contenidoPrincipal .= '<p>No se encontraron padres</p>';
} 
$contenidoPrincipal .= '</fieldset>';

$alumno = Alumno::listaAlumnos();
$contenidoPrincipal .= '<fieldset>
<legend> Alumnos </legend>';
if ($alumno) {
    $contenidoPrincipal .= '<ul>';
    foreach ($alumno as $alumno) {
        $usuario = Usuario::buscaPorId($alumno['IdAlumno']);
        $id = $usuario->getId();
        $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
        $contenidoPrincipal .= <<<EOS
        <div>
        <li>$nombre<div class="eliminarU"><a href="eliminaUsuario.php?id=$id"> Eliminar alumno</a>        </div>
        ||<a href="editaUsuario.php?id=$id"> Editar </a> </li>
        </div>
        EOS;
    }
    $contenidoPrincipal .= '</ul>';
}      
    
else {
    $contenidoPrincipal .= '<p>No se encontraron alumnos</p>';
} 
$contenidoPrincipal .= '</fieldset>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Profesores\Profesor;
use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\Aplicacion;

$idUsuario = $_POST['id'];

Usuario::borraPorId($idUsuario);

if($idUsuario == $app->idUsuario()){
    $formLogout = new \es\ucm\fdi\aw\usuarios\FormularioLogout();
    $formLogout->gestiona();
    
    echo 'logout';
}

else{

    $contenidoPrincipal = '<h1>Usuarios Campus360</h1>';

    $contenidoPrincipal .= <<<EOS
                            <button id="crearU">Crear un nuevo usuario</button>
                        EOS;

    $admins = Usuario::admins();
    $contenidoPrincipal .= '<fieldset>
    <legend> Administradores </legend>';
    if ($admins) {
        $contenidoPrincipal .= '<ul>';
        foreach ($admins as $admin) {
            $id = $admin->getId();
            $nombre = $admin->getNombre().' '.$admin->getApellidos().' ';
            $contenidoPrincipal .= <<<EOS
            <li>$nombre<button class="eliminarU" value="$id">Eliminar admin</button>
            <button class="editarU" value="$id">Editar</button></li>
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
            $nombre = $usuario->getNombre().' '.$usuario->getApellidos().' ';
            $contenidoPrincipal .= <<<EOS
            <li>$nombre<button class="eliminarU" value="$id">Eliminar profesor</button>
            <button class="editarU" value="$id">Editar</button></li>
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
            $nombre = $usuario->getNombre().' '.$usuario->getApellidos().' ';
            $contenidoPrincipal .= <<<EOS
            <li>$nombre<button class="eliminarU" value="$id">Eliminar padre</button>
            <button class="editarU" value="$id">Editar</button>
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
            $nombre = $usuario->getNombre().' '.$usuario->getApellidos().' ';
            $contenidoPrincipal .= <<<EOS
            <li>$nombre<button class="eliminarU" value="$id">Eliminar alumno</button>
            <button class="editarU" value="$id">Editar</button></li>
            EOS;
        }
        $contenidoPrincipal .= '</ul>';
    }      
        
    else {
        $contenidoPrincipal .= '<p>No se encontraron alumnos</p>';
    } 
    $contenidoPrincipal .= '</fieldset>';

    echo $contenidoPrincipal;
}

<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Ciclos\Ciclo;

$tituloPagina = 'Asignaturas campus';
$contenidoPrincipal = '<h1>Asignaturas Campus360</h1>';

$contenidoPrincipal .= <<<EOS
                        <p> <a href="crear-asignatura.php"> Crear nueva asignatura </a> </p>
                    EOS;

$contenidoPrincipal .= <<<EOS
                    <p> <a href="crear-ciclo.php"> Crear nuevo ciclo </a> </p>
                    EOS;

$ciclos = Ciclo::ciclosCampus();
if ($ciclos) {
    foreach ($ciclos as $ciclo) {
        $contenidoPrincipal .= '<fieldset>
        <legend>'.$ciclo['Nombre'].'</legend>';
        $idCiclo = $ciclo['Id'];
        for($i = 1; $i < 5; $i++){
            $contenidoPrincipal .= '<ul>';
            $asignaturas = Asignatura::buscaPorCicloCurso($idCiclo, $i);
            foreach($asignaturas as $asignatura){
                if($asignatura){
                    $id = $asignatura['Id'];
                    $nombre = $asignatura['Nombre'];
                    $curso = $asignatura['Curso'];
                    $grupo = $asignatura['Grupo'];
                    $contenidoPrincipal .= <<<EOS
                        <li>$nombre $curso º $grupo<a href="eliminaAsignatura.php?id=$id"> Eliminar Asignatura</a>||<a href="editaAsignatura.php?id=$id">Editar Asignatura</a>
                        ||<a href="añadeAsignatura.php?id=$id"> Gestionar alumnos</a>
                        </li>
                    EOS;  
                }
            } 
            $contenidoPrincipal .= '</ul>';
        }
        $contenidoPrincipal .= <<<EOS
        <div>
        <a href="eliminaCiclo.php?id=$idCiclo"> Eliminar Ciclo</a>||<a href="editaCiclo.php?id=$idCiclo"> Editar Ciclo</a>
        </div>
        </fieldset>
        EOS;
    }
}      
    
else {
    $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
} 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
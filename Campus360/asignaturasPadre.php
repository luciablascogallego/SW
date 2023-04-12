<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Ciclos\Ciclo;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Alumnos\Alumno;

$tituloPagina = 'Asignaturas padre';
$contenidoPrincipal = '<h1>Asignaturas disponibles para los hijos</h1>';

    $padreId = $app->idUsuario();
    $padre = Padre::buscaPorId($padreId);
    //$padre = Padre::hijos($padre);
    $hijos = $padre->getHijos();
    if ($hijos) {
        foreach ($hijos as $idHijo) {
            $usuario = Usuario::buscaPorId($idHijo);
            $nombre = $usuario->getNombre() .' '. $usuario->getApellidos();
            $contenidoPrincipal .= '<fieldset>
                <legend>' .$nombre. '</legend>';
          $alumno = Alumno::buscaPorId($idHijo);
          $asignaturas = $alumno->getIdAsignaturas();
            if ($asignaturas) {
                $contenidoPrincipal .= '<ul>';
                foreach ($asignaturas as $idAsignatura) {
                    $asignatura = Asignatura::buscaPorId($idAsignatura);
                    $id = $asignatura->getId();
                    $nombre = $asignatura->getNombre();
                    $curso = $asignatura->getCurso();
                    $Idciclo = $asignatura->getCiclo();
                    $ciclo = Ciclo::buscaPorId($Idciclo);
                    $nombreCiclo = $ciclo->getNombre();
                    $grupo = $asignatura->getGrupo();
                    if($asignatura)
                        $contenidoPrincipal .= <<<EOS
                            <li><a href="contenidoAsignatura.php?id=$id">$nombre $nombreCiclo $curso º $grupo</a> </li>
                        EOS;  
                }          
                $contenidoPrincipal .= '</ul>';
                } else {
                    $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
                }  
                $contenidoPrincipal .= '</fieldset>';
        }       
    } else {
        $contenidoPrincipal .= '<p>No se encontraron hijos para este padre </p>';
    } 
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
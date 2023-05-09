<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Ciclos\Ciclo;
use es\ucm\fdi\aw\Recurso\Recursos;
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Aplicacion;

$idCiclo = $_POST['id'];

$asignaturas = Asignatura::buscaPorCiclo($idCiclo);

if($asignaturas){
    foreach($asignaturas as $asignatura){
        $archivos = Recursos::getRecursosAsignatura($asignatura['Id']);
        $entregas = EntregasAlumno::getEntregasAsignatura($asignatura['Id']);
        
        if (!empty($archivos)) {
            foreach ($archivos as $archivo) {
                $ruta = $archivo['Ruta'];
                unlink($ruta);
            }
        }
        
        if (!empty($entregas)) {
            foreach ($entregas as $entrega) {
                $ruta = $entrega['Ruta'];
                unlink($ruta);
            }
        }
    }
}

Ciclo::borraPorId($idCiclo);

$contenidoPrincipal = '<h1>Asignaturas Campus360</h1>';

$contenidoPrincipal .= <<<EOS
                    <p> <button id="CrearCiclo"> Crear ciclo </button> </p>
                    EOS;

$contenidoPrincipal .= <<<EOS
                       
                    <p> <button id="CrearAsig"> Crear asignatura </button> </p>
                EOS;

$ciclos = Ciclo::ciclosCampus();
if ($ciclos) {
    foreach ($ciclos as $ciclo) {
        $contenidoPrincipal .= '<fieldset>
        <legend>'.$ciclo['Nombre'].'</legend>';
        $idCiclo = $ciclo['Id'];
        for($i = 1; $i < 5; $i++){
            $contenidoPrincipal .= '<div class="asignaturasAdmin"><ul>';
            $asignaturas = Asignatura::buscaPorCicloCurso($idCiclo, $i);
            foreach($asignaturas as $asignatura){
                if($asignatura){
                    $id = $asignatura['Id'];
                    $nombre = $asignatura['Nombre'];
                    $curso = $asignatura['Curso'];
                    $grupo = $asignatura['Grupo'];
                    $contenidoPrincipal .= <<<EOS
                        <li>$nombre $curso º $grupo<button class="eliminarU" value="$id">Eliminar Asignatura</button>
                        <button class="editarU" value="$id">Editar Asignatura</button>
                        <button class="gestionar" value="$id"> Gestionar alumnos</button>
                        </li>
                    EOS;  
                }
            } 
            $contenidoPrincipal .= '</ul></div>';
        }
        $contenidoPrincipal .= <<<EOS
        <div id="GestionCiclo">
        <button class="eliminarC" value="$idCiclo">Eliminar Ciclo</button>
        <button class="editarC" value="$idCiclo">Editar Ciclo</button>
        </div>
        </fieldset>
        EOS;
    }
}      
    
else {
    $contenidoPrincipal .= '<p>No se encontraron asignaturas disponibles para el alumno </p>';
} 

echo $contenidoPrincipal;

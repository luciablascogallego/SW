<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Profesores\Profesor;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\Ciclos\Ciclo;
use es\ucm\fdi\aw\Calificaciones\Calificacion;

$idAsignatura = $_GET['id'];
$idAlu = $_GET['id2'];

$asignatura = Asignatura::buscaPorId($idAsignatura);
$ciclo = Ciclo::buscaPorId($asignatura->getCiclo());

$tituloPagina = 'Calificaciones Asignatura Alumno';

$contenidoPrincipal = '<h1>Calificaciones '. $asignatura->getNombre(). ' '. $ciclo->getNombre().$asignatura->getCurso().'º '.$asignatura->getGrupo(). '</h1>';

$notasTrimestres = array();
$mediasTrimestres = array();
$notasTrimestre = null;
$mediaTrimestre;


if (($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE))) {
    for($i = 1 ; $i < 4; $i = $i+1){
        $calificaciones = Calificacion::getCalificacionesAsignaturaAlumnoTrimestre($idAsignatura, $idAlu, $i);
        $mediaTrimestre = 0.0;
        if($calificaciones){
            foreach ($calificaciones as $calificacion){
                $nombre = $calificacion['Nombre'];
                $porcentaje = $calificacion['Porcentaje'];
                $comentario = $calificacion['Comentario'];
                $nota = $calificacion['Nota'];
    
                $notasTrimestre = <<<EOS
                                    <tr> <td>$nombre</td> <td>$porcentaje%</td><td> $nota </td> 
                                    <td> <textarea disabled> $comentario </textarea></td></tr>
                                    EOS;
                $mediaTrimestre = $mediaTrimestre + ($nota * ($porcentaje/100));
                $mediaTrimestre = number_format($mediaTrimestre, 2);
            }
        }
        else{
            $notasTrimestre = <<<EOS
            <tr> <td>--</td><td>--</td><td>--</td><td>--</td></tr>
            EOS;
        }
        array_push($notasTrimestres, $notasTrimestre);
        array_push($mediasTrimestres, $mediaTrimestre);
        $notasTrimestre = null;
    
    }
    $notaFinal = ($mediasTrimestres[0]*($asignatura->getPrimero()/100) + $mediasTrimestres[1]*($asignatura->getSegundo()/100) + $mediasTrimestres[2]*($asignatura->getTercero()/100))/3;
    $notaFinal = number_format($notaFinal, 2);
    $contenidoPrincipal .= <<<EOS
                            <div class="tablaCalif">
                            <table>
                            <tbody> <tr> <th class="Trimestre">Primer cuatrimestre  </th><td>{$asignatura->getPrimero()}</td></tr>
                                    <tr> <th> Nombre calificación </th> <th> Porcentaje </th> 
                                    <th> Nota </th> <th> Comentario</th></tr>
                                    {$notasTrimestres[0]}
                                    <tr> <th> Nota Trimestre </th> <td> {$mediasTrimestres[0]} </td> </tr>
                                    <tr> <th class="Trimestre"> Segundo cuatrimestre </th><td>{$asignatura->getSegundo()}</td></tr>
                                    <tr> <th> Nombre calificación </th> <th> Porcentaje </th> 
                                    <th> Nota </th>  <th> Comentario</th></tr>
                                    {$notasTrimestres[1]}
                                    <tr> <th> Nota Trimestre </th> <td> {$mediasTrimestres[1]}</td> </tr>
                                    <tr> <th class="Trimestre">  Tercer cuatrimestre </th><td>{$asignatura->getTercero()}</td></tr>
                                    <tr> <th> Nombre calificación </th> <th> Porcentaje </th> 
                                    <th> Nota </th>  <th> Comentario</th></tr>
                                    {$notasTrimestres[2]}
                                    <tr> <th> Nota Trimestre </th> <td> {$mediasTrimestres[2]} </td> </tr>
                                    <tr> <th> Nota Final </th> <td> $notaFinal </td> </tr> </tbody>
                                    </table> </div>
                            EOS;

} 

if (($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE))) {
    for($i = 1 ; $i < 4; $i = $i+1){
        $calificaciones = Calificacion::getCalificacionesAsignaturaAlumnoTrimestre($idAsignatura, $idAlu, $i);
        $mediaTrimestre = 0.0;
        if($calificaciones){
            foreach ($calificaciones as $calificacion){
                $nombre = $calificacion['Nombre'];
                $porcentaje = $calificacion['Porcentaje'];
                $nota = $calificacion['Nota'];
                $comentario = $calificacion['Comentario'];
                $id = $calificacion['Id'];
    
                $notasTrimestre = <<<EOS
                                    <tr> <td>$nombre</td><td>$porcentaje%</td><td> $nota </td><td><textarea disabled> $comentario </textarea></td>
                                    <td><button class="editaNota" value="$id"> Editar </button></td>
                                    <td><button class="eliminaNota" value="$id"> Eliminar </button></td></tr>
                                    EOS;
                $mediaTrimestre = $mediaTrimestre + ($nota * ($porcentaje/100));
                $mediaTrimestre = number_format($mediaTrimestre, 2);
            }
        }
        else{
            $notasTrimestre = <<<EOS
            <tr> <td>--</td><td>--</td><td>--</td><td>--</td></tr>
            EOS;
        }
        array_push($notasTrimestres, $notasTrimestre);
        array_push($mediasTrimestres, $mediaTrimestre);
        $notasTrimestre = null;
    
    }
    
    $notaFinal = ($mediasTrimestres[0]*($asignatura->getPrimero()/100) + $mediasTrimestres[1]*($asignatura->getSegundo()/100) + $mediasTrimestres[2]*($asignatura->getTercero()/100))/3;
    $notaFinal = number_format($notaFinal, 2);
    $contenidoPrincipal .= <<<EOS
                                    <div class="tablaCalif" id="tablaCalif">
                                    <table>
                                    <tbody> <tr> <th class="Trimestre">Primer cuatrimestre  </th><td>{$asignatura->getPrimero()}%</td></tr>
                                    <tr> <th> Nombre calificación </th> <th> Porcentaje </th> 
                                    <th> Nota </th> <th> Comentario</th></tr>
                                    {$notasTrimestres[0]}
                                    <tr> <th> Nota Trimestre </th> <td> {$mediasTrimestres[0]} </td> </tr>
                                    <tr> <th class="Trimestre"> Segundo cuatrimestre </th><td>{$asignatura->getSegundo()}%</td></tr>
                                    <tr> <th> Nombre calificación </th> <th> Porcentaje </th> 
                                    <th> Nota </th>  <th> Comentario</th></tr>
                                    {$notasTrimestres[1]}
                                    <tr> <th> Nota Trimestre </th> <td> {$mediasTrimestres[1]}</td> </tr>
                                    <tr> <th class="Trimestre">  Tercer cuatrimestre </th><td>{$asignatura->getTercero()}%</td></tr>
                                    <tr> <th> Nombre calificación </th> <th> Porcentaje </th> 
                                    <th> Nota </th>  <th> Comentario</th></tr>
                                    {$notasTrimestres[2]}
                                    <tr> <th> Nota Trimestre </th> <td> {$mediasTrimestres[2]} </td> </tr>
                                    <tr> <th> Nota Final </th> <td> $notaFinal </td> </tr> </tbody>
                                    </table>
                                    <input type="hidden" id="idAlu" value="$idAlu">
                                    <input type="hidden" id="idAsig" value="$idAsignatura">
                                    <button id="crearCalificacion"> Crear Calificación </button>
                                    </div>
                            EOS;

}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);?>
<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Calificaciones\Calificacion;

$id_alumno = $_GET['id_alumno'];

$id_entrega = $_GET['id'];


$alumno = Usuario::buscaPorId($id_alumno);
$tituloPagina = 'Entrega Alumno';
$contenidoPrincipal='<h1>Archivos entregados ' .$alumno->getNombre() .' '. $alumno->getApellidos().'</h1>
<div id="entregaAlu">';

$entregas = EntregasAlumno::getEntrega($id_entrega, $id_alumno);
if(!empty($entregas)){
    $contenidoPrincipal.= "<ul>";
    foreach($entregas as $entrega) {
        $nombreEntrega = $entrega['nombre'];
        $ruta = RUTA_APP.'/entregas/'.$nombreEntrega;
        $contenidoPrincipal .= <<<EOS
        <li><a href="$ruta" target="_blank">$nombreEntrega</a></li>
        EOS;
    }
    $contenidoPrincipal.= "</ul>";
    $calificacion = Calificacion::getCalificacionEntrega($id_entrega);
    if($calificacion){
      $formEditCalifEntrega = new \es\ucm\fdi\aw\Calificaciones\FormularioEditCalifEntrega($calificacion);
      $formEditCalifEntrega = $formEditCalifEntrega->gestiona();
      $contenidoPrincipal .= '<p> Entrega puntuada con '.$calificacion->getNota().'</p>';
      $contenidoPrincipal .= '<button id="editCalifEntrega" value="'.$calificacion->getId().'"> Editar Calificación </button>';
    }
    else{
      $formCalifEntrega = new \es\ucm\fdi\aw\Calificaciones\FormularioCalificacionEntrega($id_entrega, $id_alumno);
      $formCalifEntrega = $formCalifEntrega->gestiona();
      $contenidoPrincipal .= '<input type="hidden" id="id2" value="'.$id_alumno.'">
      <button id="califEntrega" value="'.$id_entrega.'"> Crear Calificación </button>';
    }
  }
  else{
    $contenidoPrincipal.='<p>No hay ninguna entrega realizada por el alumno.</p>';
  }

  $contenidoPrincipal.= '</div>';
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
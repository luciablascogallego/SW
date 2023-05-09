<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;
use es\ucm\fdi\aw\usuarios\Usuario;

$id_tarea = $_POST['id'];

$tarea = Eventos_tareas::buscaPorId($id_tarea);

$id_asignatura = $tarea->getIdAsignatura();

Eventos_Tareas::borraPorId($id_tarea);

$entregas = es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas::getEventosAsignatura($id_asignatura);

$contenidoPrincipal = '<h1> Eventos </h1>';

if(!empty($entregas)){
  $contenidoPrincipal.= '<ul>';
    
  foreach($entregas as $entrega) {
      $contenidoPrincipal.= "<li><a href='listaEntregas.php?id=" . $entrega['Id'] . "&id_asignatura=" . $id_asignatura . "&nombre=" . $entrega['nombre'] ."'>" . $entrega['nombre'] . "</a>";
      $contenidoPrincipal .= <<<EOS
      <button  class="editarE" value="{$entrega['Id']}">Editar Evento</button>
      <button  class="eliminarE" value="{$entrega['Id']}">Eliminar Evento</button></li>
      EOS;
    }
  
  $contenidoPrincipal.= "</ul>";
}
else{
  $contenidoPrincipal.='<p>No hay eventos programados.</p>';
}

echo $contenidoPrincipal;
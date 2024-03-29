<?php
require_once __DIR__.'/includes/config.php';

$id_asignatura = $_GET['id'];
$formEventos = new \es\ucm\fdi\aw\Entregas_Eventos\FormularioCreaEvento($id_asignatura);
$formEventos = $formEventos->gestiona();

$formUpload = new \es\ucm\fdi\aw\Recurso\FormularioSubeArchivo($id_asignatura, null);
$formUpload = $formUpload->gestiona();

$tituloPagina = 'Contenido';
$contenidoPrincipal='';

//PARA MOSTRAR TODAS LOS CONTENIDOS DE UNA ASIGNATURA
$contenidoPrincipal .= '<div id="contenidoAsig"><h1>RECURSOS</h1>';

$archivos = es\ucm\fdi\aw\Recurso\Recursos::getRecursosAsignatura($id_asignatura);

// Se muestran los archivos en la página
if (!empty($archivos)) {
    $contenidoPrincipal .= "<ul>";
  foreach ($archivos as $archivo) {
    $ruta_archivo = RUTA_APP.'/recursos/'.$archivo['Nombre'];
    $nombre = $archivo['Nombre'];
    $idRecurso = $archivo['Id'];
    $contenidoPrincipal .= <<<EOS
        <li><a href="$ruta_archivo" target="_blank">$nombre</a></li>
    EOS;
    if($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE)){
      $contenidoPrincipal .= <<<EOS
      <form method="POST" action="eliminarRecurso.php">
      <input type="hidden" name="id" value=$idRecurso>
      <button type="submit" name="eliminar">Eliminar</button>
      </form>
      EOS;  
    }
  }
  $contenidoPrincipal .= "</ul>";
} else {
  $contenidoPrincipal.='<p>No se encontraron archivos para esta asignatura.</p>';
}

if($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE))
  $contenidoPrincipal .= '<button id="subirRecursos" value="'.$id_asignatura.'">Añadir Recurso </button>';

//PARA MOSTRAR TODAS LAS ENTREGAS DE LA ASIGNATURA
$contenidoPrincipal .= '<div id="Entregas"><h1>ENTREGAS</h1>';

$entregas = es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas::getEntregasAsignatura($id_asignatura);

if(!empty($entregas)){
  $contenidoPrincipal.= '<ul>';
    
  foreach($entregas as $entrega) {
    //Si somos alumno, el link mostrara el contenido de la entrega y nos dara la posibilidad de subir un archivo a la tarea
    if($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE) || $app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PADRE_ROLE)){
        $contenidoPrincipal.= "<li><a href='contenidoEntrega.php?id=" . $entrega['Id'] . "&id_asignatura=" . $id_asignatura . "'>" . $entrega['nombre'] . "</a></li>";
    }
    //Si somos profesor, el link nos mostrara todas las entregas realizadas en la tarea, en un alista alumno por alumno
    elseif($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE)){
      $contenidoPrincipal.= "<li><a href='listaEntregas.php?id=" . $entrega['Id'] . "&id_asignatura=" . $id_asignatura . "&nombre=" . $entrega['nombre'] ."'>" . $entrega['nombre'] . "</a>";
      $contenidoPrincipal .= <<<EOS
                            <button  class="editarE" value="{$entrega['Id']}">Editar Tarea</button>
                            <button  class="eliminarE" value="{$entrega['Id']}">Eliminar Tarea</button></li>
                            EOS;
    }
  }
  
  $contenidoPrincipal.= "</ul></div>";
}
else{
  $contenidoPrincipal.='<p>No hay entregas pendientes.</p>';
}

$contenidoPrincipal .= '<div id="Eventos"><h1>EVENTOS</h1>';

$entregas = es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas::getEventosAsignatura($id_asignatura);

if(!empty($entregas)){
  $contenidoPrincipal.= '<ul>';
    
  foreach($entregas as $entrega) {
    //Si somos alumno, el link mostrara el contenido de la entrega y nos dara la posibilidad de subir un archivo a la tarea
    if($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE) || $app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PADRE_ROLE)){
        $contenidoPrincipal.= "<li><a href='contenidoEntrega.php?id=" . $entrega['Id'] . "&id_asignatura=" . $id_asignatura . "'>" . $entrega['nombre'] . "</a></li>";
    }
    //Si somos profesor, el link nos mostrara todas las entregas realizadas en la tarea, en un alista alumno por alumno
    elseif($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE)){
      $contenidoPrincipal.= "<li><a href='listaEntregas.php?id=" . $entrega['Id'] . "&id_asignatura=" . $id_asignatura . "&nombre=" . $entrega['nombre'] ."'>" . $entrega['nombre'] . "</a>";
      $contenidoPrincipal .= <<<EOS
      <button  class="editarE" value="{$entrega['Id']}">Editar Evento</button>
      <button  class="eliminarE" value="{$entrega['Id']}">Eliminar Evento</button></li>
      EOS;
    }
  }
  
  $contenidoPrincipal.= "</ul></div>";
}
else{
  $contenidoPrincipal.='<p>No hay eventos programados.</p>';
}

//Un profesor puede subir nuevos archivos y entregas
if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE)) {
    $contenidoPrincipal.= '<button id="creaEventoTarea" value="'.$id_asignatura.'"> Crear Evento/Tarea </button>';
  }

$contenidoPrincipal .= '</div>';
  
  $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
  $app->generaVista('/plantillas/plantilla.php', $params);
?>
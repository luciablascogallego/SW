<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;

$id_asignatura = $_GET['id_asignatura'];

$id_entrega = $_GET['id'];

$tituloPagina = 'Entrega';
$contenidoPrincipal='';

$entregas = EntregasAlumno::getEntrega($id_entrega);
$tarea = Eventos_tareas::buscaPorId($id_entrega);
$tiempoRestante = $tarea->getFechaFin();
$descripcion = $tarea->getDescripcion();
$idEntrega = $tarea->getId();

$formUpload = new \es\ucm\fdi\aw\usuarios\FormularioSubeArchivo($id_asignatura, $idEntrega);
$formUpload = $formUpload->gestiona();

if (!empty($entregas)) {
    $contenidoPrincipal .= "<ul>";
  foreach ($entregas as $entrega) {
    $idDelete = $entrega['Id'];
    $ruta_archivo = __DIR__.'/entregas/'.$entrega['nombre'];
    //$ruta_archivo = RUTA_ENTREGAS.$entrega['Ruta'];
    $contenidoPrincipal .= '<li><a href=' . $ruta_archivo . '>' . $entrega['nombre'] . '</a></li>';
    $contenidoPrincipal .= <<<EOS
      <form method="POST" action="eliminarEntrega.php">
      <input type="hidden" name="id" value=$idDelete>
      <button type="submit" name="eliminar">Eliminar</button>
      </form>
      EOS;
  }
  $contenidoPrincipal .= "</ul>";
} else {
  $contenidoPrincipal.='<p>' . $descripcion . '</p>';
  $contenidoPrincipal.='<p>Aun no has realizado ninguna entrega en esta tarea</p>';
}
$contenidoPrincipal.='<p>La fecha limite es: ' . $tiempoRestante . '</p>';

$contenidoPrincipal.= $formUpload;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
<?php

require_once __DIR__.'/includes/config.php';
$id_asignatura = $_GET['id_asignatura'];

$formUpload = new \es\ucm\fdi\aw\usuarios\FormularioSubeArchivo($id_asignatura);
$formUpload = $formUpload->gestiona();

$id_entrega = $_GET['id'];
$id_usuario = $_GET['alumno'];

$tituloPagina = 'Entrega';

$entregas = getEntrega($id_entrega);

if (!empty($entregas)) {
    $contenidoPrincipal .= "<ul>";
  foreach ($entregas as $entrega) {
    $ruta_archivo = RUTA_ENTREGAS.$entrega['ruta'];
    $contenidoPrincipal .= "<li><a href='$ruta_archivo'>$nombre_archivo</a></li>";
  }
  $contenidoPrincipal .= "</ul>";
} else {
  $contenidoPrincipal.='<p>No se encontraron archivos para esta asignatura.</p>';
}

$contenidoPrincipal.= $formUpload;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaChat.php', $params);
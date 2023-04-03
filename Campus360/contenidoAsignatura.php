<?php
require_once __DIR__.'/includes/config.php';

$formEventos = new \es\ucm\fdi\aw\usuarios\FormularioCreaEvento();
$formEventos = $formEventos->gestiona();

$id_asignatura = $_GET['id'];

$formUpload = new \es\ucm\fdi\aw\usuarios\FormularioSubeArchivo($id_asignatura);
$formUpload = $formUpload->gestiona();

$tituloPagina = 'Contenido';
$contenidoPrincipal='';

//PARA MOSTRAR TODAS LOS CONTENIDOS DE UNA ASIGNATURA
$contenidoPrincipal .= "<h1>RECURSOS</h1>";

$archivos = es\ucm\fdi\aw\Recurso\Recursos::getRecursosAsignatura($id_asignatura);

// Se muestran los archivos en la página
if (!empty($archivos)) {
    $contenidoPrincipal .= "<ul>";
  foreach ($archivos as $archivo) {
    $ruta_archivo = 'recursos/'.$archivo['nombre'];
    $nombre = $archivo['nombre'];
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

//PARA MOSTRAR TODAS LAS ENTREGAS DE LA ASIGNATURA
$contenidoPrincipal .= "<h1>ENTREGAS</h1>";

$entregas = es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno::getEntregasAsignatura($id_asignatura);

if(!empty($entregas)){
  $contenidoPrincipal.= "<ul>";
    
  foreach($entregas as $entrega) {
    //Mostramos el nombre como enlace y si pulsamos vamos a un .php en el que se muestra la informacion de la entrega
    //Pasamos en la url el id de la entrega 
    $contenidoPrincipal.= "<li><a href='contenidoEntrega.php?id=" . $entrega['id_entrega'] . "&alumno=" . $_SESSION['idUsuario'] . "&id_asignatura=" . $id_asignatura . "'>" . "Entrega" . "</a></li>";
  }
  
  $contenidoPrincipal.= "</ul>";
}
else{
  $contenidoPrincipal.='<p>No hay entregas pendientes.</p>';
}

//Un profesor puede subir nuevos archivos y entregas
if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE)) {
    $contenidoPrincipal.= $formUpload;

    $contenidoPrincipal.= $formEventos;
  }
  
  $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
  $app->generaVista('/plantillas/plantilla.php', $params);
?>
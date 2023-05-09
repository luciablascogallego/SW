<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;
use es\ucm\fdi\aw\Calificaciones\Calificacion;

$id_asignatura = $_GET['id_asignatura'];

$id_entrega = $_GET['id'];
$idAlumno = $app->idUsuario();

$tituloPagina = 'Entrega';

$entregas = EntregasAlumno::getEntrega($id_entrega, $idAlumno);
$tarea = Eventos_tareas::buscaPorId($id_entrega);
$fechaFin = $tarea->getFechaFin();
$horaFin = $tarea->getHoraFin();
$descripcion = $tarea->getDescripcion();
$idEntrega = $tarea->getId();
$esEntrega = $tarea->getEsEntrega();

$contenidoPrincipal='<h1> '.$tarea->getNombre().'</h1>';


if($esEntrega){

  if (!empty($entregas)) {
      $contenidoPrincipal .= "<ul>";
    foreach ($entregas as $entrega) {
      $idDelete = $entrega['Id'];
      $ruta_archivo = RUTA_APP.'/entregas/'.$entrega['nombre'];
      $nombre = $entrega['nombre'];
      //$ruta_archivo = RUTA_ENTREGAS.$entrega['Ruta'];
      $contenidoPrincipal .= <<<EOS
      <li><a href="$ruta_archivo" target="_blank">$nombre</a></li>
      EOS;
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
  $contenidoPrincipal.='<p>La fecha limite es: ' . $fechaFin .' a las '.$horaFin. '</p>';
  $fecha = date('Y-m-d H:i:s');
  $today_time = strtotime("$fecha");
  $expire_time = strtotime("$fechaFin, $horaFin");
  $seconds = $expire_time - $today_time;
  $Haterminado = 0;
  
  if($today_time > $expire_time){
    $contenidoPrincipal .= '<p> El plazo de entrega ha terminado, no se aceptan más entregas</p>';
    $Haterminado = true;
  }
  else
    $contenidoPrincipal.= '<div id="subidaEntrega">
    <input type="hidden" id="id2" value="'.$idEntrega.'">
    <button id="subirEntrega" value="'.$id_asignatura.'">Subir Entrega</button></div>';

  $calificacion = Calificacion::getCalificacionEntrega($id_entrega);
  if($calificacion){
    $contenidoPrincipal .= '<p> Entrega puntuada con '.$calificacion->getNota().'</p>';
    $contenidoPrincipal .= '<h3> Comentarios </h3>';
    $contenidoPrincipal .= '<p>'.$calificacion->getComentario().'</p>';
  }
  else{
    $contenidoPrincipal .= '<p> La entrega todavía no ha sido puntuada por el profesor </p>';
  }


}

else{
  $contenidoPrincipal.='<p>' . $descripcion . '</p>';
  $contenidoPrincipal.='<p>El día del evento es: ' . $tiempoRestante . '</p>';
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>

<script>
  function closeEntrega(){
    var seconds = <?= $seconds ?>;
    var Haterminado = <?= $Haterminado ?>;
    if(Haterminado == 0){
      var functionCierra = function(){
        Haterminado = 1;
        document.getElementById("subidaEntrega").innerHTML = '<p> El plazo de entrega ha terminado, no se aceptan más entregas</p>';
      }
      var miliseconds = seconds * 1000;
      setTimeout(functionCierra, miliseconds);
    }
  }
  closeEntrega();

</script>
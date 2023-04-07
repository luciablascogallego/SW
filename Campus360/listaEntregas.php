<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;
use es\ucm\fdi\aw\usuarios\Usuario;

$id_asignatura = $_GET['id_asignatura'];

$id_entrega = $_GET['id'];

$nombreEntrega = $_GET['nombre'];

$tituloPagina = 'Entrega';
$contenidoPrincipal='<h1>Entega: ' . $nombreEntrega . '</h1>';

$entregas = EntregasAlumno::getEntregasPorId($id_entrega);
if(!empty($entregas)){
    $contenidoPrincipal.= "<ul>";
      
    foreach($entregas as $entrega) {
        $alumno = Usuario::buscaPorId($entrega['IdAlumno']);
        $nombre = $alumno->getNombre() ." ". $alumno->getApellidos();
        $contenidoPrincipal.= "<li><a href=" . $entrega['Ruta'] . ">" . $entrega['nombre'] . "</a> (" . $nombre . ")</li>";
    }
    
    $contenidoPrincipal.= "</ul>";
  }
  else{
    $contenidoPrincipal.='<p>Nadie ha hecho ninguna entega aun.</p>';
  }


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
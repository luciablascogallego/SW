<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;
use es\ucm\fdi\aw\usuarios\Usuario;

$id_alumno = $_GET['id_alumno'];

$id_entrega = $_GET['id'];


$alumno = Usuario::buscaPorId($id_alumno);
$tituloPagina = 'Entrega Alumno';
$contenidoPrincipal='<h1>Archivos entregados ' .$alumno->getNombre() .' '. $alumno->getApellidos().'</h1>';

$entregas = EntregasAlumno::getEntregasPorId($id_entrega, $id_alumno);
if(!empty($entregas)){
    $contenidoPrincipal.= "<ul>";
    foreach($entregas as $entrega) {
        $ruta = $entrega['Ruta'];
        $nombreEntrega = $entrega['nombre'];
        $contenidoPrincipal .= <<<EOS
        <li><a href="file://///$ruta" target="_blank">$nombreEntrega</a></li>
        EOS;
    }
    
    $contenidoPrincipal.= "</ul>";
  }
  else{
    $contenidoPrincipal.='<p>No hay ninguna entrega realizada por el alumno.</p>';
  }


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
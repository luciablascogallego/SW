<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;
use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\usuarios\Usuario;

$id_asignatura = $_GET['id_asignatura'];

$id_entrega = $_GET['id'];

$nombreEntrega = $_GET['nombre'];

$tituloPagina = 'Entrega';
$contenidoPrincipal='<h1>Entrega: ' .$nombreEntrega . '</h1>';

$id_alumnos = Alumno::estudianAsignatura($id_asignatura);
if($id_alumnos){
    $contenidoPrincipal.= "<ul>";
    foreach($id_alumnos as $id_alumno) {
        $alumno = Usuario::buscaPorId($id_alumno['IdAlumno']);
        $id = $alumno->getId();
        $nombre = $alumno->getNombre() ." ". $alumno->getApellidos();
        $contenidoPrincipal .= <<<EOS
        <li><a href="entregaAlumno.php?id=$id_entrega &id_alumno=$id">$nombreEntrega</a>("$nombre")</li>
        EOS;
    }
    
    $contenidoPrincipal.= "</ul>";
  }
  else{
    $contenidoPrincipal.='<p>No hay alumnos cursando la asignatura.</p>';
  }


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
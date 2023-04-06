<?php
require_once __DIR__.'/includes/config.php';

if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $entrega = es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno::buscaPorId($id);
    $asignatura = $entrega->getIdAsignatura();
    $ruta = $entrega->getRuta();
    unlink($ruta);
    $entrega->borrate();
    //Redirige a la pagina anterior
    $url = 'contenidoAsignatura.php?id='.$asignatura;
    header('Location:'.$url);
  }
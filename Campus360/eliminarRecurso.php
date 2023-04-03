<?php
require_once __DIR__.'/includes/config.php';

if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $recurso = es\ucm\fdi\aw\Recurso\Recursos::buscaPorId($id);
    $asignatura = $recurso->getIdAsignatura();
    $ruta = $recurso->getRuta();
    unlink($ruta);
    $recurso->borrate();
    //Redirige a la pagina anterior
    $url = 'contenidoAsignatura.php?id='.$asignatura;
    header('Location:'.$url);
  }
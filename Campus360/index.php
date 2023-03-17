<?php

session_start();

require_once __DIR__.'/includes/config.php';

if(isset($_SESSION['login']) && $_SESSION['login'] = true){
  if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE))
    header('Location: asignaturasAlu.php');
  else if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ADMIN_ROLE))
    header('Location: asignaturasAdmin.php');
  else if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PADRE_ROLE))
    header('Location: asignaturasPadre.php');
  else if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE))
    header('Location: asignaturasProfesor.php');
}
else{
  header('Location: login.php');
}
?>
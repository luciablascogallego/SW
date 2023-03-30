<?php

use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Aplicacion;

require_once __DIR__.'/includes/config.php';

if(isset($_SESSION['login']) && $_SESSION['login'] = true){
  if ($app->tieneRol(Usuario::ALUMNO_ROLE))
    Aplicacion::redirige('asignaturasAlu.php');
  else if ($app->tieneRol(Usuario::ADMIN_ROLE))
    Aplicacion::redirige('asignaturasAdmin.php');
  else if ($app->tieneRol(Usuario::PADRE_ROLE))
    Aplicacion::redirige('asignaturasPadre.php');
  else if ($app->tieneRol(Usuario::PROFE_ROLE))
    Aplicacion::redirige('asignaturasProfesor.php');
}
else{
  Aplicacion::redirige('login.php');
}
?>
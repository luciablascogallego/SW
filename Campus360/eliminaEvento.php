<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;
use es\ucm\fdi\aw\usuarios\Usuario;

$id_tarea = $_GET['id'];

Eventos_Tareas::borraPorId($id_tarea);

Aplicacion::redirige('contenidoAsignatura.php');
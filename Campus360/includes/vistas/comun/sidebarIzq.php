<?php
use es\ucm\fdi\aw\Aplicacion;

$app = Aplicacion::getInstance();
?>
<nav id="sidebarIzq">
	<h3>Navegación</h3>
	<ul>
		<li><a href="<?= $app->resuelve('/index.php')?>">Inicio</a></li>
		<li><a href="<?= $app->resuelve('/chat.php')?>">Foro de usuarios</a></li>
		<li><a href="<?= $app->resuelve('/vistaCalificaciones.php')?>">Calificaciones</a></li>
		<li><a href="<?= $app->resuelve('/perfil.php')?>">Perfil</a></li>
	</ul>
</nav>

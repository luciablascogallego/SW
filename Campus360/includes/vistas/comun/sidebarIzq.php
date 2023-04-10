<?php
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Aplicacion;

$app = Aplicacion::getInstance();
?>
<nav id="sidebarIzq">
	<h3>Navegación</h3>
	<ul>
		<li><a href="<?= $app->resuelve('/index.php')?>">Inicio</a></li>
		<li><a href="<?= $app->resuelve('/chat.php')?>">Foro de usuarios</a></li>
		<?php
			if(!$app->tieneRol(Usuario::ADMIN_ROLE)){
				$resuelve = $app->resuelve('/vistaCalificaciones.php');
				$enlace = <<<EOS
				<li><a href="$resuelve">Calificaciones</a></li>
				EOS;
				echo $enlace;
			}
		?>
		<li><a href="<?= $app->resuelve('/perfil.php')?>">Perfil</a></li>
	</ul>
</nav>

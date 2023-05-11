<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="icon" type="image/x-icon" href="img/Favicon.png">
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
	<script type="text/javascript" src="<?= $params['app']->resuelve('/js/jquery-3.6.4.min.js')?>" > </script>
	<script type="text/javascript" src="<?= $params['app']->resuelve('/js/comprobar.js')?>" > </script></head>
	
<body>
<div id="contenedor">

<header>
    <h1>  Campus 360 </h1>
    <div class="saludo">
    </div>
</header>
	<mainlog>
		<article>
			<?= $params['contenidoPrincipal'] ?>
		</article>
	</mainlog>
</div>
</body>
</html>

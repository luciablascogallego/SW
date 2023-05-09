<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" /></head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="formularios.js/comprobar.js"></script>
<body>
<?= $mensajes ?>
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

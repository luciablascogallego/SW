<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
//$mensajes = mensajesPeticionAnterior();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
</head>
<body>
	<div id="contenedor">
		<?php
			$params['app']->doInclude('/vistas/comun/cabecera.php');
		?>
		
		<div class="container">
		
			<?php
				$params['app']->doInclude('/vistas/comun/sidebarIzq.php');
			?>
			

			<main>
			<div class="content">
				<article>
					<?= $params['contenidoPrincipal'] ?>
				</article>
			</div>
			</main>
			<?php
				$params['app']->doInclude('/vistas/comun/sidebarDer.php');
			?>

		</div>
		<?php
			$params['app']->doInclude('/vistas/comun/pie.php');
		?>
	</div> <!-- Cierra el contenedor principal -->
</body>
</html>
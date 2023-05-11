<?php
$params['app']->doInclude('/vistas/helpers/plantilla.php');
//$mensajes = mensajesPeticionAnterior();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $params['tituloPagina'] ?></title>
	<link rel="stylesheet" href="css/calendar.css">
	<link rel="stylesheet" type="text/css" href="<?= $params['app']->resuelve('/css/estilo.css') ?>" />
	<link rel="icon" type="image/x-icon" href="img/Favicon.png">
	<script type="text/javascript" src="<?= $params['app']->resuelve('/js/jquery-3.6.4.min.js')?>" > </script>
	<script type="text/javascript" src="<?= $params['app']->resuelve('/js/enviosPostFormularios.js')?>" > </script>
	<script type="text/javascript" src="<?= $params['app']->resuelve('/js/comprobar.js')?>" > </script>
	<script src="https://cdn.jsdelivr.net/npm/moment@2.29.3/min/moment-with-locales.min.js" integrity="sha256-7WG1TljuR3d5m5qKqT0tc4dNDR/aaZtjc2Tv1C/c5/8=" crossorigin="anonymous"></script>
  	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js" integrity="sha256-XCdgoNaBjzkUaEJiauEq+85q/xi/2D4NcB3ZHwAapoM=" crossorigin="anonymous"></script>
  	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js" integrity="sha256-GcByKJnun2NoPMzoBsuCb4O2MKiqJZLlHTw3PJeqSkI=" crossorigin="anonymous"></script>
  	<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.11.0/main.global.min.js" integrity="sha256-oh4hswY1cPEqPhNdKfg+n3jATZilO3u2v7qAyYG3lVM=" crossorigin="anonymous"></script>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha256-9SEPo+fwJFpMUet/KACSwO+Z/dKMReF9q4zFhU/fT9M=" crossorigin="anonymous"></script>
	  <script>
		$(document).ready(function() {
		var calendarEl = $('#calendar')[0];
		var calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth',
			//headerToolbar: {
			//center: 'title',
			//left: 'prev,next today',
			//right: 'dayGridMonth,timeGridWeek,timeGridDay'
			//},
			//events: 'eventos.php'
		});
		calendar.render();
		});
</script>
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
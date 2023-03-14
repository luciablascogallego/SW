<aside id="sidebarDer">
	<?php
		include 'Calendar.php';
		$calendario = new Calendar(date('Y-m-d'));
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>CalendarioEventos</title>s
	</head>
	<body>
		<h2> Calendario </h2>
		<?=$calendario?>
	</body>
	</html>
</aside>

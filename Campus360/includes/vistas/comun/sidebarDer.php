<aside id="sidebarDer">
	<?php
		include 'Calendar.php';
		$calendario = new Calendar(date('Y-m-d'));
	?>
		<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/calendar.css">
	</head>
		<h2> Calendario </h2>
		<?=$calendario?>
	
</aside>

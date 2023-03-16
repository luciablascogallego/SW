<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Crear evento';
$contenidoPrincipal=<<<EOS
  <h1>Crea un nuevo evento</h1>
  <form action="crear_evento.php" method="POST">
  <label>Nombre del evento:</label>
  <input type="text" name="titulo" required>

  <label>Fecha:</label>
  <input type="date" name="fecha" required>

  <label>Hora:</label>
  <input type="time" name="hora" required>

  <button type="submit">Crear evento</button>
</form>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
<?php require_once __DIR__.'/includes/config.php'; ?>

<?php
$tituloPagina = 'Crear nuevo ciclo';
$contenidoPrincipal = '<h1>Crear nuevo ciclo</h1>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Aquí deberías agregar el código para crear el ciclo con los datos enviados por el formulario desde la base de datos
  $nombreCiclo = $_POST['nombre-ciclo'];
  crearCiclo($nombreCiclo);

  header('Location: ciclos.php');
  exit;
}
?>

<form method="POST">
  <label for="nombre-ciclo">Nombre del ciclo:</label>
  <input type="text" name="nombre-ciclo" id="nombre-ciclo" required>

  <button type="submit">Crear ciclo</button>
</form>

<?php $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params); ?>

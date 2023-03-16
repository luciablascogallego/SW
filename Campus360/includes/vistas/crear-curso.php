<?php require_once __DIR__.'/includes/config.php'; ?>

<?php
$tituloPagina = 'Crear nuevo curso';
$contenidoPrincipal = '<h1>Crear nuevo curso</h1>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Aquí deberías agregar el código para crear el curso con los datos enviados por el formulario desde la base de datos
  $numCurso = $_POST['num-curso'];
  crearCurso($numCurso);

  header('Location: cursos.php');
  exit;
}
?>

<form method="POST">
  <label for="num-curso">Número de curso:</label>
  <input type="number" name="num-curso" id="num-curso" required>

  <button type="submit">Crear curso</button>
</form>

<?php $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params); ?>

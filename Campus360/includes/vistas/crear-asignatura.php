<?php require_once __DIR__.'/includes/config.php'; ?>

<?php
$tituloPagina = 'Crear nueva asignatura';
$contenidoPrincipal = '<h1>Crear nueva asignatura</h1>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Aquí deberías agregar el código para crear el curso con los datos enviados por el formulario desde la base de datos
  $nombreAsignatura = $_POST['nombre-asignatura'];
  $profesorAsignado = $_POST['profesor-asignado'];
  $alumnosSeleccionados = $_POST['alumnos-seleccionados'];

  crearAsignatura($nombreAsignatura, $profesorAsignado, $alumnosSeleccionados);

  header('Location: listAsignaturas.php');
  exit;
}

// Obtener lista de profesores
$listaProfesores = obtenerListaProfesores();

// Obtener lista de alumnos
$listaAlumnos = obtenerListaAlumnos();

// Generar opciones para el desplegable de profesores
$opcionesProfesores = '';
foreach ($listaProfesores as $profesor) {
  $opcionesProfesores .= '<option value="'.$profesor['id'].'">'.$profesor['nombre'].' '.$profesor['apellidos'].'</option>';
}

// Generar opciones para la lista de alumnos
$opcionesAlumnos = '';
foreach ($listaAlumnos as $alumno) {
  $opcionesAlumnos .= '<li><input type="checkbox" name="alumnos-seleccionados[]" value="'.$alumno['id'].'">'.$alumno['nombre'].' '.$alumno['apellidos'].'</li>';
}

?>

<form method="POST">
  <label for="nombre-asignatura">Nombre asignatura:</label>
  <input type="text" name="nombre-asignatura" id="nombre-asignatura" required>

  <label for="profesor-asignado">Profesor asignado:</label>
  <select name="profesor-asignado" id="profesor-asignado">
    <?php echo $opcionesProfesores; ?>
  </select>

  <label>Alumnos asignados:</label>
  <ul>
    <?php echo $opcionesAlumnos; ?>
  </ul>
  
  <button type="submit">Crear asignatura</button>
</form>

<?php $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params); ?>

<?php

require_once __DIR__.'/includes/config.php';

use \es\ucm\fdi\aw\Ciclos\Ciclo;

$id = $_POST['id'];

$ciclo = Ciclo::buscaPorId($id);

$formEditaCiclo = new \es\ucm\fdi\aw\Ciclos\FormularioEditaCiclo($ciclo);
$formEditaCiclo = $formEditaCiclo->gestiona();

$tituloPagina = 'Editar ciclo';

$contenidoPrincipal=<<<EOF
  	<h1>Editar ciclo</h1>
    $formEditaCiclo
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Asignaturas\Asignatura;

$id = $_POST['id'];

$asignatura = Asignatura::buscaPorId($id);

$formPorcentajes = new \es\ucm\fdi\aw\Asignaturas\FormularioPorcentajes($asignatura);
$formPorcentajes = $formPorcentajes->gestiona();

$tituloPagina = 'Porcentajes trimestres';

$contenidoPrincipal=<<<EOF
  	<h1>Porcentajes trimestre</h1>
    $formPorcentajes
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
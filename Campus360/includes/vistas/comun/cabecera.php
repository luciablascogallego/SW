<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;

function mostrarSaludo()
{
    //$html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();
        $apellidosUsuario = $app->apellidosUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $html = "Bienvenido, ${apellidosUsuario}, ${nombreUsuario}. $htmlLogout";
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        Usuario desconocido. <a href="{$loginUrl}">Login</a> <a href="{$registroUrl}">Registro</a>
      EOS;
    }

    return $html;
}

?>
<header>
    <h1> 
        Campus 360 
    </h1>
    <div class="saludo">
        <?= mostrarSaludo(); ?>
    </div>
</header>
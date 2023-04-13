
<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Chat';
$contenidoPrincipal=<<<EOS
  <h1>Chats</h1>
  <div class="containerC">
  
  <div class="left">
  
    <ul class="asignaturas">
      <li>Chat 1</li>
      <li>Chat 2</li>
      <li>Chat 3</li>
      <li>Chat 4</li>
     

    </asignaturas>
  </div>
  <div class="right">
  <div class="chat">
  <form action="enviar-correo.php" method="post">

  <label for="asunto">Asunto:</label>
  <input type="text" id="asunto" name="asunto">

  <label for="mensaje">Mensaje:</label>
  <textarea id="mensaje" name="mensaje"></textarea>

  <button type="submit">Enviar mensaje</button>
</form>
</div>

  </div>
</div>
</div>

EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
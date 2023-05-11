<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\Profesores\Profesor;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Asignaturas\Asignatura;
use es\ucm\fdi\aw\MensajesForo\MensajeForo;

$tituloPagina = 'Chat';
$contenidoPrincipal = '';
$asignaturasForo = '';
$idAsignatura = '';

//Mostramos las asignaturas que esta cursando el alumno o que imparta el profesor
if ($app->tieneRol(Usuario::ALUMNO_ROLE)){
  $alumnoId = $app->idUsuario();
  $usuario = Usuario::buscaPorId($alumnoId);
  $nombreUsuario = $usuario->getNombre();

  $alumno = Alumno::buscaPorId($alumnoId);
  $asignaturas = $alumno->getIdAsignaturas();
}
else if ($app->tieneRol(Usuario::PROFE_ROLE)){
  $alumnoId = $app->idUsuario();
  $usuario = Usuario::buscaPorId($alumnoId);
  $nombreUsuario = $usuario->getNombre();

  $alumno = Profesor::buscaPorId($alumnoId);
  $asignaturas = $alumno->getIdAsignaturas();
}
else if ($app->tieneRol(Usuario::ADMIN_ROLE)){
  $alumnoId = $app->idUsuario();
  $usuario = Usuario::buscaPorId($alumnoId);
  $nombreUsuario = $usuario->getNombre();
  //El administrador tendra acceso a todos los foros
  $asignaturas = Asignatura::getAsignaturasCampus();
}
//El padre no podra ver los foros
else if ($app->tieneRol(Usuario::PADRE_ROLE)){
  $alumnoId = $app->idUsuario();
  $usuario = Usuario::buscaPorId($alumnoId);
  $nombreUsuario = $usuario->getNombre();
}

if(!($app->tieneRol(Usuario::PADRE_ROLE))){
  if ($asignaturas) {
      $asignaturasForo .= '<ul class = "asignaturas">';
      foreach ($asignaturas as $idAsignatura) {
          if($app->tieneRol(Usuario::ADMIN_ROLE)){
            $aux = $idAsignatura['Id'];
            $asignatura = Asignatura::buscaPorId($aux);
          }
          else{
            $asignatura = Asignatura::buscaPorId($idAsignatura);
          }
          $id = $asignatura->getId();
          $nombre = $asignatura->getNombre();
          $curso = $asignatura->getCurso();  
          $grupo = $asignatura->getGrupo();
          if($asignatura)
              $asignaturasForo .= <<<EOS
                  <li><button class="botonAsignaturas" id="$id">$nombre {$curso}º $grupo</button>
                  <input type="hidden" class="idAsignatura" value="$id">
                  <input type="hidden" class="idUsuario" value="$alumnoId">
                  <input type="hidden" class="nombre" value="$nombre">
                  </li>
              EOS;  
        }          
      $asignaturasForo .= '</ul>';
  } else {
      $asignaturasForo .= '<p>No se encontraron asignaturas disponibles para el usuario</p>';
  }

  $contenidoPrincipal=<<<EOS
    <h1>Foros</h1>
    <h3 id="foroActual"></h3>
    <div class="containerC">
    
    <div class="left">
    
      $asignaturasForo

    </div>
    <div class="right">
    <div id="chat">

    </div>
    <input type="hidden" id="nombreUsuario" value="$nombreUsuario">
    <input type="hidden" id="idUsuario" value="$alumnoId">
    <input type="text" id="mensaje" placeholders="Escribe tu mensaje">
    <button id="enviarForo">Enviar</button>
    </div>
  </div>


  EOS;
  ?>
  <script>
  var idAsignaturaSeleccionada;
  var idDestinatario;
  document.addEventListener('DOMContentLoaded', function() {
    var mensajeInput = document.getElementById('mensaje');
    var enviarForo = document.getElementById('enviarForo');
    const botonAsignaturas = document.querySelectorAll(".botonAsignaturas");
    var nombreInput = document.getElementById('nombreUsuario'); 
    var idInput = document.getElementById('idUsuario');

    mensajeInput.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      enviarForo.click();
    }
    });

    botonAsignaturas.forEach(boton => {
      boton.addEventListener("click", function() {
        const idAsignatura = this.nextElementSibling.value;
        idAsignaturaSeleccionada = idAsignatura; 
        const alumnoId = this.nextElementSibling.nextElementSibling.value;
        const nombre = this.nextElementSibling.nextElementSibling.nextElementSibling.value;

        var chat = document.getElementById('chat');
        var foroActual = document.getElementById('foroActual');
        var url = "cargarMensajesF.php?idAsignatura=" + idAsignatura;

        $.get(url, function(respuesta){
            var datos = JSON.parse(respuesta); // Parsear el JSON para obtener el arreglo
            // Obtener el elemento <div> con id "chat"
            var chatDiv = document.getElementById("chat");
            // Generar el contenido HTML para el <div> con los datos del array
            var contenidoHTML = "";
            // Recorrer el array de mensajes y generar el contenido HTML
            for (var i = 0; i < datos.length; i++) {
              var fecha = new Date(datos[i].fecha);
              var horaFormateada = fecha.toLocaleTimeString();

              if(datos[i].idAutor == alumnoId){
              contenidoHTML += "<div class='mensaje-propio'><p>" + datos[i].autor + "(" + horaFormateada + ")" + ": " + datos[i].mensaje + "</p></div>";
              }
              else{
                contenidoHTML += "<div class='mensaje-externo'><p>" + datos[i].autor + "(" + horaFormateada + ")" + ": " + datos[i].mensaje + "</p></div>";
              }
            }

            // Establecer el contenido HTML del <div> con el contenido generado
            chatDiv.innerHTML = contenidoHTML;
            foroActual.innerHTML = nombre;
            //Para ir a los mensajes mas recientes
            chat.scrollTop = chat.scrollHeight - chat.clientHeight;
        });
      });
    });

    enviarForo.addEventListener('click', function() {
      event.preventDefault();
      var nombreUsuario = nombreInput.value;
      var idUsuario = idInput.value;
      var mensaje = mensajeInput.value;

      if(mensaje.trim() !== ''){
        var nuevoMensaje = document.createElement('p');

        // AJAX
        var data = {
          nombreUsuario: nombreUsuario,
          idUsuario: idUsuario,
          mensaje: mensaje,
          idAsignatura: idAsignaturaSeleccionada
        };
        var jsonDatos = JSON.stringify(data);
        $.post("insertarMensaje.php", jsonDatos, function(respuesta){
          //Simulamos un click en el boton de la asignatura correspondiente para recargar los mensajes
          var recarga = document.getElementById(idAsignaturaSeleccionada);
          recarga.click();
        });
      }
      mensajeInput.value = "";
    });
  });
  </script>
  <?php
}

$alumnosCampus = '<ul class = "usuarios">';
$listaUsuarios = Usuario::getUsuarios();
if($listaUsuarios){
  foreach ($listaUsuarios as $user) {
    $idRemitente = $user['Id'];

    $idAutor = $alumnoId;
    $nombreAutor = $nombreUsuario;
    $nombreRemitente = $user['Nombre'];
    $apellidos = $user['Apellidos'];
    $alumnosCampus .= <<<EOS
      <li><button class="botonUsuarios" id="$idRemitente">$nombreRemitente {$apellidos}</button>
      <input type="hidden" class="idRemitente" value="$idRemitente">
      <input type="hidden" class="idAutor" value="$idAutor">
      <input type="hidden" class="nombreAutor" value="$nombreAutor">
      <input type="hidden" class="nombreRemitente" value="$nombreRemitente">
      </li>
    EOS; 
  }             
}
else{
  $alumnosCampus .= '<p>No se han encontrado alumnos para chatear</p>';
}
$alumnosCampus .= '</ul>';

  $contenidoPrincipal.=<<<EOS
  <h1>Chats privados</h1>
  <h3 id="chatActual"></h3>
  <div class="containerC2">
  <div class="left2">

    $alumnosCampus

  </div>

  <div class="right2">
  <div id="chat2">

  </div>

  <input type="hidden" id="idA" value="$alumnoId">
  <input type="hidden" id="nombreUsuario" value="$nombreUsuario">
  <input type="text" id="mensaje2" placeholders="Escribe tu mensaje">
  <button id="enviarPrivado">Enviar</button>
  </div>
</div>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>

<script>
  var idAsignaturaSeleccionada;
  var idDestinatario;
  
  document.addEventListener('DOMContentLoaded', function() {

    var mensajeInput2 = document.getElementById('mensaje2');
    
    
    var enviarPrivado = document.getElementById('enviarPrivado');

    const botonUsuarios = document.querySelectorAll(".botonUsuarios");
    var nombreInput = document.getElementById('nombreUsuario'); 
    var idInput = document.getElementById('idA'); 

    mensajeInput2.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      enviarPrivado.click();
    }

    });

    botonUsuarios.forEach(boton => {
      boton.addEventListener("click", function(){
        var idRemitente = this.nextElementSibling.value;
        idDestinatario = idRemitente;
        var idAutor = this.nextElementSibling.nextElementSibling.value;
        var nombreAutor = this.nextElementSibling.nextElementSibling.nextElementSibling.value;
        var nombreRemitente = this.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.value;

        var chat = document.getElementById('chat2');
        var chatActul = document.getElementById('chatActual');
        var url = "cargarMensajesP.php?idA="+idAutor+"&idR="+idRemitente;

        $.get(url, function(respuesta){
          console.log(idRemitente);
          var datos = JSON.parse(respuesta); // Parsear el JSON para obtener el arreglo
          // Obtener el elemento <div> con id "chat"
          var chatDiv = document.getElementById("chat2");
          // Generar el contenido HTML para el <div> con los datos del array
          var contenidoHTML = "";
          // Recorrer el array de mensajes y generar el contenido HTML
          for (var i = 0; i < datos.length; i++) {
            var fecha = new Date(datos[i].fecha);
            var horaFormateada = fecha.toLocaleTimeString();

            var mensajeElemento = document.createElement("div");
            mensajeElemento.textContent = datos[i].mensaje;
            mensajeElemento.classList.add("mensaje");
            if(datos[i].idAutor == idAutor){
              contenidoHTML += "<div class='mensaje-propio'><p>" + nombreAutor + "(" + horaFormateada + ")" + ": " + datos[i].mensaje + "</p></div>";
            }
            else{
              contenidoHTML += "<div class='mensaje-externo'><p>" + nombreRemitente + "(" + horaFormateada + ")" + ": " + datos[i].mensaje + "</p></div>";
            }
            mensajeElemento.innerHTML = contenidoHTML;
          }
          if(datos.length == 0){
            contenidoHTML += "Aun no hay mensajes en este chat...";
          }
            // Establecer el contenido HTML del <div> con el contenido generado
            chatDiv.innerHTML = contenidoHTML;
            chatActul.innerHTML = nombreRemitente;
            //Para ir a los mensajes mas recientes
            chat.scrollTop = chat.scrollHeight - chat.clientHeight;
        });
      });
    });

    enviarPrivado.addEventListener('click', function() {
      event.preventDefault();

      var idUsuario = idInput.value;
      var mensaje = mensajeInput2.value;
      var nombreA = nombreInput.value;

      if(mensaje.trim() !== ''){
        var nuevoMensaje = document.createElement('p');

        // AJAX
        var data = {
          idUsuario: idUsuario,
          mensaje: mensaje,
          idDestinatario: idDestinatario
        };
        var jsonDatos = JSON.stringify(data);
        $.post("insertarMensajeP.php", jsonDatos, function(respuesta){
          //Simulamos un click en el boton de la asignatura correspondiente para recargar los mensajes
          var recarga = document.getElementById(idDestinatario);
          recarga.click();
        });
      }
      mensajeInput2.value = "";
    });
  });
</script>
<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioCreaEvento extends Formulario
{

    public function __construct()
    {
        parent::__construct('formEvento', ['urlRedireccion' => 'contenidoAsignatura.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'fecha', 'hora'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Nuevo evento</legend>
            <div>
            <label>Nombre del evento:</label>
            <input type="text" name="titulo" required>
            {$erroresCampos['nombre']}
            </div>

            <div>
            <label>Fecha:</label>
            <input type="date" name="fecha" required>
            {$erroresCampos['fecha']}
            </div>
          
            <div>
            <label>Hora:</label>
            <input type="time" name="hora" required>
            {$erroresCampos['hora']}
            </div>
            <button type="submit">Subir</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        if (empty($_POST['nombre'])) {
            $this->errores['nombre'] = 'Es necesario un nombre para el evento';
            return;
        }
        if (empty($_POST['fecha'])) {
            $this->errores['fecha'] = 'Es necesario una fecha para el evento';
            return;
        }
        if (empty($_POST['hora'])) {
            $this->errores['nombre'] = 'Es necesario una hora para el evento';
            return;
        }

        $fecha = $_POST['fecha'];
        $nombre = $_POST['nombre'];
        $hora = $_POST['hora'];
      
        // validar el formato de la fecha
        $fecha_valida = date_create_from_format('Y-m-d', $fecha);
        if (!$fecha_valida) {
            $this->errores['fecha'] = 'El formato de la fecha es incorrecto';
            return;
        }

        //Crea un objeto evento
        $evento = Evento::crea($nombre, $fecha, $hora, '');
        //Guardo el archivo en la BD
        $evento->guarda();
    }
}

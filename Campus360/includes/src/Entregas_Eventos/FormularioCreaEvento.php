<?php
namespace es\ucm\fdi\aw\Entregas_Eventos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioCreaEvento extends Formulario
{
    private $id_asignatura;
    public function __construct($asignatura)
    {
        parent::__construct('formEvento', ['urlRedireccion' => 'contenidoAsignatura.php?id=' . $asignatura]);
        $this->id_asignatura = $asignatura;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'descripcion', 'opciones', 'fecha', 'hora'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Nuevo evento/tarea</legend>
            <div>
            <label>Nombre del evento/tarea:</label>
            <input type="text" name="nombre" required>
            {$erroresCampos['nombre']}
            </div>

            <div>
            <label>Descripcion del evento/tarea:</label>
            <input type="text" name="descripcion" required>
            {$erroresCampos['descripcion']}
            </div>

            <div>
            <label for="opciones">¿Que deseas crear?</label>
            <select id="opciones" name="opciones">
                <option value="0">Evento</option>
                <option value="1" selected>Tarea</option>
            </select>
            {$erroresCampos['opciones']}
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
        // validar el formato de la fecha
        $fecha_valida = date_create_from_format('Y-m-d', $fecha);
        if (!$fecha_valida) {
            $this->errores['fecha'] = 'El formato de la fecha es incorrecto';
            return;
        }
        $hora = $_POST['hora'];
        $fecha = date('Y-m-d', strtotime("$fecha"));
        $horaFin = date('H:i:s', strtotime("$hora"));
        $nombre = $_POST['nombre'];
        $descrpicion = $_POST['descripcion'];
        $opciones = $_POST['opciones'];
      

        //Crea un objeto evento
        $evento = Eventos_tareas::crea(null, $fecha, $this->id_asignatura, $opciones, $descrpicion, $nombre, $hora);
        //Guardo el archivo en la BD
        //$evento->guarda();
    }
}

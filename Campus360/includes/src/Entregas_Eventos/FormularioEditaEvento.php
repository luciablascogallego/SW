<?php
namespace es\ucm\fdi\aw\Entregas_Eventos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEditaEvento extends Formulario
{
    private $evento;
    public function __construct($evento)
    {
        parent::__construct('formEditaEvento', ['urlRedireccion' => 'contenidoAsignatura.php?id='.$evento->getIdAsignatura()]);
        $this->evento = $evento;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'descripcion', 'opciones', 'asignatura','fecha', 'hora'], $this->errores, 'span', array('class' => 'error'));
        $nombre = $this->evento->getNombre();
        $descripcion = $this->evento->getDescripcion();
        $fechaFin = $this->evento->getFechafin();
        $horaFin = $this->evento->getHoraFin();
        $esentrega = $this->evento->getEsEntrega();
        $asignatura = $this->evento->getIdAsignatura();
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Nuevo evento/tarea</legend>
            <div>
            <label>Nombre del evento/tarea:</label>
            <input type="text" name="nombre" value="$nombre" required>
            {$erroresCampos['nombre']}
            </div>

            <div>
            <label>Descripcion del evento/tarea:</label>
            <input type="text" name="descripcion" value="$descripcion" required>
            {$erroresCampos['descripcion']}
            </div>
            <input type="hidden" id="opciones" name="opciones" value="$esentrega">
            <input type="hidden" id="asignatura" name="asignatura" value="$esentrega">

            <div>
            <label>Fecha:</label>
            <input type="date" name="fecha" value="$fechaFin" required>
            {$erroresCampos['fecha']}
            </div>
          
            <div>
            <label>Hora:</label>
            <input type="time" name="hora" value="$horaFin" required>
            {$erroresCampos['hora']}
            </div>
            <input type="hidden" name="id" value="{$this->evento->getId()}">
            <button type="submit">Subir</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$nombre) {
            $this->errores['nombre'] = 'Es necesario un nombre para el evento';
            return;
        }
        $fecha = trim($datos['fecha'] ?? '');
        $fecha = filter_var($fecha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$fecha) {
            $this->errores['fecha'] = 'Es necesario una fecha para el evento';
            return;
        }
        $hora = trim($datos['hora'] ?? '');
        $hora = filter_var($hora, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$hora) {
            $this->errores['hora'] = 'Es necesario una hora para el evento';
            return;
        }

        // validar el formato de la fecha
        $fecha_valida = date_create_from_format('Y-m-d', $fecha);
        if (!$fecha_valida) {
            $this->errores['fecha'] = 'El formato de la fecha es incorrecto';
            return;
        }
        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $fecha = date('Y-m-d', strtotime("$fecha"));
        $horaFin = date('H:i:s', strtotime("$hora"));
        $opciones = $_POST['opciones'];

        //Crea un objeto evento
        Eventos_tareas::crea($this->evento->getId(), $fecha, $this->evento->getIdAsignatura(), $opciones, $descripcion, $nombre, $hora);
        //Guardo el archivo en la BD
        //$evento->guarda();
    }
}

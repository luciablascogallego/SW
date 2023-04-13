<?php
namespace es\ucm\fdi\aw\Entregas_Eventos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEditaEvento extends Formulario
{
    private $id_evento;
    public function __construct($id_evento, $asignatura)
    {
        parent::__construct('formEditaEvento', ['urlRedireccion' => 'contenidoAsignatura.php?id='.$asignatura]);
        $this->id_evento = $id_evento;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'descripcion', 'opciones', 'asignatura','fecha', 'hora'], $this->errores, 'span', array('class' => 'error'));
        $evento = Eventos_tareas::buscaPorId($this->id_evento);
        $nombre = $evento->getNombre();
        $descripcion = $evento->getDescripcion();
        $fechaFin = $evento->getFechafin();
        $horaFin = $evento->getHoraFin();
        $esentrega = $evento->getEsEntrega();
        $asignatura = $evento->getIdAsignatura();
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
        $asignatura = $_POST['asignatura'];

        //Crea un objeto evento
        $evento = Eventos_tareas::crea($this->id_evento, $fecha, $asignatura, $opciones, $descrpicion, $nombre, $hora);
        //Guardo el archivo en la BD
        //$evento->guarda();
    }
}

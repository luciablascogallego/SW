<?php
namespace es\ucm\fdi\aw\Calificaciones;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;

class FormularioNuevaCalificacion extends Formulario
{

    private $idAsignatura;
    private $idAlumno;

    public function __construct($idAsignatura, $idAlumno)
    {
        parent::__construct('formNewCalif', ['urlRedireccion' => 'calificacionAsignatura.php?id='.$idAsignatura.'&id2='.$idAlumno]);
        $this->idAsignatura = $idAsignatura;
        $this->idAlumno = $idAlumno;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'nota', 'porcentaje', 'trimestre', 'comentario'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para la calificación</legend>
            <div>
            <label>Nombre de la calificacion:</label>
            <input type="text" name="nombre" id="nombre" requiered">
            {$erroresCampos['nombre']}
            </div>
            <div>
            <label>Nota de la entrega:</label>
            <input type="number" name="nota" id="nota" min="0.00" max="10.00" step="0.01" requiered">
            {$erroresCampos['nota']}
            </div>
            <div>
            <label>Porcentaje de la calificación:</label>
            <input type="number" name="porcentaje" id="porcentaje" min="10" max="100" requiered">
            {$erroresCampos['porcentaje']}
            </div>
            <div>
            <label>Trimestre:</label>
            <select id="trimestre" name="trimestre">
                <option value="1" selected>1º</option>
                <option value="2">2º</option>
                <option value="3">3º</option>
                </select>
                {$erroresCampos['trimestre']}
            </div>
            <div>
            <label>Comentario:</label>
            <textarea id="comentario" name="comentario" rows="10" cols="50"> </textarea>
                {$erroresCampos['comentario']}
            </div>
            <input type="hidden" name="id" value="$this->idAsignatura">
            <input type="hidden" name="id2" value="$this->idAlumno">
            <button type="submit">Añadir calificación</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$nombre || mb_strlen($nombre) < 5){
            $this->errores['nombre'] = 'El nombre para la calificación debe tener al menos 5 caracteres';
        }

        $nota = trim($datos['nota'] ?? '');
        $nota = filter_var($nota, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$nota || ($nota > 10.0 || $nota < 0.0)){
            $this->errores['nota'] = 'Nota no valida';
        }
        $porcentaje = trim($datos['porcentaje'] ?? '');
        $porcentaje = filter_var($porcentaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$porcentaje || ($porcentaje > 100 || $porcentaje < 10)){
            $this->errores['porcentaje'] = 'Porcentaje no valido';
        }
        $trimestre = trim($datos['trimestre'] ?? '');
        $comentario = trim($datos['comentario'] ?? '');
        $comentario = filter_var($comentario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (count($this->errores) === 0)
            Calificacion::crea(null, $this->idAsignatura, $this->idAlumno, $nota, $porcentaje, $trimestre, null, $nombre, $comentario);

    }
}

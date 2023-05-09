<?php
namespace es\ucm\fdi\aw\Calificaciones;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;

class FormularioEditCalifEntrega extends Formulario
{

    private $calificacion;

    public function __construct($calificacion)
    {
        parent::__construct('formEditCalifEntrega', ['urlRedireccion' 
            => 'entregaAlumno.php?id='.$calificacion->getIdEntrega().'&id_alumno='.$calificacion->getIdAlumno()]);
        $this->calificacion = $calificacion;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $nota = $this->calificacion->getNota();
        $porcentaje = $this->calificacion->getPorcentaje();
        $trimestre = $this->calificacion->getTrimestre();
        $comentario = $this->calificacion->getComentario();
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nota', 'porcentaje', 'trimestre', 'comentario'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos de la calificación</legend>
            <div>
            <label>Nota de la entrega:</label>
            <input type="number" name="nota" id="nota" min="0.00" max="10.00" step="0.01" value="$nota" requiered">
            {$erroresCampos['nota']}
            </div>
            <div>
            <label>Porcentaje de la calificación:</label>
            <input type="number" name="porcentaje" id="porcentaje" min="10" max="100" value="$porcentaje" requiered">
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
            <textarea id="comentario" name="comentario" rows="10" cols="50">$comentario</textarea>
                {$erroresCampos['comentario']}
            </div>
            <input type="hidden" name="id" value="{$this->calificacion->getId()}">
            <button type="submit">Editar calificación</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nota = trim($datos['nota'] ?? '');
        //$nota = filter_var($nota, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
            Calificacion::crea($this->calificacion->getId(), $this->calificacion->getIdAsignatura(), $this->calificacion->getIdAlumno(),
                             $nota, $porcentaje, $trimestre, $this->calificacion->getIdEntrega(), $this->calificacion->getNombre(), $comentario);

    }
}

<?php
namespace es\ucm\fdi\aw\Asignaturas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioPorcentajes extends Formulario
{

    private $asignatura;

    public function __construct($asignatura)
    {
        parent::__construct('formPorcentajes', ['urlRedireccion' => 'alumnosCalificaciones.php?id='.$asignatura->getId()]);
        $this->asignatura = $asignatura;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['primero', 'segundo', 'tercero'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Porcentajes asignatura</legend>
            <div>
            <label>Porcentaje primer trimestre:</label>
            <input type="number" name="primero" id="primero" min="10" max="100" value="{$this->asignatura->getPrimero()}" requiered">
            {$erroresCampos['primero']}
            </div>
            <div>
            <label>Porcentaje segundo trimestre:</label>
            <input type="number" name="segundo" id="segundo" min="10" max="100" value="{$this->asignatura->getSegundo()}" requiered">
            {$erroresCampos['segundo']}
            </div>
            <div>
            <label>Porcentaje tercero trimestre:</label>
            <input type="number" name="tercero" id="tercero" min="10" max="100" value="{$this->asignatura->getTercero()}" requiered">
            {$erroresCampos['tercero']}
            </div>
            <input type="hidden" name="id" value="{$this->asignatura->getId()}">
            <button type="submit">Subir</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $primero = trim($datos['primero'] ?? '');
        $primero = filter_var($primero, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $segundo = trim($datos['segundo'] ?? '');
        $segundo = filter_var($segundo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tercero = trim($datos['tercero'] ?? '');
        $tercero = filter_var($tercero, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //Crea un objeto asignatura
        $asignatura = Asignatura::crea($this->asignatura->getNombre(), $this->asignatura->getCurso(), 
        $this->asignatura->getIdProfesor(), $this->asignatura->getCiclo(), $this->asignatura->getGrupo(),
        $this->asignatura->getId(), $primero, $segundo, $tercero);
    }
}

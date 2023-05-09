<?php
namespace es\ucm\fdi\aw\Profesores;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEditaProfe extends Formulario
{

    private $profesorId;

    public function __construct($profesorId)
    {
        parent::__construct('formEditProfe', ['urlRedireccion' => 'usuariosAdmin.php']);
        $this->profesorId = $profesorId;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['id', 'tutoria', 'despacho'], $this->errores, 'span', array('class' => 'error'));
        $despacho = null;
        $tutoria = null;
        $profesor = Profesor::buscaPorId($this->profesorId);
        if($profesor){
            $despacho = $profesor->getDespacho();
            $tutoria = $profesor->getTutorias();
        }
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Editar profesor</legend>
            <div>
            <label>Despacho:</label>
            <input type="number" name="despacho" id="depacho" min="1" max="100" value="$despacho" required>
            {$erroresCampos['despacho']}
            </div>
          
            <div>
            <label>Hora:</label>
            <input type="time" name="tutoria" id="tutoria" value="$tutoria" required>
            {$erroresCampos['tutoria']}
            </div>
            <input type="hidden" name="id" id="id"  value="$this->profesorId">
            <button type="submit">Editar profesor</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $despacho = trim($datos['despacho'] ?? '');
        $despacho = filter_var($despacho, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$despacho || mb_strlen($despacho) > 4) {
            $this->errores['despacho'] = 'El despacho solo puede ser un número del 1 al 100';
        }

        $tutoria = trim($datos['tutoria'] ?? '');
        
        if (count($this->errores) === 0) {
            Profesor::crea($this->profesorId, $tutoria, $despacho);
        }
    }
}

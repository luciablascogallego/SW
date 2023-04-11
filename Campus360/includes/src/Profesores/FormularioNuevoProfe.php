<?php
namespace es\ucm\fdi\aw\Profesores;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioNuevoProfe extends Formulario
{

    private $idProfesor;

    public function __construct($idProfesor)
    {
        parent::__construct('formProfe', ['urlRedireccion' => 'usuariosAdmin.php']);
        $this->idProfesor = $idProfesor;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['id', 'tutoria', 'despacho'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Nuevo profesor</legend>
            <div>
            <label>Despacho:</label>
            <input type="number" name="despacho" id="depacho" min="1" max="100" required>
            {$erroresCampos['despacho']}
            </div>
          
            <div>
            <label>Hora:</label>
            <input type="time" name="tutoria" id="tutoria" required>
            {$erroresCampos['tutoria']}
            </div>
            <button type="submit">Añadir profesor</button>
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
            Profesor::crea($this->idProfesor, $tutoria, $despacho);
        }
    }
}

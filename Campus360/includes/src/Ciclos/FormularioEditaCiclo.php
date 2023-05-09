<?php
namespace es\ucm\fdi\aw\Ciclos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioEditaCiclo extends Formulario
{

    private $ciclo;

    public function __construct($ciclo)
    {
        parent::__construct('formEditCiclo', ['urlRedireccion' => 'asignaturasAdmin.php']);
        $this->ciclo = $ciclo;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre'], $this->errores, 'span', array('class' => 'error'));

        $nombre = $this->ciclo->getNombre();
        
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Editar ciclo</legend>
            <div>
            <label>Nombre del ciclo:</label>
            <input type="text" name="nombre" value="$nombre" required>
            {$erroresCampos['nombre']}
            </div>
            <input type="hidden" name="id" value="{$this->ciclo->getId()}">
            <button type="submit">Editar</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$nombre || mb_strlen($nombre) < 3) {
            $this->errores['nombre'] = 'El nombre de ciclo tiene que tener una longitud de al menos 3 caracteres.';
        }

        //Crea un objeto ciclo
        if (count($this->errores) === 0) {
            Ciclo::crea($nombre, $this->ciclo->getId());
        }
    }
}

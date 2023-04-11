<?php
namespace es\ucm\fdi\aw\Ciclos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioCreaCiclo extends Formulario
{

    public function __construct()
    {
        parent::__construct('formCiclo', ['urlRedireccion' => 'asignaturasAdmin.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Crear nuevo ciclo</legend>
            <div>
            <label>Nombre del ciclo:</label>
            <input type="text" name="nombre" required>
            {$erroresCampos['nombre']}
            </div>
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
        if ( !$nombre || mb_strlen($nombre) < 3) {
            $this->errores['nombre'] = 'El nombre de usuario tiene que tener una longitud de al menos 3 caracteres.';
        }
      
        if (Ciclo::buscaPorNombre($nombre)) {
            $this->errores['nombre'] = 'El ciclo ya existe';
            return;
        }

        //Crea un objeto ciclo
        if (count($this->errores) === 0) {
            Ciclo::crea($nombre);
        }
    }
}

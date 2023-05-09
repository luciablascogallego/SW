<?php
namespace es\ucm\fdi\aw\Alumnos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\usuarios\Usuario;

class FormularioNUevoAlumno extends Formulario
{

    private $idUsuario;

    public function __construct($idUsuario)
    {
        parent::__construct('formNuevoAlu', ['urlRedireccion' => 'usuariosAdmin.php']);
        $this->idUsuario = $idUsuario;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['padre'], $this->errores, 'span', array('class' => 'error'));

        $padres = Padre::padres();
        $selPadre = <<<EOS
          
        <select id="padres" name="padre"> 
        EOS;
        foreach($padres as $padre){
            $id = $padre['IdPadre'];
            $usuario = Usuario::buscaPorId($id);
            $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
            $selPadre .= <<<EOS
                <option value="$id">$nombre</option> 
            EOS;
        }
        $selPadre .= '</select>';
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos del nuevo alumno</legend>
            <div>
            <label>Padre del alumno:</label>
            $selPadre
            {$erroresCampos['padre']}
            </div>
            <input type="hidden" name="id" id="id"  value="$this->idUsuario">
            <button type="submit">Añadir alumno</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $padre = trim($datos['padre'] ?? '');
        
        Alumno::crea($this->idUsuario, $padre);

    }
}

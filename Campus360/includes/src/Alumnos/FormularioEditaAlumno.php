<?php
namespace es\ucm\fdi\aw\Alumnos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\usuarios\Usuario;

class FormularioEditaAlumno extends Formulario
{

    private $idUsuario;

    public function __construct($idUsuario)
    {
        parent::__construct('formCiclo', ['urlRedireccion' => 'usuariosAdmin.php']);
        $this->idUsuario = $idUsuario;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['padre'], $this->errores, 'span', array('class' => 'error'));

        $padres = Padre::padres();
        $alumno = Alumno::buscaPorId($this->idUsuario);
        $idAlumno = null;
        if($alumno)
            $idAlumno = $alumno->getId();
        $selPadre = <<<EOS
        <select id="padres" name="padre"> 
        EOS;
        if($padres){
            foreach($padres as $padre){
                $id = $padre['IdPadre'];
                $usuario = Usuario::buscaPorId($id);
                $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
                if($id == $idAlumno)
                $selPadre .= <<<EOS
                <option value="$id" selected>$nombre</option> 
                EOS;
                else
                    $selPadre .= <<<EOS
                    <option value="$id">$nombre</option> 
                    EOS;
            }
        }
            $selPadre .= <<<EOS
            <option value="0" selected>--No Padre</option> 
            EOS;
        $selPadre .= '</select>';
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos del alumno</legend>
            <div>
            <label>Padre del alumno:</label>
            $selPadre
            {$erroresCampos['padre']}
            </div>
            <button type="submit">Editar alumno</button>
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

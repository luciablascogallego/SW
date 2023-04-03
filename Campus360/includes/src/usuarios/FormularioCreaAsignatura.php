<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioCreaAsignatura extends Formulario
{

    public function __construct()
    {
        parent::__construct('formAsignatura', ['urlRedireccion' => 'admin.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'profesor', 'ciclo', 'grupo', 'curso'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Nueva asignatura</legend>
            <div>
            <label>Nombre de la asignatura:</label>
            <input type="text" name="nombre" required>
            {$erroresCampos['nombre']}
            </div>

            <div>
            <label>Curso:</label>
            <input type="text" name="curso" required>
            {$erroresCampos['curso']}
            </div>

            <div>
            <label>Profesor:</label>
            <input type="text" name="profesor" required>
            {$erroresCampos['profesor']}
            </div>

            <div>
            <label>Ciclo:</label>
            <input type="text" name="ciclo" required>
            {$erroresCampos['ciclo']}
            </div>

            <div>
            <label>Grupo:</label>
            <input type="text" name="grupo" required>
            {$erroresCampos['grupo']}
            </div>

            <button type="submit">Subir</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = $_POST['nombre'];
        $profesor = $_POST['profesor'];
        $curso = $_POST['curso'];
        $ciclo = $_POST['ciclo'];
        $grupo = $_POST['grupo'];

        $usuario = Usuario::buscaPorNombre();
        $id_profesor = $usuario->getId();

        //Crea un objeto asignatura
        $asignatura = Asignatura::crea($nombre, $curso, $profesor, $id_profesor, $ciclo, $grupo);
        //Guardo el archivo en la BD
        $asignatura->guarda();
    }
}

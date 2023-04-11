<?php
namespace es\ucm\fdi\aw\Asignaturas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Ciclos\Ciclo;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\Profesores\Profesor;

class FormularioCreaAsignatura extends Formulario
{

    public function __construct()
    {
        parent::__construct('formAsignatura', ['urlRedireccion' => 'asignaturasAdmin.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'profesor', 'ciclo', 'grupo', 'curso'], $this->errores, 'span', array('class' => 'error'));
        $ciclos = Ciclo::ciclosCampus();
        $profes = Profesor::profesCampus();
        $selectCiclos = <<<EOS
        <select id="ciclo" name="ciclo"> 
        EOS;
        foreach($ciclos as $ciclo){
            $nombre = $ciclo['Nombre'];
            $id = $ciclo['Id'];
            $selectCiclos .= <<<EOS
                <option value="$id" selected>$nombre</option> 
            EOS;
        }
        $selectCiclos .= '</select>';
        $selectProfesores = <<<EOS
        <select id="profesor" name="profesor"> 
        EOS;
        foreach($profes as $profe){
            $id = $profe['IdProfesor'];
            $usuario = Usuario::buscaPorId($id);
            $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
            $selectProfesores .= <<<EOS
                <option value="$id" selected>$nombre</option> 
            EOS;
        }
        $selectProfesores .= '</select>';
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
            <select id="curso" name="curso">
                <option value="1" selected>1º</option>
                <option value="2">2º</option>
                <option value="3">3º</option>
                <option value="4">4º</option>
                </select>
                {$erroresCampos['curso']}
            </div>

            <div>
            <label>Profesor:</label>
            $selectProfesores
            {$erroresCampos['profesor']}
            </div>

            <div>
            <label>Ciclo:</label>
            $selectCiclos
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

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre de la asignatura tiene que tener una longitud de al menos 5 caracteres.';
        }

        $curso = trim($datos['curso'] ?? '');

        $grupo = trim($datos['grupo'] ?? '');
        $grupo = filter_var($grupo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$grupo || mb_strlen($grupo) != 1) {
            $this->errores['grupo'] = 'El grupo solo puede ser una letra';
        }

        $ciclo = trim($datos['ciclo'] ?? '');

        $id_profesor = trim($datos['profesor'] ?? '');

        if(Asignatura::buscaAsignatura($nombre, $curso, $grupo, $ciclo)){
            $this->errores['ciclo'] = 'La asignatura ya existe';
        }

        //Crea un objeto asignatura
        if (count($this->errores) === 0) {
            $asignatura = Asignatura::crea($nombre, $curso, $id_profesor, $ciclo, $grupo);
        }
    }
}

<?php
namespace es\ucm\fdi\aw\Alumnos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\usuarios\Usuario;

class FormularioParticipantesAsignatura extends Formulario
{

    private $idAsignatura;

    public function __construct($idAsignatura)
    {
        parent::__construct('formPartic', ['urlRedireccion' => 'asignaturasAdmin.php']);
        $this->idAsignatura = $idAsignatura;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $hidden;
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['participantes', 'todos'], $this->errores, 'span', array('class' => 'error'));
        $alumnos = Alumno::listaAlumnos();
        $html = $htmlErroresGlobales;
        $html .= '<fieldset> <legend>Gestionar alumnos de la asignatura</legend>';
        if($alumnos){
            foreach($alumnos as $alumno){
                $usuario = Usuario::buscaPorId($alumno['IdAlumno']);
                $idAlumno = $alumno['IdAlumno'];
                $nombre = $usuario->getNombre().' '.$usuario->getApellidos();
                $hidden .= <<<EOS
                            <input type="hidden" id="todos" name="todos[]" value="$idAlumno">
                            EOS;
                if(Alumno::tieneAsignatura($this->idAsignatura, $idAlumno)){
                    $html .= <<<EOS
                    <div>
                    <label for="$idAlumno">$nombre 
                    <input type="checkbox" id="$idAlumno" name="participantes[]" value="$idAlumno" checked> 
                    </label></div>
                    EOS;
                }
                else{
                $html .= <<<EOS
                        <div>
                        <label for="$idAlumno">$nombre
                        <input type="checkbox" id="$idAlumno" name="participantes[]" value="$idAlumno">
                        </label></div>
                        EOS;
                }
            }
            $html .= $hidden;
            $html .= '<button type="submit" name="añadir"> Añadir participantes</button>';
        }

        else{
            $html .= '<p> No se encontraron alumnos para añadir</p>';
        }

        $html .= '</fieldset>';

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $valuesToAdd = $datos['participantes'];
        $allValues = $datos['todos'];
        if($valuesToAdd){
            $valuesToDelete = array_diff($allValues, $valuesToAdd);
            //Añadimos los nuevos participantes
            foreach($valuesToAdd as $add){
                if(!Alumno::tieneAsignatura($this->idAsignatura, $add)){
                    Alumno::insertaAlumnoAsignatura($add, $this->idAsignatura);
                }
            }
        }
        else{
            $valuesToDelete = $allValues;
        }
        //Eliminamos los participantes que han sido quitados de la asignatura
        foreach($valuesToDelete as $delete){
            if(Alumno::tieneAsignatura($this->idAsignatura, $delete)){
                Alumno::borraAlumnoAsignatura($delete, $this->idAsignatura);
            }
        }
    }
}
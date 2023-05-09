<?php
namespace es\ucm\fdi\aw\Calificaciones;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Entregas_Eventos\Eventos_tareas;

class FormularioEditaCalificacion extends Formulario
{

    
    private $calificacion;

    public function __construct($calificacion)
    {
        parent::__construct('formEditCalif', ['urlRedireccion' => 'calificacionAsignatura.php?id='.$calificacion->getIdAsignatura().'&id2='.$calificacion->getIdAlumno()]);
        $this->calificacion = $calificacion;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'nota', 'porcentaje', 'trimestre', 'comentario'], $this->errores, 'span', array('class' => 'error'));
        $nombre = $this->calificacion->getNombre();
        $nota = $this->calificacion->getNota();
        $trimestre = $this->calificacion->getTrimestre();
        $porcentaje = $this->calificacion->getPorcentaje();
        $comentario = $this->calificacion->getComentario();
        $select = '<label>Trimestre:</label>
                    <select id="trimestre" name="trimestre">';

        for($i = 1; $i < 4; $i = $i+1){
            if($i === $trimestre)
                $select.='<option value="'.$i.'" selected>'.$i.'º</option>';
            else
                $select.='<option value="'.$i.'">'.$i.'º</option>';
        }
        $select .= '</select>';
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para la calificación</legend>
            <div>
            <label>Nombre de la calificacion:</label>
            <input type="text" name="nombre" id="nombre" value="$nombre" requiered">
            {$erroresCampos['nombre']}
            </div>
            <div>
            <label>Nota de la entrega:</label>
            <input type="number" name="nota" id="nota" min="0.00" max="10.00" step="0.01" value="$nota" requiered">
            {$erroresCampos['nota']}
            </div>
            <div>
            <label>Porcentaje de la calificación:</label>
            <input type="number" name="porcentaje" id="porcentaje" min="10" max="100" value="$porcentaje" requiered">
            {$erroresCampos['porcentaje']}
            </div>
            <div>
                $select
                {$erroresCampos['trimestre']}
            </div>
            <div>
            <label>Comentario:</label>
            <textarea id="comentario" name="comentario" rows="10" cols="50">$comentario</textarea>
                {$erroresCampos['comentario']}
            </div>
            <input type="hidden" name="id" value="{$this->calificacion->getId()}">
            <button type="submit">Editar calificación</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$nombre || mb_strlen($nombre) < 5){
            $this->errores['nombre'] = 'El nombre para la calificación debe tener al menos 5 caracteres';
        }

        $nota = trim($datos['nota'] ?? '');
        $nota = filter_var($nota, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$nota || ($nota > 10.0 || $nota < 0.0)){
            $this->errores['nota'] = 'Nota no valida';
        }
        $porcentaje = trim($datos['porcentaje'] ?? '');
        $porcentaje = filter_var($porcentaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$porcentaje || ($porcentaje > 100 || $porcentaje < 10)){
            $this->errores['porcentaje'] = 'Porcentaje no valido';
        }
        $trimestre = trim($datos['trimestre'] ?? '');
        $comentario = trim($datos['comentario'] ?? '');
        $comentario = filter_var($comentario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (count($this->errores) === 0)
            Calificacion::crea($this->calificacion->getId(), $this->calificacion->getIdAsignatura(), $this->calificacion->getIdAlumno(), $nota, 
                        $porcentaje, $trimestre, null, $nombre, $comentario);

    }
}

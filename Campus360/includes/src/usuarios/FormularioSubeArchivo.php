<?php
//Formulario basado en el ejemplo del campus virtual
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\recurso;
use es\ucm\fdi\aw\EntregasAlumno;

class FormularioSubeArchivo extends Formulario
{
    private $id_asignatura;

    public function __construct($asignatura)
    {
        parent::__construct('formSubir', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'contenidoAsignatura.php']);
        $this->id_asignatura = $asignatura;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['archivo', 'tipo'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Subida de archivo</legend>
            <div><label for="archivo">Archivo: <input type="file" name="archivo" id="archivo" /></label>{$erroresCampos['archivo']}</div>
            <button type="submit">Subir</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        // Verificamos que la subida ha sido correcta
        $ok = $_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
        if (! $ok ) {
            $this->errores['archivo'] = 'Error al subir el archivo';
            return;
        }  

        $nombre = $_FILES['archivo']['name'];

        /*Valida el nombre del archivo */
        self::check_file_uploaded_name($nombre);

        //Valida el tamaño del archivo
        $this->check_file_uploaded_length($nombre);

        //Sanitiza el nombre del archivo (elimina los caracteres que molestan)
        self::sanitize_file_uploaded_name($nombre);
       

        //el campo tmp_name es el lugar donde se ha subido el archivo
        $tmp_name = $_FILES['archivo']['tmp_name'];
        $extension = pathinfo($nombre, PATHINFO_EXTENSION);

        if ($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::PROFE_ROLE)) {
            //Crea un objeto recursos
            $contenido = Recursos::crea(null, $id_asignatura, '');

            //Formo una ruta con el id del archivo y su extension
            $rutaContenido = "{$contenido->id}.{$extension}";
            //inicializo la ruta del archivo
            $contenido->setRuta($rutaContenido);
            //Guardo el archivo en la BD
            $contenido->guarda();

            $ruta = RUTA_RECURSOS.$rutaContenido;
            if (!move_uploaded_file($tmp_name, $ruta)) {
                $this->errores['archivo'] = 'Error al mover el archivo';
            }
        }
        elseif($app->tieneRol(es\ucm\fdi\aw\usuarios\Usuario::ALUMNO_ROLE)){
            //Crea un objeto entega
            $idUsuario = $_SESSION['idUsuario'];
            $archivo = EntregasAlumno::crea(null, $id_asignatura, $idUsuario, '');

            //Formo una ruta con el id del archivo y su extension
            $fichero = "{$archivo->id}.{$extension}";
            //inicializo la ruta del archivo
            $archivo->setRuta($fichero);
            //Guardo el archivo en la BD
            $archivo->inserta($archivo);

            $ruta = RUTA_ENTREGAS.$fichero;
            if (!move_uploaded_file($tmp_name, $ruta)) {
                $this->errores['archivo'] = 'Error al mover el archivo';
            }
        }
    }


    /**
     * Check $_FILES[][name]
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private static function check_file_uploaded_name($filename)
    {
        return (bool) ((mb_ereg_match('/^[0-9A-Z-_\.]+$/i', $filename) === 1) ? true : false);
    }

    /**
     * Sanitize $_FILES[][name]. Remove anything which isn't a word, whitespace, number
     * or any of the following caracters -_~,;[]().
     *
     * If you don't need to handle multi-byte characters you can use preg_replace
     * rather than mb_ereg_replace.
     * 
     * @param (string) $filename - Uploaded file name.
     * @author Sean Vieira
     * @see http://stackoverflow.com/a/2021729
     */
    private static function sanitize_file_uploaded_name($filename)
    {
        /* Remove anything which isn't a word, whitespace, number
     * or any of the following caracters -_~,;[]().
     * If you don't need to handle multi-byte characters
     * you can use preg_replace rather than mb_ereg_replace
     * Thanks @Łukasz Rysiak!
     */
        $newName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        // Remove any runs of periods (thanks falstro!)
        $newName = mb_ereg_replace("([\.]{2,})", '', $newName);

        return $newName;
    }

    /**
     * Check $_FILES[][name] length.
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz.
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private function check_file_uploaded_length($filename)
    {
        return (bool) ((mb_strlen($filename, 'UTF-8') < 250) ? true : false);
    }
}

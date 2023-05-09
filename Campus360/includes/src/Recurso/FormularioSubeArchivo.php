<?php
//Formulario basado en el ejemplo del campus virtual
namespace es\ucm\fdi\aw\Recurso;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\EntregasAlumno\EntregasAlumno;

class FormularioSubeArchivo extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array    (   'gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif', 
                                                'txt', 'docx', 'doc', 'pdf', 'xml', 'rtf',
                                                'mp4', 'avi', 'mov', 'zip', 'rar', '7z');
    private $id_asignatura;

    private $id_tarea;

    public function __construct($asignatura, $entrega)
    {
        parent::__construct('formSubir', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'contenidoAsignatura.php?id=' . $asignatura]);
        $this->id_asignatura = $asignatura;
        $this->id_entrega = $entrega;
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['archivo', 'tipo'], $this->errores, 'span', array('class' => 'error'));

        //$id = $_GET['id'];
        $html = <<<EOS
        $htmlErroresGlobales
        <fieldset>
            <legend>Subida de archivo</legend>
            <div><label for="archivo">Archivo: <input type="file" name="archivo" id="archivo" /></label>{$erroresCampos['archivo']}</div>
            <input type="hidden" name="id" value="$this->id_asignatura">
            <input type="hidden" name="id2" value="$this->id_entrega">
            <button type="submit">Subir</button>
        </fieldset>
        EOS;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        //el campo tmp_name es el lugar donde se ha subido el archivo
        $tmp_name = $_FILES['archivo']['tmp_name'];
        if (is_uploaded_file($tmp_name)) {
            $this->errores = [];
            // Verificamos que la subida ha sido correcta
            $ok = $_FILES['archivo']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
            if (! $ok ) {
                $this->errores['archivo'] = 'Error al subir el archivo';
                exit();
            }  

            $nombre = $_FILES['archivo']['name'];

            //Sanitiza el nombre del archivo (elimina los caracteres que molestan)
            self::sanitize_file_uploaded_name($nombre);
            /*Valida el nombre del archivo, la extension, su tamaño y el tamaño del nombre*/
            $extension = pathinfo($nombre, PATHINFO_EXTENSION);
            $ok = self::check_file_uploaded_name($nombre);
            if ($ok) {
                $this->errores['nombre'] = 'El nombre del archivo no es correcto';
            }
            $ok = in_array($extension, self::EXTENSIONES_PERMITIDAS);
            if (!$ok) {
                $this->errores['nombre'] = 'La extension del archivo no es correcta';
            }
            $ok = $this->check_file_uploaded_length($nombre);
            if (!$ok) {
                $this->errores['nombre'] = 'El nombre del archivo es demasiado grande';
            }
            $ok = $this->tam100MB($_FILES['archivo']['size']);
            if (!$ok) {
                $this->errores['size'] = 'El archivo es demasiado grande';
            }

            if (count($this->errores) > 0) {
                return;
            }

            $app = Aplicacion::getInstance();
            if ($_SESSION['rol'] == Usuario::PROFE_ROLE) {
                //Crea un objeto recursos
                $contenido = Recursos::crea(null, $this->id_asignatura, '', $nombre);

                //Formo una ruta
                $rutaContenido = RUTA_RECURSOS.$_FILES['archivo']['name'];
                //inicializo la ruta del archivo
                $contenido->setRuta($rutaContenido);
                //Guardo el archivo en la BD
                $contenido->guarda();

                chmod(RUTA_RECURSOS, 0777);
                //shell_exec('sudo chmod 777 '.RUTA_RECURSOS);
                $ruta = RUTA_RECURSOS.$rutaContenido;
                if (!is_dir(RUTA_RECURSOS)) {
                    mkdir(RUTA_RECURSOS, 0777, true);
                    //shell_exec('sudo mkdir '.RUTA_RECURSOS);
                    //shell_exec('sudo chmod 777 '.RUTA_RECURSOS);
                }     
                if (!move_uploaded_file($tmp_name, 'recursos/'.$_FILES['archivo']['name'])) {
                    $this->errores['archivo'] = 'Error al mover el archivo';
                }
            }
            elseif($_SESSION['rol'] == Usuario::ALUMNO_ROLE){
                //Crea un objeto entega
                $idUsuario = $_SESSION['idUsuario'];
                $archivo = EntregasAlumno::crea(null, $this->id_asignatura, $idUsuario, '', $nombre, $this->id_entrega);

                //Formo una ruta
                $fichero = RUTA_ENTREGAS.$_FILES['archivo']['name'];
                //inicializo la ruta del archivo
                $archivo->setRuta($fichero);
                //Guardo el archivo en la BD
                $archivo->guarda();

                chmod(RUTA_RECURSOS, 0777);
                //shell_exec('sudo chmod 777 '.RUTA_ENTREGAS);
                $ruta = RUTA_ENTREGAS.$fichero;
                if (!is_dir(RUTA_ENTREGAS)) {
                    mkdir(RUTA_ENTREGAS, 0777, true);
                    //shell_exec('sudo mkdir '.RUTA_ENTREGAS);
                    //shell_exec('sudo chmod 777 '.RUTA_ENTREGAS);
                } 
                if (!move_uploaded_file($tmp_name, 'entregas/'.$_FILES['archivo']['name'])) {
                    $this->errores['archivo'] = 'Error al mover el archivo';
                }
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

    private function check_file_uploaded_length($filename)
    {
        return (bool) ((mb_strlen($filename, 'UTF-8') < 50) ? true : false);
    }

    private function tam100MB($archivo)
    {
        $maxSize = 100 * 1024 * 1024; // 100 MB en bytes
        return (bool)($archivo > $maxSize)? false : true;
    }
}

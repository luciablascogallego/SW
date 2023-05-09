<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\Alumnos\Alumno;
use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\Profesores\Profesor;

class FormularioEditaUsuario extends Formulario
{

    private $idUsuario;

    public function __construct($idUsuario) {
        parent::__construct('formEditaUsuario', ['urlRedireccion' => 'usuariosAdmin.php']);
        $this->idUsuario = $idUsuario;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $usuario = Usuario::buscaPorId($this->idUsuario);
        $emailUsuario = $usuario->getEmail();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $password = $usuario->getPassword();
        $dir = $usuario->getDir();
        $telefono = $usuario->getTelefono();
        $NIF = $usuario->getNIF();
        $rol = $usuario->getRol();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['emailUsuario','nombre', 'apellidos', 'password','direccion', 'telefono', 'NIF', 'rol'], 
        $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos del usuario</legend>
            <div>
                <label for="emailUsuario">email del usuario:</label>
                <input id="emailUsuario" type="email" name="emailUsuario" value="$emailUsuario" />
                <span class="error" id="correo-error"></span>
                {$erroresCampos['emailUsuario']}
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                <span class="error" id="nombre-error"></span>
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="apellidos">Apellidos:</label>
                <input id="apellidos" type="text" name="apellidos" value="$apellidos" />
                <span class="error" id="apellidos-error"></span>
                {$erroresCampos['apellidos']}
            </div>   
            <div>
            <input id="password" type="hidden" name="password" value="$password" />
            <span class="error" id="password-error"></span>
            {$erroresCampos['password']}
        </div>       
            <div>
                <label for="direccion">direccion:</label>
                <input id="direccion" type="text" name="direccion" value="$dir" />
                {$erroresCampos['direccion']}
            </div>      
            <div>
                <label for="telefono">telefono:</label>
                <input id="telefono" type="tel" name="telefono" value="$telefono" />
                <span class="error" id="telefono-error"></span>
                {$erroresCampos['NIF']}
            </div>    
            <div>
                <label for="NIF">NIF:</label>
                <input id="NIF" type="text" name="NIF" value="$NIF" />
                {$erroresCampos['NIF']}
            </div>
                <label for="selRol">Rol de usuario:</label>
                <select id="selRol" name="rol">
        EOF;
                if($rol == Usuario::ALUMNO_ROLE){
                    $html .= <<<EOS
                        <option value="2" selected>Alumno</option>
                    EOS;
                }
                else{
                    $html .= <<<EOS
                    <option value="2">Alumno</option>
                    EOS;
                }
                if($rol == Usuario::PADRE_ROLE){
                    $html .= <<<EOS
                        <option value="3" selected>Padre</option>
                        EOS;
                }
                else{
                    $html .= <<<EOS
                    <option value="3" >Padre</option>
                    EOS;
                }
                if($rol == Usuario::PROFE_ROLE){
                    $html .= <<<EOS
                        <option value="4" selected>Profesor</option>
                        EOS;
                }
                else{
                    $html .= <<<EOS
                    <option value="4" >Profesor</option>
                    EOS;
                }
                if($rol == Usuario::ADMIN_ROLE){
                    $html .= <<<EOS
                        <option value="1" selected>Admin</option>
                        EOS;
                }
                else{
                    $html .= <<<EOS
                    <option value="1" >Admin</option>
                    EOS;
                }
            $html .= <<<EOS
                    </select>
                    {$erroresCampos['rol']}
                    <div>
                    <button type="submit" name="registro">Editar</button>
                    </div>
                    </fieldset>
                    EOS;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $app = Aplicacion::getInstance();

        $emailUsuario = trim($datos['emailUsuario'] ?? '');
        $emailUsuario = filter_var($emailUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$emailUsuario || mb_strlen($emailUsuario) < 5) {
            $this->errores['emailUsuario'] = 'El email de usuario tiene que tener una longitud de al menos 5 caracteres.';
        }
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$nombre || mb_strlen($nombre) < 2) {
            $this->errores['nombre'] = 'El nombre de usuario tiene que tener una longitud de al menos 2 caracteres.';
        }
        $apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$apellidos || mb_strlen($apellidos) < 7) {
            $this->errores['apellidos'] = 'Los apellidos de usuario tiene que tener en total una longitud de al menos 7 caracteres.';
        }
        $telefono = trim($datos['telefono'] ?? '');
        $telefono = filter_var($telefono, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$telefono || mb_strlen($telefono) < 13) {
            $this->errores['telefono'] = 'El telefono de usuario tiene que tener una longitud de al menos 13 caracteres.';
        }
        $dir = trim($datos['direccion'] ?? '');
        $dir = filter_var($dir, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$dir || mb_strlen($dir) < 8) {
            $this->errores['direccion'] = 'La direccion de usuario tiene que tener una longitud de al menos 8 caracteres.';
        }
        $NIF = trim($datos['NIF'] ?? '');
        $NIF = filter_var($NIF, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$NIF || mb_strlen($NIF) != 9) {
            $this->errores['NIF'] = 'El NIF del usuario tiene que tener una longitud 9 caracteres.';
        }
        $rol = trim($datos['rol'] ?? '');
        $rol = filter_var($rol, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$rol || mb_strlen($rol) != 1) {
            $this->errores['rol'] = 'El rol del usuario no es válido.';
        }

        $password = $password = trim($datos['password'] ?? '');

        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaPorId($this->idUsuario);
            $antiguoRol = $usuario->getRol();
            $usuario = Usuario::crea($emailUsuario, $password, $nombre, $apellidos ,$rol, $telefono, $NIF, $dir, $this->idUsuario);

            if ($antiguoRol == Usuario::ALUMNO_ROLE && $antiguoRol != $rol){
                Alumno::borraPorId($this->idUsuario);
            }
            else if ($antiguoRol == Usuario::PADRE_ROLE && $antiguoRol != $rol){
                Padre::borraPorId($this->idUsuario);
            }
            else if ($antiguoRol == Usuario::PROFE_ROLE && $antiguoRol != $rol){
                Profesor::borraPorId($this->idUsuario);
            }

            if ($usuario->getRol() == Usuario::ALUMNO_ROLE){
                $app->redirige('editaAlumno.php?id='.$usuario->getId());
            }
            else if ($usuario->getRol() == Usuario::PROFE_ROLE){
                $app->redirige('editaProfesor.php?id='.$usuario->getId());
            }
            else if ($usuario->getRol() == Usuario::PADRE_ROLE){
                Padre::crea($usuario->getId());
            }
            if (!$usuario) {
                $this->errores[] = "Error al crear el usuario";
            } 
        }
    }
}
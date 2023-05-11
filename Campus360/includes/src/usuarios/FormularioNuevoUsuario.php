<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Padres\Padre;
use es\ucm\fdi\aw\Formulario;

class FormularioNuevoUsuario extends Formulario
{
    public function __construct() {
        parent::__construct('formNuevoUsuario');
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $emailUsuario = $datos['emailUsuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';
        $apellidos = $datos['apellidos'] ?? '';
        $dir = $datos['direccion'] ?? '';
        $telefono = $datos['telefono'] ?? '';
        $NIF = $datos['NIF'] ?? '';
        $rol = $datos['rol'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['emailUsuario', 'password', 'password2', 'nombre', 'apellidos', 'direccion', 'telefono', 'NIF', 'rol'], 
        $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos del usuario</legend>
            <div>
                <label for="emailUsuario">email del usuario:</label>
                <input id="emailUsuario" type="email" name="emailUsuario" value="$emailUsuario" required/>
                <span class="error" id="correo-error"></span>
                {$erroresCampos['emailUsuario']}
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" required/>
                <span class="error" id="nombre-error"></span>
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="apellidos">Apellidos:</label>
                <input id="apellidos" type="text" name="apellidos" value="$apellidos" required/>
                <span class="error" id="apellidos-error"></span>
                {$erroresCampos['apellidos']}
            </div>      
            <div>
                <label for="direccion">direccion:</label>
                <input id="direccion" type="text" name="direccion" value="$dir" required/>
                {$erroresCampos['direccion']}
            </div>      
            <div>
                <label for="telefono">telefono:</label>
                <input id="telefono" type="tel" name="telefono" value="$telefono" required/>
                <span class="error" id="telefono-error"></span>
                {$erroresCampos['telefono']}
            </div>    
            <div>
                <label for="NIF">NIF:</label>
                <input id="NIF" type="text" name="NIF" value="$NIF" required/>
                <span class="error" id="nif-error"></span>
                {$erroresCampos['NIF']}
            </div>    
            <div>
                <label for="password">Contraseña:</label>
                <input id="password" type="password" name="password" required/>
                <span class="error" id="password-error"></span>
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Reintroduce la contraseña:</label>
                <input id="password2" type="password" name="password2" />
                {$erroresCampos['password2']}

                <label for="selRol">Rol de usuario:</label>
                <select id="selRol" name="rol">
                <option value="2" selected>Alumno</option>
                <option value="3">Padre</option>
                <option value="4">Profe</option>
                <option value="1">Admin</option>
                </select>
                {$erroresCampos['rol']}
            </div>
            <div>
                <button type="submit" name="registro" id="CrearUsuario">Registrar</button>
            </div>
        </fieldset>
        EOF;
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
        if(Usuario::buscaUsuario($emailUsuario)){
            $this->errores['emailUsuario'] = 'El email de usuario ya existe';
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
        if(Usuario::buscaUsuarioNIF($NIF)){
            $this->errores['NIF'] = 'El NIF de usuario ya existe';
        }
        $rol = trim($datos['rol'] ?? '');
        $rol = filter_var($rol, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$rol || mb_strlen($rol) != 1) {
            $this->errores['rol'] = 'El rol del usuario no es válido.';
        }
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = 'La contraseña tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Las contraseñas deben coincidir';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::crea($emailUsuario, $password, $nombre, $apellidos ,$rol, $telefono, $NIF, $dir, null);
            if (!$usuario) {
                $this->errores[] = "Error al crear el usuario";
            }
            else{
                if ($usuario->getRol() == Usuario::ALUMNO_ROLE){
                    ?>
                    <form action="creaAlumno.php" method="post" id="datosCrearAlumno">
                        <input type="hidden" name="id" value="<?=$usuario->getId()?>">
                        <button type="submit"></button>
                    </form>
                    <script>
                        document.getElementById('datosCrearAlumno').submit();
                    </script>
                    <?php
                }
                else if ($usuario->getRol() == Usuario::PROFE_ROLE){
                    ?>
                    <form action="creaProfesor.php" method="post" id="datosCrearProfesor">
                        <input type="hidden" name="id" value="<?=$usuario->getId()?>">
                        <button type="submit"></button>
                    </form>
                    <script>
                        document.getElementById('datosCrearProfesor').submit();
                    </script>
                    <?php
                }
                else if ($usuario->getRol() == Usuario::PADRE_ROLE){
                    Padre::crea($usuario->getId());
                    $app->redirige('usuariosAdmin.php');
                }
                else{
                    $app->redirige('usuariosAdmin.php');
                }
            }
        }
    }
}
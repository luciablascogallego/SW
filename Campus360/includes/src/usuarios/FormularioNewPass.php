<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioNewPass extends Formulario
{
    public function __construct() {
        parent::__construct('formNewPass', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/login.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $emailUsuario = $datos['emailUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['emailUsuario', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el cambio de contraseña</legend>
            <div>
                <label for="emailUsuario">email del usuario:</label>
                <input id="emailUsuario" type="email" name="emailUsuario" value="$emailUsuario" />
                {$erroresCampos['emailUsuario']}
            </div>
            <div>
                <label for="password">Nueva contraseña:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Reintroduce la contraseña:</label>
                <input id="password2" type="password" name="password2" />
                {$erroresCampos['password2']}
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $result = $app->resuelve('/index.php');

        $emailUsuario = trim($datos['emailUsuario'] ?? '');
        $emailUsuario = filter_var($emailUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$emailUsuario || mb_strlen($emailUsuario) < 5) {
            $this->errores['emailUsuario'] = 'El email de usuario tiene que tener una longitud de al menos 5 caracteres.';
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
            $usuario = Usuario::buscaUsuario($emailUsuario);
	
            if (!$usuario) {
                $this->errores[] = "El email no existe";
            } else {
                $usuario = $usuario->setPassword($datos['password']);
                $usuario = Usuario::actualiza($usuario);
                $app = Aplicacion::getInstance();
                $app->login($usuario);
                return $result;
            }
        }
    }
}
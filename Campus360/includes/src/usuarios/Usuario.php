<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Usuario
{
    use MagicProperties;

    public const ADMIN_ROLE = 1;

    public const ALUMNO_ROLE = 2;

    public const PADRE_ROLE = 3;

    public const PROFE_ROLE = 4;

    public static function login($emailUsuario, $password)
    {
        $usuario = self::buscaUsuario($emailUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return self::cargaRoles($usuario);
        }
        return false;
    }
    
    public static function crea($emailUsuario, $password, $nombre, $rol)
    {
        $user = new Usuario($emailUsuario, self::hashPassword($password), $nombre);
        $user->añadeRol($rol);
        return $user->guarda();
    }

    public static function buscaUsuario($emailUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios U WHERE U.email='%s'", $conn->real_escape_string($emailUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['email'], $fila['Contraseña'], $fila['Nombre'], $fila['Id'], $fila['dirección'],
                $fila['NIF'], $fila['Apellidos'], $fila['Telefono']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios WHERE id=%d", $idUsuario);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['email'], $fila['Contraseña'], $fila['Nombre'], $fila['Id'], $fila['dirección'],
                $fila['NIF'], $fila['Apellidos'], $fila['Telefono']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function cargaRoles($usuario)
    {
        $roles=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d"
            , $usuario->id
        );
        $rs = $conn->query($query);
        if ($rs) {
            $roles = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $usuario->roles = $roles;
            return $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
   
    private static function inserta($usuario, $rol)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Usuarios(emailUsuario, nombre, Contraseña, Telefono,
        NIF, Direccion, Apellidos) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->getemailUsuario())
            , $conn->real_escape_string($usuario->getNombre())
            , $conn->real_escape_string($usuario->getPassword())
            , $conn->real_escape_string($usuario->getTelefono())
            , $conn->real_escape_string($usuario->getNIF())
            , $conn->real_escape_string($usuario->getDir())
            , $conn->real_escape_string($usuario->getApellidos())
        );
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            $result = self::insertaRoles($usuario, $rol);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    private static function insertaRoles($usuario, $rol)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO RolesUsuario(usuario, rol) VALUES (%d, %d)"
            , $usuario->id
            , $rol
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    
    public static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuarios U SET email = '%s', Nombre='%s', Contrasena='%s' , 
        Telefono='%s', NIF='%s', Direccion='%s', Apellidos='%s' WHERE U.id=%d"
            , $conn->real_escape_string($usuario->getemailUsuario())
            , $conn->real_escape_string($usuario->getNombre())
            , $conn->real_escape_string($usuario->getPassword())
            , $conn->real_escape_string($usuario->getTelefono())
            , $conn->real_escape_string($usuario->getNIF())
            , $conn->real_escape_string($usuario->getDir())
            , $conn->real_escape_string($usuario->getApellidos())
            , $usuario->id
        );
        if ( $conn->query($query) ) {
            $result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function borraRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuario RU WHERE RU.usuario = %d"
            , $usuario->id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Usuarios U WHERE U.id = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;

    private $emailUsuario;

    private $password;

    private $nombre;

    private $dir;

    private $NIF;

    private $apellidos;

    private $telefono;

    private function __construct($emailUsuario, $password, $nombre, $id = null, $dir, $NIF, $apellidos, $telefono)
    {
        $this->id = $id;
        $this->emailUsuario = $emailUsuario;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->rol = $rol;
        $this->dir = $dir;
        $this->NIF = $NIF;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getemailUsuario()
    {
        return $this->emailUsuario;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDir(){
        return $this->dir;
    }

    public function getNIF(){
        return $this->NIF;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getApellidos(){
        return $this->apellidos;
    }

    public function CambiaRol($rol)
    {
        $this->rol = $rol;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function tieneRol($role)
    {
        if ($this->roles == null) {
            self::cargaRoles($this);
        }
        return array_search($role, $this->rol) !== false;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    
    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}

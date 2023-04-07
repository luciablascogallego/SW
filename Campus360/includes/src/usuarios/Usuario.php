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
            return self::cargaRol($usuario);
        }
        return false;
    }
    
    public static function crea($emailUsuario, $password, $nombre, $apellidos ,$rol, $telefono, $NIF, $dir)
    {
        $user = new Usuario($emailUsuario, self::hashPassword($password), $nombre, null, $dir, $NIF, $apellidos, $telefono, $rol);
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
                $result = new Usuario($fila['email'], $fila['password'], $fila['Nombre'], $fila['Id'], $fila['direccion'],
                $fila['NIF'], $fila['Apellidos'], $fila['Telefono'], null);
                $result=self::cargaRol($result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaUsuarioNIF($NIF)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios U WHERE U.NIF='%s'", $conn->real_escape_string($NIF));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['email'], $fila['password'], $fila['Nombre'], $fila['Id'], $fila['direccion'],
                $fila['NIF'], $fila['Apellidos'], $fila['Telefono'], null);
                $result=self::cargaRol($result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaporNombre($nombre, $apellidos)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios U WHERE U.Nombre='%s' AND U.Apellidos='%s'", $conn->real_escape_string($nombre),
        $conn->real_escape_string($apellidos));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['email'], $fila['password'], $fila['Nombre'], $fila['Id'], $fila['direccion'],
                $fila['NIF'], $fila['Apellidos'], $fila['Telefono'], null);
                $result=self::cargaRol($result);
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
        $query = sprintf("SELECT * FROM Usuarios WHERE Id=%d", $idUsuario);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['email'], $fila['password'], $fila['Nombre'], $fila['Id'], $fila['direccion'],
                $fila['NIF'], $fila['Apellidos'], $fila['Telefono'], null);
                $result=self::cargaRol($result);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function admins(){
        $admins = [];
        $ids = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT idUsuario FROM RolesUsuarios  WHERE rol=%d"
            , self::ADMIN_ROLE
        );
        $rs = $conn->query($query);
        if ($rs) {
            $ids = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();
            if($ids){
                foreach($ids as $id) {
                    $admins[] = self::buscaPorId($id['idUsuario']);  
                }
                return $admins;
            }
            else
                return false;
        }
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function cargaRol($usuario)
    {
        $rol;
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM RolesUsuarios RU WHERE RU.idUsuario=%d"
            , $usuario->getId()
        );
        $rs = $conn->query($query);
        if ($rs) {
            $rol = $rs->fetch_assoc();
            $rs->free();

            $usuario->CambiaRol($rol['rol']);
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
        $query=sprintf("INSERT INTO Usuarios(email, nombre, password, Telefono,
        NIF, direccion, Apellidos) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->getEmail())
            , $conn->real_escape_string($usuario->getNombre())
            , $conn->real_escape_string($usuario->getPassword())
            , $conn->real_escape_string($usuario->getTelefono())
            , $conn->real_escape_string($usuario->getNIF())
            , $conn->real_escape_string($usuario->getDir())
            , $conn->real_escape_string($usuario->getApellidos())
        );
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            $result = self::insertaRol($usuario, $rol);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    private static function insertaRol($usuario, $rol)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO RolesUsuarios(idUsuario, rol) VALUES (%d, %d)"
            , $usuario->getId()
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
        $query=sprintf("UPDATE Usuarios U SET email = '%s', Nombre='%s', password='%s' , 
        Telefono='%s', NIF='%s', direccion='%s', Apellidos='%s' WHERE U.id=%d"
            , $conn->real_escape_string($usuario->getEmail())
            , $conn->real_escape_string($usuario->getNombre())
            , $conn->real_escape_string($usuario->getPassword())
            , $conn->real_escape_string($usuario->getTelefono())
            , $conn->real_escape_string($usuario->getNIF())
            , $conn->real_escape_string($usuario->getDir())
            , $conn->real_escape_string($usuario->getApellidos())
            , $usuario->getId()
        );
        if ( $conn->query($query) ) {
            $result = self::borraRol($usuario);
            if ($result) {
                $result = self::insertaRol($usuario, $usuario->getRol());
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
   
    private static function borraRol($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuarios WHERE idUsuario = %d"
            , $usuario->getId()
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    
    public static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    
    public static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Usuarios WHERE Id = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;

    private $email;

    private $password;

    private $nombre;

    private $dir;

    private $NIF;

    private $apellidos;

    private $telefono;

    private $rol;

    private function __construct($email, $password, $nombre, $id = null, $dir, $NIF, $apellidos, $telefono, $rol)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->dir = $dir;
        $this->NIF = $NIF;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->rol = $rol;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
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
            self::cargaRol($this);
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
        return self::inserta($this, $this->getRol());
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}

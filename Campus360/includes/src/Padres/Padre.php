<?php
namespace es\ucm\fdi\aw\Padres;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Padre {
    use MagicProperties;

    public static function buscaPorId($idPadre)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Padres WHERE IdPadre=%d", $idPadre);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Padre($fila['IdPadre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function crea($idPadre){
        $padre = new Padre($idPadre);
        self::inserta($padre);

        return $padre;
    }

    private static function inserta($padre)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Padres(IdPadre) VALUES ('%d')"
            , $conn->real_escape_string($padre->getId())
        );
        if ( $conn->query($query) ) {
            $result = $padre;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
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
        $query = sprintf("DELETE FROM Padres WHERE IdPadre = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function padres(){
        $padres=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Padres"
        );
        $rs = $conn->query($query);
        if ($rs) {
            $padres = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            return $padres;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function hijos($padre){
        $hijos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.IdAlumno FROM Alumnos RU WHERE RU.IdPadre=%d"
            , $padre->getId()
        );
        $rs = $conn->query($query);
        if ($rs) {
            $hijos = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();
            foreach($hijos as $hijo){
                $padre->idHijos[] = $hijo['IdAlumno'];
            }
            return $padre;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    
    private $id;
    private $idHijos = [];

    private function __construct($id){
        $this->id = $id;
        self::hijos($this);
    }

    public function getId(){
        return $this->id;
    }

    public function getHijos(){
        return $this->idHijos;
    }

}
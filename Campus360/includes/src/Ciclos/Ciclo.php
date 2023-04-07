<?php
namespace es\ucm\fdi\aw\Ciclos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;


class Ciclo{
    use MagicProperties;

    public static function buscaPorId($idCiclo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Ciclos WHERE Id=%d", $idCiclo);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Ciclo($fila['Id'], $fila['Nombre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function ciclosCampus(){
        $ciclos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Ciclos"
        );
        $rs = $conn->query($query);
        if ($rs) {
            $ciclos = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            return $ciclos;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function crea($nombre)
    {
        return self::inserta($nombre);
    }

    public static function buscaPorNombre($nombre)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Ciclos WHERE Nombre='%s'", $nombre);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Ciclo($fila['Id'], $fila['Nombre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($nombreCiclo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Ciclos(Nombre) VALUES ('%s')"
            , $nombreCiclo
        );
        if ( $conn->query($query) ) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    public static function borraPorId($idCiclo)
    {
        if (!$idCiclo) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Ciclos  WHERE Id = %d"
            , $idCiclo
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }
    
    private $Id;
    private $Nombre;

    private function __construct($Id = null, $Nombre){
        $this->Id = $Id;
        $this->Nombre = $Nombre;
    }

    public function getId(){
        return $this->Id;
    }

    public function getNombre(){
        return $this->Nombre;
    }

}
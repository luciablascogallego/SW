<?php
namespace es\ucm\fdi\aw\Recurso;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Recursos {
    use MagicProperties;

    public static function crea($id, $idAsignatura, $ruta, $nombre){
        $recurso = new Recursos($id, $idAsignatura, $ruta, $nombre);
        return $recurso->guarda();
    }

    private $id;

    private $idAsignatura;

    private $ruta;

    private $nombre;

    private function __construct($id, $idAsignatura, $ruta, $nombre){
        $this->id = $id;
        $this->idAsignatura = $idAsignatura;
        $this->ruta = $ruta;
        $this->nombre = $nombre;
    }

    public static function buscaPorId($idRecurso)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Recursos WHERE Id=%d", $idRecurso);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Recursos($fila['Id'], $fila['IdAsignatura'], $fila['Ruta'], $fila['Nombre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function borra($recurso)
    {
        return self::borraPorId($recurso->Id);
    }

    private static function borraPorId($idRecurso)
    {
        if (!$idRecurso) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Recursos WHERE Id = %d"
            , $idRecurso
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function inserta($recursoNuevo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Recursos(Id, idAsignatura, Ruta, Nombre) VALUES ('%d', '%d', '%s', '%s')"
            , $conn->real_escape_string($recursoNuevo->getId())
            , $conn->real_escape_string($recursoNuevo->getIdAsignatura())
            , $conn->real_escape_string($recursoNuevo->getRuta())
            , $conn->real_escape_string($recursoNuevo->getNombre())
        );
        if ( $conn->query($query) ) {
            $recursoNuevo->id = $conn->insert_id;
            $result = $recursoNuevo;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getRecursosAsignatura($asignatura){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Recursos WHERE IdAsignatura=%d"
            , $asignatura
        );
        $rs = $conn->query($query);
        if ($rs) {
            $archivos = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            return $archivos;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function actualiza($recurso)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Recursos SET IdAsignatura='%d', Ruta='%s', Nombre='%s' WHERE id=%d"
            , $conn->real_escape_string($recurso->getIdAsignatura())
            , $conn->real_escape_string($recurso->getRuta())
            , $conn->real_escape_string($recurso->getNombre())
            , $recurso->id
        );
        if ( !$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }

    public function getId(){
        return $this->id;
    }

    public function getRuta(){
        return $this->ruta;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setRuta($nuevaRuta){
        $this->ruta = $nuevaRuta;
    }

    public function getIdAsignatura(){
        return $this->idAsignatura;
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
?>

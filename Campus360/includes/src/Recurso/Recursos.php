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


    public static function inserta($recursoNuevo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Recursos(id, idAsignatura, ruta) VALUES ('%i', '%i', '%s')"
            , $conn->real_escape_string($recurso->getId())
            , $conn->real_escape_string($recurso->getIdAsignatura())
            , $conn->real_escape_string($recurso->getRuta())
            , $conn->real_escape_string($recurso->getNombre())
        );
        if ( $conn->query($query) ) {
            $recurso->id = $conn->insert_id;
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
        $query=sprintf("UPDATE Recursos SET idAsignatura='%i', ruta='%s' WHERE U.id=%d"
            , $conn->real_escape_string($recurso->getIdAsignatura())
            , $conn->real_escape_string($recurso->getRuta())
            , $recurso->id
        );
        
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

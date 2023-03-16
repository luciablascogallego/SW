<?php
namespace es\ucm\fdi\aw\entregasAlumno;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class EntregasAlumno {
    use MagicProperties;

    public static function crea($id, $idAsignatura, $idAlumno, $ruta){
        $recurso = new Recursos($id, $idAsignatura, $idAlumno, $ruta);
        return $recurso->guarda();
    }

    private $id;

    private $idAsignatura;

    private $ruta;

    public static function inserta($entrega)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO EntregasAlumno(id, idAsignatura, idAlumno, ruta) VALUES ('%i', '%i', '%i', '%s')"
            , $conn->real_escape_string($entrega->getId())
            , $conn->real_escape_string($entrega->getIdAsignatura())
            , $conn->real_escape_string($entrega->getIdAlumno())
            , $conn->real_escape_string($entrega->getRuta())
        );
        if ( $conn->query($query) ) {
            $entrega->id = $conn->insert_id;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static getEntregasAsignatura($asignatura){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM EntregasAlumno WHERE IdAsignatura=%i"
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

    public static getEntrega($entrega){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM EntregasAlumno WHERE IdEntrega=%i"
            , $entrega
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

    public function getId(){
        return $this->id;
    }

    public function getRuta(){
        return $this->ruta;
    }

    public function setRuta($nuevaRuta){
        this->ruta = $nuevaRuta;
    }

    public function getIdAlumno(){
        return $this->idAsignatura;
    }

    public function getIdEntega(){
        return $this->idEntrega;
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
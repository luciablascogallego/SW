<?php
namespace es\ucm\fdi\aw\EntregasAlumno;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class EntregasAlumno {
    use MagicProperties;

    public static function crea($id, $idAsignatura, $idAlumno, $ruta, $nombre, $idEntrega){
        $recurso = new EntregasAlumno($id, $idAsignatura, $idAlumno, $ruta, $nombre, $idEntrega);
        return $recurso->guarda();
    }

    private $id;

    private $idAsignatura;

    private $idAlumno;

    private $ruta;

    private $nombre;

    private $idEntrega;

    private function __construct($id, $idAsignatura, $idAlumno, $ruta, $nombre, $idEntrega){
        $this->id = $id;
        $this->idAsignatura = $idAsignatura;
        $this->idAlumno = $idAlumno;
        $this->ruta = $ruta;
        $this->nombre = $nombre;
        $this->idEntrega = $idEntrega;
    }

    public static function inserta($entrega)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO EntregasAlumno(id, idAsignatura, idAlumno, ruta, nombre, idEntrega) VALUES ('%d', '%d', '%d', '%s', '%s', '%d')"
            , $conn->real_escape_string($entrega->getId())
            , $conn->real_escape_string($entrega->getIdAsignatura())
            , $conn->real_escape_string($entrega->getIdAlumno())
            , $conn->real_escape_string($entrega->getRuta())
            , $conn->real_escape_string($entrega->getNombre())
            , $conn->real_escape_string($entrega->getIdEntrega())
        );
        if ( $conn->query($query) ) {
            $entrega->id = $conn->insert_id;
            $result = $entrega;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM EntregasAlumno WHERE Id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new EntregasAlumno($fila['Id'], $fila['IdAsignatura'], $fila['IdAlumno'], $fila['Ruta'], $fila['nombre'], $fila['idEntrega']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getEntregasPorId($id){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM EntregasAlumno WHERE IdEntrega=%d"
            , $id
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

    public static function getEntregasAsignatura($asignatura){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM EntregasAlumno WHERE IdAsignatura=%d"
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

    public static function getEntrega($entrega){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM EntregasAlumno WHERE IdEntrega=%d"
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

    public static function actualiza($entrega)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE EntregasAlumno SET IdAsignatura='%d', IdAlumno='%d', Ruta='%s', nombre='%s', IdEntrega='%d' WHERE id=%d"
            , $conn->real_escape_string($entrega->getIdAsignatura())
            , $conn->real_escape_string($entrega->getIdAlumno())
            , $conn->real_escape_string($entrega->getRuta())
            , $conn->real_escape_string($entrega->getNombre())
            , $conn->real_escape_string($entrega->getIdEntrega())
            , $entrega->id
        );
        if ( !$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }

    private static function borraPorId($idEntrega)
    {
        if (!$idEntrega) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM EntregasAlumno WHERE Id = %d"
            , $idEntrega
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public function getId(){
        return $this->id;
    }

    public function getRuta(){
        return $this->ruta;
    }

    public function setRuta($nuevaRuta){
        $this->ruta = $nuevaRuta;
    }

    public function getIdAsignatura(){
        return $this->idAsignatura;
    }

    public function getIdAlumno(){
        return $this->idAlumno;
    }

    public function getIdEntrega(){
        return $this->idEntrega;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    private static function borra($entrega)
    {
        return self::borraPorId($entrega->Id);
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
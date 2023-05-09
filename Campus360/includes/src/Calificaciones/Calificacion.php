<?php
namespace es\ucm\fdi\aw\Calificaciones;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Calificacion {

    use MagicProperties;

    public static function crea($id, $idAsignatura, $idAlumno, $nota, $porcentaje, $trimestre, $idEntrega, $nombre, $comentario){
        $calificacion = new Calificacion($id, $idAsignatura, $idAlumno, $nota, $porcentaje, $trimestre, $idEntrega, $nombre, $comentario);
        return $calificacion->guarda();
    }

    public static function inserta($calificacion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($calificacion->getIdEntrega() != null){
            $query=sprintf("INSERT INTO Calificaciones(Id, IdAsignatura, IdAlumno, Nota, Porcentaje, Trimestre, IdEntrega, Nombre, Comentario) 
            VALUES ('%d', '%d', '%d', '%s', '%d', '%d', '%d', '%s', '%s')"
                , $conn->real_escape_string($calificacion->getId())
                , $conn->real_escape_string($calificacion->getIdAsignatura())
                , $conn->real_escape_string($calificacion->getIdAlumno())
                , $conn->real_escape_string($calificacion->getNota())
                , $conn->real_escape_string($calificacion->getPorcentaje())
                , $conn->real_escape_string($calificacion->getTrimestre())
                , $conn->real_escape_string($calificacion->getIdEntrega())
                , $conn->real_escape_string($calificacion->getNombre())
                , $conn->real_escape_string($calificacion->getComentario())
            );
        }
        else{
            $query=sprintf("INSERT INTO Calificaciones(Id, IdAsignatura, IdAlumno, Nota, Porcentaje, Trimestre, Nombre, Comentario) 
            VALUES ('%d', '%d', '%d', '%s', '%d', '%d', '%s', '%s')"
                , $conn->real_escape_string($calificacion->getId())
                , $conn->real_escape_string($calificacion->getIdAsignatura())
                , $conn->real_escape_string($calificacion->getIdAlumno())
                , $conn->real_escape_string($calificacion->getNota())
                , $conn->real_escape_string($calificacion->getPorcentaje())
                , $conn->real_escape_string($calificacion->getTrimestre())
                , $conn->real_escape_string($calificacion->getNombre())
                , $conn->real_escape_string($calificacion->getComentario())
            );
        }
        if ( $conn->query($query) ) {
            $calificacion->id = $conn->insert_id;
            $result = $calificacion;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Calificaciones WHERE Id=%d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Calificacion($fila['Id'], $fila['IdAsignatura'], $fila['IdAlumno'], $fila['Nota'], $fila['Porcentaje'], $fila['Trimestre']
                , $fila['IdEntrega'], $fila['Nombre'], $fila['Comentario']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getCalificacionesAlumno($idAlumno){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Calificaciones WHERE IdAlumno=%d"
            , $idAlumno
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

    public static function getCalificacionesAsignatura($idAsignatura){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Calificaciones WHERE IdAsignatura=%d"
            , $idAsignatura
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

    public static function getCalificacionesAsignaturaAlumnoTrimestre($idAsignatura, $idAlumno, $trimestre){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Calificaciones WHERE IdAsignatura=%d AND IdAlumno=%d AND Trimestre=%d"
            , $idAsignatura
            , $idAlumno
            , $trimestre
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

    public static function getCalificacionEntrega($idEntrega){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Calificaciones WHERE IdEntrega=%d"
            , $idEntrega
        );
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Calificacion($fila['Id'], $fila['IdAsignatura'], $fila['IdAlumno'], $fila['Nota'], $fila['Porcentaje'], $fila['Trimestre']
                , $fila['IdEntrega'], $fila['Nombre'], $fila['Comentario']);
            }
            $rs->free();
            return $result;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function actualiza($calificacion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Calificaciones SET IdAsignatura='%d', IdAlumno='%d', Nota='%s', Porcentaje='%d', Trimestre='%d'
        , Nombre='%s', Comentario='%s' WHERE Id=%d"
            , $conn->real_escape_string($calificacion->getIdAsignatura())
            , $conn->real_escape_string($calificacion->getIdAlumno())
            , $conn->real_escape_string($calificacion->getNota())
            , $conn->real_escape_string($calificacion->getPorcentaje())
            , $conn->real_escape_string($calificacion->getTrimestre())
            , $conn->real_escape_string($calificacion->getNombre())
            , $conn->real_escape_string($calificacion->getComentario())
            , $calificacion->getId()
        );
        if ( !$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }

    public static function borraPorId($idCalificacion)
    {
        if (!$idCalificacion) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Calificaciones WHERE Id = %d"
            , $idCalificacion
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;

    private $idAsignatura;

    private $idAlumno;

    private $nota;

    private $porcentaje;

    private $trimestre;

    private $idEntrega;

    private $nombre;

    private $comentario;


    private function __construct($id = null, $idAsignatura, $idAlumno, $nota, $porcentaje, $trimestre, $idEntrega = null, $nombre,
                                $comentario = null){
        $this->id = $id;
        $this->idAsignatura = $idAsignatura;
        $this->idAlumno = $idAlumno;
        $this->nota = $nota;
        $this->porcentaje = $porcentaje;
        $this->trimestre = $trimestre;
        $this->idEntrega = $idEntrega;
        $this->nombre = $nombre;
        $this->comentario = $comentario;
    }

    public function getId(){
        return $this->id;
    }

    public function getNota(){
        return $this->nota;
    }

    public function getIdAsignatura(){
        return $this->idAsignatura;
    }

    public function getIdAlumno(){
        return $this->idAlumno;
    }

    public function getTrimestre(){
        return $this->trimestre;
    }

    public function getPorcentaje(){
        return $this->porcentaje;
    }

    public function getIdEntrega(){
        return $this->idEntrega;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getComentario(){
        return $this->comentario;
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    private static function borra($calificacion)
    {
        return self::borraPorId($calificacion->Id);
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
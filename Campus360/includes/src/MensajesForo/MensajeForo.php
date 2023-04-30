<?php
namespace es\ucm\fdi\aw\MensajesForo;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class MensajeForo {
    use MagicProperties;

    private $id;

    private $idAutor;

    private $mensaje;

    private $idAsignatura;

    private $autor;

    private $fecha;

    public static function crea($id, $idAutor, $idAsignatura, $mensaje, $autor, $fecha){
        $mensajeNuevo = new MensajeForo($id, $idAutor, $idAsignatura, $mensaje, $autor, $fecha);
        return $mensajeNuevo->guarda();
    }

    private function __construct($id, $idAutor, $idAsignatura, $mensaje, $autor, $fecha){
        $this->id = $id;
        $this->idAsignatura = $idAsignatura;
        $this->idAutor = $idAutor;
        $this->mensaje = $mensaje;
        $this->autor = $autor;
        $this->fecha = $fecha;
    }

    public static function inserta($mensaje)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO MensajeForo(id, idAutor, idAsignatura, mensaje, autor, fecha) VALUES ('%d', '%d', '%d', '%s', '%s', '%s')"
            , $conn->real_escape_string($mensaje->getId())
            , $conn->real_escape_string($mensaje->getIdAutor())
            , $conn->real_escape_string($mensaje->getIdAsignatura())
            , $conn->real_escape_string($mensaje->getMensaje())
            , $conn->real_escape_string($mensaje->getAutor())
            , $conn->real_escape_string($mensaje->getFecha())
        );
        if ( $conn->query($query) ) {
            $mensaje->id = $conn->insert_id;
            $result = $mensaje;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getMensajesAsignatura($asignatura){
        $mensajes=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM MensajeForo WHERE IdAsignatura=%d"
            , $asignatura
        );
        $rs = $conn->query($query);
        if ($rs) {
            $mensajes = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            return $mensajes;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function actualiza($mensaje)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE MensajeForo SET Id='%d', IdAutor='%d', idAsignatura='%d', mensaje='%s', autor='%s', fecha='%s' WHERE id=%d"
            , $conn->real_escape_string($mensaje->getId())
            , $conn->real_escape_string($mensaje->getIdAutor())
            , $conn->real_escape_string($mensaje->getIdAsignatura())
            , $conn->real_escape_string($mensaje->getMensaje())
            , $conn->real_escape_string($mensaje->getAutor())
            , $conn->real_escape_string($mensaje->getFecha())
            , $mensaje->id
        );
        if ( !$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }

    private static function borraPorId($idMensaje)
    {
        if (!$idMensaje) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM MensajeForo WHERE Id = %d"
            , $idMensaje
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

    public function getIdAutor(){
        return $this->idAutor;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function getIdAsignatura(){
        return $this->idAsignatura;
    }

    public function getMensaje(){
        return $this->mensaje;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    private static function borra($mensaje)
    {
        return self::borraPorId($mensaje->Id);
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
<?php
namespace es\ucm\fdi\aw\MensajesPrivados;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class MensajePrivado {
    use MagicProperties;

    private $id;

    private $idAutor;

    private $mensaje;

    private $idRemitente;

    private $fecha;

    public static function crea($id, $idAutor, $idRemitente, $mensaje, $fecha){
        $mensajeNuevo = new MensajePrivado($id, $idAutor, $idRemitente, $mensaje, $fecha);
        return $mensajeNuevo->guarda();
    }

    private function __construct($id, $idAutor, $idRemitente, $mensaje, $fecha){
        $this->id = $id;
        $this->idRemitente = $idRemitente;
        $this->idAutor = $idAutor;
        $this->mensaje = $mensaje;
        $this->fecha = $fecha;
    }

    public static function inserta($mensaje)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO MensajePrivado(id, idAutor, idRemitente, mensaje, fecha) VALUES ('%d', '%d', '%d', '%s', '%s')"
            , $conn->real_escape_string($mensaje->getId())
            , $conn->real_escape_string($mensaje->getIdAutor())
            , $conn->real_escape_string($mensaje->getIdRemitente())
            , $conn->real_escape_string($mensaje->getMensaje())
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

    public static function getMensajesChat($idAutor, $idRemitente){
        $mensajes=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM MensajePrivado WHERE (IdAutor=%d AND idRemitente=%d) OR (IdAutor=%d AND idRemitente=%d)"
            , $idAutor
            , $idRemitente
            , $idRemitente
            , $idAutor
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
        $query=sprintf("UPDATE MensajePrivado SET Id='%d', IdAutor='%d', idRemitente='%d', mensaje='%s', fecha='%s' WHERE id=%d"
            , $conn->real_escape_string($mensaje->getId())
            , $conn->real_escape_string($mensaje->getIdAutor())
            , $conn->real_escape_string($mensaje->getIdRemitente())
            , $conn->real_escape_string($mensaje->getMensaje())
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
        $query = sprintf("DELETE FROM MensajePrivado WHERE Id = %d"
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

    public function getIdRemitente(){
        return $this->idRemitente;
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
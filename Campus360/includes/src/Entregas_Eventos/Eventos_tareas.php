<?php
namespace es\ucm\fdi\aw\Entregas_Eventos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Eventos_tareas {
    use MagicProperties;

    private $id;

    private $fecha;

    private $idAsignatura;

    private $esentrega;

    private $descripcion;

    private $nombre;

    public static function crea($id, $fecha, $idAsignatura, $esentrega, $descripcion, $nombre){
        $evento_tarea = new Eventos_tareas($id, $fecha, $idAsignatura, $esentrega, $descripcion, $nombre);
        return $evento_tarea->guarda();
    }

    private function __construct($id, $fecha, $idAsignatura, $esentrega, $descripcion, $nombre)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->idAsignatura = $idAsignatura;
        $this->esentrega = $esentrega;
        $this->descripcion = $descripcion;
        $this->nombre = $nombre;
    }

    public static function getEntregasAsignatura($asignatura){
        $archivos=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Eventos_Tareas WHERE IdAsignatura=%d"
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

    public static function buscaPorFechaFin($fechaFin)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Eventos_Tareas WHERE FechaFin=%s", $fechaFin);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Eventos_tareas($fila['id'], $fila['idAsignatura'], $fila['fechaFin']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorIdAsignatura($idAsignatura)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Eventos_Tareas WHERE idAsignatura=%i", $idAsignatura);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Eventos_tareas($fila['Id'], $fila['FechaFin'], $fila['IdAsignatura'], $fila['esentrega'], $fila['descripcion'], $fila['nombre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idTarea)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Eventos_Tareas WHERE id=%d", $idTarea);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Eventos_tareas($fila['Id'], $fila['FechaFin'], $fila['IdAsignatura'], $fila['esentrega'], $fila['descripcion'], $fila['nombre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($nuevo)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Eventos_Tareas(Id, FechaFin, IdAsignatura, esentrega, descripcion, nombre) VALUES ('%d', '%s', '%d', '%d', '%s', '%s')"
            , $conn->real_escape_string($nuevo->getId())
            , $conn->real_escape_string($nuevo->getFechaFin())
            , $conn->real_escape_string($nuevo->getIdAsignatura())
            , $conn->real_escape_string($nuevo->getEsEntrega())
            , $conn->real_escape_string($nuevo->getDescripcion())
            , $conn->real_escape_string($nuevo->getNombre())
        );
        if ( $conn->query($query) ) {
            $nuevo->id = $conn->insert_id;
            $result = $nuevo;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function borra($tarea)
    {
        return self::borraPorId($tarea->id);
    }

    private static function borraPorId($idTarea)
    {
        if (!$idTarea) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Eventos_Tareas U WHERE U.id = %d"
            , $idTarea
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

    public function getFechafin(){
        return $this->fecha;
    }

    public function getIdAsignatura(){
        return $this->idAsignatura;
    }

    public function getEsEntrega(){
        return $this->esentrega;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
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
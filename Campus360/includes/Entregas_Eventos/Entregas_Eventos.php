<?php
namespace es\ucm\fdi\aw\entregas_eventos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Entregas_Eventos {
    use MagicProperties;

    public static function crea($nombre, $curso, $idProfesor, $ciclo, $grupo){
        $asignatura = new Entregas_Eventos($ciclo, $curso, $grupo, $nombre, $idProfesor);
        return $asignatura->guarda();
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
                $result = new Entrega_Tarea($fila['id'], $fila['idAsignatura'], $fila['fechaFin']);
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
                $result = new Entrega_Tarea($fila['id'], $fila['idAsignatura'], $fila['fechaFin']);
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
                $result = new Entrega_Tarea($fila['id'], $fila['idAsignatura'], $fila['fechaFin']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($tarea, $idAsignatura)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Eventos_Tareas(id, idAsignatura, fechaFin) VALUES ('%i', '%i', '%s')"
            , $conn->real_escape_string($tarea->getId())
            , $conn->real_escape_string($idAsignatura)
            , $conn->real_escape_string($tarea->getFechafin())
        );
        if ( $conn->query($query) ) {
            $asignatura->id = $conn->insert_id;
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


    private $id;

    private $fechaFin;

    private function __construct($id=null, $fechaFin)
    {
        $this->id = $id;
        $this->fechaFin = $fechaFin;
    }

    public function getId(){
        return $this->id;
    }

    public function getFechafin(){
        return $this->fechaFin;
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
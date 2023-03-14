<?php
namespace es\ucm\fdi\aw\asignatura;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Asignatura {
    use MagicProperties;

    public static function crea($nombre, $curso, $idProfesor, $ciclo, $grupo){
        $asignatura = new Asignatura($ciclo, $curso, $grupo, $nombre, $idProfesor);
        return $asignatura->guarda();
    }

    public static function buscaPorCursoGrupo($curso, $grupo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE curso=%i AND grupo=%s", $curso, $grupo);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Curso'], $fila['Grupo'], $fila['Ciclo'], $fila['Nombre'], $fila['id'], $fila['Profesor']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorCurso($curso)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE curso=%i", $curso);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Curso'], $fila['Grupo'], $fila['Ciclo'], $fila['Nombre'], $fila['id'], $fila['Profesor']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorCiclo($ciclo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE ciclo=%s", $ciclo);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Curso'], $fila['Grupo'], $fila['Ciclo'], $fila['Nombre'], $fila['id'], $fila['Profesor']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idAsignatura)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE id=%d", $idAsignatura);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Curso'], $fila['Grupo'], $fila['Ciclo'], $fila['Nombre'], $fila['id'], $fila['Profesor']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($asignatura)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Asignaturas(ciclo, curso, grupo, nombre, profesor) VALUES ('%s', '%i', '%s', '%s', '%i')"
            , $conn->real_escape_string($asignatura->getCiclo())
            , $conn->real_escape_string($asignatura->getCurso())
            , $conn->real_escape_string($asignatura->getGrupo())
            , $conn->real_escape_string($asignatura->getNombre())
            , $conn->real_escape_string($asignatura->getIdProfesor())
        );
        if ( $conn->query($query) ) {
            $asignatura->id = $conn->insert_id;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function borra($asignatura)
    {
        return self::borraPorId($asignatura->id);
    }

    private static function borraPorId($idAsignatura)
    {
        if (!$idAsignatura) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Asignaturas U WHERE U.id = %d"
            , $idAsignatura
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }


    private $id;

    private $ciclo;

    private $curso;

    private $grupo;

    private $nombre;

    private $idProfesor;

    private function __construct($id=null, $ciclo, $curso, $grupo, $nombre, $idProfesor)
    {
        $this->id = $id;
        $this->ciclo = $ciclo;
        $this->curso = $curso;
        $this->grupo = $grupo;
        $this->nombre = $nombre;
        $this->idProfesor = $idProfesor;
    }

    public function getId(){
        return $this->id;
    }

    public function getCiclo(){
        return $this->ciclo;
    }

    public function getCurso(){
        return $this->curso;
    }

    public function getGrupo(){
        return $this->grupo;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getIdProfesor(){
        return $this->idProfesor;
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
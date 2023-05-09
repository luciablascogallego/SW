<?php
namespace es\ucm\fdi\aw\Asignaturas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Asignatura {
    use MagicProperties;

    public static function crea($nombre, $curso, $idProfesor, $ciclo, $grupo, $id, $primero, $segundo, $tercero){
        $asignatura = new Asignatura($id, $ciclo, $curso, $grupo, $nombre, $idProfesor, $primero, $segundo, $tercero);
        return $asignatura->guarda();
    }

    public static function buscaAsignatura($nombre, $curso, $grupo, $idCiclo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE Nombre='%s' AND Curso='%s' AND Grupo='%s' AND Ciclo='%d'", 
            $nombre, $curso, $grupo, $idCiclo);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Id'], $fila['Ciclo'], $fila['Curso'], $fila['Grupo'], $fila['Nombre'], $fila['Profesor']
                        , $fila['Primero'], $fila['Segundo'], $fila['Tercero']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorCursoGrupo($curso, $grupo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE Curso='%d' AND Grupo='%s'", $curso, $grupo);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Id'], $fila['Ciclo'], $fila['Curso'], $fila['Grupo'], $fila['Nombre'], $fila['Profesor']
                        , $fila['Primero'], $fila['Segundo'], $fila['Tercero']);
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
        $query = sprintf("SELECT * FROM Asignaturas WHERE Curso='%d'", $curso);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Id'], $fila['Ciclo'], $fila['Curso'], $fila['Grupo'], $fila['Nombre'], $fila['Profesor']
                        , $fila['Primero'], $fila['Segundo'], $fila['Tercero']);
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
        $query = sprintf("SELECT * FROM Asignaturas WHERE Ciclo=%d", $ciclo);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $asignaturas = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();
            return $asignaturas;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaPorCicloCurso($ciclo, $curso)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE Ciclo=%d AND Curso=%d", $ciclo, $curso);
        $rs = $conn->query($query);
        if ($rs) {
            $asignaturas = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();
            return $asignaturas;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
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
                $result = new Asignatura($fila['Id'], $fila['Ciclo'], $fila['Curso'], $fila['Grupo'], $fila['Nombre'], $fila['Profesor']
                        , $fila['Primero'], $fila['Segundo'], $fila['Tercero']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorNombre($nombre)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Asignaturas WHERE Nombre=%s", $nombre);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Asignatura($fila['Id'], $fila['Ciclo'], $fila['Curso'], $fila['Grupo'], $fila['Nombre'], $fila['Profesor']
                        , $fila['Primero'], $fila['Segundo'], $fila['Tercero']);
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
        $query=sprintf("INSERT INTO Asignaturas(ciclo, curso, grupo, nombre, profesor, primero, segundo, tercero) VALUES ('%s', '%d', '%s', '%s', '%d', '%d', '%d', '%d')"
            , $conn->real_escape_string($asignatura->getCiclo())
            , $conn->real_escape_string($asignatura->getCurso())
            , $conn->real_escape_string($asignatura->getGrupo())
            , $conn->real_escape_string($asignatura->getNombre())
            , $conn->real_escape_string($asignatura->getIdProfesor())
            , $conn->real_escape_string($asignatura->getPrimero())
            , $conn->real_escape_string($asignatura->getSegundo())
            , $conn->real_escape_string($asignatura->getTercero())
        );
        if ( $conn->query($query) ) {
            $asignatura->id = $conn->insert_id;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function actualiza($asignatura)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Asignaturas A SET Ciclo = '%d', Curso='%d', Grupo='%s' , 
        Nombre='%s', Profesor='%d', Primero='%d', Segundo='%d', Tercero='%d' WHERE A.Id='%d'"
            , $conn->real_escape_string($asignatura->getCiclo())
            , $conn->real_escape_string($asignatura->getCurso())
            , $conn->real_escape_string($asignatura->getGrupo())
            , $conn->real_escape_string($asignatura->getNombre())
            , $conn->real_escape_string($asignatura->getIdProfesor())
            , $conn->real_escape_string($asignatura->getPrimero())
            , $conn->real_escape_string($asignatura->getSegundo())
            , $conn->real_escape_string($asignatura->getTercero())
            , $conn->real_escape_string($asignatura->getId())
        );
        if ( $conn->query($query) ) {
            if ($result) {
                $result = true;
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }

    public static function borra($idAsignatura)
    {
        self::borraParticipantes($idAsignatura);
        return self::borraPorId($idAsignatura);
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
        $query = sprintf("DELETE FROM Asignaturas WHERE Id = %d"
            , $idAsignatura
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private static function borraParticipantes($idAsignatura)
    {
        if (!$idAsignatura) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM EstudianAsignaturas WHERE IdAsignatura = %d"
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

    private $primero;

    private $segundo;

    private $tercero;

    private function __construct($id=null, $ciclo, $curso, $grupo, $nombre, $idProfesor, $primero, $segundo, $tercero)
    {
        $this->id = $id;
        $this->ciclo = $ciclo;
        $this->curso = $curso;
        $this->grupo = $grupo;
        $this->nombre = $nombre;
        $this->idProfesor = $idProfesor;
        $this->primero = $primero;
        $this->segundo = $segundo;
        $this->tercero = $tercero;
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

    public function getPrimero(){
        return $this->primero;
    }

    public function getSegundo(){
        return $this->segundo;
    }

    public function getTercero(){
        return $this->tercero;
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
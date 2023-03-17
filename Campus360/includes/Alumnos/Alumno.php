<?php
namespace es\ucm\fdi\aw\alumno;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Alumno {
    use MagicProperties;

    public static function buscaPorId($idAlumno)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Alumnos WHERE IdAlumno=%d", $idAlumno);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Alumno($fila['IdAlumno'], $fila['IdPadre']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function listaAlumnos(){
        $alumnos = [];

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT IdAlumno FROM Alumnos"
        );
        $rs = $rs = $conn->query($query);
        if ($rs) {
            $profesores = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            return $profesores;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    private static function inserta($alumno)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Alumnos(IdAlumno, IdPadre) VALUES ('%d', '%d')"
            , $conn->real_escape_string($alumno->getId())
            , $conn->real_escape_string($alumno->getIdPadre())
        );
        if ( $conn->query($query) ) {
            $result = $alumno;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Alumnos  WHERE IdAlumno = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function borraAlumnoAsignatura($idAlumno, $idAsignatura){
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM EstudianAsignaturas  WHERE IdAlumno = %d AND IdAsignatura=%d"
            , $idAlumno, $idAsignatura
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true; 
    }
   
    private static function asignaturasAlumno($alumno){
        $asignaturas=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.IdAsignatura FROM EstudianAsignaturas RU WHERE RU.IdAlumno=%d"
            , $alumno->getId()
        );
        $rs = $conn->query($query);
        if ($rs) {
            $asignaturas = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $alumno->setAsignaturas($asignaturas);
            return $alumno;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    
    private $id;
    private $idPadre;
    private $idAsignaturas = [];

    private function __construct($id, $idPadre){
        $this->id = $id;
        $this->idPadre = $idPadre;
        self::asignaturasAlumno($this);
    }

    public function getId(){
        return $this->id;
    }

    public function getIdPadre(){
        return $this->idPadre;
    }

    public function getIdAsignaturas(){
        return $this->idAsignaturas;
    }

    public function setAsignaturas($asignaturas){
        foreach($asignaturas as $asignatura){
            $this->asignaturasAlumno[] = $asignatura['IdAsignatura'];
        }
    }

}
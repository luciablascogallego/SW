<?php
namespace es\ucm\fdi\aw\Alumnos;

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
                $asiganturas = [];
                $result = new Alumno($fila['IdAlumno'], $fila['IdPadre'], null);
                $alumno = self::asignaturasAlumno($result);
                if($alumno)
                    $result = $alumno;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function crea ($idAlumno, $idPadre){
        $result = new Alumno($idAlumno, $idPadre, null);
        //$alumno = self::asignaturasAlumno($result);
        self::inserta($result);
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

    public static function insertaAlumnoAsignatura($idAlumno, $idAsignatura){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO EstudianAsignaturas(IdAlumno, IdAsignatura) VALUES ('%d', '%d')"
            , $idAlumno, $idAsignatura
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true; 
    }

    public static function borraAlumnoAsignatura($idAlumno, $idAsignatura){
        if (!$idAlumno) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM EstudianAsignaturas  WHERE IdAlumno=%d AND IdAsignatura=%d"
            , $idAlumno, $idAsignatura
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true; 
    }

    public static function tieneAsignatura($idAsignatura, $idAlumno){
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM EstudianAsignaturas  WHERE IdAlumno=%d AND IdAsignatura=%d"
            , $idAlumno, $idAsignatura
        );
        $rs = $conn->query($query);
        if ($rs){
            $fila = $rs->fetch_assoc();
            if($fila)
                $result = true;
        }
        else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;            
        }
        return $result; 
    }
   
    public static function asignaturasAlumno($alumno){
        $asignaturas=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.IdAsignatura FROM EstudianAsignaturas RU WHERE RU.IdAlumno=%d"
            , $alumno->getId()
        );
        $rs = $conn->query($query);
        if ($rs) {
            $asignaturas = $rs->fetch_all(MYSQLI_ASSOC);
            $alumno->idAsignaturas = [];
            $rs->free();
            if($asignaturas){
                foreach($asignaturas as $asignatura) {
                    $alumno->idAsignaturas[] = $asignatura['IdAsignatura'];  
                }
                return $alumno;
            }
            else
                return false;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    
    private $id;
    private $idPadre;
    private $idAsignaturas = [];

    private function __construct($id, $idPadre, $asignaturas){
        $this->id = $id;
        $this->idPadre = $idPadre;
        $this->idAsignaturas = $asignaturas;
    }

    public function tieneAsignaturas(){
        if($this->idAsignaturas == null){
            return false;
        }
        else{
            return true;
        }
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

    //public function setAsignaturas($asignaturas){
        //$this->asignaturasAlumno[] = $asignaturas;
    //}

}
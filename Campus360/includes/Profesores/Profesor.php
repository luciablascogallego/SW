<?php
namespace es\ucm\fdi\aw\profesor;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\MagicProperties;

class Profesor {
    use MagicProperties;

    private static function inserta($profesor)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Profesores(IdProfesor, Despacho, Tutorias) VALUES ('%d', '%d', %s)"
            , $conn->real_escape_string($profesor->getId())
            , $conn->real_escape_string($profesor->getDespacho())
            , $conn->real_escape_string($profesor->getTutorias())
        );
        if ( $conn->query($query) ) {
            $result = $profesor;
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
        $query = sprintf("DELETE FROM Profesores  WHERE IdProfesor = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Profesores WHERE IdProfesor=%d", $idUsuario);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Profesor($fila['IdProfesor'], $fila['Despacho'], $fila['Tutorias']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function listaProfesores(){
        $profesores = [];

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT IdProfesor FROM Profesores"
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
    
    public static function asignaturasProfesor($profesor){
        $asignaturas=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.Id FROM Asignaturas RU WHERE RU.Profesor=%d"
            , $profesor->getId()
        );
        $rs = $conn->query($query);
        if ($rs) {
            $asignaturas = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $profesor->setAsignaturas($asignaturas);
            return $profesor;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    
    private $id;
    private $despacho;
    private $tutorias;
    private $idAsignaturas = [];

    private function __construct($id, $despacho, $tutorias){
        $this->id = $id;
        $this->despacho = $despacho;
        $this->tutorias = $tutorias;
        self::asignaturasProfesor($this);
    }

    public function getId(){
        return $this->id;
    }

    public function getDespacho(){
        return $this->despacho;
    }

    public function getTutorias(){
        return $this->tutorias;
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
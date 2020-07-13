<?php
require_once "persona.php";

class Empleado extends Persona
{
    protected  $_legajo;
    protected  $_sueldo;
    protected  $_turno;
    protected  $_pathFoto;

    public function __construct( $nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno)
    {
        parent::__construct($nombre,$apellido,$dni,$sexo);
        
        $this->_legajo=$legajo;
        $this->_sueldo=$sueldo;
        $this->_turno=$turno;
    }    

    public function GetLegajo()
    {
        return $this->_legajo;
    }

    public function GetSueldo()
    {
        return $this->_sueldo;
    }

    public function GetTurno()
    {
        return $this->_turno;
    }

    public function GetPathFoto()
    {
        return $this->_pathFoto;
    }
    
    public function SetPathFoto($foto)
    {
        $this->_pathFoto=$foto;
    }

    public function Hablar($idioma)
    {
        return "El empleado habla " . $idioma;
    }

    public function ToString()
    {
        return parent::ToString() . " - " . $this->GetLegajo() . " - " . $this->GetSueldo() . " - " . $this->GetTurno() ." - " . $this->GetPathFoto();
    }

    public function ToJson()
    {
        $unEmpleado= parent::ToJson();
        $unEmpleado->legajo=$this->GetLegajo();
        $unEmpleado->sueldo=$this->GetSueldo();
        $unEmpleado->turno=$this->GetTurno();
        $unEmpleado->pathFoto=$this->GetPathFoto();

        return $unEmpleado;
    }
    





}



?>
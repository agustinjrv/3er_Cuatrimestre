<?php

namespace TP_1;


class Empleado extends Persona
{

    protected $_legajo;
    protected $_sueldo;
    protected $_turno;

    public function __construct($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno)
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

    public function Hablar($idioma)
    {
        $cadena=parent::Hablar($idioma);

        return "El empleado habla " . $cadena;
    }

    public function ToString()
    {
        return parent::ToString() . " - " . $this->_legajo . " - " . $this->_sueldo . " - " . $_turno;

    }


}




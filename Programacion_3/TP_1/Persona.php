<?php 
namespace TP_1;


abstract class Persona
{


    private $_apellido;
    private $_dni;
    private $_nombre;
    private $_sexo;

    public function __construct($nombre,$apellido,$dni,$sexo)
    {
        $this->_nombre=$nombre;
        $this->_apellido=$apellido;
        $this->_dni=$dni;
        $this->_sexo=$sexo;
    }

    public function GetApellido()
    {
        return $this->_apellido;
    }

    public function GetDni()
    {
        return $this->_dni;
    }

    public function GetNombre()
    {
        return $this->_nombre;
    }

    public function GetSexo()
    {
        return $this->_sexo;
    }

    public abstract function Hablar($idioma)
    {
        return $idioma;
    }

    public function ToString()
    {
        return $this->_apellido ." - " .$this->nombre ." - ". $this->_dni . " - " . $this->sexo;
    }

}
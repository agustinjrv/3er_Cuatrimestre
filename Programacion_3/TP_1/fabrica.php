<?php

class Fabrica
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    public function __construct($razonSosial)
    {
        $this->_razonSocial=$razonSosial;
        $this->_empleados=array();
        $this->_cantidadMaxima=5;
    }

    public function AgregarEmpleado($emp)
    {
         $retorno=false;

         if(gettype($emp)=="Empleado") 
         {
            if($this->_empleados->count()<=$_cantidadMaxima)
            {
                array_push($this->_empleados,$emp);
                $retorno=true;
            }
         }
         

        return $retorno;
    }

    public function CalcularSueldos()
    {
        $tam=$this->_empleados->count();
        $acumulador=0;
        for($i=0;$i<$tam;$i++)
        {
            $acumulador+=$this->_empleados[$i]->_sueldo;
        }

        return $acumulador;
    }

    public function EliminarEmpleado($emp)
    {
        

        return true;
    }

    private function EliminarEmpleadoRepetido()
    {

    }

    public function ToString()
    {

    }







}







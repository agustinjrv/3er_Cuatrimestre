<?php

require_once "./empleado.php";

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

         if(is_a($emp,"Empleado")) 
         {
            if(count($this->_empleados)<=$this->_cantidadMaxima)
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
        $retorno=false;
        
        foreach($this->_empleados as $key =>$i)
        {
            if($i==$emp)
            {
                unset($this->_empleados[$key]);
                $retorno=true;
                break;
            }
        }

        return $retorno;
    }

    private function EliminarEmpleadoRepetido()
    {
        $this->_empleados=array_unique($this->_empleados);
    }

    public function ToString()
    {
        $cadena="";
        $cadena.= "CANTIDAD MAXIMA: " . $this->_cantidadMaxima;
        $cadena.= "<br/> RAZON SOCIAL: " . $this->_razonSocial;
        $cadena.= "<br/>LISTA DE EMPLEADOS: <br/>";
        
        foreach ($this->_empleados as $i) 
        {
            $cadena.="<br/>" . $i->GetLegajo() . " - " . $i->GetApellido() . " - " .$i->GetNombre() . " - " . $i->GetDni() . " - " . $i->GetSexo() . " - " . $i->GetSueldo() . " - "  . $i->GetTurno() ;
        }

        return $cadena;

    }







}







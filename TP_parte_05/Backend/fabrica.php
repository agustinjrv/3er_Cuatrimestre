<?php

require_once "./empleado.php";
require_once "./interfaces.php";

class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;
   

    public function __construct($razonSosial,$_cantidadMaxima=5)
    {
        $this->_razonSocial=$razonSosial;
        $this->_empleados=array();
        $this->_cantidadMaxima=$_cantidadMaxima;
       
    }

    public function GetEmpleados()
    {
        return $this->_empleados;
    }

    public function AgregarEmpleado(Empleado $emp):bool
    {
         $retorno=false;

         if(is_a($emp,"Empleado")) 
         {
            if(count($this->_empleados)<$this->_cantidadMaxima)
            {
                array_push($this->_empleados,$emp);
                $retorno=true;
                $this->EliminarEmpleadoRepetido();
            }
         }
         
         

        return $retorno;
    }

    public function CalcularSueldos():double
    {
        $tam=$this->_empleados->count();
        $acumulador=0;
        for($i=0;$i<$tam;$i++)
        {
            $acumulador+=$this->_empleados[$i]->_sueldo;
        }

        return $acumulador;
    }

    public function EliminarEmpleado(Empleado $emp):bool
    {
        $retorno=false;
        
        foreach($this->_empleados as $key =>$i)
        {
            if($i==$emp)
            {
                unlink(trim($i->GetPathFoto()));
                unset($this->_empleados[$key]);
                $retorno=true;
                break;
            }
        }

        return $retorno;
    }

    private function EliminarEmpleadoRepetido():void
    {
        $this->_empleados=array_unique($this->_empleados,SORT_REGULAR);
    }

    public function ToString():string
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


    function GuardarEnArchivo(string $nombreArchivo):void
    {
        $archivo = fopen($nombreArchivo,"w");
        if($archivo)
        {
            foreach($this->_empleados as $unEmpleado)
            {
                fwrite($archivo,$unEmpleado->ToString()."\r\n");
            }
            fclose($archivo);
        }
    }

    function TraerDeArchivo(string $nombreArchivo):void 
    {
        $archivo=fopen($nombreArchivo,"r");
        $cadena="";
        $datos=array();
        $nuevoEmpleado;

        if($archivo)
        {
            while(!feof($archivo))
            {
                $cadena=fgets($archivo);
                $datos=explode(' - ',$cadena);

                if(count($datos)>1)
                {
                    $nuevoEmpleado=new Empleado($datos[1],$datos[0],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6]);
                    $nuevoEmpleado->SetPathFoto($datos[7]);
                    $this->AgregarEmpleado($nuevoEmpleado);
                }
            }
            fclose($archivo);
        }
    }

}







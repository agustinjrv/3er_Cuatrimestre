<?php

require_once "empleado.php";
require_once "interfaces.php";
require_once "AccesoDatos.php";
require_once "islimeable.php";

class Fabrica implements IArchivo,ISlimeable
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
        if(is_file($nombreArchivo))
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

    //BASE DE DATOS

    public function TraerDatosBD()
    {
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT * FROM empleados");
        $consulta->execute();
       // $this->AgregarEmpleado(new Empleado())
       //$obj=$consulta->fetch(PDO::FETCH_LAZY);
       //var_dump($obj);
        while($obj=$consulta->fetch(PDO::FETCH_LAZY))
        {
            $unEmpleado=new Empleado($obj->Nombre,$obj->Apellido,$obj->Dni,$obj->Sexo,$obj->Legajo,$obj->Sueldo,$obj->Turno);
            $unEmpleado->SetPathFoto($obj->PathFoto . " ");
            $this->AgregarEmpleado($unEmpleado);
           
        }
    }

    public static function InsertarEnBD($unEmpleado)
    {
       
        $bd=AccesoDatos::DameUnObjetoAcceso();


        $consulta=$bd->RetornarConsulta("INSERT INTO empleados ( `Apellido`, `Nombre`, `Dni`, `Sexo`, `Legajo`, `Sueldo`, `Turno`, `PathFoto`) 
        VALUES(:apellido, :nombre, :dni, :sexo, :legajo, :sueldo, :turno, :pathFoto)");

        $consulta->bindValue(':apellido',$unEmpleado->GetApellido());
        $consulta->bindValue(':nombre',$unEmpleado->GetNombre());
        $consulta->bindValue(':dni',$unEmpleado->GetDni());
        $consulta->bindValue(':sexo',$unEmpleado->GetSexo());
        $consulta->bindValue(':legajo',$unEmpleado->GetLegajo());
        $consulta->bindValue(':sueldo',$unEmpleado->GetSueldo());
        $consulta->bindValue(':turno',$unEmpleado->GetTurno());
        $consulta->bindValue(':pathFoto',$unEmpleado->GetPathFoto());
               
       
       return $consulta->execute();
    }

    public static function EliminarDeBD($legajo)
    {
        $bd=AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("DELETE FROM empleados WHERE Legajo = :legajo");
        $consulta->bindValue(':legajo', $legajo);
        return $consulta->execute();
    }

    public static function ModificarBD($unEmpleado)
    {
        try {
            $user="root";
            $pass="";

            $obj=new PDO("mysql:host=localhost;dbname=bd_empleados;charset=utf8",$user,$pass);
            $obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        
        $consulta = $obj->prepare("UPDATE empleados SET `Apellido` = :apellido , `Nombre` = :nombre 
        , `Sexo` = :sexo ,`Legajo`=:legajo , `Sueldo`=:sueldo ,`Turno`=:turno WHERE `Dni` = :dni ");

        $consulta->bindValue(':dni',$unEmpleado->GetDni());
        $consulta->bindValue(':apellido',$unEmpleado->GetApellido());
        $consulta->bindValue(':nombre',$unEmpleado->GetNombre());
        $consulta->bindValue(':sexo',$unEmpleado->GetSexo());
        $consulta->bindValue(':legajo',$unEmpleado->GetLegajo());
        $consulta->bindValue(':sueldo',$unEmpleado->GetSueldo());    
        $consulta->bindValue(':turno',$unEmpleado->GetTurno());
     

        return $consulta->execute();

    }

    public function ToJson()
    {
        $listaEmpleados=$this->GetEmpleados();
        $listaJson=array();
        foreach ($listaEmpleados as $key => $e) {
            array_push($listaJson, $e->ToJson());
        }

        return $listaJson;

    }

    public static function TraerUnEmpleado($id)
    {
        $unaFabrica = new Fabrica("ddd",1000);

        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT * FROM empleados where id = $id");
        $consulta->execute();
        $obj=$consulta->fetch(PDO::FETCH_LAZY);
        $unEmpleado=new Empleado($obj->Nombre,$obj->Apellido,$obj->Dni,$obj->Sexo,$obj->Legajo,$obj->Sueldo,$obj->Turno);
        $unEmpleado->SetPathFoto($obj->PathFoto . " ");

        return $unEmpleado;
    }

    public static function  TraerTodos($request, $response, $args)
    {
        $unaFabrica = new Fabrica("asd",1000);
        $unaFabrica->TraerDatosBD();
        return $response->withJson($unaFabrica->ToJson(),200);
    }

    public static function TraerUno($request, $response, $args)
    {
       $unEmpleado=Fabrica::TraerUnEmpleado($args);
        return $response->withJson($unEmpleado->ToJson(),200);
    }

    public static function AgregarUno($request, $response, $args)
    {

        $retorno = new stdClass();
        $retorno->sePudo=false;
        $retorno->estado=404;
        $array=$request->getParsedBody();      
        $aux=json_decode($array["cadenaJson"]);
      
        
       

        $archivos = $request->getUploadedFiles();
        $destino = "./fotos/";
        $nombreAnterior = $archivos['foto']->getClientFilename();
        $extension = explode(".", $nombreAnterior);
        $extension = array_reverse($extension);
        $nuevoNombre=$aux->nombre ."." . date("Gis").  "." . $extension[0];
		$archivos['foto']->moveTo($destino . $nuevoNombre);
		
        //$response->getBody()->write("cd agregado!");
        
        $unEmpleado= new Empleado($aux->nombre,$aux->apellido,$aux->dni,$aux->sexo,$aux->legajo,$aux->sueldo,$aux->turno);
        $unEmpleado->SetPathFoto($nuevoNombre);

        if(Fabrica::InsertarEnBD($unEmpleado))
        {   
            $retorno->sePudo=true;
            $retorno->estado=200;
        }

        return $response->withJson($retorno->sePudo,$retorno->estado);

    }

    public static function ModificarUno($request, $response, $args)
    {
        $retorno = new stdClass();
        $retorno->sePudo=false;
        $retorno->estado=404;
        $json=json_decode($args);

        if(Fabrica::ModificarBD($json))
        {
            $retorno->sePudo=true;
            $retorno->estado=200;
        }

        return $response->withJson($retorno->sePudo,$retorno->estado);
    }

    public static function BorrarUno($request, $response, $args)
    {
        
        $retorno = new stdClass();
        $retorno->sePudo=false;
        $retorno->estado=404;

        if(Fabrica::EliminarDeBD($args))
        {
            $retorno->sePudo=true;
            $retorno->estado=200;
        }

        return $response->withJson($retorno->sePudo,$retorno->estado);
    }

}







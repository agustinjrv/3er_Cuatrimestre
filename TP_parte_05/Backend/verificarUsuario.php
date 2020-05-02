<?php

$path="./archivos/empleados.txt";
$archivo=fopen($path,"r");
$cadena="";
$datos=array();
$encontro=false;

if($archivo)
{
    while(!feof($archivo))
    {        
        $cadena=fgets($archivo);
        $datos=explode(' - ',$cadena);

       
        if(count($datos)>2)
        {
            $dni=$datos[2];
            $apellido=$datos[0];
            if($_POST["txtDni"]==$dni && $_POST["txtApellido"]==$apellido)
            {
                $encontro=true;
                session_start();
                $_SESSION["DNIEmpleado"]=$dni;
                break;
            }    
            
        }
       
    }    
}


if($encontro)
{
    header("LOCATION: ./Mostrar.php");
}
else
{
    echo "Error,Empleado no encontrado" . "<br/>". "<br/>".'<a href="..\Frontend\login.html">Ir a login</a>';
}
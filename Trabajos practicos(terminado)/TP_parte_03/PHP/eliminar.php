<?php
require "./empleado.php";
require "./fabrica.php";

$path="./archivos/empleados.txt";
$archivo=fopen($path,"r");
$cadena="";
$datos=array();
$encontro=true;

if($archivo)
{
    while(!feof($archivo))
    {        
        $cadena=fgets($archivo);
        $datos=explode(' - ',$cadena);
        if(count($datos)>2)
        {
            if(strcmp($datos[4],$_GET["legajo"])==0)
            {
                $encontro=true;
                break;
            }
        }
       
    }  
    fclose($archivo);

    if($encontro)
    {
        $unEmpleado=new Empleado($datos[1],$datos[0],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6]);
        $unaFabrica=new Fabrica("Alfajores",7);
        $unaFabrica->TraerDeArchivo($path);
        if($unaFabrica->EliminarEmpleado($unEmpleado))
        {
            $unaFabrica->GuardarEnArchivo($path);
            echo "El empleado se a logrado eliminar";

        }
        else
        {
            echo "No se pudo eliminar el empleado";
        }
    }
    else
    {
        
        echo "No se a encontrado al empleado";
    }
}

echo '<br/><a href=".\mostrar.php">Lista</a> ' . '<br/><a href="..\Inicio\index.html">Altas</a>';;



?>
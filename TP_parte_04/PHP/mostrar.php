<?php
require "./Empleado.php";


$path="./archivos/empleados.txt";
$archivo=fopen($path,"r");
$cadena="";
$listaEmpleados=array();
$datos=array();
$nuevoEmpleado;

if($archivo)
{
    while(!feof($archivo))
    {        
        $cadena=fgets($archivo);
        $datos=explode(' - ',$cadena);

        if(count($datos)>2)
        {
            $nuevoEmpleado=new Empleado($datos[1],$datos[0],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6]);
            array_push($listaEmpleados,$nuevoEmpleado);
        }
       
    }    
}

foreach($listaEmpleados as $unEmpleado)
{
    echo $unEmpleado->ToString() . '<a href="./eliminar.php?legajo=' . $unEmpleado->GetLegajo(). ' ">Eliminar</a>' . "<br>";
}

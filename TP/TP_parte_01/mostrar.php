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

      
        if($datos[0]!='')
        {
            $nuevoEmpleado=new Empleado($datos[1],$datos[0],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6]);
            array_push($listaEmpleados,$nuevoEmpleado);
            echo $cadena.="<br/>";
        }
       
    }
    
    
}

echo "<br/>"."<br/>". "Muestro empleados por ToString<br/><br/>";
foreach($listaEmpleados as $unEmpleado)
{
    echo $unEmpleado->ToString() . "<br/>";
}

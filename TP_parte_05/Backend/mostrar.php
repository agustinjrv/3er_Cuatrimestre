<?php
require "./validarSesion.php";
require "./empleado.php";



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

echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Empleados</title>
    </head>
    <body>
    <h2>Listado de Empleados</h2>
        
    <table alingn="center">

    <tr>
        <td>Info</td>
    </tr>

    <tr>
        <td><hr></td>
    </tr>';

    foreach($listaEmpleados as $unEmpleado)
    {
        echo "<tr>".
                "<td>".
                     $unEmpleado->ToString() .
               "</td>".
                
              "<td>".
                 '<a href="./eliminar.php?legajo=' . $unEmpleado->GetLegajo(). ' ">Eliminar</a>' . 
              "</td>".
             "</tr>";
    }
   echo '

   <tr>
        <td><hr></td>    
    </tr> 

    </table>


     <a href="./cerrarSesion.php">Cerrar sesion</a>

    </body>
    </html>';

    

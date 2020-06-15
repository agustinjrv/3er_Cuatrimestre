<?php

require "./clases/televisor.php";

$_POST["accion"]="borrar";

if(isset($_GET["tipo"]))
{
    $unTelevisor=new Televisor($_GET["tipo"],$_GET["precio"],$_GET["paisOrigen"],$_GET["path"]);
    $listaTelevisores=Televisor::Traer();
    
    if($unTelevisor->Verificar($listaTelevisores))
    {
        echo "El televisor no se encuentra en la base de datos";
    }
    else
    {
        echo "El televisor se encuentra en la base de datos";

    }

    if(isset($_POST["accion"]))
    {
        if($_POST["accion"]=="borrar")
        {
           if($unTelevisor->Eliminar()) 
           {
               $unTelevisor->GuardarEnArchivo();
               header("LOCATION: ./listado.php");
           }
           else
           {
               echo "No se a podido eliminiar al Televisor";
           }

        }
    }
}
else if(isset($_GET))
{
    $listaTelevisoresBorrados=TraerDeArchivo();
         

echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Televisores borrados</title>
    </head>
    <body>
    <h2>Listado de Televisores Borrados</h2>
       
    <table alingn="center">

    <tr>
        <td>Info</td>
    </tr>

    <tr>
        <td><hr></td>
    </tr>';

    foreach($listaTelevisoresBorrados as $unTelevisor)
    {
        echo "<tr>".
                "<td>".
                     $unTelevisor->ToString() .
               "</td>".

               "<td>".
                   " IVA: " .$unTelevisor->CalcularIVA().
            "</td>".
               "<td>".
               '    <img src= '.$unTelevisor->path. ' width="90" height="90">'.
                "</td>".

             "</tr>";
    }
   echo '

   <tr>
        <td><hr></td>    
    </tr> 

    </table>
    </body>
    </html>';

}


function TraerDeArchivo()
{
    $listaTelevisoresBorrados=array();
    $nombreArchivo="./archivos/televisores_borrados.txt";

    if(is_file($nombreArchivo))
    {
        $archivo=fopen($nombreArchivo,"r");
        $cadena="";
        $datos=array();
        $unTelevisor;

        if($archivo)
        {
            while(!feof($archivo))
            {
                $cadena=fgets($archivo);
                $datos=explode(' - ',$cadena);

                if(count($datos)>1)
                {
                    $unTelevisor=new Televisor($datos[0],$datos[1],$datos[2],$datos[3]);
                    array_push($listaTelevisoresBorrados,$unTelevisor);
                }
            }
            fclose($archivo);
        }
    }

    return $listaTelevisoresBorrados;
}



?>
<?php
require "./clases/televisores.php";

$tipo=$_POST["tipo"];
$paisOrigen=$_POST["paisOrigen"];
$lista=array();
$listaTelevisores=Televisor::Traer();

if(is_set($tipo) && is_set($paisOrigen))
{
    foreach ($listaTelevisores as $key => $t) {
        
        if($tipo==$t->tipo && $paisOrigen==$t->paisOrigen)
        {
            $lista=$t;
        }
    }
}
else if($tipo)
{
 
    foreach ($listaTelevisores as $key => $t) {
        
        if($tipo==$t->tipo)
        {
            $lista=$t;
        }
    }
}
else if($paisOrigen)
{
    foreach ($listaTelevisores as $key => $t) {
        
        if($paisOrigen==$t->paisOrigen)
        {
            $lista=$t;
        }
    }
}



echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Televisores filtrados</title>
              
    </head>
    <body>
    <h2>Listado de Televisores filtrados</h2>
       
    <table alingn="center">

    <tr>
        <td>Info</td>
    </tr>

    <tr>
        <td><hr></td>
    </tr>';

    foreach($lista as $unTelevisor)
    {
        echo "<tr>".
                "<td>".
                     $unTelevisor->ToString() .
               "</td>".

                "<td>".
                    '<img src='.$unTelevisor->path. 'width="90" height="90">'.
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




















?>
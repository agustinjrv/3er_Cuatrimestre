<?php
require "./clases/televisor.php";

$listaCompleta =Televisor::Traer();
$listaTelevisores=array();

if(isset($_POST["tipo"]) && isset($_POST["paisOrigen"]))
{
    foreach ($listaCompleta as $key => $t) {
        
        if($t->tipo==$_POST["tipo"] && $t->paisOrigen==$_POST["paisOrigen"])
        {
            array_push($listaTelevisores,$t);
        }

    }
}
else if(isset($_POST["tipo"]))
{
    foreach ($listaCompleta as $key => $t) {
        
        if($t->tipo==$_POST["tipo"])
        {
            array_push($listaTelevisores,$t);
        }

    }
}
else if(isset($_POST["paisOrigen"]))
{
    foreach ($listaCompleta as $key => $t) {
        
        if($t->paisOrigen==$_POST["paisOrigen"])
        {
            array_push($listaTelevisores,$t);
        }

    }
}



echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Televisores</title>      
    </head>
    <body>
    <h2>Listado de Televisores</h2>
       
    <table alingn="center">

    <tr>
        <td>Info</td>
    </tr>

    <tr>
        <td><hr></td>
    </tr>';

    foreach($listaTelevisores as $unTelevisor)
    {
        echo "<tr>".
                "<td>".
                     $unTelevisor->ToString() .
               "</td>".

                "<td>".
                      " IVA: " .$unTelevisor->CalcularIVA().
                "</td>".
                "<td>".
                    '<img src= '.$unTelevisor->path. ' width="90" height="90">'.
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
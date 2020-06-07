<?php
require "./clases/televisores.php";

$lista=Televisor::MostrarBorrados();


echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Televisores Borrados</title>
              
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
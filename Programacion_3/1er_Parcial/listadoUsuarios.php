<?php
require "clases/Usuario.php";

$path="./archivos/usuarios.txt";
$listaUsuarios=array();
$listaUsuarios=Usuario::TraerTodos();

echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Usuarios</title>
    </head>
    <body>
    <h2>Listado de Usuarios</h2>
       
    <table alingn="center">

    <tr>
        <td>Info</td>
    </tr>

    <tr>
        <td><hr></td>
    </tr>';

    foreach($listaUsuarios as $unUsuario)
    {
        echo "<tr>".
                "<td>".
                     $unUsuario->ToString() .
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

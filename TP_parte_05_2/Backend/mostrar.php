<?php
require "./validarSesion.php";
require "./empleado.php";
require "./fabrica.php";

$path="./archivos/empleados.txt";
$listaEmpleados=array();
$unaFabrica = new Fabrica("Alfajores",7);
//$unaFabrica->TraerDeArchivo($path);
$unaFabrica->TraerDatosBD();
$listaEmpleados=$unaFabrica->GetEmpleados();

echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Empleados</title>
        <script src="../Frontend/javaScript/funciones.js"></script>        
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
                    '<img src='.$unEmpleado->GetPathFoto(). 'width="90" height="90">'.
                "</td>".
              "<td>".
                 '<a href="./eliminar.php?legajo=' . $unEmpleado->GetLegajo(). ' ">Eliminar</a>' . 
              "</td>".
              "<td>".
                  '<input type="button" value="Modificar" id="btnModificar" name="btnModificar" onclick= AdministrarModificar('.$unEmpleado->GetDni().")>".
              "</td>".
             "</tr>";
    }
   echo '

   <tr>
        <td><hr></td>    
    </tr> 

    </table>

     <a href="./cerrarSesion.php">Cerrar sesion</a>

     <form id="formDni" method="post" action="../index.php">
            <input type="hidden" name="dni" id="hiddenDni">
        </form>


    </body>
    </html>';

?>

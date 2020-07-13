<?php
require "./empleado.php";
require "./fabrica.php";


$unaFabrica=new Fabrica("alfajores",7);
if($unaFabrica->EliminarDeBD($_GET["legajo"]))
{
    echo "El empleado se a eliminado exitosamente<br/>";
}
else
{
    echo "error no se a podido eliminar al empleado<br/>";
}




echo '<br/><a href="./mostrar.php">Lista</a> ' . '<br/><a href="../index.php">Altas</a>';
?>
<?php
require "./empleado.php";
require_once "./fabrica.php";

//var_dump($_POST);
$path="./archivos/empleados.txt";
$nuevoEmpleado = new Empleado($_POST["txtNombre"],$_POST["txtApellido"],$_POST["txtDni"],$_POST["cboSexo"],$_POST["txtLegajo"],$_POST["txtSueldo"],$_POST["radTurno"]);
$unaFabrica=new Fabrica("Alfajores",7);
//$archivo = fopen($path,"a");

$unaFabrica->TraerDeArchivo($path);
if($unaFabrica->AgregarEmpleado($nuevoEmpleado))
{
    $unaFabrica->GuardarEnArchivo($path);
    echo "Empleado agregado correctamente<br/>";
    echo '<a href="./mostrar.php">Mostrar</a>';
}
else
{
    echo "No se a podido agregar al empleado,fabrica llena";
    echo '<a href="../Inicio/index.html"><br/>Volver</a>';
}

?>
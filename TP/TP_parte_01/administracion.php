<?php
require "./empleado.php";

var_dump($_POST);
$path="./archivos/empleados.txt";
$archivo = fopen($path,"a");
if($archivo)
{
    $nombre=$_POST["txtNombre"];
    $apellido=$_POST["txtApellido"];
    $dni=$_POST["txtDni"];
    $sexo=$_POST["cboSexo"];
    $legajo=$_POST["txtLegajo"];
    $sueldo=$_POST["txtSueldo"];
    $turno=$_POST["radTurno"];
    

    $nuevoEmpleado = new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);
    if(fwrite($archivo,$nuevoEmpleado->ToString()."\r\n"))
    {
        echo "Datos escritos correctamente<br/>";
        echo '<a href="./mostrar.php">Mostrar</a>';
    }
    else
    {
        echo "No se puedo escribir en el archivo<br/>";
        echo '<a href="../TP_parte_02/index.html">Volver</a>';
    }
    
    fclose($archivo);
}
else
{
    echo "El archivo no se a podido abrir<br/>";
    echo '<a href="../TP_parte_02/index.html">Volver</a>';
}

    


?>
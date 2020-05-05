<?php
require "./empleado.php";
require_once "./fabrica.php";

$path="./archivos/empleados.txt";
$unaFabrica=new Fabrica("Alfajores",7);
$unaFabrica->TraerDeArchivo($path);



if(strlen($_POST["hdnModificar"])>3)
{
    foreach($unaFabrica->GetEmpleados() as $e)
    {
        if(strcmp($e->GetDni(),$_POST["hdnModificar"])==0)
        {
           $unaFabrica->EliminarEmpleado($e);
            break;
        }
    }
}


$destino="./fotos/".$_FILES["Archivo"]["name"];
$tipoArchivo=pathinfo($destino,PATHINFO_EXTENSION);

if(getimagesize($_FILES["Archivo"]["tmp_name"]))
{
    if($tipoArchivo == "jpg" || $tipoArchivo == "bmp" || $tipoArchivo == "gif" || $tipoArchivo == "png" || $tipoArchivo == "jpeg")
    {
        if($_FILES["Archivo"]["size"]<=1000000 && !(file_exists($destino)))
        {
            $nuevoEmpleado = new Empleado($_POST["txtNombre"],$_POST["txtApellido"],$_POST["txtDni"],$_POST["cboSexo"],$_POST["txtLegajo"],$_POST["txtSueldo"],$_POST["radTurno"]);
            $_FILES["Archivo"]["name"]=$_POST["txtDni"] . "-" . $_POST["txtApellido"] . ".".$tipoArchivo;
            $destino="./fotos/".$_FILES["Archivo"]["name"];
            move_uploaded_file($_FILES["Archivo"]["tmp_name"], $destino);
            $nuevoEmpleado->SetPathFoto($destino);
        }
    }
}





if($unaFabrica->AgregarEmpleado($nuevoEmpleado))
{
    $unaFabrica->GuardarEnArchivo($path);
    echo "Empleado agregado correctamente<br/>";
    echo '<a href="./mostrar.php">Mostrar</a>';
}
else
{
    echo "No se a podido agregar al empleado,fabrica llena";
    echo '<a href="../Frontend/index.html"><br/>Volver</a>';
}

?>
<?php
require "./clases/televisor.php";

$destino="./archivos/televisores/imagenes/";
$tipoArchivo=pathinfo($_FILES["Archivo"]["name"],PATHINFO_EXTENSION);
$destino.=$_POST["tipo"] . "." . $_POST["paisOrigen"] . "." . date("Y-m-d-H:i:s") . "." .$tipoArchivo;

$nuevoTelevisor = new Televisor($_POST["tipo"],$_POST["precio"],$_POST["paisOrigen"],$destino);
move_uploaded_file($_FILES["Archivo"]["tmp_name"], $destino);

if($nuevoTelevisor->Agregar())
{
    header("LOCATION: ./listado.php");
}
else
{
    echo "No se a podido agragar a la base de datos";
}






?>
<?php
require "./clases/televisor.php";

$destino="./televisores/imagenes/".$_FILES["Archivo"]["name"];
$tipoArchivo=pathinfo($destino,PATHINFO_EXTENSION);

$destino="./televisores/imagenes/".$_POST["tipo"] . "." . $_POST["paisOrigen"] .".".date("His") .".".$tipoArchivo;
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
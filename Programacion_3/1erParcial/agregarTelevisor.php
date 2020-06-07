<?php
require "./clases/televisor.php";

$destino="./imagenes/";
$tipoArchivo=pathinfo($_FILES["Archivo"]["name"],PATHINFO_EXTENSION);
$destino.=$_POST["tipo"] . "." . $_POST["paisOrigen"] . "." . date("His") . "." .$tipoArchivo;
//$destino.="hola" .".". $tipoArchivo;
$nuevoTelevisor = new Televisor($_POST["tipo"],$_POST["precio"],$_POST["paisOrigen"],$destino);
echo $destino;
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
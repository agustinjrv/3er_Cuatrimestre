<?php

require "./clases/televisor.php";

$destino="./archivos/televisores/imagenes/";
$tipoArchivo=pathinfo($_FILES["Archivo"]["name"],PATHINFO_EXTENSION);
$destino.=$_POST["tipo"] . "." . $_POST["paisOrigen"] . "."."modificado" .".". date("Y-m-d-H:i:s") . "." .$tipoArchivo;

$unTelevisor = new Televisor("LCD",30000,"Argentina",$_POST["unPath"]);
$televisorModificado= new Televisor($_POST["tipo"],$_POST["precio"],$_POST["paisOrigen"],$destino);

move_uploaded_file($_FILES["Archivo"]["tmp_name"], $destino);

if($unTelevisor->Modificar($televisorModificado))
{
    header("LOCATION: ./listado.php");
}
else
{
    echo "No se a podido modificar la base de datos";
}

?>
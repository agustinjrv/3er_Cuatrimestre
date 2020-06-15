<?php
require "./clases/televisor.php";

$destino="./televisoresModificados/".$_FILES["Archivo"]["name"];
$tipoArchivo=pathinfo($destino,PATHINFO_EXTENSION);

$destino="./televisoresModificados/".$_POST["tipo"] . "." . $_POST["paisOrigen"] .".modificado.".date("His") .".".$tipoArchivo;
$televisorModificador = new Televisor($_POST["tipo"],$_POST["precio"],$_POST["paisOrigen"],$destino);

$unTelevisor=new Televisor("LED",20000,"Argentina");

if($unTelevisor->Modificar($televisorModificador))
{
    move_uploaded_file($_FILES["Archivo"]["tmp_name"], $destino);
    header("LOCATION: ./listado.php");
}
else
{
    echo "No se a podido modificar";

}



?>
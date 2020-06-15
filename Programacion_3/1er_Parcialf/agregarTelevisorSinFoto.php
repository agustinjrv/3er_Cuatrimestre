<?php
require "./clases/televisor.php";

$unTelevisor = new Televisor($_POST["tipo"],$_POST["precio"],$_POST["paisOrigen"]);



if($unTelevisor->Verificar(Televisor::Traer()))
{
    if($unTelevisor->Agregar())
    {
        echo "Televisor agregado correctamente";
    }
    else
    {
        echo "No se a podido agregar el televisor";
    }

}
else
{
    echo "El televisor ya se encuentra en la base de datos";
}







?>
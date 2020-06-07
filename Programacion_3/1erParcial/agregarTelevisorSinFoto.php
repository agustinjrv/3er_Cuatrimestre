<?php
require "./clases/televisores.php";

$unTelevisor=new Televisor($_POST["tipo"],$_POST["precio"],$_POST["paisOrigen"]);
$listaTelevisores=Televisor::Traer();

if($unTelevisor->Verificar($listaTelevisores))
{
    if($unTelevisor->Agregar())
    {
        echo "Televisore agregado";
    }
    else
    {
        echo "Error en la base de datos no se a podido agregar";
    }
    
}
else
{
    echo "El televisor ya existe en la Base de Datos";
}










?>
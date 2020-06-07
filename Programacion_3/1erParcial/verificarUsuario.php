<?php
require "./clases/usuario.php";

$existe= Usuario::VerificarExistencia(new Usuario($_POST["email"],$_POST["clave"]));

if($existe)
{
    
    setcookie($_POST["email"],date("Y-m-d-H:i:s"));
    header("LOCATION: ./listadoUsuarios.php");
}
else
{
    echo "El usuario no existe";
}







?>
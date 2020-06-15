<?php
require "./clases/Usuario.php";

$unUsuario = new Usuario($_POST["email"],$_POST["clave"]);

if(Usuario::VerificarExistencia($unUsuario))
{
    setcookie($_POST["email"],date("Y-m-d-H:i:s"));
    header("LOCATION: ./listadoUsuarios.php");

}
else
{
    echo "No se a encontrado el usuario";
}


?>
<?php
require "./clases/usuario.php";

$unUsuario=new Usuario($_POST["email"],$_POST["clave"]);

echo $unUsuario->GuardarEnArchivo();






?>

<?php
require "clases/Usuario.php";

$unUsuario = new Usuario($_POST["email"],$_POST["clave"]);

echo $unUsuario->GuardarEnArchivo();
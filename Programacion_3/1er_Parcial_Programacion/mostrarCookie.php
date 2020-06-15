<?php

$encontro=false;
$unaCookie;


foreach ($_COOKIE as $key => $value) {
    
    if($_GET["email"]==$key)
    {
        $encontro=true;
        $unaCookie=$value;
        break;
    }
}

if($encontro)
{
    echo "La clave es:" ,$unaCookie;
}
else
{
    echo "No se encontro la cookie";
}





?>
<?php
InvertirPalabra("La ruta nos aporto otro paso natural");

function InvertirPalabra($cadena)
{
    $tam=strlen($cadena);
    $aux=$cadena;

 
  
    for($i=0;$i<$tam;$i++)
    {
        $cadena[$i]=$aux[$tam-$i-1];
    }

    echo $cadena;
    
}


<?php

echo "Preuba de numeros pares<br/>";

if(EsPar(101))
{
    echo "Es un Numero Par<br/>";

}
else
{
    echo "Ese numero no es par<br/>";
}

echo "Prueba de numeros impares<br/>";

if(EsInpar(101))
{
    
    echo "Es un numero Inpar<br/>";
    

}
else
{
    echo "Ese Numero no es Par<br/>";
}





function EsPar($numero)
{
    $retorno=false;
    if($numero%2==0)
    {
        $retorno=true;
    }

    return $retorno;
}

function EsInpar($numero)
{
    return !(EsPar($numero));
}

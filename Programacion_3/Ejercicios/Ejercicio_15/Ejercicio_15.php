<?php

function CalcularPotencia($numero)
{
    echo "Potencia de: ". $numero."<br/>";
    for($i=1;$i<=4;$i++)
    {
        echo pow($numero,$i) . "<br/>";
    }
}


CalcularPotencia(1);
CalcularPotencia(2);
CalcularPotencia(3);
CalcularPotencia(4);
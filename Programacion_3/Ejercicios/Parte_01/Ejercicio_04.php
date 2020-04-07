<?php

$listaNumeros= array();
$contador=0;
do
{
    array_push($listaNumeros,rand(1,100));
    $acumulador=0;

     foreach ($listaNumeros as $i ) 
     {
         $acumulador+=$i;
         
     }
     $contador++;

}while($acumulador<1000);


var_dump($listaNumeros);


?>
<?php

$listaAnimales=array();
$listaAños=array();
$listaLenguajes=array();

array_push($listaAnimales,"Perro", "Gato", "Ratón", "Araña", "Mosca");

array_push($listaAños,"1986", "1996", "2015", "78", "86");

array_push($listaLenguajes,"php", "mysql", "html5", "typescript", "ajax");


$unionArray=array_merge($listaAnimales,$listaAños,$listaLenguajes);

foreach($unionArray as $i)
{
    echo $i . "<br/>";
}






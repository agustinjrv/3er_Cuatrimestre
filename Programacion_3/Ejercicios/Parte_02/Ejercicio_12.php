<?php

$lapicera1=array();
$lapicera2=array();
$lapicera3=array();
$lapicera4=array();

$lapicera1["Color"]="rojo";
$lapicera1["Marca"]="unaMarca";
$lapicera1["Trazo"]="grueso";
$lapicera1["Precio"]=123;

$lapicera2["Color"]="azul";
$lapicera2["Marca"]="bic";
$lapicera2["Trazo"]="fino";
$lapicera2["Precio"]=456;

$lapicera3["Color"]="amarillo";
$lapicera3["Marca"]="otraMarca";
$lapicera3["Trazo"]="grueso";
$lapicera3["Precio"]=789;

$lapicera4["Color"]="negro";
$lapicera4["Marca"]="yoQueSe";
$lapicera4["Trazo"]="fino";
$lapicera4["Precio"]=101;

$listaLapiceras=array($lapicera1,$lapicera2,$lapicera3,$lapicera4);

//var_dump($listaLapiceras);


foreach($listaLapiceras as $unaLapicera)
{
    foreach($unaLapicera as $i)
    {
        echo "<br/>" . $i;
    }
    echo "<br/>";
}



<?php

$listaNumeros=array();
$igualASeis=0;
$menorASeis=0;
$mayorASeis=0;

for($i=0;$i<5;$i++)
{
    array_push($listaNumeros,rand(1,10));
}

foreach ($listaNumeros as $i) 
{
    if($i==6)
    {
        $igualASeis++;
    }
    elseif($i<6)
    {
        $menorASeis++;
    }
    else {
        $mayorASeis++;
    }

}

echo "hay " . $igualASeis . " iguales a 6";
echo "<br>hay " . $menorASeis . " menores a 6";
echo "<br>hay " . $mayorASeis . " mayores a 6";

?>
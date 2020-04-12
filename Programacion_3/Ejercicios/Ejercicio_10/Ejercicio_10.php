<?php

$numerosImpares=array();

for($i=1;$i<20;$i+=2)
{
    array_push($numerosImpares,$i);
}

echo "Muestro con for:<br/>";

for($i=0;$i<10;$i++)
{
    echo "<br/>".$numerosImpares[$i];
}

echo "<br/>Muestro con while:<br/>";
$i=0;
while($i<10)
{
    echo "<br/>".$numerosImpares[$i];
    $i++;
}

echo "<br/>Muestro con foreach:<br/>";

foreach($numerosImpares as $i)
{
    echo "<br/>".$i;
}

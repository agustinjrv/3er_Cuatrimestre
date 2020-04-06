<?php

$a=rand(1,10);
$b=rand(1,10);
$c=rand(1,10);

if($a>$b && $a<$c || $a<$b && $a>$c)
{
    echo "A es: " . $a . " es el numero intermedio";
}
else if($b>$a && $b<$c || $b<$a && $b>$c)
{
    echo "B es: " . $b . " es el numero intermedio";
}
else if($c>$a && $c<$b ||  $c<$a && $c>$b)
{
    echo "C es: " . $c . " es el numero intermedio";
}
else
{
    echo "No hay valor del medio";
}
echo "<br/>";
echo "<br/>A=". $a;
echo "<br/>B=". $b;
echo "<br/>C=". $c;





?>
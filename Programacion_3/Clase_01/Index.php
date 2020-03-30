<?php

echo "hola mundo" ;

$hola = " Soy agustin";
echo "<br>";//salto de linea
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo $hola;

$vec =array(1,2,3);

var_dump($vec);

array_push($vec ,5);
array_push($vec ,6);
array_push($vec ,7);

foreach ($vec as $item ) {
    echo $item . "<br>";
}


$otro = array("hola" => 5,"chau"=>9);


var_dump($otro);

?>
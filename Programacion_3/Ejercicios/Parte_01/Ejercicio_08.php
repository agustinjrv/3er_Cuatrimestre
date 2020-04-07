<?php

echo decenas(60);


function basico($numero) {
$valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
'nueve','diez', 'once','doce','trece','catorce','quince','diesiseis','diesisiete',
'diesiocho','diesinueve','veinte','veintiuno','veintidos','veintitres','veinticuatro','veinticinco',
'veintiséis','veintisiete','veintiocho','veintinueve');
return $valor[$numero - 1];
}

function decenas($n) {
$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
70=>'setenta',80=>'ochenta',90=>'noventa');
if( $n <= 29) return basico($n);
$x = $n % 10;
if ( $x == 0 ) {
return $decenas[$n];
} else return $decenas[$n - $x].' y '. basico($x);
}




?>
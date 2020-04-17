<?php
require_once ".\Empleado.php";


$unEmpleado= new Empleado("Agustin","Rivola","42432112","m",1003,50000,"Mañana");

echo $unEmpleado->Hablar("Español,ingles");

echo "<br/>" . $unEmpleado->ToString();

?>

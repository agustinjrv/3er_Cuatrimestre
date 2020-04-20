<?php
require_once ".\Empleado.php";
require_once ".\\fabrica.php";



$Empleado1= new Empleado("Agustin","Rivola","42432112","m",1003,50000,"Mañana");
$Empleado2= new Empleado("Pepe","Argento","41110000","m",1004,40000,"Tarde");
$Empleado3= new Empleado("Micaela","Vazquez","35343332","f",1005,30000,"Noche");

echo $Empleado1->Hablar("Español,ingles");

echo "<br/>" . $Empleado1->ToString();


//Punto 4

$unaFabrica = new Fabrica("Una razon social");

$unaFabrica->AgregarEmpleado($Empleado1);
$unaFabrica->AgregarEmpleado($Empleado2);
$unaFabrica->AgregarEmpleado($Empleado3);
echo "<br/> <br/>";

echo $unaFabrica->ToString();








?>

<?php
require "./fabrica.php";

$unaFabrica = new Fabrica("Autos",50);
$unaFabrica->TraerDatosBD();


$path="./archivos/empleados.txt";
$archivo=fopen($path,"r");
$cadena="";
$datos=array();
$encontro=false;

foreach ($unaFabrica->GetEmpleados() as $key => $e) 
{
    if($_POST["txtDni"]==$e->GetDni() && (strcasecmp($_POST["txtApellido"],$e->GetApellido())==0))
    {
        $encontro=true;
        session_start();
        $_SESSION["DNIEmpleado"]=$e->GetDni();
        break;
    }               
}

if($encontro)
{
    header("LOCATION: ../Frontend/index.html");
}
else
{
    echo "Error,Empleado no encontrado" . "<br/>". "<br/>".'<a href="../index.php">Ir a login</a>';
}
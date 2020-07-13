<?php
//require "./validarSesion.php";
require "./empleado.php";
require "./fabrica.php";
require_once "AccesoDatos.php";

//sleep(2);

$quehago=$_POST["queHago"];


switch ($quehago) {
    case 'Mostrar':

    $listaEmpleados=array();
    $unaFabrica = new Fabrica("Alfajores",1000);
    $unaFabrica->TraerDatosBD();
    $listaEmpleados=$unaFabrica->ToJson();
    
    
    echo json_encode($listaEmpleados);
            
    break;
    
    case "Agregar":
        
       //recibe cadena Jsoncon datos para agregar
    $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
    //la paso a objeto para poder usarla
    $objJson = json_decode($cadenaJSON);  

    $extension = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);  //extension de la foto
    $destino = $objJson->nombre ."." . date("Gis").  "." . $extension;
    $objJson->pathFoto = $destino;
   

    $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

    $consulta =$objetoDatos->RetornarConsulta("INSERT INTO empleados (Apellido, Nombre, Dni, Sexo, Legajo, Sueldo, Turno , PathFoto)"
                                                            . "VALUES(:Apellido, :Nombre, :Dni, :Sexo, :Legajo, :Sueldo, :Turno,:PathFoto)"); 
                
    $consulta->bindValue(':Apellido', $objJson->apellido);
    $consulta->bindValue(':Nombre', $objJson->nombre);
    $consulta->bindValue(':Dni', $objJson->dni);
    $consulta->bindValue(':Sexo', $objJson->sexo);
    $consulta->bindValue(':Legajo', $objJson->legajo);
    $consulta->bindValue(':Sueldo', $objJson->sueldo);
    $consulta->bindValue(':Turno', $objJson->turno);
    $consulta->bindValue(':PathFoto', $objJson->pathFoto);

    $sePudo=$consulta->execute();

    $objRetorno= new stdClass();

    $objRetorno->ok = false; 
    $objRetorno->pathFoto = $destino;

    $destino = "./fotos/" . $objJson->nombre . "." . date("Gis") . "." . $extension;
    if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino))
    {
        $objRetorno->ok = true;
        $objRetorno->bd=$sePudo;
        $objRetorno->pathFoto = $objJson->nombre . "." . date("Gis") . "." . $extension;  //le devolemos el path nuevo, ya que al haberle cambiado el nombre, hay que actualizar el path
    }
        
    echo json_encode($objRetorno);

            break;
    default:
    $retorno=new stdClass();
    $retorno->mensaje="algo malio sal";
            echo json_encode($retorno);
         break;

 case "Eliminar":

    $exito=Fabrica::EliminarDeBD($_POST["legajo"]);
    echo $exito;
    break;

 case "Modificar":
    $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
    //la paso a objeto para poder usarla
    $objJson = json_decode($cadenaJSON);  
    $unEmpleado= new Empleado($objJson->nombre,$objJson->apellido,$objJson->dni,$objJson->sexo,$objJson->legajo,$objJson->sueldo,$objJson->turno);

    $exito=Fabrica::ModificarBD($unEmpleado);


    echo $exito;
    break;


        
}




?>
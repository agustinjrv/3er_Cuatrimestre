<?php
require "./validarSesion.php";
require "./empleado.php";
require "./fabrica.php";


$quehago=$_POST["queHago"];
var_dump($_POST);
var_dump($_FILES);

switch ($quehago) {
    case 'mostrarGrilla':

    $path="./archivos/empleados.txt";
    $listaEmpleados=array();
    $unaFabrica = new Fabrica("Alfajores",50);
    //$unaFabrica->TraerDeArchivo($path);
    $unaFabrica->TraerDatosBD();
    $listaEmpleados=$unaFabrica->GetEmpleados();

    $retorno ='
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>HTML 5 – Listado de Empleados</title>
            <script src="../Frontend/javaScript/funciones.js"></script>        
        </head>
        <body>
        <h2>Listado de Empleados</h2>
        
        <table alingn="center">

        <tr>
            <td>Info</td>
        </tr>

        <tr>
            <td><hr></td>
        </tr>';

        foreach($listaEmpleados as $unEmpleado)
        {
            $retorno.= "<tr>".
                    "<td>".
                        $unEmpleado->ToString() .
                "</td>".

                    "<td>".
                        '<img src='.' ../Backend/'.$unEmpleado->GetPathFoto(). 'width="90" height="90">'.
                    "</td>".
                "<td>".
                    '<a href="./Backend/eliminar.php?legajo=' . $unEmpleado->GetLegajo(). ' ">Eliminar</a>' . 
                "</td>".
                "<td>".
                    '<input type="button" value="Modificar" id="btnModificar" name="btnModificar" onclick= AdministrarModificar('.$unEmpleado->GetDni().")>".
                "</td>".
                "</tr>";
        }
    $retorno.= '

    <tr>
            <td><hr></td>    
        </tr> 

        </table>

        <a href="./cerrarSesion.php">Cerrar sesion</a>

        <form id="formDni" method="post" action="./index.php">
                <input type="hidden" name="dni" id="hiddenDni">
            </form>
        

        </body>
        </html>';
        sleep(5);
        
        echo $retorno;
            
    break;
    
    case "agregar":
        
        $flagModificar=false;
        $empleado=$_POST["nuevoEmpleado"];
        $retorno["Exito"] = false;        
        $unaFabrica = new Fabrica("autos",50);
        
    if(isset($_POST["hdnModificar"]))
    {
        $flagModificar=true;
    }
    var_dump($_FILES);
    $formData=$_POST["formData"];
    
    $nuevoEmpleado = new Empleado($empleado["nombre"],$empleado["apellido"],$empleado["dni"],$empleado["sexo"],$empleado["legajo"],$empleado["sueldo"],$empleado["turno"]);
    $destino="./fotos/".$empleado["dni"] . "-" . $empleado["apellido"] . ".".$tipoArchivo;

    move_uploaded_file($_FILES["Archivo"]["tmp_name"], $destino);
    $nuevoEmpleado->SetPathFoto($destino);
    
    
    if(!$flagModificar)
    {
        if($unaFabrica->InsertarEnBD($nuevoEmpleado))
        {
            $retorno["exito"] = true;        
            $retorno["mensaje"]= "Empleado agregado correctamente<br/>";
        }
        else
        {
            $retorno["mensaje"]= "No se a podido agragar a la base de datos<br/>";
        }
    }
    else
    {
        if($unaFabrica->ActualizarBD($nuevoEmpleado))
        {
            echo "Datos actualizados!!!";
        }
        else
        {
            echo "Error al actualizar!!!";
        }
    }

echo json_encode($retorno);


            break;
    default:
            echo "algo malio sal";
         break;

        
}




?>
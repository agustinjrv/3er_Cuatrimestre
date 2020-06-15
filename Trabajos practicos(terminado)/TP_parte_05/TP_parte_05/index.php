<?php
require_once "./Backend/fabrica.php";
require_once "./Backend/empleado.php";
$titulo="HTML 5 – Formulario Alta Empleado";
$apellido=null;
$nombre=null;
$dni=null;
$sexo=null;
$legajo=null;
$sueldo=null;
$turno=null;
$btn=" value=Enviar ";
$h2="Alta de Empleado";
$selected="selected=true";
$selectedMasculino="";
$selectedFemenino="";
$checkedMañana="checked";
$checkedTarde="";
$checkedNoche="";

if($_POST)
{
    $unaFabrica = new Fabrica("Alfajores",7);
    $unaFabrica->TraerDeArchivo("./Backend/archivos/empleados.txt");
    $unEmpleado;

    foreach ($unaFabrica->GetEmpleados() as $e)
    {
        if($e->GetDni()==$_POST["dni"])
        {
            $unEmpleado=$e;
            break;
        }
    }
    
    $readonly="readonly";
    $apellido=" value=".$unEmpleado->GetApellido();
    $nombre=" value=".$unEmpleado->GetNombre();
    $dni=" value=". $unEmpleado->GetDni() ." ". $readonly;
    $legajo=" value=". $unEmpleado->GetLegajo() ." ". $readonly;

    $sueldo=" value=". $unEmpleado->GetSueldo();
    $turno=" value=". $unEmpleado->GetTurno();
    $titulo="HTML 5 - Formulario Modificar Empleado";
    $btn=" value=". "Modificar";
    $h2="Modificar Empleado";
    $selected="";

    if(strcasecmp("M",$unEmpleado->GetSexo())==0)
    {
        $selectedMasculino="selected=true";
    }
    else
    {
        $selectedFemenino="selected=true";
    }

    switch ($unEmpleado->GetTurno()) {
        case "Mañana":
            break;
        
        case "Tarde":
            $checkedMañana="";
            $checkedTarde=" checked";
            break;

        case "Noche":
            $checkedMañana="";
            $checkedNoche=" checked";
            break;
    }

}



echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'. $titulo .'</title>
    <script src="./Frontend/javaScript/funciones.js"></script>
</head>
<body>
    
    <h2>'. $h2 .'</h2>

    <form action="./Backend/administracion.php" method="POST" id="formIngreso" enctype="multipart/form-data">

        <table align="center">

            <tr>
                <td colspan="2"><h4>Datos Personales</h4></td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td>DNI:</td>
                <td style="text-align:left;padding-left:15px">
                <input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000" required'. $dni .'>
                <span style="display: none;" id="spanDni">*</span>
                </td>
            </tr>
            
            <tr>
                <td >Apellido:</td>
                <td style="text-align:left;padding-left:15px">
                <input type="text" name="txtApellido" id="txtApellido" required ' . $apellido . '>
                <span style="display: none;" id="spanApellido">*</span>
                </td>
            </tr>

     
            <tr>
                <td>Nombre:</td>
                <td style="text-align:left;padding-left:15px">
                <input type="text" name="txtNombre" id="txtNombre" required ' . $nombre .'>
                <span style="display: none;" id="spanNombre">*</span>
                </td>
            </tr>

            
            <tr>
                <td>Sexo:</td> 
                <td style="text-align:left;padding-left:15px">
                    <select required
                         name="cboSexo" id="cboSexo"> 
                         <option value="---" ' . $selected .' >Seleccione</option>
                         <option value="M" '.$selectedMasculino .' >Masculino</option>
                         <option value="F" '.$selectedFemenino.' >Femenino</option>
                    </select>
                    <span style="display: none;" id="spanSexo">*</span>
                </td>
            </tr>
            
            <tr><tr/>
            <tr><tr/>
            <tr><tr/>

            <tr>
                <td colspan="2"><h4>Datos Laborales</h4></td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>

            <tr>
                <td>Legajo:</td>
                <td style="text-align:left;padding-left:15px">
                    <input type="number" name="txtLegajo" id="txt_legajo" size="5" min="100" max="550" required '. $legajo .'>
                    <span style="display: none;" id="spanLegajo">*</span>
                </td>
            </tr>

            <tr>
                <td>Sueldo:</td>
                <td style="text-align:left;padding-left:15px">
                    <input type="number" name="txtSueldo" id="txt_sueldo" min="8000" step="500" required ' . $sueldo . '>
                    <span style="display: none;" id="spanSueldo">*</span>
                </td>
            </tr>

            <tr>
                <td>Turno:</td>
            </tr>
            <tr>
                <td></td>
                <td><input type="radio" name="radTurno" id="radTurno" ' . $checkedMañana. ' value="Mañana">Mañana</td>
            </tr>
            <tr>
                <td></td>
                <td><input type="radio" name="radTurno" id="radTurno" ' .$checkedTarde.' value="Tarde">Tarde</td>
            </tr>
            <tr>
                <td ></td>
                <td><input type="radio" name="radTurno" id="radTurno" '. $checkedNoche .' value="Noche">Noche</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Foto: <input type="file" name="Archivo" id="inputFile"  accept="image/png, image/jpg,
                    image/jpeg, image/bmp, image/gif" required></td>
                    <span style="display: none;" id="spanFile">*</span>
            </tr>


            <tr>
                <td colspan="2"><hr></td>
            </tr>

            <tr>
                <td></td>
                <td align="right">
                    <input type="reset" value="Limpiar">
                </td>
            </tr>
            
            <tr>
                <td></td>
                <td align="right">
                    <input type="submit" '.$btn .' onclick="AdministrarValidaciones()">
                </td>
            </tr>

        </table>
        <input type="hidden" name="hdnModificar" id="hdnModificar" '. $dni .' >
        
    </form>
</body>
</html ';

?>


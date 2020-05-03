<?php
require "..\Backend\\fabrica.php";

var_dump($_POST);
$unaFabrica = new Fabrica("Alfajores",7);
$unaFabrica->TraerDeArchivo("..\Backend\archivos\\empleados.txt");
$unEmpleado;

foreach ($unaFabrica->GetEmpleados() as $e)
{
    if($e->GetDni()==$_POST["dni"])
    {
        $unEmpleado=$e;
        break;
    }
}






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> HTML 5 – Formulario Alta Empleado</title>
    <script src="javaScript/funciones.js"></script>
</head>
<body>
    
    <h2>Alta de Empleados</h2>

    <form action="../Backend/administracion.php" method="POST" id="formIngreso" enctype="multipart/form-data">

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
                <input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000" required>
                <span style="display: none;" id="spanDni">*</span>
                </td>
            </tr>
            
            <tr>
                <td >Apellido:</td>
                <td style="text-align:left;padding-left:15px">
                <input type="text" name="txtApellido" id="txtApellido" required>
                <span style="display: none;" id="spanApellido">*</span>
                </td>
            </tr>

     
            <tr>
                <td>Nombre:</td>
                <td style="text-align:left;padding-left:15px">
                <input type="text" name="txtNombre" id="txtNombre" required>
                <span style="display: none;" id="spanNombre">*</span>
                </td>
            </tr>

            
            <tr>
                <td>Sexo:</td> 
                <td style="text-align:left;padding-left:15px">
                    <select required
                         name="cboSexo" id="cboSexo"> 
                         <option value="---" selected="true" >Seleccione</option>
                         <option value="M">Masculino</option>
                         <option value="F">Femenino</option>
                    </select>
                    <span style="display: none;" id="spanSexo">*</span>
                </td>
            </tr>

            <tr>
                <td colspan="2"><h4>Datos Laborales</h4></td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>

            <tr>
                <td>Legajo:</td>
                <td style="text-align:left;padding-left:15px">
                    <input type="number" name="txtLegajo" id="txt_legajo" size="5" min="100" max="550" required>
                    <span style="display: none;" id="spanLegajo">*</span>
                </td>
            </tr>

            <tr>
                <td>Sueldo:</td>
                <td style="text-align:left;padding-left:15px">
                    <input type="number" name="txtSueldo" id="txt_sueldo" min="8000" step="500" required>
                    <span style="display: none;" id="spanSueldo">*</span>
                </td>
            </tr>

            <tr>
                <td>Turno:</td>
            </tr>
            <tr>
                <td></td>
                <td><input type="radio" name="radTurno" id="radTurno" checked value="Mañana">Mañana</td>
            </tr>
            <tr>
                <td></td>
                <td><input type="radio" name="radTurno" id="radTurno" value="Tarde">Tarde</td>
            </tr>
            <tr>
                <td ></td>
                <td><input type="radio" name="radTurno" id="radTurno" value="Noche">Noche</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Foto: <input type="file" name="Archivo" id="inputFile"  accept="image/png, image/jpg,
                    image/jpeg, image/bmp, image/gif" required ></td>
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
                    <input type="submit" value="Enviar"  onclick="AdministrarValidaciones()">
                </td>
            </tr>

        </table>

        
    </form>
</body>
</html
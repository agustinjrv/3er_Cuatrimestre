<?php
    require "./clases/televisor.php";
    
    $listaTelevisores=Televisor::Traer();
    var_dump($_GET);
    $_POST["accion"]="borrar";


    $unTelevisor=new Televisor($_GET["tipo"],1588,$_GET["paisOrigen"],"5aa9de8af0f1c.jpeg");
    
    if($unTelevisor->Verificar($listaTelevisores))
    {
        echo "el televisor no se encuentra en la base de datos";
    }
    else
    {
        echo "el televisor se encuentra en la base de datos";

        if($_POST["accion"]=="borrar")
        {
            if($unTelevisor->Eliminar())
            {
                $unTelevisor->GuardarEnArchivo();
                //header("LOCATION: ./listado.php");
                echo "eliminado";
            }
            else
            {
                echo "no se a podido borrar";
            }
            
        }
    }

/* no se hacer la consigna de abajo
Si recibe por GET (sin parámetros), se mostrarán en una tabla (HTML) 
la información de todos los televisores borrados y sus respectivas imagenes
*/  




?>
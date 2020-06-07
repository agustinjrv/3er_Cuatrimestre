<?php
    require "./clases/televisores.php";
    
    $listaTelevisores=Televisor::Traer();
    $unTelevisor=new Televisor($_GET["tipo"],"",$_GET["paisOrigen"],"");
    
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
                header("LOCATION: ./listado.php");
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
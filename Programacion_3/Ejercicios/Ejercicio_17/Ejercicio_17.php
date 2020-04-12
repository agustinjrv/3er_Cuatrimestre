<?php


echo ValidarPalabra("Recuperatori",10);

function ValidarPalabra($palabra,$max)
{
    $retorno=-1;
    //$tam=strlen($palabra);
   if(strlen($palabra)<=$max)
   {
       

        switch ($palabra) {
            case 'Recuperatorio':
                $retorno=1;    
                break;
            case 'Parcial':
                $retorno=1;
                break;
            case 'Programacion':
                $retorno=1;
                break;
            default:
                $retorno=0;
                break;
        }
   }

   return $retorno;

}

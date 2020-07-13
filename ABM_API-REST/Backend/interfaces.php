<?php

interface IArchivo
{
    function GuardarEnArchivo(string $nombreArchivo);
    function TraerDeArchivo(string $nombreArchivo);
}



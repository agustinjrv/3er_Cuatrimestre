<?php 

interface  ISlimeable
{
    static function TraerTodos($request, $response, $args);
    static function TraerUno($request, $response, $args);
    static function AgregarUno($request, $response, $args);
    static function ModificarUno($request, $response, $args);
    static function BorrarUno($request, $response, $args);
}
<?php
namespace Ejercicio_19;

abstract class FiguraGeometrica
{
    protected $_color;
    protected $_perimetro;
    protected $_superficie;

    public function __construct()
    {
     
    }

    protected abstract function CalcularDatos();


    public abstract function Dibujar();

    public function GetColor()
    {
        return $this->_color;
    }

    public function SetColor($color)
    {
        $this->_color=$color;
    }

    public function ToString()
    {

    }






}



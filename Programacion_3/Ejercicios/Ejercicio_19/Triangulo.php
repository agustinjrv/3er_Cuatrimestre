<?php
namespace Ejercicio_19;


class Triangulo extends FiguraGeometrica
{
    private $_altura;
    private $_base;

    public function __construct($b,$h)
    {
        CalcularDatos();


        $this->_altura=$h;
        $this->_base=$b;
    }

    protected function CalcularDatos()
    {
        parent::CalcularDatos();
        $_perimetro;
        $_superficie;
    }

    public function Dibujar()
    {

    }

    public function ToString()
    {

    }
}

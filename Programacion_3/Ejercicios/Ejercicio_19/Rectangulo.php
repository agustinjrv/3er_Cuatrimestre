<?php
namespace Ejercicio_19;

class Rectangulo extends FiguraGeometrica
{
    private $ladoUno;
    private $ladoDos;

    public function __construct($l1,$l2)
    {
        parent::__construct();
        $this->ladoUno=$l1;
        $this->ladoDos=$l2;
        CalcularDatos();
    }

    protected function CalcularDatos()
    {
        $this->_perimetro=($ladoUno +$ladoDos)*2;
        $this->_superficie=$ladoUno;
        
    }

    public function Dibujar()
    {
        $superficie="";
        for($i=0;$i<=$this->ladoUno;$i++)
        {
            $cadena+="*";
        }
        //ladoDos;
        $altura="";
        for($i=0;$i<=$this->ladoDos;$i++)
        {
            $altura+="*";

            for($j=0;$i<$this->ladoUno;$i++)
            {
                $altura=" ";
            }
            $altura+="<br/>";
        }
    }

    public function ToString()
    {
        return "Rectangulo: Lado uno: " . $this->ladoUno . " - " . " Lado dos: " . $this->ladoDos;
    }



}





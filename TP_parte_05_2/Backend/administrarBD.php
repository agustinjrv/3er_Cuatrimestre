<?php

class AdministrarBD
{
    private $obj;

    public function __construct()
    {
        try {
            $user="root";
            $pass="";

            $this->obj=new PDO("mysql:host=localhost;dbname=bd_empleados;charset=utf8",$user,$pass);
            //$this->obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }

    public function RetornarConsulta($cadena)
    {
        return $this->obj->prepare($cadena);
    }

}






?>
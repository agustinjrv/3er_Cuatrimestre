<?php
require "./clases/iParte2.php";
require "./clases/iParte3.php";
require "./clases/iParte4.php";


class Televisor implements IParte2,IParte3,IParte4
{
    public $tipo;
    public $precio;
    public $paisOrigen;
    public $path;

    public function __construct($_tipo="",$_precio="",$_paisOrigen="",$_path="")
    {
        $this->tipo=$_tipo;
        $this->precio=$_precio;
        $this->paisOrigen=$_paisOrigen;
        $this->path=$_path;
    }

    public function ToString()
    {
        return $this->tipo ." - " . $this->precio ." - ". $this->paisOrigen . " - " . $this->path;
    }

    public function Agregar()
    {
        try {
            $user="root";
            $pass="";

            $obj=new PDO("mysql:host=localhost;dbname=productos_bd;charset=utf8",$user,$pass);
            //$this->obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
            
        $consulta=$obj->prepare("INSERT INTO televisores( `tipo`, `precio`, `pais`, `foto`) 
        VALUES(:tipo, :precio, :pais, :foto)");

        $consulta->bindValue(':tipo',$this->tipo);
        $consulta->bindValue(':precio',$this->precio);
        $consulta->bindValue(':pais',$this->paisOrigen);
        $consulta->bindValue(':foto',$this->path);
                
        return $consulta->execute();    
    }

    public static function Traer()
    {
        $listaTelevisores=array();

        try {
            $user="root";
            $pass="";

            $obj=new PDO("mysql:host=localhost;dbname=productos_bd;charset=utf8",$user,$pass);
           // $obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
            
        $consulta=$obj->prepare("SELECT * FROM televisores");

        $consulta->execute();

        while($t=$consulta->fetch(PDO::FETCH_LAZY))
        {
            $unTelevisor=new Televisor($t->tipo,$t->precio,$t->pais,$t->foto);
           
            array_push($listaTelevisores,$unTelevisor);
            
        }
        

        return $listaTelevisores;
    }

    public function CalcularIVA()
    {
        return ($this->precio * 0.21) + $this->precio;
    }

    public function Verificar($listaTelevisores)
    {
        $retorno=true;

        foreach ($listaTelevisores as $key => $t) {
            
            if($this->tipo == $t->tipo && $this->paisOrigen == $t->paisOrigen)
            {
                $retorno=false;
                break;
            }
        }

        return $retorno;

        
    }

    public function Modificar($unTelevisor)
    {
        try {
            $user="root";
            $pass="";

            $obj=new PDO("mysql:host=localhost;dbname=productos_bd;charset=utf8",$user,$pass);
            //$this->obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        
        $consulta = $obj->prepare("UPDATE televisores SET `tipo` = :tipo , `precio` = :precio 
        , `pais` = :pais ,`foto`=:foto WHERE `tipo` = :tipoPropio AND `pais` =:paisPropio");


        $consulta->bindValue(':tipoPropio',$this->tipo);
        $consulta->bindValue(':paisPropio',$this->paisOrigen);
        $consulta->bindValue(':tipo',$unTelevisor->tipo);
        $consulta->bindValue(':precio',$unTelevisor->precio);
        $consulta->bindValue(':pais',$unTelevisor->paisOrigen);    
        $consulta->bindValue(':foto',$unTelevisor->path);
     

        return $consulta->execute();


    }

    function Eliminar()
    {
        try 
        {
            $user="root";
            $pass="";

            $obj=new PDO("mysql:host=localhost;dbname=productos_bd;charset=utf8",$user,$pass);
            //$this->obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        
        $consulta = $obj->prepare("DELETE FROM televisores WHERE `tipo` = :tipo AND `precio` = :precio 
        AND `pais` = :pais AND `foto`=:foto");

        $consulta->bindValue(':tipo', $this->tipo);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':pais', $this->paisOrigen);
        $consulta->bindValue(':foto', $this->path);

        return $consulta->execute();
    }
//no se como obtener id
    function GuardarEnArchivo()
    {
        $nombreArchivo="./archivos/televisores/televisores_borrados.txt";

        $archivo = fopen($nombreArchivo,"a");
        if(is_file($archivo))
        {
                        
            $destino=$this->path;
            $tipoArchivo=pathinfo($destino,PATHINFO_EXTENSION);
            $destino="./televisores/televisoresBorrados".$_POST["tipo"] . "." . $_POST["paisOrigen"] . "."."borrado" .".". date("Y-m-d-H:i:s") . "." .$tipoArchivo;
            move_uploaded_file($_FILES["Archivo"]["tmp_name"], $destino);
            fwrite($archivo,$this->ToString()."\r\n");
            fclose($archivo);            
        }
        

        return $retorno;
    }
    
    public static function MostrarBorrados()
    {
                
        $nombreArchivo="../archivos/televisores/televisores_borrados.txt";
        $listaTelevisores=array();


        if(is_file($nombreArchivo))
        {
            $archivo=fopen($nombreArchivo,"r");
            $cadena="";
            $datos=array();
            $unTelevisor;

            if($archivo)
            {
                while(!feof($archivo))
                {
                    $cadena=fgets($archivo);
                    $datos=explode(' - ',$cadena);

                    if(count($datos)>1)
                    {
                        $unTelevisor=new Televisor($datos[0],$datos[1],$datos[2],$datos[3]);
                        array_push($listaTelevisores,$unTelevisor);
                    }
                }
                fclose($archivo);
            }

            
        }
        return $listaTelevisores;
        
    }



}



?>
<?php
require_once "./clases/iParte2.php";
require_once "./clases/iParte3.php";
require_once "./clases/iParte4.php";


class Televisor implements IParte2,IParte3,IParte4
{
    public  $tipo;
    public  $precio;
    public  $paisOrigen;
    public  $path;

    public function __construct($_tipo="",$_precio="",$_paisOrigen="",$_path="")
    {    
        $this->tipo=$_tipo;
        $this->precio=$_precio;
        $this->paisOrigen=$_paisOrigen;
        $this->path=$_path;
    }    


    public function ToString()
    {
        return $this->tipo . " - " . $this->precio . " - " . $this->paisOrigen . " - " . $this->path;
    }

    function Agregar()
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

        
        $consulta=$obj->prepare("INSERT INTO televisores ( `tipo`, `precio`, `pais`, `foto`)
        VALUES(:tipo, :precio, :pais, :foto)");
            
        $consulta->bindValue(':tipo',$this->tipo);
        $consulta->bindValue(':precio',$this->precio);
        $consulta->bindValue(':pais',$this->paisOrigen);
        $consulta->bindValue(':foto',$this->path);
       
       return $consulta->execute();
    }

    static function Traer()
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

        
        $consulta=$obj->prepare("SELECT * FROM televisores");
        $consulta->execute();
        $listaTelevisores=array();
     
        while($obj=$consulta->fetch(PDO::FETCH_LAZY))
        {
            $unTelevisor=new Televisor($obj->tipo,$obj->precio,$obj->pais,$obj->foto);
            array_push($listaTelevisores,$unTelevisor);
           
        }


        return $listaTelevisores;
    }

    function CalcularIVA()
    {
        return ($this->precio * 0.21) + $this->precio;
    }   

    function Verificar($listaTelevisores)
    {
        $retorno=true;

        foreach ($listaTelevisores as $key => $t) {
            
            if($t->tipo ==$this->tipo && $t->paisOrigen == $this->paisOrigen)
            {
                $retorno=false;
                break;
            }


        }

        return $retorno;

    }

    function Modificar($unTelevisor)
    {
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

        $consulta=$obj->prepare("DELETE FROM televisores WHERE `tipo` = :tipo AND
        `precio` = :precio AND `pais` = :pais AND`foto`=:foto");

        $consulta->bindValue(':tipo', $this->tipo);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':pais', $this->paisOrigen);
        $consulta->bindValue(':foto', $this->path);

        return $consulta->execute();
    }

    function GuardarEnArchivo()
    {

        $nombreArchivo="./archivos/televisores_borrados.txt";

        $archivo = fopen($nombreArchivo,"a");
        if($archivo)
        {
            $tipoArchivo=pathinfo($this->path,PATHINFO_EXTENSION);
            $destino="./televisoresBorrados/" .$this->tipo . "." .$this->paisOrigen .".borrado.". date("His") . $tipoArchivo;
            move_uploaded_file($this->path, $destino);
            $this->path=$destino;
            fwrite($archivo,$this->ToString()."\r\n");
            fclose($archivo);        
        }    
    }

    static function MostrarBorrados()
    {
        $listaTelevisoresBorrados=array();
        $nombreArchivo="./archivos/televisores_borrados.txt";
    
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
                        array_push($listaTelevisoresBorrados,$unTelevisor);
                    }
                }
                fclose($archivo);
            }
        }

        echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML 5 – Listado de Televisores borrados</title>
    </head>
    <body>
    <h2>Listado de Televisores Borrados</h2>
       
    <table alingn="center">

    <tr>
        <td>Info</td>
    </tr>

    <tr>
        <td><hr></td>
    </tr>';

    foreach($listaTelevisoresBorrados as $unTelevisor)
    {
        echo "<tr>".
                "<td>".
                     $unTelevisor->ToString() .
               "</td>".

               "<td>".
                   " IVA: " .$unTelevisor->CalcularIVA().
            "</td>".
               "<td>".
               '    <img src= '.$unTelevisor->path. ' width="90" height="90">'.
                "</td>".

             "</tr>";
    }
    echo '

    <tr>
            <td><hr></td>    
        </tr> 

        </table>
        </body>
        </html>';
                
    }

}



?>
<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

require_once "AccesoDatos.php";





class Barbijo
{
    public $id;
    public $color;
    public $tipo;
    public $precio;


    public function __construct()
    {
        
    }

    
    private static function InsertarEnBD($unElemento)
    {
        
        $bd=AccesoDatos::DameUnObjetoAcceso();
                                    //color, tipo, precio y talle
        $consulta=$bd->RetornarConsulta("INSERT INTO Barbijos( `color`, `tipo`, `precio`) 
        VALUES(:color, :tipo, :precio)");

        $consulta->bindValue(':color',$unElemento->color);
        $consulta->bindValue(':tipo',$unElemento->tipo);
        $consulta->bindValue(':precio',$unElemento->precio);
       
       return $consulta->execute();
    }

    

    public static function AgregoUno(Request $request,Response $response,$args)
    {
        $recibo=$request->getParsedBody();
        $objJson=json_decode($recibo["barbijo"]);
    
        $retorno = new stdClass();
        

        $retorno->exito=self::InsertarEnBD($objJson);

        if($retorno->exito)
        {
            $retorno->mensaje="Se a agregado exitosamente";
            $retorno->status=200;
            $retorno->exito=true;
        }
        else
        {
            $retorno->mensaje="No se a podido agregar";
            $retorno->status=418;
            $retorno->exito=false;
        }

        return $response->withJson($retorno,$retorno->status);

    }

    public static function TraerTodosBD()
    {   
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT * FROM Barbijos");
        
        $consulta->execute();

      
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Barbijo");
    }

    public static function TraerTodos($request, $response,$args)
    {
        $lista=self::TraerTodosBD();
        $retorno = new stdClass();
        
        if(isset($lista))
        {
            $retorno->mensaje="Datos obtenidos correctamente";
            $retorno->status=200;
            $retorno->exito=true;
            $retorno->tabla=json_encode($lista);
        }
        else
        {
            $retorno->mensaje="No se a podido acceder a los datos";
            $retorno->status=424;
            $retorno->exito=false;
        }

        return $response->withJson($retorno,$retorno->status);
    }


    
    public static function BorrarEnBd($id)
    {
        $bd=AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("DELETE from Barbijos where id='$id'");
        $consulta->execute();
        return $consulta->rowCount();
    }


    public static function BorrarUno(Request $request,Response $response,$args)
    {
        $recibo=$request->getParsedBody();        
        $id=$recibo["id_barbijo"];
        $token = $request->getHeader("token")[0];
        $retorno= new stdClass();
        $retorno->status=418;

        try 
        {
            $json = JWT::decode($token,"admin",['HS256'])->data;

            
            $aux=self::BorrarEnBd($id);

            if($aux>0)
            {
                $retorno->mensaje="Elemento eliminado exitosamente";
                $retorno->status=200;
                $retorno->exito=true;
            }
            else
            {
                $retorno->mensaje="No se a podido borrar el elemento";
                $retorno->status=418;
                $retorno->exito=false;
            }

        } 
        catch (Exception $e) 
        {
           $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
           $retorno->status=418;
           $retorno->exito=false;
        }
        
        return $response->withJson($retorno,$retorno->status);
    }


    public static function ModificarEnBd($elemento)
    {
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("UPDATE Barbijos SET `color` = :color , `tipo` = :tipo 
        , `precio` = :precio  WHERE `id` = :id");

        $consulta->bindValue(':id',$elemento->id);        
        $consulta->bindValue(':color',$elemento->color);
        $consulta->bindValue(':tipo',$elemento->tipo);
        $consulta->bindValue(':precio',$elemento->precio);        

         $consulta->execute();
        return $consulta->rowCount();
        
    }


    public static function ModificarUno(Request $request,Response $response,$args)
    {

        
        $recibo=$request->getParsedBody();
        $barbijoUpdate=json_decode($recibo["barbijo"]);
        $token = $request->getHeader("token")[0];
        $retorno= new stdClass();
        $retorno->status=418;

        try 
        {
            $json = JWT::decode($token,"admin",['HS256'])->data;

    
            $aux=self::ModificarEnBd($barbijoUpdate);       

            if($aux>0)
            {
                $retorno->mensaje="Barbijo Modificado exitosamente";
                $retorno->status=200;
            }
            else
            {
                $retorno->mensaje="El barbijo no se a podio Modificar";
                $retorno->status=418;
            }
        } 
        catch (Exception $e) 
        {
           $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
           $retorno->status=418;
        }
        
        return $response->withJson($retorno,$retorno->status);


    }


    
}

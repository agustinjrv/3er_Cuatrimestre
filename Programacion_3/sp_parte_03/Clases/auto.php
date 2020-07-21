<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;


require "AccesoDatos.php";

class Auto
{
    public function __construct()
    {

    }

    private static function InsertarEnBD($unElemento)
    {
        
        $bd=AccesoDatos::DameUnObjetoAcceso();

        $consulta=$bd->RetornarConsulta("INSERT INTO Autos ( `color`, `marca`, `precio`, `modelo`) 
        VALUES(:color, :marca, :precio, :modelo)");

        $consulta->bindValue(':color',$unElemento->color);
        $consulta->bindValue(':marca',$unElemento->marca);
        $consulta->bindValue(':precio',$unElemento->precio);
        $consulta->bindValue(':modelo',$unElemento->modelo);
       
       return $consulta->execute();
    }

    

    public static function AgregoUno( $request, $response,$args)
    {
        $recibo=$request->getParsedBody();
        $objJson=json_decode($recibo["cadenaJson"]);
        $retorno = new stdClass();
        
        $retorno->exito=self::InsertarEnBD($objJson);

        if($retorno->exito)
        {
            $retorno->mensaje="Se a agregado exitosamente";
            $retorno->status=200;
        }
        else
        {
            $retorno->mensaje="No se a podido agregar";
            $retorno->status=418;
        }

        return $response->withJson($retorno,$retorno->status);

    }

    private static function TraerTodosBD()
    {
        $retorno=new stdClass();
        $retorno->listaElementos=array();
        
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT * FROM Autos");
        
        $retorno->exito=$consulta->execute();

       if($retorno->exito)
       {
            while($obj=$consulta->fetch(PDO::FETCH_LAZY))
            {
                $unElemento=new stdClass();
                $unElemento->color=$obj->color;
                $unElemento->marca=$obj->marca;
                $unElemento->precio=$obj->precio;
                $unElemento->modelo=$obj->modelo;
                
                array_push($retorno->listaElementos,$unElemento);  
            }
       }

        return $retorno;
    }

    public static function TraerTodos( $request, $response,$args)
    {
        $aux=self::TraerTodosBD();
        $retorno = new stdClass();
        
        
        if($aux->exito)
        {
            $retorno->mensaje="Datos obtenidos correctamente";
            $retorno->status=200;
            $retorno->tabla=json_encode($aux->listaElementos);
        }
        else
        {
            $retorno->mensaje="No se a podido acceder a los datos";
            $retorno->status=424;
        }

        return $response->withJson($retorno,$retorno->status);
    }

    public static function BorrarEnBd($id)
    {
        $bd=AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("DELETE from autos where id='$id'");
        return $consulta->execute();
    }


    public static function BorrarUno(Request $request,Response $response,$args)
    {
        $id=json_decode($request->getHeader("id")[0]);
        $token = $request->getHeader("jwt")[0];
        $retorno= new stdClass();
        $retorno->status=418;

        try 
        {
            $json = JWT::decode($token,"admin",['HS256'])->data;

            if(strtolower($json->perfil)=="propietario")
            {
                $retorno->exito=Auto::BorrarEnBd($id);
            }
            else
            {
                $retorno->mensaje="El usuario :" . $json->nombre ." " . $json->apellido . " no tiene permisos para borrar el auto";
                $retorno->exito=false;
            }

            if($retorno->exito)
            {
                $retorno->mensaje="Auto eliminado exitosamente";
                $retorno->status=200;
            }
            else
            {
                $retorno->mensaje="No se a podido borrar el auto";
            }

        } 
        catch (Exception $e) 
        {
           $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
        }
        
        return $response->withJson($retorno,$retorno->status);
    }

    public static function ModificarEnBd($elemento,$id)
    {//(color, marca, precio y modelo
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("UPDATE autos SET `color` = :color , `marca` = :marca 
        , `precio` = :precio ,`modelo`=:modelo WHERE `id` = $id");

        $consulta->bindValue(':color',$elemento->color);
        $consulta->bindValue(':marca',$elemento->marca);
        $consulta->bindValue(':precio',$elemento->precio);
        $consulta->bindValue(':modelo',$elemento->modelo);


        return $consulta->execute();
    }


    public static function ModificarUno(Request $request,Response $response,$args)
    {
        $auto=json_decode($request->getHeader("cadenaJson")[0]);
        $id=json_decode($request->getHeader("id")[0]);
        $token = $request->getHeader("jwt")[0];
        $retorno= new stdClass();
        $retorno->status=418;

        try 
        {
            $json = JWT::decode($token,"admin",['HS256'])->data;

            if(strtolower($json->perfil)=="propietario" || strtolower($json->perfil)=="encargado")
            {
                $retorno->exito=Auto::ModificarEnBd($auto,$id);
            }
            else
            {
                $retorno->mensaje="El usuario :" . $json->nombre ." " . $json->apellido . " no tiene permisos para modificar el auto";
                $retorno->exito=false;
            }

            if($retorno->exito)
            {
                $retorno->mensaje="Auto Modificado exitosamente";
                $retorno->status=200;
            }
            else
            {
                $retorno->mensaje="El Auto no se a podio Modificar";
            }
        } 
        catch (Exception $e) 
        {
           $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
        }
        
        return $response->withJson($retorno,$retorno->status);


    }
        

}


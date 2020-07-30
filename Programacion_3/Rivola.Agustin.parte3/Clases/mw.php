<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

class MW
{
    public function __construct()
    {

    }

    public function VerificarSeteoCorreoYClave(Request $request,Response $response, $next)
    {
        $recibo=$request->getParsedBody();
        $datos=json_decode($recibo["cadenaJson"]);
        $retorno=new stdClass();
        $retorno->mensaje="";
        $retorno->status=403;

        $flagCorreo=isset($datos->correo);
        $flagClave=isset($datos->clave);

        if(!($flagCorreo)&&!($flagClave))
        {
            $retorno->mensaje="El correo y la contraseña no estan seteados";
            $response= $response->withJson($retorno,$retorno->status);
        }
        else if(!($flagCorreo))
        {
            $retorno->mensaje="El correo no esta seteado";
            $response= $response->withJson($retorno,$retorno->status);
        }
        else if(!($flagClave))
        {
            $retorno->mensaje="La clave no esta seteada";
            $response= $response->withJson($retorno,$retorno->status);
        }
        else
        {
            $response=$next($request,$response);
        }

        return $response;
    }

    public static function VerificarVaciosCorreoYClave(Request $request,Response $response,$next)
    {
        $recibo=$request->getParsedBody();
        $datos=json_decode($recibo["cadenaJson"]);
        $retorno=new stdClass();
        $retorno->mensaje="";
        $retorno->status=409;

        $flagCorreo=empty($datos->correo);
        $flagClave=empty($datos->clave);

        if($flagCorreo && $flagClave)
        {
            $retorno->mensaje="El correo y la contraseña estan vacios";
            $response= $response->withJson($retorno,$retorno->status);
        }
        else if($flagCorreo)
        {
            $retorno->mensaje="El correo esta vacio";
            $response= $response->withJson($retorno,$retorno->status);
        }
        else if($flagClave)
        {
            $retorno->mensaje="La clave esta vacia";
            $response= $response->withJson($retorno,$retorno->status);
        }
        else
        {
            $response=$next($request,$response);
        }

        return $response;
    }

    public function VerficarEnBDCorreoYClave(Request $request,Response $response,$next)
    {
        $recibo=$request->getParsedBody();
        $datos=json_decode($recibo["cadenaJson"]);    

        $retorno = new stdClass();
        
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT correo,clave FROM Usuarios 
        where correo='$datos->correo' AND clave='$datos->clave'");
        
        $consulta->execute();

        $cantidadFilas = $consulta->rowCount();

        if($cantidadFilas >= 1)
        {
            $encontro = true;
        }

        if($encontro)
        {
            $response=$next($request,$response);
        }
        else
        {
            $retorno->mensaje="El correo y la clave no existe en la base de datos";
            $retorno->status=403;
            $response= $response->withJson($retorno,$retorno->status);
        }

        return $response;
    }

    public static function VerificarEnBdCorreo(Request $request,Response $response,$next)
    {
        $recibo=$request->getParsedBody();
        $datos=json_decode($recibo["cadenaJson"]);
        $retorno=new stdClass();
        $retorno->mensaje="";
        $retorno->status=403;    
        $encontro   =false;

        $retorno = new stdClass();
        
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT correo FROM Usuarios 
        where correo='$datos->correo'");
        
        $consulta->execute();

        $cantidadFilas = $consulta->rowCount();

        if($cantidadFilas >= 1)
        {
            $encontro = true;
        }

        if(!$encontro)
        {
            $response=$next($request,$response);
        }
        else
        {
            $retorno->mensaje="El correo ya existe en la base de datos";
            $response= $response->withJson($retorno,$retorno->status);
        }

        return $response;
    }

    
    


}
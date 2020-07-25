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
        $foto =$request->getUploadedFiles();
        
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
        $retorno=new stdClass();
        $retorno->mensaje="";
        $retorno->status=403;       

        $retorno = new stdClass();
        
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT correo,clave FROM Usuarios 
        where correo='$datos->correo' AND clave='$datos->clave'");
        
        $consulta->execute();

        $cantidadFilas = $consulta->rowCount();
        $encontro=false;
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
            $retorno->mensaje="El correo y/o clave incorrectos";
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
            $retorno->status=403; 
            $response= $response->withJson($retorno,$retorno->status);
        }

        return $response;
    }

    public function VerificarPrecioYColor(Request $request,Response $response,$next)
    {
        $recibo=$request->getParsedBody();
        $datos=json_decode($recibo["cadenaJson"]);
        $retorno=new stdClass();
        $retorno->mensaje="";
        $retorno->status=409;  

        $flagPrecio=false;
        $flagColor=false;

        if($datos->precio>=50000 && $datos->precio<=600000)
        {
            $flagPrecio=true;
        }
        if($datos->color != "azul")
        {
            $flagColor=true;
        }        

        if(!($flagPrecio) && !($flagColor))
        {
            $retorno->mensaje="El precio debe estar entre 50000 y 600000 y el color debe ser distinto de azul";
            $response= $response->withJson($retorno,$retorno->status);
        }
        else if(!($flagPrecio))
        {
            $retorno->mensaje="El precio debe estar entre 50000 y 600000";
            $response= $response->withJson($retorno,$retorno->status);
        }
        elseif(!($flagColor))
        {
            $retorno->mensaje="El color debe ser distinto de azul";   
            $response= $response->withJson($retorno,$retorno->status);        
        }
        
        if($flagColor && $flagPrecio)
        {
            $response=$next($request,$response);
        }


        return $response;
    }

    public function VerificarToken(Request $request,Response $response,$next)
    {
        $token = $request->getHeader("jwt")[0];
        $retorno= new stdClass();
        $retorno->status=403;

        try 
        {
            $json = JWT::decode($token,"admin",['HS256'])->data;
            $response=$next($request,$response);

        }
        catch (Exception $e) 
        {
           $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
           $response= $response->withJson($retorno,$retorno->status);
        }



        return $response;
    }

    public static function EsPropietario(Request $request,Response $response,$next)
    {
        $token = $request->getHeader("jwt")[0];
        $retorno= new stdClass();
        $retorno->status=409;

        $json = JWT::decode($token,"admin",['HS256'])->data;

        if(strtolower($json->perfil)=="propietario")
        {
            $retorno->propietario=true;
            $retorno->status=200;
            $response=$next($request,$response);
        }
        else
        {
            $retorno->propietario=false;
            $retorno->mensaje="No es propietario";
            $response=$response->withJson($retorno,$retorno->status);
        }


        return $response;
    }

    public function EsEncargado(Request $request,Response $response,$next=self::EsPropietario)
    {
        $token = $request->getHeader("jwt")[0];
        $retorno= new stdClass();
        $retorno->status=409;

        $json = JWT::decode($token,"admin",['HS256'])->data;

        if(strtolower($json->perfil)=="encargado")
        {
            $retorno->encargado=true;
            $retorno->status=200;
            $retorno =$response->withJson($retorno,$retorno->status);
        }
        else
        {   
            $response=$next($request,$response);

            if($response->status==200)
            {
                $retorno =$response->withJson($retorno,$retorno->status);
            }
            else
            {
                $retorno->encargado=false;
                $retorno->mensaje="no es encargado ,ni propietario";
                $response=$response->withJson($retorno,$retorno->status);
            }
            
        }


        return $response;
    }



}
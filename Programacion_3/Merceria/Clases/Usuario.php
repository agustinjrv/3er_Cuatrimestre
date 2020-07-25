<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;


class Usuario
{
    public function __construct()
    {
        
    }

    
    private static function InsertarEnBD($unElemento)
    {
        
        $bd=AccesoDatos::DameUnObjetoAcceso();

        $consulta=$bd->RetornarConsulta("INSERT INTO Usuarios ( `correo`, `clave`, `nombre`, `apellido`, `perfil`,`foto`) 
        VALUES(:correo, :clave, :nombre, :apellido, :perfil, :foto)");

        $consulta->bindValue(':correo',$unElemento->correo);
        $consulta->bindValue(':clave',$unElemento->clave);
        $consulta->bindValue(':nombre',$unElemento->nombre);
        $consulta->bindValue(':apellido',$unElemento->apellido);
        $consulta->bindValue(':perfil',$unElemento->perfil);
        $consulta->bindValue(':foto',$unElemento->foto);
       
       return $consulta->execute();
    }

    

    public static function AgregoUno($request,$response,$args)
    {
        $recibo=$request->getParsedBody();
        $objJson=json_decode($recibo["cadenaJson"]);

        /// control de archivos
        $archivos = $request->getUploadedFiles();   
        $destino = "fotos/";
        $nombreAnterior = $archivos['foto']->getClientFilename();
        $extension = explode(".", $nombreAnterior);
        $extension = array_reverse($extension);
        $nuevoNombre=$objJson->nombre ."." . date("Gis").  "." . $extension[0];
        $archivos['foto']->moveTo($destino . $nuevoNombre);
        $objJson->foto=$nuevoNombre;

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
        $consulta=$bd->RetornarConsulta("SELECT ID,correo,nombre,apellido,perfil,foto FROM Usuarios");
        
        $retorno->exito=$consulta->execute();

       if($retorno->exito)
       {
            while($obj=$consulta->fetch(PDO::FETCH_LAZY))
            {
                $elemento=new stdClass();
                $elemento->id=$obj->ID;
                $elemento->correo=$obj->correo;
                $elemento->nombre=$obj->nombre;
                $elemento->apellido=$obj->apellido;
                $elemento->perfil=$obj->perfil;
                $elemento->foto=$obj->foto;
                array_push($retorno->listaElementos,$elemento);  
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

    public static function TraerUno($elemento)
    {
        $retorno = new stdClass();
        
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT ID,correo,nombre,apellido,perfil,foto FROM Usuarios 
        where correo='$elemento->correo' AND clave='$elemento->clave'");
        
        $retorno->exito=$consulta->execute();


        if($retorno->exito)
        {
            $obj=$consulta->fetch(PDO::FETCH_LAZY);

            $elemento=new stdClass();
            $elemento->id=$obj->ID;
            $elemento->correo=$obj->correo;
            $elemento->nombre=$obj->nombre;
            $elemento->apellido=$obj->apellido;
            $elemento->perfil=$obj->perfil;
            $elemento->foto=$obj->foto;

            $retorno->obj=$elemento;
        }
        return $retorno;
    }

    public static function Login( $request, $response,$args)
    {
        $recibo=$request->GetParsedBody();
        $json=json_decode($recibo["cadenaJson"]);

        $aux=self::TraerUno($json);

        
        $retorno=new stdClass();
        
        if($aux->exito)
        {
            $retorno->status=200;
            $payload = array(
                "iat" => time(),
                "exp" =>  time()+30,
                'data' => $aux->obj
            );
            $retorno->jwt = JWT::encode($payload, "admin", "HS256");
        }
        else
        {
            $retorno->jwt=null;
            $retorno->status=403;
        }

        return $response->withJson($retorno,$retorno->status);
    }

    
    public static function VerificarToken( $request, $response,$args)
    {
        $token = $request->getHeader("data")[0];
        $retorno = new stdClass();       

        try {
        //DECODIFICO EL TOKEN RECIBIDO            
        $decodificado = JWT::decode($token,"admin",['HS256']);

        $retorno->mensaje = "Token OK!!!";
        $retorno->status = 200;
        } 
        catch (Exception $e) {

        $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
        $retorno->status = 409;
        }
        
        return $response->withJson($retorno, $retorno->status);
    }



    
}
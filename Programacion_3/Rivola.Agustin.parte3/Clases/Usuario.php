<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
require_once "./vendor/autoload.php";

class Usuario
{
    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil;
    public $foto;



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
        
        $objJson=json_decode($recibo["usuario"]);
        

        /// control de archivos
        $archivos = $request->getUploadedFiles();   
        $destino = "fotos/";
        $nombreAnterior = $archivos['foto']->getClientFilename();
        $extension = explode(".", $nombreAnterior);
        $extension = array_reverse($extension);
        $nuevoNombre=$objJson->correo ."." . date("Gis").  "." . $extension[0];
        $archivos['foto']->moveTo($destino . $nuevoNombre);
        $objJson->foto=$nuevoNombre;

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

    private static function TraerTodosBD()
    {
        
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT id,correo,nombre,apellido,perfil,foto FROM Usuarios");
        
        $consulta->execute();
 
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Usuario");
    }

    public static function TraerTodos( $request, $response,$args)
    {
        $lista=self::TraerTodosBD();
        $retorno = new stdClass();
        if(isset($lista))
        {
            $retorno->mensaje="Datos obtenidos correctamente";
            $retorno->exito=true;
            $retorno->status=200;
            $retorno->tabla=json_encode($lista);
        }
        else
        {
            $retorno->mensaje="No se a podido acceder a los datos";
            $retorno->exito=false;
            $retorno->status=424;
        }

        return $response->withJson($retorno,$retorno->status);
    }

    public static function TraerUno($elemento)
    {        
        $bd= AccesoDatos::DameUnObjetoAcceso();
        $consulta=$bd->RetornarConsulta("SELECT id,correo,nombre,apellido,perfil,foto FROM Usuarios 
        where correo='$elemento->correo' AND clave='$elemento->clave'");
        
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function Login( $request, $response,$args)
    {
        $recibo=$request->GetParsedBody();
        $json=json_decode($recibo["user"]);

        $obj=self::TraerUno($json);

        
        $retorno=new stdClass();
        
        if($obj !=false)
        {
            $payload = array(
               // "iat" => time(),
               // "exp" =>  time()+30,
                'data' => $obj
            );
            $retorno->status=200;
            $retorno->jwt = JWT::encode($payload, "admin", "HS256");
            $retorno->exito=true;

        }
        else
        {
            $retorno->jwt=null;
            $retorno->status=403;
            $retorno->exito=false;
        }

        return $response->withJson($retorno,$retorno->status);
    }

    
    public static function VerificarToken( $request, $response,$args)
    {
        $token = $request->getHeader("token")[0];
        $retorno = new stdClass();       

        try {
        //DECODIFICO EL TOKEN RECIBIDO            
        $decodificado = JWT::decode($token,"admin",['HS256']);

        $retorno->mensaje = "Token OK!!!";
        $retorno->status = 200;
        $retorno->exito = true;
        } 
        catch (Exception $e) {

        $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
        $retorno->status = 403;
        $retorno->exito=false;
        }
        
        return $response->withJson($retorno, $retorno->status);
    }

    public static function GenerarPDF(Request $request,Response $response,$args)
    {
        
      //  $recibo= $request->getParsedBody();
      //  $tipoPdf=json_decode($recibo["tipo_pdf"]);
        //$token= $request->getHeader("token")[0];
        //$retorno = new stdClass();
        /*
        try {
            //DECODIFICO EL TOKEN RECIBIDO           
            
            $usuario = JWT::decode($token,"admin",['HS256'])->data;
            
    
            $retorno->mensaje = "Token OK!!!";
            $retorno->status = 200;
            $retorno->exito = true;
            } 
            catch (Exception $e) {
    
            $retorno->mensaje = "Token no valido!!! --> " . $e->getMessage();
            $retorno->status = 403;
            $retorno->exito=false;
            }*/
        

        
        $listaUsuarios=self::TraerTodosBD();
        $listaBarbijos=Barbijo::TraerTodosBD();

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                                'pagenumPrefix' => 'Pág. ',
                                'pagenumSuffix' => ' - ',
                                'nbpgcomposer instPrefix' => ' de ']);
      //  header('content-type:application/pdf');

        $mpdf->SetHeader('Rivola Agustin||{PAGENO}{nbpg}');
        $mpdf->setFooter('|'.date("d-m-Y").'|');
         /*   
            if($usuario->perfil=="propietario")
            {
                $contraseña=$usuario->apellido;
            }
            else
            {
                $contraseña=$usuario->correo;
            }*/
        
        $mpdf->SetProtection(array('copy','print','extract'),"1234" ,"starwars");

        $mpdf->WriteHTML('
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Listado</title>
                      
            </head>
            <body>
            <h2>Listado</h2>
            
            <table alingn="center">

            <tr>
                <td>Info</td>
            </tr>

            <tr>
                <td><hr></td>
            </tr>'."<tr>".
            "<th>ID</th>".
            "<th>Correo</th>".
            "<th>Nombre</th>".
            "<th>Apellido</th>".
            "<th>Precio</th>".
            "<th>Perfil</th>".
            "<th>Foto</th>".
            "</tr> ");

            foreach($listaUsuarios as $unUsuario)
            {
                $mpdf->WriteHTML( 
                     "<tr>".
                        "<td>".$unUsuario->id . "</td>".
                        "<td>".$unUsuario->correo . "</td>".
                        "<td>".$unUsuario->nombre . "</td>".
                        "<td>".$unUsuario->apellido . "</td>".
                        "<td>".$unUsuario->perfil . "</td>".
                        "<td>".'<img src="./fotos/'.$unUsuario->foto. '" width="90" height="90">'. "</td>".
                        "<td>".                            
                        "</td>".
                    "</tr>" );
            }

            $mpdf->writeHtml("<br><br><br>");

            $mpdf->writeHTML(
                "<tr>".
                "<th>ID</th>".
                "<th>Color</th>".
                "<th>Tipo</th>".
                "<th>Precio</th>".
                "</tr>");
            foreach($listaBarbijos as $unBarbijo)
            {
                
                $mpdf->writeHTML(
                 "<tr>".
                "<td>".$unBarbijo->id . "</td>".
                "<td>".$unBarbijo->color . "</td>".
                "<td>".$unBarbijo->tipo . "</td>".
                "<td>".$unBarbijo->precio . "</td>".
                "<td>".                            
                "</td>".
                "</tr>");
            }

        $mpdf->WriteHTML('
        <tr>
                <td><hr></td>    
            </tr> 

            </table>
            
            <br/>
            <br/>

            </body>
            </html>');

        $mpdf->Output("mi_pdf.pdf","I");

        return $response->withHeader('Content-Type', 'application/pdf');;
    }



    
}
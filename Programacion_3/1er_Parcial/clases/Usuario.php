<?php 

class Usuario
{
    private $email;
    private $clave;
    
    
    public function __construct( $_email, $_clave)
    {
        $this->email=$_email;
        $this->clave=$_clave;
        
        
    }

    
    public function ToString()
    {
        return $this->email . " - " .  $this->clave;
    }

    function GuardarEnArchivo()
    {

        $nombreArchivo="./archivos/usuarios.txt";
        $retorno="No se a podido agregar al usuario";

        $archivo = fopen($nombreArchivo,"a");
        if($archivo)
        {
            fwrite($archivo,$this->ToString()."\r\n");
            fclose($archivo);
            $retorno="Se a agregado al usuario en el archivo";
        }
        
        return $retorno;
    }

    static function TraerTodos()
    {
        $nombreArchivo="./archivos/usuarios.txt";
        $listaUsuarios=array();


        if(is_file($nombreArchivo))
        {
            $archivo=fopen($nombreArchivo,"r");
            $cadena="";
            $datos=array();
            $unUsuario;

            if($archivo)
            {
                while(!feof($archivo))
                {
                    $cadena=fgets($archivo);
                    $datos=explode(' - ',$cadena);

                    if(count($datos)>1)
                    {
                        $unUsuario=new Usuario($datos[0],$datos[1]);
                        array_push($listaUsuarios,$unUsuario);
                    }
                }
                fclose($archivo);
            }
        }

        return $listaUsuarios;
    }

    static function VerificarExistencia($usuario)
    {
        $listaUsuarios=self::TraerTodos();       
        $retorno=false;

        foreach ($listaUsuarios as $key => $u) {
            
            if($u->email == $usuario->email && trim($u->clave) == trim($usuario->clave))
            {
                $retorno=true;
                break;
            }
        }

        return $retorno;
    }




}
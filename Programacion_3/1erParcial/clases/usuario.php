<?php


 class Usuario
{
    private $email;
    private $clave;

    public function __construct($_email,$_clave)
    {
        $this->email=$_email;
        $this->clave=$_clave;
    }

    public function ToString()
    {
        return $this->email . " - " . $this->clave;
    }

    public function GuardarEnArchivo()
    {
        $nombreArchivo="../archivos/usuarios.txt";
        $retorno="No se a podido agregar el Usuario";

        $archivo = fopen($nombreArchivo,"a");
        if(is_file($archivo))
        {
            fwrite($archivo,$this->ToString()."\r\n");
            fclose($archivo);
            $retorno="Usuario agregado correctamente";
        }
        

        return $retorno;
    }

    public static function TraerTodos()
    {
        $nombreArchivo="../archivos/usuarios.txt";
        if(is_file($nombreArchivo))
        {
            $archivo=fopen($nombreArchivo,"r");
            $cadena="";
            $datos=array();
            $unUsuario;
            $listaUsuarios=array();

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

            return $listaUsuarios;
        }

    }

    public static function VerificarExistencia($usuario)
    {
        $listaUsuarios=self::TraerTodos();
        $retorno=false;
        foreach ($listaUsuarios as $key => $u) {
            
            if($usuario->email==$u->email && $usuario->clave==$u->clave)
            {
                $retorno=true;
            }
        }

        return $retorno;
    }



}

?>
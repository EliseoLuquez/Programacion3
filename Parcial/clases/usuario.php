<?php


include_once './validadorjwt.php';

class Usuario 
{
    public $email;
    public $clave;
    public $tipo;


    public function __construct($email, $clave,  $tipo)
    {
        $this->email = $email;
        $this->clave = $clave;
        $this->tipo = $tipo;
    }


    public static function Singin($email, $clave, $tipo)
    {
        $retorno = false;
        $usuario = new Usuario($email, $clave, $tipo);
        if(GuardarUsuario($usuario, 'users.txt'))
        {
            $retorno = true;
        }
        return $retorno;
    }
    
    public static function Login($email, $clave)
    {
        $retorno = false;
        if(LeerUsuario('users.txt', $listaUsuarios))
        {
            $retorno = false;
            foreach ($listaUsuarios as $usuario) 
            {
                if($usuario['email'] == $email && $usuario['clave'] == $clave)
                {
                    $token = ValidadorJWT::CrearToken($usuario);
                    var_dump($token);
                    $retorno = true;
                break;
                }
            }
        } 
        
        if($retorno)
        {
            $retorno = $token;
        }
        
        return $retorno;
    }



    public function EsAdmin($dato)
    {
        $retorno = false;
        $encargado = 'encargado';
        $cliente = 'cliente';


        if($dato->tipo == $encargado)
        {
            $retorno = true;
        }
        return $retorno;
    }


}
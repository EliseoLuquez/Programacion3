<?php


include_once './validadorjwt.php';

class Usuario 
{
    public $email;
    public $clave;
    public $tipo;
    public $foto1;
    public $foto2;
    public $id;

    public function __construct($id, $email, $clave,  $tipo, $foto1 ,$foto2)
    {
        $this->id =  $id;
        $this->email = $email;
        $this->clave = $clave;
        $this->tipo = $tipo;
        $this->foto1 = $foto1;
        $this->foto2 = $foto2;
    }


    public static function Singin($id, $email, $clave, $tipo, $foto1, $foto2)
    {
        $retorno = false;
        if(Usuario::BuscarUsuario($email))
        {
            $usuario = new Usuario($id, $email, $clave, $tipo, $foto1, $foto2);
            if(Guardar($usuario, 'users.json'))
            {
                $retorno = true;
            }
        }
        else
        {
            echo 'Usuario existente';
        }
        return $retorno;
    }
    
    public static function Login($email, $clave)
    {
        $retorno = false;
        if(LeerTxt('users.txt', $listaUsuarios))
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
        $encargado = 'admin';


        if($dato->tipo == $encargado)
        {
            $retorno = true;
        }
        return $retorno;
    }

    // TRUE ya existe el usuario
    public function BuscarUsuario($email)
    {   
        $retorno = false;

        if(Leer('users.txt', $listaUsuarios))
        {
            foreach ($listaUsuarios as $auxUr)
            {
                if($email == $auxUr['email'])
                {
                    $retorno = true;
                    break;
                }
            }   
        }
        return $retorno;
    }

    public function BuscarIdToken($dato)
    {   
        $retorno = false;

        if(Leer('users.txt', $listaUsuarios))
        {
            foreach ($listaUsuarios as $auxUr)
            {
                if($dato['id'] == $auxUr['id'])
                {
                    $retorno = $auxUr['id'];
                    break;
                }
            }   
        }
        return $retorno;
    }

    public function BuscarId($id)
    {   
        $retorno = false;

        if(Leer('users.txt', $listaUsuarios))
        {
            foreach ($listaUsuarios as $auxUr)
            {
                if($id == $auxUr['id'])
                {
                    $retorno = $auxUr['id'];
                    break;
                }
            }   
        }
        return $retorno;
    }


    



}
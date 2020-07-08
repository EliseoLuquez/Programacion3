<?php

include_once 'persona.php';
include_once './validadorjwt.php';

class Usuario extends Persona
{
    public $id;
    public $obra_social;
    public $clave;
    public $tipo;


    public function __construct($id, $nombre, $dni, $obra_social, $clave,  $tipo)
    {
        $this->id = $id;
        parent::__construct($nombre, $dni);
        $this->obra_social = $obra_social;
        $this->clave = $clave;
        $this->tipo = $tipo;
    }


    public static function Singin($id, $nombre, $dni, $obra_social, $clave, $tipo)
    {
        $retorno = false;
        $usuario = new Usuario($id, $nombre, $dni, $obra_social, $clave, $tipo);
        if(!Usuario::BuscarUsuario($dni))
        {
            if(GuardarTxt($usuario, 'usuario.txt'))
            {
                $retorno = true;
            }
        }
        else
        {
            echo 'El usuario ya existe';
        }
        return $retorno;
    }
    
    public static function Login($nombre, $clave)
    {
        $retorno = false;
        //$listaUsuarios = array();
        if(LeerTxt('usuario.txt', $listaUsuarios))
        {
            $retorno = false;
            foreach ($listaUsuarios as $usuario) 
            {
                //var_dump($usuario);
                //echo $email . ','. $usuario['email'] . ',' . $clave . ',' . $usuario['clave'];
                if($usuario['nombre'] == $nombre && $usuario['clave'] == $clave)
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
        $admin = 'admin';
        $tipoUser = 'user';

        if($dato->tipo == $admin)
        {
            $retorno = true;
        }
        return $retorno;
    }

    // TRUE ya existe el usuario
    public function BuscarUsuario($dni)
    {   
        $retorno = false;

        if(LeerTxt('usuario.txt', $listaUsuarios))
        {
            foreach ($listaUsuarios as $auxUr)
            {
                if($dni == $auxUr['dni'])
                {
                    $retorno = true;
                    break;
                }
            }   
        }
        return $retorno;
    }
}
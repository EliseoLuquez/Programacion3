<?php

include_once 'persona.php';
include_once 'validadorjwt.php';
include_once 'funciones.php';

class Usuario extends Persona
{
    public $email;
    public $telefono;
    public $clave;
    public $tipo;


    public function __construct($nombre, $apellido, $email, $telefono, $clave,  $tipo)
    {
        parent::__construct($nombre, $apellido);
        $this->email = $email;
        $this->telefono = $telefono;
        $this->clave = $clave;
        $this->tipo = $tipo;
    }

    /*
    public function ValidarUsuario($array, $usuario)
    {
        if($this->email == $usuario->email && $this->clave == $usuario->clave)
        {
            return true;
        }
        return false;
    }
    */
    
    public static function Singin($nombre, $apellido, $email, $telefono, $clave, $tipo)
    {
        $retorno = false;
        $usuario = new Usuario($nombre, $apellido, $email, $telefono, $clave, $tipo);
        if(Guardar($usuario, 'usuario.txt'))
        {
            $retorno = true;
        }
        return $retorno;
    }
    
    public static function Login($email, $clave)
    {
        $retorno = false;
        //$listaUsuarios = array();
        if(Leer('usuario.txt', $listaUsuarios))
        {
            $contrasena = 'clave';
            foreach ($listaUsuarios as $usuario) 
            {
                //var_dump($usuario);
                //echo $email . ','. $usuario['email'] . ',' . $clave . ',' . $usuario['clave'];
                if($usuario['email'] == $email && $usuario['clave'] == $contrasena)
                {
                    $token = ValidadorJWT::CrearToken($usuario);
                    echo $token;
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

public function Mostrar($dato)
{
    $usuario = ValidadorJWT::VerificarToken($dato);
    $retorno = '';
    $admin = 'admin';
    if(Leer("usuario.txt", $listaUsuarios))
    {
        if($usuario->tipo == $admin)
        {
            foreach ($listaUsuarios as $aux) 
            {
                $retorno = $retorno . $aux['nombre']. PHP_EOL;    
            }
            return $retorno;
        }
        else
        {
            foreach ($listaUsuarios as $aux)
            {
                if($usuario->tipo == 'user')
                {
                    $retorno = $retorno . $aux['nombre']. PHP_EOL;
                }
                return $retorno;
            }
        }
    }
    return $retorno;
}


/*
public function BuscarUsuario($dato)
{
    if(Leer('usuario.txt', $listaUsuarios))
    {
        foreach ($listaUsuarios as $usuario) 
        {
           if($usuario['email'] == $dato['email'])
           {
              $retorno = $usuario;
              break;
           }
           else
           {
               $retorno = $usuario;
               break;
           }
        }
     } 
     return $retorno;

}*/




}
<?php

namespace App\Utils;

use App\Models\User;
use Config\DataBae;

class Funciones
{
    public static function TraerUno($usuarios, $dato)
    {
        foreach ($usuarios as $usuarioAux) 
        {
            if($usuarioAux['email'] == $dato)
            {
                $usuario = $usuarioAux;
            }
            else
            {
               $usuario = '';
            }
        }
        return $usuario;
    }

    public static function ExisteUser($usuarios, $dato)
    {
        foreach ($usuarios as $usuario) 
        {
            if($usuario['email'] == $dato)
            {
                $existe = true;
            }
            else
            {
                $existe = false;
            }
        }
        return $existe;
    }

    public static function TraerTodos()
    {
        $usuarios = User::all();

        return $usuarios;
    }

    public static function ValidarLogin($usuario, $email, $clave)
    {
        $rta = false;

        if($usuario['email'] == $email && $usuario['password'] == $clave)
        {
            $rta = true;
        }

        return $rta;
    }

}
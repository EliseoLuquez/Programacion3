<?php

include_once 'usuario.php';
include_once 'funciones.php';
include_once 'validadorjwt.php';

session_start();
//SABER QUE METODO ENTRO A LA API CON REQUEST_METHOD
$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'];


$header = getallheaders();


switch($request_method)
{
    case 'POST':
        switch ($path_info) 
        {
            case '/singin':
                if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['telefono']) &&
                isset($_POST['clave']) && isset($_POST['tipo']))
                {
                    //guardo datos
                    //$usuario = new Usuario($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['telefono'], $_POST['clave'], $_POST['tipo']);
                    if(Usuario::Singin($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['telefono'], $_POST['clave'], $_POST['tipo']))
                    {
                        $datos = 'Singin Exitoso';
                    }
                    else
                    {
                        $datos = 'Singin Error';
                    }
                }
                else
                {
                    $datos = 'Faltan datos';
                    $respuesta->success = false;
                }
                //echo json_encode($respuesta);
                break;
                case '/login':
                if(isset($_POST['email']) && isset($_POST['clave']))
                {
                    if(Usuario::Login($_POST['email'], $_POST['clave']))
                    {
                        $datos = 'Login Exitoso';
                    }
                    else
                    {
                        $datos = 'Email o Clave Incorrectas';
                        $respuesta->success = false;
                    }
                }
                //echo json_encode($respuesta);
            break;
            default:
            $datos = 'faltan datos';
                $respuesta->success = false;
            break;
        }
    break;
    
    case 'GET':
        //$datos = Usuario::Mostrar($token);
        $token = $header['token'];
        $auxUsu = ValidadorJWT::VerificarToken($token);
        //$res = ValidadorJWT::ObtenerUsuario($token);
       // $usuario = Usuario::BuscarUsuario($auxUsu);

        switch ($path_info) 
        {
            case '/detalle':
                if(isset($token))
                {
                    $datos = $auxUsu;
                }
                else
                {
                    $datos = 'Faltan datos';
                    $respuesta->success = false;
                }
                //echo json_encode($respuesta);
                break;
                case '/lista':
                if(isset($token))
                {
                    $datos = Usuario::Mostrar($token);
                }
                else
                {
                    $datos = 'Faltan datos';
                    $respuesta->success = false;
                }
                //echo json_encode($respuesta);
                break;
                default:
            $datos = 'faltan datos';
            $respuesta->success = false;
        break;

    }
    break;  
    default:
    break;
}


$respuesta = new stdClass;
$respuesta->success = true;
$respuesta->data = $datos; 

echo json_encode($respuesta);




<?php

include_once 'clases/usuario.php';
include_once 'archivos.php';
include_once 'clases/venta.php';
include_once 'clases/pizzas.php';
include_once 'clases/fecha.php';
include_once 'validadorjwt.php';

session_start();

$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'];
$fecha = new Fecha(date("d-m-Y", time()));

$header = getallheaders();

$pathImg = '/imagenes';

switch($request_method)
{
    case 'POST':
        switch ($path_info) 
        {
            case '/usuario'://PUNTO 1
                if (isset($_POST['email']) && isset($_POST['clave']) && isset($_POST['tipo']))
                {
                    if(Usuario::Singin($_POST['email'], $_POST['clave'], $_POST['tipo']))
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
                    
                }
                //echo json_encode($respuesta);
                break;
            case '/login'://PUNTO 2
                if(isset($_POST['email']) && isset($_POST['clave']))
                {
                    if(Usuario::Login($_POST['email'], $_POST['clave']))
                    {
                        $datos = 'Login Exitoso';
                    }
                    else
                    {
                        $datos = 'Nombre o Clave Incorrectas';                       
                    }
                }
                //echo json_encode($respuesta);
                break;
            case '/pizzas'://PUNTO 3 SOLO TIPO ENCARGADOS;
                $token = $header['token'];

                $auxUsu = ValidadorJWT::VerificarToken($token);
                $tipoUsuario = Usuario::EsAdmin($auxUsu);
                if($tipoUsuario)//true admin / false user
                {
                    if(isset($_POST['tipo']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_POST['sabor']) && isset($_FILES['foto']))
                    {
                        //var_dump($_FILES['foto']);
                        $pizza = new Pizza($_POST['tipo'], $_POST['precio'], $_POST['stock'], $_POST['sabor'], $_FILES['foto']['tmp_name']);
                        //var_dump($producto);
                        move_uploaded_file($_FILES['foto']['tmp_name'], 'imagenes/' . $_FILES['foto']['name']);
                        GuardarPizza($pizza, 'pizzas.txt');
                        $datos = 'post pizzas ok';
                    }
                    else
                    {                        
                        $datos = 'Faltan datos';
                    }
                }
                else
                {       
                    $datos = 'Debe ser usuario tipo Encargado';
                }
                //echo json_encode($respuesta);
                break;
            case '/Ventas'://PUNTO 5 SOLO CLIENTES
                $token = $header['token'];
                $auxUsu = ValidadorJWT::VerificarToken($token);
                $tipoUsuario = Usuario::EsAdmin($auxUsu);
                if($tipoUsuario ==  false)//true admin / false user
                {
                    if(isset($_POST['tipo']) && isset($_POST['sabor']))
                    {
                        $datos = Pizza::VerificarStock($_POST['tipo'], $_POST['sabor']);
                        if($datos != 0)
                        {
                            $venta = new Venta($auxUsu->email, $_POST['tipo'], $_POST['sabor'], $datos, $fecha);
                            //guardo venta seralizada
                            GuardarVenta($venta, 'ventas.txt');
                            //modifico stock
                            if(Pizza::ModificarStock($_POST['tipo'], $_POST['sabor']))
                            {
                                $datos = 'Monto Venta: '. $datos;

                            }
                        }
                        else
                        {
                            $datos = 'venta no realizada, no alcanza el stock';
                        }
                    }
                }
                else
                {
                    $datos = 'Debe ser usuario tipo User';                   
                }
                //echo json_encode($respuesta);
                break;
            default:
            $datos = 'faltan datos';
            // 
                break;
        }
    break;
    
    case 'GET':
        //$datos = Usuario::Mostrar($token);
        $token = $header['token'];
        $auxUsu = ValidadorJWT::VerificarToken($token);
        $tipoUsuario = Usuario::EsAdmin($auxUsu);
        
        switch ($path_info) 
        {
            case '/stock'://PUNTO 4
                $datos = Producto::MostrarProductos();
                $datos != '' ??  $datos = 'Faltan datos';
                //echo json_encode($respuesta);
                break;
            case '/ventas'://PUNTO 6
                if(isset($token))
                {
                    if($tipoUsuario)//admin
                    {
                        //mostrar todas las ventas
                        $datos = Venta::MostrarVentas();
                    }
                    else//user
                    {
                        //mostrar ventas del usuario
                        $datos = Venta::MostrarVenta($auxUsu);
                    }
                }
                else
                {
                    $datos = 'Faltan datos';    
                }
                //echo json_encode($respuesta);
                break;
            default:
                $datos = 'faltan datos';
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

  
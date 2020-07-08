<?php

include_once 'Clases/usuario.php';
include_once 'archivos.php';
include_once 'Clases/ventas.php';
include_once 'Clases/producto.php';
include_once 'validadorjwt.php';

session_start();

$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'];


$header = getallheaders();

$pathImg = '/imagenes';
$id= mt_rand();

switch($request_method)
{
    case 'POST':
        switch ($path_info) 
        {
            case '/usuario'://PUNTO 1
                if (isset($_POST['nombre']) && isset($_POST['dni']) && isset($_POST['obra_social']) && isset($_POST['clave'])
                 && isset($_POST['tipo']))
                {
                    if(Usuario::Singin($id, $_POST['nombre'], $_POST['dni'], $_POST['obra_social'], $_POST['clave'], $_POST['tipo']))
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
                if(isset($_POST['nombre']) && isset($_POST['clave']))
                {
                    if(Usuario::Login($_POST['nombre'], $_POST['clave']))
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
            case '/stock'://PUNTO 3
                $header = getallheaders();
                $token = $header['token'];

                $auxUsu = ValidadorJWT::VerificarToken($token);
                $tipoUsuario = Usuario::EsAdmin($auxUsu);
                if($tipoUsuario)//true admin / false user
                {
                    if(isset($_POST['producto']) && isset($_POST['marca']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_FILES['foto']))
                    {
                        //var_dump($_FILES['foto']);
                        $producto = new Producto($_POST['producto'], $_POST['marca'], $_POST['precio'], $_POST['stock'], $id , $_FILES['foto']['tmp_name']);
                        //var_dump($producto);
                        move_uploaded_file($_FILES['foto']['tmp_name'], 'imagenes/' . $_FILES['foto']['name']);
                        GuardarJson($producto, 'producto.json');
                        $datos = 'post stock ok';
                    }
                    else
                    {                        
                        $datos = 'Faltan datos';
                    }
                }
                else
                {       
                    $datos = 'Debe ser usuario tipo Admin';
                }
                //echo json_encode($respuesta);
                break;
            case '/Ventas'://PUNTO 5
                $token = $header['token'];
                $auxUsu = ValidadorJWT::VerificarToken($token);
                $tipoUsuario = Usuario::EsAdmin($auxUsu);
                if($tipoUsuario ==  false)//true admin / false user
                {
                    if(isset($_POST['id_producto']) && isset($_POST['cantidad']) && isset($_POST['usuario']))
                    {
                        $datos = Producto::VerificarStock($_POST['id_producto'], $_POST['cantidad']);
                        
                        if($datos != 0)
                        {
                            $venta = new Venta($_POST['id_producto'], $_POST['cantidad'], $_POST['usuario']);
                            //guardo venta seralizada
                            GuardarSerializado($venta, 'ventas.txt');
                            //modifico stock
                            if(Producto::ModificarStock($_POST['id_producto'], $_POST['cantidad']))
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




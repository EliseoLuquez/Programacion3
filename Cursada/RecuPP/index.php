<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;

require __DIR__ . '/vendor/autoload.php';

include_once 'archivos.php';
include_once 'clases/venta.php';
include_once 'clases/pizza.php';
include_once 'clases/mensaje.php';
include_once 'clases/usuario.php';
include_once 'validadorjwt.php';

session_start();

$request_method = $_SERVER['REQUEST_METHOD'];



$app = AppFactory::create();


$app->setBasePath('/RecuPP');

$app->addErrorMiddleware(true, true, true);

//PUNTO 1
$app->post('/users', function  (Request $request, Response $response)
{
    $body = $request->getParsedBody();
    
    $id = rand(0, 1000);
    
    
    if($body['email'] != '' && $body['clave'] != '' && $body['tipo'] != '' && $_FILES['foto'] != '')
    {
        if(Imagen1($foto1, './imagenes/users/', $id) && Imagen2($foto2, './imagenes/users/', $id))
        {
            if(Usuario::Singin($id, $body['email'], $body['clave'], $body['tipo'], $foto1, $foto2))
            {
                $datos = 'Usuario creado con exito';  
            }
            else
            {
                $datos = 'Error. Ya existe el usuario';
            }
        }
    }
    else
    {
        $datos = 'Error. Faltan completar datos.';
    }
    

    $rta = array("success" => true,
        "data" => $datos,
    );

$rtaJson = json_encode($rta);

$response->getBody()->write($rtaJson);

return $response
->withHeader('Content-Type', 'application/json');
});


//PUNTO 2
$app->post('/login', function  (Request $request, Response $response)
{
    $body = $request->getParsedBody();
    
    $id = rand(0, 1000);
    
    
    if($body['email'] != '' && $body['clave'] != '')
    {
        $token = Usuario::Login($body['email'], $body['clave']);
        if($token)
        {
            $datos = $token;
        }
        else
        {
            $datos = 'Error de login, Token no creado';
        }
    }
    else
    {
        $datos = 'Error. Faltan completar datos.';
    }
    

    $rta = array("success" => true,
        "data" => $datos,
    );

$rtaJson = json_encode($rta);

$response->getBody()->write($rtaJson);

return $response
->withHeader('Content-Type', 'application/json');
});

//agrupo las rutas
$app->group('/mensajes', function ($group)
{

    //PUNTO 3
    $group->put('[/]', function (Request $request, Response $response)
    {
        $fecha = new Fecha(date("d-m-Y", time()));
        //$headers = $request->getHeaders();
        $token = $request->getHeader('token');
        $body = $request->getParsedBody();

        $auxUsu = ValidadorJWT::VerificarToken($token);
 
        $mensaje = $body['mensaje'];
        $idDestino = ['id'];
        
        if($mensaje != '' && $idDestino != '')
        {  
            $idUser = Usuario::BuscarIdToken($auxUsu);
            
            if(Usuario::BuscarId($idDestino))
            {
                $auxMsj = new Mensaje($idUser, $idDestino, $mensaje, $fecha);
                Guardar($auxMsj, 'mensajes.josn');
                $datos = 'Mensajes guardado con exito.';
            }
            else
            {
                $datos = 'No existe Usuario';
            }
        }
        else
        {
            $datos = 'Faltan completar datos.';
        }

        $rta = array("success" => true,
            "data" => $datos,
        );
    
        $rtaJson = json_encode($rta);

        $response->getBody()->write($rtaJson);

        return $response
        ->withHeader('Content-Type', 'application/json');

    });


    //PUNTO 4
    $group->get('[/]', function (Request $request, Response $response)
    {

        $token = $request->getHeader('token');
        $auxUsu = ValidadorJWT::VerificarToken($token);
        $tipoUsuario = Usuario::EsAdmin($auxUsu);

        if($tipoUsuario)
        {
           $msjs = Mensaje::MostrarMensajesAdmin();
           if($msjs = '')
           {
                $datos = 'No hay mensajes';
           }
           else
           {
               $datos = $msjs;
           }
        }
        else
        {

            $datos = 'Error. Faltan completar datos.';
        }


        $rta = array("success" => true,
            "data" => $datos,
        );
    
        $rtaJson = json_encode($rta);

        $response->getBody()->write($rtaJson);

        return $response
        ->withHeader('Content-Type', 'application/json');

    });

    //PUNTO 5
    /*
    $group->post('/modificar', function  (Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        
        $id = rand(0, 1000);
        
        
        if($body['precio'] != '' && $body['tipo'] != '' && $body['sabor'] != '' && $body['stock'] != '' && $_FILES['foto1'] != '' && $_FILES['foto2'] != '')
        {
            if(Pizza::BuscarPizza($body['tipo'], $body['sabor']))
            {
                if(BackupImg1($img1, './imagenes/pizzas/', '/imagenes/backup/')  && BackupImg2($img2, './imagenes/pizzas/', '/imagenes/backup/'))
                {
                    if(Pizza::ModificarPizza($body['precio'] ,$body['tipo'] ,$body['sabor'] ,$body['stock'] ,$_FILES['foto1'] ,$_FILES['foto2']))
                    {
                        $datos = 'Modificacion exitosa.';
                    }
                }
                else
                {
                    $datos = 'Error al modificar imagen.';
                }
            }
            else
            {
                $datos = 'Error.No existe la pizza a modificar.';
            }
        }
        else
        {
            $datos = 'Error. Faltan completar datos.';
        }
        

        $rta = array("success" => true,
            "data" => $datos,
        );
    
    $rtaJson = json_encode($rta);

    $response->getBody()->write($rtaJson);

    return $response
    ->withHeader('Content-Type', 'application/json');
    });*/

});



//PUNTO 4
/*
$app->post('/ventas', function  (Request $request, Response $response)
{
    $body = $request->getParsedBody();
    
    $id = rand(0, 1000);
    
    
    if($body['email'] != '' && $body['sabor'] != '' && $body['tipo'] != '' && $body['cantidad'] != '')
    {

        if(Pizza::BuscarPizza($body['tipo'], $body['sabor']))
        {
            $costo = Pizza::VerificarStock($body['tipo'], $body['sabor'], $body['cantidad']);

            if($costo > 0)
            {
                if(Pizza::ModificarStock($body['tipo'], $body['sabor'], $body['cantidad']))
                {
                    $idVta  = rand(0, 1000);
                    $venta = new Venta($idVta, $body['email'], $body['tipo'], $body['sabor'], $body['cantidad'], $costo);
                    if(Guardar($venta, 'venta.txt'))
                    {
                        $datos = 'Venta guardada con exito.'; 
                    }
                    else
                    {
                        $datos = 'Error al Guardar venta.';
                    }
                }
                else
                {
                    $datos = 'Error al modificar stock.';
                }
            }
            else
            {
                $datos = 'Error. No hay stock suficiente.';
            }
        }
        else
        {
            $datos = 'Error. No existe la pizza';
        }
    }
    else
    {
        $datos = 'Error. Faltan completar datos.';
    }
    

    $rta = array("success" => true,
        "data" => $datos,
    );

$rtaJson = json_encode($rta);

$response->getBody()->write($rtaJson);

return $response
->withHeader('Content-Type', 'application/json');
});
*/

$app->run();


<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;

require __DIR__ . '/vendor/autoload.php';

include_once 'archivos.php';
include_once 'clases/venta.php';
include_once 'clases/pizza.php';
include_once 'clases/log.php';

session_start();

$pathImg = '/imagenes/pizzas';
$request_method = $_SERVER['REQUEST_METHOD'];
$ruta = $_SERVER['SERVER_ADDR'];
$hora = date(time());
//$header = getallheaders();

$log = new Log($ruta ,$request_method, $hora);
Guardar($log, 'log.txt');

$app = AppFactory::create();

$app->setBasePath('/Prog3/PizzasrPRPP');

$app->addErrorMiddleware(true, true, true);

//agrupo las rutas
$app->group('/pizzas', function ($group)
{
    //PUNTO 1
    $group->post('[/]', function  (Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        
        $id = rand(0, 1000);
        
        
        if($body['precio'] != '' && $body['tipo'] != '' && $body['sabor'] != '' && $body['stock'] != '' && $_FILES['foto1'] != '' && $_FILES['foto2'] != '')
        {
            if(Imagen1($img1, './imagenes/pizzas/', $id) && Imagen2($img2, './imagenes/pizzas/', $id))
            {
                if(Pizza::BuscarPizza($body['tipo'], $body['sabor']))
                {
                    $datos = 'Error. Combinacion Tipo/Sabor existente.';
                }
                else
                {
                    $pizza = new Pizza($id, $body['precio'], $body['tipo'], $body['stock'], $body['sabor'], $img1, $img2);
                    GuardarJson($pizza, 'pizza.txt');
                    $datos = 'Pizza guardada con exito.';
                }
            }
            else
            {
                $datos = 'Error al Guardar las fotos.';
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
    $group->get('[/]', function (Request $request, Response $response)
    {
        //$headers = $request->getHeaders();
        $tipo = $request->getHeader('tipo');
        $sabor = $request->getHeader('sabor');

        if ($tipo != '' && $sabor != '')
        {
            if(Pizza::BuscarPizza($tipo[0], $sabor[0]))
            {
                $datos = 'Stock Pizza ' .  $tipo[0] .' ' .$sabor[0] . ': '. Pizza::MostrarStock($tipo[0], $sabor[0]);
            }
            else
            {
                $datos = 'Error. No existe esa pizza.';
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
    });

});



//PUNTO 4
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


$app->run();


<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/slim');

$app->addErrorMiddleware(true, true, true);

//DEVULEVE TODA LA PERSONA
$app->post('/persona', function  (Request $request, Response $response)
{
    $body = $request->getParsedBody();

    $files = $_FILES;//$request->getUploadedFiles();

    $rta = array("success" => true,
        "data" => "POST",
        "body" => $body,
        "files" => $files['file']
    );

    $rtaJson = json_encode($rta);

    $response->getBody()->write($rtaJson);

    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(302);
});    

//DEVUELVE SOLO EL ID
$app->get('/persona/{id}', function (Request $request, Response $response, $args)
{
    
    //queryparams toma las variables que vienen del postamn params
    $queryString =$request->getQueryParams();

    $headers = $request->getHeaders();

    $rta = array("success" => true,
    "headers" => $headers,
     "data" => $args,
      "query" => $queryString);
    $rtaJson = json_encode($rta);
    $response->getBody()->write($rtaJson);
    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(302);
});   

// '/acceso al get, ej: '/persona' cada ruta tiene una function manejadora
// Request tiene la inforamcion que entra en la peticion, body, header etc.
// Response para devolver la respuesta
// args es un array, recibe las variables que se le envian a la ruta, path 
//devuelve toda la persona
$app->get('/persona[/]', function (Request $request, Response $response, $args)
{
    
    //queryparams toma las variables que vienen del postamn params
    $queryString =$request->getQueryParams();

    $headers = $request->getHeaders();

    $rta = array("success" => true,
    "headers" => $headers,
     "data" => $args,
      "query" => $queryString);
    $rtaJson = json_encode($rta);
    $response->getBody()->write($rtaJson);
    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(302);
});

$app->put('/persona', function (Request $request, Response $response)
{
    //queryparams toma las variables que vienen del postamn params
    $queryString =$request->getQueryParams();

    $headers = $request->getBody("PUT");

    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(302);
});


$app->delete('/persona', function (Request $request, Response $response)
{
    //queryparams toma las variables que vienen del postamn params
    $queryString =$request->getQueryParams();

    $headers = $request->getBody("delete");

    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(302);
});

//agrupo las rutas
$app->group('/alumno', function ($group)
{
    $group->get('/{id}', function (Request $request, Response $response)
    {
        $headers = $request->getBody("alumno/{id}");

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(302);

    });

    $group->get('[/]', function (Request $request, Response $response)
    {
        $headers = $request->getBody("alumno/{id}");

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(302);

    });

    //agrupa todos los metodos compartiendo la ruta /alumno
    $group->map(['GET', 'DELETE', 'POST', 'PUT'], '[/]', function (Request $request, Response $response)
    {
        $headers = $request->getBody("MAP");

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(302);

    });
});

$app->run();
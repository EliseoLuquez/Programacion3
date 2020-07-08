<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\AlumnoController;
use Slim\Routing\RouteCollectorsProxy;

return function($app)
{
    $app->get('/', function(Request $request, Response $response)
    {
        $response->getBody()->write("Hola Skeleton");
        return $response;
    });


    $app->group('mascota', function(RouteCollectorsProxy $group)
    {
        $group->get('[/]', AlumnoController::class . ":getAll");

        $group->post('[/]', AlumnoController::class . ":getAll");

        $group->put('[/]', AlumnoController::class . ":getAll");

        $group->update('[/]', AlumnoController::class . ":getAll");

        $group->delete('[/]', AlumnoController::class . ":getAll");

    });
};

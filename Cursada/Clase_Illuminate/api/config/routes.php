<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AlumnoController;

return function($app)
{
    $app->group('/alumnos', function(RouteCollectorProxy $group)
    {
        $group->get('[/]', AlumnoController::class.':getAll');
        //$group->get('[/:id]', AlumnoController::class.':getAll');
        $group->post('[/]', AlumnoController::class.':add');
        // $group->put('[/:id]', AlumnoController::class.':getAll');
        // $group->delete('[/:id]', AlumnoController::class.':getAll');

    });

    // $app->group('/materias', function(RouteCollectorProxy $group)
    // {
    //     $group->get('[/]', AlumnoController::class.':getAll');
    //     $group->get('[/:id]', AlumnoController::class.':getAll');
    //     $group->post('[/]', AlumnoController::class.':getAll');
    //     $group->put('[/:id]', AlumnoController::class.':getAll');
    //     $group->delete('[/:id]', AlumnoController::class.':getAll');

    // });
};
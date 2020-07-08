<?php

namespace Config;

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsersController;
use App\Controllers\MascotaController;
use App\Controllers\TurnoController;
use App\Middleware\BeforeMiddleware;
use App\Middleware\UserValidateMiddleware;
use App\Middleware\RegistroMiddleware;
use App\Middleware\ExisteUserMiddleware;
use App\Middleware\LoginMiddleware;
use App\Middleware\TurnoMiddleware;

return function ($app) {

    //PUNTO 1
    $app->post('/registro', UsersController::class . ':add')->add(ExisteUserMiddleware::class)->add(RegistroMiddleware::class);
    //PUNTO 2
    $app->post('/login', UsersController::class . ':login')->add(LoginMiddleware::class);
    
    //PUINTO 3
    $app->group('/mascota', function (RouteCollectorProxy $group) {
         $group->post('[/]', MascotaController::class . ':addMascota')->add(UserValidateMiddleware::class);
         //$group->get('/:id', MascotaController::class . ':getAllMascota');
    //     $group->post('registro', UsersController::class . ':add')->add(RegistroMiddleware::class);
    //     $group->post('/login', UsersController::class . ':login');
    //     $group->put('/:id', UsersController::class . ':getAll')->add(UserValidateMiddleware::class);
    //     $group->delete('/:id', UsersController::class . ':getAll');
     })->add(new BeforeMiddleware());
    
     //PUNTO 4
     $app->group('/turnos', function (RouteCollectorProxy $group) {
        $group->post('[/mascota]', TurnoController::class . ':addTurno')->add(UserValidateMiddleware::class)->add(TurnoMiddleware::class);
        $group->get('/{id}', TurnoController::class . ':id_usuario');
        //$group->get('/{id_mascota}', TurnoController::class . ':getAllMascota');
   //     $group->post('registro', UsersController::class . ':add')->add(RegistroMiddleware::class);
   //     $group->post('/login', UsersController::class . ':login');
   //     $group->put('/:id', UsersController::class . ':getAll')->add(UserValidateMiddleware::class);
   //     $group->delete('/:id', UsersController::class . ':getAll');
    })->add(new BeforeMiddleware());
    

};
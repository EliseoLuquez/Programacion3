<?php

require_once __DIR__.'/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Config\DataBase;

new DataBase;
$app = AppFactory::create();
$app->setBasePath("/skeleton/public");

//Registrar Rutas
(require __DIR__.'/routes.php'){$app};

return $app;
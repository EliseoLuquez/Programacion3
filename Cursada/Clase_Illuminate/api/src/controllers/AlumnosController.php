<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Alumno;

class AlumnosController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(Alumno::all());

        $response->getBody()->write($rta);
        return $response;
    }

    public function add(Request $request, Response $response, $args)
    {
        $alumno = new Alumno;
        $alumno->alumno = "Pedrito";
        $alumno->legajo = 1056;
        $alumno->localidad = 2;
        $alumno->cuatrimestre = 3;

        $rta = json_encode(array("ok"=>$alumno->save()));
        
        $response->getBody()->write($rta);
        return $response;
    }
}
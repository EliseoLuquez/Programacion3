<?php

namespace App\Controllers;

class AlumnoController
{
    public function getAll(Request $request, Response $response)
    {
        $response->getBody()->write("Hola Skeleton");
        return $response;
    }

    public function getOne(Request $request, Response $response)
    {
        $response->getBody()->write("Hola mascota");
        return $response;
    }

    public function update(Request $request, Response $response)
    {
        $response->getBody()->write("Hola Skeleton");
        return $response;
    }

    public function delete(Request $request, Response $response)
    {
        $response->getBody()->write("Hola Skeleton");
        return $response;
    }
}
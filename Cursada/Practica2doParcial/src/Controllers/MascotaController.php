<?php

namespace App\Controllers;

use Config\DataBase as Capsule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Mascota;
use App\Utils\ValidadorJWT;
use App\Utils\Funciones;

class MascotaController {

    public function getAllMascota(Request $request, Response $response, $args)
    {
        $rta = json_encode(Mascota::all());

        // $response->getBody()->write("Controller");
        $response->getBody()->write($rta);

        return $response;
    }

    public function addMascota(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $mascota = new Mascota;
        $mascota->nombre = $body["nombre"];
        $mascota->edad = $body["edad"];
        $mascota->id_cliente = $body["id_cliente"];
        $rta = json_encode(array("ok" => $mascota->save()));

        $response->getBody()->write($rta);

        return $response;
    }


    public function login(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $email = $body["email"];
        $clave = $body['password'];

         $usuarios = Funciones::TraerTodos();
         $usuario = Funciones::TraerUno($usuarios, $email);
         $valido = Funciones::ValidarLogin($usuario, $email, $clave);

        // $usuario = User::where('email', $email)->get();
        // var_dump($usuario->attributes['password']);
        if($valido)
        {
             $token = ValidadorJWT::CrearToken($usuario);
             $rta = json_encode($token);

        }
        else
        {
            $rta = json_encode("Error, usuario o clave no coinciden");
        }

        $response->getBody()->write($rta);

        return $response;
    }
}
<?php

namespace App\Controllers;

use Config\DataBase as Capsule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Turno;
use App\Models\User;
use App\Models\Mascota;
use App\Utils\ValidadorJWT;
use App\Utils\Funciones;
use DateTime;
use Symfony\Component\Console\Helper\Helper;

class TurnoController {

    public function getAllTurnos(Request $request, Response $response, $args)
    {
        $rta = json_encode(Turno::all());

        // $response->getBody()->write("Controller");
        $response->getBody()->write($rta);

        return $response;
    }

    public function addTurno(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        
        if(TurnoController::ValidarTurno($body["fecha"], $body["hora"], $body["id_veterinario"]))
        {
            if(TurnoController::EsVeterinario($body["id_veterinario"]))
            {
                $turno = new Turno;
                $turno->id_mascota = $body["id_mascota"];
                $turno->fecha = $body["fecha"];
                $turno->hora = $body["hora"];
                $turno->id_veterinario = $body["id_veterinario"];
                $rta = json_encode(array("ok" => $turno->save()));
            }
            else
            {
                $rta = json_encode("Id No pertenece a Veterinario");
            }
        }
        else
        {
            $rta = json_encode("Turno No Disponible");
        }

        $response->getBody()->write($rta);

        return $response;
    }

    public function id_usuario(Request $request, Response $response, $args)
    {
       $id_usuario = $args['id'];
       $veterinario = TurnoController::EsVeterinario($id_usuario);
       
        if($veterinario)
        {
            $turnos = Turno::where('id_veterinario', $id_usuario)
            ->join('mascotas', 'mascotas.id', 'turnos.id_mascota')
            ->join('users', 'users.id', 'mascotas.id_cliente')
            //$turnos = Turno::join('mascotas', 'mascota.id', 'turnos.id_mascota')
            ->get();
            $rta = json_encode($turnos);
        }
        else
        {
            $mascotas = Mascota::where('id_cliente', '=', $id_usuario)
            ->join('users', 'users.id', 'mascotas.id_cliente')
            ->get();

            //$turnos = Turno::join('turnos', '=', 'turnos.id_mascota')->get();
            //$turnos = Turno::where('id_veterinario', $id_usuario)->get();
            $rta = json_encode($mascotas);
        }

        $response->getBody()->write($rta);

        return $response;
    }

    public static function ValidarTurno($fecha, $hora, $id_veterinario)
    {
        $hrMin = array('horaMin'=> '09:00:00');
        $hrMax =  array('horaMax'=> '17:00:00');
        
        $formatDate = array('fecha'=> $fecha, 'hora'=>$hora);

        if($hrMin >= $formatDate['hora'] && $formatDate['hora'] < $hrMax)
        {
            $turnos = Turno::all();

            foreach ($turnos as $turno) 
            {
                $turnoTime = array('hora'=>$turno->hora);
                if($turno->fecha == $fecha && $turnoTime['hora'] == $formatDate['hora'] && $turno->id_veterinario == $id_veterinario)
                {
                    return false;
                }
            }
        }

        return true;
    }

    public static function EsVeterinario($id_veterinario)
    {
        $user = User::find($id_veterinario);
        //var_dump($user);
        if($user->tipo_usuario == 'veterinario')
        {
            return true;
        }
        return false;
    }

}
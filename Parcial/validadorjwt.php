<?php
use \Firebase\JWT\JWT;
use Monolog\Formatter\WildfireFormatter;
use Monolog\Handler\SwiftMailerHandler;

require_once __DIR__ . '/vendor/autoload.php';

class ValidadorJWT
{

    public static function CrearToken($dato)
    {
        $retorno = false;
        $key = 'pro3-parcial';
        $payload = array(
            "email" => $dato['email'],
            "clave" => $dato['clave'],
            "tipo"=> $dato['tipo']
        );
        $retorno = JWT::encode($payload, $key);
        return $retorno;
    }


    public function VerificarToken($token)
    {
        try
        {
            $retorno = JWT::decode($token, 'pro3-parcial', array('HS256'));
        }
        catch(Exception $e)
        {
            $retorno = false;
        }
        return $retorno;
    }

}
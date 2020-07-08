<?php

namespace App\Utils;

require_once __DIR__ . '/../../vendor/autoload.php';
use \Firebase\JWT\JWT;
use Monolog\Formatter\WildfireFormatter;
use Monolog\Handler\SwiftMailerHandler;

class ValidadorJWT
{
    private static $claveSecerta = 'contrasena';
    private static $encriptacion = ['HS256'];
    private static $aud = null;

    public static function CrearToken($dato)
    {
        $retorno = false;
        $key = 'contrasena';
        $payload = array(
            "email" => $dato['email'],
            "tipo"=> $dato['tipo_usuario'],
            "password"=> $dato['password'],
        );
        $retorno = JWT::encode($payload, $key);
        return $retorno;
    }

    public static function VerificarToken($token)
    {
        $retorno = JWT::decode($token, 'contrasena', array('HS256'));
        return $retorno;
    }
/*
    public function ObtenerUsuario($token)
    {
        
        try
        {
            $retorno = JWT::decode($token, self::$claveSecerta, self::$encriptacion);
        }
        catch(Exception $ex)
        {
            $retorno = $ex->getMessage();
        }
        return $retorno;
    }
    */
}
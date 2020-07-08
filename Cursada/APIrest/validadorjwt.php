<?php
use \Firebase\JWT\JWT;
use Monolog\Formatter\WildfireFormatter;
use Monolog\Handler\SwiftMailerHandler;

require_once __DIR__ . '/vendor/autoload.php';

class ValidadorJWT
{
    private static $claveSecerta = 'clave';
    private static $encriptacion = ['HS256'];
    private static $aud = null;

    public static function CrearToken($dato)
    {
        $payload = array(
            'nombre' => $dato['nombre'],
            'apellid0' => $dato['apellido'],
            'email' => $dato['email'],
            'telefono' => $dato['telefono'],
            'clave' => $dato['clave'],
            'tipo'=> $dato['tipo']
        );
        return JWT::encode($payload, self::$claveSecerta);
    }


    public function VerificarToken($token)
    {
        try
        {
            $retorno = JWT::decode($token, 'clave', array('HS256'));
        }
        catch(Exception $e)
        {
            $retornmo = $e->getMessage();
        }
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
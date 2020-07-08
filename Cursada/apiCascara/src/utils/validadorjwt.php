<?php
use \Firebase\JWT\JWT;
use Monolog\Formatter\WildfireFormatter;
use Monolog\Handler\SwiftMailerHandler;

require_once __DIR__ . '/vendor/autoload.php';

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
            "id" => $dato['id'],
            "nombre" => $dato['nombre'],
            "dni" => $dato['dni'],
            "obra_social" => $dato['obra_social'],
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
            $retorno = JWT::decode($token, 'contrasena', array('HS256'));
        }
        catch(Exception $e)
        {
            $retorno = false;
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
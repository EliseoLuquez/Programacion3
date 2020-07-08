<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class TurnoMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        //$response = $handler->handle($request);
        $header = getallheaders();
        $token = $header['token'];
        $body = $request->getParsedBody();
        if(isset($body['id_mascota']) && isset($body['fecha']) && isset($body['hora']) && isset($body['id_veterinario']) && isset($token))
        {
            if($body['id_mascota'] != '' && $body['fecha']  != '' && $body['hora']  != ''  && $body['id_veterinario']  != '' && $token != '')
            {
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();
                $resp = new Response();
                $resp->getBody()->write($existingContent); 
                return $resp; 
            }
            else 
            {
                $response = new Response();
                $response->getBody()->write('Faltan Completar Datos para Turno');
                $response->withStatus(403);
                return $response;
            }
        }
        else
        {
            $response = new Response();
            $response->getBody()->write('Faltan Valores para Turo');
            $response->withStatus(403);
            return $response;
        }
        
       // $response->getBody()->write('BEFORE ' . $existingContent);//
    }
}

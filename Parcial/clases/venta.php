<?php

include_once 'archivos.php';

class Venta
{
    public $email;
    public $tipo;
    public $sabor;
    public $monto;
    public $fecha;

    public function __construct($email, $tipo, $sabor, $monto, $fecha)
    {
        $this->email = $email;
        $this->tipo = $tipo;
        $this->sabor = $sabor;
        $this->monto = $monto;
        $this->fecha = $fecha;
    }



    public function MostrarVentas()
    {   
        //$usuario = ValidadorJWT::VerificarToken($dato);
        $retorno = '';
        //$admin = 'admin';
        $lectura = LeerVenta("ventas.txt", $listaVta);
        if($lectura)
        {
            foreach ($listaVta as $auxvta)
            {
                $retorno = $retorno .','.'Email: '.$auxvta->email .','. 'Tipo: ' .$auxvta->tipo .','.'Sabor: '. $auxvta->sabor. ','.'Monto: '.
                 $auxvta->monto . ','.'Fecha: '. $auxvta->fecha. PHP_EOL;
            }
        }
        return $retorno;
    }


    public function MostrarVenta($dato)
    {
        $retorno = '';

        if(LeerVenta("ventas.txt", $listaVta))
        {
            $array = array();
            foreach ($listaVta as $aux) 
            {
                if($aux->usuarioVta == $dato->id)
                {
                    array_push($array, $aux);
                    //$retorno = $retorno . $aux['idVta']. $aux['cantProd'] .  $aux['usuarioVta']. PHP_EOL;   
                    $retorno = $array; 
                }
            }
        }
        return $retorno;
    } /*   
    public static function MostrarVentasUser($nombre)
    {
        $return = false;
        $response = Data::DeserializarObjeto("ventas.txt");
        $array = array();
        foreach ($response as $users)
        {
            if ($users->comprador == $nombre && $users!='@')
            {
                array_push($array,$users);
                //$return = $return . $users;
                $return = $array;
            }
        }
        return $return;
    }
*/
}
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
        $retorno = '';

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
                    $retorno = $array; 
                }
            }
        }
        return $retorno;
    }
}
<?php

include_once 'archivos.php';

class Venta
{
    public $idVenta;
    public $email;
    public $tipo;
    public $sabor;
    public $cantidad;
    public $precio;

    public function __construct($idVenta, $email, $tipo, $sabor, $cantidad, $precio)
    {
        $this->idVenta = $idVenta;
        $this->email = $email;
        $this->tipo = $tipo;
        $this->sabor = $sabor;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
    }



    public function MostrarVentas()
    {   
        $retorno = '';

        $lectura = Leer("ventas.txt", $listaVta);
        if($lectura)
        {
            $array = array();
            foreach ($listaVta as $auxvta)
            {
                $retorno = 'Email: '.$auxvta->email .','. 'Tipo: ' .$auxvta->tipo .','.'Sabor: '. $auxvta->sabor. ','.'Monto: '.
                            $auxvta->monto . ','.'Fecha: '. $auxvta->fecha;
                array_push($array, $retorno);
            }
        }
        return $array;
    }


    public function MostrarVenta($dato)
    {
        $retorno = '';

        if(Leer("ventas.txt", $listaVta))
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

    public function MontoEncargado()
    {
        $retorno = '';
        $montoTotal = 0;
        $cont = 0;

        if(Leer("ventas.txt", $listaVta))
        {
            foreach ($listaVta as $vta)
            {
                $cont++;
                $montoTotal = $montoTotal + $vta['monto'];
            }
            $retorno = ' Cantidad de Ventas: '. $cont . ' Total Ventas: ' . $montoTotal; 
        }
        return $retorno;
    }

    public function MontoCliente($dato)
    {
        $retorno = '';
        $montoTotal = 0;

        if(Leer("ventas.txt", $listaVta))
        {
            foreach ($listaVta as $vta)
            {
                if($dato->email == $vta['email'])
                {
                    $montoTotal = $montoTotal + $vta['monto'];
                }
            }
            $retorno ='Total Compras: ' . $montoTotal; 
        }
        return $retorno;
    }

}
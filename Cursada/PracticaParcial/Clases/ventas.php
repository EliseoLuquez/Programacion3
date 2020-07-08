<?php

include_once 'archivos.php';

class Venta
{
    public $idVta;
    public $cantProd;
    public $usuarioVta;

    public function __construct($idVta, $cantProd, $usuarioVta)
    {
        $this->idVta = $idVta;
        $this->cantProd = $cantProd;
        $this->usuarioVta = $usuarioVta;
    }



    public function MostrarVentas()
    {   
        $retorno = '';
        $lectura = Leerserializado("ventas.txt", $listaVta);
        if($lectura)
        {
            $array = array();
            foreach ($listaVta as $auxvta)
            {
                $retorno = 'Id venta: '.$auxvta->idVta .','. 'Cantidad Producto: ' .$auxvta->cantProd .','.'Id Usuaurio: '.
                 $auxvta->usuarioVta;
                 array_push($array, $retorno);

            }
        }
        return $array;
    }


    public function MostrarVenta($dato)
    {
        $retorno = '';

        if(Leerserializado("ventas.txt", $listaVta))
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
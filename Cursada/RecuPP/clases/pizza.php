<?php
include_once 'archivos.php';

class Pizza
{
    public $id;
    public $precio;
    public $tipo;
    public $stock;
    public $sabor;
    public $img1;
    public $img2;

    public function __construct($id, $precio, $tipo, $stock, $sabor, $img1, $img2)
    {
        $this->id = $id;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->stock = $stock;
        $this->sabor = $sabor;
        $this->img1 = $img1;
        $this->img2 = $img2;

    }

    //costoVta   SI HAY STOCK / 0 SINO ALCANZA EL STOCK PARA LA VENTA
    public function VerificarStock($tipo, $sabor, $cantidad)
    {
        $retorno = 0;
        
        if(Leer('pizza.txt', $listaPizzas))
        {
            foreach ($listaPizzas as $auxPizza)
            {;
                if($tipo == $auxPizza['tipo'] && $sabor == $auxPizza['sabor'])
                {
                    if($auxPizza['stock'] >= $cantidad)
                    {
                        $costoVta = $cantidad * $auxPizza['precio'];
                        $retorno =  $costoVta;
                        break;
                    }
                }
            }   
        }
        return $retorno;
    }


    function ModificarStock($tipo, $sabor, $cantidad)
    {
        if(Leer('pizza.txt', $pizzas))
        {
            for ($i=0; $i < count($pizzas); $i++)
            { 
                if($tipo == $pizzas[$i]['tipo'] && $sabor == $pizzas[$i]['sabor'])
                {
                    $stock = $pizzas[$i]['stock'] - $cantidad;
                    $pizzas[$i]['stock'] = $stock;
                    ReescribirPizza($pizzas ,'pizza.txt');
                    return true;
                }
            }
        }
        return false;
    }


    function ModificarPizza($precio, $tipo, $sabor, $stock, $img1, $img2)
    {
        if(Leer('pizza.txt', $pizzas))
        {
            for ($i=0; $i < count($pizzas); $i++)
            { 
                if($tipo == $pizzas[$i]['tipo'] && $sabor == $pizzas[$i]['sabor'])
                {
                    $pizzas[$i]['precio'] = $stock;
                    $pizzas[$i]['stock'] = $stock;
                    $pizzas[$i]['foto1'] = $img1;
                    $pizzas[$i]['foto2'] = $img2;
                    ReescribirPizza($pizzas ,'pizza.txt');

                    return true;
                }
            }
        }
    }



    public function MostrarPizzasEncargado()
    {   
        $retorno = '';
        if(Leer("pizza.txt", $listaProd))
        {
            $array = array();
            foreach ($listaProd as $aux) 
            {
                $retorno = 'Pizza: ' . $aux['tipo']. ',' . $aux['precio']. ',' .$aux['stock']. ',' .$aux['sabor']. ',' .$aux['img']; 
                array_push($array, $retorno);   
            }   
        }
        return $array;
    }

    public function MostrarPizzasCliente()
    {   
        $retorno = '';
        if(Leer("pizza.txt", $listaProd))
        {
            $array = array();
            foreach ($listaProd as $aux) 
            {
                $retorno = 'Pizza: ' . $aux['tipo']. ',' . $aux['precio']. ',' .$aux['sabor']. ',' .$aux['img']; 
                array_push($array, $retorno);   
            }   
        }
        return $array;
    }

    //TRUE si ya existe la combinacion tipo/sabor
    public function BuscarPizza($tipo, $sabor)
    {   
        $retorno = false;

        if(Leer('pizza.txt', $listaPizzas))
        {
            foreach ($listaPizzas as $auxPizza)
            {
                if($tipo == $auxPizza['tipo'] && $sabor == $auxPizza['sabor'])
                {
                    $retorno = true;
                break;
            }
        }   
    }
        return $retorno;
    }


    public  function MostrarStock($tipo, $sabor)
    {
        $retorno = 0;

        if(Leer('pizza.txt', $listaPizzas))
        {
            foreach ($listaPizzas as $auxPizza)
            {
                if($tipo == $auxPizza['tipo'] && $sabor == $auxPizza['sabor'])
                {
                    $retorno = $auxPizza['stock'];
                    break;
                }
            }   
        }
        return $retorno;
    }


}
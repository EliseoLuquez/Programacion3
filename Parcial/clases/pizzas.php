<?php
include_once 'archivos.php';

class Pizza
{
    public $tipo;
    public $precio;
    public $stock;
    public $sabor;
    public $img;

    public function __construct($tipo, $precio, $stock, $sabor, $img)
    {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->sabor = $sabor;
        $this->img = $img;
    }

    //costoVta   SI HAY STOCK / 0 SINO ALCANZA EL STOCK PARA LA VENTA
    public function VerificarStock($tipo, $sabor)
    {
        $retorno = 0;
        
        if(LeerPizza('pizzas.txt', $listaPizzas))
        {
            foreach ($listaPizzas as $auxPizza)
            {
                if($tipo == $auxPizza['tipo'] && $sabor == $auxPizza['sabor'])
                {
                    if($auxPizza['stock'] > 0)
                    {
                        //var_dump($auxPizza['stock']);
                        $costoVta = 1 * $auxPizza['precio'];
                        //var_dump($costoVta);
                        $retorno =  $costoVta;
                    }
                }
            }   
        }
        return $retorno;
    }


    function ModificarStock($tipo, $sabor)
    {
        if(LeerPizza('Pizzas.json', $pizzas))
        {
            for ($i=0; $i < count($pizzas); $i++)
            { 
                if($tipo == $pizzas[$i]['tipo'] && $sabor == $pizzas[$i]['sabor'])
                {
                    $stock = $pizzas[$i]['stock'] - 1;
                    $pizzas[$i]['stock'] = $stock;
                    ReescribirPizza($pizzas ,'pizzas.txt');
                    return true;
                }
            }
        }
        return false;
    }



    public function MostrarPizzas()
    {   
        $retorno = '';
        if(LeerPizza("pizzas.txt", $listaProd))
        {

            foreach ($listaProd as $aux) 
            {
                $retorno = $retorno . $aux['tipo']. ',' . $aux['precio']. ',' .$aux['stock']. ',' .$aux['sabor']. ',' .$aux['img']. ',' .PHP_EOL;    
            }   
        }
        return $retorno;
    }
}
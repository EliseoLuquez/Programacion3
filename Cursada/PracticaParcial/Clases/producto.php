<?php
include_once 'archivos.php';

class Producto
{
    public $producto;
    public $marca;
    public $precio;
    public $stock;
    public $id;
    public $img;

    public function __construct($producto, $marca, $precio, $stock, $id, $img)
    {
        $this->producto = $producto;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->id = $id;
        $this->img = $img;
    }

    //costoVta   SI HAY STOCK / 0 SINO ALCANZA EL STOCK PARA LA VENTA
    public function VerificarStock($id, $cantidad)
    {
        $retorno = 0;

        if(LeerJson('producto.json', $listaProd))
        {
            foreach ($listaProd as $auxProd)
            {
                
                if($id == $auxProd['id'])
                {
                    if($auxProd['stock'] >= $cantidad)
                    {
                        $costoVta = $cantidad * $auxProd['precio'];
                        $retorno =  $costoVta;
                    }
                }
            }   
        }
        return $retorno;
    }


    function ModificarStock($id, $cantidad)
    {
        if(LeerJson('producto.json', $productos))
        {
            for ($i=0; $i < count($productos); $i++)
            { 
                if($id == $productos[$i]['id'])
                {
                    $stock = $productos[$i]['stock'] - $cantidad;
                    $productos[$i]['stock'] = $stock;
                    ReescribirJson($productos ,'producto.json');
                    return true;
                }
            }
        }
        return false;
    }



    public function MostrarProductos()
    {   
        $retorno = '';
        if(LeerJson("producto.json", $listaProd))
        {

            foreach ($listaProd as $aux) 
            {
                $retorno = $retorno . $aux['producto']. PHP_EOL;    
            }   
        }
        return $retorno;
    }
}
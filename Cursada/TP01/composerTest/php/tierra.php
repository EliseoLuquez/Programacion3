<?php


class Tierra implements IMostrar
{
    public static $tierra = "Tierra";

    function __construct($tierra)
    {
        $this->region = $tierra;
    }

    public function Mostrar()
    {
        echo "Region: $this->tierra<br/>";
    }






}
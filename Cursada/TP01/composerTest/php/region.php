<?php
require_once'imostrar.php';
require_once'tierra.php';

class Region extends Tierra implements IMostrar
{
    public $region;
    
    function __construct($tierra, $region)
    {
        parent::__construct($tierra);
        $this->region = $region;
    }

    public function Mostrar()
    {
        echo "Region: $this->region<br/>";
    }

}

<?php

require_once'./php/pais.php';



$pais = Pais:: PaisPorNombre("Argentina");

foreach ($paises as $key => $value) 
{
    $value->Mostrar();
}
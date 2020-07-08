<?php

namespace App\Models;


class Alumno extends \Illuminat\DataBase;
{
    public function saludar()
    {
        echo "Hola desde src/Models/Alumno";
    }
}
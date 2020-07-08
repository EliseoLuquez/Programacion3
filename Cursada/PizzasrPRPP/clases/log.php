<?php
    class Log
    {
        public $ruta;
        public $metodo;
        public $hora;
        function __construct($ruta, $metodo, $hora)
        {
            $this->ruta = $ruta;
            $this->metodo = $metodo;
            $this->hora = $hora;
        }
    }
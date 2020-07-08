<?php
    class Mensaje
    {
        public $id;
        public $idDestino;
        public $mensaje;
        public $fecha;
        function __construct($id, $idDestino, $mensaje, $fecha)
        {
            $this->id = $id;
            $this->idDestino = $idDestino;
            $this->mensaje = $mensaje;
            $this->fecha = $fecha;
        }

        public function MostrarMensajesAdmin()
        {   
            $retorno = '';
            if(Leer("mensajes.json", $listaMsj))
            {
                $array = array();
                foreach ($listaMsj as $aux) 
                {
                    $retorno = $aux['id'] . $aux['idDestino'] . $aux['fecha']; 
                    array_push($array, $retorno);                        
                }   
            }
            return $array;
        }
    
    }